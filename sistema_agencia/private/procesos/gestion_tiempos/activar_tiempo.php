<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'No has iniciado sesión']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$camposRequeridos = [
    'codigo_time', 
    'tiempo_status',
    'tiempo_encargado_usuario'
];

foreach ($camposRequeridos as $campo) {
    if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
        echo json_encode(['success' => false, 'message' => "El campo $campo es requerido"]);
        exit;
    }
}

$codigoTime = trim($_POST['codigo_time']);
$tiempoStatus = trim($_POST['tiempo_status']);
// Ya no usaremos estos valores para actualizar
// Solo los recibimos pero no los utilizaremos en la actualización
$tiempoAcumulado = isset($_POST['tiempo_acumulado']) ? trim($_POST['tiempo_acumulado']) : '00:00:00';
$tiempoRestado = isset($_POST['tiempo_restado']) ? trim($_POST['tiempo_restado']) : '00:00:00';
$tiempoEncargadoUsuario = trim($_POST['tiempo_encargado_usuario']);

if (!defined('CONFIG_PATH')) {
    define('CONFIG_PATH', $_SERVER['DOCUMENT_ROOT'] . '/private/conexion/');
}

if (!file_exists(CONFIG_PATH . 'bd.php')) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: No se pudo encontrar el archivo de configuración de la base de datos'
    ]);
    exit;
}

require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        throw new Exception("No se pudo establecer la conexión con la base de datos");
    }
    
    $conn->beginTransaction();

    // Obtener la hora actual en la zona horaria de México
    $zonaHorariaMexico = new DateTimeZone('America/Mexico_City');
    $fechaActual = new DateTime('now', $zonaHorariaMexico);
    $tiempoIniciado = $fechaActual->format('Y-m-d H:i:s');

    // Actualizar el registro en la tabla gestion_tiempo
    // Modificado para no actualizar tiempo_acumulado, tiempo_restado y tiempo_transcurrido
    $query = "UPDATE gestion_tiempo SET 
                tiempo_status = :tiempo_status,
                tiempo_encargado_usuario = :tiempo_encargado_usuario,
                tiempo_iniciado = :tiempo_iniciado
              WHERE codigo_time = :codigo_time";
              
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':tiempo_status', $tiempoStatus);
    $stmt->bindParam(':tiempo_encargado_usuario', $tiempoEncargadoUsuario);
    $stmt->bindParam(':tiempo_iniciado', $tiempoIniciado);
    $stmt->bindParam(':codigo_time', $codigoTime);
    $stmt->execute();
    
    $conn->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Tiempo activado correctamente',
        'data' => [
            'status' => $tiempoStatus,
            'tiempo_iniciado' => $tiempoIniciado
        ]
    ]);
    
} catch (PDOException $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    
    error_log("Error al activar tiempo: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    
    error_log("Error general: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error al activar el tiempo: ' . $e->getMessage()
    ]);
}