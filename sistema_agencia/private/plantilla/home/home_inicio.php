<?php

class BodyHome
{
    public function render()
    {
        echo '<body class="d-flex flex-column h-100" style="background-color: #f5f5f5; font-family: \'Poppins\', sans-serif;">';
        $this->renderHeader();
        $this->renderTeamSection();
        $this->renderEventsSection();
        echo '</body>';
    }

    private function renderHeader()
    {
        echo '<br><br>';
        echo '<main class="flex-shrink-0">';
        echo '<header style="background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%); padding: 40px 0; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);">';
        echo '<div class="container text-center">';
        echo '<h1 style="color: white; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);"><i class="bi bi-stars me-2"></i>Agencia Shein<i class="bi bi-stars ms-2"></i></h1>';
        echo '<p style="color: #e0e0e0; font-size: 1.2rem;">La mejor comunidad de Habbo Hotel</p>';
        echo '<a href="/login.php" style="background: #ffffff; color: #2c2c2c; padding: 15px 30px; border-radius: 30px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(255, 255, 255, 0.1);">¡Únete ahora!</a>';
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

            echo '<section class="team-section py-5" style="background: linear-gradient(135deg, #333333 0%, #1a1a1a 100%);">';
            echo '<div class="container">';
            echo '<h2 class="text-center mb-5" style="color: white; font-weight: 800; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">';
            echo '<i class="bi bi-award me-2" style="color: #e0e0e0;"></i>';
            echo 'Nuestro Equipo';
            echo '<i class="bi bi-award ms-2" style="color: #e0e0e0;"></i>';
            echo '</h2>';
            echo '<div class="row justify-content-center g-4">';

            foreach ($teamMembers as $member) {
                echo '<div class="col-12 col-sm-6 col-lg-4">';
                echo '<div class="team-card" style="background: white; border-radius: 20px; overflow: hidden; transition: all 0.3s ease; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">';
                echo '<div class="position-relative">';
                echo '<div class="team-banner" style="height: 80px; background: linear-gradient(45deg, #2c2c2c, #404040);"></div>';
                echo '<div class="text-center" style="margin-top: -50px;">';
                echo '<img src="' . $member['image'] . '" class="team-avatar" style="width: 100px; height: 100px; border-radius: 50%; border: 4px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">';
                echo '</div>';
                echo '</div>';
                echo '<div class="p-4 text-center">';
                echo '<h3 class="mb-2" style="color: #333; font-weight: 600;">' . $member['name'] . '</h3>';
                echo '<p class="text-muted mb-3" style="font-size: 0.9rem;">' . $member['role'] . '</p>';
                echo '<span class="rank-badge" style="background: linear-gradient(45deg, #2c2c2c, #404040); color: white; padding: 6px 15px; border-radius: 20px; font-size: 0.9rem; font-weight: 500;">';
                echo '<i class="bi bi-star-fill me-1"></i>' . $member['rank'] . '</span>';
                echo '<div class="social-links mt-4">';
                echo '<a href="https://discord.com" class="mx-2" style="color: #404040;"><i class="bi bi-discord fa-lg"></i></a>';
                echo '<a href="https://www.habbo.es" class="mx-2" style="color: #2c2c2c;"><i class="bi bi-house-door fa-lg"></i></a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
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

        echo '<section style="background: #f0f0f0; padding: 50px 0;">';
        echo '<div class="container text-center">';
        echo '<h2 style="color: #2c2c2c; font-weight: 700; margin-bottom: 40px;"><i class="bi bi-calendar-event me-2"></i>Próximos Eventos<i class="bi bi-calendar-event ms-2"></i></h2>';
        echo '<div class="row">';

        foreach ($events as $event) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); height: 100%; transition: all 0.3s ease;">';
            echo '<img src="' . $event['image'] . '" style="width: 100%; height: 180px; border-radius: 15px; object-fit: cover; margin-bottom: 20px;">';
            echo '<h3 style="color: #2c2c2c; font-weight: 600;">' . $event['title'] . '</h3>';
            echo '<p style="color: #666; margin: 15px 0;">' . $event['description'] . '</p>';
            echo '<span style="background: linear-gradient(45deg, #2c2c2c, #404040); color: white; padding: 8px 16px; border-radius: 20px; font-weight: 500;">📅 ' . $event['date'] . '</span>';
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
