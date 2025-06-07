<?php

class BodyHome
{
    public function render()
    {
        echo '<body class="d-flex flex-column h-100 bg-light" data-bs-theme="light">';
        $this->renderLoader();
        $this->renderHeader();
        $this->renderAboutSection();
        $this->renderVideosSection();
        $this->renderTeamSection();
        $this->renderBlogSection();
        $this->renderHabboPlatesSection();
        $this->renderEventsSection();
        $this->renderThemeScript();
        echo '</body>';
    }

    private function renderLoader()
    {
        echo '<div id="preloader" class="preloader">
            <div class="eyes-loader">
                <div class="eyes-container">
                    <div class="eye left-eye"></div>
                    <div class="eye right-eye"></div>
                </div>
                <div class="loading-text">Bienvenido a Agencia Shein</div>
            </div>
        </div>
        
        <style>
        .eye {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: radial-gradient(circle, #ff0000 0%, #8b0000 100%);
            box-shadow: 0 0 20px 5px rgba(255, 0, 0, 0.8);
            position: relative;
            animation: glow 1.5s infinite alternate, blink 3s infinite;
        }
    
        @keyframes blink {
            0%, 100% { transform: scaleY(1); }
            50% { transform: scaleY(0.1); }
        }
    
        @keyframes glow {
            0% {
                box-shadow: 0 0 20px 5px rgba(255, 0, 0, 0.8),
                            0 0 40px 15px rgba(255, 0, 0, 0.6),
                            0 0 60px 25px rgba(255, 0, 0, 0.4);
            }
            100% {
                box-shadow: 0 0 40px 15px rgba(255, 0, 0, 1),
                            0 0 60px 25px rgba(255, 0, 0, 0.8),
                            0 0 80px 35px rgba(255, 0, 0, 0.6);
            }
        }
        </style>
        
        <style>
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #000000;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease-out;
        }
        
        .eyes-loader {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .eyes-container {
            display: flex;
            gap: 40px;
        }
        
        .eye {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: radial-gradient(circle, #ff0000 0%, #8b0000 100%);
            box-shadow: 0 0 20px 5px rgba(255, 0, 0, 0.8);
            position: relative;
            animation: glow 1.5s infinite alternate;
        }
        
        @keyframes glow {
            0% { transform: scale(1); box-shadow: 0 0 20px 5px rgba(255, 0, 0, 0.8); }
            100% { transform: scale(1.1); box-shadow: 0 0 40px 10px rgba(255, 0, 0, 1); }
        }
        
        .loading-text {
            margin-top: 30px;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            animation: text-glow 1.5s infinite alternate;
            text-align: center;
        }
        
        @keyframes text-glow {
            0% { text-shadow: 0 0 5px #ff0000, 0 0 10px #ff0000; }
            100% { text-shadow: 0 0 10px #ff0000, 0 0 20px #ff0000, 0 0 30px #ff0000; }
        }
        </style>
        
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                const preloader = document.getElementById("preloader");
                preloader.style.opacity = "0";
                setTimeout(function() {
                    preloader.style.display = "none";
                }, 500);
            }, 1500);
        });
        </script>';
    }

    private function renderHeader()
    {
        echo '<main class="flex-shrink-0">
            <header class="bg-primary text-white py-5 position-relative overflow-hidden">
                <div class="position-absolute top-0 end-0 opacity-25">
                    <i class="bi bi-stars display-1"></i>
                </div>
                <div class="position-absolute bottom-0 start-0 opacity-25">
                    <i class="bi bi-stars display-1"></i>
                </div>
                <div class="container text-center position-relative">
                    <h1 class="display-3 fw-bold mb-4">
                        <i class="bi bi-stars me-3"></i>Agencia Shein<i class="bi bi-stars ms-3"></i>
                    </h1>
                    <p class="lead fs-4 mb-4">La mejor comunidad de Habbo Hotel con más de 5 años de experiencia</p>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="/login.php" class="btn btn-warning btn-lg rounded-pill px-4 fw-bold">
                            <i class="bi bi-door-open me-2"></i>¡Únete ahora!
                        </a>
                        <a href="#about" class="btn btn-outline-light btn-lg rounded-pill px-4">
                            <i class="bi bi-info-circle me-2"></i>Conócenos
                        </a>
                    </div>
                </div>
            </header>
            
            <div class="bg-dark py-2">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-warning fw-bold">
                            <i class="bi bi-people-fill me-2"></i>+500 miembros activos
                        </div>
                        <div class="text-white-50">
                            <span class="me-3"><i class="bi bi-calendar-check me-1"></i>Eventos diarios</span>
                            <span><i class="bi bi-trophy me-1"></i>Premios exclusivos</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>';
    }

    private function renderTeamSection()
    {
        $teamMembers = [
            [
                'id' => '1',
                'name' => 'Jo.C',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Jo.C&headonly=1&head_direction=3&size=sl1',
                'rank' => 'Founder',
                'color' => 'danger'
            ],
            [
                'id' => '2',
                'name' => 'Snotra',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Snotra&headonly=1&head_direction=3&size=sl',
                'rank' => 'Founder',
                'color' => 'danger'
            ],
            [
                'id' => '4',
                'name' => 'BigBarneyStinso',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=BigBarneyStinso&headonly=1&head_direction=3&size=sl',
                'rank' => 'Manager',
                'color' => 'warning'
            ],
            [
                'id' => '5',
                'name' => 'Nefita',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Nefita&headonly=1&head_direction=3&size=sl',
                'rank' => 'Manager',
                'color' => 'warning'
            ],
            [
                'id' => '6',
                'name' => 'juancBQ',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=juancBQ&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administrador',
                'color' => 'success'
            ],
            [
                'id' => '7',
                'name' => 'mutilla_',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=mutilla_&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administrador',
                'color' => 'success'
            ],
            [
                'id' => '8',
                'name' => 'Vanderlind',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Vanderlind&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administrador',
                'color' => 'success'
            ],
            [
                'id' => '9',
                'name' => 'maria51162',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=maria51162&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administradora',
                'color' => 'success'
            ],
        ];

        echo '<section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold text-primary mb-3">
                        <i class="bi bi-people-fill me-2"></i>Nuestro Equipo
                    </h2>
                    <p class="lead text-muted">Conoce al equipo que hace posible Agencia Shein</p>
                </div>
                <div class="row justify-content-center g-4">';

        foreach ($teamMembers as $member) {
            echo '<div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="card border-0 shadow-sm h-100 hover-scale">
                    <div class="card-header bg-'.$member['color'].' text-white text-center py-2">
                        <i class="bi bi-person-badge"></i> '.$member['rank'].'
                    </div>
                    <div class="card-body text-center p-3">
                        <img src="' . $member['image'] . '" alt="Avatar de ' . htmlspecialchars($member['name']) . '" 
                             class="img-fluid rounded-circle mb-3 shadow" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid var(--bs-'.$member['color'].');">
                        <h5 class="card-title mb-1 fw-bold">' . $member['name'] . '</h5>
                    </div>
                </div>
            </div>';
        }

        echo '</div></div></section>';
    }

    private function renderEventsSection()
    {
        $events = [
            [
                'title' => 'Fiesta de Bienvenida', 
                'description' => 'Conoce a todos los miembros de Agencia Shein en nuestra fiesta de bienvenida', 
                'date' => '15 de Marzo, 2025', 
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20party%20room%20with%20lots%20of%20avatars%20dancing&aspect=16:9',
                'badge' => 'Nuevo'
            ],
            [
                'title' => 'Concurso de Construcción', 
                'description' => 'Muestra tus habilidades de construcción y gana premios increíbles', 
                'date' => '22 de Marzo, 2025', 
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20building%20competition%20with%20furniture%20and%20decorations&aspect=16:9',
                'badge' => 'Popular'
            ],
            [
                'title' => 'Carrera de Obstáculos', 
                'description' => 'Supera todos los obstáculos en el menor tiempo posible', 
                'date' => '29 de Marzo, 2025', 
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20obstacle%20course%20with%20traps%20and%20challenges&aspect=16:9',
                'badge' => 'Próximamente'
            ],
        ];

        echo '<section class="py-5 bg-primary bg-opacity-10">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold text-primary mb-3">
                        <i class="bi bi-calendar-event me-2"></i>Próximos Eventos
                    </h2>
                    <p class="lead text-muted">Participa en nuestras actividades exclusivas para miembros</p>
                </div>
                <div class="row g-4">';

        foreach ($events as $event) {
            echo '<div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm overflow-hidden hover-scale">
                    <div class="position-relative">
                        <img src="' . $event['image'] . '" class="card-img-top" alt="' . htmlspecialchars($event['title']) . '" style="height: 200px; object-fit: cover;">
                        '.($event['badge'] ? '<span class="position-absolute top-0 end-0 m-2 badge bg-warning text-dark">'.$event['badge'].'</span>' : '').'
                    </div>
                    <div class="card-body">
                        <h3 class="card-title h5 fw-bold">' . $event['title'] . '</h3>
                        <p class="card-text text-muted">' . $event['description'] . '</p>
                        <ul class="list-unstyled">
                            <li class="mb-1"><i class="bi bi-check-circle-fill text-primary me-2"></i>Premios exclusivos</li>
                            <li class="mb-1"><i class="bi bi-check-circle-fill text-primary me-2"></i>Diversión garantizada</li>
                            <li><i class="bi bi-check-circle-fill text-primary me-2"></i>Para todos los niveles</li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                        <small class="text-body-secondary"><i class="bi bi-calendar-date me-1"></i>' . $event['date'] . '</small>
                        <a href="#" class="btn btn-sm btn-primary rounded-pill">Más info</a>
                    </div>
                </div>
            </div>';
        }

        echo '</div>
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-outline-primary btn-lg px-4">
                        <i class="bi bi-list-ul me-2"></i>Ver todos los eventos
                    </a>
                </div>
            </div>
        </section>';
    }

    private function renderAboutSection()
    {
        echo '<section class="py-5" id="about">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold text-primary mb-3">
                        <i class="bi bi-info-circle me-2"></i>Sobre Nosotros
                    </h2>
                    <p class="lead text-muted">Descubre lo que hace especial a nuestra comunidad</p>
                </div>
                <div class="row align-items-center g-5">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div class="rounded shadow overflow-hidden">
                            <img src="https://i.postimg.cc/267B81Gt/agencia2.webp" alt="Imagen de la comunidad Agencia Shein en Habbo" 
                                 class="img-fluid w-100">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="ps-lg-4">
                            <div class="mb-4">
                                <h3 class="h4 fw-bold mb-3 text-primary">
                                    <i class="bi bi-hourglass-split me-2"></i>Nuestra Historia
                                </h3>
                                <p class="text-body-secondary">Agencia Shein es una comunidad vibrante en Habbo Hotel que se dedica a crear experiencias únicas para nuestros usuarios. Desde nuestro inicio en 2025, hemos crecido hasta convertirnos en una de las agencias más reconocidas en el mundo de Habbo.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h3 class="h4 fw-bold mb-3 text-primary">
                                    <i class="bi bi-bullseye me-2"></i>Nuestra Misión
                                </h3>
                                <p class="text-body-secondary">Nuestro objetivo es proporcionar un espacio seguro y divertido donde los usuarios puedan interactuar, participar en eventos emocionantes y desarrollar sus habilidades dentro del juego.</p>
                            </div>
                            
                            <div class="bg-light p-4 rounded border">
                                <h4 class="h5 fw-bold mb-3">
                                    <i class="bi bi-star-fill text-warning me-2"></i>¿Por qué unirte?
                                </h4>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Comunidad activa y amigable</li>
                                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Eventos exclusivos semanales</li>
                                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Sistema de recompensas</li>
                                    <li><i class="bi bi-check-circle-fill text-success me-2"></i>Soporte y ayuda constante</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>';
    }

    private function renderBlogSection()
    {
        $noticias = [
            [
                'title' => 'Nuevas Actualizaciones',
                'description' => 'Descubre las últimas novedades en Habbo Hotel y cómo afectan a nuestra comunidad',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20news&aspect=16:9',
                'category' => 'Actualizaciones',
                'date' => 'Hace 2 días',
                'color' => 'info'
            ],
            [
                'title' => 'Nuevo Sistema de Recompensas',
                'description' => 'Conoce el nuevo sistema de recompensas diarias y cómo beneficiarte de él',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20rewards&aspect=16:9',
                'category' => 'Sistema',
                'date' => 'Hace 1 semana',
                'color' => 'success'
            ],
            [
                'title' => 'Mejoras en la Comunidad',
                'description' => 'Descubre las mejoras implementadas en la comunidad y nuevas funcionalidades',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20community&aspect=16:9',
                'category' => 'Anuncios',
                'date' => 'Hace 3 días',
                'color' => 'warning'
            ]
        ];

        echo '<section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold text-primary mb-3">
                        <i class="bi bi-newspaper me-2"></i>Últimas Noticias
                    </h2>
                    <p class="lead text-muted">Mantente informado sobre las novedades de Agencia Shein</p>
                </div>
                <div class="row g-4">';

        foreach ($noticias as $noticia) {
            echo '<div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm hover-scale">
                    <div class="position-relative">
                        <img src="' . $noticia['image'] . '" class="card-img-top" alt="' . htmlspecialchars($noticia['title']) . '" style="height: 200px; object-fit: cover;">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-'.$noticia['color'].'">'.$noticia['category'].'</span>
                    </div>
                    <div class="card-body">
                        <small class="text-muted d-block mb-2"><i class="bi bi-clock me-1"></i>'.$noticia['date'].'</small>
                        <h3 class="card-title h5 fw-bold">' . $noticia['title'] . '</h3>
                        <p class="card-text text-muted">' . $noticia['description'] . '</p>
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <a href="#" class="btn btn-outline-primary btn-sm stretched-link">
                            <i class="bi bi-arrow-right me-1"></i>Leer más
                        </a>
                    </div>
                </div>
            </div>';
        }

        echo '</div>
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-primary btn-lg px-4">
                        <i class="bi bi-journal-text me-2"></i>Ver todas las noticias
                    </a>
                </div>
            </div>
        </section>';
    }

    private function renderHabboPlatesSection()
    {
        $plates = [
            [
                'name' => 'Placa de Oro',
                'description' => 'La nueva placa de oro para los mejores constructores de la comunidad',
                'release_date' => '10 de Octubre, 2024',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20gold%20plate&aspect=16:9',
                'icon' => 'bi-trophy',
                'color' => 'warning'
            ],
            [
                'name' => 'Placa de Plata',
                'description' => 'Placa de plata para los usuarios más destacados y activos',
                'release_date' => '15 de Noviembre, 2024',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20silver%20plate&aspect=16:9',
                'icon' => 'bi-award',
                'color' => 'secondary'
            ],
            [
                'name' => 'Placa de Bronce',
                'description' => 'Placa de bronce para reconocer a los usuarios más activos',
                'release_date' => '20 de Diciembre, 2024',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20bronze%20plate&aspect=16:9',
                'icon' => 'bi-star',
                'color' => 'danger'
            ]
        ];

        echo '<section class="py-5 bg-dark text-white">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold text-warning mb-3">
                        <i class="bi bi-award me-2"></i>Nuevas Placas de Habbo
                    </h2>
                    <p class="lead text-white-50">Reconocimientos exclusivos para nuestros miembros</p>
                </div>
                <div class="row g-4">';

        foreach ($plates as $plate) {
            echo '<div class="col-md-4">
                <div class="card h-100 border-0 bg-dark bg-opacity-50 hover-scale">
                    <div class="card-header bg-'.$plate['color'].' bg-opacity-25 border-0 text-center py-3">
                        <i class="bi '.$plate['icon'].' display-4"></i>
                    </div>
                    <div class="card-body text-center">
                        <h3 class="card-title h4 fw-bold mb-3">' . $plate['name'] . '</h3>
                        <p class="card-text text-white-50">' . $plate['description'] . '</p>
                        <div class="mt-4">
                            <span class="badge bg-'.$plate['color'].' text-dark">
                                <i class="bi bi-calendar-date me-1"></i>' . $plate['release_date'] . '
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top-0 text-center">
                        <button class="btn btn-sm btn-outline-light rounded-pill">
                            <i class="bi bi-info-circle me-1"></i>Cómo obtenerla
                        </button>
                    </div>
                </div>
            </div>';
        }

        echo '</div>
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-warning btn-lg px-4">
                        <i class="bi bi-trophy me-2"></i>Ver sistema de recompensas
                    </a>
                </div>
            </div>
        </section>';
    }

    private function renderVideosSection()
    {
        echo '<section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold text-primary mb-3">
                        <i class="bi bi-play-circle-fill me-2"></i>Tutoriales y Videos
                    </h2>
                    <p class="lead text-muted">Aprende a sacar el máximo provecho a Agencia Shein</p>
                </div>
                
                <div class="row justify-content-center">
                    <div id="videosCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            
                            <div class="carousel-item active">
                                <div class="row justify-content-center g-4">
                                    <div class="col-lg-6">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-header bg-primary text-white">
                                                <i class="bi bi-film me-2"></i>Video Tutorial
                                            </div>
                                            <div class="ratio ratio-16x9">
                                                <iframe src="https://www.youtube.com/embed/g0ZMA5vAgyc?si=N5r-RrN_iGGh-LdH" 
                                                        title="YouTube video player" frameborder="0" 
                                                        allowfullscreen class="rounded-bottom"></iframe>
                                            </div>
                                            <div class="card-body">
                                                <h3 class="h5 fw-bold">Introducción a Agencia Shein</h3>
                                                <p class="text-body-secondary">Aprende las funcionalidades básicas de nuestra web y cómo navegar por ella</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted"><i class="bi bi-clock me-1"></i>15 min</small>
                                                    <span class="badge bg-primary">Nuevo</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-header bg-primary text-white">
                                                <i class="bi bi-film me-2"></i>Video Tutorial
                                            </div>
                                            <div class="ratio ratio-16x9 bg-body-secondary d-flex align-items-center justify-content-center">
                                                <i class="bi bi-play-circle-fill text-primary" style="font-size: 3rem;"></i>
                                            </div>
                                            <div class="card-body">
                                                <h3 class="h5 fw-bold">Gestión de Pagos y Ascensos</h3>
                                                <p class="text-body-secondary">Aprende a gestionar pagos, tiempos de servicio y ascensos de rango</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted"><i class="bi bi-clock me-1"></i>Próximamente</small>
                                                    <span class="badge bg-secondary">En producción</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="row justify-content-center g-4">
                                    <div class="col-lg-6">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-header bg-primary text-white">
                                                <i class="bi bi-film me-2"></i>Video Tutorial
                                            </div>
                                            <div class="ratio ratio-16x9 bg-body-secondary d-flex align-items-center justify-content-center">
                                                <i class="bi bi-play-circle-fill text-primary" style="font-size: 3rem;"></i>
                                            </div>
                                            <div class="card-body">
                                                <h3 class="h5 fw-bold">Participación en Eventos</h3>
                                                <p class="text-body-secondary">Cómo participar y ganar en nuestros eventos exclusivos</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted"><i class="bi bi-clock me-1"></i>Próximamente</small>
                                                    <span class="badge bg-secondary">En producción</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="card-header bg-primary text-white">
                                                <i class="bi bi-film me-2"></i>Video Tutorial
                                            </div>
                                            <div class="ratio ratio-16x9 bg-body-secondary d-flex align-items-center justify-content-center">
                                                <i class="bi bi-play-circle-fill text-primary" style="font-size: 3rem;"></i>
                                            </div>
                                            <div class="card-body">
                                                <h3 class="h5 fw-bold">Sistema de Recompensas</h3>
                                                <p class="text-body-secondary">Cómo acumular puntos y canjear recompensas exclusivas</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted"><i class="bi bi-clock me-1"></i>Próximamente</small>
                                                    <span class="badge bg-secondary">En producción</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button class="carousel-control-prev" type="button" data-bs-target="#videosCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-primary rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#videosCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-primary rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-outline-primary btn-lg px-4">
                        <i class="bi bi-collection-play me-2"></i>Ver todos los tutoriales
                    </a>
                </div>
            </div>
        </section>';
    }

    private function renderThemeScript()
    {
        echo '<style>
        .hover-scale {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-scale:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        </style>
        
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Comprobar preferencia del usuario
            const preferredTheme = localStorage.getItem("theme") || "light";
            document.body.setAttribute("data-bs-theme", preferredTheme);
            
            // Configurar botones del toggle
            document.querySelectorAll(".theme-toggle").forEach(button => {
                button.addEventListener("click", function() {
                    const theme = this.getAttribute("data-theme");
                    document.body.setAttribute("data-bs-theme", theme);
                    localStorage.setItem("theme", theme);
                });
            });
        });
        </script>';
    }
}

$bodyHome = new BodyHome();
$bodyHome->render();