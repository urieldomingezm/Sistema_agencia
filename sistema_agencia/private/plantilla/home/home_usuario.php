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
        <header class="bg-primary text-white py-5 mb-4 shadow">
            <div class="container text-center">
                <h1 class="display-4 mb-3 fw-bold">
                    <i class="bi bi-star-fill me-2 text-warning"></i> Agencia Shein <i class="bi bi-star-fill ms-2 text-warning"></i>
                </h1>
                <p class="lead mb-0 fs-4">
                    <span class="badge bg-light text-primary rounded-pill px-3 py-2">
                        <i class="bi bi-person-circle me-2"></i>Bienvenido <?= $username ?>
                    </span>
                </p>
            </div>
        </header>
    <?php
    }

    private function renderTopUsersSection()
    {
        $topUsers = [];

        try {
            $topManager = new TopEncargados();
            $topUsers = $topManager->getTopEncargados(3);
        } catch (Exception $e) {
            error_log("Error al obtener el top de encargados: " . $e->getMessage());
        }

        $formattedTopUsers = [];
        $rankColors = ['bg-warning text-dark', 'bg-secondary', 'bg-danger'];
        $rankIcons = ['bi-trophy-fill', 'bi-award-fill', 'bi-medal-fill'];
        $rankNames = ['1er Lugar', '2do Lugar', '3er Lugar'];

        foreach ($topUsers as $index => $user) {
            if ($index < 3) {
                $formattedTopUsers[] = [
                    'name' => $user['usuario'],
                    'rank' => $rankNames[$index],
                    'score' => $user['total_acciones'],
                    'badge_class' => $rankColors[$index],
                    'icon' => $rankIcons[$index]
                ];
            }
        }

    ?>
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold text-primary mb-3">
                        <i class="bi bi-trophy-fill me-2"></i>Top 3 Encargados
                    </h2>
                    <p class="lead text-muted">Los mejores miembros de nuestro equipo</p>
                </div>
                
                <div class="row g-4 justify-content-center">
                    <?php if (!empty($formattedTopUsers)): ?>
                        <?php foreach ($formattedTopUsers as $index => $user): ?>
                            <div class="col-12 col-md-4">
                                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                                    <div class="card-header py-3 <?= $user['badge_class'] ?>">
                                        <h3 class="h5 mb-0 text-center text-white fw-bold">
                                            <i class="bi <?= $user['icon'] ?> me-2"></i><?= $user['rank'] ?>
                                        </h3>
                                    </div>
                                    <div class="card-body text-center p-4">
                                        <div class="mb-4">
                                            <img loading="lazy" src="https://www.habbo.es/habbo-imaging/avatarimage?user=<?= urlencode($user['name']) ?>&amp;headonly=1&amp;head_direction=3&amp;size=m" 
                                                 alt="<?= htmlspecialchars($user['name']) ?>" 
                                                 class="rounded-circle border border-4 border-primary mb-3 img-thumbnail" 
                                                 style="width: 120px; height: 120px; object-fit: cover;">
                                            <h4 class="h5 mb-2 fw-bold"><?= htmlspecialchars($user['name']) ?></h4>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <span class="badge bg-primary rounded-pill px-3 py-2 fs-6">
                                                    <i class="bi bi-check2-circle me-2"></i><?= htmlspecialchars($user['score']) ?> Acciones
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 col-md-8">
                            <div class="alert alert-info text-center py-4">
                                <i class="bi bi-info-circle-fill fs-1 d-block mb-3"></i>
                                <h3 class="h4">No hay datos disponibles</h3>
                                <p class="mb-0">Pronto tendremos información sobre los mejores encargados</p>
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
        <section class="py-5 bg-white">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold text-primary mb-3">
                        <i class="bi bi-megaphone-fill me-2"></i>Eventos y Noticias
                    </h2>
                    <p class="lead text-muted">Mantente informado de nuestras actividades</p>
                </div>
                
                <div class="row g-4">
                    <?php foreach ($events as $event): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                                <div class="position-relative">
                                    <img src="<?= $event['image'] ?>" class="card-img-top" style="height: 180px; object-fit: cover;" alt="<?= htmlspecialchars($event['title']) ?>">
                                    <div class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 rounded-bl">
                                        <i class="bi bi-calendar-event me-1"></i> <?= $event['date'] ?>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="card-title h5 fw-bold text-primary"><?= $event['title'] ?></h3>
                                    <p class="card-text text-muted"><?= $event['description'] ?></p>
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
                                    <button class="btn btn-outline-primary w-100">
                                        <i class="bi bi-info-circle me-2"></i>Más información
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-arrow-right-circle me-2"></i>Ver todos los eventos
                    </a>
                </div>
            </div>
        </section>
    <?php
    }

    private function renderPaydaySection()
    {
        $countries = [
            ['name' => 'México', 'flag' => 'https://flagcdn.com/mx.svg', 'paytime' => '14:00'],
            ['name' => 'Argentina', 'flag' => 'https://flagcdn.com/ar.svg', 'paytime' => '17:00'],
            ['name' => 'Colombia', 'flag' => 'https://flagcdn.com/co.svg', 'paytime' => '15:00'],
            ['name' => 'Perú', 'flag' => 'https://flagcdn.com/pe.svg', 'paytime' => '15:00'],
            ['name' => 'Chile', 'flag' => 'https://flagcdn.com/cl.svg', 'paytime' => '16:00'],
            ['name' => 'Brasil', 'flag' => 'https://flagcdn.com/br.svg', 'paytime' => '17:00'],
            ['name' => 'España', 'flag' => 'https://flagcdn.com/es.svg', 'paytime' => '22:00'],
            ['name' => 'Estados Unidos', 'flag' => 'https://flagcdn.com/us.svg', 'paytime' => '14:00'],
        ];

    ?>
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold text-primary mb-3">
                        <i class="bi bi-clock-history me-2"></i>Horarios de Pago
                    </h2>
                    <p class="lead text-muted">Consulta los horarios según tu país</p>
                </div>
                
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
                                            <div class="card h-100 border-0 shadow-sm">
                                                <div class="card-body text-center p-4">
                                                    <img src="<?= $country['flag'] ?>" class="img-fluid mb-3" style="height: 80px; width: auto;" alt="<?= htmlspecialchars($country['name']) ?>">
                                                    <h3 class="h5 fw-bold text-primary mb-3"><?= $country['name'] ?></h3>
                                                    <div class="d-flex align-items-center justify-content-center bg-primary text-white rounded-pill py-2 px-4">
                                                        <i class="bi bi-clock-fill me-2 fs-4"></i>
                                                        <span class="fs-4 fw-bold"><?= $country['paytime'] ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <button class="btn btn-outline-primary mx-1" type="button" data-bs-target="#paydayCarousel" data-bs-slide="prev">
                            <i class="bi bi-chevron-left"></i> Anterior
                        </button>
                        <button class="btn btn-outline-primary mx-1" type="button" data-bs-target="#paydayCarousel" data-bs-slide="next">
                            Siguiente <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
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
                'benefits' => ['Todos beneficios Silver', 'Fila VIP prioritaria', 'Guarda paga 72h', 'Misión libre'],
                'image' => '/usuario/rangos/image/membresias/gold.png',
                'price' => '40 créditos/mes',
                'badge' => 'bg-warning text-dark'
            ],
            [
                'title' => 'Membresía Silver',
                'benefits' => ['Todos beneficios Bronce', 'Reducción requisitos', 'Acceso anticipado'],
                'image' => '/usuario/rangos/image/membresias/silver.png',
                'price' => '34 créditos/mes',
                'badge' => 'bg-secondary text-white'
            ],
            [
                'title' => 'Membresía Bronce',
                'benefits' => ['Ropa libre', 'Chat ilimitado', 'Baile y efectos', 'Soporte básico'],
                'image' => '/usuario/rangos/image/membresias/premim.png',
                'price' => '28 créditos/mes',
                'badge' => 'bg-danger text-white'
            ],
        ];

    ?>
        <section class="py-5 bg-white">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold text-primary mb-3">
                        <i class="bi bi-gem me-2"></i>Membresías Premium
                    </h2>
                    <p class="lead text-muted">Elige el plan que mejor se adapte a tus necesidades</p>
                </div>
                
                <div class="row g-4 justify-content-center">
                    <?php foreach ($memberships as $membership): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                                <div class="card-header py-3 <?= $membership['badge'] ?>">
                                    <h3 class="h4 mb-0 text-center text-white fw-bold"><?= $membership['title'] ?></h3>
                                </div>
                                <div class="card-body text-center p-4">
                                    <img src="<?= $membership['image'] ?>" class="img-fluid mb-4" style="height: 100px; width: auto;" alt="<?= htmlspecialchars($membership['title']) ?>">
                                    
                                    <ul class="list-unstyled text-start mb-4">
                                        <?php foreach ($membership['benefits'] as $benefit): ?>
                                            <li class="mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                <?= $benefit ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    
                                    <div class="d-grid">
                                        <button class="btn btn-primary py-2">
                                            <i class="bi bi-credit-card me-2"></i>
                                            <?= $membership['price'] ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="text-center mt-5">
                    <div class="alert alert-info d-inline-block">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Todas las membresías incluyen soporte prioritario y regalos exclusivos
                    </div>
                </div>
            </div>
        </section>
<?php
    }
}

require_once(BODY_DJ_PATH . 'dj_radio.php');
$bodyHome = new BodyHome();
$bodyHome->render();