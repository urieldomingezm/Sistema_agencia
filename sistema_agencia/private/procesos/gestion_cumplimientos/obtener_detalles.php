<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
require_once(CONFIG_PATH . 'bd.php');
require_once(__DIR__ . '/mostrar_usuarios.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $tipo = $_POST['tipo'] ?? null;

    if (!$id || !$tipo) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        exit;
    }

    $requisitoService = new RequisitoService();
    $resultado = $requisitoService->obtenerDetallesUsuario($id);
    
    echo json_encode($resultado);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Método no permitido']);