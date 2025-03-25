<?php 
    require_once __DIR__ . '/../../../Controller/UserController.php';

    $delete = new UserController();
    $delete->deleteUser(openssl_decrypt($_GET['id'], AES, key));
