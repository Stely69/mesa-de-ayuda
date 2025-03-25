        <!-- Barra lateral fija -->
        <aside class="w-64 bg-[#39A900] text-white flex flex-col p-4 fixed h-screen">
            <h1 class="text-2xl font-bold mb-6">Operaciones</h1>
            <nav class="flex flex-col space-y-4">
                <!-- Botón de inicio con ícono -->
                <a href="Almacen" class="nav-link p-2 bg-white text-[#39A900] rounded-md flex items-center space-x-2">
                    <!-- Ícono de casa (inicio) -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9z"></path>
                    </svg>
                    <span>Inicio</span>
                </a>
                <a href="inventario" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md">Inventario</a>
                <a href="casos" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md">Panel de Casos</a>
                <a href="historial" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md">Historial</a>
                <hr>
                <?php session_start(); ?>
                <?php if (isset($_SESSION["id"])): ?>
                    <a href="#" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md">Bienvenido, <?php echo $_SESSION["nombres"]; ?></a>
                <?php endif; ?>
                <a href="../Login/LogoutAction" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md">Cerrar Session</a>
            </nav>
        </aside>