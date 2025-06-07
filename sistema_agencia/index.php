<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_PATH . 'header.php');

// Mostrar alertas SweetAlert2 si existen
if (isset($_SESSION['swal'])) {
    echo "<script>
    Swal.fire({
        title: '{$_SESSION['swal']['titulo']}',
        text: '{$_SESSION['swal']['mensaje']}',
        icon: '{$_SESSION['swal']['tipo']}',
        confirmButtonText: 'Entendido'
    });
    </script>";
    unset($_SESSION['swal']);
}
?>
<br>
<?php
require_once(MENU_PATH . 'menu_normal.php');

// Detectar si es app o escritorio
$userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
$isApp = strpos($userAgent, 'app') !== false || strpos($userAgent, 'mobile') !== false;

if ($isApp) {
    require_once(BODY_HOME_PATH . 'home_inicio_app.php');
} else {
    require_once(BODY_HOME_PATH . 'home_inicio.php');
}

require_once(TEMPLATES_PATH . 'footer.php');
?>