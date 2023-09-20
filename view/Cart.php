<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    require_once '../View/header.php';
?>
    <section class="shop-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên Sản Phẩm</th>
                                    <th scope="col">Đơn Giá</th>
                                    <th scope="col">Hình Ảnh</th>
                                    <th scope="col">Số Lượng</th>
                                    <th scope="col">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tbody id="listcart">

                            </tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="discount__content">

                    </div>
                </div>
                <div class="col-lg-4 offset-lg-2">
                    <div class="cart__total__procced">
                        <b class="ml-4">TỔNG TIỀN:
                            <?php
                            require_once '../db/connect.php';
                            $sql = "SELECT SUM(cart.quantity * product.price) AS total FROM cart JOIN product ON cart.idproduct = product.id WHERE username='" . $username . "'";
                            $result = mysqli_query($conn, $sql);
                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $total = $row['total'];
                                $formattedPrice = number_format($total, 0, '.', ',');
                                echo "$" . $formattedPrice;
                            } else {
                                echo "0";
                            }


                            ?>
                        </b>
                        <a href="../View/Oder.php" class="btn btn-danger ml-3 mb-3 mt-3" id="btndathangne">Đặt Hàng</a>

                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>



    <!-- Scripts -->
    <!-- Nhúng CSS của SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <!-- Nhúng JavaScript của SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.5/dist/sweetalert2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script>
        function view_data() {
            $.post('../Authentication/listcart.php', {
                username: '<?php echo $username; ?>'
            }, function(data) {
                if (data == "") {
                    $("#btndathangne").css("display", "none");
                }
                $("#listcart").html(data);
            });
        }

        $(document).ready(function() {
            view_data();
            $(document).on('input', 'input[id="product-quantity"]', function() {
                inputValue = inputValue.replace(/[^0-9]/g, '');
                // Đảm bảo giá trị không âm
                inputValue = Math.max(inputValue, 0);
            });
            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '../Authentication/deletecart.php',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        view_data();
                        Toastify({
                            text: "Xóa Thành Công",
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
                    }
                });
            });
            $(document).on('click', '.edit-btn', function() {
                // closest phương thức trả về tổ tiên đầu tiên của phần tử được chọn.
                // xác định dòng trong bảng mà người dùng đang thực hiện thay đổi.
                var row = $(this).closest('tr');
                // lấy trong db phần cart
                var id = $(this).data('id');
                var idproduct = $(this).data('idproduct');
                // nhập phần tử
                var quantityInput = row.find('input[name="product-quantity"]');
                // lấy giá trị
                var quantity = quantityInput.val();

                // Kiểm tra giá trị số lượng
                if (quantity <= 0) {
                    Toastify({
                        text: "Số lượng không hợp lệ",
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top",
                        position: "right",
                        stopOnFocus: true,
                        style: {
                            background: "red",
                        },
                        onClick: function() {}
                    }).showToast();
                    return; // Dừng thực hiện nếu số lượng không hợp lệ
                }

                // Tiếp tục thực hiện các thay đổi khác (ví dụ: gửi yêu cầu AJAX)
                $.ajax({
                    url: '../Authentication/editcart.php',
                    type: 'POST',
                    data: {
                        id: id,
                        idproduct: idproduct,
                        quantity: quantity
                    },
                    success: function(response) {
                        view_data();
                        if (response === "true") {
                            Toastify({
                                text: "Cập Nhật Thành Công",
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
                        } else {
                            console.log(response);
                            Swal.fire({
                                title: 'Lỗi',
                                text: response,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                });
            });


            $(document).on('click', '.btn-number', function(e) {
                e.preventDefault();
                // Nó lấy giá trị của thuộc tính khi người dùng tăng hoặc giảm
                var fieldName = $(this).attr('data-field');
                //  Biến này dùng để xác định xem người dùng đã nhấp vào nút gì
                var type = $(this).attr('data-type');
                //  // closest phương thức trả về tổ tiên đầu tiên của phần tử được chọn.
                // xác định dòng trong bảng mà người dùng đang thực hiện thay đổi.
                var input = $(this).closest('tr').find("input[name='" + fieldName + "']"); // Tìm phần tử đầu vào trong hàng hiện tại
                var currentVal = parseInt(input.val());


                if (!isNaN(currentVal)) {
                    if (type === 'minus') {
                        if (currentVal > 1) {
                            input.val(currentVal - 1).change();
                        }
                    } else if (type === 'plus') {
                        input.val(currentVal + 1).change();
                    }
                } else {
                    input.val(1);
                }
            });

            $('input[name="product-quantity"]').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

        });
    </script>
    <?php
    require_once '../View/Footer.php';
    ?>
<?php
}
?>