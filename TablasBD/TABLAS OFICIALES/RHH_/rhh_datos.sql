-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 15-06-2016 a las 12:28:03
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
CREATE DATABASE IF NOT EXISTS `deca_admin` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `deca_admin`;

--
-- Truncar tablas antes de insertar `rhh_asistencia`
--

TRUNCATE TABLE `rhh_asistencia`;
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
(33, '2016-06-15 15:36:24', '11:36:24', '11:46:54', '2016-06-13', '2016-06-19', '19919468', '2016-06-15');

--
-- Truncar tablas antes de insertar `rhh_ausentismo_permiso`
--

TRUNCATE TABLE `rhh_ausentismo_permiso`;
--
-- Truncar tablas antes de insertar `rhh_ausentismo_reposo`
--

TRUNCATE TABLE `rhh_ausentismo_reposo`;
--
-- Truncar tablas antes de insertar `rhh_aval`
--

TRUNCATE TABLE `rhh_aval`;
--
-- Truncar tablas antes de insertar `rhh_cargo`
--

TRUNCATE TABLE `rhh_cargo`;
--
-- Volcado de datos para la tabla `rhh_cargo`
--

INSERT INTO `rhh_cargo` (`ID`, `TIME`, `codigo`, `nombre`, `tipo`, `descripcion`) VALUES
(1, '2016-05-02 16:30:10', 'ADMIN001', 'Administrativo', 'Tipo 1', 'Ninguna'),
(2, '2016-05-02 16:45:36', 'ADMIN002', 'Administrativo', 'Tipo 2', 'Ninguna'),
(3, '2016-06-04 15:56:14', 'ADMIN003', 'Administrativo', 'Tipo 3', 'Nada'),
(4, '2016-06-06 14:37:22', 'PIPSU001', 'PIPSU', 'Tiempo Completo', 'PIPSU Tiempo Completo');

--
-- Truncar tablas antes de insertar `rhh_configuracion_asistencia`
--

TRUNCATE TABLE `rhh_configuracion_asistencia`;
--
-- Volcado de datos para la tabla `rhh_configuracion_asistencia`
--

INSERT INTO `rhh_configuracion_asistencia` (`ID`, `TIME`, `minimo_horas_ausentes_sem`) VALUES
(13, '2016-03-28 17:42:14', 45);

--
-- Truncar tablas antes de insertar `rhh_configuracion_ausentismo`
--

TRUNCATE TABLE `rhh_configuracion_ausentismo`;
--
-- Volcado de datos para la tabla `rhh_configuracion_ausentismo`
--

INSERT INTO `rhh_configuracion_ausentismo` (`ID`, `TIME`, `tipo`, `nombre`, `minimo_dias_permiso`, `maximo_dias_permiso`, `tipo_dias`, `cantidad_maxima_mensual`, `soportes`) VALUES
(42, '2016-06-14 11:38:02', 'PERMISO', 'PRENATAL (NACIMIENTO)', 30, 30, 'Continuos', 1, ''),
(43, '2016-06-14 11:38:29', 'PERMISO', 'POSTNATAL (NACIMIENTO)', 110, 140, 'Hábiles', 1, ''),
(44, '2016-06-14 15:58:54', 'PERMISO', 'PRENATAL (ADOPCION) - MADRE', 70, 70, 'Hábiles', 1, 'Fallo del Juez\nOtra Cosa\nBlah blah'),
(45, '2016-06-14 17:11:27', 'PERMISO', 'PRENATAL (NACIMIENTO) - PADRE', 15, 30, 'Continuos', 1, ''),
(46, '2016-06-14 18:16:37', 'PERMISO', 'MATRIMONIO', 12, 12, 'Hábiles', 1, ''),
(47, '2016-06-14 18:46:39', 'PERMISO', 'MUERTE DE CONYUGE', 10, 15, 'Hábiles', 5, ''),
(48, '2016-06-15 15:49:47', 'REPOSO', 'REPOSO MÉDICO', 21, 356, 'Continuos', 365, '');

--
-- Truncar tablas antes de insertar `rhh_expediente_trabajador`
--

TRUNCATE TABLE `rhh_expediente_trabajador`;
--
-- Truncar tablas antes de insertar `rhh_jornada_laboral`
--

TRUNCATE TABLE `rhh_jornada_laboral`;
--
-- Volcado de datos para la tabla `rhh_jornada_laboral`
--

INSERT INTO `rhh_jornada_laboral` (`ID`, `TIME`, `hora_inicio`, `hora_fin`, `tolerancia`, `tipo`, `cantidad_horas_descanso`, `id_cargo`, `dias_jornada`) VALUES
(4, '2016-05-05 13:02:36', '07:00:00', '16:00:00', 1, '3', 1, 2, 'a:6:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"5";i:5;s:1:"6";}'),
(5, '2016-06-04 15:19:37', '07:00:00', '12:00:00', 0, '1', 1, 1, 'a:5:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"5";}'),
(25, '2016-06-04 17:08:16', '08:30:00', '12:00:00', 1, '1', 1, 3, 'a:5:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"5";}'),
(26, '2016-06-06 14:39:31', '06:00:00', '17:00:00', 1, '1', 0, 4, 'a:4:{i:0;s:1:"0";i:1;s:1:"2";i:2;s:1:"4";i:3;s:1:"6";}');

--
-- Truncar tablas antes de insertar `rhh_jornada_tipo`
--

TRUNCATE TABLE `rhh_jornada_tipo`;
--
-- Volcado de datos para la tabla `rhh_jornada_tipo`
--

INSERT INTO `rhh_jornada_tipo` (`ID`, `TIME`, `tipo`) VALUES
(1, '2016-05-25 19:15:52', 'Diurno'),
(2, '2016-05-25 19:15:52', 'Nocturno'),
(3, '2016-05-25 19:16:41', 'Tiempo Completo'),
(4, '2016-05-25 19:16:41', 'Diurno y Nocturno');

--
-- Truncar tablas antes de insertar `rhh_nota`
--

TRUNCATE TABLE `rhh_nota`;
--
-- Volcado de datos para la tabla `rhh_nota`
--

INSERT INTO `rhh_nota` (`ID`, `TIME`, `cuerpo_nota`, `tipo`, `id_trabajador`, `id_asistencia`, `tiempo_retraso`, `fecha`) VALUES
(3, '2016-05-05 18:20:32', 'The Golden Age is Over.', 'Entrada', 19919468, 6, '06 hr y 20 min', '2016-05-05'),
(7, '2016-05-09 18:07:07', 'Había harina y no era por número de cédula en el Panda que está cerca de mi casa', 'Entrada', 10037592, 12, '00 hr y 00 min', '2016-05-09'),
(26, '2016-05-30 17:08:45', 'Un ejemplo de una entrada tarde.', 'Entrada', 19919468, 25, '06 hr y 08 min', '2016-05-30'),
(28, '2016-05-30 17:12:30', 'Ejemplo de una salida temprano', 'Salida', 19919468, 25, '01 hr y 47 min', '2016-05-30'),
(31, '2016-05-30 19:08:17', '', 'Entrada', 19919468, 26, '08 hr y 08 min', '2016-05-30'),
(32, '2016-05-31 11:11:47', '', 'Salida', 19919468, 27, '09 hr y 04 min', '2016-05-31'),
(33, '2016-06-04 14:17:24', '', 'Entrada', 19919468, 28, '03 hr y 17 min', '2016-06-04'),
(34, '2016-06-04 14:24:20', '', 'Salida', 19919468, 28, '05 hr y 37 min', '2016-06-04'),
(35, '2016-06-06 12:42:53', '', 'Entrada', 19919468, 29, '01 hr y 42 min', '2016-06-06'),
(36, '2016-06-06 13:43:35', '', 'Salida', 0, 0, '', '2016-06-06'),
(37, '2016-06-06 13:43:49', '', 'Salida', 19919468, 29, '06 hr y 16 min', '2016-06-06'),
(38, '2016-06-09 13:49:49', '', 'Entrada', 19919468, 30, '02 hr y 49 min', '2016-06-09'),
(39, '2016-06-15 12:28:28', '', 'Salida', 19919468, 32, '07 hr y 41 min', '2016-06-15'),
(40, '2016-06-15 14:39:46', '', 'Salida', 19919468, 32, '05 hr y 20 min', '2016-06-15');

--
-- Truncar tablas antes de insertar `rhh_periodo_no_laboral`
--

TRUNCATE TABLE `rhh_periodo_no_laboral`;
--
-- Volcado de datos para la tabla `rhh_periodo_no_laboral`
--

INSERT INTO `rhh_periodo_no_laboral` (`ID`, `TIME`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_fin`) VALUES
(10, '2016-06-04 14:37:36', 'Vacaciones I-2016', 'Periodo vacacional I del año 2016', '2016-06-17', '2016-06-30'),
(11, '2016-06-06 14:05:24', 'Mes de Junio', 'Este es un mes completo.', '2016-06-01', '2016-06-30');

--
-- Truncar tablas antes de insertar `rhh_trabajador_aprueba_ausentismo`
--

TRUNCATE TABLE `rhh_trabajador_aprueba_ausentismo`;
--
-- Truncar tablas antes de insertar `rhh_trabajador_cargo`
--

TRUNCATE TABLE `rhh_trabajador_cargo`;
--
-- Volcado de datos para la tabla `rhh_trabajador_cargo`
--

INSERT INTO `rhh_trabajador_cargo` (`ID`, `TIME`, `id_trabajador`, `id_cargo`) VALUES
(2, '2016-05-16 12:20:16', 19919468, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
