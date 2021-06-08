<?php
    require_once("./Conexion.php");

    class Metodos_cancelar_reserva {
        private $conexionBBDD;

        //Constructor
        function __construct() {
            //Creo un objeto de la clase Conexion.php
            $bbdd = new Conexion("localhost","root","","parkingweb");

            //Establezco la conexión con la base de datos
            $this->conexionBBDD = $bbdd->conectar();
        }

        function obtenerReservasUsuario($parametros) {
            //Sentencia SQL para obtener las reservas del usuario
            $sql = "SELECT r.id, r.MatriculaVehiculo, p.nombre, pl.nombre, r.fecha, r.hora, p.id FROM reservas r INNER JOIN
            parkings p ON r.idParking = p.id INNER JOIN plazas pl ON r.idPlaza = pl.id WHERE r.DNIUsuario = :dniUsuario";

            //Preparamos la consulta
            $consulta_obtener_reservas_usuario = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta
            $consulta_obtener_reservas_usuario->execute($parametros);

            //Devolvemos el resultado de la consulta
            return $consulta_obtener_reservas_usuario->fetchAll(PDO::FETCH_NUM);
        }

        function obtenerReservasAdmin() {
            //Sentencia SQL para obtener las reservas del usuario
            $sql = "SELECT r.id ,r.MatriculaVehiculo, p.nombre, pl.nombre, r.fecha, r.hora, p.id FROM reservas r INNER JOIN
            parkings p ON r.idParking = p.id INNER JOIN plazas pl ON r.idPlaza = pl.id";

            //Preparamos la consulta
            $consulta_obtener_reservas_usuario = $this->conexionBBDD->prepare($sql,array());

            //Ejecutamos la consulta
            $consulta_obtener_reservas_usuario->execute(array());

            //Devolvemos el resultado de la consulta
            return $consulta_obtener_reservas_usuario->fetchAll(PDO::FETCH_NUM);
        }

        function eliminarReserva($parametros) {
            //Sentencia SQL para eliminar una reserva
            $sql = "DELETE FROM reservas WHERE id=:idreserva";

            //Preparo la consulta
            $consulta_borrar_reserva = $this->conexionBBDD->prepare($sql,array());

            //Ejecuto la consulta
            $consulta_borrar_reserva->execute($parametros);
        }

        function cambiarEstadoPlaza($parametros) {
            //Sentencia SQL para modificar el estado de la plaza
            $sql = "UPDATE plazas SET libre=:libre, reservada=:reservada WHERE idparking=:idparking AND nombre=:nombre_plaza";

            //Preparo la consulta SQL
            $consulta_estado_plaza = $this->conexionBBDD->prepare($sql,array());

            //Ejecuto la consulta y actualizo el estado de la plaza de la que se cancela la reserva
            $consulta_estado_plaza->execute($parametros);
        }
    }
?>