<?php
// Redireccionar al usuario a la página de inicio después de mostrar el mensaje
header("refresh:5;url=https://agenciasheinhb.site/usuario/?page=inicio");
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body text-center p-5">
                    <i class="bi bi-tools text-warning" style="font-size: 5rem;"></i>
                    <h1 class="mt-4">Sección en Mantenimiento</h1>
                    <p class="lead my-4">Estamos trabajando para mejorar esta sección del sistema. Por favor, vuelve más tarde.</p>
                    <div class="alert alert-info my-4">
                        Serás redirigido a la página de inicio en <span id="countdown">5</span> segundos.
                    </div>
                    <a href="https://agenciasheinhb.site/usuario/?page=inicio" class="btn btn-primary">Volver al Inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Contador regresivo
    let seconds = 5;
    const countdownElement = document.getElementById('countdown');
    
    const interval = setInterval(function() {
        seconds--;
        countdownElement.textContent = seconds;
        
        if (seconds <= 0) {
            clearInterval(interval);
        }
    }, 1000);
</script>