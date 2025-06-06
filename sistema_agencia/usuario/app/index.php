<?php
$pageTitle = "Agencia Shein APP - Inicio";
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_APP_PATH . 'header_app.php');
?>

<!-- Contenido principal -->
<ion-content>
    <!-- Aquí iría el contenido dinámico que cambia según la tab seleccionada -->
    <?php 
    // Puedes incluir contenido específico para cada tab aquí
    // Ejemplo: require_once(TABS_APP_PATH . 'contenido_inicio.php');
    ?>
</ion-content>

<?php
// Incluir las tabs al final, ANTES del footer
require_once(TABS_APP_PATH . 'tab_bajos.php');
require_once(TEMPLATES_APP_PATH . 'footer_app.php');
?>