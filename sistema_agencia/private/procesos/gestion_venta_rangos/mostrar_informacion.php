<?php 

require_once(CONFIG_PATH . 'bd.php');
$db = new Database();
$conn = $db->getConnection();

$query = "SELECT rangov_id, rangov_tipo, rangov_rango_anterior, rangov_mision_anterior, rangov_rango_nuevo, rangov_mision_nuevo, rangov_comprador, rangov_vendedor, rangov_fecha, rangov_firma_usuario, rangov_firma_encargado, rangov_costo FROM gestion_rangos WHERE 1 ORDER BY rangov_fecha DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$rangos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>