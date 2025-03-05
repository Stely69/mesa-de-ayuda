<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario - SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            position: relative;
            background-color: white;
        }
        .background-logo {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('../pictures/logosena.png') no-repeat center center;
            background-size: 30%;
            opacity: 0.1;
            z-index: -1;
        }
    </style>
</head>
<body class="bg-white">
    <div class="background-logo"></div>
    <!-- Navbar -->
    <nav class="bg-[#39A900] p-4 text-white flex justify-between items-center fixed w-full top-0 shadow-md z-50">
        <h1 class="text-xl font-bold">Gestión de Inventario - SENA</h1>
        <a href="../views/Login/inicio_sesion.php" class="bg-white text-[#39A900] px-4 py-2 rounded-full font-semibold hover:bg-gray-200 transition-all">Iniciar sesion</a>
    </nav>
    
    <!-- Hero Section -->
    <section class="flex flex-col md:flex-row items-center justify-center text-center md:text-left p-8 md:p-16 mt-16 opacity-0" id="hero">
        <div class="md:w-1/2">
            <h2 class="text-4xl font-bold text-[#39A900]">Sistema de Gestión de Inventario</h2>
            <p class="text-gray-700 mt-4">Optimiza el control de entrada y salida de equipos y materiales en el SENA con nuestra plataforma digital.</p>
            <button class="mt-6 bg-[#39A900] text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-green-700 transition-all">Iniciar sesion</button>
        </div>
        <div class="md:w-1/2 flex justify-center">
        <img src="../pictures/inv.png" alt="Logo SENA" class="w-100 md:w-100">        </div>
    </section>
    
    <!-- How It Works Section -->
    <section class="bg-gray-50 p-8 md:p-16 text-center opacity-0" id="how-it-works">
        <h2 class="text-3xl font-bold text-[#39A900]">¿Cómo Funciona?</h2>
        <div class="flex flex-col md:flex-row justify-center items-center gap-8 mt-8">
            <div class="p-6 bg-white rounded-lg shadow-md w-full md:w-1/3">
                <h3 class="text-2xl font-bold text-[#39A900]">1. Escaneo</h3>
                <p class="text-gray-700 mt-2">Utiliza el escáner para registrar la entrada y salida de equipos en segundos.</p>
                <img src="../pictures/escaneo.png" alt="" class="md:w-60 mx-auto">
                </div>
            <div class="p-6 bg-white rounded-lg shadow-md w-full md:w-1/3">
                <h3 class="text-2xl font-bold text-[#39A900]">2. Monitoreo</h3>
                <p class="text-gray-700 mt-2">Visualiza los registros en tiempo real y mantén el control del inventario.</p>
                <img src="../pictures/monitoreo.png" alt="" class="md:w-60 mx-auto">
            </div>
            <div class="p-6 bg-white rounded-lg shadow-md w-full md:w-1/3">
                <h3 class="text-2xl font-bold text-[#39A900]">3. Reportes</h3>
                <p class="text-gray-700 mt-2">Genera informes detallados sobre los movimientos del inventario.</p>
                <img src="../pictures/reportes.png" alt="" class="md:w-60 mx-auto">
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="p-8 md:p-16 text-center opacity-0" id="contact">
        <h2 class="text-3xl font-bold text-[#39A900]">Contáctanos</h2>
        <p class="text-gray-700 mt-4">Si necesitas soporte o más información sobre el sistema, escríbenos.</p>
        <form class="mt-6 max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <input type="text" placeholder="Tu Nombre" class="w-full p-3 border border-gray-300 rounded mb-4">
            <input type="email" placeholder="Tu Correo" class="w-full p-3 border border-gray-300 rounded mb-4">
            <textarea placeholder="Tu Mensaje" class="w-full p-3 border border-gray-300 rounded mb-4"></textarea>
            <button class="bg-[#39A900] text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-green-700 transition-all w-full">Enviar mensaje</button>
        </form>
    </section>
    
    <!-- Footer -->
    <footer class="bg-[#39A900] text-white text-center p-4 mt-8">
        <p>&copy; 2025 SENA - Sistema de Gestión de Inventario</p>
    </footer>

    <script>
        gsap.to("#hero", {opacity: 1, duration: 1, y: -20, ease: "power2.out"});
        gsap.to("#how-it-works", {opacity: 1, duration: 1, y: -20, ease: "power2.out", delay: 0.5});
        gsap.to("#contact", {opacity: 1, duration: 1, y: -20, ease: "power2.out", delay: 1});
    </script>
</body>
</html>
