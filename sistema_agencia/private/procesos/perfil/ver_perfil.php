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
            // Obtener datos básicos del usuario y ascensos
            $query = "SELECT r.usuario_registro, r.rango, r.codigo_time,
                            a.mision_actual, a.estado_ascenso, 
                            a.fecha_disponible_ascenso, a.usuario_encargado,
                            CASE 
                               WHEN a.fecha_disponible_ascenso <= NOW() THEN 'disponible'
                               ELSE 'pendiente'
                            END as estado_disponibilidad
                      FROM registro_usuario r
                      LEFT JOIN ascensos a ON r.codigo_time = a.codigo_time
                      WHERE r.id = :user_id";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();
            $userData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$userData) {
                throw new Exception('Usuario no encontrado');
            }

            $this->userData = [
                'username' => htmlspecialchars($userData['usuario_registro']),
                'role' => htmlspecialchars($userData['rango']),
                'codigo' => htmlspecialchars($userData['codigo_time']),
                'mission' => $userData['mision_actual'] ?? 'No disponible',
                'avatar' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=' . urlencode($userData['usuario_registro']) . '&action=none&direction=2&head_direction=2&gesture=&size=sl&headonly=1r',
                'paymentTime' => '14:00',
                'paymentDate' => '15',
                'totalHours' => '0:00',
                'estimatedTime' => $userData['fecha_disponible_ascenso'] ? date('d/m/Y H:i', strtotime($userData['fecha_disponible_ascenso'])) : 'No disponible',
                'status' => $this->formatStatus($userData['estado_ascenso'] ?? null),
                'encargado' => $userData['usuario_encargado'] ?? 'No asignado',
                'estado_disponibilidad' => $userData['fecha_disponible_ascenso'] && strtotime($userData['fecha_disponible_ascenso']) <= time() ? 'disponible' : 'pendiente'
            ];
        } catch (Exception $e) {
            error_log("Error al obtener datos del usuario: " . $e->getMessage());
            $this->setDefaultUserData();
        }
    }

    private function formatStatus($status) {
        if ($status === null) return 'No disponible';
        
        $statusMap = [
            'pendiente' => 'Pendiente',
            'ascendido' => 'Ascendido',
            'en_espera' => 'En espera'
        ];

        return $statusMap[$status] ?? 'No disponible';
    }

    private function setDefaultUserData() {
        $this->userData = [
            'username' => 'Usuario',
            'role' => 'No disponible',
            'codigo' => 'No disponible',
            'mission' => 'Sin misión asignada',
            'avatar' => 'https://api.a0.dev/assets/image?text=Usuario%20no%20encontrado&aspect=1:1',
            'paymentTime' => '--:--',
            'paymentDate' => '--',
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
?>