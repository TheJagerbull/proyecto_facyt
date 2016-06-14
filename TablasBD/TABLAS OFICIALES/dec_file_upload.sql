--
-- Table structure for table `dec_file_upload`
--

CREATE TABLE `dec_file_upload` (
  `ID` bigint(20) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre_archivo` varchar(30) NOT NULL,
  `tipo_archivo` varchar(30) NOT NULL,
  `tamano_bytes` int(11) NOT NULL,
  `contenido` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='para guardar archivos en la BD :: primero se suven al servid';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dec_file_upload`
--
ALTER TABLE `dec_file_upload`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dec_file_upload`
--
ALTER TABLE `dec_file_upload`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;