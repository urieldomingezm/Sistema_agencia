<?php
session_start(); // Iniciar sesión para obtener datos del encargado

// Incluir el archivo con los datos de rangos y tiempos en PHP
require_once(__DIR__ . '/rangos_data.php'); // Cambiado de rangos.php a rangos_data.php

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Método no permitido';
    echo json_encode($response);
    exit;
}

// Verificar si se proporcionó un código
if (!isset($_POST['codigo']) || empty($_POST['codigo'])) {
    $response['message'] = 'Código de usuario no proporcionado';
    echo json_encode($response);
    exit;
}

$codigoUsuario = trim($_POST['codigo']);

// Validar el código (opcional, ya se valida en JS, pero buena práctica en backend)
if (!preg_match('/^[a-zA-Z0-9]{1,5}$/', $codigoUsuario)) {
    $response['message'] = 'Formato de código de usuario inválido.';
    echo json_encode($response);
    exit;
}

// Obtener datos del encargado desde la sesión
$firmaEncargado = $_SESSION['firma'] ?? null; // Asume que la firma está en $_SESSION['firma']
$usuarioEncargado = $_SESSION['username'] ?? null; // Asume que el usuario está en $_SESSION['username'] (corregido)

if (!$usuarioEncargado) {
     $response['message'] = 'No se pudo obtener la información del encargado desde la sesión. Por favor, inicia sesión nuevamente.';
     echo json_encode($response);
     exit;
}

// Verificar si CONFIG_PATH está definido
if (!defined('CONFIG_PATH')) {
    // Si no está definido, intentar definirlo basado en la estructura del proyecto
    define('CONFIG_PATH', $_SERVER['DOCUMENT_ROOT'] . '/private/conexion/');
}

// Verificar si el archivo bd.php existe
if (!file_exists(CONFIG_PATH . 'bd.php')) {
    $response['success'] = false;
    $response['message'] = 'Error: No se pudo encontrar el archivo de configuración de la base de datos';
    echo json_encode($response);
    exit;
}

// Incluir la conexión a la base de datos
require_once(CONFIG_PATH . 'bd.php');


try {
    // Conectar a la base de datos (usando la conexión incluida)
    // $conn = getDbConnection(); // Asume que getDbConnection() es la función que devuelve la conexión PDO
    $database = new Database();
    $conn = $database->getConnection();

    if (!$conn) {
        throw new Exception("No se pudo establecer la conexión con la base de datos");
    }

    // 1. Obtener datos actuales del usuario, incluyendo fecha_disponible_ascenso
    $stmt = $conn->prepare("SELECT rango_actual, mision_actual, firma_usuario, fecha_ultimo_ascenso, fecha_disponible_ascenso FROM ascensos WHERE codigo_time = :codigo");
    $stmt->bindParam(':codigo', $codigoUsuario);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        $response['message'] = 'Usuario no encontrado en la tabla de ascensos.';
        echo json_encode($response);
        exit;
    }

    $rangoActual = strtolower($usuario['rango_actual']); // Convertir a minúsculas para coincidir con las claves del array
    $misionActual = $usuario['mision_actual'];
    $firmaUsuario = $usuario['firma_usuario'];
    $fechaDisponibleAscensoDB = $usuario['fecha_disponible_ascenso'];
    $fechaUltimoAscensoDB = $usuario['fecha_ultimo_ascenso'];


    // 2. Verificar si el usuario está disponible para ascender
    $now = new DateTime('now', new DateTimeZone('America/Mexico_City'));
    // Si fecha_disponible_ascenso es NULL o 0000-00-00 00:00:00, se considera disponible
    if (!empty($fechaDisponibleAscensoDB) && $fechaDisponibleAscensoDB !== '0000-00-00 00:00:00') {
         $fechaDisponible = new DateTime($fechaDisponibleAscensoDB, new DateTimeZone('America/Mexico_City'));
         if ($now < $fechaDisponible) {
             $response['message'] = 'El usuario aún no está disponible para ascender. Próximo ascenso disponible el ' . $fechaDisponible->format('Y-m-d H:i:s') . ' (Hora de México).';
             echo json_encode($response);
             exit;
         }
    }


    // 3. Determinar el siguiente rango y misión
    $siguienteRango = null;
    $siguienteMision = null;
    $tiempoRequeridoSegundos = 0; // Tiempo en segundos para el próximo ascenso

    // Asegurarse de que los arrays de rangos y misiones existan y no estén vacíos
    // Ahora usamos $misionesPorRango y $tiempoAscensoSegundosPorRango del archivo rangos_data.php
    if (!isset($misionesPorRango) || !is_array($misionesPorRango) || empty($misionesPorRango) ||
        !isset($tiempoAscensoSegundosPorRango) || !is_array($tiempoAscensoSegundosPorRango) || empty($tiempoAscensoSegundosPorRango)) {
         $response['message'] = 'Error de configuración: Los datos de rangos y misiones no están definidos correctamente en rangos_data.php.';
         error_log("Error: \$misionesPorRango o \$tiempoAscensoSegundosPorRango no definidos o vacíos en rangos_data.php");
         echo json_encode($response);
         exit;
    }

    $rangosKeys = array_keys($misionesPorRango);
    $currentRangoIndex = array_search($rangoActual, $rangosKeys);

    if ($currentRangoIndex !== false) {
        // Verificar si el rango actual existe en $misionesPorRango
        if (!isset($misionesPorRango[$rangoActual]) || !is_array($misionesPorRango[$rangoActual])) {
             $response['message'] = 'Error de configuración: Las misiones para el rango actual no están definidas correctamente en rangos_data.php.';
             error_log("Error: Misiones no definidas para el rango '{$rangoActual}' en rangos_data.php");
             echo json_encode($response);
             exit;
        }

        $misionesActuales = $misionesPorRango[$rangoActual];
        $currentMisionIndex = array_search($misionActual, $misionesActuales);

        if ($currentMisionIndex !== false) {
             // Verificar si es la última misión del rango actual
             if ($currentMisionIndex === count($misionesActuales) - 1) {
                 // Es la última misión del rango actual, ascender al siguiente rango
                 $nextRangoIndex = $currentRangoIndex + 1;
                 if ($nextRangoIndex < count($rangosKeys)) {
                     $siguienteRango = $rangosKeys[$nextRangoIndex];
                     // La siguiente misión es la primera del nuevo rango
                     // Verificar si el siguiente rango existe y tiene misiones definidas
                     if (!isset($misionesPorRango[$siguienteRango]) || !is_array($misionesPorRango[$siguienteRango]) || empty($misionesPorRango[$siguienteRango])) {
                          $response['message'] = 'Error de configuración: El siguiente rango no está definido o no tiene misiones en rangos_data.php.';
                          error_log("Error: Siguiente rango '{$siguienteRango}' no definido o sin misiones en rangos_data.php");
                          echo json_encode($response);
                          exit;
                     }
                     $siguienteMision = $misionesPorRango[$siguienteRango][0];

                     // Obtener tiempo requerido para el nuevo rango (ya está en segundos)
                     $tiempoRequeridoSegundos = $tiempoAscensoSegundosPorRango[$siguienteRango] ?? 0; // Default si no se encuentra

                 } else {
                     // Es el último rango y última misión, no hay siguiente ascenso
                     $response['message'] = 'El usuario ya está en el rango y misión más altos disponibles.';
                     echo json_encode($response);
                     exit;
                 }
             } else {
                 // No es la última misión del rango actual, ascender a la siguiente misión dentro del mismo rango
                 $siguienteRango = $rangoActual;
                 $siguienteMision = $misionesActuales[$currentMisionIndex + 1];

                  // Obtener tiempo requerido para el rango actual (se mantiene el tiempo del rango, ya está en segundos)
                 $tiempoRequeridoSegundos = $tiempoAscensoSegundosPorRango[$rangoActual] ?? 0; // Default si no se encuentra
             }
        } else {
             // Misión actual no encontrada en el rango
             $response['message'] = 'La misión actual del usuario no coincide con las misiones definidas para su rango en rangos_data.php.';
             error_log("Error: Misión '{$misionActual}' no encontrada para el rango '{$rangoActual}' en rangos_data.php");
             echo json_encode($response);
             exit;
        }
    } else {
        // Rango actual no encontrado
        $response['message'] = 'El rango actual del usuario no es válido o no está definido en la configuración de rangos_data.php.';
        error_log("Error: Rango '{$rangoActual}' no encontrado en rangos_data.php");
        echo json_encode($response);
        exit;
    }

    // 4. Calcular la próxima fecha disponible de ascenso
    $fechaUltimoAscenso = new DateTime('now', new DateTimeZone('America/Mexico_City')); // Hora actual de México
    $fechaDisponibleAscenso = clone $fechaUltimoAscenso;
    $fechaDisponibleAscenso->modify("+{$tiempoRequeridoSegundos} seconds");

    $fechaUltimoAscensoFormatted = $fechaUltimoAscenso->format('Y-m-d H:i:s');
    $fechaDisponibleAscensoFormatted = $fechaDisponibleAscenso->format('Y-m-d H:i:s');


    // 5. Realizar el UPDATE en la base de datos
    $stmt = $conn->prepare("UPDATE ascensos SET
        rango_actual = :siguiente_rango,
        mision_actual = :siguiente_mision,
        firma_usuario = :firma_usuario,
        firma_encargado = :firma_encargado,
        estado_ascenso = 'ascendido',
        fecha_ultimo_ascenso = :fecha_ultimo_ascenso,
        fecha_disponible_ascenso = :fecha_disponible_ascenso,
        usuario_encargado = :usuario_encargado
        WHERE codigo_time = :codigo
    ");

    $stmt->bindParam(':siguiente_rango', $siguienteRango);
    $stmt->bindParam(':siguiente_mision', $siguienteMision);
    $stmt->bindParam(':firma_usuario', $firmaUsuario); // Usar la firma existente o NULL
    $stmt->bindParam(':firma_encargado', $firmaEncargado);
    $stmt->bindParam(':fecha_ultimo_ascenso', $fechaUltimoAscensoFormatted);
    $stmt->bindParam(':fecha_disponible_ascenso', $fechaDisponibleAscensoFormatted);
    $stmt->bindParam(':usuario_encargado', $usuarioEncargado);
    $stmt->bindParam(':codigo', $codigoUsuario);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Ascenso registrado exitosamente.';
    } else {
        $response['message'] = 'Error al actualizar la base de datos.';
         // Log error: errorInfo() puede dar detalles del error SQL
         error_log("Error al actualizar ascenso para codigo {$codigoUsuario}: " . implode(":", $stmt->errorInfo()));
    }

} catch (PDOException $e) {
    $response['message'] = 'Error de base de datos: ' . $e->getMessage();
     error_log("PDOException en registrar_ascenso.php: " . $e->getMessage());
} catch (Exception $e) {
     $response['message'] = 'Error al conectar con el servidor: ' . $e->getMessage();
     error_log("General Exception in registrar_ascenso.php: " . $e->getMessage());
}
finally {
    // Cerrar conexión
    // La conexión PDO se cierra automáticamente cuando el script termina,
    // pero puedes establecerla a null explícitamente si lo prefieres.
    $conn = null;
}

echo json_encode($response);


// La función parseTiempoAscenso ya no es necesaria porque el tiempo está en segundos en rangos_data.php
// function parseTiempoAscenso($tiempoStr) {
    $tiempoStr = strtolower(trim($tiempoStr));
    $parts = explode(' ', $tiempoStr);
    if (count($parts) < 2) {
        return 0; // Formato inválido
    }

    $cantidad = (int) $parts[0];
    $unidad = $parts[1];
    $segundos = 0;

    switch ($unidad) {
        case 'minuto':
        case 'minutos':
            $segundos = $cantidad * 60;
            break;
        case 'hora':
        case 'horas':
            $segundos = $cantidad * 60 * 60;
            break;
        case 'día':
        case 'días':
            $segundos = $cantidad * 24 * 60 * 60;
            break;
        // Añadir más unidades si es necesario (semanas, meses, etc.)
    }
    return $segundos;
// Remove unexpected closing brace as it's not needed


?>