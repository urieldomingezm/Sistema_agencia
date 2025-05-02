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
        echo '<link rel="icon" type="image/x-icon" href="/public/assets/custom_general/custom_radio/img/dj.jpg">';

        // Google Analytics
        echo '<script async src="https://www.googletagmanager.com/gtag/js?id=G-32NSVX1ZQD"></script>';
        echo '<script>';
        echo 'window.dataLayer = window.dataLayer || [];';
        echo 'function gtag(){dataLayer.push(arguments);}';
        echo 'gtag("js", new Date());';
        echo 'gtag("config", "G-32NSVX1ZQD");';
        echo '</script>';

        // reCAPTCHA v3
        echo '<script src="https://www.google.com/recaptcha/api.js?render=6LfUGiwrAAAAAPDhTJ-D6pxFBueqlrs82xS_dVf0"></script>';
        echo '<script>';
        echo 'function executeRecaptcha(action) {';
        echo '    grecaptcha.ready(function() {';
        echo '        grecaptcha.execute("6LfUGiwrAAAAAPDhTJ-D6pxFBueqlrs82xS_dVf0", {action: action})';
        echo '        .then(function(token) {';
        echo '            document.getElementById("g-recaptcha-response").value = token;';
        echo '        });';
        echo '    });';
        echo '}';
        echo '</script>';

        // Cargar archivos desde CDN por defecto
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
                checkAndLoadCDN("bootstrap-css", "/public/assets/framework/bootstrap/bootstrap.css");
                checkAndLoadCDN("bootstrap-js", "/public/assets/framework/bootstrap/bootstrap.bundle.min.js");
                checkAndLoadCDN("datatable-css", "/public/assets/framework/data_simple/style.css");
                checkAndLoadCDN("datatable-js", "/public/assets/framework/data_simple/script.js");
                checkAndLoadCDN("icons-css", "/public/assets/framework/bootstrap/icons/bootstrap-icons.css");
            };
        </script>';

        echo '</head>';
        echo '<body>';
        echo '</div>';
        echo '</html>';
    }
}

// Corregir las rutas de los archivos locales
$header = new Header('Agencia Shein Habbo');
$header->addCssFile('/public/assets/framework/bootstrap/bootstrap.css');
$header->addCssFile('/public/assets/framework/bootstrap/bootstrap.min.css');
$header->addCssFile('/public/assets/framework/bootstrap/icons.css');

// Corregir la ruta de datatable
$header->addCssFile('/public/assets/framework/data_simple/style.css');
$header->addJsFile('/public/assets/framework/data_simple/script.js');

// Archivos estilos CSS para menus CSS personalizados (versiones locales)
$header->addCssFile('/public/assets/custom_general/custom_menus/style.css');

// Archivos estilos de body home (versiones locales)
$header->addCssFile('/public/assets/custom_general/custom_home/style.css');

// Archivos estilos de tablas (versiones locales)
$header->addCssFile('/public/assets/custom_general/custom_tablas/style.css');

// Archivos estilos para perfiles (versiones locales)
$header->addCssFile('/public/assets/custom_general/custom_perfil/style.css');

// Archivos de tabla de rangos, misiones y costos CSS personalizados (versiones locales)
$header->addCssFile('/public/assets/custom_general/custom/css/style.css');

// Archivos JS personalizados
$header->addJsFile('/public/assets/custom_general/custom/js/script.js');

$header->render();
