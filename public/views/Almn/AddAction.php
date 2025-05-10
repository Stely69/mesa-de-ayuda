<?php
require_once __DIR__ . '/../../../Controller/ProductoController.php';

if (
    isset($_POST['numero_placa'], $_POST['serial'], $_POST['descripcion'], $_POST['modelo'], $_POST['clase_id'], $_POST['ambiente'])
) {
    try {
        $controller = new ProductoController();
        $controller->guardarProducto(
            $_POST['numero_placa'],
            $_POST['serial'],
            $_POST['descripcion'],
            $_POST['modelo'],
            $_POST['clase_id'],
            $_POST['ambiente']
        );
        header('Location: inventario.php?status=success&message=Producto+agregado+correctamente');
        exit();
    } catch (Exception $e) {
        header('Location: inventario.php?status=error&message=' . urlencode('Error al agregar: ' . $e->getMessage()));
        exit();
    }
} else {
    header('Location: inventario.php?status=error&message=Faltan+datos+obligatorios');
    exit();
}