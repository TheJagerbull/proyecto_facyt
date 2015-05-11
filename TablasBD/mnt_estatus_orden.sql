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

----------------------------------------------------------
