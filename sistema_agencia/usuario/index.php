<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_PATH . 'header.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

class UserController
{
    private $conn;
    private $userRango;

    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
            echo "<script>
            window.location.href = '/login.php';
            </script>";
            exit;
        }

        require_once(CONFIG_PATH . 'bd.php');
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->loadUserRank();
        $this->loadMenu();
    }

    private function loadUserRank()
    {
        try {
            $query = "SELECT a.rango_actual 
                 FROM registro_usuario r
                 JOIN ascensos a ON r.codigo_time = a.codigo_time
                 WHERE r.id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            $stmt->execute();

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->userRango = $row['rango_actual'] ?? 'Agente';
                $_SESSION['rango'] = $this->userRango;
            } else {
                $this->userRango = 'Agente';
                $_SESSION['rango'] = $this->userRango;
            }
        } catch (PDOException $e) {
            error_log("Error al obtener rango: " . $e->getMessage());
            $this->userRango = 'Agente';
            $_SESSION['rango'] = $this->userRango;
        }
    }

    private function loadMenu()
    {
        $menuMap = [
            // Low rank menus
            'Agente' => 'menu_rango_bajos.php',
            'agente' => 'menu_rango_bajos.php',
            'Seguridad' => 'menu_rango_bajos.php',
            'seguridad' => 'menu_rango_bajos.php',
            'Tecnico' => 'menu_rango_bajos.php',
            'tecnico' => 'menu_rango_bajos.php',
            'Logistica' => 'menu_rango_bajos.php',
            'logistica' => 'menu_rango_bajos.php',

            // Medium rank menus
            'Supervisor' => 'menu_rango_medios.php',
            'supervisor' => 'menu_rango_medios.php',

            // High rank menus
            'Director' => 'menu_rango_altos.php',
            'director' => 'menu_rango_altos.php',
            'Presidente' => 'menu_rango_altos.php',
            'presidente' => 'menu_rango_altos.php',
            'Operativo' => 'menu_rango_altos.php',
            'operativo' => 'menu_rango_altos.php',
            'Junta directiva' => 'menu_rango_altos.php',
            'junta directiva' => 'menu_rango_altos.php',

            // Admin rank menus
            'My_queen' => 'menu_rango_admin.php',
            'my_queen' => 'menu_rango_admin.php',
            'Administrador' => 'menu_rango_admin.php',
            'administrador' => 'menu_rango_admin.php',
            'Manager' => 'menu_rango_admin.php',
            'manager' => 'menu_rango_admin.php',
            'Owner' => 'menu_rango_admin.php',
            'owner' => 'menu_rango_admin.php',
            'Fundador' => 'menu_rango_admin.php',
            'fundador' => 'menu_rango_admin.php',

            // Web_master rank menus
            'Web_master' => 'menu_rango_web.php',
            'web_master' => 'menu_rango_web.php',
        ];

        $menuFile = $menuMap[$this->userRango] ?? 'menu_rango_bajos.php';
        require_once(MENU_PATH . $menuFile);
    }

    public function handleSearch()
    {
        if (!isset($_GET['q']) || empty($_GET['q'])) {
            return;
        }

        $query = strtolower(trim($_GET['q']));
        $pages = [
            'GSTM.php' => 'gestion_de_tiempo',
            'USR.php' => 'inicio',
            'PRUS.php' => 'ver_perfil',
            'CRSS.php' => 'cerrar_session',
            'RQPG.php' => 'requisitos_paga',
            'GSAS.php' => 'gestion_ascenso',
            'HISA.php' => 'ver_mis_ascensos',
            'HIST.php' => 'ver_mis_tiempos',
            'MEMS.php' => 'membresias',
            'GTPS.php' => 'gestion_de_pagas',
            'VTM.php' => 'ventas_membresias',
            'VTR.php' => 'venta_rangos',
            'GTNT.php' => 'gestion_de_notificaciones',
        ];

        $results = [];
        foreach ($pages as $file => $title) {
            if (file_exists($file)) {
                $content = file_get_contents($file);
                preg_match('/<meta name="keywords" content="([^"]+)"/', $content, $matches);

                if (!empty($matches[1])) {
                    $keywords = explode(',', strtolower($matches[1]));
                    foreach ($keywords as $keyword) {
                        similar_text($query, $keyword, $percentage);
                        if ($percentage > 60 || strpos($keyword, $query) !== false) {
                            $results[] = ['title' => $title, 'url' => 'index.php?page=' . urlencode($title)];
                            break;
                        }
                    }
                }
            }
        }

        $this->renderSearchResults($query, $results);
    }

    private function renderSearchResults($query, $results)
    {
        echo '<div class="search-results-container">';
        echo '<div class="card shadow-lg border-0 rounded-lg">';
        echo '<div class="card-header bg-gradient-primary">';
        echo '<h4 class="text-white mb-0"><i class="bi bi-search me-2"></i>Resultados para: "' . htmlspecialchars($query) . '"</h4>';
        echo '</div>';
        echo '<div class="card-body">';

        if (!empty($results)) {
            $this->renderResultsList($results);
        } else {
            $this->renderNoResults();
        }

        echo '</div></div></div>';
    }

    private function renderResultsList($results)
    {
        echo '<div class="results-list">';
        foreach ($results as $result) {
            echo '<a href="' . $result['url'] . '" class="result-item">';
            echo '<div class="d-flex align-items-center p-3 border-bottom transition-hover">';
            echo '<i class="bi bi-link-45deg me-3 text-primary"></i>';
            echo '<div>';
            echo '<h5 class="mb-0">' . ucfirst($result['title']) . '</h5>';
            echo '</div>';
            echo '<i class="bi bi-chevron-right ms-auto text-muted"></i>';
            echo '</div>';
            echo '</a>';
        }
        echo '</div>';
    }

    private function renderNoResults()
    {
        echo '<div class="text-center p-4">';
        echo '<i class="bi bi-search-x fa-3x text-muted mb-3"></i>';
        echo '<div class="alert alert-warning mb-0">';
        echo '<h5 class="alert-heading">No se encontraron resultados</h5>';
        echo '<p class="mb-0">Intenta con otros términos de búsqueda</p>';
        echo '</div>';
        echo '</div>';
    }

    public function handlePageLoad()
    {
        if (!isset($_GET['page'])) {
            include 'USR.php';
            return;
        }

        $page = $_GET['page'];
        $validPages = [
            // Pages accessible by all roles
            'inicio' => [
                'file' => 'USR.php',
                'roles' => ['Web_master','agente', 'seguridad', 'tecnico', 'logistica', 'supervisor', 'director', 'presidente', 'operativo', 'junta directiva', 'administrador', 'manager', 'owner', 'fundador', 'my_queen', 'Agente', 'Seguridad', 'Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva', 'Administrador', 'Manager', 'owner', 'Fundador', 'My_queen']
            ],
            'ver_perfil' => [
                'file' => 'PRUS.php',
                'roles' => ['Web_master','agente', 'seguridad', 'tecnico', 'logistica', 'supervisor', 'director', 'presidente', 'operativo', 'junta directiva', 'administrador', 'manager', 'owner', 'fundador', 'my_queen', 'Agente', 'Seguridad', 'Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva', 'Administrador', 'Manager', 'owner', 'Fundador', 'My_queen']
            ],
            'cerrar_session' => [
                'file' => 'CRSS.php',
                'roles' => ['Web_master','agente', 'seguridad', 'tecnico', 'logistica', 'supervisor', 'director', 'presidente', 'operativo', 'junta directiva', 'administrador', 'manager', 'owner', 'fundador', 'my_queen', 'Agente', 'Seguridad', 'Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva', 'Administrador', 'Manager', 'owner', 'Fundador', 'My_queen']
            ],
            'requisitos_paga' => [
                'file' => 'RQPG.php',
                'roles' => ['Web_master','agente', 'seguridad', 'tecnico', 'logistica', 'supervisor', 'director', 'presidente', 'operativo', 'junta directiva', 'administrador', 'manager', 'owner', 'fundador', 'my_queen', 'Agente', 'Seguridad', 'Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva', 'Administrador', 'Manager', 'owner', 'Fundador', 'My_queen']
            ],

            // Pages accessible by logistics and above
            'gestion_ascenso' => [
                'file' => 'GSAS.php',
                'roles' => ['Web_master','logistica', 'supervisor', 'operativo', 'director', 'presidente', 'junta directiva', 'administrador', 'manager', 'owner', 'fundador', 'my_queen', 'Logistica', 'Supervisor', 'Operativo', 'Director', 'Presidente', 'Junta directiva', 'Administrador', 'Manager', 'owner', 'Fundador', 'My_queen']
            ],
            
            // Pages for viewing personal time and promotions (accessible by logistics and above)
            'ver_mis_tiempos' => [
                'file' => 'HIST.php',
                'roles' => ['Web_master','logistica', 'supervisor', 'director', 'presidente', 'operativo', 'junta directiva', 'administrador', 'manager', 'owner', 'fundador', 'my_queen', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva', 'Administrador', 'Manager', 'owner', 'Fundador', 'My_queen']
            ],
            'ver_mis_ascensos' => [
                'file' => 'HISA.php',
                'roles' => ['Web_master','logistica', 'supervisor', 'director', 'presidente', 'operativo', 'junta directiva', 'administrador', 'manager', 'owner', 'fundador', 'my_queen', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva', 'Administrador', 'Manager', 'owner', 'Fundador', 'My_queen']
            ],

            // Pages accessible by director and above
            'gestion_de_tiempo' => [
                'file' => 'GSTM.php',
                'roles' => ['Web_master','director', 'presidente', 'operativo', 'junta directiva', 'administrador', 'manager', 'owner', 'fundador', 'my_queen', 'Director', 'Presidente', 'Operativo', 'Junta directiva', 'Administrador', 'Manager', 'owner', 'Fundador', 'My_queen']
            ],

            

            // Pages accessible only by administrators
            'gestion_de_pagas' => [
                'file' => 'GTPS.php',
                'roles' => ['Web_master','administrador', 'manager', 'owner', 'fundador', 'my_queen', 'Administrador', 'Manager', 'owner', 'Fundador', 'My_queen']
            ],
            'gestion_de_notificaciones' => [
                'file' => 'GTNT.php',
                'roles' => ['Web_master','administrador', 'manager', 'owner', 'fundador', 'my_queen', 'Administrador', 'Manager', 'owner', 'Fundador', 'My_queen']
            ],
            'ventas_membresias' => [
                'file' => 'VTM.php',
                'roles' => ['Web_master','administrador', 'manager', 'owner', 'fundador', 'my_queen', 'Administrador', 'Manager', 'owner', 'Fundador', 'My_queen']
            ],
            'ventas_rangos_y_traslados' => [
                'file' => 'VTR.php',
                'roles' => ['Web_master','administrador', 'manager', 'owner', 'fundador', 'my_queen', 'Administrador', 'Manager', 'owner', 'Fundador', 'My_queen']
            ],
        ];


        if (array_key_exists($page, $validPages) && in_array($this->userRango, $validPages[$page]['roles'])) {
            include $validPages[$page]['file'];
        } else {
            $this->renderAccessDenied();
        }
    }

    private function renderAccessDenied()
    {
        $rango = $this->userRango ?? 'Agente';
        echo '<div class="alert alert-danger text-center mt-5">';
        echo '<h4 class="alert-heading">Acceso Denegado</h4>';
        echo '<p>No tienes los permisos necesarios para acceder a esta página o la página no existe.</p>';
        echo '<p>Tu rango actual es: ' . htmlspecialchars($rango) . '</p>';
        echo '<p>Redirigiendo a la página principal...</p>';
        echo '</div>';
        echo '<meta http-equiv="refresh" content="3;url=index.php">';
    }
}

$controller = new UserController();
?>

<body>
    <div class="page-container">
        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <?php
                    if (isset($_GET['q'])) {
                        $controller->handleSearch();
                    } else {
                        $controller->handlePageLoad();
                    }
                    ?>
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

        // Show loader when navigating
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && !link.hasAttribute('target') && link.href.indexOf('#') === -1) {
                const loader = document.getElementById('loader-wrapper');
                loader.style.display = 'flex';
                loader.classList.remove('fade-out');
            }
        });
    </script>
</body>

