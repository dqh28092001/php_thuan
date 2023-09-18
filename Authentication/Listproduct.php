<?php

require_once '../db/connect.php';

$response = ''; 

if (isset($_POST['searchValue'])) {
    // Kiểm tra xem 'searchValue' có được gửi qua POST không
    $searchValue = mysqli_real_escape_string($conn, $_POST['searchValue']);
} else {
    $searchValue = ''; 
}

// Truy vấn SQL để lấy tổng số sản phẩm phù hợp với tiêu chí tìm kiếm
$sql_count = "SELECT COUNT(*) as total FROM product p
              INNER JOIN category c ON p.catalogcode = c.id
              WHERE p.name LIKE '%$searchValue%' 
              AND p.status = 0 
              AND c.status = 0";

// hực hiện truy vấn SQL để lấy tổng số
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_items = $row_count['total'];

// Số lượng mục hiển thị trên mỗi trang
$items_per_page = 8;


$total_pages = ceil($total_items / $items_per_page);

// Lấy trang hiện tại từ dữ liệu POST hoặc mặc định là trang 1
$page = isset($_POST['page']) && is_numeric($_POST['page']) ? intval($_POST['page']) : 1;

// Tính toán offset cho truy vấn SQL
$offset = ($page - 1) * $items_per_page;

// Truy vấn SQL để tìm nạp sản phẩm cho trang hiện tại
$sql = "SELECT p.*, c.status as category_status
        FROM product p
        INNER JOIN category c ON p.catalogcode = c.id
        WHERE p.name LIKE '%$searchValue%' 
        AND p.status = 0 
        AND c.status = 0
        LIMIT $offset, $items_per_page";

// s
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    // Lặp lại các kết quả và xây dựng HTML phản hồi
    while ($row = mysqli_fetch_assoc($result)) {
        $status = $row['status'];
        $image = $row['image'];
        $name = $row['name'];
        $price = $row['price'];
        $formattedPrice = number_format($price, 2, '.', ',');
        $id = $row['id'];
        $category_status = $row['category_status'];

        if ($status == 0 && $category_status == 0) {
            // Xây dựng HTML thẻ sản phẩm
            $response .= '<div class="col-md-3">';
            $response .= '<div class="card mb-4 product-wap rounded-0">';
            $response .= '<div class="card rounded-0">';
            $response .= '<img style="padding:5px" class="card-img rounded-0 img-fluid" src="../Public/img/' . $image . '">';
            $response .= '<div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">';
            $response .= '<ul class="list-unstyled">';
            $response .= '<li><a class="btn btn-success text-white mt-2" href="../Views/DetailProduct.php?id=' . $id . '"><i class="far fa-eye"></i></a></li>';
            $response .= '</ul>';
            $response .= '</div>';
            $response .= '</div>';
            $response .= '<div class="card-body">';
            $response .= '<p  class="h3 text-decoration-none"><strong>' . $name . '</strong></p>';
            $response .= '<ul class="list-unstyled d-flex justify-content-center mb-1">';
            $response .= '<p class="text-center mb-0">' . '$' . $formattedPrice . '</p>';
            $response .= '</div>';
            $response .= '</div>';
            $response .= '</div>';
        }
    }
} else {
    $response .= 'Không Có Sản Phẩm'; // No products found message
}

$conn->close();

// Tạo một mảng với dữ liệu phản hồi
$responseData = array(
    'products' => $response,
    'total_pages' => $total_pages
);

// Mã hóa dữ liệu phản hồi dưới dạng JSON và lặp lại nó
echo json_encode($responseData);
?>
