-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-05-2015 a las 10:02:42
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
-- Estructura de tabla para la tabla `mnt_orden_trabajo`
--

CREATE TABLE IF NOT EXISTS `mnt_orden_trabajo` (
  `id_orden` bigint(20) NOT NULL,
  `id_tipo` bigint(20) NOT NULL,
  `nombre_contacto` varchar(255) NOT NULL,
  `telefono_contacto` int(11) NOT NULL,
  `asunto` varchar(40) NOT NULL,
  `descripcion_general` mediumtext NOT NULL,
  `dependencia` bigint(20) NOT NULL,
  `ubicacion` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `mnt_orden_trabajo`
--
ALTER TABLE `mnt_orden_trabajo`
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `dependencia` (`dependencia`),
  ADD KEY `ubicacion` (`ubicacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `mnt_orden_trabajo`
--
ALTER TABLE `mnt_orden_trabajo`
  MODIFY `id_orden` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mnt_orden_trabajo`
--
ALTER TABLE `mnt_orden_trabajo`
  ADD CONSTRAINT `ID_ORDEN_DEPENDENCIA` FOREIGN KEY (`dependencia`) REFERENCES `dec_dependencia` (`id_dependencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_TIPO_ORDEN` FOREIGN KEY (`id_tipo`) REFERENCES `mnt_tipo_orden` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_UBICACION` FOREIGN KEY (`ubicacion`) REFERENCES `mnt_ubicaciones_dep` (`id_ubicacion`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
