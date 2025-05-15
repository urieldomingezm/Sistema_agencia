<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once(PROCESOS_LOGIN_PATH . 'inicio_registrarse.php');
    exit;
}

require_once(TEMPLATES_PATH . 'header.php');
require_once(PROCESOS_LOGIN_PATH . 'inicio_registrarse.php');
?>

<!-- estilos css -->
<link rel="stylesheet" href="/public/assets/custom_general/custom_login/registro/index_registro.css">

<!-- estilos js -->
<script src="/public/assets/custom_general/custom_login/registro/index_registro.js"></script>


<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="mb-0">✨ Registro ✨</h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="registrationForm" method="post">
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person-fill"></i> Nombre de habbo</label>
                                <input type="text" class="form-control" name="username" required>
                                <small class="form-text text-muted"><i class="bi bi-info-circle"></i> Ingresa tu nombre exacto de Habbo</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-person-badge-fill"></i> Confirmar nombre</label>
                                <input type="text" class="form-control" name="habboName" required>
                                <small class="form-text text-muted"><i class="bi bi-info-circle"></i> Ingresa tu nombre exacto de Habbo</small>
                            </div>
                            <div class="mb-4">
                                <label class="form-label"><i class="bi bi-lock-fill"></i> Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php" class="text-decoration-none" style="color: #4a6bff;">¿Ya tienes cuenta? Inicia sesión</a>
                            <br>
                            <a href="index.php" class="text-decoration-none" style="color: #4a6bff;">Regresar al inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
require_once(TEMPLATES_PATH . 'footer.php');
?>