<?php
// Iniciar sesión si no está iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Definir la ruta de configuración si no está definida
if (!defined('CONFIG_PATH')) {
    // Asume que este archivo está en private/procesos/gestion_cumplimientos/
    // y la conexión está en private/conexion/
    define('CONFIG_PATH', __DIR__ . '/../../conexion/');
}

// Incluir el archivo de conexión a la base de datos
require_once(CONFIG_PATH . 'bd.php');

$response = ['success' => false, 'message' => ''];

// Verificar si el usuario ha iniciado sesión y tiene el username en sesión
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    $response['message'] = 'No has iniciado sesión o no se encontró tu nombre de usuario.';
    echo json_encode($response);
    exit;
}

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Método no permitido.';
    echo json_encode($response);
    exit;
}

// Obtener el username del usuario desde la sesión
$username = $_SESSION['username'];

// Validar y obtener los datos del requisito desde el POST
// Asumimos que se envía un campo 'requirement_name' y ahora un campo 'type'
if (!isset($_POST['requirement_name']) || !isset($_POST['type'])) {
    $response['message'] = 'Parámetros requeridos faltantes (requirement_name o type).';
    echo json_encode($response);
    exit;
}

$posted_requirement_name = trim($_POST['requirement_name']);
$type = trim($_POST['type']); // Obtener el tipo de registro (tiempos o ascensos)

$requirement_name = ''; // Establecemos requirement_name a vacío para la base de datos

// --- Extraer el conteo numérico del posted_requirement_name ---
// Asumimos que el formato es "X tiempos tomados esta semana" o "X ascensos realizados esta semana"
$count = 0; // Valor por defecto
if (preg_match('/^(\d+)\s+(tiempos|ascensos)/', $posted_requirement_name, $matches)) {
    $count = (int)$matches[1]; // Convertir el número capturado a entero
} else {
    // Si el formato no coincide, podrías querer manejar este error o loggearlo
    error_log("Formato de requirement_name inesperado: " . $posted_requirement_name);
    // Podrías decidir si esto es un error fatal o si continúas con count = 0
    // Por ahora, continuaremos con 0.
}
// --- Fin de la extracción ---


// Determinar qué columna actualizar basado en el 'type'
$count_column = '';
$message_type = '';
if ($type === 'tiempos') {
    $count_column = 'times_as_encargado_count';
    $message_type = 'Tiempos';
} elseif ($type === 'ascensos') {
    $count_column = 'ascensos_as_encargado_count';
    $message_type = 'Ascensos';
} else {
    $response['message'] = 'Tipo de registro no válido.';
    echo json_encode($response);
    exit;
}


// Conectar a la base de datos
try {
    $database = new Database();
    $conn = $database->getConnection();

    if (!$conn) {
        throw new Exception("No se pudo establecer la conexión con la base de datos.");
    }

    // --- Lógica para verificar y actualizar/insertar ---

    // Obtener el inicio y fin de la semana actual
    // Usamos la fecha actual del servidor
    date_default_timezone_set('America/Mexico_City'); // Asegúrate de usar la zona horaria correcta
    $now = new DateTime();
    $startOfWeek = (clone $now)->modify('this week Monday')->format('Y-m-d 00:00:00');
    $endOfWeek = (clone $now)->modify('this week Sunday')->format('Y-m-d 23:59:59');

    // Consulta para buscar un registro existente para este usuario en la semana actual
    // Buscamos por user y dentro del rango de la semana actual usando last_updated
    $queryCheck = "SELECT id FROM gestion_requisitos
                   WHERE user = :user
                   AND last_updated BETWEEN :start_of_week AND :end_of_week";

    $stmtCheck = $conn->prepare($queryCheck);
    $stmtCheck->bindParam(':user', $username);
    $stmtCheck->bindParam(':start_of_week', $startOfWeek);
    $stmtCheck->bindParam(':end_of_week', $endOfWeek);
    $stmtCheck->execute();
    $existingRecord = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($existingRecord) {
        // Si existe un registro para esta semana, actualizarlo
        // Solo actualizamos la columna correspondiente al tipo
        $query = "UPDATE gestion_requisitos
                  SET requirement_name = :requirement_name, {$count_column} = :count, last_updated = NOW()
                  WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':requirement_name', $requirement_name); // Ahora será una cadena vacía
        $stmt->bindParam(':count', $count, PDO::PARAM_INT); // Bindear el conteo numérico
        $stmt->bindParam(':id', $existingRecord['id']);
        $message = "Requisito semanal de {$message_type} actualizado con éxito.";
    } else {
        // Si no existe, insertar uno nuevo
        // Inicializamos ambas columnas de conteo, pero solo seteamos la que corresponde
        $query = "INSERT INTO gestion_requisitos (user, requirement_name, times_as_encargado_count, ascensos_as_encargado_count, is_completed, last_updated)
                  VALUES (:user, :requirement_name, :times_count, :ascensos_count, FALSE, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user', $username);
        $stmt->bindParam(':requirement_name', $requirement_name); // Ahora será una cadena vacía

        // Setear el conteo correcto y 0 para el otro
        $times_count_val = ($type === 'tiempos') ? $count : 0;
        $ascensos_count_val = ($type === 'ascensos') ? $count : 0;

        $stmt->bindParam(':times_count', $times_count_val, PDO::PARAM_INT);
        $stmt->bindParam(':ascensos_count', $ascensos_count_val, PDO::PARAM_INT);

        $message = "Requisito semanal de {$message_type} registrado con éxito.";
    }

    // Ejecutar la consulta (UPDATE o INSERT)
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = $message;
    } else {
        // Error al ejecutar la consulta
        $response['message'] = "Error al procesar el requisito semanal de {$message_type} en la base de datos.";
        // Opcional: logear el error $stmt->errorInfo()
    }

} catch (Exception $e) {
    // Capturar errores de conexión o ejecución
    $response['message'] = 'Error en el servidor: ' . $e->getMessage();
}

// Devolver la respuesta en formato JSON
echo json_encode($response);

?>