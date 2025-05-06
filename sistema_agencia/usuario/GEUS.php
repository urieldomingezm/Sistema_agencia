<?php 

// PROCESO PARA MOSTRAR TODOS LOS USUARIOS REGISTRADOS EN LA BASE DE DATOS Y PODER EDITARLOS O ELIMINARLOS
require_once(GESTION_USUARIOS_PACH. 'mostrar_usuarios.php');

// MODAL PARA EDITAR LA CONTRASEÑA DE LOS USUARIOS
require_once(MODAL_GESTION_USUARIOS_PACH.'modificar_contraseña.php');

?>

<table id="usuariosTable" class="table table-striped table-hover">
    <thead>
        <tr class="text-white">
            <th>ID</th>
            <th>Habbo</th>
            <th>Password</th>
            <th>Ip</th>
            <th>Fecha registro</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['id']) ?></td>
                <td><?= htmlspecialchars($usuario['nombre_habbo']) ?></td>
                <td><?= htmlspecialchars(substr($usuario['password_registro'], 0, 10)) ?></td>
                <td><?= htmlspecialchars(substr(md5($usuario['ip_registro']), 0, 16)) ?></td>
                <td><?= htmlspecialchars($usuario['fecha_registro']) ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-primary btn-sm rounded-pill me-2" onclick="editarUsuario(<?= $usuario['id'] ?>)">
                            <i class="bi bi-key-fill"></i> Contraseña
                        </button>
                        <button class="btn btn-danger btn-sm rounded-pill" onclick="eliminarUsuario(<?= $usuario['id'] ?>)">
                            <i class="bi bi-trash-fill"></i> Eliminar
                        </button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<style>
    .btn-sm {
        padding: 0.35rem 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }
    .btn-sm:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .rounded-pill {
        border-radius: 50rem !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dataTable = new simpleDatatables.DataTable("#usuariosTable", {
            searchable: true,
            fixedHeight: true,
            perPage: 10,
            perPageSelect: [10, 25, 50, 100],
            labels: {
                placeholder: "Buscar...",
                perPage: "registros por página",
                noRows: "No se encontraron registros",
                info: "Mostrando {start} a {end} de {rows} registros",
                loading: "Cargando...",
                infoFiltered: "(filtrado de {rows} registros totales)"
            }
        });
    });
</script>

<script>
    function editarUsuario(id) {
        // Mostrar modal con los datos del usuario
        $.ajax({
            url: '/private/modal/modal_gestion_usuarios/modificar_contraseña.php?id=' + id,
            success: function(response) {
                $('body').append(response);
                $('#modalCambiarPassword').modal('show');
                
                // Configurar el formulario
                $('#formCambiarPassword').on('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = $(this).serializeArray();
                    const data = {};
                    formData.forEach(item => {
                        data[item.name] = item.value;
                    });
                    
                    // Enviar datos al servidor
                    $.ajax({
                        url: '/private/procesos/gestion_usuarios/modificar_usuarios.php',
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(data),
                        success: function(response) {
                            $('#modalCambiarPassword').modal('hide');
                            Swal.fire({
                                title: response.success ? 'Éxito' : 'Error',
                                text: response.message,
                                icon: response.success ? 'success' : 'error'
                            });
                        }
                    });
                });
                
                // Limpiar modal al cerrar
                $('#modalCambiarPassword').on('hidden.bs.modal', function() {
                    $(this).remove();
                });
            }
        });
    }
</script>