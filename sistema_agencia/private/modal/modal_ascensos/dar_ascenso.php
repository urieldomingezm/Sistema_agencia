<div class="modal fade" id="dar_ascenso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dar_ascensoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content border-0 shadow">
            <!-- Encabezado del Modal con gradiente -->
            <div class="modal-header bg-primary  text-white rounded-top">
                <h5 class="modal-title fw-bold" id="dar_ascensoLabel">
                    <i class="bi bi-arrow-up-square-fill me-2"></i>
                    Dar Ascenso
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Cuerpo del Modal -->
            <div class="modal-body p-4">
                <!-- Indicador de pasos -->
                <div class="progress mb-4 bg-light" style="height: 10px;">
                    <div class="progress-bar bg-primary bg-gradient progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                
                <!-- Formulario de múltiples pasos -->
                <form id="ascensoForm">
                    <!-- Paso 1: Búsqueda de Usuario -->
                    <div class="step" id="step1">
                        <h4 class="text-center mb-4 fw-bold text-primary">Buscar Usuario</h4>
                        <div class="card border-0 shadow-sm mb-3 p-2">
                            <div class="card-body">
                                <label for="codigoTime" class="form-label fw-bold">
                                    <i class="bi bi-person-badge me-1"></i> Código de Usuario (5 caracteres)
                                </label>
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text bg-light">
                                        <i class="bi bi-hash"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg" id="codigoTime" name="codigoTime" maxlength="5" placeholder="Ingrese el código" autocomplete="off">
                                    <button class="btn btn-primary" type="button" id="buscarUsuario">
                                        <i class="bi bi-search me-1"></i> Buscar
                                    </button>
                                </div>
                                <div class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i> Ingrese el código de 5 caracteres del usuario a ascender.
                                </div>
                            </div>
                        </div>
                        <div id="resultadoBusqueda" class="mt-3"></div>
                    </div>
                    
                    <!-- Paso 2: Información del Usuario -->
                    <div class="step d-none" id="step2">
                        <h4 class="text-center mb-4 fw-bold text-primary">Información del Usuario</h4>
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-header bg-light py-3">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-person-badge-fill me-2 text-primary"></i>Datos del Usuario
                                </h5>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-light rounded-circle p-2 me-3">
                                                <i class="bi bi-person-fill text-primary"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Usuario</small>
                                                <span class="fw-bold" id="nombreUsuario"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-light rounded-circle p-2 me-3">
                                                <i class="bi bi-award-fill text-primary"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Rango Actual</small>
                                                <span class="fw-bold" id="rangoActual"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-2 me-3">
                                                <i class="bi bi-briefcase-fill text-primary"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Misión Actual</small>
                                                <span class="fw-bold" id="misionActual"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-light rounded-circle p-2 me-3">
                                                <i class="bi bi-pen-fill text-primary"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Firma</small>
                                                <span class="fw-bold" id="firmaUsuario"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-light rounded-circle p-2 me-3">
                                                <i class="bi bi-info-circle-fill text-primary"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Estado</small>
                                                <span id="estadoAscenso"></span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded-circle p-2 me-3">
                                                <i class="bi bi-calendar-event-fill text-primary"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Próximo Ascenso</small>
                                                <span class="fw-bold" id="fechaDisponible"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="mensajeDisponibilidad" class="alert d-none rounded-3 shadow-sm"></div>
                    </div>
                    
                    <!-- Paso 3: Formulario de Ascenso -->
                    <div class="step d-none" id="step3">
                        <h4 class="text-center mb-4 fw-bold text-primary">
                            <i class="bi bi-arrow-up-circle-fill me-2"></i>Registrar Ascenso
                        </h4>
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="nuevoRango" class="form-label fw-bold">
                                            <i class="bi bi-award-fill me-1 text-primary"></i> Nuevo Rango
                                        </label>
                                        <select class="form-select form-select-lg" id="nuevoRango" name="nuevoRango" required>
                                            <option value="">Seleccione un rango</option>
                                            <option value="Agente">Agente</option>
                                            <option value="Seguridad">Seguridad</option>
                                            <option value="Tecnico">Técnico</option>
                                            <option value="Logistica">Logística</option>
                                            <option value="Supervisor">Supervisor</option>
                                            <option value="Director">Director</option>
                                            <option value="Presidente">Presidente</option>
                                            <option value="Operativo">Operativo</option>
                                            <option value="Junta directiva">Junta directiva</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nuevaMision" class="form-label fw-bold">
                                            <i class="bi bi-briefcase-fill me-1 text-primary"></i> Nueva Misión
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="nuevaMision" name="nuevaMision" required>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="firmaEncargado" class="form-label fw-bold">
                                            <i class="bi bi-pen-fill me-1 text-primary"></i> Firma Encargado (3 dígitos)
                                        </label>
                                        <input type="text" class="form-control form-control-lg" id="firmaEncargado" name="firmaEncargado" maxlength="3" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nombreEncargado" class="form-label fw-bold">
                                            <i class="bi bi-person-fill me-1 text-primary"></i> Nombre Encargado
                                        </label>
                                        <input type="text" class="form-control form-control-lg bg-light" id="nombreEncargado" name="nombreEncargado" value="<?php echo $_SESSION['username']; ?>" readonly>
                                    </div>
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
                            <h4 class="mb-3 fw-bold text-success">¡Ascenso Registrado Correctamente!</h4>
                            <p class="lead">El usuario ha sido ascendido exitosamente.</p>
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
                <button type="button" class="btn btn-outline-secondary btn-lg" id="prevBtn" disabled>
                    <i class="bi bi-arrow-left me-1"></i> Anterior
                </button>
                <button type="button" class="btn btn-primary btn-lg" id="nextBtn">
                    Siguiente <i class="bi bi-arrow-right ms-1"></i>
                </button>
                <button type="button" class="btn btn-success btn-lg d-none" id="submitBtn">
                    <i class="bi bi-check-circle me-1"></i> Registrar Ascenso
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    let currentStep = 1;
    const totalSteps = 4;
    let userData = {};
    
    // Actualizar la barra de progreso
    function updateProgressBar() {
        const percent = ((currentStep - 1) / (totalSteps - 1)) * 100;
        $('.progress-bar').css('width', percent + '%').attr('aria-valuenow', percent);
    }
    
    // Mostrar el paso actual
    function showStep(step) {
        $('.step').addClass('d-none');
        $('#step' + step).removeClass('d-none');
        
        // Actualizar botones
        $('#prevBtn').prop('disabled', step === 1);
        $('#nextBtn').toggleClass('d-none', step === 3 || step === 4);
        $('#submitBtn').toggleClass('d-none', step !== 3);
        
        // Actualizar progreso
        currentStep = step;
        updateProgressBar();
    }
    
    // Buscar usuario por código
    $('#buscarUsuario').click(function() {
        const codigo = $('#codigoTime').val().trim();
        
        if (codigo.length !== 5) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El código debe tener exactamente 5 caracteres'
            });
            return;
        }
        
        // Mostrar cargando
        $('#resultadoBusqueda').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
        
        // Realizar petición AJAX
        $.ajax({
            url: '/private/procesos/gestion_ascensos/buscar_usuario.php',
            type: 'POST',
            data: { codigo: codigo },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    userData = response.data;
                    
                    // Mostrar información del usuario
                    $('#nombreUsuario').text(userData.usuario_registro);
                    $('#rangoActual').text(userData.rango_actual);
                    $('#misionActual').text(userData.mision_actual);
                    // Cambia esta línea:
                    $('#firmaUsuario').text(userData.firma_usuario);
                    // Por esta lógica:
                    $('#firmaUsuario').text(userData.firma_usuario ? userData.firma_usuario : 'No disponible');
                    
                    // Mostrar estado con badge
                    let badgeClass = 'bg-warning';
                    if (userData.estado_ascenso === 'ascendido') {
                        badgeClass = 'bg-success';
                    } else if (userData.estado_ascenso === 'pendiente') {
                        badgeClass = 'bg-danger';
                    }
                    $('#estadoAscenso').html(`<span class="badge ${badgeClass}">${userData.estado_ascenso}</span>`);
                    
                    // Mostrar fecha disponible
                    $('#fechaDisponible').text(userData.fecha_disponible_ascenso);
                    
                    // Verificar disponibilidad para ascenso
                    const fechaActual = new Date();
                    let fechaDisponible;
                    
                    // Si el campo es tipo TIME (ejemplo: "00:14:50"), lo sumamos a la hora actual
                    if (/^\d{2}:\d{2}:\d{2}$/.test(userData.fecha_disponible_ascenso)) {
                        const partes = userData.fecha_disponible_ascenso.split(':');
                        fechaDisponible = new Date(fechaActual.getTime());
                        fechaDisponible.setHours(fechaActual.getHours() + parseInt(partes[0]));
                        fechaDisponible.setMinutes(fechaActual.getMinutes() + parseInt(partes[1]));
                        fechaDisponible.setSeconds(fechaActual.getSeconds() + parseInt(partes[2]));
                    } else {
                        // Si es un datetime válido
                        fechaDisponible = new Date(userData.fecha_disponible_ascenso);
                    }
                    
                    const mensajeDiv = $('#mensajeDisponibilidad');
                    if (fechaDisponible <= fechaActual) {
                        mensajeDiv.removeClass('d-none alert-danger').addClass('alert-success')
                            .html('<i class="bi bi-check-circle-fill me-2"></i> El usuario está disponible para ascender.');
                        $('#nextBtn').prop('disabled', false);
                    } else {
                        // Calcular tiempo restante en minutos
                        const tiempoRestanteMs = fechaDisponible.getTime() - fechaActual.getTime();
                        const totalSegundos = Math.max(0, Math.floor(tiempoRestanteMs / 1000));
                        const minutos = Math.floor(totalSegundos / 60);
                        const segundos = totalSegundos % 60;
                        
                        let mensajeTiempo = '';
                        if (minutos > 0) {
                            mensajeTiempo += `${minutos} minuto${minutos !== 1 ? 's' : ''}`;
                        }
                        if (segundos > 0) {
                            if (mensajeTiempo) mensajeTiempo += ' y ';
                            mensajeTiempo += `${segundos} segundo${segundos !== 1 ? 's' : ''}`;
                        }
                        if (!mensajeTiempo) mensajeTiempo = 'menos de un segundo';
                        
                        mensajeDiv.removeClass('d-none alert-success').addClass('alert-danger')
                            .html(`<i class="bi bi-exclamation-triangle-fill me-2"></i> El usuario no está disponible para ascender. Debe esperar ${mensajeTiempo} más.`);
                        $('#nextBtn').prop('disabled', true);
                    }
                    
                    // Ir al siguiente paso
                    showStep(2);
                } else {
                    $('#resultadoBusqueda').html(`
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            ${response.message}
                        </div>
                    `);
                }
            },
            error: function() {
                $('#resultadoBusqueda').html(`
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        Error al conectar con el servidor. Intente nuevamente.
                    </div>
                `);
            }
        });
    });
    
    // Botón Anterior
    $('#prevBtn').click(function() {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    });
    
    // Botón Siguiente
    $('#nextBtn').click(function() {
        if (currentStep < totalSteps) {
            showStep(currentStep + 1);
        }
    });
    
    // Registrar ascenso
    $('#submitBtn').click(function() {
        const nuevoRango = $('#nuevoRango').val();
        const nuevaMision = $('#nuevaMision').val();
        const firmaEncargado = $('#firmaEncargado').val();
        const nombreEncargado = $('#nombreEncargado').val();
        
        // Validar campos
        if (!nuevoRango || !nuevaMision || !firmaEncargado) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son obligatorios'
            });
            return;
        }
        
        if (firmaEncargado.length !== 3) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La firma del encargado debe tener 3 dígitos'
            });
            return;
        }
        
        // Calcular tiempo de espera según el rango
        let tiempoEspera = 30; // Por defecto 30 minutos
        
        switch (nuevoRango) {
            case 'Agente':
                tiempoEspera = 30;
                break;
            case 'Seguridad':
                tiempoEspera = 45;
                break;
            case 'Tecnico':
                tiempoEspera = 60;
                break;
            case 'Logistica':
                tiempoEspera = 90;
                break;
            case 'Supervisor':
                tiempoEspera = 120;
                break;
            default:
                tiempoEspera = 180;
                break;
        }
        
        // Datos para enviar
        // En la sección de AJAX donde se realiza el registro
        const datosAscenso = {
            codigo_time: userData.codigo_time,
            rango_anterior: '', // Ya no necesitamos el rango anterior
            rango_nuevo: nuevoRango,
            mision_anterior: '', // Ya no necesitamos la misión anterior
            mision_nueva: nuevaMision,
            firma_encargado: firmaEncargado,
            usuario_encargado: nombreEncargado,
            tiempo_espera: tiempoEspera,
            firma_usuario: userData.firma_usuario // Agregamos la firma del usuario
        };
        
        // Mostrar cargando
        $('#submitBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');
        
        // Realizar petición AJAX
        $.ajax({
            url: '/private/procesos/gestion_ascensos/registrar.php',
            type: 'POST',
            data: datosAscenso,
            dataType: 'json',
            success: function(response) {
                $('#submitBtn').prop('disabled', false).html('Registrar Ascenso');
                
                if (response.success) {
                    // Ir al paso de confirmación
                    showStep(4);
                    
                    // Recargar la tabla después de 2 segundos
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                $('#submitBtn').prop('disabled', false).html('Registrar Ascenso');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al conectar con el servidor. Intente nuevamente.'
                });
            }
        });
    });
    
    // Reiniciar el formulario al cerrar el modal
    $('#dar_ascenso').on('hidden.bs.modal', function() {
        $('#ascensoForm')[0].reset();
        $('#resultadoBusqueda').html('');
        $('#mensajeDisponibilidad').addClass('d-none');
        showStep(1);
    });
    
    // Inicializar
    showStep(1);
});
</script>