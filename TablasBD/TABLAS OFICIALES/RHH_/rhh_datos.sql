SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


INSERT INTO `rhh_asistencia` VALUES
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

INSERT INTO `rhh_cargo` VALUES
(1, '2016-05-02 16:30:10', 'ADM001', 'Administrativo', 'Tipo 1', 'Ninguna'),
(2, '2016-05-02 16:45:36', 'ADM002', 'Administrativo', 'Tipo 2', 'Ninguna');

INSERT INTO `rhh_configuracion_asistencia` VALUES
(13, '2016-03-28 17:42:14', 45);

INSERT INTO `rhh_configuracion_ausentismo` VALUES
(29, '2016-05-12 14:21:06', 'PERMISO', 'Día de Bachaqueo', 1, 1, 4),
(30, '2016-05-18 13:07:53', 'PERMISO', 'Post-Natal..', 1, 1, 4),
(33, '2016-05-18 15:15:29', 'REPOSO', 'Reposo Ordinario', 1, 30, 1);

INSERT INTO `rhh_jornada_laboral` VALUES
(4, '2016-05-05 13:02:36', '07:00:00', '16:00:00', 1, '3', 1, 2, 'a:4:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";}');

INSERT INTO `rhh_jornada_tipo` VALUES
(1, '2016-05-25 19:15:52', 'Diurno'),
(2, '2016-05-25 19:15:52', 'Nocturno'),
(3, '2016-05-25 19:16:41', 'Tiempo Completo'),
(4, '2016-05-25 19:16:41', 'Diurno y Nocturno');

INSERT INTO `rhh_nota` VALUES
(3, '2016-05-05 18:20:32', 'The Golden Age is Over.', 'Entrada', 19919468, 6, '06 hr y 20 min', '2016-05-05'),
(5, '2016-05-09 13:29:57', 'Me quedé despierto video el episodio de Game of Thrones', 'Entrada', 19919468, 10, '01 hr y 29 min', '2016-05-09'),
(7, '2016-05-09 18:07:07', 'Había harina y no era por número de cédula en el Panda que está cerca de mi casa', 'Entrada', 10037592, 12, '00 hr y 00 min', '2016-05-09'),
(8, '2016-05-10 23:41:21', 'Through the tides of the ocean', 'Entrada', 19919468, 13, '11 hr y 11 min', '2016-05-10'),
(9, '2016-05-16 12:22:55', 'Esto es una prueba', 'Entrada', 19919468, 17, '01 hr y 22 min', '2016-05-16'),
(26, '2016-05-30 17:08:45', 'Un ejemplo de una entrada tarde.', 'Entrada', 19919468, 25, '06 hr y 08 min', '2016-05-30'),
(28, '2016-05-30 17:12:30', 'Ejemplo de una salida temprano', 'Salida', 19919468, 25, '01 hr y 47 min', '2016-05-30'),
(31, '2016-05-30 19:08:17', '', 'Entrada', 19919468, 26, '08 hr y 08 min', '2016-05-30'),
(32, '2016-05-31 11:11:47', '', 'Salida', 19919468, 27, '09 hr y 04 min', '2016-05-31');

INSERT INTO `rhh_periodo_no_laboral` VALUES
(1, '2016-04-25 19:00:16', 'Día de las Madres', 'Es el día en que celebras tu propia existencia.', '2016-05-08', '2016-05-08'),
(9, '2016-04-26 13:47:08', 'Día de Vampire Weekend', 'Hoy es el día de rendir tributo a la banda indie mas mainstream del final de la década de los 2000''s', '2016-05-18', '2016-06-01');

INSERT INTO `rhh_trabajador_cargo` VALUES
(2, '2016-05-16 12:20:16', 19919468, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
