<?php 
    
    require_once __DIR__ . '/../config/Database.php';

    class UserModel {

        private $conn;   

        public function __construct() {
            $database = new Database();
            $this->conn = $database->getConnection();
        }

        public function createUser($documento, $nombre, $apellido, $correo ,$password, $rol) {
            $query = "INSERT INTO usuarios (documento, nombres,apellido, correo, contraseña, rol_id,estado) 
                      VALUES (:documento, :nombre,:apellido ,:correo, :password, :rol, 'activo')";
        
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":documento", $documento);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":apellido", $apellido);
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


        public function updateUsuario($id, $nombres, $apellido, $correo, $rol_id) {
                $sql = "UPDATE usuarios SET nombres = :nombres, apellido = :apellido, correo = :correo, rol_id = :rol_id WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                // Verifica que los parámetros sean correctos
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->bindParam(":nombres", $nombres, PDO::PARAM_STR);
                $stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
                $stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
                $stmt->bindParam(":rol_id", $rol_id, PDO::PARAM_INT);
        
                return $stmt->execute();
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
        public function allUser(){
            $query = "SELECT usuarios .*, roles.nombre as rol FROM usuarios INNER JOIN roles ON usuarios.rol_id = roles.id";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        public function updateStatus($id,$status) {
            $query = 'UPDATE usuarios SET estado = :status WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        }

    }