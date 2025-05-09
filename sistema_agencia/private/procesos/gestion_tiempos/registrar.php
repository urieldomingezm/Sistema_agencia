<?php
require_once(CONFIG_PATH . 'bd.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_POST['codigo_time'], $_POST['hora_inicio'], $_POST['hora_fin'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$codigo_time = trim($_POST['codigo_time']);
$hora_inicio = $_POST['hora_inicio'];
$hora_fin = $_POST['hora_fin'];
$observaciones = isset($_POST['observaciones']) ? trim($_POST['observaciones']) : null;

try {
    $database = new Database();
    $conn = $database->getConnection();

    // Aquí puedes ajustar la lógica según tu modelo de datos
    $query = "UPDATE gestion_tiempo 
              SET tiempo_status = 'en_progreso', 
                  tiempo_transcurrido = :hora_inicio, 
                  tiempo_llevando = 1, 
                  tiempo_fecha_registro = NOW(),
                  observaciones = :observaciones
              WHERE codigo_time = :codigo_time";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':hora_inicio', $hora_inicio);
    $stmt->bindParam(':codigo_time', $codigo_time);
    $stmt->bindParam(':observaciones', $observaciones);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se pudo registrar el tiempo.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos.']);
}
?>