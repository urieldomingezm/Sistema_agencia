<div class="modal fade" id="dar_tiempo_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dar_tiempo_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="dar_tiempo_modalLabel">
                    Gestión de Tiempo
                </h5>
            </div>
            <div class="modal-body">
                <div class="progress mb-4" style="height: 10px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <form id="tiempoFormModal">
                    <div class="step" id="step1_tiempo">
                        <h4 class="text-center mb-4 fw-bold text-primary">Paso 1: Buscar Usuario</h4>
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
                    <div class="step d-none" id="step2_tiempo">
                        <h4 class="text-center mb-4 fw-bold text-primary">Paso 2: Información del Tiempo</h4>
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
                    <div class="step d-none" id="step3_tiempo">
                        <div class="text-center p-5">
                            <div class="display-1 text-success mb-4">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <h4 class="mb-3 fw-bold text-success">¡Registro Completado!</h4>
                            <p class="lead">La gestión del tiempo del usuario ha sido procesada exitosamente.</p>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let pasoActualGestionTiempo = 1;
        const totalPasosGestionTiempo = 3;
        let datosUsuarioTiempo = {};

        const darTiempoModal = document.getElementById('dar_tiempo_modal');
        const progressBar = darTiempoModal.querySelector('.progress-bar');
        const steps = darTiempoModal.querySelectorAll('.step');
        const codigoTimeInput = document.getElementById('codigoTimeTiempo');
        const buscarUsuarioBtn = document.getElementById('buscarUsuarioTiempo');
        const resultadoBusquedaDiv = document.getElementById('resultadoBusquedaTiempo');
        const nombreUsuarioSpan = document.getElementById('nombreUsuarioTiempo');
        const estadoTiempoSpan = document.getElementById('estadoTiempoModal');
        const tiempoTranscurridoSpan = document.getElementById('tiempoTranscurrido');
        const tiempoAcumuladoSpan = document.getElementById('tiempoAcumulado');
        const tiempoRestadoSpan = document.getElementById('tiempoRestado');
        const tiempoEncargadoSpan = document.getElementById('tiempoEncargado');
        const prevBtn = document.getElementById('prevBtnTiempo');
        const nextBtn = document.getElementById('nextBtnTiempo');
        const submitBtn = document.getElementById('submitBtnTiempo');
        const tiempoForm = document.getElementById('tiempoFormModal');

        function actualizarBarraProgresoTiempo() {
            const porcentaje = ((pasoActualGestionTiempo - 1) / (totalPasosGestionTiempo - 1)) * 100;
            progressBar.style.width = porcentaje + '%';
            progressBar.setAttribute('aria-valuenow', porcentaje);
        }

        function mostrarPasoTiempo(paso) {
            steps.forEach(step => step.classList.add('d-none'));
            document.getElementById('step' + paso + '_tiempo').classList.remove('d-none');

            prevBtn.disabled = paso === 1 || paso === totalPasosGestionTiempo;
            nextBtn.classList.toggle('d-none', paso === totalPasosGestionTiempo - 1 || paso === totalPasosGestionTiempo);
            submitBtn.classList.toggle('d-none', paso !== totalPasosGestionTiempo - 1);

            pasoActualGestionTiempo = paso;
            actualizarBarraProgresoTiempo();
        }

        buscarUsuarioBtn.addEventListener('click', function() {
            const codigoUsuario = codigoTimeInput.value.trim();
            const usuarioActual = '<?php echo $_SESSION['username']; ?>';

            if (codigoUsuario.length !== 5) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El código debe tener exactamente 5 caracteres'
                });
                return;
            }

            resultadoBusquedaDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';
            nextBtn.disabled = true;

            fetch('/private/procesos/gestion_tiempos/buscar_usuario.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'codigo=' + encodeURIComponent(codigoUsuario)
            })
            .then(response => response.json())
            .then(respuesta => {
                if (respuesta.success) {
                    datosUsuarioTiempo = respuesta.data;

                    if (datosUsuarioTiempo.usuario_registro === usuarioActual) {
                        resultadoBusquedaDiv.innerHTML = `
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                No puedes asignarte tiempo a ti mismo.
                            </div>
                        `;
                        nextBtn.disabled = true;
                        return;
                    }

                    nombreUsuarioSpan.textContent = datosUsuarioTiempo.usuario_registro;
                    tiempoAcumuladoSpan.textContent = datosUsuarioTiempo.tiempo_acumulado;
                    tiempoRestadoSpan.textContent = datosUsuarioTiempo.tiempo_restado;
                    tiempoTranscurridoSpan.textContent = datosUsuarioTiempo.tiempo_transcurrido || 'No disponible';
                    tiempoEncargadoSpan.textContent = datosUsuarioTiempo.tiempo_encargado_usuario || 'No asignado';

                    let claseEstado = 'bg-warning';
                    if (datosUsuarioTiempo.tiempo_status === 'activo') {
                        claseEstado = 'bg-success';
                    } else if (datosUsuarioTiempo.tiempo_status === 'finalizado') {
                        claseEstado = 'bg-danger';
                    }
                    estadoTiempoSpan.innerHTML = `<span class="badge ${claseEstado}">${datosUsuarioTiempo.tiempo_status}</span>`;

                    if (datosUsuarioTiempo.tiempo_encargado_usuario && datosUsuarioTiempo.tiempo_encargado_usuario.trim() !== '') {
                        resultadoBusquedaDiv.innerHTML = `
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Atención:</strong> Este usuario ya tiene asignado a <strong>${datosUsuarioTiempo.tiempo_encargado_usuario}</strong> como encargado de su tiempo.
                                No se puede proceder con la activación.
                            </div>
                        `;
                        nextBtn.disabled = true;
                    } else {
                        resultadoBusquedaDiv.innerHTML = `
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill me-2"></i> Usuario encontrado: <strong>${datosUsuarioTiempo.usuario_registro}</strong>
                            </div>
                        `;
                        nextBtn.disabled = false;
                    }
                } else {
                    resultadoBusquedaDiv.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> ${respuesta.message}
                        </div>
                    `;
                    nextBtn.disabled = true;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultadoBusquedaDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Error de conexión. Inténtelo de nuevo.
                    </div>
                `;
                nextBtn.disabled = true;
            });
        });

        nextBtn.addEventListener('click', function() {
            if (pasoActualGestionTiempo === 1) {
                if (!datosUsuarioTiempo || !datosUsuarioTiempo.codigo_time || nextBtn.disabled) {
                     Swal.fire({
                        icon: 'warning',
                        title: 'Atención',
                        text: 'Debes buscar y encontrar un usuario válido antes de continuar.'
                    });
                    return;
                }
            }

            if (pasoActualGestionTiempo < totalPasosGestionTiempo) {
                mostrarPasoTiempo(pasoActualGestionTiempo + 1);
            }
        });

        prevBtn.addEventListener('click', function() {
            if (pasoActualGestionTiempo > 1) {
                mostrarPasoTiempo(pasoActualGestionTiempo - 1);
            }
        });

        submitBtn.addEventListener('click', function() {
            if (!datosUsuarioTiempo || !datosUsuarioTiempo.codigo_time) {
                 Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se ha seleccionado ningún usuario para registrar el tiempo.'
                });
                return;
            }

            Swal.fire({
                title: 'Procesando Registro',
                text: 'Registrando la gestión del tiempo...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new URLSearchParams();
            formData.append('codigo_time', datosUsuarioTiempo.codigo_time);
            formData.append('tiempo_status', 'activo');
            formData.append('tiempo_encargado_usuario', '<?php echo $_SESSION['username']; ?>');

            fetch('/private/procesos/gestion_tiempos/activar_tiempo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: formData
            })
            .then(response => response.json())
            .then(respuestaTiempo => {
                Swal.close();

                if (respuestaTiempo.success) {
                    mostrarPasoTiempo(totalPasosGestionTiempo);

                    setTimeout(function() {
                        const modalInstance = bootstrap.Modal.getInstance(darTiempoModal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                        window.location.reload();
                    }, 3000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error en Registro',
                        text: respuestaTiempo.message || 'Error al registrar la gestión del tiempo.'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Conexión',
                    text: 'Error de conexión con el servidor. Inténtelo de nuevo.'
                });
            });
        });

        darTiempoModal.addEventListener('show.bs.modal', function() {
            tiempoForm.reset();
            resultadoBusquedaDiv.innerHTML = '';
            nombreUsuarioSpan.textContent = '';
            tiempoAcumuladoSpan.textContent = '';
            tiempoRestadoSpan.textContent = '';
            tiempoTranscurridoSpan.textContent = '';
            tiempoEncargadoSpan.textContent = '';
            estadoTiempoSpan.innerHTML = '';
            datosUsuarioTiempo = {};

            mostrarPasoTiempo(1);
        });

         darTiempoModal.addEventListener('shown.bs.modal', function() {
             mostrarPasoTiempo(pasoActualGestionTiempo);
         });
    });
</script>
