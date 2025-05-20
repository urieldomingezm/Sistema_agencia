<?php
// Check if constants are defined before using them
if (!defined('VER_PERFIL_PATCH') || !defined('GESTION_PAGAS_PATCH')) {
    die('Required constants are not defined');
}

require_once(VER_PERFIL_PATCH . 'ver_perfil.php');
require_once(GESTION_PAGAS_PATCH . 'mostrar_usuarios.php');

try {
    $userProfile = new UserProfile();
    $userData = $userProfile->getUserData();
} catch (Exception $e) {
    die('Error loading user data: ' . $e->getMessage());
}

$pagaUsuario = null;

if (isset($pagas) && is_array($pagas)) {
    foreach ($pagas as $paga) {
        if ($paga['pagas_usuario'] === $userData['username']) {
            $pagaUsuario = $paga;
            break;
        }
    }
}
?>

<div class="profile-header py-4 position-relative overflow-hidden">
    <div class="background-pattern"></div>
    <div class="container position-relative">
        <div class="d-flex align-items-center">
            <div class="avatar-container me-3" style="width: 60px; height: 60px;">
                <img src="<?php echo htmlspecialchars($userData['avatar'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
                     class="rounded-circle shadow border border-3 border-white" 
                     alt="Profile Avatar" 
                     style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div>
                <h1 class="h4 fw-bold text-white text-shadow mb-0 d-flex align-items-center">
                    <?php echo htmlspecialchars($userData['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    <span class="badge bg-success ms-2">Activo</span> 
                    <!-- Para "Inactivo" podrías usar: <span class="badge bg-secondary ms-2">Inactivo</span> -->
                </h1>
                <small class="text-white-50"><?php echo htmlspecialchars($userData['role'] ?? '', ENT_QUOTES, 'UTF-8'); ?></small>
            </div>
        </div>
    </div>
</div>

<div class="container py-3">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
        <?php
        $sections = [
            'Personal' => [
                ['Usuario', $userData['username'] ?? ''],
                ['Código', $userData['codigo'] ?? ''],
                ['Rango', $userData['role'] ?? '', 'badge-custom'],
                ['Membresia', $userData['role'] ?? '', 'badge-custom']
            ],
            'Requisitos pago' => [
                ['Pago Pendiente', '30'],
                ['Estado de sus requisitos', 'Pendiente', 'badge bg-warning text-dark'],
                ['Recibio pago', 'No', 'badge bg-danger text-white'],
                ['Estado de Requisitos', 'Pendiente', 'badge bg-warning text-dark']
            ],
            'Tiempo de paga' => [
                ['Tiempo Acumulado', $userData['tiempo_acumulado'] ?? '0'],
                ['Tiempo Restado', $userData['tiempo_restado'] ?? '0'],
                ['Encargado', $userData['tiempo_encargado'] ?? 'No disponible'],
                ['Estado', ucfirst($userData['tiempo_status'] ?? 'No disponible'), 'badge text-white ' . getStatusColor($userData['tiempo_status'] ?? '')]
            ],
            'Ascenso' => [
                ['Misión actual', $userData['mission'] ?? 'No asignada'],
                ['Encargado', $userData['encargado'] ?? 'No asignado'],
                ['Próxima hora', formatEstimatedTime($userData['estimatedTime'] ?? '')],
                ['Estado ascenso', ($userData['estado_disponibilidad'] ?? 'pendiente') === 'disponible' ? 'Disponible' : 'Pendiente', 
                 'badge text-white ' . (($userData['estado_disponibilidad'] ?? 'pendiente') === 'disponible' ? 'bg-success' : 'bg-warning')]
            ]
        ];

        foreach ($sections as $title => $items) {
            echo renderSection($title, $items);
        }
        ?>
    </div>
</div>

<?php
function renderSection($title, $items) {
    // Añadidas clases 'shadow' y 'border' para hacer las tarjetas más llamativas
    $html = '<div class="col"><div class="profile-card glass-effect h-100 shadow border">';
    $html .= '<div class="card-header bg-gradient-primary py-2"><h3 class="h6 mb-0">'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'</h3></div>';
    $html .= '<div class="stats-card p-2">';

    foreach ($items as $item) {
        $html .= '<div class="info-item d-flex align-items-center">';
        $html .= '<span class="info-label me-2">'.htmlspecialchars($item[0], ENT_QUOTES, 'UTF-8').'</span>';
        $html .= isset($item[2]) ?
                '<span class="'.htmlspecialchars($item[2], ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8').'</span>' :
                '<span class="info-value">'.htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8').'</span>';
        $html .= '</div>';
    }

    $html .= '</div></div></div>';
    return $html;
}

function getStatusColor($status) {
    switch(strtolower($status)) {
        case 'pausa': 
        case 'inactivo': 
            return 'bg-secondary';
        case 'activo': 
            return 'bg-primary';
        case 'completado': 
            return 'bg-success';
        default: 
            return 'bg-secondary';
    }
}

function formatEstimatedTime($time) {
    if (empty($time)) {
        return 'No disponible';
    }

    try {
        $date = DateTime::createFromFormat('d/m/Y H:i', $time);
        if (!$date) {
            $date = new DateTime($time);
        }
        
        $minutes = (int)$date->format('i');
        $seconds = (int)$date->format('s');
        $output = [];

        if ($minutes > 0) {
            $output[] = $minutes . ' minuto' . ($minutes > 1 ? 's' : '');
        }
        if ($seconds > 0) {
            $output[] = $seconds . ' segundo' . ($seconds > 1 ? 's' : '');
        }

        return empty($output) ? '0 minutos' : implode(' con ', $output);
    } catch (Exception $e) {
        return 'Formato de fecha inválido';
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let lastCheck = 0;
    const checkInterval = 60000; // 1 minute

    async function checkAscenso() {
        const now = Date.now();
        if (now - lastCheck < checkInterval) return;

        lastCheck = now;

        try {
            const response = await fetch('<?php echo VER_PERFIL_PATCH; ?>check_ascenso.php');
            if (!response.ok) throw new Error('Network response was not ok');
            
            const data = await response.json();
            if(data.disponible) {
                document.querySelectorAll('.info-item').forEach(item => {
                    if (item.querySelector('.info-label').textContent === 'Estado ascenso') {
                        const badge = item.querySelector('.badge');
                        if (badge) {
                            badge.classList.replace('bg-warning', 'bg-success');
                            badge.textContent = 'Disponible';
                        }
                    }
                });
            }
        } catch (error) {
            console.error('Error checking ascenso:', error);
        }
    }

    checkAscenso();
    setInterval(checkAscenso, checkInterval);
});
</script>