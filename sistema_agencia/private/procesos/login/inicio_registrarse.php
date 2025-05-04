<?php

require_once(CONFIG_PATH . 'bd.php');

class UserRegistration
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
            error_log("Error en constructor UserRegistration: " . $e->getMessage());
            throw $e;
        }
    }

    private function getClientIP()
    {
        // Verificar si existe proxy
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        // Verificar si viene de proxy transparente
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        // Si no hay proxy, usar la IP remota directa
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        return $ip;
    }

    private function checkExistingIP($ip)
    {
        $query = "SELECT COUNT(*) FROM {$this->table} WHERE ip_registro = :ip";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ip', $ip);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function register($username, $password, $habboName)
    {
        try {
            if (empty($username) || empty($password) || empty($habboName)) {
                return ['success' => false, 'message' => 'Todos los campos son requeridos'];
            }

            $ip = $this->getClientIP();

            if ($this->checkExistingIP($ip)) {
                return ['success' => false, 'message' => 'Ya existe un registro con esta IP'];
            }

            // Verificar si el nombre de Habbo ya existe
            $checkHabbo = "SELECT COUNT(*) FROM {$this->table} WHERE nombre_habbo = :habbo_name";
            $stmt = $this->conn->prepare($checkHabbo);
            $stmt->bindParam(':habbo_name', $habboName);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                return ['success' => false, 'message' => 'Este nombre de Habbo ya está registrado'];
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO {$this->table} 
                     (usuario_registro, password_registro, nombre_habbo, rol_id, rango, fecha_registro, ip_registro, verificado) 
                     VALUES (:username, :password, :habbo_name, 1, 'Agente', NOW(), :ip, 0)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':habbo_name', $habboName);
            $stmt->bindParam(':ip', $ip);

            if ($stmt->execute()) {
                return ['success' => true, 'message' => '¡Registro exitoso! Por favor, inicia sesión para continuar.'];
            }

            return ['success' => false, 'message' => 'Error al guardar el registro'];
        } catch (PDOException $e) {
            error_log("Error en registro: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()];
        }
    }
}

// Manejo de la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $registration = new UserRegistration();
        $result = $registration->register($_POST['username'], $_POST['password'], $_POST['habboName']);
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()]);
    }
}
?>