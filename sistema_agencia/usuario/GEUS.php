<?php 
require_once(GESTION_USUARIOS_PACH. 'mostrar_usuarios.php');
?>

<table id="usuariosTable" class="table table-striped table-hover">
    <thead>
        <tr class="text-white">
            <th>ID</th>
            <th>Nombre Habbo</th>
            <th>Rango</th>
            <th>Fecha Registro</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['id']) ?></td>
                <td><?= htmlspecialchars($usuario['nombre_habbo']) ?></td>
                <td><?= htmlspecialchars($usuario['rango']) ?></td>
                <td><?= htmlspecialchars(date('Y-m-d', strtotime($usuario['fecha_registro']))) ?></td>
                <td>
                    <span class="badge <?= $usuario['activo'] ? 'bg-success' : 'bg-danger' ?>">
                        <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?>
                    </span>
                </td>
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

<table id="ventasTable" class="table table-striped table-hover">
    <thead>
        <tr class="text-white">
            <th>ID</th>
            <th>Membresia</th>
            <th>Compra</th>
            <th>Caducidad</th>
            <th>Estado</th>
            <th>Costo</th>
            <th>Comprador</th>
            <th>Encargado</th>
            <th>Fecha Compra</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ventas as $venta): ?>
            <tr>
                <td><?= htmlspecialchars($venta['venta_id']) ?></td>
                <td><?= htmlspecialchars($venta['venta_titulo']) ?></td>
                <td><?= htmlspecialchars($venta['venta_compra']) ?></td>
                <td><?= htmlspecialchars($venta['venta_caducidad']) ?></td>
                <td>
                    <span class="badge <?= strtolower($venta['venta_estado']) === 'activo' ? 'bg-success' : 'bg-danger' ?>">
                        <?= htmlspecialchars(ucfirst(strtolower($venta['venta_estado']))) ?>
                    </span>
                </td>
                <td><?= htmlspecialchars($venta['venta_costo']) ?></td>
                <td><?= htmlspecialchars($venta['venta_comprador']) ?></td>
                <td><?= htmlspecialchars($venta['venta_encargado']) ?></td>
                <td><?= htmlspecialchars(date('Y-m-d', strtotime($venta['venta_fecha_compra']))) ?></td>
                <td>
                    <div class="dropdown">
                        <div class="btn-group" role="group">
                            <button class="btn btn-danger btn-sm" onclick="deleteVenta(<?= $venta['venta_id'] ?>)">
                                Eliminar
                            </button>
                            <button class="btn btn-success btn-sm" onclick="renovarVenta(<?= $venta['venta_id'] ?>)">
                                Renovar
                            </button>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        const dataTable = new simpleDatatables.DataTable("#ventasTable", {
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