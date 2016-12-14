-- MySQL dump 10.13  Distrib 5.7.15, for Linux (x86_64)
--
-- Host: localhost    Database: Schedule
-- ------------------------------------------------------
-- Server version	5.7.15-0ubuntu0.16.04.1-log

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
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule` (
  `fightid` varchar(60) DEFAULT NULL,
  `trainer1` varchar(60) DEFAULT NULL,
  `trainer1id` int(10) DEFAULT NULL,
  `trainer2` varchar(60) DEFAULT NULL,
  `trainer2id` int(10) DEFAULT NULL,
  `odds` float DEFAULT NULL,
  `odds2` float DEFAULT NULL,
  `time` int(20) DEFAULT NULL,
  `timestamp` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule`
--

LOCK TABLES `schedule` WRITE;
/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
INSERT INTO `schedule` VALUES ('1','Swimmer Spencer',322,'Team Rocket Grunt',146,1.66667,2.5,121316,'9:00'),('2','Juggler Nate',235,'Ruin Maniac Foster',395,1.5,3,121316,'9:15'),('3','Gamer Rich',116,'Twins Joy & Meg',330,1.28571,4.5,121316,'9:30'),('4','Swimmer Luis',29,'Scientist Rodney',188,1.5,3,121316,'9:45'),('5','Birdkeeper Edwin',279,'Channeler Jennifer',162,1.25,5,121316,'10:00'),('6','Cooltrainer Naomi',364,'Picnicker Claire',338,1.28571,4.5,121316,'10:15'),('7','Pokemaniac Cooper',107,'Engineer Bernie',80,1.77778,2.28571,121316,'10:30'),('8','Youngster Timmy',35,'Channeler Tasha',177,2.16667,1.85714,121316,'10:45'),('9','Tamer Phil',238,'Swimmer Abigail',337,1.5,3,121316,'11:00'),('10','Team Rocket Grunt',209,'Aroma Lady Violet',331,1.64706,2.54545,121316,'11:15'),('11','Biker Isaac',269,'Swimmer Samir',388,1.33333,4,121316,'11:30'),('12','Birdkeeper Robert',256,'Youngster Dillon',79,1.28571,4.5,121316,'11:45'),('13','Gentleman Thomas',59,' Rival',380,2.05556,1.94737,121316,'12:00'),('14','Juggler Gregory',369,'Swimmer Richard',281,3.25,1.44444,121316,'12:15'),('15',' Gary',198,'Lass Megan',122,2.2,1.83333,121316,'12:30'),('16','Lass Megan',122,'Hiker Dudley',106,3.07692,1.48148,121316,'12:45'),('17','Biker Malik',268,'Black Belt Atsuhi',356,1.28571,4.5,121316,'13:00'),('18','Hiker Jeremy',87,'Team Rocket Grunt',383,1.95833,2.04348,121316,'13:15'),('19','Crushkin Crush Kin Ron and Mya',271,'Lass Julia',115,3.25,1.44444,121316,'13:30'),('20','Channeler Paula',156,' Erika',135,1.52941,2.88889,121316,'13:45'),('21','Picnicker Kindra',277,'Hiker Dudley',106,2.77778,1.5625,121316,'14:00'),('22','Gentleman Thomas',59,'Team Rocket Grunt',384,1.66667,2.5,121316,'14:15'),('23','Team Rocket Grunt',186,'Hiker Brice',93,2.04348,1.95833,121316,'14:30'),('24',' Boss Giovanni',147,'Bug Catcher Colton',9,1.72727,2.375,121316,'14:45'),('25','Bug Catcher Kent',16,'Cooltrainer Yuji',355,2.09091,1.91667,121316,'15:00'),('26','Crush Girl Tanya',340,'Swimmer David',284,1.66667,2.5,121316,'15:15'),('27','Cue Ball Paxton',329,'Team Rocket Grunt',182,1.66667,2.5,121316,'15:30'),('28',' Rival',362,'Swimmer Samir',388,2.04,1.96154,121316,'15:45'),('29',' Boss Giovanni',147,' Blaine',316,1.85714,2.16667,121316,'16:00'),('30','Picnicker Valerie',254,'Crush Girl Sharon',345,2.23333,1.81081,121316,'16:15'),('31','Team Rocket Grunt',24,' Lorelei',376,1.33333,4,121316,'16:30'),('32','Lass Reli',36,'Swimmer Connie',291,1.66667,2.5,121316,'16:45'),('33','Swimmer Jerome',317,'Biker Jaren',123,2.375,1.72727,121316,'17:00'),('34','Birdkeeper Carter',259,'Channeler Stacy',174,1.33333,4,121316,'17:15'),('35','Tamer Phil',238,'Bug Catcher Rick',1,1.82353,2.21429,121316,'17:30'),('36','Burglar Quinn',309,'Hiker Allen',100,2.16667,1.85714,121316,'17:45'),('37','Pokemaniac Cooper',107,'Juggler Nelson',367,1.75,2.33333,121316,'18:00'),('38','Fisherman Dale',69,'Swimmer Barry',292,1.58333,2.71429,121316,'18:15'),('39','Camper Flint',46,'Cue Ball Koji',216,1.22222,5.5,121316,'18:30'),('40','Swimmer Melissa',301,'Youngster Tyler',61,1.5,3,121316,'18:45');
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-13 23:06:30
