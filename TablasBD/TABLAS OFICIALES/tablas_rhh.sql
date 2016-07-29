-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 29-07-2016 a las 15:50:41
-- Versión del servidor: 5.5.50-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='guarda todos los registros de la asistencia' AUTO_INCREMENT=37 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Correspondencia entre jornada y cargo, para verificar en la asistencia' AUTO_INCREMENT=5 ;

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
  `tipo_dias` enum('Hábiles','Continuos','','') NOT NULL,
  `cantidad_maxima_mensual` int(11) NOT NULL,
  `soportes` text NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_periodo`
--

CREATE TABLE IF NOT EXISTS `rhh_periodo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `cant_dias` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

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
  `cant_dias` int(11) NOT NULL,
  `fecha_fin` date NOT NULL,
  `periodo` int(11) NOT NULL COMMENT 'id de la tabla período',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `periodo` (`periodo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

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
-- Filtros para la tabla `rhh_periodo_no_laboral`
--
ALTER TABLE `rhh_periodo_no_laboral`
  ADD CONSTRAINT `periodo_periodo_no_lab` FOREIGN KEY (`periodo`) REFERENCES `rhh_periodo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rhh_trabajador_cargo`
--
ALTER TABLE `rhh_trabajador_cargo`
  ADD CONSTRAINT `rhh_trabajador_cargo_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `rhh_cargo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
