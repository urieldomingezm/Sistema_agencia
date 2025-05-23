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
                        .action-btn {
                            padding: 0.25rem 0.5rem;
                            font-size: 0.75rem;
                            margin: 0 0.1rem;
                        }
                        .action-btn i {
                            font-size: 0.8rem;
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
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Próximo ascenso</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-top-0">';

        // Array para almacenar los códigos de ascenso ya procesados
        $processedAscensos = [];

        foreach ($this->ascensos as $ascenso) {
            if (strtolower($ascenso['estado_ascenso']) === 'disponible') {
                // Verificar si el ascenso ya fue procesado
                if (!in_array($ascenso['id_ascenso'] ?? $ascenso['codigo_time'], $processedAscensos)) {
                    $html .= $this->renderRow($ascenso, true);
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
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Transcurrido</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-top-0">';

        foreach ($this->ascensos as $ascenso) {
            if (strtolower($ascenso['estado_ascenso']) === 'completado') {
                $html .= $this->renderRow($ascenso, false);
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
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Transcurrido</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-top-0">';

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

    private function renderRow($ascenso, $isDisponible)
    {
        $estado = $this->getStatusBadge($ascenso['estado_ascenso']);
        $codigo = $ascenso['id_ascenso'] ?? $ascenso['codigo_time'];
        
        // Botones de acción según el estado
        $acciones = '<div class="d-flex justify-content-center">';
        
        if ($isDisponible) {
            $acciones .= '<button type="button" class="btn btn-success action-btn ascender-btn" data-id="' . $codigo . '" title="Ascender">
                            <i class="bi bi-arrow-up-circle"></i>
                        </button>
                        <button type="button" class="btn btn-warning action-btn posponer-btn" data-id="' . $codigo . '" title="Posponer">
                            <i class="bi bi-clock-history"></i>
                        </button>';
        } else {
            $acciones .= '<button type="button" class="btn btn-primary action-btn detalles-btn" data-id="' . $codigo . '" title="Ver detalles">
                            <i class="bi bi-info-circle"></i>
                        </button>';
        }
        
        $acciones .= '</div>';

        return '<tr>
            <td class="text-center align-middle text-truncate" style="max-width: 100px;">' . htmlspecialchars($ascenso['nombre_habbo']) . '</td>
            <td class="text-center align-middle text-truncate" style="max-width: 100px;">' . htmlspecialchars($ascenso['rango_actual']) . '</td>
            <td class="text-center align-middle">' . $estado . '</td>
            <td class="text-center align-middle text-truncate" style="max-width: 100px;">' . htmlspecialchars($ascenso['tiempo_ascenso']) . '</td>
            <td class="text-center align-middle">' . $acciones . '</td>
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

<script>
// Script para manejar las acciones de los botones
$(document).ready(function() {
    // Botón de ascender
    $(document).on('click', '.ascender-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: '¿Confirmar ascenso?',
            text: "Vas a procesar este ascenso",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, ascender',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí iría la lógica para procesar el ascenso
                Swal.fire('¡Ascendido!', 'El usuario ha sido ascendido correctamente.', 'success');
            }
        });
    });

    // Botón de posponer
    $(document).on('click', '.posponer-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'Posponer ascenso',
            text: "Indica el motivo para posponer este ascenso",
            input: 'textarea',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Posponer',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí iría la lógica para posponer el ascenso
                Swal.fire('Pospuesto', 'El ascenso ha sido pospuesto.', 'info');
            }
        });
    });

    // Botón de ver detalles
    $(document).on('click', '.detalles-btn', function() {
        const id = $(this).data('id');
        // Aquí iría la lógica para mostrar los detalles
        Swal.fire({
            title: 'Detalles del ascenso',
            html: '<div class="text-start"><p><strong>ID:</strong> ' + id + '</p>' +
                  '<p><strong>Fecha de procesamiento:</strong> 01/01/2023</p>' +
                  '<p><strong>Procesado por:</strong> Admin</p>' +
                  '<p><strong>Observaciones:</strong> Ascenso completado correctamente</p></div>',
            icon: 'info',
            confirmButtonText: 'Cerrar'
        });
    });

    // Botón de eliminar
    $(document).on('click', '.eliminar-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede revertir",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí iría la lógica para eliminar
                Swal.fire('¡Eliminado!', 'El registro ha sido eliminado.', 'success');
            }
        });
    });
});
</script>