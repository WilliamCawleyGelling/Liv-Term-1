-- MySQL dump 10.14  Distrib 5.5.68-MariaDB, for Linux (x86_64)
--
-- Host: studdb.csc.liv.ac.uk    Database: sgwcawle
-- ------------------------------------------------------
-- Server version	8.0.13

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
-- Table structure for table `Teams`
--

DROP TABLE IF EXISTS `Teams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Teams` (
  `tName` char(20) NOT NULL,
  `sport` char(20) NOT NULL,
  PRIMARY KEY (`tName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Teams`
--

LOCK TABLES `Teams` WRITE;
/*!40000 ALTER TABLE `Teams` DISABLE KEYS */;
INSERT INTO `Teams` VALUES ('Everton','Football'),('Liverpool','Football'),('Sale','Rugby');
/*!40000 ALTER TABLE `Teams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `team`
--

DROP TABLE IF EXISTS `team`;
/*!50001 DROP VIEW IF EXISTS `team`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `team` (
  `tName` tinyint NOT NULL,
  `sport` tinyint NOT NULL,
  `noOfPlayers` tinyint NOT NULL,
  `totalAge` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `teams`
--

DROP TABLE IF EXISTS `teams`;
/*!50001 DROP VIEW IF EXISTS `teams`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `teams` (
  `tName` tinyint NOT NULL,
  `sport` tinyint NOT NULL,
  `aveAge` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `Players`
--

DROP TABLE IF EXISTS `Players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Players` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `tName` char(20) NOT NULL,
  `fName` char(20) NOT NULL,
  `lName` char(30) NOT NULL,
  `nationality` char(30) NOT NULL,
  `DoB` date NOT NULL,
  PRIMARY KEY (`pid`),
  KEY `tName` (`tName`),
  CONSTRAINT `Players_ibfk_1` FOREIGN KEY (`tName`) REFERENCES `Teams` (`tname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Players`
--

LOCK TABLES `Players` WRITE;
/*!40000 ALTER TABLE `Players` DISABLE KEYS */;
INSERT INTO `Players` VALUES (1,'Liverpool','James','Milner','English','1986-01-04'),(2,'Liverpool','Virgil','Van Dijk','Dutch','1991-07-08'),(3,'Liverpool','Jordan','Henderson','English','1990-06-17'),(4,'Everton','Fabian','Delph','English','1989-11-21'),(5,'Everton','Jordan','Pickford','English','1994-03-07'),(6,'Everton','Yerri','Mina','Colombian','1994-09-23'),(7,'Sale','Ben','Curry','English','1998-06-15'),(8,'Sale','Tom','Curry','English','1998-06-15'),(9,'Sale','Sam','James','English','1994-07-03');
/*!40000 ALTER TABLE `Players` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `players`
--

DROP TABLE IF EXISTS `players`;
/*!50001 DROP VIEW IF EXISTS `players`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `players` (
  `pid` tinyint NOT NULL,
  `tName` tinyint NOT NULL,
  `fName` tinyint NOT NULL,
  `Lname` tinyint NOT NULL,
  `nationality` tinyint NOT NULL,
  `DoB` tinyint NOT NULL,
  `age` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `team`
--

/*!50001 DROP TABLE IF EXISTS `team`*/;
/*!50001 DROP VIEW IF EXISTS `team`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`sgwcawle`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `team` (`tName`,`sport`,`noOfPlayers`,`totalAge`) AS select `T`.`tName` AS `tName`,`T`.`sport` AS `sport`,count(0) AS `count(*)`,sum(`P`.`age`) AS `sum(P.age)` from (`Teams` `T` join `players` `P`) where (`T`.`tName` = `P`.`tName`) group by `T`.`tName` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `teams`
--

/*!50001 DROP TABLE IF EXISTS `teams`*/;
/*!50001 DROP VIEW IF EXISTS `teams`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`sgwcawle`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `teams` (`tName`,`sport`,`aveAge`) AS select `team`.`tName` AS `tName`,`team`.`sport` AS `sport`,truncate((`team`.`totalAge` / `team`.`noOfPlayers`),2) AS `truncate(totalAge / noOfPlayers, 2)` from `team` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `players`
--

/*!50001 DROP TABLE IF EXISTS `players`*/;
/*!50001 DROP VIEW IF EXISTS `players`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`sgwcawle`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `players` (`pid`,`tName`,`fName`,`Lname`,`nationality`,`DoB`,`age`) AS select `Players`.`pid` AS `pid`,`Players`.`tName` AS `tName`,`Players`.`fName` AS `fName`,`Players`.`lName` AS `Lname`,`Players`.`nationality` AS `nationality`,`Players`.`DoB` AS `DoB`,((date_format(now(),'%Y') - date_format(`Players`.`DoB`,'%Y')) - (date_format(now(),'00-%m-%d') < date_format(`Players`.`DoB`,'00-%m-%d'))) AS `Name_exp_7` from `Players` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-01-18 17:12:05
