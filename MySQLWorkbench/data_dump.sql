-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: mydb
-- ------------------------------------------------------
-- Server version	5.7.17-0ubuntu0.16.04.1

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
-- Table structure for table `auteurs`
--

DROP TABLE IF EXISTS `auteurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auteurs` (
  `id_auteur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_auteur`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auteurs`
--

LOCK TABLES `auteurs` WRITE;
/*!40000 ALTER TABLE `auteurs` DISABLE KEYS */;
INSERT INTO `auteurs` VALUES (13,'Dire Straits'),(14,'The Cranberries');
/*!40000 ALTER TABLE `auteurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oeuvres`
--

DROP TABLE IF EXISTS `oeuvres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oeuvres` (
  `id_oeuvre` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `date` varchar(60) DEFAULT NULL COMMENT 'c''est un var char pour mettre n''importe quel format (si oeuvre ancienne on peut se retrouver avec du 500AC)',
  `description` mediumtext,
  `url_image` varchar(2000) DEFAULT NULL,
  `auteur_id_auteurs` int(11) NOT NULL,
  PRIMARY KEY (`id_oeuvre`,`auteur_id_auteurs`),
  KEY `fk_oeuvres_auteurs1_idx` (`auteur_id_auteurs`),
  CONSTRAINT `fk_oeuvres_auteurs1` FOREIGN KEY (`auteur_id_auteurs`) REFERENCES `auteurs` (`id_auteur`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oeuvres`
--

LOCK TABLES `oeuvres` WRITE;
/*!40000 ALTER TABLE `oeuvres` DISABLE KEYS */;
INSERT INTO `oeuvres` VALUES (21,'Money for Nothing','1985','tUlKAJ3ToOmmcKwcYNNDPchL9Gp3cgsfYIcxfK5mB87YFHx58R','http://www.popjoust.com/images/jousters/jouster-5177-Money_for_nothing_clip.jpg',13),(22,'Sultans of Swing','1977','A2u7xh0QVa6JbWgvwUekOkFUhtVxRZ2Qkrskx3RQaa0VOcxxfN','http://images.45cat.com/dire-straits-sultans-of-swing-vertigo-7.jpg',13),(23,'Zombie','1994','uvO9sTwDmLtSwPzZFavp1yvD8fkV2o230yP1sUE4DF5DD0rZST','https://i.ytimg.com/vi/6Ejga4kJUts/maxresdefault.jpg',14),(24,'Animal Instinct','1999','FcFQ8QKI5JQtDmCPhutlPUkEsCcfC6krptqGwdhs0iuxxMBR4t','https://i.ytimg.com/vi/bSQ7CJSTTxo/hqdefault.jpg',14);
/*!40000 ALTER TABLE `oeuvres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id_session` int(11) NOT NULL AUTO_INCREMENT,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `description` longtext,
  PRIMARY KEY (`id_session`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='Sessions de votes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES (14,'2017-03-19','2017-04-19','V4wwFPBVoYvRIdqQkvmJs2WgFflkKQmNl5BTbGQblnvyPlMXYmJcUAhHOkpv7B9KrhYFl9nCVFuqIMZhXKvxJO1pAqoaHMmQz8dO'),(15,'2017-02-19','2017-03-18','qi8Ho2Oy9ObrtjXLkdFVXJys0C57l2SiX4v0yvguEQLomOyeRmDMW5Sn9rsr7T4WpqIfSxdG0BuszJypEs34qQjVrxJ6qRLuWy7a');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions_has_oeuvres`
--

DROP TABLE IF EXISTS `sessions_has_oeuvres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions_has_oeuvres` (
  `id_sessions` int(11) NOT NULL,
  `id_oeuvres` int(11) NOT NULL,
  `score` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_sessions`,`id_oeuvres`),
  KEY `fk_sessions_has_oeuvres_oeuvres1_idx` (`id_oeuvres`),
  KEY `fk_sessions_has_oeuvres_sessions_idx` (`id_sessions`),
  CONSTRAINT `fk_sessions_has_oeuvres_oeuvres1` FOREIGN KEY (`id_oeuvres`) REFERENCES `oeuvres` (`id_oeuvre`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_sessions_has_oeuvres_sessions` FOREIGN KEY (`id_sessions`) REFERENCES `sessions` (`id_session`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions_has_oeuvres`
--

LOCK TABLES `sessions_has_oeuvres` WRITE;
/*!40000 ALTER TABLE `sessions_has_oeuvres` DISABLE KEYS */;
INSERT INTO `sessions_has_oeuvres` VALUES (14,21,0),(14,22,10),(14,23,15),(14,24,25),(15,23,0),(15,24,10);
/*!40000 ALTER TABLE `sessions_has_oeuvres` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-24 10:51:27
