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

    public function __construct() {
        $database = new Database();
        $auditoriaManager = new AuditoriaAscensos($database);
        $this->auditoriaRegistros = $auditoriaManager->getuniqueascensosmodificados();
    }

    public function renderTable() {
        $html = '<div class="container-fluid mt-4">
            <div class="card shadow-lg">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-clipboard-data me-2"></i>Registros Únicos de Auditoría</h5>
                    <button class="btn btn-light" 
                            id="Ayuda_auditoria_registro-tab" 
                            data-bs-toggle="modal" 
                            data-bs-target="#Ayuda_auditoria_registro">
                        <i class="bi bi-question-circle-fill me-1"></i> Ayuda
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="auditoriaRegistroTable" class="table table-striped table-bordered align-middle mb-0" style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">Usuario</th>
                                    <th class="text-center">Rango Anterior</th>
                                    <th class="text-center">Rango Nuevo</th>
                                    <th class="text-center">Misión Anterior</th>
                                    <th class="text-center">Misión Nueva</th>
                                    <th class="text-center">Modificador</th>
                                </tr>
                            </thead>
                            <tbody>';

        foreach ($this->auditoriaRegistros as $registro) {
            $html .= $this->renderRow($registro);
        }

        $html .= '</tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="row">
                        <div class="col-12 text-end">
                            <span class="badge bg-info"><i class="bi bi-info-circle me-1"></i> Total registros únicos: ' . count($this->auditoriaRegistros) . '</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }

    private function renderRow($registro) {
        $nombre_habbo = $registro['nombre_habbo'] ?? '';
        $codigo_time = $registro['codigo_time'] ?? '';
        $rango_anterior = $registro['rango_anterior'] ?? '';
        $rango_nuevo = $registro['rango_nuevo'] ?? '';
        $mision_anterior = $registro['mision_anterior'] ?? '';
        $mision_nueva = $registro['mision_nueva'] ?? '';
        $usuario_modificador = $registro['usuario_modificador'] ?? '';

        $badgeAnterior = $this->getRangoBadge($rango_anterior);
        $badgeNuevo = $this->getRangoBadge($rango_nuevo);

        return '<tr>
            <td class="text-start align-middle">
                <div class="d-flex align-items-center">
                    <img loading="lazy" class="me-2 rounded-circle" 
                         src="https://www.habbo.es/habbo-imaging/avatarimage?user=' . urlencode($nombre_habbo) . '&amp;headonly=1&amp;head_direction=3&amp;size=m" 
                         alt="' . htmlspecialchars($nombre_habbo) . '" 
                         title="' . htmlspecialchars($nombre_habbo) . '" 
                         width="30" height="30">
                    <div>
                        <span class="fw-semibold" style="word-break: break-word;">' . htmlspecialchars($nombre_habbo) . '</span><br>
                        <small class="text-muted">ID: ' . htmlspecialchars($codigo_time) . '</small>
                    </div>
                </div>
            </td>
            <td class="text-center align-middle">' . $badgeAnterior . '</td>
            <td class="text-center align-middle">' . $badgeNuevo . '</td>
            <td class="text-center align-middle">
                <small>' . htmlspecialchars($mision_anterior) . '</small>
            </td>
            <td class="text-center align-middle">
                <small>' . htmlspecialchars($mision_nueva) . '</small>
            </td>
            <td class="text-center align-middle">
                <span class="badge bg-primary">' . htmlspecialchars($usuario_modificador) . '</span>
            </td>
        </tr>';
    }

    private function getRangoBadge($rango) {
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

$gestionAuditoriaRegistro = new GestionAuditoriaRegistro();
echo $gestionAuditoriaRegistro->renderTable();
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataTable = new simpleDatatables.DataTable('#auditoriaRegistroTable', {
        searchable: true,
        sortable: true,
        perPage: 25,
        perPageSelect: [10, 25, 50, 100],
        labels: {
            placeholder: "Buscar...",
            perPage: "registros por página",
            noRows: "No se encontraron registros",
            info: "Mostrando {start} a {end} de {rows} registros"
        }
    });
});
</script>

<head>
    <meta name="keywords" content="Auditoría de registros únicos, cambios de rangos, historial de modificaciones">
</head>