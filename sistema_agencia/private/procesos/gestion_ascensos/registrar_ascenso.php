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

    public function __construct($misionesPorRango, $tiempoAscensoSegundosPorRango) {
        $this->misionesPorRango = $misionesPorRango;
        $this->tiempoAscensoSegundosPorRango = $tiempoAscensoSegundosPorRango;
        $this->firmaEncargado = $_SESSION['firma'] ?? null;
        $this->usuarioEncargado = $_SESSION['username'] ?? null;
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
        $currentMisionIndex = array_search($misionActual, $misionesActuales);
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
        $tiempoStr = $this->tiempoAscensoSegundosPorRango[$rangoActual] ?? '00:00:00';
        list($h, $m, $s) = explode(':', $tiempoStr);
        $interval = new DateInterval(sprintf('PT%dH%dM%dS', $h, $m, $s));
        $horaActual = new DateTime('now', new DateTimeZone('America/Mexico_City'));
        $horaDisponible = clone $horaActual;
        $horaDisponible->add($interval);
        $fechaDisponibleAscensoFormatted = $horaDisponible->format('Y-m-d H:i:s');
        $fechaUltimoAscensoFormatted = $horaActual->format('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("UPDATE ascensos SET rango_actual = :siguiente_rango, mision_actual = :siguiente_mision, firma_usuario = :firma_usuario, firma_encargado = :firma_encargado, estado_ascenso = 'ascendido', fecha_ultimo_ascenso = :fecha_ultimo_ascenso, fecha_disponible_ascenso = :fecha_disponible_ascenso, usuario_encargado = :usuario_encargado WHERE codigo_time = :codigo");
        $stmt->bindParam(':siguiente_rango', $siguienteRango);
        $stmt->bindParam(':siguiente_mision', $siguienteMision);
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
