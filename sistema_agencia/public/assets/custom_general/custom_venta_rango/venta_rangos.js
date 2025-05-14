$(document).ready(function() {
    let currentStepVenta = 1;
    const totalStepsVenta = 4;
    
    // Actualizar la barra de progreso
    function updateProgressBarVenta() {
        const percent = ((currentStepVenta - 1) / (totalStepsVenta - 1)) * 100;
        $('#venta_rangos .progress-bar').css('width', percent + '%').attr('aria-valuenow', percent);
    }
    
    // Mostrar el paso actual
    function showStepVenta(step) {
        $('#venta_rangos .step').addClass('d-none');
        $('#venta_rangos #step' + step).removeClass('d-none');
        
        // Actualizar botones
        $('#prevBtnVenta').prop('disabled', step === 1);
        $('#nextBtnVenta').toggleClass('d-none', step === 3 || step === 4);
        $('#submitBtnVenta').toggleClass('d-none', step !== 3);
        
        // Actualizar progreso
        currentStepVenta = step;
        updateProgressBarVenta();
    }
    
    // Botón Siguiente
    $('#nextBtnVenta').click(function() {
        if (currentStepVenta < totalStepsVenta) {
            showStepVenta(currentStepVenta + 1);
        }
    });
    
    // Botón Anterior
    $('#prevBtnVenta').click(function() {
        if (currentStepVenta > 1) {
            showStepVenta(currentStepVenta - 1);
        }
    });
    
    // Botón Registrar Operación
    $('#submitBtnVenta').click(function() {
        // Validar formulario
        const rangoVenta = $('#rangoVenta').val();
        const costoRango = $('#costoRango').val();
        const vendedor = $('#vendedorRango').val();
        const comprador = $('#compradorRango').val();
        const firmaVendedor = $('#firmaVendedor').val();
        const firmaComprador = $('#firmaComprador').val();
        
        if (!rangoVenta || !costoRango || !vendedor || !comprador || !firmaVendedor || !firmaComprador) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son obligatorios'
            });
            return;
        }
        
        if (firmaVendedor.length !== 3 || firmaComprador.length !== 3) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Las firmas deben tener 3 dígitos'
            });
            return;
        }
        
        // Mostrar cargando
        Swal.fire({
            title: 'Registrando operación',
            text: 'Por favor espere...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        
        // Preparar datos para enviar
        const formData = new FormData();
        formData.append('rangov_tipo', rangoVenta);
        formData.append('rangov_costo', costoRango);
        formData.append('rangov_vendedor', vendedor);
        formData.append('rangov_comprador', comprador);
        formData.append('rangov_firma_vendedor', firmaVendedor);
        formData.append('rangov_firma_comprador', firmaComprador);
        
        // Realizar petición AJAX
        $.ajax({
            url: '/private/procesos/gestion_rangos/registrar_venta.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Mostrar paso de confirmación
                    showStepVenta(4);
                    
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
                        text: response.message || 'Error al registrar la operación'
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
    
    // Inicializar el modal
    $('#venta_rangos').on('show.bs.modal', function() {
        // Resetear el formulario y volver al paso 1
        $('#ventaRangosForm')[0].reset();
        showStepVenta(1);
        $('#nextBtnVenta').prop('disabled', false);
    });
});