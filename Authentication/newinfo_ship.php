<?php 
    session_start();
    require_once '../db/connect.php';
    if(isset($_SESSION["username"])){ 
        $username = $_SESSION["username"];
    }
    $fullname = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $response = "";
    if(empty($fullname)){
        $response = "nullname";
    }else if (empty($phone)) {
        $response = "nullphonenumber";
    } else if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
        $response = "erphonenumber";
    } else if (empty($address)) { 
        $response = "eraddress";
    }
    else {
        $sql = "INSERT INTO info_ship (username, fullname, phonenumber, address) VALUES ('$username', '$fullname', '$phone', '$address')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $response = "infotrue";
        } else {
            $response = "Có lỗi xảy ra. Vui lòng thử lại sau.";
        }
    }
    echo $response;
    $conn->close();
?>