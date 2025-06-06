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
        $this->renderFooter();
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
            <header class="bg-dark text-white py-5">
                <div class="container text-center">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="bi bi-stars me-2"></i>Agencia Shein<i class="bi bi-stars ms-2"></i>
                    </h1>
                    <p class="lead mb-4">La mejor comunidad de Habbo Hotel</p>
                    <a href="/login.php" class="btn btn-outline-light btn-lg rounded-pill px-4">¡Únete ahora!</a>
                </div>
            </header>
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
            ],
            [
                'id' => '2',
                'name' => 'Snotra',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Snotra&headonly=1&head_direction=3&size=sl',
                'rank' => 'Founder',
            ],
            [
                'id' => '4',
                'name' => 'BigBarneyStinso',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=BigBarneyStinso&headonly=1&head_direction=3&size=sl',
                'rank' => 'Manager',
            ],
            [
                'id' => '5',
                'name' => 'Nefita',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Nefita&headonly=1&head_direction=3&size=sl',
                'rank' => 'Manager',
            ],
            [
                'id' => '6',
                'name' => 'juancBQ',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=juancBQ&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administrador',
            ],
            [
                'id' => '7',
                'name' => 'mutilla_',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=mutilla_&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administrador',
            ],
            [
                'id' => '8',
                'name' => 'Vanderlind',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Vanderlind&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administrador',
            ],
            [
                'id' => '9',
                'name' => 'maria51162',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=maria51162&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administradora',
            ],
        ];

        echo '<section class="py-5">
            <div class="container">
                <h2 class="text-center mb-5 text-dark-emphasis">
                    <i class="bi bi-people-fill me-2"></i>
                    Nuestro Equipo
                    <i class="bi bi-people-fill ms-2"></i>
                </h2>
                <div class="row justify-content-center g-4">';

        foreach ($teamMembers as $member) {
            echo '<div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <img src="' . $member['image'] . '" alt="Avatar de ' . htmlspecialchars($member['name']) . '" 
                             class="img-fluid rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover; border: 2px solid #212529;">
                        <h5 class="card-title mb-1">' . $member['name'] . '</h5>
                        <small class="text-muted">' . $member['rank'] . '</small>
                    </div>
                </div>
            </div>';
        }

        echo '</div></div></section>';
    }

    private function renderEventsSection()
    {
        $events = [
            ['title' => 'Fiesta de Bienvenida', 'description' => 'Conoce a todos los miembros de Agencia Shein en nuestra fiesta de bienvenida', 'date' => '15 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20party%20room%20with%20lots%20of%20avatars%20dancing&aspect=16:9'],
            ['title' => 'Concurso de Construcción', 'description' => 'Muestra tus habilidades de construcción y gana premios increíbles', 'date' => '22 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20building%20competition%20with%20furniture%20and%20decorations&aspect=16:9'],
            ['title' => 'Carrera de Obstáculos', 'description' => 'Supera todos los obstáculos en el menor tiempo posible', 'date' => '29 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20obstacle%20course%20with%20traps%20and%20challenges&aspect=16:9'],
        ];

        echo '<section class="py-5 bg-body-tertiary">
            <div class="container">
                <h2 class="text-center mb-5 text-dark-emphasis">
                    <i class="bi bi-calendar-event me-2"></i>Próximos Eventos<i class="bi bi-calendar-event ms-2"></i>
                </h2>
                <div class="row g-4">';

        foreach ($events as $event) {
            echo '<div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="' . $event['image'] . '" class="card-img-top" alt="' . htmlspecialchars($event['title']) . '" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title h5">' . $event['title'] . '</h3>
                        <p class="card-text">' . $event['description'] . '</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <small class="text-body-secondary"><i class="bi bi-calendar-date me-1"></i>' . $event['date'] . '</small>
                    </div>
                </div>
            </div>';
        }

        echo '</div></div></section>';
    }

    private function renderAboutSection()
    {
        echo '<section class="py-5">
            <div class="container">
                <h2 class="text-center mb-5 text-dark-emphasis">
                    <i class="bi bi-info-circle me-2"></i>Sobre Nosotros<i class="bi bi-info-circle ms-2"></i>
                </h2>
                <div class="row align-items-center">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <img src="https://i.postimg.cc/267B81Gt/agencia2.webp" alt="Imagen de la comunidad Agencia Shein en Habbo" 
                             class="img-fluid rounded shadow">
                    </div>
                    <div class="col-md-6">
                        <h3 class="h4 mb-3">Nuestra Historia</h3>
                        <p class="text-body-secondary">Agencia Shein es una comunidad vibrante en Habbo Hotel que se dedica a crear experiencias únicas para nuestros usuarios. Desde nuestro inicio en 2025, hemos crecido hasta convertirnos en una de las agencias más reconocidas en el mundo de Habbo.</p>
                        
                        <h3 class="h4 mt-4 mb-3">Nuestra Misión</h3>
                        <p class="text-body-secondary">Nuestro objetivo es proporcionar un espacio seguro y divertido donde los usuarios puedan interactuar, participar en eventos emocionantes y desarrollar sus habilidades dentro del juego.</p>
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
                'description' => 'Descubre las últimas novedades en Habbo Hotel',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20news&aspect=16:9'
            ],
            [
                'title' => 'Nuevo Sistema de Recompensas',
                'description' => 'Conoce el nuevo sistema de recompensas diarias',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20rewards&aspect=16:9'
            ],
            [
                'title' => 'Mejoras en la Comunidad',
                'description' => 'Descubre las mejoras implementadas en la comunidad',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20community&aspect=16:9'
            ]
        ];

        echo '<section class="py-5">
            <div class="container">
                <h2 class="text-center mb-5 text-dark-emphasis">
                    <i class="bi bi-newspaper me-2"></i>Blog<i class="bi bi-newspaper ms-2"></i>
                </h2>
                <div class="row g-4">';

        foreach ($noticias as $noticia) {
            echo '<div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="' . $noticia['image'] . '" class="card-img-top" alt="' . htmlspecialchars($noticia['title']) . '" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title h5">' . $noticia['title'] . '</h3>
                        <p class="card-text">' . $noticia['description'] . '</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="#" class="btn btn-outline-dark btn-sm">Leer más</a>
                    </div>
                </div>
            </div>';
        }

        echo '</div></div></section>';
    }

    private function renderHabboPlatesSection()
    {
        $plates = [
            [
                'name' => 'Placa de Oro',
                'description' => 'La nueva placa de oro para los mejores constructores',
                'release_date' => '10 de Octubre, 2024',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20gold%20plate&aspect=16:9'
            ],
            [
                'name' => 'Placa de Plata',
                'description' => 'Placa de plata para los usuarios destacados',
                'release_date' => '15 de Noviembre, 2024',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20silver%20plate&aspect=16:9'
            ],
            [
                'name' => 'Placa de Bronce',
                'description' => 'Placa de bronce para los usuarios activos',
                'release_date' => '20 de Diciembre, 2024',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20bronze%20plate&aspect=16:9'
            ]
        ];

        echo '<section class="py-5 bg-body-tertiary">
            <div class="container">
                <h2 class="text-center mb-5 text-dark-emphasis">
                    <i class="bi bi-award me-2"></i>Nuevas Placas de Habbo<i class="bi bi-award ms-2"></i>
                </h2>
                <div class="row g-4">';

        foreach ($plates as $plate) {
            echo '<div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="' . $plate['image'] . '" class="card-img-top" alt="' . htmlspecialchars($plate['name']) . '" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title h5">' . $plate['name'] . '</h3>
                        <p class="card-text">' . $plate['description'] . '</p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <small class="text-body-secondary"><i class="bi bi-calendar-date me-1"></i>' . $plate['release_date'] . '</small>
                    </div>
                </div>
            </div>';
        }

        echo '</div></div></section>';
    }

    private function renderVideosSection()
    {
        echo '<section class="py-5">
            <div class="container">
                <h2 class="text-center mb-5 text-dark-emphasis">
                    <i class="bi bi-play-circle-fill me-2"></i>Videos<i class="bi bi-play-circle-fill ms-2"></i>
                </h2>
                
                <div class="row justify-content-center">
                    <div id="videosCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            
                            <div class="carousel-item active">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 mb-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="ratio ratio-16x9">
                                                <iframe src="https://www.youtube.com/embed/g0ZMA5vAgyc?si=N5r-RrN_iGGh-LdH" 
                                                        title="YouTube video player" frameborder="0" 
                                                        allowfullscreen></iframe>
                                            </div>
                                            <div class="card-body">
                                                <h3 class="h5">Video tutorial 1</h3>
                                                <p class="text-body-secondary">Aprende las funcionalidades de nuestra web</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6 mb-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="ratio ratio-16x9 bg-body-tertiary d-flex align-items-center justify-content-center">
                                                <i class="bi bi-play-circle-fill" style="font-size: 3rem;"></i>
                                            </div>
                                            <div class="card-body">
                                                <h3 class="h5">Video tutorial 2</h3>
                                                <p class="text-body-secondary">Gestionar pagos, tiempos y ascensos</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6 mb-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="ratio ratio-16x9 bg-body-tertiary d-flex align-items-center justify-content-center">
                                                <i class="bi bi-play-circle-fill" style="font-size: 3rem;"></i>
                                            </div>
                                            <div class="card-body">
                                                <h3 class="h5">Video tutorial 3</h3>
                                                <p class="text-body-secondary">Próximamente</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6 mb-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <div class="ratio ratio-16x9 bg-body-tertiary d-flex align-items-center justify-content-center">
                                                <i class="bi bi-play-circle-fill" style="font-size: 3rem;"></i>
                                            </div>
                                            <div class="card-body">
                                                <h3 class="h5">Video tutorial 4</h3>
                                                <p class="text-body-secondary">Próximamente</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button class="carousel-control-prev" type="button" data-bs-target="#videosCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#videosCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>';
    }

    private function renderFooter()
    {
        echo '<footer class="mt-auto bg-dark text-white py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h3 class="h5">Agencia Shein</h3>
                        <p class="small text-body-secondary">La mejor comunidad de Habbo Hotel</p>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h3 class="h5">Enlaces</h3>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-decoration-none text-body-secondary">Inicio</a></li>
                            <li><a href="#" class="text-decoration-none text-body-secondary">Sobre Nosotros</a></li>
                            <li><a href="#" class="text-decoration-none text-body-secondary">Contacto</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h3 class="h5">Redes Sociales</h3>
                        <div class="d-flex gap-3">
                            <a href="#" class="text-decoration-none text-body-secondary"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="text-decoration-none text-body-secondary"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="text-decoration-none text-body-secondary"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="text-decoration-none text-body-secondary"><i class="bi bi-discord"></i></a>
                        </div>
                    </div>
                </div>
                <hr class="my-4 text-body-secondary">
                <div class="text-center small text-body-secondary">
                    &copy; 2025 Agencia Shein. Todos los derechos reservados.
                </div>
            </div>
        </footer>';
    }

    private function renderThemeScript()
    {
        echo '<script>
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