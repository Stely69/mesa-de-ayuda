<?php 
    
    require_once __DIR__ . '/../config/Database.php';

    class UserModel {

        private $conn;   

        public function __construct() {
            $database = new Database();
            $this->conn = $database->getConnection();
        }

        public function createUser($cedula, $nombre, $correo, $password, $rol) {
            $query = "INSERT INTO usuarios (cedula, nombre, correo, contraseña, rol_id) 
                      VALUES (:cedula, :nombre, :correo, :password, :rol)";
        
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":cedula", $cedula);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":correo", $correo);
            $stmt->bindParam(":password", $password); // Cambié contraseña por password
            $stmt->bindParam(":rol", $rol);
        
            $stmt->execute();
        }  
        
        public function getDocumento($cedula){
            $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE cedula = :cedula");
            $stmt->bindParam(':cedula', $cedula);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

    }