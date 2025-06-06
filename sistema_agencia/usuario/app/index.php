<?php
$pageTitle = "Agencia Shein APP";
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_APP_PATH . 'header_app.php');

// Controlador para manejar las páginas
class AppController
{
    private $validPages = [
        'inicio' => ['file' => 'home_inicio.php', 'roles' => ['all']],
        'perfil' => ['file' => 'perfil.php', 'roles' => ['all']],
        'notificaciones' => ['file' => 'notificaciones.php', 'roles' => ['all']],
        'tiempos' => ['file' => 'tiempos.php', 'roles' => ['Logistica', 'Supervisor', 'Director']],
        'ascensos' => ['file' => 'ascensos.php', 'roles' => ['Logistica', 'Supervisor', 'Director']],
        'configuracion' => ['file' => 'configuracion.php', 'roles' => ['all']]
    ];

    private $userRango;

    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $this->loadUserRank();
    }

    private function loadUserRank()
    {
        require_once(CONFIG_PATH . 'bd.php');
        $database = new Database();
        $conn = $database->getConnection();

        try {
            $query = "SELECT a.rango_actual 
                     FROM registro_usuario r
                     JOIN ascensos a ON r.codigo_time = a.codigo_time
                     WHERE r.id = :user_id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->userRango = $row['rango_actual'] ?? 'Agente';
        } catch (PDOException $e) {
            $this->userRango = 'Agente';
        }
    }

    public function loadContent()
    {
        $page = $_GET['page'] ?? 'inicio';

        if (array_key_exists($page, $this->validPages)) {
            $pageConfig = $this->validPages[$page];

            if ($pageConfig['roles'][0] === 'all' || in_array($this->userRango, $pageConfig['roles'])) {
                return BIENVENIDA_APP_PATH . $pageConfig['file'];
            }
        }

        // Página por defecto si no tiene permisos
        return BIENVENIDA_APP_PATH . 'home_inicio.php';
    }

    public function getUserRango()
    {
        return $this->userRango;
    }
}

$controller = new AppController();
$contentFile = $controller->loadContent();
?>

<ion-content fullscreen="true">
    <div class="inner-scroll">
        <?php require_once($contentFile); ?>
    </div>
</ion-content>

<?php
require_once(TABS_APP_PATH . 'tab_bajos.php');
require_once(TEMPLATES_APP_PATH . 'footer_app.php');
?>