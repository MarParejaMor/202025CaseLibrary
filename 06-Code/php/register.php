<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone_number']);
    $password = $_POST['password'];

    // Validaciones básicas en backend (por seguridad)
    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Complete todos los campos obligatorios']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Correo electrónico inválido']);
        exit;
    }

    // Validar contraseña con mismo patrón: mínimo 8 caracteres, 1 mayúscula, 3 números, 1 caracter especial
    if (!preg_match('/^(?=.*[A-Z])(?=(?:.*\d){3,})(?=.*[\W_]).{8,}$/', $password)) {
        echo json_encode(['success' => false, 'message' => 'La contraseña no cumple los requisitos']);
        exit;
    }

    // Verificar si username o email ya existen
    $stmt = $conn->prepare("SELECT account_id FROM account WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Usuario o correo ya registrado']);
        $stmt->close();
        exit;
    }
    $stmt->close();

    // Hashear la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $stmt = $conn->prepare("INSERT INTO ACCOUNT (username, password, email, phone_number) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $hashedPassword, $email, $phone);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Registro exitoso. Ya puede iniciar sesión.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar usuario']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
}
?>
