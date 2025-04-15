<?php
    require_once __DIR__ . '../../../../Controller/CasoController.php';

    $casoController = new CasoController();
    
    $casoController->createCasoGeneral($_POST['ambiente_id'], $_POST['asunto'], $_POST['descripcion'], $_POST['estado'], $_POST['usuario_id'], $_POST['area_asignada']);
