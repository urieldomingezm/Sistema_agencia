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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ascensos`
--

LOCK TABLES `ascensos` WRITE;
/*!40000 ALTER TABLE `ascensos` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auditoria_ascensos`
--

LOCK TABLES `auditoria_ascensos` WRITE;
/*!40000 ALTER TABLE `auditoria_ascensos` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_pagas`
--

LOCK TABLES `gestion_pagas` WRITE;
/*!40000 ALTER TABLE `gestion_pagas` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_quejas`
--

LOCK TABLES `gestion_quejas` WRITE;
/*!40000 ALTER TABLE `gestion_quejas` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_rangos`
--

LOCK TABLES `gestion_rangos` WRITE;
/*!40000 ALTER TABLE `gestion_rangos` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_requisitos`
--

LOCK TABLES `gestion_requisitos` WRITE;
/*!40000 ALTER TABLE `gestion_requisitos` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_tiempo`
--

LOCK TABLES `gestion_tiempo` WRITE;
/*!40000 ALTER TABLE `gestion_tiempo` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestion_ventas`
--

LOCK TABLES `gestion_ventas` WRITE;
/*!40000 ALTER TABLE `gestion_ventas` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_ascensos`
--

LOCK TABLES `historial_ascensos` WRITE;
/*!40000 ALTER TABLE `historial_ascensos` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_tiempos`
--

LOCK TABLES `historial_tiempos` WRITE;
/*!40000 ALTER TABLE `historial_tiempos` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registro_usuario`
--

LOCK TABLES `registro_usuario` WRITE;
/*!40000 ALTER TABLE `registro_usuario` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
