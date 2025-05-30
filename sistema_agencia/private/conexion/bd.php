<?php
class Database {
    private $host = 'db'; // Nombre del servicio en Docker
    private $db_name = 'sistema_agencia';
    private $username = 'agencia_user';
    private $password = 'AgenC!@x8rPz7LwQ'; // Contraseña segura generada
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Opcional: registrar cada conexión en un log (puedes comentar si no lo deseas)
            $this->logConnection("Conexión exitosa a la base de datos.");
        } catch(PDOException $exception) {
            $this->logConnection("Error de conexión: " . $exception->getMessage());
            echo "Error de conexión a la base de datos.";
        }

        return $this->conn;
    }

    private function logConnection($message) {
        $file = __DIR__ . '/db_connection.log';
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'CLI';
        $time = date('Y-m-d H:i:s');
        $entry = "[$time] [$ip] $message\n";
        file_put_contents($file, $entry, FILE_APPEND);
    }
}
?>
