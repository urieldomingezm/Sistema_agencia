<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        $this->host = getenv('MYSQL_HOST') ?: 'localhost';
        $this->db_name = getenv('MYSQL_DATABASE') ?: 'sistema_agencia';
        $this->username = getenv('MYSQL_USER') ?: 'usuarios_basicos';
        $this->password = getenv('MYSQL_PASSWORD') ?: 'usuario1234';

        if (!$this->host || !$this->db_name || !$this->username || !$this->password) {
            error_log("Error: Algunas variables de entorno no están definidas.");
        }
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            error_log("Error de conexión: " . $exception->getMessage());
            echo "Error de conexión a la base de datos.";
        }

        return $this->conn;
    }

    public function checkPermission($userId, $permissionName) {
        try {
            $query = "SELECT COUNT(*) as tiene_permiso 
                     FROM registro_usuario ru
                     JOIN roles_permisos rp ON ru.rol_id = rp.rol_id
                     JOIN permisos p ON rp.permiso_id = p.id
                     WHERE ru.id = :user_id AND p.nombre = :permission_name";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':permission_name', $permissionName);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['tiene_permiso'] > 0;
        } catch(PDOException $e) {
            error_log("Error checking permission: " . $e->getMessage());
            return false;
        }
    }

    public function checkTablePermission($userId, $tabla, $tipoPermiso = 'leer') {
        try {
            $query = "SELECT pt.puede_leer, pt.puede_modificar, pt.puede_eliminar
                     FROM registro_usuario ru
                     JOIN roles r ON ru.rol_id = r.id
                     JOIN permisos_tablas pt ON r.id = pt.rol_id
                     WHERE ru.id = :user_id AND pt.tabla = :tabla";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId);
            $stmt->bindParam(':tabla', $tabla);
            $stmt->execute();
            
            $permisos = $stmt->fetch(PDO::FETCH_ASSOC);
            
            switch($tipoPermiso) {
                case 'leer':
                    return $permisos['puede_leer'] ?? false;
                case 'modificar':
                    return $permisos['puede_modificar'] ?? false;
                case 'eliminar':
                    return $permisos['puede_eliminar'] ?? false;
                default:
                    return false;
            }
        } catch(PDOException $e) {
            error_log("Error verificando permisos: " . $e->getMessage());
            return false;
        }
    }
}
?>
