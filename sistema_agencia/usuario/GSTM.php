<?php

class GestionTiempos
{
    private $tiempos;

    public function __construct()
    {
        require_once(GESTION_TIEMPO_PATCH . 'mostrar_usuarios.php');
        $this->tiempos = $GLOBALS['tiempos'];
    }

    public function renderTable()
    {
        $html = '<div class="container mt-4">
            <div class="card shadow">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Gestión de Tiempos</h5>
                    <ul class="nav nav-tabs card-header-tabs mt-2">
                        <li class="nav-item mx-1">
                            <button class="nav-link active bg-dark text-white border-light" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" style="opacity: 1; transition: opacity 0.3s;">Iniciados</button>
                        </li>
                        <li class="nav-item mx-1">
                            <button class="nav-link bg-dark text-white border-light" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" style="opacity: 0.6; transition: opacity 0.3s;">Inactivos / Pausados</button>
                        </li>
                        <li class="nav-item mx-1">
                            <button class="nav-link bg-dark text-white border-light" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" style="opacity: 0.6; transition: opacity 0.3s;">Completados</button>
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
                            <table id="datatable_tiempos" class="table table-bordered table-striped table-hover text-center mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Estado</th>
                                        <th>Restado</th>
                                        <th>Acumulado</th>
                                        <th>Iniciado</th>
                                        <th>Encargado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';

        // Array para almacenar los códigos de tiempo ya procesados
        $processedTimes = [];

        foreach ($this->tiempos as $tiempo) {
            if ($tiempo['tiempo_status'] === 'activo') {
                // Verificar si el tiempo ya fue procesado
                if (!in_array($tiempo['codigo_time'], $processedTimes)) {
                    $html .= $this->renderRow($tiempo);
                    $processedTimes[] = $tiempo['codigo_time'];
                }
            }
        }

        $html .= '</tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <table id="datatable_tiempos_inactivos" class="table table-bordered table-striped table-hover text-center mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Estado</th>
                                        <th>Restado</th>
                                        <th>Acumulado</th>
                                        <th>Iniciado</th>
                                        <th>Encargado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';

        foreach ($this->tiempos as $tiempo) {
            if ($tiempo['tiempo_status'] === 'inactivo' || $tiempo['tiempo_status'] === 'pausa') {
                $html .= $this->renderRow($tiempo);
            }
        }

        $html .= '</tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab3" role="tabpanel">
                            <table id="datatable_tiempos_completados" class="table table-bordered table-striped table-hover text-center mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Estado</th>
                                        <th>Restado</th>
                                        <th>Acumulado</th>
                                        <th>Iniciado</th>
                                        <th>Encargado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>';

        foreach ($this->tiempos as $tiempo) {
            if ($tiempo['tiempo_status'] === 'completado') {
                $html .= $this->renderRow($tiempo);
            }
        }

        $html .= '</tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }

    private function renderRow($tiempo)
    {
        $status = $this->getStatusBadge($tiempo['tiempo_status']);

        return '<tr>
            <td>' . $tiempo['habbo_name'] . '</td>
            <td>' . $status . '</td>
            <td>' . $tiempo['tiempo_restado'] . '</td>
            <td>' . $tiempo['tiempo_acumulado'] . '</td>
            <td>' . $tiempo['tiempo_iniciado'] . '</td>
            <td>' . ($tiempo['tiempo_encargado_usuario'] ?? 'No disponible') . '</td>
            <td>' . $this->renderActions($tiempo) . '</td>
        </tr>';
    }

    private function getStatusBadge($status)
    {
        $status = strtolower($status);
        $badge_class = '';
        $status_text = '';

        switch ($status) {
            case 'pausa':
                $badge_class = 'warning';
                $status_text = 'Pausa';
                break;
            case 'completado':
                $badge_class = 'success';
                $status_text = 'Completado';
                break;
            case 'ausente':
                $badge_class = 'danger';
                $status_text = 'Ausente';
                break;
            case 'terminado':
                $badge_class = 'info';
                $status_text = 'Terminado';
                break;
            case 'activo':
                $badge_class = 'success';
                $status_text = 'Activo';
                break;
            default:
                $badge_class = 'secondary';
                $status_text = $status;
        }

        return '<span class="badge bg-' . $badge_class . '">' . $status_text . '</span>';
    }

    private function renderActions($tiempo)
    {
        $status = strtolower($tiempo['tiempo_status']);
        $actions = '';

        if ($status === 'pausa' || $status === 'inactivo') {
            $actions .= '
                <div class="btn-group" role="group">
                    <button class="btn btn-sm btn-success me-1 completar-tiempo" data-codigo="' . $tiempo['codigo_time'] . '">
                        <i class="bi bi-check-lg"></i>
                    </button>
                </div>';
        } elseif (!empty($tiempo['tiempo_encargado_usuario']) && $status !== 'pausa') {
            $actions .= '
                <div class="btn-group" role="group">
                    <button class="btn btn-sm btn-warning me-1 pausar-tiempo" data-codigo="' . $tiempo['codigo_time'] . '" title="Pausar">
                        <i class="bi bi-pause-fill"></i>
                    </button>
                    <button class="btn btn-sm btn-success me-1 designar-tiempo" data-codigo="' . $tiempo['codigo_time'] . '" title="Designar">
                        <i class="bi bi-person-plus-fill"></i>
                    </button>
                    <button class="btn btn-sm btn-info me-1 ver-tiempo" data-codigo="' . $tiempo['codigo_time'] . '" title="Ver Tiempo">
                        <i class="bi bi-clock-fill"></i>
                    </button>
                </div>';
        }

        return $actions;
    }
}

$gestionTiempos = new GestionTiempos();
echo $gestionTiempos->renderTable();
?>
<script src="/public/assets/custom_general/custom_gestion_tiempos/index_gestion.js"></script>