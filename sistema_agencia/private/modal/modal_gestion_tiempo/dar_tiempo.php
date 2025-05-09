<!-- Modal Wizard para Tomar Tiempo -->
<div class="modal fade" id="id_tomar_tiempo" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="tomarTiempoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
            <!-- Encabezado -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="tomarTiempoLabel">Tomar Tiempo</h5>
            </div>
            <!-- Cuerpo -->
            <div class="modal-body">
                <!-- Barra de progreso -->
                <div class="progress mb-4" style="height: 10px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <!-- Formulario de pasos -->
                <form id="tiempoForm">
                    <!-- Paso 1: Buscar usuario -->
                    <div class="step" id="step1">
                        <h4 class="text-center mb-4 fw-bold text-primary">Buscar Usuario</h4>
                        <div class="card mb-3">
                            <div class="card-body">
                                <label for="codigoTime" class="form-label fw-bold">
                                    <i class="bi bi-person-badge me-1"></i> Código de Usuario (5 caracteres)
                                </label>
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-hash"></i>
                                    </span>
                                    <input type="text" class="form-control" id="codigoTime" name="codigoTime" maxlength="5" placeholder="Ingrese el código" autocomplete="off">
                                    <button class="btn btn-primary" type="button" id="buscarUsuarioTiempo">
                                        <i class="bi bi-search me-1"></i> Buscar
                                    </button>
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i> Ingrese el código de 5 caracteres del usuario.
                                </div>
                            </div>
                        </div>
                        <div id="resultadoBusquedaTiempo" class="mt-3"></div>
                    </div>
                    <!-- Paso 2: Información de gestión de tiempo -->
                    <div class="step d-none" id="step2">
                        <h4 class="text-center mb-4 fw-bold text-primary">Información de Gestión de Tiempo</h4>
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-clock-history me-2 text-primary"></i>Datos de Tiempo del Usuario
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Status</small>
                                            <span class="fw-bold" id="tiempoStatus"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Tiempo Restado</small>
                                            <span class="fw-bold" id="tiempoRestado"></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Tiempo Acumulado</small>
                                            <span class="fw-bold" id="tiempoAcumulado"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Tiempo Transcurrido</small>
                                            <span class="fw-bold" id="tiempoTranscurrido"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Encargado</small>
                                            <span class="fw-bold" id="tiempoEncargado"></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Llevando</small>
                                            <span class="fw-bold" id="tiempoLlevando"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="mensajeDisponibilidadTiempo" class="alert d-none"></div>
                    </div>
                    <!-- Paso 3: Formulario para registrar tiempo -->
                    <div class="step d-none" id="step3">
                        <h4 class="text-center mb-4 fw-bold text-primary">
                            <i class="bi bi-stopwatch-fill me-2"></i>Registrar/Iniciar Tiempo
                        </h4>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="horaInicio" class="form-label fw-bold">
                                            <i class="bi bi-clock me-1 text-primary"></i> Hora de inicio
                                        </label>
                                        <input type="time" class="form-control" id="horaInicio" name="horaInicio" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="horaFin" class="form-label fw-bold">
                                            <i class="bi bi-clock-history me-1 text-primary"></i> Hora de fin
                                        </label>
                                        <input type="time" class="form-control" id="horaFin" name="horaFin" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label fw-bold">
                                        <i class="bi bi-journal-text me-1 text-primary"></i> Observaciones
                                    </label>
                                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Paso 4: Confirmación -->
                    <div class="step d-none" id="step4">
                        <div class="text-center p-5">
                            <div class="display-1 text-success mb-4">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <h4 class="mb-3 fw-bold text-success">¡Tiempo registrado correctamente!</h4>
                            <p class="lead">El tiempo ha sido registrado exitosamente.</p>
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

<!-- Incluye JustValidate desde CDN antes de tu script principal -->
<script src="https://cdn.jsdelivr.net/npm/just-validate@4.2.0/dist/just-validate.production.min.js"></script>
<script>
$(document).ready(function() {
    let currentStep = 1;
    const totalSteps = 4;
    let tiempoData = {};

    function updateProgressBar() {
        const percent = ((currentStep - 1) / (totalSteps - 1)) * 100;
        $('.progress-bar').css('width', percent + '%').attr('aria-valuenow', percent);
    }

    function showStep(step) {
        $('.step').addClass('d-none');
        $('#step' + step).removeClass('d-none');
        $('#prevBtnTiempo').prop('disabled', step === 1);
        $('#nextBtnTiempo').toggleClass('d-none', step === 3 || step === 4);
        $('#submitBtnTiempo').toggleClass('d-none', step !== 3);
        currentStep = step;
        updateProgressBar();
    }

    // Buscar usuario por código (AJAX)
    $('#buscarUsuarioTiempo').click(function() {
        const codigo = $('#codigoTime').val().trim();
        if (codigo.length !== 5) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El código debe tener exactamente 5 caracteres'
            });
            return;
        }
        $('#resultadoBusquedaTiempo').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
        $.ajax({
            url: '/private/procesos/gestion_tiempos/buscar_usuario.php',
            type: 'POST',
            data: { codigo: codigo },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    tiempoData = response.data;
                    // Mostrar información en el paso 2
                    $('#tiempoStatus').text(tiempoData.tiempo_status);
                    $('#tiempoRestado').text(tiempoData.tiempo_restado || '0');
                    $('#tiempoAcumulado').text(tiempoData.tiempo_acumulado || '0');
                    $('#tiempoTranscurrido').text(tiempoData.tiempo_transcurrido || '0');
                    $('#tiempoEncargado').text(tiempoData.tiempo_encargado_usuario || 'No asignado');
                    $('#tiempoLlevando').text(tiempoData.tiempo_llevando ? 'Sí' : 'No');
                    $('#mensajeDisponibilidadTiempo').addClass('d-none').removeClass('alert-danger alert-success').html('');
                    showStep(2);
                } else {
                    $('#resultadoBusquedaTiempo').html('<div class="alert alert-danger">'+response.message+'</div>');
                }
            },
            error: function() {
                $('#resultadoBusquedaTiempo').html('<div class="alert alert-danger">Error al buscar usuario.</div>');
            }
        });
    });

    $('#nextBtnTiempo').click(function() {
        if (currentStep === 1) {
            // Forzar búsqueda si no se ha hecho
            $('#buscarUsuarioTiempo').trigger('click');
        } else if (currentStep === 2) {
            // Validar si el usuario está disponible para registrar tiempo
            if (tiempoData.tiempo_llevando) {
                $('#mensajeDisponibilidadTiempo').removeClass('d-none alert-success').addClass('alert-danger')
                    .html('<i class="bi bi-exclamation-triangle-fill me-2"></i> Este usuario ya está siendo llevado por otro encargado.');
                return;
            } else {
                $('#mensajeDisponibilidadTiempo').addClass('d-none').removeClass('alert-danger alert-success').html('');
                showStep(3);
            }
        } else if (currentStep === 3) {
            // Aquí podrías validar el formulario antes de registrar
            // Si todo está bien:
            // showStep(4);
        }
    });

    $('#prevBtnTiempo').click(function() {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    });

    $('#submitBtnTiempo').click(function() {
        // Validación básica de los campos requeridos
        const horaInicio = $('#horaInicio').val();
        const horaFin = $('#horaFin').val();
        const observaciones = $('#observaciones').val();

        if (!horaInicio || !horaFin) {
            Swal.fire({
                icon: 'error',
                title: 'Campos requeridos',
                text: 'Debes ingresar la hora de inicio y fin.'
            });
            return;
        }

        // Puedes agregar más validaciones aquí si lo necesitas

        // Enviar datos vía AJAX
        $.ajax({
            url: '/private/procesos/gestion_tiempos/registrar.php',
            type: 'POST',
            data: {
                codigo_time: tiempoData.codigo_time,
                hora_inicio: horaInicio,
                hora_fin: horaFin,
                observaciones: observaciones
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showStep(4);
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo registrar el tiempo.'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al registrar el tiempo.'
                });
            }
        });
    });
    // showStep(4);
    });

    // Inicializa en el primer paso
    showStep(1);

</script>