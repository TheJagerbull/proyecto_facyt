-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-05-2015 a las 10:03:09
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
-- Estructura de tabla para la tabla `mnt_ubicaciones_dep`
--

CREATE TABLE IF NOT EXISTS `mnt_ubicaciones_dep` (
  `id_ubicacion` bigint(20) NOT NULL,
  `id_dependencia` bigint(20) NOT NULL,
  `oficina` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mnt_ubicaciones_dep`
--
ALTER TABLE `mnt_ubicaciones_dep`
  ADD PRIMARY KEY (`id_ubicacion`),
  ADD UNIQUE KEY `UBICA_DEPE` (`id_ubicacion`,`id_dependencia`),
  ADD KEY `id_dependencia` (`id_dependencia`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mnt_ubicaciones_dep`
--
ALTER TABLE `mnt_ubicaciones_dep`
  MODIFY `id_ubicacion` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mnt_ubicaciones_dep`
--
ALTER TABLE `mnt_ubicaciones_dep`
  ADD CONSTRAINT `mnt_ubicaciones_dep_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dec_dependencia` (`id_dependencia`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
