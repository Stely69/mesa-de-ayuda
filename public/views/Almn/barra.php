<!-- Botón hamburguesa solo visible en móvil -->
<button id="menu-toggle" class="md:hidden fixed top-4 left-4 z-50 bg-[#39A900] text-white p-2 rounded-full shadow-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
</button>

<!-- Barra lateral responsive -->
<aside id="sidebar" class="bg-[#39A900] text-white flex flex-col p-4 pt-20 fixed h-full w-64 top-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 shadow-2xl z-40 md:rounded-r-2xl">
    <h1 class="text-2xl font-bold mb-6 pl-1">Operaciones</h1>
    <nav class="flex flex-col space-y-4">
        <a href="Almacen" class="nav-link p-2 bg-white text-[#39A900] rounded-md flex items-center space-x-2 transition hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z"/>
            </svg>
            <span>Inicio</span>
        </a>
        <a href="inventario" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md transition hover:scale-105">Inventario</a>
        <a href="casos" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md transition hover:scale-105">Panel de Casos</a>
        <a href="historial" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md transition hover:scale-105">Historial</a>
        <hr class="border-white">
        <?php session_start(); ?>
        <?php if (isset($_SESSION["id"])): ?>
            <a href="#" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md transition hover:scale-105">
                Bienvenido, <?php echo $_SESSION["nombres"]; ?>
            </a>
        <?php endif; ?>
        <a href="../Login/LogoutAction" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md transition hover:scale-105">Cerrar Sesión</a>
    </nav>
</aside>

<script>
const menuToggle = document.getElementById('menu-toggle');
const sidebar = document.getElementById('sidebar');

menuToggle.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
});
</script>
