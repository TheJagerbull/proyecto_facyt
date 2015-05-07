-- Table structure for table `mnt_genera_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_genera_orden` (
  `id_orden` bigint(20) NOT NULL,
  `id_usuario` varchar(9) NOT NULL,
  `estado` bigint(20) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `ID_ORDEN_GENERA` (`id_orden`,`id_usuario`,`estado`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_orden` (`id_orden`),
  KEY `estado` (`estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------