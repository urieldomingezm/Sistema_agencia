<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(CONFIG_PATH . 'bd.php');

class UserProfileData {
    private $conn;
    private $userCodigoTime;
    private $nombreHabbo;

    private $personalData = null;
    private $membresiaData = null;
    private $ascensoData = null;
    private $tiempoData = null;
    private $requisitosData = [];
    private $pagasData = [];

    private $errors = [];

    public function __construct() {
        $this->userCodigoTime = $_SESSION['codigo_time'] ?? null;
        $this->nombreHabbo = $_SESSION['nombre_habbo'] ?? null;

        if (!$this->userCodigoTime && !$this->nombreHabbo) {
            $this->errors[] = "Usuario no logueado o sesión incompleta.";
            return;
        }

        try {
            $database = new Database();
            $this->conn = $database->getConnection();

            if (!$this->conn) {
                $this->errors[] = "Error al obtener la conexión a la base de datos.";
                return;
            }

            $this->fetchPersonalData();
            $this->fetchMembresiaData();
            $this->fetchAscensoData();
            $this->fetchTiempoData();
            $this->fetchRequisitosData();
            $this->fetchPagasData();

        } catch (PDOException $e) {
            $this->errors[] = "Error de PDO: " . $e->getMessage();
            error_log("Error de PDO en UserProfileData: " . $e->getMessage());
        } catch (Exception $e) {
            $this->errors[] = "Error general: " . $e->getMessage();
            error_log("Error general en UserProfileData: " . $e->getMessage());
        }
    }

    private function fetchPersonalData() {
        if (!$this->conn || !$this->userCodigoTime) return;

        $sql = "SELECT
                    id,
                    usuario_registro,
                    password_registro,
                    rol_id,
                    fecha_registro,
                    ip_registro,
                    nombre_habbo,
                    codigo_time
                FROM
                    registro_usuario
                WHERE
                    codigo_time = :codigo_time";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':codigo_time', $this->userCodigoTime, PDO::PARAM_STR);
        $stmt->execute();
        $this->personalData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($this->personalData && !isset($_SESSION['nombre_habbo'])) {
             $_SESSION['nombre_habbo'] = $this->personalData['nombre_habbo'];
             $this->nombreHabbo = $_SESSION['nombre_habbo'];
        }
    }

    private function fetchMembresiaData() {
        if (!$this->conn || !$this->nombreHabbo) return;

        $sql = "SELECT
                    venta_titulo,
                    venta_estado
                FROM
                    gestion_ventas
                WHERE
                    venta_comprador = :nombre_habbo
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre_habbo', $this->nombreHabbo, PDO::PARAM_STR);
        $stmt->execute();
        $this->membresiaData = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function fetchAscensoData() {
        if (!$this->conn || !$this->userCodigoTime) return;

        $sql = "SELECT
                    a.rango_actual,
                    a.mision_actual,
                    a.firma_usuario,
                    a.estado_ascenso,
                    a.fecha_disponible_ascenso
                FROM
                    ascensos a
                JOIN
                    registro_usuario ru ON a.codigo_time = ru.codigo_time
                WHERE
                    a.codigo_time = :codigo_time";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':codigo_time', $this->userCodigoTime, PDO::PARAM_STR);
        $stmt->execute();
        $this->ascensoData = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function fetchTiempoData() {
        if (!$this->conn || !$this->userCodigoTime) return;

        $sql = "SELECT
                    tiempo_status,
                    tiempo_restado,
                    tiempo_acumulado,
                    tiempo_transcurrido,
                    tiempo_encargado_usuario
                FROM
                    gestion_tiempo
                WHERE
                    codigo_time = :codigo_time
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':codigo_time', $this->userCodigoTime, PDO::PARAM_STR);
        $stmt->execute();
        $this->tiempoData = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function fetchRequisitosData() {
        if (!$this->conn || !$this->nombreHabbo) return;

        $sql = "SELECT
                    id,
                    user,
                    requirement_name,
                    times_as_encargado_count,
                    ascensos_as_encargado_count,
                    is_completed,
                    last_updated
                FROM
                    gestion_requisitos
                WHERE
                    user = :nombre_habbo";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre_habbo', $this->nombreHabbo, PDO::PARAM_STR);
        $stmt->execute();
        $this->requisitosData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function fetchPagasData() {
        if (!$this->conn || !$this->nombreHabbo) return;

        $sql = "SELECT
                    pagas_id,
                    pagas_usuario,
                    pagas_rango,
                    pagas_recibio,
                    pagas_motivo,
                    pagas_completo,
                    pagas_descripcion,
                    pagas_fecha_registro
                FROM
                    gestion_pagas
                WHERE
                    pagas_usuario = :nombre_habbo";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre_habbo', $this->nombreHabbo, PDO::PARAM_STR);
        $stmt->execute();
        $this->pagasData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPersonalData() {
        return $this->personalData;
    }

    public function getMembresiaData() {
        return $this->membresiaData;
    }

    public function getAscensoData() {
        return $this->ascensoData;
    }

    public function getTiempoData() {
        return $this->tiempoData;
    }

    public function getRequisitosData() {
        return $this->requisitosData;
    }

    public function getPagasData() {
        return $this->pagasData;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }

    public function __destruct() {
        $this->conn = null;
    }
}
?>