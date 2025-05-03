<?php

class BodyHome
{
    public function render()
    {
        echo '<body class="d-flex flex-column h-100" style="background-color: #ffffff; font-family: \'Poppins\', sans-serif;">';
        $this->renderHeader();
        $this->renderTeamSection();
        $this->renderEventsSection();
        echo '</body>';
    }

    private function renderHeader()
    {
        echo '<br><br>';
        echo '<main class="flex-shrink-0">';
        echo '<header style="background: linear-gradient(135deg, #4a6bff 0%, #2541b2 100%); padding: 40px 0; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">';
        echo '<div class="container text-center">';
        echo '<h1 style="color: white; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.2);"><i class="bi bi-stars me-2"></i>Agencia Shein<i class="bi bi-stars ms-2"></i></h1>';
        echo '<p style="color: #e0e0e0; font-size: 1.2rem;">La mejor comunidad de Habbo Hotel</p>';
        echo '<a href="/login.php" style="background: #ffffff; color: #2541b2; padding: 15px 30px; border-radius: 30px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(37, 65, 178, 0.2);">¡Únete ahora!</a>';
        echo '</div>';
        echo '</header>';
        echo '</main>';
    }

    private function renderTeamSection()
    {
        $teamMembers = [
            [
                'id' => '1',
                'name' => 'Jo.C',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Jo.C&headonly=1&head_direction=3&size=sl1',
                'rank' => 'Dueño',
            ],
            [
                'id' => '2',
                'name' => 'Snotra',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Snotra&headonly=1&head_direction=3&size=sl',
                'rank' => 'Founder',
            ],
            [
                'id' => '3',
                'name' => 'xOllStarx',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=xOllStarx&headonly=1&head_direction=3&size=sl',
                'rank' => 'Gerente',
            ],
            [
                'id' => '4',
                'name' => 'BigBarneyStinso',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=BigBarneyStinso&headonly=1&head_direction=3&size=sl',
                'rank' => 'Gerente',
            ],
            [
                'id' => '5',
                'name' => 'Nefita',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Nefita&headonly=1&head_direction=3&size=sl',
                'rank' => 'Manager',
            ],
            [
                'id' => '6',
                'name' => 'Keekit08',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Keekit08&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administrador',
            ],
            [
                'id' => '7',
                'name' => 'juancBQ',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=juancBQ&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administrador',
            ],
            [
                'id' => '8',
                'name' => 'mutilla_',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=mutilla_&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administrador',
            ],
            [
                'id' => '9',
                'name' => 'Vanderlind',
                'image' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=Vanderlind&headonly=1&head_direction=3&size=sl',
                'rank' => 'Administrador',
            ],
        ];

            echo '<section class="team-section py-5" style="background: #ffffff;">';
            echo '<div class="container">';
            echo '<h2 class="text-center mb-5" style="color: #2541b2; font-weight: 700; font-size: clamp(1.5rem, 4vw, 2rem);">';
            echo '<i class="bi bi-people-fill me-2" style="color: #4a6bff;"></i>';
            echo 'Nuestro Equipo';
            echo '<i class="bi bi-people-fill ms-2" style="color: #4a6bff;"></i>';
            echo '</h2>';
            echo '<div class="row justify-content-center g-3">';

            foreach ($teamMembers as $member) {
                echo '<div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-3 text-center">';
                echo '<div style="display: inline-block; width: 100%; max-width: 120px;">';
                echo '<img src="' . $member['image'] . '" style="width: 100%; height: auto; aspect-ratio: 1/1; border-radius: 50%; object-fit: cover; border: 3px solid #4a6bff;">';
                echo '<div class="mt-2">';
                echo '<div style="color: #2541b2; font-weight: 600; font-size: clamp(0.7rem, 2vw, 0.9rem); word-break: break-word;">' . $member['name'] . '</div>';
                echo '<div style="color: #4a6bff; font-size: clamp(0.6rem, 1.8vw, 0.8rem);">' . $member['rank'] . '</div>';
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

        echo '<section style="background: #f8f9fa; padding: 50px 0;">';
        echo '<div class="container text-center">';
        echo '<h2 style="color: #2541b2; font-weight: 700; margin-bottom: 40px;"><i class="bi bi-calendar-event me-2"></i>Próximos Eventos<i class="bi bi-calendar-event ms-2"></i></h2>';
        echo '<div class="row">';

        foreach ($events as $event) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05); height: 100%; transition: all 0.3s ease;">';
            echo '<img src="' . $event['image'] . '" style="width: 100%; height: 180px; border-radius: 15px; object-fit: cover; margin-bottom: 20px;">';
            echo '<h3 style="color: #2541b2; font-weight: 600;">' . $event['title'] . '</h3>';
            echo '<p style="color: #555; margin: 15px 0;">' . $event['description'] . '</p>';
            echo '<span style="background: linear-gradient(45deg, #4a6bff, #2541b2); color: white; padding: 8px 16px; border-radius: 20px; font-weight: 500;">📅 ' . $event['date'] . '</span>';
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
