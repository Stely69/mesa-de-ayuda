<?php 
    require_once __DIR__ . '/../../../Controller/UserController.php';

    $create = new UserController();
    $create->updateUser(openssl_decrypt($_POST['id'],AES,key), $_POST['nombres'], $_POST['apellido'], isset($_POST["correo"]) && !empty($_POST["correo"]) ? $_POST["correo"] : $_POST["hiddenCorreo"] ,$_POST['rol_id']);