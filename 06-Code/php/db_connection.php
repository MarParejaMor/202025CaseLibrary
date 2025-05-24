<?php
$host = "localhost";
$user = "admin";
$password = "admin";
$database = "legal_system";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
