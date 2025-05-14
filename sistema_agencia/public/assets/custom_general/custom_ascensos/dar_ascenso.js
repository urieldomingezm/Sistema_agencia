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
                tiempoEspera = 10;
                break;
            case 'Seguridad':
                tiempoEspera = 240; // 4 horas
                break;
            case 'Tecnico':
                tiempoEspera = 1080; // 18 horas
                break;
            case 'Logistica':
                tiempoEspera = 1560; // 26 horas
                break;
            case 'Supervisor':
                tiempoEspera = 5760; // 4 días
                break;
            case 'Director':
                tiempoEspera = 12960; // 9 días
                break;
            case 'Presidente':
                tiempoEspera = 20160; // 14 días
                break;
            case 'Operativo':
                tiempoEspera = 34560; // 24 días
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