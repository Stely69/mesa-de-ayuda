<?php
    require_once(__DIR__ . '/../../../Controller/AuthController.php');

    $auten = new AuthController();
    $auten->login($_POST['cedula'], $_POST['password']);

