<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

require_once(VER_PERFIL_PATCH . 'mostrar_todo.php');

try {
    $userProfileData = new UserProfileData();

    if ($userProfileData->hasErrors()) {
        die('Error al cargar datos del perfil: ' . implode(', ', $userProfileData->getErrors()));
    }

    $personalData = $userProfileData->getPersonalData();
    $membresiaData = $userProfileData->getMembresiaData();
    $ascensoData = $userProfileData->getAscensoData();
    $tiempoData = $userProfileData->getTiempoData();
    $requisitosData = $userProfileData->getRequisitosData();
    $pagasData = $userProfileData->getPagasData();
} catch (Exception $e) {
    die('Error general al procesar datos del perfil: ' . $e->getMessage());
}

$ultimaPagaUsuario = null;
if (!empty($pagasData)) {
    if (!empty($pagasData)) {
        $ultimaPagaUsuario = $pagasData[0];
    }
}
?>

<div class="profile-header py-4 position-relative overflow-hidden bg-dark">
    <div class="background-pattern"></div>
    <div class="container position-relative">
        <div class="d-flex align-items-center">
            <div>
                <h1 class="h4 fw-bold text-white text-shadow mb-0 d-flex align-items-center">
                    <?php echo htmlspecialchars($personalData['nombre_habbo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    <span class="badge bg-success ms-2">Activo</span>
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="container py-3">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        <?php
        $sections = [
            'Información' => [
                ['ID', $personalData['id'] ?? ''],
                ['Usuario', $personalData['nombre_habbo'] ?? ''],
                ['Código', $personalData['codigo_time'] ?? ''],
                ['Rango', $ascensoData['rango_actual'] ?? 'N/A', 'badge-custom'],
                ['Membresía', $membresiaData['venta_titulo'] ?? 'N/A', 'badge-custom'],
            ],
            'Pagos' => [
                ['Pendiente', 'N/A'],
                ['Estado', !empty($requisitosData) ? 'Pendiente' : 'Ninguno', !empty($requisitosData) ? 'badge bg-info text-dark' : 'badge bg-secondary'],
                ['Recibido', $ultimaPagaUsuario['pagas_completo'] ?? 'No', ($ultimaPagaUsuario['pagas_completo'] ?? false) ? 'badge bg-success text-white' : 'badge bg-danger text-white'],
            ],
            'Tiempo' => [
                ['Total', $tiempoData['tiempo_acumulado'] ?? '0'],
                ['Restado', $tiempoData['tiempo_restado'] ?? '0'],
                ['Encargado', $tiempoData['tiempo_encargado_usuario'] ?? 'N/A'],
                ['Estado', ucfirst($tiempoData['tiempo_status'] ?? 'N/A'), 'badge text-white ' . getStatusColor($tiempoData['tiempo_status'] ?? '')]
            ],
            'Ascenso' => [
                ['Tarea', $ascensoData['mision_actual'] ?? 'Ninguna'],
                ['Líder', $ascensoData['usuario_encargado'] ?? 'Ninguno'],
                ['Mi firma', $ascensoData['firma_usuario'] ?? 'N/A'],
                ['Siguiente', formatEstimatedTime($ascensoData['fecha_disponible_ascenso'] ?? '')],
                [
                    'Estado',
                    ($ascensoData['estado_ascenso'] ?? 'pendiente') === 'disponible' ? 'Listo' : 'Espera',
                    'badge text-white ' . (($ascensoData['estado_ascenso'] ?? 'pendiente') === 'disponible' ? 'bg-success' : 'bg-warning')
                ]
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
    $html = '<div class="col"><div class="card h-100 shadow border rounded">';
    $html .= '<div class="card-header bg-gradient-primary py-2"><h3 class="h6 mb-0 text-white">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</h3></div>';
    $html .= '<div class="card-body p-2 d-flex flex-wrap">';

    foreach ($items as $item) {
        $html .= '<div class="d-flex align-items-center me-3 mb-2 justify-content-between w-auto">';
        $html .= '<span class="text-muted fw-medium me-1">' . htmlspecialchars($item[0], ENT_QUOTES, 'UTF-8') . '</span>';
        $html .= isset($item[2]) ?
            '<span class="' . htmlspecialchars($item[2], ENT_QUOTES, 'UTF-8') . ' badge bg-primary rounded-pill">' . htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8') . '</span>' :
            '<span class="fw-semibold text-dark">' . htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8') . '</span>';
        $html .= '</div>';
    }

    $html .= '</div></div></div>';
    return $html;
}

function getStatusColor($status) {
    switch (strtolower($status)) {
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let lastCheck = 0;
        const checkInterval = 60000;

        async function checkAscenso() {
            const now = Date.now();
            if (now - lastCheck < checkInterval) return;

            lastCheck = now;

            try {
                const response = await fetch('<?php echo VER_PERFIL_PATCH; ?>check_ascenso.php');
                if (!response.ok) throw new Error('Network response was not ok');

                const data = await response.json();
                if (data.disponible) {
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