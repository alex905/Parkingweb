<?php
    require_once("./Conexion.php");

    class Metodos_BBDD {
        private $conexionBBDD;

        //Constructor
        function __construct() {
            //Creo un objeto de la clase Conexion.php
            $bbdd = new Conexion("localhost","root","","parkingweb");

            //Establezco la conexión con la base de datos
            $this->conexionBBDD = $bbdd->conectar();
        }

        function getPasswordEncriptado($parametros) {
            //Sentecia que obtiene la contraseña con la función PASSWORD de SQL
            $sql = "SELECT PASSWORD(" . ":pass" . ")";

            //Preparamos la consulta
            $consulta_pass = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta
            $consulta_pass->execute($parametros);

            //Devolvemos el resultado
            return $consulta_pass->fetch(PDO::FETCH_NUM);
        }
    }
?>