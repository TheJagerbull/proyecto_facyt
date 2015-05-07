-- Table structure for table `mnt_observacion_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_observacion_orden` (
  `id_usuario` varchar(9) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL,
  `observacion` varchar(40) NOT NULL,
  KEY `id_usuario` (`id_usuario`),
  KEY `id_orden_trabajo` (`id_orden_trabajo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------