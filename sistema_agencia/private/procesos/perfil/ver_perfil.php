<?php
class UserProfile {
    private $userData;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }

        require_once(CONFIG_PATH . 'bd.php');
        $database = new Database();
        $conn = $database->getConnection();

        try {
            // Obtener datos básicos del usuario
            $query = "SELECT usuario_registro, rango FROM registro_usuario WHERE id = :user_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$userData) {
                throw new Exception('Usuario no encontrado');
            }

            // Obtener datos de ascenso
            $ascensoQuery = "SELECT ascenso_rango, ascenso_mision_nueva, ascenso_status, 
                                  ascenso_hora_proxima, ascenso_encargado_usuario 
                           FROM gestion_ascenso 
                           WHERE ascenso_usuario = :username 
                           ORDER BY ascenso_fecha_registro DESC LIMIT 1";
            $stmt = $conn->prepare($ascensoQuery);
            $stmt->bindParam(':username', $userData['usuario_registro']);
            $stmt->execute();
            $ascensoData = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->userData = [
                'username' => htmlspecialchars($userData['usuario_registro']),
                'role' => htmlspecialchars($userData['rango']),
                'mission' => $ascensoData ? htmlspecialchars($ascensoData['ascenso_mision_nueva']) : 'Sin misión asignada',
                'avatar' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=' . urlencode($userData['usuario_registro']) . '&action=none&direction=2&head_direction=2&gesture=&size=sl&headonly=1r',
                'nextMission' => 'Pendiente',
                'paymentTime' => '14:00',
                'paymentDate' => '15',
                'hoursDeducted' => '1:00',
                'totalHours' => '5:00',
                'estimatedTime' => $ascensoData ? htmlspecialchars($ascensoData['ascenso_hora_proxima']) : 'No disponible',
                'status' => $ascensoData ? htmlspecialchars($ascensoData['ascenso_status']) : 'Pendiente',
                'encargado' => $ascensoData ? htmlspecialchars($ascensoData['ascenso_encargado_usuario']) : 'No asignado'
            ];
        } catch (Exception $e) {
            error_log("Error al obtener datos del usuario: " . $e->getMessage());
            $this->setDefaultUserData();
        }
    }

    private function setDefaultUserData() {
        $this->userData = [
            'username' => 'Usuario',
            'role' => 'No disponible',
            'mission' => 'Sin misión asignada',
            'avatar' => 'https://api.a0.dev/assets/image?text=Usuario%20no%20encontrado&aspect=1:1',
            'nextMission' => 'No disponible',
            'paymentTime' => '--:--',
            'paymentDate' => '--',
            'hoursDeducted' => '--:--',
            'totalHours' => '--:--',
            'estimatedTime' => 'No disponible',
            'status' => 'No disponible',
            'encargado' => 'No asignado'
        ];
    }

    public function render() {
        include 'PRUS.php';
    }

    public function getUserData() {
        return $this->userData;
    }
}

// Eliminar estas líneas que causan la duplicación
// $userProfile = new UserProfile();
// $userProfile->render();
?>