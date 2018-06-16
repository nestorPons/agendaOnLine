-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-02-2018 a las 15:30:34
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aa_db`
--
CREATE DATABASE IF NOT EXISTS aa_db; 
USE aa_db; 

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresas`
--

CREATE TABLE IF NOT EXISTS `empresas`(
  `id` int(11) NOT NULL,
  `nombre_empresa` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `web` varchar(30) NOT NULL,
  `tel` varchar(15) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sector` tinyint(1) NOT NULL,
  `plan` tinyint(1) NOT NULL DEFAULT '1',
  `num_ag` tinyint(2) NOT NULL DEFAULT '1',
  `horarios` tinyint(1) NOT NULL DEFAULT '1',
  `ultimo_acceso` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dni` varchar(11) NOT NULL,
  `nombre_usuario` varchar(30) NOT NULL,
  `dir` varchar(50) NOT NULL,
  `poblacion` varchar(50) NOT NULL,
  `provincia` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `cp` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nombre` (`nombre_empresa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
