-- Estructura de tabla para la tabla `dec_dependencia`
--

CREATE TABLE IF NOT EXISTS `dec_dependencia` (
  `id_dependencia` bigint(20) NOT NULL,
  `dependen` text COLLATE utf8_spanish_ci NOT NULL
   PRIMARY KEY (`id_dependencia`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci

-- --------------------------------------------------------


