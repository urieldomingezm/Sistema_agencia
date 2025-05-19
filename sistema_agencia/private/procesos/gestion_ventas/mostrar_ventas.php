<?php
require_once(CONFIG_PATH . 'bd.php');

$db = new Database();
$conn = $db->getConnection();

// Modificar la consulta para unir con registro_usuario por ID y obtener nombre_habbo y codigo_time
$query = "SELECT gv.*, ru.nombre_habbo AS nombre_habbo_registrado, ru.codigo_time
          FROM gestion_ventas gv
          LEFT JOIN registro_usuario ru ON gv.venta_comprador = ru.id
          ORDER BY gv.venta_fecha_compra DESC";

$stmt = $conn->prepare($query);
$stmt->execute();
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
