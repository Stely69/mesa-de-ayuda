<?php 

    require_once __DIR__ . '/../Models/UsersModel.php';


    class UserController{

        private $conn;

        public function __construct(){
            $this->conn = new UserModel();
        }

        public function Createuser($documento, $nombres,$apellido ,$correo, $Contraseña, $rol){
            $password = password_hash($Contraseña, PASSWORD_DEFAULT);
            if (!$this->conn->createUser($documento, $nombres,$apellido, $correo, $password, $rol)){
                header('Location: GestiondeUsuarios?controller=UserController&action=usuarioCreado');
                exit();
            }

            header('Location: GestiondeUsuarios?controller=UserController&action=usuarioNoCreado');
            exit();
        }

        public function Updateuser($id, $nombres,$apellido, $correo, $rol_id){
           if (!$this->conn->updateUsuario($id, $nombres,$apellido,$correo,$rol_id)){
                header('Location: GestiondaUsuarios?controller=UserController&action=usuario No Actualizado');
                exit();
            }

            header('location: GestiondeUsuarios?controller=UserController&action=usuarioActualizado');
            exit();
        }

        public function Updatestatus($id, $status) {
            $deid = openssl_decrypt($id, AES, key);
            if ($this->conn->updateStatus($deid, $status)) {
                header('Location:  Gestión de Usuarios?controller=UserController&action=Estado No Actualizado');
                exit();
            }else {
                header('location: GestiondeUsuarios?controller=UserController&action=Estado Actualizado');
                exit();
            }
        }

        public function Deleteuser($id){
            if (!$this->conn->deleteUser($id)){
                header('Location: GestiondeUsuarios?controller=UserController&action=usuarioNoEliminado');
                exit();
            }   
           header('Location: GestiondeUsuarios?controller=UserController&action=Usuario Eliminado');
           exit();
        }

        public function Getuser($documento){
            return $this->conn->getUser($documento);
        }

        public function alluser(){
            return  $this->conn->allUser();
        }

    }