<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        // Usar variables de entorno para PostgreSQL
        $this->host = getenv('PG_HOST') ?: 'localhost';
        $this->db_name = getenv('PG_DATABASE') ?: 'sistema_agencia';
        $this->username = getenv('PG_USER') ?: 'postgres'; // Usuario por defecto de PostgreSQL
        $this->password = getenv('PG_PASSWORD') ?: '';

        if (!$this->host || !$this->db_name || !$this->username || !$this->password) {
            error_log("Error: Algunas variables de entorno de PostgreSQL no están definidas.");
        }
    }

    public function getConnection() {
        $this->conn = null;

        try {
            // Usar el driver PDO para PostgreSQL (pgsql)
            $dsn = "pgsql:host=" . $this->host . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            error_log("Error de conexión a PostgreSQL: " . $exception->getMessage());
            echo "Error de conexión a la base de datos.";
        }

        return $this->conn;
    }
}
?>
