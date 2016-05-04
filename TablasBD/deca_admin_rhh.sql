-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-05-2016 a las 20:27:45
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.6.12

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
-- Estructura de tabla para la tabla `air_cntrl_mp_equipo`
--

CREATE TABLE IF NOT EXISTS `air_cntrl_mp_equipo` (
  `id` int(11) NOT NULL,
  `id_inv_equipo` int(11) NOT NULL,
  `id_air_tipo_eq` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `id_dec_dependencia` bigint(20) NOT NULL,
  `id_mnt_ubicaciones_dep` bigint(20) NOT NULL,
  `capacidad` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `fecha_mp` date NOT NULL,
  `periodo` int(11) NOT NULL,
  `creado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `air_eq_item`
--

CREATE TABLE IF NOT EXISTS `air_eq_item` (
  `id` int(11) NOT NULL,
  `id_tipo_eq` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `id_item_mnt` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `valor` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `creado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modificado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `air_items_mant`
--

CREATE TABLE IF NOT EXISTS `air_items_mant` (
  `id` int(11) NOT NULL,
  `id_air_eq_item` int(11) NOT NULL,
  `id_air_mant_item` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `valor` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `observacion` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `air_mant_equipo`
--

CREATE TABLE IF NOT EXISTS `air_mant_equipo` (
  `id` int(10) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_mnt_orden` varchar(20) CHARACTER SET utf8 NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `tipo_mant` varchar(1) CHARACTER SET utf8 NOT NULL,
  `observacion` text COLLATE utf8_spanish_ci NOT NULL,
  `creado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modificado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `air_mant_item`
--

CREATE TABLE IF NOT EXISTS `air_mant_item` (
  `id` int(11) NOT NULL,
  `cod` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `desc` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `air_tipo_eq`
--

CREATE TABLE IF NOT EXISTS `air_tipo_eq` (
  `id` int(11) NOT NULL,
  `cod` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `desc` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificado` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_aprueba`
--

CREATE TABLE IF NOT EXISTS `alm_aprueba` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_articulo`
--

CREATE TABLE IF NOT EXISTS `alm_articulo` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_articulo` varchar(10) CHARACTER SET utf8 NOT NULL,
  `unidad` varchar(9) CHARACTER SET utf8 NOT NULL,
  `descripcion` text CHARACTER SET utf8 NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `imagen` text CHARACTER SET utf8,
  `usados` int(11) DEFAULT '0',
  `nuevos` int(11) DEFAULT '0',
  `reserv` int(11) NOT NULL DEFAULT '0',
  `peso_kg` int(11) DEFAULT '0',
  `dimension_cm` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `nivel_reab` int(11) DEFAULT '0',
  `stock_min` int(11) DEFAULT '0',
  `stock_max` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_carrito`
--

CREATE TABLE IF NOT EXISTS `alm_carrito` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_carrito` varchar(9) NOT NULL,
  `observacion` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_car_contiene`
--

CREATE TABLE IF NOT EXISTS `alm_car_contiene` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_carrito` varchar(9) NOT NULL,
  `id_articulo` bigint(20) NOT NULL,
  `cant_solicitada` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_categoria`
--

CREATE TABLE IF NOT EXISTS `alm_categoria` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_categoria` varchar(9) NOT NULL,
  `descripcion` text,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_consulta`
--

CREATE TABLE IF NOT EXISTS `alm_consulta` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `cod_categoria` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_contiene`
--

CREATE TABLE IF NOT EXISTS `alm_contiene` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_articulo` bigint(20) NOT NULL,
  `NRS` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL,
  `cant_solicitada` int(11) NOT NULL,
  `cant_aprobada` int(11) DEFAULT NULL,
  `cant_usados` int(11) DEFAULT '0',
  `cant_nuevos` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_genera`
--

CREATE TABLE IF NOT EXISTS `alm_genera` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_genera_hist_a`
--

CREATE TABLE IF NOT EXISTS `alm_genera_hist_a` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_articulo` varchar(9) NOT NULL,
  `id_historial_a` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_guarda`
--

CREATE TABLE IF NOT EXISTS `alm_guarda` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `id_carrito` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_historial_a`
--

CREATE TABLE IF NOT EXISTS `alm_historial_a` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_historial_a` varchar(15) NOT NULL,
  `entrada` int(11) DEFAULT NULL,
  `salida` int(11) DEFAULT NULL,
  `nuevo` tinyint(1) NOT NULL,
  `observacion` text,
  `por_usuario` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_historial_s`
--

CREATE TABLE IF NOT EXISTS `alm_historial_s` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `NRS` varchar(10) NOT NULL,
  `fecha_gen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_ap` timestamp NULL DEFAULT NULL,
  `fecha_desp` timestamp NULL DEFAULT NULL,
  `fecha_comp` timestamp NULL DEFAULT NULL,
  `usuario_gen` varchar(9) NOT NULL,
  `usuario_ap` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_pertenece`
--

CREATE TABLE IF NOT EXISTS `alm_pertenece` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_cartegoria` varchar(9) NOT NULL,
  `cod_articulo` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_retira`
--

CREATE TABLE IF NOT EXISTS `alm_retira` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nr_solicitud` varchar(9) NOT NULL,
  `cod_articulo` varchar(9) NOT NULL,
  `id_usuario` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_solicitud`
--

CREATE TABLE IF NOT EXISTS `alm_solicitud` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL,
  `status` enum('carrito','en_proceso','aprobada','enviado','completado') NOT NULL,
  `observacion` text,
  `fecha_gen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_comp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dec_dependencia`
--

CREATE TABLE IF NOT EXISTS `dec_dependencia` (
  `id_dependencia` bigint(20) NOT NULL,
  `dependen` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `dec_dependencia`
--

INSERT INTO `dec_dependencia` (`id_dependencia`, `dependen`) VALUES
(1, 'BIBLIOTECA'),
(2, 'BIOLOGIA'),
(3, 'COMPUTACION'),
(4, 'DAE'),
(5, 'DECANATO'),
(6, 'DTIC'),
(7, 'FISICA'),
(8, 'MATEMATICA'),
(9, 'UST'),
(10, 'QUIMICA'),
(11, 'UFSH'),
(12, 'ASUNTOS PROFESORALES'),
(13, 'CURRICULUM'),
(14, 'EXTENSION'),
(15, 'ADMINISTRACION'),
(16, 'POSTGRADO'),
(17, 'INVESTIGACION'),
(18, 'CONSEJO FACULTAD'),
(19, 'DESPACHO'),
(20, 'RECURSOS HUMANOS'),
(21, 'MANTENIMIENTO'),
(22, 'ASUNTOS ESTUDIANTILES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dec_permiso`
--

CREATE TABLE IF NOT EXISTS `dec_permiso` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `nivel` text
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dec_permiso`
--

INSERT INTO `dec_permiso` (`ID`, `TIME`, `id_usuario`, `nivel`) VALUES
(1, '2016-03-16 16:39:48', '19919468', '011011111111111111100100000000000000000100000000000000000100000000000000000000000000000000000100000000000000000100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000100000000000000000100000000000000000000000000000000000100000000000000000000000000000000000000000000000000000000000000000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dec_tipo_equipo`
--

CREATE TABLE IF NOT EXISTS `dec_tipo_equipo` (
  `cod` int(11) NOT NULL,
  `desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dec_usuario`
--

CREATE TABLE IF NOT EXISTS `dec_usuario` (
  `ID` bigint(20) NOT NULL,
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
  `sys_rol` enum('autoridad','asist_autoridad','jefe_alm','director_dep','asistente_dep','ayudante_alm','no_visible') NOT NULL DEFAULT 'no_visible',
  `status` enum('activo','inactivo') NOT NULL DEFAULT 'inactivo'
) ENGINE=InnoDB AUTO_INCREMENT=310 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dec_usuario`
--

INSERT INTO `dec_usuario` (`ID`, `TIME`, `id_usuario`, `password`, `nombre`, `apellido`, `cargo`, `email`, `telefono`, `id_dependencia`, `tipo`, `observacion`, `sys_rol`, `status`) VALUES
(1, '2016-03-15 21:09:57', '10037592', '7b88f8c06353d9b379ae6a21d0a9986f6276b2bb', 'Angel Enrique', 'Rivas Mendoza', 'Director de Asuntos Profe', 'Aerivas1@uc.edu.ve', '04124865159', 5, 'docente', '', 'asistente_dep', 'activo'),
(2, '2016-03-15 21:11:24', '10082266', '006aff423cc6ea9bb995faba3d4702e08db5ff08', 'Mirba', 'Romero Matos', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(3, '2016-03-15 21:09:55', '10111075', '220d18b82501bcee5019f73598c237562aba6875', 'Sandra', 'Morales', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'activo'),
(4, '2016-03-15 21:09:50', '10114715', 'be407882f575b087accdce7b59ea3a9709460291', 'Jesus', 'Rivas ', '', '', '', 5, 'docente', NULL, 'no_visible', 'activo'),
(5, '2016-01-29 17:31:17', '10131920', 'e8947193ed5c142c854bd8b1284a22e3bf431ad5', 'Angel', 'Lopez ', 'IAsistente de Decano', 'anlopez169@gmail.com', '04124910774', 5, 'docente', 'Asistente al Decano', 'autoridad', 'activo'),
(6, '2016-03-15 21:10:08', '10146766', 'a5d1f9748cd05f862e05546560c8670629e8c318', 'Lellys', 'Contreras Moyeja', '', '', '', 5, 'docente', NULL, 'no_visible', 'activo'),
(7, '2016-03-15 21:10:06', '10227973', 'f3e71038dfdcaf36488bf3114d5b263ab52e3620', 'Hector', 'Inojosa Vitriago', '', '', '', 5, 'docente', NULL, 'no_visible', 'activo'),
(8, '2016-03-15 21:10:03', '10228698', 'c5002ba4b8d05b5977f78ef25672b34e52caf3e5', 'Anabella', 'Sanz', 'Secretaria  Ejecutiva', 'anajsanzt@gmail.com', '04144423125', 14, 'administrativo', '', 'asistente_dep', 'activo'),
(9, '2016-03-15 21:10:00', '10232537', '62ec17de53471df68c42f36e237bb7047c82b10c', 'Milagros', 'Tortolero ', 'Abogado Especialista', '', '', 5, 'administrativo', '', 'asistente_dep', 'activo'),
(10, '2016-01-27 16:57:14', '10233908', '4a7594b38d216ab593e1544f589a5e1c57896a47', 'Nancy', 'Zambrano F', 'Secretaria Ejecutiva', '', '', 5, 'administrativo', '', 'asistente_dep', 'activo'),
(307, '2015-07-08 00:11:59', '10266594', '804201024580744c894d96e0fc6cb210cd93c5c2', 'Luis', 'Zerpa', 'Ayudante de Servicios', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(11, '2015-07-08 00:11:59', '10273691', '24a1f1abf1a8a6e2e5c9707afd39548ce71b671e', 'Jorge', 'Briceno Carrasquel', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(12, '2015-07-08 00:11:59', '10378636', '999400a61e4702402e2404eb00a802550252805f', 'Daniel', 'Arias Toro', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(289, '2015-07-08 00:11:59', '10455543', 'fdad79e342db93804cb9d23acedc2c82db96005c', 'José Abraham', 'Ascanio M', '', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(13, '2015-07-08 00:11:59', '10484903', '4c5f0cdd9cd0fd92d47c6392b3f64f8bc0daa2a1', 'Maryorie', 'Machado S', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(14, '2016-03-09 16:33:13', '10561291', 'b949fc528b44ac3b59ccb247daad0b93dfdee3ba', 'Zoraida', 'Velasco S', '', '', '', 5, 'docente', NULL, 'no_visible', 'activo'),
(15, '2016-02-02 15:22:46', '10577808', '8b1d7fefa76207cbb18f8a6c219deba41792e446', 'Belkys Yubiry', 'Perez Garcia', 'Director de Departamento', 'Belperez@uc.edu.ve', '04169943277', 2, 'docente', '', 'director_dep', 'activo'),
(16, '2016-02-02 15:21:39', '10701349', '4f0356d3f52ee70af32cba6f8933d8f3dac4e73c', 'Herminia', 'Jimenez', 'Secretaria al Decano', '', '04124225927', 5, 'administrativo', '', 'asistente_dep', 'activo'),
(17, '2015-07-08 00:11:59', '10730466', '14fb0eba37fe934a3df46e7cd5defbcbf1617872', 'Iraida', 'Falcón', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(18, '2015-07-08 00:11:59', '10731726', 'e55f4f9e86c8b3de527df0a6eaf3f357f2d29e28', 'Angel', 'Leon ', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(19, '2015-07-08 00:11:59', '10732218', '36ffe34f59da3d95e10388ffecc8aaaff047ee93', 'Lilian', 'Guevara ', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(20, '2015-07-08 00:11:59', '10754307', 'f4389672b47eeef1f0ec18d7af9044efb304afd5', 'Luis', 'Puerta Silva', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(21, '2015-07-08 00:11:59', '10755388', 'e6c3fbe2252abd55b21d6b4a0d712ae2a01833da', 'Muñoz', 'Marcos', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(22, '2016-01-27 17:36:27', '11007186', '39ae3cc4b543fba86d8f4d01c4dc5c455439eb1b', 'Damarys C', 'Serrano V', 'Director de Departamento', '', '', 7, 'docente', '', 'director_dep', 'activo'),
(23, '2015-07-08 00:11:59', '11095592', '6f6c2a072db378883df2a9192f6c40b37dca95e0', 'Chirinos', 'Iris', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(24, '2015-07-08 00:11:59', '11148154', 'eebf8f01eb5447d664855aa99fba1f7341d7e0be', 'Katiuska', 'Ramos Jimenez', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(25, '2015-07-08 00:11:59', '11153957', '9d04c2017d9422ebcb4a9a9abd4d6b9456c4122b', 'Victor', 'Perez ', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(26, '2016-01-27 17:07:06', '11155728', '31c67c60ed17f1090b0260e10ac61f81e831d5a7', 'Dayana', 'Parra', 'Secretaria Ejecutiva', '', '', 7, 'administrativo', '', 'asistente_dep', 'activo'),
(27, '2015-10-06 15:08:49', '11183899', 'a8b38b80c4bd2abe2c22a31600c2b8dff3b2c52f', 'Juan', 'Pereira Antique', 'Docente', '', '', 10, 'docente', '', 'no_visible', 'activo'),
(28, '2016-01-27 17:05:57', '11352146', '5cf5f4ac354c1227c7320ed07de03a9bdce86b49', 'Erika', 'Paracare', 'Secretaria Ejecutiva', '', '', 3, 'administrativo', '', 'asistente_dep', 'activo'),
(29, '2016-01-27 16:58:15', '11359154', 'f826c1e90f441d8a3f50d4f509ce0c48c156c5fd', 'Ivonne', 'Leal M', 'Disenador Curricular', '', '', 13, 'administrativo', '', 'asistente_dep', 'activo'),
(30, '2015-07-08 00:11:59', '11362785', '57df7b60ac76cccc4ec198c5f6a20d0903d792c0', 'Esmeralda', 'Montero', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(31, '2016-03-09 16:27:56', '11364017', 'a45184005589c291ceeee5b53e94be9980ff776f', 'Yojana', 'Sequera Rojas', 'Secretaria Ejecutiva', 'yojana.sequera@gmail.com', '04123483378', 8, 'administrativo', '', 'asistente_dep', 'inactivo'),
(32, '2015-07-30 14:29:15', '11485668', '27ab9c299da62fb192d4645db9afa1cd3104307d', 'Lenys', 'Bello G', '', '', '', 5, 'docente', NULL, 'no_visible', 'activo'),
(33, '2016-01-27 16:52:21', '11525159', '15d7d77a7f0e41fa18c413513b348e000d3e7740', 'Lisbeht', 'Hernandez ', 'Coordinador Sectorial de ', '', '', 14, 'administrativo', '', 'asistente_dep', 'activo'),
(34, '2015-07-08 00:11:59', '11525430', 'b626c6da850eb834810fa1e13d0b5c4ac72bbc84', 'Jeff', 'Wilkesman Giamate', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(35, '2015-07-08 00:11:59', '11526178', '465462c3b73071c773ae78cb508be2188ee58c17', 'Elizabeth', 'Perozo Rondon', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(36, '2015-07-08 00:11:59', '11557142', '23494cc5da7d5e736bd5c184f29c33b54aeeb113', 'Carlos', 'Valera', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(37, '2015-07-08 00:11:59', '11638901', 'd389adcc186fbdad05b2997b67eff510077e4b08', 'Domenico', 'Pavone M', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(38, '2015-07-08 00:11:59', '11678882', 'e0c4cd16b28b048867a4551f17fb65c386e5968a', 'Luis', 'Rodriguez ', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(39, '2016-01-27 16:39:39', '11687214', '18de070c3f5f96bd99649284dc360f0b3cf4a8cd', 'Monica', 'Perez S', 'Analista de Presupuesto', '', '', 5, 'administrativo', '', 'asistente_dep', 'activo'),
(40, '2015-07-08 00:11:59', '11808711', '89cb09153d147c9e9f68e90db58bc46033a2236f', 'Girolamo', 'Grassi', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(41, '2015-07-08 00:11:59', '11808960', '3ccae20f695857973215638beb280204f2c6ba4c', 'Julissa', 'Brizuela', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(42, '2016-01-27 17:26:25', '11809738', '3df992e85dd90147cc3a384d3fcf5523dee03738', 'Arnaldo', 'Armado Matute', 'Director de Departamento', '', '', 10, 'docente', '', 'director_dep', 'activo'),
(43, '2015-07-08 00:11:59', '11811500', '287205b99d559aa2655434b6c667d874c3624365', 'Victor', 'Griffin B', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(44, '2015-07-08 00:11:59', '11814428', 'e78a975785af72ae246ca2ecae9b65129d57bd03', 'Elsa', 'Tovar Flores', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(45, '2015-07-08 00:11:59', '11960243', 'dd7354382d0f690c86413638b567e1b787037493', 'Jonathan', 'Liria Salazar', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(46, '2015-07-08 00:11:59', '12028017', 'dec517659a19078ed42c64dce7a77396b612ebb9', 'José', 'Garcia', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(47, '2015-07-30 14:29:28', '12029549', 'f2ab7478865ec91f20408bc66df4c1121e53a789', 'Yoanair', 'Tovar Pena', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'activo'),
(48, '2015-07-08 00:11:59', '12031020', '8c73e74a8a1f6182261ccf8a19aafe0603c60225', 'Sandra', 'Peña', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(49, '2016-01-27 16:59:59', '12032005', '10e59071eb5cc104de66bf3b3fec82e3b357c828', 'Karina', 'Gonzalez ', 'Analista Especialista', '', '', 12, 'administrativo', '', 'asistente_dep', 'activo'),
(50, '2015-07-08 00:11:59', '12033792', '503514a063072aefa7729020ba26a9e92bb6ce6a', 'Lorena', 'Febres', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(51, '2015-07-08 00:11:59', '12035391', '6d394e7c4ea2bedd8ea3c336df3b8973749316ad', 'Jose', 'Ramirez B', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(52, '2015-07-08 00:11:59', '12035819', '0c786701c3a57f64057516924c4b030d8d1e0c63', 'Hernan', 'Torres', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(53, '2015-07-08 00:11:59', '12065867', '374853e3b1e885447a5f2577b9b3a82d29175723', 'Carlos', 'Do Nascimiento', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(296, '2015-07-08 00:11:59', '12092890', '0e3acee1f779096bb1612910405976dadd487953', 'Egidio', 'López', '', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(54, '2015-07-08 00:11:59', '12102193', 'c9734e985b06542f83e0b3c90c9dd76de7d4a65e', 'Urbina Abel', 'D alessandro', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(302, '2015-07-08 00:11:59', '12106491', 'a40b089956deb25bf14dce42864016950e653c40', 'Heber', 'Perez', 'Electricista', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(55, '2015-07-08 00:11:59', '12122940', '694b95b4aa550ad609b90aefcd1960aa90733736', 'Sheyla', 'Ortiz Kukec', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(56, '2015-07-08 00:11:59', '12148374', '40159a5a7201842653a818b41667ec634291f071', 'Oscar', 'Sucre Reyes', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(57, '2015-07-08 00:11:59', '12174070', '705ebf21270620d98de348dbc075f4f8d0952c21', 'Juan', 'Mateu Petit', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(58, '2015-07-30 14:36:44', '12312009', 'f187035aacd154489cb53692d9a2fa384ab80e19', 'Amadis', 'Martinez Morales', '', '', '', 5, 'docente', NULL, 'no_visible', 'activo'),
(59, '2015-07-08 00:11:59', '12345678', '7c222fb2927d828af22f592134e8932480637c0d', 'Desk', 'Help', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(60, '2015-07-08 00:11:59', '12522701', 'b551ebce08305a894b813232c0f5e82c50f0bc2f', 'Jower', 'Ruiz A', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(61, '2015-07-08 00:11:59', '12524155', '1e3562a82af1e9aaae9edf694cf032eeaeadd229', 'Maria', 'Villegas Aguilar', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(62, '2015-07-08 00:11:59', '12546473', '522c63bf6973e19625245505f5f105ac3f233c12', 'Irazabal', 'Neudis', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(63, '2015-07-08 00:11:59', '12605080', '47c6cd201522dff9185f85912da2af12ce320606', 'Cleomara', 'Palacios', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(64, '2015-07-08 00:11:59', '12606179', 'cb2cc38c5db8e1fce446449891fd36c89b77bc89', 'Romero Ysmel', 'La Rosa', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(65, '2015-07-08 00:11:59', '12608487', 'afde2773a35b861b236d1608497dabd0a0e1c6fa', 'Mariela', 'Forti', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(66, '2016-01-27 16:36:08', '12751826', '6433b486d62b3453b4bbcb8f627aa0afb682cee9', 'Diogelia', 'Zarraga', 'Asistente Administrativo', '', '', 15, 'administrativo', '', 'asistente_dep', 'activo'),
(67, '2016-01-27 17:13:59', '12752011', '54695af571ec0c5269da1ad8fa62902596cfe09e', 'Jose', 'Manrique Rodriguez', 'Analista de Informacion y', '', '', 22, 'administrativo', '', 'asistente_dep', 'activo'),
(68, '2015-07-08 00:11:59', '12752272', '59b7c692ecf26002968420f5721b501da6d56973', 'Daniel', 'Matute', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(69, '2015-07-08 00:11:59', '12753599', '2ce4051c8051a19a5724feb3159291705133412f', 'Maria', 'Sanchez Vega', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(70, '2015-07-08 00:11:59', '12771372', '6cc54b3b6a0588c70c75884385916cc81113cd86', 'Florisela', 'Armado Matute', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(71, '2015-07-08 00:11:59', '12771395', '77e2794d7dce77167deded09e93101a7b0734070', 'Leilibet', 'Lopez Marquez', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(72, '2015-07-08 00:11:59', '12774644', '460c01b2939fd0d3822c3b46bdeeea950ac3662a', 'Dorys', 'Reyes', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(73, '2015-07-08 00:11:59', '12842680', 'e3488975528908e941fc75d5da51de3de44e9704', 'Reimer', 'Romero', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(74, '2015-07-08 00:11:59', '12856938', '83f5d0b82aba252c56c35a681f96a8da61c84b8f', 'Maria', 'Mendoza', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(75, '2015-07-08 00:11:59', '12872503', 'ac9b0f6c66f9562d2da11d154e21541f4aa2144b', 'Carmen', 'Andara D', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(76, '2015-07-08 00:11:59', '13045466', 'affbb6dbbfc05f18f617582c2bf53110adf56343', 'Dorys', 'Manzanilla Narea', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(304, '2015-07-08 00:11:59', '13047133', '9ba50347f70ca20112eea5fe23ec406f03310def', 'Nelson', 'Sanz', 'Mecánico en Refrigeración', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(77, '2015-07-08 00:11:59', '13105945', '5b4e12422b45e19687485432bd00cb1118dd89e4', 'Mavo', 'Henry', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(78, '2015-07-08 00:11:59', '13195420', '8679cf84e17336e412178516b82c89d2f0f9caee', 'G', 'Ramirez Luis', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(79, '2015-07-08 00:11:59', '13281221', 'd6263d5a044b212992c9686970eb22363c86fac4', 'Eber Enrique', 'Orozco Guillen', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(80, '2015-07-08 00:11:59', '13314242', '05d60e9b29ba98b6c00c2146a3ea1909b0215066', 'Franger', 'García A.', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(81, '2015-07-08 00:11:59', '13322048', 'f6534a52cb2449926b737ffb55671f5af8969130', 'Harold', 'Vasquez Chavarria', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(82, '2015-07-08 00:11:59', '13382475', '705e84ba6a6af0b501eb1a5389200ec703e58de1', 'Gabriela', 'Rodriguez E', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(83, '2015-07-08 00:11:59', '13509090', 'f650f9ca1dd1356c0517ad32da2a2a849d3ff657', 'Aguilar', 'Soraya', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(84, '2015-07-08 00:11:59', '13562316', '1a32c87e882df40f2205c51f4d497690aa50029d', 'QUINTERO', 'DENNY', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(85, '2016-01-27 16:11:40', '13588340', '6f050fbc223ef6b451c337dabf0f2e1330b22322', 'Jazmin', 'Moncaca', 'Secretaria Ejecutiva', '', '', 15, 'administrativo', '', 'asistente_dep', 'activo'),
(86, '2016-01-27 16:46:56', '13635990', '69f9e03cdb438c6228811a65275fc7167ea96f84', 'Maria A', 'Padron H', 'Analista de Recursos Huma', '', '', 20, 'administrativo', '', 'asistente_dep', 'activo'),
(87, '2015-07-08 00:11:59', '13666872', 'b621e1b1a52c5282bd884873e4e52c741e6dcbbb', 'Gabriela', 'Colmenares Guevara', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(88, '2015-07-08 00:11:59', '13696879', '2659df9da0f42ecbfc2eae9f41f7a1cb095e5599', 'Sierra', 'Oscar', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(89, '2015-07-08 00:11:59', '13717204', '15ee48fbb96c2cd9d82f1d764bfbf0fb9a49c2df', 'Carlos', 'Mantilla', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(90, '2015-07-08 00:11:59', '13804500', 'a71e4e9f80180049eea5b74293dbffc9edfdc0b1', 'Maria', 'Alvarado', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(91, '2015-07-08 00:11:59', '13899563', 'fb0ece17bf9d771ed3d4a9702e756f42aa9e73d8', 'Luis', 'Gaviria', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(92, '2015-07-08 00:11:59', '13899653', 'f51ae8b75e77e1059c6fe7698fac856df8dc03f3', 'GAVIRIA E.', 'LUIS F.', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(93, '2016-03-09 16:33:09', '13953077', 'ed70208bddc4900a374a4a67ba9bde60f3e0d561', 'Yolwiths', 'Plaza', '', '', '', 5, '', NULL, 'no_visible', 'activo'),
(94, '2015-07-08 00:11:59', '13987872', '46b67823e5ec827e67cc466548e6efd96160f775', 'Elluz', 'Uzcategui Perez', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(95, '2016-02-03 19:07:33', '13988151', '78f7a8fdc02c549cfaaed3fe8d35cef08bcf6626', 'Angelica G.', 'Flores B.', 'Secretaria', '', '04144046608', 12, 'administrativo', '', 'asistente_dep', 'activo'),
(96, '2015-07-08 00:11:59', '13988661', '44c9c1e5ba52303b1c2fc1d697e77855a0b39520', 'Mónica', 'Armado', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(97, '2016-01-29 15:24:06', '13989244', 'dfb2656f1cded1f9c391e6cad5f7a3bf40e06289', 'Jose', 'Henríquez', 'Administrador TIC', 'Jahenriq@gmail.com', '04265439086', 9, 'administrativo', '', 'director_dep', 'activo'),
(98, '2015-07-08 00:11:59', '13998824', 'fc6e8f0be20e7d846a1953faf8a96f09571df040', 'Johanna', 'Figueroa', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(99, '2015-07-08 00:11:59', '14025326', 'b8158e6ed766c11f723f43ea3234e495164a490c', 'Liaska Y', 'Cuamo G', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(100, '2016-02-04 18:00:19', '14078157', 'ac57c5c85e718afc6d1597e285f1d03bcfa1404d', 'Marlin', 'Moreno ', 'Planificador de informaci', 'Marlinmoreno@gmail.com', '04244293867', 22, 'administrativo', '', 'asistente_dep', 'activo'),
(101, '2015-07-08 00:11:59', '14078269', '704b96b9eb9211e42fbed1786408016af9ba376f', 'Alexander', 'Blasco', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(102, '2015-07-08 00:11:59', '14078669', '4455bf83b421e9481167384beece51221770463c', 'Parra', 'Yesenia', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(103, '2016-02-10 18:20:02', '14162837', '9394decbe8e2cc90ee19dd386211d32585626e3e', 'Vincenzo', 'Storaci', 'Laboratorio', 'Vastoraci@uc.edu.ve', '04124373143', 2, 'administrativo', 'Supervisor de Laboratorios', 'asistente_dep', 'activo'),
(104, '2016-01-28 19:21:07', '14185657', '7446129d271e76e04ac23d6a05e956ef2c5b7494', 'Johana', 'Guerrero', 'Director TIC', '', '', 5, 'docente', '', 'asistente_dep', 'activo'),
(105, '2015-07-08 00:11:59', '14247340', '877e206358956725af05f5ae8f60988de28af703', 'Aaron Alberto', 'Munoz Morales', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(106, '2015-07-08 00:11:59', '14302080', '5f5b97b827765ee0a869920d3726eb036f990881', 'Esther C.', 'Torquati Marvez', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(107, '2015-07-08 00:11:59', '14381377', 'd70a95120ec2c4f7cb970a5adb2c6647e78516c1', 'Rossana', 'Tortolero ', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(108, '2015-07-08 00:11:59', '14381875', '6df51ba005a7807681479cb7f4022208cb460c36', 'Joslem', 'Rivas Cabeza', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(109, '2016-02-03 12:56:12', '14382083', '3f096fa067ef1a46f5140511f270b3724bd03989', 'Liliana Yaneth', 'Nieto Caicedo', 'Asistente de Biologia', 'linieto78@gmail.com', '04265438994', 2, 'administrativo', '', 'asistente_dep', 'activo'),
(110, '2015-07-08 00:11:59', '14383069', 'fdc7213052504f70f57641bf16eb0499da189e4a', 'Castellanos', 'Fernando ', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(111, '2015-07-08 00:11:59', '14514919', '2f99bff5e609f9281da8f18e64bbfbaed5a0e5b0', 'Jose G', 'Parra F', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(112, '2016-01-27 17:05:03', '14573107', '31b771cb38437405410ee9868279def66606c55f', 'Belitzeth', 'Diaz', 'Secretaria', '', '', 3, 'administrativo', '', 'asistente_dep', 'activo'),
(113, '2015-07-08 00:11:59', '14573360', 'edf6a81e77635aa94dd8b0eedde3986fde9bb060', 'Nuñez', 'Maria', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(114, '2015-07-08 00:11:59', '14624510', 'e0af1d6b26f6893eef1f64d8d8afb895caca1259', 'Blazetic', 'Alberto', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(115, '2015-12-08 18:32:25', '14713134', '34cd7a29450e3123e5c7747673deb6013afdfb0d', 'Carlos', 'Parra Juan', 'Asistente de Laboratorio', '', '', 9, 'administrativo', '', 'asistente_dep', 'activo'),
(116, '2015-07-08 00:11:59', '14721738', '4d39791a6915577683f576ccb24e4273db66c68f', 'Renny', 'Pacheco ', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(117, '2016-01-27 17:01:30', '14754527', '72c27ed30a5e21c3b625557b0e33f0754f8909e0', 'Tatiana', 'Gallego Murillo', 'Administrador de Tecnolog', '', '', 9, 'administrativo', '', 'asistente_dep', 'activo'),
(118, '2015-10-09 13:41:23', '14820460', '77c33b7c499a6255303d66d39904a3476cab0228', 'Castillo', 'Jazmin', 'Secretaria', '', '', 5, 'administrativo', '', 'autoridad', 'activo'),
(119, '2015-07-08 00:11:59', '14915211', '196175b42535fe64f4ba55b3d812746988b8ed84', 'José A.', 'Sosa R.', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(120, '2015-07-08 00:11:59', '14915702', '016db1d4302ec43e885f7a45e6b57035f30d6592', 'Anibal', 'Guerra', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(121, '2015-07-08 00:11:59', '14976435', '663323a512833ab1b75d62ab6d38ec4015ccc876', 'Eucandis', 'Fuentes', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(122, '2015-07-08 00:11:59', '14999453', '049d66c2ee4fddad903d6ca53469b803f1c5f4f5', 'Luis', 'León', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(123, '2015-07-08 00:11:59', '15000848', '60f0f76c28ec4c9aede0c0d5443cb537f0f1d15b', 'Padrón', 'Maively', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(124, '2015-07-08 00:11:59', '15169197', 'aedff84569c43f32c42012e3730986fb39ac6c5a', 'Miguel', 'Suarez Ledo', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(308, '2016-01-27 16:36:03', '15189234', '5547e839fcb10d9f2cee8b1d2eee6c7fe8ae88ee', 'Gabriel Antonio', 'Hernandez Delgado', 'Jefe de Almacen', 'Gabriel_h3@hotmail.com', '315127', 15, 'administrativo', '', 'jefe_alm', 'activo'),
(125, '2015-07-08 00:11:59', '15258288', '19ec867d8d12d61588765e7eda36abc792515fdc', 'Montaño', 'Fredina', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(126, '2015-07-08 00:11:59', '15398669', 'f5ec81f9fdd9acf0393ddfc382e054c1fbf08885', 'Angelica', 'Díaz', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(127, '2015-07-08 00:11:59', '15428812', '24864b58345fab14120c036fd06306b40aaf2ca1', 'Blaides', 'Luis', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(291, '2015-07-08 00:11:59', '15494959', 'edcce5d2e0dfbc908c7ce36de5d94c7cb09f217d', 'Jonder', 'Chirinos', '', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(128, '2015-07-08 00:11:59', '15529951', 'c626984d260114d1bb284d28ce5ba8b35331661f', 'David', 'Vega Mendez', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(129, '2015-07-08 00:11:59', '15656021', '5d07d530a23c67c5c8949413b2fc6da10c769eed', 'Carlos', 'Moreno', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(130, '2016-02-02 15:04:06', '15739066', '78cb12b6a7d0c292f6f830c68689945ff178663d', 'Deisy A', 'Garcia S', 'Disenador Curricular', 'dagarcia1@uc.edu.ve', '0414-4215986', 18, 'administrativo', '', 'asistente_dep', 'activo'),
(131, '2015-07-08 00:11:59', '15897618', '2166ce8689475f7c00b286cce832e3e8eec51892', 'Dioleidy', 'Gonzalez M.', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(132, '2015-07-08 00:11:59', '16015265', 'd77c6036b18da71e6ff6f4cb3572f3eda588564c', 'Dilcia', 'Artigas', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(133, '2015-07-08 00:11:59', '16034144', 'ed21cb66a2d37ca9e38aa4b85853e14878c02eaa', 'Guerrero', 'Patricia', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(134, '2015-07-08 00:11:59', '16269715', '3655415d057267b5752cd856b3afa87822dc5b1e', 'Jimenez', 'Dora', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(135, '2015-07-08 00:11:59', '16270061', '505122b3a979f161324d26ebe9642ae834287f6e', 'Colmenares', 'Mairin', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(299, '2015-07-08 00:11:59', '16280386', '91d3b5dab248c73b730b3be63131879c60bccfe2', 'Luisana', 'Moreno E.', 'Ayudante de Servicio', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(136, '2015-07-08 00:11:59', '16288667', '73069f40f588d6c3d9978b8c43d3e4dbfc2e495d', 'Jesus', 'Figueroa', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(137, '2015-07-08 00:11:59', '16290807', 'a4ef15e71dabffba9b484b4a20f3620e178fbac3', 'Daniel', 'Rosquete', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(138, '2015-07-08 00:11:59', '16299957', '6f2aebe37f05cd27ddfdfc8e3cab8a7b3cd944ac', 'Maximo', 'Mero Barcia', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(139, '2015-07-08 00:11:59', '16454599', 'fe0923bc956028925174e8ae9a4fc74452b4e572', 'Nori', 'Nuñez', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(140, '2015-07-08 00:11:59', '16501883', '39d438d4b822f68aaa04feb3be0a11b1d10a1355', 'Cedeño', 'Fernando', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(297, '2015-07-08 00:11:59', '16503761', '70b5975b2e78e881d4bd7e899524af406bd608ef', 'José A', 'Márquez D.', 'Ayudante de Mantenimiento', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(141, '2015-07-08 00:11:59', '16579835', '965a805afd190e789a05ee2de435d256b5da5667', 'Sho', 'Antony', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(142, '2015-07-08 00:11:59', '16850688', 'eadfec32e9ddd5bff6ef855c008fdb853c46a8f9', 'Díaz', 'Bianca', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(143, '2016-01-27 16:38:38', '17032400', '60eb331d03ecd92a1747d954c790d961664cc52b', 'Milennys del Valler', 'Gallardo Diaz', 'Comprador', '', '', 5, 'administrativo', '', 'asistente_dep', 'activo'),
(290, '2015-07-08 00:11:59', '17066227', '698984f3c3f0f90fd1917add2a60a5fb1b9494fe', 'Dayana', 'Azuaje', '', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(144, '2015-07-08 00:11:59', '17066999', 'b6abd771582eb00520042d9466d09378e18e3148', 'Patricia', 'Chirivella', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(145, '2015-07-08 00:11:59', '17171090', 'c4224882cecf08990d31cb69cdcce0cae31f10aa', 'Manuel', 'Herrera', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(146, '2015-07-08 00:11:59', '17193617', '653942a2dcc6328737f200610934ac5b5b519984', 'Narea Jimenez', 'Freddy J.', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(147, '2016-03-09 16:33:11', '17316466', '75b67f80ae56bcfaf70893fe3f5bfe17a9bdacf0', 'Zharife', 'Samara', 'Secretaria', 'zsamara@uc.edu.ve', '+584144299298', 18, 'administrativo', '', 'asistente_dep', 'inactivo'),
(148, '2015-07-08 00:11:59', '17373972', '3d782ebd269ecf5790a4ee19e54c682c0ee81eff', 'Vargas', 'Ramón', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(149, '2015-07-08 00:11:59', '17387931', 'c3bea34e9a6496f0956239645c5604f2958dd689', 'Rolando', 'Gaitan Deveras', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(150, '2015-07-08 00:11:59', '17397519', '27da0b322463e3b452772e826bdb28626c7da746', 'Lisette', 'Molins', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(151, '2015-07-08 00:11:59', '17399487', '27b0afdb5c1bcd0496d004764e3e67b8fdc11e28', 'José', 'Casadiego', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(152, '2015-07-08 00:11:59', '17494728', 'cb5a1a8614682ef18aee0c05b792affde587f01c', 'Enzo', 'Garcia', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(153, '2015-07-08 00:11:59', '17599633', 'bcb20a245dd81986abb716a73a51d5d60bc4b257', 'Guevara', 'Esnil', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(154, '2015-07-08 00:11:59', '17614031', '2387395d7a28c40db7a7c470e58f06d4dc726edb', 'Laura', 'Arocha', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(293, '2015-07-08 00:11:59', '17679264', 'fbfdad8df881154ea62063e6ff3e851b9a84e6f5', 'Rosa A.', 'García A.', '', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(155, '2015-07-08 00:11:59', '17807606', '9ab47c90330b5aa0a1197578d110b67d70f990f8', 'Vasquez', 'Marianela', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(156, '2015-07-08 00:11:59', '17807836', '47e5b2b328bfdeef18128ed7c3867c5b894b02f7', 'Ottogalli', 'Kiara', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(157, '2015-07-08 00:11:59', '17904341', '55861e2a6ac159a668eac3f824d7cc4004d0a8b5', 'Moises A.', 'Lopez S.', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(158, '2015-07-20 19:08:41', '17986853', 'ac63d613e40eb05e99d92b8406b12eaa1dfd2237', 'Aury Carolina', 'Rodriguez Rodriguez', '', '', '315191', 9, 'administrativo', 'I', 'autoridad', 'activo'),
(159, '2015-07-08 00:11:59', '18060673', '5386866f4f7f56c0ee0c664e580d4a27e6a741ec', 'Gliseth', 'Hernandez', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(292, '2015-07-08 00:11:59', '18166077', 'faa3d5e8898cb5428b618cc02927d48d064e814b', 'Miguel', 'Escalona', '', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(160, '2015-07-08 00:11:59', '18180900', '03f1cb7c82a4908f62eb26f9203d30b10001b21c', 'Elias A.', 'Salazar B.', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(161, '2015-07-08 00:11:59', '18253417', '5d210d119bdf9fd7fc59f602eb93f72c19714d52', 'Acosta', 'Alí', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(162, '2015-07-08 00:11:59', '18360098', '01343b94c57ade04e244bc17b617b2883fae2a20', 'Leonardo', 'Conde', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(305, '2015-07-08 00:11:59', '18468502', 'a9d53949f5522ab33e9b6a05dbefd32dbc859cd9', 'José', 'Sequera', 'Ayudante de Mantenimiento', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(163, '2015-07-08 00:11:59', '18470357', 'abb5d24f500c3b1683bdc79c91a7daf3ad093323', 'LEON', 'JOELI', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(164, '2015-07-08 00:11:59', '18561378', 'bf55af2c7e4823e4cc436342392a48ae40861bda', 'Urquiola', 'Andreina', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(165, '2015-07-08 00:11:59', '18686803', 'a7219ecd7276571f102046311e6a75fe678b50f8', 'Lisset', 'Orozco', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(166, '2015-07-08 00:11:59', '18747162', 'ae77081af971e1458260e07068b7c99a918d1cf9', 'Analisa', 'Carbone', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(167, '2015-07-08 00:11:59', '18837119', '8fffcccd0a6dca2ff8c3d62a42a77e0b4c183494', 'Brayan', 'Salas', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(168, '2015-07-08 00:11:59', '18859671', '61bfed48830dee4f0c1702b9b2083bb8ffcca5ff', 'Orlando', 'Pandares', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(169, '2015-07-08 00:11:59', '19410300', '3be64f3696c617c9c2feff07cce3f5f0621be8cb', 'Bermúdez', 'Johana', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(170, '2015-07-08 00:11:59', '19480276', '18761308f46610fc398d07ccc8d2196977d0842f', 'María J.', 'Fernandez P.', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(171, '2015-07-08 00:11:59', '19524082', 'e04312418068dd4223e64907ca9c292a6d9f4641', 'Piñero', 'Yuney', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(295, '2015-07-08 00:11:59', '19842872', '13c1849bc85af1ea1ec4ffbe8b78aafa9fddfa15', 'Mayra', 'Gutiérrez H.', '', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(309, '2016-03-09 14:50:59', '19919468', '2e620ed8960afd5e76e20bdb7320bfe63c33db96', 'Luis Alberto', 'Pérez Vera', 'Analista Programador', 'lperez20@uc.edu.ve', '04144415939', 9, 'administrativo', '', 'autoridad', 'activo'),
(172, '2015-07-08 00:11:59', '19919960', '765221eabff8ea90cdb1a21c9283077aec619cca', 'Manuel', 'Fernandez', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(173, '2015-07-08 00:11:59', '20029038', 'e71ffd3c04441722da4cd3de9509ac0727692d37', 'Rudy R.', 'Colina M.', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(174, '2015-07-08 00:11:59', '20083998', 'ec9f03a18d6503188c59878ce8974a1c15627638', 'Rosana', 'Escalona', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(175, '2015-07-08 00:11:59', '20163880', '534f53a8850ab4d45c310113d41763ae82ae8865', 'Genesis', 'Rodriguez R.', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(303, '2015-07-08 00:11:59', '20699287', 'fcd98473e9e8bd6d1f4b3c04bd3f64fdea0ba005', 'Ricardo', 'Pérez', 'Mensajero Interno', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(176, '2015-07-08 00:11:59', '20713569', 'bd5dd2aa701b14f0581aa92b15753c57cd23f05a', 'Dorybel', 'Mojon G.', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(177, '2015-07-08 00:11:59', '20753603', '23a543cc74e06d1e2af7d9779c4cb11276075518', 'Leosbeth', 'Gomez', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(178, '2015-07-08 00:11:59', '20819097', '6d0a3332ef0193eb8179700cd3e513e7522a7251', 'Pedro', 'Romero', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(179, '2015-07-08 00:11:59', '21139778', '662efc86de81905a3c470381cf5cebc56b0118e7', 'Solano', 'Frank', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(180, '2015-07-08 00:11:59', '21454331', 'e44e050f743325da785df1b988da3b63b3d27c08', 'Edgardo', 'Rodriguez', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(181, '2015-07-08 00:11:59', '21459200', 'ed4f7d4237b6f8e57169bc60cbb94ff7d21582c6', 'Darwin', 'Palmer', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(182, '2015-07-08 00:11:59', '22001580', 'a72dfbf3b14f7a0ca531ede1906e638630df883a', 'Nohely', 'Vargas', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(183, '2015-07-08 00:11:59', '22208289', '30cf6e443bd08fb408a070cea09d430884d3ad71', 'Escalona', 'Anyelys', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(300, '2015-07-08 00:11:59', '23649287', 'c88238c536f2ced5d8e4701b8f0fbcf589a448b6', 'Oscar J.', 'Ojeda B.', 'Ayudante de Mantenimiento', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(184, '2015-07-08 00:11:59', '24002850', '682965e829de7829ae800e744f81b797c769609c', 'Jhonny', 'Tarazona', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(185, '2015-07-08 00:11:59', '24388004', 'bb1b0769cd59a0bc04828b8d7109209eecc53673', 'Teran Maria Elena', 'Mier y', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(186, '2015-07-08 00:11:59', '24471949', '8960f86916cbaa330d38ce7f189a26319bb58fc6', 'Macias', 'Alfredo', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(187, '2015-07-08 00:11:59', '24499052', '47e7a4429c8eadb518f7023c11703a922adb9a53', 'Mayra Valentina', 'Suarez Hurtado', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(188, '2015-07-08 00:11:59', '24815407', 'b4dd451b7e48826e89eac28a1ebe5297e3951d93', 'Maikel', 'Vera', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(189, '2015-07-08 00:11:59', '2523054', '954e85389f878e9697732084a64ce1d934d35103', 'Manuela', 'Sanchez', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(190, '2015-07-08 00:11:59', '3442264', 'df2c7999c6c3e13b23910b86135fdd2fabd6d5ad', 'José', 'Rodriguez', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(191, '2015-07-08 00:11:59', '3584216', 'b6fb2caf19b9d7cbd4d5dfd256b59c984b4f67da', 'Elizabeth', 'Luque Bello', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(192, '2015-07-08 00:11:59', '3987442', 'ff9354add11e6561aba5108589d187c57e5ee7ee', 'Jose', 'Ortega Becea', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(193, '2015-07-08 00:11:59', '4268159', '25b38a92a57e21e7caa291917b13847933b514fe', 'Morales de Munoz', 'Rosa C.', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(194, '2015-07-08 00:11:59', '4365931', 'c1687e943320ca7143d51d98e2809b536d7156d9', 'Fatima', 'De Abreu', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(195, '2016-02-04 18:13:47', '4460185', 'acd309bdca69fc80d1f0199b8250206d3c0dab73', 'Romali', 'Kolster B', 'Coordinadora  Administrat', 'Rkolster@uc.edu.ve', '04144982308', 15, 'administrativo', '', 'director_dep', 'activo'),
(196, '2015-07-08 00:11:59', '4567390', '8d84e2b0726532b7aacfb16b16799069d0333ca2', 'Antonio', 'Castaneda Brito', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(197, '2016-02-04 15:04:47', '4859596', 'b895065ea78dc2bfc5c4ddb677d8f0c0ab250ccb', 'Sharon', 'Basso Jardine', 'Coordinadora UFSH', 'Sbasso@gmail.com', '04166486776', 5, 'docente', '', 'director_dep', 'activo'),
(198, '2015-07-08 00:11:59', '5070033', '714fc09fb894a80ecd6407deded919d685ee8566', 'Rodriguez', 'Carmen', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(199, '2015-07-08 00:11:59', '5307499', '42dd40c744cb22c06ee5df370a2b25b8af28d001', 'Nelson', 'Hernandez T.', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(200, '2015-07-08 00:11:59', '5373527', 'c1e9b2aa4860d79ebbbff434191bf43277298e8e', 'Ilse', 'Rodriguez Bustillos', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(201, '2015-07-08 00:11:59', '5421183', '3d463eb6b611c4d5094adfb568df6a23432074a4', 'Cecilia', 'Parra ', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(202, '2015-07-08 00:11:59', '5521244', '9bc8883e10840f83ca72032de023ffb4dcb426fd', 'Francisca', 'Grimon Mejias', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(203, '2015-07-08 00:11:59', '55555555', '19dd466e43cdbd3833abc0609eba6d8786f9b342', 'OST', 'Soporte', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(204, '2015-07-08 00:11:59', '5580398', '787d6533710c5b6d789e282cb732f2aded65bae0', 'Freddy', 'Ocanto Uzcategui', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(205, '2015-07-08 00:11:59', '5592143', '18098de6b26d1bce23894d67a32f97558d643cd3', 'Sabina A', 'Caula Q', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(206, '2015-07-08 00:11:59', '5598204', '3d041348b6ca37a1b5dd29d2e1c74757af4f5d04', 'Ronald', 'Blanco ', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(207, '2015-07-08 00:11:59', '5893251', 'd29058dde5a0ea33bcac868b36f2ad015ec16b60', 'Nancy', 'Salinas Trejo', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(208, '2015-07-08 00:11:59', '5911802', 'f05c15b96e533f7f5dbb081c549cd206e778b3b9', 'Rafael', 'Ruiz J.', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(209, '2015-07-08 00:11:59', '5966736', '721f5254fadcc109db890012908506e52beb8b02', 'Maria', 'Corao Marcano', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(210, '2015-07-08 00:11:59', '6015116', '4a52c525217ee1cde0262d0d9ed687d961a20f1b', 'Luciana', 'Scarioni Dallagata', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(211, '2015-07-08 00:11:59', '6101724', '7bc73f3444d4530e57b79ebc5c9584c5e0b962ec', 'Nelson', 'Falcon Veloz', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(212, '2015-07-08 00:11:59', '6129612', '770e8631cf3f953624c9ef779887337c057491a2', 'Mario', 'Palacios Caceres', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(213, '2015-07-08 00:11:59', '6131761', '2f380090077d5fa780aedf09da48679408879d8f', 'German', 'Larrazabal Serrano', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(214, '2015-07-08 00:11:59', '6341790', '68e1b7d5c6f621598bca9a2865461fc55829f7a5', 'Sonia', 'Ardito', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(215, '2015-07-08 00:11:59', '6349490', 'b5723a22d863e129e3116c9828025e8da3ac76b9', 'Carmen', 'Rodriguez F', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(216, '2015-07-08 00:11:59', '6358124', '4038855f9f8abedb8c3a6f6a5f4fe383323530b0', 'Rafael A', 'Rodriguez A', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(217, '2015-07-08 00:11:59', '6408134', '7b84e35d19c8bf51e74e20c634d1ab6cc8ec30f5', 'Richard', 'Gonzalez R', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(306, '2015-07-08 00:11:59', '6484055', '9a9cd355d847ba2f01b14f84657be3ae4942d591', 'Wilfredo J.', 'Yeguez M.', '', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(218, '2015-07-08 00:11:59', '6650600', '87b5e59b60d8d758d2f48bc9834ab6e0da6ddbbc', 'Hanen', 'Hanna Hanna', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(219, '2015-07-08 00:11:59', '6728079', '90d4cc5267693bd8335913ddf60995d36e3cd5c4', 'Henry', 'Labrador Sanchez', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(220, '2015-07-08 00:11:59', '6850966', '41dacf8c9a2370449be8b107dff735ca15e8e9c2', 'Roberto', 'Ruggiero', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(221, '2015-07-08 00:11:59', '6884574', '0f2e2da49d0706a8bb5a74355eb1485fb6458cae', 'Lesbia', 'Martinez Lopez', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(222, '2016-01-27 17:41:11', '6887736', '3099d3fede5b15c39f7920a46f4acb25fdc7948a', 'Orestes', 'Montilla Montilla', 'Director de Asuntos Estud', '', '', 22, 'docente', '', 'director_dep', 'activo'),
(223, '2016-03-09 16:33:15', '6971554', '17de98a2e2a8e6436f67ef73b90f3bd7d468ad64', 'Zoraida Del C', 'Fernandez G', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(224, '2015-07-08 00:11:59', '6975018', 'f34955cd3ff1849cae59148359f45ed89170a54b', 'Alberto', 'Subero ', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(225, '2015-07-08 00:11:59', '6999346', '1541416368c4f9db24dd4b28090ee53489a3b774', 'Esteban', 'Flores Rodriguez', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(226, '2016-02-03 16:05:39', '7012556', '3bfc6c49cde0d962edd46136895712f330141ee3', 'Rosario', 'Fiorita,', 'Secretaria Ejecutiva', '', '04244054287', 11, 'administrativo', '', 'asistente_dep', 'activo'),
(227, '2015-07-08 00:11:59', '7016985', '649da7b6ef425eafa0223b88352f9a21482d9e8d', 'Otto G', 'Rendon Rodriguez', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(228, '2016-01-27 17:43:51', '7059903', 'a81e3eb19fcd87cde8fa5fdfd4d390da8393d2ad', 'Aldo', 'Reyes,', 'Secretario Consejo Facult', '', '', 18, 'docente', '', 'director_dep', 'activo'),
(229, '2015-07-08 00:11:59', '7063100', '27dd6579acd09579acbc71a939a8426dd4753faa', 'MANRIQUE', 'JOSE G', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(230, '2015-07-08 00:11:59', '7064568', 'b6c042fcc7bf19d90f3f726f6b343f5c3cb24cf1', 'Marlene', 'Arias Soto', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(231, '2015-07-08 00:11:59', '7068730', '28e88693acb7eccb01bbd0317e0a8067dc6e1c61', 'Jose', 'Jimenez Ochoa', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(232, '2015-07-08 00:11:59', '7079917', '5439658bd365d75db0a27ad366b069eedeb6f01c', 'Janitis', 'Arocha M', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(233, '2016-01-27 17:38:35', '7084323', '9fa9fe1fc4f9518c259112efc4cf84fe41b1c205', 'Nolly', 'Alvarez C.', 'Coordinador de Biblioteca', '', '', 1, 'administrativo', '', 'director_dep', 'activo'),
(234, '2015-07-08 00:11:59', '7088165', 'b76eb6d2feddfc3ef29b297456181657bcec93de', 'Rosa', 'Bravo Pachas', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(235, '2015-07-08 00:11:59', '7088947', 'aec6fd8218e5e2c0734a4c0b0f6cc581ed3d142e', 'Orlando', 'Alvarez L', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(236, '2015-07-08 00:11:59', '7091519', 'f44d6fec79a87a8a07de264cae1d89a705478c6c', 'Rubén', 'Rojas', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(237, '2015-07-08 00:11:59', '7092726', '4c00a8fbe141f1cf6577b9aeddd6158d0174c30b', 'Freddy', 'Perozo Rondon', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(238, '2015-07-08 00:11:59', '7094314', 'f99e4b69a06044475cea8b62964d02d708c283e4', 'Reina', 'Loaiza Barreto', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(239, '2015-07-08 00:11:59', '7106785', '910f4f41975ddfa6935066b37b7d53af69eea5dc', 'Ingrid', 'Rivero A', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(288, '2016-02-05 16:33:54', '7106822', '2727ed658e31c95f620fa43bfc5cfd28e4911909', 'Carlos E', 'Cadenas Romero', 'Director de Departamento', '', '', 8, 'docente', '', 'director_dep', 'activo'),
(240, '2016-03-09 16:33:03', '7112641', '99c0997cf6b6f6c408d7ecba65b9ba88ac43715b', 'Yadirna', 'Omana Quero', '', '', '', 5, 'docente', NULL, 'no_visible', 'activo'),
(241, '2016-01-27 17:11:50', '7113823', 'ae206ea4353f33b9d3b9497b53fffb370940c08f', 'Sibel', 'Villalta Corrales', 'Supervisor de Biblioteca', '', '', 1, 'administrativo', '', 'asistente_dep', 'activo'),
(242, '2015-07-08 00:11:59', '7122452', '60e53570265bf740493c5360549d386759988f21', 'Ygmar', 'Jimenez Barrios', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(243, '2016-01-27 17:02:49', '7122700', '8b3014381a3b5fec5ac5443fc27a2e7a2239cad8', 'Claudia', 'Manfredini', 'Secretaria Ejecutiva', '', '', 10, 'administrativo', '', 'asistente_dep', 'activo'),
(244, '2015-07-08 00:11:59', '7125852', '209eabf530f27a9d806169bf3fcf916ff2ac5a8c', 'Orlando', 'Colina', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(245, '2016-01-27 16:48:22', '7126487', '02fedaf3719c98345cdb9b2f8799aca53cfb6197', 'Leny', 'Romero O', 'Secretaria Ejecutiva', '', '', 20, 'administrativo', '', 'asistente_dep', 'activo'),
(246, '2015-07-08 00:11:59', '7127436', 'a039df3582934eca9f983e6e932011698119faaa', 'Jesus', 'Tellez Isaac', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(247, '2015-07-08 00:11:59', '7127475', '69ecdf775c867e6595a2d68b55233ae25d536780', 'Patacho', 'Fernando', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(248, '2016-01-27 16:56:01', '7128972', '493b410d6dac682f982d49d957c6a7da1dc716cb', 'Nexi', 'Peraza A', 'Asistente Ejecutivo de Es', '', '', 5, 'administrativo', '', 'asistente_dep', 'activo'),
(249, '2015-07-08 00:11:59', '7140595', '39444509aae5cab051bbfe3921d425e29b0f3c24', 'Armando', 'Leon Delgado', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(250, '2016-02-05 18:25:30', '7142771', '60bfd426141adbffe140cc4a461985f728823548', 'Andreina', 'Granado L', 'Coordinadora de proyectos', 'Andreinagranado4@gmail.com', '04143419392', 5, 'administrativo', '', 'jefe_alm', 'activo'),
(251, '2015-07-08 00:11:59', '7149603', '3359ea19523576f451804170fca183d3d2d72beb', 'De Leon Dany', 'De Cecchis', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(301, '2015-07-08 00:11:59', '7210515', 'dea0f15cf35506ff9654260f00798eee210ab650', 'Carlos', 'Perez', 'Electricista', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(252, '2015-07-08 00:11:59', '7221077', '96d877e494ad29d19e5f72b0e99fffb571bed3af', 'Miguel', 'Luis Luis', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(253, '2015-07-08 00:11:59', '7262333', 'c7611758bcb9ab66eb00a92750cdc285992360d4', 'Carlos', 'Machado', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(254, '2015-07-08 00:11:59', '7352958', 'b8cc4f8c06fcaae96420beb4fba65c69d351e8b4', 'Castillo Desiree', 'Delgado de', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(255, '2015-07-08 00:11:59', '7436881', '4f9a15cab507a99c1fed64b4f9006ee65ae8464a', 'Ana', 'Aguilera Faraco', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(256, '2015-07-08 00:11:59', '7538127', '0f4f86646d6ca2be603e4fc4ab4465727f8988b2', 'Pedro', 'Linares Herrera', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(294, '2015-07-08 00:11:59', '7560867', '4e060fe582069c7f39161ff7d89f507dbf515d78', 'José', 'Granado', '', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(257, '2016-01-27 17:23:10', '7569635', 'f23e4c906487df3da60eb3e42de314c69826748b', 'Jorge L.', 'Marval Frontado', 'Jefe Sectorial   de Presu', '', '', 5, 'administrativo', '', 'asistente_dep', 'activo'),
(258, '2015-07-08 00:11:59', '7731949', '21e6518579590bae50081d8849e15948eba1cd8b', 'Xiomara', 'Cardozo R.', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(259, '2015-07-08 00:11:59', '8007908', '3bd9b05ab768217e9781cb6a1cb236a7594cd2cf', 'Maria', 'Guevara Matheus', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(260, '2015-07-08 00:11:59', '8019647', 'c3a05964d533e20c22709df691029da410dab45d', 'Jose', 'Albornoz ', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(261, '2015-07-08 00:11:59', '8044677', 'a790b697b9f9f28c30ae0c916209f971b559d091', 'Mirella', 'Herrera Colmenares', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(262, '2015-07-08 00:11:59', '8217801', 'c381bfe30a79b8054e0649473713da167e772dbc', 'Jose', 'Guaregua Marquez', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(263, '2016-02-04 17:08:44', '8254206', 'c62102f24de6491d2a0c1645688afb599e0ad8e1', 'Jose', 'Marcano Chivico', 'Decano', 'jmarcano1967@gmail.com', '04128530463', 5, 'docente', '', 'autoridad', 'activo'),
(264, '2015-07-08 00:11:59', '84322224', 'f21fab8ac877c48eaf549632cc4f68e9d4dfb803', 'Toma', 'Ronaldo', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(265, '2015-07-08 00:11:59', '8603641', '4be5eaea932000595167c0044612490cd43ae544', 'Farran Ana', 'Armas de', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(266, '2015-07-08 00:11:59', '8611660', '0a517081eaaad762dd54223350f8941b06c98297', 'Dinarle', 'Ortega ', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(267, '2016-02-03 15:05:05', '8668239', '43b22375090d4a31e0f9a4808565411909e45bae', 'Jaidin', 'Nuñez', 'Jefe Sectorial de Recurso', 'nunezj@uc.edu.ve', '04127538172', 20, 'administrativo', '', 'director_dep', 'activo');
INSERT INTO `dec_usuario` (`ID`, `TIME`, `id_usuario`, `password`, `nombre`, `apellido`, `cargo`, `email`, `telefono`, `id_dependencia`, `tipo`, `observacion`, `sys_rol`, `status`) VALUES
(268, '2015-07-08 00:11:59', '8669391', 'fc160f65ba00bbc04696748c0158c08d2c42b146', 'Beatriz', 'Moy Fajardo', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(298, '2015-07-08 00:11:59', '8711369', '8332c49b18c9e4ee9beb225627185ced922aa7a0', 'Adelso', 'Mendez ', 'Mensajero Externo', '', '', 5, 'obrero', NULL, 'no_visible', 'activo'),
(269, '2015-07-08 00:11:59', '8730138', '67b0a27b8ba718fa0efca54f3defcfb91a893e7b', 'Infante Aracelis', 'Hernandez de', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(270, '2015-07-08 00:11:59', '8795671', '459d2d74b36873d8960da3f26a1d534e5aaf7a06', 'Saba', 'Infante Quirpa', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(271, '2015-07-08 00:11:59', '8837384', '77ae1bd9812a3043cbe4c80eec694845636e4096', 'Arturo', 'Lopez', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(272, '2015-07-08 00:11:59', '8839237', 'fbecb62d11823826fb9d39e4dfe1a19bad73d8f6', 'Luis', 'Matos Sanchez', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(273, '2016-02-10 21:59:31', '8841651', '9a9a3f8c234f3fadaf61a54d5e3c2adece89f3e2', 'Marylin', 'Giugni', 'Administrador del sistema', '', '04124303301', 3, 'docente', '', 'autoridad', 'activo'),
(274, '2015-07-08 00:11:59', '9173005', 'c54103cadedf041e9de33ca846fd30d0bbf54dea', 'Richard', 'Barrios ', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(275, '2015-07-08 00:11:59', '9212276', '35410b67ec77278d1d9f571d651f8155a4d95328', 'Jorge', 'Castellanos Diaz', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(276, '2015-07-08 00:11:59', '9277997', '0dfcff4a974e47e718c41db5d96920254aa7dee5', 'José', 'Gomez', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(277, '2015-07-08 00:11:59', '9311496', '2a31dc1af76fec4a94dd1ec0271b9e0652aac83d', 'Rivas', 'Loyda J.', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(278, '2015-07-08 00:11:59', '9349387', '428d845e8031e4b37c0c6213e0be53dc9c5336f6', 'Miguel', 'Rodriguez Rodriguez', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(279, '2015-07-08 00:11:59', '9413599', '1becc4f2058e4b960a28ac888ba1b198e9c85f52', 'Miryelis', 'Rojas Caruci', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(280, '2015-07-08 00:11:59', '9435975', '99d4eac44f11d47a6b097a691b1d21597735bf62', 'Carlos', 'Linares Aponte', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(281, '2016-03-09 16:32:59', '9449314', '6e885668de4e05b0eda630b91587088131f834f4', 'Willin', 'Alvarez ', 'Director de Estudios para', '', '', 5, 'docente', '', 'asistente_dep', 'activo'),
(282, '2015-07-08 00:11:59', '9489872', '7717eefe2718d08d9cf94816531f98a03006d0ac', 'Pimali', 'Felibertt Sanabria', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(283, '2015-07-08 00:11:59', '9588017', '00f0eb65f49f53367b5333249c703f1d2283e4ae', 'Luis', 'Rodriguez Jose', '', '', '', 5, '', NULL, 'no_visible', 'inactivo'),
(284, '2015-07-08 00:11:59', '9608943', '3fd9dc9b257885309e87fe9de6158a4df6e91f12', 'William', 'Palmero P.', '', '', '', 5, 'administrativo', NULL, 'no_visible', 'inactivo'),
(285, '2015-07-08 00:11:59', '9663251', 'c0e3987666e56089e7d5d26129082ff542bb66b5', 'Jorge', 'Rodriguez Rojas', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(286, '2015-07-08 00:11:59', '9959898', '6e175d4f4fe8dad82df9967efb229ab075a90062', 'Silva Rafael', 'Fernandez Da', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo'),
(287, '2015-07-08 00:11:59', '9966192', '0e35ab62f2eed5e73a5a148d014d7bceebc24690', 'Jose', 'Rodriguez Q', '', '', '', 5, 'docente', NULL, 'no_visible', 'inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inv_equipos`
--

CREATE TABLE IF NOT EXISTS `inv_equipos` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `inv_uc` varchar(15) NOT NULL,
  `marca` varchar(255) NOT NULL,
  `modelo` varchar(255) NOT NULL,
  `tipo_eq` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_asigna_cuadrilla`
--

CREATE TABLE IF NOT EXISTS `mnt_asigna_cuadrilla` (
  `id_usuario` varchar(9) NOT NULL,
  `id_cuadrilla` bigint(20) NOT NULL,
  `id_ordenes` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mnt_asigna_cuadrilla`
--

INSERT INTO `mnt_asigna_cuadrilla` (`id_usuario`, `id_cuadrilla`, `id_ordenes`) VALUES
('10131920', 1, '000000097'),
('10131920', 1, '000000101'),
('10131920', 1, '000000102'),
('8841651', 1, '000000071'),
('8841651', 1, '000000090'),
('10131920', 3, '000000096'),
('17986853', 3, '000000087'),
('8841651', 4, '000000078'),
('8841651', 4, '000000079'),
('8841651', 4, '000000093'),
('8841651', 4, '000000094'),
('8841651', 5, '000000077'),
('10131920', 6, '000000100'),
('8841651', 8, '000000074'),
('8841651', 8, '000000083'),
('8841651', 8, '000000091'),
('8841651', 8, '000000092');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_asigna_material`
--

CREATE TABLE IF NOT EXISTS `mnt_asigna_material` (
  `id_solicitud` bigint(20) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL,
  `id_usuario` varchar(9) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_ayudante_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_ayudante_orden` (
  `id_trabajador` varchar(9) NOT NULL,
  `id_orden_trabajo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mnt_ayudante_orden`
--

INSERT INTO `mnt_ayudante_orden` (`id_trabajador`, `id_orden_trabajo`) VALUES
('10266594', '000000001'),
('10266594', '000000002'),
('10266594', '000000003'),
('10266594', '000000074'),
('10266594', '000000083'),
('10266594', '000000084'),
('10266594', '000000085'),
('10266594', '000000091'),
('10455543', '000000002'),
('10455543', '000000003'),
('10455543', '000000071'),
('10455543', '000000085'),
('10455543', '000000090'),
('10455543', '000000092'),
('10455543', '000000097'),
('10455543', '000000101'),
('10455543', '000000102'),
('12092890', '000000085'),
('12092890', '000000092'),
('12092890', '000000093'),
('12092890', '000000100'),
('12106491', '000000083'),
('12106491', '000000085'),
('12106491', '000000091'),
('12106491', '000000092'),
('13047133', '000000078'),
('13047133', '000000079'),
('13047133', '000000085'),
('13047133', '000000093'),
('13047133', '000000094'),
('15494959', '000000096'),
('16503761', '000000100'),
('18468502', '000000078'),
('18468502', '000000079'),
('18468502', '000000094'),
('23649287', '000000087'),
('23649287', '000000096'),
('6484055', '000000077'),
('7560867', '000000078'),
('7560867', '000000079'),
('7560867', '000000093'),
('7560867', '000000094');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_cuadrilla`
--

CREATE TABLE IF NOT EXISTS `mnt_cuadrilla` (
  `id` bigint(20) NOT NULL,
  `id_trabajador_responsable` varchar(9) NOT NULL,
  `cuadrilla` varchar(30) NOT NULL,
  `icono` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mnt_cuadrilla`
--

INSERT INTO `mnt_cuadrilla` (`id`, `id_trabajador_responsable`, `cuadrilla`, `icono`) VALUES
(1, '10455543', 'MANTENIMIENTO GENERAL', 'assets/img/mnt/mntg.png'),
(2, '16280386', 'LIMPIEZA DECANATO', 'assets/img/mnt/limpieza.png'),
(3, '15494959', 'PLOMERIA', 'assets/img/mnt/plomeria.png'),
(4, '7560867', 'AIRE ACONDICIONADO', 'assets/img/mnt/aire.png'),
(5, '6484055', 'ELECTRONICA', 'assets/img/mnt/electronica.png'),
(6, '12092890', 'PINTURA', 'assets/img/mnt/pintura.png'),
(7, '8711369', 'MENSAJERIA', 'assets/img/mnt/mensajeria.png'),
(8, '10266594', 'ELECTRICIDAD', 'assets/img/mnt/electrico.png'),
(13, '10266594', 'ACRRE', 'assets/img/mnt/mensaje_icono1.'),
(18, '17679264', 'LIMPIEZA QUIMICA', 'assets/img/mnt/limpiezaq.png'),
(19, '10266594', 'Otras', 'uploads/mnt/otras.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_estatus`
--

CREATE TABLE IF NOT EXISTS `mnt_estatus` (
  `id_estado` bigint(20) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mnt_estatus`
--

INSERT INTO `mnt_estatus` (`id_estado`, `descripcion`) VALUES
(1, 'ABIERTA'),
(2, 'EN PROCESO'),
(3, 'CERRADA'),
(4, 'ANULADA'),
(5, 'PENDIENTE POR MATERIAL'),
(6, 'PENDIENTE POR PERSONAL');

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

--
-- Volcado de datos para la tabla `mnt_estatus_orden`
--

INSERT INTO `mnt_estatus_orden` (`id_estado`, `id_orden_trabajo`, `id_usuario`, `fecha_p`) VALUES
(1, 1, '17986853', '2015-07-14 06:27:28'),
(1, 1, '17986853', '2015-07-14 06:53:03'),
(1, 1, '17986853', '2015-07-15 16:07:07'),
(2, 1, '17986853', '2015-07-14 06:52:43'),
(2, 1, '17986853', '2015-07-15 12:46:33'),
(2, 1, '17986853', '2015-07-30 16:24:58'),
(6, 1, '17986853', '2015-07-15 12:47:57'),
(1, 2, '17986853', '2015-07-20 06:46:15'),
(2, 2, '17986853', '2015-07-20 06:54:50'),
(2, 2, '17986853', '2015-07-21 12:45:20'),
(2, 2, '17986853', '2015-07-21 13:02:08'),
(2, 2, '17986853', '2015-07-29 15:28:56'),
(2, 2, '17986853', '2015-07-29 15:30:44'),
(2, 2, '17986853', '2015-07-29 15:30:56'),
(2, 2, '17986853', '2015-07-30 16:24:43'),
(2, 2, '17986853', '2015-07-30 16:27:41'),
(4, 2, '17986853', '2016-02-10 13:07:42'),
(5, 2, '17986853', '2015-07-29 15:02:28'),
(5, 2, '17986853', '2015-07-29 15:44:49'),
(6, 2, '17986853', '2015-07-20 06:55:18'),
(6, 2, '17986853', '2015-07-20 06:56:57'),
(6, 2, '17986853', '2015-07-29 15:30:02'),
(1, 3, '17986853', '2015-07-29 06:25:46'),
(2, 3, '17986853', '2015-07-30 15:56:58'),
(2, 3, '17986853', '2015-07-30 16:31:38'),
(3, 3, '17986853', '2016-01-28 16:28:41'),
(1, 4, '17986853', '2015-10-06 16:42:11'),
(1, 5, '17986853', '2015-10-06 16:43:54'),
(1, 6, '17986853', '2015-10-06 16:54:27'),
(1, 7, '10701349', '2015-10-14 13:18:53'),
(1, 8, '10701349', '2015-10-14 13:36:37'),
(1, 9, '10701349', '2015-10-14 13:40:33'),
(1, 10, '10701349', '2015-10-14 13:58:46'),
(1, 11, '10701349', '2015-10-14 15:00:26'),
(1, 12, '10701349', '2015-10-14 15:03:48'),
(1, 13, '10701349', '2015-10-14 15:05:29'),
(1, 14, '10701349', '2015-10-14 15:10:30'),
(1, 15, '10701349', '2015-10-14 15:11:44'),
(1, 16, '10701349', '2015-10-14 15:13:05'),
(1, 17, '10701349', '2015-10-14 15:14:30'),
(1, 18, '10701349', '2015-10-14 15:19:22'),
(1, 19, '10701349', '2015-10-14 15:20:28'),
(1, 20, '10701349', '2015-10-14 15:21:10'),
(1, 21, '10701349', '2015-10-14 15:25:12'),
(1, 22, '10701349', '2015-10-14 15:26:25'),
(1, 23, '10701349', '2015-10-14 15:28:56'),
(1, 24, '10701349', '2015-10-14 15:31:11'),
(1, 25, '10701349', '2015-10-14 15:32:11'),
(1, 26, '10701349', '2015-10-14 15:33:55'),
(1, 27, '10701349', '2015-10-14 15:34:52'),
(1, 28, '10701349', '2015-10-14 15:36:13'),
(1, 29, '10701349', '2015-10-14 15:37:09'),
(1, 30, '10701349', '2015-10-14 15:39:16'),
(1, 31, '10701349', '2015-10-14 15:40:59'),
(1, 32, '10701349', '2015-10-14 15:42:38'),
(1, 33, '10701349', '2015-10-14 15:43:33'),
(1, 34, '10701349', '2015-10-14 15:44:20'),
(1, 35, '10701349', '2015-10-14 15:45:24'),
(1, 36, '10701349', '2015-10-14 15:46:45'),
(1, 37, '10701349', '2015-10-14 15:47:30'),
(1, 38, '10701349', '2015-10-14 15:48:15'),
(1, 39, '10701349', '2015-10-14 15:48:55'),
(1, 40, '10701349', '2015-10-14 15:49:45'),
(1, 41, '10701349', '2015-10-14 15:50:27'),
(1, 42, '10701349', '2015-10-14 15:51:29'),
(1, 43, '10701349', '2015-10-14 15:52:53'),
(1, 44, '10701349', '2015-10-14 15:54:05'),
(1, 45, '10701349', '2015-10-14 15:55:02'),
(1, 46, '10701349', '2015-10-14 15:56:18'),
(1, 47, '10701349', '2015-10-14 15:57:21'),
(1, 48, '10701349', '2015-10-14 16:13:15'),
(1, 49, '10701349', '2015-10-14 16:14:34'),
(1, 50, '10701349', '2015-10-14 16:16:25'),
(1, 51, '10701349', '2015-10-14 16:19:30'),
(1, 52, '10701349', '2015-10-14 16:20:28'),
(1, 53, '10701349', '2015-10-14 16:22:35'),
(1, 54, '10701349', '2015-10-14 16:23:19'),
(1, 55, '10701349', '2015-10-14 16:24:58'),
(1, 56, '10701349', '2015-10-14 16:26:03'),
(1, 57, '10701349', '2015-10-14 16:27:40'),
(1, 58, '10701349', '2015-10-14 16:28:38'),
(1, 59, '10701349', '2015-10-14 16:29:23'),
(1, 60, '10701349', '2015-10-14 16:30:22'),
(1, 61, '10701349', '2015-10-14 16:31:27'),
(1, 62, '10701349', '2015-10-14 16:32:06'),
(1, 63, '10701349', '2015-10-14 16:32:57'),
(1, 64, '10701349', '2015-10-14 16:34:34'),
(1, 65, '10701349', '2015-10-14 16:35:30'),
(1, 66, '10701349', '2015-10-14 16:36:27'),
(1, 67, '10701349', '2015-10-14 16:37:41'),
(1, 68, '10701349', '2015-10-14 16:38:43'),
(1, 69, '10701349', '2015-10-14 16:39:37'),
(1, 70, '10701349', '2015-10-14 16:40:07'),
(1, 71, '10701349', '2015-10-14 16:40:41'),
(2, 71, '8841651', '2015-11-30 06:03:21'),
(1, 72, '10701349', '2015-10-14 16:47:29'),
(1, 73, '10701349', '2015-10-14 16:49:05'),
(1, 74, '10701349', '2015-10-14 16:49:55'),
(2, 74, '8841651', '2016-02-03 14:05:06'),
(3, 74, '8841651', '2016-02-03 14:08:45'),
(1, 75, '10701349', '2015-10-14 16:50:50'),
(1, 76, '10701349', '2015-10-14 16:51:36'),
(1, 77, '10701349', '2015-10-14 16:54:10'),
(2, 77, '8841651', '2016-02-02 07:22:41'),
(4, 77, '8841651', '2016-02-02 07:23:54'),
(1, 78, '10701349', '2015-10-14 16:55:09'),
(2, 78, '8841651', '2016-02-02 07:22:52'),
(4, 78, '8841651', '2016-02-02 07:23:47'),
(1, 79, '10701349', '2015-10-14 16:55:42'),
(2, 79, '8841651', '2016-02-02 07:23:10'),
(4, 79, '8841651', '2016-02-02 07:23:27'),
(4, 79, '8841651', '2016-02-02 07:23:38'),
(1, 80, '10701349', '2015-10-14 17:20:48'),
(1, 81, '10701349', '2015-10-14 17:22:32'),
(1, 82, '10701349', '2015-10-14 17:23:12'),
(1, 83, '10701349', '2015-10-14 17:24:08'),
(1, 83, '8841651', '2015-11-30 06:21:42'),
(2, 83, '17986853', '2015-10-14 05:43:30'),
(2, 83, '17986853', '2015-10-14 05:51:09'),
(2, 83, '8841651', '2015-11-30 06:09:08'),
(2, 83, '8841651', '2015-11-30 06:10:32'),
(2, 83, '8841651', '2015-11-30 06:21:01'),
(2, 83, '8841651', '2015-11-30 06:21:25'),
(2, 83, '8841651', '2015-11-30 06:21:35'),
(2, 83, '8841651', '2015-11-30 06:22:08'),
(4, 83, '8841651', '2016-02-02 07:21:31'),
(1, 84, '10701349', '2015-10-14 06:02:07'),
(2, 84, '8841651', '2015-11-30 06:13:46'),
(4, 84, '8841651', '2016-02-02 07:22:18'),
(1, 85, '10701349', '2015-10-14 06:03:19'),
(2, 85, '17986853', '2015-12-01 17:13:23'),
(2, 85, '8841651', '2015-11-30 06:13:38'),
(4, 85, '8841651', '2016-02-02 07:21:50'),
(1, 86, '10701349', '2015-10-14 06:04:41'),
(1, 87, '10701349', '2015-10-14 06:05:32'),
(1, 87, '17986853', '2015-12-01 17:06:45'),
(2, 87, '17986853', '2015-12-01 17:04:06'),
(2, 87, '17986853', '2015-12-01 17:07:09'),
(4, 87, '8841651', '2016-02-02 07:22:03'),
(1, 88, '10701349', '2015-10-14 06:06:30'),
(1, 89, '10701349', '2015-10-14 06:07:03'),
(1, 90, '10701349', '2015-10-14 06:07:47'),
(2, 90, '8841651', '2016-01-29 16:13:36'),
(4, 90, '8841651', '2016-02-02 07:20:44'),
(1, 91, '10701349', '2015-10-14 06:08:30'),
(2, 91, '8841651', '2015-11-11 05:52:16'),
(3, 91, '8841651', '2015-11-11 05:53:02'),
(1, 92, '10701349', '2015-10-14 06:09:09'),
(2, 92, '8841651', '2015-11-04 14:15:30'),
(2, 92, '8841651', '2015-11-04 14:15:47'),
(2, 92, '8841651', '2015-11-10 07:30:12'),
(3, 92, '8841651', '2015-11-30 05:48:38'),
(1, 93, '8841651', '2016-01-21 14:55:54'),
(2, 93, '8841651', '2016-01-21 14:58:48'),
(2, 93, '8841651', '2016-01-21 15:00:28'),
(3, 93, '8841651', '2016-01-21 15:07:29'),
(5, 93, '8841651', '2016-01-21 15:03:58'),
(1, 94, '13989244', '2016-01-21 15:14:01'),
(2, 94, '8841651', '2016-01-21 15:18:28'),
(3, 94, '8841651', '2016-01-21 15:21:34'),
(1, 95, '10131920', '2016-01-29 16:42:54'),
(2, 95, '8841651', '2016-01-29 16:52:02'),
(3, 95, '8841651', '2016-01-29 16:57:02'),
(6, 95, '8841651', '2016-01-29 16:53:51'),
(1, 96, '8841651', '2016-02-02 16:20:05'),
(2, 96, '10131920', '2016-02-04 16:49:45'),
(1, 97, '14382083', '2016-02-04 13:59:39'),
(2, 97, '10131920', '2016-02-04 16:46:27'),
(1, 98, '11364017', '2016-02-04 15:00:10'),
(1, 99, '11364017', '2016-02-04 15:16:06'),
(1, 100, '11364017', '2016-02-04 15:18:29'),
(2, 100, '10131920', '2016-02-04 16:42:41'),
(1, 101, '11364017', '2016-02-04 15:20:37'),
(2, 101, '10131920', '2016-02-04 16:39:58'),
(1, 102, '11364017', '2016-02-04 15:22:06'),
(2, 102, '10131920', '2016-02-04 16:41:39'),
(1, 103, '11364017', '2016-02-04 15:31:37'),
(1, 104, '14162837', '2016-02-04 06:42:38'),
(1, 105, '13989244', '2016-02-10 12:50:43'),
(1, 106, '13989244', '2016-02-10 12:53:22'),
(1, 107, '14162837', '2016-02-11 13:06:48'),
(1, 108, '14162837', '2016-02-11 13:20:22'),
(1, 109, '14162837', '2016-02-11 13:21:58'),
(1, 110, '14162837', '2016-02-11 13:23:41'),
(1, 111, '14162837', '2016-02-11 13:27:57'),
(1, 112, '14162837', '2016-02-11 13:30:09'),
(1, 113, '14162837', '2016-02-11 13:31:37'),
(1, 114, '14162837', '2016-02-11 13:34:30'),
(1, 115, '14162837', '2016-02-11 13:36:43'),
(1, 116, '14162837', '2016-02-11 13:37:36'),
(1, 117, '14162837', '2016-02-11 13:38:18'),
(1, 118, '14162837', '2016-02-11 13:40:40'),
(1, 119, '14162837', '2016-02-11 13:44:17'),
(1, 120, '14162837', '2016-02-11 13:45:02'),
(1, 121, '14162837', '2016-02-11 13:45:38'),
(1, 122, '14162837', '2016-02-11 13:50:34'),
(1, 123, '14162837', '2016-02-11 14:02:30'),
(1, 124, '14162837', '2016-02-11 14:04:48'),
(1, 125, '14162837', '2016-02-11 14:07:25'),
(1, 126, '14162837', '2016-02-11 14:11:23'),
(1, 127, '14162837', '2016-02-11 14:23:50'),
(1, 128, '14162837', '2016-02-11 14:29:36'),
(1, 129, '14162837', '2016-02-11 14:32:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_miembros_cuadrilla`
--

CREATE TABLE IF NOT EXISTS `mnt_miembros_cuadrilla` (
  `id_cuadrilla` bigint(20) NOT NULL,
  `id_trabajador` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mnt_miembros_cuadrilla`
--

INSERT INTO `mnt_miembros_cuadrilla` (`id_cuadrilla`, `id_trabajador`) VALUES
(1, '10455543'),
(2, '17066227'),
(2, '16280386'),
(3, '15494959'),
(4, '7560867'),
(4, '13047133'),
(4, '18468502'),
(5, '6484055'),
(6, '12092890'),
(7, '8711369'),
(7, '20699287'),
(8, '10266594'),
(3, '23649287'),
(8, '12106491'),
(6, '16503761'),
(18, '17679264'),
(19, '10266594'),
(19, '12092890');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_observacion_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_observacion_orden` (
  `id_usuario` varchar(9) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL,
  `id_observacion` bigint(20) NOT NULL,
  `observac` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mnt_observacion_orden`
--

INSERT INTO `mnt_observacion_orden` (`id_usuario`, `id_orden_trabajo`, `id_observacion`, `observac`) VALUES
('17986853', 1, 1, ''),
('17986853', 1, 2, 'ESTAN OCUPADOS LOS OBREROS'),
('17986853', 2, 5, ''),
('17986853', 3, 6, ''),
('17986853', 4, 7, ''),
('17986853', 5, 8, ''),
('17986853', 6, 9, ''),
('10701349', 7, 10, ''),
('10701349', 8, 11, ''),
('10701349', 9, 12, ''),
('10701349', 10, 13, ''),
('10701349', 11, 14, ''),
('10701349', 12, 15, ''),
('10701349', 13, 16, ''),
('10701349', 14, 17, ''),
('10701349', 15, 18, ''),
('10701349', 16, 19, ''),
('10701349', 17, 20, ''),
('10701349', 18, 21, ''),
('10701349', 19, 22, ''),
('10701349', 20, 23, ''),
('10701349', 21, 24, ''),
('10701349', 22, 25, ''),
('10701349', 23, 26, ''),
('10701349', 24, 27, ''),
('10701349', 25, 28, ''),
('10701349', 26, 29, ''),
('10701349', 27, 30, ''),
('10701349', 28, 31, ''),
('10701349', 29, 32, ''),
('10701349', 30, 33, ''),
('10701349', 31, 34, ''),
('10701349', 32, 35, ''),
('10701349', 33, 36, ''),
('10701349', 34, 37, ''),
('10701349', 35, 38, ''),
('10701349', 36, 39, ''),
('10701349', 37, 40, ''),
('10701349', 38, 41, ''),
('10701349', 39, 42, ''),
('10701349', 40, 43, ''),
('10701349', 41, 44, ''),
('10701349', 42, 45, ''),
('10701349', 43, 46, ''),
('10701349', 44, 47, ''),
('10701349', 45, 48, ''),
('10701349', 46, 49, ''),
('10701349', 47, 50, ''),
('10701349', 48, 51, ''),
('10701349', 49, 52, ''),
('10701349', 50, 53, ''),
('10701349', 51, 54, ''),
('10701349', 52, 55, ''),
('10701349', 53, 56, ''),
('10701349', 54, 57, ''),
('10701349', 55, 58, ''),
('10701349', 56, 59, ''),
('10701349', 57, 60, ''),
('10701349', 58, 61, ''),
('10701349', 59, 62, ''),
('10701349', 60, 63, ''),
('10701349', 61, 64, ''),
('10701349', 62, 65, ''),
('10701349', 63, 66, ''),
('10701349', 64, 67, ''),
('10701349', 65, 68, ''),
('10701349', 66, 69, ''),
('10701349', 67, 70, ''),
('10701349', 68, 71, ''),
('10701349', 69, 72, ''),
('10701349', 70, 73, ''),
('10701349', 71, 74, ''),
('10701349', 72, 75, ''),
('10701349', 73, 76, ''),
('10701349', 74, 77, ''),
('10701349', 75, 78, ''),
('10701349', 76, 79, ''),
('10701349', 77, 80, ''),
('10701349', 78, 81, ''),
('10701349', 79, 82, ''),
('10701349', 80, 83, ''),
('10701349', 81, 84, ''),
('10701349', 82, 85, ''),
('10701349', 83, 86, ''),
('10701349', 84, 87, ''),
('10701349', 85, 88, ''),
('10701349', 86, 89, ''),
('10701349', 87, 90, ''),
('10701349', 88, 91, ''),
('10701349', 89, 92, ''),
('10701349', 90, 93, ''),
('10701349', 91, 94, ''),
('10701349', 92, 95, ''),
('8841651', 90, 96, 'GDFGSDFGSDFGSD'),
('10131920', 95, 97, 'CONTROL DE ESTUDIOS'),
('14382083', 97, 98, 'LABORATORIO DOCENCIA 6 (DPTO BIOLOGÍA)'),
('11364017', 98, 99, 'DPTO. MATEMÁTICA'),
('11364017', 99, 100, 'DPTO. MATEMÁTICA'),
('11364017', 100, 101, 'DPTO. MATEMÁTICA'),
('11364017', 101, 102, 'DPTO. MATEMÁTICA'),
('11364017', 102, 103, 'DPTO. MATEMÁTICA'),
('11364017', 103, 104, 'DPTO. MATEMÁTICA'),
('10131920', 103, 105, 'LLAMAR A JOSEFA PLANTA FíSICA PARA RECORDAR QUE DEBE RECOGER LOS ESCOMBROS EN MATEMáTICA. (ESTO ES UNA PRUEBA).'),
('14162837', 104, 106, 'LABORATORIO DE DOCENCIA I GENETICA'),
('14162837', 107, 107, 'LABORATORIO DE DOCENCIA I GENETICA'),
('14162837', 108, 108, 'LABORATORIO DE DOCENCIA I GENETICA'),
('14162837', 109, 109, 'LABORATORIO DE DOCENCIA I GENETICA'),
('14162837', 110, 110, 'LABORATORIO DE DOCENCIA I GENETICA'),
('14162837', 111, 111, 'LABORATORIO DE DOCENCIA I BIOQUIMICA'),
('14162837', 112, 112, 'LABORATORIO DE DOCENCIA III (LIASKA)'),
('14162837', 113, 113, 'LABORATORIO DE DOCENCIA III (LIASKA)'),
('14162837', 114, 114, 'LABORATORIO DE DOCENCIA III (ESTHER)'),
('14162837', 115, 115, 'LABORATORIO VII (JOELI)'),
('14162837', 116, 116, 'LABORATORIO VII (JOELI)'),
('14162837', 117, 117, 'LABORATORIO VII (JOELI)'),
('14162837', 118, 118, 'LABORATORIO IX (DAYANA ARAUJO)'),
('14162837', 119, 119, 'MUSEO DE ZOOLOGIA (FRANGER)'),
('14162837', 120, 120, 'MUSEO DE ZOOLOGIA (FRANGER)'),
('14162837', 121, 121, 'MUSEO DE ZOOLOGIA (FRANGER)'),
('14162837', 122, 122, 'HERBARIO (EDGAR CARRASQUERO)'),
('14162837', 123, 123, 'CUARTO DE RACTIVOS LIQUIDOS Y SOLIDOS'),
('14162837', 124, 124, 'CUARTO DE RACTIVOS LIQUIDOS Y SOLIDOS'),
('14162837', 125, 125, 'LABORATORIO VIII (ANA KARINA)'),
('14162837', 126, 126, 'CUARTO DE REACTIVOS LIQUIDOS Y SOLIDOS'),
('14162837', 127, 127, 'CUARTO DE RACTIVOS LIQUIDOS Y SOLIDOS, DESECHOS'),
('14162837', 128, 128, 'CUARTO DE BOMBONAS BIOTECNOLOGIA (ESTHER)'),
('14162837', 129, 129, 'DEPOSITO DEL BIOMAC (PROF JOSE GREGORIO RODRIGUEZ)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_orden_trabajo`
--

CREATE TABLE IF NOT EXISTS `mnt_orden_trabajo` (
  `id` bigint(20) NOT NULL,
  `id_orden` varchar(20) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_tipo` bigint(20) NOT NULL,
  `nombre_contacto` varchar(255) NOT NULL,
  `telefono_contacto` varchar(25) NOT NULL,
  `asunto` varchar(40) NOT NULL,
  `descripcion_general` mediumtext NOT NULL,
  `dependencia` bigint(20) NOT NULL,
  `ubicacion` bigint(20) NOT NULL DEFAULT '1',
  `estatus` bigint(20) NOT NULL,
  `motivo` text NOT NULL,
  `sugerencia` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mnt_orden_trabajo`
--

INSERT INTO `mnt_orden_trabajo` (`id`, `id_orden`, `fecha`, `id_tipo`, `nombre_contacto`, `telefono_contacto`, `asunto`, `descripcion_general`, `dependencia`, `ubicacion`, `estatus`, `motivo`, `sugerencia`) VALUES
(1, '000000001', '2015-07-30 16:24:58', 6, 'AURY CAROLINA  RODRIGUEZ', '123456789', 'PINTAR LAB DOCENCIA II', 'SOLICITAMOS DE SUS SERVICIOS PARA LAS LABORES DE PINTURA EN TODAS LAS AREAS QUE CORRESPONDEN AL LABORATORIO DE DOCENCIA II     ', 9, 2, 2, '', ''),
(2, '000000002', '2016-02-10 13:07:42', 3, 'AURY CAROLINA RODRIGUEZ RODRIGUEZ', '315191', 'JUHYET', 'DERTY HYRUT ', 9, 1, 4, 'PRUEBA DEL SISTEMA', ''),
(3, '000000003', '2016-02-02 15:01:21', 12, 'AURY CAROLINA RODRIGUEZ RODRIGUEZ', '315191', 'PRUEBA SOLICITUD', 'SOLICITUD DE PRUEBA', 18, 1, 3, 'PRUEBA SOLICITUD', 'PRUEBA'),
(4, '000000004', '2015-10-06 16:42:11', 6, 'VINCENZO STORACI', '6004000', 'PINTAR ESTANTES', 'LAB 1-B. BIOQUIMICA ', 2, 1, 1, '', ''),
(5, '000000005', '2015-10-06 16:43:54', 6, 'VINCENZO STORACI', '6004000', 'PINTAR REJAS ', 'PINTAR REJAS BLANCAS. \nLAB 1-B, BIOQUIMICA', 2, 1, 1, '', ''),
(6, '000000006', '2015-10-06 16:54:27', 6, 'VINCENZO STORACI', '6004000', 'PINTURA REJAS', 'LAB. BIOTECNOLOGIA  LAB IV', 2, 1, 1, '', ''),
(7, '000000007', '2015-10-14 13:18:53', 4, 'VINCENZO STORACI', '6004000', 'AIRE ACONDICIONADO DAñADO', 'LAB 1A MICROGENETICA', 2, 1, 1, '', ''),
(8, '000000008', '2015-10-14 13:36:37', 3, 'VINCENZO STORACI', '6004000', 'LLAVE DE PASO', 'LABORATORIO 1-A GENETICA', 2, 1, 1, '', ''),
(9, '000000009', '2015-10-14 13:40:33', 1, 'VINCENZO STORACI', '6004000', 'HUMEDAD DE PARED', 'LABORATORIO 1-A GENETICA', 2, 1, 1, '', ''),
(10, '000000010', '2015-10-14 13:58:46', 1, 'VINCENZO STORACI', '6004000', 'SOLDAR BANCOS', 'LABORATORIO 1-A MICRO GENETICA', 2, 1, 1, '', ''),
(11, '000000011', '2015-10-14 15:00:26', 5, 'VINCENZO STORACI', '6004000', 'FABRICADOR DE HIELO', 'LABORATORIO 1-A MICRO GENETICA', 2, 1, 1, '', ''),
(12, '000000012', '2015-10-14 15:03:48', 3, 'VINCENZO STORACI', '6004000', 'PARED TUBERIA', 'LABORATORIO 1-A MICRO GENETICA', 2, 1, 1, '', ''),
(13, '000000013', '2015-10-14 15:05:29', 4, 'VINCENZO STORACI', '6004000', 'AIRE CEPARIO GAS', 'LABORATORIO 1-A MICRO GENETICA', 2, 1, 1, '', ''),
(14, '000000014', '2015-10-14 15:10:30', 4, 'VINCENZO STORACI', '6004000', 'AIRE ACONDICIONADO DAÑADO', 'LABORATORIO 1-B   BIOQUIMICA', 2, 1, 1, '', ''),
(15, '000000015', '2015-10-14 15:11:44', 1, 'VINCENZO STORACI', '6004000', 'MANGUERA DESTILADOR', 'LABORATORIO 1-B  BIOQUIMICA', 2, 1, 1, '', ''),
(16, '000000016', '2015-10-14 15:13:05', 1, 'VINCENZO STORACI', '6004000', 'TAPAR HUECOS PARED', 'LABORATORIO 1-B  BIOQUIMICA', 2, 1, 1, '', ''),
(17, '000000017', '2015-10-14 15:14:30', 1, 'VINCENZO STORACI', '6004000', 'FRISO EXTERNO', 'LABORATORIO 1-B  BIOQUIMICA', 2, 1, 1, '', ''),
(18, '000000018', '2015-10-14 15:19:22', 8, 'VINCENZO STORACI', '6004000', 'LAMPARAS Y BALASTROS', 'LABORATORIO 1-B  BIOQUIMICA', 2, 1, 1, '', ''),
(19, '000000019', '2015-10-14 15:20:28', 1, 'VINCENZO STORACI', '6004000', 'SOLDAR 2 BANCOS', 'LABORATORIO 1-B  BIOQUIMICA', 2, 1, 1, '', ''),
(20, '000000020', '2015-10-14 15:21:10', 5, 'VINCENZO STORACI', '6004000', 'NEVERA CONDENSADOR', 'LABORATORIO 1-B  BIOQUIMICA', 2, 1, 1, '', ''),
(21, '000000021', '2015-10-14 15:25:12', 4, 'VINCENZO STORACI', '6004000', 'AIRE BOTA AGUA', 'LABORATORIO II  BIOLOGIA GENERAL Y ANIMAL', 2, 1, 1, '', ''),
(22, '000000022', '2015-10-14 15:26:25', 4, 'VINCENZO STORACI', '6004000', 'AIRE BOTA AGUA', 'LABORATORIO II BIOLOGIA GENERAL Y ANIMAL', 2, 1, 1, '', ''),
(23, '000000023', '2015-10-14 15:28:56', 1, 'VINCENZO STORACI', '6004000', 'AGUA ESTANCADA FRENTE ', 'LABORATORIO III BIOLOGIA VEGETAL Y FISIOLOGIA VEGETAL', 2, 1, 1, '', ''),
(24, '000000024', '2015-10-14 15:31:11', 4, 'VINCENZO STORACI', '6004000', 'AIRE BOTA AGUA', 'LABORATORIO III BIOLOGIA VEGETAL Y FISIOLOGIA VEGETAL', 2, 1, 1, '', ''),
(25, '000000025', '2015-10-14 15:32:11', 3, 'VINCENZO STORACI', '6004000', 'LLAVE LAVAOJOS TAPADO', 'LABORATORIO III BIOLOGIA VEGETAL Y FISIOLOGIA VEGETAL', 2, 1, 1, '', ''),
(26, '000000026', '2015-10-14 15:33:55', 3, 'VINCENZO STORACI', '6004000', 'GRIFOS FALTA EMPACADURAS', 'LABORATORIO III BIOLOGIA VEGETAL Y FISIOLOGIA VEGETAL', 2, 1, 1, '', ''),
(27, '000000027', '2015-10-14 15:34:52', 4, 'VINCENZO STORACI', '6004000', 'AIRE FILTRO GOTEA', 'LABORATORIO III BIOLOGIA VEGETAL Y FISIOLOGIA VEGETAL', 2, 1, 1, '', ''),
(28, '000000028', '2015-10-14 15:36:14', 8, 'VINCENZO STORACI', '6004000', 'BOMBILLOS 12 (TIPO 32)', 'LABORATORIO III BIOLOGIA VEGETAL Y FISIOLOGIA VEGETAL', 2, 1, 1, '', ''),
(29, '000000029', '2015-10-14 15:37:09', 1, 'VINCENZO STORACI', '6004000', 'RECARGA DE EXTINTOR', 'LABORATORIO III BIOLOGIA VEGETAL Y FISIOLOGIA VEGETAL', 2, 1, 1, '', ''),
(30, '000000030', '2015-10-14 15:39:16', 1, 'VINCENZO STORACI', '6004000', 'ARREGLAR PUERTA BISAGRA', 'LABORATORIO III BIOLOGIA VEGETAL Y FISIOLOGIA VEGETAL', 2, 1, 1, '', ''),
(31, '000000031', '2015-10-14 15:40:59', 4, 'VINCENZO STORACI', '6004000', 'RUIDO DEL EXTRACTOR', 'LABORATORIO III BIOLOGIA VEGETAL Y FISIOLOGIA VEGETAL', 2, 1, 1, '', ''),
(32, '000000032', '2015-10-14 15:42:38', 5, 'VINCENZO STORACI', '6004000', 'BOMBILLO NEVERA QUEMADO', 'LABORATORIO III BIOLOGIA VEGETAL Y FISIOLOGIA VEGETAL', 2, 1, 1, '', ''),
(33, '000000033', '2015-10-14 15:43:33', 5, 'VINCENZO STORACI', '6004000', 'BOMBA DE VACIO DAñADA', 'LABORATORIO III BIOLOGIA VEGETAL Y FISIOLOGIA VEGETAL', 2, 1, 1, '', ''),
(34, '000000034', '2015-10-14 15:44:20', 5, 'VINCENZO STORACI', '6004000', 'REGULADORES DAñADOS', 'LABORATORIO III BIOLOGIA VEGETAL Y FISIOLOGIA VEGETAL', 2, 1, 1, '', ''),
(35, '000000035', '2015-10-14 15:45:24', 5, 'VINCENZO STORACI', '6004000', 'CONTROL DE AIRE DAñADO', 'LABORATORIO III BIOLOGIA VEGETAL Y FISIOLOGIA VEGETAL', 2, 1, 1, '', ''),
(36, '000000036', '2015-10-14 15:46:45', 8, 'VINCENZO STORACI', '6004000', '15 BOMBILLOS', 'LABORATORIO IV BIOTECNOLOGIA', 2, 1, 1, '', ''),
(37, '000000037', '2015-10-14 15:47:30', 1, 'VINCENZO STORACI', '6004000', '2 SIFONES', 'LABORATORIO IV BIOTECNOLOGIA', 2, 1, 1, '', ''),
(38, '000000038', '2015-10-14 15:48:15', 4, 'VINCENZO STORACI', '6004000', 'AIRE TARJETA', 'LABORATORIO IV BIOTECNOLOGIA', 2, 1, 1, '', ''),
(39, '000000039', '2015-10-14 15:48:55', 8, 'VINCENZO STORACI', '6004000', '3 BALASTROS', 'LABORATORIO IV BIOTECNOLOGIA', 2, 1, 1, '', ''),
(40, '000000040', '2015-10-14 15:49:45', 1, 'VINCENZO STORACI', '6004000', 'MANGUERA LAVA', 'LABORATORIO IV BIOTECNOLOGIA', 2, 1, 1, '', ''),
(41, '000000041', '2015-10-14 15:50:27', 4, 'VINCENZO STORACI', '6004000', 'AIRE SIN CONTROL', 'LABORATORIO IV BIOTECNOLOGIA', 2, 1, 1, '', ''),
(42, '000000042', '2015-10-14 15:51:29', 4, 'VINCENZO STORACI', '6004000', 'AIRE GAS REFG', 'LABORATORIO IV BIOTECNOLOGIA', 2, 1, 1, '', ''),
(43, '000000043', '2015-10-14 15:52:53', 4, 'VINCENZO STORACI', '6004000', 'AIRE MANTENIMIENTO', 'LABORATORIO V ECOLOGIA MARINA', 2, 1, 1, '', ''),
(44, '000000044', '2015-10-14 15:54:05', 8, 'VINCENZO STORACI', '6004000', 'LAMPARA DE SEG', 'LABORATORIO V ECOLOGIA MARINA', 2, 1, 1, '', ''),
(45, '000000045', '2015-10-14 15:55:02', 5, 'VINCENZO STORACI', '6004000', 'NEVERA', 'LABORATORIO V ECOLOGIA MARINA', 2, 1, 1, '', ''),
(46, '000000046', '2015-10-14 15:56:18', 8, 'VINCENZO STORACI', '6004000', '3 BOMBILLOS', 'LABORATORIO V ECOLOGIA MARINA', 2, 1, 1, '', ''),
(47, '000000047', '2015-10-14 15:57:21', 1, 'VINCENZO STORACI', '6004000', 'CERAMICA BATEA', 'LABORATORIO V ECOLOGIA MARINA', 2, 1, 1, '', ''),
(48, '000000048', '2015-10-14 16:13:15', 4, 'VINCENZO STORACI', '6004000', 'EXTRACTOR', 'LABORATORIO VI BIODIVERSIDAD VEGETAL', 2, 1, 1, '', ''),
(49, '000000049', '2015-10-14 16:14:34', 4, 'VINCENZO STORACI', '6004000', 'AIRE ACONDICIONADO', 'LABORATORIO VI BIODIVERSIDAD VEGETAL', 2, 1, 1, '', ''),
(50, '000000050', '2015-10-14 16:16:25', 8, 'VINCENZO STORACI', '6004000', '4 BOMBILLOS', 'LABORATORIO VI BIODIVERSIDAD VEGETAL', 2, 1, 1, '', ''),
(51, '000000051', '2015-10-14 16:19:30', 4, 'VINCENZO STORACI', '6004000', 'RESISTENCIA DESTILADOR ', 'LABORATORIO VI BIODIVERSIDAD VEGETAL', 2, 1, 1, '', ''),
(52, '000000052', '2015-10-14 16:20:28', 3, 'VINCENZO STORACI', '6004000', 'TUBO ROTO', 'LABORATORIO VI BIODIVERSIDAD VEGETAL', 2, 1, 1, '', ''),
(53, '000000053', '2015-10-14 16:22:35', 4, 'VINCENZO STORACI', '6004000', 'MANTENIMIENTO A/A FILTRO', 'LABORATORIO VIII BIODIVERSIDAD ANIMAL', 2, 1, 1, '', ''),
(54, '000000054', '2015-10-14 16:23:19', 3, 'VINCENZO STORACI', '6004000', 'FREGADERO SILICON', 'LABORATORIO VIII BIODIVERSIDAD ANIMAL', 2, 1, 1, '', ''),
(55, '000000055', '2015-10-14 16:24:58', 8, 'VINCENZO STORACI', '6004000', '5 BOMBILLOS', 'LABORATORIO VIII BIODIVERSIDAD ANIMAL', 2, 1, 1, '', ''),
(56, '000000056', '2015-10-14 16:26:03', 1, 'VINCENZO STORACI', '6004000', 'MURO PARA EL AGUA', 'LABORATORIO VIII BIODIVERSIDAD ANIMAL', 2, 1, 1, '', ''),
(57, '000000057', '2015-10-14 16:27:40', 1, 'VINCENZO STORACI', '6004000', 'MURO AGUA', 'LABORATORIO IX ECOLOGIA TERRESTRE', 2, 1, 1, '', ''),
(58, '000000058', '2015-10-14 16:28:38', 3, 'VINCENZO STORACI', '6004000', 'SIFON 2 FREGADEROS', 'LABORATORIO IX ECOLOGIA TERRESTRE', 2, 1, 1, '', ''),
(59, '000000059', '2015-10-14 16:29:23', 5, 'VINCENZO STORACI', '6004000', 'INTERNET', 'LABORATORIO IX ECOLOGIA TERRESTRE', 2, 1, 1, '', ''),
(60, '000000060', '2015-10-14 16:30:22', 1, 'VINCENZO STORACI', '6004000', 'FILTRACION DEPOSITO', 'LABORATORIO IX ECOLOGIA TERRESTRE', 2, 1, 1, '', ''),
(61, '000000061', '2015-10-14 16:31:27', 1, 'VINCENZO STORACI', '6004000', 'CHIMENEA CAMPANA', 'LABORATORIO IX ECOLOGIA TERRESTRE', 2, 1, 1, '', ''),
(62, '000000062', '2015-10-14 16:32:06', 1, 'VINCENZO STORACI', '6004000', '3 SILLAS ROTAS', 'LABORATORIO IX ECOLOGIA TERRESTRE', 2, 1, 1, '', ''),
(63, '000000063', '2015-10-14 16:32:57', 8, 'VINCENZO STORACI', '6004000', '1 LAMPARA NO PRENDE', 'LABORATORIO IX ECOLOGIA TERRESTRE', 2, 1, 1, '', ''),
(64, '000000064', '2015-10-14 16:34:34', 1, 'VINCENZO STORACI', '6004000', 'FILTRO DE AGUA', 'LABORATORIO IX ECOLOGIA TERRESTRE', 2, 1, 1, '', ''),
(65, '000000065', '2015-10-14 16:35:30', 1, 'VINCENZO STORACI', '60040000', 'VIDRIO VENTANA', 'LABORATORIO IX ECOLOGIA TERRESTRE', 2, 1, 1, '', ''),
(66, '000000066', '2015-10-14 16:36:27', 5, 'VINCENZO STORACI', '6004000', 'INTERNET', 'MUSEO ZOOLOGIA', 2, 1, 1, '', ''),
(67, '000000067', '2015-10-14 16:37:41', 1, 'VINCENZO STORACI', '6004000', 'CONSTRUIR MURO', 'MUSEO ZOOLOGIA', 2, 1, 1, '', ''),
(68, '000000068', '2015-10-14 16:38:43', 4, 'VINCENZO STORACI', '6004000', 'COMPRESOR VENTILADOR', 'MUSEO ZOOLOGIA', 2, 1, 1, '', ''),
(69, '000000069', '2015-10-14 16:39:37', 4, 'VINCENZO STORACI', '6004000', '3 AIRES GAS', 'HERBARIO VEGETAL', 2, 1, 1, '', ''),
(70, '000000070', '2015-10-14 16:40:07', 8, 'VINCENZO STORACI', '6004000', 'BALASTROS', 'HERBARIO VEGETAL', 2, 1, 1, '', ''),
(71, '000000071', '2015-11-30 06:03:21', 1, 'HERMINIA JIMENEZ VELASQUEZ', '6004000', 'VENTANAS', 'HERBARIO VEGETAL', 2, 1, 2, '', ''),
(72, '000000072', '2015-10-14 16:47:29', 1, 'VINCENZO STORACI', '6004000', 'HUMEDAD', 'HERBARIO VEGETAL', 2, 1, 1, '', ''),
(73, '000000073', '2015-10-14 16:49:05', 1, 'VINCENZO STORACI', '6004000', 'MURO ENTRADA', 'HERBARIO VEGETAL', 2, 1, 1, '', ''),
(74, '000000074', '2016-02-03 14:08:45', 8, 'VINCENZO STORACI', '60040000', 'BOMBILLOS', 'HERBARIO VEGETAL', 2, 1, 3, 'PRUEBA DEL SISTEMA', ''),
(75, '000000075', '2015-10-14 16:50:50', 1, 'VINCENZO STORACI', '6004000', 'EXTINTOR RECARGA', 'HERBARIO VEGETAL', 2, 1, 1, '', ''),
(76, '000000076', '2015-10-14 16:51:36', 1, 'VINCENZO STORACI', '6004000', 'FUMIGACION', 'HERBARIO VEGETAL', 2, 1, 1, '', ''),
(77, '000000077', '2016-02-02 07:23:54', 5, 'VINCENZO STORACI', '6004000', 'INTERNET', 'HERBARIO VEGETAL', 2, 1, 4, 'PRUEBA DEL SISTEMA', ''),
(78, '000000078', '2016-02-02 07:23:47', 1, 'VINCENZO STORACI', '6004000', 'BOTE AGUA TANQUILLA', 'BIOTECNOLOGIA APLICADA', 2, 1, 4, 'PRUEBA DEL SISTEMA', ''),
(79, '000000079', '2016-02-02 07:23:38', 3, 'VINCENZO STORACI', '6004000', 'GRIFO MALO', 'BIOTECNOLOGIA APLICADA', 2, 1, 4, 'PRUEBA DEL SISTEMA', ''),
(80, '000000080', '2015-10-14 17:20:48', 1, 'VINCENZO STORACI', '6004000', 'CONSTRUIR MURO', 'NEUROCIENCIAS', 2, 1, 1, '', ''),
(81, '000000081', '2015-10-14 17:22:32', 1, 'VINCENZO STORACI', '6004000', '2 PAR DE OREJAS', 'LABORATORIO ANIMALARIO    ', 2, 1, 1, '', ''),
(82, '000000082', '2015-10-14 17:23:12', 1, 'VINCENZO STORACI', '6004000', 'PUERTA', 'LABORATORIO ANIMALARIO', 2, 1, 1, '', ''),
(83, '000000083', '2016-02-02 07:21:31', 1, 'VINCENZO STORACI', '6004000', 'CAMBIO DE CARTEL', ' LABORATORIO BIOMAC', 2, 1, 4, 'PRUEBA DEL SISTEMA', ''),
(84, '000000084', '2016-02-02 07:22:18', 1, 'VINCENZO STORACI', '6004000', 'CONSTRUIR MURO', 'LABORATORIO BIOMAC', 2, 1, 4, 'PRUEBA DEL SISTEMA', ''),
(85, '000000085', '2016-02-02 07:21:50', 1, 'VINCENZO STORACI', '6004000', 'OREJERAS', 'LABORATORIO BIOMAC', 2, 1, 4, 'PRUEBA DEL SISTEMA', ''),
(86, '000000086', '2015-10-14 18:04:41', 1, 'VINCENZO STORACI', '6004000', 'MANTO AL TECHO', 'LABORATORIO BIOMAC', 2, 1, 1, '', ''),
(87, '000000087', '2016-02-02 07:22:03', 1, 'VINCENZO STORACI', '6004000', 'FRISO PARED EXTERIOR', 'LABORATORIO BIOMAC', 2, 1, 4, 'PRUEBA DEL SISTEMA', ''),
(88, '000000088', '2015-10-14 18:06:30', 1, 'VINCENZO STORACI', '6004000', 'OREJAS', 'CUARTO DE REACTIVOS', 2, 1, 1, '', ''),
(89, '000000089', '2015-10-14 18:07:03', 1, 'VINCENZO STORACI', '6004000', 'HUECOS AIRES', 'CUARTO DE REACTIVOS', 2, 1, 1, '', ''),
(90, '000000090', '2016-02-02 07:20:44', 1, 'VINCENZO STORACI', '6004000', '3 CANDADOS', 'CUARTO DE REACTIVOS', 2, 1, 4, 'PRUEBA DEL SISTEMA', ''),
(91, '000000091', '2015-11-11 05:53:02', 1, 'VINCENZO STORACI', '6004000', 'CARTELES', 'CUARTO DE REACTIVOS', 2, 1, 3, 'SE REALIZÓ EL CAMBIO DE AVISOS', ''),
(92, '000000092', '2015-11-30 05:48:38', 4, 'VINCENZO STORACI', '6004000', 'EXTRACTOR', 'CUARTO DE REACTIVOS', 2, 1, 3, 'COMPLETADA. SE CAMBIó INTERNAMENTE EL EXTRACTOR, CERRANDO EL ESPACIO QUE ANTES OCUPABA.', ''),
(93, '000000093', '2016-01-21 15:08:34', 1, 'MARYLIN GIUGNI', '123456', 'LIMPIEZA DEPARTAMENTO', 'LIMPIEZA DE MANTENIMIENTO EN GENERAL PARA TODO.', 9, 4, 3, 'RESUELTA', 'BUENA'),
(94, '000000094', '2016-01-21 15:22:13', 3, 'JOSE HENRíQUEZ', '123456', 'TUBO DANADO', 'EL TUBO ESTA ROTOOOO', 9, 2, 3, 'LISTOO', 'NO ESTOY DE ACUERDO'),
(95, '000000095', '2016-01-29 16:59:20', 2, 'ANGEL LOPEZ ', '55641564', 'LIMPIEZA', 'BAñO DE CONTROL DE ESTUDIOS ...OLOR ANIMAL MUERTO', 5, 1, 3, 'ERA UNA PRUEBA', 'NO ESTOY DE ACUERDO'),
(96, '000000096', '2016-02-04 16:49:45', 3, 'MARYLIN GIUGNI', '04124303301', 'LLAVE DE LAVAMANO', 'CAMBIAR LLAVE DEL LAVAMANOS DE DIRECCIóN', 3, 1, 2, '', ''),
(97, '000000097', '2016-02-04 16:46:27', 16, 'LILIANA YANETH NIETO CAICEDO', '04265438994', 'CORTE DE SILLAS LAB 6 ', 'CORTE DE LAS PATAS DE LAS SILLAS (9)\n UBICADAS EN EL LAB 6 DEL DPTO. BIOLOGíA, (UBICAR A LA PROF. SONIA ARDITO O A LILIANA NIETO) \nTIENE MUCHO TIEMPO', 2, 1, 2, '', ''),
(98, '000000098', '2016-02-04 15:00:10', 5, 'YOJANA SEQUERA ROJAS', '315163', 'REPARACIóN FOTOCOPIADORA', 'TENGO A BIEN DIRIGIRME A USTED, A FIN DE SOLICITAR LA REPARACIóN/MANTENIMIENTO DE LAS FOTOCOPIADORAS: RICOH AFICIO 2020D Y   GESTETNER 1502.', 8, 1, 1, '', ''),
(99, '000000099', '2016-02-04 15:16:06', 1, 'YOJANA SEQUERA ROJAS', '315163', 'CUBíCULO EN REPARACIóN', 'CUBíCULO QUE ESTA EN REPARACIóN FALTA:\nLIMPIAR Y PULIR EL PISO (ANTES DE LAS INSTALACIONES)\nINSTALACIóN DE LAS PERSIANAS\nINSTALACIóN DE LOS ESCRITORIOS.', 8, 1, 1, '', ''),
(100, '000000100', '2016-02-04 16:42:41', 6, 'YOJANA SEQUERA ROJAS', '315163', 'PINTAR DEPARTAMENTO', 'PINTAR SALONES Y JARDINERÍA DEL DEPARTAMENTO', 8, 1, 2, '', ''),
(101, '000000101', '2016-02-04 16:39:58', 1, 'YOJANA SEQUERA ROJAS', '315163', 'REPARACIóN DE PUPITRES', 'REPARAR LOS PUPITRES, SILLAS Y MESAS DE LOS SALONES DEL DEPARTAMENTO.', 8, 1, 2, '', ''),
(102, '000000102', '2016-02-04 16:41:39', 1, 'YOJANA SEQUERA ROJAS', '315163', 'REPARACIóN VIDRIO SALóN', 'REPARACIóN DE VIDRIO DEL SALóN DEL DEPARTAMENTO DE MATEMáTICA. ', 8, 1, 2, '', ''),
(103, '000000103', '2016-02-04 15:31:37', 1, 'YOJANA SEQUERA ROJAS', '315163', 'QUITAR MONTE Y ESCOMBROS', 'QUITAR TODOS LOS ESCOMBROS Y MONTES SECOS QUE ESTáN ALREDEDOR DEL DEPARTAMENTO', 8, 1, 1, '', ''),
(104, '000000104', '2016-02-10 09:58:17', 4, 'VINCENZO STORACI', '04124373143', 'AIRE ACONDICIONA GENETICA', 'EL AIRE NO ESTA ENFRIANDO. FUERTE OLOR A ACEITE DEL COMPRESOR. ROTURA DE TUBERIA. ', 2, 1, 1, '', ''),
(105, '000000105', '2016-02-10 12:50:43', 4, 'JOSE HENRíQUEZ', '04265439086', 'REVISIóN AIRE LABORATORIO', 'REVISIóN DE AIRE EN EL LABORATORIO DE DOCENCIA UBICADO AL LADO DE MATEMATICA. EL AIRE ARRANCA PERO NO ENFRIA', 9, 2, 1, '', ''),
(106, '000000106', '2016-02-10 12:53:22', 1, 'JOSE HENRíQUEZ', '04265439086', 'CAMBIO PILA ENFRIADOR', 'SE NECESITA CAMBIAR LA LLAVE DE UN ENFRIADOR DE AGUA. SI NO LA TIENEN NUEVA POR FAVOR INTERCAMBIARLA CON OTRA DEL MISMO ENFRIADOR. ', 9, 2, 1, '', ''),
(107, '000000107', '2016-02-11 13:06:48', 3, 'VINCENZO STORACI', '04124373143', 'CAMBIO DE LLAVE DE PASO', 'LA LLAVE DE PASO TIENE ROTA LA MANILLA Y NO SE PUEDE ABRIR NI CERRAR', 2, 1, 1, '', ''),
(108, '000000108', '2016-02-11 13:20:22', 6, 'VINCENZO STORACI', '04124373143', 'PINTAR PUERTA ', 'PUERTA OXIDADDA DEL LABORATORIO DE GENETICA', 2, 1, 1, '', ''),
(109, '000000109', '2016-02-11 13:21:58', 1, 'VINCENZO STORACI', '04124373143', 'CERRADURA NO CIERRA', 'LA CERRADURA DE LA PUERTA DE SEGURIDAD DEL LABORATORIO DE DOCENCIA I GENETICA NO CIERRA', 2, 1, 1, '', ''),
(110, '000000110', '2016-02-11 13:23:41', 4, 'VINCENZO STORACI', '04124373143', 'AIRE ACONDICIONADO  ', 'EL AIRE ACONDICIONADO DEJO DE ENFRIAR. LOS CABLES DEL COMPRESOR HUELEN A QUEMADO', 2, 1, 1, '', ''),
(111, '000000111', '2016-02-11 13:27:57', 6, 'VINCENZO STORACI', '04124373143', 'PINTAR PUERTA', 'LA PUERTA DEL LABORATORIO DE BIOQUIMICA SE ENCUENTRA OXIDADA', 2, 1, 1, '', ''),
(112, '000000112', '2016-02-11 13:30:09', 1, 'VINCENZO STORACI', '04124373143', 'REUBICAR EL DESTILADOR', 'BAJAR EL DESTILADOR Y UBICARLO MAS ABAJO DE SU POSICION ACTUAL PARA QUE PUEDA LLEGAR LA PRESION DE AGUA', 2, 1, 1, '', ''),
(113, '000000113', '2016-02-11 13:31:37', 1, 'VINCENZO STORACI', '04124373143', 'NEVERA DAñADA', 'EL MOTOR DE LA NEVERA PASTELERA ESTA DAñADA', 2, 1, 1, '', ''),
(114, '000000114', '2016-02-11 13:34:30', 6, 'VINCENZO STORACI', '04124373143', 'PINTAR REJAS', 'PINTAR LAS REJAS OXIDADAS DEL LABORATORIO IV', 2, 1, 1, '', ''),
(115, '000000115', '2016-02-11 13:36:43', 4, 'VINCENZO STORACI', '04124373143', 'MANTENIMIENTO AIRE', 'REALIZAR MANTENIMIENTO DEL AIRE ACONDICIONADO', 2, 1, 1, '', ''),
(116, '000000116', '2016-02-11 13:37:36', 6, 'VINCENZO STORACI', '04124373143', 'PINTURA DE REJAS', 'LAS REJAS ESTAN OXIDADES Y REQUIEREN SER PINTADAS', 2, 1, 1, '', ''),
(117, '000000117', '2016-02-11 13:38:18', 6, 'VINCENZO STORACI', '04124373143', 'PINTURA DE PUERTA', 'PINTAR LA PUERTA COLOR BLANCO', 2, 1, 1, '', ''),
(118, '000000118', '2016-02-11 13:40:40', 1, 'VINCENZO STORACI', '04124373143', 'COLOCAR MANILLA', 'LA MANILLA DE LA PUERTA SE LA ROBARON Y SE REQUIERE SU SUSTITUCION', 2, 1, 1, '', ''),
(119, '000000119', '2016-02-11 13:44:17', 1, 'VINCENZO STORACI', '04124373143', 'REVISION DE NEVERA', 'LA NEVERA NO FUNCIONA REQUIERE REVISION', 2, 1, 1, '', ''),
(120, '000000120', '2016-02-11 13:45:02', 6, 'VINCENZO STORACI', '04124373143', 'PINTAR REJAS', 'LAS REJAS ESTAN OXIDADAS', 2, 1, 1, '', ''),
(121, '000000121', '2016-02-11 13:45:38', 6, 'VINCENZO STORACI', '04124373143', 'PINTAR PUERTA', 'LA PUERTA ESTA OXIDADA', 2, 1, 1, '', ''),
(122, '000000122', '2016-02-11 13:50:34', 4, 'VINCENZO STORACI', '04124373143', 'TUBERIA DE COBRE AIRE', 'SE ROBARON LA TUBERIA DE COBRE DE DOS UNIDADES', 2, 1, 1, '', ''),
(123, '000000123', '2016-02-11 14:02:30', 6, 'VINCENZO STORACI', '04124373143', 'PINTAR ESTANTES', 'PINTAR LOS ESTANTES DEL CUARTO DE REACTIVOS Y FIJARLOS A LA PARED', 2, 1, 1, '', ''),
(124, '000000124', '2016-02-11 14:04:48', 1, 'VINCENZO STORACI', '04124373143', 'FIJAR ESTANTES A LA PARED', 'FIJAR TODOS LOS ESTANTES A LA PARED', 2, 1, 1, '', ''),
(125, '000000125', '2016-02-11 14:07:25', 1, 'VINCENZO STORACI', '04124373143', 'PUERTA NO CIERRA', 'LA PUERTA DE SEGURIDAD INTERNA NO CIERRA', 2, 1, 1, '', ''),
(126, '000000126', '2016-02-11 14:11:44', 6, 'VINCENZO STORACI', '04124373143', 'PINTAR OREJAS', 'PINTAR LAS OREJAS Y PUERTAS DE LOS TRES CUARTOS DE REACTIVOS (LIQUIDOS, SOLIDOS Y DESECHOS) ', 2, 1, 1, '', ''),
(127, '000000127', '2016-02-11 14:23:50', 1, 'VINCENZO STORACI', '04124373143', 'AVISOS DE SEGURIDAD', 'COLOCAR AVISOS DE SEGURIDAD EN LOS TRES CUARTOS DE REACTIVOS. DE PRECAUCIONES E INFORMACION', 2, 1, 1, '', ''),
(128, '000000128', '2016-02-11 14:29:36', 1, 'VINCENZO STORACI', '04124373143', 'REFUERZO DE OREJAS ', 'COLOCAR DOS OREJAS ADICIONALES EN EL CUARTO DE BOMBONAS DEL LABORATORIO DE BIOTECNOLOGIA. COLOCAR PLANCHA SUPERIOR A LAS OREJAS PARA EVITAR SU CORTE', 2, 1, 1, '', ''),
(129, '000000129', '2016-02-11 14:32:20', 1, 'VINCENZO STORACI', '04124373143', 'SOLDAR PROTECTOR DE AIRE', 'SOLDAR EL PROTECTOR DE AIRE ACONDICIONADO QUE SE ENCUENTRA SOBRE EL TECHO DEL DEPOSITO DEL BIOMAC', 2, 1, 1, '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_responsable_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_responsable_orden` (
  `id_responsable` varchar(9) NOT NULL,
  `tiene_cuadrilla` enum('si','no') DEFAULT 'no',
  `id_orden_trabajo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mnt_responsable_orden`
--

INSERT INTO `mnt_responsable_orden` (`id_responsable`, `tiene_cuadrilla`, `id_orden_trabajo`) VALUES
('10266594', 'si', '000000074'),
('10455543', 'si', '000000090'),
('10455543', 'si', '000000097'),
('10455543', 'si', '000000101'),
('10455543', 'si', '000000102'),
('12092890', 'si', '000000100'),
('15494959', 'si', '000000096'),
('6484055', 'si', '000000077'),
('7560867', 'si', '000000078'),
('7560867', 'si', '000000079'),
('7560867', 'si', '000000093'),
('7560867', 'si', '000000094');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_tipo_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_tipo_orden` (
  `id_tipo` bigint(20) NOT NULL,
  `tipo_orden` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mnt_tipo_orden`
--

INSERT INTO `mnt_tipo_orden` (`id_tipo`, `tipo_orden`) VALUES
(1, 'MANTENIMIENTO GENERAL'),
(2, 'LIMPIEZA'),
(3, 'PLOMERIA'),
(4, 'AIRE ACONDICIONADO'),
(5, 'ELECTRONICA'),
(6, 'PINTURA'),
(7, 'MENSAJERIA'),
(8, 'ELECTRICIDAD'),
(9, 'PRUEBA CUADRILLA'),
(10, 'PRUEBA CUADRILLA2'),
(11, 'ACRRE'),
(12, 'Prueba4'),
(13, 'Prueba 10'),
(14, 'PRUEBA11'),
(15, 'prueba12'),
(16, 'Otras');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mnt_ubicaciones_dep`
--

CREATE TABLE IF NOT EXISTS `mnt_ubicaciones_dep` (
  `id_ubicacion` bigint(20) NOT NULL,
  `id_dependencia` bigint(20) NOT NULL,
  `oficina` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `mnt_ubicaciones_dep`
--

INSERT INTO `mnt_ubicaciones_dep` (`id_ubicacion`, `id_dependencia`, `oficina`) VALUES
(1, 1, 'N/A'),
(1, 2, 'N/A'),
(1, 3, 'N/A'),
(1, 4, 'N/A'),
(1, 5, 'N/A'),
(1, 6, 'N/A'),
(1, 7, 'N/A'),
(1, 8, 'N/A'),
(1, 9, 'N/A'),
(1, 10, 'N/A'),
(1, 11, 'N/A'),
(1, 12, 'N/A'),
(1, 13, 'N/A'),
(1, 14, 'N/A'),
(1, 15, 'N/A'),
(1, 16, 'N/A'),
(1, 17, 'N/A'),
(1, 18, 'N/A'),
(1, 19, 'N/A'),
(1, 20, 'N/A'),
(1, 21, 'N/A'),
(1, 22, 'N/A'),
(2, 9, 'LABORATORIO DE DOCENCIA II'),
(3, 9, 'CUBICULO DE PROGRAMADORES'),
(4, 9, 'EDIFICIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_asistencia`
--

CREATE TABLE IF NOT EXISTS `rhh_asistencia` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hora_entrada` time NOT NULL,
  `hora_salida` time NOT NULL,
  `fecha_inicio_semana` date NOT NULL,
  `fecha_fin_semana` date NOT NULL,
  `id_trabajador` varchar(9) NOT NULL,
  `dia` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rhh_asistencia`
--

INSERT INTO `rhh_asistencia` (`ID`, `TIME`, `hora_entrada`, `hora_salida`, `fecha_inicio_semana`, `fecha_fin_semana`, `id_trabajador`, `dia`) VALUES
(25, '2016-05-02 15:14:20', '11:14:20', '14:08:03', '2016-05-02', '2016-05-08', '19919468', '2016-05-02'),
(26, '2016-05-02 18:32:03', '14:32:03', '14:41:10', '2016-05-02', '2016-05-08', '19919468', '2016-05-02'),
(27, '2016-05-02 19:02:29', '15:02:29', '00:00:00', '2016-05-02', '2016-05-08', '19919468', '2016-05-02'),
(28, '2016-05-03 10:25:33', '06:25:33', '06:34:18', '2016-05-02', '2016-05-08', '19919468', '2016-05-03'),
(29, '2016-05-03 23:56:08', '19:26:08', '00:00:00', '2016-05-02', '2016-05-08', '19919468', '2016-05-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_ausentismo_permiso`
--

CREATE TABLE IF NOT EXISTS `rhh_ausentismo_permiso` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_trabajador` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estatus` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `fecha_solicitud` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_ausentismo_reposo`
--

CREATE TABLE IF NOT EXISTS `rhh_ausentismo_reposo` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_trabajador` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_final` date NOT NULL,
  `estatus` varchar(255) NOT NULL COMMENT 'Es estatus de un ausentismo está relacionado con la aprobación que da el encargado. Ej. “Aprobado, Negado.”',
  `fecha_solicitud` date NOT NULL COMMENT ' Fecha en la que el trabajador solicita el ausentismo en la base de datos. Se guarda automáticamente.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_aval`
--

CREATE TABLE IF NOT EXISTS `rhh_aval` (
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

CREATE TABLE IF NOT EXISTS `rhh_cargo` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(225) NOT NULL,
  `tipo` varchar(225) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='Correspondencia entre jornada y cargo, para verificar en la asistencia';

--
-- Volcado de datos para la tabla `rhh_cargo`
--

INSERT INTO `rhh_cargo` (`ID`, `TIME`, `nombre`, `tipo`, `descripcion`) VALUES
(1, '2016-05-02 16:30:10', 'Administrativo', 'Tipo 1', 'Ninguna'),
(2, '2016-05-02 16:45:36', 'Administrativo', 'Tipo 2', 'Ninguna'),
(3, '2016-05-02 16:48:05', 'Obrero', 'Obrero', 'Ninguna'),
(4, '2016-05-02 16:48:25', 'Docente', 'Tiempo Completo', 'Ninguna'),
(5, '2016-05-02 16:49:13', 'Docente', 'Tiempo Medio', 'Ninguna'),
(7, '2016-05-02 19:04:50', 'blah', 'bloh', 'serverTime.getHours()+'':''+serverTime.getSeconds()+'':''+serverTime.getSeconds();');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_configuracion_asistencia`
--

CREATE TABLE IF NOT EXISTS `rhh_configuracion_asistencia` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `minimo_horas_ausentes_sem` int(11) NOT NULL COMMENT 'Mínimo de hora semanales que puede tener de retraso el trabajador. Parámetro de configuración de la aplicación.  Parte de su uso recae en rhh_asistencia.fecha_inicio_semana y rhh_asistencia.fecha_fin_semana'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rhh_configuracion_asistencia`
--

INSERT INTO `rhh_configuracion_asistencia` (`ID`, `TIME`, `minimo_horas_ausentes_sem`) VALUES
(13, '2016-03-28 17:42:14', 47);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_configuracion_ausentismo`
--

CREATE TABLE IF NOT EXISTS `rhh_configuracion_ausentismo` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `minimo_dias_permiso` int(11) NOT NULL,
  `maximo_dias_permiso` int(11) NOT NULL,
  `cantidad_maxima_mensual` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rhh_configuracion_ausentismo`
--

INSERT INTO `rhh_configuracion_ausentismo` (`ID`, `TIME`, `tipo`, `nombre`, `minimo_dias_permiso`, `maximo_dias_permiso`, `cantidad_maxima_mensual`) VALUES
(28, '2016-04-13 19:28:19', 'PERMISO', 'Enfermedad', 2, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_expediente_trabajador`
--

CREATE TABLE IF NOT EXISTS `rhh_expediente_trabajador` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_creado` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_jornada_laboral`
--

CREATE TABLE IF NOT EXISTS `rhh_jornada_laboral` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(255) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `tolerancia` int(11) NOT NULL COMMENT 'después de la hora de inicio en el cual se considera como la cantidad de tiempo de retardo máximo que puede tener el trabajador sin que se tome con una falta',
  `tipo` varchar(255) NOT NULL,
  `cantidad_horas_descanso` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rhh_jornada_laboral`
--

INSERT INTO `rhh_jornada_laboral` (`ID`, `TIME`, `nombre`, `hora_inicio`, `hora_fin`, `tolerancia`, `tipo`, `cantidad_horas_descanso`, `id_cargo`) VALUES
(3, '2016-05-02 17:33:52', '', '07:00:00', '15:00:00', 1, 'diurno', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_nota`
--

CREATE TABLE IF NOT EXISTS `rhh_nota` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cuerpo_nota` text NOT NULL,
  `id_asistencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_periodo_no_laboral`
--

CREATE TABLE IF NOT EXISTS `rhh_periodo_no_laboral` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rhh_periodo_no_laboral`
--

INSERT INTO `rhh_periodo_no_laboral` (`ID`, `TIME`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_fin`) VALUES
(1, '2016-04-25 19:00:16', 'Día de las Madres', 'Es el día en que celebras tu propia existencia.', '2016-05-08', '2016-05-08'),
(9, '2016-04-26 13:47:08', 'Día de Vampire Weekend', 'Hoy es el día de rendir tributo a la banda indie mas mainstream del final de la década de los 2000''s', '2016-04-26', '2016-04-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rhh_trabajador_aprueba_ausentismo`
--

CREATE TABLE IF NOT EXISTS `rhh_trabajador_aprueba_ausentismo` (
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

CREATE TABLE IF NOT EXISTS `rhh_trabajador_cargo` (
  `ID` int(11) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_trabajador` int(11) NOT NULL,
  `id_cargo` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Como no puedo modificar la tabla dec_usuario he creado mi propia tabla para manejar las jornadas y asociarlas a los cargos que estarán asociados a los usuarios.';

--
-- Volcado de datos para la tabla `rhh_trabajador_cargo`
--

INSERT INTO `rhh_trabajador_cargo` (`ID`, `TIME`, `id_trabajador`, `id_cargo`) VALUES
(1, '2016-05-04 00:53:10', 19919960, 1),
(2, '2016-05-04 00:53:26', 19919468, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `air_cntrl_mp_equipo`
--
ALTER TABLE `air_cntrl_mp_equipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_inv_equipo` (`id_inv_equipo`),
  ADD UNIQUE KEY `id_dec_dependencia` (`id_dec_dependencia`),
  ADD UNIQUE KEY `id_mnt_ubicaciones_dep` (`id_mnt_ubicaciones_dep`),
  ADD UNIQUE KEY `id_air_tipo_eq` (`id_air_tipo_eq`);

--
-- Indices de la tabla `air_eq_item`
--
ALTER TABLE `air_eq_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_tipo_eq_2` (`id_tipo_eq`),
  ADD UNIQUE KEY `id_item_mnt_2` (`id_item_mnt`),
  ADD KEY `id_tipo_eq` (`id_tipo_eq`),
  ADD KEY `id_item_mnt` (`id_item_mnt`);

--
-- Indices de la tabla `air_items_mant`
--
ALTER TABLE `air_items_mant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_air_eq_item` (`id_air_eq_item`),
  ADD UNIQUE KEY `id_air_mant_item` (`id_air_mant_item`);

--
-- Indices de la tabla `air_mant_equipo`
--
ALTER TABLE `air_mant_equipo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_mnt_orden` (`id_mnt_orden`),
  ADD UNIQUE KEY `id_equipo` (`id_equipo`);

--
-- Indices de la tabla `air_mant_item`
--
ALTER TABLE `air_mant_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cod` (`cod`);

--
-- Indices de la tabla `air_tipo_eq`
--
ALTER TABLE `air_tipo_eq`
  ADD PRIMARY KEY (`cod`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `cod` (`cod`);

--
-- Indices de la tabla `alm_aprueba`
--
ALTER TABLE `alm_aprueba`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`,`nr_solicitud`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `nr_solicitud` (`nr_solicitud`);

--
-- Indices de la tabla `alm_articulo`
--
ALTER TABLE `alm_articulo`
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `cod_articulo` (`cod_articulo`);

--
-- Indices de la tabla `alm_carrito`
--
ALTER TABLE `alm_carrito`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `id_carrito` (`id_carrito`);

--
-- Indices de la tabla `alm_car_contiene`
--
ALTER TABLE `alm_car_contiene`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `id_articulo` (`id_articulo`,`cant_solicitada`),
  ADD KEY `id_carrito` (`id_carrito`);

--
-- Indices de la tabla `alm_categoria`
--
ALTER TABLE `alm_categoria`
  ADD PRIMARY KEY (`cod_categoria`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indices de la tabla `alm_consulta`
--
ALTER TABLE `alm_consulta`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `cod_categoria` (`cod_categoria`);

--
-- Indices de la tabla `alm_contiene`
--
ALTER TABLE `alm_contiene`
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `cont_histo_solicitud` (`id_articulo`,`nr_solicitud`,`NRS`),
  ADD KEY `NRS` (`NRS`),
  ADD KEY `nr_solicitud` (`nr_solicitud`);

--
-- Indices de la tabla `alm_genera`
--
ALTER TABLE `alm_genera`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `genera` (`id_usuario`,`nr_solicitud`),
  ADD KEY `nr_solicitud` (`nr_solicitud`);

--
-- Indices de la tabla `alm_genera_hist_a`
--
ALTER TABLE `alm_genera_hist_a`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `historial_articulo` (`id_articulo`,`id_historial_a`),
  ADD KEY `id_historial_a` (`id_historial_a`);

--
-- Indices de la tabla `alm_guarda`
--
ALTER TABLE `alm_guarda`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `alm_historial_a`
--
ALTER TABLE `alm_historial_a`
  ADD PRIMARY KEY (`id_historial_a`,`nuevo`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indices de la tabla `alm_historial_s`
--
ALTER TABLE `alm_historial_s`
  ADD PRIMARY KEY (`NRS`),
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indices de la tabla `alm_pertenece`
--
ALTER TABLE `alm_pertenece`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `cod_articulo` (`cod_articulo`),
  ADD UNIQUE KEY `cod_cartegoria` (`cod_cartegoria`);

--
-- Indices de la tabla `alm_retira`
--
ALTER TABLE `alm_retira`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD UNIQUE KEY `traslado_articulo` (`nr_solicitud`,`cod_articulo`,`id_usuario`),
  ADD KEY `cod_articulo` (`cod_articulo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `alm_solicitud`
--
ALTER TABLE `alm_solicitud`
  ADD PRIMARY KEY (`nr_solicitud`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `dec_dependencia`
--
ALTER TABLE `dec_dependencia`
  ADD PRIMARY KEY (`id_dependencia`);

--
-- Indices de la tabla `dec_permiso`
--
ALTER TABLE `dec_permiso`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `dec_tipo_equipo`
--
ALTER TABLE `dec_tipo_equipo`
  ADD PRIMARY KEY (`cod`);

--
-- Indices de la tabla `dec_usuario`
--
ALTER TABLE `dec_usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `ID` (`ID`),
  ADD KEY `id_dependencia` (`id_dependencia`);

--
-- Indices de la tabla `inv_equipos`
--
ALTER TABLE `inv_equipos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tipo_eq` (`tipo_eq`);

--
-- Indices de la tabla `mnt_asigna_cuadrilla`
--
ALTER TABLE `mnt_asigna_cuadrilla`
  ADD PRIMARY KEY (`id_usuario`,`id_cuadrilla`,`id_ordenes`),
  ADD KEY `id_trabajador` (`id_usuario`),
  ADD KEY `id_cuadrilla` (`id_cuadrilla`),
  ADD KEY `id_orden_trabajo` (`id_ordenes`);

--
-- Indices de la tabla `mnt_asigna_material`
--
ALTER TABLE `mnt_asigna_material`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD UNIQUE KEY `id_orden_trabajo` (`id_orden_trabajo`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `mnt_ayudante_orden`
--
ALTER TABLE `mnt_ayudante_orden`
  ADD PRIMARY KEY (`id_trabajador`,`id_orden_trabajo`),
  ADD KEY `id_orden` (`id_orden_trabajo`),
  ADD KEY `id_usuario` (`id_trabajador`);

--
-- Indices de la tabla `mnt_cuadrilla`
--
ALTER TABLE `mnt_cuadrilla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_trabajador_responsable`);

--
-- Indices de la tabla `mnt_estatus`
--
ALTER TABLE `mnt_estatus`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `mnt_estatus_orden`
--
ALTER TABLE `mnt_estatus_orden`
  ADD UNIQUE KEY `ID_UNICO_ESTADO` (`id_estado`,`id_orden_trabajo`,`id_usuario`,`fecha_p`),
  ADD KEY `id_orden_trabajo` (`id_orden_trabajo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_estado2` (`id_estado`);

--
-- Indices de la tabla `mnt_miembros_cuadrilla`
--
ALTER TABLE `mnt_miembros_cuadrilla`
  ADD KEY `id_usuario` (`id_trabajador`),
  ADD KEY `id_cuadrilla` (`id_cuadrilla`);

--
-- Indices de la tabla `mnt_observacion_orden`
--
ALTER TABLE `mnt_observacion_orden`
  ADD PRIMARY KEY (`id_observacion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_orden_trabajo` (`id_orden_trabajo`),
  ADD KEY `id_observacion` (`id_observacion`);

--
-- Indices de la tabla `mnt_orden_trabajo`
--
ALTER TABLE `mnt_orden_trabajo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_orden` (`id_orden`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `dependencia` (`dependencia`),
  ADD KEY `ubicacion` (`ubicacion`),
  ADD KEY `estatus` (`estatus`);

--
-- Indices de la tabla `mnt_responsable_orden`
--
ALTER TABLE `mnt_responsable_orden`
  ADD PRIMARY KEY (`id_responsable`,`id_orden_trabajo`),
  ADD KEY `id_orden` (`id_orden_trabajo`),
  ADD KEY `id_usuario` (`id_responsable`);

--
-- Indices de la tabla `mnt_tipo_orden`
--
ALTER TABLE `mnt_tipo_orden`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `mnt_ubicaciones_dep`
--
ALTER TABLE `mnt_ubicaciones_dep`
  ADD PRIMARY KEY (`id_ubicacion`,`id_dependencia`),
  ADD KEY `id_dependencia` (`id_dependencia`);

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
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `rhh_ausentismo_reposo`
--
ALTER TABLE `rhh_ausentismo_reposo`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `id_trabajador` (`id_trabajador`);

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
  ADD UNIQUE KEY `id_cargo` (`id_cargo`);

--
-- Indices de la tabla `rhh_nota`
--
ALTER TABLE `rhh_nota`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `id_asistencia` (`id_asistencia`);

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
  ADD KEY `id_cargo` (`id_cargo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `air_cntrl_mp_equipo`
--
ALTER TABLE `air_cntrl_mp_equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `air_eq_item`
--
ALTER TABLE `air_eq_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `air_mant_item`
--
ALTER TABLE `air_mant_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `air_tipo_eq`
--
ALTER TABLE `air_tipo_eq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_aprueba`
--
ALTER TABLE `alm_aprueba`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_articulo`
--
ALTER TABLE `alm_articulo`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_carrito`
--
ALTER TABLE `alm_carrito`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_car_contiene`
--
ALTER TABLE `alm_car_contiene`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_categoria`
--
ALTER TABLE `alm_categoria`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_consulta`
--
ALTER TABLE `alm_consulta`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_contiene`
--
ALTER TABLE `alm_contiene`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_genera`
--
ALTER TABLE `alm_genera`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_genera_hist_a`
--
ALTER TABLE `alm_genera_hist_a`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_guarda`
--
ALTER TABLE `alm_guarda`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_historial_a`
--
ALTER TABLE `alm_historial_a`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_historial_s`
--
ALTER TABLE `alm_historial_s`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_pertenece`
--
ALTER TABLE `alm_pertenece`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_retira`
--
ALTER TABLE `alm_retira`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `alm_solicitud`
--
ALTER TABLE `alm_solicitud`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `dec_dependencia`
--
ALTER TABLE `dec_dependencia`
  MODIFY `id_dependencia` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT de la tabla `dec_permiso`
--
ALTER TABLE `dec_permiso`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `dec_usuario`
--
ALTER TABLE `dec_usuario`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=310;
--
-- AUTO_INCREMENT de la tabla `inv_equipos`
--
ALTER TABLE `inv_equipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `mnt_asigna_material`
--
ALTER TABLE `mnt_asigna_material`
  MODIFY `id_orden_trabajo` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `mnt_cuadrilla`
--
ALTER TABLE `mnt_cuadrilla`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT de la tabla `mnt_estatus`
--
ALTER TABLE `mnt_estatus`
  MODIFY `id_estado` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `mnt_observacion_orden`
--
ALTER TABLE `mnt_observacion_orden`
  MODIFY `id_observacion` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=130;
--
-- AUTO_INCREMENT de la tabla `mnt_orden_trabajo`
--
ALTER TABLE `mnt_orden_trabajo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=130;
--
-- AUTO_INCREMENT de la tabla `mnt_tipo_orden`
--
ALTER TABLE `mnt_tipo_orden`
  MODIFY `id_tipo` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `mnt_ubicaciones_dep`
--
ALTER TABLE `mnt_ubicaciones_dep`
  MODIFY `id_ubicacion` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `rhh_asistencia`
--
ALTER TABLE `rhh_asistencia`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT de la tabla `rhh_ausentismo_permiso`
--
ALTER TABLE `rhh_ausentismo_permiso`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rhh_ausentismo_reposo`
--
ALTER TABLE `rhh_ausentismo_reposo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rhh_aval`
--
ALTER TABLE `rhh_aval`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rhh_cargo`
--
ALTER TABLE `rhh_cargo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `rhh_configuracion_asistencia`
--
ALTER TABLE `rhh_configuracion_asistencia`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `rhh_configuracion_ausentismo`
--
ALTER TABLE `rhh_configuracion_ausentismo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT de la tabla `rhh_expediente_trabajador`
--
ALTER TABLE `rhh_expediente_trabajador`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rhh_jornada_laboral`
--
ALTER TABLE `rhh_jornada_laboral`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `rhh_nota`
--
ALTER TABLE `rhh_nota`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rhh_periodo_no_laboral`
--
ALTER TABLE `rhh_periodo_no_laboral`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `rhh_trabajador_aprueba_ausentismo`
--
ALTER TABLE `rhh_trabajador_aprueba_ausentismo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `rhh_trabajador_cargo`
--
ALTER TABLE `rhh_trabajador_cargo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
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
-- Filtros para la tabla `alm_car_contiene`
--
ALTER TABLE `alm_car_contiene`
  ADD CONSTRAINT `alm_car_contiene_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `alm_carrito` (`id_carrito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contiene_articulo` FOREIGN KEY (`id_articulo`) REFERENCES `alm_articulo` (`ID`);

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
-- Filtros para la tabla `dec_permiso`
--
ALTER TABLE `dec_permiso`
  ADD CONSTRAINT `dec_permiso_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `dec_usuario`
--
ALTER TABLE `dec_usuario`
  ADD CONSTRAINT `dec_usuario_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dec_dependencia` (`id_dependencia`);

--
-- Filtros para la tabla `inv_equipos`
--
ALTER TABLE `inv_equipos`
  ADD CONSTRAINT `inv_equipos_ibfk_1` FOREIGN KEY (`tipo_eq`) REFERENCES `dec_tipo_equipo` (`cod`);

--
-- Filtros para la tabla `mnt_asigna_cuadrilla`
--
ALTER TABLE `mnt_asigna_cuadrilla`
  ADD CONSTRAINT `ID_ASIGNA_CUADRILLA` FOREIGN KEY (`id_cuadrilla`) REFERENCES `mnt_cuadrilla` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO6` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ordenes` FOREIGN KEY (`id_ordenes`) REFERENCES `mnt_orden_trabajo` (`id_orden`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `mnt_ayudante_orden_ibfk_1` FOREIGN KEY (`id_trabajador`) REFERENCES `dec_usuario` (`id_usuario`),
  ADD CONSTRAINT `mnt_ayudante_orden_ibfk_2` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id_orden`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `ordenes_2` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id_orden`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mnt_ubicaciones_dep`
--
ALTER TABLE `mnt_ubicaciones_dep`
  ADD CONSTRAINT `mnt_ubicaciones_dep_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dec_dependencia` (`id_dependencia`) ON DELETE CASCADE ON UPDATE CASCADE;

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
-- Filtros para la tabla `rhh_nota`
--
ALTER TABLE `rhh_nota`
  ADD CONSTRAINT `rhh_nota_ibfk_1` FOREIGN KEY (`id_asistencia`) REFERENCES `rhh_asistencia` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
