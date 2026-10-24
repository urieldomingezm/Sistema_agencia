<?php
session_start();

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Método no permitido';
    echo json_encode($response);
    exit;
}

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    $response['message'] = 'No has iniciado sesión o no se encontró tu nombre de usuario.';
    echo json_encode($response);
    exit;
}

if (!defined('CONFIG_PATH')) {
    define('CONFIG_PATH', __DIR__ . '/../../conexion/');
}

if (!file_exists(CONFIG_PATH . 'bd.php')) {
    $response['success'] = false;
    $response['message'] = 'Error: No se pudo encontrar el archivo de configuración de la base de datos';
    echo json_encode($response);
    exit;
}

require_once(CONFIG_PATH . 'bd.php');

class QuejaRegistration {
    private $conn;
    private $table = 'gestion_quejas';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registerQueja($usuario, $asunto, $descripcion) {
        try {
            if (empty($usuario) || empty($asunto) || empty($descripcion)) {
                return ['success' => false, 'message' => 'Todos los campos son obligatorios'];
            }

            $query = "INSERT INTO {$this->table}
                      (queja_usuario, queja_asunto, queja_descripcion, queja_fecha_registro)
                      VALUES (:usuario, :asunto, :descripcion, NOW())";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':asunto', $asunto);
            $stmt->bindParam(':descripcion', $descripcion);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Queja/Sugerencia registrada exitosamente.'];
            } else {
                error_log("Error al registrar queja para usuario {$usuario}: " . implode(":", $stmt->errorInfo()));
                return ['success' => false, 'message' => 'Error al guardar la queja/sugerencia en la base de datos.'];
            }

        } catch (PDOException $e) {
            error_log("Error en registro de queja (PDO): " . $e->getMessage());
            return ['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()];
        } catch (Exception $e) {
             error_log("Error en registro de queja (General): " . $e->getMessage());
             return ['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()];
        }
    }
}

try {
    $database = new Database();
    $conn = $database->getConnection();

    if (!$conn) {
        throw new Exception("No se pudo establecer la conexión con la base de datos");
    }

    $asunto = $_POST['asunto'] ?? '';
    $mensaje = $_POST['mensaje'] ?? '';
    $usuario = $_SESSION['username'];

    $quejaRegistration = new QuejaRegistration($conn);
    $result = $quejaRegistration->registerQueja($usuario, $asunto, $mensaje);

    echo json_encode($result);

} catch (Exception $e) {
    $response['message'] = 'Error en el servidor: ' . $e->getMessage();
    echo json_encode($response);
} finally {
    $conn = null;
}
?>