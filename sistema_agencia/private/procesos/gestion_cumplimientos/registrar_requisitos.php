<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!defined('CONFIG_PATH')) {
    define('CONFIG_PATH', __DIR__ . '/../../conexion/');
}

require_once(CONFIG_PATH . 'bd.php');

class RequirementManager {
    private $database;
    private $conn;
    private $response;
    
    public function __construct() {
        $this->response = ['success' => false, 'message' => ''];
        $this->initializeDatabaseConnection();
    }
    
    private function initializeDatabaseConnection() {
        try {
            $this->database = new Database();
            $this->conn = $this->database->getConnection();
            
            if (!$this->conn) {
                throw new Exception("No se pudo establecer la conexión con la base de datos.");
            }
        } catch (Exception $e) {
            $this->response['message'] = 'Error de conexión: ' . $e->getMessage();
            $this->sendResponse();
        }
    }
    
    public function handleRequest() {
        $this->validateSession();
        $this->validateRequestMethod();
        
        $username = $_SESSION['username'];
        $postedRequirementName = $this->sanitizeInput($_POST['requirement_name'] ?? '');
        $type = $this->sanitizeInput($_POST['type'] ?? '');
        
        $this->validateRequiredParameters($postedRequirementName, $type);
        
        $count = $this->extractCountFromRequirement($postedRequirementName);
        $config = $this->getConfigurationByType($type);
        
        $this->processRequirement($username, $postedRequirementName, $count, $config);
        $this->sendResponse();
    }
    
    private function validateSession() {
        if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
            $this->response['message'] = 'No has iniciado sesión o no se encontró tu nombre de usuario.';
            $this->sendResponse();
        }
    }
    
    private function validateRequestMethod() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->response['message'] = 'Método no permitido.';
            $this->sendResponse();
        }
    }
    
    private function sanitizeInput($input) {
        return trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
    }
    
    private function validateRequiredParameters($requirementName, $type) {
        if (empty($requirementName) || empty($type)) {
            $this->response['message'] = 'Parámetros requeridos faltantes (requirement_name o type).';
            $this->sendResponse();
        }
    }
    
    private function extractCountFromRequirement($postedRequirementName) {
        if (preg_match('/^(\d+)\s+(tiempos|ascensos)/', $postedRequirementName, $matches)) {
            return (int)$matches[1];
        }
        
        error_log("Formato de requirement_name inesperado: " . $postedRequirementName);
        return 0;
    }
    
    private function getConfigurationByType($type) {
        $validTypes = [
            'tiempos' => [
                'count_column' => 'times_as_encargado_count',
                'message_type' => 'Tiempos'
            ],
            'ascensos' => [
                'count_column' => 'ascensos_as_encargado_count',
                'message_type' => 'Ascensos'
            ]
        ];
        
        if (!array_key_exists($type, $validTypes)) {
            $this->response['message'] = 'Tipo de registro no válido.';
            $this->sendResponse();
        }
        
        return $validTypes[$type];
    }
    
    private function getCurrentWeekRange() {
        date_default_timezone_set('America/Mexico_City');
        $now = new DateTime();
        return [
            'start' => (clone $now)->modify('this week Monday')->format('Y-m-d 00:00:00'),
            'end' => (clone $now)->modify('this week Sunday')->format('Y-m-d 23:59:59')
        ];
    }
    
    private function findExistingRecord($username) {
        $weekRange = $this->getCurrentWeekRange();
        
        $query = "SELECT id FROM gestion_requisitos
                 WHERE user = :user
                 AND last_updated BETWEEN :start_of_week AND :end_of_week";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user', $username);
        $stmt->bindParam(':start_of_week', $weekRange['start']);
        $stmt->bindParam(':end_of_week', $weekRange['end']);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    private function processRequirement($username, $requirementName, $count, $config) {
        try {
            $existingRecord = $this->findExistingRecord($username);
            
            if ($existingRecord) {
                $this->updateExistingRecord($existingRecord['id'], $requirementName, $count, $config);
            } else {
                $this->insertNewRecord($username, $requirementName, $count, $config);
            }
        } catch (Exception $e) {
            $this->response['message'] = 'Error en el servidor: ' . $e->getMessage();
        }
    }
    
    private function updateExistingRecord($recordId, $requirementName, $count, $config) {
        $query = "UPDATE gestion_requisitos
                 SET requirement_name = :requirement_name, 
                     {$config['count_column']} = :count, 
                     last_updated = NOW()
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':requirement_name', $requirementName);
        $stmt->bindParam(':count', $count, PDO::PARAM_INT);
        $stmt->bindParam(':id', $recordId);
        
        if ($stmt->execute()) {
            $this->response['success'] = true;
            $this->response['message'] = "Requisito semanal de {$config['message_type']} actualizado con éxito.";
        } else {
            $this->response['message'] = "Error al actualizar el requisito semanal de {$config['message_type']}.";
        }
    }
    
    private function insertNewRecord($username, $requirementName, $count, $config) {
        $query = "INSERT INTO gestion_requisitos 
                 (user, requirement_name, times_as_encargado_count, ascensos_as_encargado_count, is_completed, last_updated)
                 VALUES (:user, :requirement_name, :times_count, :ascensos_count, FALSE, NOW())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user', $username);
        $stmt->bindParam(':requirement_name', $requirementName);
        
        $timesCount = ($config['message_type'] === 'Tiempos') ? $count : 0;
        $ascensosCount = ($config['message_type'] === 'Ascensos') ? $count : 0;
        
        $stmt->bindParam(':times_count', $timesCount, PDO::PARAM_INT);
        $stmt->bindParam(':ascensos_count', $ascensosCount, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $this->response['success'] = true;
            $this->response['message'] = "Requisito semanal de {$config['message_type']} registrado con éxito.";
        } else {
            $this->response['message'] = "Error al registrar el requisito semanal de {$config['message_type']}.";
        }
    }
    
    private function sendResponse() {
        header('Content-Type: application/json');
        echo json_encode($this->response);
        exit;
    }
}

// Uso de la clase
$requirementManager = new RequirementManager();
$requirementManager->handleRequest();
?>