<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

// First handle the login POST request before any output
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once(PROCESOS_LOGIN_PATH . 'inicio_session.php');
    exit; // Stop execution after handling the POST request
}

// Only after handling POST, include the header and other content
require_once(TEMPLATES_PATH . 'header.php');
require_once(PROCESOS_LOGIN_PATH . 'inicio_session.php');
?>

<!-- CUSTOM CSS PARA LOGEARSE -->
<link rel="stylesheet" href="/public/assets/modal_just_validate/login/login.css">

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card">
                    <div class="card-header text-center">
                        <h4 class="mb-0">✨ Iniciar Sesión ✨</h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="loginForm" method="post">
                            <div class="form-group mb-3">
                                <label class="form-label"><i class="bi bi-person-fill"></i> Usuario</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <br>
                            <div class="form-group mb-4">
                                <label class="form-label"><i class="bi bi-lock-fill"></i> Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="registrar.php" class="text-decoration-none" style="color: #4a6bff;">¿No tienes cuenta? Regístrate</a>
                            <br>
                            <a href="index.php" class="text-decoration-none" style="color: #4a6bff;">regresar al inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- CUSTOM JS PARA LOGEARSE -->
<script src="/public/assets/modal_just_validate/login/login.js"></script>

<?php
require_once(TEMPLATES_PATH . 'footer.php');
?>