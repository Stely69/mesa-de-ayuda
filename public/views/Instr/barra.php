<?php
if (!isset($base_path)) {
    $base_path = 'instr';
}
?>
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@700&display=swap" rel="stylesheet">

<button id="hamburger" class="lg:hidden text-[#00304D] p-2 focus:outline-none">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>
<aside id="sidebar" class="fixed inset-y-0 left-0 w-64 z-40 bg-white text-gray-800 p-6 space-y-6 shadow-md flex flex-col transform transition-transform -translate-x-full lg:translate-x-0">
    <!-- Este botón debería estar en tu encabezado o navbar -->


    <!-- Parte superior: logo y navegación -->
    <div>
        <div class="flex items-center space-x-2 mb-4">
            <img src="../pictures/logoSena.png" alt="Logo" class="w-6 h-6">
            <span class="text-lg" style="font-family: 'Rajdhani', sans-serif; font-weight: 700; color: #39A900;">
             GEDAC
            </span>
        </div>

        <nav class="flex flex-col space-y-2">
            <a href="/<?php echo $base_path; ?>/InicioInst" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-[#007832] hover:text-white text-sm font-medium transition duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3" />
                </svg>
                <span>Inicio</span>
            </a>

            <!-- Desplegable Registrar caso -->
            <div x-data="{ open: false }" class="space-y-1">
                <button onclick="document.getElementById('submenu-caso').classList.toggle('hidden')"
                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-[#00304D] hover:text-white text-sm font-medium transition duration-300 <?php echo ($currentPage == 'instructores.php') ? 'bg-[#007832] text-white' : ''; ?>">
                    <span class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 17v-6h6v6m2 4H7a2 2 0 01-2-2V7a2 2 0 012-2h3l2-2h4l2 2h3a2 2 0 012 2v12a2 2 0 01-2 2z" />
                        </svg>
                        <span>Registrar caso</span>
                    </span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="submenu-caso" class="ml-6 space-y-1 hidden">
                    <a href="/<?php echo $base_path; ?>/instructores" class="block p-2 rounded-lg hover:bg-[#007832] hover:text-white text-sm transition duration-300">Registrar por equipos</a>
                    <a href="/<?php echo $base_path; ?>/RegistarCasoGeneral" class="block p-2 rounded-lg hover:bg-[#007832] hover:text-white text-sm transition duration-300">Registrar general</a>
                </div>
            </div>

            <a href="/<?php echo $base_path; ?>/Historialinstructores?id=<?php echo $_SESSION['id']; ?>" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-[#00304D] hover:text-white text-sm font-medium transition duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" />
                </svg>
                <span>Historial de casos</span>
            </a>
        </nav>
    </div>

    <hr class="border-[#00304D] my-4">

    <div>
        <p class="text-xs font-semibold text-[#00304D] uppercase px-2 mb-1">Cuenta</p>

        <?php if (isset($_SESSION["id"])): ?>
            <a href="../Perfi/perfil" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-[#00304D] hover:text-white text-sm font-medium transition duration-300">
                <svg class="w-5 h-5 text-[#00304D]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A4.992 4.992 0 0110 15h4a4.992 4.992 0 014.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Perfil</span>
            </a>
        <?php endif; ?>

        <a href="../Login/LogoutAction" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-[#00304D] hover:text-white text-sm font-medium text-red-600 transition duration-300">
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H4a3 3 0 01-3-3V7a3 3 0 013-3h6a3 3 0 013 3v1" />
            </svg>
            <span>Cerrar sesión</span>
        </a>
    </div>

    <!-- Parte inferior: fecha y logo -->
    <div class="pt-6 border-t border-gray-200 mt-auto">
        <div class="text-xs text-gray-500 text-center mb-2" id="fecha-hora"></div>
        <div class="flex items-center justify-center space-x-2 text-gray-500 text-xs">
            <img src="../../pictures/logoSena.png" alt="Logo" class="w-4 h-4">
            <span>&copy; <?php echo date("Y"); ?> SENA</span>
        </div>
    </div>
  <script>
    function toggleDropdown() {
        const submenu = document.getElementById('submenu');
        const icon = document.getElementById('dropdown-icon');
        submenu.classList.toggle('hidden');
        submenu.classList.toggle('block');
        icon.classList.toggle('rotate-180');
    }

        function actualizarFechaHora() {
            const ahora = new Date();
            const opciones = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
            document.getElementById('fecha-hora').textContent = ahora.toLocaleDateString('es-CO', opciones);
        }

        actualizarFechaHora();
        setInterval(actualizarFechaHora, 60000);

        document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.getElementById('hamburger');
    const sidebar = document.getElementById('sidebar');

    // Alternar el sidebar al hacer clic en el botón hamburguesa
    hamburger.addEventListener('click', (e) => {
        e.stopPropagation(); // Evita que se dispare el clic del documento
        sidebar.classList.toggle('-translate-x-full');
        sidebar.classList.toggle('translate-x-0');
    });

    // Cerrar el sidebar al hacer clic fuera de él
    document.addEventListener('click', (e) => {
        if (
            !sidebar.contains(e.target) &&
            !hamburger.contains(e.target) &&
            sidebar.classList.contains('translate-x-0')
        ) {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
        }
    });
});


    </script>
</aside>
