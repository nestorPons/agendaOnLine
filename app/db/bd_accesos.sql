-- phpMyAdmin SQL Dump
-- version 4.4.7
-- https://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 18, 2017 at 08:35 PM
-- Server version: 5.5.43
-- PHP Version: 7.0.0-dev

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aol_accesos`
--
CREATE SCHEMA IF NOT EXISTS `aol_accesos`;
USE `aol_accesos`;
-- --------------------------------------------------------

--
-- Table structure for table `accesos`
--

CREATE TABLE `accesos` (
  `id` int(11) NOT NULL,
  `plan` tinyint(4) NOT NULL DEFAULT '1',
  `numAg` tinyint(4) NOT NULL DEFAULT '1',
  `horarios` tinyint(4) NOT NULL DEFAULT '1',
  `ultimoAcceso` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accesos`
--

INSERT INTO `accesos` (`id`, `plan`, `numAg`, `horarios`, `ultimoAcceso`) VALUES
(1, 1, 2, 2, '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `nif` text NOT NULL,
  `user` text NOT NULL,
  `dir` text NOT NULL,
  `poblacion` text NOT NULL,
  `pais` text NOT NULL,
  `cp` text NOT NULL,
  `email` text NOT NULL,
  `web` text NOT NULL,
  `tel` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sector` tinyint(4) NOT NULL,
  `idioma` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `empresas`
--

INSERT INTO `empresas` (`id`, `nombre`, `nif`, `user`, `dir`, `poblacion`, `pais`, `cp`, `email`, `web`, `tel`, `fecha`, `sector`, `idioma`) VALUES
(1, 'la_Plantilla', '', 'admin', 'ramon MAmon', '', '', '', 'admin@admin', 'www.miWeb.es', '123456789', '2017-02-04 07:24:35', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `idiomas`
--

CREATE TABLE `idiomas` (
  `id` tinyint(4) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `idiomas`
--

INSERT INTO `idiomas` (`id`, `nombre`) VALUES
(1, 'ES'),
(2, 'CAT'),
(3, 'EN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesos`
--
ALTER TABLE `accesos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `idiomas`
--
ALTER TABLE `idiomas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesos`
--
ALTER TABLE `accesos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `idiomas`
--
ALTER TABLE `idiomas`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `accesos`
--
ALTER TABLE `accesos`
  ADD CONSTRAINT `accesos_ibfk_1` FOREIGN KEY (`id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- --------------------------------------------------------
