
<?php
require_once '../../db/connect.php';
$username = $_POST["username"];
$permission = $_POST["permission"];
$sql = "UPDATE users SET permission = ? WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $permission, $username);
if ($stmt->execute()) {
    $response = 200;
} else {
    $response = "Lỗi";
}
$stmt->close();
$conn->close();
echo $response;

?>
