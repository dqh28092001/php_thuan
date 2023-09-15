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



// Lấy dữ liệu từ request POST
$username = $_POST["username"];

// Sau khi xử lý thành công
if (empty($username)) {
    $response['message'] = 'Vui lòng nhập username';
    //  json_encode để chuyển đổi mảng kết hợp vs $response thành một chuỗi JSON.nhận một mảng (hoặc đối tượng) 
    // và trả về phiên bản JSON của nó.
} else {
    $response['message'] = 'OK';
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
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
            $length = 50;
            $randomBytes = random_bytes($length);
            $randomString = bin2hex($randomBytes);
            $mail->Subject = 'Email Forgot Password';
            $reset_password_url = 'http://localhost:8081/PHP_Thuan/Authentication/LoginAndRegister/CheckEmailForgot.php?forgot_code=' . $randomString;
            $mail->Body = '<p>Chào Mừng Bạn Đến Với Ashion, Bạn đang trong quá trình thao tác quên mật khẩu, vui lòng click vào đây để tiếp tục: <b style="font-size: 30px;"><a href="' . $reset_password_url . '">Nhấn vào đây</a></b></p>';
            $mail->send();
            $sql = "UPDATE users SET forgot_code = ? WHERE username = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $randomString,  $username);
            if ($stmt->execute()) {
                $response['message'] = 'true';
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $response['message'] = 'Tài Khoản Không Tồn Tại';
    }
}

echo json_encode($response);

$conn->close();
?>