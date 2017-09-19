-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-09-2017 a las 19:55:23
-- Versión del servidor: 10.1.26-MariaDB
-- Versión de PHP: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_demo`
--
CREATE SCHEMA IF NOT EXISTS `bd_demo`;
USE `bd_demo`;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agendas`
--

CREATE TABLE `agendas` (
  `id` tinyint(2) NOT NULL,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `mostrar` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `agendas`
--

INSERT INTO `agendas` (`id`, `nombre`, `mostrar`) VALUES
(1, 'Agenda 1', 0),
(2, 'Agenda 2', 0),
(3, 'Agenda 3', 1),
(4, 'Agenda 4 ', 1),
(5, 'Agenda 5', 1),
(6, 'Agenda 6', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id` bigint(255) NOT NULL,
  `idCita` bigint(255) NOT NULL,
  `servicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id`, `idCita`, `servicio`) VALUES
(4, 16, 2),
(7, 24, 1),
(8, 24, 2),
(9, 26, 4),
(10, 24, 2),
(11, 16, 1),
(12, 34, 1),
(13, 31, 3),
(14, 32, 3),
(15, 33, 3),
(16, 34, 3),
(17, 34, 4),
(18, 36, 3),
(19, 37, 4),
(20, 38, 4),
(23, 41, 1),
(24, 43, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `idEmpresa` int(11) NOT NULL,
  `sendMailAdmin` tinyint(1) NOT NULL,
  `sendMailUser` tinyint(1) NOT NULL,
  `minTime` tinyint(3) NOT NULL DEFAULT '60',
  `festivosON` tinyint(1) NOT NULL DEFAULT '1',
  `ShowRow` tinyint(4) NOT NULL DEFAULT '1',
  `hora_ini` time NOT NULL DEFAULT '08:00:00',
  `hora_fin` time NOT NULL DEFAULT '20:00:00',
  `margen_dias` tinyint(2) NOT NULL DEFAULT '6'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `config`
--

INSERT INTO `config` (`idEmpresa`, `sendMailAdmin`, `sendMailUser`, `minTime`, `festivosON`, `ShowRow`, `hora_ini`, `hora_fin`, `margen_dias`) VALUES
(2, 0, 1, 60, 1, 0, '08:00:00', '20:00:00', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config_css`
--

CREATE TABLE `config_css` (
  `id` tinyint(1) NOT NULL,
  `color_main` varchar(8) COLLATE utf8_spanish_ci NOT NULL DEFAULT '#48c188',
  `color_secon` varchar(8) COLLATE utf8_spanish_ci NOT NULL DEFAULT '#eda537',
  `color_text` varchar(12) COLLATE utf8_spanish_ci NOT NULL DEFAULT '#000',
  `border_radio` varchar(4) COLLATE utf8_spanish_ci NOT NULL DEFAULT '2px',
  `font_main` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Roboto',
  `font_tile` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Raleway',
  `url_img` varchar(100) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'http://pingendo.github.io/pingendo-bootstrap/assets/blurry/800x600/12.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `config_css`
--

INSERT INTO `config_css` (`id`, `color_main`, `color_secon`, `color_text`, `border_radio`, `font_main`, `font_tile`, `url_img`) VALUES
(1, '#e24d4d', '#eaa01f', '#777', '5', 'Indie Flower', 'Bangers', 'http://pingendo.github.io/pingendo-bootstrap/assets/blurry/800x600/12.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `data`
--

CREATE TABLE `data` (
  `id` bigint(255) NOT NULL,
  `agenda` tinyint(2) NOT NULL DEFAULT '1',
  `idUsuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `obs` text COLLATE utf8_spanish2_ci,
  `usuarioCogeCita` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `data`
--

INSERT INTO `data` (`id`, `agenda`, `idUsuario`, `fecha`, `hora`, `obs`, `usuarioCogeCita`) VALUES
(16, 1, 2, '2017-08-22', '18:00:00', 'saadasdadsdssdasdsadsasdadsadssadsadaddsa', 2),
(24, 1, 2, '2017-08-18', '09:00:00', '', 2),
(25, 1, 2, '2017-08-05', '18:00:00', '', 1),
(26, 1, 2, '2017-08-05', '11:00:00', '', 1),
(27, 1, 3, '2017-08-03', '11:00:00', '', 1),
(28, 1, 3, '2017-08-09', '11:00:00', '', 1),
(29, 1, 3, '2017-08-03', '11:00:00', '', 1),
(30, 1, 3, '2017-08-03', '11:00:00', '', 1),
(31, 1, 2, '2017-08-03', '00:00:00', '', 1),
(32, 1, 2, '2017-08-03', '00:00:00', '', 1),
(33, 1, 2, '2017-08-03', '12:00:00', '', 1),
(34, 1, 1, '2017-08-17', '11:30:00', '', 1),
(35, 1, 2, '2017-08-03', '13:00:00', '', 1),
(36, 1, 2, '2017-08-03', '13:00:00', '', 1),
(37, 1, 2, '2017-08-03', '16:00:00', '', 1),
(38, 1, 1, '2017-08-04', '09:00:00', '', 1),
(41, 1, 2, '2017-08-07', '13:15:00', '', 1),
(43, 6, 2, '2017-09-06', '11:15:00', '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `del_cita`
--

CREATE TABLE `del_cita` (
  `id` bigint(255) NOT NULL DEFAULT '0',
  `idCita` bigint(255) NOT NULL,
  `servicio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `del_data`
--

CREATE TABLE `del_data` (
  `id` bigint(255) NOT NULL DEFAULT '0',
  `agenda` tinyint(2) NOT NULL DEFAULT '1',
  `idUsuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `obs` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `usuarioCogeCita` int(11) DEFAULT NULL,
  `fechaDel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Estructura de tabla para la tabla `even`
--

CREATE TABLE `even` (
  `id` bigint(20) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `idCita` int(11) DEFAULT NULL,
  `idEven` tinyint(4) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `agenda` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` tinyint(4) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familias`
--

CREATE TABLE `familias` (
  `id` tinyint(1) NOT NULL,
  `nombre` varchar(15) NOT NULL,
  `mostrar` tinyint(4) NOT NULL DEFAULT '1',
  `baja` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `familias`
--

INSERT INTO `familias` (`id`, `nombre`, `mostrar`, `baja`) VALUES
(1, 'Familia princpa', 1, 0),
(2, 'Familia 2', 1, 0),
(3, 'Familia secunda', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `festivos`
--

CREATE TABLE `festivos` (
  `id` tinyint(2) NOT NULL,
  `nombre` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `fecha` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `festivos`
--

INSERT INTO `festivos` (`id`, `nombre`, `fecha`) VALUES
(1, 'AÑO NUEVO', '2017-01-01'),
(33, 'Navidad', '2017-09-05'),
(35, 'hoy', '2017-08-24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` tinyint(2) NOT NULL,
  `agenda` tinyint(2) NOT NULL,
  `dia` tinyint(1) NOT NULL,
  `inicio` time NOT NULL,
  `fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`id`, `agenda`, `dia`, `inicio`, `fin`) VALUES
(1, 1, 6, '07:00:00', '14:00:00'),
(3, 1, 3, '16:00:00', '20:00:00'),
(4, 1, 3, '11:00:00', '14:00:00'),
(5, 1, 4, '12:00:00', '20:00:00'),
(6, 1, 5, '08:00:00', '18:00:00'),
(8, 1, 1, '09:00:00', '20:00:00'),
(9, 2, 2, '10:00:00', '19:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id` int(50) NOT NULL,
  `nota` longtext CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `codigo` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `descripcion` varchar(50) DEFAULT NULL,
  `precio` double DEFAULT '0',
  `tiempo` int(4) DEFAULT '0',
  `idFamilia` tinyint(4) DEFAULT NULL,
  `baja` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `codigo`, `descripcion`, `precio`, `tiempo`, `idFamilia`, `baja`) VALUES
(1, 'COD_SER1', 'Servicio maniciu', 1, 20, 1, 0),
(2, 'Serv2', 'Servicio 2', 23, 11, 2, 0),
(3, 'COD_SER3', 'Servicio 3 ', 12, 33, 1, 0),
(4, 'COD_SER4', 'Servicio 4', 12, 22, 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblreseteopass`
--

CREATE TABLE `tblreseteopass` (
  `id` int(10) UNSIGNED NOT NULL,
  `idusuario` int(10) NOT NULL,
  `token` varchar(64) NOT NULL,
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_reg`
--

CREATE TABLE `user_reg` (
  `id` int(10) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idCita` bigint(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 ha sido borrada , 1 ha sido insertada, 2 ha sido modificada, 3 edicion datos usuario (buscar por id usuario), 4 eliminacion usuario',
  `fecha` datetime NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla para guardar cambios hechos por los clientes';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` tinytext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `pass` varchar(50) CHARACTER SET latin1 NOT NULL,
  `tel` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `obs` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `cookie` int(11) NOT NULL,
  `idioma` tinyint(1) NOT NULL DEFAULT '1',
  `dateReg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateBaja` datetime DEFAULT NULL,
  `block` tinyint(4) DEFAULT '0',
  `token` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `pass`, `tel`, `admin`, `obs`, `cookie`, `idioma`, `dateReg`, `dateBaja`, `block`, `token`) VALUES
(1, 'Demo', 'demo@demo.es', 'cbdbe4936ce8be63184d9f2e13fc249234371b9a', '123456789', 1, '', 0, 1, '2017-04-24 20:19:15', '0000-00-00 00:00:00', 0, 0),
(2, 'Mari carmen de la maimona', '', '', '660291797', 0, 'Es el usuario 2', 0, 1, '2017-05-05 17:54:32', NULL, 0, 0),
(3, 'usuario 3', '', '', '', 0, 'es el usuario 3', 0, 1, '2017-05-05 17:58:51', NULL, 0, 0),
(4, 'Anton ', 'anton@pirulelro', '', '123456', 0, '', 0, 1, '2017-08-03 13:20:46', '0000-00-00 00:00:00', 0, 0),
(5, 'Antonieta', 'an@sasd', '', '', 0, '', 0, 1, '2017-08-03 13:21:20', NULL, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `agendas`
--
ALTER TABLE `agendas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id`);
  
--
-- Indices de la tabla `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`idEmpresa`);

--
-- Indices de la tabla `config_css`
--
ALTER TABLE `config_css`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `agenda` (`agenda`),
  ADD KEY `usuarioCogeCita` (`usuarioCogeCita`);

--
-- Indices de la tabla `del_cita`
--
ALTER TABLE `del_cita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servicio` (`servicio`),
  ADD KEY `idCita` (`idCita`);

--
-- Indices de la tabla `del_data`
--
ALTER TABLE `del_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agenda` (`agenda`),
  ADD KEY `usuarioCogeCita` (`usuarioCogeCita`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `even`
--
ALTER TABLE `even`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idEven` (`idEven`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `familias`
--
ALTER TABLE `familias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `festivos`
--
ALTER TABLE `festivos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agenda` (`agenda`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `idFamilia` (`idFamilia`);

--
-- Indices de la tabla `tblreseteopass`
--
ALTER TABLE `tblreseteopass`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `user_reg`
--
ALTER TABLE `user_reg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data` (`idCita`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `agendas`
--
ALTER TABLE `agendas`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `config_css`
--
ALTER TABLE `config_css`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `data`
--
ALTER TABLE `data`
  MODIFY `id` bigint(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `even`
--
ALTER TABLE `even`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `familias`
--
ALTER TABLE `familias`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `festivos`
--
ALTER TABLE `festivos`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tblreseteopass`
--
ALTER TABLE `tblreseteopass`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user_reg`
--
ALTER TABLE `user_reg`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `Servicios` FOREIGN KEY (`servicio`) REFERENCES `servicios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `data` FOREIGN KEY (`idCita`) REFERENCES `data` (`id`);

--
-- Filtros para la tabla `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `data_ibfk_2` FOREIGN KEY (`agenda`) REFERENCES `agendas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `data_ibfk_3` FOREIGN KEY (`usuarioCogeCita`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `del_cita`
--
ALTER TABLE `del_cita`
  ADD CONSTRAINT `del_cita_ibfk_2` FOREIGN KEY (`servicio`) REFERENCES `servicios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `del_cita_ibfk_3` FOREIGN KEY (`idCita`) REFERENCES `del_data` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `del_data`
--
ALTER TABLE `del_data`
  ADD CONSTRAINT `del_data_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `del_data_ibfk_3` FOREIGN KEY (`UsuarioCogeCita`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `even`
--
ALTER TABLE `even`
  ADD CONSTRAINT `even_ibfk_1` FOREIGN KEY (`idEven`) REFERENCES `eventos` (`id`);

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`agenda`) REFERENCES `agendas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `servicios_ibfk_1` FOREIGN KEY (`idFamilia`) REFERENCES `familias` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `tblreseteopass`
--
ALTER TABLE `tblreseteopass`
  ADD CONSTRAINT `tblreseteopass_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `user_reg`
--
ALTER TABLE `user_reg`
  ADD CONSTRAINT `user_reg_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
