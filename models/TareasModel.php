<?php
class TareasProgresoModel extends Model {
    public $conexion;
    
    public function __construct(){
        parent::__construct();
    }
    
    // Método para registrar el progreso (ya implementado)
    public function registrarProgreso($id_tarea, $comentario, $last_estado, $new_estado) {
        $query = "INSERT INTO progreso_tarea (id_tarea, comentario, last_estado, new_estado)
                  VALUES (:id_tarea, :comentario, :last_estado, :new_estado)";
        $this->conexion = $this->con->conectar();
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_tarea', $id_tarea, PDO::PARAM_INT);
        $stmt->bindParam(':comentario', $comentario);
        $stmt->bindParam(':last_estado', $last_estado);
        $stmt->bindParam(':new_estado', $new_estado);
        $resultado = $stmt->execute();
        $this->con->desconectar($this->conexion);
        return $resultado;
    }
    
    // Método para obtener el progreso de una tarea
    public function obtenerProgreso($id_tarea) {
        $query = "SELECT * FROM progreso_tarea WHERE id_tarea = :id_tarea ORDER BY id DESC";
        $this->conexion = $this->con->conectar();
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_tarea', $id_tarea, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->con->desconectar($this->conexion);
        return $result;
    }
}
?>
