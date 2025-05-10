<?php
// namespace Controller; // Revertido, la clase vuelve a estar sin namespace

require_once __DIR__ . '/../Models/CasoModel.php';
require_once '../PHPMailer/src/Exception.php';
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

class CasoController{

    private $conn;

    public function __construct() {
        $this->conn = new CasoModel();
    }
    public function getAmbientes()
    {
        return $this->conn->allAmbiente(); // Método que obtiene todos los ambientes
    }

    public function getProductosPorAmbiente($ambiente_id) {
        return $this->conn->getByAmbiente($ambiente_id);
    }
         
    public function createCaso($ambiente_id, $usuario_id, $producto_id, $estado, $rol, $descripcion, $imagen) {
        try {
            if (isset($imagen) && $imagen['error'] === 0) {
                // Validar extensión
                $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
        
                if (!in_array($extension, $extensionesPermitidas)) {
                    return ["success" => false, "message" => "Extensión no permitida"];
                }

                // Generar un nombre único para la imagen
                $nombreImagen = uniqid('img_') . '.' . $extension;
                $directorio = __DIR__ . '/../public/uploads/';
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }
                $rutaImagen = $directorio . $nombreImagen;

                // Mover imagen
                if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
                    $resultado = $this->conn->registrarCaso($ambiente_id, $usuario_id, $producto_id, $estado, $rol, $descripcion, $nombreImagen);
                    
                    if ($resultado) {
                        $usuario = $this->conn->getUser($usuario_id);
                        // Enviar correo a todos los usuarios del rol asignado
                        $this->enviarCorreoPorRol($rol, 'Nuevo caso reportado', $descripcion, $usuario['nombres']);
                        return ["success" => true, "message" => "Caso registrado correctamente con imagen"];
                    } else {
                        return ["success" => false, "message" => "Error al registrar el caso"];
                    }
                } else {
                    return ["success" => false, "message" => "Error al mover la imagen"];
                }
            }
            
            // Si no se subió imagen o hubo un error, registrar el caso sin imagen
            $resultado = $this->conn->registrarCaso($ambiente_id, $usuario_id, $producto_id, $estado, $rol, $descripcion, null);
            if ($resultado) {
                $usuario = $this->conn->getUser($usuario_id);
                // Enviar correo a todos los usuarios del rol asignado
                $this->enviarCorreoPorRol($rol, 'Nuevo caso reportado', $descripcion, $usuario['nombres']);
                return ["success" => true, "message" => "Caso registrado correctamente sin imagen"];
            } else {
                return ["success" => false, "message" => "Error al registrar el caso"];
            }
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function enviarCorreo($nombreUsuario,$descripcion) {
        // Obtener los correos de los TICS desde la base de datos
        $correosTics = $this->conn->getCorreosTics(); // Método que obtiene los correos de los TICS
        foreach ($correosTics as $correo) {
            // Configuración del correo
            $mail = new PHPMailer(true);
            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmass.co.';
                $mail->SMTPAuth = true;
                $mail->Username = 'soportetics876@gmail.com';
                $mail->Password = 'e58b0fcc-8d33-4167-8307-713018e0f649';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
        
                // Remitente y destinatario
                $mail->setFrom('soportetics876@gmail.com', 'Soporte TICS');
                $mail->addAddress($correo);
        
                // Contenido
                $mail->isHTML(true);
                $mail->Subject = 'Nuevo caso registrado';
                $mail->Body    = "
                    <h2>Nuevo caso reportado</h2>
                    <p>Se ha reportado un nuevo caso desde la plataforma de Mesa de Ayuda.</p>
                    <p><strong>Descripción:</strong> {$descripcion}</p>
                    <p><strong>Registrado por:</strong> {$nombreUsuario}</p>
                    <p>Por favor, ingrese a la plataforma para más detalles.</p>
                ";
                $mail->send();
            } catch (Exception $e) {
                return error_log("No se pudo enviar el correo: {$mail->ErrorInfo}");
            }
        }
    }

    // Nuevo método para enviar correos al área de almacén
    public function enviarCorreoAlmacen($nombreUsuario, $descripcion) {
        // Obtener los correos del personal de almacén desde la base de datos
        $correosAlmacen = $this->conn->getCorreosAlmacen(); // Este método debe ser implementado en el modelo
        
        foreach ($correosAlmacen as $correo) {
            // Configuración del correo
            $mail = new PHPMailer(true);
            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmass.co.';
                $mail->SMTPAuth = true;
                $mail->Username = 'soportetics876@gmail.com';
                $mail->Password = 'e58b0fcc-8d33-4167-8307-713018e0f649';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
        
                // Remitente y destinatario
                $mail->setFrom('soportetics876@gmail.com', 'Mesa de Ayuda - Almacén');
                $mail->addAddress($correo);
        
                // Contenido
                $mail->isHTML(true);
                $mail->Subject = 'Nuevo caso de almacén registrado';
                $mail->Body    = "
                    <h2>Nuevo caso de almacén reportado</h2>
                    <p>Se ha reportado un nuevo caso para el área de almacén desde la plataforma de Mesa de Ayuda.</p>
                    <p><strong>Descripción:</strong> {$descripcion}</p>
                    <p><strong>Registrado por:</strong> {$nombreUsuario}</p>
                    <p>Por favor, ingrese a la plataforma para más detalles.</p>
                ";
                $mail->send();
            } catch (Exception $e) {
                return error_log("No se pudo enviar el correo a almacén: {$mail->ErrorInfo}");
            }
        }
    }

    public function registrar() {

    }

    public function allmarcas(){
        return $this->conn->allmarca();
    }


    public function getCasos(){
        return $this->conn->getCasos();
    }
    public function getCasosGeneral(){
        return $this->conn->getCasosGeneral();
    }

    public function getcasogeneral($id){
        return $this->conn->getcasogeneral($id);
    }

    public function allroles(){
        return $this->conn->allroles();
    }   

    public function mostarcasos(){
        return $this->conn->contarCasos();
    }

    public function getCaso($id){
        return $this->conn->getCaso($id);
    }

    // Método para obtener casos por rol específico (sistemas o almacén)
    public function getCasosPorRol($rol_id) {
        return $this->conn->getCasosPorRol($rol_id);
    }

    public function createCasoGeneral($ambiente_id,$asunto,$descripcion,$estado_id,$instructor_id,$area_asignada) {
        $asignado_a = null;
        $creacioncasogeneral = $this->conn->CreateCasoGeneral($ambiente_id,$asunto,$descripcion,$estado_id,$instructor_id,$area_asignada,$asignado_a);
        if($creacioncasogeneral) {
            $usuario = $this->conn->getUser($instructor_id);
            // Enviar correo a todos los usuarios del área seleccionada (rol)
            try {
                $this->enviarCorreoPorRol($area_asignada, $asunto, $descripcion, $usuario['nombres']);
            } catch (\Exception $e) {
                error_log('Error enviando correo: ' . $e->getMessage());
            }
            return true;
        } else {
            return false;
        }
    }

    public function enviarCorreogeneral($nombreUsuario,$asunto,$descripcion) {
        // Obtener los correos de los TICS desde la base de datos
        $correosTics = $this->conn->getCorreosTics(); // Método que obtiene los correos de los TICS
        foreach ($correosTics as $correo) {
            $mail = new PHPMailer(true);
            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmass.co.';
                $mail->SMTPAuth = true;
                $mail->Username = 'soportetics876@gmail.coms';
                $mail->Password = 'e58b0fcc-8d33-4167-8307-713018e0f649';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
        
                // Remitente y destinatario
                $mail->setFrom('soportetics876@gmail.coms', 'Mesa de Ayuda');
                $mail->addAddress('williamsteven237gmail.com',$correo);
        
                // Contenido
                $mail->isHTML(true);
                $mail->Subject = 'Nuevo caso registrado';
                $mail->Body    = "
                    <h2>Nuevo caso reportado</h2>
                    <p>Se ha reportado un nuevo caso desde la plataforma de Mesa de Ayuda.</p>
                    <p><strong>Asunto:</strong> {$asunto}</p>
                    <p><strong>Descripción:</strong> {$descripcion}</p>
                    <p><strong>Registrado por:</strong> {$nombreUsuario}</p>
                    <p>Por favor, ingrese a la plataforma para más detalles.</p>
                ";
        
                $mail->send();

                echo "Correo enviado correctamente a {$correo}";
                return;
            } catch (Exception $e) {
                error_log("No se pudo enviar el correo: {$mail->ErrorInfo}");
            }
        }
    }

    public function updateCasoStatus($id, $estado_id,$usuario_id,$observaciones) {
        // Verificar que el usuario tenga rol TICS o Auxiliar TICS
        $usuario = $this->conn->getUser($usuario_id);
        if (!$usuario || ($usuario['rol_id'] != 3 && $usuario['rol_id'] != 5)) {
            header('Location: ../tics/ver_caso?id='.$id.'&alert=error&mensaje='.urlencode('Solo se pueden asignar casos a usuarios con rol TICS o Auxiliar TICS'));
            exit;
        }

        // OBTENER EL ESTADO ANTERIOR ANTES DE ACTUALIZAR
        $estado_anterior_id = $this->conn->getcasoestado($id);
        if($estado_anterior_id == null){
            $estado_anterior_id = 0;
        }else{
            $estado_anterior_id = $estado_anterior_id['estado_id'];
        }

        // ACTUALIZAR EL ESTADO DEL CASO
        if($this->conn->updateCasoStatus($id, $estado_id, $usuario_id)){
            // Registrar el historial del caso   
            $this->conn->registrarHistorial($id, $estado_anterior_id,$estado_id, $observaciones, $usuario_id,'caso');
            header('Location: ../tics/Tics?alert=success&mensaje='.urlencode('Estado actualizado correctamente'));
            exit;
        }else{
            header('Location: ../tics/ver_caso?id='.$id.'&alert=error&mensaje='.urlencode('Error al actualizar el estado del caso'));
            exit;
        }
    }

    // Nuevo método específico para actualizar el estado de un caso de almacén
    public function updateCasoAlmacenStatus($caso_id, $estado_id, $usuario_id, $comentario) {
        if($this->conn->updateEstadoSolo($caso_id, $estado_id)) {
            $estado_anterior_id = $this->conn->getcasoestado($caso_id);
            if($estado_anterior_id == null) {
                $estado_anterior_id = 0;
            } else {
                $estado_anterior_id = $estado_anterior_id['estado_id'];
            }
            // Registrar el historial del caso
            $this->conn->registrarHistorial($caso_id, $estado_anterior_id, $estado_id, $comentario, $usuario_id, 'almacen');
            return ["success" => true, "message" => "Estado actualizado correctamente"];
        } else {
            return ["success" => false, "message" => "Error al actualizar el estado del caso"];
        }
    }

    // Método para cerrar un caso (poner en estado 4)
    public function cerrarCaso($caso_id, $usuario_id) {
        // El estado 4 representa "Cerrado" en el sistema
        $estado_id = 4;
        $comentario = "Caso cerrado por el usuario";
        
        if($this->conn->updateCasoStatus($caso_id, $estado_id, $usuario_id)) {
            $estado_anterior_id = $this->conn->getcasoestado($caso_id);
            if($estado_anterior_id == null) {
                $estado_anterior_id = 0;
            } else {
                $estado_anterior_id = $estado_anterior_id['estado_id'];
            }
            
            // Registrar el historial del caso
            $this->conn->registrarHistorial($caso_id, $estado_anterior_id, $estado_id, $comentario, $usuario_id, 'almacen');
            
            return ["success" => true, "message" => "Caso cerrado correctamente"];
        } else {
            return ["success" => false, "message" => "Error al cerrar el caso"];
        }
    }

    // Método para obtener los detalles completos de un caso
    public function getDetalleCaso($caso_id) {
        // Obtener información básica del caso
        $caso = $this->conn->getCaso($caso_id);
        if (!$caso) {
            return ["success" => false, "message" => "Caso no encontrado"];
        }
        // Obtener historial del caso usando el método correcto
        $historial = $this->conn->historialCaso($caso_id);
        // Adaptar los campos para el frontend
        foreach ($historial as &$item) {
            $item['fecha'] = $item['fecha_actualizacion'] ?? '';
            $item['estado'] = $item['estado_nuevo'] ?? '';
            $item['comentario'] = $item['observaciones'] ?? '';
            $item['usuario_nombre'] = $item['usuario_id'] ?? '';
        }
        unset($item);
        // Añadir el historial al caso
        $caso['historial'] = $historial;
        return ["success" => true, "caso" => $caso];
    }

    public function upadateasinstate(){
        $caso = new CasoModel();
        $estado_anterior_id = $caso->getcasoestadog($_POST['caso_id']);
        
        if (!$estado_anterior_id || !isset($estado_anterior_id['estado_id'])) {
            $estado_anterior_id = ['estado_id' => 1];
        }
        
        $resultado = $caso->updateCasoGeneralStatus($_POST['caso_id'], $_POST['estado_id'], $_POST['usuario_id']);
        
        if ($resultado['success']) {
            $caso->registrarHistorialGeneral($_POST['caso_id'], $estado_anterior_id['estado_id'], $_POST['estado_id'], $_POST['observaciones'], $_POST['usuario_id']);
            header("Location: ../tics/Tics?alert=success&mensaje=" . urlencode('Estado actualizado correctamente'));
            exit;
        } else {
            header("Location: ver_casoG?id=" . $_POST['caso_id'] . "&error=" . urlencode($resultado['message']));
            exit;
        }
    }

    public function getUserCaso($id){
        try {
            return $this->conn->obtenerCasos($id);
        } catch (PDOException $e) {
            return  $e->getMessage(); // Manejo de errores
        }
    }

    public function getallcasos(){
        return $this->conn->getAllCasos();
    }

    public function getHistorialAlmacen() {
        return $this->conn->getHistorialAlmacen();
    }

    public function eliminarCasoPorId($id) {
        try {
            $success = $this->conn->eliminarCasoYHistorial($id);
            if ($success) {
                return ['success' => true, 'message' => 'Caso eliminado correctamente'];
            } else {
                return ['success' => false, 'message' => 'No se pudo eliminar el caso'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    public function contarCasosPorInstructor($instructor_id) {
        return $this->conn->contarCasosPorInstructor($instructor_id);
    }

    public function contarCasosPendientesPorInstructor($instructor_id) {
        return $this->conn->contarCasosPendientesPorInstructor($instructor_id);
    }

    public function contarCasosResueltosPorInstructor($instructor_id) {
        return $this->conn->contarCasosResueltosPorInstructor($instructor_id);
    }

    public function obtenerUltimosCasosInstructor($instructor_id) {
        return $this->conn->obtenerUltimosCasosInstructor($instructor_id);
    }

    public function obtenerCasosInstructor($instructor_id, $pagina = 1, $por_pagina = 8, $filtros = []) {
        return $this->conn->obtenerCasosInstructor($instructor_id, $pagina, $por_pagina, $filtros);
    }

    public function obtenerCasosGeneralesInstructor($instructor_id, $pagina_actual, $por_pagina, $filtros = []) {
        return $this->conn->obtenerCasosGeneralesInstructor($instructor_id, $pagina_actual, $por_pagina, $filtros);
    }

    public function enviarCorreoPorRol($rol_id, $asunto, $descripcion, $nombreUsuario) {
        $correos = $this->conn->getCorreosPorRol($rol_id);
        foreach ($correos as $correo) {
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmass.co.';
                $mail->SMTPAuth = true;
                $mail->Username = 'soportetics876@gmail.com';
                $mail->Password = 'e58b0fcc-8d33-4167-8307-713018e0f649';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setFrom('soportetics876@gmail.com', 'Mesa de Ayuda');
                $mail->addAddress($correo);
                $mail->isHTML(true);
                $mail->Subject = 'Nuevo caso asignado a su área';
                $mail->Body = "<h2>Nuevo caso reportado</h2><p>Se ha reportado un nuevo caso desde la plataforma de Mesa de Ayuda.</p><p><strong>Asunto:</strong> {$asunto}</p><p><strong>Descripción:</strong> {$descripcion}</p><p><strong>Registrado por:</strong> {$nombreUsuario}</p><p>Por favor, ingrese a la plataforma para más detalles.</p>";
                $mail->send();
            } catch (Exception $e) {
                error_log("No se pudo enviar el correo a rol {$rol_id}: {$mail->ErrorInfo}");
            }
        }
    }

    // Obtener caso normal por ID con historial para consulta rápida
    public function getCasoPorIdConHistorial($id) {
        return $this->conn->getCasoPorIdConHistorial($id);
    }

    // Obtener caso general por ID con historial para consulta rápida
    public function getCasoGeneralPorIdConHistorial($id) {
        return $this->conn->getCasoGeneralPorIdConHistorial($id);
    }

    public function getCasoPorId($id) {
        // Usar el modelo para obtener los datos del caso por ID
        return $this->conn->getCaso($id);
    }
}