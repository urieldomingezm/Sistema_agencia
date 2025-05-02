<!-- PROCESO DE VER PERFIL -->
<?php 
require_once(VER_PERFIL_PATCH . 'ver_perfil.php');

$userProfile = new UserProfile();
$userData = $userProfile->getUserData();
?>

<body class="bg-gradient">
    <div class="profile-header text-center py-5 position-relative overflow-hidden">
        <div class="background-pattern"></div>
        <div class="container position-relative">
            <div class="avatar-container mb-4">
                <div class="avatar-wrapper">
                    <img src="<?php echo $userData['avatar']; ?>"
                        class="rounded-circle shadow-lg border border-4 border-white"
                        alt="Profile Avatar">
                    <div class="status-badge pulse"></div>
                </div>
            </div>
            <h1 class="display-4 fw-bold text-white mb-2 text-shadow"><?php echo $userData['username']; ?></h1>
        </div>
    </div>

    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="profile-card glass-effect">
                    <div class="card-header bg-gradient-primary">
                        <div class="header-icon">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h3>Información Personal</h3>
                    </div>
                    <div class="stats-card">
                        <div class="info-item">
                            <span class="info-label">Usuario</span>
                            <span class="info-value"><?php echo $userData['username']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Rango</span>
                            <span class="info-value badge-custom"><?php echo $userData['role']; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="profile-card glass-effect">
                    <div class="card-header bg-gradient-success">
                        <div class="header-icon">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                        <h3>Información de Paga</h3>
                    </div>
                    <div class="stats-card">
                        <div class="info-item">
                            <span class="info-label">Día de paga</span>
                            <span class="info-value"><?php echo $userData['paymentDate']; ?> de cada mes</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Hora</span>
                            <span class="info-value"><?php echo $userData['paymentTime']; ?> hrs</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Total de horas</span>
                            <span class="info-value highlight pulse-text"><?php echo $userData['totalHours']; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="profile-card glass-effect">
                    <div class="card-header bg-gradient-info">
                        <div class="header-icon">
                            <i class="bi bi-list-check"></i>
                        </div>
                        <h3>Información de Misión</h3>
                    </div>
                    <div class="stats-card">
                        <div class="info-item">
                            <span class="info-label">Misión actual</span>
                            <span class="info-value"><?php echo $userData['mission']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Encargado</span>
                            <span class="info-value"><?php echo $userData['encargado']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Próxima hora</span>
                            <span class="info-value"><?php echo $userData['estimatedTime']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Estado</span>
                            <span class="status-pill glow"><?php echo $userData['status']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>