<?php
$host = "mysql.railway.internal";
$user = "root";
$password = "admin";
$database = "railway";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
