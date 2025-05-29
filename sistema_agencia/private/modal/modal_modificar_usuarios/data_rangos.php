<?php
// First define the array
$misionesPorRango = [
    'agente' => [
        'SHN- Iniciado I',
        'SHN- Novato H',
        'SHN- Auxiliar G',
        'SHN- Ayudante F',
        'SHN- Junior E',
        'SHN- Intermedio D',
        'SHN- Avanzado C',
        'SHN- Experto B',
        'SHN- Jefe A'
    ],
    'seguridad' => [
        'SHN- Iniciado I',
        'SHN- Novato H',
        'SHN- Auxiliar G',
        'SHN- Ayudante F',
        'SHN- Junior E',
        'SHN- Intermedio D',
        'SHN- Avanzado C',
        'SHN- Experto B',
        'SHN- Jefe A'
    ],
    'tecnico' => [
        'SHN- Iniciado I',
        'SHN- Novato H',
        'SHN- Auxiliar G',
        'SHN- Ayudante F',
        'SHN- Junior E',
        'SHN- Intermedio D',
        'SHN- Avanzado C',
        'SHN- Experto B',
        'SHN- Jefe A'
    ],
    'logistica' => [
        'SHN- Iniciado I',
        'SHN- Novato H',
        'SHN- Auxiliar G',
        'SHN- Ayudante F',
        'SHN- Junior E',
        'SHN- Intermedio D',
        'SHN- Avanzado C',
        'SHN- Experto B',
        'SHN- Jefe A'
    ],
    'supervisor' => [
        'SHN- Iniciado I',
        'SHN- Novato H',
        'SHN- Auxiliar G',
        'SHN- Ayudante F',
        'SHN- Junior E',
        'SHN- Intermedio D',
        'SHN- Avanzado C',
        'SHN- Experto B',
        'SHN- Jefe A'
    ],
    'director' => [
        'SHN- Iniciado I',
        'SHN- Novato H',
        'SHN- Auxiliar G',
        'SHN- Ayudante F',
        'SHN- Junior E',
        'SHN- Intermedio D',
        'SHN- Avanzado C',
        'SHN- Experto B',
        'SHN- Jefe A'
    ],
    'presidente' => [
        'SHN- Iniciado I',
        'SHN- Novato H',
        'SHN- Auxiliar G',
        'SHN- Ayudante F',
        'SHN- Junior E',
        'SHN- Intermedio D',
        'SHN- Avanzado C',
        'SHN- Experto B',
        'SHN- Jefe A'
    ],
    'operativo' => [
        'SHN- Iniciado I',
        'SHN- Novato H',
        'SHN- Auxiliar G',
        'SHN- Intermedio D',
        'SHN- Avanzado C',
        'SHN- Experto B',
        'SHN- Jefe A'
    ]
];

// Then output the JSON
header('Content-Type: application/json');
echo json_encode($misionesPorRango);
?>