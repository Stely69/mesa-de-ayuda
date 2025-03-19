<?php 
    
    require_once __DIR__ . '/../config/Database.php';

    class UserModel {

        private $conn;   

        public function __construct() {
            $database = new Database();
            $this->conn = $database->getConnection();
        }

        public function createUser($cedula, $nombre, $correo, $password, $rol) {
            $query = "INSERT INTO usuarios (documento, nombres, correo, contraseña, rol_id) 
                      VALUES (:documento, :nombre, :correo, :password, :rol)";
        
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":documento", $cedula);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":correo", $correo);
            $stmt->bindParam(":password", $password); // Cambié contraseña por password
            $stmt->bindParam(":rol", $rol);
        
            $stmt->execute();
        }  
        
        public function getDocumento($documento){
            $query = "SELECT * FROM usuarios WHERE documento = :documento";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":documento", $documento);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getEmail($email){
            $query = "SELECT * FROM usuarios WHERE correo = :correo";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":correo", $email);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }


        public function updateUser($documento, $nombre, $correo, $password, $rol) {
            $query = "UPDATE usuarios SET documento = :documento , nombre = :nombre, correo = :correo, contraseña = :password, rol_id = :rol WHERE id = :documento";
        
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":documento", $documento);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":correo", $correo);
            $stmt->bindParam(":password", $password); // Cambié contraseña por password
            $stmt->bindParam(":rol", $rol);
        
            $stmt->execute();
        }

        public function deleteUser($id) {
            $query = "DELETE FROM usuarios WHERE id = :id";
        
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $id);
        
            $stmt->execute();
        }

        public function getUser($id) {
            $query = "SELECT * FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($query);   
            $stmt->bindParam(":id", $cedula);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }