<?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone_number']);
    $password = $_POST['password'];

    // Validaciones básicas en backend (por seguridad)
    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Complete todos los campos obligatorios']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Correo electrónico inválido']);
        exit;
    }

    // Validar contraseña con patrón: mínimo 8 caracteres, 1 mayúscula, 3 números, 1 caracter especial
    if (!preg_match('/^(?=.*[A-Z])(?=(?:.*\d){3,})(?=.*[\W_]).{8,}$/', $password)) {
        echo json_encode(['success' => false, 'message' => 'La contraseña no cumple los requisitos']);
        exit;
    }

    // Verificar si el email ya existe
    $stmt = $conn->prepare("SELECT account_id FROM account WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Correo ya registrado']);
        $stmt->close();
        exit;
    }
    $stmt->close();

    // Hashear la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $stmt = $conn->prepare("INSERT INTO account (password, email, phone_number) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $hashedPassword, $email, $phone);

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
