<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!defined('CONFIG_PATH')) {
    define('CONFIG_PATH', __DIR__ . '/../../conexion/');
}

require_once(CONFIG_PATH . 'bd.php');

$response = ['success' => false, 'message' => ''];

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    $response['message'] = 'No has iniciado sesión o no se encontró tu nombre de usuario.';
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Método no permitido.';
    echo json_encode($response);
    exit;
}

$username = $_SESSION['username'];

if (!isset($_POST['requirement_name']) || !isset($_POST['type'])) {
    $response['message'] = 'Parámetros requeridos faltantes (requirement_name o type).';
    echo json_encode($response);
    exit;
}

$posted_requirement_name = trim($_POST['requirement_name']);
$type = trim($_POST['type']);

$requirement_name = '';

$count = 0;
if (preg_match('/^(\d+)\s+(tiempos|ascensos)/', $posted_requirement_name, $matches)) {
    $count = (int)$matches[1];
} else {
    error_log("Formato de requirement_name inesperado: " . $posted_requirement_name);
}

$count_column = '';
$message_type = '';
if ($type === 'tiempos') {
    $count_column = 'times_as_encargado_count';
    $message_type = 'Tiempos';
} elseif ($type === 'ascensos') {
    $count_column = 'ascensos_as_encargado_count';
    $message_type = 'Ascensos';
} else {
    $response['message'] = 'Tipo de registro no válido.';
    echo json_encode($response);
    exit;
}

try {
    $database = new Database();
    $conn = $database->getConnection();

    if (!$conn) {
        throw new Exception("No se pudo establecer la conexión con la base de datos.");
    }

    date_default_timezone_set('America/Mexico_City');
    $now = new DateTime();
    $startOfWeek = (clone $now)->modify('this week Monday')->format('Y-m-d 00:00:00');
    $endOfWeek = (clone $now)->modify('this week Sunday')->format('Y-m-d 23:59:59');

    $queryCheck = "SELECT id FROM gestion_requisitos
                   WHERE user = :user
                   AND last_updated BETWEEN :start_of_week AND :end_of_week";

    $stmtCheck = $conn->prepare($queryCheck);
    $stmtCheck->bindParam(':user', $username);
    $stmtCheck->bindParam(':start_of_week', $startOfWeek);
    $stmtCheck->bindParam(':end_of_week', $endOfWeek);
    $stmtCheck->execute();
    $existingRecord = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($existingRecord) {
        $query = "UPDATE gestion_requisitos
                  SET requirement_name = :requirement_name, {$count_column} = :count, last_updated = NOW()
                  WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':requirement_name', $requirement_name);
        $stmt->bindParam(':count', $count, PDO::PARAM_INT);
        $stmt->bindParam(':id', $existingRecord['id']);
        $message = "Requisito semanal de {$message_type} actualizado con éxito.";
    } else {
        $query = "INSERT INTO gestion_requisitos (user, requirement_name, times_as_encargado_count, ascensos_as_encargado_count, is_completed, last_updated)
                  VALUES (:user, :requirement_name, :times_count, :ascensos_count, FALSE, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user', $username);
        $stmt->bindParam(':requirement_name', $requirement_name);

        $times_count_val = ($type === 'tiempos') ? $count : 0;
        $ascensos_count_val = ($type === 'ascensos') ? $count : 0;

        $stmt->bindParam(':times_count', $times_count_val, PDO::PARAM_INT);
        $stmt->bindParam(':ascensos_count', $ascensos_count_val, PDO::PARAM_INT);

        $message = "Requisito semanal de {$message_type} registrado con éxito.";
    }

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = $message;
    } else {
        $response['message'] = "Error al procesar el requisito semanal de {$message_type} en la base de datos.";
    }

} catch (Exception $e) {
    $response['message'] = 'Error en el servidor: ' . $e->getMessage();
}

echo json_encode($response);

?>