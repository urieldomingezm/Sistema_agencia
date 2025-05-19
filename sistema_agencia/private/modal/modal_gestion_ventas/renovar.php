<?php
ob_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

class VentaRenovation
{
    private $conn;
    private $table = 'gestion_ventas';

    public function __construct()
    {
        try {
            $database = new Database();
            $this->conn = $database->getConnection();
            if (!$this->conn) {
                throw new Exception("Error de conexión a la base de datos");
            }
        } catch (Exception $e) {
            error_log("Error en constructor VentaRenovation: " . $e->getMessage());
            throw $e;
        }
    }

    public function renew($ventaId, $fechaRenovacion)
    {
        try {
            $this->conn->beginTransaction();

            $ventaActual = $this->getVentaById($ventaId);

            if (!$ventaActual) {
                $this->conn->rollBack();
                return ['success' => false, 'message' => 'Venta no encontrada.'];
            }

            if ($ventaActual['venta_titulo'] === "Membresía VIP") {
                $this->conn->rollBack();
                return ['success' => false, 'message' => 'La Membresía VIP no es renovable.'];
            }

            $fechaCaducidadActualObj = new DateTime($ventaActual['venta_caducidad']);
            $fechaActualObj = new DateTime();

            if ($fechaActualObj < $fechaCaducidadActualObj) {
                $this->conn->rollBack();
                return ['success' => false, 'message' => 'La membresía aún no ha caducado. Fecha de caducidad actual: ' . $fechaCaducidadActualObj->format('Y-m-d H:i:s')];
            }

            $baseDateForRenewal = new DateTime($fechaActualObj->format('Y-m-d'));
            $nuevaFechaCaducidadObj = clone $baseDateForRenewal;
            $nuevaFechaCaducidadObj->modify('+1 month');

            $diaFechaActual = $fechaActualObj->format('d');
            $ultimoDiaMesSiguiente = (new DateTime($nuevaFechaCaducidadObj->format('Y-m-d')))->modify('last day of this month')->format('d');

            if ($diaFechaActual > $ultimoDiaMesSiguiente) {
                 $nuevaFechaCaducidadObj->setDate($nuevaFechaCaducidadObj->format('Y'), $nuevaFechaCaducidadObj->format('m'), $ultimoDiaMesSiguiente);
            }

            $nuevaFechaCaducidad = $nuevaFechaCaducidadObj->format('Y-m-d H:i:s');

            if (!$this->updateVenta($ventaId, $nuevaFechaCaducidad, 'Activo')) {
                throw new Exception("Error al actualizar el registro de venta.");
            }

            $this->conn->commit();
            return ['success' => true, 'message' => 'Membresía renovada exitosamente. Nueva fecha de caducidad: ' . $nuevaFechaCaducidad];

        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error en renovación de venta (PDO): " . $e->getMessage());
            return ['success' => false, 'message' => 'Error en la renovación: ' . $e->getMessage()];
        } catch (Exception $e) {
             $this->conn->rollBack();
             error_log("Error en renovación de venta (General): " . $e->getMessage());
             return ['success' => false, 'message' => 'Error en la renovación: ' . $e->getMessage()];
        }
    }

    private function getVentaById($ventaId)
    {
        $query = "SELECT venta_titulo, venta_compra, venta_caducidad FROM {$this->table} WHERE venta_id = :ventaId LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ventaId', $ventaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function updateVenta($ventaId, $nuevaFechaCaducidad, $nuevoEstado)
    {
        $query = "UPDATE {$this->table}
                  SET venta_caducidad = :nuevaFechaCaducidad, venta_estado = :nuevoEstado
                  WHERE venta_id = :ventaId";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nuevaFechaCaducidad', $nuevaFechaCaducidad);
        $stmt->bindParam(':nuevoEstado', $nuevoEstado);
        $stmt->bindParam(':ventaId', $ventaId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

class RenovationController
{
    public function procesarSolicitud()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // No necesitamos iniciar sesión aquí si ya se hizo en el punto de entrada principal
                // if (session_status() === PHP_SESSION_NONE) {
                //     session_start();
                // }

                // Verificar si los encabezados ya han sido enviados antes de intentar enviar el encabezado JSON
                if (!headers_sent()) {
                    header('Content-Type: application/json');
                }


                $datos = $this->obtenerDatosFormulario();

                // Validar que se recibió el ID de la venta
                if (!isset($datos['ventaId']) || empty($datos['ventaId'])) {
                     $this->responderError('ID de venta no proporcionado.');
                     return;
                }

                $ventaRenovation = new VentaRenovation();
                $result = $ventaRenovation->renew(
                    $datos['ventaId'],
                    date('Y-m-d H:i:s')
                );

                echo json_encode($result);
            } catch (Exception $e) {
                $this->responderError('Error en la renovación: ' . $e->getMessage());
            }
        }
        // Se elimina el bloque else que respondía "Método no permitido"
        // else {
        //     $this->responderError('Método no permitido');
        // }
    }

    private function obtenerDatosFormulario()
    {
        // Obtener el ID de la venta a renovar del POST
        return [
            'ventaId' => isset($_POST['ventaId']) ? (int)$_POST['ventaId'] : null,
            // Puedes añadir otros campos si son necesarios para la renovación
        ];
    }

    private function responderError($mensaje)
    {
        // Verificar si los encabezados ya han sido enviados antes de intentar enviar el encabezado JSON
        if (!headers_sent()) {
            header('Content-Type: application/json');
        }
        echo json_encode([
            'success' => false,
            'message' => $mensaje
        ]);
    }
}

// Descomentar la ejecución del controlador para habilitar la funcionalidad de renovación
$controller = new RenovationController();
$controller->procesarSolicitud();
?>