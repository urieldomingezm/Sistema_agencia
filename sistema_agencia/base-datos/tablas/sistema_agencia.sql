-- MySQL dump 10.13  Distrib 8.0.42, for Linux (x86_64)
--
-- Host: localhost    Database: sistema_agencia
-- ------------------------------------------------------
-- Server version	8.0.42

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
-- Table structure for table `ascensos`
--

DROP TABLE IF EXISTS `ascensos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ascensos` (
  `ascenso_id` int NOT NULL AUTO_INCREMENT,
  `codigo_time` varchar(5) NOT NULL,
  `rango_actual` varchar(50) NOT NULL,
  `mision_actual` varchar(255) DEFAULT NULL,
  `firma_usuario` varchar(10) DEFAULT NULL,
  `firma_encargado` varchar(10) DEFAULT NULL,
  `estado_ascenso` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'pendiente',
  `fecha_ultimo_ascenso` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_disponible_ascenso` time DEFAULT NULL,
  `usuario_encargado` varchar(50) DEFAULT NULL,
  `es_recluta` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ascenso_id`),
  KEY `idx_codigo_time` (`codigo_time`)
) ENGINE=InnoDB AUTO_INCREMENT=156 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ascensos`
--

LOCK TABLES `ascensos` WRITE;
/*!40000 ALTER TABLE `ascensos` DISABLE KEYS */;
INSERT INTO `ascensos` VALUES (37,'G1H2I','Junta directiva','Junta directiva','REN',NULL,'ascendido','2025-05-11 06:42:40','00:00:00',NULL,NULL),(39,'S0T1U','Fundador','SHN- Fundadora -ADL','ADL',NULL,'ascendido','2025-05-31 06:05:36','00:00:00',NULL,NULL),(40,'V2W3X','Administrador','SHN- Administrador -CBQ','CBQ',NULL,'ascendido','2025-05-31 06:05:36','00:00:00',NULL,NULL),(41,'Y4Z5A','Owner','SHN- Owner -JOC','JOC',NULL,'ascendido','2025-05-30 22:12:19','00:00:00',NULL,NULL),(42,'B6C7D','Administrador','SHN- Mi reyna hermosa -MPM','MPM',NULL,'ascendido','2025-05-31 06:05:36','00:00:00',NULL,NULL),(44,'H0I1J','Administrador','SHN- Administrador -NEF','NEF',NULL,'ascendido','2025-05-31 06:05:36','00:00:00',NULL,NULL),(45,'P8Q9R','Administrador','Administrador','BLU','ADL','ascendido','2025-05-31 06:05:36','00:00:00',NULL,NULL),(47,'TTKQE','seguridad','SHN- Iniciado I','322',NULL,'disponible','2025-05-31 06:05:31','00:00:00',NULL,NULL),(48,'TSZU8','Web_master','Web_master',NULL,NULL,'ascendido','2025-05-30 18:51:59','00:00:00','keekit08',1),(49,'G9DNE','Administrador','Administrador',NULL,NULL,'ascendido','2025-05-11 09:45:46','00:00:00',NULL,1),(51,'WTPUQ','agente','SHN- Novato H',NULL,'7U7','ascendido','2025-05-31 05:41:51','00:00:00',NULL,1),(52,'8VPXJ','operativo','SHN- Novato H','FSR',NULL,'ascendido','2025-05-31 06:05:31','537:11:01',NULL,1),(56,'FNJQ5','supervisor','SHN- Jefe A -RGO -MPM #S','RGO','MPM','ascendido','2025-06-02 15:42:31','95:59:11','maria51162',1),(57,'QH2HW','presidente','SHN- Intermedio D','TRT',NULL,'ascendido','2025-05-31 06:05:31','249:10:55',NULL,1),(58,'ATPWD','seguridad','SHN- Ayudante F -- #S',NULL,NULL,'disponible','2025-06-01 20:11:20','00:00:00','santidemg2',1),(59,'2RTN3','Tecnico','SHN- Auxiliar G',NULL,'ADL','disponible','2025-05-31 06:05:31','00:00:00',NULL,1),(62,'YE94X','Junta directiva','SHN- Junta Directiva -RYO','RYO','ADL','ascendido','2025-05-31 06:05:36','00:00:00',NULL,1),(64,'FP898','seguridad','SHN- Iniciado I','123',NULL,'ascendido','2025-05-12 11:17:33','00:00:00',NULL,1),(66,'8WS42','Supervisor','SHN- Experto B','TEF','ADL','disponible','2025-05-31 06:05:31','00:00:00',NULL,1),(73,'DGUWQ','Operativo','SHN- Iniciado I','CHI','ADL','ascendido','2025-05-31 06:05:31','537:10:44',NULL,1),(83,'J4K5L','Seguridad','SHN- Auxiliar G',NULL,'ADL','ascendido','2025-05-12 21:53:45','00:00:00','Snotra',0),(84,'6CVD6','Operativo','SHN- Iniciado I',NULL,'ADL','ascendido','2025-05-31 06:05:31','537:10:42',NULL,1),(85,'GFX8C','Owner','SHN- Owner -XAV','XAV','ADL','ascendido','2025-05-31 06:05:36','00:00:00',NULL,1),(87,'5T7X8','seguridad','SHN- Novato H -- #S',NULL,NULL,'disponible','2025-06-02 09:00:43','00:00:00','santidemg2',0),(90,'DXNCH','seguridad','SHN- Junior E',NULL,NULL,'disponible','2025-05-31 06:05:31','00:00:00',NULL,1),(92,'SD6JZ','Seguridad','SHN- Novato H',NULL,'MPM','disponible','2025-05-31 06:05:31','00:00:00',NULL,0),(93,'UWU9J','tecnico','SHN- Auxiliar G -MPM #T',NULL,'MPM','ascendido','2025-06-03 16:12:10','10:12:10','maria51162',0),(99,'RLLGR','director','SHN- Avanzado C -REY -MPM #D','REY','MPM','ascendido','2025-06-03 16:19:46','215:59:27','maria51162',0),(100,'86DAS','logistica','SHN- Iniciado I','BTO','MPM','disponible','2025-05-31 05:41:51','00:00:00',NULL,0),(101,'2QPCG','Logistica','SHN- Auxiliar G',NULL,'MPM','disponible','2025-05-31 06:05:31','00:00:00',NULL,0),(103,'CQZKU','agente','SHN- Novato H',NULL,NULL,'disponible','2025-05-31 06:05:31','00:00:00',NULL,1),(105,'EXHE5','Agente','SHN- Novato H',NULL,NULL,'disponible','2025-05-31 06:05:31','00:00:00',NULL,0),(110,'YA4E9','Supervisor','SHN- Auxiliar G','PTY','NEF','disponible','2025-05-31 06:05:31','00:00:00',NULL,0),(112,'TNF7R','Logistica','SHN- Avanzado C',NULL,'MPM','disponible','2025-05-31 06:05:31','00:00:00',NULL,0),(113,'AAFGM','Tecnico','SHN- Ayudante F','MAR','FSR','disponible','2025-05-31 05:41:51','00:00:00',NULL,0),(114,'HAN7Q','Director','SHN- Experto B','CBQ','MPM','ascendido','2025-05-31 06:05:31','177:09:26',NULL,0),(115,'5W8W2','Seguridad','SHN- Experto B',NULL,'MPM','disponible','2025-05-31 06:05:31','00:00:00',NULL,0),(116,'Q87HE','tecnico','SHN- Novato H -MPM #T',NULL,NULL,'disponible','2025-05-31 05:41:51','00:00:00',NULL,0),(119,'HQTZV','agente','SHN- Novato H',NULL,NULL,'ascendido','2025-05-24 06:37:46','00:00:00','Santidemg2',1),(120,'2DHTY','Agente','SHN- Auxiliar G',NULL,NULL,'ascendido','2025-05-26 04:10:14','00:00:00',NULL,1),(121,'3NBMN','agente','SHN- Ayudante F',NULL,NULL,'disponible','2025-05-31 06:05:31','00:00:00',NULL,1),(126,'4589A','seguridad','SHN- Auxiliar G -TRT #S',NULL,'TRT','disponible','2025-06-02 20:21:55','00:00:00','turtlerabbittc',1),(127,'YRF42','seguridad','SHN- Iniciado I',NULL,NULL,'disponible','2025-05-31 05:41:54','00:00:00',NULL,0),(128,'CXK3Q','fundador','SHN- Fundadora -KLZ','KLZ',NULL,'ascendido','2025-05-31 06:05:36','00:00:00',NULL,0),(129,'MAKQW','fundador','SHN- Fundador -XXX','XXX',NULL,'ascendido','2025-05-31 06:05:36','00:00:00',NULL,0),(132,'QNAZE','seguridad','SHN- Ayudante F -TER #S',NULL,'TER','ascendido','2025-05-29 19:59:18','00:00:00','TereStar',1),(133,'WQU2L','presidente','SHN- Novato H -TER -NEF #P','TER','NEF','ascendido','2025-05-29 19:31:56','00:00:00','Nefita',1),(134,'EGPDW','Agente','SHN- Iniciado I',NULL,NULL,'ascendido','2025-05-30 18:41:22','00:00:00',NULL,1),(135,'VACRG','Agente','SHN- Iniciado I',NULL,NULL,'ascendido','2025-05-30 18:52:49','00:00:00',NULL,1),(136,'TFJB9','Agente','SHN- Iniciado I',NULL,NULL,'ascendido','2025-05-30 19:12:39','00:00:00',NULL,1),(137,'BJ5Z3','Seguridad','SHN- Novato H -ADL',NULL,NULL,'disponible','2025-05-31 20:39:37','00:00:00',NULL,1),(141,'FYRGV','Agente','SHN- Iniciado I',NULL,NULL,'ascendido','2025-06-01 04:07:29','00:00:00',NULL,1),(142,'D3JPZ','Agente','SHN- Iniciado I',NULL,NULL,'ascendido','2025-06-01 04:21:58','00:00:00',NULL,1),(143,'RQNSL','Agente','SHN- Iniciado I',NULL,NULL,'ascendido','2025-06-01 04:45:31','00:00:00',NULL,1),(144,'XLDP5','Agente','SHN- Iniciado I',NULL,NULL,'Ascendido','2025-06-01 18:05:35','00:10:00',NULL,1),(145,'XP9FH','Agente','SHN- Iniciado I',NULL,NULL,'Ascendido','2025-06-02 04:28:59','00:10:00',NULL,1),(146,'F4WTC','tecnico','SHN- Auxiliar G -MPM #T',NULL,'MPM','disponible','2025-06-03 16:29:28','00:00:00','maria51162',1),(147,'QF3Z9','Junta directiva','SHN- Junta directiva -DEV','DEV',NULL,'Ascendido','2025-06-02 14:43:31','00:00:00',NULL,1),(148,'E9JY3','seguridad','SHN- Novato H -DEV #S',NULL,'DEV','disponible','2025-06-04 15:39:42','00:00:00','Devilthew',0),(149,'PW5JN','agente','SHN- Novato H -- #A',NULL,NULL,'disponible','2025-06-02 21:21:25','00:00:00','santidemg2',1),(150,'ZVYN6','Agente','SHN- Iniciado I',NULL,NULL,'Ascendido','2025-06-03 19:16:34','00:10:00',NULL,1),(151,'A8UEJ','seguridad','SHN- Novato H -- #S',NULL,NULL,'ascendido','2025-06-04 12:27:26','03:59:51','santidemg2',1),(152,'P5BRQ','seguridad','SHN- Auxiliar G -DEV #S',NULL,'DEV','ascendido','2025-06-06 09:45:31','03:47:02','Devilthew',1),(154,'R93M2','agente','SHN- Auxiliar G -JOC #A',NULL,'JOC','disponible','2025-06-05 11:17:12','00:00:00','Jo.c',1),(155,'5SRM9','Agente','SHN- Iniciado I',NULL,NULL,'disponible','2025-06-06 14:06:47','00:00:00',NULL,1);
/*!40000 ALTER TABLE `ascensos` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`agencia_user`@`%`*/ /*!50003 TRIGGER `tr_auditoria_ascensos` BEFORE UPDATE ON `ascensos` FOR EACH ROW BEGIN
    INSERT INTO auditoria_ascensos (
        codigo_time,
        nombre_habbo,
        rango_anterior,
        rango_nuevo,
        mision_anterior,
        mision_nueva,
        firma_anterior,
        firma_nueva,
        usuario_modificador,
        ip_modificacion
    )
    SELECT 
        OLD.codigo_time,
        ru.nombre_habbo,
        OLD.rango_actual,
        NEW.rango_actual,
        OLD.mision_actual,
        NEW.mision_actual,
        OLD.firma_usuario,
        NEW.firma_usuario,
        @usuario_modificador,
        @ip_modificacion
    FROM registro_usuario ru
    WHERE ru.codigo_time = OLD.codigo_time;
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
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`agencia_user`@`%`*/ /*!50003 TRIGGER `after_ascenso_insert` AFTER UPDATE ON `ascensos` FOR EACH ROW BEGIN
    INSERT INTO historial_ascensos (
        codigo_time, rango_actual, mision_actual, firma_usuario, firma_encargado,
        estado_ascenso, fecha_ultimo_ascenso, fecha_disponible_ascenso, usuario_encargado,
        accion, realizado_por
    ) VALUES (
        NEW.codigo_time, NEW.rango_actual, NEW.mision_actual, NEW.firma_usuario, NEW.firma_encargado,
        NEW.estado_ascenso, NEW.fecha_ultimo_ascenso, NEW.fecha_disponible_ascenso, NEW.usuario_encargado,
        'ascendido', NEW.usuario_encargado
    );
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `ascensos_backup_20250601`
--

DROP TABLE IF EXISTS `ascensos_backup_20250601`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ascensos_backup_20250601` (
  `ascenso_id` int NOT NULL DEFAULT '0',
  `codigo_time` varchar(5) NOT NULL,
  `rango_actual` varchar(50) NOT NULL,
  `mision_actual` varchar(255) DEFAULT NULL,
  `firma_usuario` varchar(10) DEFAULT NULL,
  `firma_encargado` varchar(10) DEFAULT NULL,
  `estado_ascenso` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'pendiente',
  `fecha_ultimo_ascenso` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_disponible_ascenso` time DEFAULT NULL,
  `usuario_encargado` varchar(50) DEFAULT NULL,
  `es_recluta` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ascensos_backup_20250601`
--

LOCK TABLES `ascensos_backup_20250601` WRITE;
/*!40000 ALTER TABLE `ascensos_backup_20250601` DISABLE KEYS */;
INSERT INTO `ascensos_backup_20250601` VALUES (37,'G1H2I','Junta directiva','Junta directiva','REN',NULL,'ascendido','2025-05-11 06:42:40','00:00:00',NULL,NULL),(39,'S0T1U','Fundador','Fundador','ADL',NULL,'ascendido','2025-05-31 06:05:36','00:00:00',NULL,NULL),(40,'V2W3X','Administrador','SHN- Administrador -CBQ','CBQ',NULL,'ascendido','2025-05-31 06:05:36','00:00:00',NULL,NULL),(41,'Y4Z5A','Owner','SHN- Owner -JOC','JOC',NULL,'ascendido','2025-05-30 22:12:19','00:00:00',NULL,NULL),(42,'B6C7D','Administrador','Administrador','MPM',NULL,'ascendido','2025-05-31 06:05:36','00:00:00',NULL,NULL),(44,'H0I1J','Administrador','SHN- Administrador -NEF','NEF',NULL,'ascendido','2025-05-31 06:05:36','00:00:00',NULL,NULL),(45,'P8Q9R','Administrador','Administrador','BLU','ADL','ascendido','2025-05-31 06:05:36','00:00:00',NULL,NULL),(47,'TTKQE','seguridad','SHN- Iniciado I','322',NULL,'disponible','2025-05-31 06:05:31','00:00:00',NULL,NULL),(48,'TSZU8','Web_master','Web_master',NULL,NULL,'ascendido','2025-05-30 18:51:59','00:00:00','keekit08',1),(49,'G9DNE','Administrador','Administrador',NULL,NULL,'ascendido','2025-05-11 09:45:46','00:00:00',NULL,1),(51,'WTPUQ','agente','SHN- Novato H',NULL,'7U7','ascendido','2025-05-31 05:41:51','00:00:00',NULL,1),(52,'8VPXJ','operativo','SHN- Novato H','FSR',NULL,'ascendido','2025-05-31 06:05:31','537:11:01',NULL,1),(56,'FNJQ5','supervisor','SHN- Jefe A -RGO -MPM #S','RGO','MPM','ascendido','2025-06-02 15:42:31','95:59:11','maria51162',1),(57,'QH2HW','presidente','SHN- Intermedio D','TRT',NULL,'ascendido','2025-05-31 06:05:31','249:10:55',NULL,1),(58,'ATPWD','seguridad','SHN- Ayudante F -- #S',NULL,NULL,'disponible','2025-06-01 20:11:20','00:00:00','santidemg2',1),(59,'2RTN3','Tecnico','SHN- Auxiliar G',NULL,'ADL','disponible','2025-05-31 06:05:31','00:00:00',NULL,1),(62,'YE94X','Junta directiva','Junta directiva','RYO','ADL','ascendido','2025-05-31 06:05:36','00:00:00',NULL,1),(64,'FP898','seguridad','SHN- Iniciado I','123',NULL,'ascendido','2025-05-12 11:17:33','00:00:00',NULL,1),(66,'8WS42','Supervisor','SHN- Experto B','TEF','ADL','disponible','2025-05-31 06:05:31','00:00:00',NULL,1),(73,'DGUWQ','Operativo','SHN- Iniciado I','CHI','ADL','ascendido','2025-05-31 06:05:31','537:10:44',NULL,1),(83,'J4K5L','Seguridad','SHN- Auxiliar G',NULL,'ADL','ascendido','2025-05-12 21:53:45','00:00:00','Snotra',0),(84,'6CVD6','Operativo','SHN- Iniciado I',NULL,'ADL','ascendido','2025-05-31 06:05:31','537:10:42',NULL,1),(85,'GFX8C','Owner','SHN- Owner -XAV','XAV','ADL','ascendido','2025-05-31 06:05:36','00:00:00',NULL,1),(87,'5T7X8','seguridad','SHN- Novato H -- #S',NULL,NULL,'disponible','2025-06-02 09:00:43','00:00:00','santidemg2',0),(90,'DXNCH','seguridad','SHN- Junior E',NULL,NULL,'disponible','2025-05-31 06:05:31','00:00:00',NULL,1),(92,'SD6JZ','Seguridad','SHN- Novato H',NULL,'MPM','disponible','2025-05-31 06:05:31','00:00:00',NULL,0),(93,'UWU9J','tecnico','SHN- Auxiliar G -MPM #T',NULL,'MPM','ascendido','2025-06-03 16:12:10','10:12:10','maria51162',0),(99,'RLLGR','director','SHN- Avanzado C -REY -MPM #D','REY','MPM','ascendido','2025-06-03 16:19:46','215:59:27','maria51162',0),(100,'86DAS','logistica','SHN- Iniciado I','BTO','MPM','disponible','2025-05-31 05:41:51','00:00:00',NULL,0),(101,'2QPCG','Logistica','SHN- Auxiliar G',NULL,'MPM','disponible','2025-05-31 06:05:31','00:00:00',NULL,0),(103,'CQZKU','agente','SHN- Novato H',NULL,NULL,'disponible','2025-05-31 06:05:31','00:00:00',NULL,1),(105,'EXHE5','Agente','SHN- Novato H',NULL,NULL,'disponible','2025-05-31 06:05:31','00:00:00',NULL,0),(110,'YA4E9','Supervisor','SHN- Auxiliar G','PTY','NEF','disponible','2025-05-31 06:05:31','00:00:00',NULL,0),(112,'TNF7R','Logistica','SHN- Avanzado C',NULL,'MPM','disponible','2025-05-31 06:05:31','00:00:00',NULL,0),(113,'AAFGM','Tecnico','SHN- Ayudante F','MAR','FSR','disponible','2025-05-31 05:41:51','00:00:00',NULL,0),(114,'HAN7Q','Director','SHN- Experto B','CBQ','MPM','ascendido','2025-05-31 06:05:31','177:09:26',NULL,0),(115,'5W8W2','Seguridad','SHN- Experto B',NULL,'MPM','disponible','2025-05-31 06:05:31','00:00:00',NULL,0),(116,'Q87HE','tecnico','SHN- TEC- Novato H -MPM #T',NULL,NULL,'disponible','2025-05-31 05:41:51','00:00:00',NULL,0),(119,'HQTZV','agente','SHN- Novato H',NULL,NULL,'ascendido','2025-05-24 06:37:46','00:00:00','Santidemg2',1),(120,'2DHTY','Agente','SHN- Auxiliar G',NULL,NULL,'ascendido','2025-05-26 04:10:14','00:00:00',NULL,1),(121,'3NBMN','agente','SHN- Ayudante F',NULL,NULL,'disponible','2025-05-31 06:05:31','00:00:00',NULL,1),(126,'4589A','seguridad','SHN- Auxiliar G -TRT #S',NULL,'TRT','ascendido','2025-06-02 20:21:55','01:39:43','turtlerabbittc',1),(127,'YRF42','seguridad','SHN- Iniciado I',NULL,NULL,'disponible','2025-05-31 05:41:54','00:00:00',NULL,0),(128,'CXK3Q','fundador','SHN- Fundadora -KLZ','KLZ',NULL,'ascendido','2025-05-31 06:05:36','00:00:00',NULL,0),(129,'MAKQW','fundador','Fundador','XXX',NULL,'ascendido','2025-05-31 06:05:36','00:00:00',NULL,0),(132,'QNAZE','seguridad','SHN- Ayudante F -TER #S',NULL,'TER','ascendido','2025-05-29 19:59:18','00:00:00','TereStar',1),(133,'WQU2L','presidente','SHN- Novato H -TER -NEF #P','TER','NEF','ascendido','2025-05-29 19:31:56','00:00:00','Nefita',1),(134,'EGPDW','Agente','SHN- Iniciado I',NULL,NULL,'ascendido','2025-05-30 18:41:22','00:00:00',NULL,1),(135,'VACRG','Agente','SHN- Iniciado I',NULL,NULL,'ascendido','2025-05-30 18:52:49','00:00:00',NULL,1),(136,'TFJB9','Agente','SHN- Iniciado I',NULL,NULL,'ascendido','2025-05-30 19:12:39','00:00:00',NULL,1),(137,'BJ5Z3','Seguridad','SHN- Novato H -ADL',NULL,NULL,'disponible','2025-05-31 20:39:37','00:00:00',NULL,1),(138,'UNKJS','agente',NULL,NULL,NULL,'ascendido','2025-05-31 21:05:15','00:00:00',NULL,1),(139,'RG379','agente',NULL,NULL,NULL,'ascendido','2025-06-01 00:08:30','00:00:00',NULL,1),(141,'FYRGV','Agente','SHN- Iniciado I',NULL,NULL,'ascendido','2025-06-01 04:07:29','00:00:00',NULL,1),(142,'D3JPZ','Agente','SHN- Iniciado I',NULL,NULL,'ascendido','2025-06-01 04:21:58','00:00:00',NULL,1),(143,'RQNSL','Agente','SHN- Iniciado I',NULL,NULL,'ascendido','2025-06-01 04:45:31','00:00:00',NULL,1),(144,'XLDP5','Agente','SHN- Iniciado I',NULL,NULL,'Ascendido','2025-06-01 18:05:35','00:10:00',NULL,1),(145,'XP9FH','Agente','SHN- Iniciado I',NULL,NULL,'Ascendido','2025-06-02 04:28:59','00:10:00',NULL,1),(146,'F4WTC','tecnico','SHN- Auxiliar G -MPM #T',NULL,'MPM','ascendido','2025-06-03 16:29:28','10:29:28','maria51162',1),(147,'QF3Z9','Junta directiva','SHN- Junta directiva -DEV','DEV',NULL,'Ascendido','2025-06-02 14:43:31','00:00:00',NULL,1),(148,'E9JY3','Seguridad','SHN- Iniciado I',NULL,'MPM','disponible','2025-06-02 23:42:34','00:00:00','maria51162',0),(149,'PW5JN','agente','SHN- Novato H -- #A',NULL,NULL,'disponible','2025-06-02 21:21:25','00:00:00','santidemg2',1),(150,'ZVYN6','Agente','SHN- Iniciado I',NULL,NULL,'Ascendido','2025-06-03 19:16:34','00:10:00',NULL,1),(151,'A8UEJ','agente','SHN- Intermedio D -MPM #A',NULL,'MPM','ascendido','2025-06-03 17:21:10','17:31:10','maria51162',1);
/*!40000 ALTER TABLE `ascensos_backup_20250601` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auditoria_ascensos`
--

DROP TABLE IF EXISTS `auditoria_ascensos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auditoria_ascensos` (
  `id_auditoria` int NOT NULL AUTO_INCREMENT,
  `fecha_cambio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `codigo_time` varchar(50) DEFAULT NULL,
  `nombre_habbo` varchar(50) DEFAULT NULL,
  `rango_anterior` varchar(50) DEFAULT NULL,
  `rango_nuevo` varchar(50) DEFAULT NULL,
  `mision_anterior` varchar(255) DEFAULT NULL,
  `mision_nueva` varchar(255) DEFAULT NULL,
  `firma_anterior` varchar(3) DEFAULT NULL,
  `firma_nueva` varchar(3) DEFAULT NULL,
  `usuario_modificador` varchar(50) DEFAULT NULL,
  `ip_modificacion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_auditoria`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditoria_ascensos`
--

LOCK TABLES `auditoria_ascensos` WRITE;
/*!40000 ALTER TABLE `auditoria_ascensos` DISABLE KEYS */;
INSERT INTO `auditoria_ascensos` VALUES (1,'2025-06-05 15:56:50','Q87HE','Jefferso1142','tecnico','tecnico','SHN- TEC- Novato H -MPM #T','SHN- Novato H -MPM #T',NULL,NULL,NULL,NULL),(2,'2025-06-05 15:58:42','S0T1U','Snotra','Fundador','Fundador','Fundador','SHN- Fundadora -ADL','ADL','ADL',NULL,NULL),(3,'2025-06-05 16:01:41','MAKQW','The-Wick!!','fundador','fundador','Fundador','SHN- Fundador -XXX','XXX','XXX',NULL,NULL),(4,'2025-06-05 16:02:34','YE94X','Ryoma_','Junta directiva','Junta directiva','Junta directiva','SHN- Junta Directiva -RYO','RYO','RYO',NULL,NULL),(5,'2025-06-05 16:54:02','R93M2','Brave','Agente','Agente','SHN- Iniciado I','SHN- Iniciado I',NULL,NULL,NULL,NULL),(6,'2025-06-05 16:54:10','R93M2','Brave','Agente','Agente','SHN- Iniciado I','SHN- Iniciado I',NULL,NULL,NULL,NULL),(7,'2025-06-05 16:54:12','R93M2','Brave','Agente','Agente','SHN- Iniciado I','SHN- Iniciado I',NULL,NULL,NULL,NULL),(8,'2025-06-05 16:54:26','R93M2','Brave','Agente','Agente','SHN- Iniciado I','SHN- Iniciado I',NULL,NULL,NULL,NULL),(9,'2025-06-05 16:59:22','R93M2','Brave','Agente','Agente','SHN- Iniciado I','SHN- Iniciado I',NULL,NULL,NULL,NULL),(10,'2025-06-05 16:59:59','R93M2','Brave','Agente','Agente','SHN- Iniciado I','SHN- Iniciado I',NULL,NULL,NULL,NULL),(11,'2025-06-05 17:04:33','R93M2','Brave','Agente','agente','SHN- Iniciado I','SHN- Novato H -JOC #A',NULL,NULL,NULL,NULL),(12,'2025-06-05 17:06:36','R93M2','Brave','agente','agente','SHN- Novato H -JOC #A','SHN- Novato H -JOC #A',NULL,NULL,NULL,NULL),(13,'2025-06-05 17:08:00','R93M2','Brave','agente','agente','SHN- Novato H -JOC #A','SHN- Novato H -JOC #A',NULL,NULL,NULL,NULL),(14,'2025-06-05 17:08:23','R93M2','Brave','agente','agente','SHN- Novato H -JOC #A','SHN- Novato H -JOC #A',NULL,NULL,NULL,NULL),(15,'2025-06-05 17:09:50','R93M2','Brave','agente','agente','SHN- Novato H -JOC #A','SHN- Novato H -JOC #A',NULL,NULL,NULL,NULL),(16,'2025-06-05 17:10:10','R93M2','Brave','agente','agente','SHN- Novato H -JOC #A','SHN- Novato H -JOC #A',NULL,NULL,NULL,NULL),(17,'2025-06-05 17:12:58','R93M2','Brave','agente','agente','SHN- Novato H -JOC #A','SHN- Novato H -JOC #A',NULL,NULL,NULL,NULL),(18,'2025-06-05 17:14:56','R93M2','Brave','agente','agente','SHN- Novato H -JOC #A','SHN- Novato H -JOC #A',NULL,NULL,NULL,NULL),(19,'2025-06-05 17:17:12','R93M2','_Brave','agente','agente','SHN- Novato H -JOC #A','SHN- Auxiliar G -JOC #A',NULL,NULL,NULL,NULL),(20,'2025-06-05 23:09:39','P5BRQ','dohabbob000','seguridad','seguridad','SHN- Iniciado I -NEF #S','SHN- Iniciado I -NEF #S',NULL,NULL,NULL,NULL),(21,'2025-06-05 23:10:09','P5BRQ','dohabbob000','seguridad','seguridad','SHN- Iniciado I -NEF #S','SHN- Novato H -DEV #S',NULL,NULL,NULL,NULL),(22,'2025-06-05 23:37:39','4589A','reivaj421984','seguridad','seguridad','SHN- Auxiliar G -TRT #S','SHN- Auxiliar G -TRT #S',NULL,NULL,NULL,NULL),(23,'2025-06-05 23:37:42','E9JY3','diabl4','seguridad','seguridad','SHN- Novato H -DEV #S','SHN- Novato H -DEV #S',NULL,NULL,NULL,NULL),(24,'2025-06-06 15:45:19','P5BRQ','dohabbob000','seguridad','seguridad','SHN- Novato H -DEV #S','SHN- Novato H -DEV #S',NULL,NULL,NULL,NULL),(25,'2025-06-06 15:45:31','P5BRQ','dohabbob000','seguridad','seguridad','SHN- Novato H -DEV #S','SHN- Auxiliar G -DEV #S',NULL,NULL,NULL,NULL),(26,'2025-06-06 15:58:25','P5BRQ','dohabbob000','seguridad','seguridad','SHN- Auxiliar G -DEV #S','SHN- Auxiliar G -DEV #S',NULL,NULL,NULL,NULL),(27,'2025-06-06 15:58:29','P5BRQ','dohabbob000','seguridad','seguridad','SHN- Auxiliar G -DEV #S','SHN- Auxiliar G -DEV #S',NULL,NULL,NULL,NULL),(28,'2025-06-07 08:57:37','R93M2','_Brave','agente','agente','SHN- Auxiliar G -JOC #A','SHN- Auxiliar G -JOC #A',NULL,NULL,NULL,NULL),(29,'2025-06-07 19:38:01','5SRM9','no','Agente','Agente','SHN- Iniciado I','SHN- Iniciado I',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `auditoria_ascensos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auditoria_passwords`
--

DROP TABLE IF EXISTS `auditoria_passwords`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auditoria_passwords` (
  `id_auditoria` int NOT NULL AUTO_INCREMENT,
  `fecha_cambio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` int DEFAULT NULL,
  `nombre_habbo` varchar(50) DEFAULT NULL,
  `usuario_modificador` varchar(50) DEFAULT NULL,
  `ip_modificacion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_auditoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditoria_passwords`
--

LOCK TABLES `auditoria_passwords` WRITE;
/*!40000 ALTER TABLE `auditoria_passwords` DISABLE KEYS */;
/*!40000 ALTER TABLE `auditoria_passwords` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestion_notificaciones`
--

DROP TABLE IF EXISTS `gestion_notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gestion_notificaciones` (
  `notificacion_id` int NOT NULL AUTO_INCREMENT,
  `notificacion_mensaje` varchar(40) NOT NULL,
  `notificacion_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_id` int DEFAULT NULL,
  `id_encargado` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`notificacion_id`),
  KEY `fk_usuario_notificacion` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_notificaciones`
--

LOCK TABLES `gestion_notificaciones` WRITE;
/*!40000 ALTER TABLE `gestion_notificaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `gestion_notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestion_pagas`
--

DROP TABLE IF EXISTS `gestion_pagas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gestion_pagas` (
  `pagas_id` int NOT NULL AUTO_INCREMENT,
  `pagas_usuario` varchar(16) NOT NULL,
  `pagas_rango` varchar(40) NOT NULL,
  `pagas_recibio` int NOT NULL,
  `pagas_motivo` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pagas_completo` varchar(40) NOT NULL,
  `pagas_descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pagas_fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pagas_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_pagas`
--

LOCK TABLES `gestion_pagas` WRITE;
/*!40000 ALTER TABLE `gestion_pagas` DISABLE KEYS */;
INSERT INTO `gestion_pagas` VALUES (1,'santidemg2','Web_master',0,'Pago realizado','1','No aplica pago','2025-06-05 03:43:27'),(2,'Devilthew','Junta directiva',32,'Cumplimiento total','1','Recibió 32c por cumplimiento total (Nómina: 12c, Bonificación: 20c)','2025-06-07 19:36:18');
/*!40000 ALTER TABLE `gestion_pagas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestion_quejas`
--

DROP TABLE IF EXISTS `gestion_quejas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gestion_quejas` (
  `quejda_id` int NOT NULL AUTO_INCREMENT,
  `queja_usuario` varchar(20) NOT NULL,
  `queja_asunto` varchar(30) NOT NULL,
  `queja_descripcion` varchar(255) NOT NULL,
  `queja_fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`quejda_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_quejas`
--

LOCK TABLES `gestion_quejas` WRITE;
/*!40000 ALTER TABLE `gestion_quejas` DISABLE KEYS */;
INSERT INTO `gestion_quejas` VALUES (5,'Santidemg2','Problemas con mi dispositivo','no es compatible mi celular','2025-05-27 21:00:56'),(6,'TurtlerabbittC','sistema','No me da la opción de dar ascensos','2025-05-28 18:19:19');
/*!40000 ALTER TABLE `gestion_quejas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestion_rangos`
--

DROP TABLE IF EXISTS `gestion_rangos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gestion_rangos` (
  `rangov_id` int NOT NULL AUTO_INCREMENT,
  `rangov_tipo` varchar(50) DEFAULT NULL,
  `rangov_rango_anterior` varchar(100) DEFAULT NULL,
  `rangov_mision_anterior` varchar(100) DEFAULT NULL,
  `rangov_rango_nuevo` varchar(100) DEFAULT NULL,
  `rangov_mision_nuevo` varchar(100) DEFAULT NULL,
  `rangov_comprador` varchar(100) DEFAULT NULL,
  `rangov_vendedor` varchar(100) DEFAULT NULL,
  `rangov_fecha` datetime DEFAULT NULL,
  `rangov_firma_usuario` varchar(100) DEFAULT NULL,
  `rangov_firma_encargado` varchar(100) DEFAULT NULL,
  `rangov_costo` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`rangov_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_rangos`
--

LOCK TABLES `gestion_rangos` WRITE;
/*!40000 ALTER TABLE `gestion_rangos` DISABLE KEYS */;
INSERT INTO `gestion_rangos` VALUES (1,'Presidente',NULL,NULL,NULL,NULL,'TereStar','The-Wick','2025-05-30 00:38:39','RUS','TER',80.00);
/*!40000 ALTER TABLE `gestion_rangos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestion_requisitos`
--

DROP TABLE IF EXISTS `gestion_requisitos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gestion_requisitos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `requirement_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `times_as_encargado_count` int DEFAULT '0',
  `ascensos_as_encargado_count` int DEFAULT '0',
  `is_completed` varchar(50) DEFAULT NULL,
  `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_codigo_time` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_requisitos`
--

LOCK TABLES `gestion_requisitos` WRITE;
/*!40000 ALTER TABLE `gestion_requisitos` DISABLE KEYS */;
INSERT INTO `gestion_requisitos` VALUES (1,'Devilthew','No completo',1,0,'0','2025-06-07 19:36:39'),(2,'santidemg2','Completó todos sus requisitos',0,14,'1','2025-06-05 03:43:27');
/*!40000 ALTER TABLE `gestion_requisitos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestion_tiempo`
--

DROP TABLE IF EXISTS `gestion_tiempo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gestion_tiempo` (
  `tiempo_id` int NOT NULL AUTO_INCREMENT,
  `codigo_time` varchar(5) NOT NULL,
  `tiempo_status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'disponible',
  `tiempo_restado` time DEFAULT '00:00:00',
  `tiempo_acumulado` time DEFAULT '00:00:00',
  `tiempo_transcurrido` time DEFAULT '00:00:00',
  `tiempo_encargado_usuario` varchar(50) DEFAULT NULL,
  `tiempo_fecha_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `tiempo_iniciado` time DEFAULT NULL,
  PRIMARY KEY (`tiempo_id`),
  KEY `idx_codigo_time` (`codigo_time`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_tiempo`
--

LOCK TABLES `gestion_tiempo` WRITE;
/*!40000 ALTER TABLE `gestion_tiempo` DISABLE KEYS */;
INSERT INTO `gestion_tiempo` VALUES (3,'TSZU8','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-11 06:44:08','00:00:00'),(4,'G9DNE','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-11 15:45:46','00:00:00'),(5,'SD6JZ','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-11 17:18:54','00:00:00'),(6,'WTPUQ','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-11 17:48:07','00:00:00'),(7,'8VPXJ','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-11 17:53:29','00:00:00'),(8,'86DAS','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-11 17:54:30','00:00:00'),(9,'YA4E9','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-11 19:01:01','00:00:00'),(10,'HAN7Q','pausa','00:00:00','01:10:13','00:00:00',NULL,'2025-05-11 20:12:28','00:00:00'),(11,'FNJQ5','pausa','00:00:00','01:39:16','00:00:00',NULL,'2025-05-11 20:29:40','00:00:00'),(12,'QH2HW','completado','00:00:00','02:21:57','00:00:00',NULL,'2025-05-11 23:27:49','00:00:00'),(13,'ATPWD','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-12 00:59:29','00:00:00'),(14,'2RTN3','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-12 01:04:04','00:00:00'),(15,'RLLGR','pausa','00:00:00','07:08:47','00:00:00',NULL,'2025-05-12 01:15:17','00:00:00'),(16,'Q87HE','pausa','00:00:00','02:05:45','00:00:00',NULL,'2025-05-12 04:35:26','00:00:00'),(17,'AAFGM','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-12 14:35:54','00:00:00'),(18,'YE94X','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-12 15:14:05','00:00:00'),(19,'FP898','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-12 17:17:33','00:00:00'),(20,'8WS42','completado','00:00:00','05:03:50','00:00:00',NULL,'2025-05-12 17:51:08','00:00:00'),(21,'TNF7R','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-12 20:39:36','00:00:00'),(22,'DGUWQ','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-12 20:57:08','00:00:00'),(23,'5W8W2','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-12 21:05:35','00:00:00'),(24,'2QPCG','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-12 23:22:48','00:00:00'),(25,'UWU9J','pausa','00:00:00','04:19:21','00:00:00',NULL,'2025-05-13 01:15:58','00:00:00'),(28,'FP898','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-13 04:43:32','00:00:00'),(29,'6CVD6','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-13 04:53:36','00:00:00'),(30,'GFX8C','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-13 08:35:34','00:00:00'),(31,'5T7X8','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-13 16:20:14','00:00:00'),(32,'DXNCH','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-13 17:18:19','00:00:00'),(33,'CQZKU','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-14 20:56:21','00:00:00'),(34,'EXHE5','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-14 22:35:10','00:00:00'),(35,'MAKQW','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-19 05:08:08','00:00:00'),(38,'2DHTY','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-26 10:10:14','00:00:00'),(39,'3NBMN','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-26 15:46:26','00:00:00'),(40,'E7BU3','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-26 16:32:28','00:00:00'),(41,'ULG6G','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-26 16:41:07','00:00:00'),(42,'W86CD','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-26 16:50:23','00:00:00'),(43,'AEXPY','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-26 18:12:14','00:00:00'),(44,'4589A','pausa','00:00:00','07:13:38','00:00:00',NULL,'2025-05-26 18:12:43','00:00:00'),(45,'J4K5L','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-28 20:40:08','00:00:00'),(46,'YRF42','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-28 21:44:37','00:00:00'),(47,'LAVBY','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-29 05:16:18','00:00:00'),(48,'GN3YM','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-29 13:16:05','00:00:00'),(49,'QNAZE','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-29 23:17:03','00:00:00'),(50,'WQU2L','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-30 00:02:53','00:00:00'),(51,'EGPDW','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-30 18:41:22','00:00:00'),(52,'VACRG','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-30 18:52:49','00:00:00'),(53,'TFJB9','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-30 19:12:39','00:00:00'),(54,'UNKJS','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-05-31 21:05:15','00:00:00'),(55,'RG379','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-06-01 00:08:30','00:00:00'),(56,'J6YNZ','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-06-01 03:38:53','00:00:00'),(57,'FYRGV','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-06-01 04:07:29','00:00:00'),(58,'D3JPZ','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-06-01 04:21:58','00:00:00'),(59,'RQNSL','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-06-01 04:45:31','00:00:00'),(60,'XLDP5','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-06-01 18:05:35','00:00:00'),(61,'XP9FH','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-06-02 04:28:59','00:00:00'),(62,'F4WTC','pausado','00:00:00','04:50:00','00:00:00',NULL,'2025-06-02 04:36:51','00:00:00'),(63,'QF3Z9','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-06-02 14:43:31','00:00:00'),(64,'E9JY3','completado','00:00:00','07:14:49','00:00:00',NULL,'2025-06-02 23:42:34','00:00:00'),(65,'PW5JN','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-06-03 02:50:55','00:00:00'),(66,'BJ5Z3','completado','00:00:00','07:20:42','00:00:00',NULL,'2025-06-03 19:16:34','00:00:00'),(67,'A8UEJ','completado','00:00:00','07:14:47','00:00:00',NULL,'2025-06-03 22:06:48','00:00:00'),(68,'P5BRQ','completado','00:00:00','07:55:13','00:00:00',NULL,'2025-06-04 00:29:38','00:00:00'),(69,'F4WTC','pausa','00:00:00','04:50:00','00:00:00',NULL,'2025-06-05 13:33:49','00:00:00'),(70,'R93M2','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-06-05 16:37:10','00:00:00'),(71,'5SRM9','pausa','00:00:00','00:00:00','00:00:00',NULL,'2025-06-06 14:06:47','00:00:00');
/*!40000 ALTER TABLE `gestion_tiempo` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`agencia_user`@`%`*/ /*!50003 TRIGGER `historial_tiempos_pausa` AFTER UPDATE ON `gestion_tiempo` FOR EACH ROW BEGIN 
    IF NEW.tiempo_status = 'pausa' THEN 
        INSERT INTO historial_tiempos (
            codigo_time, 
            tiempo_acumulado, 
            tiempo_transcurrido, 
            tiempo_encargado_usuario, 
            tiempo_fecha_registro
        ) VALUES (
            OLD.codigo_time, 
            OLD.tiempo_acumulado, 
            OLD.tiempo_transcurrido, 
            OLD.tiempo_encargado_usuario, 
            NOW()
        ); 
    END IF; 
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `gestion_ventas`
--

DROP TABLE IF EXISTS `gestion_ventas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gestion_ventas` (
  `venta_id` int NOT NULL AUTO_INCREMENT,
  `venta_titulo` varchar(100) NOT NULL,
  `venta_compra` datetime NOT NULL,
  `venta_caducidad` datetime NOT NULL,
  `venta_estado` varchar(20) NOT NULL,
  `venta_costo` decimal(10,2) NOT NULL,
  `venta_comprador` int DEFAULT NULL,
  `comprador_externo` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `venta_encargado` varchar(30) DEFAULT NULL,
  `venta_fecha_compra` datetime DEFAULT NULL,
  PRIMARY KEY (`venta_id`),
  KEY `venta_comprador` (`venta_comprador`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_ventas`
--

LOCK TABLES `gestion_ventas` WRITE;
/*!40000 ALTER TABLE `gestion_ventas` DISABLE KEYS */;
INSERT INTO `gestion_ventas` VALUES (14,'Membresía Gold','2025-05-30 00:00:00','2025-06-30 00:00:00','Activo',40.00,106,NULL,'Jo.C','2025-05-30 00:00:00'),(20,'Membresía VIP','2025-06-02 00:00:00','2030-12-31 00:00:00','Activo',15.00,NULL,'damg_1073','maria51162','2025-06-02 00:00:00'),(21,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(22,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(23,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(24,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(25,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(26,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(27,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(28,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(29,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(30,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(31,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(32,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(33,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(34,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,59,NULL,'rinuu','2205-06-05 00:00:00'),(35,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,39,NULL,'rinuu','2205-06-05 00:00:00'),(36,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,39,NULL,'rinuu','2205-06-05 00:00:00'),(37,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,39,NULL,'rinuu','2205-06-05 00:00:00'),(38,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,39,NULL,'rinuu','2205-06-05 00:00:00'),(39,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,39,NULL,'rinuu','2205-06-05 00:00:00'),(40,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(41,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(42,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(43,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(44,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(45,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(46,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(47,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(48,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(49,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(50,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(51,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(52,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(53,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(54,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(55,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(56,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(57,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(58,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(59,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,34,NULL,'rinuu','2205-06-05 00:00:00'),(60,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,129,NULL,'rinuu','2205-06-05 00:00:00'),(61,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,129,NULL,'rinuu','2205-06-05 00:00:00'),(62,'Membresía Gold','2205-06-05 00:00:00','2205-07-05 00:00:00','Activo',40.00,129,NULL,'rinuu','2205-06-05 00:00:00'),(63,'Membresía Gold','2025-06-05 00:00:00','2025-07-05 00:00:00','Activo',40.00,129,NULL,'rinuu','2025-06-05 00:00:00'),(64,'Membresía Gold','2025-05-06 00:00:00','2025-06-06 00:00:00','Activo',40.00,129,NULL,'rinuu','2025-05-06 00:00:00');
/*!40000 ALTER TABLE `gestion_ventas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_ascensos`
--

DROP TABLE IF EXISTS `historial_ascensos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_ascensos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo_time` varchar(10) DEFAULT NULL,
  `rango_actual` varchar(50) DEFAULT NULL,
  `mision_actual` varchar(255) DEFAULT NULL,
  `firma_usuario` varchar(10) DEFAULT NULL,
  `firma_encargado` varchar(10) DEFAULT NULL,
  `estado_ascenso` varchar(50) DEFAULT NULL,
  `fecha_ultimo_ascenso` datetime DEFAULT NULL,
  `fecha_disponible_ascenso` datetime DEFAULT NULL,
  `usuario_encargado` varchar(100) DEFAULT NULL,
  `accion` varchar(20) DEFAULT NULL,
  `realizado_por` varchar(100) DEFAULT NULL,
  `fecha_accion` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_ascensos`
--

LOCK TABLES `historial_ascensos` WRITE;
/*!40000 ALTER TABLE `historial_ascensos` DISABLE KEYS */;
INSERT INTO `historial_ascensos` VALUES (21,'FNJQ5','supervisor','SHN- Jefe A -RGO -MPM #S','RGO','MPM','ascendido','2025-06-02 15:42:31','2025-06-02 15:42:31','maria51162','ascendido','maria51162','2025-06-02 21:42:31'),(22,'FNJQ5','supervisor','SHN- Jefe A -RGO -MPM #S','RGO','MPM','ascendido','2025-06-02 15:42:31','2025-06-05 23:59:11','maria51162','ascendido','maria51162','2025-06-02 21:43:20'),(56,'E9JY3','Seguridad','SHN- Iniciado I','DIB','MPM','disponible','2025-06-02 23:42:34','2025-06-03 00:00:00','maria51162','ascendido','maria51162','2025-06-03 04:36:54'),(63,'RLLGR','director','SHN- Intermedio D -REY -MPM #D','REY','MPM','ascendido','2025-06-03 15:37:47','2025-06-03 15:37:47','maria51162','ascendido','maria51162','2025-06-03 21:37:47'),(64,'RLLGR','director','SHN- Intermedio D -REY -MPM #D','REY','MPM','ascendido','2025-06-03 15:37:47','2025-06-11 23:58:55','maria51162','ascendido','maria51162','2025-06-03 21:38:52'),(78,'RLLGR','director','SHN- Intermedio D -REY -MPM #D','REY','MPM','ascendido','2025-06-03 15:37:47','2025-06-03 00:00:00','maria51162','ascendido','maria51162','2025-06-03 22:17:59'),(79,'RLLGR','director','SHN- Intermedio D -REY -MPM #D','REY','MPM','ascendido','2025-06-03 15:37:47','2025-06-11 23:19:39','maria51162','ascendido','maria51162','2025-06-03 22:18:08'),(80,'RLLGR','director','SHN- Intermedio D -REY -MPM #D','REY','MPM','ascendido','2025-06-03 15:37:47','2025-06-03 00:00:00','maria51162','ascendido','maria51162','2025-06-03 22:18:17'),(81,'RLLGR','director','SHN- Intermedio D -REY -MPM #D','REY','MPM','disponible','2025-06-03 15:37:47','2025-06-03 00:00:00','maria51162','ascendido','maria51162','2025-06-03 22:18:42'),(82,'RLLGR','director','SHN- Avanzado C -REY -MPM #D','REY','MPM','ascendido','2025-06-03 16:19:46','2025-06-03 16:19:46','maria51162','ascendido','maria51162','2025-06-03 22:19:46'),(83,'RLLGR','director','SHN- Avanzado C -REY -MPM #D','REY','MPM','ascendido','2025-06-03 16:19:46','2025-06-11 23:59:27','maria51162','ascendido','maria51162','2025-06-03 22:20:19'),(142,'F4WTC','tecnico','SHN- Auxiliar G -MPM #T',NULL,'MPM','disponible','2025-06-03 16:29:28','2025-06-05 00:00:00','maria51162','ascendido','maria51162','2025-06-05 05:21:01'),(143,'Q87HE','tecnico','SHN- Novato H -MPM #T',NULL,NULL,'disponible','2025-05-31 05:41:51','2025-06-05 00:00:00',NULL,'ascendido',NULL,'2025-06-05 15:56:50'),(144,'S0T1U','Fundador','SHN- Fundadora -ADL','ADL',NULL,'ascendido','2025-05-31 06:05:36','2025-06-05 00:00:00',NULL,'ascendido',NULL,'2025-06-05 15:58:42'),(145,'MAKQW','fundador','SHN- Fundador -XXX','XXX',NULL,'ascendido','2025-05-31 06:05:36','2025-06-05 00:00:00',NULL,'ascendido',NULL,'2025-06-05 16:01:41'),(146,'YE94X','Junta directiva','SHN- Junta Directiva -RYO','RYO','ADL','ascendido','2025-05-31 06:05:36','2025-06-05 00:00:00',NULL,'ascendido',NULL,'2025-06-05 16:02:34'),(147,'R93M2','Agente','SHN- Iniciado I',NULL,NULL,'Ascendido','2025-06-05 16:37:10','2025-06-05 05:53:08',NULL,'ascendido',NULL,'2025-06-05 16:54:02'),(148,'R93M2','Agente','SHN- Iniciado I',NULL,NULL,'Ascendido','2025-06-05 16:37:10','2025-06-05 05:53:00',NULL,'ascendido',NULL,'2025-06-05 16:54:10'),(149,'R93M2','Agente','SHN- Iniciado I',NULL,NULL,'Ascendido','2025-06-05 16:37:10','2025-06-05 05:52:58',NULL,'ascendido',NULL,'2025-06-05 16:54:12'),(150,'R93M2','Agente','SHN- Iniciado I',NULL,NULL,'Ascendido','2025-06-05 16:37:10','2025-06-05 05:52:44',NULL,'ascendido',NULL,'2025-06-05 16:54:26'),(151,'R93M2','Agente','SHN- Iniciado I',NULL,NULL,'Ascendido','2025-06-05 16:37:10','2025-06-05 00:00:00',NULL,'ascendido',NULL,'2025-06-05 16:59:22'),(152,'R93M2','Agente','SHN- Iniciado I',NULL,NULL,'disponible','2025-06-05 16:37:10','2025-06-05 00:00:00',NULL,'ascendido',NULL,'2025-06-05 16:59:59'),(153,'R93M2','agente','SHN- Novato H -JOC #A',NULL,'JOC','ascendido','2025-06-05 11:04:33','2025-06-05 11:14:33','Jo.c','ascendido','Jo.c','2025-06-05 17:04:33'),(154,'R93M2','agente','SHN- Novato H -JOC #A',NULL,'JOC','ascendido','2025-06-05 11:04:33','2025-06-05 00:07:57','Jo.c','ascendido','Jo.c','2025-06-05 17:06:36'),(155,'R93M2','agente','SHN- Novato H -JOC #A',NULL,'JOC','ascendido','2025-06-05 11:04:33','2025-06-05 00:06:33','Jo.c','ascendido','Jo.c','2025-06-05 17:08:00'),(156,'R93M2','agente','SHN- Novato H -JOC #A',NULL,'JOC','ascendido','2025-06-05 11:04:33','2025-06-05 00:06:10','Jo.c','ascendido','Jo.c','2025-06-05 17:08:23'),(157,'R93M2','agente','SHN- Novato H -JOC #A',NULL,'JOC','ascendido','2025-06-05 11:04:33','2025-06-05 00:04:43','Jo.c','ascendido','Jo.c','2025-06-05 17:09:50'),(158,'R93M2','agente','SHN- Novato H -JOC #A',NULL,'JOC','ascendido','2025-06-05 11:04:33','2025-06-05 00:04:23','Jo.c','ascendido','Jo.c','2025-06-05 17:10:10'),(159,'R93M2','agente','SHN- Novato H -JOC #A',NULL,'JOC','ascendido','2025-06-05 11:04:33','2025-06-05 00:01:35','Jo.c','ascendido','Jo.c','2025-06-05 17:12:58'),(160,'R93M2','agente','SHN- Novato H -JOC #A',NULL,'JOC','disponible','2025-06-05 11:04:33','2025-06-05 00:00:00','Jo.c','ascendido','Jo.c','2025-06-05 17:14:56'),(161,'R93M2','agente','SHN- Auxiliar G -JOC #A',NULL,'JOC','ascendido','2025-06-05 11:17:12','2025-06-05 11:27:12','Jo.c','ascendido','Jo.c','2025-06-05 17:17:12'),(162,'P5BRQ','seguridad','SHN- Iniciado I -NEF #S',NULL,'NEF','disponible','2025-06-03 21:36:36','2025-06-05 00:00:00','nefita','ascendido','nefita','2025-06-05 23:09:39'),(163,'P5BRQ','seguridad','SHN- Novato H -DEV #S',NULL,'DEV','ascendido','2025-06-05 17:10:09','2025-06-05 21:10:09','Devilthew','ascendido','Devilthew','2025-06-05 23:10:09'),(164,'4589A','seguridad','SHN- Auxiliar G -TRT #S',NULL,'TRT','disponible','2025-06-02 20:21:55','2025-06-05 00:00:00','turtlerabbittc','ascendido','turtlerabbittc','2025-06-05 23:37:39'),(165,'E9JY3','seguridad','SHN- Novato H -DEV #S',NULL,'DEV','disponible','2025-06-04 15:39:42','2025-06-05 00:00:00','Devilthew','ascendido','Devilthew','2025-06-05 23:37:42'),(166,'P5BRQ','seguridad','SHN- Novato H -DEV #S',NULL,'DEV','disponible','2025-06-05 17:10:09','2025-06-06 00:00:00','Devilthew','ascendido','Devilthew','2025-06-06 15:45:19'),(167,'P5BRQ','seguridad','SHN- Auxiliar G -DEV #S',NULL,'DEV','ascendido','2025-06-06 09:45:31','2025-06-06 13:45:31','Devilthew','ascendido','Devilthew','2025-06-06 15:45:31'),(168,'P5BRQ','seguridad','SHN- Auxiliar G -DEV #S',NULL,'DEV','ascendido','2025-06-06 09:45:31','2025-06-06 03:47:06','Devilthew','ascendido','Devilthew','2025-06-06 15:58:25'),(169,'P5BRQ','seguridad','SHN- Auxiliar G -DEV #S',NULL,'DEV','ascendido','2025-06-06 09:45:31','2025-06-06 03:47:02','Devilthew','ascendido','Devilthew','2025-06-06 15:58:29'),(170,'R93M2','agente','SHN- Auxiliar G -JOC #A',NULL,'JOC','disponible','2025-06-05 11:17:12','2025-06-07 00:00:00','Jo.c','ascendido','Jo.c','2025-06-07 08:57:37'),(171,'5SRM9','Agente','SHN- Iniciado I',NULL,NULL,'disponible','2025-06-06 14:06:47','2025-06-07 00:00:00',NULL,'ascendido',NULL,'2025-06-07 19:38:01');
/*!40000 ALTER TABLE `historial_ascensos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_tiempos`
--

DROP TABLE IF EXISTS `historial_tiempos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_tiempos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo_time` varchar(50) NOT NULL,
  `tiempo_acumulado` time NOT NULL,
  `tiempo_transcurrido` time NOT NULL,
  `tiempo_encargado_usuario` varchar(100) DEFAULT NULL,
  `tiempo_fecha_registro` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_tiempos`
--

LOCK TABLES `historial_tiempos` WRITE;
/*!40000 ALTER TABLE `historial_tiempos` DISABLE KEYS */;
INSERT INTO `historial_tiempos` VALUES (73,'8VPXJ','00:00:00','00:00:00','Ryoma_','2025-06-01 15:34:43'),(112,'J4K5L','01:18:49','00:00:00','maria51162','2025-06-02 03:29:45'),(128,'Q87HE','00:00:00','00:00:00','maria51162','2025-06-02 20:48:20'),(129,'QH2HW','00:00:00','00:00:00','maria51162','2025-06-02 20:57:43'),(131,'FNJQ5','00:00:00','00:00:00','maria51162','2025-06-02 22:00:30'),(132,'4589A','00:00:00','00:00:00','maria51162','2025-06-03 02:57:37'),(133,'QH2HW','00:52:22','00:00:00','maria51162','2025-06-03 03:19:39'),(134,'8WS42','00:00:00','00:00:00','maria51162','2025-06-03 04:57:14'),(135,'RLLGR','00:00:00','00:00:00','maria51162','2025-06-03 04:57:25'),(136,'8WS42','02:34:22','00:00:00','maria51162','2025-06-03 18:50:27'),(137,'4589A','04:28:12','00:00:00','maria51162','2025-06-03 20:29:42'),(138,'Q87HE','00:44:57','00:00:00','maria51162','2025-06-03 21:21:44'),(142,'UWU9J','00:00:00','00:00:00','maria51162','2025-06-03 22:56:12'),(143,'8WS42','03:15:43','00:00:00','maria51162','2025-06-03 22:56:24'),(144,'A8UEJ','00:00:00','00:00:00','Nefita','2025-06-04 01:46:45'),(145,'HAN7Q','00:00:00','00:00:00','maria51162','2025-06-04 02:13:33'),(146,'4589A','06:52:29','00:00:00','maria51162','2025-06-04 02:13:47'),(147,'BJ5Z3','01:50:00','00:00:00','maria51162','2025-06-04 02:26:34'),(148,'A8UEJ','01:19:30','00:00:00','nefita','2025-06-04 04:55:41'),(149,'E9JY3','00:00:00','00:00:00','Devilthew','2025-06-04 21:09:12'),(150,'E9JY3','00:16:35','00:00:00','Devilthew','2025-06-04 21:11:59'),(151,'E9JY3','00:18:48','00:00:00','Devilthew','2025-06-04 22:07:20'),(152,'F4WTC','02:05:45','00:00:00','Devilthew','2025-06-05 01:58:33'),(153,'P5BRQ','00:00:00','00:00:00','juancBQ','2025-06-05 02:31:52'),(154,'RLLGR','04:59:03','00:00:00','Nefita','2025-06-05 05:57:56'),(155,'BMWZN','00:00:00','00:00:00',NULL,'2025-06-05 16:09:30'),(156,'F4WTC','00:00:00','00:00:00',NULL,'2025-06-05 16:10:41'),(157,'A8UEJ','04:18:07','00:00:00','Jo.c','2025-06-05 17:23:48'),(158,'E9JY3','01:13:05','00:00:00','Devilthew','2025-06-05 20:46:18'),(159,'QH2HW','02:00:28','00:00:00','Devilthew','2025-06-05 20:58:39'),(160,'A8UEJ','05:12:49','00:00:00','Devilthew','2025-06-05 22:27:26'),(161,'P5BRQ','02:07:11','00:00:00','Devilthew','2025-06-05 23:08:39'),(162,'P5BRQ','03:52:22','00:00:00','Devilthew','2025-06-06 01:00:39'),(163,'P5BRQ','05:44:01','00:00:00','Devilthew','2025-06-06 16:02:22'),(164,'P5BRQ','07:09:45','00:00:00','Devilthew','2025-06-06 16:55:48'),(165,'E9JY3','02:13:03','00:00:00','Devilthew','2025-06-07 01:52:24');
/*!40000 ALTER TABLE `historial_tiempos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos_tablas`
--

DROP TABLE IF EXISTS `permisos_tablas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permisos_tablas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rol_id` int DEFAULT NULL,
  `tabla` varchar(50) NOT NULL,
  `puede_leer` tinyint(1) DEFAULT '1',
  `puede_modificar` tinyint(1) DEFAULT '0',
  `puede_eliminar` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rol_id` (`rol_id`),
  CONSTRAINT `permisos_tablas_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=286 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos_tablas`
--

LOCK TABLES `permisos_tablas` WRITE;
/*!40000 ALTER TABLE `permisos_tablas` DISABLE KEYS */;
INSERT INTO `permisos_tablas` VALUES (1,1,'ascensos',1,0,0),(2,2,'ascensos',1,0,0),(3,3,'ascensos',1,0,0),(4,4,'ascensos',1,0,0),(5,5,'ascensos',1,1,0),(6,6,'ascensos',1,1,0),(7,7,'ascensos',1,1,0),(8,8,'ascensos',1,1,0),(9,9,'ascensos',1,1,0),(10,10,'ascensos',1,1,1),(11,11,'ascensos',1,1,1),(12,12,'ascensos',1,1,1),(13,13,'ascensos',1,1,1),(16,1,'gestion_tiempo',1,0,0),(17,2,'gestion_tiempo',1,0,0),(18,3,'gestion_tiempo',1,0,0),(19,4,'gestion_tiempo',1,0,0),(20,5,'gestion_tiempo',1,0,0),(21,6,'gestion_tiempo',1,0,0),(22,7,'gestion_tiempo',1,0,0),(23,8,'gestion_tiempo',1,1,0),(24,9,'gestion_tiempo',1,1,0),(25,10,'gestion_tiempo',1,1,1),(26,11,'gestion_tiempo',1,1,1),(27,12,'gestion_tiempo',1,1,1),(28,13,'gestion_tiempo',1,1,1),(31,1,'registro_usuario',1,0,0),(32,1,'historial_tiempos',1,0,0),(33,1,'historial_ascensos',1,0,0),(34,1,'gestion_ventas',1,0,0),(35,1,'gestion_requisitos',1,0,0),(36,1,'gestion_rangos',1,0,0),(37,1,'gestion_quejas',1,0,0),(38,1,'gestion_pagas',1,0,0),(39,1,'gestion_notificaciones',1,0,0),(40,1,'auditoria_passwords',1,0,0),(41,1,'auditoria_ascensos',1,0,0),(42,2,'registro_usuario',1,0,0),(43,2,'historial_tiempos',1,0,0),(44,2,'historial_ascensos',1,0,0),(45,2,'gestion_ventas',1,0,0),(46,2,'gestion_requisitos',1,0,0),(47,2,'gestion_rangos',1,0,0),(48,2,'gestion_quejas',1,0,0),(49,2,'gestion_pagas',1,0,0),(50,2,'gestion_notificaciones',1,0,0),(51,2,'auditoria_passwords',1,0,0),(52,2,'auditoria_ascensos',1,0,0),(53,3,'registro_usuario',1,0,0),(54,3,'historial_tiempos',1,0,0),(55,3,'historial_ascensos',1,0,0),(56,3,'gestion_ventas',1,0,0),(57,3,'gestion_requisitos',1,0,0),(58,3,'gestion_rangos',1,0,0),(59,3,'gestion_quejas',1,0,0),(60,3,'gestion_pagas',1,0,0),(61,3,'gestion_notificaciones',1,0,0),(62,3,'auditoria_passwords',1,0,0),(63,3,'auditoria_ascensos',1,0,0),(64,4,'registro_usuario',1,0,0),(65,4,'historial_tiempos',1,0,0),(66,4,'historial_ascensos',1,0,0),(67,4,'gestion_ventas',1,0,0),(68,4,'gestion_requisitos',1,0,0),(69,4,'gestion_rangos',1,0,0),(70,4,'gestion_quejas',1,0,0),(71,4,'gestion_pagas',1,0,0),(72,4,'gestion_notificaciones',1,0,0),(73,4,'auditoria_passwords',1,0,0),(74,4,'auditoria_ascensos',1,0,0),(75,5,'registro_usuario',1,0,0),(76,5,'historial_tiempos',1,0,0),(77,5,'historial_ascensos',1,0,0),(78,5,'gestion_ventas',1,0,0),(79,5,'gestion_requisitos',1,0,0),(80,5,'gestion_rangos',1,0,0),(81,5,'gestion_quejas',1,0,0),(82,5,'gestion_pagas',1,0,0),(83,5,'gestion_notificaciones',1,0,0),(84,5,'auditoria_passwords',1,0,0),(85,5,'auditoria_ascensos',1,0,0),(86,6,'registro_usuario',1,0,0),(87,6,'historial_tiempos',1,0,0),(88,6,'historial_ascensos',1,0,0),(89,6,'gestion_ventas',1,0,0),(90,6,'gestion_requisitos',1,0,0),(91,6,'gestion_rangos',1,0,0),(92,6,'gestion_quejas',1,0,0),(93,6,'gestion_pagas',1,0,0),(94,6,'gestion_notificaciones',1,0,0),(95,6,'auditoria_passwords',1,0,0),(96,6,'auditoria_ascensos',1,0,0),(97,7,'registro_usuario',1,0,0),(98,7,'historial_tiempos',1,0,0),(99,7,'historial_ascensos',1,0,0),(100,7,'gestion_ventas',1,0,0),(101,7,'gestion_requisitos',1,0,0),(102,7,'gestion_rangos',1,0,0),(103,7,'gestion_quejas',1,0,0),(104,7,'gestion_pagas',1,0,0),(105,7,'gestion_notificaciones',1,0,0),(106,7,'auditoria_passwords',1,0,0),(107,7,'auditoria_ascensos',1,0,0),(108,8,'registro_usuario',1,0,0),(109,8,'historial_tiempos',1,0,0),(110,8,'historial_ascensos',1,0,0),(111,8,'gestion_ventas',1,0,0),(112,8,'gestion_requisitos',1,0,0),(113,8,'gestion_rangos',1,0,0),(114,8,'gestion_quejas',1,0,0),(115,8,'gestion_pagas',1,0,0),(116,8,'gestion_notificaciones',1,0,0),(117,8,'auditoria_passwords',1,0,0),(118,8,'auditoria_ascensos',1,0,0),(119,9,'registro_usuario',1,0,0),(120,9,'historial_tiempos',1,0,0),(121,9,'historial_ascensos',1,0,0),(122,9,'gestion_ventas',1,0,0),(123,9,'gestion_requisitos',1,0,0),(124,9,'gestion_rangos',1,0,0),(125,9,'gestion_quejas',1,0,0),(126,9,'gestion_pagas',1,0,0),(127,9,'gestion_notificaciones',1,0,0),(128,9,'auditoria_passwords',1,0,0),(129,9,'auditoria_ascensos',1,0,0),(130,10,'registro_usuario',1,1,1),(131,10,'historial_tiempos',1,1,1),(132,10,'historial_ascensos',1,1,1),(133,10,'gestion_ventas',1,1,1),(134,10,'gestion_requisitos',1,1,1),(135,10,'gestion_rangos',1,1,1),(136,10,'gestion_quejas',1,1,1),(137,10,'gestion_pagas',1,1,1),(138,10,'gestion_notificaciones',1,1,1),(139,10,'auditoria_passwords',1,1,1),(140,10,'auditoria_ascensos',1,1,1),(141,11,'registro_usuario',1,1,1),(142,11,'historial_tiempos',1,1,1),(143,11,'historial_ascensos',1,1,1),(144,11,'gestion_ventas',1,1,1),(145,11,'gestion_requisitos',1,1,1),(146,11,'gestion_rangos',1,1,1),(147,11,'gestion_quejas',1,1,1),(148,11,'gestion_pagas',1,1,1),(149,11,'gestion_notificaciones',1,1,1),(150,11,'auditoria_passwords',1,1,1),(151,11,'auditoria_ascensos',1,1,1),(152,12,'registro_usuario',1,1,1),(153,12,'historial_tiempos',1,1,1),(154,12,'historial_ascensos',1,1,1),(155,12,'gestion_ventas',1,1,1),(156,12,'gestion_requisitos',1,1,1),(157,12,'gestion_rangos',1,1,1),(158,12,'gestion_quejas',1,1,1),(159,12,'gestion_pagas',1,1,1),(160,12,'gestion_notificaciones',1,1,1),(161,12,'auditoria_passwords',1,1,1),(162,12,'auditoria_ascensos',1,1,1),(163,13,'registro_usuario',1,1,1),(164,13,'historial_tiempos',1,1,1),(165,13,'historial_ascensos',1,1,1),(166,13,'gestion_ventas',1,1,1),(167,13,'gestion_requisitos',1,1,1),(168,13,'gestion_rangos',1,1,1),(169,13,'gestion_quejas',1,1,1),(170,13,'gestion_pagas',1,1,1),(171,13,'gestion_notificaciones',1,1,1),(172,13,'auditoria_passwords',1,1,1),(173,13,'auditoria_ascensos',1,1,1);
/*!40000 ALTER TABLE `permisos_tablas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registro_usuario`
--

DROP TABLE IF EXISTS `registro_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro_usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario_registro` varchar(50) NOT NULL,
  `password_registro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rol_id` varchar(255) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_registro` varchar(30) NOT NULL,
  `nombre_habbo` varchar(50) DEFAULT NULL,
  `codigo_time` varchar(5) DEFAULT NULL,
  `ip_bloqueo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre_habbo` (`nombre_habbo`),
  UNIQUE KEY `idx_codigo_time` (`codigo_time`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_usuario`
--

LOCK TABLES `registro_usuario` WRITE;
/*!40000 ALTER TABLE `registro_usuario` DISABLE KEYS */;
INSERT INTO `registro_usuario` VALUES (34,'snotra','$2a$12$1qUL7N1/3NW2mjo71pnUzOPTQD.7mLxGFirJUyh8/dA92a34sGhfK','1','2025-05-04 03:49:11','104.28.246.26','Snotra','S0T1U',NULL),(35,'juancbq','$2a$15$I0Cre8MJkvaKq2fupJgbkOSdddpLfO7geA.ZZ9LrNOxn2oFB0OcXW','1','2025-05-04 04:31:15','179.52.231.230','juancBQ','V2W3X',NULL),(36,'Jo.c','$2a$12$yDPkeZ.gebCZPUkpcy72H.jgIiSQbt2rqNJ6WZ9L5imFeP0XmzFpO','1','2025-05-04 10:34:23','104.28.96.153','Jo.C','Y4Z5A',NULL),(37,'maria51162','$2a$15$f06JtEPYCucScrVIu3sceOK.8MHcc336c7MhX9lEUuiLajyWDHufS','1','2025-05-04 20:43:49','79.117.162.218','maria51162','B6C7D',NULL),(39,'nefita','$2a$15$sjMB.xJAfvXnFYKok7.YuebcuTBQ9Caw/jU5z5QjdjGstctIvkDNm','1','2025-05-04 22:45:19','181.51.89.41','Nefita','H0I1J',NULL),(40,'vanderlind','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-04 03:47:05','187.133.255.40','Vanderlind','P8Q9R',NULL),(59,'jefferso1142','$2a$15$zPuCtw2GraPfI98yWbXWPO40osmYAsTHophIItruygfcEOBk40BWe','1','2025-05-10 03:40:33','186.129.177.212','Jefferso1142','Q87HE',NULL),(61,'aprillesage','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-10 20:14:45','79.112.39.86','APRIL.LESAGE','TTKQE',NULL),(62,'santidemg2','$2a$12$kK4aOUijFaX85X6qp5V1ce6j3KfXVtmRR3yfw5DqZCjKcVwxIVWuy','10','2025-05-11 06:44:08','172.18.0.1','Santidemg2','TSZU8',NULL),(64,'faquanblaze','$2a$12$kK4aOUijFaX85X6qp5V1ce6j3KfXVtmRR3yfw5DqZCjKcVwxIVWuy','1','2025-05-11 17:18:54','186.98.194.30','FaQuan-Blaze','SD6JZ',NULL),(66,'fabianstev99','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-11 17:53:29','181.61.208.133','fabianstev99','8VPXJ',NULL),(67,'otea01','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-11 17:54:30','181.208.115.139','Otea01.*','86DAS',NULL),(68,'auricelys','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-11 19:01:01','190.218.21.109','Auricelys_','YA4E9',NULL),(69,'IllojuanDonut','$2a$12$VNgZaHDvu9eFVBPetcu0ueaR9J7uSYFXryY8qu27mFE2dbhask4/C','1','2025-05-11 20:12:28','200.119.179.2','IllojuanDonut','HAN7Q',NULL),(70,'masterbbo','$2a$12$eHSdVGxHo8quwFd2VJPMCeDRSSlDfiwYpmrd5Q.ZQFyPnmaOtBYei','1','2025-05-11 20:29:40','190.6.19.227','masterbbo','FNJQ5',NULL),(71,'turtlerabbittc','$2a$12$VQWQaAPWXV4pvT1VVnWmcudUxDLITHDhM5NB.i830KiB7dftzj/mS','1','2025-05-11 23:27:49','187.192.250.238','TurtlerabbittC','QH2HW',NULL),(72,'dobleaa','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 00:59:29','46.6.38.33','DobleAA','ATPWD',NULL),(73,'esdras507','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 01:04:04','190.35.50.196','-Esdras507','2RTN3',NULL),(74,'imica','$2a$12$wmBSfqT4AYbGJ90sDc7QjuFx8x0OZxETxDY2hMFy3XTiABc5Yybn2','1','2025-05-12 01:15:17','189.233.48.211','iMica','RLLGR',NULL),(75,'mariagarcia','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 14:35:54','89.29.189.143','MariaGarcia_','AAFGM',NULL),(76,'ryoma','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 15:14:05','179.7.180.162','Ryoma_','YE94X',NULL),(78,'estefania1598','$2a$15$zNHX4UbxE5oZMEfyN6Lv..q8jtViEE7Z4gH01AVcInfwP4hPh/SaG','1','2025-05-12 17:51:08','38.250.159.112','Estefania1598','8WS42',NULL),(79,'deyuki','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 20:39:36','190.234.75.238','deyuki','TNF7R',NULL),(80,'chiquiss01','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 20:57:08','190.62.84.76','ChiquisS_01','DGUWQ',NULL),(81,'gatito','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 21:05:35','189.234.119.113',':GATITO:','5W8W2',NULL),(82,'x=esmeralda=x','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 23:22:48','38.25.30.246',':x=esmeralda=x:','2QPCG',NULL),(83,'renailena','$2a$12$1rpmWjmly3/KxqGIrz3Mweuc0B3aXh5mq9c7YU1nV5OA1yvItRA/K','1','2025-05-13 01:15:58','200.92.180.239','RenaIlena','UWU9J',NULL),(84,'mrdem0n','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-13 04:53:36','201.240.5.49','MR.DEM0N','6CVD6',NULL),(85,'xavi88zkv1','$2a$15$R4Fq/d22MReP0jSY6Pjr3.rJE99RlZNejuGSVfo6mi96O3TuWXmHK','1','2025-05-13 08:35:34','90.167.86.183','xavi88zkv1','GFX8C',NULL),(86,'lyra','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-13 16:20:14','149.40.62.12','-.Lyra._','5T7X8',NULL),(87,'belzebong','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-13 17:18:19','187.191.8.101','Belzebong_','DXNCH',NULL),(88,'gominola12','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-14 20:56:21','186.169.215.6','Gominola12','CQZKU',NULL),(89,'lauraa23','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-14 22:35:10','84.125.77.234','lauraa23','EXHE5',NULL),(90,'thewick','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-19 05:08:08','76.168.229.221','The-Wick!!','MAKQW',NULL),(95,'pauliss21','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-26 15:46:26','84.125.72.181','pauliss21','3NBMN',NULL),(102,'reivaj421984','$2a$12$SYJ8Dyhyplrtd2KzCWGqueQdwRsRvxEO/cQCn8Grr8cdv5ZaDwxnm','1','2025-05-27 19:03:26','38.250.158.160','reivaj421984','4589A',NULL),(103,'thesteps','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-28 21:25:11','189.216.16.225','TheSteps','YRF42',NULL),(104,'.:karly:.','$2a$15$/0URi9lV3vpH8eRQrNwa8edyLANJTU6uPjTTwtKjhF69AfaJGKUJS','1','2025-05-28 22:43:09','189.176.74.51','.:karly:.','CXK3Q',NULL),(105,'Devilthew','$2a$12$dkvdpUQY2opZJw.zTCnM7OQ6xA9bJhKVvHLmeC5yg7TnF9ecxA8yO','1','2025-05-28 23:43:02','190.110.46.219','Devilthew','QF3Z9',NULL),(106,'Nocktus','$2a$12$x7JTLDHGwPW3nTanmNsAe.Ga8A7gMlJ3qiCbbnYKbYEyHJqVh1O0K','1','2025-05-29 00:41:38','179.53.123.8','Nocktus','BJ5Z3',NULL),(122,'ser-4z-132','$2y$10$BW0.RJdjf4UP/thBv1z.UO5ezT2q3N2OIcAGcgrpMxQe3BNMlC90a','1','2025-06-02 04:36:51','187.161.119.94','ser-4z-132','F4WTC',NULL),(124,'diabl4','$2y$10$A.0nsUfY6QNvug04c1bpUOxI3.2t87cRZ2BoDdyq5FYles5pRX5iq','1','2025-06-02 23:42:34','45.70.22.217','diabl4','E9JY3',NULL),(125,'LomaVerde','$2y$10$qxPB/AQtX06b7iwf/2Hnye9arKzsxeYTEIN8Z0Y.NjJRPEHQXw57e','1','2025-06-03 02:50:55','152.207.224.100','LomaVerde','PW5JN',NULL),(127,'el--rudy','$2y$10$wOj0wPxecqINGAF5T87PMO3CbBgOJCbLjkd3Y25KQVVm4HIe40d96','1','2025-06-03 22:06:48','190.131.139.207','el--rudy','A8UEJ',NULL),(128,'dohabbob000','$2y$10$Vwl7XbwULhJzIVCV5tSvIOaZyP3bzgxFMU4ge/WPWLjE0jX6ZNfSm','1','2025-06-04 00:29:38','186.189.77.3','dohabbob000','P5BRQ',NULL),(130,'_Brave','$2y$10$AFr85B7Ax8oBkyoFA5ApT.FUKYt3RbOnZKAvYr7tenI0QSx6PA7tC','1','2025-06-05 16:37:10','181.91.90.123','_Brave','R93M2',NULL),(131,'no','$2y$10$Q2cvB6nUu3puGIzvCOFyLeWeCjhq28KZlBShjMiWO7R6wFLnTlwWu','1','2025-06-06 14:06:47','188.79.111.143','no','5SRM9',NULL);
/*!40000 ALTER TABLE `registro_usuario` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`agencia_user`@`%`*/ /*!50003 TRIGGER `tr_auditoria_passwords` BEFORE UPDATE ON `registro_usuario` FOR EACH ROW BEGIN
    IF OLD.password_registro != NEW.password_registro THEN
        INSERT INTO auditoria_passwords (
            usuario_id,
            nombre_habbo,
            usuario_modificador,
            ip_modificacion
        )
        VALUES (
            OLD.id,
            OLD.nombre_habbo,
            @usuario_modificador,
            @ip_modificacion
        );
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `registro_usuario_backup_20250601`
--

DROP TABLE IF EXISTS `registro_usuario_backup_20250601`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registro_usuario_backup_20250601` (
  `id` int NOT NULL DEFAULT '0',
  `usuario_registro` varchar(50) NOT NULL,
  `password_registro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rol_id` varchar(255) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_registro` varchar(30) NOT NULL,
  `nombre_habbo` varchar(50) DEFAULT NULL,
  `codigo_time` varchar(5) DEFAULT NULL,
  `ip_bloqueo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_usuario_backup_20250601`
--

LOCK TABLES `registro_usuario_backup_20250601` WRITE;
/*!40000 ALTER TABLE `registro_usuario_backup_20250601` DISABLE KEYS */;
INSERT INTO `registro_usuario_backup_20250601` VALUES (34,'snotra','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-04 03:49:11','104.28.246.26','Snotra','S0T1U',NULL),(35,'juancbq','$2a$15$I0Cre8MJkvaKq2fupJgbkOSdddpLfO7geA.ZZ9LrNOxn2oFB0OcXW','1','2025-05-04 04:31:15','179.52.231.230','juancBQ','V2W3X',NULL),(36,'Jo.c','$2a$12$yDPkeZ.gebCZPUkpcy72H.jgIiSQbt2rqNJ6WZ9L5imFeP0XmzFpO','1','2025-05-04 10:34:23','104.28.96.153','Jo.C','Y4Z5A',NULL),(37,'maria51162','$2a$15$f06JtEPYCucScrVIu3sceOK.8MHcc336c7MhX9lEUuiLajyWDHufS','1','2025-05-04 20:43:49','79.117.162.218','maria51162','B6C7D',NULL),(39,'nefita','$2a$15$sjMB.xJAfvXnFYKok7.YuebcuTBQ9Caw/jU5z5QjdjGstctIvkDNm','1','2025-05-04 22:45:19','181.51.89.41','Nefita','H0I1J',NULL),(40,'vanderlind','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-04 03:47:05','187.133.255.40','Vanderlind','P8Q9R',NULL),(59,'jefferso1142','$2a$15$zPuCtw2GraPfI98yWbXWPO40osmYAsTHophIItruygfcEOBk40BWe','1','2025-05-10 03:40:33','186.129.177.212','Jefferso1142','Q87HE',NULL),(61,'aprillesage','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-10 20:14:45','79.112.39.86','APRIL.LESAGE','TTKQE',NULL),(62,'santidemg2','$2a$12$kK4aOUijFaX85X6qp5V1ce6j3KfXVtmRR3yfw5DqZCjKcVwxIVWuy','10','2025-05-11 06:44:08','172.18.0.1','Santidemg2','TSZU8',NULL),(64,'faquanblaze','$2a$12$kK4aOUijFaX85X6qp5V1ce6j3KfXVtmRR3yfw5DqZCjKcVwxIVWuy','1','2025-05-11 17:18:54','186.98.194.30','FaQuan-Blaze','SD6JZ',NULL),(66,'fabianstev99','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-11 17:53:29','181.61.208.133','fabianstev99','8VPXJ',NULL),(67,'otea01','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-11 17:54:30','181.208.115.139','Otea01.*','86DAS',NULL),(68,'auricelys','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-11 19:01:01','190.218.21.109','Auricelys_','YA4E9',NULL),(69,'illojuandonut','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-11 20:12:28','200.119.179.2','IllojuanDonut','HAN7Q',NULL),(70,'masterbbo','$2a$12$eHSdVGxHo8quwFd2VJPMCeDRSSlDfiwYpmrd5Q.ZQFyPnmaOtBYei','1','2025-05-11 20:29:40','190.6.19.227','masterbbo','FNJQ5',NULL),(71,'turtlerabbittc','$2a$12$VQWQaAPWXV4pvT1VVnWmcudUxDLITHDhM5NB.i830KiB7dftzj/mS','1','2025-05-11 23:27:49','187.192.250.238','TurtlerabbittC','QH2HW',NULL),(72,'dobleaa','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 00:59:29','46.6.38.33','DobleAA','ATPWD',NULL),(73,'esdras507','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 01:04:04','190.35.50.196','-Esdras507','2RTN3',NULL),(74,'imica','$2a$12$wmBSfqT4AYbGJ90sDc7QjuFx8x0OZxETxDY2hMFy3XTiABc5Yybn2','1','2025-05-12 01:15:17','189.233.48.211','iMica','RLLGR',NULL),(75,'mariagarcia','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 14:35:54','89.29.189.143','MariaGarcia_','AAFGM',NULL),(76,'ryoma','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 15:14:05','179.7.180.162','Ryoma_','YE94X',NULL),(78,'estefania1598','$2a$15$zNHX4UbxE5oZMEfyN6Lv..q8jtViEE7Z4gH01AVcInfwP4hPh/SaG','1','2025-05-12 17:51:08','38.250.159.112','Estefania1598','8WS42',NULL),(79,'deyuki','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 20:39:36','190.234.75.238','deyuki','TNF7R',NULL),(80,'chiquiss01','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 20:57:08','190.62.84.76','ChiquisS_01','DGUWQ',NULL),(81,'gatito','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 21:05:35','189.234.119.113',':GATITO:','5W8W2',NULL),(82,'x=esmeralda=x','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-12 23:22:48','38.25.30.246',':x=esmeralda=x:','2QPCG',NULL),(83,'renailena','$2a$12$1rpmWjmly3/KxqGIrz3Mweuc0B3aXh5mq9c7YU1nV5OA1yvItRA/K','1','2025-05-13 01:15:58','200.92.180.239','RenaIlena','UWU9J',NULL),(84,'mrdem0n','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-13 04:53:36','201.240.5.49','MR.DEM0N','6CVD6',NULL),(85,'xavi88zkv1','$2a$15$R4Fq/d22MReP0jSY6Pjr3.rJE99RlZNejuGSVfo6mi96O3TuWXmHK','1','2025-05-13 08:35:34','90.167.86.183','xavi88zkv1','GFX8C',NULL),(86,'lyra','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-13 16:20:14','149.40.62.12','-.Lyra._','5T7X8',NULL),(87,'belzebong','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-13 17:18:19','187.191.8.101','Belzebong_','DXNCH',NULL),(88,'gominola12','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-14 20:56:21','186.169.215.6','Gominola12','CQZKU',NULL),(89,'lauraa23','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-14 22:35:10','84.125.77.234','lauraa23','EXHE5',NULL),(90,'thewick','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-19 05:08:08','76.168.229.221','The-Wick!!','MAKQW',NULL),(95,'pauliss21','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-26 15:46:26','84.125.72.181','pauliss21','3NBMN',NULL),(102,'reivaj421984','$2a$12$SYJ8Dyhyplrtd2KzCWGqueQdwRsRvxEO/cQCn8Grr8cdv5ZaDwxnm','1','2025-05-27 19:03:26','38.250.158.160','reivaj421984','4589A',NULL),(103,'thesteps','$2a$12$o5ol3Et7OW3XsNF6XG1NdO.MPN/JxjI5GBlgcp2N0eWPYPVWK5Z7O','1','2025-05-28 21:25:11','189.216.16.225','TheSteps','YRF42',NULL),(104,'.:karly:.','$2a$15$/0URi9lV3vpH8eRQrNwa8edyLANJTU6uPjTTwtKjhF69AfaJGKUJS','1','2025-05-28 22:43:09','189.176.74.51','.:karly:.','CXK3Q',NULL),(105,'Devilthew','$2a$12$dkvdpUQY2opZJw.zTCnM7OQ6xA9bJhKVvHLmeC5yg7TnF9ecxA8yO','1','2025-05-28 23:43:02','190.110.46.219','Devilthew','QF3Z9',NULL),(106,'Nocktus','$2a$12$x7JTLDHGwPW3nTanmNsAe.Ga8A7gMlJ3qiCbbnYKbYEyHJqVh1O0K','1','2025-05-29 00:41:38','179.53.123.8','Nocktus','BJ5Z3',NULL),(122,'ser-4z-132','$2y$10$BW0.RJdjf4UP/thBv1z.UO5ezT2q3N2OIcAGcgrpMxQe3BNMlC90a','1','2025-06-02 04:36:51','187.161.119.94','ser-4z-132','F4WTC',NULL),(124,'diabl4','$2y$10$A.0nsUfY6QNvug04c1bpUOxI3.2t87cRZ2BoDdyq5FYles5pRX5iq','1','2025-06-02 23:42:34','45.70.22.217','diabl4','E9JY3',NULL),(125,'LomaVerde','$2y$10$qxPB/AQtX06b7iwf/2Hnye9arKzsxeYTEIN8Z0Y.NjJRPEHQXw57e','1','2025-06-03 02:50:55','152.207.224.100','LomaVerde','PW5JN',NULL),(127,'el--rudy','$2y$10$wOj0wPxecqINGAF5T87PMO3CbBgOJCbLjkd3Y25KQVVm4HIe40d96','1','2025-06-03 22:06:48','190.131.139.207','el--rudy','A8UEJ',NULL);
/*!40000 ALTER TABLE `registro_usuario_backup_20250601` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `nivel_acceso` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Agente',1),(2,'Seguridad',1),(3,'Tecnico',1),(4,'Logistica',1),(5,'Supervisor',2),(6,'Presidente',2),(7,'Director',2),(8,'Operativo',3),(9,'Junta Directiva',3),(10,'Administrador',4),(11,'Manager',4),(12,'Fundador',4),(13,'Dueo',4);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-07 21:23:03
