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
        // Verificamos si existe la IP
        $query = "SELECT id, usuario_registro FROM {$this->table} WHERE ip_registro = :ip ORDER BY id ASC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ip', $ip);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $exists = $user !== false;
        
        // Si existe la IP, bloqueamos solo el primer registro encontrado
        if ($exists) {
            // Generamos una contraseña aleatoria que el usuario no conocerá
            $randomPassword = bin2hex(random_bytes(10));
            $hashedPassword = password_hash($randomPassword, PASSWORD_DEFAULT);
            
            // Cambiado para usar ip_registro en lugar de id
            $updateQuery = "UPDATE {$this->table} SET 
                           bloqueo = 'se bloqueo cuenta', 
                           password_registro = :new_password 
                           WHERE ip_registro = :ip";
            
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bindParam(':new_password', $hashedPassword);
            $updateStmt->bindParam(':ip', $ip);
            
            if (!$updateStmt->execute()) {
                error_log("Error al actualizar: " . print_r($updateStmt->errorInfo(), true));
            } else {
                error_log("Registros actualizados - Filas afectadas: " . $updateStmt->rowCount());
            }
            
            error_log("Usuarios con IP {$ip} bloqueados por duplicado");
        }
        
        return $exists;
    }

    private function generateUniqueCode() {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $code = '';
        for ($i = 0; $i < 5; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }

    public function register($username, $password, $habboName)
    {
        try {
            $this->conn->beginTransaction();

            if (empty($username) || empty($password) || empty($habboName)) {
                return ['success' => false, 'message' => 'Todos los campos son requeridos'];
            }

            $ip = $this->getClientIP();

            if ($this->checkExistingIP($ip)) {
                return ['success' => false, 'message' => 'Ya existe un registro con esta IP. La cuenta ha sido bloqueada por seguridad.'];
            }

            $checkHabbo = "SELECT COUNT(*) FROM {$this->table} WHERE nombre_habbo = :habbo_name";
            $stmt = $this->conn->prepare($checkHabbo);
            $stmt->bindParam(':habbo_name', $habboName);
            $stmt->execute();
            if ($stmt->fetchColumn() > 0) {
                return ['success' => false, 'message' => 'Este nombre de Habbo ya está registrado'];
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $codigo_time = $this->generateUniqueCode();
            
            // Insertar en tabla registro_usuario
            $query = "INSERT INTO {$this->table} 
                     (usuario_registro, password_registro, nombre_habbo, rol_id, fecha_registro, ip_registro, codigo_time) 
                     VALUES (:username, :password, :habbo_name, 1, NOW(), :ip, :codigo_time)";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':habbo_name', $habboName);
            $stmt->bindParam(':ip', $ip);
            $stmt->bindParam(':codigo_time', $codigo_time);

            if (!$stmt->execute()) {
                throw new Exception("Error al guardar el registro de usuario");
            }

            // Obtener fecha y hora de México en formato datetime
            $dtMexico = new DateTime('now', new DateTimeZone('America/Mexico_City'));
            $fecha_registro = $dtMexico->format('Y-m-d H:i:s');

            // Insertar en tabla ascensos (NUEVA ESTRUCTURA)
            $queryAscenso = "INSERT INTO ascensos 
                            (codigo_time, rango_actual, mision_actual, firma_usuario, firma_encargado, estado_ascenso, fecha_ultimo_ascenso, fecha_disponible_ascenso, usuario_encargado, es_recluta) 
                            VALUES 
                            (:codigo_time, 'Agente', 'AGE- Iniciado I', NULL, NULL, 'ascendido', :fecha_ultimo_ascenso, :fecha_disponible_ascenso, NULL, TRUE)";

            $fecha_disponible_ascenso = "00:10:00";
            $stmtAscenso = $this->conn->prepare($queryAscenso);
            $stmtAscenso->bindParam(':codigo_time', $codigo_time);
            $stmtAscenso->bindParam(':fecha_ultimo_ascenso', $fecha_registro);
            $stmtAscenso->bindParam(':fecha_disponible_ascenso', $fecha_disponible_ascenso);

            if (!$stmtAscenso->execute()) {
                throw new Exception("Error al guardar el registro de ascenso");
            }

            // Insertar en tabla gestion_tiempo
            $queryTiempo = "INSERT INTO gestion_tiempo 
                          (codigo_time, tiempo_status, tiempo_restado, tiempo_acumulado, tiempo_transcurrido, tiempo_encargado_usuario, tiempo_fecha_registro) 
                          VALUES 
                          (:codigo_time, 'pausa', '00:00:00', '00:00:00', '00:00:00', NULL, NOW())";

            $stmtTiempo = $this->conn->prepare($queryTiempo);
            $stmtTiempo->bindParam(':codigo_time', $codigo_time);

            if (!$stmtTiempo->execute()) {
                throw new Exception("Error al guardar el registro de tiempo");
            }

            $this->conn->commit();
            return ['success' => true, 'message' => '¡Registro exitoso! Por favor, inicia sesión para continuar.'];

        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Error en registro: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error en el registro: ' . $e->getMessage()];
        }
    }
}

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