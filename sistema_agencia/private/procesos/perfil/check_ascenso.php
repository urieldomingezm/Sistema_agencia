<?php
require_once(CONFIG_PATH . 'bd.php');
$database = new Database();
$conn = $database->getConnection();

$query = "SELECT COUNT(*) as disponible 
          FROM ascensos 
          WHERE codigo_time = (SELECT codigo_time FROM registro_usuario WHERE id = :user_id) 
          AND fecha_disponible_ascenso <= NOW()";

$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();

header('Content-Type: application/json');
echo json_encode(['disponible' => $stmt->fetchColumn() > 0]);
?>