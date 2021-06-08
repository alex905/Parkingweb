<?php
    require_once("./Conexion.php");

    class Metodos_agregar_usuario {
        private $conexionBBDD;

        //Constructor
        function __construct() {
            //Creo un objeto de la clase Conexion.php
            $bbdd = new Conexion("localhost","root","","parkingweb");

            //Establezco la conexión con la base de datos
            $this->conexionBBDD = $bbdd->conectar();
        }

        function insertarNuevoUsuario($parametros) {

            //sentencia SQL que insertará los datos
            $sql = "INSERT INTO usuarios VALUES(:dni,:nombre,:apellidos,:email,:pass,:telefono,:administrador)";

            //Preparo la consulta que insertará los valores
            $consulta_insertar_usuario = $this->conexionBBDD->prepare($sql,array());

            //Ejecuto la consulta e inserto el usuario
            $consulta_insertar_usuario->execute($parametros);
            
        }
    }
?>