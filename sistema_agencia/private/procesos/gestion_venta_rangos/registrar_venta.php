<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/../../../config.php');
require_once(CONFIG_PATH . 'bd.php');

class RangoVenta {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function procesarVenta() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return ['success' => false, 'error' => 'Método de solicitud no permitido.'];
        }

        $required_fields = ['rangov_tipo', 'rangov_costo', 'rangov_vendedor', 'rangov_comprador', 'rangov_firma_vendedor', 'rangov_firma_comprador'];
        $data = [];

        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                return ['success' => false, 'error' => 'Campo requerido faltante: ' . $field];
            }
            $data[$field] = $_POST[$field];
        }

        if (strlen($data['rangov_firma_vendedor']) !== 3 || strlen($data['rangov_firma_comprador']) !== 3) {
            return ['success' => false, 'error' => 'Las firmas deben tener exactamente 3 caracteres.'];
        }

        $rangov_tipo = htmlspecialchars($data['rangov_tipo']);
        $rangov_costo = filter_var($data['rangov_costo'], FILTER_VALIDATE_FLOAT);
        $rangov_vendedor = htmlspecialchars($data['rangov_vendedor']);
        $rangov_comprador = htmlspecialchars($data['rangov_comprador']);
        $rangov_firma_usuario = htmlspecialchars($data['rangov_firma_vendedor']);
        $rangov_firma_encargado = htmlspecialchars($data['rangov_firma_comprador']);

        if ($rangov_costo === false) {
            return ['success' => false, 'error' => 'Costo del rango inválido.'];
        }

        $rangov_rango_anterior = NULL;
        $rangov_mision_anterior = NULL;
        $rangov_rango_nuevo = NULL;
        $rangov_mision_nuevo = NULL;
        $rangov_fecha = date('Y-m-d H:i:s');

        try {
            $sql = "INSERT INTO gestion_rangos (
                        rangov_tipo,
                        rangov_rango_anterior,
                        rangov_mision_anterior,
                        rangov_rango_nuevo,
                        rangov_mision_nuevo,
                        rangov_comprador,
                        rangov_vendedor,
                        rangov_fecha,
                        rangov_firma_usuario,
                        rangov_firma_encargado,
                        rangov_costo
                    ) VALUES (
                        :tipo,
                        :rango_anterior,
                        :mision_anterior,
                        :rango_nuevo,
                        :mision_nuevo,
                        :comprador,
                        :vendedor,
                        :fecha,
                        :firma_usuario,
                        :firma_encargado,
                        :costo
                    )";

            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindParam(':tipo', $rangov_tipo);
            $stmt->bindParam(':rango_anterior', $rangov_rango_anterior);
            $stmt->bindParam(':mision_anterior', $rangov_mision_anterior);
            $stmt->bindParam(':rango_nuevo', $rangov_rango_nuevo);
            $stmt->bindParam(':mision_nuevo', $rangov_mision_nuevo);
            $stmt->bindParam(':comprador', $rangov_comprador);
            $stmt->bindParam(':vendedor', $rangov_vendedor);
            $stmt->bindParam(':fecha', $rangov_fecha);
            $stmt->bindParam(':firma_usuario', $rangov_firma_usuario);
            $stmt->bindParam(':firma_encargado', $rangov_firma_encargado);
            $stmt->bindParam(':costo', $rangov_costo);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => 'Operación registrada exitosamente.'];
            } else {
                return ['success' => false, 'error' => 'Error al ejecutar la consulta.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'error' => 'Error en la base de datos: ' . $e->getMessage()];
        }
    }
}

// Uso de la clase
try {
    $database = new Database();
    $conn = $database->getConnection();
    
    $rangoVenta = new RangoVenta($conn);
    $resultado = $rangoVenta->procesarVenta();
    
    echo json_encode($resultado);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error inicial: ' . $e->getMessage()]);
}
?>