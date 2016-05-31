-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-12-2015 a las 11:46:07
-- Versión del servidor: 5.5.44-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.11

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
-- Estructura de tabla para la tabla `air_cntrl_mp_equipo`
--

CREATE TABLE IF NOT EXISTS `air_cntrl_mp_equipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_inv_equipo` int(11) NOT NULL,
  `id_air_tipo_eq` varchar(11) NOT NULL,
  `id_dec_dependencia` bigint(20) NOT NULL,
  `id_mnt_ubicaciones_dep` bigint(20) NOT NULL,
  `capacidad` varchar(200) NOT NULL,
  `fecha_mp` date NOT NULL,
  `periodo` int(11) NOT NULL,
  `creado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_inv_equipo` (`id_inv_equipo`),
  UNIQUE KEY `id_dec_dependencia` (`id_dec_dependencia`),
  UNIQUE KEY `id_mnt_ubicaciones_dep` (`id_mnt_ubicaciones_dep`),
  UNIQUE KEY `id_air_tipo_eq` (`id_air_tipo_eq`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `air_eq_item`
--

CREATE TABLE IF NOT EXISTS `air_eq_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_eq` varchar(10) NOT NULL,
  `id_item_mnt` varchar(10) NOT NULL,
  `valor` varchar(150) NOT NULL,
  `creado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_tipo_eq_2` (`id_tipo_eq`),
  UNIQUE KEY `id_item_mnt_2` (`id_item_mnt`),
  KEY `id_tipo_eq` (`id_tipo_eq`),
  KEY `id_item_mnt` (`id_item_mnt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `air_items_mant`
--

CREATE TABLE IF NOT EXISTS `air_items_mant` (
  `id` int(11) NOT NULL,
  `id_air_eq_item` int(11) NOT NULL,
  `id_air_mant_item` varchar(10) NOT NULL,
  `valor` varchar(10) NOT NULL,
  `observacion` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_air_eq_item` (`id_air_eq_item`),
  UNIQUE KEY `id_air_mant_item` (`id_air_mant_item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `air_mant_equipo`
--

CREATE TABLE IF NOT EXISTS `air_mant_equipo` (
  `id` int(10) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_mnt_orden` varchar(20) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `tipo_mant` varchar(1) NOT NULL,
  `observacion` text NOT NULL,
  `creado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modificado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_mnt_orden` (`id_mnt_orden`),
  UNIQUE KEY `id_equipo` (`id_equipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `air_mant_item`
--

CREATE TABLE IF NOT EXISTS `air_mant_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(10) NOT NULL,
  `desc` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `cod` (`cod`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `air_tipo_eq`
--

CREATE TABLE IF NOT EXISTS `air_tipo_eq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cod` varchar(11) NOT NULL,
  `desc` text NOT NULL,
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`cod`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_aprueba`
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
-- Estructura de tabla para la tabla `alm_articulo`
--

CREATE TABLE IF NOT EXISTS `alm_articulo` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_articulo` varchar(10) NOT NULL,
  `unidad` varchar(9) NOT NULL,
  `descripcion` text NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `imagen` text,
  `usados` int(11) DEFAULT NULL,
  `nuevos` int(11) DEFAULT NULL,
  `reserv` int(11) NOT NULL,
  `peso_kg` int(11) DEFAULT NULL,
  `dimension_cm` varchar(20) DEFAULT NULL,
  `nivel_reab` int(11) DEFAULT NULL,
  `stock_min` int(11) DEFAULT NULL,
  `stock_max` int(11) DEFAULT NULL,
  UNIQUE KEY `ID` (`ID`),
  KEY `cod_articulo` (`cod_articulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5001 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_categoria`
--

CREATE TABLE IF NOT EXISTS `alm_categoria` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_categoria` varchar(9) NOT NULL,
  `descripcion` text,
  `nombre` text NOT NULL,
  PRIMARY KEY (`cod_categoria`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_consulta`
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
-- Estructura de tabla para la tabla `alm_contiene`
--

CREATE TABLE IF NOT EXISTS `alm_contiene` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_articulo` bigint(20) NOT NULL,
  `NRS` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL,
  `cant_solicitada` int(11) NOT NULL,
  `cant_aprobada` int(11) DEFAULT NULL,
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `cont_histo_solicitud` (`id_articulo`,`nr_solicitud`,`NRS`),
  KEY `NRS` (`NRS`),
  KEY `nr_solicitud` (`nr_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_genera`
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
-- Estructura de tabla para la tabla `alm_genera_hist_a`
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
-- Estructura de tabla para la tabla `alm_historial_a`
--

CREATE TABLE IF NOT EXISTS `alm_historial_a` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_historial_a` varchar(15) NOT NULL,
  `entrada` int(11) DEFAULT NULL,
  `salida` int(11) DEFAULT NULL,
  `nuevo` tinyint(1) NOT NULL,
  `observacion` text,
  `por_usuario` varchar(9) NOT NULL,
  PRIMARY KEY (`id_historial_a`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_historial_s`
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
-- Estructura de tabla para la tabla `alm_pertenece`
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
-- Estructura de tabla para la tabla `alm_retira`
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
-- Estructura de tabla para la tabla `alm_solicitud`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dec_dependencia`
--

CREATE TABLE IF NOT EXISTS `dec_dependencia` (
  `id_dependencia` bigint(20) NOT NULL AUTO_INCREMENT,
  `dependen` text NOT NULL,
  PRIMARY KEY (`id_dependencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dec_tipo_equipo`
--

CREATE TABLE IF NOT EXISTS `dec_tipo_equipo` (
  `cod` int(11) NOT NULL,
  `desc` text NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dec_usuario`
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
  `id_dependencia` bigint(20) NOT NULL,
  `tipo` enum('docente','administrativo','obrero') NOT NULL,
  `observacion` text,
  `sys_rol` enum('autoridad','asist_autoridad','jefe_alm','jefe_mnt','director_dep','asistente_dep','ayudante_alm','resp_cuadrilla','no_visible') NOT NULL DEFAULT 'no_visible',
  `status` enum('activo','inactivo') NOT NULL DEFAULT 'inactivo',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `ID` (`ID`),
  KEY `id_dependencia` (`id_dependencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_equipos`
--

CREATE TABLE IF NOT EXISTS `inv_equipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `inv_uc` varchar(15) NOT NULL,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `tipo_eq` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tipo_eq` (`tipo_eq`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_asigna_cuadrilla`
--

CREATE TABLE IF NOT EXISTS `mnt_asigna_cuadrilla` (
  `id_usuario` varchar(9) NOT NULL,
  `id_cuadrilla` bigint(20) NOT NULL,
  `id_ordenes` bigint(20) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_cuadrilla`,`id_ordenes`) USING BTREE,
  KEY `id_trabajador` (`id_usuario`),
  KEY `id_cuadrilla` (`id_cuadrilla`),
  KEY `id_orden_trabajo` (`id_ordenes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_asigna_material`
--

CREATE TABLE IF NOT EXISTS `mnt_asigna_material` (
  `id_solicitud` bigint(20) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_usuario` varchar(9) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_solicitud`),
  UNIQUE KEY `id_orden_trabajo` (`id_orden_trabajo`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_ayudante_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_ayudante_orden` (
  `id_trabajador` varchar(9) NOT NULL,
  `id_orden_trabajo` varchar(20) NOT NULL,
  PRIMARY KEY (`id_trabajador`,`id_orden_trabajo`),
  KEY `id_orden` (`id_orden_trabajo`),
  KEY `id_usuario` (`id_trabajador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_cuadrilla`
--

CREATE TABLE IF NOT EXISTS `mnt_cuadrilla` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_trabajador_responsable` varchar(9) NOT NULL,
  `cuadrilla` varchar(30) NOT NULL,
  `icono` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_trabajador_responsable`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_estatus`
--

CREATE TABLE IF NOT EXISTS `mnt_estatus` (
  `id_estado` bigint(20) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_estatus_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_estatus_orden` (
  `id_estado` bigint(20) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL,
  `id_usuario` varchar(9) NOT NULL,
  `fecha_p` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `ID_UNICO_ESTADO` (`id_estado`,`id_orden_trabajo`,`id_usuario`,`fecha_p`),
  KEY `id_orden_trabajo` (`id_orden_trabajo`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_estado2` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_miembros_cuadrilla`
--

CREATE TABLE IF NOT EXISTS `mnt_miembros_cuadrilla` (
  `id_cuadrilla` bigint(20) NOT NULL,
  `id_trabajador` varchar(9) NOT NULL,
  KEY `id_usuario` (`id_trabajador`),
  KEY `id_cuadrilla` (`id_cuadrilla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_observacion_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_observacion_orden` (
  `id_usuario` varchar(9) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL,
  `id_observacion` bigint(20) NOT NULL AUTO_INCREMENT,
  `observac` text NOT NULL,
  PRIMARY KEY (`id_observacion`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_orden_trabajo` (`id_orden_trabajo`),
  KEY `id_observacion` (`id_observacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_orden_trabajo`
--

CREATE TABLE IF NOT EXISTS `mnt_orden_trabajo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_orden` varchar(20) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_tipo` bigint(20) NOT NULL,
  `nombre_contacto` varchar(255) NOT NULL,
  `telefono_contacto` varchar(25) NOT NULL,
  `asunto` varchar(40) NOT NULL,
  `descripcion_general` mediumtext NOT NULL,
  `motivo` mediumtext NOT NULL,
  `sugerencia` mediumtext NOT NULL,
  `dependencia` bigint(20) NOT NULL,
  `ubicacion` bigint(20) NOT NULL DEFAULT '1',
  `estatus` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_orden` (`id_orden`),
  KEY `id_tipo` (`id_tipo`),
  KEY `dependencia` (`dependencia`),
  KEY `ubicacion` (`ubicacion`),
  KEY `estatus` (`estatus`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_responsable_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_responsable_orden` (
  `id_responsable` varchar(9) NOT NULL,
  `tiene_cuadrilla` enum('si','no') NOT NULL DEFAULT 'no',
  `id_orden_trabajo` bigint(20) NOT NULL,
  PRIMARY KEY (`id_responsable`,`id_orden_trabajo`),
  KEY `id_orden` (`id_orden_trabajo`),
  KEY `id_usuario` (`id_responsable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_tipo_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_tipo_orden` (
  `id_tipo` bigint(20) NOT NULL AUTO_INCREMENT,
  `tipo_orden` varchar(25) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_ubicaciones_dep`
--

CREATE TABLE IF NOT EXISTS `mnt_ubicaciones_dep` (
  `id_ubicacion` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_dependencia` bigint(20) NOT NULL,
  `oficina` text NOT NULL,
  PRIMARY KEY (`id_ubicacion`,`id_dependencia`),
  KEY `id_dependencia` (`id_dependencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `air_cntrl_mp_equipo`
--
ALTER TABLE `air_cntrl_mp_equipo`
  ADD CONSTRAINT `air_cntrl_mp_equipo_ibfk_1` FOREIGN KEY (`id_inv_equipo`) REFERENCES `inv_equipos` (`id`),
  ADD CONSTRAINT `air_cntrl_mp_equipo_ibfk_2` FOREIGN KEY (`id_dec_dependencia`) REFERENCES `dec_dependencia` (`id_dependencia`),
  ADD CONSTRAINT `air_cntrl_mp_equipo_ibfk_3` FOREIGN KEY (`id_mnt_ubicaciones_dep`) REFERENCES `mnt_ubicaciones_dep` (`id_ubicacion`),
  ADD CONSTRAINT `air_cntrl_mp_equipo_ibfk_4` FOREIGN KEY (`id_air_tipo_eq`) REFERENCES `air_tipo_eq` (`cod`);

--
-- Filtros para la tabla `air_eq_item`
--
ALTER TABLE `air_eq_item`
  ADD CONSTRAINT `air_eq_item_ibfk_1` FOREIGN KEY (`id_tipo_eq`) REFERENCES `air_tipo_eq` (`cod`),
  ADD CONSTRAINT `air_eq_item_ibfk_2` FOREIGN KEY (`id_item_mnt`) REFERENCES `air_mant_item` (`cod`);

--
-- Filtros para la tabla `air_items_mant`
--
ALTER TABLE `air_items_mant`
  ADD CONSTRAINT `air_items_mant_ibfk_1` FOREIGN KEY (`id_air_eq_item`) REFERENCES `air_eq_item` (`id`),
  ADD CONSTRAINT `air_items_mant_ibfk_2` FOREIGN KEY (`id_air_mant_item`) REFERENCES `air_mant_item` (`cod`);

--
-- Filtros para la tabla `air_mant_equipo`
--
ALTER TABLE `air_mant_equipo`
  ADD CONSTRAINT `air_mant_equipo_ibfk_1` FOREIGN KEY (`id_mnt_orden`) REFERENCES `mnt_orden_trabajo` (`id_orden`),
  ADD CONSTRAINT `air_mant_equipo_ibfk_2` FOREIGN KEY (`id_equipo`) REFERENCES `inv_equipos` (`id`);

--
-- Filtros para la tabla `alm_aprueba`
--
ALTER TABLE `alm_aprueba`
  ADD CONSTRAINT `alm_aprueba_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_aprueba_ibfk_2` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `alm_consulta`
--
ALTER TABLE `alm_consulta`
  ADD CONSTRAINT `alm_consulta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_consulta_ibfk_2` FOREIGN KEY (`cod_categoria`) REFERENCES `alm_categoria` (`cod_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `alm_contiene`
--
ALTER TABLE `alm_contiene`
  ADD CONSTRAINT `alm_contiene_ibfk_2` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_contiene_ibfk_3` FOREIGN KEY (`NRS`) REFERENCES `alm_historial_s` (`NRS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_contiene_ibfk_4` FOREIGN KEY (`id_articulo`) REFERENCES `alm_articulo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `alm_genera`
--
ALTER TABLE `alm_genera`
  ADD CONSTRAINT `alm_genera_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `alm_solicitud` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_genera_ibfk_2` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `alm_genera_hist_a`
--
ALTER TABLE `alm_genera_hist_a`
  ADD CONSTRAINT `alm_genera_hist_a_ibfk_1` FOREIGN KEY (`id_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_genera_hist_a_ibfk_2` FOREIGN KEY (`id_historial_a`) REFERENCES `alm_historial_a` (`id_historial_a`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `alm_pertenece`
--
ALTER TABLE `alm_pertenece`
  ADD CONSTRAINT `alm_pertenece_ibfk_1` FOREIGN KEY (`cod_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `alm_retira`
--
ALTER TABLE `alm_retira`
  ADD CONSTRAINT `alm_retira_ibfk_1` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_retira_ibfk_2` FOREIGN KEY (`cod_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_retira_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `alm_solicitud`
--
ALTER TABLE `alm_solicitud`
  ADD CONSTRAINT `alm_solicitud_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`);

--
-- Filtros para la tabla `dec_usuario`
--
ALTER TABLE `dec_usuario`
  ADD CONSTRAINT `dec_usuario_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dec_dependencia` (`id_dependencia`);

--
-- Filtros para la tabla `inv_equipos`
--
ALTER TABLE `inv_equipos`
  ADD CONSTRAINT `inv_equipos_ibfk_1` FOREIGN KEY (`tipo_eq`) REFERENCES `air_tipo_eq` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mnt_asigna_cuadrilla`
--
ALTER TABLE `mnt_asigna_cuadrilla`
  ADD CONSTRAINT `ID_ASIGNA_CUADRILLA` FOREIGN KEY (`id_cuadrilla`) REFERENCES `mnt_cuadrilla` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO6` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mnt_asigna_cuadrilla_ibfk_1` FOREIGN KEY (`id_ordenes`) REFERENCES `mnt_orden_trabajo` (`id_orden`);

--
-- Filtros para la tabla `mnt_asigna_material`
--
ALTER TABLE `mnt_asigna_material`
  ADD CONSTRAINT `ID_ASIGNA_ORDEN` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO7` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mnt_ayudante_orden`
--
ALTER TABLE `mnt_ayudante_orden`
  ADD CONSTRAINT `mnt_ayudante_orden_ibfk_2` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id_orden`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mnt_ayudante_orden_ibfk_1` FOREIGN KEY (`id_trabajador`) REFERENCES `dec_usuario` (`id_usuario`);

--
-- Filtros para la tabla `mnt_cuadrilla`
--
ALTER TABLE `mnt_cuadrilla`
  ADD CONSTRAINT `ID_USUARIO_RESPONSABLE` FOREIGN KEY (`id_trabajador_responsable`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mnt_estatus_orden`
--
ALTER TABLE `mnt_estatus_orden`
  ADD CONSTRAINT `ID_ESTADO2` FOREIGN KEY (`id_estado`) REFERENCES `mnt_estatus` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_ESTADO_ORDEN` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO2` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mnt_miembros_cuadrilla`
--
ALTER TABLE `mnt_miembros_cuadrilla`
  ADD CONSTRAINT `ID_CUADRILLA` FOREIGN KEY (`id_cuadrilla`) REFERENCES `mnt_cuadrilla` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO5` FOREIGN KEY (`id_trabajador`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mnt_observacion_orden`
--
ALTER TABLE `mnt_observacion_orden`
  ADD CONSTRAINT `ID_OBSERVACION_ORDEN` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mnt_orden_trabajo`
--
ALTER TABLE `mnt_orden_trabajo`
  ADD CONSTRAINT `ID_ORDEN_DEPENDENCIA` FOREIGN KEY (`dependencia`) REFERENCES `dec_dependencia` (`id_dependencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_TIPO_ORDEN` FOREIGN KEY (`id_tipo`) REFERENCES `mnt_tipo_orden` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_UBICACION` FOREIGN KEY (`ubicacion`) REFERENCES `mnt_ubicaciones_dep` (`id_ubicacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mnt_orden_trabajo_ibfk_1` FOREIGN KEY (`estatus`) REFERENCES `mnt_estatus` (`id_estado`);

--
-- Filtros para la tabla `mnt_responsable_orden`
--
ALTER TABLE `mnt_responsable_orden`
  ADD CONSTRAINT `mnt_responsable_orden_ibfk_1` FOREIGN KEY (`id_responsable`) REFERENCES `dec_usuario` (`id_usuario`),
  ADD CONSTRAINT `mnt_responsable_orden_ibfk_2` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id_orden`);

--
-- Filtros para la tabla `mnt_ubicaciones_dep`
--
ALTER TABLE `mnt_ubicaciones_dep`
  ADD CONSTRAINT `mnt_ubicaciones_dep_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dec_dependencia` (`id_dependencia`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
