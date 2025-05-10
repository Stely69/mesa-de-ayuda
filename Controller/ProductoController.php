<?php
    require_once __DIR__ . '/../Models/ProductosAModel.php';
    class ProductoController {

        private $conn;

        public function __construct() {
            $this->conn = new ProductosAModel();
        }

        public function guardarProducto($numero_placa, $serial, $descripcion, $modelo, $clase_id, $ambiente_id) {
            try {
                $this->conn->crearProductosA($numero_placa, $serial, $descripcion, $modelo, $clase_id, $ambiente_id);
                header("Location: inventario?status=success&message=Producto+agregado+correctamente");
                exit();
            } catch (Exception $e) {
                header("Location: inventario?status=error&message=" . urlencode('Error al agregar: ' . $e->getMessage()));
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
            if (!$this->conn->deleteProductosA($id)) {
                header("Location: inventario?status=error&message=No+se+pudo+eliminar");
                exit();
            } else {
                header("Location: inventario?status=success&message=Bien+eliminado+correctamente");
                exit();
            }
        }

        public function getClase() {
            return $this->conn->getClase();
        }

        public function mostrarProductos() {
            return $this->conn->contarProductos();
        }

        public function getAllProductos() {
            return $this->conn->getAllProductos();
        }

        public function getProductosByPlaca($placa) {
            return $this->conn->getProductosByPlaca($placa);
        }

        public function getProductosByNombreAmbiente($nombre_ambiente) {
            return $this->conn->getProductosByNombreAmbiente($nombre_ambiente);
        }

        public function getProductosByAmbiente($ambiente_id) {
            return $this->conn->getProductosByAmbiente($ambiente_id);
        }

        public function updateProductosA($id, $descripcion, $modelo, $numero_placa, $serial, $ambiente_id, $clase_id) {
            return $this->conn->updateProductosA($id, $descripcion, $modelo, $numero_placa, $serial, $ambiente_id, $clase_id);
        }
    }
?>
