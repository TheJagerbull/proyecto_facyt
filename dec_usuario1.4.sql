-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 08, 2015 at 12:31 PM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `deca_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `dec_usuario`
--

CREATE TABLE IF NOT EXISTS `dec_usuario` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `password` text NOT NULL,
  `nombre` varchar(63) NOT NULL,
  `apellido` varchar(63) NOT NULL,
  `cargo` varchar(25) NOT NULL,
  `email` text,
  `telefono` varchar(25) NOT NULL,
  `dependencia` varchar(25) NOT NULL,
  `tipo` enum('docente','administrativo','obrero') NOT NULL,
  `observacion` text,
  `sys_rol` enum('autoridad','asist_autoridad','jefe_alm','director_dep','asistente_dep','ayudante_alm') NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dec_usuario`
--

INSERT INTO `dec_usuario` (`ID`, `TIME`, `id_usuario`, `password`, `nombre`, `apellido`, `cargo`, `email`, `telefono`, `dependencia`, `tipo`, `observacion`, `sys_rol`) VALUES
(1, '2015-04-07 15:25:55', '00000001', '53506cf6b8a85c19c79b64e4f9d279c512b5903c', 'Autoridad', 'Prueba', 'desarrollo', 'luigiepa87@gmail.com', '04244415320', 'Telematica', 'administrativo', 'cargo provicional para pruebas y desarrollo del sistema', 'autoridad'),
(2, '2015-03-27 13:29:53', '00000002', 'de184025b0c30b55e42d889148417b222b3799d3', 'jefe', 'Almacen', 'desarrollo', NULL, '04244415320', 'telematica', 'administrativo', NULL, 'jefe_alm'),
(3, '2015-04-06 13:46:54', '00000003', '1de3fac69a2b1ccf1b05799aea46f6192298b052', 'director', 'departamento', 'desarrollo', NULL, '04244415320', 'telematica', 'administrativo', NULL, 'asistente_dep');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
