<?php 
    require_once(__DIR__ . '/../../../Controller/AuthController.php');

    $auten = new AuthController();
    $auten->recuperar($_POST['correo']);