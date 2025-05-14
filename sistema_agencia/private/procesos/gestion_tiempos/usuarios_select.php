<?php
require_once(CONFIG_PATH . 'bd.php');

$response = array();

try {
    $database = new Database();
    $conn = $database->getConnection();

    $query = "SELECT ru.id, ru.nombre_habbo, r.rol_nombre 
              FROM registro_usuario ru
              JOIN roles r ON ru.rol_id = r.rol_id
              WHERE r.rol_nombre IN ('director', 'presidente', 'operativo', 'junta directiva', 'administrador', 'manager', 'fundador')
              ORDER BY r.rol_nombre ASC";
              
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $response['success'] = true;
    $response['data'] = $usuarios;
    
} catch (PDOException $e) {
    $response['success'] = false;
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>