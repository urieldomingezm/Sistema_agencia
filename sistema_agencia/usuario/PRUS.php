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
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Membresia</span>
                        <span class="info-value badge-custom"><?php echo $userData['role']; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="profile-card glass-effect h-100">
                <div class="card-header bg-gradient-success py-2">
                    <h3 class="h5 mb-0">Gestión de Tiempo</h3>
                </div>
                <div class="stats-card p-2">
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Tiempo Acumulado</span>
                        <span class="info-value"><?php echo $userData['tiempo_acumulado']; ?></span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Tiempo Restado</span>
                        <span class="info-value"><?php echo $userData['tiempo_restado']; ?></span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Encargado</span>
                        <span class="info-value"><?php echo $userData['tiempo_encargado'] ?? 'No disponible'; ?></span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Estado</span>
                        <span class="info-value badge text-white 
                            <?php 
                            switch($userData['tiempo_status']) {
                                case 'pausa': echo 'bg-secondary'; break;
                                case 'disponible': echo 'bg-success'; break;
                                case 'ocupado': echo 'bg-warning'; break;
                                case 'ausente': echo 'bg-info'; break;
                                case 'terminado': echo 'bg-danger'; break;
                                case 'completado': echo 'bg-primary'; break;
                                default: echo 'bg-secondary';
                            }
                            ?>">
                            <?php echo ucfirst($userData['tiempo_status'] ?? 'No disponible'); ?>
                        </span>
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
                        <span class="info-value">
                            <?php 
                            if (!empty($userData['estimatedTime'])) {
                                $date = DateTime::createFromFormat('d/m/Y H:i', $userData['estimatedTime']);
                                if ($date) {
                                    $minutes = $date->format('i');
                                    $seconds = $date->format('s');
                                    
                                    if ($minutes > 0) {
                                        echo $minutes . ' minuto' . ($minutes > 1 ? 's' : '');
                                        if ($seconds > 0) {
                                            echo ' con ' . $seconds . ' segundo' . ($seconds > 1 ? 's' : '');
                                        }
                                    } else {
                                        echo $seconds . ' segundo' . ($seconds > 1 ? 's' : '');
                                    }
                                } else {
                                    echo 'Formato de fecha inválido';
                                }
                            } else {
                                echo 'No disponible';
                            }
                            ?>
                        </span>
                    </div>
                    <div class="info-item d-flex align-items-center">
                        <span class="info-label me-2">Estado ascenso</span>
                        <span class="info-value badge text-white <?php echo ($userData['estado_disponibilidad'] ?? 'pendiente') === 'disponible' ? 'bg-success' : 'bg-warning'; ?>">
                            <?php echo ($userData['estado_disponibilidad'] ?? 'pendiente') === 'disponible' ? 'Disponible' : 'Pendiente'; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let lastCheck = 0;
    const checkInterval = 60000; // 1 minuto
    
    function checkAscenso() {
        const now = Date.now();
        if (now - lastCheck < checkInterval) return;
        
        lastCheck = now;
        
        fetch('<?php echo VER_PERFIL_PATCH; ?>check_ascenso.php')
            .then(response => response.json())
            .then(data => {
                if(data.disponible) {
                    const badge = document.querySelector('.badge');
                    if (badge) {
                        badge.classList.replace('bg-warning', 'bg-success');
                        badge.textContent = 'Disponible';
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    }
    
    // Verificar al cargar la página
    checkAscenso();
    
    // Verificar cada minuto
    setInterval(checkAscenso, checkInterval);
});
</script>


<?php if (in_array($userData['role'], ['Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva', 'Administrador', 'Manager', 'Fundador'])): ?>
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-gradient-primary text-white">
                <h5 class="card-title mb-0">Tiempos tomados</h5>
            </div>
            <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="card-text"><?php echo $userData['ascensosCompletados'] ?? '0'; ?></h2>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">en esta semana</small>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-gradient-success text-white">
                <h5 class="card-title mb-0">Ascensos Tomados</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="card-text"><?php echo $userData['ascensosCompletados'] ?? '0'; ?></h2>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">en esta semana</small>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
