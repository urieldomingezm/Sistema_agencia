<?php

class BodyHome
{
    public function render()
    {
        echo '<body class="flex flex-col h-screen bg-gray-100" data-theme="light">';
        $this->renderLoader();
        $this->renderHeader();
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
        echo '<div id="preloader" class="preloader fixed inset-0 w-full h-full bg-black flex justify-center items-center z-[9999] transition-opacity duration-500 ease-out">
            <div class="eyes-loader flex flex-col items-center">
                <div class="eyes-container flex gap-10">
                    <div class="eye left-eye w-16 h-16 rounded-full bg-[radial-gradient(circle,#ff0000_0%,#8b0000_100%)] shadow-[0_0_20px_5px_rgba(255,0,0,0.8)] relative animate-[glow_1.5s_infinite_alternate,blink_3s_infinite]"></div>
                    <div class="eye right-eye w-16 h-16 rounded-full bg-[radial-gradient(circle,#ff0000_0%,#8b0000_100%)] shadow-[0_0_20px_5px_rgba(255,0,0,0.8)] relative animate-[glow_1.5s_infinite_alternate,blink_3s_infinite]"></div>
                </div>
                <div class="loading-text mt-8 text-white text-2xl font-bold uppercase tracking-wider animate-[text-glow_1.5s_infinite_alternate] text-center">Bienvenido a Agencia Shein</div>
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
            <header class="bg-blue-600 text-white py-12 relative overflow-hidden">
                <div class="absolute top-0 right-0 opacity-25">
                    <i class="bi bi-stars text-7xl"></i>
                </div>
                <div class="absolute bottom-0 left-0 opacity-25">
                    <i class="bi bi-stars text-7xl"></i>
                </div>
                <div class="container mx-auto px-4 text-center relative">
                    <h1 class="text-5xl font-bold mb-6">
                        <i class="bi bi-stars mr-4"></i>Agencia Shein<i class="bi bi-stars ml-4"></i>
                    </h1>
                    <p class="text-xl mb-6">La mejor comunidad de Habbo Hotel con más de 5 años de experiencia</p>
                    <div class="flex gap-3 justify-center">
                        <a href="/login.php" class="bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-3 px-6 rounded-full text-lg transition duration-300">
                            <i class="bi bi-door-open mr-2"></i>¡Únete ahora!
                        </a>
                        <a href="#about" class="border border-white hover:bg-white hover:text-blue-600 text-white font-bold py-3 px-6 rounded-full text-lg transition duration-300">
                            <i class="bi bi-info-circle mr-2"></i>Conócenos
                        </a>
                    </div>
                </div>
            </header>
            
            <div class="bg-gray-900 py-2">
                <div class="container mx-auto px-4">
                    <div class="flex justify-between items-center">
                        <div class="text-yellow-400 font-bold">
                            <i class="bi bi-people-fill mr-2"></i>+500 miembros activos
                        </div>
                        <div class="text-gray-400">
                            <span class="mr-4"><i class="bi bi-calendar-check mr-1"></i>Eventos diarios</span>
                            <span><i class="bi bi-trophy mr-1"></i>Premios exclusivos</span>
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
                'color' => 'red'
            ],
            [
                'id' => '2',
                'name' => 'Snotra',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Snotra&headonly=1&head_direction=3&size=sl',
                'rank' => 'Founder',
                'color' => 'red'
            ],
            [
                'id' => '4',
                'name' => 'BigBarneyStinso',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=BigBarneyStinso&headonly=1&head_direction=3&size=sl',
                'rank' => 'Manager',
                'color' => 'yellow'
            ],
            [
                'id' => '5',
                'name' => 'Nefita',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Nefita&headonly=1&head_direction=3&size=sl',
                'rank' => 'Manager',
                'color' => 'yellow'
            ],
            [
                'id' => '6',
                'name' => 'juancBQ',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=juancBQ&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administrador',
                'color' => 'green'
            ],
            [
                'id' => '7',
                'name' => 'mutilla_',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=mutilla_&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administrador',
                'color' => 'green'
            ],
            [
                'id' => '8',
                'name' => 'Vanderlind',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Vanderlind&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administrador',
                'color' => 'green'
            ],
            [
                'id' => '9',
                'name' => 'maria51162',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=maria51162&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administradora',
                'color' => 'green'
            ],
        ];

        echo '<section class="py-12">
            <div class="container mx-auto px-4">
                <div class="text-center mb-10">
                    <h2 class="text-4xl font-bold text-blue-600 mb-4">
                        <i class="bi bi-people-fill mr-2"></i>Nuestro Equipo
                    </h2>
                    <p class="text-xl text-gray-600">Conoce al equipo que hace posible Agencia Shein</p>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 justify-center">';

        foreach ($teamMembers as $member) {
            $colorClasses = [
                'red' => 'bg-red-600',
                'yellow' => 'bg-yellow-500',
                'green' => 'bg-green-600'
            ];
            
            $borderClasses = [
                'red' => 'border-red-600',
                'yellow' => 'border-yellow-500',
                'green' => 'border-green-600'
            ];
            
            echo '<div class="col-span-1">
                <div class="card border-0 shadow-md h-full transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="'.$colorClasses[$member['color']].' text-white text-center py-2">
                        <i class="bi bi-person-badge"></i> '.$member['rank'].'
                    </div>
                    <div class="card-body text-center p-4">
                        <img src="' . $member['image'] . '" alt="Avatar de ' . htmlspecialchars($member['name']) . '" 
                             class="w-24 h-24 rounded-full mb-4 shadow-md mx-auto border-4 '.$borderClasses[$member['color']].' object-cover">
                        <h5 class="font-bold mb-1">' . $member['name'] . '</h5>
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

        echo '<section class="py-12 bg-blue-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-10">
                    <h2 class="text-4xl font-bold text-blue-600 mb-4">
                        <i class="bi bi-calendar-event mr-2"></i>Próximos Eventos
                    </h2>
                    <p class="text-xl text-gray-600">Participa en nuestras actividades exclusivas para miembros</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">';

        foreach ($events as $event) {
            echo '<div class="col-span-1">
                <div class="card h-full border-0 shadow-md overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="relative">
                        <img src="' . $event['image'] . '" class="w-full h-48 object-cover" alt="' . htmlspecialchars($event['title']) . '">
                        '.($event['badge'] ? '<span class="absolute top-2 right-2 m-2 badge bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-sm font-medium">'.$event['badge'].'</span>' : '').'
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">' . $event['title'] . '</h3>
                        <p class="text-gray-600 mb-4">' . $event['description'] . '</p>
                        <ul class="space-y-2 mb-4">
                            <li class="flex items-center"><i class="bi bi-check-circle-fill text-blue-500 mr-2"></i>Premios exclusivos</li>
                            <li class="flex items-center"><i class="bi bi-check-circle-fill text-blue-500 mr-2"></i>Diversión garantizada</li>
                            <li class="flex items-center"><i class="bi bi-check-circle-fill text-blue-500 mr-2"></i>Para todos los niveles</li>
                        </ul>
                    </div>
                    <div class="px-6 py-4 bg-white flex justify-between items-center">
                        <small class="text-gray-500"><i class="bi bi-calendar-date mr-1"></i>' . $event['date'] . '</small>
                        <a href="#" class="btn btn-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full text-sm transition duration-300">Más info</a>
                    </div>
                </div>
            </div>';
        }

        echo '</div>
                <div class="text-center mt-8">
                    <a href="#" class="inline-block border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-bold py-3 px-6 rounded-full text-lg transition duration-300">
                        <i class="bi bi-list-ul mr-2"></i>Ver todos los eventos
                    </a>
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
                'color' => 'blue'
            ],
            [
                'title' => 'Nuevo Sistema de Recompensas',
                'description' => 'Conoce el nuevo sistema de recompensas diarias y cómo beneficiarte de él',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20rewards&aspect=16:9',
                'category' => 'Sistema',
                'date' => 'Hace 1 semana',
                'color' => 'green'
            ],
            [
                'title' => 'Mejoras en la Comunidad',
                'description' => 'Descubre las mejoras implementadas en la comunidad y nuevas funcionalidades',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20community&aspect=16:9',
                'category' => 'Anuncios',
                'date' => 'Hace 3 días',
                'color' => 'yellow'
            ]
        ];

        echo '<section class="py-12">
            <div class="container mx-auto px-4">
                <div class="text-center mb-10">
                    <h2 class="text-4xl font-bold text-blue-600 mb-4">
                        <i class="bi bi-newspaper mr-2"></i>Últimas Noticias
                    </h2>
                    <p class="text-xl text-gray-600">Mantente informado sobre las novedades de Agencia Shein</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">';

        foreach ($noticias as $noticia) {
            $colorClasses = [
                'blue' => 'bg-blue-500',
                'green' => 'bg-green-500',
                'yellow' => 'bg-yellow-500'
            ];
            
            echo '<div class="col-span-1">
                <div class="card border-0 shadow-md h-full transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                    <div class="relative">
                        <img src="' . $noticia['image'] . '" class="w-full h-48 object-cover" alt="' . htmlspecialchars($noticia['title']) . '">
                        <span class="absolute top-2 left-2 m-2 badge '.$colorClasses[$noticia['color']].' text-white px-3 py-1 rounded-full text-sm font-medium">'.$noticia['category'].'</span>
                    </div>
                    <div class="p-6">
                        <small class="text-gray-500 block mb-2"><i class="bi bi-clock mr-1"></i>'.$noticia['date'].'</small>
                        <h3 class="text-xl font-bold mb-2">' . $noticia['title'] . '</h3>
                        <p class="text-gray-600 mb-4">' . $noticia['description'] . '</p>
                    </div>
                    <div class="px-6 py-4 bg-white">
                        <a href="#" class="inline-block border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-4 py-2 rounded-full text-sm transition duration-300">
                            <i class="bi bi-arrow-right mr-1"></i>Leer más
                        </a>
                    </div>
                </div>
            </div>';
        }

        echo '</div>
                <div class="text-center mt-8">
                    <a href="#" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-full text-lg transition duration-300">
                        <i class="bi bi-journal-text mr-2"></i>Ver todas las noticias
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
                'color' => 'yellow'
            ],
            [
                'name' => 'Placa de Plata',
                'description' => 'Placa de plata para los usuarios más destacados y activos',
                'release_date' => '15 de Noviembre, 2024',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20silver%20plate&aspect=16:9',
                'icon' => 'bi-award',
                'color' => 'gray'
            ],
            [
                'name' => 'Placa de Bronce',
                'description' => 'Placa de bronce para reconocer a los usuarios más activos',
                'release_date' => '20 de Diciembre, 2024',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20bronze%20plate&aspect=16:9',
                'icon' => 'bi-star',
                'color' => 'red'
            ]
        ];

        echo '<section class="py-12 bg-gray-900 text-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-10">
                    <h2 class="text-4xl font-bold text-yellow-400 mb-4">
                        <i class="bi bi-award mr-2"></i>Nuevas Placas de Habbo
                    </h2>
                    <p class="text-xl text-gray-400">Reconocimientos exclusivos para nuestros miembros</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">';

        foreach ($plates as $plate) {
            $colorClasses = [
                'yellow' => 'bg-yellow-500 bg-opacity-25',
                'gray' => 'bg-gray-500 bg-opacity-25',
                'red' => 'bg-red-500 bg-opacity-25'
            ];
            
            $badgeClasses = [
                'yellow' => 'bg-yellow-500 text-gray-900',
                'gray' => 'bg-gray-500 text-white',
                'red' => 'bg-red-500 text-white'
            ];
            
            echo '<div class="col-span-1">
                <div class="card h-full border-0 bg-gray-800 bg-opacity-50 transition-transform duration-300 hover:scale-105">
                    <div class="card-header '.$colorClasses[$plate['color']].' border-0 text-center py-6">
                        <i class="bi '.$plate['icon'].' text-5xl"></i>
                    </div>
                    <div class="card-body text-center p-6">
                        <h3 class="text-xl font-bold mb-4">' . $plate['name'] . '</h3>
                        <p class="text-gray-400 mb-6">' . $plate['description'] . '</p>
                        <div class="mt-4">
                            <span class="badge '.$badgeClasses[$plate['color']].' px-3 py-1 rounded-full text-sm font-medium">
                                <i class="bi bi-calendar-date mr-1"></i>' . $plate['release_date'] . '
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center pb-6">
                        <button class="border border-gray-400 hover:bg-gray-700 text-white px-4 py-2 rounded-full text-sm transition duration-300">
                            <i class="bi bi-info-circle mr-1"></i>Cómo obtenerla
                        </button>
                    </div>
                </div>
            </div>';
        }

        echo '</div>
                <div class="text-center mt-8">
                    <a href="#" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-3 px-6 rounded-full text-lg transition duration-300">
                        <i class="bi bi-trophy mr-2"></i>Ver sistema de recompensas
                    </a>
                </div>
            </div>
        </section>';
    }

    private function renderVideosSection()
    {
        echo '<section class="py-12 bg-gray-100">
            <div class="container mx-auto px-4">
                <div class="text-center mb-10">
                    <h2 class="text-4xl font-bold text-blue-600 mb-4">
                        <i class="bi bi-play-circle-fill mr-2"></i>Tutoriales y Videos
                    </h2>
                    <p class="text-xl text-gray-600">Aprende a sacar el máximo provecho a Agencia Shein</p>
                </div>
                
                <div class="relative">
                    <div id="videosCarousel" class="carousel slide relative" data-bs-ride="carousel">
                        <div class="carousel-inner relative w-full overflow-hidden">
                            
                            <div class="carousel-item active relative">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 justify-center">
                                    <div class="col-span-1">
                                        <div class="card border-0 shadow-md h-full">
                                            <div class="card-header bg-blue-600 text-white px-4 py-3">
                                                <i class="bi bi-film mr-2"></i>Video Tutorial
                                            </div>
                                            <div class="aspect-w-16 aspect-h-9">
                                                <iframe src="https://www.youtube.com/embed/g0ZMA5vAgyc?si=N5r-RrN_iGGh-LdH" 
                                                        title="YouTube video player" frameborder="0" 
                                                        allowfullscreen class="w-full h-full rounded-b-lg"></iframe>
                                            </div>
                                            <div class="p-6">
                                                <h3 class="text-xl font-bold mb-2">Introducción a Agencia Shein</h3>
                                                <p class="text-gray-600 mb-4">Aprende las funcionalidades básicas de nuestra web y cómo navegar por ella</p>
                                                <div class="flex justify-between items-center">
                                                    <small class="text-gray-500"><i class="bi bi-clock mr-1"></i>15 min</small>
                                                    <span class="badge bg-blue-600 text-white px-2 py-1 rounded-full text-xs">Nuevo</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-span-1">
                                        <div class="card border-0 shadow-md h-full">
                                            <div class="card-header bg-blue-600 text-white px-4 py-3">
                                                <i class="bi bi-film mr-2"></i>Video Tutorial
                                            </div>
                                            <div class="aspect-w-16 aspect-h-9 bg-gray-200 flex items-center justify-center">
                                                <i class="bi bi-play-circle-fill text-blue-600 text-5xl"></i>
                                            </div>
                                            <div class="p-6">
                                                <h3 class="text-xl font-bold mb-2">Gestión de Pagos y Ascensos</h3>
                                                <p class="text-gray-600 mb-4">Aprende a gestionar pagos, tiempos de servicio y ascensos de rango</p>
                                                <div class="flex justify-between items-center">
                                                    <small class="text-gray-500"><i class="bi bi-clock mr-1"></i>Próximamente</small>
                                                    <span class="badge bg-gray-500 text-white px-2 py-1 rounded-full text-xs">En producción</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="carousel-item relative">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 justify-center">
                                    <div class="col-span-1">
                                        <div class="card border-0 shadow-md h-full">
                                            <div class="card-header bg-blue-600 text-white px-4 py-3">
                                                <i class="bi bi-film mr-2"></i>Video Tutorial
                                            </div>
                                            <div class="aspect-w-16 aspect-h-9 bg-gray-200 flex items-center justify-center">
                                                <i class="bi bi-play-circle-fill text-blue-600 text-5xl"></i>
                                            </div>
                                            <div class="p-6">
                                                <h3 class="text-xl font-bold mb-2">Participación en Eventos</h3>
                                                <p class="text-gray-600 mb-4">Cómo participar y ganar en nuestros eventos exclusivos</p>
                                                <div class="flex justify-between items-center">
                                                    <small class="text-gray-500"><i class="bi bi-clock mr-1"></i>Próximamente</small>
                                                    <span class="badge bg-gray-500 text-white px-2 py-1 rounded-full text-xs">En producción</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-span-1">
                                        <div class="card border-0 shadow-md h-full">
                                            <div class="card-header bg-blue-600 text-white px-4 py-3">
                                                <i class="bi bi-film mr-2"></i>Video Tutorial
                                            </div>
                                            <div class="aspect-w-16 aspect-h-9 bg-gray-200 flex items-center justify-center">
                                                <i class="bi bi-play-circle-fill text-blue-600 text-5xl"></i>
                                            </div>
                                            <div class="p-6">
                                                <h3 class="text-xl font-bold mb-2">Sistema de Recompensas</h3>
                                                <p class="text-gray-600 mb-4">Cómo acumular puntos y canjear recompensas exclusivas</p>
                                                <div class="flex justify-between items-center">
                                                    <small class="text-gray-500"><i class="bi bi-clock mr-1"></i>Próximamente</small>
                                                    <span class="badge bg-gray-500 text-white px-2 py-1 rounded-full text-xs">En producción</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button class="carousel-control-prev absolute left-0 top-1/2 -translate-y-1/2 flex items-center justify-center p-2 text-center bg-blue-600 rounded-full w-12 h-12" type="button" data-bs-target="#videosCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon inline-block" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next absolute right-0 top-1/2 -translate-y-1/2 flex items-center justify-center p-2 text-center bg-blue-600 rounded-full w-12 h-12" type="button" data-bs-target="#videosCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon inline-block" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>';
    }

    private function renderThemeScript()
    {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            // Comprobar preferencia del usuario
            const preferredTheme = localStorage.getItem("theme") || "light";
            document.body.setAttribute("data-theme", preferredTheme);
            
            // Configurar botones del toggle
            document.querySelectorAll(".theme-toggle").forEach(button => {
                button.addEventListener("click", function() {
                    const theme = this.getAttribute("data-theme");
                    document.body.setAttribute("data-theme", theme);
                    localStorage.setItem("theme", theme);
                });
            });
        });
        </script>';
    }
}

$bodyHome = new BodyHome();
$bodyHome->render();