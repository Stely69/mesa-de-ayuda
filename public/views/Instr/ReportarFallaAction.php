<?php
    require_once __DIR__ . '../../../../Controller/CasoController.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$casoController = new CasoController();
$resultado = $casoController->createCaso($_POST['ambiente_id'],$_POST['usuario_id'] , $_POST['producto_id'],1, $_POST['rol'], $_POST['descripcion'] );

if ($resultado) {  // Si la inserción fue exitosa
    echo json_encode(["success" => true, "message" => "Caso registrado correctamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al registrar el caso"]);
}
exit;

?>
