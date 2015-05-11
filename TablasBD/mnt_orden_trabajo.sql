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

------------------------------------------------------------
