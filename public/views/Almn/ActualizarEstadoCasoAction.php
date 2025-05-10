<?php
session_start();
require_once __DIR__ . '/../../../Controller/CasoController.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['caso_id'], $_POST['estado'], $_POST['comentario'])) {
    $casoController = new CasoController();
    $usuario_id = $_SESSION['id'] ?? 1; // Ajusta según tu sistema de sesiones
    $resultado = $casoController->updateCasoAlmacenStatus(
        $_POST['caso_id'],
        $_POST['estado'],
        $usuario_id,
        $_POST['comentario']
    );
    echo json_encode($resultado);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Solicitud inválida.'
    ]);
} 