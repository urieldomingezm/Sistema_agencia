<?php
class UserProfile
{
    private $userData;

    public function __construct()
    {
        if (isset($_SESSION['user_id'])) {
            require_once(CONFIG_PATH . 'bd.php');
            $database = new Database();
            $conn = $database->getConnection();

            try {
                // Primero obtenemos la información básica del usuario
                $query = "SELECT usuario_registro, rango FROM registro_usuario WHERE id = :user_id";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':user_id', $_SESSION['user_id']);
                $stmt->execute();
                $userData = $stmt->fetch(PDO::FETCH_ASSOC);

                // Luego buscamos la información de ascenso usando el nombre de usuario
                $ascensoQuery = "SELECT ascenso_rango, ascenso_mision_nueva, ascenso_status, 
                                      ascenso_hora_proxima, ascenso_encargado_usuario 
                               FROM gestion_ascenso 
                               WHERE ascenso_usuario = :username 
                               ORDER BY ascenso_fecha_registro DESC LIMIT 1";
                $stmt = $conn->prepare($ascensoQuery);
                $stmt->bindParam(':username', $userData['usuario_registro']);
                $stmt->execute();
                $ascensoData = $stmt->fetch(PDO::FETCH_ASSOC);

                // Combinamos la información
                $this->userData = [
                    'username' => $userData['usuario_registro'],
                    'role' => $userData['rango'],
                    'mission' => $ascensoData ? $ascensoData['ascenso_mision_nueva'] : 'Sin misión asignada',
                    'avatar' => 'https://www.habbo.es/habbo-imaging/avatarimage?user=' . $userData['usuario_registro'] . '&action=none&direction=2&head_direction=2&gesture=&size=sl&headonly=1r',
                    'nextMission' => 'Pendiente',
                    'paymentTime' => '14:00',
                    'paymentDate' => '15',
                    'hoursDeducted' => '1:00',
                    'totalHours' => '5:00',
                    'estimatedTime' => $ascensoData ? $ascensoData['ascenso_hora_proxima'] : 'No disponible',
                    'status' => $ascensoData ? $ascensoData['ascenso_status'] : 'Pendiente',
                    'encargado' => $ascensoData ? $ascensoData['ascenso_encargado_usuario'] : 'No asignado'
                ];
            } catch (PDOException $e) {
                error_log("Error al obtener datos del usuario: " . $e->getMessage());
                // Datos por defecto en caso de error
                $this->userData = [
                    'username' => 'Usuario',
                    'role' => 'No disponible',
                    'mission' => 'AGT- Supervisor G -XDD -SDS #',
                    'avatar' => 'https://api.a0.dev/assets/image?text=Habbo%20avatar%20with%20brown%20hair&aspect=1:1',
                    'nextMission' => 'AGT- Supervisor D -XDD -SDS #',
                    'paymentTime' => '14:00',
                    'paymentDate' => '15',
                    'hoursDeducted' => '1:00',
                    'totalHours' => '5:00',
                    'estimatedTime' => '2 días',
                    'status' => 'Pendiente',
                    'joinDate' => '01/01/2023'
                ];
            }
        }
    }

    public function render()
    {
?>

        <body class="bg-gradient">
            <div class="profile-header text-center py-5">
                <div class="container">
                    <div class="avatar-container mb-4">
                        <img src="<?php echo $this->userData['avatar']; ?>"
                            class="rounded-circle shadow-lg"
                            alt="Profile Avatar">
                        <div class="status-badge"></div>
                    </div>
                    <h1 class="display-4 fw-bold text-white mb-2"><?php echo $this->userData['username']; ?></h1>
                    <p class="lead text-white-50"><?php echo $this->userData['role']; ?></p>
                </div>
            </div>

            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="profile-card">
                            <div class="card-header">
                                <i class="fas fa-user-circle me-2"></i>
                                <h3>Información Personal</h3>
                            </div>
                            <div class="stats-card">
                                <div class="info-item">
                                    <span class="info-label">Usuario</span>
                                    <span class="info-value"><?php echo $this->userData['username']; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Rango</span>
                                    <span class="info-value"><?php echo $this->userData['role']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="profile-card">
                            <div class="card-header">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                <h3>Información de Paga</h3>
                            </div>
                            <div class="stats-card">
                                <div class="info-item">
                                    <span class="info-label">Día de paga</span>
                                    <span class="info-value"><?php echo $this->userData['paymentDate']; ?> de cada mes</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Hora</span>
                                    <span class="info-value"><?php echo $this->userData['paymentTime']; ?> hrs</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Total de horas</span>
                                    <span class="info-value highlight"><?php echo $this->userData['totalHours']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="profile-card">
                            <div class="card-header">
                                <i class="fas fa-tasks me-2"></i>
                                <h3>Información de Misión</h3>
                            </div>
                            <div class="stats-card">
                                <div class="info-item">
                                    <span class="info-label">Misión actual</span>
                                    <span class="info-value"><?php echo $this->userData['mission']; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Encargado</span>
                                    <span class="info-value"><?php echo $this->userData['encargado']; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Próxima hora</span>
                                    <span class="info-value"><?php echo $this->userData['estimatedTime']; ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Estado</span>
                                    <span class="status-pill"><?php echo $this->userData['status']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
<?php
    }
}

$userProfile = new UserProfile();
$userProfile->render();
?>

<style>
    .bg-gradient {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        min-height: 100vh;
    }

    .profile-header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        backdrop-filter: blur(10px);
        margin-bottom: 2rem;
    }

    .avatar-container {
        position: relative;
        display: inline-block;
    }

    .avatar-container img {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border: 5px solid rgba(255, 255, 255, 0.3);
        transition: transform 0.3s ease;
    }

    .avatar-container img:hover {
        transform: scale(1.05);
    }

    .status-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background-color: #2ecc71;
        border: 3px solid white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .profile-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background: linear-gradient(45deg, #2193b0, #6dd5ed);
        color: white;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .stats-card {
        padding: 1.5rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.8rem 0;
        border-bottom: 1px solid #eee;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #666;
        font-weight: 500;
    }

    .info-value {
        color: #2c3e50;
        font-weight: 600;
    }

    .highlight {
        color: #2ecc71;
        font-size: 1.1rem;
    }

    .status-pill {
        background: #ffd700;
        color: #000;
        padding: 0.3rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .profile-card {
            margin-bottom: 1rem;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">