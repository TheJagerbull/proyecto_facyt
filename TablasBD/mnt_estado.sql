-- Table structure for table `mnt_estado`
--

CREATE TABLE IF NOT EXISTS `mnt_estado` (
  `id_estado` bigint(20) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(30) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `mnt_estado`
--

INSERT INTO `mnt_estado` (`id_estado`, `descripcion`) VALUES
(1, 'abierta'),
(2, 'en proceso'),
(5, 'cerrada'),
(6, 'anulada'),
(7, 'pendiente_por_material');

-- --------------------------------------------------------