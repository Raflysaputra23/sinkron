-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: db_sinkron
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dosen`
--

DROP TABLE IF EXISTS `dosen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dosen` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nip` char(18) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  PRIMARY KEY (`id_user`) USING BTREE,
  UNIQUE KEY `nip` (`nip`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dosen`
--

LOCK TABLES `dosen` WRITE;
/*!40000 ALTER TABLE `dosen` DISABLE KEYS */;
INSERT INTO `dosen` VALUES (2,'2417051050','Arip'),(3,'198765432100000001','Budi Santoso, S.Kom.'),(4,'198609262015051001','Pak Afdhall'),(5,'198609262015051002','Pak Alwine');
/*!40000 ALTER TABLE `dosen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `get_dosen`
--

DROP TABLE IF EXISTS `get_dosen`;
/*!50001 DROP VIEW IF EXISTS `get_dosen`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `get_dosen` AS SELECT 
 1 AS `nip`,
 1 AS `nama_lengkap`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `get_mk`
--

DROP TABLE IF EXISTS `get_mk`;
/*!50001 DROP VIEW IF EXISTS `get_mk`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `get_mk` AS SELECT 
 1 AS `id_mk`,
 1 AS `nama_mk`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `get_semua_kelas`
--

DROP TABLE IF EXISTS `get_semua_kelas`;
/*!50001 DROP VIEW IF EXISTS `get_semua_kelas`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `get_semua_kelas` AS SELECT 
 1 AS `id_mk`,
 1 AS `nama_mk`,
 1 AS `sks`,
 1 AS `id_kelas`,
 1 AS `hari`,
 1 AS `jam_mulai`,
 1 AS `jam_selesai`,
 1 AS `ruangan`,
 1 AS `kuota`,
 1 AS `id_dosen_koor`,
 1 AS `id_dosen_pendamping`,
 1 AS `nama_dosen`,
 1 AS `nama_dosen_pendamping`,
 1 AS `kuota_terisi`,
 1 AS `sisa_kuota`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `getdosenpembimbing`
--

DROP TABLE IF EXISTS `getdosenpembimbing`;
/*!50001 DROP VIEW IF EXISTS `getdosenpembimbing`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `getdosenpembimbing` AS SELECT 
 1 AS `nama_lengkap`,
 1 AS `nip`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `getmahasiswadosen`
--

DROP TABLE IF EXISTS `getmahasiswadosen`;
/*!50001 DROP VIEW IF EXISTS `getmahasiswadosen`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `getmahasiswadosen` AS SELECT 
 1 AS `id`,
 1 AS `nama_lengkap`,
 1 AS `role`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelas` (
  `id_kelas` varchar(20) NOT NULL,
  `id_mk` char(10) NOT NULL,
  `id_dosen_koor` char(20) NOT NULL,
  `id_dosen_pendamping` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `hari` int NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan` varchar(100) NOT NULL,
  `kuota` int NOT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `fk_kelas_dosen1` (`id_dosen_koor`),
  KEY `fk_kelas_dosen2` (`id_dosen_pendamping`),
  KEY `fk_kelas_mk` (`id_mk`),
  CONSTRAINT `fk_kelas_dosen1` FOREIGN KEY (`id_dosen_koor`) REFERENCES `dosen` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_kelas_dosen2` FOREIGN KEY (`id_dosen_pendamping`) REFERENCES `dosen` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_kelas_mk` FOREIGN KEY (`id_mk`) REFERENCES `matakuliah` (`id_mk`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` VALUES ('COMA20','COM20','198765432100000001',NULL,1,'07:30:00','09:15:00','GIK C',50),('COMA44','COM90','198765432100000001',NULL,0,'16:00:00','17:30:00','GIK C Lt. 2',50),('COMAB','COM22','2417051050','198765432100000001',0,'11:00:00','12:45:00','LAB R1',50),('COMAB36','COM81','198609262015051002','198765432100000001',0,'14:00:00','15:30:00','GIK C Lt.1',50),('COMB20','COM20','2417051050','198765432100000001',2,'07:30:00','09:15:00','GIK C Lt. 2',50),('COMB60','COM36','198765432100000001','198609262015051002',1,'07:30:00','11:00:00','GIK C Lt.1',50);
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `konfigurasi_backup`
--

DROP TABLE IF EXISTS `konfigurasi_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `konfigurasi_backup` (
  `id` int NOT NULL,
  `mode` enum('manual','otomatis') NOT NULL DEFAULT 'manual',
  `interval_waktu` varchar(50) DEFAULT NULL,
  `last_backup` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `konfigurasi_backup`
--

LOCK TABLES `konfigurasi_backup` WRITE;
/*!40000 ALTER TABLE `konfigurasi_backup` DISABLE KEYS */;
INSERT INTO `konfigurasi_backup` VALUES (1,'otomatis','setiap_jam','2026-06-05 16:08:44');
/*!40000 ALTER TABLE `konfigurasi_backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `krs`
--

DROP TABLE IF EXISTS `krs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `krs` (
  `nim` char(10) NOT NULL,
  `id_kelas` varchar(20) NOT NULL,
  `status` enum('disetujui','ditolak','menunggu') NOT NULL DEFAULT 'menunggu',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`nim`,`id_kelas`),
  KEY `fk_krs_kelas` (`id_kelas`),
  CONSTRAINT `fk_krs_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_krs_mahasiswa` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `krs`
--

LOCK TABLES `krs` WRITE;
/*!40000 ALTER TABLE `krs` DISABLE KEYS */;
INSERT INTO `krs` VALUES ('2417051011','COMA20','menunggu','2026-06-05 14:19:47'),('2417051011','COMA44','menunggu','2026-06-05 14:19:56'),('2417051011','COMAB','menunggu','2026-06-05 14:35:34'),('2417051011','COMB20','menunggu','2026-06-05 16:08:11'),('2417051011','COMB60','menunggu','2026-06-05 16:08:16'),('2417051044','COMA20','disetujui','2026-06-05 05:43:22'),('2417051044','COMA44','disetujui','2026-06-05 05:43:22'),('2417051044','COMAB','disetujui','2026-06-05 05:43:22'),('2417051044','COMAB36','disetujui','2026-06-05 05:43:22'),('2417051044','COMB20','disetujui','2026-06-05 05:43:22'),('2417051049','COMA20','menunggu','2026-06-05 05:57:47'),('2417051049','COMAB36','disetujui','2026-06-05 05:44:43'),('2417051049','COMB20','disetujui','2026-06-05 05:44:43'),('2417051051','COMB20','menunggu','2026-06-05 16:08:07'),('2417051051','COMB60','menunggu','2026-06-05 16:08:02');
/*!40000 ALTER TABLE `krs` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_after_insert_krs` AFTER INSERT ON `krs` FOR EACH ROW BEGIN
    DECLARE new_sks INT;

    SELECT m.sks INTO new_sks 
    FROM kelas k
    JOIN matakuliah m ON k.id_mk = m.id_mk
    WHERE k.id_kelas = NEW.id_kelas;

    UPDATE mahasiswa 
    SET sks = sks + IFNULL(new_sks, 0)
    WHERE nim = NEW.nim;
    
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trigger_afterr_delete_krs` AFTER DELETE ON `krs` FOR EACH ROW BEGIN
    DECLARE new_sks INT;

    SELECT m.sks INTO new_sks 
    FROM kelas k
    JOIN matakuliah m ON k.id_mk = m.id_mk
    WHERE k.id_kelas = OLD.id_kelas;

    UPDATE mahasiswa 
    SET sks = sks - IFNULL(new_sks, 0)
    WHERE nim = OLD.nim;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `action` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('berhasil','gagal','menunggu') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`),
  KEY `fk_log_dosen` (`id_user`),
  CONSTRAINT `fk_log_dosen` FOREIGN KEY (`id_user`) REFERENCES `dosen` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_log_mahasiswa` FOREIGN KEY (`id_user`) REFERENCES `mahasiswa` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mahasiswa`
--

DROP TABLE IF EXISTS `mahasiswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mahasiswa` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nim` char(10) NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `jurusan` varchar(100) NOT NULL DEFAULT 'Ilmu Komputer',
  `ipk` float NOT NULL DEFAULT '0',
  `sks` int NOT NULL DEFAULT '0',
  `foto` varchar(255) DEFAULT NULL,
  `nip_pembimbing` char(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE,
  UNIQUE KEY `nim` (`nim`),
  KEY `fk_mahasiswa_dosen` (`nip_pembimbing`),
  CONSTRAINT `fk_mahasiswa_dosen` FOREIGN KEY (`nip_pembimbing`) REFERENCES `dosen` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswa`
--

LOCK TABLES `mahasiswa` WRITE;
/*!40000 ALTER TABLE `mahasiswa` DISABLE KEYS */;
INSERT INTO `mahasiswa` VALUES (1,'2417051044','Doni','Ilmu Komputer',3.8,64,NULL,'2417051050'),(2,'2417051049','M. Rafly Saputra','Ilmu Komputer',3.6,67,NULL,'2417051050'),(3,'2417051051','Ridho','Ilmu Komputer',3.8,6,NULL,'198609262015051001'),(4,'2417051052','Bagas','Ilmu Komputer',2,0,NULL,NULL),(5,'2317051064','Abdul','Ilmu Komputer',3.9,0,NULL,NULL),(6,'2417051011','Surya Gymnastyar','Ilmu Komputer',3.9,15,NULL,'198609262015051001'),(7,'2417051010','Dinda Shaumi','Ilmu Komputer',3.8,0,NULL,NULL);
/*!40000 ALTER TABLE `mahasiswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mahasiswa_identitas`
--

DROP TABLE IF EXISTS `mahasiswa_identitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mahasiswa_identitas` (
  `nim` char(10) NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `jurusan` varchar(100) NOT NULL DEFAULT 'Ilmu Komputer',
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswa_identitas`
--

LOCK TABLES `mahasiswa_identitas` WRITE;
/*!40000 ALTER TABLE `mahasiswa_identitas` DISABLE KEYS */;
INSERT INTO `mahasiswa_identitas` VALUES ('2417051044','Doni','Ilmu Komputer',NULL),('2417051049','M. Rafly Saputra','Ilmu Komputer',NULL),('2417051051','Ridho','Ilmu Komputer',NULL),('2417051052','Bagas','Ilmu Komputer',NULL),('2317051064','Abdul','Ilmu Komputer',NULL),('2417051011','Surya Gymnastyar','Ilmu Komputer',NULL),('2417051010','Dinda Shaumi','Ilmu Komputer',NULL);
/*!40000 ALTER TABLE `mahasiswa_identitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mahasiswa_ipk_tinggi`
--

DROP TABLE IF EXISTS `mahasiswa_ipk_tinggi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mahasiswa_ipk_tinggi` (
  `id_user` int NOT NULL DEFAULT '0',
  `nim` char(10) NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `jurusan` varchar(100) NOT NULL DEFAULT 'Ilmu Komputer',
  `ipk` float NOT NULL DEFAULT '0',
  `sks` int NOT NULL DEFAULT '0',
  `foto` varchar(255) DEFAULT NULL,
  `nip_pembimbing` char(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mahasiswa_ipk_tinggi`
--

LOCK TABLES `mahasiswa_ipk_tinggi` WRITE;
/*!40000 ALTER TABLE `mahasiswa_ipk_tinggi` DISABLE KEYS */;
INSERT INTO `mahasiswa_ipk_tinggi` VALUES (1,'2417051044','Doni','Ilmu Komputer',3.8,64,NULL,'2417051050'),(2,'2417051049','M. Rafly Saputra','Ilmu Komputer',3.6,67,NULL,'2417051050'),(3,'2417051051','Ridho','Ilmu Komputer',3.8,0,NULL,'198609262015051001'),(5,'2317051064','Abdul','Ilmu Komputer',3.9,0,NULL,NULL),(6,'2417051011','Surya Gymnastyar','Ilmu Komputer',3.9,0,NULL,NULL),(7,'2417051010','Dinda Shaumi','Ilmu Komputer',3.8,0,NULL,NULL);
/*!40000 ALTER TABLE `mahasiswa_ipk_tinggi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matakuliah`
--

DROP TABLE IF EXISTS `matakuliah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `matakuliah` (
  `id_mk` char(10) NOT NULL,
  `nama_mk` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sks` int NOT NULL,
  PRIMARY KEY (`id_mk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matakuliah`
--

LOCK TABLES `matakuliah` WRITE;
/*!40000 ALTER TABLE `matakuliah` DISABLE KEYS */;
INSERT INTO `matakuliah` VALUES ('COM20','Pemrograman Web',3),('COM22','Pemrograman Terdistribusi',3),('COM24','Sistem Informasi',3),('COM36','Teknologi Aplikasi Mobile',3),('COM81','AI',3),('COM90','Machine Learning',3);
/*!40000 ALTER TABLE `matakuliah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('mahasiswa','dosen','admin') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (2,'2417051044','$2y$10$YUo0LCpTR.xueNJ8D76psOwBVvfgipbZcbLq4HxMZry4ncYrpbD6i','mahasiswa','2026-04-05 18:47:22'),(3,'2417051049','$2y$10$vP63iit3FNRCvgkKJ1yrTeZgQBUTq5zF7rWfSUF9vS2K8Yhe4Alda','mahasiswa','2026-04-06 04:11:34'),(4,'2417051050','$2y$10$fJjIOCEND4GkacJmYcEBf.nYAUNRWzpgu0rjEgjAt.9HFt1yauBYe','dosen','2026-04-06 11:18:30'),(5,'198765432100000001','$2y$10$g2gQ1Wj7LpEjmclBTxB10OoAr11XJ62KMsR9QM7FapPxO2ktMspSW','dosen','2026-04-06 17:21:18'),(6,'Rafly','$2y$10$F6AfJ8rCjiHV6/iMdVuoaenF10t7BHENeRQBm8sVWCdpGOiW7YhZG','admin','2026-04-06 17:43:05'),(7,'2417051051','$2y$10$QmGutogq.IrYVfH5uy6V5eX5OxIkxMT2D0pWoW1Ho1oEJvjQGppMy','mahasiswa','2026-04-07 08:23:32'),(10,'198609262015051001','$2y$10$4mIM5LcRT0rPZsgIo8gkjukvVeXqC.udsLEGxsbmsQuAzHeGqDK2q','dosen','2026-04-07 08:25:29'),(11,'2417051052','$2y$10$ptahOMMeI56JaR8G6ijzTes0mYvMcXzBkfFmLjUH4CX36CZm.ZyDS','mahasiswa','2026-04-07 08:26:36'),(12,'198609262015051002','$2y$10$IIyhbdBYyGc4cEMtKadOu.PH8vGFKBWz6tCrDM0kSxku47fNB94gm','dosen','2026-04-07 08:26:58'),(13,'Ilham','$2y$10$H6GRQYFLDTBvv.cCLKiKOOF8iBBhhfifBldXFZ6QeE5NSCwrVd6Xi','admin','2026-04-07 09:12:10'),(14,'2317051064','$2y$10$jSTXCDvJoHZWoRWtBI6jo.eoQTCOl/aIEoH0Rr36hBK429vrjLm7a','mahasiswa','2026-04-07 09:58:31'),(15,'2417051011','$2y$10$w.GkfLzKikeJKTMuWGx5u.G4aBA0CicYuMhyTdjlkcIexK0LJ.gGK','mahasiswa','2026-06-05 12:18:17'),(16,'2417051010','$2y$10$GVTSR6waAMDTDhCU3d4q/eqX26KuxPbttlkBaxjz6GkZAU9cNC55y','mahasiswa','2026-06-05 12:18:30');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `view_user_akademik`
--

DROP TABLE IF EXISTS `view_user_akademik`;
/*!50001 DROP VIEW IF EXISTS `view_user_akademik`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_user_akademik` AS SELECT 
 1 AS `id`,
 1 AS `nama_lengkap`,
 1 AS `role`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `get_dosen`
--

/*!50001 DROP VIEW IF EXISTS `get_dosen`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `get_dosen` AS select `dosen`.`nip` AS `nip`,`dosen`.`nama_lengkap` AS `nama_lengkap` from `dosen` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `get_mk`
--

/*!50001 DROP VIEW IF EXISTS `get_mk`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `get_mk` AS select `matakuliah`.`id_mk` AS `id_mk`,`matakuliah`.`nama_mk` AS `nama_mk` from `matakuliah` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `get_semua_kelas`
--

/*!50001 DROP VIEW IF EXISTS `get_semua_kelas`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `get_semua_kelas` AS select `mk`.`id_mk` AS `id_mk`,`mk`.`nama_mk` AS `nama_mk`,`mk`.`sks` AS `sks`,`kls`.`id_kelas` AS `id_kelas`,`kls`.`hari` AS `hari`,`kls`.`jam_mulai` AS `jam_mulai`,`kls`.`jam_selesai` AS `jam_selesai`,`kls`.`ruangan` AS `ruangan`,`kls`.`kuota` AS `kuota`,`kls`.`id_dosen_koor` AS `id_dosen_koor`,`kls`.`id_dosen_pendamping` AS `id_dosen_pendamping`,`d`.`nama_lengkap` AS `nama_dosen`,`d2`.`nama_lengkap` AS `nama_dosen_pendamping`,(select count(0) from `krs` where (`krs`.`id_kelas` = `kls`.`id_kelas`)) AS `kuota_terisi`,(`kls`.`kuota` - (select count(0) from `krs` where (`krs`.`id_kelas` = `kls`.`id_kelas`))) AS `sisa_kuota` from (((`kelas` `kls` join `matakuliah` `mk` on((`kls`.`id_mk` = `mk`.`id_mk`))) left join `dosen` `d` on((`kls`.`id_dosen_koor` = `d`.`nip`))) left join `dosen` `d2` on((`kls`.`id_dosen_pendamping` = `d2`.`nip`))) order by `mk`.`nama_mk`,`kls`.`id_kelas` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `getdosenpembimbing`
--

/*!50001 DROP VIEW IF EXISTS `getdosenpembimbing`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `getdosenpembimbing` AS select `d`.`nama_lengkap` AS `nama_lengkap`,`d`.`nip` AS `nip` from (`mahasiswa` `m` join `dosen` `d` on((`m`.`nip_pembimbing` = `d`.`nip`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `getmahasiswadosen`
--

/*!50001 DROP VIEW IF EXISTS `getmahasiswadosen`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `getmahasiswadosen` AS select `m`.`nim` AS `id`,`m`.`nama_lengkap` AS `nama_lengkap`,`u`.`role` AS `role` from (`mahasiswa` `m` join `user` `u` on((`m`.`nim` = `u`.`username`))) union all select `d`.`nip` AS `id`,`d`.`nama_lengkap` AS `nama_lengkap`,`u`.`role` AS `role` from (`dosen` `d` join `user` `u` on((`d`.`nip` = `u`.`username`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_user_akademik`
--

/*!50001 DROP VIEW IF EXISTS `view_user_akademik`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_user_akademik` AS select `mahasiswa`.`nim` AS `id`,`mahasiswa`.`nama_lengkap` AS `nama_lengkap`,'mahasiswa' AS `role` from `mahasiswa` union all select `dosen`.`nip` AS `id`,`dosen`.`nama_lengkap` AS `nama_lengkap`,'dosen' AS `role` from `dosen` */;
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

-- Dump completed on 2026-06-05 23:08:46
