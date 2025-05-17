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
                         <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-arrow-up-circle-fill me-2 text-primary"></i>Información del Ascenso
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Mostrar Próximo Rango y Próxima Misión automáticamente -->
                                <div class="mb-3">
                                    <small class="text-muted d-block">Próximo Rango</small>
                                    <span class="fw-bold text-success" id="proximoRangoAscenso"></span>
                                </div>
                                 <div class="mb-3">
                                    <small class="text-muted d-block">Próxima Misión</small>
                                    <span class="fw-bold text-success" id="proximaMisionAscenso"></span>
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
        const totalPasosAscenso = 3; // Son 3 pasos
        let datosUsuarioAscenso = {}; // Para almacenar los datos del usuario buscado

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
        // Eliminados proximoRangoAscensoSpan y proximaMisionAscensoSpan

        // Actualizar la barra de progreso
        function actualizarBarraProgresoAscenso() {
            // La barra de progreso va del paso 1 al 2 (antes del resultado final)
            const porcentaje = ((pasoActualAscenso - 1) / (totalPasosAscenso - 1)) * 100;
            progressBar.style.width = porcentaje + '%';
            progressBar.setAttribute('aria-valuenow', porcentaje);
        }

        // Mostrar el paso actual
        function mostrarPasoAscenso(paso) {
            steps.forEach(step => step.classList.add('d-none'));
            document.getElementById('step' + paso + '_ascenso').classList.remove('d-none');

            // Actualizar botones
            prevBtnAscenso.disabled = (paso === 1 || paso === totalPasosAscenso); // Deshabilitar Anterior en paso 1 y en el paso final
            nextBtnAscenso.classList.toggle('d-none', paso === totalPasosAscenso - 1 || paso === totalPasosAscenso); // Ocultar Siguiente en el penúltimo paso (Paso 2) y el final (Paso 3)
            submitBtnAscenso.classList.toggle('d-none', paso !== totalPasosAscenso - 1); // Mostrar Submit solo en el penúltimo paso (Paso 2)

            // Actualizar progreso
            pasoActualAscenso = paso;
            actualizarBarraProgresoAscenso();
        }

        // Buscar usuario por código (Solo estética por ahora)
        buscarUsuarioAscensoBtn.addEventListener('click', function() {
            const codigoUsuario = codigoTimeAscensoInput.value.trim();

            // Nueva validación: máximo 5 caracteres alfanuméricos
            const alphanumericRegex = /^[a-zA-Z0-9]{1,5}$/; // Permite 1 a 5 caracteres alfanuméricos

            if (!alphanumericRegex.test(codigoUsuario)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de formato',
                    text: 'El código debe contener solo letras y números, con un máximo de 5 caracteres.'
                });
                resultadoBusquedaAscensoDiv.innerHTML = ''; // Limpiar resultado anterior
                nextBtnAscenso.disabled = true; // Deshabilitar Siguiente
                datosUsuarioAscenso = {}; // Limpiar datos
                return;
            }

            // --- Lógica de búsqueda simulada (reemplazar con AJAX real después) ---
            // Mostrar cargando
            resultadoBusquedaAscensoDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';
            nextBtnAscenso.disabled = true; // Deshabilitar Siguiente mientras busca

            // Simular una respuesta exitosa después de un breve retraso
            setTimeout(function() {
                // Datos de ejemplo (reemplazar con datos reales de la respuesta AJAX)
                datosUsuarioAscenso = {
                    codigo_time: codigoUsuario,
                    nombre_habbo: 'Usuario Ejemplo',
                    rango_actual: 'Soldado',
                    mision_actual: 'Misión 1',
                    estado_ascenso: 'disponible', // o 'disponible', 'en_espera', 'no_cumple'
                    tiempo_transcurrido: '00:25:00',
                    proxima_hora_estimada: '01/01/1970 00:30', // Formato d/m/Y H:i
                    // Eliminados proximo_rango y proxima_mision de los datos simulados
                };

                // Mostrar información del usuario en el Paso 2 (solo si la búsqueda "simulada" fue exitosa)
                nombreUsuarioAscensoSpan.textContent = datosUsuarioAscenso.nombre_habbo;
                rangoActualAscensoSpan.textContent = datosUsuarioAscenso.rango_actual;
                misionActualAscensoSpan.textContent = datosUsuarioAscenso.mision_actual;

                // Mostrar estado con badge (simulado)
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

                // Mostrar el resultado normal
                resultadoBusquedaAscensoDiv.innerHTML = `
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill me-2"></i> Usuario encontrado: <strong>${datosUsuarioAscenso.nombre_habbo}</strong>
                    </div>
                `;

                // Habilitar el botón siguiente solo si el estado es 'disponible'
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


                // --- Fin Lógica de búsqueda simulada ---

            }, 1000); // Simular 1 segundo de carga
        });

        // Botón siguiente
        nextBtnAscenso.addEventListener('click', function() {
             // Validaciones antes de pasar al siguiente paso
            if (pasoActualAscenso === 1) {
                // En el paso 1, verificar si se ha encontrado un usuario válido y está disponible para ascender (simulado)
                if (!datosUsuarioAscenso || !datosUsuarioAscenso.codigo_time || datosUsuarioAscenso.estado_ascenso !== 'disponible') {
                     Swal.fire({
                        icon: 'warning',
                        title: 'Atención',
                        text: 'Debes buscar y encontrar un usuario válido que esté disponible para ascender antes de continuar.'
                    });
                    return; // No avanzar si no hay usuario válido o no está disponible
                }
            }
             // Puedes añadir más validaciones para otros pasos si es necesario

            if (pasoActualAscenso < totalPasosAscenso) {
                mostrarPasoAscenso(pasoActualAscenso + 1);
            }
        });

        // Botón anterior
        prevBtnAscenso.addEventListener('click', function() {
            if (pasoActualAscenso > 1) {
                mostrarPasoAscenso(pasoActualAscenso - 1);
            }
        });

        // Enviar formulario (Ahora se llama "Confirmar Ascenso" y se activa en el Paso 2)
        submitBtnAscenso.addEventListener('click', function() {
            // Validar que se haya seleccionado un usuario y esté disponible (simulado)
            if (!datosUsuarioAscenso || !datosUsuarioAscenso.codigo_time || datosUsuarioAscenso.estado_ascenso !== 'disponible') {
                 Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se ha seleccionado ningún usuario válido y disponible para registrar el ascenso.'
                });
                return;
            }

            // --- Lógica de registro simulada (reemplazar con AJAX real después) ---
            // Mostrar cargando
            Swal.fire({
                title: 'Procesando Ascenso',
                text: 'Registrando el ascenso del usuario...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Simular una respuesta exitosa después de un breve retraso
            setTimeout(function() {
                Swal.close();

                // Mostrar paso de confirmación final (Paso 3)
                mostrarPasoAscenso(totalPasosAscenso);

                // Redireccionar después de 3 segundos
                setTimeout(function() {
                    // Cerrar el modal usando la API de Bootstrap 5
                    const modalInstance = bootstrap.Modal.getInstance(darAscensoModal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                    // window.location.reload(); // Descomentar para recargar la página
                }, 3000);

            }, 1500); // Simular 1.5 segundos de carga
            // --- Fin Lógica de registro simulada ---
        });

        // Inicializar el modal
        darAscensoModal.addEventListener('show.bs.modal', function() {
            // Resetear el formulario
            document.getElementById('ascensoFormModal').reset();

            // Limpiar resultados de búsqueda y datos de usuario
            resultadoBusquedaAscensoDiv.innerHTML = '';
            nombreUsuarioAscensoSpan.textContent = '';
            rangoActualAscensoSpan.textContent = '';
            misionActualAscensoSpan.textContent = '';
            estadoAscensoModalSpan.innerHTML = '';
            tiempoTranscurridoAscensoSpan.textContent = '';
            proximaHoraAscensoSpan.textContent = '';
            // Eliminados proximoRangoAscensoSpan y proximaMisionAscensoSpan de la limpieza
            datosUsuarioAscenso = {}; // Limpiar datos del usuario seleccionado

            // Mostrar el primer paso
            mostrarPasoAscenso(1);
        });

        // Asegurarse de que los botones Anterior y Siguiente estén habilitados/deshabilitados correctamente al abrir
         darAscensoModal.addEventListener('shown.bs.modal', function() {
             mostrarPasoAscenso(pasoActualAscenso); // Re-aplicar el estado de los botones
         });

    });
</script>

<style>
/* Puedes mantener o ajustar estilos si es necesario */
</style>