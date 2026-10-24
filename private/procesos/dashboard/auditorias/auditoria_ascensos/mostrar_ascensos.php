<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

class AuditoriaAscensos {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function getuniqueascensosmodificados() {
        $sql = "SELECT DISTINCT
                    nombre_habbo,
                    codigo_time,
                    rango_anterior,
                    rango_nuevo,
                    mision_anterior,
                    mision_nueva,
                    usuario_modificador,
                    MIN(fecha_cambio) as primera_fecha
                FROM
                    auditoria_ascensos
                GROUP BY 
                    nombre_habbo,
                    codigo_time,
                    rango_anterior,
                    rango_nuevo,
                    mision_anterior,
                    mision_nueva,
                    usuario_modificador
                ORDER BY primera_fecha DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            error_log("Error fetching unique auditoria registros: " . $exception->getMessage());
            return [];
        }
    }
}

class GestionAuditoriaRegistro {
    private $auditoriaRegistros;
    private $auditoriaManager;

    public function __construct() {
        $database = new Database();
        $this->auditoriaManager = new AuditoriaAscensos($database);
        $this->auditoriaRegistros = $this->auditoriaManager->getuniqueascensosmodificados();
    }

    public function getAuditoriaRegistros() {
        return $this->auditoriaRegistros;
    }

    public function getTotalRegistros() {
        return count($this->auditoriaRegistros);
    }

    public function getRangoBadge($rango) {
        $badgeStyle = '';
        switch (strtolower($rango)) {
            case 'agente':
                $badgeStyle = 'background-color: #f8f9fa; color: #212529; border: 1px solid #dee2e6;';
                break;
            case 'seguridad':
                $badgeStyle = 'background-color: #212529; color: #f8f9fa;';
                break;
            case 'tecnico':
                $badgeStyle = 'background-color:rgb(71, 40, 0); color: #f8f9fa;';
                break;
            case 'logistica':
                $badgeStyle = 'background-color: #6610f2; color: #f8f9fa;';
                break;
            case 'supervisor':
                $badgeStyle = 'background-color: #6c757d; color: #f8f9fa;';
                break;
            case 'director':
                $badgeStyle = 'background-color: #dc3545; color: #f8f9fa;';
                break;
            case 'presidente':
                $badgeStyle = 'background-color: #0d6efd; color: #f8f9fa;';
                break;
            case 'operativo':
                $badgeStyle = 'background-color: #ffc107; color: #212529;';
                break;
            case 'junta directiva':
                $badgeStyle = 'background-color: #198754; color: #f8f9fa;';
                break;
            default:
                $badgeStyle = 'background-color: #6c757d; color: #f8f9fa;';
        }

        return '<span class="badge" style="' . $badgeStyle . '">' . htmlspecialchars($rango) . '</span>';
    }
}

// Inicializar la gestión de auditoría
$gestionAuditoriaRegistro = new GestionAuditoriaRegistro();
$auditoriaRegistros = $gestionAuditoriaRegistro->getAuditoriaRegistros();
?>
