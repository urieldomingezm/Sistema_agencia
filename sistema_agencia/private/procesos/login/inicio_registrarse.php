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

    private function checkExistingIP($ip)
    {
        $query = "SELECT COUNT(*) FROM {$this->table} WHERE ip_registro = :ip";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':ip', $ip);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
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
                return ['success' => false, 'message' => 'Ya existe un registro con esta IP'];
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
                            (:codigo_time, 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', :fecha_ultimo_ascenso, :fecha_disponible_ascenso, NULL, TRUE)";

            $fecha_disponible_ascenso = "00:10:00";
            $stmtAscenso = $this->conn->prepare($queryAscenso);
            $stmtAscenso->bindParam(':codigo_time', $codigo_time);
            $stmtAscenso->bindParam(':fecha_ultimo_ascenso', $fecha_registro);
            $stmtAscenso->bindParam(':fecha_disponible_ascenso', $fecha_disponible_ascenso);

            if (!$stmtAscenso->execute()) {
                throw new Exception("Error al guardar el registro de ascenso");
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