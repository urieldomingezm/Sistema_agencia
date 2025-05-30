<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

// Cambiamos la verificación de sesión
if (!isset($_SESSION)) {
    session_start();
}

class ModificarPassword {
    private $conn;
    private $table = 'registro_usuario';

    public function __construct() {
        try {
            $database = new Database();
            $this->conn = $database->getConnection();
            if (!$this->conn) {
                throw new Exception("Error de conexión a la base de datos");
            }
        } catch (Exception $e) {
            error_log("Error en constructor ModificarPassword: " . $e->getMessage());
            throw $e;
        }
    }

    public function actualizarPassword($usuarioId, $nuevaPassword, $usuarioModificador) {
        try {
            if (empty($usuarioId) || empty($nuevaPassword)) {
                error_log("Error: ID de usuario o contraseña vacíos");
                return false;
            }

            $hashedPassword = password_hash($nuevaPassword, PASSWORD_DEFAULT);
            
            $checkQuery = "SELECT COUNT(*) FROM {$this->table} WHERE id = :id";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindParam(':id', $usuarioId);
            $checkStmt->execute();
            
            if ($checkStmt->fetchColumn() == 0) {
                error_log("Error: Usuario con ID $usuarioId no encontrado");
                return false;
            }

            // Establecer variables para el trigger usando el username de la sesión
            $this->conn->exec("SET @usuario_modificador = '$usuarioModificador'");
            $this->conn->exec("SET @ip_modificacion = '" . $_SERVER['REMOTE_ADDR'] . "'");

            $query = "UPDATE {$this->table} SET 
                password_registro = :password,
                usuario_registro = :usuario_mod 
            WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':id', $usuarioId);
            $stmt->bindParam(':usuario_mod', $usuarioModificador);

            if ($stmt->execute()) {
                error_log("Contraseña actualizada correctamente para el usuario ID: $usuarioId");
                return true;
            } else {
                error_log("Error al ejecutar la consulta de actualización");
                return false;
            }
        } catch (Exception $e) {
            error_log("Error al actualizar contraseña: " . $e->getMessage());
            return false;
        }
    }
}

// Modificamos la verificación de sesión en el POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['username'])) {
        http_response_code(401);
        echo json_encode(['success' => false, 'error' => 'No hay sesión activa']);
        exit;
    }

    if (isset($_POST['usuario_id']) && isset($_POST['nueva_password'])) {
        try {
            $usuarioModificador = $_SESSION['username']; // Cambiamos a username
            $modificarPassword = new ModificarPassword();
            $resultado = $modificarPassword->actualizarPassword(
                $_POST['usuario_id'], 
                $_POST['nueva_password'],
                $usuarioModificador
            );
            
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Contraseña actualizada correctamente']);
            } else {
                http_response_code(500);
                echo json_encode(['success' => false, 'error' => 'Error al actualizar la contraseña']);
            }
        } catch (Exception $e) {
            error_log("Excepción al procesar cambio de contraseña: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
?>