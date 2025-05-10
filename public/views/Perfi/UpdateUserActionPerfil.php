<?php 
    require_once __DIR__ . '/../../../Controller/UserController.php';

    $actualizacion = new UserController();
    $actualizacion->updateUserDatos(
        openssl_decrypt($_POST['id'], AES, key),
        $_POST['nombres'],
        $_POST['apellido'],
        isset($_POST["correo"]) && !empty($_POST["correo"]) ? $_POST["correo"] : $_POST["hiddenCorreo"],
        $_POST['password_actual'] ?? null,
        $_POST['password_nueva'] ?? null
    );