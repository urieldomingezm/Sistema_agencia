<!-- Modal para Dar Ascenso -->
<div class="modal fade" id="modalCalcular" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                     Calculadora de Rangos
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

<!-- Mantener todos los scripts existentes sin cambios -->
<script>
    $(document).ready(function() {
        // Definir las misiones por rango
        const misionesPorRango = {
            agente: ['AGE- Iniciado I', 'AGE- Novato H', 'AGE- Auxiliar G', 'AGE- Ayudante F',
                'AGE- Junior E', 'AGE- Intermedio D', 'AGE- Avanzado C', 'AGE- Experto B', 'AGE- Jefe A'
            ],
            seguridad: ['SEG- Iniciado I', 'SEG- Novato H', 'SEG- Auxiliar G', 'SEG- Ayudante F',
                'SEG- Junior E', 'SEG- Intermedio D', 'SEG- Avanzado C', 'SEG- Experto B', 'SEG- Jefe A'
            ],
            tecnico: ['TEC- Iniciado I', 'TEC- Novato H', 'TEC- Auxiliar G', 'TEC- Ayudante F',
                'TEC- Junior E', 'TEC- Intermedio D', 'TEC- Avanzado C', 'TEC- Experto B', 'TEC- Jefe A'
            ],
            logistica: ['LOG- Iniciado I', 'LOG- Novato H', 'LOG- Auxiliar G', 'LOG- Ayudante F',
                'LOG- Junior E', 'LOG- Intermedio D', 'LOG- Avanzado C', 'LOG- Experto B', 'LOG- Jefe A'
            ],
            supervisor: ['SUP- Iniciado I', 'SUP- Novato H', 'SUP- Auxiliar G', 'SUP- Ayudante F',
                'SUP- Junior E', 'SUP- Intermedio D', 'SUP- Avanzado C', 'SUP- Experto B', 'SUP- Jefe A'
            ],
            director: ['DIR- Iniciado I', 'DIR- Novato H', 'DIR- Auxiliar G', 'DIR- Ayudante F',
                'DIR- Junior E', 'DIR- Intermedio D', 'DIR- Avanzado C', 'DIR- Experto B', 'DIR- Jefe A'
            ],
            presidente: ['PRES- Iniciado I', 'PRES- Novato H', 'PRES- Auxiliar G', 'PRES- Ayudante F',
                'PRES- Junior E', 'PRES- Intermedio D', 'PRES- Avanzado C', 'PRES- Experto B', 'PRES- Jefe A'
            ],
            operativo: ['OPE- Iniciado I', 'OPE- Novato H', 'OPE- Auxiliar G', 'OPE- Ayudante F',
                'OPE- Junior E', 'OPE- Intermedio D', 'OPE- Avanzado C', 'OPE- Experto B', 'OPE- Jefe A'
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
            logistica: 0,
            supervisor: 0,
            director: 0,
            presidente: 0,
            operativo: 0
        };

        // Agregar costos por misión
        const costosPorMision = {
            agente: {
                'AGE- Iniciado I': 0,
                'AGE- Novato H': 0,
                'AGE- Auxiliar G': 0,
                'AGE- Ayudante F': 0,
                'AGE- Junior E': 0,
                'AGE- Intermedio D': 0,
                'AGE- Avanzado C': 0,
                'AGE- Experto B': 0,
                'AGE- Jefe A': 0
            },
            seguridad: {
                'SEG- Iniciado I': 8,
                'SEG- Novato H': 10,
                'SEG- Auxiliar G': 12,
                'SEG- Ayudante F': 14,
                'SEG- Junior E': 16,
                'SEG- Intermedio D': 18,
                'SEG- Avanzado C': 20,
                'SEG- Experto B': 22,
                'SEG- Jefe A': 24
            },
            tecnico: {
                'TEC- Iniciado I': 32,
                'TEC- Novato H': 40,
                'TEC- Auxiliar G': 44,
                'TEC- Ayudante F': 48,
                'TEC- Junior E': 52,
                'TEC- Intermedio D': 60,
                'TEC- Avanzado C': 62,
                'TEC- Experto B': 64,
                'TEC- Jefe A': 68
            },
            logistica: {
                'LOG- Iniciado I': 74,
                'LOG- Novato H': 80,
                'LOG- Auxiliar G': 86,
                'LOG- Ayudante F': 92,
                'LOG- Junior E': 98,
                'LOG- Intermedio D': 104,
                'LOG- Avanzado C': 110,
                'LOG- Experto B': 116,
                'LOG- Jefe A': 122
            },
            supervisor: {
                'SUP- Iniciado I': 130,
                'SUP- Novato H': 138,
                'SUP- Auxiliar G': 146,
                'SUP- Ayudante F': 154,
                'SUP- Junior E': 162,
                'SUP- Intermedio D': 170,
                'SUP- Avanzado C': 178,
                'SUP- Experto B': 186,
                'SUP- Jefe A': 194
            },
            director: {
                'DIR- Iniciado I': 204,
                'DIR- Novato H': 214,
                'DIR- Auxiliar G': 223,
                'DIR- Ayudante F': 232,
                'DIR- Junior E': 246,
                'DIR- Intermedio D': 256,
                'DIR- Avanzado C': 266,
                'DIR- Experto B': 276,
                'DIR- Jefe A': 288
            },
            presidente: {
                'PRES- Iniciado I': 298,
                'PRES- Novato H': 301,
                'PRES- Auxiliar G': 312,
                'PRES- Ayudante F': 322,
                'PRES- Junior E': 328,
                'PRES- Intermedio D': 333,
                'PRES- Avanzado C': 340,
                'PRES- Experto B': 351,
                'PRES- Jefe A': 363
            },
            operativo: {
                'OPE- Iniciado I': 409,
                'OPE- Novato H': 429,
                'OPE- Auxiliar G': 449,
                'OPE- Ayudante F': 469,
                'OPE- Junior E': 489,
                'OPE- Intermedio D': 509,
                'OPE- Avanzado C': 529,
                'OPE- Experto B': 549,
                'OPE- Jefe A': 569
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