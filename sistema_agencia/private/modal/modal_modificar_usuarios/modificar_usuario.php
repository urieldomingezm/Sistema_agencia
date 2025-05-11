<div class="modal fade" id="editar_usuario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editar_usuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
            <!-- Encabezado del Modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="editar_usuarioLabel">
                    Editar Usuario
                </h5>
            </div>
            
            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <!-- Indicador de pasos -->
                <div class="progress mb-4" style="height: 10px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                
                <!-- Formulario de múltiples pasos -->
                <form id="editarUsuarioForm">
                    <!-- Paso 1: Búsqueda de Usuario -->
                    <div class="step" id="step1">
                        <h4 class="text-center mb-4 fw-bold text-primary">Buscar Usuario</h4>
                        <div class="card mb-3">
                            <div class="card-body">
                                <label for="codigoUsuarioEdit" class="form-label fw-bold">
                                    <i class="bi bi-person-badge me-1"></i> Código de Usuario (5 caracteres)
                                </label>
                                <div class="input-group input-group-lg mb-3">
                                    <span class="input-group-text">
                                        <i class="bi bi-hash"></i>
                                    </span>
                                    <input type="text" class="form-control" id="codigoUsuarioEdit" name="codigoUsuarioEdit" maxlength="5" placeholder="Ingrese el código" autocomplete="off">
                                    <button class="btn btn-primary" type="button" id="buscarUsuarioEdit">
                                        <i class="bi bi-search me-1"></i> Buscar
                                    </button>
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i> Ingrese el código de 5 caracteres del usuario a editar.
                                </div>
                            </div>
                        </div>
                        <div id="resultadoBusquedaEdit" class="mt-3"></div>
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
                                            <span class="fw-bold" id="nombreUsuarioEdit"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Rango Actual</small>
                                            <span class="fw-bold" id="rangoActualEdit"></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Misión Actual</small>
                                            <span class="fw-bold" id="misionActualEdit"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Firma</small>
                                            <span class="fw-bold" id="firmaUsuarioEdit"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Estado</small>
                                            <span id="estadoAscensoEdit"></span>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Código Time</small>
                                            <span class="fw-bold" id="codigoTimeInfoEdit"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Paso 3: Formulario de Modificación -->
                    <div class="step d-none" id="step3">
                        <h4 class="text-center mb-4 fw-bold text-primary">
                            <i class="bi bi-pencil-square me-2"></i>Editar Usuario
                        </h4>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="nuevoNombreEdit" class="form-label fw-bold">
                                            <i class="bi bi-person-fill me-1 text-primary"></i> Nombre de Usuario
                                        </label>
                                        <input type="text" class="form-control" id="nuevoNombreEdit" name="nuevoNombreEdit" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nuevoRangoEdit" class="form-label fw-bold">
                                            <i class="bi bi-award-fill me-1 text-primary"></i> Rango
                                        </label>
                                        <select class="form-select" id="nuevoRangoEdit" name="nuevoRangoEdit" required>
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
                                        <label for="nuevaMisionEdit" class="form-label fw-bold">
                                            <i class="bi bi-briefcase-fill me-1 text-primary"></i> Misión
                                        </label>
                                        <input type="text" class="form-control" id="nuevaMisionEdit" name="nuevaMisionEdit" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="nuevaFirmaEdit" class="form-label fw-bold">
                                            <i class="bi bi-pen-fill me-1 text-primary"></i> Firma (3 dígitos)
                                        </label>
                                        <input type="text" class="form-control" id="nuevaFirmaEdit" name="nuevaFirmaEdit" maxlength="3" required>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="nuevoEstadoEdit" class="form-label fw-bold">
                                            <i class="bi bi-toggle-on me-1 text-primary"></i> Estado
                                        </label>
                                        <select class="form-select" id="nuevoEstadoEdit" name="nuevoEstadoEdit" required>
                                            <option value="">Seleccione un estado</option>
                                            <option value="disponible">Disponible</option>
                                            <option value="pendiente">Pendiente</option>
                                            <option value="ascendido">Ascendido</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="firmaEncargadoEdit" class="form-label fw-bold">
                                            <i class="bi bi-person-check-fill me-1 text-primary"></i> Firma Encargado (3 dígitos)
                                        </label>
                                        <input type="text" class="form-control" id="firmaEncargadoEdit" name="firmaEncargadoEdit" maxlength="3" required>
                                    </div>
                                </div>
                                <input type="hidden" id="usuarioIdEdit" name="usuarioIdEdit">
                                <input type="hidden" id="codigoTimeHiddenEdit" name="codigoTimeHiddenEdit">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Paso 4: Confirmación -->
                    <div class="step d-none" id="step4">
                        <div class="text-center p-5">
                            <div class="display-1 text-success mb-4">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <h4 class="mb-3 fw-bold text-success">¡Usuario Editado Correctamente!</h4>
                            <p class="lead">Los datos del usuario han sido actualizados exitosamente.</p>
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
                <button type="button" class="btn btn-outline-secondary btn-lg" id="prevBtnEdit" disabled>
                     Anterior
                </button>
                <button type="button" class="btn btn-outline-primary btn-lg" id="nextBtnEdit">
                    Siguiente 
                </button>
                <button type="button" class="btn btn-outline-success btn-lg d-none" id="submitBtnEdit">
                     Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Incluye JustValidate desde CDN antes de tu script principal -->
<script>
$(document).ready(function() {
    let currentStepModificarUsuario = 1;
    const totalStepsModificarUsuario = 4;
    let userDataModificarUsuario = {};
    
    // Actualizar la barra de progreso
    function updateProgressBarModificarUsuario() {
        const percent = ((currentStepModificarUsuario - 1) / (totalStepsModificarUsuario - 1)) * 100;
        $('#editar_usuario .progress-bar').css('width', percent + '%').attr('aria-valuenow', percent);
    }
    
    // Mostrar el paso actual
    function showStepModificarUsuario(step) {
        $('#editar_usuario .step').addClass('d-none');
        $('#editar_usuario #step' + step).removeClass('d-none');
        
        // Actualizar botones
        $('#prevBtnEdit').prop('disabled', step === 1);
        $('#nextBtnEdit').toggleClass('d-none', step === 3 || step === 4);
        $('#submitBtnEdit').toggleClass('d-none', step !== 3);
        
        // Actualizar progreso
        currentStepModificarUsuario = step;
        updateProgressBarModificarUsuario();
    }
    
    // Buscar usuario por código
    $('#buscarUsuarioEdit').click(function() {
        const codigo = $('#codigoUsuarioEdit').val().trim();
        
        if (codigo.length !== 5) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El código debe tener exactamente 5 caracteres'
            });
            return;
        }
        
        // Mostrar cargando
        $('#resultadoBusquedaEdit').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
        
        // Realizar petición AJAX
        $.ajax({
            url: '/private/procesos/gestion_ascensos/buscar_usuario.php',
            type: 'POST',
            data: { codigo: codigo },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    userDataModificarUsuario = response.data;
                    
                    // Mostrar información del usuario
                    $('#nombreUsuarioEdit').text(userDataModificarUsuario.usuario_registro);
                    $('#rangoActualEdit').text(userDataModificarUsuario.rango_actual);
                    $('#misionActualEdit').text(userDataModificarUsuario.mision_actual);
                    $('#firmaUsuarioEdit').text(userDataModificarUsuario.firma_usuario ? userDataModificarUsuario.firma_usuario : 'No disponible');
                    $('#codigoTimeInfoEdit').text(userDataModificarUsuario.codigo_time);
                    
                    // Mostrar estado con badge
                    let badgeClass = 'bg-warning';
                    if (userDataModificarUsuario.estado_ascenso === 'ascendido') {
                        badgeClass = 'bg-success';
                    } else if (userDataModificarUsuario.estado_ascenso === 'pendiente') {
                        badgeClass = 'bg-danger';
                    }
                    $('#estadoAscensoEdit').html(`<span class="badge ${badgeClass}">${userDataModificarUsuario.estado_ascenso}</span>`);
                    
                    // Prellenar los campos del formulario de modificación
                    $('#nuevoNombreEdit').val(userDataModificarUsuario.usuario_registro);
                    $('#nuevoRangoEdit').val(userDataModificarUsuario.rango_actual);
                    $('#nuevaMisionEdit').val(userDataModificarUsuario.mision_actual);
                    $('#nuevaFirmaEdit').val(userDataModificarUsuario.firma_usuario);
                    $('#nuevoEstadoEdit').val(userDataModificarUsuario.estado_ascenso);
                    $('#usuarioIdEdit').val(userDataModificarUsuario.ascenso_id);
                    $('#codigoTimeHiddenEdit').val(userDataModificarUsuario.codigo_time);
                    
                    // Mostrar el resultado
                    $('#resultadoBusquedaEdit').html(`
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-2"></i> Usuario encontrado: <strong>${userDataModificarUsuario.usuario_registro}</strong>
                        </div>
                    `);
                    
                    // Habilitar el botón siguiente
                    $('#nextBtnEdit').prop('disabled', false);
                } else {
                    // Mostrar mensaje de error
                    $('#resultadoBusquedaEdit').html(`
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> ${response.message}
                        </div>
                    `);
                    
                    // Deshabilitar el botón siguiente
                    $('#nextBtnEdit').prop('disabled', true);
                }
            },
            error: function() {
                // Mostrar mensaje de error
                $('#resultadoBusquedaEdit').html(`
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Error de conexión. Inténtelo de nuevo.
                    </div>
                `);
                
                // Deshabilitar el botón siguiente
                $('#nextBtnEdit').prop('disabled', true);
            }
        });
    });
    
    // Botón Anterior
    $('#prevBtnEdit').click(function() {
        if (currentStepModificarUsuario > 1) {
            showStepModificarUsuario(currentStepModificarUsuario - 1);
        }
    });
    
    // Botón Siguiente
    $('#nextBtnEdit').click(function() {
        if (currentStepModificarUsuario < totalStepsModificarUsuario) {
            showStepModificarUsuario(currentStepModificarUsuario + 1);
        }
    });
    
    // Botón Guardar Cambios
    $('#submitBtnEdit').click(function() {
        // Validar formulario
        const nuevoNombre = $('#nuevoNombreEdit').val().trim();
        const nuevoRango = $('#nuevoRangoEdit').val();
        const nuevaMision = $('#nuevaMisionEdit').val().trim();
        const nuevaFirma = $('#nuevaFirmaEdit').val().trim();
        const nuevoEstado = $('#nuevoEstadoEdit').val();
        const firmaEncargado = $('#firmaEncargadoEdit').val().trim();
        
        if (!nuevoNombre || !nuevoRango || !nuevaMision || !nuevaFirma || !nuevoEstado || !firmaEncargado) {
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
            text: 'Actualizando información del usuario...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Preparar datos para enviar
        const formData = new FormData();
        formData.append('ascenso_id', $('#usuarioIdEdit').val());
        formData.append('codigo_time', $('#codigoTimeHiddenEdit').val());
        formData.append('usuario_registro', nuevoNombre);
        formData.append('rango_actual', nuevoRango);
        formData.append('mision_actual', nuevaMision);
        formData.append('firma_usuario', nuevaFirma);
        formData.append('estado_ascenso', nuevoEstado);
        formData.append('firma_encargado', firmaEncargado);
        formData.append('action', 'modificar_usuario');
        
        // Realizar petición AJAX
        $.ajax({
            url: '/private/procesos/gestion_usuarios/modificar_usuario.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.close();
                    showStepModificarUsuario(4);
                    
                    // Redireccionar después de 3 segundos
                    setTimeout(function() {
                        window.location.href = '/usuario/index.php?page=gestion de usuarios';
                    }, 3000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Error al modificar el usuario'
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
    showStepModificarUsuario(1);
});
</script>