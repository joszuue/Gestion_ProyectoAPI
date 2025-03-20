<?php
class ProyectosAsignadosModel extends Model {
    public $conexion;
    
    public function __construct(){
        parent::__construct();
    }
    
    // Obtiene los proyectos asociados a las tareas asignadas a un responsable
    public function obtenerProyectosPorResponsable($id_responsable) {
        $query = "SELECT DISTINCT p.* 
                  FROM proyecto p
                  INNER JOIN tarea t ON p.id = t.id_proyecto
                  INNER JOIN tarea_responsables tr ON t.id = tr.id_tarea
                  WHERE tr.id_responsable = :id_responsable";
        $this->conexion = $this->con->conectar();
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_responsable', $id_responsable, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->con->desconectar($this->conexion);
        return $result;
    }
}
?>
