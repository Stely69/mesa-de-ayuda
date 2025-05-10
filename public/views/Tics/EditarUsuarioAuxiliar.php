<?php 
require_once __DIR__ . '/../../../Controller/UserController.php';

$controller = new UserController();
$id = openssl_decrypt($_POST['id'], AES, key); // Asegúrate que estas constantes estén definidas
$controller->ActualizarUsuarioAuxiliar($id, $_POST['nombres'], $_POST['apellido'], $_POST['correo'], $_POST['rol']);
