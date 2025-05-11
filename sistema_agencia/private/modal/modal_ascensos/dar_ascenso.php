<div class="modal fade" id="dar_ascenso_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dar_ascenso_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
            <!-- Encabezado del Modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="dar_ascenso_modalLabel">
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
                <form id="ascensoFormModal">
                    <!-- Paso 1: Búsqueda de Usuario -->
                    <div class="step" id="step1_ascenso">
                        <h4 class="text-center mb-4 fw-bold text-primary">Buscar Usuario</h4>
                        <div class="card mb-3">
                            <div class="card-body">
                                <label for="codigoTimeAscenso" class="form-label fw-bold">
                                    <i class="bi bi-person-badge me-1"></i> Código de Usuario (5 caracteres)
                                </label>
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-hash"></i>
                                    </span>
                                    <input type="text" class="form-control" id="codigoTimeAscenso" name="codigoTimeAscenso" maxlength="5" placeholder="Ingrese el código" autocomplete="off">
                                    <button class="btn btn-primary" type="button" id="buscarUsuarioAscenso">
                                        <i class="bi bi-search me-1"></i> Buscar
                                    </button>
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i> Ingrese el código de 5 caracteres del usuario a ascender.
                                </div>
                            </div>
                        </div>
                        <div id="resultadoBusquedaAscenso" class="mt-3"></div>
                    </div>
                    
                    <!-- Paso 2: Información del Usuario -->
                    <div class="step d-none" id="step2_ascenso">
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
                                            <span class="fw-bold" id="nombreUsuarioAscenso"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Rango Actual</small>
                                            <span class="fw-bold" id="rangoActualAscenso"></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Misión Actual</small>
                                            <span class="fw-bold" id="misionActualAscenso"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Firma</small>
                                            <span class="fw-bold" id="firmaUsuarioAscenso"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Estado</small>
                                            <span id="estadoAscensoModal"></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Próximo Ascenso</small>
                                            <span class="fw-bold" id="fechaDisponibleAscenso"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="mensajeDisponibilidadAscenso" class="alert d-none"></div>
                    </div>
                    
                    <!-- Paso 3: Formulario de Ascenso -->
                    <div class="step d-none" id="step3_ascenso">
                        <h4 class="text-center mb-4 fw-bold text-primary">
                            <i class="bi bi-arrow-up-circle-fill me-2"></i>Registrar Ascenso
                        </h4>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="nuevoRangoAscenso" class="form-label fw-bold">
                                            <i class="bi bi-award-fill me-1 text-primary"></i> Nuevo Rango
                                        </label>
                                        <select class="form-select" id="nuevoRangoAscenso" name="nuevoRangoAscenso" required>
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
                                        <label for="nuevaMisionAscenso" class="form-label fw-bold">
                                            <i class="bi bi-briefcase-fill me-1 text-primary"></i> Nueva Misión
                                        </label>
                                        <input type="text" class="form-control" id="nuevaMisionAscenso" name="nuevaMisionAscenso" required>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="firmaEncargadoAscenso" class="form-label fw-bold">
                                            <i class="bi bi-pen-fill me-1 text-primary"></i> Firma Encargado (3 dígitos)
                                        </label>
                                        <input type="text" class="form-control" id="firmaEncargadoAscenso" name="firmaEncargadoAscenso" maxlength="3" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nombreEncargadoAscenso" class="form-label fw-bold">
                                            <i class="bi bi-person-fill me-1 text-primary"></i> Nombre Encargado
                                        </label>
                                        <input type="text" class="form-control bg-light" id="nombreEncargadoAscenso" name="nombreEncargadoAscenso" value="<?php echo $_SESSION['username']; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Paso 4: Confirmación -->
                    <div class="step d-none" id="step4_ascenso">
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
                <button type="button" class="btn btn-outline-secondary btn-lg" id="prevBtnAscenso" disabled>
                     Anterior
                </button>
                <button type="button" class="btn btn-outline-primary btn-lg" id="nextBtnAscenso">
                    Siguiente 
                </button>
                <button type="button" class="btn btn-outline-success btn-lg d-none" id="submitBtnAscenso">
                     Registrar Ascenso
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Incluye JustValidate desde CDN antes de tu script principal -->
<script>
$(document).ready(function() {
    let currentStepAscenso = 1;
    const totalStepsAscenso = 4;
    let userDataAscenso = {};
    let userRangoActualAscenso = '';
    
    // Definir las reglas de ascenso según el rango del encargado
    const reglasAscensoModal = {
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
    const rangoEncargadoAscenso = '<?php echo isset($_SESSION["rango"]) ? $_SESSION["rango"] : ""; ?>';
    
    // Actualizar la barra de progreso
    function updateProgressBarAscenso() {
        const percent = ((currentStepAscenso - 1) / (totalStepsAscenso - 1)) * 100;
        $('#dar_ascenso_modal .progress-bar').css('width', percent + '%').attr('aria-valuenow', percent);
    }
    
    // Mostrar el paso actual
    function showStepAscenso(step) {
        $('#dar_ascenso_modal .step').addClass('d-none');
        $('#step' + step + '_ascenso').removeClass('d-none');
        
        // Actualizar botones
        $('#prevBtnAscenso').prop('disabled', step === 1);
        $('#nextBtnAscenso').toggleClass('d-none', step === 3 || step === 4);
        $('#submitBtnAscenso').toggleClass('d-none', step !== 3);
        
        // Actualizar progreso
        currentStepAscenso = step;
        updateProgressBarAscenso();
    }
    
    // Buscar usuario por código
    $('#buscarUsuarioAscenso').click(function() {
        const codigo = $('#codigoTimeAscenso').val().trim();
        
        if (codigo.length !== 5) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El código debe tener exactamente 5 caracteres'
            });
            return;
        }
        
        // Mostrar cargando
        $('#resultadoBusquedaAscenso').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
        
        // Realizar petición AJAX
        $.ajax({
            url: '/private/procesos/gestion_ascensos/buscar_usuario.php',
            type: 'POST',
            data: { codigo: codigo },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    userDataAscenso = response.data;
                    userRangoActualAscenso = userDataAscenso.rango_actual;
                    
                    // Mostrar información del usuario
                    $('#nombreUsuarioAscenso').text(userDataAscenso.usuario_registro);
                    $('#rangoActualAscenso').text(userDataAscenso.rango_actual);
                    $('#misionActualAscenso').text(userDataAscenso.mision_actual);
                    $('#firmaUsuarioAscenso').text(userDataAscenso.firma_usuario ? userDataAscenso.firma_usuario : 'No disponible');
                    
                    // Mostrar estado con badge
                    let badgeClass = 'bg-warning';
                    if (userDataAscenso.estado_ascenso === 'ascendido') {
                        badgeClass = 'bg-success';
                    } else if (userDataAscenso.estado_ascenso === 'pendiente') {
                        badgeClass = 'bg-danger';
                    }
                    $('#estadoAscensoModal').html(`<span class="badge ${badgeClass}">${userDataAscenso.estado_ascenso}</span>`);
                    
                    // Mostrar fecha disponible
                    $('#fechaDisponibleAscenso').text(userDataAscenso.fecha_disponible_ascenso);
                    
                    // Verificar disponibilidad para ascenso
                    const fechaActual = new Date();
                    let fechaDisponible;
                    
                    // Si el campo es tipo TIME (ejemplo: "00:14:50"), lo sumamos a la hora actual
                    if (/^\d{2}:\d{2}:\d{2}$/.test(userDataAscenso.fecha_disponible_ascenso)) {
                        const partes = userDataAscenso.fecha_disponible_ascenso.split(':');
                        fechaDisponible = new Date(fechaActual.getTime());
                        fechaDisponible.setHours(fechaActual.getHours() + parseInt(partes[0]));
                        fechaDisponible.setMinutes(fechaActual.getMinutes() + parseInt(partes[1]));
                        fechaDisponible.setSeconds(fechaActual.getSeconds() + parseInt(partes[2]));
                    } else {
                        // Si es un datetime válido
                        fechaDisponible = new Date(userDataAscenso.fecha_disponible_ascenso);
                    }
                    
                    const mensajeDiv = $('#mensajeDisponibilidadAscenso');
                    if (fechaDisponible <= fechaActual) {
                        mensajeDiv.removeClass('d-none alert-danger').addClass('alert-success')
                            .html('<i class="bi bi-check-circle-fill me-2"></i> El usuario está disponible para ascender.');
                        $('#nextBtnAscenso').prop('disabled', false);
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
                        $('#nextBtnAscenso').prop('disabled', true);
                    }
                    
                    // Mostrar el resultado
                    $('#resultadoBusquedaAscenso').html(`
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-2"></i> Usuario encontrado: <strong>${userDataAscenso.usuario_registro}</strong>
                        </div>
                    `);
                    
                    // Habilitar el botón siguiente
                    $('#nextBtnAscenso').prop('disabled', false);
                } else {
                    // Mostrar mensaje de error
                    $('#resultadoBusquedaAscenso').html(`
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> ${response.message}
                        </div>
                    `);
                    
                    // Deshabilitar el botón siguiente
                    $('#nextBtnAscenso').prop('disabled', true);
                }
            },
            error: function() {
                // Mostrar mensaje de error
                $('#resultadoBusquedaAscenso').html(`
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Error de conexión. Inténtelo de nuevo.
                    </div>
                `);
                
                // Deshabilitar el botón siguiente
                $('#nextBtnAscenso').prop('disabled', true);
            }
        });
    });
    
    // Actualizar opciones de rango según el rango del encargado
    function actualizarOpcionesRangoAscenso() {
        const nuevoRangoSelect = $('#nuevoRangoAscenso');
        nuevoRangoSelect.empty();
        nuevoRangoSelect.append('<option value="">Seleccione un rango</option>');
        
        // Si el encargado no tiene un rango válido o el usuario no tiene un rango actual, no mostrar opciones
        if (!rangoEncargadoAscenso || !reglasAscensoModal[rangoEncargadoAscenso] || !userRangoActualAscenso) {
            return;
        }
        
        // Filtrar rangos permitidos según el rango actual del usuario
        const rangosPermitidos = reglasAscensoModal[rangoEncargadoAscenso];
        
        // Agregar opciones de rangos permitidos
        for (const rango of rangosPermitidos) {
            nuevoRangoSelect.append(`<option value="${rango}">${rango}</option>`);
        }
    }
    
    // Botón Anterior
    $('#prevBtnAscenso').click(function() {
        if (currentStepAscenso > 1) {
            showStepAscenso(currentStepAscenso - 1);
        }
    });
    
    // Botón Siguiente
    $('#nextBtnAscenso').click(function() {
        if (currentStepAscenso < totalStepsAscenso) {
            if (currentStepAscenso === 2) {
                // Actualizar opciones de rango antes de mostrar el paso 3
                actualizarOpcionesRangoAscenso();
            }
            showStepAscenso(currentStepAscenso + 1);
        }
    });
    
    // Botón Registrar Ascenso
    $('#submitBtnAscenso').click(function() {
        // Validar formulario
        const nuevoRango = $('#nuevoRangoAscenso').val();
        const nuevaMision = $('#nuevaMisionAscenso').val().trim();
        const firmaEncargado = $('#firmaEncargadoAscenso').val().trim();
        
        if (!nuevoRango || !nuevaMision || !firmaEncargado) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son obligatorios'
            });
            return;
        }
        
        // Mostrar cargando
        Swal.fire({
            title: 'Procesando',
            text: 'Registrando ascenso...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Preparar datos para enviar
        const formData = new FormData();
        formData.append('codigo_time', userDataAscenso.codigo_time);
        formData.append('usuario_registro', userDataAscenso.usuario_registro);
        formData.append('rango_actual', nuevoRango);
        formData.append('mision_actual', nuevaMision);
        formData.append('firma_usuario', userDataAscenso.firma_usuario);
        formData.append('firma_encargado', firmaEncargado);
        formData.append('nombre_encargado', $('#nombreEncargadoAscenso').val());
        formData.append('action', 'registrar_ascenso');
        
        // Realizar petición AJAX
        $.ajax({
            url: '/private/procesos/gestion_ascensos/registrar_ascenso.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.close();
                    showStepAscenso(4);
                    
                    // Redireccionar después de 3 segundos
                    setTimeout(function() {
                        window.location.href = '/usuario/index.php?page=gestion de ascensos';
                    }, 3000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Error al registrar el ascenso'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error de conexión. Inténtelo de nuevo.'
                });
            }
        });
    });
    
    // Inicializar
    showStepAscenso(1);
});
</script>