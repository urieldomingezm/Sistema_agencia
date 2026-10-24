<?php
// Session handling at the very beginning
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check session before any output
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header('Location: /login.php');
    exit;
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_PATH . 'header.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

class AdminController {
    private $conn;
    private $userRango;

    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }

        // Verificar sesión y rango
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
            header('Location: /login.php');
            exit;
        }

        // Conectar a la base de datos
        require_once(CONFIG_PATH . 'bd.php');
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->loadUserRank();
        
        // Verificar si el usuario tiene permisos administrativos
        $allowedRanks = ['Owner', 'owner', 'Fundador', 'fundador', 'My_queen', 'my_queen', 'Web_master', 'web_master'];
        if (!in_array($this->userRango, $allowedRanks)) {
            header('Location: /usuario/index.php');
            exit;
        }

        $this->loadAdminMenu();
    }

    private function loadUserRank() {
        try {
            $query = "SELECT a.rango_actual 
                     FROM registro_usuario r
                     JOIN ascensos a ON r.codigo_time = a.codigo_time
                     WHERE r.id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->userRango = $row['rango_actual'];
                $_SESSION['rango'] = $this->userRango;
            }
        } catch (PDOException $e) {
            error_log("Error al obtener rango: " . $e->getMessage());
        }
    }

    private function loadAdminMenu() {
        require_once(MENU_PATH . 'menu_administrativo.php');
    }

    public function handlePageLoad() {
        if (!isset($_GET['page'])) {
            include 'USR.php';
            return;
        }

        $page = $_GET['page'];
        $validPages = [
            'dashboard' => [
                'file' => 'USR.php',
                'roles' => ['Owner', 'owner', 'Fundador', 'fundador', 'My_queen', 'my_queen', 'Web_master']
            ],
            'estadisticas' => [
                'file' => 'estadisticas.php',
                'roles' => ['Owner', 'owner', 'Fundador', 'fundador', 'My_queen', 'my_queen', 'Web_master']
            ],
            'configuracion' => [
                'file' => 'configuracion.php',
                'roles' => ['Owner', 'owner', 'Fundador', 'fundador', 'My_queen', 'my_queen', 'Web_master']
            ],
            'logs' => [
                'file' => 'logs.php',
                'roles' => ['Owner', 'owner', 'Fundador', 'fundador', 'My_queen', 'my_queen', 'Web_master']
            ],
            'cerrar_session' => [
                'file' => 'CRSS.php',
                'roles' => ['Owner', 'owner', 'Fundador', 'fundador', 'My_queen', 'my_queen', 'Web_master']
            ],
            'auditoria_de_ascensos' => [
                'file' => 'AUS.php',
                'roles' => ['Owner', 'owner', 'Fundador', 'fundador', 'My_queen', 'my_queen', 'Web_master']
            ],
            'auditoria_de_registros' => [
                'file' => 'AUR.php',
                'roles' => ['Owner', 'owner', 'Fundador', 'fundador', 'My_queen', 'my_queen', 'Web_master']
            ],
            'lista_de_usuarios' => [
                'file' => 'LIST_AU.php',
                'roles' => ['Owner', 'owner', 'Fundador', 'fundador', 'My_queen', 'my_queen', 'Web_master']
            ]            
        ];

        if (array_key_exists($page, $validPages) && in_array($this->userRango, $validPages[$page]['roles'])) {
            include $validPages[$page]['file'];
        } else {
            $this->renderAccessDenied();
        }
    }

    private function renderAccessDenied() {
        echo '<div class="alert alert-danger text-center mt-5">';
        echo '<h4 class="alert-heading">Acceso Denegado</h4>';
        echo '<p>No tienes los permisos necesarios para acceder a esta sección administrativa.</p>';
        echo '<p>Tu rango actual es: ' . htmlspecialchars($this->userRango) . '</p>';
        echo '<a href="/usuario/index.php" class="btn btn-primary mt-3">Volver al área de usuario</a>';
        echo '</div>';
    }
}

$controller = new AdminController();
?>

<body>
    <div class="page-container">
        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-12">
                    <?php $controller->handlePageLoad(); ?>
                </div>
            </div>
        </div>
    </div>

    <div id="loader-wrapper" class="loader-wrapper">
        <div class="loader">
            <div class="loader-ring"></div>
            <div class="loader-ring-inner"></div>
        </div>
    </div>

    <?php require_once(TEMPLATES_PATH . 'footer.php'); ?>

    <script>
        window.addEventListener('load', function() {
            const loader = document.getElementById('loader-wrapper');
            loader.classList.add('fade-out');
            setTimeout(() => {
                loader.style.display = 'none';
            }, 300);
        });
    </script>
</body>