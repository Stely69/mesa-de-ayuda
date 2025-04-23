<?php 
    require_once __DIR__ . '/../Config/database.php';

    class CasoModel{
        private $conn;

        public function __construct(){
            $database = new Database();
            $this->conn = $database->getConnection();
        }

        public function allAmbiente(){
            $query = 'SELECT * FROM ambientes';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getAmbientes($id){
            $query = 'SELECT * FROM ambientes WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id) ;
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getByAmbiente($ambiente_id) {
            try {
                $sql = "SELECT p.* 
                        FROM productos p
                        JOIN ambiente_productos ap ON p.id = ap.producto_id
                        WHERE ap.ambiente_id = ?";
        
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$ambiente_id]); // Pasamos el parámetro en un array
        
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Error en la consulta: " . $e->getMessage());
            }
        }

        public function registrarCaso($ambiente_id, $usuario_id, $producto_id, $estado_id, $asignado_a, $descripcion,$imagen) {
            try {
                $sql = "INSERT INTO casos (ambiente_id, usuario_id, producto_id, estado_id,asignado_a, descripcion,imagen,fecha_creacion) 
                        VALUES (?, ?, ?, ?, ?, ?,?,NOW())";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$ambiente_id, $usuario_id, $producto_id, $estado_id, $asignado_a, $descripcion,$imagen]);
                
                return ["success" => true, "message" => "Caso registrado correctamente en la base de datos"];
            } catch (PDOException $e) {
                return ["error" => true, "message" => $e->getMessage()];
            }
        }
        
        public function allroles(){
            $query = 'SELECT * FROM roles';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }
        
        public function allmarca(){
            $query = 'SELECT * FROM marcas';
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getCasos() {
            $query = '
                SELECT  c.id,
                        a.nombre          AS ambiente,
                        u.nombres         AS usuario,
                        p.numero_placa    AS producto,
                        e.estado   AS estados_casos,
                        c.asignado_a,
                        c.descripcion,
                        c.imagen,
                        c.fecha_creacion
                FROM   casos c
                JOIN   ambientes      a ON c.ambiente_id = a.id
                JOIN   usuarios       u ON c.instructor_id  = u.id
                JOIN   productos      p ON c.producto_id = p.id
                JOIN   estados_casos  e ON c.estado_id   = e.id';
        
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function contarCasos() {
            $stmt = $this->conn->prepare("SELECT COUNT(*) AS total FROM casos");
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'];
        }

        public function getCaso($id) {
            $query = 'SELECT * FROM casos WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        

        public function CreateCasoGeneral($ambiente_id,$asunto,$descripcion,$estado_id,$instructor_id,$area_asignada,$asignado_a) {
            try {   
                $query = 'INSERT INTO casos_generales (ambiente_id, asunto, descripcion, estado_id, instructor_id, area_asignada, asignado_a, fecha_creacion)
                VALUES (?, ?, ?, ?, ?, ?, ?,now())';
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$ambiente_id, $asunto, $descripcion, $estado_id, $instructor_id, $area_asignada, $asignado_a]);
                
            } catch (PDOException $e) {
                return false; // Error al registrar el caso
            }
        }

        public function getUser($id) {
            $query = "SELECT * FROM usuarios WHERE id = :id";
            $stmt = $this->conn->prepare($query);   
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getCorreosTics() {
            $query = "SELECT correo FROM users WHERE rol_id = (SELECT id FROM roles WHERE nombre = 'Tics')";
            $stmt = $this->conn->query($query);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        public function getCasosGeneral() {
            $query = "
                SELECT  cg.id,
                        cg.asunto,
                        cg.descripcion,
                        cg.fecha_creacion,                         -- si tu campo se llama distinto, cámbialo
                        a.nombre          AS ambiente,
                        e.estado   AS estado,
                        iu.nombres        AS instructor,
                        au.nombres        AS asignado_a
                FROM   casos_generales cg
                JOIN   ambientes       a  ON cg.ambiente_id   = a.id
                JOIN   estados_casos       e  ON cg.estado_id     = e.id
                JOIN   usuarios          iu ON cg.instructor_id = iu.id
                LEFT JOIN usuarios       au ON cg.asignado_a    = au.id
                ORDER BY cg.fecha_creacion DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getCasoGeneral($id) {
            $query = 'SELECT * FROM casos_generales WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

