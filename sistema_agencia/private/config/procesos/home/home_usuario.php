<?php
class BodyHome
{
    private $userData;

    public function __construct() {

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
            echo "<script>window.location.href = '/login.php';</script>";
            exit;
        }

        $this->userData = [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'verificado' => $_SESSION['verificado'] ?? 0
            
        ];
    }
    
    public function render()
    {
        ?>
        <div class="home-container">
            <?php
            $this->renderHeader();
            $this->renderTeamSection();
            $this->renderEventsSection();
            $this->renderPaydaySection();
            $this->renderMembershipSection();
            ?>
        </div>

        <style>
        .home-container {
            background: linear-gradient(135deg, #f6f8fd 0%, #f0f3fa 100%);
            min-height: 100vh;
            padding-bottom: 4rem;
        }

        .welcome-header {
            background: linear-gradient(90deg, #8A2BE2, #9370DB);
            padding: 3rem 0;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .welcome-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('/public/custom/custom_login_registro/img/hb.png');
            opacity: 0.1;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #00c6fb, #005bea);
            border-radius: 2px;
        }

        .team-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .team-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid #005bea;
            padding: 3px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .team-card:hover .team-avatar {
            transform: scale(1.1);
        }

        .news-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }

        .news-card:hover {
            transform: translateY(-5px);
        }

        .news-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .news-content {
            padding: 1.5rem;
        }

        .country-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }

        .country-card:hover {
            transform: translateY(-5px);
        }

        .country-flag {
            width: 100%;
            height: 100px;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .membership-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .membership-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #00c6fb, #005bea);
        }

        .membership-card:hover {
            transform: translateY(-5px);
        }

        .membership-image {
            width: 100%;
            height: 180px;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .section-container {
            padding: 3rem 0;
            position: relative;
        }

        @media (max-width: 768px) {
            .welcome-header {
                padding: 2rem 0;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .team-avatar {
                width: 100px;
                height: 100px;
            }
        }
        </style>
        <?php
    }

    private function getRolName($verificado) {
        $estados = [
            0 => 'En espera de verificación',
            1 => 'Usuario Verificado',
            2 => 'Usuario Rechazado'
        ];
        return $estados[$verificado] ?? 'Estado Desconocido';
    }

    private function renderHeader()
    {
        $username = htmlspecialchars($this->userData['username']);
        $verificado = $_SESSION['verificado'] ?? 0;
        $estadoName = $this->getRolName($verificado);
        
        $badgeClass = match($verificado) {
            1 => 'bg-success',
            2 => 'bg-danger',
            default => 'bg-warning'
        };
        ?>
        <header class="welcome-header text-center">
            <div class="container">
                <h1 class="display-4 text-white mb-3">
                    <i class="fas fa-star me-2"></i> Agencia Atenas <i class="fas fa-star me-2"></i>
                </h1>
                <p class="lead text-white mb-2">
                    Bienvenido <?= $username ?> 
                </p>
                <p class="text-white-50">
                    Estado: <span class="badge <?= $badgeClass ?>"><?= $estadoName ?></span>
                </p>
            </div>
        </header>
        <?php
    }

    private function renderTeamSection()
    {
        $teamMembers = [
            ['name' => 'Santidemg', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20avatar%20with%20blonde%20hair%20and%20suit&aspect=1:1', 'rank' => 'Dueño'],
            ['name' => 'Manu', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20avatar%20female%20with%20pink%20hair&aspect=1:1', 'rank' => 'Dueño'],
            ['name' => 'Carlos Díaz', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20avatar%20with%20brown%20hair%20and%20glasses&aspect=1:1', 'rank' => 'Dueño'],
            ['name' => 'María Ruiz', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20avatar%20female%20with%20red%20dress&aspect=1:1', 'rank' => 'Dueño'],
            ['name' => 'Loucio', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20avatar%20female%20with%20blue%20outfit&aspect=1:1', 'rank' => 'Administrador'],
            ['name' => 'Sofia', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20avatar%20female%20with%20green%20dress&aspect=1:1', 'rank' => 'Administradora'],
        ];

        echo '<section style="background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important; padding: 50px 0;">';
        echo '<div class="container text-center">';
        echo '<h2 style="color: black; font-weight: bold;">👑 Nuestro Equipo 👑</h2>';
        echo '<div class="row justify-content-center">'; // Centrar el contenido

        foreach ($teamMembers as $member) {
            echo '<div class="col-12 col-sm-6 col-md-4 mb-4">'; // 1 columna en móvil, 2 en tablet, 3 en PC
            echo '<div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0px 5px 10px rgba(0,0,0,0.2); transition: transform 0.3s;">';
            echo '<img src="' . $member['image'] . '" style="border-radius: 50%; width: 100px; height: 100px; border: 3px solid #FFD700;">';
            echo '<h3 style="color: #333;">' . $member['name'] . '</h3>';
            echo '<span style="background: #FF4500; color: white; padding: 5px 10px; border-radius: 10px;">' . $member['rank'] . '</span>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
        echo '</section>';
    }

    private function renderEventsSection()
    {
        $events = [
            ['title' => 'Fiesta de Bienvenida', 'description' => 'Conoce a todos los miembros de Agencia Atenas en nuestra fiesta de bienvenida', 'date' => '15 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20party%20room%20with%20lots%20of%20avatars%20dancing&aspect=16:9'],
            ['title' => 'Construcción', 'description' => 'Muestra tus habilidades de construcción y gana premios increíbles', 'date' => '22 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20building%20competition%20with%20furniture%20and%20decorations&aspect=16:9'],
            ['title' => 'Carrera de Obstáculos', 'description' => 'Supera todos los obstáculos en el menor tiempo posible', 'date' => '29 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20obstacle%20course%20with%20traps%20and%20challenges&aspect=16:9'],
        ];

        echo '<section style="background: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important; padding: 10px 0;">';
        echo '<div class="container text-center">';
        echo '<h2 style="color: black; font-weight: bold;">🎉 Noticias 🎉</h2>';
        echo '<div class="row">';

        foreach ($events as $event) {
            echo '<div class="col-md-4" style="margin-top: 20px;">';
            echo '<div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0px 5px 10px rgba(0,0,0,0.2);">';
            echo '<img src="' . $event['image'] . '" style="width: 100%; height: 150px; border-radius: 10px; object-fit: cover;">';
            echo '<h3 style="color: #333; margin-top: 10px;">' . $event['title'] . '</h3>';
            echo '<p style="color: #666;">' . $event['description'] . '</p>';
            echo '<span style="background: #008080; color: white; padding: 5px 10px; border-radius: 10px;">' . $event['date'] . '</span>';
            echo '<br><br>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
        echo '</section>';
    }

    private function renderPaydaySection()
    {
        $countries = [
            ['name' => 'México', 'flag' => 'https://flagcdn.com/mx.svg'],
            ['name' => 'Argentina', 'flag' => 'https://flagcdn.com/ar.svg'],
            ['name' => 'Colombia', 'flag' => 'https://flagcdn.com/co.svg'],
            ['name' => 'Perú', 'flag' => 'https://flagcdn.com/pe.svg'],
            ['name' => 'Chile', 'flag' => 'https://flagcdn.com/cl.svg'],
            ['name' => 'Brasil', 'flag' => 'https://flagcdn.com/br.svg'],
            ['name' => 'España', 'flag' => 'https://flagcdn.com/es.svg'],
            ['name' => 'Estados Unidos', 'flag' => 'https://flagcdn.com/us.svg'],
        ];

        echo '<section style="background: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important; padding: 20px 0;">';
        echo '<div class="container text-center">';
        echo '<h2 style="color: black; font-weight: bold;">💰 Día de Paga 💰</h2>';
        echo '<div class="row justify-content-center">';

        foreach ($countries as $country) {
            echo '<div class="col-6 col-sm-4 col-md-3 mb-4">';
            echo '<div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0px 8px 15px rgba(0,0,0,0.2);">';
            echo '<img src="' . $country['flag'] . '" style="width: 100%; height: 120px; border-radius: 8px; object-fit: cover;">';
            echo '<p style="color: #333; margin-top: 15px; font-size: 18px; font-weight: bold;">' . $country['name'] . '</p>';
            echo '<p style="color: #666; font-size: 16px;">Hora de paga: 14:00</p>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
        echo '</section>';
    }


    private function renderMembershipSection()
    {
        $memberships = [
            [
                'title' => 'Membresía gold',
                'benefits' => 'Bonificación del 5% en paga.',
                'image' => '/public/custom/custom_requisitos_rangos/image/membresias/gold.png' // URL de la imagen
            ],
            [
                'title' => 'Membresía Premium',
                'benefits' => 'Bonificación del 15% en paga.',
                'image' => '/public/custom/custom_requisitos_rangos/image/membresias/premim.png' // URL de la imagen
            ],
            [
                'title' => 'Membresía regla libre',
                'benefits' => 'Bonificación del 25% en paga.',
                'image' => '/public/custom/custom_requisitos_rangos/image/membresias/regla.png' // URL de la imagen
            ],
            [
                'title' => 'Membresía save',
                'benefits' => 'Bonificación del 35% en paga.',
                'image' => '/public/custom/custom_requisitos_rangos/image/membresias/save.png' // URL de la imagen
            ],
            [
                'title' => 'Membresía vip',
                'benefits' => 'Bonificación del 50% en paga.',
                'image' => '/public/custom/custom_requisitos_rangos/image/membresias/vip.png' // URL de la imagen
            ],
            [
                'title' => 'Membresía silver',
                'benefits' => 'Bonificación del 50% en paga.',
                'image' => '/public/custom/custom_requisitos_rangos/image/membresias/silver.png' // URL de la imagen
            ],
        ];

        echo '<section style="background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important; padding: 10px 0;">';
        echo '<div class="container text-center">';
        echo '<h2 style="color: #333; font-weight: bold;">🌟 Membresías Disponibles 🌟</h2>';
        echo '<p style="color: #666; font-size: 18px;">Elige la membresía que mejor se adapte a tus necesidades y disfruta de nuestros beneficios exclusivos.</p>';
        echo '<div class="row justify-content-center">';

        foreach ($memberships as $membership) {
            echo '<div class="col-12 col-sm-6 col-md-4 mb-4">'; // 1 columna en móvil, 2 en tablet, 3 en PC
            echo '<div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0px 5px 10px rgba(0,0,0,0.2); transition: transform 0.3s;">';
            echo '<img src="' . $membership['image'] . '" style="width: 100%; height: 150px; border-radius: 10px; object-fit: cover; margin-bottom: 15px;">'; // Imagen de la membresía
            echo '<h3 style="color: #333;">' . $membership['title'] . '</h3>';
            echo '<p style="color: #008080; font-weight: bold;">' . $membership['benefits'] . '</p>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>'; // Cierre de la fila
        echo '</div>'; // Cierre del contenedor
        echo '</section>';
    }
}

// Instancia y renderizado de la clase
require_once(BODY_DJ_PATH . 'dj_radio.php');
$bodyHome = new BodyHome();
$bodyHome->render();
