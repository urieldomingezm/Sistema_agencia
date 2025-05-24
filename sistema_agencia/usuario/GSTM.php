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
        // Incluir el archivo del modal aquí, dentro del método que lo necesita
        require_once(MODAL_AYUDA_TIEMPO_PACH . 'ayuda_gestion_times.php');

        $html = '<div class="container-fluid mt-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Gestión de Tiempos</h5>
<ul class="nav nav-tabs card-header-tabs mt-2">
    <li class="nav-item mx-1">
        <button class="nav-link active bg-dark text-white border-light" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button">
            <i class="bi bi-play-circle me-1"></i> Iniciados
        </button>
    </li>
    <li class="nav-item mx-1">
        <button class="nav-link bg-dark text-white border-light" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button">
            <i class="bi bi-pause-circle me-1"></i> Pausados
        </button>
    </li>
    <li class="nav-item mx-1">
        <button class="nav-link bg-dark text-white border-light" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button">
            <i class="bi bi-check-circle me-1"></i> Completados
        </button>
    </li>
    <li class="nav-item mx-1">
        <button class="nav-link bg-success text-white border-light rounded-circle p-1" 
                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                id="Ayuda_gestion_times-tab" 
                data-bs-toggle="modal" 
                data-bs-target="#Ayuda_gestion_times" 
                type="button">
            <i class="bi bi-question-circle-fill"></i>
        </button>
    </li>
    <li class="nav-item mx-1">
        <button class="nav-link bg-warning text-white border-light rounded-circle p-1" 
                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                type="button">
            <i class="bi bi-arrow-clockwise"></i>
        </button>
    </li>
    
</ul>
                </div>
                <div class="card-body">
                    
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                            <div class="table-responsive">
                                <table id="datatable_tiempos" class="table table-striped table-bordered align-middle mb-0" style="width:100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">Usuario</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Restante</th>
                                            <th class="text-center">Acumulado</th>
                                            <th class="text-center">Iniciado</th>
                                            <th class="text-center">Encargado</th>
                                            <th class="text-center">Acciones</th>
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
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <div class="table-responsive">
                                <table id="datatable_tiempos_inactivos" class="table table-striped table-bordered align-middle mb-0" style="width:100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">Usuario</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Restante</th>
                                            <th class="text-center">Acumulado</th>
                                            <th class="text-center">Iniciado</th>
                                            <th class="text-center">Encargado</th>
                                            <th class="text-center">Acciones</th>
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
                        </div>
                        <div class="tab-pane fade" id="tab3" role="tabpanel">
                            <div class="table-responsive">
                                <table id="datatable_tiempos_completados" class="table table-striped table-bordered align-middle mb-0" style="width:100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">Usuario</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Restante</th>
                                            <th class="text-center">Acumulado</th>
                                            <th class="text-center">Iniciado</th>
                                            <th class="text-center">Encargado</th>
                                            <th class="text-center">Acciones</th>
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
                <div class="card-footer bg-light">
                    <div class="row">
                        <div class="col-12 text-end">
                            <span class="badge bg-info"><i class="bi bi-info-circle me-1"></i> Total registros: ' . count($this->tiempos) . '</span>
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
        $restante = $this->formatTime($tiempo['tiempo_restado']);
        $acumulado = $this->formatTime($tiempo['tiempo_acumulado']);
        // Assuming tiempo_iniciado is a TIME string (HH:MM:SS)
        // Display the time directly, or 'N/A' if empty
        $iniciado_display = !empty($tiempo['tiempo_iniciado']) ? $tiempo['tiempo_iniciado'] : 'N/A';

        return '<tr>
            <td class="text-start align-middle">
                <div class="d-flex align-items-center">
                    <img loading="lazy" class="me-2 rounded-circle" src="https://www.habbo.es/habbo-imaging/avatarimage?user=' . urlencode($tiempo['habbo_name']) . '&amp;headonly=1&amp;head_direction=3&amp;size=m" alt="' . htmlspecialchars($tiempo['habbo_name']) . '" title="' . htmlspecialchars($tiempo['habbo_name']) . '" width="40" height="40">
                    <div>
                        <span class="fw-semibold" style="word-break: break-word;">' . htmlspecialchars($tiempo['habbo_name']) . '</span><br>
                        <small class="text-muted">ID: ' . htmlspecialchars($tiempo['codigo_time']) . '</small>
                    </div>
                </div>
            </td>
            <td class="text-center align-middle">' . $status . '</td>
            <td class="text-center align-middle fw-bold">' . $restante . '</td>
            <td class="text-center align-middle">' . $acumulado . '</td>
            <td class="text-center align-middle">' . $iniciado_display . '</td>
            <td class="text-center align-middle">
                ' . ($tiempo['tiempo_encargado_usuario'] ? '<span class="badge bg-primary">' . htmlspecialchars($tiempo['tiempo_encargado_usuario']) . '</span>' : '<span class="badge bg-secondary">No asignado</span>') . '
            </td>
            <td class="text-center align-middle">' . $this->renderActions($tiempo) . '</td>
        </tr>';
    }

    private function formatTime($time)
    {
        // Formatear el tiempo para mostrarlo mejor (puedes personalizar esto)
        return $time; // o implementar lógica de formateo
    }

    private function formatDate($date)
    {
        // Formatear la fecha para mostrarla mejor (puedes personalizar esto)
        // Check if $date is not null or empty before formatting
        if (!empty($date)) {
            return date('d/m/Y H:i', strtotime($date));
        } else {
            return 'N/A'; // Or return an empty string ''
        }
    }

    private function getStatusBadge($status)
    {
        $status = strtolower($status);
        $badge_class = '';
        $status_text = '';
        $icon = '';

        switch ($status) {
            case 'pausa':
                $badge_class = 'warning';
                $status_text = 'Pausa';
                $icon = 'bi-pause-circle';
                break;
            case 'completado':
                $badge_class = 'success';
                $status_text = 'Completado';
                $icon = 'bi-check-circle';
                break;
            case 'ausente':
                $badge_class = 'danger';
                $status_text = 'Ausente';
                $icon = 'bi-exclamation-circle';
                break;
            case 'terminado':
                $badge_class = 'info';
                $status_text = 'Terminado';
                $icon = 'bi-stop-circle';
                break;
            case 'activo':
                $badge_class = 'success';
                $status_text = 'Activo';
                $icon = 'bi-play-circle';
                break;
            default:
                $badge_class = 'secondary';
                $status_text = $status;
                $icon = 'bi-question-circle';
        }

        return '<span class="badge bg-' . $badge_class . '"><i class="bi ' . $icon . ' me-1"></i>' . $status_text . '</span>';
    }

    private function renderActions($tiempo)
    {
        $status = strtolower($tiempo['tiempo_status']);
        $actions = '';

        if ($status === 'pausa' || $status === 'inactivo') {
            $actions .= '
                <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-success completar-tiempo" data-codigo="' . $tiempo['codigo_time'] . '" title="Completar">
                        <i class="bi bi-check-circle-fill"></i>
                    </button>
                </div>';
        } elseif (!empty($tiempo['tiempo_encargado_usuario']) && $status !== 'pausa') {
            $actions .= '
                <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-warning pausar-tiempo" data-codigo="' . $tiempo['codigo_time'] . '" title="Pausar">
                        <i class="bi bi-pause-fill"></i>
                    </button>
                    <button class="btn btn-danger designar-tiempo" data-codigo="' . $tiempo['codigo_time'] . '" title="Designar">
                        <i class="bi bi-person-plus-fill"></i>
                    </button>
                    <button class="btn btn-info ver-tiempo" data-codigo="' . $tiempo['codigo_time'] . '" title="Detalles">
                        <i class="bi bi-clock-fill"></i>
                    </button>
                </div>';
        } elseif ($status === 'completado') {
            $actions .= '
                <button class="btn btn-sm btn-outline-secondary" title="No hay acciones disponibles" disabled>
                    <i class="bi bi-lock-fill"></i>
                </button>';
        }

        return $actions;
    }
}

$gestionTiempos = new GestionTiempos();
echo $gestionTiempos->renderTable();
?>

<script src="/public/assets/custom_general/custom_gestion_tiempos/index_gestion.js"></script>