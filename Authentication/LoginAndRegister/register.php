<?php
require_once '../../db/connect.php';
?>

<?php

//email
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';


if (isset($_GET["username"])) {
  $username = $_GET["username"];
  if (empty($username)) {
    echo json_encode("Username Không Được Để Trống", JSON_UNESCAPED_UNICODE);
    // JSON_UNESCAPED_UNICODE ký tự Unicode không bị mã hóa lại.
    exit;
  }
  $sql = "SELECT * FROM users WHERE username = '" . $username . "'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    echo json_encode("Username Đã Tồn Tại", JSON_UNESCAPED_UNICODE);
    exit;
  }
}
if (isset($_GET["email"])) {
  $email = $_GET["email"];
  if (empty($email)) {
    echo json_encode("Email Không Được Để Trống", JSON_UNESCAPED_UNICODE);
    exit;
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode("Email Không Đúng Định Dạng", JSON_UNESCAPED_UNICODE);
    exit;
  }
  $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    echo json_encode("Email Đã Tồn Tại", JSON_UNESCAPED_UNICODE);
    exit;
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Lấy dữ liệu từ request POST
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $rpassword = $_POST["rpassword"];

  // Thực hiện xử lý đăng ký ở đây (kiểm tra dữ liệu, thêm vào cơ sở dữ liệu, vv.)
  $sql = "SELECT * FROM users WHERE username = '" . $username . "'";
  $result = mysqli_query($conn, $sql);

  // Sau khi xử lý thành công
  if (empty($username)) {
    $response = array('message' => 'Không có tài khoản');
    echo json_encode($response);
    //  json_encode để chuyển đổi mảng kết hợp vs $response thành một chuỗi JSON.nhận một mảng (hoặc đối tượng) 
    // và trả về phiên bản JSON của nó.
  } else if (empty($email)) {
    $response = array('message' => 'Không có email');
    echo json_encode($response);
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response =   array('message' => 'Email Không Đúng Định Dạng');
    echo json_encode($response);
  } else if (empty($password)) {
    $response = array('message' => 'Không có mật khẩu');
    echo json_encode($response);
  } else if (empty($rpassword)) {
    $response['message'] = 'Vui lòng nhập Lại Mật Khẩu';
    echo json_encode($response);
  } else if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
    $response = array('message' => 'Mật khẩu không được chứa kí tự đặc biệt');
    echo json_encode($response);
  } else if (strlen($password) < 6) {
    $response = array('message' => 'Mật khẩu phải có ít nhất 6 kí tự');
    echo json_encode($response);
  } else if (strlen($password) > 20) {
    $response = array('message' => 'Mật khẩu phải dưới 20 kí tự');
    echo json_encode($response);
  } else if ($password != $rpassword) {
    $response['message'] = 'Mật khẩu phải giống nhau';
    echo json_encode($response);
  } else {
    $sql = "SELECT * FROM users WHERE username = '" . $username . "'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
      $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
      $result = mysqli_query($conn, $sql);
      if (mysqli_num_rows($result) == 0) {
        $mail = new PHPMailer(true);
        try {
          $mail->SMTPDebug = 0;
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'dqh28092001@gmail.com';
          $mail->Password = 'auwkegklguqzyugp';
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port = 587;
          $mail->setFrom('dqh28092001@gmail.com', '');
          $mail->addAddress($email);
          $mail->isHTML(true);
          $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
          $mail->Subject = 'Email verification';
          $mail->Body    = '<p>Chào Mừng Đến Với Ashion, Mã Xác Thực Của Bạn Là:: <b style="font-size: 30px;">' . $verification_code . '</b></p>';
          $mail->send();

          $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
          $sql = "INSERT INTO users (username, email, password,verificationcodes) VALUES (?, ?, ?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ssss", $username, $email, $hashedPassword, $verification_code);
          // thực thi thực thi truy vấn SQL execute()
          if ($stmt->execute()) {
            $response = array('success' => true, 'username' => $username);
            echo json_encode($response);
          }
        } catch (Exception $e) {
          echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
      } else {
        $response = array('message' => 'Email Đã Tồn Tại');
        echo json_encode($response);
      }
    } else {
      $response = array('message' => 'Username Đã Tồn Tại');
      echo json_encode($response);
    }
  }
}
$conn->close();
?>