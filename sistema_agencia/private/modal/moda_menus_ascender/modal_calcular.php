<!-- CALCULAR RANGO EN VENTA -->

<!-- Modal para Dar Ascenso -->
<div class="modal fade" id="modalCalcular" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                    <i class="fas fa-calculator"></i> Calculadora de Rangos
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="calculatorForm">
                    <div class="mb-3">
                        <select class="form-select" required id="seleccion_eres">
                            <option value="" disabled selected>Selecciona tu estado</option>
                            <option value="trabajador">Trabajador</option>
                            <option value="nuevo">Nuevo</option>
                        </select>
                    </div>

                    <div id="campos_dinamicos" class="row g-2">
                        <!-- Los campos dinámicos se insertarán aquí -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.modal-content {
    border-radius: 10px;
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
}
.modal-header {
    background: linear-gradient(45deg, #4e73df, #224abe);
    border: none;
    padding: 1rem;
}
.modal-body {
    padding: 1rem;
}
.form-select, .form-control {
    font-size: 0.9rem;
    padding: 0.5rem;
    border: 1px solid #e3e6f0;
}
.form-select:focus, .form-control:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
}
#campos_dinamicos .col-md-6 {
    margin-bottom: 0.5rem;
}
.form-control[readonly] {
    background-color: #f8f9fc;
}
</style>

<!-- Mantener todos los scripts existentes sin cambios -->
<script>
    $(document).ready(function() {
        // Definir las misiones por rango
        const misionesPorRango = {
            agente: ['SNY- Aspirante', 'SNY- Agente -I', 'SNY- Agente -II', 'SNY- Agente -III'],
            seguridad: ['SNY - Seguridad -VIII', 'SNY - Seguridad -VII', 'SNY - Seguridad -VI', 'SNY - Seguridad -V',
                'SNY - Seguridad -IV', 'SNY - Seguridad -III', 'SNY - Seguridad -II', 'SNY - Seguridad -I',
                'SNY - JEFE DE Seguridad'
            ],
            tecnico: ['SNY - Tecnico VIII', 'SNY - Tecnico VII', 'SNY - Tecnico VI', 'SNY - Tecnico V',
                'SNY - Tecnico IV', 'SNY - Tecnico III', 'SNY - Tecnico II', 'SNY - Tecnico I',
                'SNY - INSPECTOR DE TECNICO'
            ],
            logistica: ['SNY - Logistica VIII', 'SNY - Logistica VII', 'SNY - Logistica VI', 'SNY - Logistica V',
                'SNY - Logistica IV', 'SNY - Logistica III', 'SNY - Logistica II', 'SNY - Logistica I',
                'SNY - ING. Logistico'
            ],
            supervisor: ['SNY - Supervisor VIII', 'SNY - Supervisor VII', 'SNY - Supervisor VI', 'SNY - Supervisor V',
                'SNY - Supervisor IV', 'SNY - Supervisor III', 'SNY - Supervisor II', 'SNY - Supervisor I',
                'SNY - SUP. EJECUTIVO'
            ],
            director: ['SNY - Director VIII', 'SNY - Director VII', 'SNY - Director VI', 'SNY - Director V',
                'SNY - Director IV', 'SNY - Director III', 'SNY - Director II', 'SNY - Director I',
                'SNY - Director SUPREMO'
            ],
            presidente: ['SNY - Presidente VIII', 'SNY - Presidente VII', 'SNY - Presidente VI', 'SNY - Presidente V',
                'SNY - Presidente IV', 'SNY - Presidente III', 'SNY - Presidente II', 'SNY - Presidente I',
                'SNY - Presidente MAYOR'
            ],
            operativo: ['SNY - Operativo VIII', 'SNY - Operativo VII', 'SNY - Operativo VI', 'SNY - Operativo V',
                'SNY - Operativo IV', 'SNY - Operativo III', 'SNY - Operativo II', 'SNY - Operativo I',
                'SNY - JEFE DPTO. OP'
            ]
        };

        // Definir los rangos disponibles para ascenso según el rango actual
        const rangosDisponibles = {
            agente: ['seguridad', 'tecnico', 'logistica', 'supervisor', 'director', 'presidente', 'operativo'],
            seguridad: ['tecnico', 'logistica', 'supervisor', 'director', 'presidente', 'operativo'],
            tecnico: ['logistica', 'supervisor', 'director', 'presidente', 'operativo'],
            logistica: ['supervisor', 'director', 'presidente', 'operativo'],
            supervisor: ['director', 'presidente', 'operativo'],
            director: ['presidente', 'operativo'],
            presidente: ['operativo'],
            operativo: []
        };

        // Actualizar la estructura de costos
        const costosPorRango = {
            agente: 0,
            seguridad: 0,
            tecnico: 0,
            logistica: 40,
            supervisor: 100,
            director: 295,
            presidente: 540,
            operativo: 1200
        };

        // Agregar costos por misión
        const costosPorMision = {
            agente: {
                'SNY- Aspirante': 0,
                'SNY- Agente -I': 0,
                'SNY- Agente -II': 0,
                'SNY- Agente -III': 0
            },
            seguridad: {
                'SNY - Seguridad -VIII': 0,
                'SNY - Seguridad -VII': 0,
                'SNY - Seguridad -VI': 0,
                'SNY - Seguridad -V': 0,
                'SNY - Seguridad -IV': 0,
                'SNY - Seguridad -III': 0,
                'SNY - Seguridad -II': 0,
                'SNY - Seguridad -I': 0,
                'SNY - JEFE DE Seguridad': 0
            },
            tecnico: {
                'SNY - Tecnico VIII': 0,
                'SNY - Tecnico VII': 0,
                'SNY - Tecnico VI': 0,
                'SNY - Tecnico V': 0,
                'SNY - Tecnico IV': 0,
                'SNY - Tecnico III': 0,
                'SNY - Tecnico II': 0,
                'SNY - Tecnico I': 0,
                'SNY - INSPECTOR DE TECNICO': 0
            },
            logistica: {
                'SNY - Logistica VIII': 40,
                'SNY - Logistica VII': 47,
                'SNY - Logistica VI': 54,
                'SNY - Logistica V': 61,
                'SNY - Logistica IV': 68,
                'SNY - Logistica III': 75,
                'SNY - Logistica II': 82,
                'SNY - Logistica I': 89,
                'SNY - ING. Logistico': 95
            },
            supervisor: {
                'SNY - Supervisor VIII': 100,
                'SNY - Supervisor VII': 110,
                'SNY - Supervisor VI': 120,
                'SNY - Supervisor V': 130,
                'SNY - Supervisor IV': 145,
                'SNY - Supervisor III': 160,
                'SNY - Supervisor II': 175,
                'SNY - Supervisor I': 190,
                'SNY - SUP. EJECUTIVO': 205
            },
            director: {
                'SNY - Director VIII': 295,
                'SNY - Director VII': 310,
                'SNY - Director VI': 325,
                'SNY - Director V': 340,
                'SNY - Director IV': 360,
                'SNY - Director III': 380,
                'SNY - Director II': 400,
                'SNY - Director I': 420,
                'SNY - Director SUPREMO': 440
            },
            presidente: {
                'SNY - Presidente VIII': 540,
                'SNY - Presidente VII': 580,
                'SNY - Presidente VI': 620,
                'SNY - Presidente V': 660,
                'SNY - Presidente IV': 700,
                'SNY - Presidente III': 740,
                'SNY - Presidente II': 780,
                'SNY - Presidente I': 820,
                'SNY - Presidente MAYOR': 860
            },
            operativo: {
                'SNY - Operativo VIII': 1200,
                'SNY - Operativo VII': 1300,
                'SNY - Operativo VI': 1400,
                'SNY - Operativo V': 1500,
                'SNY - Operativo IV': 1600,
                'SNY - Operativo III': 1700,
                'SNY - Operativo II': 1800,
                'SNY - Operativo I': 2000,
                'SNY - JEFE DPTO. OP': 2200
            }
        };

        // Función para generar opciones de rango
        function generarOpcionesRango(rangos) {
            let options = '<option disabled selected>Seleccionar</option>';
            rangos.forEach(rango => {
                options += `<option value="${rango}">${rango.charAt(0).toUpperCase() + rango.slice(1)}</option>`;
            });
            return options;
        }

        // Función para generar opciones de misión
        function generarOpcionesMision(rango) {
            let options = '<option disabled selected>Seleccionar</option>';
            misionesPorRango[rango].forEach(mision => {
                options += `<option value="${mision}">${mision}</option>`;
            });
            return options;
        }

        // Handle change event on selection dropdown
        $('#seleccion_eres').change(function() {
            const tipo = $(this).val();
            let campos = '';

            const todosLosRangos = ['agente', 'seguridad', 'tecnico', 'logistica', 'supervisor', 'director', 'presidente', 'operativo'];
            const rankOptions = generarOpcionesRango(todosLosRangos);

            if (tipo === 'trabajador') {
                campos = `
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Tu rango</label>
                        <select class="form-select" required id="rango_actual">
                            ${rankOptions}
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Misión</label>
                        <select class="form-select" required id="mision_actual">
                            <option disabled selected>Seleccione</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Rango deseado</label>
                        <select class="form-select" required id="rango_deseado">
                            <option disabled selected>Seleccione</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Misión deseada</label>
                        <select class="form-select" required id="mision_deseada">
                            <option disabled selected>Seleccione</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Costo total</label>
                        <input type="number" class="form-control" id="costo" readonly required>
                    </div>
                `;
            } else if (tipo === 'nuevo') {
                campos = `
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Rango deseado</label>
                        <select class="form-select" required id="rango_deseado_nuevo">
                            ${rankOptions}
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Misión</label>
                        <select class="form-select" required id="mision_nuevo">
                            <option disabled selected>Seleccione</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">Costo</label>
                        <input class="form-control" id="costo_nuevo" readonly required>
                    </div>
                `;
            }

            $('#campos_dinamicos').html(campos);

            // Actualizar eventos para trabajador
            if (tipo === 'trabajador') {
                $('#rango_actual').change(function() {
                    const rangoActual = $(this).val();
                    $('#mision_actual').html(generarOpcionesMision(rangoActual));
                    $('#rango_deseado').html(generarOpcionesRango(rangosDisponibles[rangoActual]));
                });

                $('#rango_deseado, #mision_deseada').change(function() {
                    const rangoDeseado = $('#rango_deseado').val();
                    const misionDeseada = $('#mision_deseada').val();

                    if (rangoDeseado && misionDeseada) {
                        const costoRango = costosPorRango[rangoDeseado];
                        const costoMision = costosPorMision[rangoDeseado][misionDeseada];
                        const costoTotal = costoRango + costoMision;
                        $('#costo').val(costoTotal);
                    }
                });

                $('#rango_deseado').change(function() {
                    const rangoDeseado = $(this).val();
                    $('#mision_deseada').html(generarOpcionesMision(rangoDeseado));
                });
            }

            // Actualizar eventos para nuevo
            if (tipo === 'nuevo') {
                $('#rango_deseado_nuevo').change(function() {
                    const rangoDeseado = $(this).val();
                    $('#mision_nuevo').html(generarOpcionesMision(rangoDeseado));
                });

                $('#rango_deseado_nuevo, #mision_nuevo').change(function() {
                    const rangoDeseado = $('#rango_deseado_nuevo').val();
                    const misionSeleccionada = $('#mision_nuevo').val();

                    if (rangoDeseado && misionSeleccionada) {
                        const costoRango = costosPorRango[rangoDeseado];
                        const costoMision = costosPorMision[rangoDeseado][misionSeleccionada];
                        const costoTotal = costoRango + costoMision;
                        $('#costo_nuevo').val(costoTotal);
                    }
                });
            }
        });
    });
</script>