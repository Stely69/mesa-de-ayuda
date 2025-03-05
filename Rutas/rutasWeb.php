<?php

use Controller\InicioControlador;
use Libreria\Enrutador;

// Ruta para la página de inicio
Enrutador::get("/", [InicioControlador::class, "inicio"]);

// Procesa la ruta
Enrutador::obtenerRuta();
