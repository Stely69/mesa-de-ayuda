<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../../Controller/CasoController.php';
header('Content-Type: application/json');

$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$tipo || !$id) {
    echo json_encode(['error' => 'Parámetros inválidos.']);
    exit;
}

$casos = new CasoController();

if ($tipo === 'normal') {
    $caso = $casos->getCasoPorIdConHistorial($id); // Debe devolver array con historial
    if (!$caso) {
        echo json_encode(['error' => 'No se encontró el caso normal con ese ID.']);
        exit;
    }
    echo json_encode($caso);
    exit;
} elseif ($tipo === 'general') {
    $caso = $casos->getCasoGeneralPorIdConHistorial($id); // Debe devolver array con historial
    if (!$caso) {
        echo json_encode(['error' => 'No se encontró el caso general con ese ID.']);
        exit;
    }
    echo json_encode($caso);
    exit;
} else {
    echo json_encode(['error' => 'Tipo de caso inválido.']);
    exit;
} 