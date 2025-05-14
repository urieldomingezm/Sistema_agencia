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
                                        <label for="tiempoAcumuladoInfo" class="form-label fw-bold">
                                            <i class="bi bi-plus-circle-fill me-1 text-primary"></i> Tiempo Acumulado (Solo lectura)
                                        </label>
                                        <input type="text" class="form-control bg-light" id="tiempoAcumuladoInfo" name="tiempoAcumuladoInfo" readonly>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="tiempoRestadoInfo" class="form-label fw-bold">
                                            <i class="bi bi-dash-circle-fill me-1 text-primary"></i> Tiempo Restado (Solo lectura)
                                        </label>
                                        <input type="text" class="form-control bg-light" id="tiempoRestadoInfo" name="tiempoRestadoInfo" readonly>
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
                            <h4 class="mb-3 fw-bold text-success">¡Tiempo se activo Correctamente!</h4>
                            <p class="lead">El tiempo del usuario ha sido activada exitosamente.</p>
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
<script src="/public/assets/custom_general/custom_gestion_tiempos/index_dar_tiempo.js"></script>

