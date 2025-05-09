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
    'codigo_time', 'rango_nuevo', 
    'mision_nueva', 'firma_encargado', 
    'usuario_encargado', 'tiempo_espera'
];

foreach ($camposRequeridos as $campo) {
    if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
        echo json_encode(['success' => false, 'message' => "El campo $campo es requerido"]);
        exit;
    }
}

$codigoTime = trim($_POST['codigo_time']);
$rangoNuevo = trim($_POST['rango_nuevo']);
$misionNueva = trim($_POST['mision_nueva']);
$firmaUsuario = trim($_POST['firma_usuario']);
$firmaEncargado = trim($_POST['firma_encargado']);
$usuarioEncargado = trim($_POST['usuario_encargado']);
$tiempoEspera = intval($_POST['tiempo_espera']);

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

    $deleteQuery = "DELETE FROM ascensos WHERE codigo_time = :codigo_time";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bindParam(':codigo_time', $codigoTime);
    $deleteStmt->execute();

    $fechaActual = new DateTime();
    $fechaDisponible = clone $fechaActual;
    $fechaDisponible->add(new DateInterval("PT{$tiempoEspera}M"));

    $query = "INSERT INTO ascensos (
                codigo_time,
                rango_actual,
                mision_actual,
                firma_usuario, 
                firma_encargado,
                estado_ascenso,
                fecha_ultimo_ascenso,
                fecha_disponible_ascenso,
                usuario_encargado
              ) VALUES (
                :codigo_time,
                :rango_nuevo,
                :mision_nueva,
                :firma_usuario,
                :firma_encargado,
                'ascendido',
                :fecha_actual,
                :fecha_disponible,
                :usuario_encargado
              )";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':codigo_time', $codigoTime);
    $stmt->bindParam(':rango_nuevo', $rangoNuevo);
    $stmt->bindParam(':mision_nueva', $misionNueva);
    $stmt->bindParam(':firma_usuario', $firmaUsuario);
    $stmt->bindParam(':firma_encargado', $firmaEncargado);
    $stmt->bindParam(':fecha_actual', $fechaActual->format('Y-m-d H:i:s'));
    $stmt->bindParam(':fecha_disponible', $fechaDisponible->format('Y-m-d H:i:s'));
    $stmt->bindParam(':usuario_encargado', $usuarioEncargado);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        throw new Exception("No se pudo insertar el registro de ascenso");
    }
    
    $conn->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Ascenso registrado correctamente',
        'data' => [
            'rango_nuevo' => $rangoNuevo,
            'mision_nueva' => $misionNueva,
            'fecha_disponible' => $fechaDisponible->format('Y-m-d H:i:s')
        ]
    ]);
    
} catch (PDOException $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    
    error_log("Error al registrar ascenso: " . $e->getMessage());
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
        'message' => 'Error al registrar el ascenso: ' . $e->getMessage()
    ]);
}
?>