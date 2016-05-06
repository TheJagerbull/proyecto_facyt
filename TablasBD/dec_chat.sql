
--
-- Table structure for table `dec_chat_lineas`
--

CREATE TABLE IF NOT EXISTS `dec_chat_lineas` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_autor` varchar(9) NOT NULL,
  `id_receptor` varchar(9) NOT NULL,
  `gravatar` varchar(32) NOT NULL,
  `mensaje` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `TIME` (`TIME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dec_chat_usuarios`
--

CREATE TABLE IF NOT EXISTS `dec_chat_usuarios` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` varchar(9) NOT NULL,
  `gravatar` varchar(32) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `id_usuario` (`id_usuario`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dec_chat_usuarios`
--
ALTER TABLE `dec_chat_usuarios`
  ADD CONSTRAINT `dec_chat_usuarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `dec_usuario` (`id_usuario`);
