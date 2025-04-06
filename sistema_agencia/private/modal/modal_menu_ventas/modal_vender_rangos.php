<?php
require_once(CONFIG_PATH . 'bd.php');

class Venta
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registrarVenta($titulo, $descripcion, $compra, $caducidad, $estado, $costo, $comprador, $encargado)
    {
        try {
            $sql = "INSERT INTO gestion_ventas 
                    (venta_titulo, venta_descripcion, venta_compra, venta_caducidad, venta_estado, venta_costo, venta_comprador, venta_encargado, venta_fecha_compra) 
                    VALUES (:titulo, :descripcion, :compra, :caducidad, :estado, :costo, :comprador, :encargado, NOW())";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':compra', $compra);
            $stmt->bindParam(':caducidad', $caducidad);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':costo', $costo);
            $stmt->bindParam(':comprador', $comprador);
            $stmt->bindParam(':encargado', $encargado);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al registrar venta: " . $e->getMessage());
            return false;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['guardarVenta'])) {
    $database = new Database();
    $db = $database->getConnection();
    $venta = new Venta($db);

    $resultado = $venta->registrarVenta(
        $_POST['venta_titulo'],
        $_POST['venta_descripcion'],
        $_POST['venta_compra'],
        $_POST['venta_caducidad'],
        $_POST['venta_estado'],
        $_POST['venta_costo'],
        $_POST['venta_comprador'],
        $_POST['venta_encargado']
    );

    if ($resultado) {
        echo "<script>
        Swal.fire({
            title: '¡Éxito!',
            text: 'Venta registrada exitosamente',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/usuario/index.php?page=gestionar ventas';
            }
        });
    </script>";
    } else {
        echo "<script>
        Swal.fire({
            title: '¡Error!',
            text: 'Error al registrar la venta',
            icon: 'error',
            confirmButtonText: 'Intentar de nuevo'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/usuario/index.php?page=gestionar ventas';
            }
        });
    </script>";
    }
}
?>

<!-- Modal para Venta de Rangos -->
<div class="modal fade" id="modalrangos" tabindex="-1" aria-labelledby="modalrangosLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalrangosLabel">Venta de Rangos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" class="was-validated">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Título de Venta</label>
                            <select name="venta_titulo" id="venta_titulo" class="form-control" required>
                                <option value="membresia">Membresía</option>
                                <option value="venta_rango">Venta de Rango</option>
                                <option value="traslado">Traslado</option>
                            </select>
                            <div class="invalid-feedback">Título es requerido</div>
                        </div>
                        <div class="col-md-6 mb-2" id="descripcion_div">
                            <label class="form-label">Descripción</label>
                            <!-- Este select aparece solo si se selecciona "Membresía" -->
                            <select name="venta_descripcion" id="venta_descripcion" class="form-control" style="display:none;">
                                <option value="opcion_1">Opción 1</option>
                                <option value="opcion_2">Opción 2</option>
                                <option value="opcion_3">Opción 3</option>
                                <option value="opcion_4">Opción 4</option>
                                <option value="opcion_5">Opción 5</option>
                            </select>
                            <!-- Si no es Membresía, el campo será un texto normal -->
                            <input type="text" name="venta_descripcion" maxlength="60" class="form-control" id="venta_descripcion_input" required>
                            <div class="invalid-feedback">Descripción es requerida</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Fecha de Compra</label>
                            <input type="date" name="venta_compra" id="venta_compra" class="form-control" required>
                            <div class="invalid-feedback">Fecha de compra es requerida</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Fecha de Caducidad</label>
                            <input type="date" name="venta_caducidad" id="venta_caducidad" class="form-control" required>
                            <div class="invalid-feedback">Fecha de caducidad es requerida</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Estado</label>
                            <input type="text" name="venta_estado" id="venta_estado" maxlength="50" class="form-control" required>
                            <div class="invalid-feedback">Estado es requerido</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Costo</label>
                            <input type="number" name="venta_costo" class="form-control" required>
                            <div class="invalid-feedback">Costo es requerido</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Comprador</label>
                            <input type="text" name="venta_comprador" maxlength="16" class="form-control" required>
                            <div class="invalid-feedback">Comprador es requerido</div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Encargado</label>
                            <input type="text" name="venta_encargado" maxlength="16" class="form-control" required>
                            <div class="invalid-feedback">Encargado es requerido</div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" name="guardarVenta" class="btn btn-success">Registrar Venta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Función que se activa cuando se cambia el valor del select
    document.getElementById('venta_titulo').addEventListener('change', function() {
        const titulo = this.value;
        const compra = document.getElementById('venta_compra');
        const caducidad = document.getElementById('venta_caducidad');
        const estado = document.getElementById('venta_estado');
        const descripcionDiv = document.getElementById('descripcion_div');
        const descripcionSelect = document.getElementById('venta_descripcion');
        const descripcionInput = document.getElementById('venta_descripcion_input');

        if (titulo === 'membresia') {
            // Habilitar fecha de compra y deshabilitar fecha de caducidad
            compra.disabled = false;
            caducidad.disabled = false;
            estado.value = 'Disponible'; // Establecer estado como "Disponible"
            
            // Mostrar el select de descripciones
            descripcionDiv.innerHTML = `
                <label class="form-label">Descripción</label>
                <select name="venta_descripcion" id="venta_descripcion" class="form-control" required>
                    <option value="opcion_1">Opción 1</option>
                    <option value="opcion_2">Opción 2</option>
                    <option value="opcion_3">Opción 3</option>
                    <option value="opcion_4">Opción 4</option>
                    <option value="opcion_5">Opción 5</option>
                </select>
            `;
        } else {
            // Deshabilitar fecha de compra, caducidad y estado
            compra.disabled = true;
            caducidad.disabled = true;
            estado.value = ''; // Limpiar el campo de estado

            // Mostrar el campo de texto para la descripción
            descripcionDiv.innerHTML = `
                <label class="form-label">Descripción</label>
                <input type="text" name="venta_descripcion" maxlength="60" class="form-control" id="venta_descripcion_input" required>
            `;
        }
    });

    // Función para establecer la fecha de caducidad un mes después de la fecha de compra
    document.getElementById('venta_compra').addEventListener('change', function() {
        const compraFecha = new Date(this.value);
        if (compraFecha) {
            const caducidadFecha = new Date(compraFecha);
            caducidadFecha.setMonth(compraFecha.getMonth() + 1); // Añadir un mes
            const caducidadFormatted = caducidadFecha.toISOString().split('T')[0]; // Formatear la fecha
            document.getElementById('venta_caducidad').value = caducidadFormatted;
        }
    });
</script>
