<?php
    use Controller\InicioControlador;
    use Libreria\Enrutador;

    // Rutas para la página de inicio
    Enrutador::get("/", [InicioControlador::class, "inicio"]);
    // Rutas de Admin
    Enrutador::get("admin", [InicioControlador::class, "admin"]);
    Enrutador::get("GestiondeUsuarios", [InicioControlador::class,"gestiondeusuarios"]);
    Enrutador::post("RegistroAction", [InicioControlador::class,"createaction"]);
    Enrutador::post("UpdateAction", [InicioControlador::class,"updateaction"]);
    Enrutador::post("UpdateStatus", [InicioControlador::class,"statusaction"]);
    Enrutador::get("DeleteAction", [InicioControlador::class,"deleteaction"]);
    // Rutas de Login
    Enrutador::post("LoginAction", [InicioControlador::class, "Loginaction"]);
    Enrutador::get("LogoutAction", [InicioControlador::class,"Logout"]);
    Enrutador::get("inicio_sesion", [InicioControlador::class, "Login"]);
    Enrutador::get("recuperar", [InicioControlador::class,"recuperar"]);
    // Rutas de los instructores
    Enrutador::get("instructores", [InicioControlador::class, "instructor"]);
    Enrutador::post("GetAmbienteAction", [InicioControlador::class,"getambientes"]);
    Enrutador::post("ReportarFallaAction", [InicioControlador::class,"registrarCaso"]);
    // Rutas del almacén
    Enrutador::get("Almacen", [InicioControlador::class, "alm"]);
    Enrutador::get("historial", [InicioControlador::class,"almacenhistrorial"]);
    Enrutador::get("inventario", [InicioControlador::class,"almaceninventario"]);
    Enrutador::get("casos", [InicioControlador::class,"almacenreportes"]);
    Enrutador::get("AddProducto", [InicioControlador::class,"addproducto"]);
    Enrutador::post("AddAction", [InicioControlador::class,"AddAction"]);
    // Rutas de Tics
    Enrutador::get("Tics", [InicioControlador::class,"tics"]);
    Enrutador::get("pendientes", [InicioControlador::class,"ticspendientes"]);


    Enrutador::obtenerRuta();
