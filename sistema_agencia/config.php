<?php

define('ROOT_PATH', __DIR__ . '/');


// Rutas a carpetas privadas
define('PRIVATE_PATH', ROOT_PATH . 'private/');
define('TEMPLATES_PATH', PRIVATE_PATH . 'plantilla/'); 
define('CONFIG_PATH', PRIVATE_PATH . 'conexion/'); 

// Rutas para body de inicio, usuarios, etc
define('BODY_HOME_PATH', PRIVATE_PATH . 'plantilla/home/'); 
define('BODY_DJ_PATH', PRIVATE_PATH . 'radio/'); 

// Rutas para procesos de login, registros, etc
define('PROCESOS_LOGIN_PATH', PRIVATE_PATH . 'config/procesos/login_registro/'); 

// Rutas para modales de ascender y tomar tiempo usando menus
define('MODALES_MENU_PATH', PRIVATE_PATH . 'modal/moda_menus_ascender/');
// Rutas para autenticacion de usuario
define('PROCESO_ATHUR_PATH', PRIVATE_PATH . 'config/procesos/autenticacion/');

// Rutas para modales de paga
define('MODALES_MENU_PAGA_PATH', PRIVATE_PATH . 'modal/modal_menu_paga/');

// Rutas para modales de venta
define('MODALES_MENU_VENTAS_PATH', PRIVATE_PATH . 'modal/modal_menu_ventas/');

// Rutas de configuración privadas
define('MENU_PATH', PRIVATE_PATH . 'menus/');     
define('MODAL_GESTION_TIME_PATH', PRIVATE_PATH . 'modal/modal_gestion_tiempo/'); 
define('MODAL_GESTION_TIME_ADMIN_PATH', PRIVATE_PATH . 'modal/modal_gestion_time_admin/');      
define('SCRIPTS_PATH', PRIVATE_PATH . 'scripts/');     
define('SUBSCRIPTIONS_PATH', PRIVATE_PATH . 'subscriptions/');      
define('MODAL_PATH', PRIVATE_PATH . 'modals/');   

// Rutas para proceso de gestion de tiempo
define('GESTION_TIEMPO_PATCH', PRIVATE_PATH . 'procesos/gestion_tiempos/');

// Rutas para procesos
define('VER_PERFIL_PATCH', PRIVATE_PATH . 'procesos/perfil/');

// Rutas a carpetas públicas como CSS, JS, IMG
define('PUBLIC_PATH', ROOT_PATH . 'public/');

define('CUSTOM_LOGIN_REGISTRO_PATH', PUBLIC_PATH . 'assets/custom_general/custom_login_registro/');
define('CUSTOM_LOGIN_REGISTRO_CSS_PATH', PUBLIC_PATH . 'assets/custom_general/custom_login_registro/css/');
define('CUSTOM_HOME_PATH', PUBLIC_PATH . 'assets/custom_general/custom_home/');
define('CUSTOM_HOME_CSS_PATH', PUBLIC_PATH . 'assets/custom_general/custom_home/css/');
define('CUSTOM_HOME_JS_PATH', PUBLIC_PATH . 'assets/custom_general/custom_home/js/');
define('CUSTOM_RADIO_CSS_PATH', PUBLIC_PATH . 'assets/custom_general/custom_radio/');

// Ruta de carpeta para modales de gestion de ascenso
define('MODAL_GESTION_ASCENSO_PATH', PRIVATE_PATH . 'modal/modal_gestion_ascenso/'); 
// Ruta de carpeta para modales de gestion de tiempo
define('MODAL_GESTION_TIEMPO_PATH', PRIVATE_PATH . 'modal/modal_gestion_tiempo/'); 
?>