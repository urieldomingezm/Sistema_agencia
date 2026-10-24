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
    
    // Palabras permitidas para rangos especiales
    private $allowed_words = ['SHN', 'administrador', 'fundador', 'manager', 'dueño'];
    
    // Misiones permitidas por nivel
    private $allowed_missions = [
        'SHN- Iniciado I',
        'SHN- Novato H',
        'SHN- Auxiliar G',
        'SHN- Ayudante F',
        'SHN- Junior E',
        'SHN- Intermedio D',
        'SHN- Avanzado C',
        'SHN- Experto B',
        'SHN- Jefe A'
    ];

    // Rangos válidos
    private $valid_ranks = [
        'agente', 'seguridad', 'tecnico', 'logistica', 'supervisor', 
        'director', 'presidente', 'operativo', 'junta directiva', 
        'administrador', 'manager', 'fundador', 'owner'
    ];

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    private function validateInput($text, $isSpecialRank = false) {
        // Convertir a minúsculas para comparación
        $lowerText = strtolower($text);
        
        // Verificar palabras bloqueadas
        foreach ($this->blocked_words as $word) {
            if (strpos($lowerText, $word) !== false) {
                throw new Exception('El texto contiene palabras no permitidas');
            }
        }

        // Remover la firma y el sufijo estándar para validar solo la misión
        $misionBase = preg_replace('/ -[A-Z0-9]{3} -XDD #A$/', '', $text);
        $misionBase = trim($misionBase);

        if ($isSpecialRank) {
            // Para rangos especiales, validar palabras permitidas
            $words = preg_split('/\s+/', $misionBase);
            foreach ($words as $word) {
                $normalizedWord = strtolower(preg_replace('/[^a-zñ]/u', '', $word));
                if ($normalizedWord && !in_array($normalizedWord, array_map('strtolower', $this->allowed_words))) {
                    throw new Exception('La palabra "' . $word . '" no está permitida en la misión');
                }
            }
        } else {
            // Para rangos normales, validar contra lista de misiones
            if (!in_array($misionBase, $this->allowed_missions)) {
                throw new Exception('La misión "' . $misionBase . '" no está permitida');
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

            // Determinar si es un rango especial
            $rangosEspeciales = ['administrador', 'manager', 'fundador', 'owner', 'junta directiva'];
            $isSpecialRank = in_array(strtolower($nuevoRango), $rangosEspeciales);

            // Validar misión
            if (empty($nuevaMision)) {
                throw new Exception('La misión es requerida');
            }
            
            $this->validateInput($nuevaMision, $isSpecialRank);

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
