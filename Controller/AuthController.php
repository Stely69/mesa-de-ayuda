<?php 

    require_once '../Models/UsersModel.php';

    class AuthController {
        private  $conn;

        public function __construct() {
            $this->conn = new UserModel();
        }

        public function login($documento, $password) {
            $user = $this->conn->getDocumento($documento);

            if($user){
                echo'Ese usuario no existe';
                //header('');
                exit();
            }

            if(password_verify($password, $user['password'])){
                echo 'Contraseña incorrecta';
                //header('');
                exit();
            }

            session_start();

            $_SESSION['user_cedula'] = $user['cedula'];
            $_SESSION['rol_id'] = $user['rol'];
            $_SESSION['nombre'] = $user['nombre'];

            switch($user['rol']){
                case $user == 1:
                    header('Location: ../admin/admin');
                    exit();
                case $user == 2:
                    header('Location: ../roles/intructores');
                    exit();
                case $user == 3:
                    header('Location: ../roles/Tics');
                    exit();
                case $user == 4:
                    header('Location: ../roles/Almacen');
                    exit();
                default:
                    header('Location: ../');
                    exit();   
            }
        }

        public function logout() {
            session_start();
            session_destroy();
            header('Location: ../');
            exit();
        }
    }