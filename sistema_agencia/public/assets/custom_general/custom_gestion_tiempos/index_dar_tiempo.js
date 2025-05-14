
    $(document).ready(function() {
        let pasoActualGestionTiempo = 1;
        const totalPasosGestionTiempo = 4;
        let datosUsuarioTiempo = {};

        // Actualizar la barra de progreso
        function actualizarBarraProgresoTiempo() {
            const porcentaje = ((pasoActualGestionTiempo - 1) / (totalPasosGestionTiempo - 1)) * 100;
            $('#dar_tiempo_modal .progress-bar').css('width', porcentaje + '%').attr('aria-valuenow', porcentaje);
        }

        // Mostrar el paso actual
        function mostrarPasoTiempo(paso) {
            $('#dar_tiempo_modal .step').addClass('d-none');
            $('#step' + paso + '_tiempo').removeClass('d-none');

            // Actualizar botones
            $('#prevBtnTiempo').prop('disabled', paso === 1);
            $('#nextBtnTiempo').toggleClass('d-none', paso === 3 || paso === 4);
            $('#submitBtnTiempo').toggleClass('d-none', paso !== 3);

            // Actualizar progreso
            pasoActualGestionTiempo = paso;
            actualizarBarraProgresoTiempo();
        }

        // Buscar usuario por código
        $('#buscarUsuarioTiempo').click(function() {
            const codigoUsuario = $('#codigoTimeTiempo').val().trim();
            const usuarioActual = '<?php echo $_SESSION['username']; ?>';

            if (codigoUsuario.length !== 5) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'El código debe tener exactamente 5 caracteres'
                });
                return;
            }

            // Mostrar cargando
            $('#resultadoBusquedaTiempo').html('<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>');

            // Realizar petición AJAX
            $.ajax({
                url: '/private/procesos/gestion_tiempos/buscar_usuario.php',
                type: 'POST',
                data: {
                    codigo: codigoUsuario
                },
                dataType: 'json',
                success: function(respuesta) {
                    if (respuesta.success) {
                        datosUsuarioTiempo = respuesta.data;

                        // Validar si el usuario está intentando asignarse tiempo a sí mismo
                        if (datosUsuarioTiempo.usuario_registro === usuarioActual) {
                            $('#resultadoBusquedaTiempo').html(`
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                                    No puedes asignarte tiempo a ti mismo.
                                </div>
                            `);
                            $('#nextBtnTiempo').prop('disabled', true);
                            return;
                        }

                        // Mostrar información del usuario
                        $('#nombreUsuarioTiempo').text(datosUsuarioTiempo.usuario_registro);
                        $('#tiempoAcumulado').text(datosUsuarioTiempo.tiempo_acumulado);
                        $('#tiempoRestado').text(datosUsuarioTiempo.tiempo_restado);
                        $('#tiempoTranscurrido').text(datosUsuarioTiempo.tiempo_transcurrido || 'No disponible');
                        $('#tiempoEncargado').text(datosUsuarioTiempo.tiempo_encargado_usuario || 'No asignado');
                        
                        // Mostrar los valores en los campos informativos del paso 3
                        $('#tiempoAcumuladoInfo').val(datosUsuarioTiempo.tiempo_acumulado);
                        $('#tiempoRestadoInfo').val(datosUsuarioTiempo.tiempo_restado);
                        
                        // Mostrar estado con badge
                        let claseEstado = 'bg-warning';
                        if (datosUsuarioTiempo.tiempo_status === 'activo') {
                            claseEstado = 'bg-success';
                        } else if (datosUsuarioTiempo.tiempo_status === 'finalizado') {
                            claseEstado = 'bg-danger';
                        }
                        $('#estadoTiempoModal').html(`<span class="badge ${claseEstado}">${datosUsuarioTiempo.tiempo_status}</span>`);

                        // Verificar si ya tiene un encargado asignado
                        if (datosUsuarioTiempo.tiempo_encargado_usuario && datosUsuarioTiempo.tiempo_encargado_usuario.trim() !== '') {
                            // Mostrar alerta de que ya tiene encargado
                            $('#resultadoBusquedaTiempo').html(`
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                                    <strong>Atención:</strong> Este usuario ya tiene asignado a <strong>${datosUsuarioTiempo.tiempo_encargado_usuario}</strong> como encargado de su tiempo.
                                    No se puede proceder con la activación.
                                </div>
                            `);
                            
                            // Deshabilitar el botón siguiente
                            $('#nextBtnTiempo').prop('disabled', true);
                        } else {
                            // Mostrar el resultado normal
                            $('#resultadoBusquedaTiempo').html(`
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle-fill me-2"></i> Usuario encontrado: <strong>${datosUsuarioTiempo.usuario_registro}</strong>
                                </div>
                            `);
                            
                            // Habilitar el botón siguiente
                            $('#nextBtnTiempo').prop('disabled', false);
                        }
                    } else {
                        // Mostrar mensaje de error
                        $('#resultadoBusquedaTiempo').html(`
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> ${respuesta.message}
                            </div>
                        `);

                        // Deshabilitar el botón siguiente
                        $('#nextBtnTiempo').prop('disabled', true);
                    }
                },
                error: function() {
                    // Mostrar mensaje de error
                    $('#resultadoBusquedaTiempo').html(`
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Error de conexión. Inténtelo de nuevo.
                        </div>
                    `);
                    $('#nextBtnTiempo').prop('disabled', true);
                }
            });
        });

        // Botón siguiente
        $('#nextBtnTiempo').click(function() {
            if (pasoActualGestionTiempo < totalPasosGestionTiempo) {
                mostrarPasoTiempo(pasoActualGestionTiempo + 1);
            }
        });

        // Botón anterior
        $('#prevBtnTiempo').click(function() {
            if (pasoActualGestionTiempo > 1) {
                mostrarPasoTiempo(pasoActualGestionTiempo - 1);
            }
        });

        // Enviar formulario
        $('#submitBtnTiempo').click(function() {
            // Validar campos
            const estadoTiempo = $('#tiempoStatus').val();
            
            if (!estadoTiempo) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Debe seleccionar un estado para el tiempo'
                });
                return;
            }

            // Mostrar cargando
            Swal.fire({
                title: 'Procesando',
                text: 'Actualizando tiempo...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Realizar petición AJAX
            $.ajax({
                url: '/private/procesos/gestion_tiempos/activar_tiempo.php',
                type: 'POST',
                data: {
                    codigo_time: datosUsuarioTiempo.codigo_time,
                    tiempo_status: estadoTiempo,
                    tiempo_encargado_usuario: $('#nombreEncargadoTiempo').val()
                },
                dataType: 'json',
                success: function(respuestaTiempo) {
                    Swal.close();
                    
                    if (respuestaTiempo.success) {
                        // Mostrar paso de confirmación
                        mostrarPasoTiempo(4);
                        
                        // Redireccionar después de 3 segundos
                        setTimeout(function() {
                            $('#dar_tiempo_modal').modal('hide');
                            window.location.reload();
                        }, 3000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: respuestaTiempo.message || 'Error al actualizar el tiempo'
                        });
                    }
                },
                error: function() {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error de conexión. Inténtelo de nuevo.'
                    });
                }
            });
        });

        // Inicializar el modal
        $('#dar_tiempo_modal').on('show.bs.modal', function() {
            // Resetear el formulario
            $('#tiempoFormModal')[0].reset();
            
            // Mostrar el primer paso
            mostrarPasoTiempo(1);
            
            // Limpiar resultados
            $('#resultadoBusquedaTiempo').html('');
            
            // Deshabilitar botón siguiente
            $('#nextBtnTiempo').prop('disabled', true);
        });
    });
