<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

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

    public function actualizarPassword($usuarioId, $nuevaPassword) {
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

            $query = "UPDATE {$this->table} SET password_registro = :password WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':id', $usuarioId);

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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario_id']) && isset($_POST['nueva_password'])) {
    try {
        error_log("Solicitud recibida para cambiar contraseña del usuario ID: " . $_POST['usuario_id']);
        
        $modificarPassword = new ModificarPassword();
        $resultado = $modificarPassword->actualizarPassword($_POST['usuario_id'], $_POST['nueva_password']);
        
        if ($resultado) {
            echo "success";
        } else {
            http_response_code(500);
            echo "error";
        }
    } catch (Exception $e) {
        error_log("Excepción al procesar cambio de contraseña: " . $e->getMessage());
        http_response_code(500);
        echo "Error: " . $e->getMessage();
    }
}
?>