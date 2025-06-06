<?php
$pageTitle = "Agencia Shein APP";
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_APP_PATH . 'header_app.php');
?>

<ion-content>
    <?php
    require_once(BIENVENIDA_APP_PATH . 'home_inicio.php');
    ?>
</ion-content>

<?php
// Incluir las tabs al final, ANTES del footer
require_once(TABS_APP_PATH . 'tab_bajos.php');
require_once(TEMPLATES_APP_PATH . 'footer_app.php');
?>