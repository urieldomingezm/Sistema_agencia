<!-- Modal -->
<div class="modal fade" id="venta_rangos" tabindex="-1" aria-labelledby="ventaRangoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="ventaRangoModalLabel">
                    <i class="bi bi-arrow-left-right"></i> Venta/Traslado de Rangos
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="progress mb-4" style="height: 10px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <!-- Paso 1: Tipo de Operación -->
                <div class="step" id="step1">
                    <h4 class="text-center mb-4 fw-bold text-primary">
                        <i class="bi bi-1-circle-fill"></i> Tipo de Operación
                    </h4>
                    
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="bi bi-arrow-left-right me-1"></i> Tipo de operación
                                </label>
                                <select class="form-select" id="tipoOperacion">
                                    <option value="" selected disabled>-- Seleccione --</option>
                                    <option value="venta">Venta de Rango</option>
                                    <option value="traslado">Traslado de Rango</option>
                                </select>
                            </div>
                            
                            <!-- Campos para venta -->
                            <div id="ventaFields" class="mt-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-star-fill me-1"></i> Rango a vender
                                    </label>
                                    <select class="form-select" id="rangoVenta">
                                        <option value="" selected disabled>-- Seleccione --</option>
                                        <option value="1">Rango 1</option>
                                        <option value="2">Rango 2</option>
                                        <option value="3">Rango 3</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-flag-fill me-1"></i> Misión
                                    </label>
                                    <select class="form-select" id="misionVenta">
                                        <option value="" selected disabled>-- Seleccione --</option>
                                        <option value="1">Misión Alpha</option>
                                        <option value="2">Misión Beta</option>
                                        <option value="3">Misión Gamma</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-cash-stack me-1"></i> Costo de venta ($)
                                    </label>
                                    <input type="number" class="form-control" id="costoVenta" placeholder="Ej: 5000">
                                </div>
                            </div>
                            
                            <!-- Campos para traslado (ocultos inicialmente) -->
                            <div id="trasladoFields" class="mt-3 d-none">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-arrow-left-right me-1"></i> Rango a trasladar
                                    </label>
                                    <select class="form-select" id="rangoTraslado">
                                        <option value="" selected disabled>-- Seleccione --</option>
                                        <option value="1">Rango 1</option>
                                        <option value="2">Rango 2</option>
                                        <option value="3">Rango 3</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-flag-fill me-1"></i> Misión actual
                                    </label>
                                    <select class="form-select" id="misionTraslado">
                                        <option value="" selected disabled>-- Seleccione --</option>
                                        <option value="1">Misión Alpha</option>
                                        <option value="2">Misión Beta</option>
                                        <option value="3">Misión Gamma</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paso 2: Información del Receptor -->
                <div class="step" id="step2">
                    <h4 class="text-center mb-4 fw-bold text-primary">
                        <i class="bi bi-2-circle-fill"></i> Información del Receptor
                    </h4>
                    
                    <!-- Campos para venta -->
                    <div id="ventaStep2Fields">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-person-fill me-1"></i> Nombre completo del receptor
                                    </label>
                                    <input type="text" class="form-control" id="nombreReceptorVenta" placeholder="Ej: Juan Pérez">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-pen-fill me-1"></i> Firma (3 caracteres)
                                    </label>
                                    <input type="text" class="form-control" id="firmaReceptorVenta" maxlength="3" placeholder="Ej: ABC">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Campos para traslado -->
                    <div id="trasladoStep2Fields" class="d-none">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-building me-1"></i> Agencia de procedencia
                                        </label>
                                        <select class="form-select" id="agenciaProcedencia">
                                            <option value="" selected disabled>-- Seleccione --</option>
                                            <option value="1">Agencia Norte</option>
                                            <option value="2">Agencia Sur</option>
                                            <option value="3">Agencia Este</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-star me-1"></i> Rango de procedencia
                                        </label>
                                        <select class="form-select" id="rangoProcedencia">
                                            <option value="" selected disabled>-- Seleccione --</option>
                                            <option value="1">Rango 1</option>
                                            <option value="2">Rango 2</option>
                                            <option value="3">Rango 3</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-flag me-1"></i> Misión de procedencia
                                    </label>
                                    <select class="form-select" id="misionProcedencia">
                                        <option value="" selected disabled>-- Seleccione --</option>
                                        <option value="1">Misión Alpha</option>
                                        <option value="2">Misión Beta</option>
                                        <option value="3">Misión Gamma</option>
                                    </select>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-person-fill me-1"></i> Nombre del receptor
                                        </label>
                                        <input type="text" class="form-control" id="nombreReceptorTraslado" placeholder="Ej: María González">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-pen-fill me-1"></i> Firma (3 caracteres)
                                        </label>
                                        <input type="text" class="form-control" id="firmaReceptorTraslado" maxlength="3" placeholder="Ej: XYZ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paso 3: Confirmación -->
                <div class="step" id="step3">
                    <h4 class="text-center mb-4 fw-bold text-primary">
                        <i class="bi bi-3-circle-fill"></i> Confirmación
                    </h4>
                    
                    <div class="card mb-3">
                        <div class="card-body">
                            <div id="confirmacionVenta" class="d-none">
                                <h5 class="text-center text-success mb-4">
                                    <i class="bi bi-check-circle-fill"></i> Resumen de Venta de Rango
                                </h5>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th class="bg-light">Tipo de Operación</th>
                                                <td id="confirmTipoOperacionVenta">Venta de Rango</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Rango Vendido</th>
                                                <td id="confirmRangoVenta">Rango 1</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Misión</th>
                                                <td id="confirmMisionVenta">Misión Alpha</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Costo</th>
                                                <td id="confirmCostoVenta">$5,000</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Receptor</th>
                                                <td id="confirmReceptorVenta">Juan Pérez</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Firma</th>
                                                <td id="confirmFirmaVenta">ABC</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div id="confirmacionTraslado" class="d-none">
                                <h5 class="text-center text-success mb-4">
                                    <i class="bi bi-check-circle-fill"></i> Resumen de Traslado de Rango
                                </h5>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th class="bg-light">Tipo de Operación</th>
                                                <td id="confirmTipoOperacionTraslado">Traslado de Rango</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Rango Trasladado</th>
                                                <td id="confirmRangoTraslado">Rango 2</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Misión Actual</th>
                                                <td id="confirmMisionTraslado">Misión Beta</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Agencia Procedencia</th>
                                                <td id="confirmAgenciaProcedencia">Agencia Norte</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Rango Procedencia</th>
                                                <td id="confirmRangoProcedencia">Rango 1</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Misión Procedencia</th>
                                                <td id="confirmMisionProcedencia">Misión Alpha</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Receptor</th>
                                                <td id="confirmReceptorTraslado">María González</td>
                                            </tr>
                                            <tr>
                                                <th class="bg-light">Firma</th>
                                                <td id="confirmFirmaTraslado">XYZ</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="alert alert-info mt-3">
                                <i class="bi bi-info-circle-fill"></i> Revise cuidadosamente la información antes de confirmar.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <button type="button" class="btn btn-outline-secondary" id="prevBtn" disabled>
                    <i class="bi bi-arrow-left"></i> Anterior
                </button>
                <button type="button" class="btn btn-outline-primary" id="nextBtn">
                    <i class="bi bi-arrow-right"></i> Siguiente
                </button>
                <button type="button" class="btn btn-success d-none" id="confirmBtn">
                    <i class="bi bi-check-circle"></i> Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Variables del wizard
    const ventaRangoModal = document.getElementById('ventaRangoModal');
    const steps = document.querySelectorAll('.step');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const confirmBtn = document.getElementById('confirmBtn');
    const progressBar = document.querySelector('.progress-bar');
    let currentStep = 1;
    const totalSteps = 3;
    
    // Elementos del formulario
    const tipoOperacionSelect = document.getElementById('tipoOperacion');
    const ventaFields = document.getElementById('ventaFields');
    const trasladoFields = document.getElementById('trasladoFields');
    const ventaStep2Fields = document.getElementById('ventaStep2Fields');
    const trasladoStep2Fields = document.getElementById('trasladoStep2Fields');
    const confirmacionVenta = document.getElementById('confirmacionVenta');
    const confirmacionTraslado = document.getElementById('confirmacionTraslado');
    
    // Mostrar paso actual
    function showStep(step) {
        steps.forEach(s => s.style.display = 'none');
        document.getElementById(`step${step}`).style.display = 'block';
        
        // Actualizar estado de los botones
        prevBtn.disabled = step === 1;
        nextBtn.style.display = step === totalSteps ? 'none' : 'inline-block';
        confirmBtn.style.display = step === totalSteps ? 'inline-block' : 'none';
        
        // Actualizar barra de progreso
        const progress = ((step - 1) / (totalSteps - 1)) * 100;
        progressBar.style.width = `${progress}%`;
        progressBar.setAttribute('aria-valuenow', progress);
        
        currentStep = step;
        
        // Si estamos en el paso 3, actualizar la confirmación
        if (step === 3) {
            updateConfirmation();
        }
    }
    
    // Cambiar entre venta y traslado
    tipoOperacionSelect.addEventListener('change', function() {
        const tipo = this.value;
        
        if (tipo === 'venta') {
            ventaFields.style.display = 'block';
            trasladoFields.style.display = 'none';
            ventaStep2Fields.style.display = 'block';
            trasladoStep2Fields.style.display = 'none';
        } else if (tipo === 'traslado') {
            ventaFields.style.display = 'none';
            trasladoFields.style.display = 'block';
            ventaStep2Fields.style.display = 'none';
            trasladoStep2Fields.style.display = 'block';
        }
    });
    
    // Navegación
    nextBtn.addEventListener('click', function() {
        if (validateStep(currentStep)) {
            showStep(currentStep + 1);
        }
    });
    
    prevBtn.addEventListener('click', function() {
        showStep(currentStep - 1);
    });
    
    // Validar paso actual
    function validateStep(step) {
        const tipoOperacion = tipoOperacionSelect.value;
        
        if (step === 1) {
            if (!tipoOperacion) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campo requerido',
                    text: 'Debe seleccionar el tipo de operación'
                });
                return false;
            }
            
            if (tipoOperacion === 'venta') {
                const rangoVenta = document.getElementById('rangoVenta').value;
                const misionVenta = document.getElementById('misionVenta').value;
                const costoVenta = document.getElementById('costoVenta').value;
                
                if (!rangoVenta || !misionVenta || !costoVenta) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos requeridos',
                        text: 'Debe completar todos los campos para la venta'
                    });
                    return false;
                }
            } else {
                const rangoTraslado = document.getElementById('rangoTraslado').value;
                const misionTraslado = document.getElementById('misionTraslado').value;
                
                if (!rangoTraslado || !misionTraslado) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos requeridos',
                        text: 'Debe completar todos los campos para el traslado'
                    });
                    return false;
                }
            }
        } else if (step === 2) {
            if (tipoOperacion === 'venta') {
                const nombre = document.getElementById('nombreReceptorVenta').value;
                const firma = document.getElementById('firmaReceptorVenta').value;
                
                if (!nombre || !firma || firma.length !== 3) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos requeridos',
                        text: 'Debe ingresar el nombre y una firma de 3 caracteres'
                    });
                    return false;
                }
            } else {
                const agencia = document.getElementById('agenciaProcedencia').value;
                const rangoProc = document.getElementById('rangoProcedencia').value;
                const misionProc = document.getElementById('misionProcedencia').value;
                const nombre = document.getElementById('nombreReceptorTraslado').value;
                const firma = document.getElementById('firmaReceptorTraslado').value;
                
                if (!agencia || !rangoProc || !misionProc || !nombre || !firma || firma.length !== 3) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Campos requeridos',
                        text: 'Debe completar todos los campos y la firma debe ser de 3 caracteres'
                    });
                    return false;
                }
            }
        }
        
        return true;
    }
    
    // Actualizar información de confirmación
    function updateConfirmation() {
        const tipoOperacion = tipoOperacionSelect.value;
        
        if (tipoOperacion === 'venta') {
            confirmacionVenta.style.display = 'block';
            confirmacionTraslado.style.display = 'none';
            
            // Obtener valores
            const rangoVenta = document.getElementById('rangoVenta');
            const rangoText = rangoVenta.options[rangoVenta.selectedIndex].text;
            
            const misionVenta = document.getElementById('misionVenta');
            const misionText = misionVenta.options[misionVenta.selectedIndex].text;
            
            const costo = document.getElementById('costoVenta').value;
            const nombre = document.getElementById('nombreReceptorVenta').value;
            const firma = document.getElementById('firmaReceptorVenta').value;
            
            // Actualizar tabla
            document.getElementById('confirmTipoOperacionVenta').textContent = 'Venta de Rango';
            document.getElementById('confirmRangoVenta').textContent = rangoText;
            document.getElementById('confirmMisionVenta').textContent = misionText;
            document.getElementById('confirmCostoVenta').textContent = `$${parseInt(costo).toLocaleString()}`;
            document.getElementById('confirmReceptorVenta').textContent = nombre;
            document.getElementById('confirmFirmaVenta').textContent = firma;
        } else {
            confirmacionVenta.style.display = 'none';
            confirmacionTraslado.style.display = 'block';
            
            // Obtener valores
            const rangoTraslado = document.getElementById('rangoTraslado');
            const rangoText = rangoTraslado.options[rangoTraslado.selectedIndex].text;
            
            const misionTraslado = document.getElementById('misionTraslado');
            const misionText = misionTraslado.options[misionTraslado.selectedIndex].text;
            
            const agencia = document.getElementById('agenciaProcedencia');
            const agenciaText = agencia.options[agencia.selectedIndex].text;
            
            const rangoProc = document.getElementById('rangoProcedencia');
            const rangoProcText = rangoProc.options[rangoProc.selectedIndex].text;
            
            const misionProc = document.getElementById('misionProcedencia');
            const misionProcText = misionProc.options[misionProc.selectedIndex].text;
            
            const nombre = document.getElementById('nombreReceptorTraslado').value;
            const firma = document.getElementById('firmaReceptorTraslado').value;
            
            // Actualizar tabla
            document.getElementById('confirmTipoOperacionTraslado').textContent = 'Traslado de Rango';
            document.getElementById('confirmRangoTraslado').textContent = rangoText;
            document.getElementById('confirmMisionTraslado').textContent = misionText;
            document.getElementById('confirmAgenciaProcedencia').textContent = agenciaText;
            document.getElementById('confirmRangoProcedencia').textContent = rangoProcText;
            document.getElementById('confirmMisionProcedencia').textContent = misionProcText;
            document.getElementById('confirmReceptorTraslado').textContent = nombre;
            document.getElementById('confirmFirmaTraslado').textContent = firma;
        }
    }
    
    // Confirmar operación
    confirmBtn.addEventListener('click', function() {
        const tipoOperacion = tipoOperacionSelect.value;
        
        Swal.fire({
            title: '¿Confirmar operación?',
            text: `Está a punto de registrar un ${tipoOperacion === 'venta' ? 'venta' : 'traslado'} de rango`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí iría la lógica para guardar en la base de datos
                // Por ahora solo mostramos un mensaje de éxito
                
                Swal.fire({
                    title: 'Operación exitosa!',
                    text: `El ${tipoOperacion === 'venta' ? 'venta' : 'traslado'} de rango se ha registrado correctamente`,
                    icon: 'success'
                }).then(() => {
                    // Cerrar el modal
                    const modal = bootstrap.Modal.getInstance(ventaRangoModal);
                    modal.hide();
                    
                    // Resetear el formulario
                    resetForm();
                });
            }
        });
    });
    
    // Resetear formulario cuando se cierra el modal
    ventaRangoModal.addEventListener('hidden.bs.modal', function() {
        resetForm();
    });
    
    function resetForm() {
        // Resetear selects e inputs
        document.querySelectorAll('select').forEach(select => {
            select.selectedIndex = 0;
        });
        
        document.querySelectorAll('input').forEach(input => {
            input.value = '';
        });
        
        // Resetear vistas
        ventaFields.style.display = 'block';
        trasladoFields.style.display = 'none';
        ventaStep2Fields.style.display = 'block';
        trasladoStep2Fields.style.display = 'none';
        confirmacionVenta.style.display = 'none';
        confirmacionTraslado.style.display = 'none';
        
        // Volver al paso 1
        showStep(1);
    }
    
    // Inicializar mostrando el primer paso
    showStep(1);
});
</script>