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

            $query = "SELECT r.id, r.usuario_registro, r.password_registro, r.rol_id, a.rango_actual 
                     FROM {$this->table} r
                     LEFT JOIN ascensos a ON r.codigo_time = a.codigo_time
                     WHERE r.usuario_registro = :username";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $user['password_registro'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['usuario_registro'];
                    $_SESSION['rol_id'] = $user['rol_id'];
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
?>