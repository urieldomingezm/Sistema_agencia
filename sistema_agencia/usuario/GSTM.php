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
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Gestión de Tiempos</h5>
                </div>
                <div class="card-body">
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
            $html .= $this->renderRow($tiempo);
        }

        $html .= '</tbody>
                    </table>
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

            function handleVerTiempo(codigo) {
                Swal.fire({
                    title: 'Tiempo Actual',
                    text: 'Mostrando detalles del tiempo...',
                    icon: 'info',
                    confirmButtonText: 'Aceptar'
                });
            }
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
                text: "Se pausará el tiempo actual",
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
                        text: 'Pausando tiempo...',
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
                                text: 'Tiempo pausado correctamente',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                // Recargar la página para ver los cambios
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: data.message || 'Ocurrió un error al pausar el tiempo',
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

        setupButtonEvents();

        dataTable.on('datatable.page', setupButtonEvents);
        dataTable.on('datatable.sort', setupButtonEvents);
        dataTable.on('datatable.search', setupButtonEvents);
        dataTable.on('datatable.perpage', setupButtonEvents);
    });
</script>