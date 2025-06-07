<?php
$pageTitle = "Agencia Shein APP";
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(TEMPLATES_APP_PATH . 'header_app.php');

class AppController {
    private $userRango;
    private $conn;
    private $validPages = [
        'inicio' => ['path' => APP_SECCIONES, 'file' => 'home_inicio.php'],
        'perfil' => ['path' => APP_SECCIONES, 'file' => 'perfil.php'],
        'cerrar_session' => ['path' => APP_SECCIONES, 'file' => 'cerrar_session.php']
    ];

    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
        require_once(CONFIG_PATH . 'bd.php');
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->loadUserRank();
        $this->handlePageLoad();
    }

    private function loadUserRank() {
        try {
            $query = "SELECT a.rango_actual FROM registro_usuario r 
                      JOIN ascensos a ON r.codigo_time = a.codigo_time 
                      WHERE r.id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->userRango = $row['rango_actual'] ?? 'Agente';
        } catch (PDOException $e) {
            error_log("Error al obtener rango: " . $e->getMessage());
            $this->userRango = 'Agente';
        }
    }

    // CAMBIO: Este método ahora es público
    public function getTabFile() {
        $tabMap = [
            'Agente' => 'tab_bajos.php',
            'Seguridad' => 'tab_bajos.php',
            'Tecnico' => 'tab_bajos.php',
            'Logistica' => 'tab_bajos.php',
            'Supervisor' => 'tab_medios.php',
            'Director' => 'tab_altos.php',
            'Presidente' => 'tab_altos.php',
            'Operativo' => 'tab_altos.php',
            'Junta directiva' => 'tab_altos.php',
            'My_queen' => 'tab_administradores.php',
            'Administrador' => 'tab_administradores.php',
            'Manager' => 'tab_administradores.php',
            'Owner' => 'tab_administradores.php',
            'Fundador' => 'tab_administradores.php',
            'Web_master' => 'tab_administradores.php'
        ];
        return $tabMap[$this->userRango] ?? 'tab_bajos.php';
    }

    public function handlePageLoad() {
        if (!isset($_GET['page'])) {
            require_once(APP_SECCIONES . 'home_inicio.php');
            return;
        }

        $page = $_GET['page'];
        if (array_key_exists($page, $this->validPages)) {
            require_once($this->validPages[$page]['path'] . $this->validPages[$page]['file']);
        } else {
            require_once(APP_SECCIONES . 'home_inicio.php');
        }
    }
}

$app = new AppController();

require_once(TABS_APP_PATH . $app->getTabFile());
require_once(TEMPLATES_APP_PATH . 'footer_app.php');
?>
