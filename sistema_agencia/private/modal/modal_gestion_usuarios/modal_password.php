<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(PROCESO_CAMBIAR_PACTH . 'modificar_password.php');
?>
<div class="modal fade" id="modalCambiarPassword" tabindex="-1" aria-labelledby="modalCambiarPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCambiarPasswordLabel">Cambiar Contraseña</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 p-md-4">
                <form id="formCambiarPassword" method="POST" class="needs-validation" novalidate>
                    <input type="hidden" id="usuario_id" name="usuario_id">
                    
                    <div class="mb-3">
                        <label for="nombre_habbo" class="form-label fw-bold">Nombre de Habbo</label>
                        <input type="text" class="form-control" id="nombre_habbo" name="nombre_habbo" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nueva_password" class="form-label fw-bold">Nueva Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="nueva_password" name="nueva_password">
                            <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center" 
                                    type="button" id="togglePassword1" 
                                    style="height: 100%; width: 50px;">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>                    </div>
                    
                    <div class="mb-3">
                        <label for="confirmar_password" class="form-label fw-bold">Confirmar Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirmar_password" name="confirmar_password">
                            <button class="btn btn-outline-secondary d-flex align-items-center justify-content-center" 
                                    type="button" id="togglePassword2" 
                                    style="height: 100%; width: 50px;">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="d-flex flex-column flex-sm-row justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary order-2 order-sm-1" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary order-1 order-sm-2 mb-2 mb-sm-0">
                            <i class="bi bi-check-circle me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS DE MODAL PASSWORD -->
<script src="/public/assets/modal_just_validate/modal_password/modal_password.js"></script>