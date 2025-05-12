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
                        <h4 class="text-center mb-4 fw-bold text-primary">Buscar Usuario</h4>
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

                    <!-- Paso 2: Información del Usuario -->
                    <div class="step d-none" id="step2_tiempo">
                        <h4 class="text-center mb-4 fw-bold text-primary">Información del Tiempo</h4>
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
                    </div>

                    <!-- Paso 3: Formulario de Gestión de Tiempo -->
                    <div class="step d-none" id="step3_tiempo">
                        <h4 class="text-center mb-4 fw-bold text-primary">
                            <i class="bi bi-clock-fill me-2"></i>Gestionar Tiempo
                        </h4>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="tiempoStatus" class="form-label fw-bold">
                                            <i class="bi bi-toggle-on me-1 text-primary"></i> Estado del Tiempo
                                        </label>
                                        <input type="text" class="form-control" id="tiempoStatus" name="tiempoStatus" value="activo" placeholder="Activar" readonly required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tiempoAcumuladoInput" class="form-label fw-bold">
                                            <i class="bi bi-plus-circle-fill me-1 text-primary"></i> Tiempo a Acumular (HH:MM:SS)
                                        </label>
                                        <input type="text" class="form-control" id="tiempoAcumuladoInput" name="tiempoAcumuladoInput" placeholder="00:00:00" pattern="[0-9]{2}:[0-9]{2}:[0-9]{2}" readonly>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="tiempoRestadoInput" class="form-label fw-bold">
                                            <i class="bi bi-dash-circle-fill me-1 text-primary"></i> Tiempo a Restar (HH:MM:SS)
                                        </label>
                                        <input type="text" class="form-control" id="tiempoRestadoInput" name="tiempoRestadoInput" placeholder="00:00:00" pattern="[0-9]{2}:[0-9]{2}:[0-9]{2}" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nombreEncargadoTiempo" class="form-label fw-bold">
                                            <i class="bi bi-person-fill me-1 text-primary"></i> Nombre Encargado
                                        </label>
                                        <input type="text" class="form-control bg-light" id="nombreEncargadoTiempo" name="nombreEncargadoTiempo" value="<?php echo $_SESSION['username']; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 4: Confirmación -->
                    <div class="step d-none" id="step4_tiempo">
                        <div class="text-center p-5">
                            <div class="display-1 text-success mb-4">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <h4 class="mb-3 fw-bold text-success">¡Tiempo Actualizado Correctamente!</h4>
                            <p class="lead">El tiempo del usuario ha sido actualizado exitosamente.</p>
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
                    Activar Tiempo
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script para el funcionamiento del modal -->
<script>
    $(document).ready(function() {
        let pasoActualGestionTiempo = 1;
        const totalPasosGestionTiempo = 4;
        let datosUsuarioTiempo = {};

        // Actualizar la barra de progreso
        function actualizarBarraProgresoTiempo() {
            const porcentaje = ((pasoActualGestionTiempo - 1) / (totalPasosGestionTiempo - 1)) * 100;
            $('#dar_tiempo_modal .progress-bar').css('width', porcentaje + '%').attr('aria-valuenow', porcentaje);
        }

        // Mostrar el paso actual
        function mostrarPasoTiempo(paso) {
            $('#dar_tiempo_modal .step').addClass('d-none');
            $('#step' + paso + '_tiempo').removeClass('d-none');

            // Actualizar botones
            $('#prevBtnTiempo').prop('disabled', paso === 1);
            $('#nextBtnTiempo').toggleClass('d-none', paso === 3 || paso === 4);
            $('#submitBtnTiempo').toggleClass('d-none', paso !== 3);

            // Actualizar progreso
            pasoActualGestionTiempo = paso;
            actualizarBarraProgresoTiempo();
        }

        // Buscar usuario por código
        $('#buscarUsuarioTiempo').click(function() {
            const codigoUsuario = $('#codigoTimeTiempo').val().trim();

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

                        // Mostrar información del usuario
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

                        // Mostrar el resultado
                        $('#resultadoBusquedaTiempo').html(`
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill me-2"></i> Usuario encontrado: <strong>${datosUsuarioTiempo.usuario_registro}</strong>
                            </div>
                        `);

                        // Habilitar el botón siguiente
                        $('#nextBtnTiempo').prop('disabled', false);
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

        // Enviar formulario
        $('#submitBtnTiempo').click(function() {
            // Validar campos
            const estadoTiempo = $('#tiempoStatus').val();
            const horasAcumuladas = $('#tiempoAcumuladoInput').val();
            const horasRestadas = $('#tiempoRestadoInput').val();
            
            if (!estadoTiempo) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debe seleccionar un estado para el tiempo'
                });
                return;
            }

            // Validar formato de tiempo si se ingresó
            const formatoTiempo = /^([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/;
            
            if (horasAcumuladas && !formatoTiempo.test(horasAcumuladas)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El formato del tiempo acumulado debe ser HH:MM:SS'
                });
                return;
            }

            if (horasRestadas && !formatoTiempo.test(horasRestadas)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El formato del tiempo restado debe ser HH:MM:SS'
                });
                return;
            }

            // Mostrar cargando
            Swal.fire({
                title: 'Procesando',
                text: 'Actualizando tiempo...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Realizar petición AJAX
            $.ajax({
                url: '/private/procesos/gestion_tiempos/actualizar_tiempo.php',
                type: 'POST',
                data: {
                    codigo_time: datosUsuarioTiempo.codigo_time,
                    tiempo_status: estadoTiempo,
                    tiempo_acumulado: horasAcumuladas || '00:00:00',
                    tiempo_restado: horasRestadas || '00:00:00',
                    tiempo_encargado_usuario: $('#nombreEncargadoTiempo').val()
                },
                dataType: 'json',
                success: function(respuestaTiempo) {
                    Swal.close();
                    
                    if (respuestaTiempo.success) {
                        // Mostrar paso de confirmación
                        mostrarPasoTiempo(4);
                        
                        // Redireccionar después de 3 segundos
                        setTimeout(function() {
                            $('#dar_tiempo_modal').modal('hide');
                            window.location.reload();
                        }, 3000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: respuestaTiempo.message || 'Error al actualizar el tiempo'
                        });
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error de conexión. Inténtelo de nuevo.'
                    });
                }
            });
        });

        // Inicializar el modal
        $('#dar_tiempo_modal').on('show.bs.modal', function() {
            // Resetear el formulario
            $('#tiempoFormModal')[0].reset();
            
            // Mostrar el primer paso
            mostrarPasoTiempo(1);
            
            // Limpiar resultados
            $('#resultadoBusquedaTiempo').html('');
            
            // Deshabilitar botón siguiente
            $('#nextBtnTiempo').prop('disabled', true);
        });
    });
</script>