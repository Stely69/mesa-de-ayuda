<?php 
    require_once __DIR__ . '/../config/Database.php';

    class ProductosAModel{
        private $conn;

        public function __construct() {
            $database = new Database();
            $this->conn = $database->getConnection();
        }

        public function crearProductosA($numero_placa, $serial, $descripcion, $modelo,$clase_id , $ambiente_id) {
            try {
                $this->conn->beginTransaction();
        
                // Verificar si el ambiente_id existe antes de la inserción
                $stmt_check = $this->conn->prepare("SELECT COUNT(*) FROM ambientes WHERE id = ?");
                $stmt_check->execute([$ambiente_id]);
                $ambienteExiste = $stmt_check->fetchColumn();
                
                if ($ambienteExiste == 0) {
                    throw new Exception("Error: El ambiente_id $ambiente_id no existe en la tabla ambientes.");
                }
        
                // Insertar en productos
                $query = 'INSERT INTO productos (numero_placa, serial, descripcion, modelo, clase_id, fecha_creacion, fecha_modificacion) 
                          VALUES (:numero_placa, :serial, :descripcion, :modelo, :clase_id, NOW(), NOW())';
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':numero_placa', $numero_placa);
                $stmt->bindParam(':serial', $serial);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':modelo', $modelo);
                $stmt->bindParam(':clase_id', $clase_id);
                $stmt->execute();
        
                $producto_id = $this->conn->lastInsertId();
        
                // Insertar en ambiente_productos
                $sql_ambiente = "INSERT INTO ambiente_productos (ambiente_id, producto_id, cantidad) VALUES (?, ?, 1)";
                $stmt_ambiente = $this->conn->prepare($sql_ambiente);
                $stmt_ambiente->execute([$ambiente_id, $producto_id]);
        
                $this->conn->commit();
            } catch (Exception $e) {
                $this->conn->rollBack();
                throw $e;
            }
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

        public function getclase(){
            $query = 'SELECT * FROM clases_producto';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function contarProductos() {
            $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM productos");
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        }
        

    }