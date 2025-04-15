<?php
    require_once __DIR__ . '../../../../Controller/CasoController.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$casoController = new CasoController();
$resultado = $casoController->createCaso($_POST['ambiente_id'],$_POST['usuario_id'] , $_POST['producto_id'],1, $_POST['rol'], $_POST['descripcion'], isset($_FILES['imagen']) ? $_FILES['imagen'] : null);


if ($resultado) {  
    echo json_encode(["success" => true, "message" => $resultado["message"]]);
} else {
    echo json_encode(["success" => false, "message" => $resultado["message"]]);
}
exit;

?>
