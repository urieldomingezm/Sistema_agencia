<?php
$pageTitle = "Agencia Shein APP";
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_APP_PATH . 'header_app.php');

class AppController {
    private $userRango;
    private $validPages = [
        'inicio' => ['path' => APP_SECCIONES, 'file' => 'home_inicio.php'],
        'perfil' => ['path' => APP_SECCIONES, 'file' => 'perfil.php'],
        'cerrar_session' => ['path' => APP_SECCIONES, 'file' => 'cerrar_session.php']
    ];

    public function __construct() {
        $this->loadUserRank();
        $this->handlePageLoad();
    }

    private function loadUserRank() {
        // Implementación similar a UserController
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

new AppController();

require_once(TABS_APP_PATH . 'tab_bajos.php');
require_once(TEMPLATES_APP_PATH . 'footer_app.php');
?>
