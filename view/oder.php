<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];

    require_once '../View/header.php';
?>
    <div class="container" style="min-height:800px;">
        <?php
        require_once '../db/connect.php';
        $sql = "select * from cart where username = '" . $username . "'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) == 0) {
            echo '<h2> Vui Lòng Thêm Sản Phẩm </h2>';
        } else {
        ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên Sản Phẩm</th>
                        <th scope="col">Hình Ảnh</th>
                        <th scope="col">Đơn Giá</th>
                        <th scope="col">Số Lượng</th>
                    </tr>
                </thead>
                <tbody id="listcart">

                </tbody>
            </table>
            <div class="row mt-2">
                <div>
                    <h2><b>Chi Tiết Đơn Hàng</b></h2>
                </div>
            </div>
            <div class="row">
                <div class="d-flex align-items-center">
                    <label for="address" class="form-label mt-2 ml-3"><b>Thông Tin Nhận Hàng:</b></label>
                    <div id="info">
                    </div>
                    <button type="button" id="btnthaydoi" class="btn btn-success ml-3" data-toggle="modal" data-target="#exampleModal">Thêm Địa Chỉ</button>
                </div>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thay Đổi Địa Chỉ Người Nhận</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-check" id="showin_fo">
                                <!-- Content for "Thông Tin Nhận Hàng" modification will be dynamically inserted here -->
                            </div>
                            <div class="border-top mt-3">
                                <!-- <b class="mt-3">Thêm Thông Tin Nhận Hàng Mới</b> -->
                                <div class="form-group">
                                    <label for="newname">Tên người nhận:</label>
                                    <label class="text-warning" id="ername"> </label>
                                    <input type="text" class="form-control" id="newname" placeholder="Nhập tên người nhận">
                                </div>
                                <div class="form-group">
                                    <label for="newphone">Số điện thoại:</label>
                                    <label class="text-warning" id="erphone"> </label>
                                    <input type="text" class="form-control" id="newphone" placeholder="Nhập số điện thoại">
                                </div>
                                <div class="form-group">
                                    <label for="newaddress">Địa chỉ: </label>
                                    <label class="text-warning" id="eraddress"> </label>
                                    <input type="text" class="form-control" id="newaddress" placeholder="Nhập địa chỉ">
                                </div>
                                <button type="button" class="btn btn-success addNewAddressBtn">Thêm</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning macdinhinfo" data-dismiss="modal">Đặt Làm Mặc Định</button>
                            <button type="button" class="btn btn-success capnhatinfo" data-dismiss="modal">Thay Đổi</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <label for="address" class="form-label mt-2 "><b>Số Lượng Hàng:</b>
                    <?php
                    require_once '../db/connect.php';
                    $sql = "SELECT sum(quantity) AS total FROM cart WHERE username = '" . $username . "'";
                    $result = mysqli_query($conn, $sql);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $totalquantity = $row['total'];
                        echo $totalquantity;
                    } else {
                        echo "0";
                    }
                    ?>
                </label>
                <br>
                <label for="address" class="form-label mt-2"><b>Tổng Tiền: $</b>
                    <?php
                    require_once '../db/connect.php';
                    $sql = "SELECT sum(cart.quantity * product.price) AS total
                        FROM cart
                        JOIN product ON cart.idproduct = product.id
                        WHERE cart.username = '" . $username . "'";
                    $result = mysqli_query($conn, $sql);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $totalprice = $row['total'];
                        $formattedPrice = number_format($totalprice, 2, '.', ',');
                        echo $formattedPrice;
                    } else {
                        echo "0";
                    }
                    ?>
                </label>
            </div>
            <div id="buttonpayment" style="max-width: 400px;">
                <div id="result"></div>
                <div>
                    <button type="button" id="thanhtoankhinhanhang" class="btn btn-success mb-3 col-12" data-toggle="modal" data-target="#customModal">Thanh Toán Khi Nhận Hàng!</button>
                </div>
                <div id="paypal-button-container"></div>
            </div>
            <div class="modal fade" id="customModal" tabindex="-1" aria-labelledby="customModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="customModalLabel">Xác Nhận</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Bạn Có Đồng Ý Thanh Toán Khi Nhận Hàng?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            <button type="button" id="confirm-payment-btn" data-dismiss="modal" class="btn btn-success">Đồng Ý</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div>
    <?php
            $conn->close();
        }

    ?>

    </div>
    <?php
    require_once '../View/Footer.php';
    ?>
    <script>
        function view_data() {
            $.post('../Authentication/listthanhtoan.php', {
                username: '<?php echo $username; ?>'
            }, function(data) {
                $("#listcart").html(data);
            });
        }

        function show_info_ship_order() {
            $.post('../Authentication/updateinfoship.php', function(response) {
                $("#info").html(response);
                if (response == "Vui Lòng Nhập Địa Chỉ Nhận Hàng") {
                    $("#thanhtoankhinhanhang").css("display", "none");
                    $("#paypal-button-container").css("display", "none");
                } else {
                    $("#thanhtoankhinhanhang").css("display", "block");
                    $("#paypal-button-container").css("display", "block");
                }
            });
        }
        //show info_ship model
        function show_info_ship_model() {
            $.post('../Authentication/show_infoship_model.php', function(response) {
                $("#showin_fo").html(response);
            });
        }


        $(document).ready(function() {
            view_data();
            show_info_ship_order();
            show_info_ship_model();

            //info_ship
            $(document).on('click', '.capnhatinfo', function() {
                var selectedId = $("input[name='address']:checked").data("id");
                $.ajax({
                    url: '../Authentication/updateinfoship.php',
                    type: 'POST',
                    data: {
                        selectedId: selectedId
                    },
                    success: function(response) {
                        $('#info').html(response);
                        Toastify({
                            text: "Thay Đổi Địa Chỉ Thành Công",
                            duration: 3000,
                            newWindow: true,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)",
                            },
                            onClick: function() {}
                        }).showToast();
                        if (response == "Vui Lòng Nhập Địa Chỉ Nhận Hàng") {
                            $("#thanhtoankhinhanhang").css("display", "none");
                            $("#paypal-button-container").css("display", "none");

                        } else {
                            $("#thanhtoankhinhanhang").css("display", "block");
                            $("#paypal-button-container").css("display", "block");
                        }

                    }
                });
            });
            $(document).on('click', '.macdinhinfo', function() {
                var selectedId = $("input[name='address']:checked").data("id");

                $.ajax({
                    url: '../Authentication/default_info_user.php',
                    type: 'POST',
                    data: {
                        selectedId: selectedId
                    },
                    success: function(response) {
                        if (response == "OK") {
                            Toastify({
                                text: "Đặt địa chỉ mặc định Thành Công",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top",
                                position: "right",
                                stopOnFocus: true,
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                                onClick: function() {}
                            }).showToast();
                            show_info_ship_order();
                        }
                    }
                });
            });
            //không được nhập số hoặc chữ
            $('input[id="newphone"]').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            $('input[id="newname"]').on('input', function() {
                this.value = this.value.replace(/[0-9]/g, '');
            });

            $(document).on('click', '.addNewAddressBtn', function() {
                var name = $('#newname').val();
                var phone = $('#newphone').val();
                var address = $('#newaddress').val();
                $.ajax({
                    url: '../Authentication/newinfo_ship.php',
                    type: 'POST',
                    data: {
                        name: name,
                        phone: phone,
                        address: address
                    },
                    success: function(response) {
                        var reponsetemp = "";
                        var color = "red";
                        if (response == "infotrue") {
                            show_info_ship_model();
                            // xóa các trường đầu vào có ID newname, newphone, và newaddress, 
                            // đặt lại chúng về các giá trị trống một cách hiệu quả.
                            $("#newname").val('');
                            $("#newphone").val('');
                            $("#newaddress").val('');
                            reponsetemp = "Thêm Mới Địa Chỉ Thành Công"
                            color = "linear-gradient(to right, #00b09b, #96c93d)";
                        } else if (response == "nullname") {
                            reponsetemp = "Vui Lòng Nhập Tên"
                        } else if (response == "nullphonenumber") {
                            reponsetemp = "Vui lòng nhập số điện thoại"
                        } else if (response == "erphonenumber") {
                            reponsetemp = "Số điện thoại không hợp lệ"
                        } else if (response == "eraddress") {
                            reponsetemp = "Vui lòng nhập địa chỉ"
                        } else {
                            reponsetemp = response
                        }
                        Toastify({
                            text: reponsetemp,
                            duration: 3000,
                            newWindow: true,
                            close: true,
                            gravity: "top",
                            position: "right",
                            stopOnFocus: true,
                            style: {
                                background: color,
                            },
                            onClick: function() {}
                        }).showToast();
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Lỗi',
                            text: 'Có lỗi xảy ra. Vui lòng thử lại sau.',
                            icon: 'error',
                            confirmButtonText: 'Đóng'
                        });
                    }
                });
            });
            paypal.Buttons({
                // data: Chứa thông tin về đơn hàng.
                // actions: Chứa các phương thức để thực hiện hành động liên quan đến đơn hàng.
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '<?php echo $totalprice; ?>'
                            }
                        }]
                    });
                },
                // onApprove xử lý khi người dùng hoàn thành thanh toán PayPal và phê duyệt giao dịch
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(orderData) {
                        //actions.order.capture() để xác nhận và chấp nhận thanh toán PayPal. 
                        const transaction = orderData.purchase_units[0].payments.captures[0];
                        var idInfoShip = document.querySelector('.form-check-label').dataset.id;
                        //  Tạo một thời gian
                        var create_at = new Date().toISOString();
                        var requestData = {
                            'id_info_ship': idInfoShip,
                            'createat': create_at,
                            'paymentstatus': 1,
                            'paymentmethod': "PayPal",
                        };
                        $.ajax({
                                method: "POST",
                                url: "../Authentication/oder.php",
                                data: requestData,
                            })
                            .done(function(response) {
                                $("#thanhtoankhinhanhang").css("display", "none");
                                $("#paypal-button-container").css("display", "none");
                                $("#btnthaydoi").hide();
                                var color = "red";
                                if (response == 200) {
                                    color = "linear-gradient(to right, #00b09b, #96c93d)";
                                    response = "Bạn Đã Đặt Hàng Thành Công";
                                }
                                Toastify({
                                    text: response,
                                    duration: 3000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    stopOnFocus: true,
                                    style: {
                                        background: color,
                                    },
                                    onClick: function() {} // Callback after click
                                }).showToast();
                            });
                    });
                }
            }).render('#paypal-button-container');

            //thanh toán khi nhận hàng 
            $(document).on('click', '#confirm-payment-btn', function() {
                var idInfoShip = document.querySelector('.form-check-label').dataset.id;
                var create_at = new Date().toISOString();
                var requestData = {
                    'id_info_ship': idInfoShip,
                    'createat': create_at,
                    'paymentstatus': 0,
                    'paymentmethod': "Thanh Toán Khi Nhận Hàng",
                };
                $.ajax({
                    method: "POST",
                    url: "../Authentication/oder.php",
                    data: requestData,
                }).done(function(response) {
                    $("#thanhtoankhinhanhang").css("display", "none");
                    $("#paypal-button-container").css("display", "none");
                    $("#btnthaydoi").hide();
                    Toastify({
                        text: "Đặt Hàng Thành Công",
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        stopOnFocus: true,
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        onClick: function() {}
                    }).showToast();
                });
            });

        });
    </script>
    

<?php
}
?>