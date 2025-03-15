<?php
    class EquipoModel extends Model{
        public $conexion;
        function __construct(){
            parent::__construct();
        }
 
        function listaEquipos(){
            $query = "SELECT * FROM equipo WHERE estado = 'Activo'";
            $this->conexion = $this->con->conectar();
            $resultado = $this->conexion->prepare($query); 
            $resultado->execute();
            $array = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $this->con->desconectar($this->conexion); //cerramos la conexion
            return $array; //retornamos el arreglo
        }

        function selectEquipo($id){
            $query = "SELECT * FROM equipo WHERE estado = 'Activo' AND id = :id";
            $this->conexion = $this->con->conectar();
            $resultado = $this->conexion->prepare($query); 
            $resultado->bindParam(':id', $id);
            $resultado->execute();
            $array = $resultado->fetch(PDO::FETCH_ASSOC);
            $this->con->desconectar($this->conexion); //cerramos la conexion
            return $array; //retornamos el arreglo
        }
        
        function agregarEquipo($idResponsable, $nombre, $estado){
            $query = "INSERT INTO equipo VALUES(null, :idResponsable, :nombre,:estado)";
            $this->conexion = $this->con->conectar();
            $row = $this->conexion->prepare($query);
            $row->bindParam(':idResponsable', $idResponsable); //enviamos parametros a la consulta, esto evita inyecciones SQL
            $row->bindParam(':nombre', $nombre);
            $row->bindParam(':estado', $estado);
            if ($row->execute()) {
                return $this->conexion->lastInsertId(); // Devuelve el ID insertado
            } else {
                return false; // Si la inserción falla, devuelve false
            }
        }

        function actualizarEquipo($id, $idResponsable, $nombre){
            $query = "UPDATE equipo SET id_responsable = :idResponsable,  nombre = :nombre WHERE id = :id";
            $this->conexion = $this->con->conectar();
            $row = $this->conexion->prepare($query);
            $row->bindParam(':idResponsable', $idResponsable); //enviamos parametros a la consulta, esto evita inyecciones SQL
            $row->bindParam(':nombre', $nombre);
            $row->bindParam(':id', $id);
            return $row->execute();//devolvera un booleano dependiendo si la consulta y conexion fue exitosa
        }

        function eliminarEquipo($id, $estado){
            $query = "UPDATE equipo SET estado = :estado WHERE id = :id";
            $this->conexion = $this->con->conectar();
            $row = $this->conexion->prepare($query);
            $row->bindParam(':id', $id);
            $row->bindParam(':estado', $estado);
            return $row->execute(); //devolvera un booleano dependiendo si la consulta y conexion fue exitosa
        }

    }
?>