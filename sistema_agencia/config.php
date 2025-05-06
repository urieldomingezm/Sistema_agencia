<?php

// Rutas principales
define('ROOT_PATH', __DIR__ . '/');
define('PRIVATE_PATH', ROOT_PATH . 'private/');
define('PUBLIC_PATH', ROOT_PATH . 'public/');

// Rutas de plantillas y configuraciones
define('TEMPLATES_PATH', PRIVATE_PATH . 'plantilla/');
define('CONFIG_PATH', PRIVATE_PATH . 'conexion/');

// Rutas para body y contenido principal
define('BODY_HOME_PATH', PRIVATE_PATH . 'plantilla/home/');
define('BODY_DJ_PATH', PRIVATE_PATH . 'radio/');

// Rutas para procesos
define('PROCESOS_LOGIN_PATH', PRIVATE_PATH . 'procesos/login/');
define('VER_PERFIL_PATCH', PRIVATE_PATH . 'procesos/perfil/');
define('GESTION_TIEMPO_PATCH', PRIVATE_PATH . 'procesos/gestion_tiempos/');
define('GESTION_ASCENSOS_PATCH', PRIVATE_PATH . 'procesos/gestion_ascensos/');
define('GESTION_TIEMPOS_PATCH', PRIVATE_PATH . 'procesos/gestion_tiempos/');
define('GESTION_VENTAS_PATCH', PRIVATE_PATH . 'procesos/gestion_ventas/');

// Rutas para gestion de ventas (renovar y vender membresia)
define('GESTION_RENOVAR_VENTA_PATCH', PRIVATE_PATH. 'modal/modal_gestion_ventas/');

// Rutas para modales
define('MODALES_MENU_PATH', PRIVATE_PATH . 'modal/moda_menus_ascender/');
define('MODALES_MENU_PAGA_PATH', PRIVATE_PATH . 'modal/modal_menu_paga/');
define('MODALES_MENU_VENTAS_PATH', PRIVATE_PATH . 'modal/modal_menu_ventas/');
define('MODAL_PATH', PRIVATE_PATH . 'modals/');
define('DAR_ASCENSO_PATCH', PRIVATE_PATH . 'modal/modal_ascensos/');
define('DAR_TIEMPO_PATCH', PRIVATE_PATH . 'modal/modal_gestion_tiempo/');
define('MODAL_GESTION_ASCENSO_PATH', PRIVATE_PATH . 'modal/modal_gestion_ascenso/');
define('MODAL_GESTION_TIEMPO_PATH', PRIVATE_PATH . 'modal/modal_gestion_tiempo/');

// Rutas para menús
define('MENU_PATH', PRIVATE_PATH . 'menus/');

// Rutas para rangos de usuarios
define('RANGOS_PATH', ROOT_PATH . 'usuario/rangos/');
define('VER_RANGOS_PATH', ROOT_PATH . 'usuario/');

// Rutas para anti-saltos urls
define('ANTI_SALTOS_PATH', PRIVATE_PATH . 'procesos/seguridad/');

// Rutas para assets personalizados
define('CUSTOM_LOGIN_REGISTRO_PATH', PUBLIC_PATH . 'assets/custom_general/custom_login_registro/');
define('CUSTOM_LOGIN_REGISTRO_CSS_PATH', PUBLIC_PATH . 'assets/custom_general/custom_login_registro/css/');
define('CUSTOM_HOME_PATH', PUBLIC_PATH . 'assets/custom_general/custom_home/');
define('CUSTOM_HOME_CSS_PATH', PUBLIC_PATH . 'assets/custom_general/custom_home/css/');
define('CUSTOM_HOME_JS_PATH', PUBLIC_PATH . 'assets/custom_general/custom_home/js/');
define('CUSTOM_RADIO_CSS_PATH', PUBLIC_PATH . 'assets/custom_general/custom_radio/');
?>