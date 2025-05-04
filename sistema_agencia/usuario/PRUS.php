<!-- PROCESO DE VER PERFIL -->
<?php
require_once(VER_PERFIL_PATCH . 'ver_perfil.php');
$userProfile = new UserProfile();
$userData = $userProfile->getUserData();
?>

<div class="profile-header text-center py-3 position-relative overflow-hidden">
    <div class="background-pattern"></div>
    <div class="container position-relative">
        <div class="d-flex align-items-center justify-content-center">
            <div class="avatar-container me-3" style="width: 70px; height: 70px;">
                <img src="<?php echo $userData['avatar']; ?>"
                    class="rounded-circle shadow border border-2 border-white"
                    alt="Profile Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                <div class="status-badge pulse" style="width: 12px; height: 12px;"></div>
            </div>
            <div>
                <h1 class="h4 fw-bold text-white text-shadow mb-0"><?php echo $userData['username']; ?></h1>
                <small class="text-white-50"><?php echo $userData['role']; ?></small>
            </div>
        </div>
    </div>
</div>

<div class="container py-3">
    <div class="row g-3">
        <!-- Secciones de información -->
        <div class="col-md-4">
            <div class="profile-card glass-effect h-100">
                <div class="card-header bg-gradient-primary py-2">
                    <h3 class="h5 mb-0">Información Personal</h3>
                </div>
                <div class="stats-card p-2">
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Usuario</span>
                        <span class="info-value"><?php echo $userData['username']; ?></span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Código</span>
                        <span class="info-value"><?php echo $userData['codigo']; ?></span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Rango</span>
                        <span class="info-value badge-custom"><?php echo $userData['role']; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="profile-card glass-effect h-100">
                <div class="card-header bg-gradient-success py-2">
                    <h3 class="h5 mb-0">Time de Paga</h3>
                </div>
                <div class="stats-card p-2">
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Día de paga</span>
                        <span class="info-value"><?php echo $userData['paymentDate']; ?> de cada mes</span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Hora</span>
                        <span class="info-value"><?php echo $userData['paymentTime']; ?> hrs</span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Total de horas</span>
                        <span class="info-value highlight pulse-text"><?php echo $userData['totalHours']; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="profile-card glass-effect h-100">
                <div class="card-header bg-gradient-info py-2">
                    <h3 class="h5 mb-0">Información de Misión</h3>
                </div>
                <div class="stats-card p-2">
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Misión actual</span>
                        <span class="info-value"><?php echo $userData['mission']; ?></span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Encargado</span>
                        <span class="info-value"><?php echo $userData['encargado']; ?></span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Próxima hora</span>
                        <span class="info-value"><?php echo $userData['estimatedTime']; ?></span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Estado ascenso</span>
                        <span class="info-value badge text-white <?php echo ($userData['estado_disponibilidad'] ?? 'pendiente') === 'disponible' ? 'bg-success' : 'bg-warning'; ?>">
                            <?php echo ($userData['estado_disponibilidad'] ?? 'pendiente') === 'disponible' ? 'Disponible' : 'Pendiente'; ?>
                        </span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Estado</span>
                        <span class="status-pill glow"><?php echo $userData['status']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Verificar cada minuto si el ascenso está disponible
    setInterval(() => {
        fetch('<?php echo VER_PERFIL_PATCH; ?>check_ascenso.php')
            .then(response => response.json())
            .then(data => {
                if(data.disponible) {
                    document.querySelector('.badge').classList.replace('bg-warning', 'bg-success');
                    document.querySelector('.badge').textContent = 'Disponible';
                }
            });
    }, 60000);
});
</script>