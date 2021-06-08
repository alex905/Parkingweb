<?php
    class Conexion {
        private $host;
        private $usuario;
        private $pass;
        private $db;

        function __construct($host, $usuario, $pass, $db) {
            $this->host = $host;
            $this->usuario = $usuario;
            $this->pass = $pass;
            $this->db = $db;
        }

        function conectar() {
 
        $opciones = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::MYSQL_ATTR_FOUND_ROWS => true
        );
 
        try {
            $this->connection = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db,
                $this->usuario,
                $this->pass,
                $opciones
                );

                return $this->connection;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
        
        }
    }
?>