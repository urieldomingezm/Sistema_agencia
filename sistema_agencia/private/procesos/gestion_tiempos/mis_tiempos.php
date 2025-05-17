<?php
require_once(CONFIG_PATH . 'bd.php');

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'No has iniciado sesión']);
    exit;
}

$username = $_SESSION['username'];

try {
    // Crear instancia de la clase Database
    $database = new Database();
    $conn = $database->getConnection();
    
    // Primero obtenemos el código_time del usuario actual
    $stmt = $conn->prepare("SELECT codigo_time FROM registro_usuario WHERE usuario_registro = :username OR nombre_habbo = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$userData) {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
        exit;
    }
    
    $codigoTime = $userData['codigo_time'];
    
    // Consulta para obtener los tiempos donde el usuario es el encargado
    $stmt = $conn->prepare("
        SELECT ht.id, ht.codigo_time, ht.tiempo_acumulado, ht.tiempo_transcurrido, 
               ht.tiempo_encargado_usuario, ht.tiempo_fecha_registro,
               ru.usuario_registro, ru.nombre_habbo
        FROM historial_tiempos ht
        LEFT JOIN registro_usuario ru ON ht.codigo_time = ru.codigo_time
        WHERE ht.tiempo_encargado_usuario = :username
        ORDER BY ht.tiempo_fecha_registro DESC
    ");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    $tiemposEncargado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Consulta para obtener los tiempos del usuario
    $stmt = $conn->prepare("
        SELECT ht.id, ht.codigo_time, ht.tiempo_acumulado, ht.tiempo_transcurrido, 
               ht.tiempo_encargado_usuario, ht.tiempo_fecha_registro,
               ru.usuario_registro, ru.nombre_habbo
        FROM historial_tiempos ht
        LEFT JOIN registro_usuario ru ON ht.codigo_time = ru.codigo_time
        WHERE ht.codigo_time = :codigoTime
        ORDER BY ht.tiempo_fecha_registro DESC
    ");
    $stmt->bindParam(':codigoTime', $codigoTime);
    $stmt->execute();
    
    $tiemposUsuario = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true, 
        'tiemposEncargado' => $tiemposEncargado,
        'tiemposUsuario' => $tiemposUsuario
    ]);
    
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
}
?>