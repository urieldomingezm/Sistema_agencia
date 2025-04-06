<div class="modal fade" id="modalInformacionPersonaEncargado" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-gradient-primary border-0 py-2">
                <h6 class="modal-title text-white mb-0">
                    <i class="fas fa-user-tie me-2"></i>Persona Encargada
                </h6>
                <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="profile-header text-center p-3">
                    <div class="avatar-wrapper mb-2">
                        <img src="https://www.habbo.es/habbo-imaging/avatarimage?user=goblinslayer88&action=none&direction=2&head_direction=2&gesture=&size=sl&headonly=2"
                             class="avatar-img">
                        <span class="status-badge"></span>
                    </div>
                    <h5 class="mb-0">Goblinslayer88</h5>
                    <span class="badge bg-gradient-warning text-dark mt-1">Dueño</span>
                </div>

                <div class="profile-info">
                    <div class="info-row">
                        <i class="fas fa-history text-primary"></i>
                        <div class="info-content">
                            <small class="text-muted">Misión Anterior</small>
                            <p class="mb-0">ATN- Supervisor A -XDD -SDS</p>
                        </div>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-arrow-right text-success"></i>
                        <div class="info-content">
                            <small class="text-muted">Misión Nueva</small>
                            <p class="mb-0">ATN- Supervisor B -XDD -SDS</p>
                        </div>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-signature text-info"></i>
                        <div class="info-content">
                            <small class="text-muted">Firma</small>
                            <p class="mb-0">XDD</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #4e73df, #224abe);
}

.bg-gradient-warning {
    background: linear-gradient(45deg, #f6c23e, #f4b619);
}

.profile-header {
    background: #f8f9fc;
    border-bottom: 1px solid rgba(0,0,0,.05);
}

.avatar-wrapper {
    position: relative;
    display: inline-block;
}

.avatar-img {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 2px 10px rgba(0,0,0,.1);
}

.status-badge {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 12px;
    height: 12px;
    background: #2ecc71;
    border: 2px solid #fff;
    border-radius: 50%;
}

.profile-info {
    padding: 0.5rem;
}

.info-row {
    display: flex;
    align-items: flex-start;
    padding: 0.75rem;
    border-bottom: 1px solid rgba(0,0,0,.05);
}

.info-row:last-child {
    border-bottom: none;
}

.info-row i {
    margin-right: 0.75rem;
    margin-top: 0.25rem;
}

.info-content {
    flex: 1;
}

.info-content small {
    display: block;
    font-size: 0.75rem;
}

.info-content p {
    font-size: 0.875rem;
    font-weight: 500;
}

.modal-sm {
    max-width: 300px;
}
</style>