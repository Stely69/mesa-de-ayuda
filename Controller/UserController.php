<?php 

    require_once __DIR__ . '/../Models/UsersModel.php';


    class UserController{

        private $conn;

        public function __construct(){
            $this->conn = new UserModel();
        }

        public function Createuser($cedula, $nombre ,$correo, $Contraseña, $rol){
            $password = password_hash($Contraseña, PASSWORD_DEFAULT);
            if (!$this->conn->createUser($cedula, $nombre, $correo, $password, $rol)){
                header('Location: ');
                exit();
            }

            header('');
            exit();
        }

        public function Updateuser($cedula, $nombre, $correo, $contraseña, $rol){
           if (!$this->conn->updateUser($cedula, $nombre, $correo, $contraseña, $rol)){
                header('Location: ');
                exit();
            }

            header('');
            exit();
        }

        public function Deleteuser($cedula){
            if (!$this->conn->deleteUser($cedula)){
                header('Location: ');
                exit();
            }   
           header('');
           exit();
        }

        public function Getuser($cedula){
            return $this->conn->getUser($cedula);
        }

    }