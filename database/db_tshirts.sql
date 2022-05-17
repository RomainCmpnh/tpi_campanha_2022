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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Adidas'),(2,'Nike'),(3,'Zara'),(4,'Thommy Hilfiger'),(18,'Inconnue'),(19,'Dadou'),(20,'Supreme'),(21,'wwqg'),(22,'gqwg'),(23,'qwgwg'),(24,'wqfwqf'),(25,'qwgqg'),(26,'wqgqg'),(27,'wqfw'),(28,'23'),(29,'weqww'),(30,'qwew'),(31,'wqg'),(32,'ewgewg'),(33,'wqwqr'),(34,'ewg'),(35,'egwg'),(36,'qwe'),(37,'rehreh'),(38,'wehewh'),(39,'wetwet'),(40,'gew'),(41,'ewrwer'),(42,'ewrew'),(43,'ret'),(44,'werwer'),(45,'reh'),(46,'ewgweg'),(47,'ewgfe'),(48,'wer'),(49,'reer'),(50,'erwe'),(51,'ngffgh');
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
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorite`
--

LOCK TABLES `favorite` WRITE;
/*!40000 ALTER TABLE `favorite` DISABLE KEYS */;
INSERT INTO `favorite` VALUES (48,4,13),(51,4,18),(52,4,17),(53,4,16),(62,4,19);
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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `models`
--

LOCK TABLES `models` WRITE;
/*!40000 ALTER TABLE `models` DISABLE KEYS */;
INSERT INTO `models` VALUES (6,'Zara',3),(7,'Zara',3),(8,'Adidas',1),(9,'Adidas',1),(10,'Nike',2),(12,'Coupe slim',4),(15,'large fit',4),(16,'waaaw fit',4),(17,'dingue fit',4),(18,'le nouveau trop cool',2),(19,'le beau T-Shirt de M.Garcia',18),(20,'le test',1),(21,'le t-shirt de dadou',19);
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
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_tshirts`
--

LOCK TABLES `order_tshirts` WRITE;
/*!40000 ALTER TABLE `order_tshirts` DISABLE KEYS */;
INSERT INTO `order_tshirts` VALUES (57,33,8,1,20.00),(58,33,18,1,3.00),(59,34,18,1,3.00),(60,35,9,1,20.00),(61,35,11,1,20.00);
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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (33,0,23.00,'2022-05-17',7),(34,0,3.00,'2022-05-17',7),(35,0,40.00,'2022-05-17',11);
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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tshirts`
--

LOCK TABLES `tshirts` WRITE;
/*!40000 ALTER TABLE `tshirts` DISABLE KEYS */;
INSERT INTO `tshirts` VALUES (7,6,20.00,'Il se vend plutot bien',10),(8,7,20.00,'Il se vend plutot bien',9),(9,8,20.00,'Il se vend plutot bien',6),(10,9,20.00,'Il se vend plutot bien',10),(11,10,20.00,'Il se vend plutot bien',6),(13,12,20.00,'Il se vend plutot bien',8),(16,15,20.00,'Il se vend plutot bien',6),(17,16,20.00,'Il se vend plutot bien',0),(18,18,3.00,'il est vraiment nouveau et vraiment trop cool',12),(19,19,5000.00,'Produit unique',0),(20,20,2.00,'wawwww',0),(21,21,500.00,'modèle unique',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'admin','admin@gmail.com','1234',0,1),(4,'admin1','admin1@gmail.com','03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',1,1),(7,'Romarin','romain@gmail.com','03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',1,0),(8,'romDeux','roro@gmail.com','03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',1,0),(9,'Marc','marc@gmail.com','03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',0,0),(10,'Dadou','dadou@gmail.com','0df55addf230c0040da973a7a30da952d9c107bb055314a7d3bdba3335ec099d',1,0),(11,'Dodos','dodosleboss@gmail.com','f1c22278c2201af8649fe7c1aa71af256e2c739128b641f3b06cfa4f7aa4163c',1,0),(12,'Amir le giga bg','zizidefou@gmail.com','be178c0543eb17f5f3043021c9e5fcf30285e557a4fc309cce97ff9ca6182912',0,0),(13,'user','user@gmail.com','03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',1,0),(14,'waw','waw@gmail.com','03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4',1,0);
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

-- Dump completed on 2022-05-17 14:38:23
