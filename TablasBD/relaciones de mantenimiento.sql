
-- Índices para tablas volcadas

-- Indices de la tabla `dec_dependencia`
--
ALTER TABLE `dec_dependencia`
  ADD PRIMARY KEY (`id_dependencia`);

-- AUTO_INCREMENT de la tabla `dec_dependencia`
--
ALTER TABLE `dec_dependencia`
  MODIFY `id_dependencia` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;

-- Indices de la tabla `mnt_ubicaciones_dep`
--
ALTER TABLE `mnt_ubicaciones_dep`
  ADD PRIMARY KEY (`id_ubicacion`),
  ADD UNIQUE KEY `UBICA_DEPE` (`id_ubicacion`,`id_dependencia`),
  ADD KEY `id_dependencia` (`id_dependencia`);

-- AUTO_INCREMENT de la tabla `mnt_ubicaciones_dep`
--
ALTER TABLE `mnt_ubicaciones_dep`
  MODIFY `id_ubicacion` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas

-- Filtros para la tabla `mnt_ubicaciones_dep`
--
ALTER TABLE `mnt_ubicaciones_dep`
  ADD CONSTRAINT `mnt_ubicaciones_dep_ibfk_1` FOREIGN KEY (`id_dependencia`) REFERENCES `dec_dependencia` (`id_dependencia`) ON DELETE CASCADE ON UPDATE CASCADE;
-- Indices de la tabla `mnt_orden_trabajo`
--
ALTER TABLE `mnt_orden_trabajo`
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `id_tipo` (`id_tipo`),
  ADD KEY `dependencia` (`dependencia`),
  ADD KEY `ubicacion` (`ubicacion`);

-- AUTO_INCREMENT de la tabla `mnt_orden_trabajo`
--
ALTER TABLE `mnt_orden_trabajo`
  MODIFY `id_orden` bigint(20) NOT NULL AUTO_INCREMENT;

-- Restricciones para tablas volcadas
-- Filtros para la tabla `mnt_orden_trabajo`
--
ALTER TABLE `mnt_orden_trabajo`
  ADD CONSTRAINT `ID_ORDEN_DEPENDENCIA` FOREIGN KEY (`dependencia`) REFERENCES `dec_dependencia` (`id_dependencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_TIPO_ORDEN` FOREIGN KEY (`id_tipo`) REFERENCES `mnt_tipo_orden` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_UBICACION` FOREIGN KEY (`ubicacion`) REFERENCES `mnt_ubicaciones_dep` (`id_ubicacion`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Indices de la tabla `mnt_tipo_orden`
--
ALTER TABLE `mnt_tipo_orden`
  ADD PRIMARY KEY (`id_tipo`);

-- Indices de la tabla `mnt_observacion_orden`
--
ALTER TABLE `mnt_observacion_orden`
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_orden_trabajo` (`id_orden_trabajo`),
  ADD FULLTEXT KEY `observacion` (`observac`);

-- Filtros para la tabla `mnt_observacion_orden`
--
ALTER TABLE `mnt_observacion_orden`
  ADD CONSTRAINT `ID_OBSERVACION_ORDEN` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id_orden`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Indices de la tabla `mnt_cuadrilla`
--
ALTER TABLE `mnt_cuadrilla`
  ADD PRIMARY KEY (`id_cuadrilla`),
  ADD KEY `id_usuario` (`id_usuario_responsable`);

-- AUTO_INCREMENT de la tabla `mnt_cuadrilla`
--
ALTER TABLE `mnt_cuadrilla`
  MODIFY `id_cuadrilla` bigint(20) NOT NULL AUTO_INCREMENT;

-- Filtros para la tabla `mnt_cuadrilla`
--
ALTER TABLE `mnt_cuadrilla`
  ADD CONSTRAINT `ID_USUARIO_RESPONSABLE` FOREIGN KEY (`id_usuario_responsable`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Indices de la tabla `mnt_miembros_cuadrilla`
--
ALTER TABLE `mnt_miembros_cuadrilla`
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_cuadrilla` (`id_cuadrilla`);

-- Filtros para la tabla `mnt_miembros_cuadrilla`
--
ALTER TABLE `mnt_miembros_cuadrilla`
  ADD CONSTRAINT `ID_CUADRILLA` FOREIGN KEY (`id_cuadrilla`) REFERENCES `mnt_cuadrilla` (`id_cuadrilla`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO5` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Indices de la tabla `mnt_estatus`
--
ALTER TABLE `mnt_estatus`
  ADD PRIMARY KEY (`id_estado`);

-- AUTO_INCREMENT de la tabla `mnt_estatus`
--
ALTER TABLE `mnt_estatus`
  MODIFY `id_estado` bigint(20) NOT NULL AUTO_INCREMENT;

-- Indices de la tabla `mnt_estatus_orden`
--
ALTER TABLE `mnt_estatus_orden`
  ADD UNIQUE KEY `ID_UNICO_ESTADO` (`id_estado`,`id_orden_trabajo`,`id_usuario`),
  ADD KEY `id_orden_trabajo` (`id_orden_trabajo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_estado2` (`id_estado`);

-- Filtros para la tabla `mnt_estatus_orden`
--
ALTER TABLE `mnt_estatus_orden`
  ADD CONSTRAINT `ID_ESTADO2` FOREIGN KEY (`id_estado`) REFERENCES `mnt_estatus` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_ESTADO_ORDEN` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id_orden`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO2` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Indices de la tabla `mnt_ayudante_orden`
--
ALTER TABLE `mnt_ayudante_orden`
  ADD PRIMARY KEY (`id_usuario`,`id_responsable`,`id_orden_trabajo`),
  ADD KEY `id_trabajador` (`id_responsable`),
  ADD KEY `id_orden` (`id_orden_trabajo`),
  ADD KEY `id_usuario` (`id_usuario`);

-- Filtros para la tabla `mnt_ayudante_orden`
--
ALTER TABLE `mnt_ayudante_orden`
  ADD CONSTRAINT `ID_ORDEN10` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id_orden`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_TRABAJADOR` FOREIGN KEY (`id_responsable`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `mnt_ayudante_orden_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`);

-- Indices de la tabla `mnt_asigna_material`
--
ALTER TABLE `mnt_asigna_material`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD UNIQUE KEY `id_orden_trabajo` (`id_orden_trabajo`),
  ADD KEY `id_usuario` (`id_usuario`);

-- AUTO_INCREMENT de la tabla `mnt_asigna_material`
--
ALTER TABLE `mnt_asigna_material`
  MODIFY `id_orden_trabajo` bigint(20) NOT NULL AUTO_INCREMENT;

-- Filtros para la tabla `mnt_asigna_material`
--
ALTER TABLE `mnt_asigna_material`
  ADD CONSTRAINT `ID_ASIGNA_ORDEN` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id_orden`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO7` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Indices de la tabla `mnt_asigna_cuadrilla`
--
ALTER TABLE `mnt_asigna_cuadrilla`
  ADD PRIMARY KEY (`id_usuario`,`id_cuadrilla`,`id_orden_trabajo`),
  ADD KEY `id_trabajador` (`id_usuario`),
  ADD KEY `id_cuadrilla` (`id_cuadrilla`),
  ADD KEY `id_orden_trabajo` (`id_orden_trabajo`);

-- Filtros para la tabla `mnt_asigna_cuadrilla`
--
ALTER TABLE `mnt_asigna_cuadrilla`
  ADD CONSTRAINT `ID_ASIGNA_CUADRILLA` FOREIGN KEY (`id_cuadrilla`) REFERENCES `mnt_cuadrilla` (`id_cuadrilla`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_ASIGNA_ORDEN2` FOREIGN KEY (`id_orden_trabajo`) REFERENCES `mnt_orden_trabajo` (`id_orden`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ID_USUARIO6` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
