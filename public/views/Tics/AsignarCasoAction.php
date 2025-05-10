<?php 
    require_once __DIR__ . '/../../../Controller/CasoController.php';

    $statu =  new CasoController();
    $statu->asingarCaso($_POST['id'],$_POST['usuario']);   