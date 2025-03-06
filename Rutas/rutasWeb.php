<?php
    use Controller\InicioControlador;
    use Libreria\Enrutador;

    // Rutas para la página de inicio
    Enrutador::get("/", [InicioControlador::class, "inicio"]);
    // Rutas de Admin
    Enrutador::get("admin", [InicioControlador::class, "admin"]);
    Enrutador::get("GestiondeUsuarios", [InicioControlador::class,"gestiondeusuarios"]);
    // Rutas de Login
    Enrutador::post("LoginAction", [InicioControlador::class, "Loginaction"]);
    Enrutador::get("LogoutAction", [InicioControlador::class,"Logout"]);
    Enrutador::get("inicio_sesion", [InicioControlador::class, "Login"]);
    // Rutas de los roles
    Enrutador::get("intructores", [InicioControlador::class, "intructor"]);
   
    Enrutador::obtenerRuta();
