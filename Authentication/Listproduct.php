<?php
require_once '../db/connect.php'; // Kết nối CSDL

// Thực hiện truy vấn để lấy dữ liệu sản phẩm
$query = "SELECT * FROM product";
$result = mysqli_query($conn, $query);

// Khởi tạo biến đếm sản phẩm trong hàng và số lượng sản phẩm cần hiển thị
$productCountInRow = 0;
$productsToShow = 8; // Số lượng sản phẩm cần hiển thị

// Bắt đầu một hàng mới
$productListHTML = '<div class="row">';

// Lặp qua danh sách sản phẩm và tạo HTML để hiển thị
while ($row = mysqli_fetch_assoc($result)) {
    if ($productCountInRow < $productsToShow) {
        $image = $row['image'];
        $name = $row['name'];
        $price = $row['price'];
        $formattedPrice = number_format($price, 0, '.', ',');
        $id = $row['id'];

        $productListHTML .= '<div class="col-md-3">';
        $productListHTML .= '<div class="card mb-4 product-wap rounded-0">';
        $productListHTML .= '<div class="card rounded-0">';
        $productListHTML .= '<img style="padding:5px" class="card-img  rounded-0 img-fluid" src="../Public/img/' . $image . '">';
        $productListHTML .= '<div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">';
        $productListHTML .= '<ul class="list-unstyled">';
        $productListHTML .= '<li><a class="btn btn-success text-white mt-2" href="../Views/DetailProduct.php?id=' . $id . '"><i class="far fa-eye"></i></a></li>';
        $productListHTML .= '</ul>';
        $productListHTML .= '</div>';
        $productListHTML .= '</div>';
        $productListHTML .= '<div class="card-body">';
        $productListHTML .= '<p  class="h3 text-decoration-none"><strong>' . $name . '</strong></p>';
        $productListHTML .= '<ul class="list-unstyled d-flex justify-content-center mb-1">';
        $productListHTML .= '<p class="text-center mb-0">' . '$' . $formattedPrice . '</p>';
        $productListHTML .= '</div>';
        $productListHTML .= '</div>';
        $productListHTML .= '</div>';

        $productCountInRow++;
    }
}

$productListHTML .= '</div>'; // Close the row

// Trả về danh sách sản phẩm dưới dạng HTML
echo $productListHTML;


?>
