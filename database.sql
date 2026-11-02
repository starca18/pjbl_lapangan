-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: pjbl_lapangan
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
-- Table structure for table `booking_slots`
--

DROP TABLE IF EXISTS `booking_slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking_slots` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` int(11) unsigned NOT NULL,
  `court_id` int(11) unsigned NOT NULL,
  `booking_date` date NOT NULL,
  `slot_time` time NOT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `court_id_booking_date_slot_time` (`court_id`,`booking_date`,`slot_time`),
  KEY `booking_id` (`booking_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_slots`
--

LOCK TABLES `booking_slots` WRITE;
/*!40000 ALTER TABLE `booking_slots` DISABLE KEYS */;
INSERT INTO `booking_slots` VALUES (1,1,1,'2026-11-02','16:00:00','2026-11-02 15:03:47'),(2,1,1,'2026-11-02','17:00:00','2026-11-02 15:03:47'),(3,2,3,'2026-11-02','19:00:00','2026-11-02 15:03:47'),(4,2,3,'2026-11-02','20:00:00','2026-11-02 15:03:47'),(5,3,4,'2026-11-02','09:00:00','2026-11-02 15:03:47'),(6,3,4,'2026-11-02','10:00:00','2026-11-02 15:03:47'),(7,4,8,'2026-11-02','19:00:00','2026-11-02 15:03:47'),(8,4,8,'2026-11-02','20:00:00','2026-11-02 15:03:47'),(9,5,7,'2026-11-02','07:00:00','2026-11-02 15:03:47'),(10,5,7,'2026-11-02','08:00:00','2026-11-02 15:03:47'),(11,6,1,'2026-11-02','20:00:00','2026-11-02 15:03:47'),(12,6,1,'2026-11-02','21:00:00','2026-11-02 15:03:47'),(13,7,8,'2026-11-03','18:00:00','2026-11-02 15:03:47'),(14,7,8,'2026-11-03','19:00:00','2026-11-02 15:03:47'),(15,8,1,'2026-11-05','14:00:00','2026-11-02 15:16:32'),(16,8,1,'2026-11-05','15:00:00','2026-11-02 15:16:32'),(17,9,1,'2026-12-15','13:00:00','2026-11-02 15:21:13'),(18,10,7,'2026-11-05','16:00:00','2026-11-02 15:51:24'),(19,10,7,'2026-11-05','18:00:00','2026-11-02 15:51:24'),(20,10,7,'2026-11-05','20:00:00','2026-11-02 15:51:24'),(21,11,4,'2026-11-11','10:00:00','2026-11-02 15:59:53'),(22,11,4,'2026-11-11','11:00:00','2026-11-02 15:59:53'),(23,11,4,'2026-11-11','12:00:00','2026-11-02 15:59:53');
/*!40000 ALTER TABLE `booking_slots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `booking_code` varchar(25) NOT NULL,
  `court_id` int(11) unsigned NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(30) NOT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `total_hours` int(11) NOT NULL DEFAULT 1,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_method` varchar(50) NOT NULL DEFAULT 'Transfer Bank',
  `payment_status` enum('unpaid','paid','dp') NOT NULL DEFAULT 'unpaid',
  `status` enum('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'confirmed',
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `booking_code` (`booking_code`),
  KEY `court_id` (`court_id`),
  KEY `booking_date` (`booking_date`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (1,'BK-20261102-001',1,'Rian Pratama (FC Galaxy)','081298765432','rian@example.com','2026-11-02','16:00:00','18:00:00',2,300000.00,'Transfer BCA','paid','confirmed','Sparing tim futsal kantor','2026-11-02 15:03:47','2026-11-02 15:03:47'),(2,'BK-20261102-002',3,'Coach Dimas (Garuda Muda)','085712349988','dimas@example.com','2026-11-02','19:00:00','21:00:00',2,750000.00,'QRIS','paid','confirmed','Latihan rutin komunitas mini soccer','2026-11-02 15:03:47','2026-11-02 15:03:47'),(3,'BK-20261102-003',4,'Budi Santoso','082133445566','budi@example.com','2026-11-02','09:00:00','11:00:00',2,130000.00,'Tunai / Kasir','paid','completed','Sewa raket 2 pcs','2026-11-02 15:03:47','2026-11-02 15:03:47'),(4,'BK-20261102-004',8,'Kevin & Friends','081377889900','kevin@example.com','2026-11-02','19:00:00','21:00:00',2,440000.00,'Transfer Mandiri','paid','confirmed','Game ganda padel','2026-11-02 15:03:47','2026-11-02 15:03:47'),(5,'BK-20261102-005',7,'dr. Hendra Sp.A','081822334455','hendra@example.com','2026-11-02','07:00:00','09:00:00',2,250000.00,'Transfer BCA','paid','completed','Pagi tenis rutin','2026-11-02 15:03:47','2026-11-02 15:03:47'),(6,'BK-20261102-006',1,'Aris Munandar','087811223344','aris@example.com','2026-11-02','20:00:00','22:00:00',2,300000.00,'QRIS','unpaid','pending','Menunggu verifikasi pembayaran','2026-11-02 15:03:47','2026-11-02 15:03:47'),(7,'BK-20261103-001',8,'Sarah Wijaya','081900112233','sarah@example.com','2026-11-03','18:00:00','20:00:00',2,440000.00,'QRIS','paid','confirmed','Padel evening match','2026-11-02 15:03:47','2026-11-02 15:03:47'),(8,'BK-20261102-007',1,'Testing User','081122334455','test@example.com','2026-11-05','14:00:00','16:00:00',2,300000.00,'QRIS','paid','confirmed','Test Booking','2026-11-02 15:16:32','2026-11-02 15:16:32'),(9,'BK-20261102-008',1,'Caca','081221665048','','2026-12-15','13:00:00','14:00:00',1,150000.00,'QRIS (Gopay/OVO/ShopeePay/Dana)','paid','confirmed','','2026-11-02 15:21:13','2026-11-02 15:21:13'),(10,'BK-20261102-009',7,'cacantik','08','','2026-11-05','16:00:00','21:00:00',3,375000.00,'Transfer Bank BCA','paid','confirmed','','2026-11-02 15:51:24','2026-11-02 15:51:24'),(11,'BK-20261102-010',4,'Nuurul','08976591443','','2026-11-11','10:00:00','13:00:00',3,195000.00,'Transfer Bank BCA','paid','confirmed','','2026-11-02 15:59:53','2026-11-02 15:59:53');
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(50) NOT NULL DEFAULT 'bi-trophy',
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'futsal','Futsal','bi-dribbble','Lapangan futsal standar kompetisi dengan pilihan lantai vinyl taraflex & rumput sintetis.','2026-11-02 15:03:47','2026-11-02 15:03:47'),(2,'mini-soccer','Mini Soccer','bi-shield-shaded','Lapangan mini soccer 7 vs 7 dengan rumput sintetis monofilament standar FIFA & lampu sorot LED.','2026-11-02 15:03:47','2026-11-02 15:03:47'),(3,'badminton','Badminton','bi-lightning-charge','Karpet vinyl matras standar BWF dengan sirkulasi udara sejuk dan pencahayaan anti-silau.','2026-11-02 15:03:47','2026-11-02 15:03:47'),(4,'voli','Bola Voli','bi-circle-half','Lapangan voli indoor dengan lantai parquet kayu interlock & jaring standar nasional PBVSI.','2026-11-02 15:03:47','2026-11-02 15:03:47'),(5,'tenis','Tenis Lapangan','bi-circle','Hard court acrylic standar ITF dengan peredaman pantulan bola optimal.','2026-11-02 15:03:47','2026-11-02 15:03:47'),(6,'padel','Padel','bi-grid-3x3','Lapangan padel terkini dengan dinding kaca tempered panoramic & rumput sintetis Mondo texturized.','2026-11-02 15:03:47','2026-11-02 15:03:47');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courts`
--

DROP TABLE IF EXISTS `courts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `court_type` varchar(50) NOT NULL DEFAULT 'Indoor',
  `floor_type` varchar(50) DEFAULT NULL,
  `price_per_hour` decimal(10,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courts`
--

LOCK TABLES `courts` WRITE;
/*!40000 ALTER TABLE `courts` DISABLE KEYS */;
INSERT INTO `courts` VALUES (1,1,'FUT-01','Futsal Vinyl Court A','Indoor','Vinyl Taraflex 7mm',150000.00,'futsal_vinyl.svg','Lantai vinyl licin pas dan empuk, nyaman untuk lari cepat, aman bagi lutut.',1,'2026-11-02 15:03:47','2026-11-02 15:03:47'),(2,1,'FUT-02','Futsal Rumput Sintetis B','Indoor','Rumput Sintetis Premium',135000.00,'futsal_rumput.svg','Rumput sintetis halus dengan butiran rubber infill berkualitas tinggi.',1,'2026-11-02 15:03:47','2026-11-02 15:03:47'),(3,2,'MSC-01','Mini Soccer Arena Stadium','Outdoor','Rumput Monofilament 60mm',375000.00,'minisoccer.svg','Ukuran lapangan 7v7 (55m x 35m) lengkap dengan tribun penonton dan lampu sorot 800 Lux.',1,'2026-11-02 15:03:47','2026-11-02 15:03:47'),(4,3,'BDM-01','Badminton Court 1 (Matras Hijau)','Indoor','Matras Vinyl BWF Approved',65000.00,'badminton_1.svg','Matras profesional anti-slip dengan garis lapangan kontras presisi.',1,'2026-11-02 15:03:47','2026-11-02 15:03:47'),(5,3,'BDM-02','Badminton Court 2 (Matras Biru)','Indoor','Matras Vinyl BWF Approved',65000.00,'badminton_2.svg','Lampu tidak silau dari atas bola, sirkulasi exhaust fan dingin.',1,'2026-11-02 15:03:47','2026-11-02 15:03:47'),(6,4,'VOL-01','Voli Indoor Hall','Indoor','Interlocking Polypropylene Court',110000.00,'voli.svg','Langit-langit aula tinggi 10 meter, tiang dan net regulasi PBVSI.',1,'2026-11-02 15:03:47','2026-11-02 15:03:47'),(7,5,'TNS-01','Tenis Center Court (Hard Court)','Outdoor','Acrylic Plexipave Hard Court',125000.00,'tenis.svg','Pantulan bola medium-fast, garis rapi, tersedia bangku wasit dan canopy istirahat.',1,'2026-11-02 15:03:47','2026-11-02 15:03:47'),(8,6,'PDL-01','Padel Panoramic Court 1','Indoor','Mondo Texturized Turf + Tempered Glass',220000.00,'padel_indoor.svg','Kaca panoramik tanpa pilar sudut pandang 360 derajat, rumput padel profesional.',1,'2026-11-02 15:03:47','2026-11-02 15:03:47'),(9,6,'PDL-02','Padel Sunset Outdoor Court 2','Outdoor','Mondo Turf + Glass Enclosure',180000.00,'padel_outdoor.svg','Bermain padel di udara terbuka dengan pemandangan matahari sore dan pencahayaan malam.',1,'2026-11-02 15:03:47','2026-11-02 15:03:47');
/*!40000 ALTER TABLE `courts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2026-11-02-080220','App\\Database\\Migrations\\CreateReservationTables','default','App',1793606571,1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `role` enum('admin','staff') NOT NULL DEFAULT 'admin',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$BdS1cy9U.0VJdoG3RKmO5uHSgJ92A8pr9Ztpp/lT8BPG3PX4XLqby','Administrator Olahraga','admin@arenasport.id','081234567890','admin','2026-11-02 15:03:47','2026-11-02 15:03:47');
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

-- Dump completed on 2026-11-02 16:15:09