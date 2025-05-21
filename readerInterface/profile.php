<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'legal_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $account_id = 1; // ID del usuario logueado

    // Consulta principal del perfil
    $stmtProfile = $pdo->prepare("
        SELECT 
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
        WHERE a.account_id = :account_id
        LIMIT 1
    ");
    $stmtProfile->execute(['account_id' => $account_id]);
    $profile = $stmtProfile->fetch();

    if (!$profile) {
        echo json_encode(['error' => 'Cuenta de usuario no encontrada']);
        exit;
    }

    // Manejo de certificaciones
    $qualifications = [];
    if (!empty($profile['profile_id'])) {
        $stmtQualif = $pdo->prepare("
            SELECT qualification_type, role, institution, place, 
                   startYear, endYear 
            FROM qualification 
            WHERE profile_id = :profile_id
        ");
        $stmtQualif->execute(['profile_id' => $profile['profile_id']]);
        $qualifications = $stmtQualif->fetchAll();
    }

    // Construir respuesta
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

} catch (PDOException $e) {
    echo json_encode([
        'error' => 'Error de base de datos: ' . $e->getMessage()
    ]);
    exit;
}
?>