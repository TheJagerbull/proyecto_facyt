-- Table structure for table `mnt_cuadrilla`
--

CREATE TABLE IF NOT EXISTS `mnt_cuadrilla` (
  `id_cuadrilla` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_usuario_responsable` varchar(9) NOT NULL,
  `descripcion` varchar(30) NOT NULL,
  PRIMARY KEY (`id_cuadrilla`),
  KEY `id_usuario` (`id_usuario_responsable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------