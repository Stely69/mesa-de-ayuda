<?php     
    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    require_once '../Models/UsersModel.php';

    use PHPMailer\PHPMailer\PHPMailer;

    session_start();
    class AuthController {
        private  $conn;

        public function __construct() {
            $this->conn = new UserModel();
        }

        public function login($documento, $password) {
            $user = $this->conn->getDocumento($documento);

            if(!$user){
                header('Location: ../Login/inicio_sesion?mensaje=Usuario no registrado.');
                exit();
            }

            if ($user['estado'] !== 'activo') {
                echo "<script>alert('Usuario deshabilitado, contacta al administrador'); window.location.href='inicio_sesion';</script>";
                exit();
            }            

            if(!password_verify($password, $user['contraseña'])){
                header('Location: ../Login/inicio_sesion?mensaje=Contraseña incorrecta.');
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
                    header('Location: ../Instr/instructores');
                    break;
                case 3:
                   header('Location: ../Tics/Tics');
                    break;
                case 4:
                    header('Location: ../Almn/Almacen');
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
                header("Location: ../Login/recuperar?mensaje=El correo no está registrado.");
                exit();
            }

            if ($user) {
                // Crear token y fecha de expiración
                $token = bin2hex(random_bytes(50));
                $expires_at = date("Y-m-d H:i:s", strtotime("+1 hour"));
        
                // Guardar en la tabla password_reset
                $stmt = $this->conn->password_reset($email, $token, $expires_at);
                if (!$stmt) {
                    echo "Error al guardar el token en la base de datos.";
                    exit();
                }                
                // Enviar correo con el enlace de recuperación
                $reset_link = "http://mesadeayuda.test/Login/RecuperarContrasena?token=" . $token;
        
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = 'smtp.gmass.co.'; 
                $mail->SMTPAuth = true;
                $mail->Username = 'soportetics876@gmail.coms';
                $mail->Password = '';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->setLanguage('es', '../PHPMailer/language/');
                $mail->CharSet = 'UTF-8';
        
                $mail->setFrom('soportetics876@gmail.com', 'Soporte');
                $mail->addAddress($email);
                $mail->Subject = "=?UTF-8?B?" . base64_encode("Recuperación de contraseña") . "?=";
                
                $mail->isHTML(true);
                $mail->Body = $mail->isHTML(true);
                $mail->Body = "
                            <html>
                                    <head>
                                        <meta charset='UTF-8'>
                                        <style>
                                            body {
                                                font-family: 'Arial', sans-serif;
                                                background-color: #f4f4f4;
                                                margin: 0;
                                                padding: 0;
                                                text-align: center;
                                            }
                                            .container {
                                                width: 100%;
                                                max-width: 500px;
                                                background: white;
                                                padding: 20px;
                                                margin: 20px auto;
                                                border-radius: 8px;
                                                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
                                            }
                                            .header {
                                                background-color: #3498db;
                                                color: white;
                                                padding: 15px;
                                                font-size: 20px;
                                                font-weight: bold;
                                                border-radius: 8px 8px 0 0;
                                            }
                                            .message {
                                                font-size: 16px;
                                                color: #333;
                                                margin-top: 15px;
                                            }
                                            .button {
                                                display: inline-block;
                                                background-color: #3498db;
                                                color: white;
                                                padding: 12px 20px;
                                                font-size: 16px;
                                                text-decoration: none;
                                                border-radius: 5px;
                                                font-weight: bold;
                                                margin-top: 15px;
                                            }
                                            .button:hover {
                                                background-color: #217dbb;
                                            }
                                            .footer {
                                                margin-top: 20px;
                                                font-size: 14px;
                                                color: #777;
                                            }
                                        </style>
                                    </head>
                                    <body>
                                        <div class='container'>
                                            <div class='header'>Recuperación de Contraseña</div>
                                            <p class='message'>Estimado usuario,</p>
                                            <p class='message'>Hemos recibido una solicitud para restablecer su contraseña. Haga clic en el siguiente botón para proceder con la recuperación:</p>
                                            <p>
                                                <a href='" . $reset_link . "' class='button'>Restablecer Contraseña</a>
                                            </p>
                                            <p class='message'>Si no solicitó este cambio, ignore este mensaje.</p>
                                            <p class='footer'>Atentamente,<br><strong>El equipo de soporte</strong></p>
                                        </div>
                                    </body>
                            </html>";
                                            
                if (!$mail->send()) {
                    echo "Error al enviar correo: " . $mail->ErrorInfo;
                } else {
                   header("Location: ../Login/inicio_sesion?mensaje=Correo enviado con éxito.");
                    exit();
                }
                
            } else {
                header("Location: ../Login/recuperar?mensaje=El correo no está registrado.");
                exit();
            }
        }

        public function obtenertoken($token) {
            $record = $this->conn->obtenerToken($token);
    
            if (!$record) {
                die("El enlace ha expirado o es inválido.");
            }

        }

        public function updatepassaword($new_password, $token) {
            $record = $this->conn->obtenerToken($token);
            // Validar si el token existe
            if (!$record) {
                die("Token inválido o expirado.");
            }
        
            // Hash de la nueva contraseña
            $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
        
            // Actualizar la contraseña y eliminar el token si todo está bien
            if ($this->conn->actualizarContraseña($record['email'], $hashedPassword)) {
                $this->conn->eliminarToken($token);
                echo "Contraseña actualizada con éxito.";
            } else {
                echo "Error al actualizar contraseña.";
            }
        }
    }
