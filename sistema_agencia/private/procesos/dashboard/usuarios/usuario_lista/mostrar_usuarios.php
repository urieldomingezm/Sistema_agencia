<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

class RegistroUsuarioManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function getAllRegistroUsuarios() {
        $sql = "SELECT
                    id,
                    usuario_registro,
                    fecha_registro,
                    ip_registro,
                    codigo_time,
                    ip_bloqueo
                FROM
                    registro_usuario
                ORDER BY fecha_registro DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            error_log("Error fetching registro usuarios: " . $exception->getMessage());
            return [];
        }
    }

    public function getUsuariosActivosCount() {
        $sql = "SELECT COUNT(*) as count FROM registro_usuario WHERE ip_bloqueo IS NULL OR ip_bloqueo = ''";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch(PDOException $exception) {
            error_log("Error counting active users: " . $exception->getMessage());
            return 0;
        }
    }

    public function getUsuariosBloqueadosCount() {
        $sql = "SELECT COUNT(*) as count FROM registro_usuario WHERE ip_bloqueo IS NOT NULL AND ip_bloqueo != ''";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] ?? 0;
        } catch(PDOException $exception) {
            error_log("Error counting blocked users: " . $exception->getMessage());
            return 0;
        }
    }

    // Helper function to mask IP address
    public function maskIP($ip) {
        if (empty($ip)) return '';
        $parts = explode('.', $ip);
        if (count($parts) === 4) {
            return $parts[0] . '.***.***.' . $parts[3];
        }
        return hash('sha256', $ip);
    }
}

class GestionRegistroUsuario {
    private $registroUsuarios;
    private $registroManager;

    public function __construct() {
        $database = new Database();
        $this->registroManager = new RegistroUsuarioManager($database);
        $this->registroUsuarios = $this->registroManager->getAllRegistroUsuarios();
    }

    public function getRegistroUsuarios() {
        return $this->registroUsuarios;
    }

    public function getTotalUsuarios() {
        return count($this->registroUsuarios);
    }

    public function getUsuariosActivos() {
        return $this->registroManager->getUsuariosActivosCount();
    }

    public function getUsuariosBloqueados() {
        return $this->registroManager->getUsuariosBloqueadosCount();
    }

    public function formatearFecha($fecha) {
        return !empty($fecha) ? date('d/m/Y H:i:s', strtotime($fecha)) : '';
    }

    public function maskIP($ip) {
        return $this->registroManager->maskIP($ip);
    }

    public function getEstadoBadge($ip_bloqueo) {
        if (!empty($ip_bloqueo)) {
            return '<span class="badge bg-danger fs-6"><i class="bi bi-lock-fill me-1"></i>Bloqueado</span>';
        } else {
            return '<span class="badge bg-success fs-6"><i class="bi bi-check-circle-fill me-1"></i>Activo</span>';
        }
    }
}

// Inicializar la gestión de usuarios
$gestionRegistroUsuario = new GestionRegistroUsuario();
$registroUsuarios = $gestionRegistroUsuario->getRegistroUsuarios();
?>