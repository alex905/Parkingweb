<?php
    require_once("./Conexion.php");

    class Metodos_lista_parking {
        private $conexionBBDD;

        //Constructor
        function __construct() {
            //Creo un objeto de la clase Conexion.php
            $bbdd = new Conexion("localhost","root","","parkingweb");

            //Establezco la conexión con la base de datos
            $this->conexionBBDD = $bbdd->conectar();
        }

        function obtenerDatosParkingsAdmin() {
            //Consulta SQL para obtener la información de todos los usuarios
            $sql = "SELECT * FROM parkings";

            //Preparamos la consulta
            $consulta_parkings = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta
            $consulta_parkings->execute();

            //Devolvemos los resultados
            return $consulta_parkings->fetchALL(PDO::FETCH_OBJ);
        }
    }
?>