-- Table structure for table `mnt_miembros_cuadrilla`
--

CREATE TABLE IF NOT EXISTS `mnt_miembros_cuadrilla` (
  `id_cuadrilla` bigint(20) NOT NULL,
  `id_usuario` varchar(9) NOT NULL,
  KEY `id_usuario` (`id_usuario`),
  KEY `id_cuadrilla` (`id_cuadrilla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
