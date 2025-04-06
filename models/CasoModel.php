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

        public function registrarCaso($ambiente_id, $usuario_id, $producto_id, $estado_id, $asignado_a, $descripcion) {
            try {
                $sql = "INSERT INTO casos (ambiente_id, usuario_id, producto_id, estado_id, asignado_a, descripcion, fecha_creacion) 
                        VALUES (?, ?, ?, ?, ?, ?, NOW())";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$ambiente_id, $usuario_id, $producto_id, $estado_id, $asignado_a, $descripcion]);
                
                return ["success" => true, "message" => "Caso registrado correctamente"];
            } catch (PDOException $e) {
                return ["error" => true, "message" => $e->getMessage()];
            }
        }
        
        public function allroles(){
            $query = 'SELECT * FROM roles';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
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

