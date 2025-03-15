<?php
    class UsuariosModel extends Model{
        public $conexion;
        function __construct(){
            parent::__construct();
        }
 
        function listaUsuarios(){
            $query = "SELECT * FROM usuarios WHERE estado = 'Activo'";
            $this->conexion = $this->con->conectar();
            $resultado = $this->conexion->prepare($query); 
            $resultado->execute();
            $array = $resultado->fetchAll(PDO::FETCH_ASSOC);
            $this->con->desconectar($this->conexion); //cerramos la conexion
            return $array; //retornamos el arreglo
        }

        function selectUsuario($id){
            $query = "SELECT * FROM usuarios WHERE estado = 'Activo' AND id = :id";
            $this->conexion = $this->con->conectar();
            $resultado = $this->conexion->prepare($query); 
            $resultado->bindParam(':id', $id);
            $resultado->execute();
            $array = $resultado->fetch(PDO::FETCH_ASSOC);
            $this->con->desconectar($this->conexion); //cerramos la conexion
            return $array; //retornamos el arreglo
        }
        
        function agregarUsuario($nombres, $apellidos, $email, $contra, $rol, $estado){
            $query = "INSERT INTO usuarios VALUES(null, :nombres,:apellidos, :email,:contra,:rol,:estado)";
            $this->conexion = $this->con->conectar();
            $row = $this->conexion->prepare($query);
            $row->bindParam(':nombres', $nombres); //enviamos parametros a la consulta, esto evita inyecciones SQL
            $row->bindParam(':apellidos', $apellidos);
            $row->bindParam(':email', $email);
            $row->bindParam(':contra', $contra);
            $row->bindParam(':rol', $rol);
            $row->bindParam(':estado', $estado);
            if ($row->execute()) {
                return $this->conexion->lastInsertId(); // Devuelve el ID insertado
            } else {
                return false; // Si la inserción falla, devuelve false
            }
        }

        function actualizarUsuario($id, $nombres, $apellidos, $email, $contra, $rol){
            $query = "UPDATE usuarios SET nombres = :nombres, apellidos = :apellidos, email = :email, contra = :contra, rol = :rol WHERE id = :id";
            $this->conexion = $this->con->conectar();
            $row = $this->conexion->prepare($query);
            $row->bindParam(':nombres', $nombres); //enviamos parametros a la consulta, esto evita inyecciones SQL
            $row->bindParam(':apellidos', $apellidos);
            $row->bindParam(':email', $email);
            $row->bindParam(':contra', $contra);
            $row->bindParam(':rol', $rol);
            $row->bindParam(':id', $id);
            return $row->execute();//devolvera un booleano dependiendo si la consulta y conexion fue exitosa
        }

        function eliminarUsuario($id, $estado){
            $query = "UPDATE usuarios SET estado = :estado WHERE id = :id";
            $this->conexion = $this->con->conectar();
            $row = $this->conexion->prepare($query);
            $row->bindParam(':id', $id);
            $row->bindParam(':estado', $estado);
            return $row->execute(); //devolvera un booleano dependiendo si la consulta y conexion fue exitosa
        }


        //LOGICA DE NEGOCIOS 

        //Funcion para obtener la contraseña
        function findPass($email){
            $query = "SELECT * FROM usuarios WHERE estado = :estado AND email = :email";
            $this->conexion = $this->con->conectar();//accedemos a la funcion conectar, y por ende su return, el cual recordara es la bdd
            $resultado = $this->conexion->prepare($query); //preparamos la consulta
            $resultado->bindValue(':estado', "Activo");
            $resultado->bindParam(':email', $email);
            $resultado->execute();//ejecutamos la consulta
            $contra = " ";
            while ($row = $resultado->fetch()) {//obtenemos los resultados de la consulta, aqui se convertiran en arreglos nativos de php que podemos recorrer y usar
                $contra = $row['contra'];
            }
            $this->con->desconectar($this->conexion);//cerramos la conexion
            return $contra;//retornamos el arreglo
        }

        function findUser($email, $contra){
            $query = "SELECT * FROM usuarios WHERE email = :email AND contra = :contra";
            $this->conexion = $this->con->conectar();
            $resultado = $this->conexion->prepare($query); 
            $resultado->bindParam(':email', $email);
            $resultado->bindParam(':contra', $contra);
            $resultado->execute();
            $array = $resultado->fetch(PDO::FETCH_ASSOC);
            $this->con->desconectar($this->conexion); //cerramos la conexion
            return $array; //retornamos el arreglo
        }


    }
?>