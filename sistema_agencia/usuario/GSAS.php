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
                    <ul class="nav nav-tabs card-header-tabs mt-2">
                        <li class="nav-item mx-1">
                            <button class="nav-link active bg-dark text-white border-light" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" style="opacity: 1; transition: opacity 0.3s;">
                                <i class="bi bi-list-check me-1"></i> Disponibles
                            </button>
                        </li>
                        <li class="nav-item mx-1">
                            <button class="nav-link bg-dark text-white border-light" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" style="opacity: 0.6; transition: opacity 0.3s;">
                                <i class="bi bi-check-circle me-1"></i> Ascendidos
                            </button>
                        </li>
                        <li class="nav-item mx-1">
                            <button class="nav-link bg-dark text-white border-light" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" style="opacity: 0.6; transition: opacity 0.3s;">
                                <i class="bi bi-clock me-1"></i> Pendientes
                            </button>
                        </li>
                        <li class="nav-item mx-1">
                            <button class="nav-link bg-success text-white border-light" 
                                    id="Ayuda_gestion_ascensos-tab" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#Ayuda_gestion_ascensos" 
                                    type="button" 
                                    style="opacity: 0.6; transition: opacity 0.3s;">
                                <i class="bi bi-question-circle-fill me-1"></i> Ayuda
                            </button>
                        </li>
                    </ul>
                    <style>
                        .nav-link.active {
                            opacity: 1 !important;
                        }
                        .nav-link:not(.active) {
                            opacity: 0.6 !important;
                        }
                        .nav-link:hover {
                            opacity: 0.8 !important;
                        }
                    </style>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                            <div class="table-responsive">
                                <table id="ascensosDisponiblesTable" class="table table-striped table-bordered align-middle mb-0" style="width:100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">Usuario</th>
                                            <th class="text-center">Rango</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Próximo Ascenso</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

        $processedAscensos = [];
        foreach ($this->ascensos as $ascenso) {
            if (strtolower($ascenso['estado_ascenso']) === 'disponible' && !in_array($ascenso['id_ascenso'] ?? $ascenso['codigo_time'], $processedAscensos)) {
                $html .= $this->renderRow($ascenso, true);
                $processedAscensos[] = $ascenso['id_ascenso'] ?? $ascenso['codigo_time'];
            }
        }

        $html .= '</tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <div class="table-responsive">
                                <table id="ascensosAscendidosTable" class="table table-striped table-bordered align-middle mb-0" style="width:100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">Usuario</th>
                                            <th class="text-center">Rango</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Proximo ascenso</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

        foreach ($this->ascensos as $ascenso) {
            if (strtolower($ascenso['estado_ascenso']) === 'ascendido') {
                $html .= $this->renderRow($ascenso, false);
            }
        }

        $html .= '</tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab3" role="tabpanel">
                            <div class="table-responsive">
                                <table id="ascensosPendientesTable" class="table table-striped table-bordered align-middle mb-0" style="width:100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">Usuario</th>
                                            <th class="text-center">Rango</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Proximo ascenso</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

        foreach ($this->ascensos as $ascenso) {
            if (strtolower($ascenso['estado_ascenso']) === 'pendiente') {
                $html .= $this->renderRow($ascenso, false);
            }
        }

        $html .= '</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="row">
                        <div class="col-12 text-end">
                            <span class="badge bg-info"><i class="bi bi-info-circle me-1"></i> Total registros: ' . count($this->ascensos) . '</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }

    private function renderRow($ascenso, $isDisponible)
    {
        $estado = $this->getStatusBadge($ascenso['estado_ascenso']);
        $codigo = $ascenso['id_ascenso'] ?? $ascenso['codigo_time'];
        // Determine the correct date field based on status
        // Changed back to fecha_ultimo_ascenso for available ascensos
        $fechaCampo = $isDisponible ? 'fecha_ultimo_ascenso' : ($ascenso['estado_ascenso'] === 'ascendido' ? 'fecha_ascenso' : 'fecha_pospuesto');

        // Determine badge style based on rank
        $badgeStyle = '';
        switch ($ascenso['rango_actual']) {
            case 'Agente':
                $badgeStyle = 'background-color: #f8f9fa; color: #212529; border: 1px solid #dee2e6;'; // White with black/grey text
                break;
            case 'Seguridad':
                $badgeStyle = 'background-color: #212529; color: #f8f9fa;'; // Black with white text
                break;
            case 'Técnico':
                $badgeStyle = 'background-color: #6f42c1; color: #f8f9fa;'; // Purple with white text (using a Bootstrap purple)
                break;
            case 'Logística':
                $badgeStyle = 'background-color: #6610f2; color: #f8f9fa;'; // Another purple option
                break;
            case 'Supervisor':
                $badgeStyle = 'background-color: #6c757d; color: #f8f9fa;'; // Grey with white text
                break;
            case 'Director':
                $badgeStyle = 'background-color: #dc3545; color: #f8f9fa;'; // Red with white text
                break;
            case 'Presidente':
                $badgeStyle = 'background-color: #0d6efd; color: #f8f9fa;'; // Blue with white text
                break;
            case 'Operativo':
                $badgeStyle = 'background-color: #ffc107; color: #212529;'; // Yellow with black text
                break;
            case 'Junta directiva':
                $badgeStyle = 'background-color: #198754; color: #f8f9fa;'; // Green with white text
                break;
            default:
                $badgeStyle = 'background-color: #6c757d; color: #f8f9fa;'; // Default grey with white
        }

        // Format the date/time based on the field
        $formattedDate = 'N/A';
        if (!empty($ascenso[$fechaCampo])) {
            // Use existing formatDate for all date fields now
            $formattedDate = $this->formatDate($ascenso[$fechaCampo]);
        }

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
            <td class="text-center align-middle">' . $formattedDate . '</td>
            <td class="text-center align-middle">' . $this->renderActions($ascenso, $isDisponible) . '</td>
        </tr>';
    }

    private function renderActions($ascenso, $isDisponible)
    {
        $codigo = $ascenso['id_ascenso'] ?? $ascenso['codigo_time'];
        $actions = '<div class="btn-group btn-group-sm" role="group">';

        if ($isDisponible) {
            $actions .= '
                <button class="btn btn-success ascender-btn" data-id="' . $codigo . '" title="Ascender">
                    <i class="bi bi-arrow-up-circle-fill"></i>
                </button>
                <button class="btn btn-warning posponer-btn" data-id="' . $codigo . '" title="Posponer">
                    <i class="bi bi-clock-fill"></i>
                </button>';
        } else {
            $actions .= '
                <button class="btn btn-primary detalles-btn" data-id="' . $codigo . '" title="Detalles">
                    <i class="bi bi-info-circle-fill"></i>
                </button>';
        }

        $actions .= '</div>';
        return $actions;
    }

    private function getStatusBadge($status)
    {
        $status = strtolower($status);
        $badge_class = '';
        $status_text = '';
        $icon = '';

        switch ($status) {
            case 'pendiente':
                $badge_class = 'warning';
                $status_text = 'Pendiente';
                $icon = 'bi-clock';
                break;
            case 'ascendido':
                $badge_class = 'success';
                $status_text = 'Ascendido';
                $icon = 'bi-check-circle';
                break;
            case 'disponible':
                $badge_class = 'primary';
                $status_text = 'Disponible';
                $icon = 'bi-list-check';
                break;
            default:
                $badge_class = 'secondary';
                $status_text = ucfirst($status);
                $icon = 'bi-question-circle';
        }

        return '<span class="badge bg-' . $badge_class . '"><i class="bi ' . $icon . ' me-1"></i>' . $status_text . '</span>';
    }

    private function formatDate($date)
    {
        if (!empty($date)) {
            return date('d/m/Y H:i', strtotime($date));
        }
        return 'N/A';
    }
}

$gestionAscensos = new GestionAscensos();
echo $gestionAscensos->renderTable();
?>

<!-- JavaScript para la gestión de ascensos -->
<script src="/public/assets/custom_general/custom_gestion_ascensos/index_gestion.js"></script>