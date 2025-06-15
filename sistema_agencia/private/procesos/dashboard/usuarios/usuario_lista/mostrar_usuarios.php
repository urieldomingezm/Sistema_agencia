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
                    rol_id,
                    fecha_registro,
                    ip_registro,
                    nombre_habbo,
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="registroUsuarioTable" class="table table-striped table-bordered align-middle mb-0" style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Usuario</th>
                                    <th class="text-center">Fecha Registro</th>
                                    <th class="text-center">IP Registro</th>
                                    <th class="text-center">Habbo</th>
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
                <div class="card-footer bg-light">
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
        $rol_id = $registro['rol_id'] ?? '';
        $fecha_registro = $registro['fecha_registro'] ?? '';
        $ip_registro = $registro['ip_registro'] ?? '';
        $nombre_habbo = $registro['nombre_habbo'] ?? '';
        $codigo_time = $registro['codigo_time'] ?? '';
        $ip_bloqueo = $registro['ip_bloqueo'] ?? '';

        $fechaFormateada = !empty($fecha_registro) ? date('d/m/Y H:i:s', strtotime($fecha_registro)) : '';
        
        // Badge para rol
        $rolBadge = $this->getRolBadge($rol_id);
        
        // Estado del usuario (bloqueado o activo)
        $estadoBadge = $this->getEstadoBadge($ip_bloqueo);

        return '<tr>
            <td class="text-center align-middle">
                <span class="badge bg-secondary">' . htmlspecialchars($id) . '</span>
            </td>
            <td class="text-start align-middle">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-circle me-2 text-primary" style="font-size: 1.5rem;"></i>
                    <div>
                        <span class="fw-semibold">' . htmlspecialchars($usuario_registro) . '</span><br>
                        <small class="text-muted">ID: ' . htmlspecialchars($codigo_time) . '</small>
                    </div>
                </div>
            </td>
            <td class="text-center align-middle">
                <small>' . htmlspecialchars($fechaFormateada) . '</small>
            </td>
            <td class="text-center align-middle">
                <small class="text-muted">' . htmlspecialchars($ip_registro) . '</small>
            </td>
            <td class="text-start align-middle">
                <div class="d-flex align-items-center">
                    <img loading="lazy" class="me-2 rounded-circle" 
                         src="https://www.habbo.es/habbo-imaging/avatarimage?user=' . urlencode($nombre_habbo) . '&amp;headonly=1&amp;head_direction=3&amp;size=m" 
                         alt="' . htmlspecialchars($nombre_habbo) . '" 
                         title="' . htmlspecialchars($nombre_habbo) . '" 
                         width="30" height="30">
                    <span class="fw-semibold" style="word-break: break-word;">' . htmlspecialchars($nombre_habbo) . '</span>
                </div>
            </td>
            <td class="text-center align-middle">' . $estadoBadge . '</td>
        </tr>';
    }

    private function getRolBadge($rol_id) {
        $badgeStyle = '';
        $rolTexto = '';
        
        switch ($rol_id) {
            case '1':
                $badgeStyle = 'background-color: #dc3545; color: #f8f9fa;';
                $rolTexto = 'Administrador';
                break;
            case '2':
                $badgeStyle = 'background-color: #0d6efd; color: #f8f9fa;';
                $rolTexto = 'Moderador';
                break;
            case '3':
                $badgeStyle = 'background-color: #198754; color: #f8f9fa;';
                $rolTexto = 'Usuario';
                break;
            case '4':
                $badgeStyle = 'background-color: #ffc107; color: #212529;';
                $rolTexto = 'Invitado';
                break;
            default:
                $badgeStyle = 'background-color: #6c757d; color: #f8f9fa;';
                $rolTexto = 'Rol ' . $rol_id;
        }

        return '<span class="badge" style="' . $badgeStyle . '">' . htmlspecialchars($rolTexto) . '</span>';
    }

    private function getEstadoBadge($ip_bloqueo) {
        if (!empty($ip_bloqueo)) {
            return '<span class="badge bg-danger"><i class="bi bi-lock-fill me-1"></i>Bloqueado</span>';
        } else {
            return '<span class="badge bg-success"><i class="bi bi-check-circle-fill me-1"></i>Activo</span>';
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
        perPage: 25,
        perPageSelect: [10, 25, 50, 100],
        labels: {
            placeholder: "Buscar...",
            perPage: "registros por página",
            noRows: "No se encontraron registros",
            info: "Mostrando {start} a {end} de {rows} registros"
        },
        columns: [
            { select: 1, sortable: false }, // Deshabilitar ordenamiento en columna de usuario
            { select: 5, sortable: false }, // Deshabilitar ordenamiento en columna de habbo
        ]
    });
    
    // Ordenar por fecha de registro descendente por defecto
    dataTable.columns().sort(3, "desc");
});
</script>

<head>
    <meta name="keywords" content="Lista de usuarios registrados, gestión de usuarios, registro de usuarios">
</head>