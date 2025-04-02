<?php
class TareasModel extends Model {
    public $conexion;

    public function __construct(){
        parent::__construct();
    }

    // Crear nueva tarea
    public function crearTarea($id_proyecto, $tarea, $estado) {
        $query = "INSERT INTO tarea (id_proyecto, tarea, estado) VALUES (:id_proyecto, :tarea, :estado)";
        $this->conexion = $this->con->conectar();
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_proyecto', $id_proyecto, PDO::PARAM_INT);
        $stmt->bindParam(':tarea', $tarea, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->execute();
        $idInsertado = $this->conexion->lastInsertId();
        $this->con->desconectar($this->conexion);
        return $idInsertado;
    }

    // Obtener tareas por proyecto
    public function obtenerTareasPorProyecto($id_proyecto) {
        $query = "SELECT * FROM tarea WHERE id_proyecto = :id_proyecto";
        $this->conexion = $this->con->conectar();
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_proyecto', $id_proyecto, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->con->desconectar($this->conexion);
        return $resultado;
    }

    // Eliminar una tarea
    public function eliminarTarea($id_tarea) {
        $query = "DELETE FROM tarea WHERE id = :id_tarea";
        $this->conexion = $this->con->conectar();
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_tarea', $id_tarea, PDO::PARAM_INT);
        $resultado = $stmt->execute();
        $this->con->desconectar($this->conexion);
        return $resultado;
    }

    // Actualizar tarea
    public function actualizarTarea($id_tarea, $tarea, $estado) {
        $query = "UPDATE tarea SET tarea = :tarea, estado = :estado WHERE id = :id_tarea";
        $this->conexion = $this->con->conectar();
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id_tarea', $id_tarea, PDO::PARAM_INT);
        $stmt->bindParam(':tarea', $tarea, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $resultado = $stmt->execute();
        $this->con->desconectar($this->conexion);
        return $resultado;
    }
}
?>
