<?php
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();

    // Consulta para obtener los datos de los ascensos con el nombre de usuario
    $query = "SELECT a.ascenso_id, a.codigo_time, a.rango_actual, a.mision_actual, 
                     a.mision_nueva, a.estado_ascenso, a.fecha_disponible_ascenso, 
                     a.usuario_encargado, r.usuario_registro
              FROM ascensos a
              JOIN registro_usuario r ON a.codigo_time = r.codigo_time";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Obtener los resultados como array asociativo
    $ascensos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pasar los datos a GSAS.php
    $GLOBALS['ascensos'] = $ascensos;

} catch(PDOException $e) {
    error_log("Error al obtener datos de ascensos: " . $e->getMessage());
    $GLOBALS['ascensos'] = [];
}
?>
