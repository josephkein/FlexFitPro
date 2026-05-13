-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: flexfitpro
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `coaching`
--

DROP TABLE IF EXISTS `coaching`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coaching` (
  `coaching_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `trainer_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`coaching_id`),
  KEY `idx_coaching_trainer` (`trainer_id`),
  KEY `idx_coaching_customer` (`customer_id`),
  CONSTRAINT `coaching_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  CONSTRAINT `coaching_ibfk_2` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`trainer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coaching`
--

LOCK TABLES `coaching` WRITE;
/*!40000 ALTER TABLE `coaching` DISABLE KEYS */;
INSERT INTO `coaching` VALUES (1,1,1,'2026-01-01','2026-01-31'),(3,3,13,'2026-05-04','2026-05-28'),(4,4,13,'2026-05-03','2026-05-21'),(5,5,13,'2026-05-05','2026-05-19'),(6,6,6,'2026-01-25','2026-02-25'),(11,12,13,'2026-05-03','2026-05-21'),(13,2,12,'2026-05-07','2026-05-28');
/*!40000 ALTER TABLE `coaching` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(75) NOT NULL,
  `customer_type` enum('student','regular') NOT NULL DEFAULT 'regular',
  PRIMARY KEY (`customer_id`),
  KEY `idx_customer_name_type` (`customer_name`,`customer_type`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (4,'Ana Reyes','student'),(5,'Carlos Miguel','student'),(9,'David Tan','regular'),(8,'Elena Cruz','student'),(13,'Jennycakes Brigoli','student'),(3,'John Smith','regular'),(12,'Joseph Kein Honrada','student'),(1,'Juan Dela Cruz','student'),(10,'Liam Wilson','student'),(2,'Maria Santos','regular'),(7,'Miguel Lopez','regular'),(16,'Narciso Voldigoad','regular'),(15,'Rene Radaza','regular'),(6,'Sofia Garcia','student'),(17,'Wil Smith','student');
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `memberships`
--

DROP TABLE IF EXISTS `memberships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memberships` (
  `membership_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `plan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`membership_id`),
  KEY `idx_membership_customer` (`customer_id`),
  KEY `fk_membership_plan` (`plan_id`),
  CONSTRAINT `fk_membership_plan` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`plan_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `memberships_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `memberships`
--

LOCK TABLES `memberships` WRITE;
/*!40000 ALTER TABLE `memberships` DISABLE KEYS */;
INSERT INTO `memberships` VALUES (2,12,'2026-05-03',1),(3,3,'2026-05-04',2),(6,16,'2026-05-15',2);
/*!40000 ALTER TABLE `memberships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_type` enum('visit','membership') NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `user_id` (`user_id`),
  KEY `idx_payment_customer` (`customer_id`),
  KEY `idx_payment_date` (`payment_date`),
  KEY `idx_payment_type` (`payment_type`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (24,3,2,70.00,'2026-05-01 13:00:55','visit'),(25,12,2,50.00,'2026-05-01 19:10:23','visit'),(26,2,2,70.00,'2026-05-01 19:16:18','visit'),(27,13,2,35.35,'2026-05-01 23:19:20','visit'),(28,5,6,50.00,'2026-05-02 01:59:10','visit'),(29,12,6,50.00,'2026-05-02 01:59:25','visit'),(30,4,2,50.00,'2026-05-02 02:38:55','visit'),(33,8,2,50.00,'2026-05-02 09:04:27','visit'),(35,16,2,70.00,'2026-05-03 12:22:29','visit'),(36,15,2,70.00,'2026-05-03 12:22:35','visit'),(38,5,2,50.00,'2026-05-03 14:42:01','visit'),(39,4,2,50.00,'2026-05-03 15:13:57','visit'),(51,12,2,800.00,'2026-05-03 17:59:06','membership'),(52,4,2,50.00,'2026-05-03 21:48:37','visit'),(53,8,2,50.00,'2026-05-03 21:58:03','visit'),(54,3,2,2300.00,'2026-05-04 13:24:10','membership'),(55,5,14,50.00,'2026-05-04 14:44:27','visit'),(56,9,2,50.00,'2026-05-05 18:49:11','visit'),(57,4,2,50.00,'2026-05-08 09:03:22','visit'),(60,16,2,2300.00,'2026-05-13 13:18:56','membership');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_name` varchar(50) NOT NULL,
  `duration_month` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`plan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` VALUES (1,'Basic',1,800.00),(2,'Pro',3,2300.00),(3,'Premium',12,8500.00),(4,'Mythic',18,15000.00),(6,'Ubec Colon',999,1000000.00);
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trainers`
--

DROP TABLE IF EXISTS `trainers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trainers` (
  `trainer_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `contact_no` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`trainer_id`),
  KEY `idx_trainer_name` (`first_name`,`last_name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trainers`
--

LOCK TABLES `trainers` WRITE;
/*!40000 ALTER TABLE `trainers` DISABLE KEYS */;
INSERT INTO `trainers` VALUES (1,'Mark','Johnson',500.00,4,'09236233423'),(3,'Chris','Davis',600.00,6,'09987654323'),(4,'Paul','Wilson',550.00,5,'09234567890'),(5,'James','Taylor',700.00,7,'09345678901'),(6,'Anna','Moore',650.00,6,'09456789012'),(8,'David','Lewis',480.00,4,'09678901234'),(11,'Dwayne','Rillera',250.00,5,'09789012345'),(12,'Jeff','Gabisan',300.00,6,'09890123456'),(13,'Clarke Michael','Risma',500.00,4,'09111222333'),(14,'Jkeinskie','Honrada',500.00,5,'09999888777');
/*!40000 ALTER TABLE `trainers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','staff') NOT NULL,
  `status` enum('active','disabled') DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `idx_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'jkeinskie','$2y$10$kp1d/SEAS7f8FLZeZUb30eqqrIZh4OHQXzXdxoZbr7wKShgiaacBm','admin','active'),(6,'johndoe','$2y$10$LhLoGvVtP6OIZdauqkgyT.Awl1PGOJv.xtDvaLASihEdJYV6171ce','staff','disabled'),(7,'admin','$2y$10$H7E8CWvy2AXgcW67vu1Da.I1Q3lb7E/ZH9nOSFhqbvYd4JGVOA0Fu','admin','active'),(12,'jefferson','$2y$10$4lE0eENLqZ.juWXkyIni4O2ABK29CXi96I8Zojfq1C7p6BD613SMC','staff','active'),(13,'wade','$2y$10$XnPYo3e8hgMHiM7AIpSAU.u2UR85dCJumFeG.XtEN5nU17M09VNPu','staff','active'),(14,'user','$2y$10$RFSPmyos7FtGFrQqe1ojPOHSgeeGNENmocEvoMsT5XaIE4nTMX6nq','staff','active');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visits` (
  `visit_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `visit_date` datetime NOT NULL,
  PRIMARY KEY (`visit_id`),
  KEY `user_id` (`user_id`),
  KEY `idx_visit_customer` (`customer_id`),
  KEY `idx_visit_date` (`visit_date`),
  CONSTRAINT `visits_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  CONSTRAINT `visits_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visits`
--

LOCK TABLES `visits` WRITE;
/*!40000 ALTER TABLE `visits` DISABLE KEYS */;
INSERT INTO `visits` VALUES (11,1,2,'2026-04-01 08:00:00'),(12,2,2,'2026-04-01 09:00:00'),(13,3,2,'2026-04-02 10:00:00'),(14,4,2,'2026-04-02 11:00:00'),(15,5,2,'2026-04-03 08:30:00'),(16,6,2,'2026-04-03 09:30:00'),(17,7,2,'2026-04-04 10:30:00'),(18,8,2,'2026-04-04 11:30:00'),(19,9,2,'2026-04-05 07:00:00'),(20,10,2,'2026-04-05 08:15:00'),(21,2,2,'2026-04-21 11:50:00'),(22,3,2,'2026-04-21 11:50:00'),(23,8,2,'2026-04-21 11:51:00'),(26,13,2,'2026-04-29 09:04:02'),(27,13,2,'2026-04-29 09:04:28'),(28,4,2,'2026-04-29 09:05:44'),(29,4,2,'2026-04-29 12:30:30'),(30,9,2,'2026-04-29 12:43:35'),(31,9,2,'2026-04-30 09:51:49'),(32,4,6,'2026-05-01 04:04:49'),(35,9,6,'2026-05-01 04:50:39'),(36,9,6,'2026-05-01 04:53:10'),(37,5,6,'2026-05-01 06:26:48'),(38,12,2,'2026-05-01 11:47:17'),(39,13,2,'2026-05-01 11:49:56'),(40,8,2,'2026-05-01 12:00:59'),(41,3,2,'2026-05-01 13:00:55'),(42,12,2,'2026-05-01 19:10:23'),(43,2,2,'2026-05-01 19:16:18'),(44,13,2,'2026-05-01 23:19:20'),(45,5,6,'2026-05-02 01:59:10'),(46,12,6,'2026-05-02 01:59:25'),(47,4,2,'2026-05-02 02:38:55'),(48,8,2,'2026-05-02 02:41:44'),(49,3,2,'2026-05-02 08:44:13'),(50,8,2,'2026-05-02 09:04:27'),(51,13,2,'2026-05-02 15:05:33'),(52,16,2,'2026-05-03 12:22:29'),(53,15,2,'2026-05-03 12:22:35'),(54,5,2,'2026-05-03 14:42:01'),(55,5,2,'2026-05-03 15:04:08'),(56,4,2,'2026-05-03 15:13:57'),(57,4,2,'2026-05-03 21:48:37'),(58,12,2,'2026-05-03 21:51:26'),(59,8,2,'2026-05-03 21:58:03'),(60,12,2,'2026-05-03 21:58:09'),(61,12,2,'2026-05-04 00:34:07'),(62,5,14,'2026-05-04 14:44:27'),(63,9,2,'2026-05-05 18:49:11'),(64,4,2,'2026-05-08 09:03:22'),(65,12,2,'2026-05-08 09:03:39'),(66,16,2,'2026-05-13 13:19:33'),(67,16,2,'2026-05-13 13:24:49'),(68,16,2,'2026-05-13 13:31:34'),(69,3,2,'2026-05-13 13:31:58'),(70,12,2,'2026-05-13 13:32:26'),(71,16,2,'2026-05-13 13:32:50'),(72,3,2,'2026-05-13 13:45:58'),(73,16,2,'2026-05-13 13:46:02'),(74,16,2,'2026-05-13 13:46:36'),(75,3,2,'2026-05-13 13:50:09');
/*!40000 ALTER TABLE `visits` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-13 14:39:39
