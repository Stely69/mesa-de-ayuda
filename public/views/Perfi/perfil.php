<?php   
    session_start();
    require_once __DIR__ . '/../../../Controller/UserController.php';
    $userController = new UserController();
    $user = $userController->Getuser($_SESSION['id']);

    // Obtener mensajes de alerta
    $alert = isset($_GET['alert']) ? $_GET['alert'] : null;
    $mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : null;
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
            senaGreen: '#007832',
            senaGreenDark: '#00304D',
          }
        }
      }
    }
  </script>
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col md:flex-row min-h-screen">
  <?php
    // Definir la ruta base según el rol
    $base_path = '';
    $rol_id = $user['rol_id'];
    
    switch($rol_id) {
        case 1: // Administrador
            $base_path = 'admin';
            include __DIR__ . '/../Admin/barra.php';
            break;
        case 2: // Instructor
            $base_path = 'instr';
            include __DIR__ . '/../Instr/barra.php';
            break;
        case 3: // Tics
            $base_path = 'tics';
            include __DIR__ . '/../Tics/barra.php';
            break;
        case 4: // Almacen
            $base_path = 'almacen';
            include __DIR__ . '/../Almn/barra.php';
            break;
        case 5: // Auxiliar Tics
            $base_path = 'tics';
            include __DIR__ . '/../Tics/barra.php';
            break;
        default:
            // Si no hay rol definido, no se incluye ninguna barra
            break;
    }
  ?>

  <!-- CONTENIDO PRINCIPAL -->
  <main class="flex-1 mt-16 md:mt-6 md:ml-64 p-4 sm:p-6 transition-all">
    <?php if ($alert && $mensaje): ?>
    <div class="max-w-6xl mx-auto mb-4">
      <div class="p-4 rounded-lg <?= $alert === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
        <?= htmlspecialchars($mensaje) ?>
      </div>
    </div>
    <?php endif; ?>

    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg border p-4 sm:p-6">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b pb-4 gap-4">
        <img src="../../pictures/logoSena.png" alt="Logo SENA" class="w-20 mx-auto sm:mx-0">
        <h2 class="text-2xl font-bold text-senaGreen text-center sm:text-left">Perfil de Usuario</h2>
      </div>

      <!-- Información del Usuario -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <!-- Tarjeta -->
        <div class="bg-white p-8 rounded-2xl shadow-lg text-center border border-gray-100">
          <div class="flex flex-col items-center">
            <div class="w-32 h-32 bg-senaGreen text-white text-4xl font-bold flex items-center justify-center rounded-full shadow-md">
              <?= strtoupper(substr($user['nombres'], 0, 1)) ?>
            </div>
            <h3 class="mt-6 text-2xl font-bold text-gray-800"><?= htmlspecialchars($user['nombres'] . ' ' . $user['apellido']) ?></h3>
            <p class="text-senaGreen font-semibold text-lg mt-2"><?= htmlspecialchars($user['rol_id']) ?></p>
            <button onclick="toggleForm()" class="mt-6 bg-senaGreen text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl hover:bg-senaGreenDark transition-all duration-300 transform hover:-translate-y-1 text-lg font-semibold w-full">
              ✏️ Editar perfil
            </button>
          </div>
        </div>

        <!-- Detalles -->
        <div class="bg-white p-8 rounded-2xl shadow-lg md:col-span-2 border border-gray-100">
          <h4 class="text-2xl font-bold mb-6 text-gray-800">Detalles de usuario</h4>
          <div class="space-y-4">
            <div class="flex items-center space-x-4">
              <svg class="w-6 h-6 text-senaGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              <div>
                <p class="text-sm text-gray-500">Correo electrónico</p>
                <p class="text-lg font-semibold"><?= htmlspecialchars($user['correo']) ?></p>
              </div>
            </div>
            <div class="flex items-center space-x-4">
              <svg class="w-6 h-6 text-senaGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
              </svg>
              <div>
                <p class="text-sm text-gray-500">Documento</p>
                <p class="text-lg font-semibold"><?= htmlspecialchars($user['documento']) ?></p>
              </div>
            </div>
            <div class="flex items-center space-x-4">
              <svg class="w-6 h-6 text-senaGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <div>
                <p class="text-sm text-gray-500">Estado de cuenta</p>
                <p class="text-lg font-semibold"><?= htmlspecialchars($user['estado']) ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- MODAL editar perfil -->
  <div id="editForm" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-[90%] sm:w-[500px] max-h-[90vh] overflow-y-auto">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Editar Perfil</h2>
        <button onclick="toggleForm()" class="text-gray-500 hover:text-gray-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
      <form action="UpdateUserActionPerfil" method="POST" class="space-y-6">
        <input type="hidden" name="id" value="<?= openssl_encrypt($user['id'], AES, key) ?>">
        <input type="hidden" name="hiddenCorreo" value="<?= htmlspecialchars($user['correo']) ?>">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Nombre</label>
          <input type="text" name="nombres" value="<?= htmlspecialchars($user['nombres']) ?>" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-senaGreen focus:border-transparent transition-all duration-300">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Apellido</label>
          <input type="text" name="apellido" value="<?= htmlspecialchars($user['apellido']) ?>" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-senaGreen focus:border-transparent transition-all duration-300">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
          <input type="email" name="correo" value="<?= htmlspecialchars($user['correo']) ?>" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-senaGreen focus:border-transparent transition-all duration-300">
        </div>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña actual</label>
            <input type="password" name="password_actual" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-senaGreen focus:border-transparent transition-all duration-300">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nueva contraseña</label>
            <input type="password" name="password_nueva" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-senaGreen focus:border-transparent transition-all duration-300">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar nueva contraseña</label>
            <input type="password" name="confirmar_password" class="w-full p-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-senaGreen focus:border-transparent transition-all duration-300">
          </div>
        </div>
        <div class="flex space-x-4">
          <button type="submit" class="flex-1 bg-senaGreen text-white py-5 px-6 rounded-2xl shadow-md hover:shadow-xl hover:bg-senaGreenDark transition-all duration-300 transform hover:-translate-y-1 text-lg font-semibold">
            Guardar Cambios
          </button>
          <button type="button" onclick="toggleForm()" class="flex-1 bg-gray-200 text-gray-700 py-5 px-6 rounded-2xl shadow-md hover:shadow-xl hover:bg-gray-300 transition-all duration-300 transform hover:-translate-y-1 text-lg font-semibold">
            Cancelar
          </button>
        </div>
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
