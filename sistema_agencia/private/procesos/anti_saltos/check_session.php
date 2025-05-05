<?php
session_start();

// Verificar si es desarrollador
$isDeveloper = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'developer';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // Alerta para usuarios no logueados
    $_SESSION['login_error'] = [
        'title' => 'Acceso restringido',
        'message' => 'Se informará al administrador de la página que está intentando acceder a una sección restringida. Esto podría resultar en el bloqueo de su cuenta. Gracias por su comprensión.',
        'icon' => 'error'
    ];
    header('Location: /index.php');
    exit;
} elseif (!$isDeveloper) {
    // Alerta para usuarios normales que intentan acceder a áreas privadas
    $_SESSION['access_error'] = [
        'title' => 'Área restringida',
        'message' => 'Esta área es solo para desarrollo. No tienes permisos para acceder.',
        'icon' => 'warning'
    ];
    header('Location: /usuario/index.php');
    exit;
}
?>

<?php
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    $cnd = [
        'success' => false,
        'message' => 'Debes iniciar sesión para acceder a esta página',
        'redirect' => '/index.php',
        'icon' => 'error',
        'title' => 'Error',
        'showConfirmButton' => true,
        'timer' => 3000,
        'timerProgressBar' => true,
        'allowOutsideClick' => false
    ];
    
    header('Content-Type: application/json');
    echo json_encode($cnd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}
?>