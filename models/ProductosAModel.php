<?php 
    require_once __DIR__ . '/../config/Database.php';

    class ProductosAModel{
        private $conn;

        public function __construct() {
            $database = new Database();
            $this->conn->getConnection();
        }

        public function  crearProductosA($descripcion, $modelo,$numero_placa,$serial,$ambiente_id){
            $query ='INSERT INTO productos (numero_placa ,serial ,descripcion ,modelo ,ambiente_id)VALUES(:descripcion, :modelo, :numero_placa, :serial, :ambiente_id)';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':descripcion', $descripcion) ;
            $stmt->bindParam(':modelo', $modelo) ;
            $stmt->bindParam(':nuemro_placa', $numero_placa) ;
            $stmt->bindParam('ambiente_id', $ambiente_id) ;
            $stmt->execute();
        }   
         
        public function updateProductosA($id,$descripcion,$modelo,$numero_placa,$serial,$ambiente_id){
            $query = 'UPDATE productos SET descripcion = :descripcion, modelo = :modelo, numero_placa = :numero_placa, serial = :serial, ambiente_id = :ambiente_id WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id) ;
            $stmt->bindParam(':descripcion', $descripcion) ;
            $stmt->bindParam(':modelo', $modelo) ;
            $stmt->bindParam(':numero_placa', $numero_placa) ;
            $stmt->bindParam(':serial', $serial) ;
            $stmt->bindParam(':ambiente_id', $ambiente_id) ;
            $stmt->execute();
        }

        public function deleteProductosA($id){
            $query = 'DELETE FROM productos WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id) ;
            $stmt->execute();
        }

        public function getAmbientes($id){
            $query = 'SELECT * FROM ambientes WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id) ;
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function createAmbiente($nombre){
            $query = 'INSERT INTO ambientes (nombre) VALUES (:nombre)';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nombre', $nombre) ;
            $stmt->execute();
        }

        public function deleteAmbiente($id){
            $query = 'DELETE FROM ambientes WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id) ;
            $stmt->execute();
        }

    }