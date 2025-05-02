<?php
session_start();

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct()
    {
        $this->host = getenv('MYSQL_HOST') ?: 'localhost';
        $this->db_name = getenv('MYSQL_DATABASE') ?: 'sistema_agencia';
        $this->username = getenv('MYSQL_USER') ?: 'root';
        $this->password = getenv('MYSQL_PASSWORD') ?: '';

        if (!$this->host || !$this->db_name || !$this->username || !$this->password) {
            error_log("Error: Algunas variables de entorno no están definidas.");
        }
    }

    public function getConnection()
    {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            error_log("Error de conexión: " . $exception->getMessage());
            echo "Error de conexión a la base de datos.";
        }

        return $this->conn;
    }
}

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
            if (empty($username) || empty($password)) {
                return ['success' => false, 'message' => 'Usuario y contraseña son requeridos'];
            }

            $query = "SELECT id, usuario_registro, password_registro, rol_id FROM {$this->table} 
                     WHERE usuario_registro = :username";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $user['password_registro'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['usuario_registro'];
                    $_SESSION['rol_id'] = $user['rol_id'];

                    return ['success' => true, 'message' => '¡Bienvenido!'];
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