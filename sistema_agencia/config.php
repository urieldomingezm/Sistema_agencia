<?php

class PathConfig {
    private static $instance = null;
    private $paths = [];

    private function __construct() {
        // Base Paths
        $this->paths['ROOT_PATH'] = __DIR__ . '/';
        $this->paths['PRIVATE_PATH'] = $this->paths['ROOT_PATH'] . 'private/';
        $this->paths['PUBLIC_PATH'] = $this->paths['ROOT_PATH'] . 'public/';

        // Template and Configuration Paths
        $this->paths['TEMPLATES_PATH'] = $this->paths['PRIVATE_PATH'] . 'plantilla/';
        $this->paths['CONFIG_PATH'] = $this->paths['PRIVATE_PATH'] . 'conexion/';
        $this->paths['BODY_HOME_PATH'] = $this->paths['PRIVATE_PATH'] . 'plantilla/home/';
        $this->paths['BODY_DJ_PATH'] = $this->paths['PRIVATE_PATH'] . 'radio/';

        // Process Paths
        $this->paths['ANTI_SALTOS_PATH'] = $this->paths['PRIVATE_PATH'] . 'procesos/seguridad/';
        $this->paths['PROCESOS_LOGIN_PATH'] = $this->paths['PRIVATE_PATH'] . 'procesos/login/';
        $this->paths['VER_PERFIL_PATCH'] = $this->paths['PRIVATE_PATH'] . 'procesos/perfil/';

        // Management Process Paths
        $this->paths['GESTION_ASCENSOS_PATCH'] = $this->paths['PRIVATE_PATH'] . 'procesos/gestion_ascensos/';
        $this->paths['GESTION_TIEMPO_PATCH'] = $this->paths['PRIVATE_PATH'] . 'procesos/gestion_tiempos/';
        $this->paths['GESTION_TIEMPOS_PATCH'] = $this->paths['PRIVATE_PATH'] . 'procesos/gestion_tiempos/';
        $this->paths['GESTION_VENTAS_PATCH'] = $this->paths['PRIVATE_PATH'] . 'procesos/gestion_ventas/';
        $this->paths['PROCESO_CAMBIAR_PACTH'] = $this->paths['PRIVATE_PATH'] . 'procesos/gestion_usuarios/';

        // Modal Paths
        $this->paths['MODAL_PATH'] = $this->paths['PRIVATE_PATH'] . 'modals/';
        $this->paths['MODALES_MENU_PATH'] = $this->paths['PRIVATE_PATH'] . 'modal/moda_menus_ascender/';
        $this->paths['MODALES_MENU_PAGA_PATH'] = $this->paths['PRIVATE_PATH'] . 'modal/modal_menu_paga/';
        $this->paths['MODALES_MENU_VENTAS_PATH'] = $this->paths['PRIVATE_PATH'] . 'modal/modal_menu_ventas/';
        $this->paths['GESTION_RENOVAR_VENTA_PATCH'] = $this->paths['PRIVATE_PATH'] . 'modal/modal_gestion_ventas/';
        $this->paths['DAR_ASCENSO_PATCH'] = $this->paths['PRIVATE_PATH'] . 'modal/modal_ascensos/';
        $this->paths['DAR_TIEMPO_PATCH'] = $this->paths['PRIVATE_PATH'] . 'modal/modal_gestion_tiempo/';
        $this->paths['MODAL_GESTION_ASCENSO_PATH'] = $this->paths['PRIVATE_PATH'] . 'modal/modal_gestion_ascenso/';
        $this->paths['MODAL_GESTION_TIEMPO_PATH'] = $this->paths['PRIVATE_PATH'] . 'modal/modal_gestion_tiempo/';
        $this->paths['MODAL_GESTION_USUARIOS_PACH'] = $this->paths['PRIVATE_PATH'] . 'modal/modal_gestion_usuarios/';

        // Menu and User Rank Paths
        $this->paths['MENU_PATH'] = $this->paths['PRIVATE_PATH'] . 'menus/';
        $this->paths['RANGOS_PATH'] = $this->paths['ROOT_PATH'] . 'usuario/rangos/';
        $this->paths['VER_RANGOS_PATH'] = $this->paths['ROOT_PATH'] . 'usuario/';

        // Asset Paths
        $this->paths['CUSTOM_LOGIN_REGISTRO_PATH'] = $this->paths['PUBLIC_PATH'] . 'assets/custom_general/custom_login_registro/';
        $this->paths['CUSTOM_LOGIN_REGISTRO_CSS_PATH'] = $this->paths['PUBLIC_PATH'] . 'assets/custom_general/custom_login_registro/css/';
        $this->paths['CUSTOM_HOME_PATH'] = $this->paths['PUBLIC_PATH'] . 'assets/custom_general/custom_home/';
        $this->paths['CUSTOM_HOME_CSS_PATH'] = $this->paths['PUBLIC_PATH'] . 'assets/custom_general/custom_home/css/';
        $this->paths['CUSTOM_HOME_JS_PATH'] = $this->paths['PUBLIC_PATH'] . 'assets/custom_general/custom_home/js/';
        $this->paths['CUSTOM_RADIO_CSS_PATH'] = $this->paths['PUBLIC_PATH'] . 'assets/custom_general/custom_radio/';
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPath($key) {
        return isset($this->paths[$key]) ? $this->paths[$key] : null;
    }

    public function getAllPaths() {
        return $this->paths;
    }
}

// Initialize singleton and define constants for backward compatibility
$pathConfig = PathConfig::getInstance();
foreach ($pathConfig->getAllPaths() as $key => $value) {
    if (!defined($key)) {
        define($key, $value);
    }
}
?>