-- Table structure for table `mnt_estado_orden`
--

CREATE TABLE IF NOT EXISTS `mnt_estado_orden` (
  `id_estado` bigint(20) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL,
  `id_usuario` varchar(9) CHARACTER SET utf8 NOT NULL,
  `fecha_p` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `ID_UNICO_ESTADO` (`id_estado`,`id_orden_trabajo`,`id_usuario`),
  KEY `id_orden_trabajo` (`id_orden_trabajo`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_estado2` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------