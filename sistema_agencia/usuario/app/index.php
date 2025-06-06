<?php
$pageTitle = "Agencia Shein APP";
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_APP_PATH . 'header_app.php');

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

    public function loadContent()
    {
        $page = $_GET['page'] ?? 'inicio';

        if (array_key_exists($page, $this->validPages)) {
            $pageConfig = $this->validPages[$page];

            if ($pageConfig['roles'][0] === 'all') {
                if ($page === 'perfil') {
                    return $pageConfig['file']; // Ahora usará la ruta relativa
                }
                return BIENVENIDA_APP_PATH . $pageConfig['file'];
            }
        }

        return BIENVENIDA_APP_PATH . 'home_inicio.php';
    }
}

$controller = new AppController();
$contentFile = $controller->loadContent();
?>

<div class="page-content">
    <div class="content-block">
        <?php require_once($contentFile); ?>
    </div>
</div>

<?php
require_once(TABS_APP_PATH . 'tab_bajos.php');
require_once(TEMPLATES_APP_PATH . 'footer_app.php');
?>