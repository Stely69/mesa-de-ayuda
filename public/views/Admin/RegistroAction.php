<?php 
    require_once __DIR__ . '../../../Controller/UserController.php';

    $create = new UserController();
    $create->Createuser($_POST['cedula'], $_POST['nombre'], $_POST['correo'], $_POST['contraseña'], $_POST['rol']);