-- Table structure for table `mnt_asigna_material`
--

CREATE TABLE IF NOT EXISTS `mnt_asigna_material` (
  `id_solicitud` bigint(20) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL,
  `id_usuario` varchar(9) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_solicitud`),
  UNIQUE KEY `id_orden_trabajo` (`id_orden_trabajo`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------