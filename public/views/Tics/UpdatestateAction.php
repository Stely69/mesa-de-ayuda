<?php
    require_once __DIR__ . '/../../../Controller/CasoController.php';

    $statu =  new CasoController();
    $statu->Updatestatus($_POST['id'],$_POST['status']);