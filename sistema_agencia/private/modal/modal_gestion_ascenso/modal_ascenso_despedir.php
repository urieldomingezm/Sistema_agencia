<div class="modal fade" id="modal_despedir_persona" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-gradient-danger border-0">
                <h5 class="modal-title text-white">
                    <i class="fas fa-user-times me-2"></i>Despedir Personal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <div class="avatar-preview mb-3">
                        <img src="https://www.habbo.es/habbo-imaging/avatarimage" alt="Usuario" class="avatar-img">
                    </div>
                    <h5 class="mb-1" id="userName">Nombre del Usuario</h5>
                    <span class="badge bg-secondary">Rango Actual</span>
                </div>

                <form id="dismissalForm">
                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-exclamation-circle text-danger me-2"></i>
                            Motivo del Despido
                        </label>
                        <select class="form-select" required>
                            <option value="">Seleccionar motivo...</option>
                            <option value="inactivity">Inactividad</option>
                            <option value="performance">Bajo rendimiento</option>
                            <option value="conduct">Mala conducta</option>
                            <option value="other">Otro motivo</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label">
                            <i class="fas fa-comment-alt text-danger me-2"></i>
                            Detalles Adicionales
                        </label>
                        <textarea class="form-control" rows="3" placeholder="Describe los detalles del despido..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-signature text-danger me-2"></i>
                            Firma del Supervisor
                        </label>
                        <input type="text" class="form-control" placeholder="Tu firma..." required>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-danger" form="dismissalForm">
                    <i class="fas fa-user-times me-2"></i>Confirmar Despido
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-danger {
    background: linear-gradient(45deg, #e74a3b, #c23321);
}

.avatar-preview {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    position: relative;
}

.avatar-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.form-control, .form-select {
    border: 1px solid #e3e6f0;
    padding: 0.75rem;
    font-size: 0.9rem;
}

.form-control:focus, .form-select:focus {
    border-color: #e74a3b;
    box-shadow: 0 0 0 0.2rem rgba(231, 74, 59, 0.25);
}

.modal-content {
    border-radius: 15px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.btn-danger {
    background: linear-gradient(45deg, #e74a3b, #c23321);
    border: none;
    padding: 0.5rem 1.5rem;
}

.btn-danger:hover {
    background: linear-gradient(45deg, #c23321, #a42a1b);
}

.form-label {
    font-weight: 500;
    color: #5a5c69;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dismissalModal = document.getElementById('modal_despedir_persona');
    dismissalModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const usuario = button.getAttribute('data-usuario');
        const rango = button.getAttribute('data-rango');
        
        // Update modal content
        document.getElementById('userName').textContent = usuario;
        document.querySelector('#modal_despedir_persona .badge').textContent = rango;
        document.querySelector('.avatar-img').src = 
            `https://www.habbo.es/habbo-imaging/avatarimage?user=${usuario}&action=none&direction=2&head_direction=2&gesture=&size=l`;
        
        // Set hidden input for form submission
        const form = document.getElementById('dismissalForm');
        form.querySelector('[name="usuario"]').value = usuario;
        form.querySelector('[name="encargado"]').value = '<?= $_SESSION['usuario_registro'] ?>';
    });
});
</script>