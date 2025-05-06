<?php 
require_once(GESTION_USUARIOS_PACH. 'mostrar_usuarios.php');
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
                <td><?= htmlspecialchars($usuario['password_registro']) ?></td>
                <td><?= htmlspecialchars(substr(md5($usuario['ip_registro']), 0, 16)) ?></td>
                <td><?= htmlspecialchars($usuario['fecha_registro']) ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-primary btn-sm" onclick="editarUsuario(<?= $usuario['id'] ?>)">
                            Editar
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(<?= $usuario['id'] ?>)">
                            Eliminar
                        </button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

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