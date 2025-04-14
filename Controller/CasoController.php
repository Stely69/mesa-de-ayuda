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
            if (isset($imagen) && $imagen['error'] === 0) {
                // Validar extensión
                $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
                $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
        
                if (!in_array($extension, $extensionesPermitidas)) {
                    return false; // Extensión no permitida
                }
        
                // Generar un nombre único para la imagen
                $nombreImagen = uniqid('img_') . '.' . $extension;
                $rutaImagen = 'public/uploads/' . $nombreImagen;
        
                // Mover imagen
                if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
                    return $this->conn->registrarCaso($ambiente_id, $usuario_id, $producto_id, $estado, $rol, $descripcion, $nombreImagen, $imagen);
                } else {
                    return false; // Error al mover la imagen
                }
            } else {
                // Si no se subió imagen, puedes mandar NULL o una imagen por defecto
                return $this->conn->registrarCaso($ambiente_id, $usuario_id, $producto_id, $estado, $rol, $descripcion, null,null);
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

        public function createCasoGeneral($asunto, $descripcion, $imagen, $usuario_id, $estado) {
            $estado = 1; // Asignar un valor por defecto o manejarlo según tu lógica
            $ambiente_id = null; // Asignar un valor por defecto o manejarlo según tu lógica    
            $producto_id = null; // Asignar un valor por defecto o manejarlo según tu lógica
            $rol = null; // Asignar un valor por defecto o manejarlo según tu lógica

            if (isset($imagen) && $imagen['error'] === 0) {
                // Validar extensión
                $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
                $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
        
                if (!in_array($extension, $extensionesPermitidas)) {
                    return false; // Extensión no permitida
                }
        
                // Generar un nombre único para la imagen
                $nombreImagen = uniqid('img_') . '.' . $extension;
                $rutaImagen = 'public/uploads/' . $nombreImagen;
        
                // Mover imagen
                if (move_uploaded_file($imagen['tmp_name'], $rutaImagen)) {
                    return $this->conn->registrarCasoGeneral($ambiente_id, $usuario_id, $producto_id, $estado, $rol, $descripcion, $nombreImagen, $imagen);
                } else {
                    return false; // Error al mover la imagen
                }
            } else {
                // Si no se subió imagen, puedes mandar NULL o una imagen por defecto
                return $this->conn->registrarCasoGeneral($ambiente_id, $usuario_id, $producto_id, $estado, $rol, $descripcion, null, null);
            }
        }
    }