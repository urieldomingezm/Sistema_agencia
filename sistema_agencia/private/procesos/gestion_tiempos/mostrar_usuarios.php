<?php
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();

    // Obtener el nombre de usuario de la sesión actual
    $usuario_actual = isset($_SESSION['username']) ? $_SESSION['username'] : '';

    // Consulta para obtener los datos de tiempos donde el usuario actual es el encargado
    $query = "SELECT gt.tiempo_id, gt.codigo_time, gt.tiempo_status, gt.tiempo_restado, 
                     gt.tiempo_acumulado, gt.tiempo_transcurrido, gt.tiempo_iniciado, gt.tiempo_encargado_usuario, 
                     gt.tiempo_fecha_registro, ru.usuario_registro AS habbo_name
              FROM gestion_tiempo gt
              JOIN registro_usuario ru ON gt.codigo_time = ru.codigo_time
              WHERE gt.tiempo_encargado_usuario = :usuario_actual OR :usuario_actual = ''";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':usuario_actual', $usuario_actual);
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
