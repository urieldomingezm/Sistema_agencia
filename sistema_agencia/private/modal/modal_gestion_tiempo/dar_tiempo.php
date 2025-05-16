<div class="modal fade" id="dar_tiempo_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dar_tiempo_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
            <!-- Encabezado del Modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="dar_tiempo_modalLabel">
                    Gestión de Tiempo
                </h5>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <!-- Indicador de pasos -->
                <div class="progress mb-4" style="height: 10px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <!-- Formulario de múltiples pasos -->
                <form id="tiempoFormModal">
                    <!-- Paso 1: Búsqueda de Usuario -->
                    <div class="step" id="step1_tiempo">
                        <h4 class="text-center mb-4 fw-bold text-primary">Paso 1: Buscar Usuario</h4>
                        <div class="card mb-3">
                            <div class="card-body">
                                <label for="codigoTimeTiempo" class="form-label fw-bold">
                                    <i class="bi bi-person-badge me-1"></i> Código de Usuario (5 caracteres)
                                </label>
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-hash"></i>
                                    </span>
                                    <input type="text" class="form-control" id="codigoTimeTiempo" name="codigoTimeTiempo" maxlength="5" placeholder="Ingrese el código" autocomplete="off">
                                    <button class="btn btn-primary" type="button" id="buscarUsuarioTiempo">
                                        <i class="bi bi-search me-1"></i> Buscar
                                    </button>
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i> Ingrese el código de 5 caracteres del usuario para gestionar su tiempo.
                                </div>
                            </div>
                        </div>
                        <div id="resultadoBusquedaTiempo" class="mt-3"></div>
                    </div>

                    <!-- Paso 2: Información del Tiempo -->
                    <div class="step d-none" id="step2_tiempo">
                        <h4 class="text-center mb-4 fw-bold text-primary">Paso 2: Información del Tiempo</h4>
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-person-badge-fill me-2 text-primary"></i>Datos del Usuario
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Usuario</small>
                                            <span class="fw-bold" id="nombreUsuarioTiempo"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Estado</small>
                                            <span id="estadoTiempoModal"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Tiempo Transcurrido</small>
                                            <span class="fw-bold" id="tiempoTranscurrido"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Tiempo Acumulado</small>
                                            <span class="fw-bold" id="tiempoAcumulado"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Tiempo Restado</small>
                                            <span class="fw-bold" id="tiempoRestado"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Encargado</small>
                                            <span class="fw-bold" id="tiempoEncargado"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Aquí podrías añadir un resumen o confirmación antes de registrar si fuera necesario -->
                    </div>

                    <!-- Paso 3: Resultado del Registro -->
                    <div class="step d-none" id="step3_tiempo">
                        <div class="text-center p-5">
                            <div class="display-1 text-success mb-4">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <h4 class="mb-3 fw-bold text-success">¡Registro Completado!</h4>
                            <p class="lead">La gestión del tiempo del usuario ha sido procesada exitosamente.</p>
                            <div class="mt-4">
                                <div class="spinner-grow spinner-grow-sm text-success me-1" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                                <span class="text-muted">Redirigiendo...</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Pie del Modal -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-danger btn-lg" data-bs-dismiss="modal">
                    Cerrar
                </button>
                <button type="button" class="btn btn-outline-secondary btn-lg" id="prevBtnTiempo" disabled>
                    Anterior
                </button>
                <button type="button" class="btn btn-outline-primary btn-lg" id="nextBtnTiempo">
                    Siguiente
                </button>
                <button type="button" class="btn btn-outline-success btn-lg d-none" id="submitBtnTiempo">
                    Registrar Tiempo
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script para el funcionamiento del modal -->
<script>
    $(document).ready(function() {
        let pasoActualGestionTiempo = 1;
        const totalPasosGestionTiempo = 3; // Ahora son 3 pasos
        let datosUsuarioTiempo = {};

        // Actualizar la barra de progreso
        function actualizarBarraProgresoTiempo() {
            // La barra de progreso va del paso 1 al 2 (antes del resultado final)
            const porcentaje = ((pasoActualGestionTiempo - 1) / (totalPasosGestionTiempo - 1)) * 100;
            $('#dar_tiempo_modal .progress-bar').css('width', porcentaje + '%').attr('aria-valuenow', porcentaje);
        }

        // Mostrar el paso actual
        function mostrarPasoTiempo(paso) {
            $('#dar_tiempo_modal .step').addClass('d-none');
            $('#step' + paso + '_tiempo').removeClass('d-none');

            // Actualizar botones
            $('#prevBtnTiempo').prop('disabled', paso === 1 || paso === totalPasosGestionTiempo); // Deshabilitar Anterior en paso 1 y en el paso final
            $('#nextBtnTiempo').toggleClass('d-none', paso === totalPasosGestionTiempo - 1 || paso === totalPasosGestionTiempo); // Ocultar Siguiente en el penúltimo paso (Paso 2) y el final (Paso 3)
            $('#submitBtnTiempo').toggleClass('d-none', paso !== totalPasosGestionTiempo - 1); // Mostrar Submit solo en el penúltimo paso (Paso 2)

            // Actualizar progreso
            pasoActualGestionTiempo = paso;
            actualizarBarraProgresoTiempo();
        }

        // Buscar usuario por código
        $('#buscarUsuarioTiempo').click(function() {
            const codigoUsuario = $('#codigoTimeTiempo').val().trim();
            const usuarioActual = '<?php echo $_SESSION['username']; ?>';

            if (codigoUsuario.length !== 5) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El código debe tener exactamente 5 caracteres'
                });
                return;
            }

            // Mostrar cargando
            $('#resultadoBusquedaTiempo').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
             $('#nextBtnTiempo').prop('disabled', true); // Deshabilitar Siguiente mientras busca


            // Realizar petición AJAX
            $.ajax({
                url: '/private/procesos/gestion_tiempos/buscar_usuario.php',
                type: 'POST',
                data: {
                    codigo: codigoUsuario
                },
                dataType: 'json',
                success: function(respuesta) {
                    if (respuesta.success) {
                        datosUsuarioTiempo = respuesta.data;

                        // Validar si el usuario está intentando asignarse tiempo a sí mismo
                        if (datosUsuarioTiempo.usuario_registro === usuarioActual) {
                            $('#resultadoBusquedaTiempo').html(`
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    No puedes asignarte tiempo a ti mismo.
                                </div>
                            `);
                            $('#nextBtnTiempo').prop('disabled', true);
                            return;
                        }

                        // Mostrar información del usuario en el Paso 2
                        $('#nombreUsuarioTiempo').text(datosUsuarioTiempo.usuario_registro);
                        $('#tiempoAcumulado').text(datosUsuarioTiempo.tiempo_acumulado);
                        $('#tiempoRestado').text(datosUsuarioTiempo.tiempo_restado);
                        $('#tiempoTranscurrido').text(datosUsuarioTiempo.tiempo_transcurrido || 'No disponible');
                        $('#tiempoEncargado').text(datosUsuarioTiempo.tiempo_encargado_usuario || 'No asignado');

                        // Mostrar estado con badge
                        let claseEstado = 'bg-warning';
                        if (datosUsuarioTiempo.tiempo_status === 'activo') {
                            claseEstado = 'bg-success';
                        } else if (datosUsuarioTiempo.tiempo_status === 'finalizado') {
                            claseEstado = 'bg-danger';
                        }
                        $('#estadoTiempoModal').html(`<span class="badge ${claseEstado}">${datosUsuarioTiempo.tiempo_status}</span>`);

                        // Verificar si ya tiene un encargado asignado
                        if (datosUsuarioTiempo.tiempo_encargado_usuario && datosUsuarioTiempo.tiempo_encargado_usuario.trim() !== '') {
                            // Mostrar alerta de que ya tiene encargado
                            $('#resultadoBusquedaTiempo').html(`
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <strong>Atención:</strong> Este usuario ya tiene asignado a <strong>${datosUsuarioTiempo.tiempo_encargado_usuario}</strong> como encargado de su tiempo.
                                    No se puede proceder con la activación.
                                </div>
                            `);

                            // Deshabilitar el botón siguiente
                            $('#nextBtnTiempo').prop('disabled', true);
                        } else {
                            // Mostrar el resultado normal
                            $('#resultadoBusquedaTiempo').html(`
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle-fill me-2"></i> Usuario encontrado: <strong>${datosUsuarioTiempo.usuario_registro}</strong>
                                </div>
                            `);

                            // Habilitar el botón siguiente
                            $('#nextBtnTiempo').prop('disabled', false);
                        }
                    } else {
                        // Mostrar mensaje de error
                        $('#resultadoBusquedaTiempo').html(`
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> ${respuesta.message}
                            </div>
                        `);

                        // Deshabilitar el botón siguiente
                        $('#nextBtnTiempo').prop('disabled', true);
                    }
                },
                error: function() {
                    // Mostrar mensaje de error
                    $('#resultadoBusquedaTiempo').html(`
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Error de conexión. Inténtelo de nuevo.
                        </div>
                    `);
                    $('#nextBtnTiempo').prop('disabled', true);
                }
            });
        });

        // Botón siguiente
        $('#nextBtnTiempo').click(function() {
             // Validaciones antes de pasar al siguiente paso
            if (pasoActualGestionTiempo === 1) {
                // En el paso 1, verificar si se ha encontrado un usuario válido
                if (!datosUsuarioTiempo || !datosUsuarioTiempo.codigo_time || $('#nextBtnTiempo').prop('disabled')) {
                     Swal.fire({
                        icon: 'warning',
                        title: 'Atención',
                        text: 'Debes buscar y encontrar un usuario válido antes de continuar.'
                    });
                    return; // No avanzar si no hay usuario válido o el botón Siguiente está deshabilitado
                }
            }
             // Puedes añadir más validaciones para otros pasos si es necesario

            if (pasoActualGestionTiempo < totalPasosGestionTiempo) {
                mostrarPasoTiempo(pasoActualGestionTiempo + 1);
            }
        });

        // Botón anterior
        $('#prevBtnTiempo').click(function() {
            if (pasoActualGestionTiempo > 1) {
                mostrarPasoTiempo(pasoActualGestionTiempo - 1);
            }
        });

        // Enviar formulario (Ahora se llama "Registrar Tiempo" y se activa en el Paso 2)
        $('#submitBtnTiempo').click(function() {
            // Validar que se haya seleccionado un usuario
            if (!datosUsuarioTiempo || !datosUsuarioTiempo.codigo_time) {
                 Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se ha seleccionado ningún usuario para registrar el tiempo.'
                });
                return;
            }

            // Mostrar cargando
            Swal.fire({
                title: 'Procesando Registro',
                text: 'Registrando la gestión del tiempo...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Realizar petición AJAX
            $.ajax({
                url: '/private/procesos/gestion_tiempos/activar_tiempo.php', // Mantener la URL si el backend maneja la lógica
                type: 'POST',
                data: {
                    codigo_time: datosUsuarioTiempo.codigo_time,
                    tiempo_status: 'activo', // Hardcodeado a 'activo' ya que no hay input para cambiarlo
                    tiempo_encargado_usuario: '<?php echo $_SESSION['username']; ?>' // Usar el usuario actual directamente
                },
                dataType: 'json',
                success: function(respuestaTiempo) {
                    Swal.close();

                    if (respuestaTiempo.success) {
                        // Mostrar paso de confirmación final (Paso 3)
                        mostrarPasoTiempo(totalPasosGestionTiempo);

                        // Redireccionar después de 3 segundos
                        setTimeout(function() {
                            $('#dar_tiempo_modal').modal('hide');
                            window.location.reload();
                        }, 3000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en Registro',
                            text: respuestaTiempo.message || 'Error al registrar la gestión del tiempo.'
                        });
                         // Opcional: Volver al paso anterior o mostrar un mensaje en el paso 2
                         // mostrarPasoTiempo(totalPasosGestionTiempo - 1);
                         // $('#resultadoRegistroTiempo').html(`<div class="alert alert-danger mt-3">${respuestaTiempo.message || 'Error desconocido.'}</div>`); // Si añades un div para resultados en paso 2
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Conexión',
                        text: 'Error de conexión con el servidor. Inténtelo de nuevo.'
                    });
                     // Opcional: Mostrar mensaje de error en el paso 2
                     // $('#resultadoRegistroTiempo').html('<div class="alert alert-danger mt-3">Error de conexión con el servidor.</div>');
                }
            });
        });

        // Inicializar el modal
        $('#dar_tiempo_modal').on('show.bs.modal', function() {
            // Resetear el formulario
            $('#tiempoFormModal')[0].reset();

            // Limpiar resultados de búsqueda y datos de usuario
            $('#resultadoBusquedaTiempo').html('');
            $('#nombreUsuarioTiempo').text('');
            $('#tiempoAcumulado').text('');
            $('#tiempoRestado').text('');
            $('#tiempoTranscurrido').text('');
            $('#tiempoEncargado').text('');
            $('#estadoTiempoModal').html('');
            datosUsuarioTiempo = {}; // Limpiar datos del usuario seleccionado

            // Mostrar el primer paso
            mostrarPasoTiempo(1);
        });

        // Asegurarse de que los botones Anterior y Siguiente estén habilitados/deshabilitados correctamente al abrir
         $('#dar_tiempo_modal').on('shown.bs.modal', function() {
             mostrarPasoTiempo(pasoActualGestionTiempo); // Re-aplicar el estado de los botones
         });

    });
</script>

<style>
/* Puedes mantener o ajustar estilos si es necesario */
</style>
