--
-- Tablas de Almacen, Inventario y Solicitudes de almacen
--
-- ---ENTIDADES----
CREATE TABLE IF NOT EXISTS `alm_historial_s` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nr_solicitud` varchar(10) NOT NULL,
  `fecha_ej` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `usuario_ej` varchar(9) NOT NULL,
  `status_ej` enum('carrito','en_proceso','aprobado','enviado','completado', 'cancelado', 'anulado', 'cerrado') NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `historial` (`nr_solicitud`, `status_ej`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `alm_articulo` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_articulo` varchar(10) CHARACTER SET utf8 NOT NULL,
  `unidad` varchar(9) CHARACTER SET utf8 NOT NULL,
  `descripcion` text CHARACTER SET utf8 NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `imagen` text CHARACTER SET utf8,
  `usados` int(11) DEFAULT '0',
  `nuevos` int(11) DEFAULT '0',
  `reserv` int(11) NOT NULL DEFAULT '0',
  `peso_kg` int(11) DEFAULT '0',
  `dimension_cm` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `nivel_reab` int(11) DEFAULT '0',
  `stock_min` int(11) DEFAULT '0',
  `stock_max` int(11) DEFAULT '0',
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `cod_articulo` (`cod_articulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `alm_solicitud` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nr_solicitud` varchar(9) NOT NULL,
  `status` enum('carrito','en_proceso','aprobado','enviado','completado', 'cancelado', 'anulado', 'cerrado') NOT NULL,
  `observacion` text,
  `fecha_gen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_comp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`nr_solicitud`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `alm_categoria` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_categoria` varchar(9) NOT NULL,
  `descripcion` text,
  `nombre` text NOT NULL,
  PRIMARY KEY (`cod_categoria`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `alm_historial_a` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_historial_a` varchar(15) NOT NULL,
  `entrada` int(11) DEFAULT NULL,
  `salida` int(11) DEFAULT NULL,
  `nuevo` tinyint(1) NOT NULL,
  `observacion` text,
  `por_usuario` varchar(9) NOT NULL,
  PRIMARY KEY (`id_historial_a`,`nuevo`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- ---RELACIONES----

CREATE TABLE IF NOT EXISTS `alm_efectua` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `procesa` (`id_usuario`,`nr_solicitud`),
  UNIQUE KEY `ID` (`ID`),
  KEY `nr_solicitud` (`nr_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `alm_art_en_solicitud` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_articulo` bigint(20) NOT NULL,
  `id_usuario` varchar(9) DEFAULT NULL,
  `nr_solicitud` varchar(9) NOT NULL,
  `cant_solicitada` int(11) NOT NULL,
  `cant_aprobada` int(11) DEFAULT NULL,
  `cant_usados` int(11) DEFAULT '0',
  `cant_nuevos` int(11) DEFAULT '0',
  `estado_articulo` enum('activo', 'anulado') NOT NULL DEFAULT 'activo',
  `motivo` text CHARACTER SET utf8 DEFAULT NULL,
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `cont_art_solicitud` (`id_articulo`,`nr_solicitud`),
  KEY `nr_solicitud` (`nr_solicitud`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `alm_consulta` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `cod_categoria` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `id_usuario` (`id_usuario`),
  KEY `cod_categoria` (`cod_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `alm_genera_hist_a` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_articulo` varchar(9) NOT NULL,
  `id_historial_a` varchar(15) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `historial_articulo` (`id_articulo`,`id_historial_a`),
  KEY `id_historial_a` (`id_historial_a`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
CREATE TABLE IF NOT EXISTS `alm_pertenece` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_categoria` varchar(9) NOT NULL,
  `cod_articulo` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `cod_articulo` (`cod_articulo`),
  UNIQUE KEY `cod_categoria` (`cod_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- --------------------postulado para remover de la BD--------------------------------
-- CREATE TABLE IF NOT EXISTS `alm_genera` (
--   `ID` bigint(20) NOT NULL AUTO_INCREMENT,
--   `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
--   `id_usuario` varchar(9) NOT NULL,
--   `nr_solicitud` varchar(9) NOT NULL,
--   PRIMARY KEY (`ID`),
--   UNIQUE KEY `genera` (`id_usuario`,`nr_solicitud`),
--   KEY `nr_solicitud` (`nr_solicitud`)
-- ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- CREATE TABLE IF NOT EXISTS `alm_retira` (
--   `ID` bigint(20) NOT NULL AUTO_INCREMENT,
--   `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
--   `nr_solicitud` varchar(9) NOT NULL,
--   `cod_articulo` varchar(9) NOT NULL,
--   `id_usuario` varchar(9) NOT NULL,
--   PRIMARY KEY (`ID`),
--   UNIQUE KEY `ID` (`ID`),
--   UNIQUE KEY `traslado_articulo` (`nr_solicitud`,`cod_articulo`,`id_usuario`),
--   KEY `cod_articulo` (`cod_articulo`),
--   KEY `id_usuario` (`id_usuario`)
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- CREATE TABLE IF NOT EXISTS `alm_edita` (
--   `ID` bigint(20) NOT NULL AUTO_INCREMENT,
--   `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
--   `id_usuario` varchar(9) NOT NULL,
--   `id_estado_articulo` varchar(19) NOT NULL,
--   PRIMARY KEY (`ID`),
--   UNIQUE KEY `edita` (`id_usuario`,`nr_solicitud`),
--   KEY `nr_solicitud` (`nr_solicitud`)
-- ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- CREATE TABLE IF NOT EXISTS `alm_estado_articulo` (
--   `ID` bigint(20) NOT NULL AUTO_INCREMENT,
--   `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
--   `id_estado_articulo` varchar(19) NOT NULL,
--   `estado_articulo` enum('activo', 'anulado') NOT NULL,
--   `motivo` text CHARACTER SET utf8 NOT NULL,
--   PRIMARY KEY (`ID`),
--   UNIQUE KEY `edita` (`id_usuario`,`id_estado_articulo`),
--   KEY `nr_solicitud` (`nr_solicitud`)
-- ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
-- -------------------^postulado para remover de la BD^-------------------------------

--
-- Constraints for table `alm_efectua`
--
ALTER TABLE `alm_efectua`
  ADD CONSTRAINT `alm_efectua_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_efectua_ibfk_2` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_consulta`
--
ALTER TABLE `alm_consulta`
  ADD CONSTRAINT `alm_consulta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_consulta_ibfk_2` FOREIGN KEY (`cod_categoria`) REFERENCES `alm_categoria` (`cod_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_art_en_solicitud`
--
ALTER TABLE `alm_art_en_solicitud`
  ADD CONSTRAINT `alm_art_en_solicitud_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_art_en_solicitud_ibfk_2` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_art_en_solicitud_ibfk_4` FOREIGN KEY (`id_articulo`) REFERENCES `alm_articulo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_genera_hist_a`
--
ALTER TABLE `alm_genera_hist_a`
  ADD CONSTRAINT `alm_genera_hist_a_ibfk_1` FOREIGN KEY (`id_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_genera_hist_a_ibfk_2` FOREIGN KEY (`id_historial_a`) REFERENCES `alm_historial_a` (`id_historial_a`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_pertenece`
--
ALTER TABLE `alm_pertenece`
  ADD CONSTRAINT `alm_pertenece_ibfk_1` FOREIGN KEY (`cod_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_pertenece_ibfk_2` FOREIGN KEY (`cod_categoria`) REFERENCES `alm_categoria` (`cod_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;