<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(TEMPLATES_PATH . 'header.php');

// Obtener el rango del usuario y cargar el menú correspondiente
if (isset($_SESSION['user_id'])) {
    require_once(CONFIG_PATH . 'bd.php');
    $database = new Database();
    $conn = $database->getConnection();

    try {
        $query = "SELECT rango FROM registro_usuario WHERE id = :user_id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $userRango = $row['rango'];
            // Determinar qué menú cargar según el rango
            switch ($userRango) {
                case 'En Espera de ser verificado':
                    require_once(MENU_PATH . 'menu_aunno_verificado.php');
                    break;
                case 'Agente':
                case 'Seguridad':
                case 'Tecnico':
                    require_once(MENU_PATH . 'menu_rango_bajos.php');
                    break;
                case 'Logistica':
                case 'Supervisor':
                    require_once(MENU_PATH . 'menu_rango_medios.php');
                    break;
                case 'Director':
                case 'Presidente':
                case 'Operativo':
                case 'Junta directiva':
                    require_once(MENU_PATH . 'menu_rango_altos.php');
                    break;
                case 'Administrador':
                case 'Manager':
                case 'Dueno':
                case 'Fundador':
                    require_once(MENU_PATH . 'menu_rango_admin.php');
                    break;
                default:
                    require_once(MENU_PATH . 'menu_rango_bajos.php');
            }
        }
    } catch (PDOException $e) {
        error_log("Error al obtener rango: " . $e->getMessage());
        require_once(MENU_PATH . 'menu_rango_bajos.php'); // Menú por defecto en caso de error
    }
}

// Add session check here
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location.href = '/login.php';</script>";
    exit;
}
?>

<body>
    <div class="page-container">
        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <?php
                    if (isset($_GET['q']) && !empty($_GET['q'])) {
                        $query = strtolower(trim($_GET['q']));
                        // Funcion de buscar
                        $pages = [
                            'GSTM.php' => 'gestion_de_tiempo',
                            'USR.php' => 'inicio',
                            'PRUS.php' => 'ver_perfil',
                            'CRSS.php' => 'cerrar_session',
                            'RQPG.php' => 'Requisitos_paga',
                            'GSAS.php' => 'gestion_ascenso',
                            'GVE.php' => 'Pendiente',
                            'GVP.php' => 'Pendiente',
                            'MEMS.php' => 'membresias',
                            'GTPS.php' => 'gestion_de_pagas',
                            'GEPS.php' => 'grafico de pagas',
                            'VTM.php' => 'ventas_membresias',
                            'VTR.php' => 'venta_rangos',
                            'GEDV.php' => 'total_ventas',
                        ];

                        $results = [];

                        foreach ($pages as $file => $title) {
                            if (file_exists($file)) {
                                $content = file_get_contents($file);
                                preg_match('/<meta name="keywords" content="([^"]+)"/', $content, $matches);

                                if (!empty($matches[1])) {
                                    $keywords = explode(',', strtolower($matches[1]));
                                    foreach ($keywords as $keyword) {
                                        similar_text($query, $keyword, $percentage);
                                        if ($percentage > 60 || strpos($keyword, $query) !== false) {
                                            $results[] = ['title' => $title, 'url' => 'index.php?page=' . urlencode($title)];
                                            break;
                                        }
                                    }
                                }
                            }
                        }

                        echo '<div class="search-results-container">';
                        echo '<div class="card shadow-lg border-0 rounded-lg">';
                        echo '<div class="card-header bg-gradient-primary">';
                        echo '<h4 class="text-dark mb-0"><i class="fas fa-search me-2"></i>Resultados para: "' . htmlspecialchars($query) . '"</h4>';
                        echo '</div>';
                        echo '<div class="card-body">';

                        if (!empty($results)) {
                            echo '<div class="results-list">';
                            foreach ($results as $result) {
                                echo '<a href="' . $result['url'] . '" class="result-item">';
                                echo '<div class="d-flex align-items-center p-3 border-bottom transition-hover">';
                                echo '<i class="fas fa-link me-3 text-primary"></i>';
                                echo '<div>';
                                echo '<h5 class="mb-0">' . ucfirst($result['title']) . '</h5>';
                                echo '</div>';
                                echo '<i class="fas fa-chevron-right ms-auto text-muted"></i>';
                                echo '</div>';
                                echo '</a>';
                            }
                            echo '</div>';
                        } else {
                            echo '<div class="text-center p-4">';
                            echo '<i class="fas fa-search-minus fa-3x text-muted mb-3"></i>';
                            echo '<div class="alert alert-warning mb-0">';
                            echo '<h5 class="alert-heading">No se encontraron resultados</h5>';
                            echo '<p class="mb-0">Intenta con otros términos de búsqueda</p>';
                            echo '</div>';
                            echo '</div>';
                        }

                        echo '</div></div></div>';
                    } else {
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                            $validPages = [
                                'gestion_de_tiempo' => ['file' => 'GSTM.php', 'roles' => ['Director', 'Presidente', 'Operativo', 'Junta directiva', 'Administrador', 'Manager', 'Dueño', 'Fundador']],
                                'inicio' => ['file' => 'USR.php', 'roles' => ['Agente', 'Seguridad', 'Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva', 'Administrador', 'Manager', 'Dueño', 'Fundador']],
                                'ver_perfil' => ['file' => 'PRUS.php', 'roles' => ['Agente', 'Seguridad', 'Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva', 'Administrador', 'Manager', 'Dueño', 'Fundador']],
                                'cerrar_session' => ['file' => 'CRSS.php', 'roles' => ['Agente', 'Seguridad', 'Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva', 'Administrador', 'Manager', 'Dueño', 'Fundador']],
                                'requisitos_paga' => ['file' => 'RQPG.php', 'roles' => ['Agente', 'Seguridad', 'Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo','Junta directiva', 'Administrador', 'Manager', 'Dueño', 'Fundador']],
                                'gestion_ascenso' => ['file' => 'GSAS.php', 'roles' => ['Logistica', 'Supervisor', 'Operativo','Director', 'Presidente', 'Junta directiva','Administrador', 'Manager', 'Dueño', 'Fundador']],
                                'gestion_de_pagas' => ['file' => 'GTPS.php', 'roles' => ['Administrador', 'Manager', 'Dueño', 'Fundador']],
                                'grafico de pagas' => ['file' => 'GEPS.php', 'roles' => ['Administrador', 'Manager', 'Dueño', 'Fundador']],
                                'ventas_membresias' => ['file' => 'VTM.php', 'roles' => ['Administrador', 'Manager', 'Dueño', 'Fundador']],
                                'venta_rangos' => ['file' => 'VTR.php', 'roles' => ['Administrador', 'Manager', 'Dueño', 'Fundador']],
                                'verificar_usuarios' => ['file' => 'VER.php', 'roles' => ['Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva','Administrador', 'Manager', 'Dueño', 'Fundador']],
                                'gestionar_usuarios' => ['file' => 'GEUS.php', 'roles' => ['Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva','Administrador', 'Manager', 'Dueño', 'Fundador']],
                                'total_ventas' => ['file' => 'GEDV.php', 'roles' => ['Tecnico', 'Logistica', 'Supervisor', 'Director', 'Presidente', 'Operativo', 'Junta directiva','Administrador', 'Manager', 'Dueño', 'Fundador']],
                            ];


                            $userRango = '';
                            if (isset($_SESSION['user_id'])) {
                                require_once(CONFIG_PATH . 'bd.php');
                                $database = new Database();
                                $conn = $database->getConnection();

                                try {
                                    $query = "SELECT rango FROM registro_usuario WHERE id = :user_id";
                                    $stmt = $conn->prepare($query);
                                    $stmt->bindParam(':user_id', $_SESSION['user_id']);
                                    $stmt->execute();

                                    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $userRango = $row['rango'];
                                        $_SESSION['rango'] = $userRango;
                                    }
                                } catch (PDOException $e) {
                                    error_log("Error en la consulta: " . $e->getMessage());
                                    echo '<div class="alert alert-danger">Error al verificar permisos</div>';
                                    exit();
                                }
                            }

                            // Resto del código de validación
                            if (array_key_exists($page, $validPages) && in_array($userRango, $validPages[$page]['roles'])) {
                                include $validPages[$page]['file'];
                            } else {
                                echo '<div class="alert alert-danger text-center mt-5">';
                                echo '<h4 class="alert-heading">Acceso Denegado</h4>';
                                echo '<p>No tienes los permisos necesarios para acceder a esta página u la pagina no existe.</p>';
                                echo '<p>Tu rango actual es: ' . htmlspecialchars($userRango) . '</p>';
                                echo '<p>Redirigiendo a la página principal...</p>';
                                echo '</div>';
                                echo '<meta http-equiv="refresh" content="3;url=index.php">';
                                exit();
                            }
                        } else {
                            include 'USR.php';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

<body>
    <div id="loader-wrapper" class="loader-wrapper">
        <div class="loader">
            <div class="loader-ring"></div>
            <div class="loader-ring-inner"></div>
        </div>
    </div>

    <style>
        .bg-gradient-light {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .page-container {
            min-height: calc(100vh - 400px);
            padding: 4rem 0;
        }

        .search-results-container {
            animation: fadeIn 0.3s ease-in-out;
            margin-top: 80px;
        }

        .card-header {
            padding: 1.5rem !important;
        }

        .card-body {
            padding: 2rem !important;
        }

        body {
            background-color: #F3F0FF;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #00c6fb 0%, #005bea 100%);
            padding: 1.5rem;
        }

        .result-item {
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .result-item:hover {
            background-color: rgba(0, 123, 255, 0.05);
            color: inherit;
        }

        .transition-hover {
            transition: all 0.3s ease;
        }

        .transition-hover:hover {
            transform: translateX(5px);
        }

        .card {
            border-radius: 15px;
            overflow: hidden;
        }

        .card-header h4 {
            font-weight: 600;
        }

        .results-list {
            border-radius: 10px;
            overflow: hidden;
        }

        .border-bottom {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
        }

        .border-bottom:last-child {
            border-bottom: none !important;
        }

        /* Loader styles */
        .loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(243, 240, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            position: relative;
            width: 150px;
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .loader-image {
            width: 80px;
            height: 80px;
            position: absolute;
            z-index: 2;
            animation: none;  /* Asegura que la imagen no tenga animación */
            transform: none;  /* Previene cualquier transformación */
        }

        .loader-ring {
            position: absolute;
            width: 150px;
            height: 150px;
            border: 4px solid transparent;
            border-radius: 50%;
            border-top: 4px solid #00c6fb;
            border-bottom: 4px solid #005bea;
            animation: spin 2s linear infinite;
        }

        .loader-ring-inner {
            position: absolute;
            width: 120px;
            height: 120px;
            border: 4px solid transparent;
            border-radius: 50%;
            border-left: 4px solid #00c6fb;
            border-right: 4px solid #005bea;
            animation: spin-reverse 1.5s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes spin-reverse {
            0% { transform: rotate(360deg); }
            100% { transform: rotate(0deg); }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .page-container {
                padding: 1rem 0;
            }
            .loader {
                width: 120px;
                height: 120px;
            }
            .loader-image {
                width: 60px;
                height: 60px;
            }
            .loader-ring {
                width: 120px;
                height: 120px;
            }
            .loader-ring-inner {
                width: 90px;
                height: 90px;
            }
        }
    </style>
</body>

<?php require_once(TEMPLATES_PATH . 'footer.php'); ?>


<style>
    .loader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(243, 240, 255, 0.9);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.3s ease-out;
    }

    .loader-wrapper.fade-out {
        opacity: 0;
        pointer-events: none;
    }

    .loader {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-radius: 50%;
        border-top: 5px solid #00c6fb;
        border-bottom: 5px solid #005bea;
        animation: spin 1s linear infinite;
    }

    .loader-inner {
        position: absolute;
        width: 30px;
        height: 30px;
        border: 5px solid #f3f3f3;
        border-radius: 50%;
        border-top: 5px solid #005bea;
        border-bottom: 5px solid #00c6fb;
        top: 50%;
        left: 50%;
        margin: -15px 0 0 -15px;
        animation: spin 0.8s linear infinite reverse;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
</body>


<script>
    window.addEventListener('load', function() {
        const loader = document.getElementById('loader-wrapper');
        loader.classList.add('fade-out');
        setTimeout(() => {
            loader.style.display = 'none';
            
            // Check if welcome message has been shown today
            const lastShown = localStorage.getItem('welcomeLastShown');
            const today = new Date().toDateString();
            
            if (!lastShown || lastShown !== today) {
                Swal.fire({
                    title: '¡Bienvenido al Sistema!',
                    html: `
                        <div class="text-center">
                            <p class="mb-2"><strong>Sistema en Fase de Pruebas</strong></p>
                            <p class="text-muted">Estamos trabajando para mejorar tu experiencia.<br>
                            Algunas funciones podrían estar en desarrollo.</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#8A2BE2',
                    timer: 6000,
                    timerProgressBar: true,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
                // Save today's date
                localStorage.setItem('welcomeLastShown', today);
            }
        }, 300);
    });

    // Show loader when navigating
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && !link.hasAttribute('target') && link.href.indexOf('#') === -1) {
            const loader = document.getElementById('loader-wrapper');
            loader.style.display = 'flex';
            loader.classList.remove('fade-out');
        }
    });
</script>