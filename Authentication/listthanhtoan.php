<?php
session_start();
    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];

    }else{
        echo "khong co user";
    }
    $nameproduct = '';
    $price = 0;
    $image = '';
    $quantity = 0;
    $id='';
    $stt = 0; 
    require_once '../db/connect.php';
    $sql = "SELECT cart.quantity, product.name, product.image, product.price, cart.id, product.id as idproduct  
    FROM cart 
    JOIN product ON cart.idproduct = product.id 
    WHERE username = '".$username."'";


    $result = mysqli_query($conn, $sql); 
    $response = "";
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $nameproduct = $row["name"];
            $price = $row['price'];
            $image = $row['image'];
            $quantity = $row['quantity'];
            $id = $row['id'];
            $idproduct = $row['idproduct'];
            $stt++;
            $response .= '<tr>';
            $response .= '<td>' . $stt . '</td>';
            $response .= '<td>' . $nameproduct . '</td>';
            $response .= '<td>';
            if (!empty($image)) {
                $response .= '<img src="../Public/img/' . $image . '" alt="Ảnh Sản Phẩm" style="width: 100px;">';
            } else {
                $response .= '<span>Không có ảnh</span>';
            }
            $response .= '</td>';
            $formattedPrice = number_format(($price * $quantity), 2, '.', ',');
            $response .= '<td>' . $formattedPrice . '</td>';
            $response .= '<td>' . $quantity . '</td>';
            $response .= '</tr>';
        }
    }
    
    $conn->close();

    echo $response;
?>
