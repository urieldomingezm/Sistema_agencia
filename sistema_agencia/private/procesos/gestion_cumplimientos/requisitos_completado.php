<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!defined('CONFIG_PATH')) {
    define('CONFIG_PATH', __DIR__ . '/../../conexion/');
}

require_once(CONFIG_PATH . 'bd.php');
require_once(__DIR__ . '/data_creditos_usuarios.php');

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['status'])) {
        $id = $_POST['id'];
        $status = $_POST['status'];

        $database = new Database();
        $conn = $database->getConnection();

        $is_completed = 0;
        $requirement_name = '';
        $paga_recibio = 0;

        switch ($status) {
            case 'complete_all':
                $is_completed = 1;
                $requirement_name = 'Completó todos sus requisitos';
                break;
            case 'complete_bonus':
                $is_completed = 1;
                $requirement_name = 'Cumplió pura nomina';
                break;
            case 'incomplete':
                $is_completed = 0;
                $requirement_name = 'No completo';
                break;
            default:
                $response['message'] = 'Estado no válido.';
                echo json_encode($response);
                exit;
        }

        try {
            $conn->beginTransaction();

            $queryUser = "SELECT user FROM gestion_requisitos WHERE id = :id";
            $stmtUser = $conn->prepare($queryUser);
            $stmtUser->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtUser->execute();
            $requisito = $stmtUser->fetch(PDO::FETCH_ASSOC);

            if (!$requisito) {
                $response['message'] = 'Requisito no encontrado.';
                $conn->rollBack();
                echo json_encode($response);
                exit;
            }
            $username = $requisito['user'];

            $queryUpdate = "UPDATE gestion_requisitos
                            SET is_completed = :is_completed, requirement_name = :requirement_name, last_updated = NOW()
                            WHERE id = :id";
            $stmtUpdate = $conn->prepare($queryUpdate);
            $stmtUpdate->bindParam(':is_completed', $is_completed, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':requirement_name', $requirement_name, PDO::PARAM_STR);
            $stmtUpdate->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmtUpdate->execute()) {
                if ($is_completed == 1) {
                    // Obtener rango actual usando codigo_time
                    $queryRango = "SELECT a.rango_actual 
                                  FROM ascensos a 
                                  INNER JOIN registro_usuario ru ON a.codigo_time = ru.codigo_time 
                                  WHERE ru.usuario_registro = :user 
                                  ORDER BY a.fecha_ultimo_ascenso DESC LIMIT 1";
                    $stmtRango = $conn->prepare($queryRango);
                    $stmtRango->bindParam(':user', $username, PDO::PARAM_STR);
                    $stmtRango->execute();
                    $rangoData = $stmtRango->fetch(PDO::FETCH_ASSOC);
                    
                    $rango_actual = $rangoData ? $rangoData['rango_actual'] : 'Desconocido';
                    
                    // Buscar el rango en el array de rangos
                    $rangoInfo = array_filter($rangos, function($r) use ($rango_actual) {
                        return strtolower($r['rango']) === strtolower($rango_actual);
                    });
                    
                    $rangoInfo = reset($rangoInfo); // Obtener el primer elemento
                    
                    // Determinar el pago según el tipo de cumplimiento
                    if ($status === 'complete_all' && $rangoInfo) {
                        $paga_recibio = (int)str_replace('c', '', $rangoInfo['total']);
                        $motivo = 'Cumplimiento total';
                        $descripcion = "Recibió {$rangoInfo['total']} por cumplimiento total de requisitos";
                    } elseif ($status === 'complete_bonus' && $rangoInfo) {
                        $paga_recibio = (int)str_replace('c', '', $rangoInfo['nomina']);
                        $motivo = 'Cumplimiento nómina';
                        $descripcion = "Recibió {$rangoInfo['nomina']} por cumplimiento de nómina";
                    } else {
                        $paga_recibio = 0;
                        $motivo = 'Sin pago';
                        $descripcion = "No aplica pago";
                    }

                    $queryInsertPaga = "INSERT INTO gestion_pagas (
                        pagas_usuario, 
                        pagas_rango, 
                        pagas_recibio, 
                        pagas_motivo, 
                        pagas_completo, 
                        pagas_descripcion, 
                        pagas_fecha_registro
                    ) VALUES (
                        :usuario, 
                        :rango, 
                        :recibio, 
                        :motivo, 
                        :completo, 
                        :descripcion, 
                        NOW()
                    )";
                    
                    $stmtInsertPaga = $conn->prepare($queryInsertPaga);
                    $completo_paga = 1;

                    $stmtInsertPaga->bindParam(':usuario', $username, PDO::PARAM_STR);
                    $stmtInsertPaga->bindParam(':rango', $rango_actual, PDO::PARAM_STR);
                    $stmtInsertPaga->bindParam(':recibio', $paga_recibio, PDO::PARAM_INT);
                    $stmtInsertPaga->bindParam(':motivo', $motivo, PDO::PARAM_STR);
                    $stmtInsertPaga->bindParam(':completo', $completo_paga, PDO::PARAM_INT);
                    $stmtInsertPaga->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);

                    if ($stmtInsertPaga->execute()) {
                        $conn->commit();
                        $response['success'] = true;
                        $response['message'] = 'Estado del requisito actualizado y pago registrado correctamente.';
                    } else {
                        $conn->rollBack();
                        $response['message'] = 'Estado del requisito actualizado, pero error al registrar el pago.';
                    }
                } else {
                    $conn->commit();
                    $response['success'] = true;
                    $response['message'] = 'Estado del requisito actualizado correctamente.';
                }
            } else {
                $conn->rollBack();
                $response['message'] = 'Error al actualizar el estado del requisito.';
            }
        } catch (PDOException $e) {
            $conn->rollBack();
            $response['message'] = 'Error de base de datos: ' . $e->getMessage();
        } catch (Exception $e) {
            $conn->rollBack();
            $response['message'] = 'Error en el servidor: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'Parámetros incompletos.';
    }
} else {
    $response['message'] = 'Método de solicitud no permitido.';
}

echo json_encode($response);
