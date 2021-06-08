<?php
    require_once("./Conexion.php");

    class Metodos_modificar_parking {
        private $conexionBBDD;

        //Constructor
        function __construct() {
            //Creo un objeto de la clase Conexion.php
            $bbdd = new Conexion("localhost","root","","parkingweb");

            //Establezco la conexión con la base de datos
            $this->conexionBBDD = $bbdd->conectar();
        }

        function obtenerDatosParkingPorId($parametros) {
            //Sentencia SQL que obtiene toda la información del parking seleccionado
            $sql = "SELECT * FROM  parkings WHERE id=:id";

            //Preparo la sentencia SQL
            $consulta_datos_parking = $this->conexionBBDD->prepare($sql,array());

            //Ejecuto la consulta
            $consulta_datos_parking->execute($parametros);

            //Devuelvo el resultado de la consulta anterior
            return $consulta_datos_parking->fetch(PDO::FETCH_NUM);
        }

        function modificarCaracteres($parametros) {
            //Consulta sql para modificar los caracteres < >
            $sql = "SELECT reemplazarCaracteres(:id)";

            //Preparamos la consulta
            $consulta_reemplazo_caracteres = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta
            $consulta_reemplazo_caracteres->execute($parametros);

            //Devolvemos el resultado
            return $consulta_reemplazo_caracteres->fetch(PDO::FETCH_NUM)[0];
        }

        function eliminarParking($parametros) {
            //Consulta SQL para eliminar el parking
            $sql = "DELETE FROM parkings WHERE id=:idParking";

            //Preparo la consutla
            $consulta_eliminar_parking = $this->conexionBBDD->prepare($sql,array());

            //Ejecuto la consulta y borro el parking
            $consulta_eliminar_parking->execute($parametros);
        }

        function modificarParking($parametros) {
            //Sentencia SQL que modificará el parking
            $sql = "UPDATE parkings SET nombre=:nombreParking, tarifa=:tarifaParking, direccion=:direccionParking, mapa=:mapaParking WHERE id=:idParking";

            //Preparamos la sentencia
            $consulta_modificar_parking = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la sentencia y guardamos los cambios
            $consulta_modificar_parking->execute($parametros);
        }
    }
?>