<?php   
    session_start();
    require_once __DIR__ . '../../../../Controller/UserController.php';
    $userController = new UserController();
    $user = $userController->Getuser($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Perfil de Usuario</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <!--Colores personalizados-->
  <script>
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
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col md:flex-row min-h-screen">
  <!-- Botón hamburguesa -->
  <button id="menuBtn" class="md:hidden p-4 absolute z-20 text-senaGreen">
    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
  </button>

  <!-- Sidebar -->
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

  <!-- CONTENIDO PRINCIPAL -->
  <main class="flex-1 mt-16 md:mt-6 md:ml-0 p-4 sm:p-6 transition-all">
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg border p-4 sm:p-6">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b pb-4 gap-4">
        <img src="../../pictures/logoSena.png" alt="Logo SENA" class="w-20 mx-auto sm:mx-0">
        <h2 class="text-2xl font-bold text-senaGreen text-center sm:text-left">Perfil de Usuario</h2>
      </div>

      <!-- Información del Usuario -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <!-- Tarjeta -->
        <div class="bg-gray-50 p-6 rounded-lg shadow text-center">
          <div class="flex flex-col items-center">
            <div class="w-24 h-24 bg-purple-600 text-white text-3xl font-bold flex items-center justify-center rounded-full">
              <?= strtoupper(substr($user['nombres'], 0, 1)) ?>
            </div>
            <h3 class="mt-4 text-xl font-bold"><?= htmlspecialchars($user['nombres'] . ' ' . $user['apellido']) ?></h3>
            <p class="text-green-600 font-semibold"><?= htmlspecialchars($user['rol_id']) ?></p>
            <button onclick="toggleForm()" class="mt-4 bg-senaGreen text-white py-2 px-4 rounded-md hover:bg-senaGreenDark">
              ✏️ Editar perfil
            </button>
          </div>
        </div>

        <!-- Detalles -->
        <div class="bg-gray-50 p-6 rounded-lg shadow md:col-span-2">
          <h4 class="text-lg font-semibold mb-2">Detalles de usuario</h4>
          <p><strong>Correo:</strong> <?= htmlspecialchars($user['correo']) ?></p>
          <p><strong>Documento:</strong> <?= htmlspecialchars($user['documento']) ?></p>
        </div>
      </div>

      <!-- Tarjetas inferiores -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <div class="bg-gray-50 p-6 rounded-lg shadow">
          <h4 class="text-lg font-semibold mb-2">Miscelánea</h4>
          <ul class="text-blue-600 space-y-1">
            <li><a href="#" class="hover:underline">Mis novedades creadas</a></li>
            <li><a href="#" class="hover:underline">Mis novedades pendientes</a></li>
            <li><a href="#" class="hover:underline">Mis novedades en proceso</a></li>
            <li><a href="#" class="hover:underline">Mis novedades cerradas</a></li>
          </ul>
        </div>
        <div class="bg-gray-50 p-6 rounded-lg shadow">
          <h4 class="text-lg font-semibold mb-2">Informes</h4>
          <p><a href="#" class="text-blue-600 hover:underline">Trazabilidad de casos</a></p>
          <p><a href="#" class="text-blue-600 hover:underline">Resumen de novedades</a></p>
        </div>
        <div class="bg-gray-50 p-6 rounded-lg shadow">
          <h4 class="text-lg font-semibold mb-2">Estado de Cuenta</h4>
          <p><strong>Estado:</strong> <?= htmlspecialchars($user['estado']) ?></p>
        </div>
      </div>
    </div>
  </main>

  <!-- MODAL editar perfil -->
  <div id="editForm" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-[90%] sm:w-[500px] max-h-[90vh] overflow-y-auto">
      <h2 class="text-xl font-bold mb-4 text-center text-black">Editar Perfil</h2>
      <form action="UpdateUserAction.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">
        <div class="mb-4">
          <label class="block font-semibold">Nombre</label>
          <input type="text" name="nombres" value="<?= htmlspecialchars($user['nombres']) ?>" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
        </div>
        <div class="mb-4">
          <label class="block font-semibold">Apellido</label>
          <input type="text" name="apellido" value="<?= htmlspecialchars($user['apellido']) ?>" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
        </div>
        <div class="mb-4">
          <label class="block font-semibold">Correo Electrónico</label>
          <input type="email" name="correo" value="<?= htmlspecialchars($user['correo']) ?>" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
        </div>
        <div class="mb-4">
          <label class="block font-semibold">Contraseña actual</label>
          <input type="password" name="password_actual" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
          <label class="block font-semibold mt-2">Nueva contraseña</label>
          <input type="password" name="password_nueva" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
          <label class="block font-semibold mt-2">Confirmar nueva contraseña</label>
          <input type="password" name="confirmar_password" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
        </div>
        <button type="submit" class="w-full bg-senaGreen text-white py-2 px-4 rounded hover:bg-senaGreenDark">Guardar Cambios</button>
        <button type="button" onclick="toggleForm()" class="w-full mt-2 bg-red-500 text-white py-2 px-4 rounded hover:bg-red-700">Cancelar</button>
      </form>
    </div>
  </div>

  <!-- JS para mostrar/ocultar -->
  <script>
    const menuBtn = document.getElementById('menuBtn');
    const closeSidebar = document.getElementById('closeSidebar');
    const sidebar = document.getElementById('sidebar');

    menuBtn.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
    });

    closeSidebar.addEventListener('click', () => {
      sidebar.classList.add('-translate-x-full');
    });

    function toggleForm() {
      document.getElementById("editForm").classList.toggle("hidden");
    }
  </script>

</body>
</html>
