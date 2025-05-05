<?php
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();

    // Consulta para obtener los datos de tiempos
    $query = "SELECT tiempo_id, codigo_time, tiempo_status, tiempo_restado, 
                     tiempo_acumulado, tiempo_transcurrido, tiempo_encargado_usuario, 
                     tiempo_fecha_registro 
              FROM gestion_tiempo";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Obtener los resultados como array asociativo
    $tiempos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pasar los datos a GSTM.php
    $GLOBALS['tiempos'] = $tiempos;

} catch(PDOException $e) {
    error_log("Error al obtener datos de tiempos: " . $e->getMessage());
    $GLOBALS['tiempos'] = [];
}
?>
