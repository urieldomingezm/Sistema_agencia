<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_PATH . 'header.php');
?>
<br>
<?php
require_once(MENU_PATH . 'menu_normal.php');
require_once(BODY_HOME_PATH . 'home_inicio.php');
require_once(TEMPLATES_PATH . 'footer.php');

if (isset($_GET['unauthorized'])) {
    echo "<script>
        Swal.fire({
            title: 'Acceso no autorizado',
            text: 'Debes iniciar sesión para acceder a esta sección',
            icon: 'error',
            confirmButtonText: 'Entendido'
        }).then(() => {
            window.location.href = '/';
        });
    </script>";
}

if (isset($_SESSION['login_error'])) {
    echo "<script>
        Swal.fire({
            title: '".$_SESSION['login_error']['title']."',
            text: '".$_SESSION['login_error']['message']."',
            icon: '".$_SESSION['login_error']['icon']."'
        });
    </script>";
    unset($_SESSION['login_error']);
}

if (isset($_SESSION['access_error'])) {
    echo "<script>
        Swal.fire({
            title: '".$_SESSION['access_error']['title']."',
            text: '".$_SESSION['access_error']['message']."',
            icon: '".$_SESSION['access_error']['icon']."'
        });
    </script>";
    unset($_SESSION['access_error']);
}
?>