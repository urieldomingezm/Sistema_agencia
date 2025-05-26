<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');

header('Content-Type: application/json');

class UserDataFetcher {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function findUserDataById($id) {
        if (!$id) {
            throw new Exception('ID de usuario requerido');
        }

        $stmt = $this->conn->prepare("SELECT codigo_time, nombre_habbo FROM registro_usuario WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$registro || !$registro['codigo_time']) {
            throw new Exception('Código Time no encontrado para el ID: ' . $id);
        }

        $stmt = $this->conn->prepare("SELECT 
            rango_actual, 
            mision_actual, 
            firma_usuario,
            fecha_ultimo_ascenso
        FROM ascensos 
        WHERE codigo_time = :codigo");
        $stmt->execute([':codigo' => $registro['codigo_time']]);
        $ascenso = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ascenso) {
            throw new Exception('Registro de ascenso no encontrado');
        }

        return array_merge($registro, $ascenso);
    }
}

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? null;

    try {
        $fetcher = new UserDataFetcher($conn);
        $userData = $fetcher->findUserDataById($id);
        echo json_encode(['success' => true, 'data' => $userData]);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false, 
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }
}