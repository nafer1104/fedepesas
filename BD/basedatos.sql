/*
SQLyog Enterprise - MySQL GUI v7.13 
MySQL - 5.6.21 : Database - dbfedepesas
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbfedepesas` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `dbfedepesas`;

/*Table structure for table `atleta` */

DROP TABLE IF EXISTS `atleta`;

CREATE TABLE `atleta` (
  `codPersona` varchar(10) NOT NULL,
  `peso` int(3) DEFAULT NULL,
  `codCategoria` varchar(10) DEFAULT NULL,
  `codEntrenador` varchar(10) DEFAULT NULL,
  `codLiga` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`codPersona`),
  KEY `FK_AtletaLiga` (`codLiga`),
  KEY `FK_AtletaCategoria` (`codCategoria`),
  KEY `FK_AtletaEntrenador` (`codEntrenador`),
  CONSTRAINT `FK_AtletaCategoria` FOREIGN KEY (`codCategoria`) REFERENCES `categoria` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_AtletaEntrenador` FOREIGN KEY (`codEntrenador`) REFERENCES `entrenador` (`codPersona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_AtletaLiga` FOREIGN KEY (`codLiga`) REFERENCES `liga` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_AtletaPersona` FOREIGN KEY (`codPersona`) REFERENCES `persona` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `atleta` */

/*Table structure for table `categoria` */

DROP TABLE IF EXISTS `categoria`;

CREATE TABLE `categoria` (
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `peso` int(3) DEFAULT NULL,
  `codRama` varchar(10) DEFAULT NULL,
  `codTipo` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FK_CategoriaTipoCategoria` (`codTipo`),
  KEY `FK_CategoriaRama` (`codRama`),
  CONSTRAINT `FK_CategoriaRama` FOREIGN KEY (`codRama`) REFERENCES `rama` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_CategoriaTipoCategoria` FOREIGN KEY (`codTipo`) REFERENCES `tipocategoria` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `categoria` */

/*Table structure for table `entrenador` */

DROP TABLE IF EXISTS `entrenador`;

CREATE TABLE `entrenador` (
  `codPersona` varchar(10) NOT NULL,
  PRIMARY KEY (`codPersona`),
  CONSTRAINT `FK_EntrenadorPersona` FOREIGN KEY (`codPersona`) REFERENCES `persona` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `entrenador` */

/*Table structure for table `evento` */

DROP TABLE IF EXISTS `evento`;

CREATE TABLE `evento` (
  `codigo` varchar(10) NOT NULL,
  `fechaEvento` date NOT NULL,
  `codDepartamneto` varchar(10) NOT NULL,
  `codCiudad` varchar(10) NOT NULL,
  `direccionVeriDefi` varchar(250) DEFAULT NULL,
  `direccionCompe` varchar(250) DEFAULT NULL,
  `direccionEntrena` varchar(250) DEFAULT NULL,
  `condFinancieras` varchar(250) DEFAULT NULL,
  `alojaTransporte` varchar(250) DEFAULT NULL,
  `mediosAcreditacion` varchar(250) DEFAULT NULL,
  `formInscripcionPre` varchar(250) DEFAULT 'Podria ser el codigo del archivo pdf o una plantilla html',
  `formInscripcionFinal` varchar(250) DEFAULT 'Podria ser el codigo del archivo pdf o una plantilla html',
  `nota` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `evento` */

/*Table structure for table `inscripcion` */

DROP TABLE IF EXISTS `inscripcion`;

CREATE TABLE `inscripcion` (
  `codigo` varchar(10) NOT NULL,
  `codAtleta` varchar(10) DEFAULT NULL,
  `tipo` varchar(5) DEFAULT NULL,
  `sorteo` int(11) DEFAULT NULL,
  `codEvento` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FK_inscripcionAtletas` (`codAtleta`),
  KEY `FK_inscripcionEventos` (`codEvento`),
  CONSTRAINT `FK_inscripcionAtletas` FOREIGN KEY (`codAtleta`) REFERENCES `atleta` (`codPersona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_inscripcionEventos` FOREIGN KEY (`codEvento`) REFERENCES `evento` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `inscripcion` */

/*Table structure for table `jueces` */

DROP TABLE IF EXISTS `jueces`;

CREATE TABLE `jueces` (
  `codigo` varchar(10) NOT NULL,
  `codPersona` varchar(10) NOT NULL,
  `codTipo` varchar(10) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FK_JuecesTipoJuz` (`codTipo`),
  CONSTRAINT `FK_JuecesTipoJuz` FOREIGN KEY (`codTipo`) REFERENCES `tipojuez` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `jueces` */

/*Table structure for table `juecesevento` */

DROP TABLE IF EXISTS `juecesevento`;

CREATE TABLE `juecesevento` (
  `codJuez` varchar(10) NOT NULL,
  `codEvento` varchar(10) NOT NULL,
  PRIMARY KEY (`codJuez`,`codEvento`),
  KEY `FK_JuecesEvento` (`codEvento`),
  CONSTRAINT `FK_JuecesEvento` FOREIGN KEY (`codEvento`) REFERENCES `evento` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_JuecesEventoJueces` FOREIGN KEY (`codJuez`) REFERENCES `jueces` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `juecesevento` */

/*Table structure for table `liga` */

DROP TABLE IF EXISTS `liga`;

CREATE TABLE `liga` (
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `abreviatura` varchar(5) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `liga` */

/*Table structure for table `participantes` */

DROP TABLE IF EXISTS `participantes`;

CREATE TABLE `participantes` (
  `codRama` varchar(10) NOT NULL,
  `codAtleta` varchar(10) NOT NULL,
  `codEvento` varchar(10) NOT NULL,
  PRIMARY KEY (`codRama`,`codAtleta`,`codEvento`),
  KEY `FK_ParticipantesEventos` (`codEvento`),
  KEY `FK_ParticipantesAtletas` (`codAtleta`),
  CONSTRAINT `FK_ParticipantesAtletas` FOREIGN KEY (`codAtleta`) REFERENCES `atleta` (`codPersona`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ParticipantesEventos` FOREIGN KEY (`codEvento`) REFERENCES `evento` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ParticipantesRama` FOREIGN KEY (`codRama`) REFERENCES `rama` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `participantes` */

/*Table structure for table `persona` */

DROP TABLE IF EXISTS `persona`;

CREATE TABLE `persona` (
  `codigo` varchar(10) NOT NULL,
  `nombre1` varchar(40) DEFAULT NULL,
  `nombre2` varchar(40) DEFAULT NULL,
  `apellido1` varchar(40) DEFAULT NULL,
  `apellido2` varchar(40) DEFAULT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `genero` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `persona` */

/*Table structure for table `rama` */

DROP TABLE IF EXISTS `rama`;

CREATE TABLE `rama` (
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `rama` */

/*Table structure for table `tipocategoria` */

DROP TABLE IF EXISTS `tipocategoria`;

CREATE TABLE `tipocategoria` (
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tipocategoria` */

/*Table structure for table `tipojuez` */

DROP TABLE IF EXISTS `tipojuez`;

CREATE TABLE `tipojuez` (
  `codigo` varchar(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nomenclatura` varchar(5) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tipojuez` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
