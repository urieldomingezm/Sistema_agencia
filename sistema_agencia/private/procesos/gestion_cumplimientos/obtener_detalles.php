<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');
require_once(__DIR__ . '/mostrar_usuarios.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $tipo = $_POST['tipo'] ?? null;

    // Agregar logs para debug
    error_log("ID recibido: " . $id);
    error_log("Tipo recibido: " . $tipo);

    if (!$id || !$tipo) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        exit;
    }

    $requisitoService = new RequisitoService();
    $resultado = $requisitoService->obtenerDetallesUsuario($id);
    
    // Log del resultado
    error_log("Resultado obtenido: " . print_r($resultado, true));
    
    echo json_encode($resultado);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Método no permitido']);