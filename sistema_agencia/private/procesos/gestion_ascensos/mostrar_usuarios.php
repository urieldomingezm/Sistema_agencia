<?php
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();

    // Consulta para obtener los datos de los ascensos
    $query = "SELECT ascenso_id, codigo_time, rango_actual, mision_actual, 
                     firma_usuario, firma_encargado, estado_ascenso, 
                     fecha_ultimo_ascenso, fecha_disponible_ascenso, 
                     usuario_encargado, es_recluta 
              FROM ascensos";
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
