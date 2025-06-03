<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$codigoTime = $input['codigo_time'] ?? null;

if (!$codigoTime) {
    echo json_encode(['success' => false, 'message' => 'Código de tiempo no proporcionado']);
    exit;
}

try {
    $database = new Database();
    $conn = $database->getConnection();

    $query = "SELECT 
        tiempo_status,
        tiempo_acumulado,
        tiempo_iniciado
    FROM gestion_tiempo 
    WHERE codigo_time = :codigo_time";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':codigo_time', $codigoTime);
    $stmt->execute();

    $tiempo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tiempo) {
        date_default_timezone_set('America/Mexico_City');
        $tiempo_actual = new DateTime();
        $tiempo_transcurrido = '00:00:00';
        $tiempo_total = $tiempo['tiempo_acumulado'];

        if ($tiempo['tiempo_status'] === 'activo' && $tiempo['tiempo_iniciado']) {
            $tiempo_inicio = new DateTime($tiempo['tiempo_iniciado']);
            $diferencia = $tiempo_actual->diff($tiempo_inicio);
            
            $tiempo_transcurrido = sprintf(
                '%02d:%02d:%02d',
                ($diferencia->days * 24) + $diferencia->h,
                $diferencia->i,
                $diferencia->s
            );

            // Calcular tiempo total
            list($h_acu, $m_acu, $s_acu) = explode(':', $tiempo['tiempo_acumulado']);
            list($h_trans, $m_trans, $s_trans) = explode(':', $tiempo_transcurrido);
            
            $total_segundos = ($h_acu * 3600 + $m_acu * 60 + $s_acu) +
                            ($h_trans * 3600 + $m_trans * 60 + $s_trans);
            
            $h_total = floor($total_segundos / 3600);
            $m_total = floor(($total_segundos % 3600) / 60);
            $s_total = $total_segundos % 60;
            
            $tiempo_total = sprintf('%02d:%02d:%02d', $h_total, $m_total, $s_total);
        }

        echo json_encode([
            'success' => true,
            'tiempo_acumulado' => $tiempo['tiempo_acumulado'],
            'tiempo_transcurrido' => $tiempo_transcurrido,
            'tiempo_total' => $tiempo_total
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontraron datos de tiempo']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

// En la sección de 'Tiempo' del array $sections
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