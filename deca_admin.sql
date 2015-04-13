-- phpMyAdmin SQL Dump
-- version 4.0.10.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 18, 2015 at 10:06 AM
-- Server version: 5.1.73
-- PHP Version: 5.3.3

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
-- Table structure for table `alm_aprueba`
--

CREATE TABLE IF NOT EXISTS `alm_aprueba` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `id_usuario` (`id_usuario`,`nr_solicitud`),
  UNIQUE KEY `ID` (`ID`),
  KEY `nr_solicitud` (`nr_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alm_articulo`
--

CREATE TABLE IF NOT EXISTS `alm_articulo` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_articulo` varchar(10) CHARACTER SET utf8 NOT NULL,
  `unidad` varchar(9) CHARACTER SET utf8 NOT NULL,
  `descripcion` text CHARACTER SET utf8 NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `categoria` varchar(10) CHARACTER SET utf8 NOT NULL,
  `nuevo` tinyint(1) NOT NULL,
  `imagen` text CHARACTER SET utf8 NOT NULL,
  `disp` int(11) NOT NULL,
  `reserv` int(11) NOT NULL,
  `peso_kg` int(11) DEFAULT NULL,
  `dimension_cm` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `nivel_reab` int(11) DEFAULT NULL,
  `stock_min` int(11) DEFAULT NULL,
  `stock_max` int(11) DEFAULT NULL,
  PRIMARY KEY (`cod_articulo`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alm_categoria`
--

CREATE TABLE IF NOT EXISTS `alm_categoria` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_categoria` varchar(9) NOT NULL,
  `descripcion` text,
  `nombre` text NOT NULL,
  PRIMARY KEY (`cod_categoria`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alm_consulta`
--

CREATE TABLE IF NOT EXISTS `alm_consulta` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `cod_categoria` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `id_usuario` (`id_usuario`),
  KEY `cod_categoria` (`cod_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alm_contiene`
--

CREATE TABLE IF NOT EXISTS `alm_contiene` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_articulo` varchar(9) NOT NULL,
  `NRS` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL,
  `cant_solicitada` int(11) NOT NULL,
  `cant_aprobada` int(11) NOT NULL,
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `cont_histo_solicitud` (`cod_articulo`,`NRS`,`nr_solicitud`),
  KEY `NRS` (`NRS`),
  KEY `nr_solicitud` (`nr_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alm_genera`
--

CREATE TABLE IF NOT EXISTS `alm_genera` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `genera` (`id_usuario`,`nr_solicitud`),
  KEY `nr_solicitud` (`nr_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alm_genera_hist_a`
--

CREATE TABLE IF NOT EXISTS `alm_genera_hist_a` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_articulo` varchar(9) NOT NULL,
  `id_historial_a` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `id_articulo` (`id_articulo`),
  UNIQUE KEY `historial_articulo` (`id_articulo`,`id_historial_a`),
  KEY `id_historial_a` (`id_historial_a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alm_historial_a`
--

CREATE TABLE IF NOT EXISTS `alm_historial_a` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_historial_a` varchar(15) NOT NULL,
  `entrada` int(11) DEFAULT NULL,
  `salida` int(11) DEFAULT NULL,
  `observacion` text,
  `por_usuario` varchar(9) NOT NULL,
  PRIMARY KEY (`id_historial_a`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alm_historial_s`
--

CREATE TABLE IF NOT EXISTS `alm_historial_s` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `NRS` varchar(10) NOT NULL,
  `fecha_gen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_ap` timestamp NULL DEFAULT NULL,
  `fecha_desp` timestamp NULL DEFAULT NULL,
  `fecha_comp` timestamp NULL DEFAULT NULL,
  `usuario_gen` varchar(9) NOT NULL,
  `usuario_ap` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`NRS`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alm_pertenece`
--

CREATE TABLE IF NOT EXISTS `alm_pertenece` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_cartegoria` varchar(9) NOT NULL,
  `cod_articulo` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `cod_articulo` (`cod_articulo`),
  UNIQUE KEY `cod_cartegoria` (`cod_cartegoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alm_retira`
--

CREATE TABLE IF NOT EXISTS `alm_retira` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nr_solicitud` varchar(9) NOT NULL,
  `cod_articulo` varchar(9) NOT NULL,
  `id_usuario` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `traslado_articulo` (`nr_solicitud`,`cod_articulo`,`id_usuario`),
  KEY `cod_articulo` (`cod_articulo`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alm_solicitud`
--

CREATE TABLE IF NOT EXISTS `alm_solicitud` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL,
  `status` enum('carrito','en_proceso','aprobada','enviado','completado') NOT NULL,
  `observacion` text,
  `fecha_gen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_comp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`nr_solicitud`),
  UNIQUE KEY `ID` (`ID`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
  `telefono` varchar(25) NOT NULL,
  `dependencia` varchar(25) NOT NULL,
  `observacion` text,
  `sys_rol` enum('autoridad','asist_autoridad','jefe_alm','director_dep','asistente_dep','ayudante_alm') NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `dec_usuario`
--

INSERT INTO `dec_usuario` (`ID`, `TIME`, `id_usuario`, `password`, `nombre`, `apellido`, `cargo`, `telefono`, `dependencia`, `observacion`, `sys_rol`) VALUES
(1, '2015-03-16 16:42:31', '00000001', '37a668a7ae9501af42255f27d26449b309770222', 'autoridad', 'prueba', 'desarrollo', '04244415320', 'telematica', 'cargo provicional para pruebas y desarrollo del sistema', 'autoridad'),
(2, '2015-03-16 16:44:24', '00000002', 'de184025b0c30b55e42d889148417b222b3799d3', 'jefe', 'Almacen', 'desarrollo', '04244415320', 'telematica', NULL, 'jefe_alm'),
(3, '2015-03-16 16:46:10', '00000003', '1de3fac69a2b1ccf1b05799aea46f6192298b052', 'director', 'departamento', 'desarrollo', '04244415320', 'telematica', NULL, 'director_dep'),
(4, '2015-04-13 20:18:54', '13989244', 'db23591a4d3e3129c9b73dc7dc9ecdd475e96b06', 'Jose', 'Henriquez', 'TIC', 'jahenriq@uc.edu.ve', '04124221729', 'OST', 'docente', NULL, 'autoridad');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alm_aprueba`
--
ALTER TABLE `alm_aprueba`
  ADD CONSTRAINT `alm_aprueba_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_aprueba_ibfk_2` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_consulta`
--
ALTER TABLE `alm_consulta`
  ADD CONSTRAINT `alm_consulta_ibfk_2` FOREIGN KEY (`cod_categoria`) REFERENCES `alm_categoria` (`cod_categoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_consulta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_contiene`
--
ALTER TABLE `alm_contiene`
  ADD CONSTRAINT `alm_contiene_ibfk_3` FOREIGN KEY (`NRS`) REFERENCES `alm_historial_s` (`NRS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_contiene_ibfk_1` FOREIGN KEY (`cod_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_contiene_ibfk_2` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_genera`
--
ALTER TABLE `alm_genera`
  ADD CONSTRAINT `alm_genera_ibfk_2` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_genera_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `alm_solicitud` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_genera_hist_a`
--
ALTER TABLE `alm_genera_hist_a`
  ADD CONSTRAINT `alm_genera_hist_a_ibfk_2` FOREIGN KEY (`id_historial_a`) REFERENCES `alm_historial_a` (`id_historial_a`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_genera_hist_a_ibfk_1` FOREIGN KEY (`id_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_pertenece`
--
ALTER TABLE `alm_pertenece`
  ADD CONSTRAINT `alm_pertenece_ibfk_1` FOREIGN KEY (`cod_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_retira`
--
ALTER TABLE `alm_retira`
  ADD CONSTRAINT `alm_retira_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_retira_ibfk_1` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_retira_ibfk_2` FOREIGN KEY (`cod_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
