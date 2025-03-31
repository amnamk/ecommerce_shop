-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ecommerceshop
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `specialproduct_id` int DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `product_id` (`product_id`),
  KEY `fk_specialproduct` (`specialproduct_id`),
  KEY `cart_ibfk_1` (`user_id`),
  CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  CONSTRAINT `fk_specialproduct` FOREIGN KEY (`specialproduct_id`) REFERENCES `specialproducts` (`specialproduct_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (13,2,2,1,NULL),(14,2,2,1,NULL),(15,2,2,1,NULL),(16,2,2,1,NULL),(17,2,2,1,NULL),(20,2,3,1,NULL),(21,2,NULL,3,6),(22,2,8,3,NULL),(23,2,NULL,2,5),(24,7,6,2,NULL);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorites` (
  `favorite_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `specialproduct_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  PRIMARY KEY (`favorite_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  KEY `specialproduct_id` (`specialproduct_id`),
  CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  CONSTRAINT `favorites_ibfk_4` FOREIGN KEY (`specialproduct_id`) REFERENCES `specialproducts` (`specialproduct_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` VALUES (1,2,5,NULL),(4,7,NULL,8),(5,7,5,NULL);
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general`
--

DROP TABLE IF EXISTS `general`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `general` (
  `general_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`general_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general`
--

LOCK TABLES `general` WRITE;
/*!40000 ALTER TABLE `general` DISABLE KEYS */;
INSERT INTO `general` VALUES (1,'Sample Title',NULL,'This is a sample description for testing.',NULL),(2,'Sample Title 1','Author One','This is a description for Sample Title 1.','https://example.com/image1.jpg');
/*!40000 ALTER TABLE `general` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `cardholder_name` varchar(255) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `expiry_date` varchar(5) NOT NULL,
  `cvv` varchar(4) NOT NULL,
  `address` text NOT NULL,
  `state` varchar(100) NOT NULL,
  `shipping_fee` decimal(10,2) DEFAULT '10.00',
  PRIMARY KEY (`payment_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (2,2,'John Doe','1234567812345678','12/25','123','123 Main Street','Alabama',5.99);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int DEFAULT NULL,
  `reviews` varchar(100) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `picture` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Test Product',NULL,29.99,50,NULL,NULL,NULL),(2,'Test Product','A description of the test product.',29.99,120,'Great product!','Test Category','path/to/product_image.jpg'),(3,'New Product','This is a new product description.',100.00,50,NULL,'Electronics','new_product.jpg'),(4,'New Product','This is a new product description.',100.00,50,NULL,'Electronics','new_product.jpg'),(5,'New Product','This is a new product description.',100.00,50,'This is a review.','Electronics','new_product.jpg'),(6,'Test Product','This is a test product.',99.99,50,'4.5','Test Category','test_product.jpg'),(7,'New Product','This is a new product description.',19.99,50,'Great product!','Electronics','https://via.placeholder.com/150'),(8,'Sample Product','This is a sample product.',29.99,100,'Good product!','Electronics','product.jpg'),(9,'New Product','This is a description for a new product.',99.99,250,'This is a review.','Electronics','new_product.jpg');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specialproducts`
--

DROP TABLE IF EXISTS `specialproducts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specialproducts` (
  `specialproduct_id` int NOT NULL AUTO_INCREMENT,
  `discount` decimal(5,2) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int DEFAULT NULL,
  `reviews` varchar(100) DEFAULT NULL,
  `picture` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`specialproduct_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specialproducts`
--

LOCK TABLES `specialproducts` WRITE;
/*!40000 ALTER TABLE `specialproducts` DISABLE KEYS */;
INSERT INTO `specialproducts` VALUES (5,25.00,'Winter Special Jacket','A special winter jacket with a 25% discount for a limited time.',150.00,33,'Best jacket for winter!','images/winter_jacket.jpg'),(6,15.50,'Special Product 1','This is a description for the special product.',99.99,50,'Good product, highly recommended!','image_path.jpg');
/*!40000 ALTER TABLE `specialproducts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'John Doe','john@example.com','$2y$10$pI0m9KzJVvhehFm9EGDab.CgzLMWt2L5Sg0s8.Zz.69pP94GeQ8b6',NULL),(4,'Amna Mutap','amnamutap@gmail.com','$2y$10$/hdKUsmF/wr1NhK64txebOwYMAsVQYBbzeLPZhrfx9p5BJSpEK5je',NULL),(6,'John Doe','john.doe@example.com','$2y$10$RKgrWvkgo.vvXBColUkHkebr96Rx3JRlpt03k9g8/nI7sdQmZZtP.',NULL),(7,'Williams Harold','williams@example.com','$2y$10$xKqWQTCxKHnJXmcT2RzqNOvCqrHnYxbhsi/iBqO.lyjAild4fH4y6','user'),(9,'Amy Make','amymake@example.com','Test12345!','user'),(10,'Johnny Alame','johnny.alame@example.com','$2y$10$R08qnBKT4Sxy0Eu0n2QIXO3gvlgDoyEpwC19cJjkfoYoy2zcnbJ0O','user'),(11,'Anny Bot','anny.bot@example.com','$2y$10$aWkxlV12e/iJxkPwqFnkhuXch0hD43jFWjsDLEukddFjJYwOy2V4G','user'),(12,'Anny Lol','anny.lot@example.com','$2y$10$UbsX2ixXzMz2T50RY6m7sO5udKb8Nd9Z7j9FnbP5Tq9mScbCtdzBu','user'),(13,'Muhammed Assaid','muhammed.assaid@example.com','Password123!','user'),(14,'New User','newuser@example.com','securepassword','user'),(15,'New User1','newuse1r@example.com','securepassword','admin'),(16,'New User2','newuser2@example.com','securepassword','admin'),(17,'Test User','test@example.com','$2y$10$228jQjB6dNf7UndL28AVeOMfJO0aTFNIOW8R7i6R6g3eOk4z05Q4C','user'),(18,'John Doe','test123@example.com','Test123455','user');
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

-- Dump completed on 2025-03-31 21:35:03
