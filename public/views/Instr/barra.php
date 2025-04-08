        <!-- Barra lateral fija -->
        <aside id="sidebar" class="bg-senaGreen text-white w-64 p-6 space-y-4 fixed inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40 md:relative md:block">
            <div class="flex justify-end md:hidden -mt-4 -mr-4">
            <button id="closeSidebar" class="text-white p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            </div>
            <h1 class="text-2xl font-bold mb-6">Admin SENA</h1>
            <nav class="flex flex-col space-y-3">
            <a href="../" class="p-2 hover:bg-white hover:text-senaGreen rounded">Inicio</a>
            <a href="#" class="p-2 bg-white text-senaGreen rounded">Dashboard</a>
            <a href="GestiondeUsuarios" class="p-2 hover:bg-white hover:text-senaGreen rounded">Gestión de Usuarios</a>
            <hr class="border-white opacity-30">
            <?php if (isset($_SESSION["id"])): ?>
                <a href="../Perfi/perfil" class="p-2 hover:bg-white hover:text-senaGreen rounded">Bienvenido, <?php echo $_SESSION["nombres"]; ?></a>
            <?php endif; ?>
            <a href="../Login/LogoutAction" class="p-2 hover:bg-white hover:text-senaGreen rounded">Cerrar Sesión</a>
            </nav>
        </aside>

        <script>
            // Mostrar barra lateral en pantallas pequeñas
            const sidebar = document.getElementById('sidebar');
            const closeSidebarButton = document.getElementById('closeSidebar');

            closeSidebarButton.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Mostrar barra lateral al hacer clic en el botón de menú (hamburguesa)
            const menuButton = document.getElementById('menuButton');
            menuButton.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        </script>

        <script>
            <!--Colores personalizados-->
            tailwind.config = {
            theme: {
                extend: {
                colors: {
                    senaGreen: '#39A900',
                    senaGreenDark: '#2f8800',
                }
                }
            }
            }
        </script>