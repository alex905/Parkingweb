<?php
    require_once("./Conexion.php");

    class Metodos_agregar_parking {
        private $conexionBBDD;

        //Constructor
        function __construct() {
            //Creo un objeto de la clase Conexion.php
            $bbdd = new Conexion("localhost","root","","parkingweb");

            //Establezco la conexión con la base de datos
            $this->conexionBBDD = $bbdd->conectar();
        }

        function insertarParking($parametros) {
            //Sentencia SQL para insertar el nuevo parking
            $sql = "INSERT INTO parkings(nombre,direccion,mapa,tarifa) VALUES(:nombre,:direccion,:mapa,:tarifa)";

            //Preparo la consulta
            $consulta_insertar_parking = $this->conexionBBDD->prepare($sql,array());

            //Ejecuto la consulta y agrego el nuevo parking
            $consulta_insertar_parking->execute($parametros);

            //Devolvemos el id del último parking que hemos creado
            return $this->conexionBBDD->lastInsertId();
        }

        function insertarPlaza($parametros) {
            //Creo la sentencia SQL para insertar la plaza
            $sql = "INSERT INTO plazas(nombre,libre,reservada,idParking) VALUES(:nombre_plaza,:libre,:reservada,:idParking)";

            //Preparamos la consulta
            $consulta_insertar_plaza = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta
            $consulta_insertar_plaza->execute($parametros);
        }
    }


?>