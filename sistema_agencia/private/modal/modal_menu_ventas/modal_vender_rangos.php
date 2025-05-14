<?php
require_once(PROCESO_VENTAS_MEMBRESIAS_PACTH . 'registrar_venta.php');
?>

<!-- Modal para Venta de Rangos -->
<div class="modal fade" id="modalrangos" tabindex="-1" aria-labelledby="modalrangosLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalrangosLabel">Venta de Rangos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" class="was-validated">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Título de Venta</label>
                            <select name="venta_titulo" id="venta_titulo" class="form-control" required>
                                <option value="membresia">Membresía</option>
                                <option value="venta_rango">Venta de Rango</option>
                                <option value="traslado">Traslado</option>
                            </select>
                            <div class="invalid-feedback">Título es requerido</div>
                        </div>
                        <div class="col-md-6 mb-2" id="descripcion_div">
                            <label class="form-label">Descripción</label>
                            <!-- Este select aparece solo si se selecciona "Membresía" -->
                            <select name="venta_descripcion" id="venta_descripcion" class="form-control" style="display:none;">
                                <option value="opcion_1">Opción 1</option>
                                <option value="opcion_2">Opción 2</option>
                                <option value="opcion_3">Opción 3</option>
                                <option value="opcion_4">Opción 4</option>
                                <option value="opcion_5">Opción 5</option>
                            </select>
                            <!-- Si no es Membresía, el campo será un texto normal -->
                            <input type="text" name="venta_descripcion" maxlength="60" class="form-control" id="venta_descripcion_input" required>
                            <div class="invalid-feedback">Descripción es requerida</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Fecha de Compra</label>
                            <input type="date" name="venta_compra" id="venta_compra" class="form-control" required>
                            <div class="invalid-feedback">Fecha de compra es requerida</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Fecha de Caducidad</label>
                            <input type="date" name="venta_caducidad" id="venta_caducidad" class="form-control" required>
                            <div class="invalid-feedback">Fecha de caducidad es requerida</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Estado</label>
                            <input type="text" name="venta_estado" id="venta_estado" maxlength="50" class="form-control" required>
                            <div class="invalid-feedback">Estado es requerido</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Costo</label>
                            <input type="number" name="venta_costo" class="form-control" required>
                            <div class="invalid-feedback">Costo es requerido</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Comprador</label>
                            <input type="text" name="venta_comprador" maxlength="16" class="form-control" required>
                            <div class="invalid-feedback">Comprador es requerido</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Encargado</label>
                            <input type="text" name="venta_encargado" maxlength="16" class="form-control" required>
                            <div class="invalid-feedback">Encargado es requerido</div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" name="guardarVenta" class="btn btn-success">Registrar Venta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JUST-VALIDATE DE MODAL VENDER MEMBRESIAS -->
<script src="/public/assets/modal_just_validate/modal_membresias/modal_membresias.js"></script>
