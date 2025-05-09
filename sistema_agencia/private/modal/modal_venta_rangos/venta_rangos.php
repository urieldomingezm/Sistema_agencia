<!-- Modal -->
<div class="modal fade" id="ventas_rangos_traslados" tabindex="-1" role="dialog" aria-labelledby="ventasRangosModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white">
                <h5 class="modal-title" id="ventasRangosModalLabel">Ventas Rangos y Traslados</h5>
            </div>
            <div class="modal-body">
                <form id="ventaRangosForm">
                    <!-- Barra de progreso -->
                    <div class="progress mb-4">
                        <div class="progress-bar" role="progressbar" style="width: 33%" id="wizardProgress"></div>
                    </div>

                    <!-- Paso 1 -->
                    <div class="step" id="step1">
                        <h5 class="mb-4">Datos del Comprador</h5>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Tipo de operación</label>
                                <select class="form-select" name="rangov_tipo" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="traslado">Traslado</option>
                                    <option value="venta">Venta de Rango</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Nombre del Comprador</label>
                                <input type="text" class="form-control" name="rangov_comprador" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Rango Anterior</label>
                                <input type="text" class="form-control" name="rangov_rango_anterior" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Misión Anterior</label>
                                <input type="text" class="form-control" name="rangov_mision_anterior" required>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-primary next-step" data-next="step2">Siguiente</button>
                        </div>
                    </div>

                    <!-- Paso 2 -->
                    <div class="step" id="step2" style="display:none;">
                        <h5 class="mb-4">Datos del Nuevo Rango</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Rango Nuevo</label>
                                <input type="text" class="form-control" name="rangov_rango_nuevo" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Misión Nueva</label>
                                <input type="text" class="form-control" name="rangov_mision_nuevo" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Costo</label>
                                <input type="number" class="form-control" name="rangov_costo" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Firma del Encargado</label>
                                <input type="text" class="form-control" name="rangov_firma_encargado" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Firma Deseada del Usuario</label>
                                <input type="text" class="form-control" name="rangov_firma_usuario" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary prev-step" data-prev="step1">Anterior</button>
                            <button type="button" class="btn btn-primary next-step" data-next="step3">Siguiente</button>
                        </div>
                    </div>

                    <!-- Paso 3 -->
                    <div class="step" id="step3" style="display:none;">
                        <h5 class="mb-4">Confirmación</h5>
                        <div class="alert alert-info">
                            Por favor revise cuidadosamente los datos antes de enviar
                        </div>
                        <div id="summaryData" class="mb-4"></div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary prev-step" data-prev="step2">Anterior</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Actualizar barra de progreso
        function updateProgress(step) {
            const progress = document.getElementById('wizardProgress');
            progress.style.width = `${step * 33}%`;
        }

        // Navegación entre pasos
        document.querySelectorAll('.next-step').forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = this.closest('.step');
                const nextStepId = this.dataset.next;
                currentStep.style.display = 'none';
                document.getElementById(nextStepId).style.display = 'block';
                updateProgress(parseInt(nextStepId.replace('step', '')));
            });
        });

        document.querySelectorAll('.prev-step').forEach(button => {
            button.addEventListener('click', function() {
                const currentStep = this.closest('.step');
                const prevStepId = this.dataset.prev;
                currentStep.style.display = 'none';
                document.getElementById(prevStepId).style.display = 'block';
                updateProgress(parseInt(prevStepId.replace('step', '')) - 1);
            });
        });

        // Validación y envío del formulario
        document.getElementById('ventaRangosForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Aquí iría el código para enviar los datos al servidor
            alert('Datos guardados correctamente');
            $('#ventas_rangos_traslados').modal('hide');
        });
    });
</script>