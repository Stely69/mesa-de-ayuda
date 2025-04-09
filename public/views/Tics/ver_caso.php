<?php
require_once __DIR__ . '../../../../Controller/CasoController.php';
session_start();

$casoController = new CasoController();
$casoId = isset($_GET['id']) ? $_GET['id'] : null;
$caso = $casoController->getCaso($casoId); // Este método debe existir

if (!$caso) {
    echo "Caso no encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Detalle del Caso</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-xl p-6">
    <h1 class="text-2xl font-bold text-[#39A900] mb-4">Detalle del Caso</h1>
    
    <dl class="space-y-3 text-gray-700">
      <div>
        <dt class="font-semibold">Producto:</dt>
        <dd><?= htmlspecialchars($caso['producto_id']) ?></dd>
      </div>
      <div>
        <dt class="font-semibold">Ambiente:</dt>
        <dd><?= htmlspecialchars($caso['ambiente_id']) ?></dd>
      </div>
      <div>
        <dt class="font-semibold">Descripción:</dt>
        <dd><?= htmlspecialchars($caso['descripcion']) ?></dd>
      </div>
      <div>
        <dt class="font-semibold">Estado:</dt>
        <dd>
        <?= htmlspecialchars($caso['estado_id']) ?>
        </dd>
        <dt class="font-semibold">Resolver caso:</dt>
        <dd>
        <?php if ($caso['estado_id'] != 2): ?>
            <form method="POST" class="mt-6 space-y-4">
                <textarea name="nota_tecnica" rows="4" required placeholder="Describe cómo se resolvió el problema" class="w-full p-3 border border-gray-300 rounded-md"></textarea>
                
                <button type="submit" name="resolver" class="px-6 py-2 bg-[#39A900] text-white rounded hover:bg-green-700">Marcar como resuelto</button>
            </form>
        <?php else: ?>
            <div class="mt-6 p-4 bg-green-100 text-green-700 rounded space-y-2">
                <div><strong>Estado:</strong> Resuelto</div>
                <div><strong>Resolución:</strong> <?= htmlspecialchars($caso['nota_tecnica'] ?? 'Sin nota técnica') ?></div>
                <div><strong>Resuelto por:</strong> <?= htmlspecialchars($caso['resuelto_por'] ?? 'Desconocido') ?></div>
            </div>
        <?php endif; ?>
        </dd>
      </div>
      <div>
        <dt class="font-semibold">Fecha de creación:</dt>
        <dd><?= htmlspecialchars($caso['fecha_creacion']) ?></dd>
      </div>
      <div>
        <dt class="font-semibold">Fecha de resolución:</dt>
        <dd><?= !empty($caso['fecha_resolucion']) ? htmlspecialchars($caso['fecha_resolucion']) : 'No resuelto aún' ?></dd>
      </div>
      <!-- Puedes añadir más campos aquí -->
    </dl>

    <a href="Tics" class="inline-block mt-6 px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Volver</a>
  </div>
</body>
</html>
