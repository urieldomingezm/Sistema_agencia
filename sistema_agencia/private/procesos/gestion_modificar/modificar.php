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

class UserModifier {
    private $conn;
    private $blocked_words = ['hack', 'xxx', 'porn', 'sexo', 'puto', 'puta', 'mierda', 'pendejo'];
    private $allowed_words = ['SHN', 'administrador', 'fundador', 'manager', 'dueño'];
    private $valid_ranks = [
        'agente', 'seguridad', 'tecnico', 'logistica', 'supervisor', 
        'director', 'presidente', 'operativo', 'junta directiva', 
        'administrador', 'manager', 'fundador', 'owner'
    ];

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    private function validateInput($text) {
        // Convertir a minúsculas para comparación
        $lowerText = strtolower($text);
        
        // Verificar palabras bloqueadas
        foreach ($this->blocked_words as $word) {
            if (strpos($lowerText, $word) !== false) {
                throw new Exception('El texto contiene palabras no permitidas');
            }
        }

        // Verificar palabras permitidas
        $words = preg_split('/\s+/', $text);
        foreach ($words as $word) {
            $normalizedWord = strtolower(preg_replace('/[^a-zñ]/u', '', $word));
            if ($normalizedWord && !in_array($normalizedWord, array_map('strtolower', $this->allowed_words))) {
                throw new Exception('La palabra "' . $word . '" no está permitida en la misión');
            }
        }

        return true;
    }

    public function updateUser($userId, $nuevoRango, $nuevaMision, $nuevaFirma, $usuarioModificador) {
        try {
            // Validar rango
            if (!in_array(strtolower($nuevoRango), $this->valid_ranks)) {
                throw new Exception('Rango no válido');
            }

            // Validar misión
            if (strlen($nuevaMision) < 12) {
                throw new Exception('La misión debe tener al menos 12 caracteres');
            }
            
            $this->validateInput($nuevaMision);

            // Validar firma para rangos que la requieren
            $rangosBasicos = ['agente', 'seguridad', 'tecnico', 'logistica'];
            if (!in_array(strtolower($nuevoRango), $rangosBasicos)) {
                if (!$nuevaFirma) {
                    throw new Exception('La firma es requerida para este rango');
                }
                if (!preg_match('/^[A-Z0-9]{3}$/', $nuevaFirma)) {
                    throw new Exception('El formato de la firma es inválido. Debe ser 3 caracteres alfanuméricos en mayúsculas');
                }
            }

            // Obtener código_time del usuario
            $stmt = $this->conn->prepare("SELECT codigo_time FROM registro_usuario WHERE id = :id");
            $stmt->execute([':id' => $userId]);
            $registro = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$registro) {
                throw new Exception('Usuario no encontrado');
            }

            // Registrar la modificación
            $this->conn->beginTransaction();

            // Actualizar ascensos
            $stmt = $this->conn->prepare("
                UPDATE ascensos 
                SET rango_actual = :rango,
                    mision_actual = :mision,
                    firma_usuario = :firma,
                    usuario_encargado = :usuario_mod,
                    fecha_modificacion = NOW()
                WHERE codigo_time = :codigo
            ");

            $stmt->execute([
                ':rango' => $nuevoRango,
                ':mision' => $nuevaMision,
                ':firma' => $nuevaFirma,
                ':usuario_mod' => $usuarioModificador,
                ':codigo' => $registro['codigo_time']
            ]);

            // Registrar en log de modificaciones
            $stmt = $this->conn->prepare("
                INSERT INTO log_modificaciones (
                    codigo_time, 
                    usuario_modificador, 
                    ip_modificacion, 
                    fecha_modificacion,
                    detalle_modificacion
                ) VALUES (
                    :codigo,
                    :usuario,
                    :ip,
                    NOW(),
                    :detalle
                )
            ");

            $stmt->execute([
                ':codigo' => $registro['codigo_time'],
                ':usuario' => $usuarioModificador,
                ':ip' => $_SERVER['REMOTE_ADDR'],
                ':detalle' => json_encode([
                    'rango' => $nuevoRango,
                    'mision' => $nuevaMision,
                    'firma' => $nuevaFirma
                ])
            ]);

            $this->conn->commit();
            return ['success' => true, 'message' => 'Usuario actualizado correctamente'];

        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
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
