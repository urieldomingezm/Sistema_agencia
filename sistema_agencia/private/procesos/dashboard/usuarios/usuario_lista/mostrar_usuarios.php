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

    // Helper function to mask IP address
    private function maskIP($ip) {
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

    public function __construct() {
        $database = new Database();
        $registroManager = new RegistroUsuarioManager($database);
        $this->registroUsuarios = $registroManager->getAllRegistroUsuarios();
    }

    public function renderTable() {
        $html = '<div class="container-fluid mt-4">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>Lista de Usuarios Registrados</h5>
                    <button class="btn btn-light" 
                            id="Ayuda_registro_usuario-tab" 
                            data-bs-toggle="modal" 
                            data-bs-target="#Ayuda_registro_usuario">
                        <i class="bi bi-question-circle-fill me-1"></i> Ayuda
                    </button>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table id="registroUsuarioTable" class="table table-sm table-striped table-bordered align-middle mb-0" style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Usuario</th>
                                    <th class="text-center">Fecha Registro</th>
                                    <th class="text-center">IP Registro</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>';

        foreach ($this->registroUsuarios as $registro) {
            $html .= $this->renderRow($registro);
        }

        $html .= '</tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light py-2">
                    <div class="row">
                        <div class="col-12 text-end">
                            <span class="badge bg-success"><i class="bi bi-info-circle me-1"></i> Total usuarios: ' . count($this->registroUsuarios) . '</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }

    private function renderRow($registro) {
        $id = $registro['id'] ?? '';
        $usuario_registro = $registro['usuario_registro'] ?? '';
        $fecha_registro = $registro['fecha_registro'] ?? '';
        $ip_registro = $registro['ip_registro'] ?? '';
        $codigo_time = $registro['codigo_time'] ?? '';
        $ip_bloqueo = $registro['ip_bloqueo'] ?? '';

        // Mask IP addresses
        $masked_ip = $this->maskIP($ip_registro);
        $masked_ip_bloqueo = $this->maskIP($ip_bloqueo);

        $fechaFormateada = !empty($fecha_registro) ? date('d/m/Y H:i:s', strtotime($fecha_registro)) : '';
        
        // Estado del usuario (bloqueado o activo)
        $estadoBadge = $this->getEstadoBadge($masked_ip_bloqueo);

        return '<tr>
            <td class="text-center align-middle p-1">
                <span class="badge bg-secondary">' . htmlspecialchars($id) . '</span>
            </td>
            <td class="text-start align-middle p-1">
                <div class="d-flex align-items-center">
                    <img loading="lazy" class="me-1 rounded-circle" 
                         src="https://www.habbo.es/habbo-imaging/avatarimage?user=' . urlencode($usuario_registro) . '&amp;headonly=1&amp;head_direction=3&amp;size=m" 
                         alt="' . htmlspecialchars($usuario_registro) . '" 
                         title="' . htmlspecialchars($usuario_registro) . '" 
                         width="25" height="25">
                    <div>
                        <span class="fw-semibold small">' . htmlspecialchars($usuario_registro) . '</span><br>
                        <small class="text-muted" style="font-size: 0.75rem;">ID: ' . htmlspecialchars($codigo_time) . '</small>
                    </div>
                </div>
            </td>
            <td class="text-center align-middle p-1">
                <small style="font-size: 0.8rem;">' . htmlspecialchars($fechaFormateada) . '</small>
            </td>
            <td class="text-center align-middle p-1">
                <small class="text-muted" style="font-size: 0.8rem;">' . htmlspecialchars($masked_ip) . '</small>
            </td>
            <td class="text-center align-middle p-1">' . $estadoBadge . '</td>
        </tr>';
    }

    private function maskIP($ip) {
        if (empty($ip)) return '';
        $parts = explode('.', $ip);
        if (count($parts) === 4) {
            return $parts[0] . '.***.***.' . $parts[3];
        }
        return hash('sha256', $ip);
    }

    private function getEstadoBadge($ip_bloqueo) {
        if (!empty($ip_bloqueo)) {
            return '<span class="badge bg-danger" style="font-size: 0.75rem;"><i class="bi bi-lock-fill me-1"></i>Bloqueado</span>';
        } else {
            return '<span class="badge bg-success" style="font-size: 0.75rem;"><i class="bi bi-check-circle-fill me-1"></i>Activo</span>';
        }
    }
}

$gestionRegistroUsuario = new GestionRegistroUsuario();
echo $gestionRegistroUsuario->renderTable();
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataTable = new simpleDatatables.DataTable('#registroUsuarioTable', {
        searchable: true,
        sortable: true,
        perPage: 10,
        perPageSelect: [10, 25, 50, 100],
        labels: {
            placeholder: "Buscar...",
            perPage: "registros por página",
            noRows: "No se encontraron registros",
            info: "Mostrando {start} a {end} de {rows} registros"
        },
        columns: [
            { select: 1, sortable: false }
        ]
    });
    
    dataTable.columns().sort(2, "desc");
});
</script>

<head>
    <meta name="keywords" content="Lista de usuarios registrados, gestión de usuarios, registro de usuarios">
</head>