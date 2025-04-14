<?php
    require_once __DIR__ . '../../../../Controller/CasoController.php';

    $casoController = new CasoController();
    
    $create = $casoController->createCasoGeneral($_POST['asunto'], $_POST['descripcion'], $_FILES['imagen'], $_POST['usuario_id'], $_POST['estado']);