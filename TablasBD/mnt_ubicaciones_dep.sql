-- Table structure for table `mnt_ubicaciones_dep`
--

CREATE TABLE IF NOT EXISTS `mnt_ubicaciones_dep` (
  `id_ubicacion` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_dependencia` bigint(20) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_ubicacion`),
  UNIQUE KEY `UBICA_DEPE` (`id_ubicacion`,`id_dependencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- --------------------------------------------------------