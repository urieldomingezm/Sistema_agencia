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

    public function register($ventaTitulo, $fechaCompra, $nombreComprador, $nombreEncargado)
    {
        try {
            $this->conn->beginTransaction();

            // Validar campos básicos
            if (!$this->validarCampos($ventaTitulo, $fechaCompra, $nombreComprador, $nombreEncargado)) {
                return ['success' => false, 'message' => 'Todos los campos son obligatorios'];
            }

            // Obtener ID del comprador por nombre de usuario
            $compradorId = $this->getUserIdByUsername($nombreComprador);
            $compradorExterno = null; // Inicializar comprador_externo a null

            // Si el comprador no es encontrado
            if (!$compradorId) {
                // Permitir comprador no registrado SOLO para Membresía VIP
                if ($ventaTitulo === "Membresía VIP") {
                    $compradorId = null; // Establecer ID a NULL para insertar en la base de datos
                    $compradorExterno = $nombreComprador; // Guardar el nombre en comprador_externo
                } else {
                    // Para otras membresías, el comprador DEBE ser un usuario registrado
                    $this->conn->rollBack();
                    return ['success' => false, 'message' => 'Usuario comprador no encontrado en el sistema. Para esta membresía, el comprador debe ser un usuario registrado.'];
                }
            }

            // Obtener el nombre de usuario del encargado directamente de la sesión
            $encargadoUsername = $_SESSION['username'] ?? null;
            if (!$encargadoUsername) {
                 $this->conn->rollBack();
                 return ['success' => false, 'message' => 'Nombre de usuario encargado no disponible en la sesión'];
            }


            // Calcular fecha de caducidad (ejemplo: 30 días después de la compra)
            // Puedes ajustar esta lógica según la duración de cada membresía
            $fechaCompraObj = new DateTime($fechaCompra);
            $fechaCaducidadObj = new DateTime($fechaCompra); // Clonar para no modificar la fecha de compra

            if ($ventaTitulo === "Membresía VIP") {
                $fechaCaducidadObj = new DateTime('2030-12-31'); // Fecha fija para VIP
            } else {
                $fechaCaducidadObj->modify('+1 month'); // Añadir un mes para otras membresías

                // Ajustar al último día del mes si el día original es mayor que los días del mes siguiente
                $ultimoDiaMesSiguiente = (new DateTime($fechaCaducidadObj->format('Y-m-d')))->modify('last day of this month')->format('d');
                if ($fechaCompraObj->format('d') > $ultimoDiaMesSiguiente) {
                     $fechaCaducidadObj->setDate($fechaCaducidadObj->format('Y'), $fechaCaducidadObj->format('m'), $ultimoDiaMesSiguiente);
                }
            }

            $fechaCaducidad = $fechaCaducidadObj->format('Y-m-d H:i:s'); // Formato para la base de datos

            $ventaEstado = 'Activo';
            $ventaCosto = $this->calcularCosto($ventaTitulo);

            // Pasar el nombre de usuario del encargado en lugar del ID
            // Ahora también pasamos compradorExterno
            if (!$this->insertarVenta($ventaTitulo, $fechaCompra, $fechaCaducidad, $ventaEstado, $ventaCosto, $compradorId, $compradorExterno, $encargadoUsername)) {
                throw new Exception("Error al guardar el registro de venta");
            }

            $this->conn->commit();
            return ['success' => true, 'message' => 'Venta registrada exitosamente'];

        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error en registro de venta (PDO): " . $e->getMessage());
            return ['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()];
        } catch (Exception $e) {
             $this->conn->rollBack();
             error_log("Error en registro de venta (General): " . $e->getMessage());
             return ['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()];
        }
    }

    private function validarCampos($ventaTitulo, $fechaCompra, $nombreComprador, $nombreEncargado)
    {
        // Ahora validamos el nombre del comprador y encargado (username)
        return !empty($ventaTitulo) && !empty($fechaCompra) && !empty($nombreComprador) && !empty($nombreEncargado);
    }

    private function calcularCosto($ventaTitulo)
    {
        return $this->membresiaCostos[$ventaTitulo] ?? 0;
    }

    // Nuevo método para obtener el ID de usuario por nombre de usuario
    private function getUserIdByUsername($username)
    {
        // Cambiar 'username' a 'nombre_habbo' en la consulta
        $query = "SELECT id FROM registro_usuario WHERE nombre_habbo = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }

    // Método de inserción actualizado para usar IDs, el nombre del encargado y comprador_externo
    private function insertarVenta($ventaTitulo, $fechaCompra, $fechaCaducidad, $ventaEstado, $ventaCosto, $compradorId, $compradorExterno, $encargadoUsername)
    {
        $query = "INSERT INTO {$this->table}
                (venta_titulo, venta_compra, venta_caducidad, venta_estado, venta_costo, venta_comprador, comprador_externo, venta_encargado, venta_fecha_compra)
                VALUES
                (:venta_titulo, :venta_compra, :venta_caducidad, :venta_estado, :venta_costo, :venta_comprador, :comprador_externo, :venta_encargado, :venta_fecha_compra)"; // Cambiado NOW() a :venta_fecha_compra

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':venta_titulo', $ventaTitulo);
        $stmt->bindParam(':venta_compra', $fechaCompra); // Usar $fechaCompra del formulario
        $stmt->bindParam(':venta_caducidad', $fechaCaducidad);
        $stmt->bindParam(':venta_estado', $ventaEstado);
        $stmt->bindParam(':venta_costo', $ventaCosto);
        // Bind compradorId - si es null, PDO lo manejará correctamente si la columna es NULLABLE
        if ($compradorId === null) {
             $stmt->bindValue(':venta_comprador', null, PDO::PARAM_NULL);
        } else {
             $stmt->bindParam(':venta_comprador', $compradorId, PDO::PARAM_INT);
        }
        // Bind compradorExterno - si es null, PDO lo manejará correctamente
        if ($compradorExterno === null) {
             $stmt->bindValue(':comprador_externo', null, PDO::PARAM_NULL);
        } else {
             $stmt->bindParam(':comprador_externo', $compradorExterno);
        }

        $stmt->bindParam(':venta_encargado', $encargadoUsername); // Ahora bindea el string
        $stmt->bindParam(':venta_fecha_compra', $fechaCompra); // Bindear $fechaCompra para la columna venta_fecha_compra

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
                // Pasar nombreComprador y nombreEncargado (username)
                $result = $ventaRegistration->register(
                    $datos['ventaTitulo'],
                    $datos['fechaCompra'],
                    $datos['nombreComprador'], // Pasar nombre
                    $datos['nombreEncargado']  // Pasar nombre (username)
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
        // Obtener nombreComprador del POST y nombreEncargado (username) de la sesión
        return [
            'ventaTitulo' => isset($_POST['ventaTitulo']) ? trim($_POST['ventaTitulo']) : '',
            'fechaCompra' => isset($_POST['fechaCompra']) ? trim($_POST['fechaCompra']) : '',
            // fechaCaducidad ya no se obtiene del formulario, se calcula en VentaRegistration
            'nombreComprador' => isset($_POST['nombreComprador']) ? trim($_POST['nombreComprador']) : '',
            'nombreEncargado' => $_SESSION['username'] ?? '' // Obtener username del encargado de la sesión
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