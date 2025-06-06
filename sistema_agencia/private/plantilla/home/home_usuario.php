<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

if (!defined('PROCESOS_MEJOR_TOP')) {
    define('PROCESOS_MEJOR_TOP', PRIVATE_PATH . 'procesos/gestion_primeros_lugares/');
}

require_once(PROCESOS_MEJOR_TOP . 'mostrar_top.php');

class BodyHome
{
    private $userData;

    public function __construct()
    {
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
        <div class="container-fluid px-0">
            <?php
            $this->renderHeader();
            $this->renderTopUsersSection();
            $this->renderEventsSection();
            $this->renderPaydaySection();
            $this->renderMembershipSection();
            ?>
        </div>
    <?php
    }

    private function renderHeader()
    {
        $username = htmlspecialchars($this->userData['username']);
    ?>
        <header class="bg-dark text-white py-4 mb-4 shadow">
            <div class="container text-center">
                <h1 class="display-5 mb-3 fw-bold">
                    <i class="bi bi-star-fill me-2 text-warning"></i> Agencia Shein <i class="bi bi-star-fill ms-2 text-warning"></i>
                </h1>
                <p class="lead mb-4 fs-5">Bienvenido <?= $username ?></p>
                <div class="alert alert-dark mb-0 alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>
                        <strong>¡Actualización del Sistema!</strong>
                        <p class="mb-2 mt-1">Se ha implementado el sistema de pagos semanales y actualización de rangos.</p>
                        <small class="text-muted">Ver. 20.1</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </header>
    <?php
    }

    private function renderTopUsersSection()
    {
        $topUsers = [];

        try {
            $topManager = new TopEncargados();
            $topUsers = $topManager->getTopEncargados(3); // Limitar a 3 resultados
        } catch (Exception $e) {
            error_log("Error al obtener el top de encargados: " . $e->getMessage());
        }

        $formattedTopUsers = [];
        $rankColors = ['#FFD700', '#C0C0C0', '#CD7F32'];
        $rankNames = ['1er Lugar', '2do Lugar', '3er Lugar'];

        foreach ($topUsers as $index => $user) {
            // Solo procesar los primeros 3 lugares
            if ($index < 3) {
                $formattedTopUsers[] = [
                    'name' => $user['usuario'],
                    'rank' => $rankNames[$index], // Usar nombres fijos
                    'score' => $user['total_acciones'],
                    'icon_color' => $rankColors[$index]
                ];
            }
        }

    ?>
        <section class="py-5 bg-secondary bg-opacity-10">
            <div class="container">
                <h2 class="text-center mb-5 display-6 fw-bold text-white">
                    <i class="bi bi-trophy-fill me-2 text-warning"></i> Top 3 Encargados <i class="bi bi-trophy-fill ms-2 text-warning"></i>
                </h2>
                <div class="row g-4 justify-content-center">
                    <?php if (!empty($formattedTopUsers)): ?>
                        <?php foreach ($formattedTopUsers as $user): ?>
                            <div class="col-12 col-md-4">
                                <div class="card h-100 border-0 shadow-sm bg-dark text-white">
                                    <div class="card-body text-center p-4">
                                        <i class="bi bi-trophy-fill display-4 mb-3" style="color: <?= $user['icon_color'] ?>"></i>
                                        <div class="mb-3">
                                            <img loading="lazy" src="https://www.habbo.es/habbo-imaging/avatarimage?user=<?= urlencode($user['name']) ?>&amp;headonly=1&amp;head_direction=3&amp;size=m" alt="<?= htmlspecialchars($user['name']) ?>" class="rounded-circle mb-2 img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                            <h3 class="h4 mb-0 fw-bold"><?= htmlspecialchars($user['name']) ?></h3>
                                        </div>
                                        <p class="text-muted mb-2"><?= htmlspecialchars($user['rank']) ?></p>
                                        <span class="badge bg-primary rounded-pill fs-5"><?= htmlspecialchars($user['score']) ?> Acciones</span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-dark text-center text-white">
                                No hay datos disponibles para mostrar el top de encargados.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php
    }

    private function renderEventsSection()
    {
        $events = [
            ['title' => 'Fiesta de Bienvenida', 'description' => 'Conoce a todos los miembros de Agencia Atenas en nuestra fiesta de bienvenida', 'date' => '15 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20party%20room%20with%20lots%20of%20avatars%20dancing&aspect=16:9'],
            ['title' => 'Construcción', 'description' => 'Muestra tus habilidades de construcción y gana premios increíbles', 'date' => '22 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20building%20competition%20with%20furniture%20and%20decorations&aspect=16:9'],
            ['title' => 'Carrera de Obstáculos', 'description' => 'Supera todos los obstáculos en el menor tiempo posible', 'date' => '29 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20obstacle%20course%20with%20traps%20and%20challenges&aspect=16:9'],
        ];

    ?>
        <section class="py-5 bg-dark">
            <div class="container">
                <h2 class="text-center mb-5 display-6 fw-bold text-white">
                    <i class="bi bi-newspaper me-2 text-primary"></i> Noticias <i class="bi bi-newspaper ms-2 text-primary"></i>
                </h2>
                <div class="row g-4">
                    <?php foreach ($events as $event): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm bg-secondary text-white">
                                <img src="<?= $event['image'] ?>" class="card-img-top" style="height: 180px; object-fit: cover;" alt="<?= htmlspecialchars($event['title']) ?>">
                                <div class="card-body">
                                    <h3 class="card-title h5 fw-bold"><?= $event['title'] ?></h3>
                                    <p class="card-text text-white-50"><?= $event['description'] ?></p>
                                </div>
                                <div class="card-footer bg-dark border-top-0">
                                    <span class="badge bg-success rounded-pill"><?= $event['date'] ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php
    }

    private function renderPaydaySection()
    {
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

    ?>
        <section class="py-5 bg-secondary bg-opacity-10">
            <div class="container">
                <h2 class="text-center mb-5 display-6 fw-bold text-white">
                    <i class="bi bi-clock-history me-2 text-primary"></i> Horarios de Pago <i class="bi bi-clock-history ms-2 text-primary"></i>
                </h2>
                <div id="paydayCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $chunks = array_chunk($countries, 3);
                        foreach ($chunks as $index => $chunk):
                        ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <div class="row g-4 justify-content-center">
                                    <?php foreach ($chunk as $country): ?>
                                        <div class="col-md-4">
                                            <div class="card h-100 border-0 shadow-sm bg-dark text-white">
                                                <div class="card-body text-center">
                                                    <img src="<?= $country['flag'] ?>" class="img-fluid mb-3" style="height: 80px;" alt="<?= htmlspecialchars($country['name']) ?>">
                                                    <h3 class="h5 fw-bold"><?= $country['name'] ?></h3>
                                                    <div class="d-flex align-items-center justify-content-center mt-3">
                                                        <i class="bi bi-clock-fill me-2 text-primary"></i>
                                                        <span class="fs-5 fw-bold"><?= $country['paytime'] ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#paydayCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#paydayCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section>
<?php
    }

    private function renderMembershipSection()
    {
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

        echo '<section class="py-5 bg-dark">';
        echo '<div class="container text-center">';
        echo '<h2 class="text-white mb-4 display-6 fw-bold"><i class="bi bi-gem me-2 text-primary"></i> Membresías Disponibles <i class="bi bi-gem ms-2 text-primary"></i></h2>';
        echo '<p class="text-white-50 mb-5">Elige la membresía que mejor se adapte a tus necesidades y disfruta de nuestros beneficios exclusivos.</p>';
        echo '<div id="membershipCarousel" class="carousel slide" data-bs-ride="carousel">';
        echo '<div class="carousel-inner">';

        $chunks = array_chunk($memberships, 3);
        foreach ($chunks as $index => $chunk) {
            echo '<div class="carousel-item' . ($index === 0 ? ' active' : '') . '">';
            echo '<div class="row justify-content-center">';

            foreach ($chunk as $membership) {
                echo '<div class="col-12 col-sm-6 col-md-4 mb-4">';
                echo '<div class="bg-secondary text-white p-4 rounded-3 shadow h-100">';
                echo '<img src="' . $membership['image'] . '" class="img-fluid rounded mb-3" style="height: 150px; object-fit: cover;" alt="Imagen de la membresía ' . htmlspecialchars($membership['title']) . '">';
                echo '<h3 class="h5 fw-bold">' . $membership['title'] . '</h3>';
                echo '<p class="text-white-50">' . $membership['benefits'] . '</p>';
                echo '<div class="badge bg-warning text-dark rounded-pill py-2 px-3 mt-2">';
                echo '<i class="bi bi-coin me-2"></i>' . $membership['price'];
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '<button class="carousel-control-prev" type="button" data-bs-target="#membershipCarousel" data-bs-slide="prev">';
        echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
        echo '<span class="visually-hidden">Previous</span>';
        echo '</button>';
        echo '<button class="carousel-control-next" type="button" data-bs-target="#membershipCarousel" data-bs-slide="next">';
        echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
        echo '<span class="visually-hidden">Next</span>';
        echo '</button>';
        echo '</div>';
        echo '</div>';
        echo '</section>';
    }
}

require_once(BODY_DJ_PATH . 'dj_radio.php');
$bodyHome = new BodyHome();
$bodyHome->render();