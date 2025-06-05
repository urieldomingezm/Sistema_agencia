<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

// Asegurar que la respuesta sea JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Depuración
    error_log("POST recibido: " . print_r($_POST, true));
    
    // Obtener y validar datos
    $id = isset($_POST['id']) ? trim($_POST['id']) : null;
    $motivo = isset($_POST['motivo']) ? trim($_POST['motivo']) : null;

    // Validar que los datos no estén vacíos
    if (empty($id) || empty($motivo)) {
        error_log("Datos incompletos - ID: $id, Motivo: $motivo");
        echo json_encode([
            'success' => false, 
            'message' => 'Datos incompletos',
            'debug' => ['id' => $id, 'motivo' => $motivo]
        ]);
        exit;
    }

    try {
        $db = new Database();
        $conn = $db->getConnection();

        // Query para actualizar solo pagas_motivo
        $query = "UPDATE gestion_pagas 
                 SET pagas_motivo = :motivo,
                     pagas_completo = CASE 
                         WHEN :motivo = 'Pago realizado' THEN 1 
                         ELSE 0 
                     END
                 WHERE pagas_id = :id";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':motivo', $motivo, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Verificar si se actualizó algún registro
            if ($stmt->rowCount() > 0) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Pago actualizado correctamente'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'No se encontró el pago con ID: ' . $id
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
            'message' => 'Error en la base de datos'
        ]);
    } catch (Exception $e) {
        error_log("Error general: " . $e->getMessage());
        echo json_encode([
            'success' => false,
            'message' => 'Error general'
        ]);
    }
    exit;
}

echo json_encode([
    'success' => false,
    'message' => 'Método no permitido'
]);