-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-05-2015 a las 10:00:55
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
-- Estructura de tabla para la tabla `mnt_asigna_cuadrilla`
--

CREATE TABLE IF NOT EXISTS `mnt_asigna_cuadrilla` (
  `id_usuario` varchar(9) NOT NULL,
  `id_cuadrilla` bigint(20) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mnt_asigna_cuadrilla`
--
ALTER TABLE `mnt_asigna_cuadrilla`
  ADD PRIMARY KEY (`id_usuario`,`id_cuadrilla`,`id_orden_trabajo`),
  ADD KEY `id_trabajador` (`id_usuario`),
  ADD KEY `id_cuadrilla` (`id_cuadrilla`),
  ADD KEY `id_orden_trabajo` (`id_orden_trabajo`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mnt_asigna_cuadrilla`
--
ALTER TABLE `mnt_asigna_cuadrilla`
  ADD CONSTRAINT `ID_ASIGNA_CUADRILLA` FOREIGN KEY (`id_cuadrilla`) REFERENCES `mnt_cuadrilla` (`id_cuadrilla`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_ASIGNA_ORDEN2` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id_orden`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO6` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
