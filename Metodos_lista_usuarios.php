<?php
    require_once("./Conexion.php");

    class Metodos_lista_usuarios {
        private $conexionBBDD;

        //Constructor
        function __construct() {
            //Creo un objeto de la clase Conexion.php
            $bbdd = new Conexion("localhost","root","","parkingweb");

            //Establezco la conexión con la base de datos
            $this->conexionBBDD = $bbdd->conectar();
        }

        function obtenerUsuariosAdmin($parametros) {
            //Sentencia SQL para obtener los datos de todos los usuarios
            $sql = "SELECT * FROM usuarios WHERE dni <> :dni";

            //Preparamos la sentencia
            $consulta_todosUsuarios = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta
            $consulta_todosUsuarios->execute($parametros);

            //Devolvemos los resultados de la consulta
            return $consulta_todosUsuarios->fetchAll(PDO::FETCH_OBJ);
        }

        function borrarUsuario($parametros) {
            //Consulta SQL para borrar el usuario seleccionado
            $sql = "DELETE FROM usuarios WHERE dni=:dni";

            //Preparo la consulta
            $consulta_borrar_usuario = $this->conexionBBDD->prepare($sql,array());

            //Ejecuto la consulta y elimino al usuario
            $consulta_borrar_usuario->execute($parametros);
        }
    }
?>