-- Table structure for table `mnt_ayudante_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_ayudante_orden` (
  `id_usuario` varchar(9) NOT NULL,
  `id_trabajador` varchar(9) NOT NULL,
  `id_orden` bigint(20) NOT NULL,
  PRIMARY KEY (`id_usuario`,`id_trabajador`,`id_orden`),
  KEY `id_trabajador` (`id_trabajador`),
  KEY `id_orden` (`id_orden`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------