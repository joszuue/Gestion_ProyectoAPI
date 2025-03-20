<?php
class TareasAsignadasModel extends Model {
    public $conexion;

    public function __construct(){
        parent::__construct();
    }
    
    // Obtiene las tareas asignadas a un usuario (responsable)
    public function obtenerTareasPorResponsable($id_responsable) {
        $query = "SELECT t.* 
                  FROM tarea t 
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
