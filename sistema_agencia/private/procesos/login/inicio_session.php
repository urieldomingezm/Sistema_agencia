<?php

require_once(CONFIG_PATH . 'bd.php');

class UserLogin
{
    private $conn;
    private $table = 'registro_usuario';

    public function __construct()
    {
        try {
            $database = new Database();
            $this->conn = $database->getConnection();
            if (!$this->conn) {
                throw new Exception("Error de conexión a la base de datos");
            }
        } catch (Exception $e) {
            error_log("Error en constructor UserLogin: " . $e->getMessage());
            throw $e;
        }
    }

    public function login($username, $password)
    {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }
            
            if (empty($username) || empty($password)) {
                return ['success' => false, 'message' => 'Usuario y contraseña son requeridos'];
            }

            $query = "SELECT r.id, r.usuario_registro, r.password_registro, r.rol_id, 
                            a.rango_actual, r.ip_bloqueo, ro.nombre as rol_nombre,
                            ro.nivel_acceso
                     FROM {$this->table} r
                     LEFT JOIN ascensos a ON r.codigo_time = a.codigo_time
                     LEFT JOIN roles ro ON r.rol_id = ro.id
                     WHERE r.usuario_registro = :username";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user['ip_bloqueo'] !== null) {
                    return ['success' => false, 'message' => 'Cuenta bloqueada. Por favor, contacte al soporte.'];
                }

                if (password_verify($password, $user['password_registro'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['usuario_registro'];
                    $_SESSION['rol_id'] = $user['rol_id'];
                    $_SESSION['rol_nombre'] = $user['rol_nombre'];
                    $_SESSION['nivel_acceso'] = $user['nivel_acceso'];
                    $_SESSION['rango'] = $user['rango_actual'] ?? 'Agente';

                    return [
                        'success' => true, 
                        'message' => '¡Bienvenido!',
                        'redirect' => '/usuario/index.php'
                    ];
                }
            }

            return ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];
        } catch (PDOException $e) {
            error_log("Error en login: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al iniciar sesión'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $login = new UserLogin();
        $result = $login->login($_POST['username'], $_POST['password']);
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// Ejemplo de uso en cualquier archivo que necesite verificar permisos
function checkUserPermission($permissionName) {
    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    $db = new Database();
    return $db->checkPermission($_SESSION['user_id'], $permissionName);
}

// Ejemplo de uso:
if (checkUserPermission('modify_ascensos')) {
    // Permitir modificar ascensos
} else {
    echo "No tienes permiso para realizar esta acción";
}

// Actualizar la función de verificación de permisos
function checkUserTablePermission($tabla, $tipoPermiso = 'leer') {
    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    $db = new Database();
    return $db->checkTablePermission($_SESSION['user_id'], $tabla, $tipoPermiso);
}
?>