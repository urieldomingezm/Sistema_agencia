<!-- Modal para Dar Ascenso -->
<div class="modal fade" id="modalCalcular" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                     Calculadora de Rangos
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="calculatorForm">
                    <div class="mb-3">
                        <select class="form-select" required id="seleccion_eres">
                            <option value="" disabled selected>Selecciona tu estado</option>
                            <option value="trabajador">Trabajador</option>
                            <option value="nuevo">Nuevo</option>
                        </select>
                    </div>

                    <div id="campos_dinamicos" class="row g-2">
                        <!-- Los campos dinámicos se insertarán aquí -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- archivo de validación -->
<script src="/public/assets/custom_general/custom_calcular_rango/calcular_rango.js"></script>