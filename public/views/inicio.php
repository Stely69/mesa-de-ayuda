<?php
$titulo = "Inicio";
include __DIR__ . '/../views/plantillas/header_inicio.php';
?>
<!DOCTYPE html>
<html lang="es">

<body class="bg-white">
    <div class="background-logo"></div>

    <!-- Navbar -->
    <nav class="bg-[#39A900] p-4 text-white flex justify-between items-center fixed w-full top-0 shadow-md z-50">
        <h1 class="text-xl font-bold">Sena-Stock</h1>
        <div class="flex gap-4">
            <a href="#how-it-works" class="bg-white text-[#39A900] px-4 py-2 rounded-full font-semibold hover:bg-gray-200 transition-all">¿Cómo Funciona?</a>
            <a href="#team" class="bg-white text-[#39A900] px-4 py-2 rounded-full font-semibold hover:bg-gray-200 transition-all">Nuestro Equipo</a>
            <a href="Login/inicio_sesion" class="bg-white text-[#39A900] px-4 py-2 rounded-full font-semibold hover:bg-gray-200 transition-all">Iniciar sesión</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="flex flex-col md:flex-row items-center justify-center text-center md:text-left p-8 md:p-16 mt-24 gap-8" id="hero">
        <div class="md:w-1/2 max-w-xl">
            <h2 class="text-5xl md:text-6xl font-bold text-[#39A900] leading-tight">
                Sistema de Gestión de Inventario
            </h2>
            <p class="text-xl md:text-2xl text-gray-700 mt-4">
                Un sistema de gestión de inventario para los ambientes de formación y oficinas del CDAE, permitiendo el control y seguimiento de equipos electrónicos, mobiliario y otros recursos.
            </p>
            <a href="Almacen/dashboard_Almacen" class="mt-6">
                <button class="mt-6 bg-[#39A900] text-white px-8 py-4 rounded-full text-xl md:text-2xl font-semibold hover:bg-green-700 transition-all">
                    Iniciar sesión
                </button>
            </a>
        </div>
        <div class="md:w-1/2 flex justify-center">
            <img src="../pictures/inve.png" alt="Gestión de Inventario" class="w-full md:w-auto max-w-md">
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="bg-gray-50 p-8 md:p-16 text-center" id="how-it-works">
        <h2 class="text-3xl font-bold text-[#39A900]">¿Cómo Funciona?</h2>
        <div class="flex flex-col md:flex-row justify-center items-center gap-8 mt-8">
            <div class="p-6 bg-white rounded-lg shadow-md w-full md:w-1/3">
                <h3 class="text-2xl font-bold text-[#39A900]">1. Reporte de Novedad</h3>
                <p class="text-gray-700 mt-2">Los usuarios identifican fallas en los equipos y las reportan en el sistema para su revisión.</p>
                <img src="../pictures/reporte.png" alt="Reporte" class="w-32 mx-auto">
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md w-full md:w-1/3">
                <h3 class="text-2xl font-bold text-[#39A900]">2. Gestión y Solución</h3>
                <p class="text-gray-700 mt-2">El área encargada revisa el reporte y soluciona la novedad, ya sea con reparación o reemplazo.</p>
                <img src="../pictures/Comprobar.png" alt="Comprobar.png" class="w-32 mx-auto">
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md w-full md:w-1/3">
                <h3 class="text-2xl font-bold text-[#39A900]">3. Registro y Seguimiento</h3>
                <p class="text-gray-700 mt-2">
                    Se almacena un historial de cada equipo, permitiendo un mejor control y trazabilidad de los cambios realizados.
                </p>
                <img src="../pictures/seguimiento.png" alt="Seguimiento" class="w-32 mx-auto">
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="p-8 md:p-16 text-center" id="team">
        <h2 class="text-3xl font-bold text-[#39A900]">Nuestro Equipo</h2>
        <div class="flex flex-wrap justify-center gap-8 mt-8">
            <div class="text-center">
                <img src="../pictures/persona.jpeg" alt="Miembro 1" class="w-32 h-32 rounded-full mx-auto">
                <p class="mt-2 font-semibold">Felipe Muñoz</p>
            </div>
            <div class="text-center">
                <img src="../pictures/persona.jpeg" alt="Miembro 2" class="w-32 h-32 rounded-full mx-auto">
                <p class="mt-2 font-semibold">Stiven Vanegas</p>
            </div>
            <div class="text-center">
                <img src="../pictures/persona.jpeg" alt="Miembro 3" class="w-32 h-32 rounded-full mx-auto">
                <p class="mt-2 font-semibold">Kevin Chavez</p>
            </div>
            <div class="text-center">
                <img src="../pictures/persona.jpeg" alt="Miembro 4" class="w-32 h-32 rounded-full mx-auto">
                <p class="mt-2 font-semibold">Julian Rivera</p>
            </div>
        </div>
    </section>

    <script>
        gsap.to("#hero", {opacity: 1, duration: 1, y: -20, ease: "power2.out"});
        gsap.to("#how-it-works", {opacity: 1, duration: 1, y: -20, ease: "power2.out", delay: 0.5});
        gsap.to("#team", {opacity: 1, duration: 1, y: -20, ease: "power2.out", delay: 1});
    </script>
</body>
</html>

<?php
include __DIR__ . '/../views/plantillas/footer_inicio.php';
?>
