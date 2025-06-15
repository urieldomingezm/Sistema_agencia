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
define('PROCESO_VENTAS_RANGOS_PACTH', PRIVATE_PATH . 'procesos/gestion_venta_rangos/');
define('PROCESO_VENTAS_MEMBRESIAS_PACTH', PRIVATE_PATH . 'procesos/gestion_ventas/');
define('PROCESOS_MEJOR_TOP', PRIVATE_PATH . 'procesos/gestion_primeros_lugares/');
define('PROCESOS_REQUERIMIENTOS_PACTH', PRIVATE_PATH . 'procesos/gestion_cumplimientos/');
define('PROCESOS_NOTIFICACIONES_PACTH', PRIVATE_PATH . 'procesos/gestion_notificaciones/');


// Modal Paths
define('MODAL_PATH', PRIVATE_PATH . 'modals/');
define('MODALES_MENU_PATH', PRIVATE_PATH . 'modal/moda_menus_ascender/');
define('MODALES_MENU_PAGA_PATH', PRIVATE_PATH . 'modal/modal_paga/');
define('MODALES_MENU_VENTAS_PATH', PRIVATE_PATH . 'modal/modal_menu_ventas/');
define('GESTION_RENOVAR_VENTA_PATCH', PRIVATE_PATH. 'modal/modal_gestion_ventas/');
define('DAR_ASCENSO_PATCH', PRIVATE_PATH . 'modal/modal_ascensos/');
define('DAR_TIEMPO_PATCH', PRIVATE_PATH . 'modal/modal_gestion_tiempo/');
define('MODAL_GESTION_ASCENSO_PATH', PRIVATE_PATH . 'modal/modal_gestion_ascenso/');
define('MODAL_GESTION_TIEMPO_PATH', PRIVATE_PATH . 'modal/modal_gestion_tiempo/');
define('MODAL_GESTION_USUARIOS_PACH', PRIVATE_PATH . 'modal/modal_gestion_usuarios/');
define('MODAL_GESTION_VENTAS_RANGOS_PACH', PRIVATE_PATH . 'modal/modal_venta_rangos/');
define('MODAL_MODIFICAR_USUARIO_PACH', PRIVATE_PATH . 'modal/modal_modificar_usuarios/');
define('MODAL_AYUDA_TIEMPO_PACH', PRIVATE_PATH . 'modal/modal_ayuda/');


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

// APP
define('TEMPLATES_APP_PATH', PRIVATE_PATH . 'plantilla/');
define('TABS_APP_PATH', PRIVATE_PATH . 'tabs/');
define('APP_SECCIONES', ROOT_PATH . 'usuario/app/');
define('APP_PATH', __DIR__ . '/usuario/app/');

// DASHBOARD
define('DASHBOARD_PATH', PRIVATE_PATH . 'procesos/dashboard/');

// AUDITORIAS 
define('AUDITORIA_ASCENSOS_PATH', PRIVATE_PATH . 'procesos/dashboard/auditorias/auditoria_ascensos/');
define('AUDITORIA_PAGOS_PATH', PRIVATE_PATH . 'procesos/dashboard/auditorias/auditoria_pagos/');
define('AUDITORIA_RANGOS_PATH', PRIVATE_PATH . 'procesos/dashboard/auditorias/auditoria_rangos/');
define('AUDITORIA_REGISTRO_PATH', PRIVATE_PATH . 'procesos/dashboard/auditorias/auditoria_registro/');

// INTERFAZ
define('INTERFAZ_ANUNCIOS_PATH', PRIVATE_PATH . 'procesos/dashboard/interfaz/interfaz_anuncios/');
define('INTERFAZ_HORARIOS_PATH', PRIVATE_PATH . 'procesos/dashboard/interfaz/interfaz_horarios/');
define('INTERFAZ_MEMBRESIAS_PATH', PRIVATE_PATH . 'procesos/dashboard/interfaz/interfaz_membresias/');
define('INTERFAZ_NOTICIAS_PATH', PRIVATE_PATH . 'procesos/dashboard/interfaz/interfaz_noticias/');

// MEMBRESIAS
define('MEMBRESIA_HISTORIAL_PATH', PRIVATE_PATH . 'procesos/dashboard/membresias/membresia_historial/');
define('MEMBRESIA_LISTA_PATH', PRIVATE_PATH . 'procesos/dashboard/membresias/membresia_lista/');
define('MEMBRESIA_VENTAS_PATH', PRIVATE_PATH . 'procesos/dashboard/membresias/membresia_ventas/');
define('MEMBRESIAS_RENOVACIONES_PATH', PRIVATE_PATH . 'procesos/dashboard/membresias/membresias_renovaciones/');

// PAGOS
define('PAGO_LISTA_PATH', PRIVATE_PATH . 'procesos/dashboard/pagos/pago_lista/');
define('PAGO_REGISTRO_PATH', PRIVATE_PATH . 'procesos/dashboard/pagos/pago_registro/');
define('PAGO_TRANSACCIONES_PATH', PRIVATE_PATH . 'procesos/dashboard/pagos/pago_transacciones/');

// USUARIOS
define('USUARIO_LISTA_PATH', PRIVATE_PATH . 'procesos/dashboard/usuarios/usuario_lista/');
define('USUARIO_MODIFICAR_PATH', PRIVATE_PATH . 'procesos/dashboard/usuarios/usuario_modificar/');


?>