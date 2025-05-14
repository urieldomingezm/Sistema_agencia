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