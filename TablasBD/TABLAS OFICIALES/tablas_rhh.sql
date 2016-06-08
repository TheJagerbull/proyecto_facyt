-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 31-05-2016 a las 15:06:04
-- Versión del servidor: 5.5.49-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.17

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
-- Estructura de tabla para la tabla `rhh_asistencia`
--

CREATE TABLE IF NOT EXISTS `rhh_asistencia` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hora_entrada` time NOT NULL,
  `hora_salida` time NOT NULL,
  `fecha_inicio_semana` date NOT NULL,
  `fecha_fin_semana` date NOT NULL,
  `id_trabajador` varchar(9) NOT NULL,
  `dia` date NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_trabajador` (`id_trabajador`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `rhh_asistencia`
--

INSERT INTO `rhh_asistencia` (`ID`, `TIME`, `hora_entrada`, `hora_salida`, `fecha_inicio_semana`, `fecha_fin_semana`, `id_trabajador`, `dia`) VALUES
(6, '2016-05-05 18:20:32', '08:20:32', '14:58:59', '2016-05-02', '2016-05-08', '19919468', '2016-05-05'),
(7, '2016-05-06 11:10:32', '07:10:32', '07:19:09', '2016-05-02', '2016-05-08', '19919468', '2016-05-06'),
(10, '2016-05-09 13:29:57', '09:29:57', '18:53:24', '2016-05-09', '2016-05-15', '19919468', '2016-05-09'),
(12, '2016-05-09 18:07:07', '14:07:07', '14:08:11', '2016-05-09', '2016-05-15', '10037592', '2016-05-09'),
(13, '2016-05-10 23:41:21', '19:11:21', '00:00:00', '2016-05-09', '2016-05-15', '19919468', '2016-05-10'),
(17, '2016-05-16 12:22:54', '08:22:54', '15:21:57', '2016-05-16', '2016-05-22', '19919468', '2016-05-16'),
(18, '2016-05-17 13:14:08', '09:14:07', '15:21:46', '2016-05-16', '2016-05-22', '19919468', '2016-05-17'),
(19, '2016-05-18 11:07:06', '07:07:06', '00:00:00', '2016-05-16', '2016-05-22', '19919468', '2016-05-18'),
(20, '2016-05-23 14:32:27', '10:32:27', '14:45:56', '2016-05-23', '2016-05-29', '19919468', '2016-05-23'),
(26, '2016-05-30 19:08:17', '15:08:17', '00:00:00', '2016-05-30', '2016-06-05', '19919468', '2016-05-30'),
(27, '2016-05-31 10:55:04', '06:55:04', '06:55:22', '2016-05-30', '2016-06-05', '19919468', '2016-05-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_ausentismo_permiso`
--

CREATE TABLE IF NOT EXISTS `rhh_ausentismo_permiso` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_trabajador` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estatus` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `fecha_solicitud` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_ausentismo_reposo`
--

CREATE TABLE IF NOT EXISTS `rhh_ausentismo_reposo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_trabajador` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estatus` varchar(255) NOT NULL COMMENT 'Es estatus de un ausentismo está relacionado con la aprobación que da el encargado. Ej. “Aprobado, Negado.”',
  `fecha_solicitud` date NOT NULL COMMENT ' Fecha en la que el trabajador solicita el ausentismo en la base de datos. Se guarda automáticamente.',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `id_trabajador` (`id_trabajador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_aval`
--

CREATE TABLE IF NOT EXISTS `rhh_aval` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` varchar(255) NOT NULL,
  `ubicacion_archivo` text NOT NULL,
  `id_ausentismo` int(11) NOT NULL COMMENT 'Aqui el valor proviene de la tabla rhh_ausentismo_permiso o rhh_ausentismo_reposo',
  `fecha_agregado` date NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_ausentismo` (`id_ausentismo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_cargo`
--

CREATE TABLE IF NOT EXISTS `rhh_cargo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `codigo` varchar(225) NOT NULL,
  `nombre` varchar(225) NOT NULL,
  `tipo` varchar(225) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `nombre` (`nombre`,`tipo`),
  UNIQUE KEY `nombre_2` (`nombre`,`tipo`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Correspondencia entre jornada y cargo, para verificar en la asistencia' AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `rhh_cargo`
--

INSERT INTO `rhh_cargo` (`ID`, `TIME`, `codigo`, `nombre`, `tipo`, `descripcion`) VALUES
(1, '2016-05-02 16:30:10', 'ADM001', 'Administrativo', 'Tipo 1', 'Ninguna'),
(2, '2016-05-02 16:45:36', 'ADM002', 'Administrativo', 'Tipo 2', 'Ninguna');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_configuracion_asistencia`
--

CREATE TABLE IF NOT EXISTS `rhh_configuracion_asistencia` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `minimo_horas_ausentes_sem` int(11) NOT NULL COMMENT 'Mínimo de hora semanales que puede tener de retraso el trabajador. Parámetro de configuración de la aplicación.  Parte de su uso recae en rhh_asistencia.fecha_inicio_semana y rhh_asistencia.fecha_fin_semana',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Volcado de datos para la tabla `rhh_configuracion_asistencia`
--

INSERT INTO `rhh_configuracion_asistencia` (`ID`, `TIME`, `minimo_horas_ausentes_sem`) VALUES
(13, '2016-03-28 17:42:14', 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_configuracion_ausentismo`
--

CREATE TABLE IF NOT EXISTS `rhh_configuracion_ausentismo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `minimo_dias_permiso` int(11) NOT NULL,
  `maximo_dias_permiso` int(11) NOT NULL,
  `cantidad_maxima_mensual` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

--
-- Volcado de datos para la tabla `rhh_configuracion_ausentismo`
--

INSERT INTO `rhh_configuracion_ausentismo` (`ID`, `TIME`, `tipo`, `nombre`, `minimo_dias_permiso`, `maximo_dias_permiso`, `cantidad_maxima_mensual`) VALUES
(29, '2016-05-12 14:21:06', 'PERMISO', 'Día de Bachaqueo', 1, 1, 4),
(30, '2016-05-18 13:07:53', 'PERMISO', 'Post-Natal', 1, 2, 4),
(33, '2016-05-18 15:15:29', 'REPOSO', 'Reposo Ordinario', 1, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_expediente_trabajador`
--

CREATE TABLE IF NOT EXISTS `rhh_expediente_trabajador` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_creado` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_jornada_laboral`
--

CREATE TABLE IF NOT EXISTS `rhh_jornada_laboral` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `tolerancia` int(11) NOT NULL COMMENT 'después de la hora de inicio en el cual se considera como la cantidad de tiempo de retardo máximo que puede tener el trabajador sin que se tome con una falta',
  `tipo` varchar(255) NOT NULL,
  `cantidad_horas_descanso` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `dias_jornada` varchar(200) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `id_cargo` (`id_cargo`),
  KEY `tipo` (`tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Volcado de datos para la tabla `rhh_jornada_laboral`
--

INSERT INTO `rhh_jornada_laboral` (`ID`, `TIME`, `hora_inicio`, `hora_fin`, `tolerancia`, `tipo`, `cantidad_horas_descanso`, `id_cargo`, `dias_jornada`) VALUES
(4, '2016-05-05 13:02:36', '07:00:00', '16:00:00', 1, '3', 1, 2, 'a:4:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_jornada_tipo`
--

CREATE TABLE IF NOT EXISTS `rhh_jornada_tipo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` varchar(225) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Para servir de parametros al tipo de la tabla rrh_jornada' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `rhh_jornada_tipo`
--

INSERT INTO `rhh_jornada_tipo` (`ID`, `TIME`, `tipo`) VALUES
(1, '2016-05-25 19:15:52', 'Diurno'),
(2, '2016-05-25 19:15:52', 'Nocturno'),
(3, '2016-05-25 19:16:41', 'Tiempo Completo'),
(4, '2016-05-25 19:16:41', 'Diurno y Nocturno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_nota`
--

CREATE TABLE IF NOT EXISTS `rhh_nota` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cuerpo_nota` text NOT NULL,
  `tipo` varchar(225) NOT NULL COMMENT 'discrimirnar entre entrada o salida',
  `id_trabajador` int(11) NOT NULL,
  `id_asistencia` int(11) NOT NULL,
  `tiempo_retraso` varchar(225) NOT NULL COMMENT 'Contiene el tiempo de retraso calculado cuando se agrego la asistencia',
  `fecha` date NOT NULL COMMENT 'Fecha en la que se generó la nota',
  PRIMARY KEY (`ID`),
  KEY `id_trabajador` (`id_trabajador`),
  KEY `id_asistencia` (`id_asistencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `rhh_nota`
--

INSERT INTO `rhh_nota` (`ID`, `TIME`, `cuerpo_nota`, `tipo`, `id_trabajador`, `id_asistencia`, `tiempo_retraso`, `fecha`) VALUES
(3, '2016-05-05 18:20:32', 'The Golden Age is Over.', 'Entrada', 19919468, 6, '06 hr y 20 min', '2016-05-05'),
(5, '2016-05-09 13:29:57', 'Me quedé despierto video el episodio de Game of Thrones', 'Entrada', 19919468, 10, '01 hr y 29 min', '2016-05-09'),
(7, '2016-05-09 18:07:07', 'Había harina y no era por número de cédula en el Panda que está cerca de mi casa', 'Entrada', 10037592, 12, '00 hr y 00 min', '2016-05-09'),
(8, '2016-05-10 23:41:21', 'Through the tides of the ocean', 'Entrada', 19919468, 13, '11 hr y 11 min', '2016-05-10'),
(9, '2016-05-16 12:22:55', 'Esto es una prueba', 'Entrada', 19919468, 17, '01 hr y 22 min', '2016-05-16'),
(26, '2016-05-30 17:08:45', 'Un ejemplo de una entrada tarde.', 'Entrada', 19919468, 25, '06 hr y 08 min', '2016-05-30'),
(28, '2016-05-30 17:12:30', 'Ejemplo de una salida temprano', 'Salida', 19919468, 25, '01 hr y 47 min', '2016-05-30'),
(31, '2016-05-30 19:08:17', '', 'Entrada', 19919468, 26, '08 hr y 08 min', '2016-05-30'),
(32, '2016-05-31 11:11:47', '', 'Salida', 19919468, 27, '09 hr y 04 min', '2016-05-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_periodo_no_laboral`
--

CREATE TABLE IF NOT EXISTS `rhh_periodo_no_laboral` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `rhh_periodo_no_laboral`
--

INSERT INTO `rhh_periodo_no_laboral` (`ID`, `TIME`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_fin`) VALUES
(1, '2016-04-25 19:00:16', 'Día de las Madres', 'Es el día en que celebras tu propia existencia.', '2016-05-08', '2016-05-08'),
(9, '2016-04-26 13:47:08', 'Día de Vampire Weekend', 'Hoy es el día de rendir tributo a la banda indie mas mainstream del final de la década de los 2000''s', '2016-05-18', '2016-06-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_trabajador_aprueba_ausentismo`
--

CREATE TABLE IF NOT EXISTS `rhh_trabajador_aprueba_ausentismo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha` date NOT NULL,
  `id_trabajador_da` int(11) NOT NULL,
  `id_trabajador_recibe` int(11) NOT NULL,
  `id_ausentismo` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_trabajador_cargo`
--

CREATE TABLE IF NOT EXISTS `rhh_trabajador_cargo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_trabajador` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_trabajador` (`id_trabajador`),
  KEY `id_cargo` (`id_cargo`),
  KEY `id_cargo_2` (`id_cargo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Como no puedo modificar la tabla dec_usuario he creado mi propia tabla para manejar las jornadas y asociarlas a los cargos que estarán asociados a los usuarios.' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `rhh_trabajador_cargo`
--

INSERT INTO `rhh_trabajador_cargo` (`ID`, `TIME`, `id_trabajador`, `id_cargo`) VALUES
(2, '2016-05-16 12:20:16', 19919468, 2);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `rhh_asistencia`
--
ALTER TABLE `rhh_asistencia`
  ADD CONSTRAINT `asistencia_id_usuario` FOREIGN KEY (`id_trabajador`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rhh_jornada_laboral`
--
ALTER TABLE `rhh_jornada_laboral`
  ADD CONSTRAINT `rhh_jornada_laboral_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `rhh_cargo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rhh_trabajador_cargo`
--
ALTER TABLE `rhh_trabajador_cargo`
  ADD CONSTRAINT `rhh_trabajador_cargo_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `rhh_cargo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
