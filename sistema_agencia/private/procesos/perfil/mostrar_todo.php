<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(CONFIG_PATH . 'bd.php');

class UserProfileData {
    private $conn;
    private $userCodigoTime = null; // Inicializar como null
    private $nombreHabbo = null; // Inicializar como null

    private $personalData = null;
    private $membresiaData = null;
    private $ascensoData = null;
    private $tiempoData = null;
    private $requisitosData = [];
    private $pagasData = [];

    private $errors = [];

    public function __construct() {
        // Cambiar la verificación inicial para usar user_id o username de la sesión
        $userId = $_SESSION['user_id'] ?? null;
        $username = $_SESSION['username'] ?? null;

        if (!$userId && !$username) {
            $this->errors[] = "Usuario no logueado o sesión incompleta (user_id/username no encontrados).";
            return;
        }

        try {
            $database = new Database();
            $this->conn = $database->getConnection();

            if (!$this->conn) {
                $this->errors[] = "Error al obtener la conexión a la base de datos.";
                return;
            }

            // Primero, obtener los datos personales usando user_id o username
            $this->fetchPersonalData($userId, $username);

            // Si se obtuvieron los datos personales y con ellos codigo_time y nombre_habbo,
            // entonces proceder a obtener los demás datos.
            if ($this->userCodigoTime || $this->nombreHabbo) {
                $this->fetchMembresiaData();
                $this->fetchAscensoData();
                $this->fetchTiempoData();
                $this->fetchRequisitosData();
                $this->fetchPagasData();
            } else {
                 $this->errors[] = "No se pudo obtener codigo_time o nombre_habbo del usuario logueado.";
            }


        } catch (PDOException $e) {
            $this->errors[] = "Error de PDO: " . $e->getMessage();
            error_log("Error de PDO en UserProfileData: " . $e->getMessage());
        } catch (Exception $e) {
            $this->errors[] = "Error general: " . $e->getMessage();
            error_log("Error general en UserProfileData: " . $e->getMessage());
        }
    }

    // Modificar fetchPersonalData para usar user_id o username
    private function fetchPersonalData($userId, $username) {
        if (!$this->conn || (!$userId && !$username)) return;

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
                    id = :user_id OR usuario_registro = :username
                LIMIT 1"; // Limitar a 1 por si acaso

        $stmt = $this->conn->prepare($sql);
        // Bindear ambos parámetros, aunque solo uno se use en la sesión
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $this->personalData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si se encontraron datos, establecer las propiedades codigo_time y nombre_habbo de la clase
        if ($this->personalData) {
             $this->userCodigoTime = $this->personalData['codigo_time'] ?? null;
             $this->nombreHabbo = $this->personalData['nombre_habbo'] ?? null;

             // Opcional: Asegurar que nombre_habbo esté en sesión si se encontró
             if (!isset($_SESSION['nombre_habbo']) && $this->nombreHabbo) {
                 $_SESSION['nombre_habbo'] = $this->nombreHabbo;
             }
        } else {
             $this->errors[] = "No se encontraron datos personales para el usuario logueado.";
        }
    }

    private function fetchMembresiaData() {
        // Ahora usamos la propiedad de la clase
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
        // Ahora usamos la propiedad de la clase
        if (!$this->conn || !$this->userCodigoTime) return;

        $sql = "SELECT
                    a.rango_actual,
                    a.mision_actual,
                    a.firma_usuario,
                    a.estado_ascenso,
                    a.fecha_disponible_ascenso,
                    a.usuario_encargado -- Asegurarse de seleccionar este campo si existe
                FROM
                    ascensos a
                WHERE
                    a.codigo_time = :codigo_time";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':codigo_time', $this->userCodigoTime, PDO::PARAM_STR);
        $stmt->execute();
        $this->ascensoData = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function fetchTiempoData() {
        // Ahora usamos la propiedad de la clase
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
        // Ahora usamos la propiedad de la clase
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
        // Ahora usamos la propiedad de la clase
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
                    pagas_usuario = :nombre_habbo
                ORDER BY pagas_fecha_registro DESC"; // Ordenar para obtener la última paga primero

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