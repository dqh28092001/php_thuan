<?php
session_start();
require_once '../db/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = array();

    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
        $id = $_POST["id"];
        $quantity = $_POST["quantity"];

        if (empty($quantity)) {
            $response['message'] = 'Vui Lòng Nhập Số Lượng';
        } else {
            $sqlQuantity = "SELECT * FROM product WHERE id = ?";
            // prepare chuẩn bị một câu lệnh SQL 
            $stmtQuantity = $conn->prepare($sqlQuantity);
            // Dòng này liên kết một tham số với câu lệnh đã chuẩn bị. Chỉ "i"ra rằng tham số là một số nguyên. 
            $stmtQuantity->bind_param("i", $id);
            $stmtQuantity->execute();
            $resultQuantity = $stmtQuantity->get_result();

            // nó đang kiểm tra xem một sản phẩm có ID cụ thể có tồn tại trong product hay không.
            if ($resultQuantity && $resultQuantity->num_rows > 0) {
                // Nếu sản phẩm tồn tại, nó sẽ lấy số lượng có sẵn của sản phẩm đó từ cơ sở dữ liệu.
                $row = $resultQuantity->fetch_assoc();
                // số lượng có trong kho
                $availableQuantity = $row['quantity'];
                
                //  Nó tính tổng cột "số lượng" trong bảng "giỏ hàng" cho "tên người dùng" và "idproduct" 
                // cụ thể. Kết quả được đặt bí danh là "total_quantity".
                $sqlCartQuantity = "SELECT SUM(quantity) as total_quantity FROM cart WHERE username = ? AND idproduct = ?";
                $stmtCartQuantity = $conn->prepare($sqlCartQuantity);
                $stmtCartQuantity->bind_param("si", $username, $id);
                $stmtCartQuantity->execute();
                $resultCartQuantity = $stmtCartQuantity->get_result();
                $rowCartQuantity = $resultCartQuantity->fetch_assoc();
                $totalCartQuantity = $rowCartQuantity['total_quantity'];

                // kiểm tra xem số lương còn trong kho hay khôg
                if (($totalCartQuantity + $quantity) <= $availableQuantity) {

                    $sqlUserAndProduct = "SELECT * FROM cart WHERE username = ? AND idproduct = ?";
                    $stmtUserAndProduct = $conn->prepare($sqlUserAndProduct);
                    $stmtUserAndProduct->bind_param("si", $username, $id);
                    $stmtUserAndProduct->execute();
                    $resultUserAndProduct = $stmtUserAndProduct->get_result();

                    // ADD SẢN PHẨM
                    //  có nghĩa là đã tìm thấy bản ghi khớp trong bảng 'giỏ hàng' cho 'tên người dùng' và 'idproduct đã cho '.
                    if ($resultUserAndProduct && $resultUserAndProduct->num_rows > 0) {
                        $sql = "UPDATE cart SET quantity = quantity + ? WHERE username = ? AND idproduct = ?";
                        $stmt = $conn->prepare($sql);
                        // "isi"là một chuỗi định dạng chỉ định kiểu dữ liệu của các biến mà bạn đang liên kết với phần giữ chỗ. 
                        // "i"là viết tắt của số nguyên.
                        // "s"là viết tắt của chuỗi.
                        $stmt->bind_param("isi", $quantity, $username, $id);
                    } else {
                        $sql = "INSERT INTO cart (username, idproduct, quantity) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sii", $username, $id, $quantity);
                    }

                    if ($stmt->execute() && $stmt->affected_rows > 0) {
                        $response['message'] = 'true';
                    } else {
                        $response['message'] = 'Thất Bại';
                    }
                } else {
                    $response['message'] = 'Số Lượng Hàng Không Đủ';
                }
            } else {
                $response['message'] = 'Không Tìm Thấy Sản Phẩm';
            }
        }
    } else {
        $response['message'] = 'Vui Lòng Đăng Nhập';
    }

    echo json_encode($response);
    exit;
}

$conn->close();
