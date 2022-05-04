-- MySQL dump 10.13  Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost    Database: db_tshirts
-- ------------------------------------------------------
-- Server version	5.5.5-10.3.31-MariaDB-0ubuntu0.20.04.1

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
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id_brand` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_brand`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Adidas'),(2,'Nike'),(3,'Zara'),(4,'Thommy Hilfiger');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorite`
--

DROP TABLE IF EXISTS `favorite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorite` (
  `id_favorite` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_tshirt` int(11) NOT NULL,
  PRIMARY KEY (`id_favorite`),
  KEY `id_user` (`id_user`),
  KEY `id_shirt` (`id_tshirt`),
  CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`id_tshirt`) REFERENCES `tshirts` (`id_tshirt`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorite`
--

LOCK TABLES `favorite` WRITE;
/*!40000 ALTER TABLE `favorite` DISABLE KEYS */;
/*!40000 ALTER TABLE `favorite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `models`
--

DROP TABLE IF EXISTS `models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `models` (
  `id_model` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `id_brand` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_model`),
  KEY `id_brand` (`id_brand`),
  CONSTRAINT `models_ibfk_1` FOREIGN KEY (`id_brand`) REFERENCES `brands` (`id_brand`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `models`
--

LOCK TABLES `models` WRITE;
/*!40000 ALTER TABLE `models` DISABLE KEYS */;
INSERT INTO `models` VALUES (1,'modele test',1),(2,'Le classique',3),(3,'Boss absolu',2),(4,'waaaaaaw',4),(5,'completement dingue',2),(6,'maximum',3),(7,'l\'incroyable',3),(8,'Le dinguos',1),(9,'L\'inimaginable',1),(10,'Le fantastique',2),(11,'Coupe large',3),(12,'Coupe slim',4),(13,'oversize',4),(14,'Slim fit',4),(15,'large fit',4),(16,'waaaw fit',4),(17,'dingue fit',4);
/*!40000 ALTER TABLE `models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_tshirts`
--

DROP TABLE IF EXISTS `order_tshirts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_tshirts` (
  `id_order_tshirts` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `id_tshirt` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_order_tshirts`),
  KEY `id_shirt` (`id_tshirt`),
  KEY `id_order` (`id_order`),
  CONSTRAINT `order_tshirts_ibfk_2` FOREIGN KEY (`id_tshirt`) REFERENCES `tshirts` (`id_tshirt`),
  CONSTRAINT `order_tshirts_ibfk_3` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_tshirts`
--

LOCK TABLES `order_tshirts` WRITE;
/*!40000 ALTER TABLE `order_tshirts` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_tshirts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL AUTO_INCREMENT,
  `is_confirmed` tinyint(4) DEFAULT 0,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_order`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tshirts`
--

DROP TABLE IF EXISTS `tshirts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tshirts` (
  `id_tshirt` int(11) NOT NULL AUTO_INCREMENT,
  `id_model` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(5) NOT NULL DEFAULT 20,
  PRIMARY KEY (`id_tshirt`),
  KEY `id_model` (`id_model`),
  CONSTRAINT `tshirts_ibfk_1` FOREIGN KEY (`id_model`) REFERENCES `models` (`id_model`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tshirts`
--

LOCK TABLES `tshirts` WRITE;
/*!40000 ALTER TABLE `tshirts` DISABLE KEYS */;
INSERT INTO `tshirts` VALUES (1,1,30.00,'waaaw',1),(2,2,40.00,'le plus beau de tous',5),(3,3,10.00,'pas chère du tout',15),(4,4,20.00,'Il se vend plutot bien',2),(5,5,50.00,'trop cool',5),(6,5,20.00,'Il se vend plutot bien',10),(7,6,20.00,'Il se vend plutot bien',10),(8,7,20.00,'Il se vend plutot bien',10),(9,8,20.00,'Il se vend plutot bien',10),(10,9,20.00,'Il se vend plutot bien',10),(11,10,20.00,'Il se vend plutot bien',10),(12,11,20.00,'Il se vend plutot bien',10),(13,12,20.00,'Il se vend plutot bien',10),(14,13,20.00,'Il se vend plutot bien',10),(15,14,20.00,'Il se vend plutot bien',10),(16,15,20.00,'Il se vend plutot bien',10),(17,16,20.00,'Il se vend plutot bien',10);
/*!40000 ALTER TABLE `tshirts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `actif` int(1) NOT NULL DEFAULT 1,
  `admin` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `idx_email` (`email`),
  KEY `idx_password` (`password`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'db_tshirts'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-04 15:33:16
