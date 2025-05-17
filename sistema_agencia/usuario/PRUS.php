<!-- PROCESO DE VER PERFIL -->
<?php
require_once(VER_PERFIL_PATCH . 'ver_perfil.php');
require_once(GESTION_PAGAS_PATCH . 'mostrar_usuarios.php'); // MOSTRAR USUARIOS
$userProfile = new UserProfile();
$userData = $userProfile->getUserData();


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

<div class="profile-header py-4 position-relative overflow-hidden"> <!-- Increased padding -->
    <div class="background-pattern"></div>
    <div class="container position-relative">
        <div class="d-flex align-items-center">
            <div class="avatar-container me-3" style="width: 60px; height: 60px;"> <!-- Slightly larger avatar -->
                <img src="<?php echo $userData['avatar']; ?>" class="rounded-circle shadow border border-3 border-white" alt="Profile Avatar" style="width: 100%; height: 100%; object-fit: cover;"> <!-- Thicker border -->
                <div class="status-badge pulse" style="width: 12px; height: 12px;"></div> <!-- Slightly larger badge -->
            </div>
            <div>
                <h1 class="h4 fw-bold text-white text-shadow mb-0"><?php echo $userData['username']; ?></h1> <!-- Adjusted font size -->
                <small class="text-white-50"><?php echo $userData['role']; ?></small>
            </div>
        </div>
    </div>
</div>

<div class="container py-3">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
        <?php
        $sections = [
            'Personal' => [
                ['Usuario', $userData['username']],
                ['Código', $userData['codigo']],
                ['Rango', $userData['role'], 'badge-custom'],
                ['Membresia', $userData['role'], 'badge-custom'] // Assuming role is used for membership status
            ],
            'Requisitos pago' => [
                ['Pago Pendiente', '30'], // Placeholder value
                ['Estado de sus requisitos', 'Pendiente', 'badge bg-warning text-dark'], // Placeholder value
                ['Recibio pago', 'No', 'badge bg-danger text-white'], // Placeholder value
                ['Estado de Requisitos', 'Pendiente', 'badge bg-warning text-dark'] // Placeholder value
            ],
            'Tiempo de paga' => [
                ['Tiempo Acumulado', $userData['tiempo_acumulado']],
                ['Tiempo Restado', $userData['tiempo_restado']],
                ['Encargado', $userData['tiempo_encargado'] ?? 'No disponible'],
                ['Estado', ucfirst($userData['tiempo_status'] ?? 'No disponible'), 'badge text-white ' . getStatusColor($userData['tiempo_status'])]
            ],
            'Ascenso' => [
                ['Misión actual', $userData['mission']],
                ['Encargado', $userData['encargado']],
                ['Próxima hora', formatEstimatedTime($userData['estimatedTime'])],
                ['Estado ascenso', ($userData['estado_disponibilidad'] ?? 'pendiente') === 'disponible' ? 'Disponible' : 'Pendiente', 'badge text-white ' . (($userData['estado_disponibilidad'] ?? 'pendiente') === 'disponible' ? 'bg-success' : 'bg-warning')]
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
    $html = '<div class="col"><div class="profile-card glass-effect h-100">';
    $html .= '<div class="card-header bg-gradient-primary py-2"><h3 class="h6 mb-0">'.$title.'</h3></div>'; // Adjusted font size
    $html .= '<div class="stats-card p-2">';

    foreach ($items as $item) {
        $html .= '<div class="info-item d-flex align-items-center">';
        $html .= '<span class="info-label me-2">'.$item[0].'</span>';
        $html .= isset($item[2]) ? '<span class="'.$item[2].'">'.$item[1].'</span>' : '<span class="info-value">'.$item[1].'</span>';
        $html .= '</div>';
    }

    $html .= '</div></div></div>';
    return $html;
}

function getStatusColor($status) {
    switch($status) {
        case 'pausa': case 'inactivo': return 'bg-secondary';
        case 'Activo': return 'bg-primary';
        case 'completado': return 'bg-success';
        default: return 'bg-secondary';
    }
}

function formatEstimatedTime($time) {
    if (empty($time)) return 'No disponible';

    // Assuming $time is already in 'd/m/Y H:i' format from the database query
    // If it's a database timestamp, you might need:
    // $date = new DateTime($time);
    // $minutes = $date->format('i');
    // $seconds = $date->format('s');

    // If it's already 'd/m/Y H:i' string:
    $date = DateTime::createFromFormat('d/m/Y H:i', $time);
    if (!$date) {
         // Fallback if format is different, try common database timestamp format
         $date = new DateTime($time);
         if (!$date) return 'Formato de fecha inválido';
    }

    $minutes = (int)$date->format('i');
    $seconds = (int)$date->format('s');
    $output = [];

    if ($minutes > 0) $output[] = $minutes . ' minuto' . ($minutes > 1 ? 's' : '');
    if ($seconds > 0) $output[] = $seconds . ' segundo' . ($seconds > 1 ? 's' : '');

    return empty($output) ? '0 minutos' : implode(' con ', $output);
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Removed the initial SweetAlert2 message as requested previously

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
                    // Find the badge for 'Estado ascenso' specifically
                    const infoItems = document.querySelectorAll('.info-item');
                    infoItems.forEach(item => {
                        if (item.querySelector('.info-label').textContent === 'Estado ascenso') {
                            const badge = item.querySelector('.badge');
                            if (badge) {
                                badge.classList.replace('bg-warning', 'bg-success');
                                badge.textContent = 'Disponible';
                            }
                        }
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    }

    checkAscenso();
    setInterval(checkAscenso, checkInterval);
});
</script>