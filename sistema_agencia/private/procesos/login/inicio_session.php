<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(CONFIG_PATH . 'bd.php');

class UserLogin {
    private $conn;
    private $table = 'registro_usuario';

    public function __construct() {
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

    public function login($username, $password) {
        try {
            if (empty($username) || empty($password)) {
                return ['success' => false, 'message' => 'Usuario y contraseña son requeridos'];
            }

            // Modificar la consulta para ser más específica
            $query = "SELECT 
                r.id,
                r.usuario_registro,
                r.password_registro,
                r.rol_id,
                r.ip_bloqueo,
                ro.nombre as rol_nombre,
                ro.nivel_acceso,
                a.rango_actual
            FROM registro_usuario r
            LEFT JOIN roles ro ON r.rol_id = ro.id
            LEFT JOIN ascensos a ON r.codigo_time = a.codigo_time
            WHERE r.usuario_registro = :username";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            // Agregar logs detallados
            error_log("Intento de inicio de sesión - Usuario: " . $username);
            
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                error_log("Datos del usuario encontrado: " . print_r($user, true));

                if ($user['ip_bloqueo'] !== null) {
                    return ['success' => false, 'message' => 'Cuenta bloqueada. Contacte al soporte.'];
                }

                if (password_verify($password, $user['password_registro'])) {
                    error_log("Contraseña verificada correctamente");
                    
                    // Verificar que tengamos todos los datos necesarios
                    if (!$user['rol_id'] || !$user['nivel_acceso']) {
                        error_log("Error: Faltan datos de rol - ID: {$user['rol_id']}, Nivel: {$user['nivel_acceso']}");
                        return ['success' => false, 'message' => 'Error en la configuración de permisos'];
                    }

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['usuario_registro'];
                    $_SESSION['rol_id'] = $user['rol_id'];
                    $_SESSION['rol_nombre'] = $user['rol_nombre'];
                    $_SESSION['nivel_acceso'] = $user['nivel_acceso'];
                    $_SESSION['rango'] = $user['rango_actual'] ?? 'Agente';

                    error_log("Sesión iniciada correctamente: " . print_r($_SESSION, true));

                    return [
                        'success' => true,
                        'message' => '¡Bienvenido!',
                        'redirect' => '/usuario/index.php'
                    ];
                } else {
                    error_log("Contraseña incorrecta para el usuario: " . $username);
                    return ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];
                }
            }

            error_log("Usuario no encontrado: " . $username);
            return ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];

        } catch (PDOException $e) {
            error_log("Error en la base de datos: " . $e->getMessage());
            error_log("SQL State: " . $e->errorInfo[0]);
            error_log("Error Code: " . $e->errorInfo[1]);
            error_log("Error Message: " . $e->errorInfo[2]);
            return ['success' => false, 'message' => 'Error al iniciar sesión: ' . $e->getMessage()];
        } catch (Exception $e) {
            error_log("Error general: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error del sistema: ' . $e->getMessage()];
        }
    }
}

// Mover el código de manejo de POST al final del archivo
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