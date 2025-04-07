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
             
        public function createCaso($ambiente_id,$usuario_id,$producto_id,$estado,$rol,$descripcion){
            return $this->conn->registrarCaso($ambiente_id,$ambiente_id,$producto_id,$estado,$rol,$descripcion );
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
    }