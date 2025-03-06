<?php
    use Controller\InicioControlador;
    use Libreria\Enrutador;

    // Rutas para la página de inicio
    Enrutador::get("/", [InicioControlador::class, "inicio"]);

    // Rutas de Login
   
    Enrutador::obtenerRuta();
