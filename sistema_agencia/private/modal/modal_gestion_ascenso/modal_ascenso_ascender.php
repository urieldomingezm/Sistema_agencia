<div class="modal fade" id="modal_ascender" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-gradient-success border-0">
                <h5 class="modal-title text-white">
                    <i class="fas fa-arrow-up me-2"></i>Ascender Personal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="avatar-preview mb-3">
                        <img src="" alt="Usuario" class="avatar-img">
                    </div>
                    <h5 class="mb-1" id="promotionUserName"></h5>
                    <span class="badge bg-info" id="currentRank"></span>
                </div>

                <form id="promotionForm">
                    <input type="hidden" name="usuario">
                    <input type="hidden" name="encargado">
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-star text-success me-2"></i>Nuevo Rango
                                </label>
                                <select class="form-select" name="nuevo_rango" required>
                                    <!-- Same options as in demotion modal -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tasks text-success me-2"></i>Nueva Misión
                                </label>
                                <input type="text" class="form-control" name="nueva_mision" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">
                            <i class="fas fa-clock text-success me-2"></i>Tiempo de Espera
                        </label>
                        <select class="form-select" name="tiempo_espera" required>
                            <!-- Same options as in demotion modal -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success" form="promotionForm">Confirmar Ascenso</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const promotionModal = document.getElementById('modal_ascender');
    promotionModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const usuario = button.getAttribute('data-usuario');
        const rango = button.getAttribute('data-rango');
        
        // Update modal content
        document.getElementById('promotionUserName').textContent = usuario;
        document.getElementById('currentRank').textContent = rango;
        document.querySelector('#modal_ascender .avatar-img').src = 
            `https://www.habbo.es/habbo-imaging/avatarimage?user=${usuario}&action=none&direction=2&head_direction=2&gesture=&size=l`;
        
        // Set form values
        const form = document.getElementById('promotionForm');
        form.querySelector('[name="usuario"]').value = usuario;
        form.querySelector('[name="encargado"]').value = '<?= $_SESSION['usuario_registro'] ?>';
        
        // Disable current rank in select
        const rangoSelect = form.querySelector('[name="nuevo_rango"]');
        Array.from(rangoSelect.options).forEach(option => {
            if (option.value === rango) {
                option.disabled = true;
            }
        });
    });
});
</script>