<?php

// Rutas para gestion de tiempos
require_once(GESTION_TIEMPO_PATCH . 'mostrar_usuarios.php');
?>

<div class="container mt-4">
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
                <tbody>
                    <?php foreach ($GLOBALS['tiempos'] as $tiempo): ?>
                        <tr>
                            <td><?= $tiempo['habbo_name'] ?></td>
                            <td>
                                <?php
                                $status = $tiempo['tiempo_status'];
                                $badge_class = '';
                                $status_text = '';

                                switch (strtolower($status)) {
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
                                ?>
                                <span class="badge bg-<?= $badge_class ?>"><?= $status_text ?></span>
                            </td>
                            <td><?= $tiempo['tiempo_restado'] ?></td>
                            <td><?= $tiempo['tiempo_acumulado'] ?></td>
                            <td><?= $tiempo['tiempo_iniciado'] ?></td>
                            <td><?= $tiempo['tiempo_encargado_usuario'] ?? 'No disponible' ?></td>
                            <td>
                                <?php if (strtolower($status) === 'pausa' && !empty($tiempo['tiempo_encargado_usuario'])): ?>
                                    <button class="btn btn-sm btn-danger liberar-encargado" data-codigo="<?= $tiempo['codigo_time'] ?>">
                                        <i class="bi bi-person-x-fill"></i> Liberar encargado
                                    </button>
                                <?php elseif (!empty($tiempo['tiempo_encargado_usuario']) && strtolower($status) !== 'pausa'): ?>
                                    <button class="btn btn-sm btn-warning pausar-tiempo" data-codigo="<?= $tiempo['codigo_time'] ?>">
                                        <i class="bi bi-pause-fill"></i> Pausar
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTable
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

        // Agregar evento para liberar encargado
        document.querySelectorAll('.liberar-encargado').forEach(button => {
            button.addEventListener('click', function() {
                const codigo = this.getAttribute('data-codigo');
                
                // Confirmar antes de liberar
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Se liberará al encargado actual para que otra persona pueda tomar el tiempo",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, liberar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mostrar cargando
                        Swal.fire({
                            title: 'Procesando',
                            text: 'Liberando encargado...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Enviar solicitud para liberar encargado
                        fetch('/usuario/procesar_tiempo.php', {
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
                                    // Recargar la página para ver los cambios
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
            });
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar DataTable
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

        // Agregar evento para liberar encargado
        document.querySelectorAll('.liberar-encargado').forEach(button => {
            button.addEventListener('click', function() {
                const codigo = this.getAttribute('data-codigo');
                
                // Confirmar antes de liberar
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Se liberará al encargado actual para que otra persona pueda tomar el tiempo",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, liberar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mostrar cargando
                        Swal.fire({
                            title: 'Procesando',
                            text: 'Liberando encargado...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Enviar solicitud para liberar encargado
                        fetch('/usuario/procesar_tiempo.php', {
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
                                    // Recargar la página para ver los cambios
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
            });
        });

        // Agregar evento para pausar tiempo
        document.querySelectorAll('.pausar-tiempo').forEach(button => {
            button.addEventListener('click', function() {
                const codigo = this.getAttribute('data-codigo');
                
                // Confirmar antes de pausar
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
                        // Mostrar cargando
                        Swal.fire({
                            title: 'Procesando',
                            text: 'Pausando tiempo...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Enviar solicitud para pausar tiempo
                        fetch('/usuario/procesar_tiempo.php', {
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
            });
        });
    });
</script>