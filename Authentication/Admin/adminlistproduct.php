<?php
require_once '../../db/connect.php';
// Lấy giá trị từ form POST và gán vào biến
$searchValue = isset($_POST['searchValue']) ? $_POST['searchValue'] : null;
$categoryvalue = isset($_POST['categoryId']) ? $_POST['categoryId'] : null;
// Tạo một mảng để lưu các điều kiện tìm kiếm
$where = [];
// Kiểm tra nếu có giá trị cho category
if ($categoryvalue !== null) {
    $categoryvalue = $_POST["categoryId"];
    $where[] = "p.catalogcode = '$categoryvalue'";
}
if ($searchValue !== null) {
    $searchValue = $_POST["searchValue"];
    $where[] = "(p.name LIKE '%$searchValue%' OR p.color LIKE '%$searchValue%' OR c.name LIKE '%$searchValue%' )";
}
// Tạo điều kiện WHERE bằng cách nối các điều kiện trong mảng
$whereClause = implode(' AND ', $where); //implode dùng để nối mảng
// Tạo truy vấn SQL dựa trên các điều kiện
$sql = "SELECT p.id, p.name, p.price, p.`describe`, p.quantity, p.image, p.color, p.datecreated, p.update_at, p.catalogcode, p.status, c.name AS category_name
    FROM product p
    JOIN category c ON p.catalogcode = c.id";
if (!empty($whereClause)) {
    $sql .= " WHERE $whereClause";
}
$result = mysqli_query($conn, $sql);
$response = "";
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row["id"];
        $name = $row['name'];
        $price = $row['price'];
        $quantity = $row['quantity'];
        $image = $row['image'];
        $color = $row['color'];
        $datecreated = $row['datecreated'];
        $status = $row['status'];
        $category_name = $row['category_name'];
        $response .= '<tr>';
        $response .= '<td class="small">' . $id . '</td>';
        $response .= '<td class="small">' . $name . '</td>';
        $formattedPrice = number_format($price, 2, '.', ',');
        $response .= '<td class="small">' . $formattedPrice . '</td>';
        $response .= '<td class="small">' . $quantity . '</td>';
        $response .= '<td class="small">';
        if (!empty($image)) {
            $response .= '<img src="../../Public/img/' . $image . '" alt="Ảnh Sản Phẩm" style="width: 100px;">';
        } else {
            $response .= '<span>Không có ảnh</span>';
        }
        $response .= '<td class="small">' . $color . '</td>';
        $response .= '<td class="small">' . $datecreated . '</td>';
        if ($status == 0) {
            $statusText = "Mở Bán";
            $statusColor = "green";
        } else if ($status == 1) {
            $statusText = "Dự Kiến";
            $statusColor = "blue";
        } else {
            $statusText = "Unknown";
            $statusColor = "gray";
        }
        $response .= '<td class="small" style="color: ' . $statusColor . ';">' . $statusText . '</td>';
        $response .= '<td class="small">' . $category_name . '</td>';
        $response .= '<td>';
        $response .= '<div class="btn-group" role="group">';
        $response .= '<button class="btn btn-danger delete-btn" data-id="' . $id . '" style="margin-right: 1pc;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;">Xoá</button>';
        $response .= '<a class="btn btn-success edit-btn" href="../Admin/adminupdateproduct.php?id=' . $id . '" style="margin-right: 1pc;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;">Sửa</a>';
        $response .= '</div>';
        $response .= '</td>';
        $response .= '</tr>';
    }
}
$conn->close();

echo $response;
