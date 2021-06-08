<?php
    require_once("./Conexion.php");

    class Metodos_index {
        private $conexionBBDD;

        //Constructor
        function __construct() {
            //Creo un objeto de la clase Conexion.php
            $bbdd = new Conexion("localhost","root","","parkingweb");

            //Establezco la conexión con la base de datos
            $this->conexionBBDD = $bbdd->conectar();
        }
    
        function getIdNombreParkings() {
            //Sentencia SQL para obtener el id y nombre de cada parking
            $sql = "SELECT id,nombre FROM parkings";

            //Preparo la consulta que ejecutaremos en el servidor
            $consulta_parkings = $this->conexionBBDD->prepare($sql,array());

            //Ejecuto la consulta
            $consulta_parkings->execute(array());

            //Devuelvo el resultado
            return $consulta_parkings->fetchAll(PDO::FETCH_OBJ);
        }

        function getDatosParkingSeleccionadoIndex($parametros) {
            //Sentencia SQL para obtener el nombre, la dirección, el mapa, la tarifa y las plazas libres y ocupadas
            //del parking seleccionado por el usuario en el index
            $sql_parking = "SELECT p.nombre, p.Direccion,p.mapa,tarifa,
            (SELECT COUNT(pl.nombre) FROM plazas pl WHERE pl.IdParking = :id AND pl.Libre = 'Sí') AS 'Libres',
            (SELECT COUNT(pl.nombre) FROM plazas pl WHERE pl.IdParking = :id AND pl.Libre = 'No') AS 'Ocupadas',
            (SELECT COUNT(pl.nombre) FROM plazas pl WHERE pl.IdParking = :id) AS 'Totales'
            from parkings p where p.id = :id";

            //Preparamos la consulta anterior
            $info_parking = $this->conexionBBDD->prepare($sql_parking,array());

            //Ejecutamos la consulta preparada sustituyendo los parámetros por su valor
            $info_parking->execute($parametros);

            //Devolvemos los resultados de la consulta
            return $info_parking->fetchALL(PDO::FETCH_OBJ);
        }
    }
?>