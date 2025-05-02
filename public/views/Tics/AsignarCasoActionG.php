<?php 
    require_once __DIR__ . '/../../../Controller/CasoController.php';

    $statu =  new CasoController();
    $statu->upadateasinstate($_POST['caso_id'],$_POST['estado_id'],$_POST['usuario_id'],$_POST['observaciones']);