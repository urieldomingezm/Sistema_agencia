<?php
class BodyHome {
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
    
    public function render() {
        ?>
        <div class="home-container">
            <?php
            $this->renderHeader();
            $this->renderTopUsersSection(); // Añadir la nueva sección aquí
            $this->renderEventsSection();
            $this->renderPaydaySection();
            $this->renderMembershipSection();
            ?>
        </div>
        <?php
    }

    private function renderHeader() {
        $username = htmlspecialchars($this->userData['username']);
        ?>
        <header class="welcome-header text-center" style="background: linear-gradient(135deg, #4a6bff 0%, #2541b2 100%); padding: 20px 0; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
            <div class="container">
                <h1 class="display-4 text-white mb-2" style="font-size: clamp(1.5rem, 6vw, 2.5rem);">
                    <i class="bi bi-star-fill me-2"></i> Agencia Shein <i class="bi bi-star-fill me-2"></i>
                </h1>
                <p class="lead text-white mb-1" style="font-size: clamp(0.9rem, 3vw, 1.2rem);">
                    Bienvenido <?= $username ?>
                </p>
                <?php
                // Anuncio de ejemplo
                $announcement = "¡Atención! Por el momento la toma de ascenso estara en mantenimiento pueden tomar tiempo de los usuarios por el momento.";
                ?>
                <div class="alert alert-warning mt-3 mb-0" role="alert" style="font-size: clamp(0.8rem, 2.5vw, 1rem);">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= htmlspecialchars($announcement) ?>
                </div>
            </div>
        </header>
        <?php
    }

    // Nuevo método para renderizar la sección de Top 3 Usuarios
    private function renderTopUsersSection() {
        $topUsers = [
            ['name' => 'UsuarioEjemplo1', 'rank' => '1er Lugar', 'score' => 1500, 'icon_color' => '#FFD700'], // Gold
            ['name' => 'UsuarioEjemplo2', 'rank' => '2do Lugar', 'score' => 1200, 'icon_color' => '#C0C0C0'], // Silver
            ['name' => 'UsuarioEjemplo3', 'rank' => '3er Lugar', 'score' => 1000, 'icon_color' => '#CD7F32'], // Bronze
        ];
        ?>
        <section style="background: #ffffff; padding: 20px 0;">
            <div class="container text-center">
                <h2 style="color: #2541b2; font-weight: bold; font-size: clamp(1.2rem, 4vw, 1.8rem); margin-bottom: 30px;">
                    <i class="bi bi-trophy-fill me-2" style="color: #FFD700;"></i> Top 3 Usuarios <i class="bi bi-trophy-fill ms-2" style="color: #FFD700;"></i>
                </h2>
                <div class="row justify-content-center">
                    <?php foreach ($topUsers as $user): ?>
                        <div class="col-12 col-sm-6 col-md-4 mb-4">
                            <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 20px; border-radius: 15px; box-shadow: 0px 5px 10px rgba(0,0,0,0.1); height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                <i class="bi bi-trophy-fill" style="font-size: 3rem; color: <?= $user['icon_color'] ?>; margin-bottom: 15px;"></i>
                                <h3 style="color: #333; font-size: clamp(1rem, 3vw, 1.2rem); margin-bottom: 5px;"><?= htmlspecialchars($user['name']) ?></h3>
                                <p style="color: #555; font-size: clamp(0.9rem, 2.5vw, 1.1rem); margin-bottom: 10px;"><?= htmlspecialchars($user['rank']) ?></p>
                                <span style="background: #2541b2; color: white; padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: clamp(0.8rem, 2vw, 1rem);"><?= htmlspecialchars($user['score']) ?> Puntos</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    private function renderEventsSection() {
        $events = [
            ['title' => 'Fiesta de Bienvenida', 'description' => 'Conoce a todos los miembros de Agencia Atenas en nuestra fiesta de bienvenida', 'date' => '15 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20party%20room%20with%20lots%20of%20avatars%20dancing&aspect=16:9'],
            ['title' => 'Construcción', 'description' => 'Muestra tus habilidades de construcción y gana premios increíbles', 'date' => '22 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20building%20competition%20with%20furniture%20and%20decorations&aspect=16:9'],
            ['title' => 'Carrera de Obstáculos', 'description' => 'Supera todos los obstáculos en el menor tiempo posible', 'date' => '29 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20obstacle%20course%20with%20traps%20and%20challenges&aspect=16:9'],
        ];

        echo '<section style="background: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important; padding: 10px 0;">';
        echo '<div class="container text-center">';
        echo '<h2 style="color: black; font-weight: bold; font-size: clamp(1.2rem, 4vw, 1.8rem);"><i class="bi bi-newspaper me-1"></i> Noticias <i class="bi bi-newspaper me-1"></i></h2>';
        echo '<div class="row justify-content-center">';

        foreach ($events as $event) {
            echo '<div class="col-12 col-md-6 col-lg-4 mb-3">';
            echo '<div style="background: white; padding: 15px; border-radius: 15px; box-shadow: 0px 5px 10px rgba(0,0,0,0.2);">';
            // Añadido atributo alt descriptivo para la imagen del evento
            echo '<img src="' . $event['image'] . '" style="width: 100%; height: 120px; border-radius: 10px; object-fit: cover;" alt="' . htmlspecialchars($event['title']) . '">';
            echo '<h3 style="color: #333; margin-top: 10px; font-size: clamp(1rem, 3vw, 1.2rem);">' . $event['title'] . '</h3>';
            echo '<p style="color: #666; font-size: clamp(0.8rem, 2.5vw, 1rem);">' . $event['description'] . '</p>';
            echo '<span style="background: #008080; color: white; padding: 5px 10px; border-radius: 10px; font-size: clamp(0.7rem, 2vw, 0.9rem);">' . $event['date'] . '</span>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
        echo '</section>';
    }

    private function renderPaydaySection() {
        $countries = [
            [
                'name' => 'México',
                'flag' => 'https://flagcdn.com/mx.svg',
                'paytime' => '14:00'
            ],
            [
                'name' => 'Argentina',
                'flag' => 'https://flagcdn.com/ar.svg',
                'paytime' => '17:00'
            ],
            [
                'name' => 'Colombia',
                'flag' => 'https://flagcdn.com/co.svg',
                'paytime' => '15:00'
            ],
            [
                'name' => 'Perú',
                'flag' => 'https://flagcdn.com/pe.svg',
                'paytime' => '15:00'
            ],
            [
                'name' => 'Chile',
                'flag' => 'https://flagcdn.com/cl.svg',
                'paytime' => '16:00'
            ],
            [
                'name' => 'Brasil',
                'flag' => 'https://flagcdn.com/br.svg',
                'paytime' => '17:00'
            ],
            [
                'name' => 'España',
                'flag' => 'https://flagcdn.com/es.svg',
                'paytime' => '22:00'
            ],
            [
                'name' => 'Estados Unidos',
                'flag' => 'https://flagcdn.com/us.svg',
                'paytime' => '14:00'
            ],
        ];

        echo '<section style="background: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important; padding: 20px 0;">';
        echo '<div class="container text-center">';
        echo '<h2 style="color: black; font-weight: bold;"><i class="bi bi-cash-coin me-1"></i> Día de Paga <i class="bi bi-cash-coin me-1"></i></h2>';
        
        echo '<div id="paydayCarousel" class="carousel slide" data-bs-ride="carousel">';
        
        echo '<div class="carousel-inner">';
        
        $itemsPerSlide = 4;
        $totalSlides = ceil(count($countries) / $itemsPerSlide);
        
        for ($i = 0; $i < $totalSlides; $i++) {
            echo '<div class="carousel-item ' . ($i === 0 ? 'active' : '') . '">';
            echo '<div class="row justify-content-center">';
            
            for ($j = $i * $itemsPerSlide; $j < min(($i + 1) * $itemsPerSlide, count($countries)); $j++) {
                $country = $countries[$j];
                echo '<div class="col-md-3 mb-4">';
                echo '<div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0px 8px 15px rgba(0,0,0,0.2);">';
                // Añadido atributo alt descriptivo para la bandera del país
                echo '<img src="' . $country['flag'] . '" style="width: 100%; height: 120px; border-radius: 8px; object-fit: cover;" alt="Bandera de ' . htmlspecialchars($country['name']) . '">';
                echo '<p style="color: #333; margin-top: 15px; font-size: 18px; font-weight: bold;">' . $country['name'] . '</p>';
                echo '<p style="color: #666; font-size: 16px;">Hora de paga: ' . $country['paytime'] . '</p>';
                echo '</div>';
                echo '</div>';
            }
            
            echo '</div>';
            echo '</div>';
        }
        
        echo '</div>';
        
        // Controles del carrusel (flechas negras)
        echo '<button class="carousel-control-prev" type="button" data-bs-target="#paydayCarousel" data-bs-slide="prev" style="width: 5%;">';
        echo '<span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: black; border-radius: 50%; padding: 15px;"></span>';
        echo '<span class="visually-hidden">Anterior</span>';
        echo '</button>';
        echo '<button class="carousel-control-next" type="button" data-bs-target="#paydayCarousel" data-bs-slide="next" style="width: 5%;">';
        echo '<span class="carousel-control-next-icon" aria-hidden="true" style="background-color: black; border-radius: 50%; padding: 15px;"></span>';
        echo '<span class="visually-hidden">Siguiente</span>';
        echo '</button>';
        
        echo '</div>'; // Fin del carrusel
        echo '</div>'; // Fin del container
        echo '</section>';
    }


    private function renderMembershipSection() {
        $memberships = [
            [
                'title' => 'Membresía Gold',
                'benefits' => 'Mimsmos beneficios de bronce y silver + fila vip + Guarda paga + Mision libre.',
                'image' => '/usuario/rangos/image/membresias/gold.png',
                'price' => '40 créditos por mes'
            ],
            [
                'title' => 'Membresía Bronce',
                'benefits' => 'Incluye ropa libre + Chat libre + Baile + Uso de efectos.',
                'image' => '/usuario/rangos/image/membresias/premim.png',
                'price' => '28 créditos por mes'
            ],
            [
                'title' => 'Membresía regla libre',
                'benefits' => 'Chat, Mision y ropa libre',
                'image' => '/usuario/rangos/image/membresias/regla.png',
                'price' => '25 créditos por mes'
            ],
            [
                'title' => 'Membresía save',
                'benefits' => 'Guarda tu paga por 48 Horas.',
                'image' => '/usuario/rangos/image/membresias/save.png',
                'price' => '10 créditos por mes'
            ],
            [
                'title' => 'Membresía Fila Vip',
                'benefits' => 'Garantiza beneficios frente al resto de usuarios que no tengan fila vip.',
                'image' => '/usuario/rangos/image/membresias/vip.png',
                'price' => '15 créditos por mes'
            ],
            [
                'title' => 'Membresía silver',
                'benefits' => 'Mismos beneficios de la Membresia bronce + Reduccion en requisitos.',
                'image' => '/usuario/rangos/image/membresias/silver.png',
                'price' => '34 créditos por mes'
            ],
        ];

        echo '<section style="background-color: rgba(var(--bs-light-rgb), var(--bs-bg-opacity)) !important; padding: 10px 0;">';
        echo '<div class="container text-center">';
        echo '<h2 style="color: #333; font-weight: bold;"><i class="bi bi-gem me-1"></i> Membresías Disponibles <i class="bi bi-gem me-1"></i></h2>';
        echo '<p style="color: #666; font-size: 18px;">Elige la membresía que mejor se adapte a tus necesidades y disfruta de nuestros beneficios exclusivos.</p>';
        echo '<div class="row justify-content-center">';

        foreach ($memberships as $membership) {
            echo '<div class="col-12 col-sm-6 col-md-4 mb-4">';
            echo '<div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0px 5px 10px rgba(0,0,0,0.2); transition: transform 0.3s;">';
            // Añadido atributo alt descriptivo para la imagen de la membresía
            echo '<img src="' . $membership['image'] . '" style="width: 100%; height: 150px; border-radius: 10px; object-fit: cover; margin-bottom: 15px;" alt="Imagen de la membresía ' . htmlspecialchars($membership['title']) . '">';
            echo '<h3 style="color: #333;">' . $membership['title'] . '</h3>';
            echo '<p style="color: #008080; font-weight: bold;">' . $membership['benefits'] . '</p>';
            echo '<div style="background: #FFD700; color: #333; padding: 8px 15px; border-radius: 20px; display: inline-block; font-weight: bold; margin-top: 10px;">';
            echo '<i class="bi bi-coin me-2"></i>' . $membership['price'];
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
        echo '</section>';
    }
}

require_once(BODY_DJ_PATH . 'dj_radio.php');
$bodyHome = new BodyHome();
$bodyHome->render();
