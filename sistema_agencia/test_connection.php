<?php
require_once('private/config/bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();
    if($conn) {
        echo "¡Conexión exitosa!";
    }
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>