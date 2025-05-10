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
                $sql = "SELECT p.*, cp.nombre AS clase_nombre 
                        FROM productos p
                        JOIN ambiente_productos ap ON p.id = ap.producto_id
                        JOIN clases_producto cp ON p.clase_id = cp.id
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
                $resultado = $stmt->execute([$ambiente_id, $usuario_id, $producto_id, $estado_id, $asignado_a, $descripcion,$imagen]);
                
                if ($resultado) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                error_log("Error al registrar caso: " . $e->getMessage());
                return false;
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
                        u.nombres         AS reportado_por,
                        cp.nombre         AS clase_equipo,
                        e.estado   AS estados_casos,
                        c.asignado_a,
                        c.descripcion,
                        c.imagen,
                        c.fecha_creacion,
                        CASE 
                            WHEN c.estado_id = 1 THEN "No asignado"
                            ELSE COALESCE(ua.nombres, "No asignado")
                        END AS nombre_asignado
                FROM   casos c
                JOIN   ambientes      a ON c.ambiente_id = a.id
                JOIN   usuarios       u ON c.instructor_id  = u.id
                JOIN   productos      p ON c.producto_id = p.id
                JOIN   clases_producto cp ON p.clase_id = cp.id
                JOIN   estados_casos  e ON c.estado_id   = e.id
                LEFT JOIN usuarios    ua ON c.auxiliar_id = ua.id AND (ua.rol_id = 3 OR ua.rol_id = 5)
                ORDER BY c.fecha_creacion DESC';
        
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
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Si no hay resultado, devolver un array con valores por defecto
            if (!$resultado) {
                return [
                    'id' => $id,
                    'descripcion' => 'No disponible',
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                    'ambiente' => 'No disponible',
                    'producto' => 'No disponible',
                    'estado' => 'No disponible',
                    'estado_id' => 1,
                    'instructor' => 'No disponible',
                    'asignado_a' => 'No asignado',
                    'imagen' => null,
                    'auxiliar' => 'No asignado'
                ];
            }
            
            return $resultado;
        }

        public function CreateCasoGeneral($ambiente_id,$asunto,$descripcion,$estado_id,$instructor_id,$area_asignada,$asignado_a) {
            try {   
                $query = 'INSERT INTO casos_generales (ambiente_id, asunto, descripcion, estado_id, instructor_id, area_asignada, asignado_a, fecha_creacion)
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())';
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$ambiente_id, $asunto, $descripcion, $estado_id, $instructor_id, $area_asignada, $asignado_a]);
                return true;
            } catch (PDOException $e) {
                error_log("Error al crear caso general: " . $e->getMessage());
                return false;
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
                        cg.fecha_creacion,
                        a.nombre          AS ambiente,
                        e.estado          AS estado,
                        iu.nombres        AS instructor,
                        'caso_general' as tipo_caso,
                        COALESCE(au.nombres, 'No asignado') AS nombre_asignado,
                        cg.asignado_a     AS asignado_a_id
                FROM   casos_generales cg
                JOIN   ambientes       a  ON cg.ambiente_id   = a.id
                JOIN   estados_casos   e  ON cg.estado_id     = e.id
                JOIN   usuarios        iu ON cg.instructor_id = iu.id
                LEFT   JOIN usuarios   au ON cg.asignado_a    = au.id
                ORDER BY cg.fecha_creacion DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $casos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($casos as &$caso) {
                $historialQuery = "
                    SELECT 
                        h.fecha_actualizacion,
                        e.estado AS estado_anterior,
                        e2.estado AS estado_nuevo,
                        h.observaciones,
                        u.nombres AS usuario,
                        r.nombre AS rol_usuario
                    FROM historial_casos h
                    JOIN estados_casos e ON h.estado_anterior_id = e.id
                    JOIN estados_casos e2 ON h.estado_nuevo_id = e2.id
                    JOIN usuarios u ON h.usuario_id = u.id
                    JOIN roles r ON u.rol_id = r.id
                    WHERE h.caso_id = :caso_id AND h.tipo_caso = 'caso_general'
                    ORDER BY h.fecha_actualizacion DESC";
                
                $historialStmt = $this->conn->prepare($historialQuery);
                $historialStmt->bindParam(':caso_id', $caso['id'], PDO::PARAM_INT);
                $historialStmt->execute();
                $caso['historial'] = $historialStmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $casos;
        }

        public function getCasoGeneral($id) {
            $sql = "
                SELECT  cg.id,
                        cg.asunto,
                        cg.descripcion,
                        cg.fecha_creacion,
                        a.nombre           AS ambiente,
                        e.id               AS estado_id,
                        e.estado           AS estado,
                        iu.nombres         AS instructor,
                        au.nombres         AS asignado_a,
                        cg.asignado_a      AS asignado_a_id
                FROM   casos_generales cg
                JOIN   ambientes       a  ON cg.ambiente_id   = a.id
                JOIN   estados_casos   e  ON cg.estado_id     = e.id
                JOIN   usuarios        iu ON cg.instructor_id = iu.id
                LEFT   JOIN usuarios   au ON cg.asignado_a    = au.id
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

        public function updateCasoGeneralStatus($id, $estado_id, $asignado_a) {
            try {
                // Primero verificamos si el caso existe
                $checkQuery = "SELECT id FROM casos_generales WHERE id = :id";
                $checkStmt = $this->conn->prepare($checkQuery);
                $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
                $checkStmt->execute();
                
                if (!$checkStmt->fetch()) {
                    return ["error" => true, "message" => "El caso no existe"];
                }

                // Actualizamos el caso
                $query = "UPDATE casos_generales SET estado_id = :estado_id, asignado_a = :asignado_a WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':estado_id', $estado_id, PDO::PARAM_INT);
                $stmt->bindParam(':asignado_a', $asignado_a, PDO::PARAM_INT);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                
                if ($stmt->execute()) {
                    return ["success" => true, "message" => "Estado del caso general actualizado correctamente"];
                } else {
                    return ["error" => true, "message" => "Error al actualizar el estado del caso general"];
                }
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

        public function registrarHistorial($caso_id, $estado_anterior_id, $estado_nuevo_id, $observaciones, $usuario_id, $tipo_caso = 'caso') {
            // Si el estado_anterior_id es 0 o null, establecerlo como 1 (Pendiente)
            if (!$estado_anterior_id || $estado_anterior_id == 0) {
                $estado_anterior_id = 1;
            }

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

        
        public function registrarHistorialGeneral($caso_id, $estado_anterior_id, $estado_nuevo_id, $observaciones, $usuario_id, $tipo_caso = 'caso_general') {
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

        public function getcasoestadog($id){
            $query = 'SELECT estado_id FROM casos_generales WHERE id = :id';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Si no hay resultado o el estado_id es null, retornar 1 (Pendiente)
            if (!$resultado || !isset($resultado['estado_id'])) {
                return ['estado_id' => 1];
            }
            
            return $resultado;
        }

        public function obtenerHistorialCompleto($casoId) {
            $sql = "SELECT 
                        c.titulo,
                        c.descripcion AS descripcion_caso,
                        c.estado,
                        u.nombres AS creado_por,
                        h.observaciones,
                        h.fecha,
                        aux.nombres AS asignado_a
                    FROM casos c
                    LEFT JOIN historial_casos h ON c.id = h.caso_id
                    LEFT JOIN usuarios u ON c.usuario_id = u.id
                    LEFT JOIN usuarios aux ON c.auxiliar_id = aux.id
                    WHERE c.id = ?
                    ORDER BY h.fecha DESC";
        
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$casoId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function obtenerCasos($instructor_id) {
            try {
                $sql = "SELECT 
                c.id             AS id_caso,
                p.numero_placa   AS producto,
                a.nombre         AS ambiente,
                c.descripcion    AS descripcion_caso,
                e.estado         AS estado,
                u.nombres        AS creado_por,
                h.observaciones,
                h.fecha_actualizacion AS fecha,
                COALESCE(ux.nombres, 'No asignado')   AS asignado_a
                FROM casos c
                LEFT JOIN historial_casos h ON c.id = h.caso_id
                LEFT JOIN ambientes a ON c.ambiente_id = a.id
                LEFT JOIN productos p ON c.producto_id = p.id
                LEFT JOIN usuarios u ON c.instructor_id = u.id
                LEFT JOIN usuarios aux ON c.auxiliar_id = aux.id
                LEFT JOIN estados_casos e ON c.estado_id = e.id
                WHERE c.instructor_id = :id
                ORDER BY c.id DESC, h.fecha_actualizacion DESC";
        
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':id', $instructorId, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // Manejo de excepciones en caso de error en la consulta
                echo "Error en la consulta: " . $e->getMessage();
                return [];  // En caso de error, devolver un arreglo vacío
            }
        }
     
        public function getAllCasos() {
            $query = "
                SELECT 
                    c.id AS caso_id,
                    c.descripcion AS descripcion_caso,
                    a.nombre AS ambiente,
                    p.numero_placa AS producto,
                    c.fecha_creacion,
                    e.estado AS estado_actual,
                    u.nombres AS creado_por,
                    c.instructor_id,
                    'caso' as tipo_caso,
                    COALESCE(ux.nombres, 'No asignado') AS asignado_a
                FROM casos c
                LEFT JOIN estados_casos e ON c.estado_id = e.id
                LEFT JOIN ambientes a ON c.ambiente_id = a.id
                LEFT JOIN productos p ON c.producto_id = p.id
                LEFT JOIN usuarios u ON c.instructor_id = u.id
                LEFT JOIN usuarios ux ON c.auxiliar_id = ux.id
                ORDER BY c.fecha_creacion DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $casos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($casos as &$caso) {
                $historialQuery = "
                    SELECT 
                        h.fecha_actualizacion,
                        e.estado AS estado_anterior,
                        e2.estado AS estado_nuevo,
                        h.observaciones,
                        u.nombres AS usuario,
                        r.nombre AS rol_usuario
                    FROM historial_casos h
                    JOIN estados_casos e ON h.estado_anterior_id = e.id
                    JOIN estados_casos e2 ON h.estado_nuevo_id = e2.id
                    JOIN usuarios u ON h.usuario_id = u.id
                    JOIN roles r ON u.rol_id = r.id
                    WHERE h.caso_id = :caso_id AND h.tipo_caso = 'caso'
                    ORDER BY h.fecha_actualizacion DESC";
                
                $historialStmt = $this->conn->prepare($historialQuery);
                $historialStmt->bindParam(':caso_id', $caso['caso_id'], PDO::PARAM_INT);
                $historialStmt->execute();
                $caso['historial'] = $historialStmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $casos;
        }
     
        // Obtener historial de todos los movimientos de los casos que ve almacén (igual que en el panel de casos)
        public function getHistorialAlmacen($rol_id = 4) {
            $query = "
                SELECT 
                    p.numero_placa AS producto,
                    e.estado AS estado,
                    a.nombre AS ambiente,
                    h.fecha_actualizacion AS fecha,
                    h.observaciones,
                    u.nombres AS usuario
                FROM historial_casos h
                LEFT JOIN casos c ON h.caso_id = c.id
                LEFT JOIN productos p ON c.producto_id = p.id
                LEFT JOIN ambientes a ON c.ambiente_id = a.id
                LEFT JOIN estados_casos e ON h.estado_nuevo_id = e.id
                LEFT JOIN usuarios u ON h.usuario_id = u.id
                WHERE c.id IN (SELECT id FROM casos WHERE asignado_a = :rol_id)
                ORDER BY h.fecha_actualizacion DESC
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':rol_id', $rol_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Obtener casos filtrados por rol (por ejemplo, almacén)
        public function getCasosPorRol($rol_id) {
            $query = "
                SELECT  c.id,
                        a.nombre          AS ambiente,
                        u.nombres         AS instructor,
                        p.numero_placa    AS producto,
                        e.estado          AS estados_casos,
                        c.asignado_a,
                        c.descripcion,
                        c.imagen,
                        c.fecha_creacion,
                        CASE 
                            WHEN c.estado_id = 1 THEN 'No asignado'
                            ELSE COALESCE(ua.nombres, 'No asignado')
                        END AS nombre_asignado
                FROM   casos c
                JOIN   ambientes      a ON c.ambiente_id = a.id
                JOIN   usuarios       u ON c.instructor_id  = u.id
                JOIN   productos      p ON c.producto_id = p.id
                JOIN   estados_casos  e ON c.estado_id   = e.id
                LEFT JOIN usuarios    ua ON c.auxiliar_id = ua.id
                WHERE c.asignado_a = :rol_id
                ORDER BY c.fecha_creacion DESC
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':rol_id', $rol_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Actualiza solo el estado del caso, sin modificar auxiliar_id (para almacén)
        public function updateEstadoSolo($id, $estado_id) {
            $query = "UPDATE casos SET estado_id = :estado_id WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':estado_id', $estado_id, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        public function eliminarCasoYHistorial($id) {
            try {
                $stmtHistorial = $this->conn->prepare("DELETE FROM historial_casos WHERE caso_id = ?");
                $stmtHistorial->execute([$id]);
                $stmt = $this->conn->prepare("DELETE FROM casos WHERE id = ?");
                $success = $stmt->execute([$id]);
                return $success;
            } catch (Exception $e) {
                return false;
            }
        }

        public function contarCasosPorInstructor($instructor_id) {
            try {
                // Contar casos normales
                $query1 = "SELECT COUNT(*) AS total FROM casos WHERE instructor_id = :instructor_id";
                $stmt1 = $this->conn->prepare($query1);
                $stmt1->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
                $stmt1->execute();
                $total_normales = $stmt1->fetch(PDO::FETCH_ASSOC)['total'];

                // Contar casos generales
                $query2 = "SELECT COUNT(*) AS total FROM casos_generales WHERE instructor_id = :instructor_id";
                $stmt2 = $this->conn->prepare($query2);
                $stmt2->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
                $stmt2->execute();
                $total_generales = $stmt2->fetch(PDO::FETCH_ASSOC)['total'];

                return $total_normales + $total_generales;
            } catch (PDOException $e) {
                error_log("Error al contar casos: " . $e->getMessage());
                return 0;
            }
        }

        public function contarCasosPendientesPorInstructor($instructor_id) {
            try {
                // Contar casos normales pendientes
                $query1 = "SELECT COUNT(*) AS total FROM casos 
                          WHERE instructor_id = :instructor_id 
                          AND estado_id = (SELECT id FROM estados_casos WHERE estado = 'Pendiente')";
                $stmt1 = $this->conn->prepare($query1);
                $stmt1->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
                $stmt1->execute();
                $total_normales = $stmt1->fetch(PDO::FETCH_ASSOC)['total'];

                // Contar casos generales pendientes
                $query2 = "SELECT COUNT(*) AS total FROM casos_generales 
                          WHERE instructor_id = :instructor_id 
                          AND estado_id = (SELECT id FROM estados_casos WHERE estado = 'Pendiente')";
                $stmt2 = $this->conn->prepare($query2);
                $stmt2->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
                $stmt2->execute();
                $total_generales = $stmt2->fetch(PDO::FETCH_ASSOC)['total'];

                return $total_normales + $total_generales;
            } catch (PDOException $e) {
                error_log("Error al contar casos pendientes: " . $e->getMessage());
                return 0;
            }
        }

        public function contarCasosResueltosPorInstructor($instructor_id) {
            try {
                // Contar casos normales resueltos
                $query1 = "SELECT COUNT(*) AS total FROM casos c
                          JOIN estados_casos e ON c.estado_id = e.id
                          WHERE c.instructor_id = :instructor_id 
                          AND e.estado IN ('Resuelto', 'Cerrado', 'Repuesto')";
                $stmt1 = $this->conn->prepare($query1);
                $stmt1->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
                $stmt1->execute();
                $total_normales = $stmt1->fetch(PDO::FETCH_ASSOC)['total'];

                // Contar casos generales resueltos
                $query2 = "SELECT COUNT(*) AS total FROM casos_generales cg
                          JOIN estados_casos e ON cg.estado_id = e.id
                          WHERE cg.instructor_id = :instructor_id 
                          AND e.estado IN ('Resuelto', 'Cerrado', 'Repuesto')";
                $stmt2 = $this->conn->prepare($query2);
                $stmt2->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
                $stmt2->execute();
                $total_generales = $stmt2->fetch(PDO::FETCH_ASSOC)['total'];

                return $total_normales + $total_generales;
            } catch (PDOException $e) {
                error_log("Error al contar casos resueltos: " . $e->getMessage());
                return 0;
            }
        }

        public function obtenerUltimosCasosInstructor($instructor_id) {
            try {
                // Obtener últimos casos normales
                $query1 = "SELECT 
                    'normal' as tipo_caso,
                    c.id,
                    c.descripcion,
                    c.fecha_creacion,
                    CASE 
                        WHEN c.asignado_a = 4 THEN 'Almacén'
                        WHEN c.asignado_a = 3 THEN 'TICS'
                        ELSE 'No asignado'
                    END AS area_asignada,
                    e.estado AS estado_actual
                FROM casos c
                JOIN estados_casos e ON c.estado_id = e.id
                WHERE c.instructor_id = :instructor_id";

                // Obtener últimos casos generales
                $query2 = "SELECT 
                    'general' as tipo_caso,
                    cg.id,
                    cg.asunto as descripcion,
                    cg.fecha_creacion,
                    r.nombre as area_asignada,
                    e.estado AS estado_actual
                FROM casos_generales cg
                JOIN estados_casos e ON cg.estado_id = e.id
                LEFT JOIN roles r ON cg.area_asignada = r.id
                WHERE cg.instructor_id = :instructor_id";

                // Combinar y ordenar resultados
                $query = "($query1) UNION ALL ($query2) ORDER BY fecha_creacion DESC LIMIT 5";
                
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                error_log("Error al obtener últimos casos: " . $e->getMessage());
                return [];
            }
        }

        public function obtenerCasosInstructor($instructor_id, $pagina = 1, $por_pagina = 8, $filtros = []) {
            try {
                // Construir la consulta base
                $query = "
                    SELECT 
                        c.id,
                        c.descripcion,
                        c.fecha_creacion,
                        CASE 
                            WHEN c.asignado_a = 4 THEN 'Almacén'
                            WHEN c.asignado_a = 3 THEN 'TICS'
                            ELSE 'No asignado'
                        END AS area_asignada,
                        p.numero_placa,
                        p.descripcion AS descripcion_producto,
                        e.estado AS estado_actual
                    FROM casos c
                    JOIN productos p ON c.producto_id = p.id
                    JOIN estados_casos e ON c.estado_id = e.id
                    WHERE c.instructor_id = :instructor_id";

                // Aplicar filtros
                $params = [':instructor_id' => $instructor_id];
                
                if (!empty($filtros['area'])) {
                    if ($filtros['area'] === 'Tics') {
                        $query .= " AND c.asignado_a = 3";
                    } elseif ($filtros['area'] === 'Almacen') {
                        $query .= " AND c.asignado_a = 4";
                    }
                }
                
                if (!empty($filtros['estado'])) {
                    $query .= " AND e.estado = :estado";
                    $params[':estado'] = $filtros['estado'];
                }
                
                if (!empty($filtros['fecha_inicio'])) {
                    $query .= " AND c.fecha_creacion >= :fecha_inicio";
                    $params[':fecha_inicio'] = $filtros['fecha_inicio'] . ' 00:00:00';
                }
                
                if (!empty($filtros['fecha_fin'])) {
                    $query .= " AND c.fecha_creacion <= :fecha_fin";
                    $params[':fecha_fin'] = $filtros['fecha_fin'] . ' 23:59:59';
                }

                // Obtener el total de registros para la paginación
                $countQuery = "SELECT COUNT(*) AS total FROM ($query) AS total";
                $stmt = $this->conn->prepare($countQuery);
                $stmt->execute($params);
                $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
                $total_paginas = ceil($total / $por_pagina);

                // Aplicar paginación
                $offset = ($pagina - 1) * $por_pagina;
                $query .= " ORDER BY c.fecha_creacion DESC LIMIT :offset, :limit";
                $params[':offset'] = $offset;
                $params[':limit'] = $por_pagina;

                // Ejecutar la consulta final
                $stmt = $this->conn->prepare($query);
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
                }
                $stmt->execute();
                $casos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return [
                    'casos' => $casos,
                    'total_paginas' => $total_paginas
                ];
            } catch (PDOException $e) {
                error_log("Error en obtenerCasosInstructor: " . $e->getMessage());
                return [
                    'casos' => [],
                    'total_paginas' => 0
                ];
            }
        }

        public function obtenerCasosGeneralesInstructor($instructor_id, $pagina_actual, $por_pagina, $filtros = []) {
            try {
                $offset = ($pagina_actual - 1) * $por_pagina;
                
                // Construir la consulta base
                $query = "SELECT cg.id, cg.asunto, cg.descripcion, cg.fecha_creacion, 
                         a.nombre as ambiente, e.estado as estado_actual, r.nombre as area_asignada
                         FROM casos_generales cg
                         LEFT JOIN ambientes a ON cg.ambiente_id = a.id
                         LEFT JOIN estados_casos e ON cg.estado_id = e.id
                         LEFT JOIN roles r ON cg.area_asignada = r.id
                         WHERE cg.instructor_id = :instructor_id";
                
                $params = [':instructor_id' => $instructor_id];
                
                // Aplicar filtros
                if (!empty($filtros['area'])) {
                    $query .= " AND r.nombre = :area";
                    $params[':area'] = $filtros['area'];
                }
                
                if (!empty($filtros['estado'])) {
                    $query .= " AND e.estado = :estado";
                    $params[':estado'] = $filtros['estado'];
                }
                
                if (!empty($filtros['fecha_inicio'])) {
                    $query .= " AND DATE(cg.fecha_creacion) >= :fecha_inicio";
                    $params[':fecha_inicio'] = $filtros['fecha_inicio'];
                }
                
                if (!empty($filtros['fecha_fin'])) {
                    $query .= " AND DATE(cg.fecha_creacion) <= :fecha_fin";
                    $params[':fecha_fin'] = $filtros['fecha_fin'];
                }
                
                // Obtener el total de registros para la paginación
                $total_query = "SELECT COUNT(*) as total FROM casos_generales cg 
                               LEFT JOIN roles r ON cg.area_asignada = r.id
                               LEFT JOIN estados_casos e ON cg.estado_id = e.id
                               WHERE cg.instructor_id = :instructor_id";
                
                // Agregar las mismas condiciones de filtro a la consulta de conteo
                if (!empty($filtros['area'])) {
                    $total_query .= " AND r.nombre = :area";
                }
                if (!empty($filtros['estado'])) {
                    $total_query .= " AND e.estado = :estado";
                }
                if (!empty($filtros['fecha_inicio'])) {
                    $total_query .= " AND DATE(cg.fecha_creacion) >= :fecha_inicio";
                }
                if (!empty($filtros['fecha_fin'])) {
                    $total_query .= " AND DATE(cg.fecha_creacion) <= :fecha_fin";
                }
                
                // Ejecutar la consulta de conteo
                $stmt = $this->conn->prepare($total_query);
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value, PDO::PARAM_STR);
                }
                $stmt->execute();
                $total_result = $stmt->fetch(PDO::FETCH_ASSOC);
                $total = isset($total_result['total']) ? $total_result['total'] : 0;
                
                // Agregar límite y offset para la paginación
                $query .= " ORDER BY cg.fecha_creacion DESC LIMIT :limit OFFSET :offset";
                
                $stmt = $this->conn->prepare($query);
                // Vincular primero los parámetros de la consulta principal
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value, PDO::PARAM_STR);
                }
                // Vincular los parámetros de paginación
                $stmt->bindValue(':limit', (int)$por_pagina, PDO::PARAM_INT);
                $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
                
                $stmt->execute();
                $casos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                return [
                    'casos' => $casos,
                    'total_paginas' => ceil($total / $por_pagina)
                ];
            } catch (PDOException $e) {
                error_log("Error al obtener casos generales: " . $e->getMessage());
                return [
                    'casos' => [],
                    'total_paginas' => 0
                ];
            }
        }

        public function getCorreosPorRol($rol_id) {
            $query = "SELECT correo FROM usuarios WHERE rol_id = :rol_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':rol_id', $rol_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        // Obtener caso normal por ID con historial
        public function getCasoPorIdConHistorial($id) {
            $query = "
                SELECT 
                    c.id AS caso_id,
                    c.descripcion AS descripcion_caso,
                    a.nombre AS ambiente,
                    p.numero_placa AS producto,
                    c.fecha_creacion,
                    e.estado AS estado_actual,
                    u.nombres AS creado_por,
                    c.instructor_id,
                    'caso' as tipo_caso,
                    COALESCE(ux.nombres, 'No asignado') AS asignado_a
                FROM casos c
                LEFT JOIN estados_casos e ON c.estado_id = e.id
                LEFT JOIN ambientes a ON c.ambiente_id = a.id
                LEFT JOIN productos p ON c.producto_id = p.id
                LEFT JOIN usuarios u ON c.instructor_id = u.id
                LEFT JOIN usuarios ux ON c.auxiliar_id = ux.id
                WHERE c.id = :id
                LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $caso = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$caso) return null;
            $historialQuery = "
                SELECT 
                    h.fecha_actualizacion,
                    e.estado AS estado_anterior,
                    e2.estado AS estado_nuevo,
                    h.observaciones,
                    u.nombres AS usuario,
                    r.nombre AS rol_usuario
                FROM historial_casos h
                JOIN estados_casos e ON h.estado_anterior_id = e.id
                JOIN estados_casos e2 ON h.estado_nuevo_id = e2.id
                JOIN usuarios u ON h.usuario_id = u.id
                JOIN roles r ON u.rol_id = r.id
                WHERE h.caso_id = :caso_id AND h.tipo_caso = 'caso'
                ORDER BY h.fecha_actualizacion DESC";
            $historialStmt = $this->conn->prepare($historialQuery);
            $historialStmt->bindParam(':caso_id', $id, PDO::PARAM_INT);
            $historialStmt->execute();
            $caso['historial'] = $historialStmt->fetchAll(PDO::FETCH_ASSOC);
            return $caso;
        }

        // Obtener caso general por ID con historial
        public function getCasoGeneralPorIdConHistorial($id) {
            $query = "
                SELECT  cg.id,
                        cg.asunto,
                        cg.descripcion,
                        cg.fecha_creacion,
                        a.nombre          AS ambiente,
                        e.estado          AS estado,
                        iu.nombres        AS instructor,
                        'caso_general' as tipo_caso,
                        COALESCE(au.nombres, 'No asignado') AS nombre_asignado,
                        cg.asignado_a     AS asignado_a_id
                FROM   casos_generales cg
                JOIN   ambientes       a  ON cg.ambiente_id   = a.id
                JOIN   estados_casos   e  ON cg.estado_id     = e.id
                JOIN   usuarios        iu ON cg.instructor_id = iu.id
                LEFT   JOIN usuarios   au ON cg.asignado_a    = au.id
                WHERE cg.id = :id
                LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $caso = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$caso) return null;
            $historialQuery = "
                SELECT 
                    h.fecha_actualizacion,
                    e.estado AS estado_anterior,
                    e2.estado AS estado_nuevo,
                    h.observaciones,
                    u.nombres AS usuario,
                    r.nombre AS rol_usuario
                FROM historial_casos h
                JOIN estados_casos e ON h.estado_anterior_id = e.id
                JOIN estados_casos e2 ON h.estado_nuevo_id = e2.id
                JOIN usuarios u ON h.usuario_id = u.id
                JOIN roles r ON u.rol_id = r.id
                WHERE h.caso_id = :caso_id AND h.tipo_caso = 'caso_general'
                ORDER BY h.fecha_actualizacion DESC";
            $historialStmt = $this->conn->prepare($historialQuery);
            $historialStmt->bindParam(':caso_id', $id, PDO::PARAM_INT);
            $historialStmt->execute();
            $caso['historial'] = $historialStmt->fetchAll(PDO::FETCH_ASSOC);
            return $caso;
        }
    }

