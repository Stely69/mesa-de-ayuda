<?php
    require_once __DIR__ . '/../Models/ProductosAModel.php';
    class ProductoController {

        private $conn;

        public function __construct() {
            $this->conn = new ProductosAModel();
        }

        public function guardarProducto($numero_placa, $serial, $descripcion, $modelo,$clase_id, $ambiente_id,) {
            if (!$this->conn->crearProductosA($numero_placa, $serial, $descripcion, $modelo, $clase_id,$ambiente_id)) {
                header("Location: inventario?controller=Producto&action=productoAgregado");
                exit();
            } else {

                header("Location: inventario?controller=Producto&action=productoNoAgregado");
                exit();
            }
        }

        public function updateBienes($numero_placa, $serial, $descripcion, $modelo, $ambiente_id) {
            if (!$this->conn->updateBienes($numero_placa, $serial, $descripcion, $modelo, $ambiente_id)) {
                header("Location: ");
                exit();
            } else {
                header("");
                exit();
            }
        }

        public function deleteBienes($id) {
            if (!$this->conn->deleteBienes($id)) {
                header("Location: ");
                exit();
            } else {
                header("");
                exit();
            }
        }

        public function getClase() {
            return $this->conn->getClase();
        }

        public function mostrarProductos() {
            return $this->conn->contarProductos();
        }
    }
?>
