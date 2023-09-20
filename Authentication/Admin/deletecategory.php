<?php
    require_once '../../db/connect.php';
    $id = $_POST["id"];
    $sql = "DELETE FROM category WHERE id = $id"; 
    $result = mysqli_query($conn, $sql);
?>