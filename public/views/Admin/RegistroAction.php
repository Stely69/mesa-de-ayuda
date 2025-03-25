<?php 
    require_once __DIR__ . '/../../../Controller/UserController.php';


    $create = new UserController();
    $create->Createuser($_POST['documento'], $_POST['nombres'],$_POST['apellido'], $_POST['correo'], $_POST['contraseña'], $_POST['rol']);