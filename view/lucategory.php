<?php
session_start();
require_once '../View/header.php';

?>
<div class="row mt-4 mb-4 ml-4 mr-4" style="min-height:600px;">
    <div class="col-md-2 ">
        <div>
            <h1 class="h2 pb-4">Categories</h1>
            <ul class="list-unstyled templatemo-accordion border rounded">
                <?php
                require_once '../db/connect.php';
                $sql = "SELECT * FROM category WHERE status = 0";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $name = $row['name'];
                    $id = $row['id'];
                    ?>
                    <li><a class="idcategory nav-link" href="#" data-id="<?php echo $id; ?>"><?php echo $name; ?></a></li>
                    <?php
                }
                mysqli_close($conn);
                ?>
            </ul>
        </div>
        <div>
            <div class="form-group">
                <label for="price-range">Khoảng giá:</label>
                <div class="form-check">
                    <input class="form-check-input price-range" type="radio" name="price-range" id="range1"
                        value="100-500">
                    <label class="form-check-label" for="range1">
                        100$ - 500$
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input price-range" type="radio" name="price-range" id="range2"
                        value="1000-5000">
                    <label class="form-check-label" for="range2">
                        1000$ - 5000$
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input price-range" type="radio" name="price-range" id="range3"
                        value="5000">
                    <label class="form-check-label" for="range3">
                        Trên 5000$
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-10">
        <!-- product -->
        <h1 class="h1">Products</h1>
        <div class="row" id="load_data"></div>
        <div class="ml-5 col-md-10">
            <div class="text-center ml-5 mt-4">
                <div id="pagination" class="pagination"></div>
            </div>
        </div>
    </div>
</div>
<?php
require_once '../View/Footer.php';
?>
<script>
    $(document).ready(function () {
        $(".nav-item form").hide();
        var currentPage = 1;
        var totalPages = 0;

        function loadProducts(idcategory, priceRange, page = 1) {
            $("#load_data").empty();
            $.ajax({
                url: "../Authentication/listproductpage.php",
                type: "POST",
                data: {
                    idcategory: idcategory,
                    priceRange: priceRange,
                    page: page
                },
                dataType: "json",
                success: function (response) {
                    var responseData = response;
                    var productsHtml = responseData.products;
                    totalPages = responseData.total_pages;

                    if (page === 1) {
                        $("#load_data").html(productsHtml);
                    } else {
                        $("#load_data").append(productsHtml);
                    }
                    updatePagination(currentPage, totalPages);
                },
                error: function () {
                    $("#load_data").html("Không Có Sản Phẩm");
                }
            });
        }

        function updatePagination(currentPage, totalPages) {
            var paginationHtml = '';
            if (totalPages > 1) {
                for (var i = 1; i <= totalPages; i++) {
                    paginationHtml += `<button class="page-number ${i === currentPage ? 'active' : ''}">${i}</button>`;
                }
            }
            $("#pagination").html(paginationHtml);
        }
        // updatePageState cập nhật trạng thái của trang web trong URL của trình duyệt
        function updatePageState(idcategory, priceRange, page) {
            var url = `?idcategory=${idcategory}&price-range=${priceRange}&page=${page}`;
            history.pushState(null, null, url);
        }

        $(document).on('click', '.idcategory', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            loadProducts(id, "");
            $('.idcategory').removeClass('activecustom');
            $(this).addClass('activecustom');
            $('.price-range').prop('checked', false);
            currentPage = 1;
            updatePageState(id, "", currentPage);
            localStorage.removeItem('selectedPriceRange'); // Xóa giá trị giá tiền khi chọn category mới
        });

        $(document).on('change', '.price-range', function () {
            var idcategory = $("a.idcategory.activecustom").data('id');
            var priceRange = $(this).val();
            loadProducts(idcategory, priceRange);
            currentPage = 1;
            updatePageState(idcategory, priceRange, currentPage);
            localStorage.setItem('selectedPriceRange', priceRange);
        });

        $(document).on('click', '.page-number', function (event) {
            event.preventDefault();
            currentPage = parseInt($(this).text());
            var selectedCategory = $('.idcategory.activecustom').data('id');
            var selectedPriceRange = localStorage.getItem('selectedPriceRange');
            loadProducts(selectedCategory, selectedPriceRange, currentPage);
            updatePageState(selectedCategory, selectedPriceRange, currentPage);
        });

        // Khôi phục trạng thái từ URL khi tải lại trang
        var urlParams = new URLSearchParams(window.location.search);
        var initialIdCategory = urlParams.get('idcategory');
        var initialPriceRange = urlParams.get('price-range');
        var initialPage = urlParams.get('page');
        if (initialIdCategory) {
            loadProducts(initialIdCategory, initialPriceRange, initialPage);
            $('.idcategory[data-id="' + initialIdCategory + '"]').addClass('activecustom');
            currentPage = parseInt(initialPage);
        }

        // Khôi phục trạng thái của giá tiền từ localStorage khi tải lại trang
        // var savedPriceRange = localStorage.getItem('selectedPriceRange');
        // if (savedPriceRange) {
        //     $('input[name="price-range"][value="' + savedPriceRange + '"]').prop('checked', true);
        // }
    });
</script>