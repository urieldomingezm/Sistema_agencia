<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(PROCESO_CAMBIAR_PACTH . 'modificar_password.php');
?>
<div class="modal fade" id="modalCambiarPassword" tabindex="-1" aria-labelledby="modalCambiarPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white py-2">
                <h5 class="modal-title" id="modalCambiarPasswordLabel">Cambiar Contraseña</h5>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <form id="formCambiarPassword" method="POST" class="row g-2">
                    <input type="hidden" id="usuario_id" name="usuario_id">
                    <div class="mb-2">
                        <label for="nombre_habbo" class="form-label small mb-1">Nombre de Habbo</label>
                        <input type="text" class="form-control form-control-sm" id="nombre_habbo" name="nombre_habbo" readonly>
                    </div>
                    <div class="mb-2">
                        <label for="nueva_password" class="form-label small mb-1">Nueva Contraseña</label>
                        <input type="password" class="form-control form-control-sm" id="nueva_password" name="nueva_password" required>
                    </div>
                    <div class="mb-2">
                        <label for="confirmar_password" class="form-label small mb-1">Confirmar Contraseña</label>
                        <input type="password" class="form-control form-control-sm" id="confirmar_password" name="confirmar_password" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>