<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'No hay sesión activa']);
    exit;
}

class ModificarPassword {
    private $conn;
    private $table = 'registro_usuario';

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function actualizarPassword($usuarioId, $nuevaPassword) {
        try {
            // Validar datos
            if (empty($usuarioId) || empty($nuevaPassword)) {
                throw new Exception("Datos incompletos");
            }

            // Hashear la contraseña
            $hashedPassword = password_hash($nuevaPassword, PASSWORD_DEFAULT);

            // Preparar la consulta
            $query = "UPDATE {$this->table} 
                     SET password_registro = :password,
                         usuario_modificador = :usuario_mod,
                         fecha_modificacion = NOW()
                     WHERE id = :id";

            $stmt = $this->conn->prepare($query);
            
            // Vincular parámetros
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':id', $usuarioId);
            $stmt->bindParam(':usuario_mod', $_SESSION['username']);

            // Ejecutar la consulta
            if (!$stmt->execute()) {
                throw new Exception("Error al actualizar la contraseña");
            }

            // Verificar si se actualizó algún registro
            if ($stmt->rowCount() === 0) {
                throw new Exception("No se encontró el usuario");
            }

            return true;

        } catch (PDOException $e) {
            error_log("Error PDO: " . $e->getMessage());
            throw new Exception("Error en la base de datos");
        } catch (Exception $e) {
            throw $e;
        }
    }
}

// Manejo de la petición POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    try {
        // Verificar que los datos necesarios estén presentes
        if (!isset($_POST['usuario_id']) || !isset($_POST['nueva_password'])) {
            throw new Exception("Datos incompletos");
        }

        // Instanciar la clase y actualizar la contraseña
        $modificador = new ModificarPassword();
        $resultado = $modificador->actualizarPassword(
            $_POST['usuario_id'],
            $_POST['nueva_password']
        );

        echo json_encode([
            'success' => true,
            'message' => 'Contraseña actualizada correctamente'
        ]);

    } catch (Exception $e) {
        error_log("Error al modificar contraseña: " . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}
?>