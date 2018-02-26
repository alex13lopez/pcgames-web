-- MySQL dump 10.13  Distrib 5.7.21, for Linux (x86_64)
--
-- Host: localhost    Database: pcgames
-- ------------------------------------------------------
-- Server version	5.7.21-0ubuntu0.16.04.1

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
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` text,
  `platform` varchar(100) DEFAULT 'Steam',
  `price` float DEFAULT NULL,
  `region` varchar(100) DEFAULT 'GLOBAL',
  `type` varchar(100) DEFAULT 'Key',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `ind_title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'THE ELDER SCROLLS V: SKYRIM - Legendary Edition','Steam',8.75,'GLOBAL','Key'),(3,'THE ELDER SCROLLS V: SKYRIM','Steam',4.75,'GLOBAL','Key'),(4,'THE ELDER SCROLLS IV: OBLIVION - GOTY','Steam',4.37,'GLOBAL','Key'),(5,'Mass effect Trilogy','Origin',6.88,'GLOBAL','Key'),(6,'Far Cry 3','Steam',14.59,'GLOBAL','Key'),(7,'Grand Theft Auto V','Rockstar',21.99,'GLOBAL','Key'),(8,'Grand Theft Auto San Andreas','Steam',5.79,'GLOBAL','Key'),(9,'Grand Theft Auto IV','Steam',6.88,'GLOBAL','Key'),(11,'Dishonored - Definitive Edition','Steam',5.29,'GLOBAL','Key');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `user` varchar(255) NOT NULL,
  `passwd` text,
  `roles` varchar(50) DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_unique` (`email`,`user`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'alexlopezmelo@gmail.com','AlexLopez','$2y$10$M55mx1ZyIQ3jC8pVx2boFOtdvj/SnwDSwap4U8DVmoUSwDuDEORkW','admin'),(21,'shopadmin@pcgames.com','shopadmin','$2y$10$H34NKKh4cdaCrGelgWA1A..HwERl1k0FNmVZraHI4dbOyElZUMNTC','shopadmin'),(22,'luser1@blabla.com','luser1','$2y$10$UVQu8tCtu.K7fVoQFKsGwuSQEhW27rYNC3eSRVMp7G5LiFIXo3Y3q','user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-26 19:30:46
