<?php
    require_once __DIR__ . '/../Models/ProductosAModel.php';
    class ProductoController {

        private $conn;

        public function __construct() {
            $this->conn = new ProductosAModel();
        }

        public function guardarProducto($numero_placa, $serial, $descripcion, $modelo, $ambiente_id) {
            if (!$this->conn->crearProductosA($numero_placa, $serial, $descripcion, $modelo, $ambiente_id)) {
                header("Location: AddProducto?controller=Producto&action=productoNoAgregado");
                exit();
            } else {

                header("Location: AddProducto?controller=Producto&action=productoAgregado");
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

        public function getBienes($id) {
            return $this->conn->getBienes($id);
        }

    }
?>
