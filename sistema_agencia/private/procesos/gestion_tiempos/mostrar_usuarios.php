<?php
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();

    // Consulta para obtener los datos de tiempos
    $query = "SELECT gt.tiempo_id, gt.codigo_time, gt.tiempo_status, gt.tiempo_restado, 
                     gt.tiempo_acumulado, gt.tiempo_transcurrido, gt.tiempo_encargado_usuario, 
                     gt.tiempo_fecha_registro, ru.usuario_registro AS habbo_name
              FROM gestion_tiempo gt
              JOIN registro_usuario ru ON gt.codigo_time = ru.codigo_time";
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
