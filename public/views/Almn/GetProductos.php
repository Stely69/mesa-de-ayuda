<?php 
    require_once __DIR__ . '../../../../Controller/ProductoController.php';

    $obtener = new ProductoController();
    $obtener->obtenerCategoria($_POST['ambiente_id']);
