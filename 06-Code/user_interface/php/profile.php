<?php
header('Content-Type: application/json');
require_once("database.php");

try {
    $conn = getDBConnection();

    // ID fijo para ejemplo (en producción, toma de sesión o parámetro)
    $account_id = 1;

    // Consulta perfil
    $sqlProfile = "SELECT 
                        a.name, 
                        a.lastname, 
                        a.email, 
                        a.phone_number,
                        up.title, 
                        up.bio, 
                        up.profile_picture,
                        up.profile_id
                    FROM account a
                    LEFT JOIN user_profile up ON a.account_id = up.account_id
                    WHERE a.account_id = ?
                    LIMIT 1";

    $stmt = $conn->prepare($sqlProfile);
    if (!$stmt) throw new Exception("Error en preparación: " . $conn->error);
    $stmt->bind_param("i", $account_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $profile = $result->fetch_assoc();
    $stmt->close();

    if (!$profile) {
        echo json_encode(['error' => 'Cuenta de usuario no encontrada']);
        exit;
    }

    // Obtener certificaciones
    $qualifications = [];
    if (!empty($profile['profile_id'])) {
        $sqlQualif = "SELECT qualification_type, role, institution, place, startYear, endYear FROM qualification WHERE profile_id = ?";
        $stmt2 = $conn->prepare($sqlQualif);
        if (!$stmt2) throw new Exception("Error en preparación: " . $conn->error);
        $stmt2->bind_param("i", $profile['profile_id']);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        while ($row = $result2->fetch_assoc()) {
            $qualifications[] = $row;
        }
        $stmt2->close();
    }

    // Armar respuesta
    $response = [
        'name' => $profile['name'],
        'lastname' => $profile['lastname'],
        'email' => $profile['email'],
        'phone_number' => $profile['phone_number'] ?? 'No registrado',
        'title' => $profile['title'] ?? '',
        'bio' => $profile['bio'] ?? 'Sin biografía',
        'profile_picture' => $profile['profile_picture'] ?? null,
        'qualifications' => $qualifications
    ];

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
