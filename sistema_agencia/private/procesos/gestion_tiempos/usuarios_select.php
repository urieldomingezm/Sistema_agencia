<?php
// Desactivar la visualización de errores de PHP en la salida
error_reporting(0);
ini_set('display_errors', 0);

// Verificar si CONFIG_PATH está definido
if (!defined('CONFIG_PATH')) {
    // Si no está definido, intentar definirlo basado en la estructura del proyecto
    // Ajusta la ruta si tu estructura de carpetas es diferente
    define('CONFIG_PATH', $_SERVER['DOCUMENT_ROOT'] . '/private/conexion/');
}

// Verificar si el archivo bd.php existe antes de incluirlo
if (!file_exists(CONFIG_PATH . 'bd.php')) {
    $response['success'] = false;
    $response['message'] = 'Error: No se pudo encontrar el archivo de configuración de la base de datos.';
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

require_once(CONFIG_PATH . 'bd.php');

$response = array();

try {
    $database = new Database();
    $conn = $database->getConnection();

    // Verificar si la conexión fue exitosa
    if (!$conn) {
         throw new Exception("No se pudo establecer la conexión con la base de datos.");
    }

    // Nueva consulta para obtener usuarios y su rango de la tabla ascensos
    $query = "SELECT ru.id, ru.nombre_habbo, a.rango_actual AS rol_nombre
              FROM registro_usuario ru
              JOIN ascensos a ON ru.codigo_time = a.codigo_time
              WHERE a.rango_actual IN ('operativo', 'junta directiva', 'administrador', 'manager', 'fundador')
              ORDER BY a.rango_actual ASC"; // Puedes ajustar el ORDER BY si necesitas un orden específico de rangos

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['data'] = $usuarios;

} catch (PDOException $e) {
    // Capturar errores de base de datos y devolver una respuesta JSON de error
    $response['success'] = false;
    $response['message'] = 'Error en la base de datos: ' . $e->getMessage();
} catch (Exception $e) {
    // Capturar cualquier otro tipo de excepción
    $response['success'] = false;
    $response['message'] = 'Ocurrió un error inesperado: ' . $e->getMessage();
}

// Asegurarse de que la respuesta sea siempre JSON
header('Content-Type: application/json');
echo json_encode($response);
exit; // Asegurarse de que no se imprima nada más después del JSON
?>
