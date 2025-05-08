<?php
require_once(CONFIG_PATH . 'bd.php');

try {
    $database = new Database();
    $conn = $database->getConnection();

    // Si es una petición AJAX para actualizar el estado y la fecha disponible
    if (
        $_SERVER['REQUEST_METHOD'] === 'POST' &&
        isset($_POST['codigo_time']) &&
        isset($_POST['nuevo_estado']) &&
        isset($_POST['nueva_fecha_disponible'])
    ) {
        $codigo_time = $_POST['codigo_time'];
        $nuevo_estado = $_POST['nuevo_estado'];
        $nueva_fecha_disponible = $_POST['nueva_fecha_disponible'];

        $query = "UPDATE ascensos SET estado_ascenso = :nuevo_estado, fecha_disponible_ascenso = :nueva_fecha_disponible WHERE codigo_time = :codigo_time";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nuevo_estado', $nuevo_estado);
        $stmt->bindParam(':nueva_fecha_disponible', $nueva_fecha_disponible);
        $stmt->bindParam(':codigo_time', $codigo_time);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Estado y fecha actualizados']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
        }
        exit;
    }

    // Consulta normal para mostrar los ascensos
    $query = "SELECT ascenso_id, codigo_time, rango_actual, mision_actual, 
                     firma_usuario, firma_encargado, estado_ascenso, 
                     fecha_ultimo_ascenso, fecha_disponible_ascenso, 
                     usuario_encargado, es_recluta 
              FROM ascensos";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    $ascensos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $GLOBALS['ascensos'] = $ascensos;

} catch(PDOException $e) {
    error_log("Error al obtener datos de ascensos: " . $e->getMessage());
    $GLOBALS['ascensos'] = [];
}
?>
