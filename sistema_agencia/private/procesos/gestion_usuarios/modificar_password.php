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
            $this->conn->beginTransaction(); // Iniciar transacción

            if (empty($usuarioId) || empty($nuevaPassword)) {
                throw new Exception("ID de usuario o contraseña vacíos");
            }

            $hashedPassword = password_hash($nuevaPassword, PASSWORD_DEFAULT);
            
            // Verificar que el usuario existe
            $checkQuery = "SELECT nombre_habbo FROM {$this->table} WHERE id = :id";
            $checkStmt = $this->conn->prepare($checkQuery);
            $checkStmt->bindParam(':id', $usuarioId);
            $checkStmt->execute();
            
            if (!$checkStmt->fetch()) {
                throw new Exception("Usuario no encontrado");
            }

            // Establecer variables para el trigger
            $this->conn->exec("SET @usuario_modificador = " . $this->conn->quote($usuarioModificador));
            $this->conn->exec("SET @ip_modificacion = " . $this->conn->quote($_SERVER['REMOTE_ADDR']));

            // Actualizar la contraseña
            $query = "UPDATE {$this->table} SET 
                password_registro = :password,
                usuario_modificador = :usuario_mod,
                fecha_modificacion = NOW()
            WHERE id = :id";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':id', $usuarioId);
            $stmt->bindParam(':usuario_mod', $usuarioModificador);

            if (!$stmt->execute()) {
                throw new Exception("Error al ejecutar la actualización");
            }

            $this->conn->commit(); // Confirmar transacción
            return true;

        } catch (Exception $e) {
            $this->conn->rollBack(); // Revertir cambios en caso de error
            error_log("Error al actualizar contraseña: " . $e->getMessage());
            throw $e;
        }
    }
}

// Modificamos la verificación de sesión en el POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    try {
        if (!isset($_SESSION['username'])) {
            throw new Exception('No hay sesión activa');
        }

        if (!isset($_POST['usuario_id']) || !isset($_POST['nueva_password'])) {
            throw new Exception('Datos incompletos');
        }

        $modificarPassword = new ModificarPassword();
        $resultado = $modificarPassword->actualizarPassword(
            $_POST['usuario_id'],
            $_POST['nueva_password'],
            $_SESSION['username']
        );
        
        echo json_encode([
            'success' => true, 
            'message' => 'Contraseña actualizada correctamente'
        ]);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false, 
            'error' => $e->getMessage()
        ]);
    }
}
?>