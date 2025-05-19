<?php
ob_start();

if (!headers_sent()) {
    header('Content-Type: application/json');
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

$response = array('success' => false, 'message' => 'Error desconocido.');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['ventaId'])) {
        $ventaId = filter_var($_POST['ventaId'], FILTER_SANITIZE_NUMBER_INT);

        if ($ventaId === false || $ventaId <= 0) {
            $response['message'] = 'ID de venta inválido.';
        } else {
            $db = new Database();
            $conn = $db->getConnection();

            $query = "DELETE FROM gestion_ventas WHERE venta_id = :ventaId";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':ventaId', $ventaId, PDO::PARAM_INT);

            try {
                if ($stmt->execute()) {
                    if ($stmt->rowCount() > 0) {
                        $response['success'] = true;
                        $response['message'] = 'Registro de venta eliminado exitosamente.';
                    } else {
                        $response['message'] = 'No se encontró el registro de venta con el ID proporcionado.';
                    }
                } else {
                    $response['message'] = 'Error al ejecutar la consulta de eliminación.';
                    error_log("Error al eliminar venta (execute): " . $stmt->errorInfo()[2]);
                }
            } catch (PDOException $e) {
                $response['message'] = 'Error de base de datos al eliminar el registro.';
                error_log("Error al eliminar venta (PDOException): " . $e->getMessage());
            }
        }
    } else {
        $response['message'] = 'ID de venta no proporcionado.';
    }
    echo json_encode($response);
} else {
    // No imprimir nada si el método no es POST, o podrías imprimir un mensaje simple si lo prefieres
    // echo json_encode(['success' => false, 'message' => 'Método de solicitud no permitido.']);
}
?>