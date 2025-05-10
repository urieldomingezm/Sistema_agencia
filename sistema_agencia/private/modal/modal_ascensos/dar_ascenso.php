<div class="modal fade" id="dar_ascenso" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dar_ascensoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
            <!-- Encabezado del Modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="dar_ascensoLabel">
                    Dar Ascenso
                </h5>
            </div>
            
            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <!-- Indicador de pasos -->
                <div class="progress mb-4" style="height: 10px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                
                <!-- Formulario de múltiples pasos -->
                <form id="ascensoForm">
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
                                    <button class="btn btn-primary" type="button" id="buscarUsuario">
                                        <i class="bi bi-search me-1"></i> Buscar
                                    </button>
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i> Ingrese el código de 5 caracteres del usuario a ascender.
                                </div>
                            </div>
                        </div>
                        <div id="resultadoBusqueda" class="mt-3"></div>
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
                                            <span class="fw-bold" id="nombreUsuario"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Rango Actual</small>
                                            <span class="fw-bold" id="rangoActual"></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Misión Actual</small>
                                            <span class="fw-bold" id="misionActual"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Firma</small>
                                            <span class="fw-bold" id="firmaUsuario"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Estado</small>
                                            <span id="estadoAscenso"></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Próximo Ascenso</small>
                                            <span class="fw-bold" id="fechaDisponible"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="mensajeDisponibilidad" class="alert d-none"></div>
                    </div>
                    
                    <!-- Paso 3: Formulario de Ascenso -->
                    <div class="step d-none" id="step3">
                        <h4 class="text-center mb-4 fw-bold text-primary">
                            <i class="bi bi-arrow-up-circle-fill me-2"></i>Registrar Ascenso
                        </h4>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="nuevoRango" class="form-label fw-bold">
                                            <i class="bi bi-award-fill me-1 text-primary"></i> Nuevo Rango
                                        </label>
                                        <select class="form-select" id="nuevoRango" name="nuevoRango" required>
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
                                        <input type="text" class="form-control" id="nuevaMision" name="nuevaMision" required>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="firmaEncargado" class="form-label fw-bold">
                                            <i class="bi bi-pen-fill me-1 text-primary"></i> Firma Encargado (3 dígitos)
                                        </label>
                                        <input type="text" class="form-control" id="firmaEncargado" name="firmaEncargado" maxlength="3" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nombreEncargado" class="form-label fw-bold">
                                            <i class="bi bi-person-fill me-1 text-primary"></i> Nombre Encargado
                                        </label>
                                        <input type="text" class="form-control bg-light" id="nombreEncargado" name="nombreEncargado" value="<?php echo $_SESSION['username']; ?>" readonly>
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
                <button type="button" class="btn btn-outline-danger btn-lg" data-bs-dismiss="modal">
                    Cerrar
                </button>
                <button type="button" class="btn btn-outline-secondary btn-lg" id="prevBtn" disabled>
                     Anterior
                </button>
                <button type="button" class="btn btn-outline-primary btn-lg" id="nextBtn">
                    Siguiente 
                </button>
                <button type="button" class="btn btn-outline-success btn-lg d-none" id="submitBtn">
                     Registrar Ascenso
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Incluye JustValidate desde CDN antes de tu script principal -->
<script>
$(document).ready(function() {
    let currentStep = 1;
    const totalSteps = 4;
    let userData = {};
    let userRangoActual = '';
    
    // Definir las reglas de ascenso según el rango del encargado
    const reglasAscenso = {
        'Logistica': ['Agente'],
        'Supervisor': ['Agente', 'Seguridad'],
        'Director': ['Agente', 'Seguridad', 'Tecnico'],
        'Presidente': ['Agente', 'Seguridad', 'Tecnico', 'Logistica'],
        'Operativo': ['Agente', 'Seguridad', 'Tecnico', 'Logistica', 'Supervisor'],
        'Junta directiva': ['Agente', 'Seguridad', 'Tecnico', 'Logistica', 'Supervisor', 'Director'],
        'Administrador': ['Agente', 'Seguridad', 'Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva'],
        'Manager': ['Agente', 'Seguridad', 'Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva'],
        'Dueño': ['Agente', 'Seguridad', 'Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva']
    };
    
    // Obtener el rango del usuario actual (encargado)
    const rangoEncargado = '<?php echo isset($_SESSION["rango"]) ? $_SESSION["rango"] : ""; ?>';
    
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
                    userRangoActual = userData.rango_actual;
                    
                    // Mostrar información del usuario
                    $('#nombreUsuario').text(userData.usuario_registro);
                    $('#rangoActual').text(userData.rango_actual);
                    $('#misionActual').text(userData.mision_actual);
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
                        // Calcular tiempo restante en horas, minutos y segundos
                        const tiempoRestanteMs = fechaDisponible.getTime() - fechaActual.getTime();
                        const totalSegundos = Math.max(0, Math.floor(tiempoRestanteMs / 1000));
                        const horas = Math.floor(totalSegundos / 3600);
                        const minutos = Math.floor((totalSegundos % 3600) / 60);
                        const segundos = totalSegundos % 60;
                    
                        let mensajeTiempo = '';
                        if (horas > 0) {
                            mensajeTiempo += `${horas} hora${horas !== 1 ? 's' : ''}`;
                        }
                        if (minutos > 0) {
                            if (mensajeTiempo) mensajeTiempo += ', ';
                            mensajeTiempo += `${minutos} minuto${minutos !== 1 ? 's' : ''}`;
                        }
                        if (segundos > 0) {
                            if (mensajeTiempo) mensajeTiempo += ' y ';
                            mensajeTiempo += `${segundos} segundo${segundos !== 1 ? 's' : ''}`;
                        }
                        
                        mensajeDiv.removeClass('d-none alert-success').addClass('alert-danger')
                            .html(`<i class="bi bi-exclamation-triangle-fill me-2"></i> El usuario no está disponible para ascender. Tiempo restante: ${mensajeTiempo}.`);
                        $('#nextBtn').prop('disabled', true);
                    }
                    
                    // Mostrar el resultado
                    $('#resultadoBusqueda').html(`
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-2"></i> Usuario encontrado: <strong>${userData.usuario_registro}</strong>
                        </div>
                    `);
                    
                    // Habilitar el botón siguiente
                    $('#nextBtn').prop('disabled', false);
                } else {
                    // Mostrar mensaje de error
                    $('#resultadoBusqueda').html(`
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> ${response.message}
                        </div>
                    `);
                    
                    // Deshabilitar el botón siguiente
                    $('#nextBtn').prop('disabled', true);
                }
            },
            error: function() {
                // Mostrar mensaje de error
                $('#resultadoBusqueda').html(`
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Error de conexión. Inténtelo de nuevo.
                    </div>
                `);
                
                // Deshabilitar el botón siguiente
                $('#nextBtn').prop('disabled', true);
            }
        });
    });
    
    // Actualizar opciones de rango según el rango del encargado
    function actualizarOpcionesRango() {
        const nuevoRangoSelect = $('#nuevoRango');
        nuevoRangoSelect.empty();
        nuevoRangoSelect.append('<option value="">Seleccione un rango</option>');
        
        // Si el encargado no tiene un rango válido o el usuario no tiene un rango actual, no mostrar opciones
        if (!rangoEncargado || !reglasAscenso[rangoEncargado] || !userRangoActual) {
            return;
        }
        
        // Filtrar rangos permitidos según el rango actual del usuario
        const rangosPermitidos = reglasAscenso[rangoEncargado];
        
        // Agregar opciones de rangos permitidos
        if (rangosPermitidos.includes('Agente')) {
            nuevoRangoSelect.append('<option value="Agente">Agente</option>');
        }
        if (rangosPermitidos.includes('Seguridad')) {
            nuevoRangoSelect.append('<option value="Seguridad">Seguridad</option>');
        }
        if (rangosPermitidos.includes('Tecnico')) {
            nuevoRangoSelect.append('<option value="Tecnico">Técnico</option>');
        }
        if (rangosPermitidos.includes('Logistica')) {
            nuevoRangoSelect.append('<option value="Logistica">Logística</option>');
        }
        if (rangosPermitidos.includes('Supervisor')) {
            nuevoRangoSelect.append('<option value="Supervisor">Supervisor</option>');
        }
        if (rangosPermitidos.includes('Director')) {
            nuevoRangoSelect.append('<option value="Director">Director</option>');
        }
        if (rangosPermitidos.includes('Presidente')) {
            nuevoRangoSelect.append('<option value="Presidente">Presidente</option>');
        }
        if (rangosPermitidos.includes('Operativo')) {
            nuevoRangoSelect.append('<option value="Operativo">Operativo</option>');
        }
        if (rangosPermitidos.includes('Junta directiva')) {
            nuevoRangoSelect.append('<option value="Junta directiva">Junta directiva</option>');
        }
    }
    
    // Botón siguiente
    $('#nextBtn').click(function() {
        if (currentStep < totalSteps) {
            if (currentStep === 2) {
                // Actualizar opciones de rango antes de mostrar el paso 3
                actualizarOpcionesRango();
            }
            showStep(currentStep + 1);
        }
    });
    
    // Botón anterior
    $('#prevBtn').click(function() {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    });
    
    // Validación del formulario
    const validator = new JustValidate('#ascensoForm', {
        validateBeforeSubmitting: true,
        lockForm: true,
        focusInvalidField: true,
        errorFieldCssClass: 'is-invalid',
        successFieldCssClass: 'is-valid',
        errorLabelCssClass: ['invalid-feedback'],
        successLabelCssClass: ['valid-feedback']
    });
    
    validator
        .addField('#nuevoRango', [
            {
                rule: 'required',
                errorMessage: 'Debe seleccionar un rango'
            }
        ])
        .addField('#nuevaMision', [
            {
                rule: 'required',
                errorMessage: 'Debe ingresar una misión'
            }
        ])
        .addField('#firmaEncargado', [
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
    $('#submitBtn').click(function() {
        validator.validate().then(function(isValid) {
            if (isValid) {
                // Verificar si el rango seleccionado está permitido
                const nuevoRango = $('#nuevoRango').val();
                
                // Verificar si el encargado tiene permiso para ascender al usuario a este rango
                if (!rangoEncargado || !reglasAscenso[rangoEncargado] || !reglasAscenso[rangoEncargado].includes(nuevoRango)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No tienes permiso para ascender a este rango'
                    });
                    return;
                }
                
                // Preparar datos para enviar
                const formData = {
                    codigo_time: userData.codigo_time,
                    rango_nuevo: nuevoRango,
                    mision_nueva: $('#nuevaMision').val(),
                    firma_usuario: userData.firma_usuario || '',
                    firma_encargado: $('#firmaEncargado').val(),
                    usuario_encargado: $('#nombreEncargado').val(),
                    tiempo_espera: 60 // Tiempo de espera en minutos (ajustar según necesidad)
                };
                
                // Mostrar cargando
                Swal.fire({
                    title: 'Procesando',
                    text: 'Registrando ascenso...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Enviar datos al servidor
                $.ajax({
                    url: '/private/procesos/gestion_ascensos/registrar.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        Swal.close();
                        
                        if (response.success) {
                            // Mostrar mensaje de éxito
                            showStep(4);
                            
                            // Redireccionar después de 3 segundos
                            setTimeout(function() {
                                $('#dar_ascenso').modal('hide');
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
                    error: function() {Swal.fire({
                        icon: 'success',
                        title: '¡Ascenso registrado!',
                        text: 'El ascenso se ha registrado correctamente.',
                        allowOutsideClick: false,
                        confirmButtonText: 'Ir a gestión'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '?page=gestion_ascenso';
                        }
                    });
            }
                });
            }
        });
    });
    
    // Inicializar
    showStep(1);
});
</script>