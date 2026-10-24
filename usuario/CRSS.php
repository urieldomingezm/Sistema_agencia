<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_destroy();
    echo json_encode(['success' => true]);
    exit;
}
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: '¿Cerrar sesión?',
        text: "¿Estás seguro que deseas cerrar la sesión?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#8B5CF6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('CRSS.php', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: '¡Sesión cerrada!',
                    text: 'Has cerrado sesión correctamente',
                    icon: 'success',
                    confirmButtonColor: '#8B5CF6'
                }).then(() => {
                    window.location.href = '/login.php';
                });
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un error al cerrar la sesión',
                    icon: 'error',
                    confirmButtonColor: '#8B5CF6'
                });
            });
        } else {
            window.history.back();
        }
    });
});
</script>