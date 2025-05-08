<?php

// Base Paths
define('ROOT_PATH', __DIR__ . '/');
define('PRIVATE_PATH', ROOT_PATH . 'private/');
define('PUBLIC_PATH', ROOT_PATH . 'public/');

// Template and Configuration Paths
define('TEMPLATES_PATH', PRIVATE_PATH . 'plantilla/');
define('CONFIG_PATH', PRIVATE_PATH . 'conexion/');
define('BODY_HOME_PATH', PRIVATE_PATH . 'plantilla/home/');
define('BODY_DJ_PATH', PRIVATE_PATH . 'radio/');

// Process Paths
define('ANTI_SALTOS_PATH', PRIVATE_PATH . 'procesos/seguridad/');
define('PROCESOS_LOGIN_PATH', PRIVATE_PATH . 'procesos/login/');
define('VER_PERFIL_PATCH', PRIVATE_PATH . 'procesos/perfil/');

// Management Process Paths
define('GESTION_ASCENSOS_PATCH', PRIVATE_PATH . 'procesos/gestion_ascensos/');
define('GESTION_TIEMPO_PATCH', PRIVATE_PATH . 'procesos/gestion_tiempos/');
define('GESTION_TIEMPOS_PATCH', PRIVATE_PATH . 'procesos/gestion_tiempos/');
define('GESTION_VENTAS_PATCH', PRIVATE_PATH . 'procesos/gestion_ventas/');
define('GESTION_PAGAS_PATCH', PRIVATE_PATH . 'procesos/gestion_pagas/');
define('PROCESO_CAMBIAR_PACTH', PRIVATE_PATH . 'procesos/gestion_usuarios/');

// Modal Paths
define('MODAL_PATH', PRIVATE_PATH . 'modals/');
define('MODALES_MENU_PATH', PRIVATE_PATH . 'modal/moda_menus_ascender/');
define('MODALES_MENU_PAGA_PATH', PRIVATE_PATH . 'modal/modal_menu_paga/');
define('MODALES_MENU_VENTAS_PATH', PRIVATE_PATH . 'modal/modal_menu_ventas/');
define('GESTION_RENOVAR_VENTA_PATCH', PRIVATE_PATH. 'modal/modal_gestion_ventas/');
define('DAR_ASCENSO_PATCH', PRIVATE_PATH . 'modal/modal_ascensos/');
define('DAR_TIEMPO_PATCH', PRIVATE_PATH . 'modal/modal_gestion_tiempo/');
define('MODAL_GESTION_ASCENSO_PATH', PRIVATE_PATH . 'modal/modal_gestion_ascenso/');
define('MODAL_GESTION_TIEMPO_PATH', PRIVATE_PATH . 'modal/modal_gestion_tiempo/');
define('MODAL_GESTION_USUARIOS_PACH', PRIVATE_PATH . 'modal/modal_gestion_usuarios/');

// Menu and User Rank Paths
define('MENU_PATH', PRIVATE_PATH . 'menus/');
define('RANGOS_PATH', ROOT_PATH . 'usuario/rangos/');
define('VER_RANGOS_PATH', ROOT_PATH . 'usuario/');

// Asset Paths
define('CUSTOM_LOGIN_REGISTRO_PATH', PUBLIC_PATH . 'assets/custom_general/custom_login_registro/');
define('CUSTOM_LOGIN_REGISTRO_CSS_PATH', PUBLIC_PATH . 'assets/custom_general/custom_login_registro/css/');
define('CUSTOM_HOME_PATH', PUBLIC_PATH . 'assets/custom_general/custom_home/');
define('CUSTOM_HOME_CSS_PATH', PUBLIC_PATH . 'assets/custom_general/custom_home/css/');
define('CUSTOM_HOME_JS_PATH', PUBLIC_PATH . 'assets/custom_general/custom_home/js/');
define('CUSTOM_RADIO_CSS_PATH', PUBLIC_PATH . 'assets/custom_general/custom_radio/');
?>