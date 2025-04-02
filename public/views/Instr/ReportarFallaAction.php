<?php
    require_once __DIR__ . '../../../../Controller/CasoController.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$casoController = new CasoController();
$resultado = $casoController->createCaso($_POST['usuario_id'], $_POST['ambiente_id'], $_POST['producto_id'], $_POST['rol'], $_POST['descripcion'], 1);

if ($resultado === true) {
    echo json_encode(['success' => 'Falla reportada correctamente']);
} else {
    echo json_encode(['error' => 'Error al insertar en la base de datos', 'details' => $resultado]);
}
exit;

?>
