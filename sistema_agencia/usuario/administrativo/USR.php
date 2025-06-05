<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');?>

<body class="bg-light">
    <div class="container-fluid">
        <div class="row flex-nowrap">
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
