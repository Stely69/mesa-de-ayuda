<?php 
    namespace Controller;
    // use Controller\CasoController;
    use \CasoController;
    use PhpOffice\PhpSpreadsheet\IOFactory;

    class InicioControlador extends Controlador {
        // Método para cargar la vista de inicio
        public function inicio() {
            $this->cargarVista("inicio");
        }

        public function admin() {
            $this->cargarVista("Admin/Admin");
        }

        public function Login() {
            $this->cargarVista("Login/inicio_sesion");
        }

        public function Loginaction() {
            $this->cargarVista("Login/LoginAction");
        }

        public function Logout() {
            $this->cargarVista("Login/Logoutaction");
        }

        public function instructor () {
            $this->cargarVista("Instr/instructores");
        }

        public function getambientes() {
            $this->cargarVista("Instr/GetAmbienteAction");
        }

        public function registrarCaso() {
            $this->cargarVista("Instr/ReportarFallaAction");
        }

        public function historialcasos() {
            $this->cargarVista("Instr/Historialinstructores");
        }
        public function registarcasogeneral() {
            $this->cargarVista("Instr/RegistarCasoGeneral");
        }

        public function registrarcasogeneralaction() {
            $this->cargarVista("Instr/CasoGeneralAction");
        }

        public function historialinstructores() {
            $this->cargarVista("Instr/Historialinstructores");
        }

        public function InicioInstr() {
            $this->cargarVista("Instr/InicioInst");
        }

        public function gestiondeusuarios() {
            $this->cargarVista("Admin/GestiondeUsuarios");
        }

        public function createaction() {
            $this->cargarVista("Admin/RegistroAction");
        }

        public function updateaction() {
            $this->cargarVista("Admin/UpdateAction");
        }

        public function statusaction() {
            $this->cargarVista("Admin/UpdateStatus");
        }

        public function deleteaction() {
            $this->cargarVista("Admin/DeleteAction");
        }

        public function historialadmin(){
            $this->cargarVista("Admin/HistorialAdmin");
        }

        public function recuperar() {
            $this->cargarVista("Login/recuperar");
        }

        public function recuperaraction() {
            $this->cargarVista("Login/RecuperarAction");
        }

        public function recuperarcontrasena() {
            $this->cargarVista("Login/RecuperarContrasena");
        }
        public function recuperarcontraseñaction() {
            $this->cargarVista("Login/RecuperarContraseñaAction");
        }
        public function updatepassword() {
            $this->cargarVista("Login/UpdatePasswordAction");
        }

        public function alm(){
            $this->cargarVista("Almn/Almacen");
        }

        public function almacenhistrorial(){
            $this->cargarVista("Almn/historial");
        }
        

        public function almaceninventario(){
            $this->cargarVista("Almn/inventario");
        }

        public function almacenreportes(){
            $this->cargarVista("Almn/reportes");
        }

        public function addproducto(){
            $this->cargarVista("Almn/AddProducto");
        }

        public function addAction(){
            $this->cargarVista("Almn/AddAction");
        }

        public function tics(){
            $this->cargarVista("Tics/Tics");
        }

        public function ticspendientes(){
            $this->cargarVista("Tics/pendientes");
        }

        public function ver_caso(){
            $this->cargarVista("Tics/ver_caso");
        }

        public function ver_casog(){
            $this->cargarVista("Tics/ver_casoG");
        }

        public function gestiondeauxiliares(){
            $this->cargarVista("Tics/GestiondeAuxiliares");
        }

        public function deleteactionA(){
            $this->cargarVista("Tics/DeleteActionA");
        }

        public function updateactionA(){
            $this->cargarVista("Tics/UpdateStatusA");
        }

        public function createactionG(){
            $this->cargarVista("Tics/RegistroActionG");
        }

        public function updatestatusa(){
            $this->cargarVista("Tics/UpdatestatusAction");
        }

        public function editarauxiliar(){
            $this->cargarVista("Tics/EditarUsuarioAuxiliar");
        }

        public function asignarauxiliar(){
            $this->cargarVista("Tics/AsignarCasoActionG");
        }

        public function perfil(){
            $this->cargarVista("Perfi/perfil");
        }

        public function updateUser(){
            $this->cargarVista("Perfi/UpdateUserAction");
        }

        public function updateUserPerfil(){
            $this->cargarVista("Perfi/UpdateUserActionPerfil");
        }

        public function actualizarEstadoCasoAlmacen() {
            header('Content-Type: application/json');
            session_start();
            require_once __DIR__ . '/CasoController.php';
            $casoController = new \CasoController();
            $usuario_id = $_SESSION['id'] ?? 1;
            // Log temporal para depuración
            file_put_contents(__DIR__ . '/debug_post_almacen.txt', print_r($_POST, true));
            if (
                $_SERVER['REQUEST_METHOD'] === 'POST' &&
                isset($_POST['caso_id'], $_POST['estado'])
            ) {
                $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : '';
                $resultado = $casoController->updateCasoAlmacenStatus(
                    $_POST['caso_id'],
                    $_POST['estado'],
                    $usuario_id,
                    $comentario
                );
                echo json_encode($resultado);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Solicitud inválida.'
                ]);
            }
            exit;
        }

        public function eliminarCasoAlmacen() {
            header('Content-Type: application/json');
            require_once __DIR__ . '/CasoController.php';
            $casoController = new \CasoController();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['caso_id'])) {
                $resultado = $casoController->eliminarCasoPorId($_POST['caso_id']);
                echo json_encode($resultado);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Solicitud inválida.'
                ]);
            }
            exit;
        }

        public function eliminarBienAction() {
            require_once __DIR__ . '/../models/ProductosAModel.php';
            $productosModel = new \ProductosAModel();
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_bien_id'])) {
                $id = $_POST['eliminar_bien_id'];
                $productosModel->deleteProductosA($id);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Solicitud inválida.']);
            }
            exit;
        }

        public function editarBienAction() {
            require_once __DIR__ . '/../models/ProductosAModel.php';
            $productosModel = new \ProductosAModel();
            header('Content-Type: application/json');
            if (
                $_SERVER['REQUEST_METHOD'] === 'POST' &&
                isset(
                    $_POST['editar_bien_id'],
                    $_POST['editar_descripcion'],
                    $_POST['editar_modelo'],
                    $_POST['editar_numero_placa'],
                    $_POST['editar_serial'],
                    $_POST['editar_ambiente'],
                    $_POST['editar_clase_id']
                )
            ) {
                $productosModel->updateProductosA(
                    $_POST['editar_bien_id'],
                    $_POST['editar_descripcion'],
                    $_POST['editar_modelo'],
                    $_POST['editar_numero_placa'],
                    $_POST['editar_serial'],
                    $_POST['editar_ambiente'],
                    $_POST['editar_clase_id']
                );
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Solicitud inválida.']);
            }
            exit;
        }

        public function cargarBienesExcelAction() {
            require_once __DIR__ . '/../models/ProductosAModel.php';
            $productosModel = new \ProductosAModel();
            $errores = [];
            $agregados = 0;

            if (isset($_FILES['archivo_excel']) && $_FILES['archivo_excel']['error'] === UPLOAD_ERR_OK) {
                $archivoTmp = $_FILES['archivo_excel']['tmp_name'];
                if (($handle = fopen($archivoTmp, "r")) !== FALSE) {
                    // Detectar delimitador (coma o punto y coma)
                    $firstLine = fgets($handle);
                    $delimiter = (strpos($firstLine, ";") !== false) ? ";" : ",";
                    rewind($handle);
                    $encabezados = fgetcsv($handle, 0, $delimiter); // Leer la primera fila (encabezados)
                    while (($fila = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
                        if (count($fila) < 6) continue;
                        list($ambiente, $clase, $numero_placa, $serial, $modelo, $descripcion) = $fila;
                        try {
                            $ambiente_id = $productosModel->getAmbienteIdPorNombre($ambiente);
                            $clase_id = $productosModel->getClaseIdPorNombre($clase);
                            if (!$ambiente_id || !$clase_id) throw new Exception('Ambiente o clase no válido');
                            $productosModel->crearProductosA($numero_placa, $serial, $descripcion, $modelo, $clase_id, $ambiente_id);
                            $agregados++;
                        } catch (Exception $e) {
                            $errores[] = "Fila: " . implode(", ", $fila) . " - " . $e->getMessage();
                        }
                    }
                    fclose($handle);
                }
                $msg = "Bienes agregados: $agregados.";
                if ($errores) $msg .= " Errores: " . implode(' | ', $errores);
                header('Location: inventario?status=success&message=' . urlencode($msg));
                exit;
            } else {
                header('Location: inventario?status=error&message=Error+al+cargar+el+archivo');
                exit;
            }
        }

        public function consultaCasoAjax() {
            header('Content-Type: application/json; charset=utf-8');
            $tipo = $_GET['tipo'] ?? '';
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            require_once __DIR__ . '/CasoController.php';
            $casos = new \CasoController();

            if (!$tipo || !$id) {
                echo json_encode(['error' => 'Parámetros inválidos.']);
                exit;
            }

            if ($tipo === 'normal') {
                $caso = $casos->getCasoPorIdConHistorial($id);
                if (!$caso) {
                    echo json_encode(['error' => 'No se encontró el caso normal con ese ID.']);
                    exit;
                }
                echo json_encode($caso);
                exit;
            } elseif ($tipo === 'general') {
                $caso = $casos->getCasoGeneralPorIdConHistorial($id);
                if (!$caso) {
                    echo json_encode(['error' => 'No se encontró el caso general con ese ID.']);
                    exit;
                }
                echo json_encode($caso);
                exit;
            } else {
                echo json_encode(['error' => 'Tipo de caso inválido.']);
                exit;
            }
        }

        public function verCasoAlmacen() {
            $this->cargarVista("Almn/Ver_Casos_Almn");
        }
    }