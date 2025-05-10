<?php 
    require_once __DIR__ . '/../../../Controller/CasoController.php';

    $statu =  new CasoController();
    $statu->updateCasoStatusG($_POST['caso_id'],$_POST['estado_id']);