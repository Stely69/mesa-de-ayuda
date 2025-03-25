<?php 
    require_once __DIR__ . '/../Models/CasoModel.php';

    class CasoController{

        private $conn;

        public function __construct() {
            $this->conn = new CasoModel();
        }

        public function allambientes(){
            return $this->conn->allAmbiente();
        }

        public function getambientesP($ambiente_id){
            $this->conn->getByAmbiente($ambiente_id);
            //header('Location: instructores?ambiente_id='.$ambiente_id);
            //exit();

        }


        public function registrar() {

        }

        public function allmarcas(){
            return $this->conn->allmarca();
        }


        public function getCasos(){
            return $this->conn->getCasos();
        }
    }