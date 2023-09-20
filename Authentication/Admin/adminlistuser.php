<?php
require_once '../../db/connect.php';
$selectedValue = isset($_POST['selectedValue']) ? $_POST['selectedValue'] : null;
$searchValue = isset($_POST['searchValue']) ? $_POST['searchValue'] : null;

$sql = "SELECT * FROM users"; 
$where = [];

if ($selectedValue !== null) {
    $where[] = "permission = '$selectedValue'";
}

if ($searchValue !== null) {
    $searchValue = mysqli_real_escape_string($conn, $searchValue);
    $where[] = "(name LIKE '%$searchValue%' OR email LIKE '%$searchValue%')";
}

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$result = mysqli_query($conn, $sql); 
$response = "";
$stt = 1;
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row["username"];
        $name = $row['name'];
        $email = $row['email'];
        $permission = $row['permission'];
        $image = $row['image'];    
        $datecreated = $row['datecreated'];        
        $response .= '<tr>';
        $response .= '<td class="small">'.$stt.'</td>';
        $response .= '<td class="small">'.$username.'</td>';
        $response .= '<td class="small col-2"> '.$name.'</td>';
        $response .= '<td class="small col-2">'.$email.'</td>';
        if ($permission == 1) {
            $permissionText = "Quản Trị Viên";
            $permissionColor = "green"; 
        } else {
            $permissionText = "Khách Hàng";
            $permissionColor = "blue"; 
        }
        
        $response .= '<td class="small" style="color: ' . $permissionColor . '">' . $permissionText . '</td>';
        $response .= '<td class="small">';
        if (!empty($image)) {
            $response .= '<img src="../../Public/img/'.$image.'" alt="Ảnh Người Dùng" style="width: 60px;">';
        } else {
            $response .= '<img src="../../Public/img/khach.jpg" alt="Ảnh Người Dùng" style="width: 60px;">';
        }
        $response .= '</td>';
        $response .= '<td class="small">'.$datecreated.'</td>';
        $response .= '<td class="small">';
        $response .= '<button class="btn ml-3 edit-btn" name="edit-btn" data-toggle="modal" data-target="#customModal" data-username="' .$username . '" value="' . $username . '" style="background: #d98585;
        color: #fff;
        margin-right: 10px;
        border-radius: 8px;
        font-family: initial;
        border: none;">Chỉnh Sửa Quyền</button>';
        $response .= '</td>';
        $response .= '</tr>';
        $stt += 1;
    }
}
$conn->close();
echo $response;
?>
