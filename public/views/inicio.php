<?php
$titulo = "GEDAC | Inicio";
include __DIR__ . '/../views/plantillas/header_inicio.php';
?>

<body class="bg-white overflow-x-hidden">
    <!-- Fondo animado -->
    <div class="fixed inset-0 -z-10">
        <div class="absolute inset-0 bg-gradient-to-br from-white to-gray-50"></div>
        <div class="absolute inset-0 bg-[url('../pictures/logosena.png')] bg-no-repeat bg-center bg-[length:30%] opacity-[0.06]"></div>
        <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
    </div>

    <!-- Navbar -->
    <nav class="bg-[#39A900] text-white fixed top-0 w-full z-50 shadow">
        <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            <a href="#" class="text-2xl font-extrabold tracking-wide flex items-center gap-2">
                <i class="fas fa-cube text-3xl"></i>
                GEDAC
            </a>
            <div class="flex flex-col md:flex-row gap-4">
                <a href="#hero" class="font-semibold px-4 py-2 rounded hover:bg-white hover:text-[#39A900] transition">Inicio</a>
                <a href="#how-it-works" class="font-semibold px-4 py-2 rounded hover:bg-white hover:text-[#39A900] transition">¿Cómo Funciona?</a>
                <a href="#team" class="font-semibold px-4 py-2 rounded hover:bg-white hover:text-[#39A900] transition">Nuestro Equipo</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="min-h-screen flex flex-col-reverse md:flex-row items-center justify-center text-center md:text-left p-6 md:p-16 gap-8 relative">
        <div class="w-full md:w-1/2 flex justify-center items-center">
            <img src="../pictures/inicio_img.png" alt="Gestión de Activos" class="w-full max-w-xs sm:max-w-md md:max-w-lg lg:max-w-xl rounded-2xl shadow-lg">
        </div>
        <div class="w-full md:w-1/2 max-w-xl flex flex-col items-center md:items-start justify-center">
            <h2 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-[#39A900] leading-tight mb-6 drop-shadow-sm">
                Sistema Gestión de Activos
            </h2>
            <p class="text-base sm:text-lg md:text-xl text-gray-700 mb-8 max-w-lg">
                Una plataforma diseñada para el control, seguimiento y trazabilidad de activos físicos en los ambientes de formación y oficinas del CDAE.
            </p>
            <a href="Login/inicio_sesion" class="inline-block">
                <button class="bg-[#39A900] text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-green-700 transition-all duration-300 shadow-lg flex items-center gap-2">
                    Iniciar sesión
                    <i class="fas fa-arrow-right"></i>
                </button>
            </a>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="bg-gray-50 px-6 py-12 md:px-16 text-center min-h-screen flex flex-col justify-center items-center">
        <h2 class="text-4xl font-extrabold text-[#39A900] mb-16 drop-shadow-sm">
            ¿Cómo Funciona?
            <div class="w-24 h-1 bg-[#39A900] rounded-full mx-auto mt-2"></div>
        </h2>
        <div class="flex flex-col md:flex-row justify-center items-stretch gap-8 w-full max-w-7xl">
            <!-- Paso 1 -->
            <div class="flex flex-col items-center bg-white rounded-2xl shadow-lg p-10 w-full md:w-1/3">
                <div class="mb-6">
                    <i class="fas fa-clipboard-list text-5xl text-[#39A900]"></i>
                </div>
                <h3 class="text-2xl font-semibold text-[#39A900] mb-4">1. Registro de Activos</h3>
                <p class="text-lg text-gray-600">Los responsables registran nuevos activos y actualizan datos como ubicación, estado y persona encargada.</p>
            </div>
            <!-- Paso 2 -->
            <div class="flex flex-col items-center bg-white rounded-2xl shadow-lg p-10 w-full md:w-1/3">
                <div class="mb-6">
                    <i class="fas fa-chart-line text-5xl text-[#39A900]"></i>
                </div>
                <h3 class="text-2xl font-semibold text-[#39A900] mb-4">2. Reporte y Gestión</h3>
                <p class="text-lg text-gray-600">Los instructores reportan novedades y las áreas de TICS y Almacén las gestionan para brindar soluciones efectivas.</p>
            </div>
            <!-- Paso 3 -->
            <div class="flex flex-col items-center bg-white rounded-2xl shadow-lg p-10 w-full md:w-1/3">
                <div class="mb-6">
                    <i class="fas fa-search text-5xl text-[#39A900]"></i>
                </div>
                <h3 class="text-2xl font-semibold text-[#39A900] mb-4">3. Control y Trazabilidad</h3>
                <p class="text-lg text-gray-600">Cada acción queda registrada en el sistema, permitiendo trazabilidad, auditoría y una gestión administrativa más eficiente.</p>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="px-6 py-12 md:px-16 text-center min-h-screen flex flex-col justify-center items-center">
        <h2 class="text-4xl font-extrabold text-[#39A900] mb-16 drop-shadow-sm">
            Nuestro Equipo
            <div class="w-24 h-1 bg-[#39A900] rounded-full mx-auto mt-2"></div>
        </h2>
        <div class="flex flex-wrap justify-center gap-8 max-w-7xl">
            <!-- Integrante 1 -->
            <div class="bg-white rounded-2xl shadow-md p-6 w-64 flex flex-col items-center">
                <img src="../pictures/Felipe_Muñoz.jpeg" alt="Felipe Muñoz" class="w-32 h-32 rounded-full object-cover border-4 border-[#39A900]/20 mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Felipe Muñoz</h3>
                <p class="text-sm text-gray-600 mb-2">Líder de Proyecto   Desarrollador FullStack</p>
                <div class="flex space-x-4 mt-2">
                    <a href="#" target="_blank" class="text-gray-500 hover:text-[#39A900]">
                        <i class="fab fa-github text-xl"></i>
                    </a>
                    <a href="#" target="_blank" class="text-gray-500 hover:text-[#39A900]">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                </div>
            </div>
            <!-- Integrante 2 -->
            <div class="bg-white rounded-2xl shadow-md p-6 w-64 flex flex-col items-center">
                <img src="../pictures/WilliamSteven.jpg" alt="Steven Vanegas" class="w-32 h-32 rounded-full object-cover border-4 border-[#39A900]/20 mb-4">
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
            <!-- Integrante 3 -->
            <div class="bg-white rounded-2xl shadow-md p-6 w-64 flex flex-col items-center">
                <img src="../pictures/Kevin_Chavez.jpeg" alt="Kevin Chávez" class="w-32 h-32 rounded-full object-cover border-4 border-[#39A900]/20 mb-4">
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
            <!-- Integrante 4 -->
            <div class="bg-white rounded-2xl shadow-md p-6 w-64 flex flex-col items-center">
                <img src="../pictures/Julian_Rivera.jpeg" alt="Julian Rivera" class="w-32 h-32 rounded-full object-cover border-4 border-[#39A900]/20 mb-4">
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
            <!-- Integrante 5: Felipe Restrepo, Project Manager -->
            <div class="bg-white rounded-2xl shadow-md p-6 w-72 flex flex-col items-center mt-8">
                <img src="../pictures/ins.png" alt="Felipe Restrepo" class="w-40 h-40 rounded-full object-cover border-4 border-[#39A900]/20 mb-4">
                <h3 class="text-xl font-bold text-gray-800">Felipe Restrepo</h3>
                <p class="text-base text-gray-600 mb-2">Project Manager</p>
            </div>
        </div>
    </section>

    <style>
        .bg-grid-pattern {
            background-image: linear-gradient(to right, #39A90011 1px, transparent 1px),
                            linear-gradient(to bottom, #39A90011 1px, transparent 1px);
            background-size: 30px 30px;
        }
    </style>
</body>
</html>

<?php
include __DIR__ . '/../views/plantillas/footer_inicio.php';
?>