<?php
    require_once __DIR__ . '/../../../Controller/CasoController.php';

    $statu =  new CasoController();
    $statu->updateCasoStatus($_POST['caso_id'],$_POST['estado_id'],$_POST['usuario_id'],$_POST['observaciones']);
