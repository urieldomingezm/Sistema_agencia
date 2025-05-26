<?php

// Definición de misiones por rango en PHP
$misionesPorRango = [
    'agente' => [
        'AGE- Iniciado I',
        'AGE- Novato H',
        'AGE- Auxiliar G',
        'AGE- Ayudante F',
        'AGE- Junior E',
        'AGE- Intermedio D',
        'AGE- Avanzado C',
        'AGE- Experto B',
        'AGE- Jefe A'
    ],
    'seguridad' => [
        'SEG- Iniciado I',
        'SEG- Novato H',
        'SEG- Auxiliar G',
        'SEG- Ayudante F',
        'SEG- Junior E',
        'SEG- Intermedio D',
        'SEG- Avanzado C',
        'SEG- Experto B',
        'SEG- Jefe A'
    ],
    'tecnico' => [
        'TEC- Iniciado I',
        'TEC- Novato H',
        'TEC- Auxiliar G',
        'TEC- Ayudante F',
        'TEC- Junior E',
        'TEC- Intermedio D',
        'TEC- Avanzado C',
        'TEC- Experto B',
        'TEC- Jefe A'
    ],
    'logistica' => [
        'LOG- Iniciado I',
        'LOG- Novato H',
        'LOG- Auxiliar G',
        'LOG- Ayudante F',
        'LOG- Junior E',
        'LOG- Intermedio D',
        'LOG- Avanzado C',
        'LOG- Experto B',
        'LOG- Jefe A'
    ],
    'supervisor' => [
        'SUP- Iniciado I',
        'SUP- Novato H',
        'SUP- Auxiliar G',
        'SUP- Ayudante F',
        'SUP- Junior E',
        'SUP- Intermedio D',
        'SUP- Avanzado C',
        'SUP- Experto B',
        'SUP- Jefe A'
    ],
    'director' => [
        'DIR- Iniciado I',
        'DIR- Novato H',
        'DIR- Auxiliar G',
        'DIR- Ayudante F',
        'DIR- Junior E',
        'DIR- Intermedio D',
        'DIR- Avanzado C',
        'DIR- Experto B',
        'DIR- Jefe A'
    ],
    'presidente' => [
        'PRES- Iniciado I',
        'PRES- Novato H',
        'PRES- Auxiliar G',
        'PRES- Ayudante F',
        'PRES- Junior E',
        'PRES- Intermedio D',
        'PRES- Avanzado C',
        'PRES- Experto B',
        'PRES- Jefe A'
    ],
    'operativo' => [
        'OPE- Iniciado I',
        'OPE- Novato H',
        'OPE- Auxiliar G',
        'OPE- Intermedio D',
        'OPE- Avanzado C',
        'OPE- Experto B',
        'OPE- Jefe A'
    ]
];

// Definición de tiempo para ascender según rango en PHP (en segundos para facilitar cálculos)
// Convertiremos los tiempos legibles a segundos
$tiempoAscensoSegundosPorRango = [
    'agente' => '00:10:00',       // 10 minutos
    'seguridad' => '04:00:00',    // 4 horas
    'tecnico' => '18:00:00',      // 18 horas
    'logistica' => '26:00:00',    // 1 día + 2 horas
    'supervisor' => '96:00:00',   // 4 días
    'director' => '216:00:00',    // 9 días
    'presidente' => '288:00:00',  // 12 días
    'operativo' => '576:00:00',   // 24 días
];
