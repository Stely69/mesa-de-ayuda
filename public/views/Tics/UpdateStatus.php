<?php
    require_once __DIR__ . '/../../../Controller/UserController.php';

    $statu =  new UserController();
    $statu->Updatestatus($_POST['id'],$_POST['status']);