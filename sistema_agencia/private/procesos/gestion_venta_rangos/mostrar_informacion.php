<?php 

require_once(CONFIG_PATH . 'bd.php');
$db = new Database();
$conn = $db->getConnection();

$query = "SELECT pagas_usuario, pagas_recibio, pagas_motivo, pagas_completo, pagas_rango, pagas_descripcion, pagas_fecha_registro FROM gestion_pagas ORDER BY pagas_fecha_registro DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$pagas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>