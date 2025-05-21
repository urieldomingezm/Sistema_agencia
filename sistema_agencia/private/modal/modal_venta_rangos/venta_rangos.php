<div class="modal fade" id="venta_rangos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="venta_rangosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
        <div class="modal-content">
            <!-- Encabezado del Modal -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="venta_rangosLabel">
                    Venta/Traslado de Rangos
                </h5>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <!-- Indicador de pasos -->
                <div class="progress mb-4" style="height: 10px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <!-- Formulario de múltiples pasos -->
                <form id="ventaRangosForm">
                    <!-- Paso 1: Selección de Rango -->
                    <div class="step" id="step1">
                        <h4 class="text-center mb-4 fw-bold text-primary">Seleccionar Rango</h4>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="rangoVenta" class="form-label fw-bold">
                                            <i class="bi bi-award-fill me-1 text-primary"></i> Rango a Vender/Trasladar
                                        </label>
                                        <select class="form-select" id="rangoVenta" name="rangoVenta" required>
                                            <option value="">Seleccione un rango</option>
                                            <option value="Agente">Agente</option>
                                            <option value="Seguridad">Seguridad</option>
                                            <option value="Tecnico">Técnico</option>
                                            <option value="Logistica">Logística</option>
                                            <option value="Supervisor">Supervisor</option>
                                            <option value="Director">Director</option>
                                            <option value="Presidente">Presidente</option>
                                            <option value="Operativo">Operativo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="costoRango" class="form-label fw-bold">
                                            <i class="bi bi-cash-coin me-1 text-primary"></i> Costo del Rango
                                        </label>
                                        <input type="number" class="form-control" id="costoRango" name="costoRango" required min="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 2: Información de las Partes -->
                    <div class="step d-none" id="step2">
                        <h4 class="text-center mb-4 fw-bold text-primary">Información de las Partes</h4>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="vendedorRango" class="form-label fw-bold">
                                            <i class="bi bi-person-fill me-1 text-primary"></i> Vendedor
                                        </label>
                                        <input type="text" class="form-control" id="vendedorRango" name="vendedorRango" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="compradorRango" class="form-label fw-bold">
                                            <i class="bi bi-person-fill me-1 text-primary"></i> Comprador
                                        </label>
                                        <input type="text" class="form-control" id="compradorRango" name="compradorRango" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 3: Confirmación y Firmas -->
                    <div class="step d-none" id="step3">
                        <h4 class="text-center mb-4 fw-bold text-primary">
                            <i class="bi bi-file-earmark-check-fill me-2"></i>Confirmación
                        </h4>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="firmaVendedor" class="form-label fw-bold">
                                            <i class="bi bi-pen-fill me-1 text-primary"></i> Firma Vendedor (3 dígitos)
                                        </label>
                                        <input type="text" class="form-control" id="firmaVendedor" name="firmaVendedor" maxlength="3" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="firmaComprador" class="form-label fw-bold">
                                            <i class="bi bi-pen-fill me-1 text-primary"></i> Firma Comprador (3 dígitos)
                                        </label>
                                        <input type="text" class="form-control" id="firmaComprador" name="firmaComprador" maxlength="3" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 4: Confirmación Final -->
                    <div class="step d-none" id="step4">
                        <div class="text-center p-5">
                            <div class="display-1 text-primary mb-4">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <h4 class="mb-3 fw-bold text-primary">¡Operación Registrada Correctamente!</h4>
                            <p class="lead">La venta/traslado de rango se ha registrado exitosamente.</p>
                            <div class="mt-4">
                                <div class="spinner-grow spinner-grow-sm text-primary me-1" role="status">
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
                <button type="button" class="btn btn-outline-secondary btn-lg" id="prevBtnVenta" disabled>
                     Anterior
                </button>
                <button type="button" class="btn btn-outline-primary btn-lg" id="nextBtnVenta">
                    Siguiente
                </button>
                <button type="button" class="btn btn-outline-primary btn-lg d-none" id="submitBtnVenta">
                     Registrar Operación
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Script para el funcionamiento del modal -->
<script>
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
</script>