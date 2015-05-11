CREATE TABLE IF NOT EXISTS `dec_usuario` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `password` text NOT NULL,
  `nombre` varchar(63) NOT NULL,
  `apellido` varchar(63) NOT NULL,
  `cargo` varchar(25) NOT NULL,
  `email` text,
  `telefono` varchar(25) NOT NULL,
  `dependencia` varchar(25) NOT NULL,
  `tipo` enum('docente','administrativo','obrero') NOT NULL,
  `observacion` text,
  `sys_rol` enum('autoridad','asist_autoridad','jefe_alm','director_dep','asistente_dep','ayudante_alm') NOT NULL,
  `status` enum('activo','inactivo') NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;