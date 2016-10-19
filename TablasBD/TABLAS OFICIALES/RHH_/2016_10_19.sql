-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 19-10-2016 a las 14:41:38
-- Versión del servidor: 5.7.15-0ubuntu0.16.04.1
-- Versión de PHP: 5.6.26-2+deb.sury.org~xenial+1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `deca_admin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_asistencia`
--

CREATE TABLE `rhh_asistencia` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hora_entrada` time NOT NULL,
  `hora_salida` time DEFAULT NULL,
  `fecha_inicio_semana` date NOT NULL,
  `fecha_fin_semana` date NOT NULL,
  `id_trabajador` varchar(9) NOT NULL,
  `dia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(27, '2016-05-31 10:55:04', '06:55:04', '06:55:22', '2016-05-30', '2016-06-05', '19919468', '2016-05-31'),
(28, '2016-06-04 14:17:24', '10:17:24', '10:22:21', '2016-05-30', '2016-06-05', '19919468', '2016-06-04'),
(29, '2016-06-06 12:42:53', '08:42:52', '09:43:46', '2016-06-06', '2016-06-12', '19919468', '2016-06-06'),
(30, '2016-06-09 13:49:48', '09:49:47', '00:00:00', '2016-06-06', '2016-06-12', '19919468', '2016-06-09'),
(31, '2016-06-14 11:12:38', '07:12:37', '22:51:06', '2016-06-13', '2016-06-19', '19919468', '2016-06-14'),
(33, '2016-06-15 15:36:24', '11:36:24', '11:46:54', '2016-06-13', '2016-06-19', '19919468', '2016-06-15'),
(34, '2016-10-17 19:05:45', '15:05:45', NULL, '2016-10-17', '2016-10-23', '19919468', '2016-10-17'),
(35, '2016-10-19 16:20:47', '12:20:47', NULL, '2016-10-17', '2016-10-23', '19919468', '2016-10-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_ausentismo_permiso`
--

CREATE TABLE `rhh_ausentismo_permiso` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_trabajador` int(11) NOT NULL,
  `id_tipo_ausentismo` int(11) NOT NULL COMMENT 'Referencia a una configuración de ausentismos',
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estatus` varchar(255) NOT NULL,
  `fecha_solicitud` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rhh_ausentismo_permiso`
--

INSERT INTO `rhh_ausentismo_permiso` (`ID`, `TIME`, `id_trabajador`, `id_tipo_ausentismo`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_final`, `estatus`, `fecha_solicitud`) VALUES
(11, '2016-10-17 14:35:23', 19919468, 43, 'POSTNATAL (NACIMIENTO)', 'TBA', '2016-10-17', '2017-05-09', 'TBA', '2016-10-17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_ausentismo_reposo`
--

CREATE TABLE `rhh_ausentismo_reposo` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_trabajador` int(11) NOT NULL,
  `id_tipo_ausentismo` int(11) NOT NULL COMMENT 'Referencia a una configuración de ausentismos',
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estatus` varchar(255) NOT NULL COMMENT 'Es estatus de un ausentismo está relacionado con la aprobación que da el encargado. Ej. “Aprobado, Negado.”',
  `fecha_solicitud` date NOT NULL COMMENT ' Fecha en la que el trabajador solicita el ausentismo en la base de datos. Se guarda automáticamente.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rhh_ausentismo_reposo`
--

INSERT INTO `rhh_ausentismo_reposo` (`ID`, `TIME`, `id_trabajador`, `id_tipo_ausentismo`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_final`, `estatus`, `fecha_solicitud`) VALUES
(10, '2016-10-10 15:33:59', 19919468, 39, 'OBRERO', 'TBA', '2016-10-10', '2016-10-30', 'TBA', '2016-10-10'),
(11, '2016-10-19 12:10:15', 19919468, 46, 'PROFESORES', 'TBA', '2016-10-19', '2016-11-06', 'TBA', '2016-10-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_aval`
--

CREATE TABLE `rhh_aval` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` varchar(255) NOT NULL,
  `ubicacion_archivo` text NOT NULL,
  `id_ausentismo` int(11) NOT NULL COMMENT 'Aqui el valor proviene de la tabla rhh_ausentismo_permiso o rhh_ausentismo_reposo',
  `fecha_agregado` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_cargo`
--

CREATE TABLE `rhh_cargo` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `codigo` varchar(225) NOT NULL,
  `nombre` varchar(225) NOT NULL,
  `tipo` varchar(225) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Correspondencia entre jornada y cargo, para verificar en la asistencia';

--
-- Volcado de datos para la tabla `rhh_cargo`
--

INSERT INTO `rhh_cargo` (`ID`, `TIME`, `codigo`, `nombre`, `tipo`, `descripcion`) VALUES
(1, '2016-05-02 16:30:10', 'ADMIN001', 'Administrativo', 'Tipo 1', 'Ninguna'),
(2, '2016-05-02 16:45:36', 'ADMIN002', 'Administrativo', 'Tipo 2', 'Ninguna'),
(3, '2016-06-04 15:56:14', 'ADMIN003', 'Administrativo', 'Tipo 3', 'Ninguna'),
(4, '2016-06-06 14:37:22', 'PIPSU001', 'PIPSU', 'Tiempo Completo', 'PIPSU Tiempo Completo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_configuracion_asistencia`
--

CREATE TABLE `rhh_configuracion_asistencia` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `minimo_horas_ausentes_sem` int(11) NOT NULL COMMENT 'Mínimo de hora semanales que puede tener de retraso el trabajador. Parámetro de configuración de la aplicación.  Parte de su uso recae en rhh_asistencia.fecha_inicio_semana y rhh_asistencia.fecha_fin_semana'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rhh_configuracion_asistencia`
--

INSERT INTO `rhh_configuracion_asistencia` (`ID`, `TIME`, `minimo_horas_ausentes_sem`) VALUES
(13, '2016-03-28 17:42:14', 45);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_configuracion_ausentismo`
--

CREATE TABLE `rhh_configuracion_ausentismo` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `minimo_dias_permiso` int(11) NOT NULL,
  `maximo_dias_permiso` int(11) NOT NULL,
  `tipo_dias` enum('Hábiles','Continuos','','') NOT NULL,
  `cantidad_maxima_mensual` int(11) NOT NULL,
  `soportes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rhh_configuracion_ausentismo`
--

INSERT INTO `rhh_configuracion_ausentismo` (`ID`, `TIME`, `tipo`, `nombre`, `minimo_dias_permiso`, `maximo_dias_permiso`, `tipo_dias`, `cantidad_maxima_mensual`, `soportes`) VALUES
(39, '2016-09-16 17:48:41', 'REPOSO', 'OBRERO', 1, 21, 'Continuos', 1, 'Justificativo'),
(42, '2016-06-14 11:38:02', 'PERMISO', 'PRENATAL (NACIMIENTO)', 30, 30, 'Continuos', 1, 'No se ha especificado alguno, aun'),
(43, '2016-06-14 11:38:29', 'PERMISO', 'POSTNATAL (NACIMIENTO)', 110, 140, 'Hábiles', 1, 'Soporte 1, soporte 2, Soporte 3, Soporte 4'),
(44, '2016-06-14 15:58:54', 'PERMISO', 'PRENATAL (ADOPCION) - MADRE', 70, 70, 'Hábiles', 1, 'Fallo del Juez, Otra Cosa, Blah blah'),
(45, '2016-06-14 17:11:27', 'PERMISO', 'PRENATAL (NACIMIENTO) - PADRE', 15, 30, 'Continuos', 1, ''),
(46, '2016-10-10 18:03:57', 'REPOSO', 'PROFESORES', 1, 21, 'Continuos', 1, 'Justificativo médico, otro tipo de reglamentación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_expediente_trabajador`
--

CREATE TABLE `rhh_expediente_trabajador` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_creado` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_jornada_laboral`
--

CREATE TABLE `rhh_jornada_laboral` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `tolerancia` int(11) NOT NULL COMMENT 'después de la hora de inicio en el cual se considera como la cantidad de tiempo de retardo máximo que puede tener el trabajador sin que se tome con una falta',
  `tipo` varchar(255) NOT NULL,
  `cantidad_horas_descanso` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL,
  `dias_jornada` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rhh_jornada_laboral`
--

INSERT INTO `rhh_jornada_laboral` (`ID`, `TIME`, `hora_inicio`, `hora_fin`, `tolerancia`, `tipo`, `cantidad_horas_descanso`, `id_cargo`, `dias_jornada`) VALUES
(4, '2016-05-05 13:02:36', '07:00:00', '16:00:00', 1, '3', 1, 2, 'a:5:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"5";}'),
(5, '2016-06-04 15:19:37', '07:00:00', '12:00:00', 0, '1', 1, 1, 'a:5:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"5";}'),
(25, '2016-06-04 17:08:16', '08:30:00', '12:00:00', 1, '1', 1, 3, 'a:5:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"5";}'),
(26, '2016-06-06 14:39:31', '06:00:00', '17:00:00', 1, '1', 0, 4, 'a:4:{i:0;s:1:"0";i:1;s:1:"2";i:2;s:1:"4";i:3;s:1:"6";}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_jornada_tipo`
--

CREATE TABLE `rhh_jornada_tipo` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Para servir de parametros al tipo de la tabla rrh_jornada';

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

CREATE TABLE `rhh_nota` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cuerpo_nota` text NOT NULL,
  `tipo` varchar(225) NOT NULL COMMENT 'discrimirnar entre entrada o salida',
  `id_trabajador` int(11) NOT NULL,
  `id_asistencia` int(11) NOT NULL,
  `tiempo_retraso` varchar(225) NOT NULL COMMENT 'Contiene el tiempo de retraso calculado cuando se agrego la asistencia',
  `fecha` date NOT NULL COMMENT 'Fecha en la que se generó la nota'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rhh_nota`
--

INSERT INTO `rhh_nota` (`ID`, `TIME`, `cuerpo_nota`, `tipo`, `id_trabajador`, `id_asistencia`, `tiempo_retraso`, `fecha`) VALUES
(3, '2016-05-05 18:20:32', 'The Golden Age is Over.', 'Entrada', 19919468, 6, '06 hr y 20 min', '2016-05-05'),
(7, '2016-05-09 18:07:07', 'Había harina y no era por número de cédula en el Panda que está cerca de mi casa', 'Entrada', 10037592, 12, '00 hr y 00 min', '2016-05-09'),
(26, '2016-05-30 17:08:45', 'Un ejemplo de una entrada tarde.', 'Entrada', 19919468, 25, '06 hr y 08 min', '2016-05-30'),
(28, '2016-05-30 17:12:30', 'Ejemplo de una salida temprano', 'Salida', 19919468, 25, '01 hr y 47 min', '2016-05-30'),
(36, '2016-06-06 13:43:35', '', 'Salida', 0, 0, '', '2016-06-06'),
(41, '2016-10-17 19:05:45', '', 'Entrada', 19919468, 34, '08 hr y 05 min', '2016-10-17'),
(42, '2016-10-19 16:20:47', '', 'Entrada', 19919468, 35, '05 hr y 20 min', '2016-10-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_periodo`
--

CREATE TABLE `rhh_periodo` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `cant_dias` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_periodo_no_laboral`
--

CREATE TABLE `rhh_periodo_no_laboral` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `cant_dias` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rhh_periodo_no_laboral`
--

INSERT INTO `rhh_periodo_no_laboral` (`ID`, `TIME`, `nombre`, `descripcion`, `cant_dias`, `fecha_inicio`, `fecha_fin`) VALUES
(10, '2016-06-04 14:37:36', 'Vacaciones I-2016', 'Periodo vacacional I del año 2016', 0, '2016-06-17', '2016-06-30'),
(11, '2016-06-06 14:05:24', 'Mes de Junio', 'Este es un mes completo.', 0, '2016-06-01', '2016-06-30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_trabajador_aprueba_ausentismo`
--

CREATE TABLE `rhh_trabajador_aprueba_ausentismo` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha` date NOT NULL,
  `id_trabajador_da` int(11) NOT NULL,
  `id_trabajador_recibe` int(11) NOT NULL,
  `id_ausentismo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_trabajador_cargo`
--

CREATE TABLE `rhh_trabajador_cargo` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_trabajador` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Como no puedo modificar la tabla dec_usuario he creado mi propia tabla para manejar las jornadas y asociarlas a los cargos que estarán asociados a los usuarios.';

--
-- Volcado de datos para la tabla `rhh_trabajador_cargo`
--

INSERT INTO `rhh_trabajador_cargo` (`ID`, `TIME`, `id_trabajador`, `id_cargo`) VALUES
(2, '2016-05-16 12:20:16', 19919468, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `rhh_asistencia`
--
ALTER TABLE `rhh_asistencia`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_trabajador` (`id_trabajador`);

--
-- Indices de la tabla `rhh_ausentismo_permiso`
--
ALTER TABLE `rhh_ausentismo_permiso`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_tipo_ausentismo` (`id_tipo_ausentismo`),
  ADD KEY `id_trabajador` (`id_trabajador`);

--
-- Indices de la tabla `rhh_ausentismo_reposo`
--
ALTER TABLE `rhh_ausentismo_reposo`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_tipo_ausentismo` (`id_tipo_ausentismo`),
  ADD KEY `id_trabajador` (`id_trabajador`) USING BTREE;

--
-- Indices de la tabla `rhh_aval`
--
ALTER TABLE `rhh_aval`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_ausentismo` (`id_ausentismo`);

--
-- Indices de la tabla `rhh_cargo`
--
ALTER TABLE `rhh_cargo`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `nombre` (`nombre`,`tipo`),
  ADD UNIQUE KEY `nombre_2` (`nombre`,`tipo`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indices de la tabla `rhh_configuracion_asistencia`
--
ALTER TABLE `rhh_configuracion_asistencia`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `rhh_configuracion_ausentismo`
--
ALTER TABLE `rhh_configuracion_ausentismo`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indices de la tabla `rhh_expediente_trabajador`
--
ALTER TABLE `rhh_expediente_trabajador`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `rhh_jornada_laboral`
--
ALTER TABLE `rhh_jornada_laboral`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `id_cargo` (`id_cargo`),
  ADD KEY `tipo` (`tipo`);

--
-- Indices de la tabla `rhh_jornada_tipo`
--
ALTER TABLE `rhh_jornada_tipo`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indices de la tabla `rhh_nota`
--
ALTER TABLE `rhh_nota`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_trabajador` (`id_trabajador`),
  ADD KEY `id_asistencia` (`id_asistencia`);

--
-- Indices de la tabla `rhh_periodo`
--
ALTER TABLE `rhh_periodo`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indices de la tabla `rhh_periodo_no_laboral`
--
ALTER TABLE `rhh_periodo_no_laboral`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indices de la tabla `rhh_trabajador_aprueba_ausentismo`
--
ALTER TABLE `rhh_trabajador_aprueba_ausentismo`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `rhh_trabajador_cargo`
--
ALTER TABLE `rhh_trabajador_cargo`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_trabajador` (`id_trabajador`),
  ADD KEY `id_cargo` (`id_cargo`),
  ADD KEY `id_cargo_2` (`id_cargo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `rhh_asistencia`
--
ALTER TABLE `rhh_asistencia`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT de la tabla `rhh_ausentismo_permiso`
--
ALTER TABLE `rhh_ausentismo_permiso`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `rhh_ausentismo_reposo`
--
ALTER TABLE `rhh_ausentismo_reposo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `rhh_aval`
--
ALTER TABLE `rhh_aval`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rhh_cargo`
--
ALTER TABLE `rhh_cargo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `rhh_configuracion_asistencia`
--
ALTER TABLE `rhh_configuracion_asistencia`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `rhh_configuracion_ausentismo`
--
ALTER TABLE `rhh_configuracion_ausentismo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT de la tabla `rhh_expediente_trabajador`
--
ALTER TABLE `rhh_expediente_trabajador`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rhh_jornada_laboral`
--
ALTER TABLE `rhh_jornada_laboral`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT de la tabla `rhh_jornada_tipo`
--
ALTER TABLE `rhh_jornada_tipo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `rhh_nota`
--
ALTER TABLE `rhh_nota`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT de la tabla `rhh_periodo`
--
ALTER TABLE `rhh_periodo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `rhh_periodo_no_laboral`
--
ALTER TABLE `rhh_periodo_no_laboral`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `rhh_trabajador_aprueba_ausentismo`
--
ALTER TABLE `rhh_trabajador_aprueba_ausentismo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rhh_trabajador_cargo`
--
ALTER TABLE `rhh_trabajador_cargo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `rhh_asistencia`
--
ALTER TABLE `rhh_asistencia`
  ADD CONSTRAINT `asistencia_id_usuario` FOREIGN KEY (`id_trabajador`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rhh_ausentismo_permiso`
--
ALTER TABLE `rhh_ausentismo_permiso`
  ADD CONSTRAINT `rhh_ausentismo_permiso_ibfk_1` FOREIGN KEY (`id_tipo_ausentismo`) REFERENCES `rhh_configuracion_ausentismo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rhh_ausentismo_reposo`
--
ALTER TABLE `rhh_ausentismo_reposo`
  ADD CONSTRAINT `rhh_ausentismo_reposo_ibfk_1` FOREIGN KEY (`id_tipo_ausentismo`) REFERENCES `rhh_configuracion_ausentismo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
