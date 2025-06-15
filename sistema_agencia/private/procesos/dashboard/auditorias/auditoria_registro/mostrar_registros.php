<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

class AuditoriaPasswordManager {
    private $conn;

    public function __construct($db) {
        $this->conn = $db->getConnection();
    }

    public function getAllAuditoriaPasswords() {
        $sql = "SELECT
                    id_auditoria,
                    fecha_cambio,
                    usuario_id,
                    nombre_habbo,
                    usuario_modificador,
                    ip_modificacion
                FROM
                    auditoria_passwords
                ORDER BY fecha_cambio DESC";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            error_log("Error fetching auditoria passwords: " . $exception->getMessage());
            return [];
        }
    }
}

class GestionAuditoriaPassword {
    private $auditoriaPasswords;

    public function __construct() {
        $database = new Database();
        $auditoriaManager = new AuditoriaPasswordManager($database);
        $this->auditoriaPasswords = $auditoriaManager->getAllAuditoriaPasswords();
    }

    public function renderTable() {
        $html = '<div class="container-fluid mt-4">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Auditoría de Cambios de Contraseñas</h5>
                    <button class="btn btn-dark" 
                            id="Ayuda_auditoria_password-tab" 
                            data-bs-toggle="modal" 
                            data-bs-target="#Ayuda_auditoria_password">
                        <i class="bi bi-question-circle-fill me-1"></i> Ayuda
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="auditoriaPasswordTable" class="table table-striped table-bordered align-middle mb-0" style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Usuario</th>
                                    <th class="text-center">Modificador</th>
                                    <th class="text-center">IP</th>
                                </tr>
                            </thead>
                            <tbody>';

        foreach ($this->auditoriaPasswords as $registro) {
            $html .= $this->renderRow($registro);
        }

        $html .= '</tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="row">
                        <div class="col-12 text-end">
                            <span class="badge bg-warning text-dark"><i class="bi bi-info-circle me-1"></i> Total registros: ' . count($this->auditoriaPasswords) . '</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }

    private function renderRow($registro) {
        $id_auditoria = $registro['id_auditoria'] ?? '';
        $fecha_cambio = $registro['fecha_cambio'] ?? '';
        $usuario_id = $registro['usuario_id'] ?? '';
        $nombre_habbo = $registro['nombre_habbo'] ?? '';
        $usuario_modificador = $registro['usuario_modificador'] ?? '';
        $ip_modificacion = $registro['ip_modificacion'] ?? '';

        $fechaFormateada = !empty($fecha_cambio) ? date('d/m/Y H:i:s', strtotime($fecha_cambio)) : '';

        return '<tr>
            <td class="text-center align-middle">
                <span class="badge bg-secondary">' . htmlspecialchars($id_auditoria) . '</span>
            </td>
            <td class="text-center align-middle">
                <small>' . htmlspecialchars($fechaFormateada) . '</small>
            </td>
            <td class="text-start align-middle">
                <div class="d-flex align-items-center">
                    <img loading="lazy" class="me-2 rounded-circle" 
                         src="https://www.habbo.es/habbo-imaging/avatarimage?user=' . urlencode($nombre_habbo) . '&amp;headonly=1&amp;head_direction=3&amp;size=m" 
                         alt="' . htmlspecialchars($nombre_habbo) . '" 
                         title="' . htmlspecialchars($nombre_habbo) . '" 
                         width="30" height="30">
                    <div>
                        <span class="fw-semibold" style="word-break: break-word;">' . htmlspecialchars($nombre_habbo) . '</span><br>
                        <small class="text-muted">ID: ' . htmlspecialchars($usuario_id) . '</small>
                    </div>
                </div>
            </td>
            <td class="text-center align-middle">
                <span class="badge bg-primary">' . htmlspecialchars($usuario_modificador) . '</span>
            </td>
            <td class="text-center align-middle">
                <small class="text-muted">' . htmlspecialchars($ip_modificacion) . '</small>
            </td>
        </tr>';
    }
}

$gestionAuditoriaPassword = new GestionAuditoriaPassword();
echo $gestionAuditoriaPassword->renderTable();
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataTable = new simpleDatatables.DataTable('#auditoriaPasswordTable', {
        searchable: true,
        sortable: true,
        perPage: 25,
        perPageSelect: [10, 25, 50, 100],
        labels: {
            placeholder: "Buscar...",
            perPage: "registros por página",
            noRows: "No se encontraron registros",
            info: "Mostrando {start} a {end} de {rows} registros"
        },
        columns: [
            { select: 2, sortable: false }, // Deshabilitar ordenamiento en columna de usuario
        ]
    });
    
    // Ordenar por fecha descendente por defecto
    dataTable.columns().sort(1, "desc");
});
</script>

<head>
    <meta name="keywords" content="Auditoría de contraseñas, cambios de passwords, historial de modificaciones de seguridad">
</head>

