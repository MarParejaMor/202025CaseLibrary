<?php
$host = "localhost";
$user = "admin";
$password = "admin";
$database = "legalcondor";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
