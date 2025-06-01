<?php
// Asegurarnos de que no haya output antes de los headers
ob_start();

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/password_errors.log');

try {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
    require_once(CONFIG_PATH . 'bd.php');

    if (!isset($_SESSION)) {
        session_start();
    }

    // Log para debugging
    error_log("Iniciando proceso de modificación de contraseña");
    error_log("POST data: " . print_r($_POST, true));
    error_log("Session data: " . print_r($_SESSION, true));

    header('Content-Type: application/json; charset=utf-8');

    if (!isset($_SESSION['username'])) {
        throw new Exception('No hay sesión activa');
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    if (!isset($_POST['usuario_id']) || !isset($_POST['nueva_password'])) {
        throw new Exception('Datos incompletos');
    }

    $usuarioId = filter_var($_POST['usuario_id'], FILTER_SANITIZE_NUMBER_INT);
    $nuevaPassword = $_POST['nueva_password'];

    if (empty($usuarioId) || empty($nuevaPassword)) {
        throw new Exception('Datos inválidos');
    }

    // Verificar conexión a BD
    if (!$conn || !($conn instanceof PDO)) {
        throw new Exception('Error de conexión a la base de datos');
    }

    // Verificar que el usuario existe
    $checkStmt = $conn->prepare("SELECT id FROM registro_usuario WHERE id = ?");
    $checkStmt->execute([$usuarioId]);
    if (!$checkStmt->fetch()) {
        throw new Exception('Usuario no encontrado');
    }

    $hashedPassword = password_hash($nuevaPassword, PASSWORD_DEFAULT);

    $conn->beginTransaction();

    try {
        $query = "UPDATE registro_usuario 
                  SET password_registro = :password,
                      usuario_modificador = :usuario_mod,
                      fecha_modificacion = NOW()
                  WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $usuarioId);
        $stmt->bindParam(':usuario_mod', $_SESSION['username']);

        if (!$stmt->execute()) {
            throw new Exception('Error al ejecutar la actualización: ' . implode(', ', $stmt->errorInfo()));
        }

        if ($stmt->rowCount() === 0) {
            throw new Exception('No se realizaron cambios en la base de datos');
        }

        $conn->commit();

        error_log("Contraseña actualizada exitosamente para usuario ID: $usuarioId");

        echo json_encode([
            'success' => true,
            'message' => 'Contraseña actualizada correctamente'
        ]);

    } catch (Exception $e) {
        $conn->rollBack();
        throw $e;
    }

} catch (PDOException $e) {
    error_log("Error PDO: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    error_log("Error general: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} finally {
    if (ob_get_length()) ob_end_clean();
}
?>