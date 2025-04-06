<?php 
    require_once(__DIR__ . '/../../../Controller/AuthController.php');

    $auten = new AuthController();
    $auten-> updatepassaword($_POST['new_password'], $_POST['token']);