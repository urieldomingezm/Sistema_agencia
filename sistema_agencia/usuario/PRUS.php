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
    $ultimaPagaUsuario = $pagasData[0];
}

$sections = [
    'Información' => [
        ['ID', $personalData['id'] ?? ''],
        ['Usuario', $personalData['nombre_habbo'] ?? ''],
        ['Código', $personalData['codigo_time'] ?? ''],
        ['Rango', $ascensoData['rango_actual'] ?? 'N/A', 'badge bg-primary'],
        ['Membresía', $membresiaData['venta_titulo'] ?? 'N/A', 'badge bg-warning text-dark'],
    ],
    'Pagos' => [
        ['Estado', !empty($requisitosData) ? 'Pendiente' : 'Ninguno', !empty($requisitosData) ? 'badge bg-info text-dark' : 'badge bg-secondary'],
        ['Recibido', $ultimaPagaUsuario['pagas_completo'] ?? 'No', ($ultimaPagaUsuario['pagas_completo'] ?? false) ? 'badge bg-success text-white' : 'badge bg-danger text-white'],
    ],
    'Tiempo' => [
        ['Total', $tiempoData['tiempo_acumulado'] ?? '0'],
        ['Restado', $tiempoData['tiempo_restado'] ?? '0'],
        ['Estado', ucfirst($tiempoData['tiempo_status'] ?? 'N/A'), 'badge text-white ' . getStatusColor($tiempoData['tiempo_status'] ?? '')]
    ],
    'Ascenso' => [
        ['Tarea', $ascensoData['mision_actual'] ?? 'Ninguna'],
        ['Siguiente', formatEstimatedTime($ascensoData['fecha_disponible_ascenso'] ?? '')],
        [
            'Estado',
            ($ascensoData['estado_ascenso'] ?? 'pendiente') === 'disponible' ? 'Listo' : 'Espera',
            'badge text-white ' . (($ascensoData['estado_ascenso'] ?? 'pendiente') === 'disponible' ? 'bg-success' : 'bg-warning')
        ]
    ]
];
?>

<div class="container-fluid p-0">
    <!-- Header -->
    <div class="bg-gradient-primary text-white py-4">
        <div class="container">
            <div class="d-flex flex-column align-items-center">
                <div class="avatar bg-white rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-person-fill text-primary fs-2"></i>
                </div>
                <h1 class="h4 mb-2 fw-bold text-center">
                    <?= htmlspecialchars($personalData['nombre_habbo'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                </h1>
                <span class="badge bg-success">
                    <i class="bi bi-check-circle-fill me-1"></i>Activo
                </span>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="container py-4">
        <!-- Información General -->
        <div class="card mb-4 border-start border-primary border-4 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-info-circle-fill text-primary me-2"></i>Información General
                </h5>
            </div>
            <div class="card-body">
                <?php foreach ($sections['Información'] as $item): ?>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted"><?= htmlspecialchars($item[0]) ?></span>
                    <span class="fw-bold">
                        <?php if (isset($item[2])): ?>
                            <span class="<?= htmlspecialchars($item[2]) ?>">
                                <?= htmlspecialchars($item[1]) ?>
                            </span>
                        <?php else: ?>
                            <?= htmlspecialchars($item[1]) ?>
                        <?php endif; ?>
                    </span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sección de Pagos y Tiempo -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card h-100 border-start border-success border-4 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-credit-card-fill text-success me-2"></i>Pagos
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($sections['Pagos'] as $item): ?>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted"><?= htmlspecialchars($item[0]) ?></span>
                            <span class="fw-bold">
                                <?php if (isset($item[2])): ?>
                                    <span class="<?= htmlspecialchars($item[2]) ?>">
                                        <?= htmlspecialchars($item[1]) ?>
                                    </span>
                                <?php else: ?>
                                    <?= htmlspecialchars($item[1]) ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 border-start border-warning border-4 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-stopwatch-fill text-warning me-2"></i>Tiempo
                        </h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($sections['Tiempo'] as $item): ?>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted"><?= htmlspecialchars($item[0]) ?></span>
                            <span class="fw-bold">
                                <?php if (isset($item[2])): ?>
                                    <span class="<?= htmlspecialchars($item[2]) ?>">
                                        <?= htmlspecialchars($item[1]) ?>
                                    </span>
                                <?php else: ?>
                                    <?= htmlspecialchars($item[1]) ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Ascenso -->
        <div class="card border-start border-info border-4 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-graph-up-arrow text-info me-2"></i>Ascenso
                </h5>
            </div>
            <div class="card-body">
                <?php foreach ($sections['Ascenso'] as $item): ?>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted"><?= htmlspecialchars($item[0]) ?></span>
                    <span class="fw-bold">
                        <?php if (isset($item[2])): ?>
                            <span class="<?= htmlspecialchars($item[2]) ?>">
                                <?= htmlspecialchars($item[1]) ?>
                            </span>
                        <?php else: ?>
                            <?= htmlspecialchars($item[1]) ?>
                        <?php endif; ?>
                    </span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php
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