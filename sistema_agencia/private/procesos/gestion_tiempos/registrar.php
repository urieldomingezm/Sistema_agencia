<?php
require_once(CONFIG_PATH . 'bd.php');

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurar cabeceras para respuesta JSON
header('Content-Type: application/json');

// Validar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit;
}

// Obtener datos del formulario
$datos = [
    'codigo_time' => isset($_POST['codigo_time']) ? trim($_POST['codigo_time']) : '',
    'tipo_tiempo' => isset($_POST['tipo_tiempo']) ? trim($_POST['tipo_tiempo']) : '',
    'fecha_hora' => isset($_POST['fecha_hora']) ? trim($_POST['fecha_hora']) : '',
    'firma_encargado' => isset($_POST['firma_encargado']) ? trim($_POST['firma_encargado']) : '',
    'usuario_encargado' => isset($_POST['usuario_encargado']) ? trim($_POST['usuario_encargado']) : '',
    'observaciones' => isset($_POST['observaciones']) ? trim($_POST['observaciones']) : ''
];

// Validaciones básicas - CORREGIDO: Paréntesis faltantes
if (empty($datos['codigo_time'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Código de usuario requerido'
    ]);
    exit;
}

if (empty($datos['tipo_tiempo'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Tipo de tiempo requerido'
    ]);
    exit;
}

if (strlen($datos['firma_encargado']) !== 3) {
    echo json_encode([
        'success' => false,
        'message' => 'La firma debe tener exactamente 3 caracteres'
    ]);
    exit;
}

try {
    // Conectar a la base de datos
    $db = new Database();
    $conn = $db->getConnection();
    
    // Verificar si el usuario existe
    $sqlVerificar = "SELECT usuario_id FROM usuarios WHERE codigo_time = :codigo";
    $stmtVerificar = $conn->prepare($sqlVerificar);
    $stmtVerificar->bindParam(':codigo', $datos['codigo_time']);
    $stmtVerificar->execute();
    
    if ($stmtVerificar->rowCount() === 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Usuario no encontrado'
        ]);
        exit;
    }
    
    // Determinar el estado del tiempo basado en el tipo
    $estadoTiempo = 'activo';
    if ($datos['tipo_tiempo'] === 'Salida') {
        $estadoTiempo = 'inactivo';
    }
    
    // Insertar nuevo registro de tiempo
    $sqlInsert = "INSERT INTO gestion_tiempo (
                    codigo_time,
                    tiempo_status,
                    tiempo_tipo,
                    tiempo_fecha_registro,
                    tiempo_encargado_usuario,
                    tiempo_firma_encargado,
                    tiempo_observaciones
                ) VALUES (
                    :codigo,
                    :estado,
                    :tipo,
                    :fecha,
                    :encargado,
                    :firma,
                    :observaciones
                )";
    
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bindParam(':codigo', $datos['codigo_time']);
    $stmtInsert->bindParam(':estado', $estadoTiempo);
    $stmtInsert->bindParam(':tipo', $datos['tipo_tiempo']);
    $stmtInsert->bindParam(':fecha', $datos['fecha_hora']);
    $stmtInsert->bindParam(':encargado', $datos['usuario_encargado']);
    $stmtInsert->bindParam(':firma', $datos['firma_encargado']);
    $stmtInsert->bindParam(':observaciones', $datos['observaciones']);
    
    if ($stmtInsert->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Tiempo registrado correctamente'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al registrar el tiempo'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ]);
}
?>