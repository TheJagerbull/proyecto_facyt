-- Table structure for table `mnt_asigna_cuadrilla`
--

CREATE TABLE IF NOT EXISTS `mnt_asigna_cuadrilla` (
  `id_usuario` varchar(9) CHARACTER SET utf8 NOT NULL,
  `id_cuadrilla` bigint(20) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_cuadrilla`,`id_orden_trabajo`),
  KEY `id_trabajador` (`id_usuario`),
  KEY `id_cuadrilla` (`id_cuadrilla`),
  KEY `id_orden_trabajo` (`id_orden_trabajo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------