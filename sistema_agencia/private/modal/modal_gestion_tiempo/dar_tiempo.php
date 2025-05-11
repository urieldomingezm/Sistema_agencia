<!-- Modal Wizard para Tomar Tiempo -->
<div class="modal fade" id="id_tomar_tiempo" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="tomarTiempoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
            <!-- Encabezado del Modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="tomarTiempoLabel">
                    Tomar Tiempo
                </h5>
            </div>
            
            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <!-- Indicador de pasos -->
                <div class="progress mb-4" style="height: 10px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                
                <!-- Formulario de múltiples pasos -->
                <form id="tiempoForm">
                    <!-- Paso 1: Búsqueda de Usuario -->
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
                                    <i class="bi bi-info-circle me-1"></i> Ingrese el código de 5 caracteres del usuario a tomar tiempo.
                                </div>
                            </div>
                        </div>
                        <div id="resultadoBusquedaTiempo" class="mt-3"></div>
                    </div>
                    
                    <!-- Paso 2: Información del Usuario -->
                    <div class="step d-none" id="step2">
                        <h4 class="text-center mb-4 fw-bold text-primary">Información del Usuario</h4>
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
                                            <small class="text-muted d-block">Rango Actual</small>
                                            <span class="fw-bold" id="rangoActualTiempo"></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Misión Actual</small>
                                            <span class="fw-bold" id="misionActualTiempo"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Firma</small>
                                            <span class="fw-bold" id="firmaUsuarioTiempo"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Estado</small>
                                            <span id="estadoTiempo"></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Tiempo Actual</small>
                                            <span class="fw-bold" id="tiempoActual"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="mensajeDisponibilidadTiempo" class="alert d-none"></div>
                    </div>
                    
                    <!-- Paso 3: Formulario de Tiempo -->
                    <div class="step d-none" id="step3">
                        <h4 class="text-center mb-4 fw-bold text-primary">
                            <i class="bi bi-clock-fill me-2"></i>Registrar Tiempo
                        </h4>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipoTiempo" class="form-label fw-bold">
                                            <i class="bi bi-clock-history me-1 text-primary"></i> Tipo de Tiempo
                                        </label>
                                        <select class="form-select" id="tipoTiempo" name="tipoTiempo" required>
                                            <option value="">Seleccione tipo</option>
                                            <option value="Entrada">Entrada</option>
                                            <option value="Salida">Salida</option>
                                            <option value="Pausa">Pausa</option>
                                            <option value="Reanudar">Reanudar</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tiempoRegistrado" class="form-label fw-bold">
                                            <i class="bi bi-calendar-check-fill me-1 text-primary"></i> Fecha y Hora
                                        </label>
                                        <input type="datetime-local" class="form-control" id="tiempoRegistrado" name="tiempoRegistrado" required>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="firmaEncargadoTiempo" class="form-label fw-bold">
                                            <i class="bi bi-pen-fill me-1 text-primary"></i> Firma Encargado (3 dígitos)
                                        </label>
                                        <input type="text" class="form-control" id="firmaEncargadoTiempo" name="firmaEncargadoTiempo" maxlength="3" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nombreEncargadoTiempo" class="form-label fw-bold">
                                            <i class="bi bi-person-fill me-1 text-primary"></i> Nombre Encargado
                                        </label>
                                        <input type="text" class="form-control bg-light" id="nombreEncargadoTiempo" name="nombreEncargadoTiempo" value="<?php echo $_SESSION['username']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label fw-bold">
                                        <i class="bi bi-chat-left-text-fill me-1 text-primary"></i> Observaciones
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
                            <h4 class="mb-3 fw-bold text-success">¡Tiempo Registrado Correctamente!</h4>
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

<!-- Script para el wizard de tiempo -->
<script>
$(document).ready(function() {
    let currentStepTiempo = 1;
    const totalStepsTiempo = 4;
    let userDataTiempo = {};
    
    // Actualizar la barra de progreso
    function updateProgressBarTiempo() {
        const percent = ((currentStepTiempo - 1) / (totalStepsTiempo - 1)) * 100;
        $('.progress-bar', '#id_tomar_tiempo').css('width', percent + '%').attr('aria-valuenow', percent);
    }
    
    // Mostrar el paso actual
    function showStepTiempo(step) {
        $('.step', '#id_tomar_tiempo').addClass('d-none');
        $('#step' + step, '#id_tomar_tiempo').removeClass('d-none');
        
        // Actualizar botones
        $('#prevBtnTiempo').prop('disabled', step === 1);
        $('#nextBtnTiempo').toggleClass('d-none', step === 3 || step === 4);
        $('#submitBtnTiempo').toggleClass('d-none', step !== 3);
        
        // Actualizar progreso
        currentStepTiempo = step;
        updateProgressBarTiempo();
    }
    
    // Buscar usuario por código
    $('#buscarUsuarioTiempo').click(function() {
        const codigo = $('#codigoTime', '#id_tomar_tiempo').val().trim();
        
        if (codigo.length !== 5) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El código debe tener exactamente 5 caracteres'
            });
            return;
        }
        
        // Mostrar cargando
        $('#resultadoBusquedaTiempo').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
        
        // Realizar petición AJAX (ajusta la URL según tu endpoint)
        $.ajax({
            url: '/private/procesos/gestion_tiempos/buscar_usuario.php',
            type: 'POST',
            data: { codigo: codigo },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    userDataTiempo = response.data;
                    
                    // Mostrar información del usuario
                    $('#nombreUsuarioTiempo').text(userDataTiempo.usuario_registro);
                    $('#rangoActualTiempo').text(userDataTiempo.rango_actual);
                    $('#misionActualTiempo').text(userDataTiempo.mision_actual);
                    $('#firmaUsuarioTiempo').text(userDataTiempo.firma_usuario ? userDataTiempo.firma_usuario : 'No disponible');
                    $('#tiempoActual').text(userDataTiempo.tiempo_actual || 'No registrado');
                    
                    // Mostrar estado con badge
                    let badgeClass = 'bg-warning';
                    if (userDataTiempo.estado_tiempo === 'activo') {
                        badgeClass = 'bg-success';
                    } else if (userDataTiempo.estado_tiempo === 'inactivo') {
                        badgeClass = 'bg-danger';
                    }
                    $('#estadoTiempo').html(`<span class="badge ${badgeClass}">${userDataTiempo.estado_tiempo}</span>`);
                    
                    // Mostrar el resultado
                    $('#resultadoBusquedaTiempo').html(`
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-2"></i> Usuario encontrado: <strong>${userDataTiempo.usuario_registro}</strong>
                        </div>
                    `);
                    
                    // Habilitar el botón siguiente
                    $('#nextBtnTiempo').prop('disabled', false);
                } else {
                    // Mostrar mensaje de error
                    $('#resultadoBusquedaTiempo').html(`
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> ${response.message}
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
                
                // Deshabilitar el botón siguiente
                $('#nextBtnTiempo').prop('disabled', true);
            }
        });
    });
    
    // Botón siguiente
    $('#nextBtnTiempo').click(function() {
        if (currentStepTiempo < totalStepsTiempo) {
            if (currentStepTiempo === 2) {
                // Establecer fecha y hora actual por defecto
                const now = new Date();
                const formattedDateTime = now.toISOString().slice(0, 16);
                $('#tiempoRegistrado').val(formattedDateTime);
            }
            showStepTiempo(currentStepTiempo + 1);
        }
    });
    
    // Botón anterior
    $('#prevBtnTiempo').click(function() {
        if (currentStepTiempo > 1) {
            showStepTiempo(currentStepTiempo - 1);
        }
    });
    
    // Validación del formulario
    const validatorTiempo = new JustValidate('#tiempoForm', {
        validateBeforeSubmitting: true,
        lockForm: true,
        focusInvalidField: true,
        errorFieldCssClass: 'is-invalid',
        successFieldCssClass: 'is-valid',
        errorLabelCssClass: ['invalid-feedback'],
        successLabelCssClass: ['valid-feedback']
    });
    
    validatorTiempo
        .addField('#tipoTiempo', [
            {
                rule: 'required',
                errorMessage: 'Debe seleccionar un tipo de tiempo'
            }
        ])
        .addField('#tiempoRegistrado', [
            {
                rule: 'required',
                errorMessage: 'Debe ingresar fecha y hora'
            }
        ])
        .addField('#firmaEncargadoTiempo', [
            {
                rule: 'required',
                errorMessage: 'Debe ingresar su firma'
            },
            {
                rule: 'minLength',
                value: 3,
                errorMessage: 'La firma debe tener 3 dígitos'
            },
            {
                rule: 'maxLength',
                value: 3,
                errorMessage: 'La firma debe tener 3 dígitos'
            }
        ]);
    
    // Botón de envío
    $('#submitBtnTiempo').click(function() {
        validatorTiempo.validate().then(function(isValid) {
            if (isValid) {
                // Preparar datos para enviar
                const formData = {
                    codigo_time: userDataTiempo.codigo_time,
                    tipo_tiempo: $('#tipoTiempo').val(),
                    fecha_hora: $('#tiempoRegistrado').val(),
                    firma_encargado: $('#firmaEncargadoTiempo').val(),
                    usuario_encargado: $('#nombreEncargadoTiempo').val(),
                    observaciones: $('#observaciones').val()
                };
                
                // Mostrar cargando
                Swal.fire({
                    title: 'Procesando',
                    text: 'Registrando tiempo...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Enviar datos al servidor (ajusta la URL según tu endpoint)
                $.ajax({
                    url: '/private/procesos/gestion_tiempos/registrar.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        Swal.close();
                        
                        if (response.success) {
                            // Mostrar mensaje de éxito
                            showStepTiempo(4);
                            
                            // Redireccionar después de 3 segundos
                            setTimeout(function() {
                                $('#id_tomar_tiempo').modal('hide');
                                location.reload();
                            }, 3000);
                        } else {
                            // Mostrar mensaje de error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error de conexión con el servidor'
                        });
                    }
                });
            }
        });
    });
    
    // Inicializar
    showStepTiempo(1);
});
</script>
