<?php

class GestionAscensos {
    private $ascensos;

    public function __construct() {
        require_once(GESTION_ASCENSOS_PATCH . 'mostrar_usuarios.php');
        $database = new Database();
        $ascensoManager = new AscensoManager($database);
        $this->ascensos = $ascensoManager->getAllAscensos();
    }

    public function renderTable() {
        $html = '<div class="container-fluid mt-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-arrow-up-circle me-2"></i>Gestión de Ascensos</h5>
                    <button class="btn btn-success" 
                            id="Ayuda_gestion_ascensos-tab" 
                            data-bs-toggle="modal" 
                            data-bs-target="#Ayuda_gestion_ascensos">
                        <i class="bi bi-question-circle-fill me-1"></i> Ayuda
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="ascensosDisponiblesTable" class="table table-striped table-bordered align-middle mb-0" style="width:100%">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-center">Usuario</th>
                                    <th class="text-center">Rango</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Misión</th>
                                    <th class="text-center">Disponible</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>';

        $processedAscensos = [];
        foreach ($this->ascensos as $ascenso) {
            if (!in_array($ascenso['id_ascenso'] ?? $ascenso['codigo_time'], $processedAscensos)) {
                $html .= $this->renderRow($ascenso);
                $processedAscensos[] = $ascenso['id_ascenso'] ?? $ascenso['codigo_time'];
            }
        }

        $html .= '</tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="row">
                        <div class="col-12 text-end">
                            <span class="badge bg-info"><i class="bi bi-info-circle me-1"></i> Total registros: ' . count($processedAscensos) . '</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }

    private function renderRow($ascenso) {
        $estado = $this->getStatusBadge($ascenso['estado_ascenso']);
        $codigo = $ascenso['id_ascenso'] ?? $ascenso['codigo_time'];

        $badgeStyle = '';
        switch (strtolower($ascenso['rango_actual'])) {
            case 'agente':
            case 'Agente':
                $badgeStyle = 'background-color: #f8f9fa; color: #212529; border: 1px solid #dee2e6;';
                break;
            case 'seguridad':
            case 'Seguridad':
                $badgeStyle = 'background-color: #212529; color: #f8f9fa;';
                break;
            case 'Tecnico':
            case 'tecnico':
                $badgeStyle = 'background-color:rgb(71, 40, 0); color: #f8f9fa;';
                break;
            case 'Logistica':
            case 'logistica':
                $badgeStyle = 'background-color: #6610f2; color: #f8f9fa;';
                break;
            case 'supervisor':
            case 'Supervisor':
                $badgeStyle = 'background-color: #6c757d; color: #f8f9fa;';
                break;
            case 'director':
                case 'Director':
                $badgeStyle = 'background-color: #dc3545; color: #f8f9fa;';
                break;
            case 'presidente':
                case 'Presidente':
                $badgeStyle = 'background-color: #0d6efd; color: #f8f9fa;';
                break;
            case 'operativo':
                case 'Operativo':
                $badgeStyle = 'background-color: #ffc107; color: #212529;';
                break;
            case 'junta directiva':
                case 'Junta directiva':
                $badgeStyle = 'background-color: #198754; color: #f8f9fa;';
                break;
            default:
                $badgeStyle = 'background-color: #6c757d; color: #f8f9fa;';
        }

        $fechaMostrar = !empty($ascenso['fecha_ultimo_ascenso']) ? date('d/m/Y H:i', strtotime($ascenso['fecha_ultimo_ascenso'])) : '';
        $fechaDisponible = !empty($ascenso['fecha_disponible_ascenso']) ? date('H:i:s', strtotime($ascenso['fecha_disponible_ascenso'])) : '';

        return '<tr>
            <td class="text-start align-middle">
                <div class="d-flex align-items-center">
                    <img loading="lazy" class="me-2 rounded-circle" src="https://www.habbo.es/habbo-imaging/avatarimage?user=' . urlencode($ascenso['nombre_habbo']) . '&amp;headonly=1&amp;head_direction=3&amp;size=m" alt="' . htmlspecialchars($ascenso['nombre_habbo']) . '" title="' . htmlspecialchars($ascenso['nombre_habbo']) . '" width="40" height="40">
                    <div>
                        <span class="fw-semibold" style="word-break: break-word;">' . htmlspecialchars($ascenso['nombre_habbo']) . '</span><br>
                        <small class="text-muted">ID: ' . htmlspecialchars($codigo) . '</small>
                    </div>
                </div>
            </td>
            <td class="text-center align-middle">
                <span class="badge" style="' . $badgeStyle . '">' . htmlspecialchars($ascenso['rango_actual']) . '</span>
            </td>
            <td class="text-center align-middle">' . $estado . '</td>
            <td class="text-center align-middle">' . htmlspecialchars($ascenso['mision_actual']) . '</td>
            <td class="text-center align-middle">' . $fechaDisponible . '</td>
            <td class="text-center align-middle">' . $this->renderActions($codigo) . '</td>
        </tr>';
    }

    private function renderActions($codigo) {
        // ... existing code ...
        $buttons = '<div class="btn-group btn-group-sm" role="group">'; // Initialize $buttons here

        // Assuming $this->ascensos contains the current row's data, including estado_ascenso
        // You might need to pass the full $ascenso object to this method
        $ascenso = null;
        foreach ($this->ascensos as $item) {
            if (($item['id_ascenso'] ?? $item['codigo_time']) == $codigo) {
                $ascenso = $item;
                break;
            }
        }

        if ($ascenso) {
            switch (strtolower($ascenso['estado_ascenso'])) {
                case 'ascendido':
                    $buttons .= '<button class="btn btn-warning verificar-tiempo-btn" data-id="' . $codigo . '" title="Checar tiempo">
                                    Checar tiempo
                                </button>';
                    break;
                case 'disponible':
                case 'pendiente':
                    $buttons .= '<button class="btn btn-success ascender-btn" data-id="' . $codigo . '" title="Ascender">
                                    Ascender
                                </button>';
                    break;
            }
        }

        $buttons .= '</div>';
        return $buttons;
    }

    private function getStatusBadge($status) {
        $badgeClass = '';
        $statusText = ucfirst(strtolower($status));

        switch (strtolower($status)) {
            case 'disponible':
                $badgeClass = 'bg-primary';
                break;
            case 'ascendido':
                $badgeClass = 'bg-success';
                break;
            case 'pendiente':
                $badgeClass = 'bg-warning';
                break;
            default:
                $badgeClass = 'bg-secondary';
                break;
        }

        return '<span class="badge ' . $badgeClass . '"><i class="bi bi-list-check me-1"></i>' . $statusText . '</span>';
    }

    private function calculateElapsedTime($startTime) {
        if (empty($startTime)) return '';
        $start = new DateTime($startTime);
        $now = new DateTime();
        $interval = $start->diff($now);
        return $interval->format('%H:%I:%S');
    }
}

$gestionAscensos = new GestionAscensos();
echo $gestionAscensos->renderTable();
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Configuración para la tabla de disponibles
    const tableConfig = {
        searchable: true,
        perPage: 5,
        perPageSelect: [5, 10, 25, 50, 100],
        labels: {
            placeholder: "Buscar...",
            perPage: "registros por página",
            noRows: "No se encontraron registros",
            info: "Mostrando {start} a {end} de {rows} registros",
            loading: "Cargando...",
            infoFiltered: " (filtrado de {rows} registros totales)",
            next: "Siguiente",
            previous: "Anterior"
        }
    };

    // Inicializar solo la tabla de disponibles
    if (document.getElementById("ascensosDisponiblesTable")) {
        new simpleDatatables.DataTable("#ascensosDisponiblesTable", tableConfig);
    }

    // Botón de ascender y verificar tiempo (using event delegation)
    document.addEventListener('click', function(e) {
        if (e.target.matches('.ascender-btn')) {
            const id = e.target.dataset.id;
            
            // Get the modal element and the input field for the user code
            const darAscensoModal = new bootstrap.Modal(document.getElementById('dar_ascenso_modal'));
            const codigoTimeAscensoInput = document.getElementById('codigoTimeAscenso');

            // Set the user code in the input field
            if (codigoTimeAscensoInput) {
                codigoTimeAscensoInput.value = id;
            }

            // Open the modal
            darAscensoModal.show();

            // Optionally, trigger the search automatically after setting the code
            // You might need to find the search button element and trigger its click event
            const buscarUsuarioAscensoBtn = document.getElementById('buscarUsuarioAscenso');
            if (buscarUsuarioAscensoBtn) {
                 buscarUsuarioAscensoBtn.click();
            }

        } else if (e.target.matches('.verificar-tiempo-btn')) {
            const id = e.target.closest('button').dataset.id;
            verificarTiempoAscenso(id);
        }
    });

});
</script>

<script src="/public/assets/custom_general/custom_gestion_ascensos/index_gestion.js"></script>
<head>
    <meta name="keywords" content="Requisitos de paga, ascensos y misiones para los usuarios como tambien traslados">
</head>