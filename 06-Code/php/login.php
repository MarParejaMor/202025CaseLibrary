<?php
session_start();
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userInput = trim($_POST['userInput']);
    $password = $_POST['password'];

    // Consulta que busca por username o email
    $stmt = $conn->prepare("SELECT account_id, password FROM account WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $userInput, $userInput);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['account_id'] = $row['account_id'];
            echo json_encode(['success' => true, 'message' => 'Inicio de sesión exitoso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario o correo no encontrado']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
}
?>
