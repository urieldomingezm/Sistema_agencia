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
                                            <option value="Administrador">Administrador</option>
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
<script src="/public/assets/custom_general/custom_ascensos/dar_ascenso.js"></script>
