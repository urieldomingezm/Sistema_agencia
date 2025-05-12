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
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                
                <!-- Formulario de múltiples pasos -->
                <form id="darAscensoForm">
                    <!-- Paso 1: Búsqueda de Usuario -->
                    <div class="step" id="step1">
                        <h4 class="text-center mb-4 fw-bold text-success">Buscar Usuario para Ascenso</h4>
                        <div class="card mb-3">
                            <div class="card-body">
                                <label for="codigoUsuarioAscenso" class="form-label fw-bold">
                                    <i class="bi bi-person-badge me-1"></i> Código de Usuario (5 caracteres)
                                </label>
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-hash"></i>
                                    </span>
                                    <input type="text" class="form-control" id="codigoUsuarioAscenso" name="codigoUsuarioAscenso" maxlength="5" placeholder="Ingrese el código" autocomplete="off">
                                    <button class="btn btn-success" type="button" id="buscarUsuarioAscenso">
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
                    <div class="step d-none" id="step2">
                        <h4 class="text-center mb-4 fw-bold text-success">Información del Usuario</h4>
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-person-badge-fill me-2 text-success"></i>Datos del Usuario
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
                                            <span id="estadoAscensoAscenso"></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Código Time</small>
                                            <span class="fw-bold" id="codigoTimeInfoAscenso"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Paso 3: Formulario de Ascenso -->
                    <div class="step d-none" id="step3">
                        <h4 class="text-center mb-4 fw-bold text-success">
                            <i class="bi bi-arrow-up-circle-fill me-2"></i>Dar Ascenso
                        </h4>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="codigoTimeAscenso" class="form-label fw-bold">
                                            <i class="bi bi-person-fill me-1 text-success"></i> Código Time
                                        </label>
                                        <input type="text" class="form-control" id="codigoTimeAscenso" name="codigoTimeAscenso" readonly>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nuevoRangoAscenso" class="form-label fw-bold">
                                            <i class="bi bi-award-fill me-1 text-success"></i> Nuevo Rango
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
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="nuevaMisionAscenso" class="form-label fw-bold">
                                            <i class="bi bi-briefcase-fill me-1 text-success"></i> Nueva Misión
                                        </label>
                                        <input type="text" class="form-control" id="nuevaMisionAscenso" name="nuevaMisionAscenso" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="firmaUsuario" class="form-label fw-bold">
                                            <i class="bi bi-pen-fill me-1 text-success"></i> Firma Usuario (3 dígitos)
                                        </label>
                                        <input type="text" class="form-control" id="firmaUsuario" name="firmaUsuario" maxlength="3">
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="firmaEncargadoAscenso" class="form-label fw-bold">
                                            <i class="bi bi-person-check-fill me-1 text-success"></i> Firma Encargado (3 dígitos)
                                        </label>
                                        <input type="text" class="form-control" id="firmaEncargadoAscenso" name="firmaEncargadoAscenso" maxlength="3" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nombreEncargadoAscenso" class="form-label fw-bold">
                                            <i class="bi bi-person-fill me-1 text-success"></i> Nombre Encargado
                                        </label>
                                        <input type="text" class="form-control" id="nombreEncargadoAscenso" name="nombreEncargadoAscenso" value="<?php echo $_SESSION['username']; ?>" readonly required>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="tiempoEsperaAscenso" class="form-label fw-bold">
                                            <i class="bi bi-clock-fill me-1 text-success"></i> Tiempo de Espera (minutos)
                                        </label>
                                        <input type="number" class="form-control" id="tiempoEsperaAscenso" name="tiempoEsperaAscenso" required min="0" readonly>
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
                <button type="button" class="btn btn-outline-secondary btn-lg" id="prevBtnAscenso" disabled>
                     Anterior
                </button>
                <button type="button" class="btn btn-outline-success btn-lg" id="nextBtnAscenso">
                    Siguiente 
                </button>
                <button type="button" class="btn btn-outline-success btn-lg d-none" id="submitBtnAscenso">
                     Registrar Ascenso
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script para el funcionamiento del modal -->
<script>
$(document).ready(function() {
    let currentStepDarAscenso = 1;
    const totalStepsDarAscenso = 4;
    let userDataDarAscenso = {};
    
    // Actualizar la barra de progreso
    function updateProgressBarDarAscenso() {
        const percent = ((currentStepDarAscenso - 1) / (totalStepsDarAscenso - 1)) * 100;
        $('#dar_ascenso .progress-bar').css('width', percent + '%').attr('aria-valuenow', percent);
    }
    
    // Mostrar el paso actual
    function showStepDarAscenso(step) {
        $('#dar_ascenso .step').addClass('d-none');
        $('#dar_ascenso #step' + step).removeClass('d-none');
        
        // Actualizar botones
        $('#prevBtnAscenso').prop('disabled', step === 1);
        $('#nextBtnAscenso').toggleClass('d-none', step === 3 || step === 4);
        $('#submitBtnAscenso').toggleClass('d-none', step !== 3);
        
        // Actualizar progreso
        currentStepDarAscenso = step;
        updateProgressBarDarAscenso();
    }
    
    // Función para mostrar/ocultar el campo de firma según el rango
    function toggleFirmaField() {
        const rangoSeleccionado = $('#nuevoRangoAscenso').val();
        const firmaContainer = $('#firmaUsuario').closest('.col-md-6');
        
        if (rangoSeleccionado === 'Agente' || rangoSeleccionado === 'Seguridad') {
            firmaContainer.hide();
            $('#firmaUsuario').val('').removeAttr('required');
        } else {
            firmaContainer.show();
            $('#firmaUsuario').attr('required', 'required');
        }
    }
    
    // Ejecutar cuando cambie el rango
    $('#nuevoRangoAscenso').change(toggleFirmaField);
    
    // Función para actualizar el tiempo de espera según el rango
    function updateTiempoEspera() {
        const rangoSeleccionado = $('#nuevoRangoAscenso').val();
        let tiempoEspera = 0;
        
        // Definir tiempos de espera por rango (en minutos)
        switch(rangoSeleccionado) {
            case 'Agente':
                tiempoEspera = 30;
                break;
            case 'Seguridad':
                tiempoEspera = 120; // 2 horas
                break;
            case 'Tecnico':
                tiempoEspera = 1440; // 24 horas
                break;
            case 'Logistica':
                tiempoEspera = 2880; // 48 horas
                break;
            case 'Supervisor':
                tiempoEspera = 4350; // 72.5 horas
                break;
            case 'Director':
                tiempoEspera = 7200; // 120 horas
                break;
            case 'Presidente':
                tiempoEspera = 10080; // 168 horas
                break;
            case 'Operativo':
                tiempoEspera = 12960; // 216 horas
                break;
            default:
                tiempoEspera = 0;
        }
        
        $('#tiempoEsperaAscenso').val(tiempoEspera);
    }
    
    // Actualizar tiempo de espera cuando cambie el rango
    $('#nuevoRangoAscenso').change(updateTiempoEspera);
    
    // Buscar usuario por código
    $('#buscarUsuarioAscenso').click(function() {
        const codigo = $('#codigoUsuarioAscenso').val().trim();
        
        if (codigo.length !== 5) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El código debe tener exactamente 5 caracteres'
            });
            return;
        }
        
        // Mostrar cargando
        $('#resultadoBusquedaAscenso').html('<div class="text-center"><div class="spinner-border text-success" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
        
        // Realizar petición AJAX
        $.ajax({
            url: '/private/procesos/gestion_ascensos/buscar_usuario.php',
            type: 'POST',
            data: { codigo: codigo },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    userDataDarAscenso = response.data;
                    
                    // Mostrar información del usuario
                    $('#nombreUsuarioAscenso').text(userDataDarAscenso.usuario_registro);
                    $('#rangoActualAscenso').text(userDataDarAscenso.rango_actual);
                    $('#misionActualAscenso').text(userDataDarAscenso.mision_actual);
                    $('#firmaUsuarioAscenso').text(userDataDarAscenso.firma_usuario ? userDataDarAscenso.firma_usuario : 'No disponible');
                    $('#codigoTimeInfoAscenso').text(userDataDarAscenso.codigo_time);
                    
                    // Mostrar estado con badge
                    let badgeClass = 'bg-warning';
                    if (userDataDarAscenso.estado_ascenso === 'ascendido') {
                        badgeClass = 'bg-success';
                    } else if (userDataDarAscenso.estado_ascenso === 'pendiente') {
                        badgeClass = 'bg-danger';
                    } else if (userDataDarAscenso.estado_ascenso === 'disponible') {
                        badgeClass = 'bg-info';
                    }
                    $('#estadoAscensoAscenso').html(`<span class="badge ${badgeClass}">${userDataDarAscenso.estado_ascenso}</span>`);
                    
                    // Prellenar los campos del formulario de ascenso
                    $('#codigoTimeAscenso').val(userDataDarAscenso.codigo_time);
                    $('#firmaUsuario').val(userDataDarAscenso.firma_usuario);
                    
                    // Aplicar la lógica de mostrar/ocultar firma según el rango
                    toggleFirmaField();
                    
                    // Mostrar el resultado
                    $('#resultadoBusquedaAscenso').html(`
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-2"></i> Usuario encontrado: <strong>${userDataDarAscenso.usuario_registro}</strong>
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
    
    // Botón Siguiente
    $('#nextBtnAscenso').click(function() {
        if (currentStepDarAscenso < totalStepsDarAscenso) {
            showStepDarAscenso(currentStepDarAscenso + 1);
        }
    });
    
    // Botón Anterior
    $('#prevBtnAscenso').click(function() {
        if (currentStepDarAscenso > 1) {
            showStepDarAscenso(currentStepDarAscenso - 1);
        }
    });
    
    // Botón Registrar Ascenso
    $('#submitBtnAscenso').click(function() {
        // Validar formulario
        const codigoTime = $('#codigoTimeAscenso').val();
        const nuevoRango = $('#nuevoRangoAscenso').val();
        const nuevaMision = $('#nuevaMisionAscenso').val().trim();
        const firmaUsuario = $('#firmaUsuario').val().trim();
        const firmaEncargado = $('#firmaEncargadoAscenso').val().trim();
        const nombreEncargado = $('#nombreEncargadoAscenso').val().trim();
        const tiempoEspera = $('#tiempoEsperaAscenso').val();
        
        // Validación condicional según el rango
        if (!codigoTime || !nuevoRango || !nuevaMision || !firmaEncargado || !nombreEncargado || !tiempoEspera) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son obligatorios excepto la firma del usuario para rangos Agente y Seguridad'
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
        
        // Solo validar la firma si se ha ingresado algo y es requerida
        if (nuevoRango !== 'Agente' && nuevoRango !== 'Seguridad') {
            if (!firmaUsuario || firmaUsuario.length !== 3) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'La firma del usuario debe tener 3 dígitos'
                });
                return;
            }
        }
        
        // Mostrar cargando
        Swal.fire({
            title: 'Registrando ascenso',
            text: 'Por favor espere...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Preparar datos para enviar
        const formData = new FormData();
        formData.append('codigoTimeAscenso', codigoTime);
        formData.append('nuevoRangoAscenso', nuevoRango);
        formData.append('nuevaMisionAscenso', nuevaMision);
        formData.append('firmaUsuario', firmaUsuario);
        formData.append('firmaEncargadoAscenso', firmaEncargado);
        formData.append('nombreEncargadoAscenso', nombreEncargado);
        formData.append('tiempoEsperaAscenso', tiempoEspera);
        
        // Realizar petición AJAX
        $.ajax({
            url: '/private/procesos/gestion_ascensos/registrar.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Mostrar paso de confirmación
                    showStepDarAscenso(4);
                    
                    // Cerrar el modal de carga
                    Swal.close();
                    
                    // Redireccionar después de 3 segundos
                    setTimeout(function() {
                        window.location.href = '/usuario/GSAS.php';
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
    });
    
    // Inicializar el modal
    $('#dar_ascenso').on('show.bs.modal', function() {
        // Resetear el formulario y volver al paso 1
        $('#darAscensoForm')[0].reset();
        showStepDarAscenso(1);
        $('#resultadoBusquedaAscenso').html('');
        $('#nextBtnAscenso').prop('disabled', false);
        
        // Establecer el nombre del encargado (usuario actual)
        $('#nombreEncargadoAscenso').val('<?php echo $_SESSION['username']; ?>');
    });
});
</script>