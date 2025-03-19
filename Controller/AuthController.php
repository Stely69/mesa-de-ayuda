<?php     
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    require_once '../Models/UsersModel.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    session_start();
    class AuthController {
        private  $conn;

        public function __construct() {
            $this->conn = new UserModel();
        }

        public function login($documento, $password) {
            $user = $this->conn->getDocumento($documento);

            if(!$user){
                echo'Ese usuario no existe';
                //header('');
                exit();
            }

            if(!password_verify($password, $user['contraseña'])){
                echo 'Contraseña incorrecta';
                //header('');
                exit();
            }

            $_SESSION['rol_id'] = $user['rol_id'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['nombres'] = $user['nombres'];


            switch($_SESSION['rol_id']){
               case 1:
                    header('Location: ../admin/admin');
                    break;
                case 2:
                    header('Location: ../Instructores/instructores');
                    break;
                case 3:
                   header('Location: ../Tics/Tics');
                    break;
                case 4:
                    header('Location: ../almacen/dashboard_Almacen');
                    break;
                default:
                    header('Location: ../');
                    break; 
            }
            exit();
        }

        public function logout() {
            session_start();
            session_destroy();
            header('Location: ../');
            exit();
        }

        public function recuperar($email) {
            $user = $this->conn->getEmail($email);

            if(!$user){
                echo 'Ese usuario no existe';
                //header('');
                exit();
            }

            $usuarios = $user['nombre'];
            $idusuarios = $user['id'];

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'user@example.com';                     //SMTP username
                $mail->Password   = 'secret';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('', 'Stock Control');
                $mail->addAddress($email,$usuarios, );     //Add a recipient

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Hola, Bienvenido a Stock Control';
                $mail->Body    = 'Te enbiamos este correo para que puedas recuperar tu contraseña, si
                no fuiste tu quien solicito este correo por favor ignoralo, si fuiste tu, por favor <a href="http://mesadeayuda.test/Login/recuperar_contraseña?id=$idusuario">clickea aqui</a> para recuperar tu contraseña';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                header('Location: ../Login/inicio_sesion');
                exit();

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        }

    }
