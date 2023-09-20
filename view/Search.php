<?php
session_start();

require_once '../View/header.php';

?>
<div class="row mt-4 mb-4 ml-4 mr-4" style="min-height: 600px;">
    <div class="col-md-10 mx-auto"> 
        <h2>Tìm Kiếm Sản Phẩm</h2>
        <div class="row">
            <?php
            require_once '../db/connect.php';
            $searchValue = $_GET['search'];
            $escapedSearchValue = $conn->real_escape_string($searchValue);
            //real_escape_string xử lí tránh tấn công SQL injection
            $sql = "SELECT p.*, c.name as namecategory
            FROM product p
            INNER JOIN category c ON p.catalogcode = c.id
            WHERE p.name LIKE '%$escapedSearchValue%' OR c.name LIKE '%$escapedSearchValue%'";
                    
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
                        <div class="col-md-3">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0">
                                    <img style="padding:5px" class="card-img rounded-0 img-fluid"
                                        src="../public/img/<?php echo $image; ?>">
                                    <div
                                        class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                        <ul class="list-unstyled">
                                            <li><a class="btn btn-success text-white mt-2"
                                                    href="../View/DetailProduct.php?id=<?php echo $id; ?>"><i
                                                        class="far fa-eye"></i></a></li>
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
                echo '<p  class="h3 ml-3 text-danger">Không có sản phẩm trong danh mục này.</p>';
            }
            ?>
        </div>
    </div>
</div>

<?php
require_once '../View/Footer.php';
?>
<script>
    $(document).ready(function () {
        $("#search-btn").click(function(event) {
            var searchValue = $("#search-input").val();
            var searchUrl = "../View/Search.php?search=" + encodeURIComponent(searchValue);
            //encodeURIComponent mã hóa
            window.location.href = searchUrl;
        }); 
    });
</script>