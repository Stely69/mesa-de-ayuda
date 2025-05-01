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
                $sql = "INSERT INTO casos (ambiente_id,instructor_id, producto_id, estado_id,asignado_a, descripcion,imagen,fecha_creacion) 
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
            $sql = "
                SELECT  c.id,
                        c.descripcion,
                        c.fecha_creacion,
                        a.nombre        AS ambiente,
                        p.numero_placa  AS producto,
                        e.estado        AS estado,
                        e.id            AS estado_id, 
                        ui.nombres      AS instructor,
                        ua.nombres      AS asignado_a,
                        c.imagen,
                        COALESCE(ux.nombres, 'No asignado') AS auxiliar
                FROM   casos c
                JOIN   ambientes       a  ON c.ambiente_id = a.id
                JOIN   productos       p  ON c.producto_id = p.id
                JOIN   estados_casos   e  ON c.estado_id   = e.id
                JOIN   usuarios        ui  ON c.instructor_id  = ui.id
                LEFT  JOIN usuarios    ux  ON c.auxiliar_id = ux.id
                LEFT  JOIN usuarios    ua  ON c.asignado_a  = ua.id
                WHERE  c.id = :id
                LIMIT  1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function CreateCasoGeneral($ambiente_id,$asunto,$descripcion,$estado_id,$instructor_id,$area_asignada,$asignado_a) {
            try {   
                $query = 'INSERT INTO casos_generales (ambiente_id, asunto, descripcion, estado_id, instructor_id, area_asignada, asignado_a, fecha_creacion)
                VALUES (?, ?, ?, ?, ?, ?, ?,now(),null)';
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
            $query = "SELECT correo FROM usuarios WHERE rol_id = (SELECT id FROM roles WHERE nombre = 'Tics')";
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
            $sql = "
                SELECT  cg.id,
                        cg.asunto,
                        cg.descripcion,
                        cg.fecha_creacion,                              -- ajusta si tu columna se llama distinto
                        a.nombre           AS ambiente,
                        e.id               AS estado_id,       -- id del estado
                        e.estado   AS estado,          -- nombre legible del estado
                        iu.nombres         AS instructor,      -- quien reporta
                        au.nombres         AS asignado_a       -- responsable (puede ser NULL)
                FROM   casos_generales cg
                JOIN   ambientes       a  ON cg.ambiente_id   = a.id
                JOIN   estados_casos        e  ON cg.estado_id     = e.id
                JOIN   usuarios          iu ON cg.instructor_id = iu.id
                LEFT  JOIN usuarios       au ON cg.asignado_a    = au.id
                WHERE  cg.id = :id
                LIMIT  1";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        

        public function updateCasoStatus($id, $estado_id, $asignado_a) {
            $query = "UPDATE casos SET estado_id = :estado_id, auxiliar_id = :auxiliar_id WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':estado_id', $estado_id);
            $stmt->bindParam(':auxiliar_id', $asignado_a);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        }

        public function updateCasoGeneralStatus($id, $estado_id) {
            try {
            $query = "UPDATE casos_generales SET estado_id = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$estado_id, $id]);
            return ["success" => true, "message" => "Estado del caso general actualizado correctamente"];
            } catch (PDOException $e) {
            return ["error" => true, "message" => $e->getMessage()];
            }
        }

        public function asignacionCaso($id, $asignado_a) {
            try {
                $query = "UPDATE casos SET asignado_a = ? WHERE id = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$asignado_a, $id]);
                return ["success" => true, "message" => "Caso asignado correctamente"];
            } catch (PDOException $e) {
                return ["error" => true, "message" => $e->getMessage()];
            }
        }

        public function asingacionCasoGeneral($id, $asignado_a) {
            try {
                $query = "UPDATE casos_generales SET asignado_a = ? WHERE id = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$asignado_a, $id]);
                return ["success" => true, "message" => "Caso general asignado correctamente"];
            } catch (PDOException $e) {
                return ["error" => true, "message" => $e->getMessage()];
            }
        }

        public function historialCaso($id) {
            $query = "
                SELECT  h.fecha_actualizacion,
                        e.estado AS estado_anterior,
                        e2.estado AS estado_nuevo,
                        h.observaciones,
                        u.nombres AS usuario_id
                FROM   historial_casos h
                JOIN   estados_casos e ON h.estado_anterior = e.id
                JOIN   estados_casos e2 ON h.estado_nuevo = e2.id
                JOIN   usuarios u ON h.usuario_id = u.id
                WHERE  h.caso_id = :id
                ORDER BY h.fecha_actualizacion DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function Createhistorial($caso_id, $estado_anterior, $estado_nuevo, $observaciones, $usuario_id) {
            try {
                $query = 'INSERT INTO historial_casos (caso_id, estado_anterior, estado_nuevo, observaciones, usuario_id, fecha_actualizacion)
                VALUES (?, ?, ?, ?, ?, now())';
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$caso_id, $estado_anterior, $estado_nuevo, $observaciones, $usuario_id]);
                
            } catch (PDOException $e) {
                return false; // Error al registrar el caso
            }
        }

        public function registrarHistorial($caso_id, $estado_anterior_id, $estado_nuevo_id, $observaciones, $usuario_id, $tipo_caso = 'caso_general') {
            $query = 'INSERT INTO historial_casos (caso_id, estado_anterior_id, estado_nuevo_id, observaciones, usuario_id, tipo_caso) 
                      VALUES (:caso_id, :estado_anterior_id, :estado_nuevo_id, :observaciones, :usuario_id, :tipo_caso)';
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':caso_id', $caso_id, PDO::PARAM_INT);
            $stmt->bindParam(':estado_anterior_id', $estado_anterior_id, PDO::PARAM_INT);
            $stmt->bindParam(':estado_nuevo_id', $estado_nuevo_id, PDO::PARAM_INT);
            $stmt->bindParam(':observaciones', $observaciones, PDO::PARAM_STR);
            $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindParam(':tipo_caso', $tipo_caso, PDO::PARAM_STR);
        
            return $stmt->execute();
        }

        public function getcasoestado($id){
            $query = 'SELECT estado_id FROM casos WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id) ;
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        
    }

