<?php
session_start();
require_once(__DIR__ . '/rangos_data.php');
header('Content-Type: application/json');

class AscensoHandler {
    private $conn;
    private $misionesPorRango;
    private $tiempoAscensoSegundosPorRango;
    private $firmaEncargado;
    private $usuarioEncargado;
    private $codigoUsuario;
    private $response = ['success' => false, 'message' => ''];

    private function getFirmaEncargado() {
        // Get the encargado's codigo_time from registro_usuario table
        $query = "SELECT codigo_time FROM registro_usuario WHERE usuario_registro = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->usuarioEncargado);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result || empty($result['codigo_time'])) {
            return null;
        }
        
        $codigoTimeEncargado = $result['codigo_time'];
        
        // Get the encargado's signature from ascensos table
        $query = "SELECT firma_usuario FROM ascensos WHERE codigo_time = :codigo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codigo', $codigoTimeEncargado);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['firma_usuario'] ?? null;
    }
    
    // Modify the constructor to get the firma_encargado automatically
    public function __construct($misionesPorRango, $tiempoAscensoSegundosPorRango) {
        if (!defined('CONFIG_PATH')) {
            define('CONFIG_PATH', $_SERVER['DOCUMENT_ROOT'] . '/private/conexion/');
        }
        
        $this->misionesPorRango = $misionesPorRango;
        $this->tiempoAscensoSegundosPorRango = $tiempoAscensoSegundosPorRango;
        $this->usuarioEncargado = $_SESSION['username'] ?? null;
        
        // Initialize connection once
        require_once(CONFIG_PATH . 'bd.php');
        $database = new Database();
        $this->conn = $database->getConnection();
        
        if (!$this->conn) {
            throw new Exception("No se pudo establecer la conexión con la base de datos");
        }
        
        $this->firmaEncargado = $this->getFirmaEncargado();
    }

    public function procesar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->response['message'] = 'Método no permitido';
            $this->output();
        }
        if (!isset($_POST['codigo']) || empty($_POST['codigo'])) {
            $this->response['message'] = 'Código de usuario no proporcionado';
            $this->output();
        }
        $this->codigoUsuario = trim($_POST['codigo']);
        if (!preg_match('/^[a-zA-Z0-9]{1,5}$/', $this->codigoUsuario)) {
            $this->response['message'] = 'Formato de código de usuario inválido.';
            $this->output();
        }
        if (!$this->usuarioEncargado) {
            $this->response['message'] = 'No se pudo obtener la información del encargado desde la sesión. Por favor, inicia sesión nuevamente.';
            $this->output();
        }
        if (!defined('CONFIG_PATH')) {
            define('CONFIG_PATH', $_SERVER['DOCUMENT_ROOT'] . '/private/conexion/');
        }
        if (!file_exists(CONFIG_PATH . 'bd.php')) {
            $this->response['message'] = 'Error: No se pudo encontrar el archivo de configuración de la base de datos';
            $this->output();
        }
        require_once(CONFIG_PATH . 'bd.php');
        try {
            $database = new Database();
            $this->conn = $database->getConnection();
            if (!$this->conn) {
                throw new Exception("No se pudo establecer la conexión con la base de datos");
            }
            $usuario = $this->getUsuario();
            if (!$usuario) {
                $this->response['message'] = 'Usuario no encontrado en la tabla de ascensos.';
                $this->output();
            }
            $this->procesarAscenso($usuario);
        } catch (PDOException $e) {
            $this->response['message'] = 'Error de base de datos: ' . $e->getMessage();
        } catch (Exception $e) {
            $this->response['message'] = 'Error al conectar con el servidor: ' . $e->getMessage();
        } finally {
            $this->conn = null;
        }
        $this->output();
    }

    private function getUsuario() {
        $stmt = $this->conn->prepare("SELECT rango_actual, mision_actual, firma_usuario, fecha_ultimo_ascenso, fecha_disponible_ascenso FROM ascensos WHERE codigo_time = :codigo");
        $stmt->bindParam(':codigo', $this->codigoUsuario);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function procesarAscenso($usuario) {
        $rangoActual = strtolower($usuario['rango_actual']);
        $misionActual = $usuario['mision_actual'];
        $firmaUsuario = $usuario['firma_usuario'];
        $fechaDisponibleAscensoDB = $usuario['fecha_disponible_ascenso'];
        $now = new DateTime('now', new DateTimeZone('America/Mexico_City'));
        if (!empty($fechaDisponibleAscensoDB) && $fechaDisponibleAscensoDB !== '0000-00-00 00:00:00') {
            $fechaDisponible = new DateTime($fechaDisponibleAscensoDB, new DateTimeZone('America/Mexico_City'));
            if ($now < $fechaDisponible) {
                $this->response['message'] = 'El usuario aún no está disponible para ascender. Próximo ascenso disponible el ' . $fechaDisponible->format('Y-m-d H:i:s') . ' (Hora de México).';
                $this->output();
            }
        }
        if (!isset($this->misionesPorRango) || !is_array($this->misionesPorRango) || empty($this->misionesPorRango) || !isset($this->tiempoAscensoSegundosPorRango) || !is_array($this->tiempoAscensoSegundosPorRango) || empty($this->tiempoAscensoSegundosPorRango)) {
            $this->response['message'] = 'Error de configuración: Los datos de rangos y misiones no están definidos correctamente en rangos_data.php.';
            $this->output();
        }
        $rangosKeys = array_keys($this->misionesPorRango);
        $currentRangoIndex = array_search($rangoActual, $rangosKeys);
        if ($currentRangoIndex === false) {
            $this->response['message'] = 'El rango actual del usuario no es válido o no está definido en la configuración de rangos_data.php.';
            $this->output();
        }
        $misionesActuales = $this->misionesPorRango[$rangoActual];
        
        // Limpiar la misión actual para comparación
        $misionActualLimpia = preg_replace('/^SHN-\s*|\s*-.*$/', '', trim($misionActual));
        
        // Buscar coincidencia en el array de misiones
        $currentMisionIndex = false;
        foreach ($misionesActuales as $index => $mision) {
            $misionLimpia = preg_replace('/^SHN-\s*/', '', trim($mision));
            if (strcasecmp(trim($misionActualLimpia), trim($misionLimpia)) === 0) {
                $currentMisionIndex = $index;
                break;
            }
        }

        if ($currentMisionIndex === false) {
            $this->response['message'] = 'La misión actual del usuario no coincide con las misiones definidas para su rango en rangos_data.php.';
            $this->output();
        }

        if ($currentMisionIndex === count($misionesActuales) - 1) {
            $nextRangoIndex = $currentRangoIndex + 1;
            if ($nextRangoIndex < count($rangosKeys)) {
                $siguienteRango = $rangosKeys[$nextRangoIndex];
                $siguienteMision = $this->misionesPorRango[$siguienteRango][0];
            } else {
                $this->response['message'] = 'El usuario ya está en el rango y misión más altos disponibles.';
                $this->output();
            }
        } else {
            $siguienteRango = $rangoActual;
            $siguienteMision = $misionesActuales[$currentMisionIndex + 1];
        }

        // Obtener la inicial del rango actual
        $inicialRango = strtoupper(substr($siguienteRango, 0, 1));
        
        // Modificar la parte donde se formatea la misión
        $misionActualPartes = explode('-', $misionActual);
        $firmaUsuario = $usuario['firma_usuario'];
        
        // Si el usuario no tiene firma, no incluir su parte en el formato
        if (empty($firmaUsuario)) {
            $misionFormateada = sprintf("SHN- %s -%s #%s",
                str_replace('SHN- ', '', $siguienteMision),
                $this->firmaEncargado ?: '-',
                $inicialRango
            );
        } else {
            $misionFormateada = sprintf("SHN- %s -%s -%s #%s",
                str_replace('SHN- ', '', $siguienteMision),
                $firmaUsuario,
                $this->firmaEncargado ?: '-',
                $inicialRango
            );
        }

        // Obtener el tiempo de espera del rango actual
        $tiempoStr = $this->tiempoAscensoSegundosPorRango[$rangoActual] ?? '00:00:00';
        
        // Convertir el formato HH:MM:SS a segundos para cálculos precisos
        list($horas, $minutos, $segundos) = explode(':', $tiempoStr);
        $tiempoEnSegundos = ($horas * 3600) + ($minutos * 60) + $segundos;
        
        // Crear el intervalo usando los segundos calculados
        $interval = new DateInterval('PT' . $tiempoEnSegundos . 'S');
        
        // Establecer la zona horaria de México
        $horaActual = new DateTime('now', new DateTimeZone('America/Mexico_City'));
        $horaDisponible = clone $horaActual;
        $horaDisponible->add($interval);

        // Formatear las fechas
        $fechaDisponibleAscensoFormatted = $horaDisponible->format('Y-m-d H:i:s');
        $fechaUltimoAscensoFormatted = $horaActual->format('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("UPDATE ascensos SET rango_actual = :siguiente_rango, mision_actual = :siguiente_mision, firma_usuario = :firma_usuario, firma_encargado = :firma_encargado, estado_ascenso = 'ascendido', fecha_ultimo_ascenso = :fecha_ultimo_ascenso, fecha_disponible_ascenso = :fecha_disponible_ascenso, usuario_encargado = :usuario_encargado WHERE codigo_time = :codigo");
        $stmt->bindParam(':siguiente_rango', $siguienteRango);
        $stmt->bindParam(':siguiente_mision', $misionFormateada); // Usar la misión formateada
        $stmt->bindParam(':firma_usuario', $firmaUsuario);
        $stmt->bindParam(':firma_encargado', $this->firmaEncargado);
        $stmt->bindParam(':fecha_ultimo_ascenso', $fechaUltimoAscensoFormatted);
        $stmt->bindParam(':fecha_disponible_ascenso', $fechaDisponibleAscensoFormatted);
        $stmt->bindParam(':usuario_encargado', $this->usuarioEncargado);
        $stmt->bindParam(':codigo', $this->codigoUsuario);
        if ($stmt->execute()) {
            $this->response['success'] = true;
            $this->response['message'] = 'Ascenso registrado exitosamente.';
        } else {
            $this->response['message'] = 'Error al actualizar la base de datos.';
        }
    }

    private function output() {
        echo json_encode($this->response);
        exit;
    }
}

$handler = new AscensoHandler($misionesPorRango, $tiempoAscensoSegundosPorRango);
$handler->procesar();
