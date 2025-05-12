<?php
// Rutas para gestion de ascensos
require_once(GESTION_ASCENSOS_PATCH . 'mostrar_usuarios.php');
?>

<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="text-primary">
            GESTIÓN DE ASCENSOS DE USUARIOS
        </h1>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Total Usuarios</h6>
                        <h4 class="mb-0"><?php echo count($GLOBALS['ascensos']); ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:50px;height:50px;">
                        <i class="bi bi-arrow-up-circle fs-3"></i>
                    </div>
                    <div>
                        <h6 class="mb-1 text-muted">Ascensos Disponibles</h6>
                        <h4 class="mb-0">
                            <?php
                            $disponibles = 0;
                            foreach ($GLOBALS['ascensos'] as $ascenso) {
                                if ($ascenso['estado_ascenso'] === 'disponible') $disponibles++;
                            }
                            echo $disponibles;
                            ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Tabla de Ascensos -->

            <div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Gestión de Ascensos</h5>
        </div>
        <div class="card-body">
        <table id="tabladeusuariosascensos" class="table table-bordered table-striped table-hover text-center mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Código</th>
                        <th>Rango Actual</th>
                        <th>Misión Actual</th>
                        <th>Estado</th>
                        <th>Fecha de registro</th>
                        <th>Próximo Ascenso</th>
                        <th>Transcurrido</th>
                        <th>Actualizar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($GLOBALS['ascensos'] as $ascenso): 
                        // Calcular tiempo restante inicial
                        $tiempoRestante = '00:00:00';
                        $fechaActual = new DateTime('now', new DateTimeZone('America/Mexico_City'));
                        
                        // Calcular tiempo transcurrido desde el último ascenso
                        $tiempoTranscurrido = '00:00:00';
                        if (!empty($ascenso['fecha_ultimo_ascenso'])) {
                            $fechaUltimo = new DateTime($ascenso['fecha_ultimo_ascenso']);
                            $intervaloTranscurrido = $fechaUltimo->diff($fechaActual);
                            $tiempoTranscurrido = $intervaloTranscurrido->format('%H:%I:%S');
                        }
                        
                        // Calcular tiempo restante para próximo ascenso
                        if (!empty($ascenso['fecha_disponible_ascenso'])) {
                            $fechaDisponible = new DateTime($ascenso['fecha_disponible_ascenso']);
                            if ($fechaDisponible > $fechaActual) {
                                $intervalo = $fechaActual->diff($fechaDisponible);
                                $tiempoRestante = $intervalo->format('%H:%I:%S');
                            }
                        }
                        
                        // Mostrar el tiempo transcurrido si existe en la BD, o el calculado si es NULL
                        $tiempoMostrar = (!empty($ascenso['tiempo_ascenso']) && $ascenso['tiempo_ascenso'] != '00:00:00') 
                            ? $ascenso['tiempo_ascenso'] 
                            : $tiempoTranscurrido;
                    ?>
                        <tr data-codigo-time="<?= htmlspecialchars($ascenso['codigo_time']) ?>">
                            <td><?= htmlspecialchars($ascenso['nombre_habbo']) ?></td>
                            <td><?= htmlspecialchars($ascenso['rango_actual']) ?></td>
                            <td><?= htmlspecialchars($ascenso['mision_actual']) ?></td>
                            <td>
                                <span class="badge <?= $ascenso['estado_ascenso'] === 'disponible' ? 'bg-success' : ($ascenso['estado_ascenso'] === 'pendiente' ? 'bg-warning' : ($ascenso['estado_ascenso'] === 'en_espera' ? 'bg-secondary' : 'bg-info')) ?>">
                                    <?= htmlspecialchars($ascenso['estado_ascenso']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($ascenso['fecha_ultimo_ascenso']) ?></td>
                            <td data-fecha-ascenso="<?= htmlspecialchars($ascenso['fecha_disponible_ascenso']) ?>">
                                <?= htmlspecialchars($ascenso['fecha_disponible_ascenso'] ? date('Y-m-d H:i:s', strtotime($ascenso['fecha_disponible_ascenso'])) : 'No disponible') ?>
                            </td>
                            <td data-tiempo-restante="<?= htmlspecialchars($tiempoMostrar) ?>" data-tiempo-transcurrido="<?= htmlspecialchars($tiempoTranscurrido) ?>">
                                <?= htmlspecialchars($tiempoMostrar) ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    data-codigo="<?= htmlspecialchars($ascenso['codigo_time']) ?>">
                                    Actualizar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTable
    const dataTable = new simpleDatatables.DataTable("#tabladeusuariosascensos", {
        searchable: true,
        fixedHeight: true,
        labels: {
            placeholder: "Buscar...",
            perPage: "Registros por página",
            noRows: "No hay registros",
            info: "Mostrando {start} a {end} de {rows} registros",
        }
    });

    // Función para convertir milisegundos a formato HH:MM:SS
    function msToTime(duration) {
        if (isNaN(duration)) return "00:00:00";
        duration = Math.max(0, duration);
        
        const seconds = Math.floor((duration / 1000) % 60);
        const minutes = Math.floor((duration / (1000 * 60)) % 60);
        const hours = Math.floor((duration / (1000 * 60 * 60)));
        
        const pad = (n) => n.toString().padStart(2, '0');
        return `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
    }

    // Función para obtener la hora actual en México
    function getHoraMexico() {
        try {
            return new Date(new Date().toLocaleString("en-US", {timeZone: "America/Mexico_City"}));
        } catch (e) {
            console.error("Error al obtener hora México:", e);
            return new Date();
        }
    }

    // Función para parsear fecha de la base de datos
    function parseFechaDB(fechaStr) {
        if (!fechaStr || fechaStr === 'No disponible') return null;
        
        fechaStr = fechaStr.trim();
        let fecha = new Date(fechaStr);
        
        if (!isNaN(fecha.getTime())) return fecha;
        
        fecha = new Date(fechaStr.replace(' ', 'T'));
        if (!isNaN(fecha.getTime())) return fecha;
        
        const partes = fechaStr.split(/[\/\-\s:]/);
        if (partes.length >= 3) {
            const dia = parseInt(partes[0], 10);
            const mes = parseInt(partes[1], 10) - 1;
            const anio = parseInt(partes[2], 10);
            fecha = new Date(anio, mes, dia);
            if (!isNaN(fecha.getTime())) return fecha;
        }
        
        console.error("No se pudo parsear fecha:", fechaStr);
        return null;
    }

    // Función para calcular tiempo transcurrido entre dos fechas
    function calcularTiempoTranscurrido(fechaInicio, fechaFin) {
        const diffMs = Math.abs(fechaFin - fechaInicio);
        return msToTime(diffMs);
    }

    // Función para actualizar el estado del ascenso
    async function actualizarAscenso(codigoTime, button) {
        const fila = document.querySelector(`tr[data-codigo-time="${codigoTime}"]`);
        if (!fila) return;
        
        const celdaFechaDisponible = fila.querySelector('td:nth-child(6)');
        const celdaFechaUltimo = fila.querySelector('td:nth-child(5)');
        const celdaEstado = fila.querySelector('td:nth-child(4) span');
        const celdaTiempoRestante = fila.querySelector('td:nth-child(7)');
        
        const fechaUltimoTexto = celdaFechaUltimo.textContent.trim();
        const fechaUltimo = parseFechaDB(fechaUltimoTexto);
        
        if (!fechaUltimo) {
            alert("No se pudo obtener la fecha del último ascenso.");
            return;
        }
        
        try {
            const horaActual = getHoraMexico();
            const tiempoCalculado = calcularTiempoTranscurrido(fechaUltimo, horaActual);
            
            // Preparar datos para enviar al servidor
            const formData = new FormData();
            formData.append('action', 'actualizar_tiempo_ascenso');
            formData.append('codigo_time', codigoTime);
            formData.append('tiempo_ascenso', tiempoCalculado);
            formData.append('estado_ascenso', 'pendiente');
            formData.append('tiempo_transcurrido', tiempoCalculado);
            
            button.disabled = true;
            button.innerHTML = '<i class="bi bi-hourglass-split"></i> Actualizando...';
            
            // Enviar la actualización al servidor
            const response = await fetch('procesar_ascenso.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.error || 'Error en la actualización');
            }
            
            // Actualizar la UI con la respuesta del servidor
            celdaEstado.textContent = data.nuevo_estado;
            celdaEstado.className = data.nuevo_estado === 'disponible' ? 'badge bg-success' : 'badge bg-warning';
            
            celdaTiempoRestante.textContent = data.tiempo_transcurrido;
            celdaTiempoRestante.setAttribute('data-tiempo-transcurrido', data.tiempo_transcurrido);
            
            // Mostrar la nueva fecha disponible
            const fechaMostrar = data.nueva_fecha === '0000-00-00 00:00:00' ? '00:00:00' : 
                new Date(data.nueva_fecha).toLocaleString('es-MX', {timeZone: 'America/Mexico_City'});
            celdaFechaDisponible.textContent = fechaMostrar;
            celdaFechaDisponible.setAttribute('data-fecha-ascenso', data.nueva_fecha);
            
            // Feedback visual
            button.innerHTML = '<i class="bi bi-check-circle-fill"></i> Actualizado';
            button.classList.remove('btn-primary');
            button.classList.add('btn-success');
            
            setTimeout(() => {
                button.innerHTML = 'Actualizar';
                button.classList.remove('btn-success');
                button.classList.add('btn-primary');
                button.disabled = false;
            }, 2000);
            
        } catch (error) {
            console.error("Error al actualizar ascenso:", error);
            button.innerHTML = 'Error';
            button.classList.remove('btn-primary');
            button.classList.add('btn-danger');
            
            setTimeout(() => {
                button.innerHTML = 'Actualizar';
                button.classList.remove('btn-danger');
                button.classList.add('btn-primary');
                button.disabled = false;
            }, 2000);
            
            alert("Error al actualizar: " + error.message);
        }
    }

    // Manejador de eventos para los botones de actualizar
    document.addEventListener('click', function(e) {
        if (e.target && e.target.matches('button[data-codigo]')) {
            const codigoTime = e.target.getAttribute('data-codigo');
            actualizarAscenso(codigoTime, e.target);
        }
    });

    // Actualizar automáticamente los tiempos cada minuto
    function actualizarTiempos() {
        const ahora = getHoraMexico();
        const filas = document.querySelectorAll('tr[data-codigo-time]');
        
        filas.forEach(fila => {
            const fechaUltimoTexto = fila.querySelector('td:nth-child(5)').textContent.trim();
            const fechaUltimo = parseFechaDB(fechaUltimoTexto);
            
            if (!fechaUltimo) return;
            
            try {
                const tiempoTranscurrido = calcularTiempoTranscurrido(fechaUltimo, ahora);
                const celdaTiempo = fila.querySelector('td:nth-child(7)');
                celdaTiempo.textContent = tiempoTranscurrido;
                celdaTiempo.setAttribute('data-tiempo-transcurrido', tiempoTranscurrido);
            } catch (error) {
                console.error("Error en actualización automática:", error);
            }
        });
    }
    
    // Ejecutar al cargar y cada minuto
    actualizarTiempos();
    setInterval(actualizarTiempos, 60000);
});
</script>