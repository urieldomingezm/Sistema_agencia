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
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        
        return $ip;
    }

    private function checkExistingIP($ip) {
        try {
            error_log("DEBUG: checkExistingIP called for IP: " . $ip);
            $query = "SELECT id FROM {$this->table} WHERE ip_registro = :ip";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':ip', $ip);
            $stmt->execute();
            
            return $stmt->fetchColumn() !== false;
        } catch (PDOException $e) {
            error_log("Error en checkExistingIP: " . $e->getMessage());
            throw $e;
        }
    }

    private function blockAccountsByIP($ip) {
        try {
            $randomPassword = bin2hex(random_bytes(16));
            $hashedPassword = password_hash($randomPassword, PASSWORD_DEFAULT);
            
            $updateQuery = "UPDATE {$this->table} SET password_registro = :password, ip_bloqueo = :bloqueo WHERE ip_registro = :ip";
            $updateStmt = $this->conn->prepare($updateQuery);
            
            $bloqueoStatus = 'se bloqueo cuenta';
            $updateStmt->bindParam(':password', $hashedPassword);
            $updateStmt->bindParam(':bloqueo', $bloqueoStatus);
            $updateStmt->bindParam(':ip', $ip);
            
            if (!$updateStmt->execute()) {
                error_log("ERROR: Fallo al ejecutar el UPDATE para IP: " . $ip);
                throw new Exception("Error al bloquear cuentas existentes");
            }
            
            return $updateStmt->rowCount();
        } catch (PDOException $e) {
            error_log("Error en blockAccountsByIP: " . $e->getMessage());
            throw $e;
        }
    }

    private function generateUniqueCode() {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        return substr(str_shuffle($characters), 0, 5);
    }

    public function register($habboName, $password)
    {
        try {
            $this->conn->beginTransaction();

            if (empty($habboName) || empty($password)) {
                return ['success' => false, 'message' => 'Todos los campos son requeridos'];
            }

            $ip = $this->getClientIP();

            // 1. Verificar IP existente
            if ($this->checkExistingIP($ip)) {
                // 2. Bloquear cuentas existentes
                $affected = $this->blockAccountsByIP($ip);
                error_log("Bloqueadas $affected cuentas con IP $ip");
                
                $this->conn->commit(); // Confirmar el UPDATE del bloqueo
                return ['success' => false, 'message' => 'No se permiten múltiples registros. Cuentas bloqueadas.'];
            }

            // 3. Verificar nombre de Habbo
            $checkHabbo = "SELECT COUNT(*) FROM {$this->table} WHERE nombre_habbo = :habbo_name OR usuario_registro = :habbo_name";
            $stmtHabbo = $this->conn->prepare($checkHabbo);
            $stmtHabbo->bindParam(':habbo_name', $habboName);
            $stmtHabbo->execute();
            
            if ($stmtHabbo->fetchColumn() > 0) {
                $this->conn->rollBack();
                return ['success' => false, 'message' => 'Nombre de Habbo ya registrado'];
            }

            // 4. Registrar nuevo usuario
            $codigo_time = $this->generateUniqueCode();
            $query = "INSERT INTO {$this->table} 
                     (usuario_registro, password_registro, nombre_habbo, rol_id, fecha_registro, ip_registro, codigo_time, ip_bloqueo) 
                     VALUES (:habbo_name, :password, :habbo_name, 1, NOW(), :ip, :codigo_time, NULL)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':habbo_name', $habboName);
            $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
            $stmt->bindParam(':ip', $ip);
            $stmt->bindParam(':codigo_time', $codigo_time);

            if (!$stmt->execute()) {
                throw new Exception("Error al registrar usuario");
            }

            $this->conn->commit();
            return ['success' => true, 'message' => '¡Registro exitoso!'];

        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error en registro: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $registration = new UserRegistration();
        $result = $registration->register($_POST['habboName'], $_POST['password']);
        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}