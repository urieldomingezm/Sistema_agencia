<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

class VentaRegistration
{
    private $conn;
    private $table = 'gestion_ventas';
    private $membresiaCostos = [
        'Membresía Gold' => 15,
        'Membresía Bronce' => 5,
        'Membresía regla libre' => 10,
        'Membresía save' => 8,
        'Membresía silver' => 12,
        'Membresía VIP' => 30
    ];

    public function __construct()
    {
        try {
            $database = new Database();
            $this->conn = $database->getConnection();
            if (!$this->conn) {
                throw new Exception("Error de conexión a la base de datos");
            }
        } catch (Exception $e) {
            error_log("Error en constructor VentaRegistration: " . $e->getMessage());
            throw $e;
        }
    }

    public function register($ventaTitulo, $fechaCompra, $fechaCaducidad, $nombreComprador, $nombreEncargado)
    {
        try {
            $this->conn->beginTransaction();

            if (!$this->validarCampos($ventaTitulo, $fechaCompra, $fechaCaducidad, $nombreComprador, $nombreEncargado)) {
                return ['success' => false, 'message' => 'Todos los campos son obligatorios'];
            }

            $ventaEstado = 'Activo';
            $ventaCosto = $this->calcularCosto($ventaTitulo);
            
            if (!$this->insertarVenta($ventaTitulo, $fechaCompra, $fechaCaducidad, $ventaEstado, $ventaCosto, $nombreComprador, $nombreEncargado)) {
                throw new Exception("Error al guardar el registro de venta");
            }

            $this->conn->commit();
            return ['success' => true, 'message' => 'Venta registrada exitosamente'];

        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error en registro de venta: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()];
        }
    }
    
    private function validarCampos($ventaTitulo, $fechaCompra, $fechaCaducidad, $nombreComprador, $nombreEncargado)
    {
        return !empty($ventaTitulo) && !empty($fechaCompra) && !empty($fechaCaducidad) && !empty($nombreComprador) && !empty($nombreEncargado);
    }
    
    private function calcularCosto($ventaTitulo)
    {
        return $this->membresiaCostos[$ventaTitulo] ?? 0;
    }
    
    private function insertarVenta($ventaTitulo, $fechaCompra, $fechaCaducidad, $ventaEstado, $ventaCosto, $nombreComprador, $nombreEncargado)
    {
        $query = "INSERT INTO {$this->table} 
                (venta_titulo, venta_compra, venta_caducidad, venta_estado, venta_costo, venta_comprador, venta_encargado, venta_fecha_compra) 
                VALUES 
                (:venta_titulo, :venta_compra, :venta_caducidad, :venta_estado, :venta_costo, :venta_comprador, :venta_encargado, NOW())";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':venta_titulo', $ventaTitulo);
        $stmt->bindParam(':venta_compra', $fechaCompra);
        $stmt->bindParam(':venta_caducidad', $fechaCaducidad);
        $stmt->bindParam(':venta_estado', $ventaEstado);
        $stmt->bindParam(':venta_costo', $ventaCosto);
        $stmt->bindParam(':venta_comprador', $nombreComprador);
        $stmt->bindParam(':venta_encargado', $nombreEncargado);
        
        return $stmt->execute();
    }
}

class VentaController
{
    public function procesarSolicitud()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                header('Content-Type: application/json');
                
                $datos = $this->obtenerDatosFormulario();
                $ventaRegistration = new VentaRegistration();
                $result = $ventaRegistration->register(
                    $datos['ventaTitulo'], 
                    $datos['fechaCompra'], 
                    $datos['fechaCaducidad'], 
                    $datos['nombreComprador'], 
                    $datos['nombreEncargado']
                );
                
                echo json_encode($result);
            } catch (Exception $e) {
                $this->responderError('Error en el registro: ' . $e->getMessage());
            }
        } else {
            $this->responderError('Método no permitido');
        }
    }
    
    private function obtenerDatosFormulario()
    {
        return [
            'ventaTitulo' => isset($_POST['ventaTitulo']) ? trim($_POST['ventaTitulo']) : '',
            'fechaCompra' => isset($_POST['fechaCompra']) ? trim($_POST['fechaCompra']) : '',
            'fechaCaducidad' => isset($_POST['fechaCaducidad']) ? trim($_POST['fechaCaducidad']) : '',
            'nombreComprador' => isset($_POST['nombreComprador']) ? trim($_POST['nombreComprador']) : '',
            'nombreEncargado' => isset($_POST['nombreEncargado']) ? trim($_POST['nombreEncargado']) : ''
        ];
    }
    
    private function responderError($mensaje)
    {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => $mensaje
        ]);
    }
}

$controller = new VentaController();
$controller->procesarSolicitud();
?>