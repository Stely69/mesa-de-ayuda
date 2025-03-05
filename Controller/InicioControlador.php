<?php 
namespace Controller;
use Controller\Controlador;

class InicioControlador extends Controlador {
    public function inicio() {
        $this->cargarVista("views/inicio"); // Cargar vista desde la carpeta "views"
    }
}
