-- MySQL dump 10.13  Distrib 5.7.26, for osx10.10 (x86_64)
--
-- Host: localhost    Database: PID_db
-- ------------------------------------------------------
-- Server version	5.7.26

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
-- Current Database: `PID_db`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `PID_db` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `PID_db`;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `adminId` int(11) NOT NULL AUTO_INCREMENT,
  `adminName` varchar(20) NOT NULL,
  `adminPass` varchar(20) NOT NULL,
  PRIMARY KEY (`adminId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','admin');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `uId` int(11) NOT NULL,
  `pId` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  PRIMARY KEY (`uId`,`pId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (1,4,4);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orderDetail`
--

DROP TABLE IF EXISTS `orderDetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orderDetail` (
  `orderId` varchar(15) NOT NULL,
  `productId` int(11) NOT NULL,
  `unitPrice` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orderDetail`
--

LOCK TABLES `orderDetail` WRITE;
/*!40000 ALTER TABLE `orderDetail` DISABLE KEYS */;
INSERT INTO `orderDetail` VALUES ('1202009071000',1,100,6),('1202009071000',3,10,99),('1202009071000',4,870,18),('1202009071003',1,100,5),('1202009071003',2,999,9),('1202009071003',4,870,7),('1202009071006',1,100,5),('1202009071006',4,870,7),('1202009071008',1,100,6),('1202009071009',4,870,8),('1202009071010',5,50000,1);
/*!40000 ALTER TABLE `orderDetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `oId` varchar(16) NOT NULL,
  `oDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uId` int(11) NOT NULL,
  `ship` int(11) NOT NULL,
  `note` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`oId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES ('1202009071000','2020-09-07 03:02:58',1,0,NULL),('1202009071003','2020-08-08 09:22:48',1,0,NULL),('1202009071006','2020-07-07 09:23:17',1,0,NULL),('1202009071008','2020-06-03 09:37:47',1,0,NULL),('1202009071009','2020-09-07 09:37:55',1,0,NULL),('1202009071010','2020-05-12 09:38:09',1,0,NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `pId` int(11) NOT NULL AUTO_INCREMENT,
  `pName` varchar(30) NOT NULL,
  `pPrice` int(11) NOT NULL,
  `pInventory` int(11) NOT NULL,
  `pInfo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`pId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'口罩',100,78,'非醫療用'),(2,'紙飛機套組',999,191,'喝水不夠'),(3,'冷凍便當',10,0,'熱銷\r\n'),(4,'熊班長掃把',870,47,'掃地時間到了'),(5,'東海畢業證書',50000,0,'值錢');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userTable`
--

DROP TABLE IF EXISTS `userTable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userTable` (
  `uId` int(11) NOT NULL AUTO_INCREMENT,
  `uName` varchar(20) NOT NULL,
  `uPass` varchar(20) NOT NULL,
  `uMail` varchar(50) NOT NULL,
  `uPermission` enum('0','1','2') DEFAULT '2',
  `uOrderIdx` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`uId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userTable`
--

LOCK TABLES `userTable` WRITE;
/*!40000 ALTER TABLE `userTable` DISABLE KEYS */;
INSERT INTO `userTable` VALUES (1,'owen5566','5566','owen@mail.com','1',11),(2,'userBanned','5566','ban@mail.com','0',0);
/*!40000 ALTER TABLE `userTable` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-09-07 17:58:56
