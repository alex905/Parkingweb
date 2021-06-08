<?php
    require_once("./Conexion.php");

    class Metodos_modificar_usuario {
        private $conexionBBDD;

        //Constructor
        function __construct() {
            //Creo un objeto de la clase Conexion.php
            $bbdd = new Conexion("localhost","root","","parkingweb");

            //Establezco la conexión con la base de datos
            $this->conexionBBDD = $bbdd->conectar();
        }

        function obtenerPasswordDni($parametros) {
            //Consulta SQL que obtiene la pass del usuario mediante su dni
            $sql = "SELECT pass FROM usuarios WHERE dni=:dni";

            //Preparo la consulta
            $consulta_passwordId = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta
            $consulta_passwordId->execute($parametros);

            //Devolvemos el resultado
            return $consulta_passwordId->fetch(PDO::FETCH_NUM);
        }

        function actualizarUsuario($parametros) {
            //Sentencia SQL para actualizar el usuario
            $sql = "UPDATE usuarios SET nombre=:nombre, apellidos=:apellidos, email=:email, 
            pass=:pass, telefono=:telefono, administrador=:administrador WHERE dni=:dni";

            //Preparamos la consulta
            $actualizar_usuario = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta y actualizamos los datos del usuario
            $actualizar_usuario->execute($parametros);
        }

        function obtenerDatosUsuario($parametros) {
            //Consulta SQL para obtener los datos del usuario
            $sql = "SELECT nombre, apellidos, email, telefono, dni, administrador, pass FROM usuarios WHERE dni = :dni";

            //Preparamos la consulta
            $consulta_usuario = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta
            $consulta_usuario->execute($parametros);

            //Devolvemos los resultados
            return $consulta_usuario->fetch(PDO::FETCH_NUM);
        }

        function borrarUsuario($parametros) {
            //Consulta SQL para eliminar el usuario seleccionado
            $sql = "DELETE FROM usuarios WHERE DNI=:dni_usuario";

            //Preparamos la consulta
            $consulta_borrar_usuario = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta y borramos el usuario
            $consulta_borrar_usuario->execute($parametros);
        }
    }
?>