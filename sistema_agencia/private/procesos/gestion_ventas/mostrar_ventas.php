<?php
require_once(CONFIG_PATH . 'bd.php');

$db = new Database();
$conn = $db->getConnection();

$query = "SELECT * FROM gestion_ventas ORDER BY venta_fecha_compra DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
