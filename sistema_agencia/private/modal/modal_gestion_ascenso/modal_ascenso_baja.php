<div class="modal fade" id="modal_bajar_rango" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-gradient-warning border-0">
                <h5 class="modal-title text-dark">
                    <i class="fas fa-level-down-alt me-2"></i>Degradación de Rango
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="user-info-header text-center mb-4">
                    <div class="rank-change-indicator">
                        <i class="fas fa-user-circle current-rank"></i>
                        <i class="fas fa-arrow-down arrow-down"></i>
                        <i class="fas fa-user-circle new-rank"></i>
                    </div>
                </div>

                <form id="demotionForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user text-warning me-2"></i>Usuario
                                </label>
                                <input type="text" class="form-control" name="ascenso_usuario" readonly>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">
                                    <i class="fas fa-briefcase text-warning me-2"></i>Misión Actual
                                </label>
                                <input class="form-control" name="mision_actual" readonly>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">
                                    <i class="fas fa-signature text-warning me-2"></i>Firma
                                </label>
                                <input class="form-control" name="ascenso_firma" required>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">
                                    <i class="fas fa-user-shield text-warning me-2"></i>Encargado
                                </label>
                                <input class="form-control" name="ascenso_encargado_usuario" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-star text-warning me-2"></i>Nuevo Rango
                                </label>
                                <select class="form-select" name="ascenso_rango" required>
                                    <option value="" disabled selected>Seleccionar rango...</option>
                                    <option value="Agente">Agente</option>
                                    <option value="Seguridad">Seguridad</option>
                                    <option value="Tecnico">Técnico</option>
                                    <option value="Logistica">Logística</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Director">Director</option>
                                    <option value="Presidente">Presidente</option>
                                    <option value="Operativo">Operativo</option>
                                    <option value="Junta directiva">Junta directiva</option>
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">
                                    <i class="fas fa-tasks text-warning me-2"></i>Nueva Misión
                                </label>
                                <input class="form-control" name="ascenso_mision_nueva" required>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">
                                    <i class="fas fa-info-circle text-warning me-2"></i>Status
                                </label>
                                <input class="form-control" name="ascenso_status" required>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">
                                    <i class="fas fa-clock text-warning me-2"></i>Tiempo de Espera
                                </label>
                                <select class="form-select" name="ascenso_hora_proxima" required>
                                    <option value="" disabled selected>Seleccionar tiempo...</option>
                                    <option value="00:30:00">30 minutos</option>
                                    <option value="02:00:00">2 horas</option>
                                    <option value="24:00:00">1 día</option>
                                    <option value="48:00:00">2 días</option>
                                    <option value="72:00:00">3 días</option>
                                    <option value="120:00:00">5 días</option>
                                    <option value="168:00:00">1 semana</option>
                                    <option value="240:00:00">10 días</option>
                                    <option value="360:00:00">15 días</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-warning" form="demotionForm">
                    <i class="fas fa-level-down-alt me-2"></i>Confirmar Degradación
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-warning {
    background: linear-gradient(45deg, #f6c23e, #f4b619);
}

.modal-content {
    border-radius: 15px;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.user-info-header {
    padding: 1rem;
    background: #f8f9fc;
    border-radius: 10px;
}

.rank-change-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    font-size: 2rem;
}

.current-rank {
    color: #4e73df;
}

.arrow-down {
    color: #f6c23e;
    font-size: 1.5rem;
}

.new-rank {
    color: #858796;
}

.form-control, .form-select {
    border: 1px solid #e3e6f0;
    padding: 0.75rem;
    font-size: 0.9rem;
}

.form-control:focus, .form-select:focus {
    border-color: #f6c23e;
    box-shadow: 0 0 0 0.2rem rgba(246, 194, 62, 0.25);
}

.form-label {
    font-weight: 500;
    color: #5a5c69;
}

.btn-warning {
    background: linear-gradient(45deg, #f6c23e, #f4b619);
    border: none;
    color: #fff;
}

.btn-warning:hover {
    background: linear-gradient(45deg, #f4b619, #e0a800);
    color: #fff;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const demotionModal = document.getElementById('modal_bajar_rango');
    demotionModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const usuario = button.getAttribute('data-usuario');
        const rango = button.getAttribute('data-rango');
        const mision = button.getAttribute('data-mision');
        
        // Populate form fields
        const form = document.getElementById('demotionForm');
        form.querySelector('[name="ascenso_usuario"]').value = usuario;
        form.querySelector('[name="mision_actual"]').value = mision;
        form.querySelector('[name="ascenso_encargado_usuario"]').value = '<?= $_SESSION['usuario_registro'] ?>';
        
        // Set current rank in select
        const rangoSelect = form.querySelector('[name="ascenso_rango"]');
        Array.from(rangoSelect.options).forEach(option => {
            if (option.value === rango) {
                option.disabled = true;
            }
        });
    });
});
</script>