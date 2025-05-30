<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

// Cambiamos la verificación de sesión
if (!isset($_SESSION)) {
    session_start();
}

// Verificamos si existe username en lugar de usuario
if (!isset($_SESSION['username'])) {
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'No hay sesión activa']);
    exit;
}

header('Content-Type: application/json');

class UserModifier
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function updateUser($userId, $nuevoRango, $nuevaMision, $nuevaFirma, $usuarioModificador)
    {
        if (!$userId || !$nuevoRango || !$nuevaMision) {
            throw new Exception('Datos incompletos para la modificación');
        }

        $rangosBasicos = ['agente', 'seguridad', 'tecnico', 'logistica'];

        // Si es un rango básico, la firma será NULL
        if (in_array($nuevoRango, $rangosBasicos)) {
            $nuevaFirma = null;
        } else {
            // Solo validar firma para rangos no básicos
            if (!$nuevaFirma || !preg_match('/^[A-Z0-9]{3}$/', $nuevaFirma)) {
                throw new Exception('Firma requerida o inválida para el rango seleccionado.');
            }
        }

        $stmt = $this->conn->prepare("SELECT codigo_time FROM registro_usuario WHERE id = :id");
        $stmt->execute([':id' => $userId]);
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$registro || !$registro['codigo_time']) {
            throw new Exception('Código Time no encontrado para el ID de usuario: ' . $userId);
        }

        $codigoTime = $registro['codigo_time'];

        // Establecer variables para el trigger
        $this->conn->exec("SET @usuario_modificador = '$usuarioModificador'");
        $this->conn->exec("SET @ip_modificacion = '" . $_SERVER['REMOTE_ADDR'] . "'");

        $stmt = $this->conn->prepare("UPDATE ascensos SET 
            rango_actual = :rango,
            mision_actual = :mision,
            firma_usuario = :firma,
            usuario_encargado = :usuario_mod
        WHERE codigo_time = :codigo");

        $stmt->execute([
            ':rango' => $nuevoRango,
            ':mision' => $nuevaMision,
            ':firma' => $nuevaFirma,
            ':codigo' => $codigoTime,
            ':usuario_mod' => $usuarioModificador
        ]);

        if ($stmt->rowCount() === 0) {
            throw new Exception('No se encontró registro de ascenso para actualizar con el Código Time: ' . $codigoTime);
        }

        return ['success' => true, 'message' => 'Usuario actualizado correctamente'];
    }
}

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $userId = $data['userId'] ?? null;
    $nuevoRango = $data['nuevoRango'] ?? null;
    $nuevaMision = $data['nuevaMision'] ?? null;
    $nuevaFirma = $data['nuevaFirma'] ?? null;
    $usuarioModificador = $_SESSION['username']; // Cambiamos a username

    try {
        $modifier = new UserModifier($conn);
        $response = $modifier->updateUser($userId, $nuevoRango, $nuevaMision, $nuevaFirma, $usuarioModificador);
        echo json_encode($response);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}
