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

        public function instructor () {
            $this->cargarVista("Instructores/instructores");
        }

        public function gestiondeusuarios() {
            $this->cargarVista("Admin/GestiondeUsuarios");
        }

        public function createaction() {
            $this->cargarVista("Admin/RegistroAction");
        }

        public function recuperar() {
            $this->cargarVista("Login/recuperar");
        }

        public function almacen(){
            $this->cargarVista("Almacen/dashboard_Almacen");
        }

        public function almacenhistrorial(){
            $this->cargarVista("Almacen/historial");
        }
        

        public function almaceninventario(){
            $this->cargarVista("Almacen/inventario");
        }

        public function almacenreportes(){
            $this->cargarVista("Almacen/reportes");
        }

        public function tics(){
            $this->cargarVista("Tics/Tics");
        }

        public function ticspendientes(){
            $this->cargarVista("Tics/pendientes");
        }
    }
