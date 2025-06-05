<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

// Asegurar que la respuesta sea JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Depuración
    error_log("POST recibido: " . print_r($_POST, true));
    
    // Obtener y validar datos
    $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : null;
    $motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : null;

    // Validar que los datos no estén vacíos
    if (empty($usuario) || empty($motivo)) {
        error_log("Datos incompletos - Usuario: $usuario, Motivo: $motivo");
        echo json_encode([
            'success' => false, 
            'message' => 'Datos incompletos',
            'debug' => ['usuario' => $usuario, 'motivo' => $motivo]
        ]);
        exit;
    }

    try {
        $db = new Database();
        $conn = $db->getConnection();

        // Query para actualizar por nombre de usuario
        $query = "UPDATE gestion_pagas 
                 SET pagas_motivo = :motivo,
                     pagas_completo = CASE 
                         WHEN :motivo = 'Pago realizado' THEN 1 
                         ELSE 0 
                     END
                 WHERE pagas_usuario = :usuario";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':motivo', $motivo, PDO::PARAM_STR);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Verificar si se actualizó algún registro
            if ($stmt->rowCount() > 0) {
                echo json_encode([
                    'success' => true,
                    'message' => "Pago actualizado correctamente para $usuario"
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => "No se encontró el usuario: $usuario"
                ]);
            }
        } else {
            error_log("Error al ejecutar la consulta: " . print_r($stmt->errorInfo(), true));
            echo json_encode([
                'success' => false, 
                'message' => 'Error al actualizar el pago'
            ]);
        }

    } catch (PDOException $e) {
        error_log("Error de PDO: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Error en la base de datos: ' . $e->getMessage()
        ]);
    } catch (Exception $e) {
        error_log("Error general: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Error general: ' . $e->getMessage()
        ]);
    }
    exit;
}

echo json_encode([
    'success' => false,
    'message' => 'Método no permitido'
]);