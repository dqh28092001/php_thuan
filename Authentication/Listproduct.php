<?php

require_once '../db/connect.php';

// tổng số sản phẩm hiện thị 
$productsPerPage = 8;
// để xác định trang hiện tại.
$current_page = isset($_POST['page']) ? $_POST['page'] : 1;
//  tính chỉ số bắt đầu của sản phẩm cần hiển thị trên trang này.
$startIndex = ($current_page - 1) * $productsPerPage;

// Truy vấn sản phẩm cho trang hiện tại
$query = "SELECT * FROM product LIMIT $startIndex, $productsPerPage";
$result = mysqli_query($conn, $query);

// Bắt đầu một hàng mới
$productListHTML = '<div class="row">';

while ($row = mysqli_fetch_assoc($result)) {
    $image = $row['image'];
    $name = $row['name'];
    $price = $row['price'];
    $formattedPrice = number_format($price, 0, '.', ',');
    $id = $row['id'];

    // Đối với mỗi sản phẩm, thêm một cột vào hàng
    $productListHTML .= '<div class="col-md-3">';
    $productListHTML .= '<div class="card mb-4 product-wap rounded-0">';
    $productListHTML .= '<div class="card rounded-0">';
    $productListHTML .= '<img style="padding:5px" class="card-img  rounded-0 img-fluid" src="../Public/img/' . $image . '">';
    $productListHTML .= '<div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">';
    $productListHTML .= '<ul class="list-unstyled">';
    $productListHTML .= '<li><a class="btn btn-success text-white mt-2" href="../View/DetailProduct.php?id=' . $id . '"><i class="far fa-eye"></i></a></li>';
    $productListHTML .= '</ul>';
    $productListHTML .= '</div>';
    $productListHTML .= '</div>';
    $productListHTML .= '<div class="card-body">';
    $productListHTML .= '<p class="h3 text-decoration-none"><strong>' . $name . '</strong></p>';
    $productListHTML .= '<ul class="list-unstyled d-flex justify-content-center mb-1">';
    $productListHTML .= '<p class="text-center mb-0">' . '$' . $formattedPrice . '</p>';
    $productListHTML .= '</div>';
    $productListHTML .= '</div>';
    $productListHTML .= '</div>';
}

// Kết thúc hàng
$productListHTML .= '</div>';

echo $productListHTML;

// đếm số dòng trong bảng product 
$queryTotal = "SELECT COUNT(*) AS total FROM product";
$totalResult = mysqli_query($conn, $queryTotal);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalProducts = $totalRow['total'];
// ính tổng số trang cần hiển thị
$totalPages = ceil($totalProducts / $productsPerPage);

echo '<ul class="pagination">';
for ($page = 1; $page <= $totalPages; $page++) {
    $activeClass = ($page == $current_page) ? 'active' : '';
    echo '<li class="page-item ' . $activeClass . '">';
    echo '<a class="page-link page-btn" href="#" data-page="' . $page . '" onclick="changePage(' . $page . '); return false;">' . $page . '</a>';
    echo '</li>';
}
echo '</ul>';
?>
