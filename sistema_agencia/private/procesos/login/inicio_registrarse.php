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

    private function insertDefaultRecords($codigo_time) {
        try {
            // Insertar registro en tabla ascensos con valores por defecto
            $queryAscensos = "INSERT INTO ascensos (
                codigo_time, 
                rango_actual, 
                mision_actual, 
                firma_usuario, 
                firma_encargado, 
                estado_ascenso, 
                fecha_ultimo_ascenso,
                fecha_disponible_ascenso,
                es_recluta
            ) VALUES (
                :codigo_time,
                'Agente',          
                'SHN- Iniciado I', 
                NULL,
                NULL,
                'Ascendido',       
                NOW(),
                '00:10:00',       
                1                   
            )";

            $stmtAscensos = $this->conn->prepare($queryAscensos);
            $stmtAscensos->bindParam(':codigo_time', $codigo_time);
            
            if (!$stmtAscensos->execute()) {
                throw new Exception("Error al insertar registro en ascensos");
            }

            // Insertar registro en tabla gestion_tiempo
            $queryTiempo = "INSERT INTO gestion_tiempo (
                codigo_time,
                tiempo_status,
                tiempo_restado,
                tiempo_acumulado,
                tiempo_transcurrido,
                tiempo_encargado_usuario,
                tiempo_fecha_registro,
                tiempo_iniciado
            ) VALUES (
                :codigo_time,
                'pausa',     
                '00:00:00',
                '00:00:00',
                '00:00:00',
                NULL,
                NOW(),
                '00:00:00'
            )";

            $stmtTiempo = $this->conn->prepare($queryTiempo);
            $stmtTiempo->bindParam(':codigo_time', $codigo_time);
            
            if (!$stmtTiempo->execute()) {
                throw new Exception("Error al insertar registro en gestion_tiempo");
            }

            return true;
        } catch (Exception $e) {
            error_log("Error en insertDefaultRecords: " . $e->getMessage());
            throw $e;
        }
    }

    public function register($habboName, $password)
    {
        try {
            $this->conn->beginTransaction();

            if (empty($habboName) || empty($password)) {
                return ['success' => false, 'message' => 'Todos los campos son requeridos'];
            }

            // Validar el formato del nombre
            if (!preg_match('/^[a-zA-Z0-9]+$/', $habboName)) {
                return ['success' => false, 'message' => 'El nombre solo puede contener letras y números'];
            }

            $ip = $this->getClientIP();
            error_log("IP del cliente: " . $ip); // Debug

            // Verificar IP existente
            if ($this->checkExistingIP($ip)) {
                $affected = $this->blockAccountsByIP($ip);
                error_log("Bloqueadas $affected cuentas con IP $ip");
                return ['success' => false, 'message' => 'No se permiten múltiples registros'];
            }

            // Verificar nombre de usuario
            $checkHabbo = "SELECT COUNT(*) as total FROM {$this->table} 
                          WHERE LOWER(nombre_habbo) = LOWER(:habbo_name) 
                          OR LOWER(usuario_registro) = LOWER(:habbo_name)";
            
            $stmtHabbo = $this->conn->prepare($checkHabbo);
            $stmtHabbo->bindValue(':habbo_name', strtolower($habboName));
            $stmtHabbo->execute();
            
            if ($stmtHabbo->fetchColumn() > 0) {
                $this->conn->rollBack();
                return ['success' => false, 'message' => 'Nombre de usuario ya registrado'];
            }

            // Generar código único
            $codigo_time = $this->generateUniqueCode();
            error_log("Código generado: " . $codigo_time); // Debug

            // Registrar usuario
            $query = "INSERT INTO {$this->table} 
                     (usuario_registro, password_registro, nombre_habbo, rol_id, fecha_registro, ip_registro, codigo_time) 
                     VALUES (:username, :password, :habbo_name, 1, NOW(), :ip, :codigo_time)";

            $stmt = $this->conn->prepare($query);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt->bindValue(':username', $habboName);
            $stmt->bindValue(':password', $hashedPassword);
            $stmt->bindValue(':habbo_name', $habboName);
            $stmt->bindValue(':ip', $ip);
            $stmt->bindValue(':codigo_time', $codigo_time);

            if (!$stmt->execute()) {
                throw new Exception("Error al insertar usuario: " . implode(", ", $stmt->errorInfo()));
            }

            // Insertar registros por defecto
            if (!$this->insertDefaultRecords($codigo_time)) {
                throw new Exception("Error al insertar registros por defecto");
            }

            $this->conn->commit();
            return ['success' => true, 'message' => '¡Registro exitoso!'];

        } catch (Exception $e) {
            $this->conn->rollBack();
            error_log("Error detallado en registro: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error al registrar usuario: ' . $e->getMessage()];
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