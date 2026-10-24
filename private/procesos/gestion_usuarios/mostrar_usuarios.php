<?php
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();

    // Query to get all users data
    $query = "SELECT `id`, `usuario_registro`, `password_registro`, `rol_id`, 
                     `fecha_registro`, `ip_registro`, `nombre_habbo`, `codigo_time`, `ip_bloqueo`
              FROM `registro_usuario`";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Get results as associative array
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Pass data to global scope
    $GLOBALS['usuarios'] = $usuarios;

} catch(PDOException $e) {
    error_log("Error getting users data: " . $e->getMessage());
    $GLOBALS['usuarios'] = [];
}
?>