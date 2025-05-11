<?php
require_once(CONFIG_PATH . 'bd.php');

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configurar cabeceras para respuesta JSON
header('Content-Type: application/json');

// Función para formatear el tiempo acumulado en formato legible
function formatearTiempo($segundos) {
    if (!$segundos) return '00:00:00';
    
    $horas = floor($segundos / 3600);
    $minutos = floor(($segundos % 3600) / 60);
    $segundos = $segundos % 60;
    
    return sprintf("%02d:%02d:%02d", $horas, $minutos, $segundos);
}

// Obtener el código del usuario desde la solicitud POST
$codigo = isset($_POST['codigo']) ? trim($_POST['codigo']) : '';

// Validar que el código tenga 5 caracteres
if (strlen($codigo) !== 5) {
    echo json_encode([
        'success' => false,
        'message' => 'El código debe tener exactamente 5 caracteres'
    ]);
    exit;
}

try {
    // Conectar a la base de datos
    $db = new Database();
    $conn = $db->getConnection();
    
    // Consulta SQL para obtener información del usuario y su tiempo
    $sql = "SELECT 
                u.usuario_id,
                u.codigo_time,
                u.usuario_registro,
                u.rango_actual,
                u.mision_actual,
                u.firma_usuario,
                t.tiempo_status AS estado_tiempo,
                t.tiempo_acumulado AS tiempo_actual,
                t.tiempo_fecha_registro
            FROM usuarios u
            LEFT JOIN gestion_tiempo t ON u.codigo_time = t.codigo_time
            WHERE u.codigo_time = :codigo
            ORDER BY t.tiempo_fecha_registro DESC
            LIMIT 1";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Formatear los datos para la respuesta
        $data = [
            'usuario_id' => $row['usuario_id'],
            'codigo_time' => $row['codigo_time'],
            'usuario_registro' => $row['usuario_registro'],
            'rango_actual' => $row['rango_actual'],
            'mision_actual' => $row['mision_actual'],
            'firma_usuario' => $row['firma_usuario'],
            'estado_tiempo' => $row['estado_tiempo'] ?? 'inactivo',
            'tiempo_actual' => formatearTiempo($row['tiempo_acumulado'] ?? 0),
            'tiempo_fecha_registro' => $row['tiempo_fecha_registro']
        ];
        
        echo json_encode([
            'success' => true,
            'data' => $data
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Usuario no encontrado con el código proporcionado'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ]);
}
?>