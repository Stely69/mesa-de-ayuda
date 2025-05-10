<?php
    require_once __DIR__ . '../../../../Controller/CasoController.php';
    session_start();

    header('Content-Type: application/json');
    
    $casoController = new CasoController();
    
    // Verificar que todos los campos requeridos estén presentes
    if (isset($_POST['ambiente_id']) && isset($_POST['asunto']) && isset($_POST['descripcion']) && 
        isset($_POST['usuario_id']) && isset($_POST['area_asignada'])) {
        
        // Obtener los valores del POST
        $ambiente_id = $_POST['ambiente_id'];
        $asunto = $_POST['asunto'];
        $descripcion = $_POST['descripcion'];
        $instructor_id = $_POST['usuario_id'];
        $area_asignada = $_POST['area_asignada'];
        $estado_id = 1; // Estado pendiente

        // Crear el caso general
        $resultado = $casoController->createCasoGeneral(
            $ambiente_id,
            $asunto,
            $descripcion,
            $estado_id,
            $instructor_id,
            $area_asignada
        );

        if ($resultado) {
            echo json_encode([
                "success" => true,
                "message" => "Caso general reportado exitosamente",
                "redirect" => "InicioInst"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Error al reportar el caso general"
            ]);
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Faltan campos requeridos"
        ]);
    }
    exit;
?>
