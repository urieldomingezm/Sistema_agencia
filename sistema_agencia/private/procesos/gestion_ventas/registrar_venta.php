<?php
require_once(CONFIG_PATH . 'bd.php');

// Data Transfer Object for sale information
class VentaDTO {
    private $titulo;
    private $descripcion;
    private $compra;
    private $caducidad;
    private $estado;
    private $costo;
    private $comprador;
    private $encargado;

    public function __construct(array $data) {
        $this->titulo = $data['venta_titulo'] ?? null;
        $this->descripcion = $data['venta_descripcion'] ?? null;
        $this->compra = $data['venta_compra'] ?? null;
        $this->caducidad = $data['venta_caducidad'] ?? null;
        $this->estado = $data['venta_estado'] ?? null;
        $this->costo = $data['venta_costo'] ?? null;
        $this->comprador = $data['venta_comprador'] ?? null;
        $this->encargado = $data['venta_encargado'] ?? null;
    }

    public function toArray(): array {
        return [
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'compra' => $this->compra,
            'caducidad' => $this->caducidad,
            'estado' => $this->estado,
            'costo' => $this->costo,
            'comprador' => $this->comprador,
            'encargado' => $this->encargado
        ];
    }
}

// Response handler for UI feedback
class ResponseHandler {
    public static function sendResponse(bool $success): void {
        $title = $success ? '¡Éxito!' : '¡Error!';
        $text = $success ? 'Venta registrada exitosamente' : 'Error al registrar la venta';
        $icon = $success ? 'success' : 'error';
        
        echo "<script>
        Swal.fire({
            title: '$title',
            text: '$text',
            icon: '$icon',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/usuario/index.php?page=gestionar ventas';
            }
        });
        </script>";
    }
}

// Main sale class with repository pattern
class VentaRepository {
    private $conn;

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    public function registrarVenta(VentaDTO $ventaDTO): bool {
        try {
            $sql = "INSERT INTO gestion_ventas 
                    (venta_titulo, venta_descripcion, venta_compra, venta_caducidad, 
                     venta_estado, venta_costo, venta_comprador, venta_encargado, venta_fecha_compra) 
                    VALUES (:titulo, :descripcion, :compra, :caducidad, 
                           :estado, :costo, :comprador, :encargado, NOW())";

            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($ventaDTO->toArray());
        } catch (PDOException $e) {
            error_log("Error al registrar venta: " . $e->getMessage());
            return false;
        }
    }
}

// Controller logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardarVenta'])) {
    $database = new Database();
    $db = $database->getConnection();
    
    $ventaDTO = new VentaDTO($_POST);
    $ventaRepository = new VentaRepository($db);
    
    $resultado = $ventaRepository->registrarVenta($ventaDTO);
    ResponseHandler::sendResponse($resultado);
}
?>