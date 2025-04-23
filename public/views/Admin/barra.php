<!-- Botón hamburguesa solo visible en móvil -->
<button id="menu-toggle" class="md:hidden fixed top-4 left-4 z-50 bg-[#39A900] text-white p-2 rounded-full shadow-lg">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
</button>

<!-- Barra lateral responsive -->
<aside id="sidebar" class="bg-[#39A900] text-white w-64 p-6 pt-20 space-y-4 fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40 md:relative md:block shadow-2xl md:rounded-r-2xl">
    
    <!-- Botón X para cerrar solo en móvil -->
    <div class="flex justify-end md:hidden absolute top-4 right-4">
        <button id="closeSidebar" class="text-white p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <h1 class="text-2xl font-bold mb-6 pl-1">Operaciones</h1>
    
    <nav class="flex flex-col space-y-3">
        <a href="admin" class="p-2 hover:bg-white hover:text-[#39A900] rounded transition flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z" />
            </svg>
            <span>Inicio</span>
        </a>
        
        <a href="GestiondeUsuarios" class="p-2 hover:bg-white hover:text-[#39A900] rounded transition">Gestión de Usuarios</a>
        <a href="historial" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md transition hover:scale-105">Historial</a>
        
        <hr class="border-white opacity-30">
        
        <?php if (isset($_SESSION["id"])): ?>
            <a href="../Perfi/perfil" class="p-2 hover:bg-white hover:text-[#39A900] rounded transition">
                Bienvenido, <?php echo $_SESSION["nombres"]; ?>
            </a>
        <?php endif; ?>
        
        <a href="../Login/LogoutAction" class="p-2 hover:bg-white hover:text-[#39A900] rounded transition">Cerrar Sesión</a>
    </nav>
</aside>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const closeSidebar = document.getElementById('closeSidebar');

    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });

    if (closeSidebar) {
        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
        });
    }
</script>
