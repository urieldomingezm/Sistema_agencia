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
<style>
        .profile-header {
            height: 120px;
            background: linear-gradient(45deg, #1877f2, #25a3ff);
        }
        .profile-avatar {
            width: 60px;
            height: 60px;
            border: 3px solid white;
            background-color: #f0f2f5;
        }
        .compact-card {
            border-radius: 8px;
            margin-bottom: 0.75rem;
            border: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .compact-card .card-header {
            padding: 0.5rem 1rem;
            background: white;
            border-bottom: 1px solid #eee;
        }
        .compact-card .card-body {
            padding: 0;
        }
        .info-row {
            padding: 0.5rem 1rem;
            border-bottom: 1px solid #f5f5f5;
            display: flex;
            justify-content: space-between;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        /* Estilo para hacer las letras de los valores más grandes */
        .info-row span.fw-bold {
            font-size: 1rem;
        }
        /* Estilo para hacer las letras de las etiquetas más grandes */
        .info-row span.text-muted.small {
            font-size: 1rem; /* Ajustado a 1rem */
        }
        .signature-box {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
            font-size: 0.9rem;
        }
        .badge-sm {
            padding: 0.25em 0.5em;
            font-size: 0.75em;
        }
        @media (max-width: 576px) {
            .profile-header {
                height: 100px;
            }
            .profile-avatar {
                width: 50px;
                height: 50px;
            }
            .section-title {
                font-size: 0.95rem;
            }
             /* Ajuste para pantallas pequeñas si es necesario */
            .info-row span.fw-bold {
                font-size: 0.9rem;
            }
            /* Ajuste para pantallas pequeñas si es necesario */
            .info-row span.text-muted.small {
                font-size: 0.9rem;
            }
        }
    </style>

    <div class="container-fluid p-0">
        <!-- Header compacto -->
        <div class="profile-header position-relative" style="height: 125px;">
            <div class="container pt-2">
                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                    <div class="profile-avatar rounded-circle d-flex align-items-center justify-content-center mb-2">
                        <i class="bi bi-person-fill text-muted"></i>
                    </div>
                    <h1 class="h5 mb-1 text-white fw-bold text-center">
                        <?php echo htmlspecialchars($personalData['nombre_habbo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </h1>
                    <span class="badge bg-success badge-sm">
                        <i class="bi bi-check-circle-fill me-1"></i>Activo
                    </span>
                </div>
            </div>
        </div>

        <!-- Contenido principal compacto -->
        <div class="container py-2 px-2">
            <!-- Información General -->
            <div class="card compact-card mb-2 border border-primary">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold section-title"><i class="bi bi-info-circle me-1"></i>Información</h6>
                </div>
                <div class="card-body">
                    <?php foreach ($sections['Información'] as $item): ?>
                    <div class="info-row">
                        <span class="text-muted small"><?php echo htmlspecialchars($item[0], ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="fw-bold text-end small">
                            <?php if (isset($item[2])): ?>
                                <span class="<?php echo htmlspecialchars($item[2], ENT_QUOTES, 'UTF-8'); ?> badge-sm px-1">
                                    <?php echo htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            <?php else: ?>
                                <?php echo htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8'); ?>
                            <?php endif; ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Pagos y Tiempo en una fila -->
            <div class="row g-2">
                <div class="col-md-6">
                    <div class="card compact-card h-100 border border-info">
                        <div class="card-header">
                            <h6 class="mb-0 fw-bold section-title"><i class="bi bi-credit-card me-1"></i>Pagos</h6>
                        </div>
                        <div class="card-body">
                            <?php foreach ($sections['Pagos'] as $item): ?>
                            <div class="info-row">
                                <span class="text-muted small"><?php echo htmlspecialchars($item[0], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="fw-bold text-end small">
                                    <?php if (isset($item[2])): ?>
                                        <span class="<?php echo htmlspecialchars($item[2], ENT_QUOTES, 'UTF-8'); ?> badge-sm px-1">
                                            <?php echo htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    <?php else: ?>
                                        <?php echo htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8'); ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card compact-card h-100 border border-warning">
                        <div class="card-header">
                            <h6 class="mb-0 fw-bold section-title"><i class="bi bi-stopwatch me-1"></i>Tiempo</h6>
                        </div>
                        <div class="card-body">
                            <?php foreach ($sections['Tiempo'] as $item): ?>
                            <div class="info-row">
                                <span class="text-muted small"><?php echo htmlspecialchars($item[0], ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="fw-bold text-end small">
                                    <?php if (isset($item[2])): ?>
                                        <span class="<?php echo htmlspecialchars($item[2], ENT_QUOTES, 'UTF-8'); ?> badge-sm px-1">
                                            <?php echo htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    <?php else: ?>
                                        <?php echo htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8'); ?>
                                    <?php endif; ?>
                                </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ascenso -->
            <div class="card compact-card mt-2 border border-success">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold section-title"><i class="bi bi-graph-up me-1"></i>Ascenso</h6>
                </div>
                <div class="card-body">
                    <?php foreach ($sections['Ascenso'] as $item): ?>
                    <div class="info-row">
                        <span class="text-muted small"><?php echo htmlspecialchars($item[0], ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="fw-bold text-end small">
                            <?php if (isset($item[2])): ?>
                                <span class="<?php echo htmlspecialchars($item[2], ENT_QUOTES, 'UTF-8'); ?> badge-sm px-1">
                                    <?php echo htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            <?php else: ?>
                                <?php echo htmlspecialchars($item[1], ENT_QUOTES, 'UTF-8'); ?>
                            <?php endif; ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <br>
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