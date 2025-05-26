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
            // Primero verificamos si existe la IP
            $query = "SELECT id, usuario_registro FROM {$this->table} WHERE ip_registro = :ip";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':ip', $ip);
            $stmt->execute();
            
            $existingUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $exists = count($existingUsers) > 0;
            
            error_log("DEBUG: IP " . $ip . " exists: " . ($exists ? 'true' : 'false') . ". Found " . count($existingUsers) . " users.");
    
            // Si existe la IP, bloqueamos todas las cuentas asociadas a esa IP
            if ($exists) {
                // Generamos una contraseña aleatoria que el usuario no conocerá
                $randomPassword = bin2hex(random_bytes(16));
                $hashedPassword = password_hash($randomPassword, PASSWORD_DEFAULT);
                
                // Actualizamos TODOS los registros con esta IP
                $updateQuery = "UPDATE {$this->table} SET password_registro = :password, ip_bloqueo = :bloqueo WHERE ip_registro = :ip";
                $updateStmt = $this->conn->prepare($updateQuery);
                
                $bloqueoStatus = 'se bloqueo cuenta';
                $updateStmt->bindParam(':password', $hashedPassword);
                $updateStmt->bindParam(':bloqueo', $bloqueoStatus);
                $updateStmt->bindParam(':ip', $ip);
                
                if (!$updateStmt->execute()) {
                    error_log("ERROR: Fallo al ejecutar el UPDATE para IP: " . $ip . ". ErrorInfo: " . print_r($updateStmt->errorInfo(), true));
                    throw new Exception("Error al bloquear cuentas existentes");
                }
                
                $affectedRows = $updateStmt->rowCount();
                error_log("DEBUG: UPDATE para IP " . $ip . " ejecutado. Filas afectadas: " . $affectedRows);
                error_log("Cuentas con IP {$ip} bloqueadas por duplicado");
            }
            
            return $exists;
        } catch (PDOException $e) {
            error_log("Error en checkExistingIP: " . $e->getMessage());
            throw $e;
        }
    }

    private function generateUniqueCode() {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $code = '';
        for ($i = 0; $i < 5; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }

    public function register($habboName, $password)
    {
        try {
            $this->conn->beginTransaction();
    
            if (empty($habboName) || empty($password)) {
                return ['success' => false, 'message' => 'Todos los campos son requeridos'];
            }
    
            $ip = $this->getClientIP();
    
            // Inserción de nuevo usuario
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $codigo_time = $this->generateUniqueCode();
            $query = "INSERT INTO {$this->table} 
                     (usuario_registro, password_registro, nombre_habbo, rol_id, fecha_registro, ip_registro, codigo_time, ip_bloqueo) 
                     VALUES (:habbo_name, :password, :habbo_name, 1, NOW(), :ip, :codigo_time, NULL)";
    
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':habbo_name', $habboName);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':ip', $ip);
            $stmt->bindParam(':codigo_time', $codigo_time);
    
            if (!$stmt->execute()) {
                throw new Exception("Error al guardar el registro de usuario");
            }
    
            // Verificación de IP existente
            if ($this->checkExistingIP($ip)) {
                // Bloqueo de cuentas existentes
                $randomPassword = bin2hex(random_bytes(16));
                $hashedPassword = password_hash($randomPassword, PASSWORD_DEFAULT);
                $updateQuery = "UPDATE {$this->table} SET password_registro = :password, ip_bloqueo = :bloqueo WHERE ip_registro = :ip";
                $updateStmt = $this->conn->prepare($updateQuery);
                $bloqueoStatus = 'se bloqueo cuenta';
                $updateStmt->bindParam(':password', $hashedPassword);
                $updateStmt->bindParam(':bloqueo', $bloqueoStatus);
                $updateStmt->bindParam(':ip', $ip);
    
                if (!$updateStmt->execute()) {
                    error_log("ERROR: Fallo al ejecutar el UPDATE para IP: " . $ip . ". ErrorInfo: " . print_r($updateStmt->errorInfo(), true));
                    throw new Exception("Error al bloquear cuentas existentes");
                }
    
                $affectedRows = $updateStmt->rowCount();
                error_log("DEBUG: UPDATE para IP " . $ip . " ejecutado. Filas afectadas: " . $affectedRows);
                error_log("Cuentas con IP {$ip} bloqueadas por duplicado");
            }
    
            $this->conn->commit();
            return ['success' => true, 'message' => '¡Registro exitoso! Por favor, inicia sesión para continuar.'];
    
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error en registro: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()];
        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error en registro: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $registration = new UserRegistration();
        $result = $registration->register($_POST['habboName'], $_POST['password']);
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()]);
    }
}