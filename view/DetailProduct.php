<?php
session_start();
require_once '../View/header.php';
?>
<!-- Open Content -->
<section class="">
    <div class="container pb-5">
        <div class="row">
            <!-- PHP read -->
            <?php
            require_once '../db/connect.php';
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "select *, product.name as name  from product,category where product.catalogcode=category.id and product.id= '" . $id . "' ";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $name = $row['name'];
                    $price = $row['price'];
                    $formattedPrice = number_format($price, 0, '.', ',');
                    $trademark = $row['trademark'];
                    $describe = $row['describe'];
                    $image = $row['image'];
                    $color = $row['color'];
                    $quantity = $row['quantity'];
            ?>
                    <!-- Product Details Section Begin -->
                    <section class="product-details spad">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <img class="card-img img-fluid" src="../public/img/<?php echo $image; ?>" alt="Card image cap" id="product-detail">
                                </div>
                                <div class="col-lg-6">
                                    <div class="product__details__text">
                                        <h3> <?php echo $name; ?></span></h3>
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <span>( 138 reviews )</span>
                                        </div>
                                        <div class="product__details__price"><?php echo '$' . $formattedPrice; ?><span>$ 530.000</span></div>
                                        <p class="text-muted">Brand:<strong>
                                                <?php echo $trademark; ?>
                                            </strong></p>
                                        <h6>Description:</h6>
                                        <p><?php echo $describe; ?></p>

                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <h6>Available Color:</h6>
                                            </li>
                                            <li class="list-inline-item">
                                                <p class="text-muted"><strong>
                                                        <?php echo $color; ?>
                                                    </strong></p>
                                            </li>
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <h6>Số Lượng Hiện Có:</h6>
                                                </li>
                                                <li class="list-inline-item">
                                                    <p class="text-muted"><strong>
                                                            <?php echo $quantity; ?>
                                                        </strong></p>
                                                </li>
                                            </ul>
                                            <form method="POST">
                                                <input type="hidden" id="idproduct" value="<?php echo $_GET['id']; ?>">
                                                <div class="product__details__button">
                                                    <div class="input-group">
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="product-quantity">
                                                                -
                                                            </button>
                                                        </span>
                                                        <input type="number" name="product-quantity" id="product-quantity" class="form-control col-5 ml-1 mr-1" value="1" />
                                                        <span class="input-group-btn">
                                                            <button type="button" class="btn btn-danger btn-number" data-type="plus" data-field="product-quantity">
                                                                +
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <div class="row pb-3">
                                                        <div class="ml-3 mb-3" id="result" style="color: red;"></div>
                                                        <div class="col-12 d-grid">
                                                            <button type="button" class="btn btn-danger btn-lg" name="addtocart" id="addtocart">Add To Cart</button>
                                                        </div>
                                                    </div>

                                                </div>
                                    </div>
                                    </form>
                                </div>
                                <div class="col-lg-12">
                                    <div class="product__details__tab">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Description</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Specification</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">Reviews ( 2 )</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                                <h6>Description</h6>
                                                <p><?php echo $describe; ?></p>
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                                    dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                                    nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                                    quis, sem.</p>
                                            </div>
                                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                                <h6>Specification</h6>
                                                <p>Điểm nổi bật của những sản phẩm trong Burberry chính là họa tiết các hình sọc vuông ấn tượng, độc lạ, đặc trưng giữa hàng trăm thương hiệu thời trang nổi tiếng khác. Chính vì vậy, kể từ khi thành lập đến nay thì Burberry luôn được giới mộ điệu đánh giá là một nhãn hàng thời trang có thế lực hùng mạnh với khối lượng sản phẩm đồ sộ ngày càng đẳng cấp, cũng như thể hiện được sự rất riêng của Burberry..</p>
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                                    dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                                    nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                                    quis, sem.</p>
                                            </div>
                                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                                <h6>Reviews ( 2 )</h6>
                                                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed
                                                    quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt loret.
                                                    Neque porro lorem quisquam est, qui dolorem ipsum quia dolor si. Nemo enim ipsam
                                                    voluptatem quia voluptas sit aspernatur aut odit aut loret fugit, sed quia ipsu
                                                    consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Nulla
                                                    consequat massa quis enim.</p>
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget
                                                    dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes,
                                                    nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium
                                                    quis, sem.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>
                    <!-- Product Details Section End -->

            <?php
                } else {
                    echo '<p>No product found.</p>';
                }
            } else {
                echo '<p>Invalid product ID.</p>';
            }
            mysqli_close($conn);
            ?>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        // Điều này gọi view_datahàm khi tài liệu đã sẵn sàng.
        view_data();

        function view_data() {
            $.post('../Authentication/Listproduct.php', function(data) {
                $("#load_data").html(data);
            });
        }
        $('#product-quantity').on('input', function() {
            // this.valueđ giá trị hiện tại của trường nhập 'sản phẩm-số lượng'.
            this.value = this.value.replace(/[^0-9]/g, '');
        });
        $(document).on('click', '#addtocart', function() {
            var id = $('#idproduct').val();
            var quantity = $('input[name="product-quantity"]').val();
            $.ajax({
                type: 'POST',
                url: '../Authentication/addtocart.php',
                data: {
                    id: id,
                    quantity: quantity
                },
                dataType: 'json',
                success: function(response) {
                    var color = "red";
                    if (response.message == "true") {
                        var color = "linear-gradient(to right, #00b09b, #96c93d)";
                        response.message = "Thêm Thành Công";
                    }
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        // destination: "https://github.com/apvarun/toastify-js",
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
                    // $('#result').text(response.message);
                },
                error: function() {
                    $('#result').text('An error occurred during the AJAX request.');
                }
            });
        });

        // Xử lý sự kiện click nút (+)
        $(document).on('click', '.btn-number', function(e) {
            e.preventDefault();
            // Nó lấy giá trị của thuộc tính khi người dùng tăng hoặc giảm
            var fieldName = $(this).attr('data-field');
            //  Biến này dùng để xác định xem người dùng đã nhấp vào nút gì
            var type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
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


    });
</script>
<?php
require_once '../View/Footer.php';
?>