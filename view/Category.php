<?php
session_start();
require_once '../View/header.php';
$minPrice = 0;
$maxPrice = PHP_INT_MAX;
if (isset($_GET["idcategory"])) {
    $idcategory = $_GET["idcategory"];
}
if (isset($_GET["price-range"])) {
    $pricerange = $_GET["price-range"];
    if ($pricerange === '5000') {
        $minPrice = 5000;
    } else {
        list($minPrice, $maxPrice) = explode('-', $pricerange);

        if (!is_numeric($minPrice) || !is_numeric($maxPrice)) {
            echo "Lỗi";
        }
    }
}
$productsPerPage = 4;


$sqlCount = "SELECT COUNT(*) AS total 
FROM product WHERE catalogcode = '$idcategory' 
AND price >= '$minPrice' AND price <= '$maxPrice'";
$resultCount = mysqli_query($conn, $sqlCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$totalProducts = $rowCount['total'];
$totalPages = ceil($totalProducts / $productsPerPage);
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($current_page - 1) * $productsPerPage;
$sql = "SELECT *
        FROM product 
        WHERE catalogcode = '$idcategory' 
        AND price >= '$minPrice'
        AND price <= '$maxPrice'
        LIMIT $start, $productsPerPage";
$result = mysqli_query($conn, $sql);
?>
<section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="shop__sidebar">
                       
                        <div class="sidebar__sizes">
                            <div class="section-title">
                                <h4>Price range from</h4>
                            </div>
                            <div class="size__list">
                                <label for="xxs">
                                <a class="form-check-label price-range-link" href="../View/category.php?idcategory=<?php echo $idcategory; ?>&price-range=100-500">
                        100$ - 500$
                    </a>
                                    
                                </label>
                                <label for="xs">
                                <a class="form-check-label price-range-link" href="../View/category.php?idcategory=<?php echo $idcategory; ?>&price-range=1000-5000">
                        1000$ - 5000$
                    </a>
                                    
                                </label>
                                <label for="xss">
                                <a class="form-check-label price-range-link" href="../View/category.php?idcategory=<?php echo $idcategory; ?>&price-range=5000">
                        Trên 5000$
                    </a>
                                </label>
                                
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                <div class="row mt-4 mb-4 ml-4 mr-4" style="min-height: 600px;">
    <!-- Categories -->
    
    <div class="col-md-10" style="text-align: center;">
        <?php
        if (isset($_GET["idcategory"])) {
            $idcategory = $_GET["idcategory"];
            require_once '../db/connect.php';
            $sql = "SELECT name FROM category WHERE id = $idcategory";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $name = $row['name'];
            } else {
                $name = "Unknown Category";
            }
        } else {
            $name = "Unknown Category";
        }
        ?>
        <h1 class="h1">Danh Mục
            <?php echo $name ?>
        </h1>
        <?php
        if (isset($_GET["price-range"])) {
            $pricerange = $_GET["price-range"];
        ?>
            <p class="text-danger">Khoảng Giá Từ
                <?php echo $pricerange ?>
            </p>
        <?php
        }
        ?>
        <div class="row" style="display: flex;
    justify-content: center;
    margin-top: 3pc;">
            <?php
            $sql = "SELECT *
                    FROM product 
                    WHERE catalogcode = '$idcategory' 
                    AND price >= '$minPrice'
                    AND price <= '$maxPrice'
                    LIMIT $start, $productsPerPage";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $status = $row['status'];
                    $image = $row['image'];
                    $name = $row['name'];
                    $price = $row['price'];
                    $formattedPrice = number_format($price, 2, '.', ',');
                    $id = $row['id'];
                    if ($status == 0) {
            ?>
                        <div class="col-md-6">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0">
                                    <img style="padding:5px" class="card-img rounded-0 img-fluid" src="../public/img/<?php echo $image; ?>">
                                    <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                        <ul class="list-unstyled">
                                            <li><a class="btn btn-success text-white mt-2" href="../View/DetailProduct.php?id=<?php echo $id; ?>"><i class="far fa-eye"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="h3 text-decoration-none"><strong>
                                            <?php echo $name; ?>
                                        </strong></p>
                                    <ul class="list-unstyled d-flex justify-content-center mb-1">
                                        <p class="text-center mb-0">
                                            <?php echo '$' . $formattedPrice; ?>
                                        </p>
                                    </ul>
                                </div>
                            </div>
                        </div>
            <?php
                    }
                }
            } else {
                echo '<p class="h3">Không có sản phẩm trong danh mục này.</p>';
            }
            ?>
        </div>
        <div class="ml-5 col-md-10">
            <div class="text-center ml-5 mt-4">
                <div id="pagination" class="pagination">
                    <?php
                    if ($totalPages > 1) {
                        for ($i = 1; $i <= $totalPages; $i++) {
                            $pageLink = "../View/category.php?idcategory=$idcategory&page=$i";
                            if (isset($pricerange)) {
                                $pageLink .= "&price-range=$pricerange";
                            }

                            // Kiểm tra nếu không có tham số page và $i là 1, hoặc tham số page là $i
                            if ((!isset($_GET['page']) && $i == 1) || (isset($_GET['page']) && $_GET['page'] == $i)) {
                                echo "<a style='font-weight: bold; padding:10px; border-radius: 10px; background-color: pink; margin: 10px;' href='$pageLink'>$i</a>";
                            } else {
                                echo "<a style='color: #333; border-radius: 10px; padding:10px; background-color: white; margin: 10px;' href='$pageLink'>$i</a>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
    </section>


<?php
require_once '../View/Footer.php';
?>
<script>
    $(document).ready(function() {
        $("#search-btn").click(function(event) {
            var searchValue = $("#search-input").val();
            if (searchValue.trim() === "") {
                event.preventDefault();
            } else {
                var searchUrl = "../View/Search.php?search=" + encodeURIComponent(searchValue);
                window.location.href = searchUrl;
            }
        });
    });
</script>