<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');?>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <!-- Sidebar -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark min-vh-100">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white">
                    <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-4 d-none d-sm-inline"><i class="bi bi-speedometer2"></i> Dashboard</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start">
                        <li class="nav-item">
                            <a href="#" class="nav-link text-white">
                                <i class="bi bi-house-door"></i> <span class="ms-2 d-none d-sm-inline">Inicio</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white">
                                <i class="bi bi-people"></i> <span class="ms-2 d-none d-sm-inline">Usuarios</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white">
                                <i class="bi bi-chat-dots"></i> <span class="ms-2 d-none d-sm-inline">Chat</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link text-white">
                                <i class="bi bi-gear"></i> <span class="ms-2 d-none d-sm-inline">Configuración</span>
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="https://via.placeholder.com/32" alt="user" width="32" height="32" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1">Admin</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="#">Perfil</a></li>
                            <li><a class="dropdown-item" href="#">Salir</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div class="col py-3">
                <div class="container">
                    <div class="row mb-4">
                        <div class="col">
                            <h2><i class="bi bi-speedometer2"></i> Panel Administrativo</h2>
                        </div>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary h-100">
                                <div class="card-body d-flex align-items-center">
                                    <i class="bi bi-people fs-1 me-3"></i>
                                    <div>
                                        <h5 class="card-title">Usuarios</h5>
                                        <p class="card-text">Gestión de usuarios activos.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-success h-100">
                                <div class="card-body d-flex align-items-center">
                                    <i class="bi bi-chat-dots fs-1 me-3"></i>
                                    <div>
                                        <h5 class="card-title">Chat</h5>
                                        <p class="card-text">Mensajes recientes y soporte.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-warning h-100">
                                <div class="card-body d-flex align-items-center">
                                    <i class="bi bi-gear fs-1 me-3"></i>
                                    <div>
                                        <h5 class="card-title">Configuración</h5>
                                        <p class="card-text">Ajustes del sistema.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Chat Section -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-secondary text-white">
                                    <i class="bi bi-chat-dots"></i> Chat Administrativo
                                </div>
                                <div class="card-body" id="chat-container" style="height: 300px; overflow-y: auto;">
                                    <!-- Mensajes del chat aquí -->
                                </div>
                                <div class="card-footer">
                                    <form id="chat-form" class="d-flex">
                                        <input type="text" class="form-control me-2" placeholder="Escribe un mensaje..." id="chat-input">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-send"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <i class="bi bi-info-circle"></i> Información
                                </div>
                                <div class="card-body">
                                    <p>Bienvenido al panel administrativo. Aquí puedes gestionar usuarios, ver mensajes y ajustar configuraciones.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap JS (opcional, para dropdowns y otros componentes) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chat.js (solo maquetación, sin funcionalidad real) -->
    <script>
        // Solo para maquetación, no funcional
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const input = document.getElementById('chat-input');
            if (input.value.trim() !== '') {
                const chatContainer = document.getElementById('chat-container');
                const msg = document.createElement('div');
                msg.className = 'mb-2';
                msg.innerHTML = `<span class="badge bg-primary me-2">Tú</span> ${input.value}`;
                chatContainer.appendChild(msg);
                chatContainer.scrollTop = chatContainer.scrollHeight;
                input.value = '';
            }
        });
    </script>
</body>
