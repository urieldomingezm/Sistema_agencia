<?php
// Asegurarnos de que no haya output antes de los headers
ob_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

// Asegurarnos de que los errores no se muestren en la salida
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/logs/php_errors.log');

header('Content-Type: application/json; charset=utf-8');

try {
    if (!isset($_SESSION)) {
        session_start();
    }

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

    // Hashear la contraseña
    $hashedPassword = password_hash($nuevaPassword, PASSWORD_DEFAULT);

    // Preparar la consulta
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
        throw new Exception('Error al actualizar la contraseña');
    }

    if ($stmt->rowCount() === 0) {
        throw new Exception('No se encontró el usuario o no se realizaron cambios');
    }

    echo json_encode([
        'success' => true,
        'message' => 'Contraseña actualizada correctamente'
    ]);

} catch (Exception $e) {
    error_log("Error en modificar_password.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} finally {
    // Limpiar cualquier salida pendiente
    ob_end_flush();
}
?>