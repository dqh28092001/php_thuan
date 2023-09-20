<?php 
    session_start();
    require_once '../db/connect.php';
    if(isset($_SESSION["username"])){ 
        $username = $_SESSION["username"];
    }
    $sql = "SELECT * FROM info_ship WHERE username = '".$username."'";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $fullname = $row['fullname'];
            $phonenumber = $row['phonenumber'];
            $address = $row['address'];
            
            // Đặt radio button và thông tin vào cùng một label
            echo '<label>';
            echo '<input class="form-check-input" type="radio" name="address" value="' . $fullname . ' - '. $phonenumber . ' - ' . $address . '" data-id="' . $id . '">';
            echo $fullname . ' - ' . $phonenumber . ' -<b> ' . $address . '</b>';
            echo '</label><br>';
        }
    }
    $conn->close();
?>
