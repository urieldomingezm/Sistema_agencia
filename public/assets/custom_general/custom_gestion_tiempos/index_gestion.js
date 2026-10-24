document.addEventListener('DOMContentLoaded', function() {

    // Configuración para la tabla principal
    const dataTable = new simpleDatatables.DataTable("#datatable_tiempos", {
        searchable: true,
        fixedHeight: true,
        labels: {
            placeholder: "Buscar...",
            perPage: "Registros por página",
            noRows: "No hay registros",
            info: "Mostrando {start} a {end} de {rows} registros",
        }
    });

    // Configuración para la tabla de tiempos inactivos
    const dataTableInactivos = new simpleDatatables.DataTable("#datatable_tiempos_inactivos", {
        searchable: true,
        labels: {
            placeholder: "Buscar...",
            perPage: "Registros por página",
            noRows: "No hay registros",
            info: "Mostrando {start} a {end} de {rows} registros",
        }
    });

    // Configuración para la tabla de tiempos completados
    const dataTableCompletados = new simpleDatatables.DataTable("#datatable_tiempos_completados", {
        searchable: true,
        labels: {
            placeholder: "Buscar...",
            perPage: "Registros por página",
            noRows: "No hay registros",
            info: "Mostrando {start} a {end} de {rows} registros",
        }
    });

    function setupButtonEvents() {
        document.querySelectorAll('.liberar-encargado').forEach(button => {
            button.addEventListener('click', function() {
                const codigo = this.getAttribute('data-codigo');
                handleLiberarEncargado(codigo);
            });
        });

        document.querySelectorAll('.pausar-tiempo').forEach(button => {
            button.addEventListener('click', function() {
                const codigo = this.getAttribute('data-codigo');
                handlePausarTiempo(codigo);
            });
        });

        document.querySelectorAll('.ver-tiempo').forEach(button => {
            button.addEventListener('click', function() {
                const codigo = this.getAttribute('data-codigo');
                handleVerTiempo(codigo);
            });
        });

        document.querySelectorAll('.completar-tiempo').forEach(button => {
            button.addEventListener('click', function() {
                const codigo = this.getAttribute('data-codigo');
                handleCompletarTiempo(codigo);
            });
        });

        function handleCompletarTiempo(codigo) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas marcar este tiempo como completado?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, completar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/private/procesos/gestion_tiempos/procesar_tiempo.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'accion=completar_tiempo&codigo_time=' + encodeURIComponent(codigo)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('¡Éxito!', 'Tiempo completado correctamente', 'success').then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Error al completar el tiempo', 'error');
                        }
                    });
                }
            });
        }

        document.querySelectorAll('.designar-tiempo').forEach(button => {
            button.addEventListener('click', function() {
                const codigo = this.getAttribute('data-codigo');
                handleDesignarTiempo(codigo);
            });
        });

        function handleDesignarTiempo(codigo) {
            Swal.fire({
                title: 'Designar Tiempo',
                html: `
                    <select id="usuarioDesignado" class="form-select">
                        <option value="">Seleccionar usuario</option>
                    </select>
                `,
                showCancelButton: true,
                confirmButtonText: 'Designar',
                cancelButtonText: 'Cancelar',
                didOpen: () => {
                    fetch('/private/procesos/gestion_tiempos/usuarios_select.php')
                        .then(response => response.json())
                        .then(data => {
                            const select = document.getElementById('usuarioDesignado');
                            if (data.success) {
                                data.data.forEach(usuario => {
                                    const option = document.createElement('option');
                                    option.value = usuario.id;
                                    option.textContent = `${usuario.nombre_habbo} (${usuario.rol_nombre})`;
                                    select.appendChild(option);
                                });
                            } else {
                                Swal.showValidationMessage(data.message);
                            }
                        });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const usuarioDesignado = document.getElementById('usuarioDesignado').value;
                    if (usuarioDesignado) {
                        fetch('/private/procesos/gestion_tiempos/procesar_tiempo.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: 'accion=designar_tiempo&codigo_time=' + encodeURIComponent(codigo) + '&usuario_designado=' + encodeURIComponent(usuarioDesignado)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('¡Éxito!', 'Tiempo designado correctamente', 'success').then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire('Error', data.message || 'Error al designar el tiempo', 'error');
                            }
                        });
                    }
                }
            });
        }
    }

    function handleVerTiempo(codigo) {
        fetch('/private/procesos/gestion_tiempos/procesar_tiempo.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'accion=ver_tiempo&codigo_time=' + encodeURIComponent(codigo)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Tiempo Acumulado',
                    html: '<div style="text-align: center;">' +
                          '<b>Tiempo acumulado:</b> ' + data.tiempo_acumulado + '<br>' +
                          '<b>Tiempo transcurrido:</b> ' + data.tiempo_transcurrido + '<br>' +
                          '<b>Total:</b> ' + data.tiempo_total +
                          '</div>',
                    icon: 'info',
                    confirmButtonText: 'Aceptar'
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Error al obtener el tiempo',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Error de conexión',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        });
    }

    function handleLiberarEncargado(codigo) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se liberará el Tiempo actual para que otra persona pueda tomar el tiempo",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, liberar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Procesando',
                    text: 'Liberando encargado...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('/private/procesos/gestion_tiempos/procesar_tiempo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'accion=liberar_encargado&codigo_time=' + encodeURIComponent(codigo)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'Encargado liberado correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Ocurrió un error al liberar al encargado',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error de conexión',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                });
            }
        });
    }

    function handlePausarTiempo(codigo) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se pausará el tiempo actual y se liberará para que otra persona pueda tomar el tiempo",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, pausar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Procesando',
                    text: 'Pausando y liberando tiempo...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('/private/procesos/gestion_tiempos/procesar_tiempo.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'accion=pausar_tiempo&codigo_time=' + encodeURIComponent(codigo)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'Tiempo pausado y liberado correctamente',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Ocurrió un error al pausar y liberar el tiempo',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error',
                        text: 'Ocurrió un error de conexión',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                });
            }
        });
    }

    // Configurar eventos para todas las tablas
    function setupTableEvents(table) {
        table.on('datatable.page', setupButtonEvents);
        table.on('datatable.sort', setupButtonEvents);
        table.on('datatable.search', setupButtonEvents);
        table.on('datatable.perpage', setupButtonEvents);
    }

    // Aplicar eventos a todas las tablas
    setupTableEvents(dataTable);
    setupTableEvents(dataTableInactivos);
    setupTableEvents(dataTableCompletados);

    setupButtonEvents();
});