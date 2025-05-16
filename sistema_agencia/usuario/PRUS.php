<!-- PROCESO DE VER PERFIL -->
<?php
require_once(VER_PERFIL_PATCH . 'ver_perfil.php');
require_once(GESTION_PAGAS_PATCH . 'mostrar_usuarios.php'); // MOSTRAR USUARIOS
$userProfile = new UserProfile();
$userData = $userProfile->getUserData();

// Inicializar la variable pagaUsuario
$pagaUsuario = null;

// Obtener la paga del usuario actual si existe
if (isset($pagas) && is_array($pagas)) {
    foreach ($pagas as $paga) {
        if ($paga['pagas_usuario'] === $userData['username']) {
            $pagaUsuario = $paga;
            break;
        }
    }
}
?>

<div class="profile-header py-2 position-relative overflow-hidden">
    <div class="background-pattern"></div>
    <div class="container position-relative">
        <div class="d-flex align-items-center">
            <div class="avatar-container me-2" style="width: 50px; height: 50px;">
                <img src="<?php echo $userData['avatar']; ?>" class="rounded-circle shadow border border-2 border-white" alt="Profile Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                <div class="status-badge pulse" style="width: 10px; height: 10px;"></div>
            </div>
            <div>
                <h1 class="h5 fw-bold text-white text-shadow mb-0"><?php echo $userData['username']; ?></h1>
                <small class="text-white-50"><?php echo $userData['role']; ?></small>
            </div>
        </div>
    </div>
</div>

<div class="container py-2">
    <div class="row g-2">
        <!-- Información Personal y de Pago -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-gradient-primary py-1">
                    <h3 class="h6 mb-0 text-white">Información Personal</h3>
                </div>
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Usuario:</small>
                            <p class="mb-1 small"><?php echo $userData['username']; ?></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Código:</small>
                            <p class="mb-1 small"><?php echo $userData['codigo']; ?></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Rango:</small>
                            <p class="mb-1 small badge-custom"><?php echo $userData['role']; ?></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Membresia:</small>
                            <p class="mb-1 small badge-custom"><?php echo $userData['role']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-gradient-primary py-1">
                    <h3 class="h6 mb-0 text-white">Información de Pago</h3>
                </div>
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Pago Pendiente:</small>
                            <p class="mb-1 small text-dark">
                                <?php 
                                    if ($pagaUsuario) {
                                        echo htmlspecialchars($pagaUsuario['pagas_motivo']);
                                    } else {
                                        echo "No disponible";
                                    }
                                ?>
                            </p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Estado Requisitos:</small>
                            <p class="mb-1 small">
                                <?php if ($pagaUsuario && $pagaUsuario['pagas_completo'] == 1): ?>
                                    <span class="badge bg-success text-white">Completado</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Recibió Pago:</small>
                            <p class="mb-1 small">
                                <?php if ($pagaUsuario && $pagaUsuario['pagas_recibio'] == 1): ?>
                                    <span class="badge bg-success text-white">Sí</span>
                                <?php else: ?>
                                    <span class="badge bg-danger text-white">No</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Rango de Pago:</small>
                            <p class="mb-1 small">
                                <?php 
                                    if ($pagaUsuario) {
                                        echo htmlspecialchars($pagaUsuario['pagas_rango']);
                                    } else {
                                        echo "No disponible";
                                    }
                                ?>
                            </p>
                        </div>
                        <?php if ($pagaUsuario): ?>
                        <div class="col-12">
                            <small class="text-muted">Descripción:</small>
                            <p class="mb-1 small">
                                <?php echo htmlspecialchars($pagaUsuario['pagas_descripcion']); ?>
                            </p>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Fecha de registro:</small>
                            <p class="mb-1 small">
                                <?php echo htmlspecialchars($pagaUsuario['pagas_fecha_registro']); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gestión de Tiempo y Misión -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-gradient-primary py-1">
                    <h3 class="h6 mb-0 text-white">Gestión de Tiempo</h3>
                </div>
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Tiempo Acumulado:</small>
                            <p class="mb-1 small"><?php echo $userData['tiempo_acumulado']; ?></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Tiempo Restado:</small>
                            <p class="mb-1 small"><?php echo $userData['tiempo_restado']; ?></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Encargado:</small>
                            <p class="mb-1 small"><?php echo $userData['tiempo_encargado'] ?? 'No disponible'; ?></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Estado:</small>
                            <p class="mb-1 small"><span class="badge text-white <?php 
                                switch($userData['tiempo_status']) {
                                    case 'pausa': echo 'bg-secondary'; break;
                                    case 'inactivo': echo 'bg-secondary'; break;
                                    case 'Activo': echo 'bg-primary'; break;
                                    case 'completado': echo 'bg-success'; break;
                                    default: echo 'bg-secondary';
                                }
                                ?>"><?php echo ucfirst($userData['tiempo_status'] ?? 'No disponible'); ?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-gradient-primary py-1">
                    <h3 class="h6 mb-0 text-white">Información de Misión</h3>
                </div>
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">Misión actual:</small>
                            <p class="mb-1 small"><?php echo $userData['mission']; ?></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Encargado:</small>
                            <p class="mb-1 small"><?php echo $userData['encargado']; ?></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Próxima hora:</small>
                            <p class="mb-1 small"><?php 
                            if (!empty($userData['estimatedTime'])) {
                                $date = DateTime::createFromFormat('d/m/Y H:i', $userData['estimatedTime']);
                                if ($date) {
                                    $minutes = $date->format('i');
                                    $seconds = $date->format('s');
                                    
                                    if ($minutes > 0) {
                                        echo $minutes . ' min' . ($minutes > 1 ? 's' : '');
                                        if ($seconds > 0) {
                                            echo ' ' . $seconds . ' seg';
                                        }
                                    } else {
                                        echo $seconds . ' seg';
                                    }
                                } else {
                                    echo 'Formato inválido';
                                }
                            } else {
                                echo 'No disponible';
                            }
                            ?></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Estado ascenso:</small>
                            <p class="mb-1 small"><span class="badge text-white <?php echo ($userData['estado_disponibilidad'] ?? 'pendiente') === 'disponible' ? 'bg-success' : 'bg-warning'; ?>">
                                <?php echo ($userData['estado_disponibilidad'] ?? 'pendiente') === 'disponible' ? 'Disponible' : 'Pendiente'; ?>
                            </span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php if (in_array($userData['role'], ['Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva', 'Administrador', 'Manager', 'Fundador'])): ?>
    <div class="row mt-2 g-2">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-primary py-1">
                    <h5 class="h6 mb-0 text-white">Tiempos tomados</h5>
                </div>
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0"><?php echo $userProfile->getTotalTiemposTomados(); ?></h2>
                        <small class="text-muted">esta semana</small>
                    </div>
                    <div class="progress mt-1" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-gradient-success py-1">
                    <h5 class="h6 mb-0 text-white">Ascensos Tomados</h5>
                </div>
                <div class="card-body p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="h4 mb-0"><?php echo $userData['ascensosCompletados'] ?? '0'; ?></h2>
                        <small class="text-muted">esta semana</small>
                    </div>
                    <div class="progress mt-1" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
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
    
    checkAscenso();
    setInterval(checkAscenso, checkInterval);
});
</script>
