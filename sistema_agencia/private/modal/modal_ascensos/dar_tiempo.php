<div class="modal fade" id="id_tomar_tiempo" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="tomarTiempoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="tomarTiempoLabel">Tomar Tiempo</h5>
            </div>
            <div class="modal-body">
                <form id="formTomarTiempo">
                    <div class="mb-3">
                        <label for="tiempoInicio" class="form-label">Hora de inicio</label>
                        <input type="time" class="form-control" id="tiempoInicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="tiempoFin" class="form-label">Hora de fin</label>
                        <input type="time" class="form-control" id="tiempoFin" required>
                    </div>
                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formTomarTiempo" class="btn btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>