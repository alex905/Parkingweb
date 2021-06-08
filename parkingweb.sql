-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2021 a las 21:21:18
-- Versión del servidor: 10.4.16-MariaDB-log
-- Versión de PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `parkingweb`
--
CREATE DATABASE IF NOT EXISTS `parkingweb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `parkingweb`;

DELIMITER $$
--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `reemplazarCaracteres` (`idParking` INT(11)) RETURNS VARCHAR(1000) CHARSET utf8mb4 BEGIN
	#Declaro las variables que usaremos
	DECLARE resultado VARCHAR(1000);
	
	#Sentencia para obtener el string del mapa
	SELECT REPLACE((SELECT mapa FROM parkings WHERE id = idParking),"<","&lt;") INTO resultado;
	
	#Reemplazo el caracter final
	SELECT REPLACE(resultado,">","&gt;") INTO resultado;
	
	RETURN resultado;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parkings`
--

CREATE TABLE `parkings` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(200) DEFAULT NULL,
  `tarifa` double(5,2) DEFAULT NULL,
  `Direccion` varchar(200) DEFAULT NULL,
  `Mapa` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `parkings`
--

INSERT INTO `parkings` (`ID`, `Nombre`, `tarifa`, `Direccion`, `Mapa`) VALUES
(1, 'Parking Paseo de Colón', 1.52, 'Paseo de Cristóbal Colón, 10, 41001 Sevilla', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12680.60848677401!2d-5.9995628!3d37.3862346!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x288606b58e4e8059!2sParking%20Paseo%20de%20Col%C3%B3n!5e0!3m2!1ses!2ses!4v1620785671778!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>'),
(2, 'Parking Muelle de las Delicias Empark', 1.20, 'Muelle de las Delicias, s/n, 41012 Sevilla ESPAÑA', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3170.6610528119945!2d-5.993707684599444!3d37.37419624287735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd126c2488006839%3A0x12a944c32e1e9bad!2sParking%20Muelle%20de%20las%20Delicias%20Empark!5e0!3m2!1ses!2ses!4v1620785716715!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>'),
(3, 'Parking Mercado del Arenal | AUSSA |', 1.35, 'Calle Genil, 41001 Sevilla', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3170.102772390011!2d-6.002555184599148!3d37.38740174212417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd126c13b8641ebb%3A0xda9f090a8ec17038!2sParking%20Mercado%20del%20Arenal%20%7C%20AUSSA%20%7C%20Parking%20en%20Sevilla!5e0!3m2!1ses!2ses!4v1620785754974!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>'),
(12, 'Parking SABA Plaza Concordia 123', 1.60, 'Pl. de la Concordia, 41002 Sevilla, España', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3169.823072130705!2d-5.998978784599035!3d37.394016241747!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd126c0f06544f31%3A0x1cabb5b70fe1fb61!2sParking%20Saba%20Plaza%20Concordia!5e0!3m2!1ses!2ses!4v1622067220576!5m2!1ses!2ses\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plazas`
--

CREATE TABLE `plazas` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(20) DEFAULT NULL,
  `Libre` enum('Sí','No') DEFAULT 'Sí',
  `Reservada` enum('Si','No') DEFAULT 'No',
  `IdParking` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `plazas`
--

INSERT INTO `plazas` (`ID`, `Nombre`, `Libre`, `Reservada`, `IdParking`) VALUES
(1, 'A1', 'No', 'Si', 1),
(2, 'A2', 'No', 'Si', 1),
(3, 'A3', 'Sí', 'No', 1),
(4, 'A4', 'Sí', 'No', 1),
(5, 'A5', 'Sí', 'No', 1),
(6, 'A6', 'No', 'Si', 1),
(7, 'A7', 'No', 'Si', 1),
(8, 'A8', 'No', 'Si', 1),
(9, 'A9', 'No', 'Si', 1),
(10, 'A10', 'No', 'Si', 1),
(1111, 'A1', 'Sí', 'No', 12),
(1112, 'A2', 'Sí', 'No', 12),
(1113, 'A3', 'Sí', 'No', 12),
(1114, 'A4', 'Sí', 'No', 12),
(1115, 'A5', 'Sí', 'No', 12),
(1116, 'A6', 'Sí', 'No', 12),
(1117, 'A7', 'Sí', 'No', 12),
(1118, 'A8', 'Sí', 'No', 12),
(1119, 'A9', 'Sí', 'No', 12),
(1120, 'A10', 'Sí', 'No', 12),
(1121, 'A11', 'Sí', 'No', 12),
(1122, 'A12', 'Sí', 'No', 12),
(1123, 'A13', 'Sí', 'No', 12),
(1124, 'A14', 'Sí', 'No', 12),
(1125, 'A15', 'Sí', 'No', 12),
(1126, 'A16', 'Sí', 'No', 12),
(1127, 'A17', 'Sí', 'No', 12),
(1128, 'A18', 'Sí', 'No', 12),
(1129, 'A19', 'Sí', 'No', 12),
(1130, 'A20', 'Sí', 'No', 12),
(1131, 'A21', 'Sí', 'No', 12),
(1132, 'A22', 'Sí', 'No', 12),
(1133, 'A23', 'Sí', 'No', 12),
(1134, 'A24', 'Sí', 'No', 12),
(1135, 'A25', 'Sí', 'No', 12),
(1136, 'A26', 'Sí', 'No', 12),
(1137, 'A27', 'Sí', 'No', 12),
(1138, 'A28', 'Sí', 'No', 12),
(1139, 'A29', 'Sí', 'No', 12),
(1140, 'A30', 'Sí', 'No', 12),
(1141, 'A31', 'Sí', 'No', 12),
(1142, 'A32', 'Sí', 'No', 12),
(1143, 'A33', 'Sí', 'No', 12),
(1144, 'A34', 'Sí', 'No', 12),
(1145, 'A35', 'Sí', 'No', 12),
(1146, 'A36', 'Sí', 'No', 12),
(1147, 'A37', 'Sí', 'No', 12),
(1148, 'A38', 'Sí', 'No', 12),
(1149, 'A39', 'Sí', 'No', 12),
(1150, 'A40', 'Sí', 'No', 12),
(1151, 'A41', 'Sí', 'No', 12),
(1152, 'A42', 'Sí', 'No', 12),
(1153, 'A43', 'Sí', 'No', 12),
(1154, 'A44', 'Sí', 'No', 12),
(1155, 'A45', 'Sí', 'No', 12),
(1156, 'A46', 'Sí', 'No', 12),
(1157, 'A47', 'Sí', 'No', 12),
(1158, 'A48', 'Sí', 'No', 12),
(1159, 'A49', 'Sí', 'No', 12),
(1160, 'A50', 'Sí', 'No', 12),
(1161, 'B1', 'Sí', 'No', 12),
(1162, 'B2', 'Sí', 'No', 12),
(1163, 'B3', 'Sí', 'No', 12),
(1164, 'B4', 'Sí', 'No', 12),
(1165, 'B5', 'Sí', 'No', 12),
(1166, 'B6', 'Sí', 'No', 12),
(1167, 'B7', 'Sí', 'No', 12),
(1168, 'B8', 'Sí', 'No', 12),
(1169, 'B9', 'Sí', 'No', 12),
(1170, 'B10', 'Sí', 'No', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `ID` int(11) NOT NULL,
  `DNIUsuario` varchar(9) NOT NULL,
  `MatriculaVehiculo` varchar(8) NOT NULL,
  `IdParking` int(11) NOT NULL,
  `IdPlaza` int(11) NOT NULL,
  `Fecha` timestamp NOT NULL DEFAULT curdate(),
  `Hora` timestamp NOT NULL DEFAULT curtime()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `DNI` varchar(9) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellidos` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Pass` varchar(41) DEFAULT NULL,
  `Telefono` varchar(9) DEFAULT NULL,
  `Administrador` enum('Sí','No') DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`DNI`, `Nombre`, `Apellidos`, `Email`, `Pass`, `Telefono`, `Administrador`) VALUES
('12345678A', 'Administrador', 'Admin Admin', 'administrador@gmail.com', '*4ACFE3202A5FF5CF467898FC58AAB1D615029441', '600111222', 'Sí'),
('12345679B', 'Usuario', 'normal normal', 'usuario@gmail.com', '*96B0150C50489D818DA193ADB55F29A1E4C91D11', '600123456', 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `Matricula` varchar(8) NOT NULL,
  `DNIUsuario` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `parkings`
--
ALTER TABLE `parkings`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `plazas`
--
ALTER TABLE `plazas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IdParking` (`IdParking`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `DNIUsuario` (`DNIUsuario`),
  ADD KEY `MatriculaVehiculo` (`MatriculaVehiculo`),
  ADD KEY `IdParking` (`IdParking`),
  ADD KEY `IdPlaza` (`IdPlaza`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`DNI`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`Matricula`),
  ADD KEY `DNIUsuario` (`DNIUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `parkings`
--
ALTER TABLE `parkings`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `plazas`
--
ALTER TABLE `plazas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1207;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `plazas`
--
ALTER TABLE `plazas`
  ADD CONSTRAINT `plazas_ibfk_1` FOREIGN KEY (`IdParking`) REFERENCES `parkings` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `reservas_ibfk_1` FOREIGN KEY (`DNIUsuario`) REFERENCES `usuarios` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_2` FOREIGN KEY (`MatriculaVehiculo`) REFERENCES `vehiculos` (`Matricula`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_3` FOREIGN KEY (`IdParking`) REFERENCES `parkings` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservas_ibfk_4` FOREIGN KEY (`IdPlaza`) REFERENCES `plazas` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`DNIUsuario`) REFERENCES `usuarios` (`DNI`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
