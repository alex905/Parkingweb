<?php
    require_once("./Conexion.php");

    class Metodos_reservas {
        private $conexionBBDD;

        //Constructor
        function __construct() {
            //Creo un objeto de la clase Conexion.php
            $bbdd = new Conexion("localhost","root","","parkingweb");

            //Establezco la conexión con la base de datos
            $this->conexionBBDD = $bbdd->conectar();
        }

        function contarPlazasLibres($parametros) {
            //Comprobamos si ha plazas libres en el parking seleccionado
            $sql = "SELECT COUNT(id) FROM plazas WHERE idParking=:idParking AND libre=:libre";
        
            //Preparamos la consulta
            $consulta_contar_plazas = $this->conexionBBDD->prepare($sql,array());
        
            //Ejecutamos la consulta
            $consulta_contar_plazas->execute($parametros);
        
            //Devolvemos el usuario de la consulta anterior
            return $consulta_contar_plazas->fetch(PDO::FETCH_NUM)[0];
        }

        function insertarVehiculo($parametros) {
            //Consulta SQL para guardar matrícula y el DNI del usuario
            $sql = "INSERT INTO vehiculos VALUES(:matricula,:dniUsuario)";

            //Preparo la consulta
            $consulta_vehiculo = $this->conexionBBDD->prepare($sql,array());

            //Ejecuto la consulta e inserto el DNI y la matrícula del vehículo del usuario
            $consulta_vehiculo->execute($parametros);
        }

        function obtenerPrimeraPlazaVacia($parametros) {
            //Consulta SQL para obtener el nombre de la primera plaza vacía del parking seleccionado
            $sql = "SELECT id,nombre FROM plazas WHERE libre=:libre AND idParking=:idParking";

            //Preparamos la consulta
            $consulta_plazas = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta
            $consulta_plazas->execute($parametros);

            //Devolvemos el resultado de la consulta
            return $consulta_plazas->fetch(PDO::FETCH_NUM);
        }

        function modificarEstadoPlaza($parametros) {
            //Sentencia SQL para modificar el estado de la plaza
            $sql = "UPDATE plazas SET libre=:libre, reservada=:reservada WHERE id=:idplaza";

            //Preparamos la sentencia
            $consulta_mod_plazas = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta y modificamos los valores de los campos libre y reservada
            $consulta_mod_plazas->execute($parametros);
        }

        function realizarReserva($parametros) {
            //Consulta SQL para realizar la reserva
            $sql = "INSERT INTO reservas VALUES(DEFAULT,:dni,:matricula,:idParking,:idPlaza,CURRENT_DATE(),CURRENT_TIME())";

            //Preparamos la consulta
            $consulta_insertar_reserva = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta y creamos la reserva en la base de datos
            $consulta_insertar_reserva->execute($parametros);
        }


    }


?>