<?php
session_start();
require_once '../../db/connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usernamelog = $_POST["usernamelog"];
  $passwordlog = $_POST["passwordlog"];
  $response = array();


  if (empty($usernamelog)) {
    $response['message'] = 'Vui lòng nhập tên đăng nhập.';
  } else if (empty($passwordlog)) {
    $response['message'] = 'Vui lòng nhập mật khẩu.';
  } else if (strlen($passwordlog) < 6) {
    $response['message'] = 'Mật khẩu phải có ít nhất 6 kí tự.';
  } else {
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usernamelog);
    $stmt->execute();
    $result = $stmt->get_result();
    // ($result->num_rows > 0) kiểm tra xem có bất kỳ hàng nào được truy vấn trả về hay không. 
    // Nếu có, điều đó có nghĩa là người dùng có tên người dùng được cung cấp tồn tại trong cơ sở dữ liệu.
    if ($result->num_rows > 0) {
      // $row lưu trữ hàng đầu tiên của tập kết quả.
      $row = $result->fetch_assoc();
      $hashedPassword = $row['password'];
      $vertified = $row['vertified'];
      $email = $row['email'];
      if (password_verify($passwordlog, $hashedPassword)) {
        if ($vertified == 0) {
          $sql = "UPDATE users SET verificationcodes = ? WHERE username = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ss", $verification_code, $usernamelog);
          if ($stmt->execute()) {
            $response['message'] = 'xacthuc';
          }
        } else {
          $_SESSION['username'] = $usernamelog;
          $permission = $row['permission'];
          if ($permission == 0) {
            $response['message'] = 'user';
          } else if ($permission == 1) {
            $response['message'] = 'admin';
          }
        }
      } else {
        $response['message'] = 'Tên Đăng Nhập Hoặc Mật Khẩu Không Đúng.';
      }
    } else {
      $response['message'] = 'Tên Đăng Nhập Hoặc Mật Khẩu Không Đúng.';
    }
  }
  echo json_encode($response);
}

$conn->close();
