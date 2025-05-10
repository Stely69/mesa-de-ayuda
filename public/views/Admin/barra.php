<?php
if (!isset($base_path)) {
    $base_path = 'admin';
}
?>
<!-- Fuente personalizada -->
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@700&display=swap" rel="stylesheet">

<!-- Botón hamburguesa solo visible en móvil -->
<button id="menu-toggle" class="md:hidden fixed top-4 left-4 z-50 bg-[#39A900] text-white p-2 rounded-full shadow-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
</button>

<!-- Sidebar -->
<aside id="sidebar" class="fixed inset-y-0 left-0 w-64 z-40 bg-white text-gray-800 p-6 space-y-6 shadow-md flex flex-col transform -translate-x-full md:translate-x-0 transition-transform duration-300 md:relative md:block md:rounded-r-2xl">

    <!-- Botón X solo visible en móvil -->
    <div class="flex justify-end md:hidden absolute top-4 right-4">
        <button id="closeSidebar" class="text-gray-800 p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Logo y título -->
    <div class="flex items-center space-x-2 mb-4 mt-6">
        <img src="../pictures/logoSena.png" alt="Logo" class="w-6 h-6">
        <span class="text-lg" style="font-family: 'Rajdhani', sans-serif; font-weight: 700; color: #39A900;">
            GEDAC
        </span>
    </div>

    <!-- Navegación -->
<nav class="flex flex-col space-y-2">
    <!-- Inicio -->
    <a href="admin" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-[#007832] hover:text-white text-sm font-medium transition duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3" />
        </svg>
        <span>Inicio</span>
    </a>

    <!-- Gestión de Usuarios -->
    <a href="GestiondeUsuarios" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-[#00304D] hover:text-white text-sm font-medium transition duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 20h5v-2a4 4 0 00-5-4M9 20H4v-2a4 4 0 015-4m3-4a4 4 0 100-8 4 4 0 000 8zm6 4a4 4 0 10-8 0 4 4 0 008 0z" />
        </svg>
        <span>Gestión de Usuarios</span>
    </a>

    <!-- Historial -->
    <a href="HistorialAdmin" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-[#00304D] hover:text-white text-sm font-medium transition duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Historial</span>
    </a>
</nav>

    <hr class="border-[#00304D] my-4">

    <!-- Cuenta -->
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

    <!-- Pie de sidebar -->
    <div class="pt-6 border-t border-gray-200 mt-auto">
        <div class="text-xs text-gray-500 text-center mb-2" id="fecha-hora"></div>
        <div class="flex items-center justify-center space-x-2 text-gray-500 text-xs">
            <img src="../../pictures/logoSena.png" alt="Logo" class="w-4 h-4">
            <span>&copy; <?php echo date("Y"); ?> SENA</span>
        </div>
    </div>
</aside>

<!-- Script JS -->
<script>
    function actualizarFechaHora() {
        const ahora = new Date();
        const opciones = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        document.getElementById('fecha-hora').textContent = ahora.toLocaleDateString('es-CO', opciones);
    }

    actualizarFechaHora();
    setInterval(actualizarFechaHora, 60000);

    document.addEventListener('DOMContentLoaded', () => {
        const menuToggle = document.getElementById('menu-toggle');
        const closeSidebar = document.getElementById('closeSidebar');
        const sidebar = document.getElementById('sidebar');

        menuToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
        });

        if (closeSidebar) {
            closeSidebar.addEventListener('click', () => {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
            });
        }

        document.addEventListener('click', (e) => {
            if (
                !sidebar.contains(e.target) &&
                !menuToggle.contains(e.target) &&
                sidebar.classList.contains('translate-x-0') &&
                window.innerWidth < 768
            ) {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
            }
        });
    });
</script>
