-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 11-05-2015 a las 10:06:01
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

--
-- Volcado de datos para la tabla `mnt_orden_trabajo`
--

INSERT INTO `mnt_orden_trabajo` (`id_orden`, `id_tipo`, `nombre_contacto`, `telefono_contacto`, `asunto`, `descripcion_general`, `dependencia`, `ubicacion`) VALUES
(1, 2, 'Manuel Perez', 2147483647, 'TECHO DAÑADO', 'REVISAR EL TECHO YA QUE TIENE GOTERAS DEL LADO DONDE ESTA LA PUERTA PRINCIPAL', 2, 1),
(2, 1, 'CESAR RONDON', 2147483647, 'TUBERIA DAÑADA', 'HAY UN BOTE DE AGUA EN EL BAÑO DEL DECANATO', 9, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
