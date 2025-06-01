<?php
// Asegurarnos de que no haya output antes de los headers
ob_start();

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/var/log/php/password_errors.log'); // Cambiado a una ruta absoluta

// Función para manejar la respuesta JSON
function sendJsonResponse($success, $message, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode([
        'success' => $success,
        'message' => $message
    ]);
    exit();
}

try {
    require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
    require_once(CONFIG_PATH . 'bd.php');

    if (!isset($_SESSION)) {
        session_start();
    }

    // Log para debugging
    error_log("[" . date('Y-m-d H:i:s') . "] Iniciando proceso de modificación de contraseña");
    error_log("[" . date('Y-m-d H:i:s') . "] POST data: " . print_r($_POST, true));
    error_log("[" . date('Y-m-d H:i:s') . "] Session data: " . print_r($_SESSION, true));

    header('Content-Type: application/json; charset=utf-8');

    // Verificar sesión
    if (!isset($_SESSION['username'])) {
        sendJsonResponse(false, 'No hay sesión activa', 401);
    }

    // Verificar método
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendJsonResponse(false, 'Método no permitido', 405);
    }

    // Verificar datos POST
    if (!isset($_POST['usuario_id']) || !isset($_POST['nueva_password'])) {
        sendJsonResponse(false, 'Datos incompletos', 400);
    }

    // Sanitizar y validar datos
    $usuarioId = filter_var($_POST['usuario_id'], FILTER_SANITIZE_NUMBER_INT);
    $nuevaPassword = $_POST['nueva_password'];

    if (empty($usuarioId) || empty($nuevaPassword)) {
        sendJsonResponse(false, 'Datos inválidos', 400);
    }

    // Verificar conexión BD
    if (!isset($conn) || !($conn instanceof PDO)) {
        error_log("[" . date('Y-m-d H:i:s') . "] Error de conexión: " . print_r($conn, true));
        sendJsonResponse(false, 'Error de conexión a la base de datos', 500);
    }

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Iniciar transacción
    $conn->beginTransaction();

    try {
        // Verificar usuario
        $checkStmt = $conn->prepare("SELECT id FROM registro_usuario WHERE id = ?");
        $checkStmt->execute([$usuarioId]);
        
        if (!$checkStmt->fetch()) {
            $conn->rollBack();
            sendJsonResponse(false, 'Usuario no encontrado', 404);
        }

        // Actualizar contraseña
        $hashedPassword = password_hash($nuevaPassword, PASSWORD_DEFAULT);
        
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
            throw new PDOException('Error al ejecutar la actualización');
        }

        if ($stmt->rowCount() === 0) {
            throw new Exception('No se realizaron cambios');
        }

        $conn->commit();
        error_log("[" . date('Y-m-d H:i:s') . "] Contraseña actualizada exitosamente para usuario ID: $usuarioId");
        sendJsonResponse(true, 'Contraseña actualizada correctamente');

    } catch (PDOException $e) {
        $conn->rollBack();
        error_log("[" . date('Y-m-d H:i:s') . "] Error PDO: " . $e->getMessage());
        sendJsonResponse(false, 'Error en la base de datos: ' . $e->getMessage(), 500);
    }

} catch (Exception $e) {
    error_log("[" . date('Y-m-d H:i:s') . "] Error general: " . $e->getMessage());
    sendJsonResponse(false, $e->getMessage(), 500);
}