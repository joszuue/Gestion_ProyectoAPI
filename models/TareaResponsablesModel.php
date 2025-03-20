<?php
class TareaResponsablesModel extends Model {
    public $conexion;

    public function __construct(){
        parent::__construct();
    }
    
    // Inserta en la tabla tarea_responsables
    public function asignarResponsable($id_tarea, $id_responsable) {
        $query = "INSERT INTO tarea_responsables (id_tarea, id_responsable) 
                  VALUES (:id_tarea, :id_responsable)";
        
        // Usando la misma conexión que en UsuariosModel
        $this->conexion = $this->con->conectar();
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_tarea', $id_tarea, PDO::PARAM_INT);
        $stmt->bindParam(':id_responsable', $id_responsable, PDO::PARAM_INT);
        
        $resultado = $stmt->execute();
        $this->con->desconectar($this->conexion);
        
        return $resultado;
    }
}
?>
