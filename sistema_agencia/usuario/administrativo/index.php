<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_PATH . 'header.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

class AdminController
{
    private $conn;
    private $userRango;

    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
            echo "<script>window.location.href = '/login.php';</script>";
            exit;
        }

        require_once(CONFIG_PATH . 'bd.php');
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->loadUserRank();

        // Verificar que el usuario tenga un rango permitido (solo Web_master, Fundador, Owner)
        $allowedRoles = ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador'];
        
        if (!in_array($this->userRango, $allowedRoles)) {
            // Redirigir a la interfaz de usuario normal para rangos no permitidos
            header('Location: /usuario/index.php');
            exit;
        }

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
            error_log("Error al obtener rango en AdminController: " . $e->getMessage());
            $this->userRango = 'Agente';
            $_SESSION['rango'] = $this->userRango;
        }
    }

    private function loadMenu()
    {
        // Para la interfaz administrativa, siempre cargamos el menu_rango_web.php
        require_once(MENU_PATH . 'menu_rango_web.php');
    }

    public function handleSearch()
    {
        if (!isset($_GET['q']) || empty($_GET['q'])) {
            return;
        }

        $query = strtolower(trim($_GET['q']));
        $pages = [
            // Páginas específicas para la interfaz administrativa
            'gestion_de_usuarios' => 'gestion_usuarios',
            'gestion_de_pagas' => 'gestion_de_pagas',
            'gestion_de_notificaciones' => 'gestion_de_notificaciones',
            'ventas_membresias' => 'ventas_membresias',
            'ventas_rangos_y_traslados' => 'ventas_rangos_y_traslados',
            'gestion_de_tiempo' => 'gestion_de_tiempo',
            'gestion_ascenso' => 'gestion_ascenso',
            'ver_perfil' => 'ver_perfil',
            'cerrar_session' => 'cerrar_session',
            'requisitos_paga' => 'requisitos_paga',
            'ver_mis_tiempos' => 'ver_mis_tiempos',
            'ver_mis_ascensos' => 'ver_mis_ascensos',
            'inicio' => 'inicio'
        ];

        $results = [];
        foreach ($pages as $fileKey => $title) {
            // Construir la ruta completa del archivo PHP
            $filePath = '';
            if (in_array($fileKey, ['gestion_de_usuarios', 'gestion_de_pagas', 'gestion_de_notificaciones', 'ventas_membresias', 'ventas_rangos_y_traslados', 'gestion_de_tiempo', 'gestion_ascenso'])) {
                $filePath = PROCESOS_PATH . str_replace('_', '/', $fileKey) . '.php';
            } else if (in_array($fileKey, ['ver_perfil', 'cerrar_session', 'requisitos_paga', 'ver_mis_tiempos', 'ver_mis_ascensos', 'inicio'])) {
                $filePath = USER_PATH . str_replace('_', '/', $fileKey) . '.php';
            }
            
            if (file_exists($filePath)) {
                $content = file_get_contents($filePath);
                preg_match('/<meta name="keywords" content="([^"]+)"/', $content, $matches);

                if (!empty($matches[1])) {
                    $keywords = explode(',', strtolower($matches[1]));
                    foreach ($keywords as $keyword) {
                        similar_text($query, $keyword, $percentage);
                        if ($percentage > 60 || strpos($keyword, $query) !== false) {
                            $results[] = ['title' => $title, 'url' => 'index.php?page=' . urlencode($fileKey)];
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
            echo '<h5 class="mb-0">' . ucfirst(str_replace('_', ' ', $result['title'])) . '</h5>';
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
            // Cargar el dashboard de inicio por defecto
            $this->loadDashboard();
            return;
        }

        $page = $_GET['page'];
        $validPages = [
            'inicio' => [
                'file' => USER_PATH . 'USR.php',
                'roles' => ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador']
            ],
            'ver_perfil' => [
                'file' => USER_PATH . 'PRUS.php',
                'roles' => ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador']
            ],
            'cerrar_session' => [
                'file' => USER_PATH . 'CRSS.php',
                'roles' => ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador']
            ],
            'requisitos_paga' => [
                'file' => USER_PATH . 'RQPG.php',
                'roles' => ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador']
            ],
            'gestion_ascenso' => [
                'file' => USER_PATH . 'GSAS.php',
                'roles' => ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador']
            ],
            'ver_mis_tiempos' => [
                'file' => USER_PATH . 'HIST.php',
                'roles' => ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador']
            ],
            'ver_mis_ascensos' => [
                'file' => USER_PATH . 'HISA.php',
                'roles' => ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador']
            ],
            'gestion_de_tiempo' => [
                'file' => USER_PATH . 'GSTM.php',
                'roles' => ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador']
            ],
            'gestion_de_pagas' => [
                'file' => USER_PATH . 'GTPS.php',
                'roles' => ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador']
            ],
            'gestion_de_notificaciones' => [
                'file' => USER_PATH . 'GTNT.php',
                'roles' => ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador']
            ],
            'ventas_membresias' => [
                'file' => USER_PATH . 'VTM.php',
                'roles' => ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador']
            ],
            'ventas_rangos_y_traslados' => [
                'file' => USER_PATH . 'VTR.php',
                'roles' => ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador']
            ],
            'gestion_de_usuarios' => [
                'file' => PROCESOS_PATH . 'gestion_usuarios/gestion_usuarios.php',
                'roles' => ['Web_master', 'Owner', 'Fundador', 'web_master', 'owner', 'fundador']
            ],
        ];

        if (array_key_exists($page, $validPages) && in_array($this->userRango, $validPages[$page]['roles'])) {
            include $validPages[$page]['file'];
        } else {
            $this->renderAccessDenied();
        }
    }

    private function loadDashboard()
    {
        // Cargar el dashboard de inicio (USR.php)
        include USER_PATH . 'USR.php';
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
        echo '<meta http-equiv="refresh" content="3;url=/usuario/administrativo/index.php">';
    }
}

$controller = new AdminController();

if (isset($_GET['q'])) {
    $controller->handleSearch();
} else {
    $controller->handlePageLoad();
}

require_once(TEMPLATES_PATH . 'footer.php');
?>

<script>
    // Script para manejar la selección de interfaz
    function selectInterface(interfaceType) {
        fetch('/set_interface.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'interface=' + interfaceType
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (interfaceType === 'admin') {
                        window.location.href = '/usuario/administrativo/index.php';
                    } else {
                        window.location.href = '/usuario/index.php';
                    }
                }
            })
            .catch(error => console.error('Error:', error));
    }

    $(document).ready(function() {
        // Lógica para resetear modales
        $('#modificar_usuario, #dar_ascenso').on('hidden.bs.modal', function() {
            $(this).find('form').trigger('reset');

            if ($(this).find('.step').length > 0) {
                $(this).find('.step').addClass('d-none');
                $(this).find('.step:first').removeClass('d-none');
            }

            $(this).find('.progress-bar').css('width', '0%');
            $(this).find('button[id$="Btn"]').prop('disabled', false);
            $(this).find('button[id="submitBtn"]').addClass('d-none');
            $(this).find('button[id="nextBtn"]').removeClass('d-none');
            $(this).find('#resultadoBusqueda').html('');

            if (typeof currentStep !== 'undefined') {
                currentStep = 1;
            }

            setTimeout(function() {
                $(document).trigger('modal_reset');
            }, 100);
        });

        $('.modal').on('show.bs.modal', function(e) {
            var currentModalId = $(this).attr('id');

            $('.modal').not(this).each(function() {
                if ($(this).hasClass('show')) {
                    var modalInstance = bootstrap.Modal.getInstance(this);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
            });

            window.activeModal = currentModalId;
        });

        $('[data-bs-toggle="modal"]').on('click', function(e) {
            var targetModal = $(this).data('bs-target').replace('#', '');

            if (window.activeModal && window.activeModal !== targetModal) {
                var modalElement = document.getElementById(window.activeModal);
                if (modalElement) {
                    var modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
            }
        });
    });
</script>