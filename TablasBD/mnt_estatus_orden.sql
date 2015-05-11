-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-05-2015 a las 10:01:59
-- Versión del servidor: 10.0.17-MariaDB
-- Versión de PHP: 5.6.8

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
-- Estructura de tabla para la tabla `mnt_estatus_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_estatus_orden` (
  `id_estado` bigint(20) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL,
  `id_usuario` varchar(9) NOT NULL,
  `fecha_p` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mnt_estatus_orden`
--
ALTER TABLE `mnt_estatus_orden`
  ADD UNIQUE KEY `ID_UNICO_ESTADO` (`id_estado`,`id_orden_trabajo`,`id_usuario`),
  ADD KEY `id_orden_trabajo` (`id_orden_trabajo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_estado2` (`id_estado`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mnt_estatus_orden`
--
ALTER TABLE `mnt_estatus_orden`
  ADD CONSTRAINT `ID_ESTADO2` FOREIGN KEY (`id_estado`) REFERENCES `mnt_estatus` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_ESTADO_ORDEN` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id_orden`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO2` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
