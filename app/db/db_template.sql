SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `agendas` (
  `id` tinyint(2) PRIMARY KEY AUTO_INCREMENT ,
  `nombre` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `mostrar` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `auth_tokens` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT ,
  `selector` char(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validator` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cita` (
  `id` bigint(255) PRIMARY KEY AUTO_INCREMENT ,
  `idCita` bigint(255) NOT NULL,
  `servicio` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE `config` (
  `idEmpresa` int(11) NOT NULL PRIMARY KEY,
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
  `id` bigint(255) PRIMARY KEY AUTO_INCREMENT ,
  `agenda` tinyint(2) NOT NULL DEFAULT '1',
  `idUsuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `obs` text COLLATE utf8_spanish2_ci,
  `usuarioCogeCita` int(11) DEFAULT NULL,
  `lastMod` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

CREATE TABLE `del_cita` (
  `id` bigint(255) NOT NULL DEFAULT '0' PRIMARY KEY,
  `idCita` bigint(255) NOT NULL,
  `servicio` smallint(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `del_data` (
  `id` bigint(255) NOT NULL DEFAULT '0' PRIMARY KEY,
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
  `id` tinyint(2) PRIMARY KEY AUTO_INCREMENT ,
  `nombre` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `mostrar` tinyint(1) NOT NULL DEFAULT '1',
  `baja` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `festivos` (
  `id` tinyint(2) PRIMARY KEY AUTO_INCREMENT ,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `fecha` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `horarios` (
  `id` tinyint(2) PRIMARY KEY AUTO_INCREMENT ,
  `agenda` tinyint(2) NOT NULL,
  `dia` tinyint(1) NOT NULL,
  `inicio` time NOT NULL,
  `fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `notas` (
  `id` int(50) PRIMARY KEY AUTO_INCREMENT ,
  `nota` longtext CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `servicios` (
  `id` smallint(3) PRIMARY KEY AUTO_INCREMENT ,
  `codigo` varchar(8) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `precio` double DEFAULT '0',
  `tiempo` int(4) DEFAULT '0',
  `idFamilia` tinyint(2) DEFAULT NULL,
  `baja` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tblreseteopass` (
  `id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `usuarios` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT ,
  `nombre` tinytext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `pass` varchar(255) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `obs` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `idioma` tinyint(1) NOT NULL DEFAULT '1',
  `dateReg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateBaja` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 = active, 1 = block bruteForce, 2= block autorization',
  `attempts` tinyint(4) NOT NULL DEFAULT '0',
  `pin` SMALLINT(4) NULL
) ENGINE=InnoDB;

CREATE TABLE `logs` (
	`id` int(11) PRIMARY KEY AUTO_INCREMENT,
	`idUser` int(11) NOT NULL, 
	`action` int(2) NOT NULL, 
	`idFK` bigint(255), 
	`status` tinyint(1) NOT NULL, 
	`tables` varchar(30)  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `auth_tokens`
  ADD KEY `idUser` (`idUser`);

ALTER TABLE `cita`
  ADD KEY `idCita` (`idCita`),
  ADD KEY `servicios` (`servicio`);

ALTER TABLE `data`
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `agenda` (`agenda`),
  ADD KEY `usuarioCogeCita` (`usuarioCogeCita`);

ALTER TABLE `del_cita`
  ADD KEY `servicio` (`servicio`),
  ADD KEY `idCita` (`idCita`);

ALTER TABLE `del_data`
  ADD KEY `agenda` (`agenda`),
  ADD KEY `usuarioCogeCita` (`usuarioCogeCita`),
  ADD KEY `idUsuario` (`idUsuario`);

ALTER TABLE `horarios`
  ADD KEY `agenda` (`agenda`);

ALTER TABLE `servicios`
  ADD INDEX(`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `idFamilia` (`idFamilia`);

ALTER TABLE `usuarios`
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `logs`
	ADD KEY `idUSer`(`idUser`);

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

ALTER TABLE `logs`
  ADD CONSTRAINT `LOG_IDU_FK` FOREIGN KEY (`idUser`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
COMMIT;