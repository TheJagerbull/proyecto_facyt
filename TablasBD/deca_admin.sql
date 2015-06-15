--
-- Tablas de Almacen, Inventario y Solicitudes de almacen
--
CREATE TABLE IF NOT EXISTS `alm_aprueba` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `id_usuario` (`id_usuario`,`nr_solicitud`),
  UNIQUE KEY `ID` (`ID`),
  KEY `nr_solicitud` (`nr_solicitud`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `alm_articulo` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_articulo` varchar(10) CHARACTER SET utf8 NOT NULL,
  `unidad` varchar(9) CHARACTER SET utf8 NOT NULL,
  `descripcion` text CHARACTER SET utf8 NOT NULL,
  `ACTIVE` tinyint(1) NOT NULL,
  `nuevo` tinyint(1) NOT NULL,
  `imagen` text CHARACTER SET utf8,
  `disp` int(11) NOT NULL,
  `reserv` int(11) NOT NULL,
  `peso_kg` int(11) DEFAULT NULL,
  `dimension_cm` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  `nivel_reab` int(11) DEFAULT NULL,
  `stock_min` int(11) DEFAULT NULL,
  `stock_max` int(11) DEFAULT NULL,
  UNIQUE KEY `ID` (`ID`),
  KEY `cod_articulo` (`cod_articulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=5001 ;

CREATE TABLE IF NOT EXISTS `alm_categoria` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_categoria` varchar(9) NOT NULL,
  `descripcion` text,
  `nombre` text NOT NULL,
  PRIMARY KEY (`cod_categoria`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

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

CREATE TABLE IF NOT EXISTS `alm_contiene` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_articulo` bigint(20) NOT NULL,
  `NRS` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL,
  `cant_solicitada` int(11) NOT NULL,
  `cant_aprobada` int(11) DEFAULT NULL,
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `cont_histo_solicitud` (`id_articulo`,`nr_solicitud`,`NRS`),
  KEY `NRS` (`NRS`),
  KEY `nr_solicitud` (`nr_solicitud`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

CREATE TABLE IF NOT EXISTS `alm_genera` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `genera` (`id_usuario`,`nr_solicitud`),
  KEY `nr_solicitud` (`nr_solicitud`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

CREATE TABLE IF NOT EXISTS `alm_genera_hist_a` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_articulo` varchar(9) NOT NULL,
  `id_historial_a` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `id_articulo` (`id_articulo`),
  UNIQUE KEY `historial_articulo` (`id_articulo`,`id_historial_a`),
  KEY `id_historial_a` (`id_historial_a`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `alm_historial_a` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_historial_a` varchar(15) NOT NULL,
  `entrada` int(11) DEFAULT NULL,
  `salida` int(11) DEFAULT NULL,
  `observacion` text,
  `por_usuario` varchar(9) NOT NULL,
  PRIMARY KEY (`id_historial_a`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `alm_historial_s` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `NRS` varchar(10) NOT NULL,
  `fecha_gen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_ap` timestamp NULL DEFAULT NULL,
  `fecha_desp` timestamp NULL DEFAULT NULL,
  `fecha_comp` timestamp NULL DEFAULT NULL,
  `usuario_gen` varchar(9) NOT NULL,
  `usuario_ap` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`NRS`),
  UNIQUE KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
CREATE TABLE IF NOT EXISTS `alm_pertenece` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cod_cartegoria` varchar(9) NOT NULL,
  `cod_articulo` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `cod_articulo` (`cod_articulo`),
  UNIQUE KEY `cod_cartegoria` (`cod_cartegoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `alm_retira` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `nr_solicitud` varchar(9) NOT NULL,
  `cod_articulo` varchar(9) NOT NULL,
  `id_usuario` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  UNIQUE KEY `traslado_articulo` (`nr_solicitud`,`cod_articulo`,`id_usuario`),
  KEY `cod_articulo` (`cod_articulo`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `alm_solicitud` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `nr_solicitud` varchar(9) NOT NULL,
  `status` enum('carrito','en_proceso','aprobada','enviado','completado') NOT NULL,
  `observacion` text,
  `fecha_gen` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fecha_comp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`nr_solicitud`),
  UNIQUE KEY `ID` (`ID`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

CREATE TABLE IF NOT EXISTS `dec_dependencia` (
  `id_dependencia` bigint(20) NOT NULL AUTO_INCREMENT,
  `dependen` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id_dependencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=10 ;

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
  `id_dependencia` bigint(20) NOT NULL,
  `tipo` enum('docente','administrativo','obrero') NOT NULL,
  `observacion` text,
  `sys_rol` enum('autoridad','asist_autoridad','jefe_alm','director_dep','asistente_dep','ayudante_alm') NOT NULL,
  `status` enum('activo','inactivo') NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `ID` (`ID`),
  KEY `id_dependencia` (`id_dependencia`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Constraints for table `alm_aprueba`
--
ALTER TABLE `alm_aprueba`
  ADD CONSTRAINT `alm_aprueba_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_aprueba_ibfk_2` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_consulta`
--
ALTER TABLE `alm_consulta`
  ADD CONSTRAINT `alm_consulta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_consulta_ibfk_2` FOREIGN KEY (`cod_categoria`) REFERENCES `alm_categoria` (`cod_categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_contiene`
--
ALTER TABLE `alm_contiene`
  ADD CONSTRAINT `alm_contiene_ibfk_2` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_contiene_ibfk_3` FOREIGN KEY (`NRS`) REFERENCES `alm_historial_s` (`NRS`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_contiene_ibfk_4` FOREIGN KEY (`id_articulo`) REFERENCES `alm_articulo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_genera`
--
ALTER TABLE `alm_genera`
  ADD CONSTRAINT `alm_genera_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `alm_solicitud` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_genera_ibfk_2` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `alm_pertenece_ibfk_1` FOREIGN KEY (`cod_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_retira`
--
ALTER TABLE `alm_retira`
  ADD CONSTRAINT `alm_retira_ibfk_1` FOREIGN KEY (`nr_solicitud`) REFERENCES `alm_solicitud` (`nr_solicitud`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_retira_ibfk_2` FOREIGN KEY (`cod_articulo`) REFERENCES `alm_articulo` (`cod_articulo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_retira_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alm_solicitud`
--
ALTER TABLE `alm_solicitud`
  ADD CONSTRAINT `alm_solicitud_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`);

--
-- Constraints for table `dec_usuario`
--
ALTER TABLE `dec_usuario`
  ADD CONSTRAINT `dec_usuario_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dec_dependencia` (`id_dependencia`);


--
-- Tabals de mantenimiento
--

CREATE TABLE IF NOT EXISTS `mnt_asigna_cuadrilla` (
  `id_usuario` varchar(9) NOT NULL,
  `id_cuadrilla` bigint(20) NOT NULL,
  `id_ordenes` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mnt_asigna_material` (
  `id_solicitud` bigint(20) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL,
  `id_usuario` varchar(9) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mnt_ayudante_orden` (
  `id_trabajador` varchar(9) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mnt_cuadrilla` (
  `id` bigint(20) NOT NULL,
  `id_trabajador_responsable` varchar(9) NOT NULL,
  `cuadrilla` varchar(30) NOT NULL,
  `icono` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mnt_estatus` (
  `id_estado` bigint(20) NOT NULL,
  `descripcion` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mnt_estatus_orden` (
  `id_estado` bigint(20) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL,
  `id_usuario` varchar(9) NOT NULL,
  `fecha_p` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mnt_miembros_cuadrilla` (
  `id_cuadrilla` bigint(20) NOT NULL,
  `id_trabajador` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mnt_observacion_orden` (
  `id_usuario` varchar(9) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL,
  `id_observacion` bigint(20) NOT NULL,
  `observac` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mnt_orden_trabajo` (
  `id` bigint(20) NOT NULL,
  `id_orden` varchar(20) NOT NULL,
  `id_tipo` bigint(20) NOT NULL,
  `nombre_contacto` varchar(255) NOT NULL,
  `telefono_contacto` int(11) NOT NULL,
  `asunto` varchar(40) NOT NULL,
  `descripcion_general` mediumtext NOT NULL,
  `dependencia` bigint(20) NOT NULL,
  `ubicacion` bigint(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mnt_responsable_orden` (
  `id_responsable` varchar(9) NOT NULL,
  `id_orden_trabajo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mnt_tipo_orden` (
  `id_tipo` bigint(20) NOT NULL,
  `tipo_orden` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mnt_ubicaciones_dep` (
  `id_ubicacion` bigint(20) NOT NULL,
  `id_dependencia` bigint(20) NOT NULL,
  `oficina` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

ALTER TABLE `mnt_asigna_cuadrilla`
  ADD PRIMARY KEY (`id_usuario`,`id_cuadrilla`,`id_ordenes`),
  ADD KEY `id_trabajador` (`id_usuario`),
  ADD KEY `id_cuadrilla` (`id_cuadrilla`),
  ADD KEY `id_orden_trabajo` (`id_ordenes`);

ALTER TABLE `mnt_asigna_material`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD UNIQUE KEY `id_orden_trabajo` (`id_orden_trabajo`),
  ADD KEY `id_usuario` (`id_usuario`);

ALTER TABLE `mnt_ayudante_orden`
  ADD PRIMARY KEY (`id_trabajador`,`id_orden_trabajo`),
  ADD KEY `id_orden` (`id_orden_trabajo`),
  ADD KEY `id_usuario` (`id_trabajador`);

ALTER TABLE `mnt_cuadrilla`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_trabajador_responsable`);

ALTER TABLE `mnt_estatus`
  ADD PRIMARY KEY (`id_estado`);

ALTER TABLE `mnt_estatus_orden`
  ADD UNIQUE KEY `ID_UNICO_ESTADO` (`id_estado`,`id_orden_trabajo`,`id_usuario`),
  ADD KEY `id_orden_trabajo` (`id_orden_trabajo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_estado2` (`id_estado`);

ALTER TABLE `mnt_miembros_cuadrilla`
  ADD KEY `id_usuario` (`id_trabajador`),
  ADD KEY `id_cuadrilla` (`id_cuadrilla`);

ALTER TABLE `mnt_observacion_orden`
  ADD PRIMARY KEY (`id_observacion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_orden_trabajo` (`id_orden_trabajo`),
  ADD KEY `id_observacion` (`id_observacion`);

ALTER TABLE `mnt_orden_trabajo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_orden` (`id_orden`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `dependencia` (`dependencia`),
  ADD KEY `ubicacion` (`ubicacion`);

ALTER TABLE `mnt_responsable_orden`
  ADD PRIMARY KEY (`id_responsable`,`id_orden_trabajo`),
  ADD KEY `id_orden` (`id_orden_trabajo`),
  ADD KEY `id_usuario` (`id_responsable`);

ALTER TABLE `mnt_tipo_orden`
  ADD PRIMARY KEY (`id_tipo`);

ALTER TABLE `mnt_ubicaciones_dep`
  ADD PRIMARY KEY (`id_ubicacion`),
  ADD UNIQUE KEY `UBICA_DEPE` (`id_ubicacion`,`id_dependencia`),
  ADD KEY `id_dependencia` (`id_dependencia`);

ALTER TABLE `mnt_asigna_material`
  MODIFY `id_orden_trabajo` bigint(20) NOT NULL AUTO_INCREMENT;
  
ALTER TABLE `mnt_cuadrilla`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;

ALTER TABLE `mnt_estatus`
  MODIFY `id_estado` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;

ALTER TABLE `mnt_observacion_orden`
  MODIFY `id_observacion` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;

ALTER TABLE `mnt_orden_trabajo`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;

ALTER TABLE `mnt_ubicaciones_dep`
  MODIFY `id_ubicacion` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;

ALTER TABLE `mnt_asigna_cuadrilla`
  ADD CONSTRAINT `ID_ASIGNA_CUADRILLA` FOREIGN KEY (`id_cuadrilla`) REFERENCES `mnt_cuadrilla` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_ASIGNA_ORDEN2` FOREIGN KEY (`id_ordenes`) REFERENCES `mnt_orden_trabajo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO6` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `mnt_asigna_material`
  ADD CONSTRAINT `ID_ASIGNA_ORDEN` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO7` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `mnt_ayudante_orden`
  ADD CONSTRAINT `ID_ORDEN10` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mnt_ayudante_orden_ibfk_1` FOREIGN KEY (`id_trabajador`) REFERENCES `dec_usuario` (`id_usuario`);

ALTER TABLE `mnt_cuadrilla`
  ADD CONSTRAINT `ID_USUARIO_RESPONSABLE` FOREIGN KEY (`id_trabajador_responsable`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `mnt_estatus_orden`
  ADD CONSTRAINT `ID_ESTADO2` FOREIGN KEY (`id_estado`) REFERENCES `mnt_estatus` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_ESTADO_ORDEN` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO2` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `mnt_miembros_cuadrilla`
  ADD CONSTRAINT `ID_CUADRILLA` FOREIGN KEY (`id_cuadrilla`) REFERENCES `mnt_cuadrilla` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO5` FOREIGN KEY (`id_trabajador`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `mnt_observacion_orden`
  ADD CONSTRAINT `ID_OBSERVACION_ORDEN` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `mnt_orden_trabajo`
  ADD CONSTRAINT `ID_ORDEN_DEPENDENCIA` FOREIGN KEY (`dependencia`) REFERENCES `dec_dependencia` (`id_dependencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_TIPO_ORDEN` FOREIGN KEY (`id_tipo`) REFERENCES `mnt_tipo_orden` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_UBICACION` FOREIGN KEY (`ubicacion`) REFERENCES `mnt_ubicaciones_dep` (`id_ubicacion`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `mnt_responsable_orden`
  ADD CONSTRAINT `mnt_responsable_orden_ibfk_1` FOREIGN KEY (`id_responsable`) REFERENCES `dec_usuario` (`id_usuario`),
  ADD CONSTRAINT `mnt_responsable_orden_ibfk_2` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id`);

ALTER TABLE `mnt_ubicaciones_dep`
  ADD CONSTRAINT `mnt_ubicaciones_dep_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dec_dependencia` (`id_dependencia`) ON DELETE CASCADE ON UPDATE CASCADE;
