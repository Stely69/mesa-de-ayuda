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
                header('Location: GestiondeUsuarios?alert=success&mensaje='. urlencode('Usuario Creado'));
                exit();
            }
            
            header('Location: GestiondeUsuarios?alert=error&mensaje='. urlencode('Usuario No Creado'));
            exit();
        }

        public function CreateuserAuxiliar($documento, $nombres,$apellido ,$correo, $Contraseña, $rol){
            $password = password_hash($Contraseña, PASSWORD_DEFAULT);
            if (!$this->conn->createUser($documento, $nombres,$apellido, $correo, $password, $rol)){
                header('Location: GestiondeAuxiliares?alert=success&mensaje='. urlencode('Usuario Creado'));
                exit();
            }
            
            header('Location: GestiondeAuxiliares?alert=error&mensaje='. urlencode('Usuario No Creado'));
            exit();
        }

        public function Updateuser($id, $nombres,$apellido, $correo, $rol_id){
           if (!$this->conn->updateUsuario($id, $nombres,$apellido,$correo,$rol_id)){
                header('Location: GestiondaUsuarios?alert=error&mensaje='. urlencode('Usuario No Actualizado'));
                exit();
            }

            header('location: GestiondeUsuarios?alert=success&mensaje='. urlencode('Usuario Actualizado'));
            exit();
        }

        public function Updatestatus($id, $status) {
            $deid = openssl_decrypt($id, AES, key);
            if ($this->conn->updateStatus($deid, $status)) {
                header('Location:  GestióndeUsuarios?alert=error&mensaje='. urlencode("Estado No Actualizado"));
                exit();
            }else {
                header('location: GestiondeUsuarios?alert=success&mensaje='. urlencode('Estado Actualizado'));
                exit();
            }
        }

        public function Deleteuser($id){
            if (!$this->conn->deleteUser($id)){
                header('Location: GestiondeUsuarios?alert=success&mensaje='. urlencode('Usuario Eliminado'));
                exit();
            }   
           header('Location: GestiondeUsuarios?alert=error&mensaje='. urlencode('Usuario No Eliminado'));
           exit();
        }

        public function Getuser( $id ){
            return $this->conn->getUser( $id );
        }

        public function alluser(){
            return  $this->conn->allUser();
        }

        public function updateUserDatos($id,$nombres,$apellido,$correo,$password_ac,$password_nu){ {
            $user = $this->conn->getUser($id);

            if (!$user) {
                header('Location: perfil?controller=UserController&action=usuarioNoEncontrado');
                exit();
            }
        
            if (!empty($password_ac) && !empty($password_nu)) {
                if (!password_verify($password_ac, $user['contraseña'])) {
                    header('Location: perfil?controller=UserController&action=contraseñaIncorrecta');
                    exit();
                }
        
                // Encripta la nueva contraseña
                $password = password_hash($password_nu, PASSWORD_DEFAULT);
            } else {
                // Si no se proporciona una nueva contraseña, mantenemos la actual
                $password = $user['contraseña'];
            }
                
            $password = password_hash($password_nu, PASSWORD_DEFAULT);

            if (!$this->conn->updateUserDatos($id,$nombres,$apellido,$correo,$password)){
                header('Location: perfil?controller=UserController&action=usuarioNoActualizado');
                exit();
                }
                header('Location: perfil?controller=UserController&action=usuarioActualizado');
                exit();
            }
        }

        public function mostarusuaruio(){
            return $this->conn->contarUsuarios();
        }

        public function getUserAuxiliar(){
            return $this->conn->getticsauxiliar() ;
        }

        public function gettics(){
            return $this->conn->gettics() ;
        }

    }
