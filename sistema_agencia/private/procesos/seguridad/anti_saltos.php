<?php
session_start();

function mostrarAlerta($titulo, $mensaje, $tipo = 'error')
{
    $_SESSION['swal'] = [
        'titulo' => $titulo,
        'mensaje' => $mensaje,
        'tipo' => $tipo
    ];
}

function verificarSesion()
{
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
        mostrarAlerta('Acceso no autorizado', 'Debes iniciar sesión para acceder a esta sección');
        header('Location: /index.php');
        exit;
    }
}

function bloquearAcceso($ruta)
{
    $rutasBloqueadas = ['/private/', '/public/', '/base-datos/'];

    if (in_array($ruta, $rutasBloqueadas)) {
        mostrarAlerta('Acceso restringido', 'No tienes permiso para acceder a esta ruta');
        header('Location: /index.php');
        exit;
    }
}

$rutaActual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Verificar sesión para rutas de usuario
if (strpos($rutaActual, '/usuario/') === 0 || 
    strpos($rutaActual, '/usuario/administrativo/') === 0 ||
    strpos($rutaActual, '/usuario/app/') === 0) {
    verificarSesion();
}

// Bloquear acceso a rutas restringidas
bloquearAcceso($rutaActual);
