<?php
$pageTitle = "Agencia Shein APP";
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    echo "<script>window.location.href = '/login.php';</script>";
    exit;
}

echo '
<div id="loading-screen" class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-90 z-50">
  <svg class="w-12 h-12 text-indigo-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" >
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
  </svg>
</div>

<script>
  window.addEventListener("load", function() {
    const loader = document.getElementById("loading-screen");
    if(loader) {
      loader.style.display = "none";
    }
  });
</script>
';

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
