-- Table structure for table `mnt_orden_trabajo`
--

CREATE TABLE IF NOT EXISTS `mnt_orden_trabajo` (
  `id_orden` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_tipo` bigint(20) NOT NULL,
  `nombre_contacto` varchar(255) NOT NULL,
  `telefono_contacto` int(11) NOT NULL,
  `observacion` varchar(40) NOT NULL,
  `descripcion_general` varchar(60) NOT NULL,
  `dependencia` bigint(20) NOT NULL,
  `ubicacion` bigint(20) NOT NULL,
  PRIMARY KEY (`id_orden`),
  KEY `id_tipo` (`id_tipo`),
  KEY `dependencia` (`dependencia`),
  KEY `ubicacion` (`ubicacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------