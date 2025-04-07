<?php
$titulo = "GEDAC | Inicio";
include __DIR__ . '/../views/plantillas/header_inicio.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/tailwind.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <title></title>
</head> 

<body class="bg-white">
    <div class="background-logo"></div>

    <!-- Navbar -->
    <nav class="bg-[#39A900] text-white fixed top-0 w-full z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo / Marca -->
            <a href="#" class="text-2xl font-extrabold tracking-wide">GEDAC</a>
            <!-- Botón hamburguesa (solo visible en móviles) -->
            <button id="menu-btn" class="md:hidden focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
            <!-- Menú principal -->
            <div id="menu" class="hidden md:flex flex-col md:flex-row md:items-center gap-4 absolute md:static top-16 left-0 w-full md:w-auto bg-[#39A900] md:bg-transparent px-6 md:px-0 py-4 md:py-0 shadow-md md:shadow-none">
                <div class="flex flex-col md:flex-row gap-4">
                    <a href="#hero" class="bg-white text-[#39A900] px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition duration-200 text-center">Inicio</a>
                    <a href="#how-it-works" class="bg-white text-[#39A900] px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition duration-200 text-center">¿Cómo Funciona?</a>
                    <a href="#team" class="bg-white text-[#39A900] px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition duration-200 text-center">Nuestro Equipo</a>
                </div>
            </div>
        </div>
    </nav>

    <script>
        // JS para alternar el menú móvil
        const menuBtn = document.getElementById('menu-btn');
        const menu = document.getElementById('menu');

        menuBtn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    </script>


    <!-- Hero Section -->
    <section id="hero" class="min-h-screen flex flex-col-reverse md:flex-row items-center justify-center text-center md:text-left p-6 md:p-16 gap-8">
        <!-- Imagen -->
        <div class="w-full md:w-1/2 flex justify-center items-center">
            <img src="../pictures/inicio_img.png" alt="Gestión de Activos" class="w-full max-w-xs sm:max-w-md md:max-w-lg lg:max-w-xl">
        </div>
        <!-- Texto -->
        <div class="w-full md:w-1/2 max-w-xl flex flex-col items-center md:items-start justify-center items-center">
            <h2 class="text-4xl sm:text-5xl md:text-6xl font-bold text-[#39A900] leading-tight">
                Sistema Gestión de Activos
            </h2>
            <p class="text-base sm:text-lg md:text-xl text-gray-700 mt-4">
                Una plataforma diseñada para el control, seguimiento y trazabilidad de activos físicos en los ambientes de formación y oficinas del CDAE, facilitando la gestión de equipos electrónicos, mobiliario y otros recursos de forma eficiente y colaborativa.
            </p>
            <a href="Login/inicio_sesion" class="inline-block mt-6">
                <button class="bg-[#39A900] text-white px-6 py-3 sm:px-8 sm:py-4 rounded-full text-lg sm:text-xl font-semibold hover:bg-green-700 transition-all">
                    Iniciar sesión
                </button>
            </a>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="bg-gray-50 px-6 py-12 md:px-16 text-center min-h-screen flex flex-col justify-center items-center">
        <h2 class="text-4xl font-extrabold text-[#39A900] mb-10">¿Cómo Funciona?</h2>

        <div class="flex flex-col md:flex-row justify-center items-stretch gap-8 w-full max-w-7xl">

            <!-- Paso 1 -->
            <div class="flex flex-col items-center bg-white rounded-2xl shadow-lg p-10 w-full md:w-1/3 transition-transform hover:scale-105">
                <img src="../pictures/registro.png" alt="Registro de activos" class="w-28 h-28 object-contain mb-6">
                <h3 class="text-2xl font-semibold text-[#39A900] mb-4">1. Registro de Activos</h3>
                <p class="text-lg text-gray-600">Los responsables registran nuevos activos y actualizan datos como ubicación, estado y persona encargada.</p>
            </div>

            <!-- Paso 2 -->
            <div class="flex flex-col items-center bg-white rounded-2xl shadow-lg p-10 w-full md:w-1/3 transition-transform hover:scale-105">
                <img src="../pictures/reportes.png" alt="Reporte y gestión" class="w-28 h-28 object-contain mb-6">
                <h3 class="text-2xl font-semibold text-[#39A900] mb-4">2. Reporte y Gestión</h3>
                <p class="text-lg text-gray-600">Los instructores reportan novedades y las áreas de TICS y Almacén las gestionan para brindar soluciones efectivas.</p>
            </div>

            <!-- Paso 3 -->
            <div class="flex flex-col items-center bg-white rounded-2xl shadow-lg p-10 w-full md:w-1/3 transition-transform hover:scale-105">
                <img src="../pictures/seguimiento.png" alt="Control y trazabilidad" class="w-28 h-28 object-contain mb-6">
                <h3 class="text-2xl font-semibold text-[#39A900] mb-4">3. Control y Trazabilidad</h3>
                <p class="text-lg text-gray-600">Cada acción queda registrada en el sistema, permitiendo trazabilidad, auditoría y una gestión administrativa más eficiente.</p>
            </div>

        </div>
    </section>



    <!-- Team Section -->
    <section id="team" class="px-6 py-12 md:px-16 text-center min-h-screen flex flex-col justify-center items-center">
        <h2 class="text-4xl font-extrabold text-[#39A900] mb-10">Nuestro Equipo</h2>
        <div class="flex flex-wrap justify-center gap-8">
            <!-- Integrante -->
            <div class="bg-white rounded-2xl shadow-md p-6 w-64 flex flex-col items-center">
                <img src="../pictures/persona.jpeg" alt="Felipe Muñoz" class="w-32 h-32 rounded-full object-cover mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Felipe Muñoz</h3>
                <p class="text-sm text-gray-600 mb-2">Líder de Proyecto</p>
                <div class="flex space-x-4 mt-2">
                    <a href="#" target="_blank" class="text-gray-500 hover:text-[#39A900]">
                        <i class="fab fa-github text-xl"></i>
                    </a>
                    <a href="#" target="_blank" class="text-gray-500 hover:text-[#39A900]">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                </div>
            </div>
            <!-- Repite por cada integrante -->
            <div class="bg-white rounded-2xl shadow-md p-6 w-64 flex flex-col items-center">
                <img src="../pictures/persona.jpeg" alt="Stiven Vanegas" class="w-32 h-32 rounded-full object-cover mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Steven Vanegas</h3>
                <p class="text-sm text-gray-600 mb-2">Desarrollador Backend</p>
                <div class="flex space-x-4 mt-2">
                    <a href="#" target="_blank" class="text-gray-500 hover:text-[#39A900]">
                        <i class="fab fa-github text-xl"></i>
                    </a>
                    <a href="#" target="_blank" class="text-gray-500 hover:text-[#39A900]">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 w-64 flex flex-col items-center">
                <img src="../pictures/persona.jpeg" alt="Kevin Chávez" class="w-32 h-32 rounded-full object-cover mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Kevin Chávez</h3>
                <p class="text-sm text-gray-600 mb-2">Desarrollador Frontend</p>
                <div class="flex space-x-4 mt-2">
                    <a href="#" target="_blank" class="text-gray-500 hover:text-[#39A900]">
                        <i class="fab fa-github text-xl"></i>
                    </a>
                    <a href="#" target="_blank" class="text-gray-500 hover:text-[#39A900]">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-md p-6 w-64 flex flex-col items-center">
                <img src="../pictures/persona.jpeg" alt="Julian Rivera" class="w-32 h-32 rounded-full object-cover mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Julian Rivera</h3>
                <p class="text-sm text-gray-600 mb-2">Diseñador UI/UX</p>
                <div class="flex space-x-4 mt-2">
                    <a href="#" target="_blank" class="text-gray-500 hover:text-[#39A900]">
                        <i class="fab fa-github text-xl"></i>
                    </a>
                    <a href="#" target="_blank" class="text-gray-500 hover:text-[#39A900]">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                </div>
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