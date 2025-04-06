<?php 
    require_once __DIR__ . '../../../../Controller/ProductoController.php';

    $guardar = new ProductoController();
    $guardar->guardarProducto($_POST['numero_placa'], $_POST['serial'], $_POST['descripcion'], $_POST['modelo'],$_POST['clase_id'], $_POST['ambiente']);