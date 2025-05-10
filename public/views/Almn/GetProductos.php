<?php 
require_once __DIR__ . '/../../../Controller/CasoController.php';
require_once __DIR__ . '../../../../Controller/ProductoController.php';

$obtener = new ProductoController();
$obtener->obtenerCategoria($_POST['ambiente_id']);

// Verificar que se envía el ID del caso
if (!isset($_POST['caso_id']) || empty($_POST['caso_id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de caso no proporcionado']);
    exit;
}

try {
    $caso_id = $_POST['caso_id'];
    $casoController = new CasoController();
    
    // Obtener detalles del caso
    $resultado = $casoController->getDetalleCaso($caso_id);
    
    // Enviar respuesta
    echo json_encode($resultado);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>