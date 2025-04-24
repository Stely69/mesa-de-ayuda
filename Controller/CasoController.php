<?php 
    require_once __DIR__ . '/../Models/CasoModel.php';
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

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
            try{
                if (isset($imagen) && $imagen['error'] === 0) {
                    // Validar extensión
                    $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
                    $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
            
                    if (!in_array($extension, $extensionesPermitidas)) {
                        return ["error" => true, "message" => "Extensión no permitida"]; // Extensión no permitida
                    }
            
                    // Generar un nombre único para la imagen
                    $nombreImagen = uniqid('img_') . '.' . $extension;
                    $rutaImagen = 'public/uploads/' . $nombreImagen;
            
                    // Mover imagen
                    if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
                        $this->conn->registrarCaso($ambiente_id, $usuario_id, $producto_id, $estado, $rol, $descripcion, $nombreImagen);
                        return  ["success" => true, "message" => "Caso registrado correctamente con imagen"];
                    } else {
                        return ["error" => true, "message" => "Error al mover la imagen" ]; // Error al mover la imagen
                    }
                } else {
                    // Si no se subió imagen, puedes mandar NULL o una imagen por defecto
                   $resultado =  $this->conn->registrarCaso($ambiente_id, $usuario_id, $producto_id, $estado, $rol, $descripcion, null);

                    if($resultado){

                        $usuario = $this->conn->getUser($usuario_id);
                        $this->enviarCorreo( $usuario['nombre'], $descripcion);
                    }else{
                        return ["error" => true, "message" => "Error al registrar el caso"]; // Error al registrar el caso 
                    }
                    
                }
            }catch (Exception $e) {
                // Manejo de errores
                return ["error" => true, "message" => $e->getMessage() ]; // Error al registrar el caso
            }
        }

        public function enviarCorreo($nombreUsuario,$descripcion) {
            // Obtener los correos de los TICS desde la base de datos
            $correosTics = $this->conn->getCorreosTics(); // Método que obtiene los correos de los TICS
            foreach ($correosTics as $correo) {
                $mail = new PHPMailer(true);
                try {
                    // Configuración del servidor SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = '';
                    $mail->Password = '';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
            
                    // Remitente y destinatario
                    $mail->setFrom('', '');
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
                    error_log("No se pudo enviar el correo: {$mail->ErrorInfo}");
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

        public function createCasoGeneral($ambiente_id,$asunto,$descripcion,$estado_id,$instructor_id,$area_asinganda) {
            $asignado_a = null;
            $creacioncasogeneral = $this->conn->CreateCasoGeneral($ambiente_id,$asunto,$descripcion,$estado_id,$instructor_id,$area_asinganda,$asignado_a);
            if(!$creacioncasogeneral){
                    header('Location: ../Inst/RegistarCasoGeneral?alert=success&mensaje='. urlencode('Caso registrado correctamente'));
                    exit;
                }
                if(!$creacioncasogeneral){
                    $usuario = $this->conn->getUser($instructor_id);
                    $this->enviarCorreogeneral( $usuario['nombre'],$asunto , $descripcion);
                } else {
                    header("Location: ../Inst/RegistarCasoGeneral?alert=error&mensaje=".urlencode('Error al registrar el caso'));
                    exit;
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

        public function updateCasoStatus($id, $estado_id) {
           if($this->conn->updateCasoStatus($id, $estado_id)){
                header('Location: ../Inst/ver_caso?id='.$id.'&alert=success&mensaje='.urlencode('Estado actualizado correctamente'));
                exit;
            }else{
                header('Location: ../Inst/ver_caso?id='.$id.'&alert=error&mensaje='.urlencode('Error al actualizar el estado'));
                exit;
           }
        }

        public function asingarCaso($id, $asignado_a) {
            if($this->conn->asignacionCaso($id, $asignado_a)){
                header('Location: ../Inst/ver_caso?id='.$id.'&alert=success&mensaje='.urlencode('Caso asignado correctamente'));
                exit;
            }else{
                header('Location: ../Inst/ver_caso?id='.$id.'&alert=error&mensaje='.urlencode('Error al asignar el caso'));
                exit;
            }
        }

        public function asingarcasoGeneral($id, $asignado_a) {
            if($this->conn->asingacionCasoGeneral($id, $asignado_a)){
                header('Location: ../Inst/ver_casoG?id='.$id.'&alert=success&mensaje='.urlencode('Caso asignado correctamente'));
                exit;
            }else{
                header('Location: ../Inst/ver_casoG?id='.$id.'&alert=error&mensaje='.urlencode('Error al asignar el caso'));
                exit;
            }
        }
    }