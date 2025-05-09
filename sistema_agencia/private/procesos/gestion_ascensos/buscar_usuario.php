<?php

// Iniciar sesión si no está iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Verificar si se proporcionó un código
if (!isset($_POST['codigo']) || empty($_POST['codigo'])) {
    echo json_encode(['success' => false, 'message' => 'Código no proporcionado']);
    exit;
}

// Obtener el código
$codigo = trim($_POST['codigo']);

// Validar que el código tenga 5 caracteres
if (strlen($codigo) !== 5) {
    echo json_encode(['success' => false, 'message' => 'El código debe tener exactamente 5 caracteres']);
    exit;
}

// Verificar si CONFIG_PATH está definido
if (!defined('CONFIG_PATH')) {
    // Si no está definido, intentar definirlo basado en la estructura del proyecto
    define('CONFIG_PATH', $_SERVER['DOCUMENT_ROOT'] . '/private/conexion/');
}

// Verificar si el archivo bd.php existe
if (!file_exists(CONFIG_PATH . 'bd.php')) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: No se pudo encontrar el archivo de configuración de la base de datos'
    ]);
    exit;
}

// Incluir la conexión a la base de datos
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        throw new Exception("No se pudo establecer la conexión con la base de datos");
    }

    // Consulta para obtener los datos del usuario y sus ascensos
    $query = "SELECT a.ascenso_id, a.codigo_time, a.rango_actual, a.mision_actual, 
                     a.firma_usuario, a.firma_encargado, a.estado_ascenso, 
                     a.fecha_ultimo_ascenso, a.fecha_disponible_ascenso, 
                     a.usuario_encargado, a.es_recluta, r.usuario_registro
              FROM ascensos a
              JOIN registro_usuario r ON a.codigo_time = r.codigo_time
              WHERE a.codigo_time = :codigo";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->execute();

    // Verificar si se encontró el usuario
    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Devolver los datos del usuario
        echo json_encode([
            'success' => true,
            'data' => $row
        ]);
    } else {
        // Verificar si el usuario existe pero no tiene registro en ascensos
        $query2 = "SELECT codigo_time, usuario_registro FROM registro_usuario WHERE codigo_time = :codigo";
        $stmt2 = $conn->prepare($query2);
        $stmt2->bindParam(':codigo', $codigo);
        $stmt2->execute();
        
        if ($user = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            echo json_encode([
                'success' => false,
                'message' => 'El usuario existe pero no tiene información de ascensos'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se encontró ningún usuario con el código proporcionado'
            ]);
        }
    }
} catch (PDOException $e) {
    error_log("Error al buscar usuario: " . $e->getMessage());
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