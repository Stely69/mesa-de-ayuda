<?php 
    require_once __DIR__ . '/../Config/database.php';

    class CasoModel{
        private $conn;

        public function __construct(){
            $database = new Database();
            $this->conn = $database->getConnection();
        }

        public function allAmbiente(){
            $query = 'SELECT * FROM ambientes';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getAmbientes($id){
            $query = 'SELECT * FROM ambientes WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id) ;
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getByAmbiente($ambiente_id) {
            try {
                $sql = "SELECT p.* 
                        FROM productos p
                        JOIN ambiente_productos ap ON p.id = ap.producto_id
                        WHERE ap.ambiente_id = ?";
        
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$ambiente_id]); // Pasamos el parámetro en un array
        
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Error en la consulta: " . $e->getMessage());
            }
        }

        public function registrarCaso($ambiente_id, $usuario_id, $producto_id, $estado, $rol,$descripcion ){
            $query = 'INSERT INTO casos (ambiente_id,usuario_id , producto_id, estado_id , asignado_id,descripcion, fecha_creacion) 
        VALUES (:ambiente_id, :usuario_id, :producto_id, :estado,:rol ,:descripcion,  NOW())';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':ambiente_id', $ambiente_id) ;
            $stmt->bindParam(':usuario_id', $usuario_id) ;
            $stmt->bindParam(':produto_id', $producto_id) ;
            $stmt->bindParam(':estado', $estado) ;
            $stmt->bindParam(':rol', $rol) ;
            $stmt->bindParam(':descripcion', $descripcion) ;

            $stmt->execute();
        }
        
        public function allmarca(){
            $query = 'SELECT * FROM marcas';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getCasos(){
            $query = 'SELECT * FROM casos';

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }



    }

