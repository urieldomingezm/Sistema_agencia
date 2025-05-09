<?php
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();

    // Consulta normal para mostrar los ascensos
    $query = "SELECT a.ascenso_id, a.codigo_time, r.nombre_habbo, a.rango_actual, a.mision_actual, 
                     a.firma_usuario, a.firma_encargado, a.estado_ascenso, 
                     a.fecha_ultimo_ascenso, a.fecha_disponible_ascenso, 
                     a.usuario_encargado, a.es_recluta 
              FROM ascensos a
              JOIN registro_usuario r ON a.codigo_time = r.codigo_time";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $ascensos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $GLOBALS['ascensos'] = $ascensos;

} catch(PDOException $e) {
    error_log("Error al obtener datos de ascensos: " . $e->getMessage());
    $GLOBALS['ascensos'] = [];
}
?>
