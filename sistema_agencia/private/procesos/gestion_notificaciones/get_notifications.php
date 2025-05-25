<?php

require_once(CONFIG_PATH . 'bd.php');

class NotificationManager {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getNotificationsByUserId($userId) {
        $notifications = [];
        if ($this->conn) {
            $query = "SELECT gn.notificacion_id, gn.notificacion_mensaje, gn.notificacion_registro, gn.usuario_id, ru.nombre_habbo 
                      FROM gestion_notificaciones gn
                      JOIN registro_usuario ru ON gn.usuario_id = ru.id
                      WHERE gn.usuario_id = :userId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $notifications;
    }
}

// Example usage (you might call this from menu_rango_admin.php)
/*
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {
    $notificationManager = new NotificationManager();
    $userNotifications = $notificationManager->getNotificationsByUserId($_SESSION['user_id']);
    // Now $userNotifications contains the array of notifications for the logged-in user
    // You can then loop through this array to display them in the menu
} else {
    // User is not logged in, handle accordingly (e.g., show no notifications)
    $userNotifications = [];
}
*/

?>