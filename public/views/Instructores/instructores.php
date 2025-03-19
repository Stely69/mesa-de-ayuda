<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Inventario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-[#39A900]">Administrar Inventario por Ambiente</h1>
        <a href="Almacen.php" class="bg-blue-500 text-white px-4 py-2 rounded-md">Inicio</a>
    </header>
    
    <div class="flex">
        <!-- Barra lateral fija -->
        <aside class="w-64 bg-[#39A900] text-white flex flex-col p-4 fixed h-screen">
            <h1 class="text-2xl font-bold mb-6">Operaciones</h1>
            <nav class="flex flex-col space-y-4">
                <a href="inventario.php" class="nav-link p-2 bg-white text-[#39A900] rounded-md">Inventario</a>
                <a href="historial.php" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md">Historial</a>
                <a href="reportes.php" class="nav-link p-2 hover:bg-white hover:text-[#39A900] rounded-md">Reportes</a>
            </nav>
        </aside>
        
        <!-- Contenido principal con margen izquierdo -->
        <main class="flex-1 p-6 ml-64 overflow-auto">
            <div class="mb-4">
                <label for="ambiente" class="block text-gray-700 font-bold mb-2">Selecciona un ambiente:</label>
                <select id="ambiente" class="p-2 border rounded-md">
                    <option value="">-- Seleccionar --</option>
                    <option value="101">Ambiente 101</option>
                    <option value="102">Ambiente 102</option>
                    <option value="103">Ambiente 103</option>
                    <option value="104">Ambiente 104</option>
                    <option value="105">Ambiente 105</option>
                    <option value="106">Ambiente 106</option>
                    <option value="107">Ambiente 107</option>
                    <option value="108">Ambiente 108</option>
                    <option value="109">Ambiente 109</option>
                    <option value="110">Ambiente 110</option>
                </select>
            </div>
            
            <div id="inventario" class="bg-white p-6 rounded-md shadow hidden">
                <h2 class="text-2xl font-semibold text-[#39A900] mb-4">Inventario del Ambiente <span id="num-ambiente"></span></h2>
                <div id="lista-inventario" class="grid grid-cols-3 gap-4"></div>
                <button class="mt-4 bg-green-500 text-white px-4 py-2 rounded-md">Inventario General del Ambiente</button>
            </div>
        </main>
    </div>
    
    <script>
        document.getElementById("ambiente").addEventListener("change", function() {
            const ambienteSeleccionado = this.value;
            const inventarioDiv = document.getElementById("inventario");
            const listaInventario = document.getElementById("lista-inventario");
            const numAmbiente = document.getElementById("num-ambiente");

            if (ambienteSeleccionado) {
                numAmbiente.textContent = ambienteSeleccionado;
                listaInventario.innerHTML = "";
                
                // Elementos posibles en cada ambiente
                const elementos = ["Pantallas", "Escritorios", "Mouse", "Teclado", "Videobeam", "Sillas", "Televisores", "Tablero"];
                
                elementos.forEach(item => {
                    const cantidad = Math.floor(Math.random() * 10) + 1; // Cantidad aleatoria entre 1 y 10
                    const card = document.createElement("div");
                    card.className = "bg-gray-200 p-4 rounded-md shadow text-center";
                    card.innerHTML = `
                        <h3 class="text-lg font-semibold text-gray-700">${item}</h3>
                        <p class="text-gray-600">Cantidad: ${cantidad}</p>
                        <button class="mt-2 bg-blue-500 text-white px-4 py-2 rounded-md">Ver Todo</button>
                    `;
                    listaInventario.appendChild(card);
                });
                
                inventarioDiv.classList.remove("hidden");
            } else {
                inventarioDiv.classList.add("hidden");
            }
        });
    </script>
</body>
</html>
