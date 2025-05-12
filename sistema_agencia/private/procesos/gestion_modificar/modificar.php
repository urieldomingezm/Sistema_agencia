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
    'codigoTimeHiddenEdit', 
    'nuevoRangoEdit', 'nuevaMisionEdit', 
    'nuevaFirmaEdit', 'nuevoEstadoEdit',
    'firmaEncargadoEdit'
];

foreach ($camposRequeridos as $campo) {
    if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
        echo json_encode(['success' => false, 'message' => "El campo $campo es requerido"]);
        exit;
    }
}

$codigoTime = trim($_POST['codigoTimeHiddenEdit']);
$nuevoRango = trim($_POST['nuevoRangoEdit']);
$nuevaMision = trim($_POST['nuevaMisionEdit']);
$nuevaFirma = trim($_POST['nuevaFirmaEdit']);
$nuevoEstado = trim($_POST['nuevoEstadoEdit']);
$firmaEncargado = trim($_POST['firmaEncargadoEdit']);
$usuarioEncargado = $_SESSION['username'];

if (strlen($nuevaFirma) !== 3) {
    echo json_encode(['success' => false, 'message' => 'La firma del usuario debe tener 3 dígitos']);
    exit;
}

if (strlen($firmaEncargado) !== 3) {
    echo json_encode(['success' => false, 'message' => 'La firma del encargado debe tener 3 dígitos']);
    exit;
}

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

    // Actualizar el registro en la tabla ascensos sin modificar el nombre de usuario
    $query = "UPDATE ascensos SET 
                rango_actual = :nuevo_rango,
                mision_actual = :nueva_mision,
                firma_usuario = :nueva_firma, 
                firma_encargado = :firma_encargado,
                estado_ascenso = :nuevo_estado,
                usuario_encargado = :usuario_encargado,
                fecha_ultimo_ascenso = NOW()
              WHERE codigo_time = :codigo_time";
              
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':nuevo_rango', $nuevoRango);
    $stmt->bindParam(':nueva_mision', $nuevaMision);
    $stmt->bindParam(':nueva_firma', $nuevaFirma);
    $stmt->bindParam(':firma_encargado', $firmaEncargado);
    $stmt->bindParam(':nuevo_estado', $nuevoEstado);
    $stmt->bindParam(':usuario_encargado', $usuarioEncargado);
    $stmt->bindParam(':codigo_time', $codigoTime);
    $stmt->execute();
    
    $conn->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Usuario modificado correctamente',
        'data' => [
            'rango' => $nuevoRango,
            'mision' => $nuevaMision,
            'estado' => $nuevoEstado
        ]
    ]);
    
} catch (PDOException $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    
    error_log("Error al modificar usuario: " . $e->getMessage());
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
        'message' => 'Error al modificar el usuario: ' . $e->getMessage()
    ]);
}
?>