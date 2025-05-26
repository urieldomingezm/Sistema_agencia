
document.addEventListener('DOMContentLoaded', function() {
    const btnRegistrarAscenso = document.getElementById('btnRegistrarAscensoSemanal');
    const weeklyAscensosCount = <?php echo json_encode($weeklyAscensosCount); ?>;

    if (btnRegistrarAscenso) {
        btnRegistrarAscenso.addEventListener('click', function() {
            if (weeklyAscensosCount === 0) {
                Swal.fire({
                    title: 'Sin Ascensos Registrados',
                    text: 'No tienes ascensos realizados esta semana para registrar.',
                    icon: 'info',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#3085d6',
                    backdrop: 'rgba(0,0,0,0.4)'
                });
                return;
            }

            Swal.fire({
                title: 'Confirmar Registro',
                html: `¿Deseas registrar tus <b>${weeklyAscensosCount}</b> ascensos realizados esta semana?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-check-circle me-2"></i>Sí, Registrar',
                cancelButtonText: '<i class="bi bi-x-circle me-2"></i>Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                backdrop: 'rgba(0,0,0,0.4)',
                customClass: {
                    confirmButton: 'btn-lg',
                    cancelButton: 'btn-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const requirementName = `${weeklyAscensosCount} ascensos realizados esta semana`;
                    const type = 'ascensos';

                    Swal.fire({
                        title: 'Registrando...',
                        html: 'Por favor espera mientras procesamos tu solicitud',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                        backdrop: 'rgba(0,0,0,0.4)'
                    });

                    fetch('/private/procesos/gestion_cumplimientos/registrar_requisitos.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'requirement_name=' + encodeURIComponent(requirementName) + '&type=' + encodeURIComponent(type)
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();
                        if (data.success) {
                            Swal.fire({
                                title: '¡Registro Exitoso!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor: '#3085d6',
                                backdrop: 'rgba(0,0,0,0.4)'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: data.message,
                                icon: 'error',
                                confirmButtonText: 'Entendido',
                                confirmButtonColor: '#3085d6',
                                backdrop: 'rgba(0,0,0,0.4)'
                            });
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error de Conexión',
                            text: 'Ocurrió un error al comunicarse con el servidor.',
                            icon: 'error',
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#3085d6',
                            backdrop: 'rgba(0,0,0,0.4)'
                        });
                    });
                }
            });
        });
    }
});