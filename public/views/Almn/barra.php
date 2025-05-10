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
            <a href="Almacen" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-[#007832] hover:text-white text-sm font-medium transition duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3" />
                </svg>
                <span>Inicio</span>
            </a>


            <a href="inventario" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-[#00304D] hover:text-white text-sm font-medium transition duration-300">
                <!-- Icono: Caja (Inventario) -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9-4 9 4v10l-9 4-9-4V7z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 21V9l6-3" />
                </svg>
                <span>Inventario</span>
            </a>

            <a href="casos" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-[#00304D] hover:text-white text-sm font-medium transition duration-300">
                <!-- Icono: Tablero / Dashboard -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h7v7H3V3zm0 11h7v7H3v-7zm11-11h7v4h-7V3zm0 7h7v11h-7V10z" />
                </svg>
                <span>Panel de Casos</span>
            </a>


            <a href="historial" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-[#00304D] hover:text-white text-sm font-medium transition duration-300">
                <!-- Icono: Reloj o Historial -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Historial</span>
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
