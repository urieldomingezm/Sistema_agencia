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

if (!isset($_POST['username']) || empty($_POST['username'])) {
    echo json_encode(['success' => false, 'message' => 'Nombre de usuario no proporcionado']);
    exit;
}

$username = trim($_POST['username']);

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
    
    // Consulta para obtener la firma del usuario
    $query = "SELECT firma_usuario FROM gestion_ascensos 
              WHERE usuario_registro = :username 
              ORDER BY fecha_registro DESC 
              LIMIT 1";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo json_encode([
            'success' => true,
            'firma' => $row['firma_usuario']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró la firma del encargado'
        ]);
    }
} catch (PDOException $e) {
    error_log("Error al obtener firma: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    error_log("Error general: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error al conectar con el servidor: ' . $e->getMessage()
    ]);
}
?>