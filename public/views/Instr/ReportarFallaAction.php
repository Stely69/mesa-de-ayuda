<?php
require_once __DIR__ . '../../../../Controller/CasoController.php';

header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);

$casoController = new CasoController();
$resultado = $casoController->createCaso(
    $_POST['ambiente_id'],
    $_POST['usuario_id'],
    $_POST['producto_id'],
    1,
    $_POST['rol'],
    $_POST['descripcion'],
    isset($_FILES['imagen']) ? $_FILES['imagen'] : null
);

if (isset($resultado['success']) && $resultado['success']) {
    echo json_encode([
        "success" => true,
        "message" => $resultado["message"],
        "redirect" => "InicioInst"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => isset($resultado["message"]) ? $resultado["message"] : "Error al registrar el caso"
    ]);
}
exit;
?>
