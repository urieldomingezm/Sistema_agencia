<?php
// Modal Wizard para Dar Ascenso
?>

<div class="modal fade" id="ascensoWizardModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ascensoWizardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
            <!-- Encabezado del Modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="ascensoWizardModalLabel">
                    Wizard de Ascenso
                </h5>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <!-- Indicador de pasos -->
                <div class="progress mb-4" style="height: 10px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <!-- Formulario de múltiples pasos -->
                <form id="ascensoWizardForm">
                    <!-- Paso 1: Buscar Usuario -->
                    <div class="step" id="step1_ascenso">
                        <h4 class="text-center mb-4 fw-bold text-primary">Paso 1: Buscar Usuario</h4>
                        <div class="card mb-3">
                            <div class="card-body">
                                <p>Utiliza el campo de búsqueda para encontrar al usuario que deseas ascender.</p>
                                <div class="mb-3">
                                    <label for="searchInputAscenso" class="form-label fw-bold">
                                        <i class="bi bi-person-badge me-1"></i> Nombre de Usuario o Código:
                                    </label>
                                    <div class="input-group input-group-lg mb-3">
                                        <span class="input-group-text">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" class="form-control" id="searchInputAscenso" placeholder="Escribe aquí para buscar..." autocomplete="off">
                                        <button class="btn btn-primary" type="button" id="buscarUsuarioAscenso">
                                            <i class="bi bi-search me-1"></i> Buscar
                                        </button>
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i> Ingresa el nombre o código del usuario.
                                    </div>
                                </div>
                                <div id="searchResultsAscenso" class="mt-3">
                                    <!-- Los resultados de la búsqueda se mostrarán aquí -->
                                    <p class="text-muted">Ingresa un término de búsqueda para empezar.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 2: Información del Usuario -->
                    <div class="step d-none" id="step2_ascenso">
                        <h4 class="text-center mb-4 fw-bold text-primary">Paso 2: Información del Usuario</h4>
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h5 class="mb-0 fw-bold">
                                    <i class="bi bi-person-badge-fill me-2 text-primary"></i>Datos del Usuario
                                </h5>
                            </div>
                            <div class="card-body">
                                <p>Verifica la información del usuario seleccionado antes de proceder.</p>
                                <div id="userInfoAscenso">
                                    <!-- La información del usuario seleccionado se mostrará aquí -->
                                    <p class="text-muted">Selecciona un usuario de los resultados de búsqueda.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 3: Confirmar Ascenso -->
                    <div class="step d-none" id="step3_ascenso">
                        <h4 class="text-center mb-4 fw-bold text-primary">Paso 3: Confirmar Ascenso</h4>
                        <div class="card mb-3">
                            <div class="card-body">
                                <p>Confirma que deseas ascender a este usuario. El proceso será automático.</p>
                                <div id="ascensoConfirmationAscenso">
                                    <!-- Mensaje de confirmación y/o resultado del ascenso -->
                                    <p class="text-muted">Información del usuario a ascender.</p>
                                </div>
                                <div id="ascensoResultAscenso" class="mt-3">
                                    <!-- El resultado del proceso de ascenso se mostrará aquí -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 4: Confirmación Final -->
                    <div class="step d-none" id="step4_ascenso">
                        <div class="text-center p-5">
                            <div class="display-1 text-success mb-4">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <h4 class="mb-3 fw-bold text-success">¡Ascenso Realizado Correctamente!</h4>
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
                    Confirmar Ascenso
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script para el funcionamiento del modal -->
<script>
    $(document).ready(function() {
        let pasoActualAscenso = 1;
        const totalPasosAscenso = 4; // Incluye el paso de confirmación final
        let datosUsuarioAscenso = {}; // Para almacenar los datos del usuario buscado

        // Actualizar la barra de progreso
        function actualizarBarraProgresoAscenso() {
            // La barra de progreso va del paso 1 al 3 (antes de la confirmación final)
            const porcentaje = ((pasoActualAscenso - 1) / (totalPasosAscenso - 1)) * 100;
            $('#ascensoWizardModal .progress-bar').css('width', porcentaje + '%').attr('aria-valuenow', porcentaje);
        }

        // Mostrar el paso actual
        function mostrarPasoAscenso(paso) {
            $('#ascensoWizardModal .step').addClass('d-none');
            $('#step' + paso + '_ascenso').removeClass('d-none');

            // Actualizar botones
            $('#prevBtnAscenso').prop('disabled', paso === 1 || paso === totalPasosAscenso); // Deshabilitar Anterior en paso 1 y en el paso final
            $('#nextBtnAscenso').toggleClass('d-none', paso === totalPasosAscenso - 1 || paso === totalPasosAscenso); // Ocultar Siguiente en el paso de confirmación y el final
            $('#submitBtnAscenso').toggleClass('d-none', paso !== totalPasosAscenso - 1); // Mostrar Submit solo en el paso de confirmación (Paso 3)

            // Actualizar progreso
            pasoActualAscenso = paso;
            actualizarBarraProgresoAscenso();
        }

        // Buscar usuario por nombre o código
        $('#buscarUsuarioAscenso').click(function() {
            const searchTerm = $('#searchInputAscenso').val().trim();
            const searchResultsDiv = $('#searchResultsAscenso');

            if (searchTerm.length < 3) {
                searchResultsDiv.html('<p class="text-danger"><i class="bi bi-exclamation-triangle-fill me-1"></i> Ingresa al menos 3 caracteres para buscar.</p>');
                $('#nextBtnAscenso').prop('disabled', true); // Deshabilitar Siguiente si no hay búsqueda válida
                return;
            }

            // Mostrar cargando
            searchResultsDiv.html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>');
            $('#nextBtnAscenso').prop('disabled', true); // Deshabilitar Siguiente mientras busca

            // Realizar petición AJAX para buscar usuario
            $.ajax({
                url: '/private/procesos/gestion_ascensos/buscar_usuario.php', // Ajusta esta URL si es diferente
                type: 'POST',
                data: {
                    term: searchTerm // Usar 'term' o el nombre de parámetro que espere tu backend
                },
                dataType: 'json',
                success: function(respuesta) {
                    if (respuesta.success && respuesta.data.length > 0) {
                        let resultsHtml = '<ul class="list-group">';
                        respuesta.data.forEach(usuario => {
                            // Asegúrate de que los nombres de las propiedades coincidan con la respuesta de tu backend
                            resultsHtml += `
                                <li class="list-group-item list-group-item-action"
                                    data-user-id="${usuario.id}"
                                    data-user-codigo="${usuario.codigo_time}"
                                    data-user-name="${usuario.usuario_registro}"
                                    data-user-rango="${usuario.rango_actual}"
                                    data-user-mision="${usuario.mision_actual}"
                                    data-user-estado="${usuario.estado_ascenso}">
                                    <strong>${usuario.usuario_registro}</strong> (${usuario.codigo_time}) - Rango: ${usuario.rango_actual}
                                </li>
                            `;
                        });
                        resultsHtml += '</ul>';
                        searchResultsDiv.html(resultsHtml);

                        // Añadir event listeners a los resultados
                        searchResultsDiv.find('.list-group-item').click(function() {
                            // Almacenar los datos del usuario seleccionado
                            datosUsuarioAscenso = {
                                id: $(this).data('user-id'),
                                codigo_time: $(this).data('user-codigo'),
                                usuario_registro: $(this).data('user-name'),
                                rango_actual: $(this).data('user-rango'),
                                mision_actual: $(this).data('user-mision'),
                                estado_ascenso: $(this).data('user-estado')
                            };

                            // Mostrar información del usuario seleccionado en el Paso 2
                            $('#userInfoAscenso').html(`
                                <p><strong>Usuario Seleccionado:</strong> ${datosUsuarioAscenso.usuario_registro}</p>
                                <p><strong>Código:</strong> ${datosUsuarioAscenso.codigo_time}</p>
                                <p><strong>Rango Actual:</strong> ${datosUsuarioAscenso.rango_actual}</p>
                                <p><strong>Misión Actual:</strong> ${datosUsuarioAscenso.mision_actual}</p>
                                <p><strong>Estado de Ascenso:</strong> ${datosUsuarioAscenso.estado_ascenso}</p>
                                <!-- Agrega más campos si son necesarios para el ascenso -->
                            `);

                            // Mostrar información del usuario en el Paso 3 para confirmación
                             $('#ascensoConfirmationAscenso').html(`
                                <p>¿Estás seguro de que deseas ascender a <strong>${datosUsuarioAscenso.usuario_registro}</strong>?</p>
                                <p>Su rango actual es: <strong>${datosUsuarioAscenso.rango_actual}</strong>.</p>
                                <!-- Puedes añadir aquí información sobre el próximo rango si tu backend la proporciona -->
                            `);


                            // Habilitar el botón Siguiente
                            $('#nextBtnAscenso').prop('disabled', false);

                            // Opcional: Resaltar el elemento seleccionado
                            searchResultsDiv.find('.list-group-item').removeClass('active');
                            $(this).addClass('active');
                        });

                    } else {
                        searchResultsDiv.html('<div class="alert alert-warning"><i class="bi bi-exclamation-triangle-fill me-1"></i> No se encontraron usuarios.</div>');
                        $('#nextBtnAscenso').prop('disabled', true); // Deshabilitar Siguiente si no hay resultados
                    }
                },
                error: function() {
                    searchResultsDiv.html('<div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill me-1"></i> Error al buscar usuario. Inténtelo de nuevo.</div>');
                    $('#nextBtnAscenso').prop('disabled', true); // Deshabilitar Siguiente en caso de error
                }
            });
        });

        // Botón siguiente
        $('#nextBtnAscenso').click(function() {
            // Validaciones antes de pasar al siguiente paso
            if (pasoActualAscenso === 1) {
                // En el paso 1, verificar si se ha seleccionado un usuario
                if (!datosUsuarioAscenso || !datosUsuarioAscenso.id) {
                     Swal.fire({
                        icon: 'warning',
                        title: 'Atención',
                        text: 'Debes seleccionar un usuario de la lista de resultados.'
                    });
                    return; // No avanzar si no hay usuario seleccionado
                }
                 // Si el usuario ya está en estado 'ascendido', no permitir avanzar
                if (datosUsuarioAscenso.estado_ascenso === 'ascendido') {
                     Swal.fire({
                        icon: 'warning',
                        title: 'Atención',
                        text: 'Este usuario ya ha sido ascendido recientemente.'
                    });
                    return; // No avanzar si el estado es 'ascendido'
                }
            }
             // Puedes añadir más validaciones para otros pasos si es necesario

            if (pasoActualAscenso < totalPasosAscenso) {
                mostrarPasoAscenso(pasoActualAscenso + 1);
            }
        });

        // Botón anterior
        $('#prevBtnAscenso').click(function() {
            if (pasoActualAscenso > 1) {
                mostrarPasoAscenso(pasoActualAscenso - 1);
            }
        });

        // Botón Confirmar Ascenso (Submit)
        $('#submitBtnAscenso').click(function() {
            // Validar que se haya seleccionado un usuario
            if (!datosUsuarioAscenso || !datosUsuarioAscenso.id) {
                 Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se ha seleccionado ningún usuario para ascender.'
                });
                return;
            }

            // Mostrar cargando
            Swal.fire({
                title: 'Procesando Ascenso',
                text: 'Realizando el ascenso automático...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Realizar petición AJAX para realizar el ascenso
            $.ajax({
                url: '/private/procesos/gestion_ascensos/realizar_ascenso.php', // Ajusta esta URL
                type: 'POST',
                data: {
                    usuario_id: datosUsuarioAscenso.id,
                    codigo_time: datosUsuarioAscenso.codigo_time // Enviar código_time si es necesario para el proceso
                    // Puedes añadir otros datos necesarios aquí
                },
                dataType: 'json',
                success: function(respuestaAscenso) {
                    Swal.close();

                    if (respuestaAscenso.success) {
                        // Mostrar paso de confirmación final
                        mostrarPasoAscenso(totalPasosAscenso);

                        // Redireccionar o cerrar modal después de 3 segundos
                        setTimeout(function() {
                            $('#ascensoWizardModal').modal('hide');
                            // Opcional: Recargar la página o actualizar la tabla de ascensos
                            window.location.reload();
                        }, 3000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error en Ascenso',
                            text: respuestaAscenso.message || 'Ocurrió un error al realizar el ascenso.'
                        });
                         // Opcional: Volver al paso anterior o mostrar un mensaje en el paso 3
                         $('#ascensoResultAscenso').html(`<div class="alert alert-danger mt-3">${respuestaAscenso.message || 'Error desconocido.'}</div>`);
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Conexión',
                        text: 'Error de conexión con el servidor. Inténtelo de nuevo.'
                    });
                     $('#ascensoResultAscenso').html('<div class="alert alert-danger mt-3">Error de conexión con el servidor.</div>');
                }
            });
        });

        // Inicializar el modal
        $('#ascensoWizardModal').on('show.bs.modal', function() {
            // Resetear el formulario y el estado al abrir el modal
            $('#ascensoWizardForm')[0].reset();
            $('#searchResultsAscenso').html('<p class="text-muted">Ingresa un término de búsqueda para empezar.</p>');
            $('#userInfoAscenso').html('<p class="text-muted">Selecciona un usuario de los resultados de búsqueda.</p>');
            $('#ascensoConfirmationAscenso').html('<p class="text-muted">Información del usuario a ascender.</p>');
            $('#ascensoResultAscenso').html(''); // Limpiar resultados anteriores
            datosUsuarioAscenso = {}; // Limpiar datos del usuario seleccionado

            // Mostrar el primer paso
            mostrarPasoAscenso(1);
        });

        // Asegurarse de que los botones Anterior y Siguiente estén habilitados/deshabilitados correctamente al abrir
         $('#ascensoWizardModal').on('shown.bs.modal', function() {
             mostrarPasoAscenso(pasoActualAscenso); // Re-aplicar el estado de los botones
         });

    });
</script>

<style>
/* Puedes mantener o ajustar estilos si es necesario */
</style>