<?php
// Incluir archivos necesarios
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

// Verificar si es una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Inicializar la respuesta
    $response = [
        'success' => false,
        'message' => 'Acción no especificada'
    ];

    // Verificar la acción solicitada
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        // Crear instancia de la base de datos
        $database = new Database();
        $conn = $database->getConnection();

        // Procesar según la acción
        switch ($accion) {
            case 'liberar_encargado':
                // Verificar que se proporcionó el código de tiempo
                if (isset($_POST['codigo_time']) && !empty($_POST['codigo_time'])) {
                    $codigo_time = $_POST['codigo_time'];
                    
                    try {
                        // Verificar que el usuario esté en estado de pausa
                        $query_check = "SELECT tiempo_status FROM gestion_tiempo WHERE codigo_time = :codigo_time";
                        $stmt_check = $conn->prepare($query_check);
                        $stmt_check->bindParam(':codigo_time', $codigo_time);
                        $stmt_check->execute();
                        
                        $tiempo_data = $stmt_check->fetch(PDO::FETCH_ASSOC);
                        
                        if ($tiempo_data && strtolower($tiempo_data['tiempo_status']) === 'pausa') {
                            // Actualizar el encargado a NULL
                            $query = "UPDATE gestion_tiempo SET tiempo_encargado_usuario = NULL WHERE codigo_time = :codigo_time";
                            $stmt = $conn->prepare($query);
                            $stmt->bindParam(':codigo_time', $codigo_time);
                            
                            if ($stmt->execute()) {
                                $response['success'] = true;
                                $response['message'] = 'Encargado liberado correctamente';
                            } else {
                                $response['message'] = 'Error al liberar al encargado';
                            }
                        } else {
                            $response['message'] = 'El usuario no está en estado de pausa';
                        }
                    } catch (PDOException $e) {
                        $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
                    }
                } else {
                    $response['message'] = 'Código de tiempo no proporcionado';
                }
                break;
                
            // Aquí puedes agregar más casos para otras acciones
                
            default:
                $response['message'] = 'Acción no reconocida';
                break;
        }
    }
    
    // Devolver la respuesta como JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>