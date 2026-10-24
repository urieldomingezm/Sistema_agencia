<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

require_once(CONFIG_PATH . 'bd.php');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigoTime = $_POST['codigo'] ?? '';

    if (empty($codigoTime)) {
        $response['message'] = 'El código de usuario no puede estar vacío.';
        echo json_encode($response);
        exit;
    }

    if (strlen($codigoTime) !== 5 || !ctype_alnum($codigoTime)) {
        $response['message'] = 'El código de usuario debe tener exactamente 5 caracteres alfanuméricos.';
        echo json_encode($response);
        exit;
    }

    // Usar la clase Database y su método getConnection()
    $database = new Database();
    $conn = $database->getConnection();

    if (!$conn) {
         $response['message'] = 'Error al conectar con la base de datos.';
         echo json_encode($response);
         exit;
    }

    // Buscar en registro_usuario
    // Usando PDO para consultas preparadas
    $stmtUsuario = $conn->prepare("SELECT `id`, `nombre_habbo`, `codigo_time` FROM `registro_usuario` WHERE `codigo_time` = :codigoTime");
    $stmtUsuario->bindParam(':codigoTime', $codigoTime);
    $stmtUsuario->execute();
    $usuario = $stmtUsuario->fetch(PDO::FETCH_ASSOC);
    $stmtUsuario->closeCursor(); // Cerrar cursor para la siguiente consulta

    if (!$usuario) {
        $response['message'] = 'Usuario no encontrado con ese código.';
        echo json_encode($response);
        // PDO no necesita $conn->close() explícito, se cierra al finalizar el script o al asignar null
        exit;
    }

    // Buscar en ascensos
    // Usando PDO para consultas preparadas
    // Corregida la consulta para usar fecha_disponible_ascenso en lugar de tiempo_ascenso
    $stmtAscenso = $conn->prepare("SELECT `rango_actual`, `mision_actual`, `estado_ascenso`, `fecha_ultimo_ascenso`, `fecha_disponible_ascenso` FROM `ascensos` WHERE `codigo_time` = :codigoTime");
    $stmtAscenso->bindParam(':codigoTime', $codigoTime);
    $stmtAscenso->execute();
    $ascenso = $stmtAscenso->fetch(PDO::FETCH_ASSOC);
    $stmtAscenso->closeCursor(); // Cerrar cursor

    // PDO no necesita $conn->close() explícito aquí

    if (!$ascenso) {
        $response['message'] = 'No se encontraron datos de ascenso para este usuario.';
        echo json_encode($response);
        exit;
    }

    $tiempoTranscurrido = 'No disponible';
    $proximaHoraEstimada = 'No disponible';

    // Ajustar la lógica para usar fecha_disponible_ascenso
    if ($ascenso['estado_ascenso'] === 'en_espera' && !empty($ascenso['fecha_disponible_ascenso']) && $ascenso['fecha_disponible_ascenso'] !== '0000-00-00 00:00:00') {
        try {
            $fechaDisponible = new DateTime($ascenso['fecha_disponible_ascenso'], new DateTimeZone('America/Mexico_City'));
            $ahora = new DateTime('now', new DateTimeZone('America/Mexico_City'));

            if ($ahora < $fechaDisponible) {
                $intervalo = $ahora->diff($fechaDisponible);

                // Calcular segundos restantes
                $segundosRestantes = $intervalo->days * 86400 + $intervalo->h * 3600 + $intervalo->i * 60 + $intervalo->s;

                $horas = floor($segundosRestantes / 3600);
                $minutos = floor(($segundosRestantes % 3600) / 60);
                $segundos = $segundosRestantes % 60;

                $tiempoTranscurrido = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
                $proximaHoraEstimada = $fechaDisponible->format('d/m/Y H:i');
            } else {
                 // Si la fecha disponible ya pasó, el estado debería ser 'disponible'
                 // Esto es una inconsistencia, pero mostramos que ya está disponible
                 $tiempoTranscurrido = 'Listo para ascender';
                 $proximaHoraEstimada = 'Inmediatamente';
                 // Opcional: podrías considerar actualizar el estado_ascenso a 'disponible' aquí si es necesario
            }


        } catch (Exception $e) {
             error_log("Error calculando tiempo de ascenso: " . $e->getMessage());
             $tiempoTranscurrido = 'Error al calcular';
             $proximaHoraEstimada = 'Error al calcular';
        }
    } else if ($ascenso['estado_ascenso'] === 'disponible') {
         $tiempoTranscurrido = 'Listo para ascender';
         $proximaHoraEstimada = 'Inmediatamente';
    } else {
         // Otros estados como 'ascendido', 'no_cumple', etc.
         $tiempoTranscurrido = 'No aplica';
         $proximaHoraEstimada = 'No aplica';
    }


    $response['success'] = true;
    $response['data'] = [
        'codigo_time' => $usuario['codigo_time'],
        'nombre_habbo' => $usuario['nombre_habbo'],
        'rango_actual' => $ascenso['rango_actual'],
        'mision_actual' => $ascenso['mision_actual'],
        'estado_ascenso' => $ascenso['estado_ascenso'],
        'tiempo_transcurrido' => $tiempoTranscurrido, // Esto ahora muestra el tiempo RESTANTE
        'proxima_hora_estimada' => $proximaHoraEstimada,
    ];

} else {
    $response['message'] = 'Método de solicitud no permitido.';
}

echo json_encode($response);
?>