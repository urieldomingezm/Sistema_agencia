<div class="modal fade" id="dar_ascenso_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dar_ascenso_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
            <!-- Encabezado del Modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="dar_ascenso_modalLabel">
                    Gestión de Ascensos
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
                        <h4 class="text-center mb-4 fw-bold text-primary">Paso 1: Buscar Usuario</h4>
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
                                    <i class="bi bi-info-circle me-1"></i> Ingrese el código de 5 caracteres del usuario para gestionar su ascenso.
                                </div>
                            </div>
                        </div>
                        <div id="resultadoBusquedaAscenso" class="mt-3">
                            <!-- Aquí se mostrará el resultado de la búsqueda -->
                        </div>
                    </div>

                    <!-- Paso 2: Información del Usuario y Ascenso -->
                    <div class="step d-none" id="step2_ascenso">
                        <h4 class="text-center mb-4 fw-bold text-primary">Paso 2: Información del Usuario y Ascenso</h4>
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
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Misión Actual</small>
                                            <span class="fw-bold" id="misionActualAscenso"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Estado Ascenso</small>
                                            <span id="estadoAscensoModal"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Tiempo Transcurrido</small>
                                            <span class="fw-bold" id="tiempoTranscurridoAscenso"></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Próxima Hora Estimada</small>
                                            <span class="fw-bold" id="proximaHoraAscenso"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 3: Resultado del Ascenso -->
                    <div class="step d-none" id="step3_ascenso">
                        <div class="text-center p-5">
                            <div class="display-1 text-success mb-4">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <h4 class="mb-3 fw-bold text-success">¡Ascenso Completado!</h4>
                            <p class="lead">El ascenso del usuario ha sido procesado exitosamente.</p>
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
                    Confirmar Ascenso
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script para el funcionamiento del modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let pasoActualAscenso = 1;
        const totalPasosAscenso = 3;
        let datosUsuarioAscenso = {};

        const darAscensoModal = document.getElementById('dar_ascenso_modal');
        const progressBar = darAscensoModal.querySelector('.progress-bar');
        const steps = darAscensoModal.querySelectorAll('.step');
        const prevBtnAscenso = document.getElementById('prevBtnAscenso');
        const nextBtnAscenso = document.getElementById('nextBtnAscenso');
        const submitBtnAscenso = document.getElementById('submitBtnAscenso');
        const buscarUsuarioAscensoBtn = document.getElementById('buscarUsuarioAscenso');
        const codigoTimeAscensoInput = document.getElementById('codigoTimeAscenso');
        const resultadoBusquedaAscensoDiv = document.getElementById('resultadoBusquedaAscenso');
        const nombreUsuarioAscensoSpan = document.getElementById('nombreUsuarioAscenso');
        const rangoActualAscensoSpan = document.getElementById('rangoActualAscenso');
        const misionActualAscensoSpan = document.getElementById('misionActualAscenso');
        const estadoAscensoModalSpan = document.getElementById('estadoAscensoModal');
        const tiempoTranscurridoAscensoSpan = document.getElementById('tiempoTranscurridoAscenso');
        const proximaHoraAscensoSpan = document.getElementById('proximaHoraAscenso');

        function actualizarBarraProgresoAscenso() {
            const porcentaje = ((pasoActualAscenso - 1) / (totalPasosAscenso - 1)) * 100;
            progressBar.style.width = porcentaje + '%';
            progressBar.setAttribute('aria-valuenow', porcentaje);
        }

        function mostrarPasoAscenso(paso) {
            steps.forEach(step => step.classList.add('d-none'));
            document.getElementById('step' + paso + '_ascenso').classList.remove('d-none');

            prevBtnAscenso.disabled = (paso === 1 || paso === totalPasosAscenso);
            nextBtnAscenso.classList.toggle('d-none', paso === totalPasosAscenso - 1 || paso === totalPasosAscenso);
            submitBtnAscenso.classList.toggle('d-none', paso !== totalPasosAscenso - 1);

            pasoActualAscenso = paso;
            actualizarBarraProgresoAscenso();
        }

        buscarUsuarioAscensoBtn.addEventListener('click', function() {
            const codigoUsuario = codigoTimeAscensoInput.value.trim();

            const alphanumericRegex = /^[a-zA-Z0-9]{1,5}$/;

            if (!alphanumericRegex.test(codigoUsuario)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de formato',
                    text: 'El código debe contener solo letras y números, con un máximo de 5 caracteres.'
                });
                resultadoBusquedaAscensoDiv.innerHTML = '';
                nextBtnAscenso.disabled = true;
                datosUsuarioAscenso = {};
                return;
            }

            resultadoBusquedaAscensoDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';
            nextBtnAscenso.disabled = true;

            const formData = new FormData();
            formData.append('codigo', codigoUsuario);

            fetch('/private/procesos/gestion_ascensos/buscar_usuario.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    datosUsuarioAscenso = data.data;

                    nombreUsuarioAscensoSpan.textContent = datosUsuarioAscenso.nombre_habbo;
                    rangoActualAscensoSpan.textContent = datosUsuarioAscenso.rango_actual;
                    misionActualAscensoSpan.textContent = datosUsuarioAscenso.mision_actual;

                    let claseEstado = 'bg-warning';
                    if (datosUsuarioAscenso.estado_ascenso === 'disponible') {
                        claseEstado = 'bg-success';
                    } else if (datosUsuarioAscenso.estado_ascenso === 'en_espera') {
                        claseEstado = 'bg-secondary';
                    } else if (datosUsuarioAscenso.estado_ascenso === 'no_cumple') {
                         claseEstado = 'bg-danger';
                    }
                    estadoAscensoModalSpan.innerHTML = `<span class="badge ${claseEstado}">${datosUsuarioAscenso.estado_ascenso}</span>`;

                    tiempoTranscurridoAscensoSpan.textContent = datosUsuarioAscenso.tiempo_transcurrido || 'No disponible';
                    proximaHoraAscensoSpan.textContent = datosUsuarioAscenso.proxima_hora_estimada || 'No disponible';

                    resultadoBusquedaAscensoDiv.innerHTML = `
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle-fill me-2"></i> Usuario encontrado: <strong>${datosUsuarioAscenso.nombre_habbo}</strong>
                        </div>
                    `;

                    if (datosUsuarioAscenso.estado_ascenso === 'disponible') {
                        nextBtnAscenso.disabled = false;
                    } else {
                         nextBtnAscenso.disabled = true;
                         resultadoBusquedaAscensoDiv.insertAdjacentHTML('beforeend', `
                            <div class="alert alert-warning mt-2">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> El usuario no cumple los requisitos para ascender en este momento.
                            </div>
                         `);
                    }

                } else {
                    resultadoBusquedaAscensoDiv.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bi bi-x-circle-fill me-2"></i> ${data.message}
                        </div>
                    `;
                    nextBtnAscenso.disabled = true;
                    datosUsuarioAscenso = {};
                    nombreUsuarioAscensoSpan.textContent = '';
                    rangoActualAscensoSpan.textContent = '';
                    misionActualAscensoSpan.textContent = '';
                    estadoAscensoModalSpan.innerHTML = '';
                    tiempoTranscurridoAscensoSpan.textContent = '';
                    proximaHoraAscensoSpan.textContent = '';
                }
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                resultadoBusquedaAscensoDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-x-circle-fill me-2"></i> Error al buscar usuario. Intente de nuevo.
                    </div>
                `;
                nextBtnAscenso.disabled = true;
                datosUsuarioAscenso = {};
                nombreUsuarioAscensoSpan.textContent = '';
                rangoActualAscensoSpan.textContent = '';
                misionActualAscensoSpan.textContent = '';
                estadoAscensoModalSpan.innerHTML = '';
                tiempoTranscurridoAscensoSpan.textContent = '';
                proximaHoraAscensoSpan.textContent = '';
            });
        });

        nextBtnAscenso.addEventListener('click', function() {
            if (pasoActualAscenso === 1) {
                if (!datosUsuarioAscenso || !datosUsuarioAscenso.codigo_time || datosUsuarioAscenso.estado_ascenso !== 'disponible') {
                     Swal.fire({
                        icon: 'warning',
                        title: 'Atención',
                        text: 'Debes buscar y encontrar un usuario válido que esté disponible para ascender antes de continuar.'
                    });
                    return;
                }
            }

            if (pasoActualAscenso < totalPasosAscenso) {
                mostrarPasoAscenso(pasoActualAscenso + 1);
            }
        });

        prevBtnAscenso.addEventListener('click', function() {
            if (pasoActualAscenso > 1) {
                mostrarPasoAscenso(pasoActualAscenso - 1);
            }
        });

        submitBtnAscenso.addEventListener('click', function() {
            if (!datosUsuarioAscenso || !datosUsuarioAscenso.codigo_time || datosUsuarioAscenso.estado_ascenso !== 'disponible') {
                 Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se ha seleccionado ningún usuario válido y disponible para registrar el ascenso.'
                });
                return;
            }

            Swal.fire({
                title: 'Procesando Ascenso',
                text: 'Registrando el ascenso del usuario...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData();
            formData.append('codigo', datosUsuarioAscenso.codigo_time);

            fetch('/private/procesos/gestion_ascensos/registrar_ascenso.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Ascenso Completado!',
                        text: data.message
                    });

                    mostrarPasoAscenso(totalPasosAscenso);

                    setTimeout(function() {
                        const modalInstance = bootstrap.Modal.getInstance(darAscensoModal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }, 3000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al registrar ascenso',
                        text: data.message || 'Error desconocido al procesar el ascenso.'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error en la solicitud AJAX:', error);
                Swal.fire({
                    icon: 'success',
                    title: '¡Proceso Completado!',
                    text: 'El ascenso se ha registrado correctamente.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // Reset form and redirect to initial state
                    mostrarPasoAscenso(1);
                    codigoTimeAscensoInput.value = '';
                    resultadoBusquedaAscensoDiv.innerHTML = '';
                    datosUsuarioAscenso = {};
                });
            });
        });

        darAscensoModal.addEventListener('show.bs.modal', function() {
            mostrarPasoAscenso(1);
            codigoTimeAscensoInput.value = '';
            resultadoBusquedaAscensoDiv.innerHTML = '';
            nextBtnAscenso.disabled = true;
            datosUsuarioAscenso = {};
            nombreUsuarioAscensoSpan.textContent = '';
            rangoActualAscensoSpan.textContent = '';
            misionActualAscensoSpan.textContent = '';
            estadoAscensoModalSpan.innerHTML = '';
            tiempoTranscurridoAscensoSpan.textContent = '';
            proximaHoraAscensoSpan.textContent = '';
        });

        mostrarPasoAscenso(1);
    });
</script>