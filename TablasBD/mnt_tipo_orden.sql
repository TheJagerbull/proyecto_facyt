-- Table structure for table `mnt_tipo_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_tipo_orden` (
  `id_tipo` bigint(20) NOT NULL,
  `descripcion` varchar(25) NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mnt_tipo_orden`
--

INSERT INTO `mnt_tipo_orden` (`id_tipo`, `descripcion`) VALUES
(1, 'plomeria'),
(2, 'obras civiles'),
(3, 'electricidad'),
(4, 'areas verdes'),
(5, 'mantenimiento general'),
(6, 'obras civiles'),
(7, 'electricidad'),
(8, 'areas verdes'),
(9, 'mantenimiento general');

-- --------------------------------------------------------