<?php
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ambiente_id'])) {
        $ambiente_id = $_POST['ambiente_id'];
    
        $controller = new CasoController();
        $productos = $controller->getProductosPorAmbiente($ambiente_id);
    
        echo json_encode($productos);
    }
    
?>


