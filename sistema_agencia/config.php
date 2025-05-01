<?php

// Ruta raíz
define('ROOT_PATH', __DIR__ . '/');

// Rutas principales
define('PRIVATE_PATH', ROOT_PATH . 'private/');
define('PUBLIC_PATH', ROOT_PATH . 'public/');
define('USUARIO_PATH', ROOT_PATH . 'usuario/');
define('ADMIN_PATH', ROOT_PATH . 'admin/');

// Rutas de configuración y plantillas
define('TEMPLATES_PATH', PRIVATE_PATH . 'plantilla/');
define('CONFIG_PATH', PRIVATE_PATH . 'config/');
define('SCRIPTS_PATH', PRIVATE_PATH . 'scripts/');

// Rutas de autenticación y procesos
define('AUTH_DJ_PATH', PRIVATE_PATH . 'config/procesos/autenticacion/');
define('PROCESO_ATHUR_PATH', PRIVATE_PATH . 'config/procesos/autenticacion/');
define('PROCESOS_LOGIN_PATH', PRIVATE_PATH . 'config/procesos/login_registro/');

// Rutas de modelos y POO
define('POO_PATH', PRIVATE_PATH . 'poo/login/');
define('MODELOS_PATH', PRIVATE_PATH . 'modelos/login/');
define('POO_HOME_PATH', PRIVATE_PATH . 'modelos/home/');

// Rutas de contenido principal
define('BODY_HOME_PATH', PRIVATE_PATH . 'config/procesos/home/');
define('BODY_DJ_PATH', PRIVATE_PATH . 'config/procesos/dj/');
define('MENU_PATH', PRIVATE_PATH . 'menus/');
define('SUBSCRIPTIONS_PATH', PRIVATE_PATH . 'subscriptions/');

// Rutas de modales
define('MODAL_PATH', PRIVATE_PATH . 'modals/');
define('MODALES_MENU_PATH', PRIVATE_PATH . 'modal/moda_menus_ascender/');
define('MODALES_MENU_PAGA_PATH', PRIVATE_PATH . 'modal/modal_menu_paga/');
define('MODALES_MENU_VENTAS_PATH', PRIVATE_PATH . 'modal/modal_menu_ventas/');
define('MODAL_GESTION_TIME_PATH', PRIVATE_PATH . 'modal/modal_gestion_tiempo/');
define('MODAL_GESTION_TIME_ADMIN_PATH', PRIVATE_PATH . 'modal/modal_gestion_time_admin/');
define('MODAL_GESTION_ASCENSO_PATH', PRIVATE_PATH . 'modal/modal_gestion_ascenso/');
define('MODAL_GESTION_TIEMPO_PATH', PRIVATE_PATH . 'modal/modal_gestion_tiempo/');

// Rutas públicas de recursos
define('MUSIC_PATH', PUBLIC_PATH . 'music/');
define('CUSTOM_LOGIN_REGISTRO_PATH', PUBLIC_PATH . 'custom/custom_login_registro/');
define('CUSTOM_LOGIN_REGISTRO_CSS_PATH', PUBLIC_PATH . 'custom/custom_login_registro/css/');
define('CUSTOM_HOME_PATH', PUBLIC_PATH . 'custom/custom_home/');
define('CUSTOM_HOME_CSS_PATH', PUBLIC_PATH . 'custom/custom_home/css/');
define('CUSTOM_HOME_JS_PATH', PUBLIC_PATH . 'custom/custom_home/js/');
define('CUSTOM_RADIO_PATH', PUBLIC_PATH . 'custom/custom_radio/');
define('CUSTOM_RADIO_CSS_PATH', PUBLIC_PATH . 'custom/custom_radio/css/');

// Rutas de usuario
define('MI_CUENTA_PATH', USUARIO_PATH . 'mi_cuenta/');
define('ACCIONES_PATH', USUARIO_PATH . 'acciones/');

// Rutas de administración
define('MI_CUENTA_ADMIN_PATH', ADMIN_PATH . 'mi_cuenta/');
define('DASHBOARD_PATH', ADMIN_PATH . 'dashboard/');
define('ACCIONES_ADMIN_PATH', ADMIN_PATH . 'acciones/');
?>