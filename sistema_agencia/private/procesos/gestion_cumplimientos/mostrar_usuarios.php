<?php
require_once(CONFIG_PATH . 'bd.php');

$response = ['success' => false, 'message' => '', 'data' => []];

try {
    $database = new Database();
    $conn = $database->getConnection();

    if (!$conn) {
        throw new Exception("No se pudo establecer la conexión con la base de datos.");
    }

    $query = "SELECT `id`, `user`, `requirement_name`, `times_as_encargado_count`, `ascensos_as_encargado_count`, `is_completed`, `last_updated` FROM `gestion_requisitos` WHERE 1";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Asignar los resultados a la variable global para que CUMP.php pueda acceder a ellos
    $GLOBALS['cumplimientos'] = $results;

    $response['success'] = true;
    $response['message'] = 'Usuarios y requisitos obtenidos con éxito.';
    $response['data'] = $results;

} catch (PDOException $e) {
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
} catch (Exception $e) {
    $response['message'] = 'Error general: ' . $e->getMessage();
} finally {
    if ($conn) {
        $conn = null;
    }
}

?>