<?php
require_once '../db/connect.php';

$id = $_POST["id"];
$action = $_POST["action"]; 
$response = "";

// Kiểm tra nếu hành động là "delete"
if ($action == "delete") {
    // Tạo truy vấn SQL để cập nhật bản ghi có id tương ứng
    $sql = "UPDATE oder SET admin_status = 2 WHERE id = $id"; 

    // Thực hiện truy vấn SQL và kiểm tra kết quả
    if ($conn->query($sql) === TRUE) { 
        $response = "Hủy Đơn Hàng Thành Công";
    } else {
        $response = "Lỗi";
    }
} 
// Kiểm tra nếu hành động là "approve"
else if ($action == "approve") {
    // Tạo truy vấn SQL để lấy thông tin đơn hàng và sản phẩm
    $order_query = "SELECT od.product_id, od.product_quantity, p.quantity AS available_quantity
                    FROM order_detail od
                    INNER JOIN product p ON od.product_id = p.id
                    WHERE od.oder_id = $id";
    $order_result = $conn->query($order_query);

    // Khởi tạo biến để kiểm tra xem có thể phê duyệt đơn hàng hay không
    $can_approve = true;    
    $products_to_update = array(); 

    // Kiểm tra kết quả truy vấn đơn hàng
    if ($order_result && $order_result->num_rows > 0) {
        while ($row = $order_result->fetch_assoc()) {
            $product_id = $row["product_id"];
            $order_quantity = $row["product_quantity"];
            $available_quantity = $row["available_quantity"];
            
            // Kiểm tra xem có đủ số lượng hàng trong kho để phê duyệt đơn hàng hay không
            if ($order_quantity > $available_quantity) {
                $can_approve = false;
                break;
            } else {
                $products_to_update[$product_id] = $order_quantity;
            }
        }
    } else {
        $can_approve = false;
    }
    
    // Nếu có thể phê duyệt đơn hàng
    if ($can_approve) {
        // Tạo truy vấn SQL để cập nhật trạng thái đơn hàng và số lượng sản phẩm
        $sql = "UPDATE oder SET admin_status = 1 WHERE id = $id"; 
        
        // Thực hiện truy vấn SQL để phê duyệt đơn hàng và cập nhật số lượng sản phẩm trong kho
        if ($conn->query($sql) === TRUE) { 
            foreach ($products_to_update as $product_id => $order_quantity) {
                $update_quantity_sql = "UPDATE product SET quantity = quantity - $order_quantity WHERE id = $product_id";
                $conn->query($update_quantity_sql);
            }
            $response = "Phê Duyệt Đơn Hàng Thành Công"; 
        } else {
            $response = "Lỗi";
        }
    } else {
        $response = "Không đủ số lượng hàng trong kho để phê duyệt đơn hàng này";
    }
} 
// Kiểm tra nếu hành động là "thanhtoan"
else if ($action == "thanhtoan") {
    // Tạo truy vấn SQL để xác nhận đơn hàng và thanh toán
    $sql = "UPDATE oder SET order_status = 1, payment_status = 1 WHERE id = $id"; 
    
    // Thực hiện truy vấn SQL để xác nhận đơn hàng và thanh toán
    if ($conn->query($sql) === TRUE) { 
        $response = "Xác Nhận Thành Công"; 
    } else {
        $response = "Lỗi";
    }
}

$conn->close();

echo $response;
?>
