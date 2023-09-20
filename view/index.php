<?php
session_start();
require_once '../View/header.php';

?>
<!-- Categories Section Begin -->
<section class="categories">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 p-0">
                <div class="categories__item categories__large__item set-bg" data-setbg="../display/img/categories/category-1.jpg">
                    <div class="categories__text">
                        <h1>Women’s fashion</h1>
                        <p>Sitamet, consectetur adipiscing elit, sed do eiusmod tempor incidid-unt labore
                            edolore magna aliquapendisse ultrices gravida.</p>
                        <a href="#">Shop now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="../display/img/categories/category-2.jpg">
                            <div class="categories__text">
                                <h4>Men’s fashion</h4>
                                <p>358 items</p>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="../display/img/categories/category-3.jpg">
                            <div class="categories__text">
                                <h4>Kid’s fashion</h4>
                                <p>273 items</p>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="../display/img/categories/category-4.jpg">
                            <div class="categories__text">
                                <h4>Cosmetics</h4>
                                <p>159 items</p>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="../display/img/categories/category-5.jpg">
                            <div class="categories__text">
                                <h4>Accessories</h4>
                                <p>792 items</p>
                                <a href="#">Shop now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Product Section Begin -->
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h4>Products</h4>
                </div>
            </div>

        </div>
        <div>
            <div id="product_list">
                <!-- Danh sách sản phẩm sẽ được hiển thị ở đây -->
            </div>
            <div id="pagination_container">
                <!-- Các nút phân trang sẽ được hiển thị ở đây -->
            </div>


        </div>
    </div>
</section>
<!-- Product Section End -->

<!-- Banner Section Begin -->
<section class="banner set-bg" data-setbg="../display/img/banner/banner-1.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-8 m-auto">
                <div class="banner__slider owl-carousel">
                    <div class="banner__item">
                        <div class="banner__text">
                            <span>The Chloe Collection</span>
                            <h1>The Project Jacket</h1>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                    <div class="banner__item">
                        <div class="banner__text">
                            <span>The Chloe Collection</span>
                            <h1>The Project Jacket</h1>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                    <div class="banner__item">
                        <div class="banner__text">
                            <span>The Chloe Collection</span>
                            <h1>The Project Jacket</h1>
                            <a href="#">Shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->


<!-- Discount Section Begin -->


<!-- Services Section Begin -->
<section class="services spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-car"></i>
                    <h6>Free Shipping</h6>
                    <p>For all oder over $99</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-money"></i>
                    <h6>Money Back Guarantee</h6>
                    <p>If good have Problems</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-support"></i>
                    <h6>Online Support 24/7</h6>
                    <p>Dedicated support</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="services__item">
                    <i class="fa fa-headphones"></i>
                    <h6>Payment Secure</h6>
                    <p>100% secure payment</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->


<?php
require_once '../view/footer.php';

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Định nghĩa hàm loadProducts(page) để tải sản phẩm từ máy chủ
    function loadProducts(page) {
        $.ajax({
            url: '../Authentication/Listproduct.php',
            type: 'POST',
            data: {
                page: page
            },
            success: function(data) {
                // Khi yêu cầu thành công, thay thế nội dung của #product_list bằng dữ liệu tải được
                $('#product_list').html(data);
            },
            error: function(xhr, status, error) {
                // Xử lý lỗi nếu có
                console.log('Error: ' + error);
            }
        });
    }

    // Định nghĩa hàm changePage(page) để xử lý sự kiện khi người dùng chuyển trang
    function changePage(page) {
        loadProducts(page); // Gọi hàm loadProducts để tải sản phẩm cho trang mới

        // Thay đổi URL trên thanh địa chỉ trình duyệt bằng cách sử dụng HTML5 History API
        var newUrl = window.location.pathname + '?page=' + page;
        history.pushState({}, '', newUrl);
    }

    $(document).ready(function() {
        loadProducts(1); // Load trang đầu tiên khi trang web được tải

        // Định nghĩa lại hàm loadProducts(page) bên trong ready function
        function loadProducts(page) {
            $.ajax({
                url: '../Authentication/Listproduct.php',
                type: 'POST',
                data: {
                    page: page
                },
                success: function(data) {
                    $('#product_list').html(data);
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        }

        // Lắng nghe sự kiện khi người dùng click vào nút phân trang (pagination-link)
        $(document).on('click', '.pagination-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            changePage(page); // Gọi hàm changePage để chuyển trang
        });

        // Lấy số trang từ URL nếu có và tải sản phẩm tương ứng
        var urlParams = new URLSearchParams(window.location.search);
        var pageParam = urlParams.get('page');
        if (pageParam) {
            loadProducts(pageParam);
        }
    });
</script>