<?php
$servername = "localhost"; // Replace with your database server name
$usernamedb = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "php_thuan"; // Replace with your database name
 
// Create a connection
$conn = new mysqli($servername, $usernamedb, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
