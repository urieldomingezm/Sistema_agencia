<?php

// Definición de misiones por rango en PHP
$misionesPorRango = [
    'agente' => ['AGE- Iniciado I', 'AGE- Novato H', 'AGE- Auxiliar G', 'AGE- Ayudante F',
        'AGE- Junior E', 'AGE- Intermedio D', 'AGE- Avanzado C', 'AGE- Experto B', 'AGE- Jefe A'
    ],
    'seguridad' => ['SEG- Iniciado I', 'SEG- Novato H', 'SEG- Auxiliar G', 'SEG- Ayudante F',
        'SEG- Junior E', 'SEG- Intermedio D', 'SEG- Avanzado C', 'SEG- Experto B', 'SEG- Jefe A'
    ],
    'tecnico' => ['TEC- Iniciado I', 'TEC- Novato H', 'TEC- Auxiliar G', 'TEC- Ayudante F',
        'TEC- Junior E', 'TEC- Intermedio D', 'TEC- Avanzado C', 'TEC- Experto B', 'TEC- Jefe A'
    ],
    'logistica' => ['LOG- Iniciado I', 'LOG- Novato H', 'LOG- Auxiliar G', 'LOG- Ayudante F',
        'LOG- Junior E', 'LOG- Intermedio D', 'LOG- Avanzado C', 'LOG- Experto B', 'LOG- Jefe A'
    ],
    'supervisor' => ['SUP- Iniciado I', 'SUP- Novato H', 'SUP- Auxiliar G', 'SUP- Ayudante F',
        'SUP- Junior E', 'SUP- Intermedio D', 'SUP- Avanzado C', 'SUP- Experto B', 'SUP- Jefe A'
    ],
    'director' => ['DIR- Iniciado I', 'DIR- Novato H', 'DIR- Auxiliar G', 'DIR- Ayudante F',
        'DIR- Junior E', 'DIR- Intermedio D', 'DIR- Avanzado C', 'DIR- Experto B', 'DIR- Jefe A'
    ],
    'presidente' => ['PRES- Iniciado I', 'PRES- Novato H', 'PRES- Auxiliar G', 'PRES- Ayudante F',
        'PRES- Junior E', 'PRES- Intermedio D', 'PRES- Avanzado C', 'PRES- Experto B', 'PRES- Jefe A'
    ],
    'operativo' => ['OPE- Iniciado I', 'OPE- Novato H', 'OPE- Auxiliar G', 'OPE- Intermedio D', 'OPE- Avanzado C', 'OPE- Experto B', 'OPE- Jefe A'
    ]
];

// Definición de tiempo para ascender según rango en PHP (en segundos para facilitar cálculos)
// Convertiremos los tiempos legibles a segundos
$tiempoAscensoSegundosPorRango = [
    'agente' => 10 * 60, // 10 minutos
    'seguridad' => 4 * 3600, // 4 horas
    'tecnico' => 18 * 3600, // 18 horas
    'logistica' => 26 * 3600, // 26 horas
    'supervisor' => 4 * 24 * 3600, // 4 días
    'director' => 9 * 24 * 3600, // 9 días
    'presidente' => 12 * 24 * 3600, // 12 días
    'operativo' => 24 * 24 * 3600 // 24 días
];

?>