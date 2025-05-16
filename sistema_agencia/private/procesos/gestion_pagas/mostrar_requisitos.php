<?php

require_once(CONFIG_PATH . 'bd.php');
$db = new Database();
$conn = $db->getConnection();

$query = "SELECT user_codigo_time, is_completed, last_updated, requirement_name FROM gestion_requisitos WHERE is_completed = FALSE ORDER BY last_updated DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$requisitos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>