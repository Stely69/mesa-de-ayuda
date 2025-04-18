<?php 
    require_once __DIR__ . '/../Models/CasoModel.php';

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
                    return $this->conn->registrarCaso($ambiente_id, $usuario_id, $producto_id, $estado, $rol, $descripcion, null);
                    
                }
            }catch (Exception $e) {
                // Manejo de errores
                return ["error" => true, "message" => $e->getMessage() ]; // Error al registrar el caso
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
            if(!$this->conn->CreateCasoGeneral($ambiente_id,$asunto,$descripcion,$estado_id,$instructor_id,$area_asinganda,$asignado_a)){
                header('Location: ../Inst/RegistarCasoGeneral?alert=success&mensaje='. urlencode('Caso registrado correctamente'));
                exit;
            }else{
                header("Location: ../Inst/RegistarCasoGeneral?alert=error&mensaje=".urlencode('Error al registrar el caso'));
                exit;
            }
        }
    }