<?php
require_once(CONFIG_PATH . 'bd.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['codigo'])) {
    echo json_encode(['success' => false, 'message' => 'Petición inválida']);
    exit;
}

$codigo = trim($_POST['codigo']);

try {
    $database = new Database();
    $conn = $database->getConnection();

    $query = "SELECT * FROM gestion_tiempo WHERE codigo_time = :codigo LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        // Puedes ajustar aquí si necesitas transformar algún campo
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontró información de tiempo para este código.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos.']);
}
?>