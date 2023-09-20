<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
} else {
    echo "khong co user";
}
$nameproduct = '';
$price = 0;
$image = '';
$quantity = 0;
$id = '';
$stt = 0;
require_once '../db/connect.php';
$sql = "SELECT cart.quantity, product.name, product.image, product.price, cart.id, product.id as idproduct  
    FROM cart 
    JOIN product ON cart.idproduct = product.id 
    WHERE username = '" . $username . "'";


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
        // Kiểm tra nếu số lượng là âm
        if ($quantity < 0) {
            // Xử lý thông báo lỗi và gán số lượng về 0
            // $quantity = 0;
            $response .= '<div class="alert alert-danger"></div>';
        }
        $total = $price * $quantity;
        $formattedPrice = number_format($total, 2, '.', ',');
        $stt++;
        $response .= '<tr>';
        $response .= '<td>' . $stt . '</td>';
        $response .= '<td>' . $nameproduct . '</td>';
        $response .= '<td class="col-2">' . '$' . $formattedPrice . '</td>';
        $response .= '<td>';
        
        if (!empty($image)) {
            $response .= '<img src="../Public/img/' . $image . '" alt="Ảnh Sản Phẩm" style="width: 100px;">';
        } else {
            $response .= '<span>Không có ảnh</span>';
        }
        $response .= '</td>';
        $response .= '<td>';
        $response .= '<div class="input-group" style="max-width: 300px; min-width:200px;">';
        $response .= '<span class="input-group-btn">
                            <button type="button" class="btn btn-success btn-number" data-type="minus" data-field="product-quantity">-</button>
                        </span>';
        $response .= '<input type="number" name="product-quantity" id="product-quantity"  class="form-control col-4 p-0 ml-1 mr-1" value="' . $quantity . '" />';
        $response .= '<span class="input-group-btn">
                            <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="product-quantity">+</button>
                        </span>';
        $response .= '</div>';
        $response .= '</td>';
        $response .= '<td>';
        $response .= '<div class="btn-group" role="group">';
        $response .= '<button class="btn btn-danger delete-btn" data-id="' . $id . '" style="margin-right: 1pc;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;">Xoá</button>';
        $response .= '<button class="btn btn-success edit-btn" data-id="' . $id . '" data-idproduct="' . $idproduct . '" style="margin-right: 1pc;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;">Cập Nhật</button>';
        $response .= '</div>';
        $response .= '</td>';
        $response .= '</tr>';
    }
}
$conn->close();

echo $response;
