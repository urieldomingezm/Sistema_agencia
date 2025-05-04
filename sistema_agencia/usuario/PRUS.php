<!-- PROCESO DE VER PERFIL -->
<?php
require_once(VER_PERFIL_PATCH . 'ver_perfil.php');

$userProfile = new UserProfile();
$userData = $userProfile->getUserData();
?>


<div class="profile-header text-center py-5 position-relative overflow-hidden">
    <div class="background-pattern"></div>
    <div class="container position-relative">
        <div class="avatar-container mb-4">
            <div class="avatar-wrapper">
                <img src="<?php echo $userData['avatar']; ?>"
                    class="rounded-circle shadow-lg border border-4 border-white"
                    alt="Profile Avatar">
                <div class="status-badge pulse"></div>
            </div>
        </div>
        <h1 class="display-4 fw-bold text-white mb-2 text-shadow"><?php echo $userData['username']; ?></h1>
    </div>
</div>

<div class="container py-5">
    <div class="row g-4">
        <!-- Tarjeta de Información Personal -->
        <div class="col-md-4">
            <div class="profile-card glass-effect">
                <div class="card-header bg-gradient-primary d-flex align-items-center">
                    <h3 class="mb-0">Información Personal</h3>
                </div>
                <div class="stats-card">
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

        <!-- Tarjeta de Información de Time de Paga -->
        <div class="col-md-4">
            <div class="profile-card glass-effect">
                <div class="card-header bg-gradient-success d-flex align-items-center">
                    <h3 class="mb-0">Time de Paga</h3>
                </div>
                <div class="stats-card">
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

        <!-- Tarjeta de Información de Misión -->
        <div class="col-md-4">
            <div class="profile-card glass-effect">
                <div class="card-header bg-gradient-info d-flex align-items-center">
                    <h3 class="mb-0">Información de Misión</h3>
                </div>
                <div class="stats-card">
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