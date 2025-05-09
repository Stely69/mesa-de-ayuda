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
    Enrutador::get("HistorialAdmin",[InicioControlador::class,"historialadmin"]);
    // Rutas de Login
    Enrutador::post("LoginAction", [InicioControlador::class, "Loginaction"]);
    Enrutador::get("LogoutAction", [InicioControlador::class,"Logout"]);
    Enrutador::get("inicio_sesion", [InicioControlador::class, "Login"]);
    Enrutador::get("recuperar", [InicioControlador::class,"recuperar"]);
    Enrutador::post("RecuperarAction", [InicioControlador::class,"recuperaraction"]);
    Enrutador::get("RecuperarContrasena", [InicioControlador::class,"recuperarcontrasena"]);
    Enrutador::post("RecuperarContraseñaAction", [InicioControlador::class,"recuperarcontraseñaction"]);
    Enrutador::post("UpdatePasswordAction", [InicioControlador::class,"updatepassword"]);

    // Rutas de los instructores
    Enrutador::get("instructores", [InicioControlador::class, "instructor"]);
    Enrutador::post("GetAmbienteAction", [InicioControlador::class,"getambientes"]);
    Enrutador::post("ReportarFallaAction", [InicioControlador::class,"registrarCaso"]);
    Enrutador::get("historialcasos", [InicioControlador::class,"historialcasos"]);
    Enrutador::get("RegistarCasoGeneral", [InicioControlador::class,"registarcasogeneral"]);
    Enrutador::post("CasoGeneralAction", [InicioControlador::class,"registrarcasogeneralaction"]);
    Enrutador::get("Historialinstructores", [InicioControlador::class,"historialinstructores"]);
    Enrutador::get("InicioInst", [InicioControlador::class,"InicioInstr"]);
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
    Enrutador::get("GestiondeAuxiliares",[InicioControlador::class, "gestiondeauxiliares"]);
    Enrutador::post("RegistroActionG", [InicioControlador::class,"createactionG"]);
    Enrutador::get("DeleteActionA", [InicioControlador::class,"deleteactionA"]);
    Enrutador::post("UpdateStatusA", [InicioControlador::class,"updateactionA"]);
    Enrutador::get("ver_caso", [InicioControlador::class,"ver_caso"]);
    Enrutador::get("ver_casoG", [InicioControlador::class,"ver_casog"]);
    Enrutador::post("UpdatestatusAction", [InicioControlador::class,"updatestatusa"]);
    Enrutador::post("AsignarCasoActionG", [InicioControlador::class,"asignarauxiliar"]);
    Enrutador::post("EditarUsuarioAuxiliar", [InicioControlador::class,"editarauxiliar"]);
    // ruta de perfil
    Enrutador::get("perfil", [InicioControlador::class,"perfil"]);
    Enrutador::post("UpdateUserActionPerfil", [InicioControlador::class,"updateUserPerfil"]);
    Enrutador::post("UpdateUserAction", [InicioControlador::class,"updateUser"]);
    Enrutador::post("ActualizarEstadoCasoAlmacen", [InicioControlador::class,"actualizarEstadoCasoAlmacen"]);
    Enrutador::post("EliminarCasoAlmacen", [InicioControlador::class, "eliminarCasoAlmacen"]);
    Enrutador::post("EliminarBienAction", [InicioControlador::class, "eliminarBienAction"]);
    Enrutador::post("EditarBienAction", [InicioControlador::class, "editarBienAction"]);
    Enrutador::post("CargarBienesExcel", [InicioControlador::class, "cargarBienesExcelAction"]);
    Enrutador::get("consulta_caso", [InicioControlador::class, "consultaCasoAjax"]);
    Enrutador::get("Ver_Casos_Almn", [InicioControlador::class, "verCasoAlmacen"]);

    Enrutador::obtenerRuta();
