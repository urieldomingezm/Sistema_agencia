<?php

class GestionTiempos {
    private $tiempos;

    public function __construct() {
        require_once(GESTION_TIEMPO_PATCH . 'mostrar_usuarios.php');
        $this->tiempos = $GLOBALS['tiempos'];
    }

    public function renderTable() {
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
                                <thead>
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
            if ($tiempo['tiempo_status'] === 'activo') {
                $html .= $this->renderRow($tiempo);
            }
        }

        $html .= '</tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <table id="datatable_tiempos_inactivos" class="table table-bordered table-striped table-hover text-center mb-0">
                                <thead>
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
                                <thead>
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

    private function renderRow($tiempo) {
        $status = $this->getStatusBadge($tiempo['tiempo_status']);
        
        return '<tr>
            <td>'.$tiempo['habbo_name'].'</td>
            <td>'.$status.'</td>
            <td>'.$tiempo['tiempo_restado'].'</td>
            <td>'.$tiempo['tiempo_acumulado'].'</td>
            <td>'.$tiempo['tiempo_iniciado'].'</td>
            <td>'.($tiempo['tiempo_encargado_usuario'] ?? 'No disponible').'</td>
            <td>'.$this->renderActions($tiempo).'</td>
        </tr>';
    }

    private function getStatusBadge($status) {
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

        return '<span class="badge bg-'.$badge_class.'">'.$status_text.'</span>';
    }

    private function renderActions($tiempo) {
        $status = strtolower($tiempo['tiempo_status']);
        $actions = '';

        if ($status === 'pausa' && !empty($tiempo['tiempo_encargado_usuario'])) {
            $actions .= '<button class="btn btn-sm btn-danger liberar-encargado" data-codigo="'.$tiempo['codigo_time'].'">
                <i class="bi bi-person-x-fill"></i> Liberar Tiempo
            </button>';
        } elseif (!empty($tiempo['tiempo_encargado_usuario']) && $status !== 'pausa') {
            $actions .= '<button class="btn btn-sm btn-warning pausar-tiempo" data-codigo="'.$tiempo['codigo_time'].'">
                <i class="bi bi-pause-fill"></i> Pausar
            </button>
            <button class="btn btn-sm btn-success designar-tiempo" data-codigo="'.$tiempo['codigo_time'].'">
                <i class="bi bi-person-plus-fill"></i> Designar
            </button>
            <button class="btn btn-sm btn-info ver-tiempo" data-codigo="'.$tiempo['codigo_time'].'">
                <i class="bi bi-clock-fill"></i> Ver Tiempo
            </button>';
        }

        return $actions;
    }
}

$gestionTiempos = new GestionTiempos();
echo $gestionTiempos->renderTable();
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Configuración para la tabla principal
        const dataTable = new simpleDatatables.DataTable("#datatable_tiempos", {
            searchable: true,
            fixedHeight: true,
            labels: {
                placeholder: "Buscar...",
                perPage: "Registros por página",
                noRows: "No hay registros",
                info: "Mostrando {start} a {end} de {rows} registros",
            }
        });

        // Configuración para la tabla de tiempos inactivos
        const dataTableInactivos = new simpleDatatables.DataTable("#datatable_tiempos_inactivos", {
            searchable: true,
            labels: {
                placeholder: "Buscar...",
                perPage: "Registros por página",
                noRows: "No hay registros",
                info: "Mostrando {start} a {end} de {rows} registros",
            }
        });

        // Configuración para la tabla de tiempos completados
        const dataTableCompletados = new simpleDatatables.DataTable("#datatable_tiempos_completados", {
            searchable: true,
            labels: {
                placeholder: "Buscar...",
                perPage: "Registros por página",
                noRows: "No hay registros",
                info: "Mostrando {start} a {end} de {rows} registros",
            }
        });

        function setupButtonEvents() {
            document.querySelectorAll('.liberar-encargado').forEach(button => {
                button.addEventListener('click', function() {
                    const codigo = this.getAttribute('data-codigo');
                    handleLiberarEncargado(codigo);
                });
            });

            document.querySelectorAll('.pausar-tiempo').forEach(button => {
                button.addEventListener('click', function() {
                    const codigo = this.getAttribute('data-codigo');
                    handlePausarTiempo(codigo);
                });
            });

            document.querySelectorAll('.ver-tiempo').forEach(button => {
                button.addEventListener('click', function() {
                    const codigo = this.getAttribute('data-codigo');
                    handleVerTiempo(codigo);
                });
            });

            document.querySelectorAll('.designar-tiempo').forEach(button => {
                button.addEventListener('click', function() {
                    const codigo = this.getAttribute('data-codigo');
                    handleDesignarTiempo(codigo);
                });
            });

            function handleDesignarTiempo(codigo) {
                Swal.fire({
                    title: 'Designar Tiempo',
                    html: `
                        <select id="usuarioDesignado" class="form-select">
                            <option value="">Seleccionar usuario</option>
                        </select>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Designar',
                    cancelButtonText: 'Cancelar',
                    didOpen: () => {
                        fetch('/private/procesos/gestion_tiempos/usuarios_select.php')
                            .then(response => response.json())
                            .then(data => {
                                const select = document.getElementById('usuarioDesignado');
                                if (data.success) {
                                    data.data.forEach(usuario => {
                                        const option = document.createElement('option');
                                        option.value = usuario.id;
                                        option.textContent = `${usuario.nombre_habbo} (${usuario.rol_nombre})`;
                                        select.appendChild(option);
                                    });
                                } else {
                                    Swal.showValidationMessage(data.message);
                                }
                            });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const usuarioDesignado = document.getElementById('usuarioDesignado').value;
                        if (usuarioDesignado) {
                            fetch('/private/procesos/gestion_tiempos/procesar_tiempo.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: 'accion=designar_tiempo&codigo_time=' + encodeURIComponent(codigo) + '&usuario_designado=' + encodeURIComponent(usuarioDesignado)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('¡Éxito!', 'Tiempo designado correctamente', 'success').then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire('Error', data.message || 'Error al designar el tiempo', 'error');
                                }
                            });
                        }
                    }
                });
            }
        }

        function handleVerTiempo(codigo) {
            fetch('/private/procesos/gestion_tiempos/procesar_tiempo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'accion=ver_tiempo&codigo_time=' + encodeURIComponent(codigo)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Tiempo Acumulado',
                        html: '<div style="text-align: center;">' +
                              '<b>Tiempo acumulado:</b> ' + data.tiempo_acumulado + '<br>' +
                              '<b>Tiempo transcurrido:</b> ' + data.tiempo_transcurrido + '<br>' +
                              '<b>Total:</b> ' + data.tiempo_total +
                              '</div>',
                        icon: 'info',
                        confirmButtonText: 'Aceptar'
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'Error al obtener el tiempo',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error de conexión',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
        }
        function handleLiberarEncargado(codigo) {
 
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se liberará el Tiempo actual para que otra persona pueda tomar el tiempo",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, liberar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
   
                    Swal.fire({
                        title: 'Procesando',
                        text: 'Liberando encargado...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch('/private/procesos/gestion_tiempos/procesar_tiempo.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'accion=liberar_encargado&codigo_time=' + encodeURIComponent(codigo)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '¡Éxito!',
                                text: 'Encargado liberado correctamente',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: data.message || 'Ocurrió un error al liberar al encargado',
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error de conexión',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    });
                }
            });
        }

        function handlePausarTiempo(codigo) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se pausará el tiempo actual y se liberará para que otra persona pueda tomar el tiempo",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, pausar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Procesando',
                        text: 'Pausando y liberando tiempo...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch('/private/procesos/gestion_tiempos/procesar_tiempo.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'accion=pausar_tiempo&codigo_time=' + encodeURIComponent(codigo)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: '¡Éxito!',
                                text: 'Tiempo pausado y liberado correctamente',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: data.message || 'Ocurrió un error al pausar y liberar el tiempo',
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un error de conexión',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    });
                }
            });
        }

        // Configurar eventos para todas las tablas
        function setupTableEvents(table) {
            table.on('datatable.page', setupButtonEvents);
            table.on('datatable.sort', setupButtonEvents);
            table.on('datatable.search', setupButtonEvents);
            table.on('datatable.perpage', setupButtonEvents);
        }

        // Aplicar eventos a todas las tablas
        setupTableEvents(dataTable);
        setupTableEvents(dataTableInactivos);
        setupTableEvents(dataTableCompletados);

        setupButtonEvents();
    });
</script>
