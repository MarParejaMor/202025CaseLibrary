<?php
header('Content-Type: application/json');
require_once("database.php");
// session_start(); // Ya no se necesita sesión

try {
    $conn = getDBConnection();

    // Ya no verificamos autenticación ni existe $_SESSION['account_id']

    $data = json_decode(file_get_contents('php://input'), true);

    $requiredFields = ['type', 'date', 'description'];
    foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
            throw new Exception("El campo $field es requerido");
        }
    }

    // Validar fecha en formato correcto
    $dateTime = DateTime::createFromFormat('Y-m-d\TH:i', $data['date']);
    if (!$dateTime) {
        throw new Exception('Formato de fecha inválido');
    }

    // Cambiar consulta para NO insertar account_id
    $stmt = $conn->prepare("INSERT INTO appointment (type, date, description, contact_info) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $type = htmlspecialchars($data['type']);
    $date = $dateTime->format('Y-m-d H:i:s');
    $description = htmlspecialchars($data['description']);
    $contact_info = htmlspecialchars($data['contact_info'] ?? '');

    $stmt->bind_param("ssss", $type, $date, $description, $contact_info);

    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Cita creada exitosamente',
        'appointment_id' => $conn->insert_id
    ]);

    $stmt->close();

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
