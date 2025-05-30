<?php
session_start();

class Header
{
    private $title;
    private $cssFiles = [];
    private $jsFiles = [];
    private $preloadLinks = []; // Añadir propiedad para enlaces de precarga

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

    // Añadir método para agregar enlaces de precarga
    public function addPreloadLink($href, $as, $type = null)
    {
        $link = '<link rel="preload" href="' . $href . '" as="' . $as . '"';
        if ($type) {
            $link .= ' type="' . $type . '"';
        }
        $link .= '>';
        $this->preloadLinks[] = $link;
    }

    public function render()
    {
        echo '<!DOCTYPE html>';
        echo '<html lang="es">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>' . $this->title . '</title>';
        echo '<link rel="icon" type="image/x-icon" href="/public/assets/img/icono.png">';

        // Meta tags para SEO
        echo '<meta name="description" content="Agencia Shein es una comunidad vibrante en Habbo Hotel que se dedica a crear experiencias únicas para nuestros usuarios. Proporcionamos un espacio seguro y divertido donde los usuarios pueden interactuar, participar en eventos emocionantes y desarrollar sus habilidades dentro del juego.">';
        echo '<meta name="keywords" content="Agencia Shein, Habbo, comunidad, eventos, Habbo Hotel, juegos, diversión, interacción">';
        echo '<meta name="author" content="Ing. Medina">';

        // Google Analytics
        echo '<script async src="https://www.googletagmanager.com/gtag/js?id=G-32NSVX1ZQD"></script>';
        echo '<script>';
        echo 'window.dataLayer = window.dataLayer || [];';
        echo 'function gtag(){dataLayer.push(arguments);}';
        echo 'gtag("js", new Date());';
        echo 'gtag("config", "G-32NSVX1ZQD");';
        echo '</script>';

        // Google Ads
        echo '<meta name="google-adsense-account" content="ca-pub-1683982217981918">';
        // Script de Google Ads (Añadido aquí)
        echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1683982217981918" crossorigin="anonymous"></script>';

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
        echo '<link id="datatable-css" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">'; // Referencia a datatable-css CDN
        echo '<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>';

        // BOOSTRAP
        echo '<link id="bootstrap-css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">'; // Referencia a Bootstrap CSS CDN
        echo '<script id="bootstrap-js" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>';

        // CHART.JS
        echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';
        echo '<link id="chart-css" href="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.css" rel="stylesheet">'; // Referencia a Chart.js CSS CDN

        // SWEETALERT 2
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo '<link id="sweetalert-css" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.min.css" rel="stylesheet">'; // Referencia a SweetAlert2 CSS CDN

        // VALIDATE.JS
        echo '<script src="https://unpkg.com/just-validate@latest/dist/just-validate.production.min.js"></script>';

        // BOOSTRAP ICONS
        echo '<link id="icons-css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">'; // Referencia a Bootstrap Icons CSS CDN

        // Enlaces de precarga (Añadir este bucle)
        foreach ($this->preloadLinks as $link) {
            echo $link;
        }

        // Cargar archivos CSS adicionales
        foreach ($this->cssFiles as $file) {
            echo '<link href="' . $file . '" rel="stylesheet">';
        }

        // Cargar archivos JS adicionales
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
                checkAndLoadCDN("bootstrap-css", "/public/assets/framework/bootstrap/bootstrap.css"); // Fallback local Bootstrap CSS
                checkAndLoadCDN("bootstrap-js", "/public/assets/framework/bootstrap/bootstrap.bundle.min.js");
                checkAndLoadCDN("datatable-css", "/public/assets/framework/data_simple/style.css"); // Fallback local DataTables CSS
                checkAndLoadCDN("datatable-js", "/public/assets/framework/data_simple/script.js");
                checkAndLoadCDN("icons-css", "/public/assets/framework/bootstrap/icons/bootstrap-icons.css"); // Fallback local Bootstrap Icons CSS
            };
        </script>';

        echo '</head>';
        echo '<body>';
        echo '</div>'; // Nota: Este </div> parece estar fuera de lugar aquí, debería estar después del contenido del body.
        echo '</html>';
    }
}

// Corregir las rutas de los archivos locales
$header = new Header('Agencia Shein Habbo');

// Añadir la precarga para la imagen LCP (Añadir esta línea)
// $header->addPreloadLink('/private/plantilla/home/agencia2.png', 'image');

// Archivo local Bootstrap CSS (añadido directamente)
$header->addCssFile('/public/assets/framework/bootstrap/bootstrap.min.css'); // Archivo local Bootstrap minified CSS (añadido directamente)

// Corregir la ruta de datatable
$header->addJsFile('/public/assets/framework/data_simple/script.js');

// Archivos estilos CSS para menus CSS personalizados (versiones locales)
$header->addCssFile('/public/assets/custom_general/custom_menus/style.css');

// Archivos estilos de body home (versiones locales)
$header->addCssFile('/public/assets/custom_general/custom_home/style.css');

// Archivos de tabla de rangos, misiones y costos CSS personalizados (versiones locales)
$header->addCssFile('/public/assets/custom_general/custom/css/style.css');

// Archivos JS personalizados
$header->addJsFile('/public/assets/custom_general/custom/js/script.js');

$header->render();
