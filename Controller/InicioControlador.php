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
            $this->cargarVista("Instr/instructores");
        }

        public function getambientes() {
            $this->cargarVista("Instr/GetAmbienteAction");
        }

        public function registrarCaso() {
            $this->cargarVista("Instr/ReportarFallaAction");
        }

        public function historialcasos() {
            $this->cargarVista("Instr/historialcasos");
        }
        
        public function registarcasogeneral() {
            $this->cargarVista("Instr/RegistarCasoGeneral");
        }

        public function registrarcasogeneralaction() {
            $this->cargarVista("Instr/CasoGeneralAction");
        }

        public function gestiondeusuarios() {
            $this->cargarVista("Admin/GestiondeUsuarios");
        }

        public function createaction() {
            $this->cargarVista("Admin/RegistroAction");
        }

        public function updateaction() {
            $this->cargarVista("Admin/UpdateAction");
        }

        public function statusaction() {
            $this->cargarVista("Admin/UpdateStatus");
        }

        public function deleteaction() {
            $this->cargarVista("Admin/DeleteAction");
        }

        public function recuperar() {
            $this->cargarVista("Login/recuperar");
        }

        public function recuperaraction() {
            $this->cargarVista("Login/RecuperarAction");
        }

        public function recuperarcontrasena() {
            $this->cargarVista("Login/RecuperarContrasena");
        }
        public function recuperarcontraseñaction() {
            $this->cargarVista("Login/RecuperarContraseñaAction");
        }
        public function updatepassword() {
            $this->cargarVista("Login/UpdatePasswordAction");
        }

        public function alm(){
            $this->cargarVista("Almn/Almacen");
        }

        public function almacenhistrorial(){
            $this->cargarVista("Almn/historial");
        }
        

        public function almaceninventario(){
            $this->cargarVista("Almn/inventario");
        }

        public function almacenreportes(){
            $this->cargarVista("Almn/reportes");
        }

        public function addproducto(){
            $this->cargarVista("Almn/AddProducto");
        }

        public function addAction(){
            $this->cargarVista("Almn/AddAction");
        }

        public function tics(){
            $this->cargarVista("Tics/Tics");
        }

        public function ticspendientes(){
            $this->cargarVista("Tics/pendientes");
        }

        public function ver_caso(){
            $this->cargarVista("Tics/ver_caso");
        }

        public function ver_casog(){
            $this->cargarVista("Tics/ver_casoG");
        }

        public function gestiondeauxiliares(){
            $this->cargarVista("Tics/GestiondeAuxiliares");
        }

        public function updatestatusa(){
            $this->cargarVista("Tics/UpdatestatusAction");
        }

        public function asignarauxiliar(){
            $this->cargarVista("Tics/AsignarCasoAction");
        }

        public function perfil(){
            $this->cargarVista("Perfi/perfil");
        }

        public function updateUser(){
            $this->cargarVista("Perfi/UpdateUserAction");
        }

    }
