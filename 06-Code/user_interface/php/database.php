<?php
$host = "mysql.railway.internal";
$user = "root";
$password = "XMUHooSNwYbAZhKljqaXhDqZWCJVcZBP";
$database = "legal_system";
$port = 3306;

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

function getDBConnection() {
    global $conn;
    return $conn;
}
?>