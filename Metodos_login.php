<?php
    require_once("./Conexion.php");

    class Metodos_login {
        private $conexionBBDD;

        //Constructor
        function __construct() {
            //Creo un objeto de la clase Conexion.php
            $bbdd = new Conexion("localhost","root","","parkingweb");

            //Establezco la conexión con la base de datos
            $this->conexionBBDD = $bbdd->conectar();
        }

        function comprobarUsuarioLogin($parametros) {
            //Sentencia que comprueba que existe el usuario
            $sql = "SELECT dni,nombre,apellidos,administrador FROM usuarios WHERE email = :email AND pass=:pass";

            //Preparamos la consulta
            $consulta_usuario = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta
            $consulta_usuario->execute($parametros);

            //Devolvemos el resultado
            return $consulta_usuario->fetch(PDO::FETCH_NUM);
        }
    }
?>