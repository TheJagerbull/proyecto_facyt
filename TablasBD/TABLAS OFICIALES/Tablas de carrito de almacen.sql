-- la intencion de estas tablas es crear un auxiliar que permita guardar 
-- una "solicitud" sin numero de solicitud, que permita ser subida a session
-- cuando esta guardada y sin enviar, y bajada de session para ser trasladada a solicitud con numero asignada


--
-- Table structure for table `alm_carrito`
--

CREATE TABLE IF NOT EXISTS `alm_carrito` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_carrito` varchar(9) NOT NULL,
  `observacion` text,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `id_carrito` (`id_carrito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alm_car_contiene`
--

CREATE TABLE IF NOT EXISTS `alm_car_contiene` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_carrito` varchar(9) NOT NULL,
  `id_articulo` bigint(20) NOT NULL,
  `cant_solicitada` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `ID` (`ID`),
  KEY `id_articulo` (`id_articulo`,`cant_solicitada`),
  KEY `id_carrito` (`id_carrito`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `alm_guarda`
--

CREATE TABLE IF NOT EXISTS `alm_guarda` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `id_carrito` varchar(9) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `id_usuario` (`id_usuario`),
  UNIQUE KEY `id_carrito` (`id_carrito`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alm_car_contiene`
--
ALTER TABLE `alm_car_contiene`
  ADD CONSTRAINT `alm_car_contiene_ibfk_1` FOREIGN KEY (`id_carrito`) REFERENCES `alm_carrito` (`id_carrito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contiene_articulo` FOREIGN KEY (`id_articulo`) REFERENCES `alm_articulo` (`ID`);

--
-- Constraints for table `alm_guarda`
--
ALTER TABLE `alm_guarda`
  ADD CONSTRAINT `alm_guarda_ibfk_2` FOREIGN KEY (`id_carrito`) REFERENCES `alm_carrito` (`id_carrito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alm_guarda_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;  