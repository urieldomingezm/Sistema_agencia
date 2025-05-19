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
// Asumimos que se envía un campo 'requirement_name'
if (!isset($_POST['requirement_name']) || empty(trim($_POST['requirement_name']))) {
    $response['message'] = 'El nombre del requisito es requerido.';
    echo json_encode($response);
    exit;
}

$requirement_name = trim($_POST['requirement_name']);

// --- Extraer el conteo numérico del requirement_name ---
// Asumimos que el formato es "X tiempos tomados esta semana"
$times_count = 0; // Valor por defecto
if (preg_match('/^(\d+)\s+tiempos/', $requirement_name, $matches)) {
    $times_count = (int)$matches[1]; // Convertir el número capturado a entero
} else {
    // Si el formato no coincide, podrías querer manejar este error o loggearlo
    // Por ahora, simplemente usará 0 como conteo.
    error_log("Formato de requirement_name inesperado: " . $requirement_name);
}
// --- Fin de la extracción ---


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
        $query = "UPDATE gestion_requisitos
                  SET requirement_name = :requirement_name, times_as_encargado_count = :times_count, last_updated = NOW()
                  WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':requirement_name', $requirement_name);
        $stmt->bindParam(':times_count', $times_count, PDO::PARAM_INT); // Bindear el conteo numérico
        $stmt->bindParam(':id', $existingRecord['id']);
        $message = 'Requisito semanal actualizado con éxito.';
    } else {
        // Si no existe, insertar uno nuevo
        $query = "INSERT INTO gestion_requisitos (user, requirement_name, times_as_encargado_count, is_completed, last_updated)
                  VALUES (:user, :requirement_name, :times_count, FALSE, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user', $username);
        $stmt->bindParam(':requirement_name', $requirement_name);
        $stmt->bindParam(':times_count', $times_count, PDO::PARAM_INT); // Bindear el conteo numérico
        $message = 'Requisito semanal registrado con éxito.';
    }

    // Ejecutar la consulta (UPDATE o INSERT)
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = $message;
    } else {
        // Error al ejecutar la consulta
        $response['message'] = 'Error al procesar el requisito semanal en la base de datos.';
        // Opcional: logear el error $stmt->errorInfo()
    }

} catch (Exception $e) {
    // Capturar errores de conexión o ejecución
    $response['message'] = 'Error en el servidor: ' . $e->getMessage();
}

// Devolver la respuesta en formato JSON
echo json_encode($response);

?>