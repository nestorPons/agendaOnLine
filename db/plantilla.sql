-- MySQL dump 10.16  Distrib 10.1.21-MariaDB, for Linux (i686)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agendas`
--

DROP TABLE IF EXISTS `agendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agendas` (
  `Id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `Nombre` text CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Mostrar` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`),
  KEY `Id_2` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `articulos`
--

DROP TABLE IF EXISTS `articulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articulos` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Codigo` varchar(15) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL DEFAULT '',
  `Descripcion` varchar(50) DEFAULT NULL,
  `Precio` double DEFAULT '0',
  `Tiempo` int(4) DEFAULT '0',
  `IdFamilia` tinyint(4) DEFAULT NULL,
  `Baja` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Codigo` (`Codigo`),
  KEY `IdFamilia` (`IdFamilia`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cita`
--

DROP TABLE IF EXISTS `cita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cita` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `IdCita` int(10) NOT NULL,
  `Hora` int(3) NOT NULL,
  `Servicio` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `IdCita` (`IdCita`),
  KEY `Servicio` (`Servicio`),
  CONSTRAINT `DaTa` FOREIGN KEY (`IdCita`) REFERENCES `data` (`IdCita`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `config`
--

DROP TABLE IF EXISTS `config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config` (
  `idEmpresa` int(11) NOT NULL,
  `sendMailAdmin` tinyint(1) NOT NULL,
  `sendMailUser` tinyint(1) NOT NULL,
  `MinTime` tinyint(3) NOT NULL DEFAULT '60',
  `festivosON` tinyint(1) NOT NULL DEFAULT '1',
  `ShowRow` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idEmpresa`),
  UNIQUE KEY `idEmpresa` (`idEmpresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data` (
  `IdCita` int(10) NOT NULL AUTO_INCREMENT,
  `Agenda` tinyint(2) NOT NULL DEFAULT '1',
  `IdUsuario` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Obs` text COLLATE utf8_spanish2_ci,
  `UsuarioCogeCita` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdCita`),
  KEY `IdUsuario` (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=281 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `del_cita`
--

DROP TABLE IF EXISTS `del_cita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `del_cita` (
  `Id` int(10) NOT NULL DEFAULT '0',
  `IdCita` int(10) NOT NULL,
  `Hora` int(3) NOT NULL,
  `Servicio` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `del_data`
--

DROP TABLE IF EXISTS `del_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `del_data` (
  `IdCita` int(10) NOT NULL DEFAULT '0',
  `Agenda` tinyint(2) NOT NULL DEFAULT '1',
  `IdUsuario` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Obs` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `UsuarioCogeCita` int(11) DEFAULT NULL,
  `FechaDel` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`IdCita`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `even`
--

DROP TABLE IF EXISTS `even`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `even` (
  `Id` bigint(20) NOT NULL AUTO_INCREMENT,
  `IdUsuario` int(11) DEFAULT NULL,
  `IdCita` int(11) DEFAULT NULL,
  `IdEven` tinyint(4) DEFAULT NULL,
  `Fecha` datetime DEFAULT NULL,
  `Admin` tinyint(1) DEFAULT NULL,
  `agenda` tinyint(4) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `IdEven` (`IdEven`),
  CONSTRAINT `even_ibfk_1` FOREIGN KEY (`IdEven`) REFERENCES `eventos` (`IdEven`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `eventos`
--

DROP TABLE IF EXISTS `eventos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventos` (
  `IdEven` tinyint(4) NOT NULL,
  `Nombre` text NOT NULL,
  PRIMARY KEY (`IdEven`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `familias`
--

DROP TABLE IF EXISTS `familias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `familias` (
  `IdFamilia` tinyint(1) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(15) NOT NULL,
  `Mostrar` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`IdFamilia`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `festivos`
--

DROP TABLE IF EXISTS `festivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `festivos` (
  `Id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `Nombre` text CHARACTER SET utf8 COLLATE utf8_spanish2_ci,
  `Fecha` date NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `horarios`
--

DROP TABLE IF EXISTS `horarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horarios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` char(10) NOT NULL DEFAULT 'Horario 1',
  `FechaIni` int(4) unsigned zerofill DEFAULT '0101',
  `FechaFin` int(4) unsigned zerofill DEFAULT '1231',
  `h11` tinyint(1) NOT NULL DEFAULT '1',
  `h12` tinyint(1) DEFAULT '1',
  `h13` tinyint(1) DEFAULT '1',
  `h14` tinyint(1) DEFAULT '1',
  `h15` tinyint(1) DEFAULT '1',
  `h16` tinyint(1) DEFAULT '1',
  `h17` tinyint(1) DEFAULT '1',
  `h18` tinyint(1) DEFAULT '1',
  `h19` tinyint(1) DEFAULT '1',
  `h110` tinyint(1) DEFAULT '1',
  `h111` tinyint(1) DEFAULT '1',
  `h112` tinyint(1) DEFAULT '1',
  `h113` tinyint(1) DEFAULT '1',
  `h114` tinyint(1) DEFAULT '1',
  `h115` tinyint(1) DEFAULT '1',
  `h116` tinyint(1) DEFAULT '1',
  `h117` tinyint(1) DEFAULT '1',
  `h118` tinyint(1) DEFAULT '1',
  `h119` tinyint(1) DEFAULT '1',
  `h120` tinyint(1) DEFAULT '1',
  `h121` tinyint(1) DEFAULT '1',
  `h122` tinyint(1) DEFAULT '1',
  `h123` tinyint(1) DEFAULT '1',
  `h124` tinyint(1) DEFAULT '1',
  `h125` tinyint(1) DEFAULT '1',
  `h126` tinyint(1) DEFAULT '1',
  `h127` tinyint(1) DEFAULT '1',
  `h128` tinyint(1) DEFAULT '1',
  `h129` tinyint(1) DEFAULT '1',
  `h130` tinyint(1) DEFAULT '1',
  `h131` tinyint(1) DEFAULT '1',
  `h132` tinyint(1) DEFAULT '1',
  `h133` tinyint(1) DEFAULT '1',
  `h134` tinyint(1) DEFAULT '1',
  `h135` tinyint(1) DEFAULT '1',
  `h136` tinyint(1) DEFAULT '1',
  `h137` tinyint(1) DEFAULT '1',
  `h138` tinyint(1) DEFAULT '1',
  `h139` tinyint(1) DEFAULT '1',
  `h140` tinyint(1) DEFAULT '1',
  `h141` tinyint(1) DEFAULT '1',
  `h142` tinyint(1) DEFAULT '1',
  `h143` tinyint(1) DEFAULT '1',
  `h144` tinyint(1) DEFAULT '1',
  `h145` tinyint(1) DEFAULT '1',
  `h146` tinyint(1) DEFAULT '1',
  `h147` tinyint(1) DEFAULT '1',
  `h148` tinyint(1) DEFAULT '1',
  `h149` tinyint(1) DEFAULT '1',
  `h150` tinyint(1) DEFAULT '1',
  `h151` tinyint(1) DEFAULT '1',
  `h152` tinyint(1) DEFAULT '1',
  `h153` tinyint(1) DEFAULT '1',
  `h154` tinyint(1) DEFAULT '1',
  `h155` tinyint(1) DEFAULT '1',
  `h156` tinyint(1) DEFAULT '1',
  `h157` tinyint(1) DEFAULT '1',
  `h158` tinyint(1) DEFAULT '1',
  `h159` tinyint(1) DEFAULT '1',
  `h160` tinyint(1) DEFAULT '0',
  `h161` tinyint(1) DEFAULT '0',
  `h162` tinyint(1) DEFAULT '0',
  `h163` tinyint(1) DEFAULT '0',
  `h164` tinyint(1) DEFAULT '0',
  `h165` tinyint(1) DEFAULT '0',
  `h166` tinyint(1) DEFAULT '0',
  `h167` tinyint(1) DEFAULT '0',
  `h168` tinyint(1) DEFAULT '0',
  `h169` tinyint(1) DEFAULT '0',
  `h170` tinyint(1) DEFAULT '0',
  `h171` tinyint(1) DEFAULT '0',
  `h172` tinyint(1) DEFAULT '0',
  `h173` tinyint(1) DEFAULT '0',
  `h21` tinyint(1) DEFAULT '0',
  `h22` tinyint(1) DEFAULT '0',
  `h23` tinyint(1) DEFAULT '0',
  `h24` tinyint(1) DEFAULT '0',
  `h25` tinyint(1) DEFAULT '0',
  `h26` tinyint(1) DEFAULT '0',
  `h27` tinyint(1) DEFAULT '0',
  `h28` tinyint(1) DEFAULT '0',
  `h29` tinyint(1) DEFAULT '0',
  `h210` tinyint(1) DEFAULT '0',
  `h211` tinyint(1) DEFAULT '1',
  `h212` tinyint(1) DEFAULT '1',
  `h213` tinyint(1) DEFAULT '1',
  `h214` tinyint(1) DEFAULT '1',
  `h215` tinyint(1) DEFAULT '1',
  `h216` tinyint(1) DEFAULT '1',
  `h217` tinyint(1) DEFAULT '1',
  `h218` tinyint(1) DEFAULT '1',
  `h219` tinyint(1) DEFAULT '1',
  `h220` tinyint(1) DEFAULT '1',
  `h221` tinyint(1) DEFAULT '1',
  `h222` tinyint(1) DEFAULT '1',
  `h223` tinyint(1) DEFAULT '1',
  `h224` tinyint(1) DEFAULT '1',
  `h225` tinyint(1) DEFAULT '1',
  `h226` tinyint(1) DEFAULT '1',
  `h227` tinyint(1) DEFAULT '1',
  `h228` tinyint(1) DEFAULT '1',
  `h229` tinyint(1) DEFAULT '1',
  `h230` tinyint(1) DEFAULT '1',
  `h231` tinyint(1) DEFAULT '1',
  `h232` tinyint(1) DEFAULT '1',
  `h233` tinyint(1) DEFAULT '1',
  `h234` tinyint(1) DEFAULT '1',
  `h235` tinyint(1) DEFAULT '1',
  `h236` tinyint(1) DEFAULT '1',
  `h237` tinyint(1) DEFAULT '1',
  `h238` tinyint(1) DEFAULT '1',
  `h239` tinyint(1) DEFAULT '1',
  `h240` tinyint(1) DEFAULT '1',
  `h241` tinyint(1) DEFAULT '1',
  `h242` tinyint(1) DEFAULT '1',
  `h243` tinyint(1) DEFAULT '1',
  `h244` tinyint(1) DEFAULT '1',
  `h245` tinyint(1) DEFAULT '1',
  `h246` tinyint(1) DEFAULT '1',
  `h247` tinyint(1) DEFAULT '1',
  `h248` tinyint(1) DEFAULT '1',
  `h249` tinyint(1) DEFAULT '1',
  `h250` tinyint(1) DEFAULT '1',
  `h251` tinyint(1) DEFAULT '1',
  `h252` tinyint(1) DEFAULT '1',
  `h253` tinyint(1) DEFAULT '1',
  `h254` tinyint(1) DEFAULT '1',
  `h255` tinyint(1) DEFAULT '1',
  `h256` tinyint(1) DEFAULT '1',
  `h257` tinyint(1) DEFAULT '1',
  `h258` tinyint(1) DEFAULT '1',
  `h259` tinyint(1) DEFAULT '1',
  `h260` tinyint(1) DEFAULT '0',
  `h261` tinyint(1) DEFAULT '0',
  `h262` tinyint(1) DEFAULT '0',
  `h263` tinyint(1) DEFAULT '0',
  `h264` tinyint(1) DEFAULT '0',
  `h265` tinyint(1) DEFAULT '0',
  `h266` tinyint(1) DEFAULT '0',
  `h267` tinyint(1) DEFAULT '0',
  `h268` tinyint(1) DEFAULT '0',
  `h269` tinyint(1) DEFAULT '0',
  `h270` tinyint(1) DEFAULT '0',
  `h271` tinyint(1) DEFAULT '0',
  `h272` tinyint(1) DEFAULT '0',
  `h273` tinyint(1) DEFAULT '0',
  `h31` tinyint(1) DEFAULT '0',
  `h32` tinyint(1) DEFAULT '0',
  `h33` tinyint(1) DEFAULT '0',
  `h34` tinyint(1) DEFAULT '0',
  `h35` tinyint(1) DEFAULT '0',
  `h36` tinyint(1) DEFAULT '0',
  `h37` tinyint(1) DEFAULT '0',
  `h38` tinyint(1) DEFAULT '0',
  `h39` tinyint(1) DEFAULT '0',
  `h310` tinyint(1) DEFAULT '0',
  `h311` tinyint(1) DEFAULT '1',
  `h312` tinyint(1) DEFAULT '1',
  `h313` tinyint(1) DEFAULT '1',
  `h314` tinyint(1) DEFAULT '1',
  `h315` tinyint(1) DEFAULT '1',
  `h316` tinyint(1) DEFAULT '1',
  `h317` tinyint(1) DEFAULT '1',
  `h318` tinyint(1) DEFAULT '1',
  `h319` tinyint(1) DEFAULT '1',
  `h320` tinyint(1) DEFAULT '1',
  `h321` tinyint(1) DEFAULT '1',
  `h322` tinyint(1) DEFAULT '1',
  `h323` tinyint(1) DEFAULT '1',
  `h324` tinyint(1) DEFAULT '1',
  `h325` tinyint(1) DEFAULT '1',
  `h326` tinyint(1) DEFAULT '1',
  `h327` tinyint(1) DEFAULT '1',
  `h328` tinyint(1) DEFAULT '1',
  `h329` tinyint(1) DEFAULT '1',
  `h330` tinyint(1) DEFAULT '1',
  `h331` tinyint(1) DEFAULT '1',
  `h332` tinyint(1) DEFAULT '1',
  `h333` tinyint(1) DEFAULT '1',
  `h334` tinyint(1) DEFAULT '1',
  `h335` tinyint(1) DEFAULT '1',
  `h336` tinyint(1) DEFAULT '1',
  `h337` tinyint(1) DEFAULT '1',
  `h338` tinyint(1) DEFAULT '1',
  `h339` tinyint(1) DEFAULT '1',
  `h340` tinyint(1) DEFAULT '1',
  `h341` tinyint(1) DEFAULT '1',
  `h342` tinyint(1) DEFAULT '1',
  `h343` tinyint(1) DEFAULT '1',
  `h344` tinyint(1) DEFAULT '1',
  `h345` tinyint(1) DEFAULT '1',
  `h346` tinyint(1) DEFAULT '1',
  `h347` tinyint(1) DEFAULT '1',
  `h348` tinyint(1) DEFAULT '1',
  `h349` tinyint(1) DEFAULT '1',
  `h350` tinyint(1) DEFAULT '1',
  `h351` tinyint(1) DEFAULT '1',
  `h352` tinyint(1) DEFAULT '1',
  `h353` tinyint(1) DEFAULT '1',
  `h354` tinyint(1) DEFAULT '1',
  `h355` tinyint(1) DEFAULT '1',
  `h356` tinyint(1) DEFAULT '1',
  `h357` tinyint(1) DEFAULT '1',
  `h358` tinyint(1) DEFAULT '1',
  `h359` tinyint(1) DEFAULT '1',
  `h360` tinyint(1) DEFAULT '0',
  `h361` tinyint(1) DEFAULT '0',
  `h362` tinyint(1) DEFAULT '0',
  `h363` tinyint(1) DEFAULT '0',
  `h364` tinyint(1) DEFAULT '0',
  `h365` tinyint(1) DEFAULT '0',
  `h366` tinyint(1) DEFAULT '0',
  `h367` tinyint(1) DEFAULT '0',
  `h368` tinyint(1) DEFAULT '0',
  `h369` tinyint(1) DEFAULT '0',
  `h370` tinyint(1) DEFAULT '0',
  `h371` tinyint(1) DEFAULT '0',
  `h372` tinyint(1) DEFAULT '0',
  `h373` tinyint(1) DEFAULT '0',
  `h41` tinyint(1) DEFAULT '0',
  `h42` tinyint(1) DEFAULT '0',
  `h43` tinyint(1) DEFAULT '0',
  `h44` tinyint(1) DEFAULT '0',
  `h45` tinyint(1) DEFAULT '0',
  `h46` tinyint(1) DEFAULT '0',
  `h47` tinyint(1) DEFAULT '0',
  `h48` tinyint(1) DEFAULT '0',
  `h49` tinyint(1) DEFAULT '0',
  `h410` tinyint(1) DEFAULT '0',
  `h411` tinyint(1) DEFAULT '1',
  `h412` tinyint(1) DEFAULT '1',
  `h413` tinyint(1) DEFAULT '1',
  `h414` tinyint(1) DEFAULT '1',
  `h415` tinyint(1) DEFAULT '1',
  `h416` tinyint(1) DEFAULT '1',
  `h417` tinyint(1) DEFAULT '1',
  `h418` tinyint(1) DEFAULT '1',
  `h419` tinyint(1) DEFAULT '1',
  `h420` tinyint(1) DEFAULT '1',
  `h421` tinyint(1) DEFAULT '1',
  `h422` tinyint(1) DEFAULT '1',
  `h423` tinyint(1) DEFAULT '1',
  `h424` tinyint(1) DEFAULT '1',
  `h425` tinyint(1) DEFAULT '1',
  `h426` tinyint(1) DEFAULT '1',
  `h427` tinyint(1) DEFAULT '1',
  `h428` tinyint(1) DEFAULT '1',
  `h429` tinyint(1) DEFAULT '1',
  `h430` tinyint(1) DEFAULT '1',
  `h431` tinyint(1) DEFAULT '1',
  `h432` tinyint(1) DEFAULT '1',
  `h433` tinyint(1) DEFAULT '1',
  `h434` tinyint(1) DEFAULT '1',
  `h435` tinyint(1) DEFAULT '1',
  `h436` tinyint(1) DEFAULT '1',
  `h437` tinyint(1) DEFAULT '1',
  `h438` tinyint(1) DEFAULT '1',
  `h439` tinyint(1) DEFAULT '1',
  `h440` tinyint(1) DEFAULT '1',
  `h441` tinyint(1) DEFAULT '1',
  `h442` tinyint(1) DEFAULT '1',
  `h443` tinyint(1) DEFAULT '1',
  `h444` tinyint(1) DEFAULT '1',
  `h445` tinyint(1) DEFAULT '1',
  `h446` tinyint(1) DEFAULT '1',
  `h447` tinyint(1) DEFAULT '1',
  `h448` tinyint(1) DEFAULT '1',
  `h449` tinyint(1) DEFAULT '1',
  `h450` tinyint(1) DEFAULT '1',
  `h451` tinyint(1) DEFAULT '1',
  `h452` tinyint(1) DEFAULT '1',
  `h453` tinyint(1) DEFAULT '1',
  `h454` tinyint(1) DEFAULT '1',
  `h455` tinyint(1) DEFAULT '1',
  `h456` tinyint(1) DEFAULT '1',
  `h457` tinyint(1) DEFAULT '1',
  `h458` tinyint(1) DEFAULT '1',
  `h459` tinyint(1) DEFAULT '1',
  `h460` tinyint(1) DEFAULT '0',
  `h461` tinyint(1) DEFAULT '0',
  `h462` tinyint(1) DEFAULT '0',
  `h463` tinyint(1) DEFAULT '0',
  `h464` tinyint(1) DEFAULT '0',
  `h465` tinyint(1) DEFAULT '0',
  `h466` tinyint(1) DEFAULT '0',
  `h467` tinyint(1) DEFAULT '0',
  `h468` tinyint(1) DEFAULT '0',
  `h469` tinyint(1) DEFAULT '0',
  `h470` tinyint(1) DEFAULT '0',
  `h471` tinyint(1) DEFAULT '0',
  `h472` tinyint(1) DEFAULT '0',
  `h473` tinyint(1) DEFAULT '0',
  `h51` tinyint(1) DEFAULT '0',
  `h52` tinyint(1) DEFAULT '0',
  `h53` tinyint(1) DEFAULT '0',
  `h54` tinyint(1) DEFAULT '0',
  `h55` tinyint(1) DEFAULT '0',
  `h56` tinyint(1) DEFAULT '0',
  `h57` tinyint(1) DEFAULT '0',
  `h58` tinyint(1) DEFAULT '0',
  `h59` tinyint(1) DEFAULT '0',
  `h510` tinyint(1) DEFAULT '0',
  `h511` tinyint(1) DEFAULT '1',
  `h512` tinyint(1) DEFAULT '1',
  `h513` tinyint(1) DEFAULT '1',
  `h514` tinyint(1) DEFAULT '1',
  `h515` tinyint(1) DEFAULT '1',
  `h516` tinyint(1) DEFAULT '1',
  `h517` tinyint(1) DEFAULT '1',
  `h518` tinyint(1) DEFAULT '1',
  `h519` tinyint(1) DEFAULT '1',
  `h520` tinyint(1) DEFAULT '1',
  `h521` tinyint(1) DEFAULT '1',
  `h522` tinyint(1) DEFAULT '1',
  `h523` tinyint(1) DEFAULT '1',
  `h524` tinyint(1) DEFAULT '1',
  `h525` tinyint(1) DEFAULT '1',
  `h526` tinyint(1) DEFAULT '1',
  `h527` tinyint(1) DEFAULT '1',
  `h528` tinyint(1) DEFAULT '1',
  `h529` tinyint(1) DEFAULT '1',
  `h530` tinyint(1) DEFAULT '1',
  `h531` tinyint(1) DEFAULT '1',
  `h532` tinyint(1) DEFAULT '1',
  `h533` tinyint(1) DEFAULT '1',
  `h534` tinyint(1) DEFAULT '1',
  `h535` tinyint(1) DEFAULT '1',
  `h536` tinyint(1) DEFAULT '1',
  `h537` tinyint(1) DEFAULT '1',
  `h538` tinyint(1) DEFAULT '1',
  `h539` tinyint(1) DEFAULT '1',
  `h540` tinyint(1) DEFAULT '1',
  `h541` tinyint(1) DEFAULT '1',
  `h542` tinyint(1) DEFAULT '1',
  `h543` tinyint(1) DEFAULT '1',
  `h544` tinyint(1) DEFAULT '1',
  `h545` tinyint(1) DEFAULT '1',
  `h546` tinyint(1) DEFAULT '1',
  `h547` tinyint(1) DEFAULT '1',
  `h548` tinyint(1) DEFAULT '1',
  `h549` tinyint(1) DEFAULT '1',
  `h550` tinyint(1) DEFAULT '1',
  `h551` tinyint(1) DEFAULT '1',
  `h552` tinyint(1) DEFAULT '1',
  `h553` tinyint(1) DEFAULT '1',
  `h554` tinyint(1) DEFAULT '1',
  `h555` tinyint(1) DEFAULT '1',
  `h556` tinyint(1) DEFAULT '1',
  `h557` tinyint(1) DEFAULT '1',
  `h558` tinyint(1) DEFAULT '1',
  `h559` tinyint(1) DEFAULT '1',
  `h560` tinyint(1) DEFAULT '0',
  `h561` tinyint(1) DEFAULT '0',
  `h562` tinyint(1) DEFAULT '0',
  `h563` tinyint(1) DEFAULT '0',
  `h564` tinyint(1) DEFAULT '0',
  `h565` tinyint(1) DEFAULT '0',
  `h566` tinyint(1) DEFAULT '0',
  `h567` tinyint(1) DEFAULT '0',
  `h568` tinyint(1) DEFAULT '0',
  `h569` tinyint(1) DEFAULT '0',
  `h570` tinyint(1) DEFAULT '0',
  `h571` tinyint(1) DEFAULT '0',
  `h572` tinyint(1) DEFAULT '0',
  `h573` tinyint(1) DEFAULT '0',
  `h61` tinyint(1) DEFAULT '0',
  `h62` tinyint(1) DEFAULT '0',
  `h63` tinyint(1) DEFAULT '0',
  `h64` tinyint(1) DEFAULT '0',
  `h65` tinyint(1) DEFAULT '0',
  `h66` tinyint(1) DEFAULT '0',
  `h67` tinyint(1) DEFAULT '0',
  `h68` tinyint(1) DEFAULT '0',
  `h69` tinyint(1) DEFAULT '0',
  `h610` tinyint(1) DEFAULT '0',
  `h611` tinyint(1) DEFAULT '1',
  `h612` tinyint(1) DEFAULT '1',
  `h613` tinyint(1) DEFAULT '1',
  `h614` tinyint(1) DEFAULT '1',
  `h615` tinyint(1) DEFAULT '1',
  `h616` tinyint(1) DEFAULT '1',
  `h617` tinyint(1) DEFAULT '1',
  `h618` tinyint(1) DEFAULT '1',
  `h619` tinyint(1) DEFAULT '1',
  `h620` tinyint(1) DEFAULT '1',
  `h621` tinyint(1) DEFAULT '1',
  `h622` tinyint(1) DEFAULT '1',
  `h623` tinyint(1) DEFAULT '1',
  `h624` tinyint(1) DEFAULT '1',
  `h625` tinyint(1) DEFAULT '1',
  `h626` tinyint(1) DEFAULT '1',
  `h627` tinyint(1) DEFAULT '1',
  `h628` tinyint(1) DEFAULT '1',
  `h629` tinyint(1) DEFAULT '1',
  `h630` tinyint(1) DEFAULT '1',
  `h631` tinyint(1) DEFAULT '1',
  `h632` tinyint(1) DEFAULT '1',
  `h633` tinyint(1) DEFAULT '1',
  `h634` tinyint(1) DEFAULT '1',
  `h635` tinyint(1) DEFAULT '1',
  `h636` tinyint(1) DEFAULT '1',
  `h637` tinyint(1) DEFAULT '1',
  `h638` tinyint(1) DEFAULT '1',
  `h639` tinyint(1) DEFAULT '1',
  `h640` tinyint(1) DEFAULT '1',
  `h641` tinyint(1) DEFAULT '1',
  `h642` tinyint(1) DEFAULT '1',
  `h643` tinyint(1) DEFAULT '1',
  `h644` tinyint(1) DEFAULT '1',
  `h645` tinyint(1) DEFAULT '1',
  `h646` tinyint(1) DEFAULT '1',
  `h647` tinyint(1) DEFAULT '1',
  `h648` tinyint(1) DEFAULT '1',
  `h649` tinyint(1) DEFAULT '1',
  `h650` tinyint(1) DEFAULT '0',
  `h651` tinyint(1) DEFAULT '0',
  `h652` tinyint(1) DEFAULT '0',
  `h653` tinyint(1) DEFAULT '0',
  `h654` tinyint(1) DEFAULT '0',
  `h655` tinyint(1) DEFAULT '0',
  `h656` tinyint(1) DEFAULT '0',
  `h657` tinyint(1) DEFAULT '0',
  `h658` tinyint(1) DEFAULT '0',
  `h659` tinyint(1) DEFAULT '0',
  `h660` tinyint(1) DEFAULT '0',
  `h661` tinyint(1) DEFAULT '0',
  `h662` tinyint(1) DEFAULT '0',
  `h663` tinyint(1) DEFAULT '0',
  `h664` tinyint(1) DEFAULT '0',
  `h665` tinyint(1) DEFAULT '0',
  `h666` tinyint(1) DEFAULT '0',
  `h667` tinyint(1) DEFAULT '0',
  `h668` tinyint(1) DEFAULT '0',
  `h669` tinyint(1) DEFAULT '0',
  `h670` tinyint(1) DEFAULT '0',
  `h671` tinyint(1) DEFAULT '0',
  `h672` tinyint(1) DEFAULT '0',
  `h673` tinyint(1) DEFAULT '0',
  `h71` tinyint(1) DEFAULT '0',
  `h72` tinyint(1) DEFAULT '0',
  `h73` tinyint(1) DEFAULT '0',
  `h74` tinyint(1) DEFAULT '0',
  `h75` tinyint(1) DEFAULT '0',
  `h76` tinyint(1) DEFAULT '0',
  `h77` tinyint(1) DEFAULT '0',
  `h78` tinyint(1) DEFAULT '0',
  `h79` tinyint(1) DEFAULT '0',
  `h710` tinyint(1) DEFAULT '0',
  `h711` tinyint(1) DEFAULT '0',
  `h712` tinyint(1) DEFAULT '0',
  `h713` tinyint(1) DEFAULT '0',
  `h714` tinyint(1) DEFAULT '0',
  `h715` tinyint(1) DEFAULT '0',
  `h716` tinyint(1) DEFAULT '0',
  `h717` tinyint(1) DEFAULT '0',
  `h718` tinyint(1) DEFAULT '0',
  `h719` tinyint(1) DEFAULT '0',
  `h720` tinyint(1) DEFAULT '0',
  `h721` tinyint(1) DEFAULT '0',
  `h722` tinyint(1) DEFAULT '0',
  `h723` tinyint(1) DEFAULT '0',
  `h724` tinyint(1) DEFAULT '0',
  `h725` tinyint(1) DEFAULT '0',
  `h726` tinyint(1) DEFAULT '0',
  `h727` tinyint(1) DEFAULT '0',
  `h728` tinyint(1) DEFAULT '0',
  `h729` tinyint(1) DEFAULT '0',
  `h730` tinyint(1) DEFAULT '0',
  `h731` tinyint(1) DEFAULT '0',
  `h732` tinyint(1) DEFAULT '0',
  `h733` tinyint(1) DEFAULT '0',
  `h734` tinyint(1) DEFAULT '0',
  `h735` tinyint(1) DEFAULT '0',
  `h736` tinyint(1) DEFAULT '0',
  `h737` tinyint(1) DEFAULT '0',
  `h738` tinyint(1) DEFAULT '0',
  `h739` tinyint(1) DEFAULT '0',
  `h740` tinyint(1) DEFAULT '0',
  `h741` tinyint(1) DEFAULT '0',
  `h742` tinyint(1) DEFAULT '0',
  `h743` tinyint(4) DEFAULT '1',
  `h744` tinyint(1) DEFAULT '0',
  `h745` tinyint(1) DEFAULT '0',
  `h746` tinyint(1) DEFAULT '0',
  `h747` tinyint(1) DEFAULT '0',
  `h748` tinyint(1) DEFAULT '0',
  `h749` tinyint(1) DEFAULT '0',
  `h750` tinyint(1) DEFAULT '0',
  `h751` tinyint(1) DEFAULT '0',
  `h752` tinyint(1) DEFAULT '0',
  `h753` tinyint(1) DEFAULT '0',
  `h754` tinyint(1) DEFAULT '0',
  `h755` tinyint(1) DEFAULT '0',
  `h756` tinyint(1) DEFAULT '0',
  `h757` tinyint(1) DEFAULT '0',
  `h758` tinyint(1) DEFAULT '0',
  `h759` tinyint(1) DEFAULT '0',
  `h760` tinyint(1) DEFAULT '0',
  `h761` tinyint(1) DEFAULT '0',
  `h762` tinyint(1) DEFAULT '0',
  `h763` tinyint(1) DEFAULT '0',
  `h764` tinyint(1) DEFAULT '0',
  `h765` tinyint(1) DEFAULT '0',
  `h766` tinyint(1) DEFAULT '0',
  `h767` tinyint(1) DEFAULT '0',
  `h768` tinyint(1) DEFAULT '0',
  `h769` tinyint(1) DEFAULT '0',
  `h770` tinyint(1) DEFAULT '0',
  `h771` tinyint(1) DEFAULT '0',
  `h772` tinyint(1) DEFAULT '0',
  `h773` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notas`
--

DROP TABLE IF EXISTS `notas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notas` (
  `Id` int(50) NOT NULL AUTO_INCREMENT,
  `Nota` longtext CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha` date NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tblreseteopass`
--

DROP TABLE IF EXISTS `tblreseteopass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tblreseteopass` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idusuario` int(10) NOT NULL,
  `token` varchar(64) NOT NULL,
  `creado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` tinytext CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Email` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `Pass` varchar(50) CHARACTER SET latin1 NOT NULL,
  `Tel` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `Admin` tinyint(1) NOT NULL DEFAULT '0',
  `Obs` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `Block` tinyint(1) DEFAULT NULL,
  `Baja` tinyint(1) NOT NULL DEFAULT '0',
  `Active` tinyint(4) NOT NULL DEFAULT '0',
  `datePass` date NOT NULL,
  `cookie` int(11) NOT NULL,
  `Idioma` tinyint(1) NOT NULL DEFAULT '1',
  `dateReg` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dateBaja` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-22 18:19:09
