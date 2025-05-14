<?php
require_once(PROCESO_VENTAS_MEMBRESIAS_PACTH . 'registrar_venta.php');
?>

<div class="modal fade" id="registrarVentaModal" tabindex="-1" aria-labelledby="registrarVentaModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white bg-primary">
                <h5 class="modal-title text-center" id="registrarVentaModalLabel">
                    Registrar Nueva Venta
                </h5>
            </div>
            <div class="modal-body">
                <form id="registrarVentaForm" method="post" class="was-validated">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="ventaTitulo" name="ventaTitulo" required>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="Membresía Gold">Membresía Gold</option>
                                    <option value="Membresía Bronce">Membresía Bronce</option>
                                    <option value="Membresía regla libre">Membresía regla libre</option>
                                    <option value="Membresía save">Membresía save</option>
                                    <option value="Membresía silver">Membresía silver</option>
                                    <option value="Membresía VIP">Membresía VIP</option>
                                </select>
                                <label for="ventaTitulo">Título de la Venta</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="fechaCompra" name="fechaCompra" readonly required>
                                <label for="fechaCompra">Fecha de Compra</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" id="fechaCaducidad" name="fechaCaducidad" readonly required>
                                <label for="fechaCaducidad">Fecha de Caducidad</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nombreComprador" name="nombreComprador" placeholder="Nombre del Comprador" required>
                                <label for="nombreComprador">Nombre del Comprador</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="nombreEncargado" name="nombreEncargado" placeholder="Nombre del Encargado" value="<?= $_SESSION['username'] ?? '' ?>" readonly required>
                                <label for="nombreEncargado">Nombre del Encargado</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 mt-4">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="btnGuardarVenta">
                            Guardar Venta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JUST-VALIDATE DE MODAL VENDER MEMBRESIAS -->
<script src="/public/assets/modal_just_validate/modal_ventas_membresias/ventas_membresias.js"></script>
