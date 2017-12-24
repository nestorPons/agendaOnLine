SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `agendas` (
  `id` tinyint(2) NOT NULL,
  `nombre` varchar(10) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `mostrar` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `auth_tokens` (
  `id` int(11) NOT NULL,
  `selector` char(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validator` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cita` (
  `id` bigint(255) NOT NULL,
  `idCita` bigint(255) NOT NULL,
  `servicio` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE `config` (
  `idEmpresa` int(11) NOT NULL,
  `sendMailAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `sendMailUser` tinyint(1) NOT NULL DEFAULT '1',
  `minTime` smallint(3) NOT NULL DEFAULT '60',
  `festivosON` tinyint(1) NOT NULL DEFAULT '1',
  `ShowRow` tinyint(1) NOT NULL DEFAULT '0',
  `hora_ini` time NOT NULL DEFAULT '08:00:00',
  `hora_fin` time NOT NULL DEFAULT '20:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `config_css` (
  `color_main` varchar(10) NOT NULL DEFAULT '#48c188',
  `color_secon` varchar(10) NOT NULL DEFAULT '#eda537',
  `color_text` varchar(12) NOT NULL DEFAULT '#000',
  `border_radio` tinyint(2) NOT NULL DEFAULT '2',
  `font_main` varchar(20) NOT NULL DEFAULT 'Roboto',
  `font_tile` varchar(20) NOT NULL DEFAULT 'Raleway',
  `url_img` varchar(100) NOT NULL DEFAULT 'http://pingendo.github.io/pingendo-bootstrap/assets/blurry/800x600/12.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE `data` (
  `id` bigint(255) NOT NULL,
  `agenda` tinyint(2) NOT NULL DEFAULT '1',
  `idUsuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `obs` text COLLATE utf8_spanish2_ci,
  `usuarioCogeCita` int(11) DEFAULT NULL,
  `lastMod` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE `del_cita` (
  `id` bigint(255) NOT NULL DEFAULT '0',
  `idCita` bigint(255) NOT NULL,
  `servicio` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `del_data` (
  `id` bigint(255) NOT NULL DEFAULT '0',
  `agenda` tinyint(2) NOT NULL DEFAULT '1',
  `idUsuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `obs` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `usuarioCogeCita` int(11) DEFAULT NULL,
  `fechaDel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastMod` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `familias` (
  `id` tinyint(2) NOT NULL,
  `nombre` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `mostrar` tinyint(1) NOT NULL DEFAULT '1',
  `baja` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `festivos` (
  `id` tinyint(2) NOT NULL,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `fecha` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `horarios` (
  `id` tinyint(2) NOT NULL,
  `agenda` tinyint(2) NOT NULL,
  `dia` tinyint(1) NOT NULL,
  `inicio` time NOT NULL,
  `fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `notas` (
  `id` int(50) NOT NULL,
  `nota` longtext CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `servicios` (
  `id` smallint(3) NOT NULL,
  `codigo` varchar(8) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `precio` double DEFAULT '0',
  `tiempo` int(4) DEFAULT '0',
  `idFamilia` tinyint(2) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tblreseteopass` (
  `id` int(11) UNSIGNED NOT NULL,
  `token` varchar(64) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` tinytext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `pass` varchar(255) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `obs` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `idioma` tinyint(1) NOT NULL DEFAULT '1',
  `dateReg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateBaja` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 = active, 1 = block bruteForce, 2= block autorization',
  `attempts` tinyint(4) NOT NULL DEFAULT '0'
  `pin` SMALLINT(4) NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

ALTER TABLE `agendas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`);

ALTER TABLE `cita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCita` (`idCita`),
  ADD KEY `servicios` (`servicio`);

ALTER TABLE `config`
  ADD PRIMARY KEY (`idEmpresa`),
  ADD UNIQUE KEY `idEmpresa` (`idEmpresa`);

ALTER TABLE `config_css`
  ADD PRIMARY KEY (`color_main`);

ALTER TABLE `data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `agenda` (`agenda`),
  ADD KEY `usuarioCogeCita` (`usuarioCogeCita`);

ALTER TABLE `del_cita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servicio` (`servicio`),
  ADD KEY `idCita` (`idCita`);

ALTER TABLE `del_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agenda` (`agenda`),
  ADD KEY `usuarioCogeCita` (`usuarioCogeCita`),
  ADD KEY `idUsuario` (`idUsuario`);

ALTER TABLE `familias`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `festivos`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agenda` (`agenda`);

ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD INDEX(`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `idFamilia` (`idFamilia`);

ALTER TABLE `tblreseteopass`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idUser` (`idUser`);

ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);
  
ALTER TABLE `agendas`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT;

ALTER TABLE `auth_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `cita`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `data`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT;

ALTER TABLE `familias`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT;

ALTER TABLE `festivos`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT;

ALTER TABLE `horarios`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT;

ALTER TABLE `notas`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

ALTER TABLE `servicios`
  MODIFY `id` smallint(3) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tblreseteopass`
  MODIFY `id` int(11) UNSIGNED NOT NULL;

ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `TOK_IDU_FK` FOREIGN KEY (`idUser`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `cita`
  ADD CONSTRAINT `ID_SER_FK` FOREIGN KEY (`servicio`) REFERENCES `servicios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
  
ALTER TABLE `data`
  ADD CONSTRAINT `DAT_IDU_FK` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `del_cita`
  ADD CONSTRAINT `DCT_SER_FK` FOREIGN KEY (`servicio`) REFERENCES `servicios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `DCT_IDC_FK` FOREIGN KEY (`idCita`) REFERENCES `del_data` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `del_data`
  ADD CONSTRAINT `DDA_IDU_FK` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `horarios`
  ADD CONSTRAINT `HOR_AGE_FK` FOREIGN KEY (`agenda`) REFERENCES `agendas` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `servicios`
  ADD CONSTRAINT `SER_FAM_FK` FOREIGN KEY (`idFamilia`) REFERENCES `familias` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `tblreseteopass`
  ADD CONSTRAINT `RPS_ID_FK` FOREIGN KEY (`id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;