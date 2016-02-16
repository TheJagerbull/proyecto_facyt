--
-- Table structure for table `dec_permiso`
--

CREATE TABLE IF NOT EXISTS `dec_permiso` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_usuario` varchar(9) NOT NULL,
  `nivel` text,
  PRIMARY KEY (`ID`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dec_permiso`
--
ALTER TABLE `dec_permiso`
  ADD CONSTRAINT `dec_permiso_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;