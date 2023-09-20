<?php
require_once '../../db/connect.php';
// Nó kiểm tra xem khóa 'searchValue' có tồn tại trong mảng siêu toàn cầu $_POST
if (isset($_POST['searchValue'])) {
    // biểu mẫu đã được gửi với trường có tên 'searchValue'), nó sẽ gán giá trị của nó cho biến $searchValue.
    $searchValue = $_POST['searchValue'];
} else {
    $searchValue = null;
}

$sql = "SELECT * FROM category"; 
// $where được tạo để lưu trữ các điều kiện sẽ được thêm vào truy vấn SQL sau này.
$where = [];

if ($searchValue !== null) {
    $searchValue = mysqli_real_escape_string($conn, $searchValue);
    $where[] = "(name LIKE '%$searchValue%' OR trademark LIKE '%$searchValue%')";
}
// Kiểm tra xem mảng $where có trống không
if (!empty($where)) {
    // Nếu mảng không trống, bắt đầu xây dựng phần điều kiện của câu truy vấn SQL
    $sql .= " WHERE ";
    
    // Sử dụng implode để nối các phần tử của mảng $where bằng "AND"
    // Điều này có nghĩa là tất cả các điều kiện trong mảng $where sẽ được kết hợp bằng "AND" trong câu truy vấn SQL
    $sql .= implode(" AND ", $where);
}

$result = mysqli_query($conn, $sql); 
$response = "";
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row["id"];
        $name = $row['name'];
        $trademark = $row['trademark'];
        $status = $row['status'];
        $datecreated = $row['datecreated'];
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
        $response .= '<tr>';
        $response .= '<td>'.$id.'</td>';
        $response .= '<td>'.$name.'</td>';
        $response .= '<td>'.$trademark.'</td>';
        $response .= '<td>'.$datecreated.'</td>';
        $response .= '<td style="color: ' . $statusColor . ';">' . $statusText . '</td>';
        $response .= '<td>';
        $response .= '<button class="btn btn-danger delete-btn" data-id="'.$id.'">Xoá</button>';
        $response .= '<a class="btn btn-success ml-3 edit-btn" href="../Admin/adminupdatecategory.php?id='.$id.'">Sửa</a>';
        $response .= '</td>';
        $response .= '</tr>';
    }
}
$conn->close();
echo $response;
?>
