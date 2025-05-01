<?php
session_start();

class Header
{
    private $title;
    private $cssFiles = [];
    private $jsFiles = [];

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function addCssFile($filePath)
    {
        $this->cssFiles[] = $filePath;
    }

    public function addJsFile($filePath)
    {
        $this->jsFiles[] = $filePath;
    }

    public function render()
    {
        echo '<!DOCTYPE html>';
        echo '<html lang="es">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>' . $this->title . '</title>';
        echo '<link rel="icon" type="image/x-icon" href="/public/custom/custom_radio/img/dj.jpg">';

        // Google Analytics
        echo '<script async src="https://www.googletagmanager.com/gtag/js?id=G-GPVYVF599C"></script>';
        echo '<script>';
        echo 'window.dataLayer = window.dataLayer || [];';
        echo 'function gtag(){dataLayer.push(arguments);}';
        echo 'gtag("js", new Date());';
        echo 'gtag("config", "G-GPVYVF599C");';
        echo '</script>';

        // Cargar archivos desde CDN por defecto

        // FONT AWESOME
        echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">';
        
        //DATA TABLE SIMPLE
        echo '<link id="datatable-css" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet">';
       
        // BOOSTRAP
        echo '<link id="bootstrap-css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">';
        echo '<script id="bootstrap-js" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>';
        
        // CHART.JS
        echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
        echo '<link id="chart-css" href="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.css" rel="stylesheet">';
       
        // JQUERY 3.6.0
        echo '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>';
       
        // SWEETALERT 2
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<link id="sweetalert-css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.min.css" rel="stylesheet">';
       
        // BOOSTRAP ICONS
        echo '<link id="icons-css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">';
       
        // JUST VALIDATE
        echo '<script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>';

        foreach ($this->cssFiles as $file) {
            echo '<link href="' . $file . '" rel="stylesheet">';
        }

        foreach ($this->jsFiles as $file) {
            echo '<script src="' . $file . '" type="text/javascript"></script>';
        }

        echo '<script>
            function checkAndLoadCDN(id, fallbackUrl) {
                var element = document.getElementById(id);
                if (!element || element.sheet === null) {
                    console.warn("CDN no disponible, cargando desde local:", fallbackUrl);
                    var newElement;
                    
                    if (id.includes("-js")) {
                        newElement = document.createElement("script");
                        newElement.src = fallbackUrl;
                        newElement.async = false;
                    } else {
                        newElement = document.createElement("link");
                        newElement.rel = "stylesheet";
                        newElement.href = fallbackUrl;
                    }

                    document.head.appendChild(newElement);
                }
            }
            window.onload = function () {
                checkAndLoadCDN("bootstrap-css", "/public/custom/bootstrap/bootstrap.css");
                checkAndLoadCDN("bootstrap-js", "/public/custom/bootstrap/bootstrap.bundle.min.js");
                checkAndLoadCDN("datatable-css", "/public/custom/datatables/style.css");
                checkAndLoadCDN("datatable-js", "/public/custom/datatables/datatables.js");
                checkAndLoadCDN("icons-css", "/public/custom/bootstrap/icons.css");
                checkAndLoadCDN("sweetalert-css", "/public/custom/sweetalert2/sweetalert2.min.css");
                checkAndLoadCDN("chart-css", "/public/custom/chart.js/chart.min.css");
            };
        </script>';

        echo '</head>';
        echo '<body>';
    }
}

$header = new Header('Agencia Habbo Atenas');
// Archivos CSS personalizados (versiones locales)
$header->addCssFile('/public/custom/bootstrap/bootstrap.css');
$header->addCssFile('/public/custom/bootstrap/bootstrap.min.css');
$header->addCssFile('/public/custom/bootstrap/icons.css');

// Archivos de datatable simple CSS y JS personalizados (versiones locales)
$header->addCssFile('/public/custom/simple_datatables/css/style.css');
$header->addJsFile('/public/custom/simple_datatables/js/script.js');

// Archivos de gestion de ascenso CSS y JS personalizados (versiones locales)
$header->addCssFile('/public/custom/custom_gestion_ascensos/css/style.css');
$header->addJsFile('/public/custom/custom_gestion_ascensos/js/script.js');

// Archivos estilos CSS para menus CSS personalizados (versiones locales)
$header->addCssFile('/public/assets/custom_general/custom_menus/style.css');

// Archivos estilos de body home (versiones locales)
$header->addCssFile('/public/assets/custom_general/custom_home/style.css');

// Archivos estilos de tablas (versiones locales)
$header->addCssFile('/public/assets/custom_general/custom_tablas/style.css');

// Archivos de tabla de rangos, misiones y costos CSS personalizados (versiones locales)
// $header->addCssFile('/public/custom/custom_tabla_rangos/css/style.css');
$header->addCssFile('/public/custom/custom/css/style.css');

// Archivos de gestion de tiempos CSS y JS personalizados (versiones locales)
$header->addCssFile('/public/custom/custom_gestion_tiempos/css/style.css');
$header->addJsFile('/public/custom/custom_gestion_tiempos/js/script.js');

// Archivos JS personalizados
$header->addJsFile('/public/custom/custom/js/script.js');

$header->render();
