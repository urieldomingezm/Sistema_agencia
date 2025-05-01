<?php

class BodyHome
{
    public function render()
    {
        echo '<body class="d-flex flex-column h-100" style="background-color: #F3F0FF; font-family: \'Poppins\', sans-serif;">';
        $this->renderHeader();
        $this->renderTeamSection();
        $this->renderEventsSection();
        echo '</body>';
    }

    private function renderHeader()
    {
        echo '<br><br>';
        echo '<main class="flex-shrink-0">';
        echo '<header style="background: linear-gradient(135deg, #A78BFA, #8B5CF6); padding: 40px 0; box-shadow: 0 4px 6px rgba(139, 92, 246, 0.1);">';
        echo '<div class="container text-center">';
        echo '<h1 style="color: white; font-weight: 700;">✨ Agencia Atenas ✨</h1>';
        echo '<p style="color: #FFF; font-size: 1.2rem; opacity: 0.9;">La mejor comunidad de Habbo Hotel</p>';
        echo '<a href="#" style="background: #F3F0FF; color: #8B5CF6; padding: 15px 30px; border-radius: 30px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;">¡Únete ahora!</a>';
        echo '</div>';
        echo '</header>';
        echo '</main>';
    }

    private function renderTeamSection()
    {
        $teamMembers = [
            [
                'id' => '1',
                'name' => 'Santidemgs',
                'role' => 'ATN- Supervisor -XDD -SDD #',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20avatar%20with%20blonde%20hair%20and%20suit&aspect=1:1',
                'rank' => 'Dueño',
                'discord' => '#santidemgs',
                'habbo' => 'Santidemgs'
            ],
            [
                'id' => '2',
                'name' => 'Alys',
                'role' => 'ATN- Supervisor -XDD -SDD #',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20avatar%20female%20with%20pink%20hair&aspect=1:1',
                'rank' => 'Dueño',
                'discord' => '#alys',
                'habbo' => 'Alys'
            ],
            [
                'id' => '3',
                'name' => 'Morrys.ale',
                'role' => 'ATN- Supervisor -XDD -SDD #',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20avatar%20with%20brown%20hair%20and%20glasses&aspect=1:1',
                'rank' => 'Dueño',
            ],
            [
                'id' => '4',
                'name' => 'Eli98',
                'role' => 'ATN- Supervisor -XDD -SDD #',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20avatar%20female%20with%20red%20dress&aspect=1:1',
                'rank' => 'Dueño',
            ],
            [
                'id' => '5',
                'name' => 'Kisame231',
                'role' => 'ATN- Supervisor -XDD -SDD #',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20avatar%20female%20with%20blue%20outfit&aspect=1:1',
                'rank' => 'Administrador',
            ],
            [
                'id' => '6',
                'name' => 'Brujita23s',
                'role' => 'ATN- Supervisor -XDD -SDD #',
                'image' => 'https://api.a0.dev/assets/image?text=Habbo%20avatar%20with%20dark%20hair%20and%20casual%20clothes&aspect=1:1',
                'rank' => 'Administrador',
            ],
        ];

            echo '<section class="team-section py-5" style="background: linear-gradient(135deg, #87CEEB 0%, #6495ED 100%);">
                <div class="container">
                    <h2 class="text-center mb-5" style="color: white; font-weight: 800; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                        <i class="fas fa-crown me-2" style="color: #FFD700;"></i>
                        Nuestro Equipo
                        <i class="fas fa-crown ms-2" style="color: #FFD700;"></i>
                    </h2>
                    <div class="row justify-content-center g-4">';

            foreach ($teamMembers as $member) {
                echo '<div class="col-12 col-sm-6 col-lg-4">
                    <div class="team-card" style="background: white; border-radius: 20px; overflow: hidden; transition: all 0.3s ease; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                        <div class="position-relative">
                            <div class="team-banner" style="height: 80px; background: linear-gradient(45deg, #4158D0, #C850C0);"></div>
                            <div class="text-center" style="margin-top: -50px;">
                                <img src="' . $member['image'] . '" class="team-avatar" style="width: 100px; height: 100px; border-radius: 50%; border: 4px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
                            </div>
                        </div>
                        <div class="p-4 text-center">
                            <h3 class="mb-2" style="color: #333; font-weight: 600;">' . $member['name'] . '</h3>
                            <p class="text-muted mb-3" style="font-size: 0.9rem;">' . $member['role'] . '</p>
                            <span class="rank-badge" style="background: linear-gradient(45deg, #FF416C, #FF4B2B); color: white; padding: 6px 15px; border-radius: 20px; font-size: 0.9rem; font-weight: 500;">
                                <i class="fas fa-star me-1"></i>' . $member['rank'] . '
                            </span>
                            <div class="social-links mt-4">
                                <a href="https://discord.com" class="mx-2" style="color: #7289DA;"><i class="fab fa-discord fa-lg"></i></a>
                                <a href="https://www.habbo.es" class="mx-2" style="color: #FF6B6B;"><i class="fas fa-hotel fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>';
            }

            echo '</div></div></section>';

            // Add CSS for animations
            echo '<style>
                .team-card {
                    transform: translateY(0);
                    transition: all 0.3s ease;
                }
                .team-card:hover {
                    transform: translateY(-10px);
                    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
                }
                .team-avatar {
                    transition: all 0.3s ease;
                }
                .team-card:hover .team-avatar {
                    transform: scale(1.1);
                }
                .social-links a {
                    transition: all 0.3s ease;
                    opacity: 0.8;
                }
                .social-links a:hover {
                    opacity: 1;
                    transform: scale(1.2);
                }
                .rank-badge {
                    transition: all 0.3s ease;
                }
                .team-card:hover .rank-badge {
                    transform: scale(1.1);
                    box-shadow: 0 5px 15px rgba(255, 75, 43, 0.3);
                }
            </style>';
    }

    private function renderEventsSection()
    {
        $events = [
            ['title' => 'Fiesta de Bienvenida', 'description' => 'Conoce a todos los miembros de Agencia Atenas en nuestra fiesta de bienvenida', 'date' => '15 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20party%20room%20with%20lots%20of%20avatars%20dancing&aspect=16:9'],
            ['title' => 'Concurso de Construcción', 'description' => 'Muestra tus habilidades de construcción y gana premios increíbles', 'date' => '22 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20building%20competition%20with%20furniture%20and%20decorations&aspect=16:9'],
            ['title' => 'Carrera de Obstáculos', 'description' => 'Supera todos los obstáculos en el menor tiempo posible', 'date' => '29 de Marzo, 2025', 'image' => 'https://api.a0.dev/assets/image?text=Habbo%20obstacle%20course%20with%20traps%20and%20challenges&aspect=16:9'],
        ];

        echo '<section style="background: #DDD6FE; padding: 50px 0;">';
        echo '<div class="container text-center">';
        echo '<h2 style="color: #7C3AED; font-weight: 700; margin-bottom: 40px;">🎉 Próximos Eventos 🎉</h2>';
        echo '<div class="row">';

        foreach ($events as $event) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 10px 15px rgba(139, 92, 246, 0.1); height: 100%;">';
            echo '<img src="' . $event['image'] . '" style="width: 100%; height: 180px; border-radius: 15px; object-fit: cover; margin-bottom: 20px;">';
            echo '<h3 style="color: #4C1D95; font-weight: 600;">' . $event['title'] . '</h3>';
            echo '<p style="color: #6B7280; margin: 15px 0;">' . $event['description'] . '</p>';
            echo '<span style="background: #8B5CF6; color: white; padding: 8px 16px; border-radius: 20px; font-weight: 500;">📅 ' . $event['date'] . '</span>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
        echo '</section>';
    }
}

$bodyHome = new BodyHome();
$bodyHome->render();
