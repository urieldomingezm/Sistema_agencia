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

$siguienteAscenso = 'No disponible';
$descripcionTiempo = '';

if (isset($ascensoData['fecha_disponible_ascenso'])) {
    if ($ascensoData['fecha_disponible_ascenso'] === '00:00:00') {
        $siguienteAscenso = 'Disponible ahora';
        $descripcionTiempo = 'Ya puedes solicitar tu ascenso';
    } else {
        // Parsear el tiempo en formato HH:MM:SS
        $tiempo = $ascensoData['fecha_disponible_ascenso'];

        if (preg_match('/^(\d{2}):(\d{2}):(\d{2})$/', $tiempo, $matches)) {
            $horas = intval($matches[1]);
            $minutos = intval($matches[2]);
            $segundos = intval($matches[3]);

            // Convertir a días si hay más de 24 horas
            $dias = 0;
            if ($horas >= 24) {
                $dias = floor($horas / 24);
                $horas = $horas % 24;
            }

            // Construir descripción detallada
            $partesTiempo = [];

            if ($dias > 0) {
                $partesTiempo[] = $dias . ' día' . ($dias > 1 ? 's' : '');
            }
            if ($horas > 0) {
                $partesTiempo[] = $horas . ' hora' . ($horas > 1 ? 's' : '');
            }
            if ($minutos > 0) {
                $partesTiempo[] = $minutos . ' minuto' . ($minutos > 1 ? 's' : '');
            }
            if ($segundos > 0) {
                $partesTiempo[] = $segundos . ' segundo' . ($segundos > 1 ? 's' : '');
            }

            $siguienteAscenso = $ascensoData['fecha_disponible_ascenso'];
            $descripcionTiempo = 'Faltan ' . implode(', ', $partesTiempo);
        } else {
            $siguienteAscenso = $ascensoData['fecha_disponible_ascenso'];
            $descripcionTiempo = 'Tiempo no válido';
        }
    }
}

$sections = [
    'Información' => [
        ['ID', $personalData['id'] ?? 'N/A'],
        ['Usuario', $personalData['nombre_habbo'] ?? 'N/A'],
        ['Código', $personalData['codigo_time'] ?? 'N/A'],
        ['Rango', $ascensoData['rango_actual'] ?? 'N/A', 'badge bg-primary'],
        [
            'Membresía',
            isset($membresiaData['venta_titulo']) ?
                "{$membresiaData['venta_titulo']} - {$membresiaData['venta_estado']}" :
                'Sin membresía',
            isset($membresiaData['venta_estado']) && $membresiaData['venta_estado'] === 'activa' ?
                'badge bg-success' : 'badge bg-warning text-dark'
        ],
    ],
    'Pagos' => [
        [
            'Estado Requisitos',
            !empty($requisitosData) && is_array($requisitosData[0]) ?
                ($requisitosData[0]['is_completed'] ? 'Completado' : 'Pendiente') :
                'Sin requisitos',
            !empty($requisitosData) && is_array($requisitosData[0]) ?
                ($requisitosData[0]['is_completed'] ? 'badge bg-success' : 'badge bg-warning') :
                'badge bg-secondary'
        ],
        [
            'Último Pago',
            !empty($pagasData) && is_array($pagasData[0]) ?
                "Recibió {$pagasData[0]['pagas_recibio']}c - {$pagasData[0]['pagas_motivo']}" :
                'Sin pagos previos',
            !empty($pagasData) && is_array($pagasData[0]) && $pagasData[0]['pagas_completo'] ?
                'badge bg-success' : 'badge bg-secondary'
        ],
        [
            'Próximo Pago',
            !empty($requisitosData) && is_array($requisitosData[0]) && $requisitosData[0]['is_completed'] ?
                'Pendiente de recibir pago' : 'Complete los requisitos',
            !empty($requisitosData) && is_array($requisitosData[0]) && $requisitosData[0]['is_completed'] ?
                'badge bg-info' : 'badge bg-warning'
        ],
    ],
    'Tiempo' => [
        [
            'Total Acumulado', 
            $tiempoData['tiempo_acumulado'] ?? '00:00:00',
            '',
            '<button onclick="verificarTiempoTranscurrido(\'' . ($personalData['codigo_time'] ?? '') . '\')" 
         class="btn btn-sm btn-outline-primary ms-2">
            <i class="bi bi-clock-history"></i>
         </button>'
        ],
        ['Tiempo Restado', $tiempoData['tiempo_restado'] ?? '00:00:00'],
        [
            'Encargado',
            $tiempoData['tiempo_encargado_usuario'] ?? 'Sin asignar',
            $tiempoData['tiempo_encargado_usuario'] ? 'badge bg-info' : 'badge bg-secondary'
        ],
        [
            'Estado',
            ucfirst($tiempoData['tiempo_status'] ?? 'inactivo'),
            'badge text-white ' . getStatusColor($tiempoData['tiempo_status'] ?? 'inactivo')
        ]
    ],
    'Ascenso' => [
        ['Misión Actual', $ascensoData['mision_actual'] ?? 'Sin misión'],
        [
            'Próximo Ascenso',
            $siguienteAscenso . ($descripcionTiempo ? '<br><small class="text-muted">' . $descripcionTiempo . '</small>' : ''),
            'badge ' . ($siguienteAscenso === 'Disponible ahora' ? 'bg-success' : 'bg-info') . ' text-white'
        ],
        [
            'Estado',
            ($ascensoData['estado_ascenso'] ?? 'pendiente') === 'disponible' ?
                'Disponible para ascender' : 'En Espera',
            'badge text-white ' .
                (($ascensoData['estado_ascenso'] ?? 'pendiente') === 'disponible' ?
                    'bg-success' : 'bg-warning')
        ],
        [
            'Encargado',
            $ascensoData['usuario_encargado'] ?? 'Sin asignar',
            $ascensoData['usuario_encargado'] ? 'badge bg-info' : 'badge bg-secondary'
        ]
    ]
};
?>

<div class="container-fluid p-0">
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

    <div class="container py-4">
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
                                    <?= $item[1] // Nota: Aquí quitamos htmlspecialchars para permitir el HTML del <small> 
                                    ?>
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
function getStatusColor($status)
{
    switch (strtolower($status)) {
        case 'pausa':
        case 'inactivo':
            return 'bg-warning';
        case 'activo':
            return 'bg-primary';
        case 'completado':
            return 'bg-success';
        default:
            return 'bg-secondary';
    }
}

function formatEstimatedTime($time)
{
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

<head>
    <meta name="keywords" content="Requisitos de paga, ascensos y misiones para los usuarios como tambien traslados">
</head>

<script>
function verificarTiempoTranscurrido(codigoTime) {
    if (!codigoTime) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se encontró el código de tiempo'
        });
        return;
    }

    Swal.fire({
        title: 'Verificando tiempo...',
        text: 'Por favor espera',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('/private/procesos/gestion_tiempos/ver_tiempo_ajax.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            codigo_time: codigoTime
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'info',
                title: 'Tiempo Transcurrido',
                html: `
                    <div class="text-start">
                        <p><strong>Tiempo Acumulado:</strong> ${data.tiempo_acumulado}</p>
                        <p><strong>Tiempo Transcurrido:</strong> ${data.tiempo_transcurrido}</p>
                        <p><strong>Tiempo Total:</strong> ${data.tiempo_total}</p>
                    </div>
                `,
                confirmButtonColor: '#3085d6'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'No se pudo obtener el tiempo transcurrido'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al procesar la solicitud'
        });
    });
}
</script>