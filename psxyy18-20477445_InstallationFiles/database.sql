-- MySQL dump 10.13  Distrib 5.6.24, for Win32 (x86)
--
-- Host: mysql.cs.nott.ac.uk    Database: psxyy18
-- ------------------------------------------------------
-- Server version	5.5.60-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Fines`
--

DROP TABLE IF EXISTS `Fines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Fines` (
  `Fine_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Fine_Amount` int(11) NOT NULL,
  `Fine_Points` int(11) NOT NULL,
  `Incident_ID` int(11) NOT NULL,
  PRIMARY KEY (`Fine_ID`),
  KEY `Incident_ID` (`Incident_ID`),
  CONSTRAINT `fk_fines` FOREIGN KEY (`Incident_ID`) REFERENCES `Incident` (`Incident_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Fines`
--

INSERT INTO `Fines` (`Fine_ID`, `Fine_Amount`, `Fine_Points`, `Incident_ID`) VALUES (1,2000,6,3),(2,50,0,2),(3,500,3,4),(4,222,12,1);

--
-- Table structure for table `Incident`
--

DROP TABLE IF EXISTS `Incident`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Incident` (
  `Incident_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Vehicle_ID` int(11) DEFAULT NULL,
  `People_ID` int(11) DEFAULT NULL,
  `Incident_Date` date DEFAULT NULL,
  `Incident_Report` varchar(500) DEFAULT NULL,
  `Offence_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Incident_ID`),
  KEY `fk_incident_vehicle` (`Vehicle_ID`),
  KEY `fk_incident_people` (`People_ID`),
  KEY `fk_incident_offence` (`Offence_ID`),
  CONSTRAINT `fk_incident_offence` FOREIGN KEY (`Offence_ID`) REFERENCES `Offence` (`Offence_ID`),
  CONSTRAINT `fk_incident_people` FOREIGN KEY (`People_ID`) REFERENCES `People` (`People_ID`),
  CONSTRAINT `fk_incident_vehicle` FOREIGN KEY (`Vehicle_ID`) REFERENCES `Vehicle` (`Vehicle_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Incident`
--

INSERT INTO `Incident` (`Incident_ID`, `Vehicle_ID`, `People_ID`, `Incident_Date`, `Incident_Report`, `Offence_ID`) VALUES (1,15,4,'2017-12-01','40mph in a 30 limit',1),(2,20,8,'2017-11-01','Double parked',4),(3,13,4,'2017-09-17','110mph on motorway',1),(4,14,2,'2017-08-22','Failure to stop at a red light - travelling 25mph',8),(5,13,4,'2017-10-17','Not wearing a seatbelt on the M1',3),(6,80,31,'2022-10-01','dunk on Rudy Gobert',1);

--
-- Table structure for table `Offence`
--

DROP TABLE IF EXISTS `Offence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Offence` (
  `Offence_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Offence_description` varchar(50) NOT NULL,
  `Offence_maxFine` int(11) NOT NULL,
  `Offence_maxPoints` int(11) NOT NULL,
  PRIMARY KEY (`Offence_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Offence`
--

INSERT INTO `Offence` (`Offence_ID`, `Offence_description`, `Offence_maxFine`, `Offence_maxPoints`) VALUES (1,'Speeding',1000,3),(2,'Speeding on a motorway',2500,6),(3,'Seat belt offence',500,0),(4,'Illegal parking',500,0),(5,'Drink driving',10000,11),(7,'Driving without a licence',10000,0),(8,'Traffic light offences',1000,3),(9,'Cycling on pavement',500,0),(10,'Failure to have control of vehicle',1000,3),(11,'Dangerous driving',1000,11),(12,'Careless driving',5000,6);

--
-- Table structure for table `Ownership`
--

DROP TABLE IF EXISTS `Ownership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Ownership` (
  `People_ID` int(11) NOT NULL,
  `Vehicle_ID` int(11) NOT NULL,
  KEY `fk_people` (`People_ID`),
  KEY `fk_vehicle` (`Vehicle_ID`),
  CONSTRAINT `fk_person` FOREIGN KEY (`People_ID`) REFERENCES `People` (`People_ID`),
  CONSTRAINT `fk_vehicle` FOREIGN KEY (`Vehicle_ID`) REFERENCES `Vehicle` (`Vehicle_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ownership`
--

INSERT INTO `Ownership` (`People_ID`, `Vehicle_ID`) VALUES (3,12),(8,20),(4,15),(4,13),(1,16),(2,14),(5,17),(6,18),(7,21),(26,77),(28,79);

--
-- Table structure for table `People`
--

DROP TABLE IF EXISTS `People`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `People` (
  `People_ID` int(11) NOT NULL AUTO_INCREMENT,
  `People_name` varchar(65) NOT NULL,
  `People_address` varchar(65) DEFAULT NULL,
  `People_licence` varchar(65) DEFAULT NULL,
  PRIMARY KEY (`People_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `People`
--

INSERT INTO `People` (`People_ID`, `People_name`, `People_address`, `People_licence`) VALUES (1,'James Smith','23 Barnsdale Road, Leicester','SMITH92LDOFJJ829'),(2,'Jennifer Allen','46 Bramcote Drive, Nottingham','ALLEN88K23KLR9B3'),(3,'John Myers','323 Derby Road, Nottingham','MYERS99JDW8REWL3'),(4,'James Smith','26 Devonshire Avenue, Nottingham','SMITHR004JFS20TR'),(5,'Terry Brown','7 Clarke Rd, Nottingham','BROWND3PJJ39DLFG'),(6,'Mary Adams','38 Thurman St, Nottingham','ADAMSH9O3JRHH107'),(7,'Neil Becker','6 Fairfax Close, Nottingham','BECKE88UPR840F9R'),(8,'Angela Smith','30 Avenue Road, Grantham','SMITH222LE9FJ5DS'),(9,'Xene Medora','22 House Drive, West Bridgford','MEDORH914ANBB223'),(26,'Paul George','Los Angeles ','PaulGeorgeclippers13'),(28,'LuKa Doncic','Dallas','LukaDoncic77'),(29,'Lebron James','Los Angeles','LosAngelesLakers23&6'),(31,'Russel Westbrook','Los Angeles','LosAngelesLakers0tripledouble'),(32,'Kobe Bryant','Los Angeles','LosAngelesLakers24'),(33,'Jimmy Butler','Miamiheatstreet','miamiheatbutler'),(34,'KawhiLeonardtest','Canada Torontotest','raptorkawhi2test'),(35,'Chris Paul','Phoneix','chrispaul3nochamp');

--
-- Table structure for table `Vehicle`
--

DROP TABLE IF EXISTS `Vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Vehicle` (
  `Vehicle_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Vehicle_type` varchar(20) NOT NULL,
  `Vehicle_colour` varchar(20) NOT NULL,
  `Vehicle_licence` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Vehicle_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Vehicle`
--

INSERT INTO `Vehicle` (`Vehicle_ID`, `Vehicle_type`, `Vehicle_colour`, `Vehicle_licence`) VALUES (12,'Ford Fiesta','Blue','LB15AJL'),(13,'Ferrari 458','Red','MY64PRE'),(14,'Vauxhall Astra','Silver','FD65WPQ'),(15,'Honda Civic','Green','FJ17AUG'),(16,'Toyota Prius','Silver','FP16KKE'),(17,'Ford Mondeo','Black','FP66KLM'),(18,'Ford Focus','White','DJ14SLE'),(20,'Nissan Pulsar','Red','NY64KWD'),(21,'Renault Scenic','Silver','BC16OEA'),(22,'Hyundai i30','Grey','AD223NG'),(77,'Porsche 918 spyder','Blue','PaulGeorge13'),(79,'Ferrari 458 Italia','red','LukaDoncic'),(80,'Ferrari 458 Italia','Blue','BlueFerraritest');

--
-- Table structure for table `audit_trail`
--

DROP TABLE IF EXISTS `audit_trail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_trail` (
  `Time` datetime DEFAULT NULL,
  `User` varchar(45) DEFAULT NULL,
  `Action` varchar(45) DEFAULT NULL,
  `Record_ID` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Record_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=242 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`Time`, `User`, `Action`, `Record_ID`) VALUES ('2022-12-16 16:01:31','daniels','insert',1),('2022-12-16 16:18:59','daniels','insert',9),('2022-12-16 16:25:05','daniels','insert',10),('2022-12-16 16:27:28','daniels','login',11),('2022-12-16 16:27:39','mcnulty','login',12),('2022-12-16 16:27:46','daniels','login',13),('2022-12-16 16:31:17','daniels','login',14),('2022-12-16 16:31:27','daniels','login',15),('2022-12-16 16:32:15','daniels','login',16),('2022-12-16 16:32:30','daniels','login',17),('2022-12-16 17:58:08','mcnulty','login',18),('2022-12-16 18:35:32','daniels','login',19),('2022-12-16 20:39:45','daniels','insertion into table incident',20),('2022-12-16 20:40:57','daniels','insertion into table incident',21),('2022-12-16 20:41:16','daniels','insertion into table incident',22),('2022-12-16 20:50:37','daniels','insertion into table incident',23),('2022-12-16 20:54:46','daniels','insertion into table incident',24),('2022-12-17 00:38:31','daniels','update of record with ID 8 in table Incident_',25),('2022-12-17 00:47:03','daniels','update of record with ID 8 in table Incident_',26),('2022-12-17 00:51:14','daniels','update of record with ID 8 in table Incident_',27),('2022-12-17 01:10:37','daniels','update of record with ID  in table Incident_r',28),('2022-12-17 16:50:06','mcnulty','login',29),('2022-12-17 18:17:13','mcnulty','update record in table Incident',30),('2022-12-17 18:22:37','mcnulty','update record in table Incident',31),('2022-12-17 19:49:01','mcnulty','access to table Vehicle,People,Ownership',32),('2022-12-17 19:49:01','mcnulty','access to table Vehicle,People,Ownership',33),('2022-12-17 19:49:01','mcnulty','access to table Vehicle,People,Ownership',34),('2022-12-17 19:49:01','mcnulty','access to table Vehicle,People,Ownership',35),('2022-12-17 19:49:01','mcnulty','access to table Vehicle,People,Ownership',36),('2022-12-17 19:51:58','mcnulty','access to table People',37),('2022-12-17 19:52:00','mcnulty','access to table People',38),('2022-12-17 19:52:03','mcnulty','access to table People',39),('2022-12-17 19:52:15','mcnulty','update record in table People',40),('2022-12-17 19:52:55','daniels','login',41),('2022-12-17 19:54:09','daniels','access to table Vehicle,People,Ownership',42),('2022-12-17 19:54:09','daniels','access to table Vehicle,People,Ownership',43),('2022-12-17 19:54:09','daniels','access to table Vehicle,People,Ownership',44),('2022-12-17 19:54:09','daniels','access to table Vehicle,People,Ownership',45),('2022-12-17 19:54:09','daniels','access to table Vehicle,People,Ownership',46),('2022-12-17 19:54:48','daniels','access to table Vehicle,People,Ownership',47),('2022-12-17 19:56:32','daniels','insertion into table People',48),('2022-12-17 19:59:08','daniels','insertion into table People',49),('2022-12-17 20:00:36','daniels','access to table Vehicle,People,Ownership',50),('2022-12-17 20:00:36','daniels','access to table Vehicle,People,Ownership',51),('2022-12-17 20:00:36','daniels','access to table Vehicle,People,Ownership',52),('2022-12-17 20:00:36','daniels','access to table Vehicle,People,Ownership',53),('2022-12-17 20:00:36','daniels','access to table Vehicle,People,Ownership',54),('2022-12-17 20:09:22','daniels','access to table Vehicle,People,Ownership',55),('2022-12-17 20:18:21','daniels','insertion into vehicle table',56),('2022-12-17 20:18:21','daniels','insertion into ownership table',57),('2022-12-17 20:19:39','daniels','insertion into vehicle table',58),('2022-12-17 20:19:39','daniels','insertion into ownership table',59),('2022-12-17 20:20:43','daniels','insertion into vehicle table',60),('2022-12-17 20:20:43','daniels','insertion into ownership table',61),('2022-12-17 20:21:41','daniels','insertion into table People',62),('2022-12-17 20:21:41','daniels','insertion into table incident',63),('2022-12-17 20:23:46','daniels','insertion into table incident',64),('2022-12-17 20:27:23','daniels','access to table Incident',65),('2022-12-17 20:27:35','daniels','update record in table Incident',66),('2022-12-17 20:28:04','daniels','access to table Incident',67),('2022-12-17 20:28:54','daniels','access to table Incident',68),('2022-12-17 20:28:58','daniels','update record in table Incident',69),('2022-12-17 20:28:58','daniels','access to table Incident',70),('2022-12-17 20:29:09','daniels','update record in table Incident',71),('2022-12-17 20:29:09','daniels','access to table Incident',72),('2022-12-17 20:29:16','daniels','update record in table Incident',73),('2022-12-17 20:29:16','daniels','access to table Incident',74),('2022-12-17 20:31:09','daniels','update record in table Incident',75),('2022-12-17 20:31:09','daniels','access to table Incident',76),('2022-12-17 20:34:06','daniels','access to table Incident',77),('2022-12-17 20:34:25','daniels','access to table Incident',78),('2022-12-17 20:35:13','daniels','access to table Incident',79),('2022-12-17 20:35:17','daniels','access to table Incident',80),('2022-12-17 20:35:27','daniels','access to table Incident',81),('2022-12-17 20:35:35','daniels','access to table Incident',82),('2022-12-17 20:35:47','daniels','access to table Incident',83),('2022-12-17 20:35:55','daniels','access to table Incident',84),('2022-12-17 20:36:00','daniels','access to table Incident',85),('2022-12-17 20:36:11','daniels','access to table Incident',86),('2022-12-17 20:37:03','daniels','access to table Incident',87),('2022-12-17 20:37:08','daniels','access to table Incident',88),('2022-12-17 20:38:03','daniels','access to table Incident',89),('2022-12-17 20:38:06','daniels','access to table Incident',90),('2022-12-17 20:38:32','daniels','access to table Incident',91),('2022-12-17 20:38:41','daniels','access to table Incident',92),('2022-12-17 20:38:48','daniels','access to table Incident',93),('2022-12-17 20:38:53','daniels','access to table Incident',94),('2022-12-17 20:39:07','daniels','access to table Incident',95),('2022-12-17 20:39:12','daniels','update record in table Incident',96),('2022-12-17 20:39:12','daniels','access to table Incident',97),('2022-12-17 20:44:31','daniels','access to table Incident',98),('2022-12-17 20:44:35','daniels','access to table Incident',99),('2022-12-17 20:44:40','daniels','access to table Incident',100),('2022-12-17 20:45:55','daniels','access to table Incident',101),('2022-12-17 20:47:10','daniels','access to table Incident',102),('2022-12-17 20:51:21','daniels','add a new officer account',103),('2022-12-17 21:29:40','daniels','insertion to table fine',104),('2022-12-17 21:30:00','daniels','insertion to table fine',105),('2022-12-17 21:33:17','daniels','insertion to table fine',106),('2022-12-17 21:34:15','daniels','insertion to table fine',107),('2022-12-17 21:34:37','daniels','insertion to table fine',108),('2022-12-17 21:34:56','','access to audit trail',109),('2022-12-17 21:36:47','daniels','access to audit trail',110),('2022-12-17 21:37:09','daniels','access to audit trail',111),('2022-12-17 21:41:18','mcnulty','login',112),('2022-12-17 21:41:24','daniels','login',113),('2022-12-17 21:57:23','mcnulty','login',114),('2022-12-17 22:07:20','daniels','login',115),('2022-12-17 22:07:37','daniels','login',116),('2022-12-17 22:11:29','daniels','login',117),('2022-12-17 22:11:40','mcnulty','login',118),('2022-12-17 22:12:09','daniels','login',119),('2022-12-17 22:13:11','mcnulty','login',120),('2022-12-17 22:23:07','mcnulty','login',121),('2022-12-17 22:25:26','daniels','login',122),('2022-12-17 22:25:35','mcnulty','login',123),('2022-12-17 22:26:07','mcnulty','reset_password',124),('2022-12-17 22:26:25','daniels','login',125),('2022-12-17 22:26:33','mcnulty','login',126),('2022-12-17 22:26:41','daniels','login',127),('2022-12-17 22:27:23','mcnulty','login',128),('2022-12-17 22:27:33','daniels','login',129),('2022-12-17 22:29:24','daniels','access to table Incident',130),('2022-12-17 22:29:29','daniels','access to table Incident',131),('2022-12-17 22:30:10','daniels','access to audit trail',132),('2022-12-17 22:32:09','mcnulty','login',133),('2022-12-17 22:32:29','mcnulty','access to table Incident',134),('2022-12-17 22:32:46','daniels','login',135),('2022-12-17 22:33:34','daniels','access to table Incident',136),('2022-12-17 22:36:05','daniels','update record in table People',137),('2022-12-17 22:36:12','daniels','update record in table People',138),('2022-12-17 22:37:23','daniels','access to table People',139),('2022-12-17 22:41:36','daniels','update record in table People',140),('2022-12-17 22:41:52','daniels','update record in table People',141),('2022-12-17 22:44:46','daniels','access to table People',142),('2022-12-17 22:45:15','daniels','insertion into table People',143),('2022-12-17 22:45:26','daniels','update record in table People',144),('2022-12-17 22:48:26','daniels','access to table People',145),('2022-12-17 22:48:36','daniels','update record in table People',146),('2022-12-17 22:48:49','daniels','access to table People',147),('2022-12-17 22:49:21','daniels','insertion into table People',148),('2022-12-17 22:49:39','daniels','access to table Vehicle,People,Ownership',149),('2022-12-17 22:50:07','daniels','insertion into People table',150),('2022-12-17 22:50:07','daniels','insertion into vehicle table',151),('2022-12-17 22:50:07','daniels','insertion into ownership table',152),('2022-12-17 22:52:25','daniels','access to table Vehicle,People,Ownership',153),('2022-12-17 22:52:25','daniels','access to table Vehicle,People,Ownership',154),('2022-12-17 22:54:30','daniels','access to table Vehicle,People,Ownership',155),('2022-12-17 22:54:30','daniels','access to table Vehicle,People,Ownership',156),('2022-12-17 22:54:51','daniels','insertion into People table',157),('2022-12-17 22:54:51','daniels','insertion into vehicle table',158),('2022-12-17 22:54:51','daniels','insertion into ownership table',159),('2022-12-17 22:57:51','daniels','insertion into table incident',160),('2022-12-17 22:58:16','daniels','access to table Incident',161),('2022-12-17 22:58:22','daniels','update record in table Incident',162),('2022-12-17 22:58:22','daniels','access to table Incident',163),('2022-12-17 22:58:31','daniels','update record in table Incident',164),('2022-12-17 22:58:31','daniels','access to table Incident',165),('2022-12-17 22:58:37','daniels','update record in table Incident',166),('2022-12-17 22:58:37','daniels','access to table Incident',167),('2022-12-17 23:10:04','daniels','access to table Incident',168),('2022-12-17 23:10:04','daniels','access to table Incident',169),('2022-12-17 23:26:50','daniels','access to table Incident',170),('2022-12-17 23:26:51','daniels','access to table Incident',171),('2022-12-17 23:27:35','daniels','access to table Incident',172),('2022-12-17 23:27:39','daniels','update record in table Incident',173),('2022-12-17 23:27:39','daniels','access to table Incident',174),('2022-12-17 23:27:50','daniels','update record in table Incident',175),('2022-12-17 23:27:50','daniels','access to table Incident',176),('2022-12-17 23:28:54','daniels','update record in table Incident',177),('2022-12-17 23:28:54','daniels','access to table Incident',178),('2022-12-17 23:33:23','daniels','update record in table Incident',179),('2022-12-17 23:33:23','daniels','access to table Incident',180),('2022-12-17 23:33:31','daniels','update record in table Incident',181),('2022-12-17 23:33:31','daniels','access to table Incident',182),('2022-12-17 23:33:36','daniels','update record in table Incident',183),('2022-12-17 23:33:36','daniels','access to table Incident',184),('2022-12-17 23:34:47','daniels','update record in table Incident',185),('2022-12-17 23:35:10','daniels','access to table Incident',186),('2022-12-17 23:35:10','daniels','access to table Incident',187),('2022-12-17 23:36:10','daniels','update record in table Incident',188),('2022-12-17 23:36:10','daniels','access to table Incident',189),('2022-12-17 23:38:35','daniels','update record in table Incident',190),('2022-12-17 23:38:35','daniels','access to table Incident',191),('2022-12-17 23:43:20','daniels','access to table Incident',192),('2022-12-17 23:44:59','daniels','update record in table Incident',193),('2022-12-17 23:44:59','daniels','access to table Incident',194),('2022-12-17 23:45:09','daniels','update record in table Incident',195),('2022-12-17 23:45:09','daniels','access to table Incident',196),('2022-12-17 23:45:55','daniels','update record in table Incident',197),('2022-12-17 23:45:55','daniels','access to table Incident',198),('2022-12-17 23:46:19','daniels','login',199),('2022-12-17 23:46:23','daniels','access to table Incident',200),('2022-12-17 23:46:32','daniels','update record in table Incident',201),('2022-12-17 23:46:32','daniels','access to table Incident',202),('2022-12-17 23:49:10','daniels','update record in table Incident',203),('2022-12-17 23:49:10','daniels','access to table Incident',204),('2022-12-17 23:50:47','daniels','update record in table Incident',205),('2022-12-17 23:50:47','daniels','access to table Incident',206),('2022-12-17 23:50:54','daniels','update record in table Incident',207),('2022-12-17 23:50:54','daniels','access to table Incident',208),('2022-12-17 23:51:02','daniels','update record in table Incident',209),('2022-12-17 23:51:02','daniels','access to table Incident',210),('2022-12-18 00:00:02','daniels','update record in table Incident',211),('2022-12-18 00:00:02','daniels','access to table Incident',212),('2022-12-18 00:00:24','daniels','access to table Incident',213),('2022-12-18 00:00:28','daniels','access to table Incident',214),('2022-12-18 00:00:45','daniels','update record in table Incident',215),('2022-12-18 00:00:45','daniels','access to table Incident',216),('2022-12-18 00:01:42','daniels','update record in table People',217),('2022-12-18 00:03:39','daniels','access to table Incident',218),('2022-12-18 00:03:48','daniels','update record in table Incident',219),('2022-12-18 00:03:48','daniels','access to table Incident',220),('2022-12-18 00:15:40','daniels','access to table Incident',221),('2022-12-18 00:15:40','daniels','access to table Incident',222),('2022-12-18 00:16:42','daniels','access to table Incident',223),('2022-12-18 00:17:16','daniels','access to table Incident',224),('2022-12-18 00:17:21','daniels','access to table Incident',225),('2022-12-18 00:17:26','daniels','access to table Incident',226),('2022-12-18 00:19:05','daniels','access to table Incident',227),('2022-12-18 00:19:36','daniels','access to table Incident',228),('2022-12-18 00:20:07','daniels','access to table Incident',229),('2022-12-18 00:23:59','daniels','access to table Incident',230),('2022-12-18 00:25:16','daniels','update record in table Incident',231),('2022-12-18 00:25:16','daniels','access to table Incident',232),('2022-12-18 00:25:29','daniels','update record in table Incident',233),('2022-12-18 00:25:29','daniels','access to table Incident',234),('2022-12-18 00:30:20','daniels','access to table Incident',235),('2022-12-18 00:30:58','daniels','update record in table Incident',236),('2022-12-18 00:30:59','daniels','access to table Incident',237),('2022-12-18 00:31:17','daniels','update record in table Incident',238),('2022-12-18 00:31:17','daniels','access to table Incident',239),('2022-12-18 00:31:58','daniels','insertion to table fine',240),('2022-12-18 00:32:43','daniels','access to table Incident',241);

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `type` varchar(65) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Username`, `Password`, `type`) VALUES (1,'mcnulty','plod123','user'),(2,'moreland','fuzz42','user'),(3,'daniels','copper99','admin');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed
