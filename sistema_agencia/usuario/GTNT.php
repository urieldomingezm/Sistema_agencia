<?php

class GestionNotificaciones {
    private $notificaciones;

    public function __construct() {
        require_once(PROCESOS_NOTIFICACIONES_PACTH . 'mostrar_notificaciones.php');
        
        $notificacionManager = new NotificacionManager();
        $response = $notificacionManager->obtenerNotificaciones();
        $this->notificaciones = $response['data'] ?? [];
    }

    public function renderTable() {
        $html = '<div class="container-fluid mt-4">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-bell me-2"></i>Gestión de Notificaciones</h5>
                    <ul class="nav nav-tabs card-header-tabs mt-2">
                        <li class="nav-item mx-1">
                            <button class="nav-link active bg-dark text-white border-light" id="todas-tab" data-bs-toggle="tab" data-bs-target="#todas" type="button">
                                <i class="bi bi-bell-fill me-1"></i> Todas
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="todas" role="tabpanel">
                            <div class="table-responsive">
                                <table id="datatable_notificaciones" class="table table-striped table-bordered align-middle mb-0" style="width:100%">
                                    <thead class="table-dark">
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Mensaje</th>
                                            <th class="text-center">Fecha Registro</th>
                                            <th class="text-center">Usuario</th>
                                            <th class="text-center">Encargado de envio</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>';

        foreach ($this->notificaciones as $notificacion) {
            $html .= $this->renderRow($notificacion);
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
                            <span class="badge bg-info"><i class="bi bi-info-circle me-1"></i> Total notificaciones: ' . count($this->notificaciones) . '</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }

    private function renderRow($notificacion) {
        return '<tr>
            <td class="text-center align-middle">' . htmlspecialchars($notificacion['notificacion_id']) . '</td>
            <td class="text-start align-middle">' . htmlspecialchars($notificacion['notificacion_mensaje']) . '</td>
            <td class="text-center align-middle">' . $this->formatDate($notificacion['notificacion_registro']) . '</td>
            <td class="text-center align-middle">
                <span class="badge bg-primary" title="ID: ' . htmlspecialchars($notificacion['usuario_id']) . '">' . 
                    htmlspecialchars($notificacion['usuario_registro']) . 
                '</span>
            </td>
            <td class="text-center align-middle">
                ' . ($notificacion['encargado_nombre'] ? 
                     '<span class="badge bg-success" title="ID: ' . htmlspecialchars($notificacion['id_encargado']) . '">' . 
                     htmlspecialchars($notificacion['encargado_nombre']) . '</span>' : 
                     '<span class="badge bg-secondary">No asignado</span>') . '
            </td>
            <td class="text-center align-middle">' . $this->renderActions($notificacion) . '</td>
        </tr>';
    }

    private function formatDate($date) {
        if (!empty($date)) {
            return date('d/m/Y H:i', strtotime($date));
        }
        return 'N/A';
    }

    private function renderActions($notificacion) {
        return '<div class="btn-group btn-group-sm" role="group">
            <button class="btn btn-danger eliminar-notificacion" data-id="' . $notificacion['notificacion_id'] . '" title="Eliminar">
                <i class="bi bi-trash-fill"></i>
            </button>
        </div>';
    }
}

$gestionNotificaciones = new GestionNotificaciones();
echo $gestionNotificaciones->renderTable();
?>

<script src="/public/assets/custom_general/custom_gestion_notificaciones/index_gestion.js"></script>