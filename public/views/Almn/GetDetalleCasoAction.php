<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once __DIR__ . '../../../../Controller/CasoController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['caso_id'])) {
    $caso_id = intval($_POST['caso_id']);
    $casoController = new CasoController();
    $caso = $casoController->getDetalleCaso($caso_id);
    if ($caso) {
        echo json_encode([
            'success' => true,
            'caso' => $caso
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró el caso.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Solicitud inválida.'
    ]);
} 