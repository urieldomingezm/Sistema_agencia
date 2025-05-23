<?php

class GestionAscensos
{
    private $ascensos;

    public function __construct()
    {
        require_once(GESTION_ASCENSOS_PATCH . 'mostrar_usuarios.php');
        // Crear una instancia de AscensoManager y obtener los datos directamente
        $database = new Database(); // Esta clase ya está incluida en mostrar_usuarios.php
        $ascensoManager = new AscensoManager($database);
        $this->ascensos = $ascensoManager->getAllAscensos();
    }

    public function renderTable()
    {
        $html = '<div class="container mt-4">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top">
                    <h5 class="mb-0 fw-bold">Gestión de Ascensos</h5>
                    <ul class="nav nav-tabs card-header-tabs mt-2">
                        <li class="nav-item mx-1">
                            <button class="nav-link active bg-dark text-white border-light rounded-top" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" style="opacity: 1; transition: opacity 0.3s;">
                                <i class="bi bi-list-check me-1"></i> Disponibles
                            </button>
                        </li>
                        <li class="nav-item mx-1">
                            <button class="nav-link bg-dark text-white border-light rounded-top" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" style="opacity: 0.6; transition: opacity 0.3s;">
                                <i class="bi bi-check-circle me-1"></i> Ascendidos
                            </button>
                        </li>
                        <li class="nav-item mx-1">
                            <button class="nav-link bg-dark text-white border-light rounded-top" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" style="opacity: 0.6; transition: opacity 0.3s;">
                                <i class="bi bi-clock me-1"></i> Pendientes
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
                        .table {
                            border-collapse: separate;
                            border-spacing: 0;
                        }
                        .table th {
                            background-color: #212529;
                            color: white;
                            font-weight: 500;
                            border-bottom: 2px solid #0d6efd;
                        }
                        .table tbody tr:nth-of-type(odd) {
                            background-color: rgba(0, 0, 0, 0.02);
                        }
                        .table tbody tr:hover {
                            background-color: rgba(13, 110, 253, 0.05);
                        }
                        .table td, .table th {
                            padding: 0.75rem;
                            vertical-align: middle;
                        }
                    </style>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                            <div>
                                <table id="ascensosDisponiblesTable" class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Rango</th>
                                            <th class="text-center">Misión</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Transcurrido</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-top-0">';

        // Array para almacenar los códigos de ascenso ya procesados
        $processedAscensos = [];

        foreach ($this->ascensos as $ascenso) {
            if (strtolower($ascenso['estado_ascenso']) === 'disponible') {
                // Verificar si el ascenso ya fue procesado
                if (!in_array($ascenso['id_ascenso'] ?? $ascenso['codigo_time'], $processedAscensos)) {
                    $html .= $this->renderRow($ascenso);
                    $processedAscensos[] = $ascenso['id_ascenso'] ?? $ascenso['codigo_time'];
                }
            }
        }

        $html .= '</tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <div>
                                <table id="ascensosAscendidosTable" class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Rango</th>
                                            <th class="text-center">Misión</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Transcurrido</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-top-0">';

        foreach ($this->ascensos as $ascenso) {
            if (strtolower($ascenso['estado_ascenso']) === 'completado') {
                $html .= $this->renderRow($ascenso);
            }
        }

        $html .= '</tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab3" role="tabpanel">
                            <div>
                                <table id="ascensosPendientesTable" class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nombre</th>
                                            <th class="text-center">Rango</th>
                                            <th class="text-center">Misión</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Transcurrido</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-top-0">';

        foreach ($this->ascensos as $ascenso) {
            if (strtolower($ascenso['estado_ascenso']) === 'pendiente') {
                $html .= $this->renderRow($ascenso);
            }
        }

        $html .= '</tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light rounded-bottom">
                    <div class="row">
                        <div class="col-12 text-end">
                            <span class="badge bg-info rounded-pill"><i class="bi bi-info-circle me-1"></i> Total registros: ' . count($this->ascensos) . '</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }

    private function renderRow($ascenso)
    {
        $estado = $this->getStatusBadge($ascenso['estado_ascenso']);

        return '<tr>
            <td class="text-center align-middle text-truncate" style="max-width: 100px;">' . htmlspecialchars($ascenso['nombre_habbo']) . '</td>
            <td class="text-center align-middle text-truncate" style="max-width: 100px;">' . htmlspecialchars($ascenso['rango_actual']) . '</td>
            <td class="text-center align-middle text-truncate" style="max-width: 100px;">' . htmlspecialchars($ascenso['mision_actual']) . '</td>
            <td class="text-center align-middle">' . $estado . '</td>
            <td class="text-center align-middle text-truncate" style="max-width: 100px;">' . htmlspecialchars($ascenso['tiempo_ascenso']) . '</td>
        </tr>';
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
            case 'completado':
                $badge_class = 'success';
                $status_text = 'Completado';
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

        return '<span class="badge bg-' . $badge_class . ' rounded-pill"><i class="bi ' . $icon . ' me-1"></i>' . $status_text . '</span>';
    }
}

$gestionAscensos = new GestionAscensos();
echo $gestionAscensos->renderTable();
?>

<script src="/public/assets/custom_general/custom_gestion_ascensos/index_gestion.js"></script>