<?php
    class ProyectosModel extends Model{
        public $conexion;
        function __construct(){
            parent::__construct();
        }
 
        function listaProyectos(){
            $query = "SELECT * FROM proyecto WHERE estado = 'Activo'";
            $this->conexion = $this->con->conectar();
            $resultado = $this->conexion->prepare($query); 
            $resultado->execute();
            $array = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $this->con->desconectar($this->conexion); //cerramos la conexion
            return $array; //retornamos el arreglo
        }

        function selectProyecto($id){
            $query = "SELECT * FROM proyecto WHERE estado = 'Activo' AND id = :id";
            $this->conexion = $this->con->conectar();
            $resultado = $this->conexion->prepare($query); 
            $resultado->bindParam(':id', $id);
            $resultado->execute();
            $array = $resultado->fetch(PDO::FETCH_ASSOC);
            $this->con->desconectar($this->conexion); //cerramos la conexion
            return $array; //retornamos el arreglo
        }
        
        function agregarProyecto($idCliente, $idEquipo, $fecha, $nombre, $estado){
            $query = "INSERT INTO proyecto VALUES(null, :idCliente,:idEquipo, :fecha,:nombre,:estado)";
            $this->conexion = $this->con->conectar();
            $row = $this->conexion->prepare($query);
            $row->bindParam(':idCliente', $idCliente); //enviamos parametros a la consulta, esto evita inyecciones SQL
            $row->bindParam(':idEquipo', $idEquipo);
            $row->bindParam(':fecha', $fecha);
            $row->bindParam(':nombre', $nombre);
            $row->bindParam(':estado', $estado);
            if ($row->execute()) {
                return $this->conexion->lastInsertId(); // Devuelve el ID insertado
            } else {
                return false; // Si la inserción falla, devuelve false
            }
        }

        function actualizarProyecto($id, $idCliente, $idEquipo, $fecha, $nombre){
            $query = "UPDATE proyecto SET id_cliente = :idCliente, id_equipo = :idEquipo, fecha_entrega = :fecha, nombre = :nombre WHERE id = :id";
            $this->conexion = $this->con->conectar();
            $row = $this->conexion->prepare($query);
            $row->bindParam(':idCliente', $idCliente); //enviamos parametros a la consulta, esto evita inyecciones SQL
            $row->bindParam(':idEquipo', $idEquipo);
            $row->bindParam(':fecha', $fecha);
            $row->bindParam(':nombre', $nombre);
            $row->bindParam(':id', $id);
            return $row->execute();//devolvera un booleano dependiendo si la consulta y conexion fue exitosa
        }

        function eliminarProyecto($id, $estado){
            $query = "UPDATE proyecto SET estado = :estado WHERE id = :id";
            $this->conexion = $this->con->conectar();
            $row = $this->conexion->prepare($query);
            $row->bindParam(':id', $id);
            $row->bindParam(':estado', $estado);
            return $row->execute(); //devolvera un booleano dependiendo si la consulta y conexion fue exitosa
        }
    }
?>