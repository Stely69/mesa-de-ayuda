<?php 
    namespace Controller;

    class InicioControlador extends Controlador {
        // Método para cargar la vista de inicio
        public function inicio() {
            $this->cargarVista("inicio");
        }

        public function admin() {
            $this->cargarVista("Admin/Admin");
        }

        public function Login() {
            $this->cargarVista("Login/inicio_sesion");
        }

        public function Loginaction() {
            $this->cargarVista("Login/LoginAction");
        }

        public function Logout() {
            $this->cargarVista("Login/Logoutaction");
        }

        public function intructor () {
            $this->cargarVista("roles/instructores");
        }

        public function gestiondeusuarios() {
            $this->cargarVista("Admin/GestiondeUsuarios");
        }
        
    }
