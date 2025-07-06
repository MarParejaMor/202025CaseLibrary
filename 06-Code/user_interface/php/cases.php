<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
require_once("database.php"); // ✅ Si está en la misma carpeta


$response = [];

try {
    // Construir consulta base
    $query = "SELECT * FROM process WHERE 1=1";
    $params = [];
    $types = '';

    // Filtrar por búsqueda
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = "%{$_GET['search']}%";
        $query .= " AND (title LIKE ? OR process_number LIKE ? OR process_type LIKE ?)";
        $params = array_merge($params, [$search, $search, $search]);
        $types .= 'sss';
    }

    // Filtrar por estado
    if (isset($_GET['status']) && $_GET['status'] !== 'all') {
        $query .= " AND process_status = ?";
        $params[] = $_GET['status'];
        $types .= 's';
    }

    $query .= " ORDER BY process_id DESC";

    // Preparar y ejecutar consulta
    $stmt = $conn->prepare($query);
    
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $cases = $result->fetch_all(MYSQLI_ASSOC);

    $response = [
        'success' => true,
        'data' => $cases,
        'count' => count($cases)
    ];

} catch (Exception $e) {
    http_response_code(500);
    $response = [
        'success' => false,
        'message' => 'Error al obtener casos: ' . $e->getMessage()
    ];
}

echo json_encode($response);
$conn->close();
?>