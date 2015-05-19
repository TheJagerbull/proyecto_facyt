-- phpMyAdmin SQL Dump
-- version 4.3.13
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 15-05-2015 a las 10:43:34
-- Versión del servidor: 10.0.17-MariaDB
-- Versión de PHP: 5.6.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `deca_admin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_observacion_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_observacion_orden` (
  `id_observacion` bigint(20) NOT NULL,
  `id_usuario` varchar(9) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL,
  `observac` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mnt_observacion_orden`
--
ALTER TABLE `mnt_observacion_orden`
  ADD PRIMARY KEY (`id_observacion`), ADD KEY `id_usuario` (`id_usuario`), ADD KEY `id_orden_trabajo` (`id_orden_trabajo`), ADD FULLTEXT KEY `observacion` (`observac`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mnt_observacion_orden`
--
ALTER TABLE `mnt_observacion_orden`
  MODIFY `id_observacion` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mnt_observacion_orden`
--
ALTER TABLE `mnt_observacion_orden`
ADD CONSTRAINT `ID_OBSERVACION_ORDEN` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id_orden`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `ID_USUARIO` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
