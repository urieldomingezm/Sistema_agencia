-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 21-05-2025 a las 11:22:22
-- Versión del servidor: 8.0.42
-- Versión de PHP: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_agencia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ascensos`
--

CREATE TABLE `ascensos` (
  `ascenso_id` int NOT NULL,
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
  `tiempo_ascenso` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ascensos`
--

INSERT INTO `ascensos` (`ascenso_id`, `codigo_time`, `rango_actual`, `mision_actual`, `firma_usuario`, `firma_encargado`, `estado_ascenso`, `fecha_ultimo_ascenso`, `fecha_disponible_ascenso`, `usuario_encargado`, `es_recluta`, `tiempo_ascenso`) VALUES
(37, 'G1H2I', 'Junta directiva', 'Junta directiva', 'REN', NULL, 'disponible', '2025-05-11 06:42:40', '00:00:00', NULL, NULL, '05:57:40'),
(39, 'S0T1U', 'Fundador', 'Fundador', 'ADL', NULL, 'disponible', '2025-05-11 06:42:40', '00:00:00', NULL, NULL, '05:57:41'),
(40, 'V2W3X', 'Administrador', 'Administrador', 'CBQ', NULL, 'disponible', '2025-05-11 06:42:40', '00:00:00', NULL, NULL, '05:57:42'),
(41, 'Y4Z5A', 'Fundador', 'Fundador', 'JOC', NULL, 'disponible', '2025-05-11 06:42:40', '00:00:00', NULL, NULL, '05:57:43'),
(42, 'B6C7D', 'Administrador', 'Administrador', 'MPM', NULL, 'disponible', '2025-05-11 06:42:40', '00:00:00', NULL, NULL, '05:57:44'),
(44, 'H0I1J', 'Administrador', 'Administrador', 'NEF', NULL, 'disponible', '2025-05-11 06:42:40', '00:00:00', NULL, NULL, '05:57:46'),
(45, 'P8Q9R', 'Administrador', 'SHN- Administrador -ADL -BLU', 'BLU', 'ADL', 'disponible', '2025-05-11 06:42:40', '00:00:00', 'Snotra', NULL, '05:57:47'),
(47, 'TTKQE', 'agente', 'agente', NULL, NULL, 'disponible', '2025-05-11 06:42:40', '00:00:00', NULL, NULL, '05:54:32'),
(48, 'TSZU8', 'Administrador', 'AGE- Iniciado I', NULL, NULL, 'disponible', '2025-05-11 00:44:08', '00:00:00', NULL, 1, '00:03:57'),
(49, 'G9DNE', 'Administrador', 'Administrador', NULL, NULL, 'disponible', '2025-05-11 09:45:46', '00:00:00', NULL, 1, '01:27:43'),
(51, 'WTPUQ', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'disponible', '2025-05-11 11:48:07', '00:00:00', NULL, 1, '22:56:59'),
(52, '8VPXJ', 'Operativo', 'OPE- Iniciado I', 'FSR', 'ADL', 'disponible', '2025-05-12 00:55:54', '00:00:00', 'Santidemg2', 1, '09:49:10'),
(56, 'FNJQ5', 'Supervisor', 'SHN - SUP- Experto B', 'RGO', 'ADL', 'disponible', '2025-05-12 20:47:17', '00:00:00', 'Snotra', 1, '06:00:16'),
(57, 'QH2HW', 'Presidente', 'PRES- Junior E', 'TRT', 'ADL', 'disponible', '2025-05-11 17:27:49', '00:00:00', 'Snotra', 1, '17:17:20'),
(58, 'ATPWD', 'Seguridad', 'SHN - SEG- Auxiliar G', NULL, 'ADL', 'disponible', '2025-05-12 01:03:22', '00:00:00', 'Snotra', 1, '08:22:54'),
(59, '2RTN3', 'Tecnico', 'SHN - TEC - Auxiliar G', 'ESD', 'ADL', 'disponible', '2025-05-12 14:02:14', '00:00:00', 'Snotra', 1, '04:36:00'),
(62, 'YE94X', 'Junta directiva', 'SHN- JDT Iniciado I', 'RYO', 'ADL', 'disponible', '2025-05-12 15:19:23', '00:00:00', 'Snotra', 1, '05:53:05'),
(64, 'FP898', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'disponible', '2025-05-12 11:17:33', '00:00:00', NULL, 1, '10:36:15'),
(66, '8WS42', 'Supervisor', 'SHN- SUP- Experto B', 'TEF', 'ADL', 'disponible', '2025-05-12 22:42:08', '00:00:00', 'Snotra', 1, '05:59:49'),
(73, 'DGUWQ', 'Operativo', 'SHN- OP- Iniciado I', 'CHI', 'ADL', 'disponible', '2025-05-12 21:04:30', '00:00:00', 'Snotra', 1, '06:00:11'),
(83, 'J4K5L', 'Seguridad', 'SHN - SEG Auxiliar G', '', 'ADL', 'ascendido', '2025-05-12 21:53:45', '01:53:45', 'Snotra', 0, NULL),
(84, '6CVD6', 'Operativo', 'SHN- OP- Iniciado I', 'HIM', 'ADL', 'disponible', '2025-05-13 05:02:33', '00:00:00', 'Snotra', 1, '05:59:43'),
(85, 'GFX8C', 'Junta directiva', 'SHN - JDT- Iniciado I', 'ZKV', 'ADL', 'pendiente', '2025-05-13 22:44:21', '00:10:00', 'Snotra', 1, NULL),
(90, 'DXNCH', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-13 11:18:19', '00:10:00', NULL, 1, NULL),
(92, 'SD6JZ', 'Seguridad', 'SEG- Novato H', '', 'MPM', 'ascendido', '2025-05-13 14:02:28', '18:02:28', 'maria51162', 0, NULL),
(93, 'UWU9J', 'Tecnico', 'TEC- Iniciado I', 'NYJ', 'MPM', 'ascendido', '2025-05-13 15:05:35', '09:05:35', 'maria51162', 0, NULL),
(99, 'RLLGR', 'Director', 'DIR- Junior E -', 'REY', 'MPM', 'ascendido', '2025-05-14 12:44:43', '12:44:43', 'maria51162', 0, NULL),
(100, '86DAS', 'Tecnico', 'TEC- Novato H', 'BTO', 'MPM', 'pendiente', '2025-05-20 04:41:05', '06:46:35', 'maria51162', 0, NULL),
(101, '2QPCG', 'Logistica', 'LOG- Auxiliar G -', 'ELA', 'MPM', 'ascendido', '2025-05-14 12:48:16', '14:48:16', 'maria51162', 0, NULL),
(103, 'CQZKU', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-14 14:56:21', '00:10:00', NULL, 1, NULL),
(105, 'EXHE5', 'Agente', 'SHN - AGE- Novato H', '', 'ADL', 'ascendido', '2025-05-14 16:45:40', '16:55:40', 'Snotra', 0, NULL),
(110, 'YA4E9', 'Supervisor', 'SUP- Auxiliar G -', 'PTY', 'NEF', 'ascendido', '2025-05-14 22:32:23', '22:32:23', 'Nefita', 0, NULL),
(113, 'AAFGM', 'Tecnico', 'TEC- Tecnico E', 'MAR', 'MPM', 'pendiente', '2025-05-20 01:00:36', '11:15:00', 'maria51162', 0, NULL),
(114, 'HAN7Q', 'Director', 'DIR- Experto B -', 'CBQ', 'MPM', 'ascendido', '2025-05-15 19:09:01', '19:09:01', 'maria51162', 0, NULL),
(115, '5W8W2', 'Seguridad', 'SEG- Experto B', '', 'MPM', 'ascendido', '2025-05-15 19:19:45', '23:19:45', 'maria51162', 0, NULL),
(116, 'Q87HE', 'Seguridad', 'SHN - SEG- Avanzado C - ADL', NULL, 'ADL', 'pendiente', '2025-05-18 20:13:54', '00:55:23', 'Snotra', 0, NULL),
(117, '5T7X8', 'Tecnico', 'TEC- Novato H', 'LIA', 'MPM', 'ascendido', '2025-05-16 13:41:49', '07:41:49', 'maria51162', 0, NULL),
(118, 'TNF7R', 'Logistica', 'LOG- Experto B', 'DEY', 'FSR', 'ascendido', '2025-05-16 13:41:57', '15:41:57', 'fabianstev99', 0, NULL),
(119, 'MAKQW', 'Seguridad', 'SHN - SEG- Junior E', NULL, 'MPM', 'pendiente', '2025-05-20 07:02:54', '00:10:00', 'maria51162', 1, NULL);

--
-- Disparadores `ascensos`
--
DELIMITER $$
CREATE TRIGGER `after_ascenso_insert` AFTER INSERT ON `ascensos` FOR EACH ROW BEGIN
    INSERT INTO historial_ascensos (
        codigo_time, rango_actual, mision_actual, firma_usuario, firma_encargado,
        estado_ascenso, fecha_ultimo_ascenso, fecha_disponible_ascenso, usuario_encargado,
        accion, realizado_por
    ) VALUES (
        NEW.codigo_time, NEW.rango_actual, NEW.mision_actual, NEW.firma_usuario, NEW.firma_encargado,
        NEW.estado_ascenso, NEW.fecha_ultimo_ascenso, NEW.fecha_disponible_ascenso, NEW.usuario_encargado,
        'ascendido', NEW.usuario_encargado
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_pagas`
--

CREATE TABLE `gestion_pagas` (
  `pagas_id` int NOT NULL,
  `pagas_usuario` varchar(16) NOT NULL,
  `pagas_rango` varchar(40) NOT NULL,
  `pagas_recibio` int NOT NULL,
  `pagas_motivo` varchar(30) NOT NULL,
  `pagas_completo` varchar(40) NOT NULL,
  `pagas_descripcion` varchar(255) NOT NULL,
  `pagas_fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `gestion_pagas`
--

INSERT INTO `gestion_pagas` (`pagas_id`, `pagas_usuario`, `pagas_rango`, `pagas_recibio`, `pagas_motivo`, `pagas_completo`, `pagas_descripcion`, `pagas_fecha_registro`) VALUES
(4, 'Santidegm', 'Seguridad', 23, 'Guarda paga', 'Bonificacion', '', '2025-03-21 01:11:55'),
(5, 'FaQuan-Blaze', 'Seguridad', 18, 'paga y boni', 'completo', '', '2025-05-18 17:48:05'),
(6, 'B3to', 'Tecnico', 20, 'paga y boni', 'completo', '', '2025-05-18 17:48:55'),
(7, 'DobleAA\r\n', 'Seguridad', 18, 'paga y boni', 'completo', '', '2025-05-18 17:49:39'),
(8, 'iMica', 'Director', 25, 'paga y boni', 'completo', '', '2025-05-18 17:50:17'),
(9, 'Jefferso1142', 'Seguridad', 18, 'paga y boni', 'completo', '', '2025-05-18 17:50:48'),
(10, 'MariaGarcia_', 'Tecnico', 20, 'paga y boni', 'completo', '', '2025-05-18 17:51:58'),
(11, 'Estefania1598', 'Supervisor', 23, 'paga y boni', 'completo', '', '2025-05-18 17:52:28'),
(12, 'deyuki', 'Logistica', 22, 'paga y boni', 'completo', '', '2025-05-18 17:52:56'),
(13, 'GATITO', 'Seguridad', 18, 'paga y boni', 'completo', '', '2025-05-18 17:53:21'),
(14, ':x=esmeralda=x:', 'Logistica', 22, 'paga y boni', 'completo', '', '2025-05-18 17:53:46'),
(15, 'RenaIlena', 'Tecnico', 20, 'paga y boni', 'completo', '', '2025-05-18 17:54:10'),
(16, '-.Lyra-', 'Tecnico', 20, 'paga y boni', 'completo', '', '2025-05-18 17:54:34'),
(17, 'fabianstev99', 'Operativo', 28, 'paga y boni', 'completo', '', '2025-05-18 17:57:33'),
(18, 'MR.DEM0N', 'Operativo', 28, 'paga y boni', 'completo', '', '2025-05-18 17:57:46'),
(19, 'ChiquisS_01', 'Operativo', 28, 'paga y boni', 'completo', '', '2025-05-18 17:57:58'),
(20, 'juancBQ', 'Operativo', 28, 'paga y boni', 'completo', '', '2025-05-18 17:58:11'),
(21, 'xavi88zkv1', 'Junta directiva', 32, 'paga y boni', 'completo', '', '2025-05-18 17:58:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_rangos`
--

CREATE TABLE `gestion_rangos` (
  `rangov_id` int NOT NULL,
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
  `rangov_costo` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_requisitos`
--

CREATE TABLE `gestion_requisitos` (
  `id` int NOT NULL,
  `user_codigo_time` varchar(255) NOT NULL,
  `requirement_name` varchar(255) NOT NULL,
  `is_completed` tinyint(1) DEFAULT '0',
  `last_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_tiempo`
--

CREATE TABLE `gestion_tiempo` (
  `tiempo_id` int NOT NULL,
  `codigo_time` varchar(5) NOT NULL,
  `tiempo_status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'disponible',
  `tiempo_restado` time DEFAULT '00:00:00',
  `tiempo_acumulado` time DEFAULT '00:00:00',
  `tiempo_transcurrido` time DEFAULT '00:00:00',
  `tiempo_encargado_usuario` varchar(50) DEFAULT NULL,
  `tiempo_fecha_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `tiempo_iniciado` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `gestion_tiempo`
--

INSERT INTO `gestion_tiempo` (`tiempo_id`, `codigo_time`, `tiempo_status`, `tiempo_restado`, `tiempo_acumulado`, `tiempo_transcurrido`, `tiempo_encargado_usuario`, `tiempo_fecha_registro`, `tiempo_iniciado`) VALUES
(3, 'TSZU8', 'completado', '00:00:00', '56:49:38', '00:00:00', NULL, '2025-05-11 06:44:08', '00:00:00'),
(4, 'G9DNE', 'pausa', '00:00:00', '00:00:45', '00:00:00', NULL, '2025-05-11 15:45:46', '00:00:00'),
(5, 'SD6JZ', 'completado', '00:00:00', '09:54:33', '00:00:00', NULL, '2025-05-11 17:18:54', '00:00:00'),
(6, 'WTPUQ', 'pausa', '00:00:00', '00:00:00', '00:00:00', NULL, '2025-05-11 17:48:07', '00:00:00'),
(7, '8VPXJ', 'pausa', '00:00:00', '00:01:47', '00:00:00', NULL, '2025-05-11 17:53:29', '00:00:00'),
(8, '86DAS', 'completado', '00:00:00', '08:22:04', '00:00:00', NULL, '2025-05-11 17:54:30', '00:00:00'),
(9, 'YA4E9', 'pausa', '00:00:00', '00:00:00', '00:00:00', NULL, '2025-05-11 19:01:01', '00:00:00'),
(10, 'HAN7Q', 'pausa', '00:00:00', '02:29:46', '00:00:00', NULL, '2025-05-11 20:12:28', '00:00:00'),
(11, 'FNJQ5', 'inactivo', '00:00:00', '00:27:38', '00:00:00', NULL, '2025-05-11 20:29:40', '00:00:00'),
(12, 'QH2HW', 'pausa', '00:00:00', '00:00:00', '00:00:00', NULL, '2025-05-11 23:27:49', '00:00:00'),
(13, 'ATPWD', 'completado', '00:00:00', '07:42:15', '00:00:00', NULL, '2025-05-12 00:59:29', '00:00:00'),
(14, '2RTN3', 'inactivo', '00:00:00', '01:26:24', '00:00:00', NULL, '2025-05-12 01:04:04', '00:00:00'),
(15, 'RLLGR', 'completado', '00:00:00', '13:33:36', '00:00:00', NULL, '2025-05-12 01:15:17', '00:00:00'),
(16, 'Q87HE', 'completado', '00:00:00', '07:24:41', '00:00:00', NULL, '2025-05-12 04:35:26', '00:00:00'),
(17, 'AAFGM', 'completado', '00:00:00', '09:54:55', '00:00:00', NULL, '2025-05-12 14:35:54', '00:00:00'),
(18, 'YE94X', 'pausa', '00:00:00', '00:00:00', '00:00:00', NULL, '2025-05-12 15:14:05', '00:00:00'),
(19, 'FP898', 'pausa', '00:00:00', '00:00:00', '00:00:00', NULL, '2025-05-12 17:17:33', NULL),
(20, '8WS42', 'completado', '00:00:00', '09:02:11', '00:00:00', NULL, '2025-05-12 17:51:08', '00:00:00'),
(21, 'TNF7R', 'completado', '00:00:00', '09:07:32', '00:00:00', NULL, '2025-05-12 20:39:36', '00:00:00'),
(22, 'DGUWQ', 'pausado', '00:00:00', '00:00:00', '00:00:00', NULL, '2025-05-12 20:57:08', NULL),
(23, '5W8W2', 'completado', '00:00:00', '07:09:28', '00:00:00', NULL, '2025-05-12 21:05:35', '00:00:00'),
(24, '2QPCG', 'completado', '00:00:00', '09:00:01', '00:00:00', NULL, '2025-05-12 23:22:48', '00:00:00'),
(25, 'UWU9J', 'completado', '00:00:00', '08:27:50', '00:00:00', NULL, '2025-05-13 01:15:58', '00:00:00'),
(28, 'FP898', 'pausado', '00:00:00', '00:00:00', '00:00:00', NULL, '2025-05-13 04:43:32', '00:00:00'),
(29, '6CVD6', 'pausa', '00:00:00', '00:00:00', '00:00:00', NULL, '2025-05-13 04:53:36', NULL),
(30, 'GFX8C', 'pausa', '00:00:00', '00:00:00', '00:00:00', NULL, '2025-05-13 08:35:34', NULL),
(31, '5T7X8', 'completado', '00:00:00', '08:48:17', '00:00:00', NULL, '2025-05-13 16:20:14', '00:00:00'),
(32, 'DXNCH', 'pausa', '00:00:00', '00:00:00', '00:00:00', NULL, '2025-05-13 17:18:19', NULL),
(33, 'CQZKU', 'pausa', '00:00:00', '00:00:00', '00:00:00', NULL, '2025-05-14 20:56:21', NULL),
(34, 'EXHE5', 'pausa', '00:00:00', '00:00:00', '00:00:00', NULL, '2025-05-14 22:35:10', NULL),
(35, 'MAKQW', 'pausa', '00:00:00', '00:00:00', '00:00:00', NULL, '2025-05-19 05:08:08', NULL);

--
-- Disparadores `gestion_tiempo`
--
DELIMITER $$
CREATE TRIGGER `historial_tiempos_pausa` AFTER UPDATE ON `gestion_tiempo` FOR EACH ROW BEGIN 
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
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_ventas`
--

CREATE TABLE `gestion_ventas` (
  `venta_id` int NOT NULL,
  `venta_titulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `venta_compra` date DEFAULT NULL,
  `venta_caducidad` date DEFAULT NULL,
  `venta_estado` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `venta_costo` int DEFAULT NULL,
  `venta_comprador` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `venta_encargado` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `venta_fecha_compra` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `gestion_ventas`
--

INSERT INTO `gestion_ventas` (`venta_id`, `venta_titulo`, `venta_compra`, `venta_caducidad`, `venta_estado`, `venta_costo`, `venta_comprador`, `venta_encargado`, `venta_fecha_compra`) VALUES
(3, 'Membresia VIP', '2025-03-20', '2125-03-20', 'ACTIVO', 35, '-_:Evolution:_-', 'juancBQ', '2025-05-06 10:54:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_ascensos`
--

CREATE TABLE `historial_ascensos` (
  `id` int NOT NULL,
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
  `fecha_accion` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `historial_ascensos`
--

INSERT INTO `historial_ascensos` (`id`, `codigo_time`, `rango_actual`, `mision_actual`, `firma_usuario`, `firma_encargado`, `estado_ascenso`, `fecha_ultimo_ascenso`, `fecha_disponible_ascenso`, `usuario_encargado`, `accion`, `realizado_por`, `fecha_accion`) VALUES
(10, 'P8Q9R', 'Operativo', 'J4K5Lswewew', '', 'ssd', 'ascendido', '2025-05-09 01:56:54', '2025-05-09 04:56:54', 'Santidemg2', 'ascendido', 'Santidemg2', '2025-05-09 01:56:54'),
(11, 'MZXN2', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-10 05:28:20', '2025-05-10 05:58:20', NULL, 'ascendido', NULL, '2025-05-10 05:28:20'),
(12, 'WSBKG', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-09 23:36:05', '2025-05-10 00:06:05', NULL, 'ascendido', NULL, '2025-05-10 05:36:05'),
(13, 'SJFAW', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-09 23:42:23', '2025-05-10 00:10:00', NULL, 'ascendido', NULL, '2025-05-10 05:42:23'),
(14, 'G36N3', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-09 23:43:59', '2025-05-10 00:13:59', NULL, 'ascendido', NULL, '2025-05-10 05:43:59'),
(15, 'DXQTT', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-09 23:45:00', '2025-05-10 00:10:00', NULL, 'ascendido', NULL, '2025-05-10 05:45:00'),
(16, 'B6C7D', 'Junta directiva', 'sdsds', 'MPM', 'sds', 'ascendido', '2025-05-10 18:26:37', '2025-05-10 21:26:37', 'Santidemg2', 'ascendido', 'Santidemg2', '2025-05-10 18:26:37'),
(17, 'J4K5L', 'Presidente', 'sadas', 'null', 'asd', 'ascendido', '2025-05-10 13:00:55', '2025-05-10 16:00:55', 'Santidemg2', 'ascendido', 'Santidemg2', '2025-05-10 19:00:55'),
(18, 'DXQTT', 'Junta directiva', 'sdsds', '', 'dsd', 'ascendido', '2025-05-10 13:49:41', '2025-05-10 16:49:41', 'Santidemg2', 'ascendido', 'Santidemg2', '2025-05-10 19:49:41'),
(19, 'DXQTT', 'Junta directiva', 'sdsds', '', 'dsd', 'ascendido', '2025-05-10 14:05:25', '2025-05-10 17:05:25', 'Santidemg2', 'ascendido', 'Santidemg2', '2025-05-10 20:05:25'),
(20, 'DXQTT', 'Junta directiva', 'sdsds', '', 'dsd', 'ascendido', '2025-05-10 14:07:25', '2025-05-10 17:07:25', 'Santidemg2', 'ascendido', 'Santidemg2', '2025-05-10 20:07:25'),
(21, 'DXQTT', 'Operativo', 'swdsd', '', 'sds', 'ascendido', '2025-05-10 14:53:27', '2025-05-10 17:53:27', 'Santidemg2', 'ascendido', 'Santidemg2', '2025-05-10 20:53:27'),
(22, '7BSUE', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-10 15:33:26', '2025-05-10 00:10:00', NULL, 'ascendido', NULL, '2025-05-10 21:33:26'),
(23, '7BSUE', 'Seguridad', 'sdsds', '', 'sds', 'ascendido', '2025-05-10 15:36:21', '2025-05-10 16:36:21', 'Santidemg2', 'ascendido', 'Santidemg2', '2025-05-10 21:36:21'),
(24, '7BSUE', 'Seguridad', 'sdsds', '', 'sds', 'ascendido', '2025-05-10 15:36:28', '2025-05-10 16:36:28', 'Santidemg2', 'ascendido', 'Santidemg2', '2025-05-10 21:36:28'),
(25, '7BSUE', 'Agente', 'sdsds', '', 'sds', 'ascendido', '2025-05-10 15:39:08', '2025-05-10 16:39:08', 'Santidemg2', 'ascendido', 'Santidemg2', '2025-05-10 21:39:08'),
(26, '7BSUE', 'Seguridad', 'sdsds', '', 'sds', 'ascendido', '2025-05-10 15:39:58', '2025-05-10 16:39:58', 'Santidemg2', 'ascendido', 'Santidemg2', '2025-05-10 21:39:58'),
(27, 'GWGXF', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-10 18:29:59', '2025-05-11 00:10:00', NULL, 'ascendido', NULL, '2025-05-11 00:29:59'),
(28, 'G1H2I', 'Junta directiva', 'Junta directiva', 'REN', NULL, 'en_espera', '2025-05-11 06:42:40', '2025-05-11 00:30:00', NULL, 'ascendido', NULL, '2025-05-11 06:42:40'),
(29, 'J4K5L', 'Seguridad', 'Seguridad', NULL, NULL, 'en_espera', '2025-05-11 06:42:40', '2025-05-11 00:30:00', NULL, 'ascendido', NULL, '2025-05-11 06:42:40'),
(30, 'S0T1U', 'Founder', 'Founder', 'ADL', NULL, 'en_espera', '2025-05-11 06:42:40', '2025-05-11 00:30:00', NULL, 'ascendido', NULL, '2025-05-11 06:42:40'),
(31, 'V2W3X', 'Administrador', 'Administrador', 'CBQ', NULL, 'en_espera', '2025-05-11 06:42:40', '2025-05-11 00:30:00', NULL, 'ascendido', NULL, '2025-05-11 06:42:40'),
(32, 'Y4Z5A', 'Founder', 'Founder', 'JOC', NULL, 'en_espera', '2025-05-11 06:42:40', '2025-05-11 00:30:00', NULL, 'ascendido', NULL, '2025-05-11 06:42:40'),
(33, 'B6C7D', 'Administrador', 'Administrador', 'MPM', NULL, 'en_espera', '2025-05-11 06:42:40', '2025-05-11 00:30:00', NULL, 'ascendido', NULL, '2025-05-11 06:42:40'),
(34, 'E8F9G', 'Founder', 'Founder', 'STK', NULL, 'en_espera', '2025-05-11 06:42:40', '2025-05-11 00:30:00', NULL, 'ascendido', NULL, '2025-05-11 06:42:40'),
(35, 'H0I1J', 'Administrador', 'Administrador', 'NEF', NULL, 'en_espera', '2025-05-11 06:42:40', '2025-05-11 00:30:00', NULL, 'ascendido', NULL, '2025-05-11 06:42:40'),
(36, 'P8Q9R', 'Administrador', 'Administrador', 'BLU', NULL, 'en_espera', '2025-05-11 06:42:40', '2025-05-11 00:30:00', NULL, 'ascendido', NULL, '2025-05-11 06:42:40'),
(37, 'Q87HE', 'Seguridad', 'SHN -SEG- Inicial I -ADL', NULL, NULL, 'en_espera', '2025-05-11 06:42:40', '2025-05-11 00:30:00', NULL, 'ascendido', NULL, '2025-05-11 06:42:40'),
(38, 'TTKQE', 'agente', 'agente', NULL, NULL, 'en_espera', '2025-05-11 06:42:40', '2025-05-11 00:30:00', NULL, 'ascendido', NULL, '2025-05-11 06:42:40'),
(39, 'TSZU8', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-11 00:44:08', '2025-05-11 00:10:00', NULL, 'ascendido', NULL, '2025-05-11 06:44:08'),
(40, 'G9DNE', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-11 09:45:46', '2025-05-11 00:10:00', NULL, 'ascendido', NULL, '2025-05-11 15:45:46'),
(41, 'SD6JZ', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-11 11:18:54', '2025-05-11 00:10:00', NULL, 'ascendido', NULL, '2025-05-11 17:18:54'),
(42, 'WTPUQ', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-11 11:48:07', '2025-05-11 00:10:00', NULL, 'ascendido', NULL, '2025-05-11 17:48:07'),
(43, '8VPXJ', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-11 11:53:29', '2025-05-11 00:10:00', NULL, 'ascendido', NULL, '2025-05-11 17:53:29'),
(44, '86DAS', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-11 11:54:30', '2025-05-11 00:10:00', NULL, 'ascendido', NULL, '2025-05-11 17:54:30'),
(45, 'YA4E9', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-11 13:01:01', '2025-05-11 00:10:00', NULL, 'ascendido', NULL, '2025-05-11 19:01:01'),
(46, 'HAN7Q', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-11 14:12:28', '2025-05-11 00:10:00', NULL, 'ascendido', NULL, '2025-05-11 20:12:28'),
(47, 'FNJQ5', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-11 14:29:40', '2025-05-11 00:10:00', NULL, 'ascendido', NULL, '2025-05-11 20:29:40'),
(48, 'QH2HW', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-11 17:27:49', '2025-05-11 00:10:00', NULL, 'ascendido', NULL, '2025-05-11 23:27:49'),
(49, 'ATPWD', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-11 18:59:29', '2025-05-12 00:10:00', NULL, 'ascendido', NULL, '2025-05-12 00:59:29'),
(50, '2RTN3', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-11 19:04:04', '2025-05-12 00:10:00', NULL, 'ascendido', NULL, '2025-05-12 01:04:04'),
(51, 'RLLGR', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-11 19:15:17', '2025-05-12 00:10:00', NULL, 'ascendido', NULL, '2025-05-12 01:15:17'),
(52, 'AAFGM', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-12 08:35:54', '2025-05-12 00:10:00', NULL, 'ascendido', NULL, '2025-05-12 14:35:54'),
(53, 'YE94X', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-12 09:14:05', '2025-05-12 00:10:00', NULL, 'ascendido', NULL, '2025-05-12 15:14:05'),
(54, 'AAFGM', 'Tecnico', 'SHN - TEC Iniciado I', 'MAR', 'ADL', 'ascendido', '2025-05-12 10:45:07', '2025-05-12 10:45:07', 'Snotra', 'ascendido', 'Snotra', '2025-05-12 16:45:07'),
(55, 'FP898', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-12 11:17:33', '2025-05-12 00:10:00', NULL, 'ascendido', NULL, '2025-05-12 17:17:33'),
(56, 'J4K5L', 'Seguridad', 'SEG H', '', 'joc', 'ascendido', '2025-05-12 11:30:02', '2025-05-12 13:30:02', 'Jo.C', 'ascendido', 'Jo.C', '2025-05-12 17:30:02'),
(57, '8WS42', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-12 11:51:08', '2025-05-12 00:10:00', NULL, 'ascendido', NULL, '2025-05-12 17:51:08'),
(58, 'SD6JZ', 'Agente', 'AGE- Novato H', '', 'G9D', 'ascendido', '2025-05-12 12:27:41', '2025-05-12 12:57:41', 'keekit08', 'ascendido', 'keekit08', '2025-05-12 18:27:41'),
(59, 'SD6JZ', 'Agente', 'AGE- Auxiliar G', '', 'MPM', 'ascendido', '2025-05-12 12:51:14', '2025-05-12 13:21:14', 'maria51162', 'ascendido', 'maria51162', '2025-05-12 18:51:14'),
(60, 'SD6JZ', 'Agente', 'AGE- Ayudante F', '', 'MPM', 'ascendido', '2025-05-12 13:15:32', '2025-05-12 13:45:32', 'maria51162', 'ascendido', 'maria51162', '2025-05-12 19:15:32'),
(61, 'SD6JZ', 'Agente', 'AGE- Ayudante F', '', 'MPM', 'ascendido', '2025-05-12 13:39:58', '2025-05-12 14:09:58', 'maria51162', 'ascendido', 'maria51162', '2025-05-12 19:39:58'),
(62, 'SD6JZ', 'Agente', 'SHN - AGE Avanzado C', '', 'ADL', 'ascendido', '2025-05-12 14:11:08', '2025-05-12 14:41:08', 'Snotra', 'ascendido', 'Snotra', '2025-05-12 20:11:08'),
(63, 'TNF7R', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-12 14:39:36', '2025-05-12 00:10:00', NULL, 'ascendido', NULL, '2025-05-12 20:39:36'),
(64, 'DGUWQ', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-12 14:57:08', '2025-05-12 00:10:00', NULL, 'ascendido', NULL, '2025-05-12 20:57:08'),
(65, '5W8W2', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-12 15:05:35', '2025-05-12 00:10:00', NULL, 'ascendido', NULL, '2025-05-12 21:05:35'),
(66, 'TNF7R', 'Logistica', 'LOG F', 'DEY', 'JOC', 'ascendido', '2025-05-12 15:08:52', '2025-05-12 15:08:52', 'Jo.C', 'ascendido', 'Jo.C', '2025-05-12 21:08:52'),
(67, '2QPCG', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-12 17:22:48', '2025-05-12 00:10:00', NULL, 'ascendido', NULL, '2025-05-12 23:22:48'),
(68, '5W8W2', 'Seguridad', 'AGE- Junior E', '', 'MPM', 'ascendido', '2025-05-12 18:00:32', '2025-05-13 20:00:32', 'maria51162', 'ascendido', 'maria51162', '2025-05-13 00:00:32'),
(69, '5W8W2', 'Seguridad', 'SEG- Junior E', '', 'MPM', 'ascendido', '2025-05-12 18:02:07', '2025-05-13 20:02:07', 'maria51162', 'ascendido', 'maria51162', '2025-05-13 00:02:07'),
(70, 'UWU9J', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-12 19:15:58', '2025-05-13 00:10:00', NULL, 'ascendido', NULL, '2025-05-13 01:15:58'),
(71, 'UWU9J', 'Seguridad', 'SEG- Experto B', '', 'MPM', 'ascendido', '2025-05-12 19:59:52', '2025-05-13 23:59:52', 'maria51162', 'ascendido', 'maria51162', '2025-05-13 01:59:52'),
(72, 'J4K5L', 'Seguridad', 'SEG- Auxiliar G', '', 'MPM', 'ascendido', '2025-05-12 21:40:34', '2025-05-13 01:40:34', 'maria51162', 'ascendido', 'maria51162', '2025-05-13 03:40:34'),
(73, 'J4K5L', 'Seguridad', 'SHN - SEG Auxiliar G', '', 'ADL', 'ascendido', '2025-05-12 21:49:22', '2025-05-13 01:49:22', 'Snotra', 'ascendido', 'Snotra', '2025-05-13 03:49:22'),
(74, 'J4K5L', 'Seguridad', 'SHN - SEG Auxiliar G', '', 'ADL', 'ascendido', '2025-05-12 21:53:45', '2025-05-13 01:53:45', 'Snotra', 'ascendido', 'Snotra', '2025-05-13 03:53:45'),
(75, '6CVD6', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-12 22:53:36', '2025-05-13 00:10:00', NULL, 'ascendido', NULL, '2025-05-13 04:53:36'),
(76, 'GFX8C', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-13 02:35:34', '2025-05-13 00:10:00', NULL, 'ascendido', NULL, '2025-05-13 08:35:34'),
(77, '5T7X8', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-13 10:20:14', '2025-05-13 00:10:00', NULL, 'ascendido', NULL, '2025-05-13 16:20:14'),
(78, '5T7X8', 'Tecnico', 'TEC- Iniciado I', 'LIA', 'MPM', 'ascendido', '2025-05-13 11:01:02', '2025-05-13 05:01:02', 'maria51162', 'ascendido', 'maria51162', '2025-05-13 17:01:02'),
(79, '86DAS', 'Seguridad', 'SEG- Experto B', '', 'MPM', 'ascendido', '2025-05-13 11:03:19', '2025-05-13 15:03:19', 'maria51162', 'ascendido', 'maria51162', '2025-05-13 17:03:19'),
(80, 'UWU9J', 'Seguridad', 'SEG- Jefe A', '', 'MPM', 'ascendido', '2025-05-13 11:08:05', '2025-05-13 15:08:05', 'maria51162', 'ascendido', 'maria51162', '2025-05-13 17:08:05'),
(81, 'DXNCH', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-13 11:18:19', '2025-05-13 00:10:00', NULL, 'ascendido', NULL, '2025-05-13 17:18:19'),
(82, '2QPCG', 'Logistica', 'LOG- Novato H', 'ELA', 'MPM', 'ascendido', '2025-05-13 12:37:53', '2025-05-13 14:37:53', 'maria51162', 'ascendido', 'maria51162', '2025-05-13 18:37:53'),
(83, 'SD6JZ', 'Seguridad', 'SEG- Novato H', '', 'MPM', 'ascendido', '2025-05-13 14:02:28', '2025-05-13 18:02:28', 'maria51162', 'ascendido', 'maria51162', '2025-05-13 20:02:28'),
(84, 'UWU9J', 'Tecnico', 'TEC- Iniciado I', 'NYJ', 'MPM', 'ascendido', '2025-05-13 15:05:35', '2025-05-13 09:05:35', 'maria51162', 'ascendido', 'maria51162', '2025-05-13 21:05:35'),
(85, 'AAFGM', 'Tecnico', 'SHN - TEC Novato H', 'MAR', 'ADL', 'ascendido', '2025-05-13 16:37:37', '2025-05-13 10:37:37', 'Snotra', 'ascendido', 'Snotra', '2025-05-13 22:37:37'),
(86, 'TNF7R', 'Logistica', 'SHN - LOG- Junior E', 'DEY', 'ADL', 'ascendido', '2025-05-13 16:42:38', '2025-05-13 18:42:38', 'Snotra', 'ascendido', 'Snotra', '2025-05-13 22:42:38'),
(87, '5W8W2', 'Seguridad', 'SEG- Intermedio D', '', 'FSR', 'ascendido', '2025-05-13 18:45:07', '2025-05-14 22:45:07', 'fabianstev99', 'ascendido', 'fabianstev99', '2025-05-14 00:45:07'),
(88, '86DAS', 'Seguridad', 'SHN - SEG- Jefe A', '', 'ADL', 'ascendido', '2025-05-13 19:42:52', '2025-05-14 23:42:52', 'Snotra', 'ascendido', 'Snotra', '2025-05-14 01:42:52'),
(89, 'Q87HE', 'Seguridad', 'SEG- Auxiliar G', '', 'FSR', 'ascendido', '2025-05-13 20:56:31', '2025-05-14 00:56:31', 'fabianstev99', 'ascendido', 'fabianstev99', '2025-05-14 02:56:31'),
(90, 'RLLGR', 'Director', 'DIR- Junior E -', 'REY', 'MPM', 'ascendido', '2025-05-14 12:44:43', '2025-05-14 12:44:43', 'maria51162', 'ascendido', 'maria51162', '2025-05-14 18:44:43'),
(91, '86DAS', 'Tecnico', 'TEC- Iniciado I', 'BTO', 'MPM', 'ascendido', '2025-05-14 12:46:35', '2025-05-14 06:46:35', 'maria51162', 'ascendido', 'maria51162', '2025-05-14 18:46:35'),
(92, '2QPCG', 'Logistica', 'LOG- Auxiliar G -', 'ELA', 'MPM', 'ascendido', '2025-05-14 12:48:16', '2025-05-14 14:48:16', 'maria51162', 'ascendido', 'maria51162', '2025-05-14 18:48:16'),
(93, 'TNF7R', 'Logistica', 'LOG- Intermedio D -', 'DEY', 'MPM', 'ascendido', '2025-05-14 14:30:26', '2025-05-14 16:30:26', 'maria51162', 'ascendido', 'maria51162', '2025-05-14 20:30:26'),
(94, 'CQZKU', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-14 14:56:21', '2025-05-14 00:10:00', NULL, 'ascendido', NULL, '2025-05-14 20:56:21'),
(95, 'EXHE5', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-14 16:35:10', '2025-05-14 00:10:00', NULL, 'ascendido', NULL, '2025-05-14 22:35:10'),
(96, 'EXHE5', 'Agente', 'SHN - AGE- Novato H', '', 'ADL', 'ascendido', '2025-05-14 16:45:40', '2025-05-14 16:55:40', 'Snotra', 'ascendido', 'Snotra', '2025-05-14 22:45:40'),
(97, '5W8W2', 'Seguridad', 'AGE - Avanzando C', '', 'NEF', 'ascendido', '2025-05-14 17:50:00', '2025-05-14 21:50:00', 'Nefita', 'ascendido', 'Nefita', '2025-05-14 23:50:00'),
(98, '5W8W2', 'Seguridad', 'AGE - Avanzando C', '', 'HIM', 'ascendido', '2025-05-14 18:04:13', '2025-05-15 22:04:13', 'MR.DEM0N', 'ascendido', 'MR.DEM0N', '2025-05-15 00:04:13'),
(99, 'AAFGM', 'Tecnico', 'TEC- Auxiliar G', 'MAR', 'REY', 'ascendido', '2025-05-14 18:49:39', '2025-05-15 12:49:39', 'iMica', 'ascendido', 'iMica', '2025-05-15 00:49:39'),
(100, 'YA4E9', 'Logistica', 'LOG- Auxiliar G -', 'PTY', 'NEF', 'ascendido', '2025-05-14 22:27:05', '2025-05-15 00:27:05', 'Nefita', 'ascendido', 'Nefita', '2025-05-15 04:27:05'),
(101, 'YA4E9', 'Supervisor', 'SUP- Auxiliar G -', 'PTY', 'NEF', 'ascendido', '2025-05-14 22:32:23', '2025-05-15 22:32:23', 'Nefita', 'ascendido', 'Nefita', '2025-05-15 04:32:23'),
(102, 'Q87HE', 'Seguridad', 'SEG- Ayudante F', '', 'MPM', 'ascendido', '2025-05-14 22:49:37', '2025-05-15 02:49:37', 'maria51162', 'ascendido', 'maria51162', '2025-05-15 04:49:37'),
(103, 'TNF7R', 'Logistica', 'LOG- Avanzado C -', 'DEY', 'MPM', 'ascendido', '2025-05-15 15:45:13', '2025-05-15 17:45:13', 'maria51162', 'ascendido', 'maria51162', '2025-05-15 21:45:13'),
(104, 'AAFGM', 'Tecnico', 'TEC- Ayudante F', 'MAR', 'FSR', 'ascendido', '2025-05-15 17:15:00', '2025-05-15 11:15:00', 'fabianstev99', 'ascendido', 'fabianstev99', '2025-05-15 23:15:00'),
(105, 'HAN7Q', 'Director', 'DIR- Experto B -', 'CBQ', 'MPM', 'ascendido', '2025-05-15 19:09:01', '2025-05-16 19:09:01', 'maria51162', 'ascendido', 'maria51162', '2025-05-16 01:09:01'),
(106, '5W8W2', 'Seguridad', 'SEG- Experto B', '', 'MPM', 'ascendido', '2025-05-15 19:19:45', '2025-05-16 23:19:45', 'maria51162', 'ascendido', 'maria51162', '2025-05-16 01:19:45'),
(107, 'Q87HE', 'Seguridad', 'SEG- Junior E', '', 'FSR', 'ascendido', '2025-05-15 20:55:23', '2025-05-16 00:55:23', 'fabianstev99', 'ascendido', 'fabianstev99', '2025-05-16 02:55:23'),
(108, '5T7X8', 'Tecnico', 'TEC- Novato H', 'LIA', 'MPM', 'ascendido', '2025-05-16 13:41:49', '2025-05-16 07:41:49', 'maria51162', 'ascendido', 'maria51162', '2025-05-16 19:41:49'),
(109, 'TNF7R', 'Logistica', 'LOG- Experto B', 'DEY', 'FSR', 'ascendido', '2025-05-16 13:41:57', '2025-05-16 15:41:57', 'fabianstev99', 'ascendido', 'fabianstev99', '2025-05-16 19:41:57'),
(110, 'MAKQW', 'Agente', 'AGE- Iniciado I', NULL, NULL, 'en_espera', '2025-05-18 23:08:08', '2025-05-19 00:10:00', NULL, 'ascendido', NULL, '2025-05-19 05:08:08');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_tiempos`
--

CREATE TABLE `historial_tiempos` (
  `id` int NOT NULL,
  `codigo_time` varchar(50) NOT NULL,
  `tiempo_acumulado` time NOT NULL,
  `tiempo_transcurrido` time NOT NULL,
  `tiempo_encargado_usuario` varchar(100) DEFAULT NULL,
  `tiempo_fecha_registro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `historial_tiempos`
--

INSERT INTO `historial_tiempos` (`id`, `codigo_time`, `tiempo_acumulado`, `tiempo_transcurrido`, `tiempo_encargado_usuario`, `tiempo_fecha_registro`) VALUES
(1, 'SD6JZ', '04:15:24', '00:00:00', 'maria51162', '2025-05-14 19:30:04'),
(2, 'SD6JZ', '18:19:56', '00:00:00', 'Santidemg2', '2025-05-14 19:56:10'),
(3, 'TNF7R', '06:29:54', '00:00:00', 'Snotra', '2025-05-14 20:19:29'),
(4, 'TSZU8', '28:07:56', '00:00:00', 'Santidemg2', '2025-05-14 20:20:51'),
(5, 'AAFGM', '05:15:44', '00:00:00', 'maria51162', '2025-05-14 22:54:48'),
(6, '5T7X8', '02:37:29', '00:00:00', 'ChiquisS_01', '2025-05-15 00:00:45'),
(7, 'AAFGM', '40:05:40', '00:00:00', 'ChiquisS_01', '2025-05-15 00:24:31'),
(8, '5T7X8', '21:34:58', '00:00:00', 'ChiquisS_01', '2025-05-15 00:24:43'),
(9, 'RLLGR', '08:00:47', '00:00:00', 'MR.DEM0N', '2025-05-15 00:53:05'),
(10, '2QPCG', '01:31:56', '00:00:00', 'MR.DEM0N', '2025-05-15 00:53:19'),
(11, 'AAFGM', '59:57:09', '00:00:00', 'MR.DEM0N', '2025-05-15 00:56:12'),
(12, '86DAS', '04:17:24', '00:00:00', 'maria51162', '2025-05-15 01:17:57'),
(13, '5T7X8', '05:12:25', '00:00:00', 'MR.DEM0N', '2025-05-15 01:18:00'),
(14, '5T7X8', '05:55:54', '00:00:00', 'Nefita', '2025-05-15 02:38:50'),
(15, '5T7X8', '07:14:04', '00:00:00', 'Nefita', '2025-05-15 04:59:25'),
(16, '86DAS', '04:47:45', '00:00:00', 'Nefita', '2025-05-15 05:00:18'),
(17, 'Q87HE', '06:14:03', '00:00:00', 'Nefita', '2025-05-15 05:34:11'),
(18, 'RLLGR', '09:20:44', '00:00:00', 'Nefita', '2025-05-15 05:49:38'),
(19, 'TNF7R', '06:29:54', '00:00:00', 'maria51162', '2025-05-15 22:28:01'),
(20, 'TNF7R', '07:36:42', '00:00:00', 'fabianstev99', '2025-05-15 22:58:53'),
(21, '8VPXJ', '00:00:00', '00:00:00', 'Nefita', '2025-05-15 23:36:37'),
(22, 'AAFGM', '09:00:09', '00:00:00', 'fabianstev99', '2025-05-15 23:39:27'),
(23, 'HAN7Q', '00:20:54', '00:00:00', 'maria51162', '2025-05-16 01:42:20'),
(24, 'SD6JZ', '08:12:16', '00:00:00', 'Snotra', '2025-05-16 04:44:20'),
(25, 'SD6JZ', '08:42:47', '00:00:00', 'Snotra', '2025-05-16 06:00:52'),
(26, 'SD6JZ', '31:31:02', '00:00:00', NULL, '2025-05-16 15:44:06'),
(27, 'HAN7Q', '01:19:57', '00:00:00', 'Snotra', '2025-05-17 02:34:02'),
(28, 'G9DNE', '00:00:00', '00:00:00', 'Jo.C', '2025-05-17 15:26:36'),
(29, 'GJ1KL', '04:12:11', '00:00:00', 'fabianstev99', '2025-05-12 08:15:10'),
(30, 'KX5TR', '03:45:32', '00:00:00', 'fabianstev99', '2025-05-12 10:30:44'),
(31, 'P9WQZ', '05:13:21', '00:00:00', 'fabianstev99', '2025-05-12 13:22:59'),
(32, 'UR8CN', '02:30:00', '00:00:00', 'fabianstev99', '2025-05-12 15:50:02'),
(33, 'M3LKD', '01:59:48', '00:00:00', 'fabianstev99', '2025-05-12 18:25:30'),
(34, 'BQ2XE', '06:44:10', '00:00:00', 'fabianstev99', '2025-05-13 09:12:55'),
(35, 'XKD3L', '03:10:15', '00:00:00', 'fabianstev99', '2025-05-13 11:40:03'),
(36, 'VN7TA', '07:08:55', '00:00:00', 'fabianstev99', '2025-05-13 14:35:50'),
(37, 'YC1KM', '05:25:31', '00:00:00', 'fabianstev99', '2025-05-13 17:20:18'),
(38, 'HF5PL', '04:30:00', '00:00:00', 'fabianstev99', '2025-05-13 20:01:49'),
(39, 'ZD6VA', '03:12:40', '00:00:00', 'fabianstev99', '2025-05-14 08:33:17'),
(40, 'QX9CE', '02:44:55', '00:00:00', 'fabianstev99', '2025-05-14 10:27:30'),
(41, 'TMG42', '01:25:37', '00:00:00', 'fabianstev99', '2025-05-14 12:41:03'),
(42, 'LMC94', '06:15:22', '00:00:00', 'fabianstev99', '2025-05-14 15:10:47'),
(43, 'PKV12', '02:56:00', '00:00:00', 'fabianstev99', '2025-05-14 17:53:21'),
(44, 'RY8BZ', '03:30:00', '00:00:00', 'fabianstev99', '2025-05-15 09:10:00'),
(45, 'WNT03', '05:00:00', '00:00:00', 'fabianstev99', '2025-05-15 11:45:44'),
(46, 'HG7XK', '04:40:33', '00:00:00', 'fabianstev99', '2025-05-15 14:10:27'),
(47, 'JUXM8', '01:11:11', '00:00:00', 'fabianstev99', '2025-05-16 08:02:15'),
(48, 'NERD2', '03:22:22', '00:00:00', 'fabianstev99', '2025-05-16 10:35:42'),
(49, 'OM9BT', '06:06:06', '00:00:00', 'fabianstev99', '2025-05-16 13:29:50'),
(50, 'KEA7Y', '04:44:44', '00:00:00', 'fabianstev99', '2025-05-16 16:55:21'),
(51, 'RICK9', '03:33:33', '00:00:00', 'fabianstev99', '2025-05-17 10:10:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_usuario`
--

CREATE TABLE `registro_usuario` (
  `id` int NOT NULL,
  `usuario_registro` varchar(50) NOT NULL,
  `password_registro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rol_id` varchar(255) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip_registro` varchar(30) NOT NULL,
  `nombre_habbo` varchar(50) DEFAULT NULL,
  `codigo_time` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `registro_usuario`
--

INSERT INTO `registro_usuario` (`id`, `usuario_registro`, `password_registro`, `rol_id`, `fecha_registro`, `ip_registro`, `nombre_habbo`, `codigo_time`) VALUES
(23, 'goblinslayer88', '$2y$10$MDq6LOeA2v4tB4sv9F208e/ykSWvyuyB8MbFTsdUcTeHOtlRhXSTK', '1', '2025-05-10 21:26:32', '172.18.0.1111111111', 'goblinslayer88', NULL),
(26, 'Santidemg', '$2y$10$Bbym0JEhXKuZkqwV.2QgKeF/LXLKx5Lcc/QtR28fe6A7vOzliWnNq', '1', '2025-05-10 01:06:17', '172.18.0.111111', 'Santidemg', NULL),
(29, 'Renzz', '$2y$10$5RQGu1NrrWlLCKRrSyiXiOatHj6cAyPoTl/ZyurxRxWwa7Ue/7ni2', '1', '2025-05-04 03:21:09', '172.18.0.52222', 'Renzz', 'G1H2I'),
(30, 'Nocktus', '$2y$10$Y415sFlvKnZ4r./1.AhAVO1rMLHLjnKw0.lSirv2BfOyrmz6xFoVC', '1', '2025-05-04 03:25:31', '172.18.0.5223232', 'jazy1234', 'J4K5L'),
(34, 'Snotra', '$2y$10$dfb27mIroIH.3lSYfxVp5.oVCFxiAfCt4w8CU2ST/u8ZTAgoSmh8a', '1', '2025-05-04 03:49:11', '104.28.246.26', 'Snotra', 'S0T1U'),
(35, 'juancBQ', '$2y$10$gplCIBsf678/dqneHZfDsO43N7hMu2obFv3XRjgu4u.peOX4dgFX2', '1', '2025-05-04 04:31:15', '179.52.231.230', 'juancBQ', 'V2W3X'),
(36, 'Jo.C', '$2y$10$rxPs.HMhPrNG/WzmGczdJOyreLOCmZ6bmV9svtBEjRFpsJltrwkVa', '1', '2025-05-04 10:34:23', '104.28.96.153', 'Jo.C', 'Y4Z5A'),
(37, 'maria51162', '$2y$10$VHf4SOKGgWTwkbJHyE2kSO5ueIku4IDgyGbTtcctvu2.HJpfRsJe.', '1', '2025-05-04 20:43:49', '79.117.162.218', 'maria51162', 'B6C7D'),
(39, 'Nefita', '$2y$10$QGzzuEZk6XIlWcgAQ042.OHoKts5jcqyITcjNpyHjAIfetqNHp3Ru', '1', '2025-05-04 22:45:19', '181.51.89.41', 'Nefita', 'H0I1J'),
(40, 'Vanderlind', '$2y$10$4QUUrIKmi1me0RJtzNdsBuJBk3b6WT.sYz2/pYI8nMGvRMusNcbwO', '1', '2025-05-04 03:47:05', '187.133.255.40', 'Vanderlind', 'P8Q9R'),
(59, 'Jefferso1142', '$2y$10$RIjjKaBt1iYCmQMKQhxKLOpo95bAwTB7lUAMTfMb4V84Y4IgwdObq', '1', '2025-05-10 03:40:33', '186.129.177.212', 'Jefferso1142', 'Q87HE'),
(61, 'APRIL.LESAGE', '$2y$10$AEplhoQGUnh4Y2KWG48ohu2OwVrKuVYPZIild2fVRAOVrmnNX7GC6', '1', '2025-05-10 20:14:45', '79.112.39.86', 'APRIL.LESAGE', 'TTKQE'),
(62, 'Santidemg2', '$2y$10$EjB/j8M.zhvIjbwCUkow8OykoDQnT3pG/jNj39AGQ1lf/H3EYx5ui', '1', '2025-05-11 06:44:08', '172.18.0.1', 'Santidemg2', 'TSZU8'),
(63, 'keekit08', '$2y$10$kd7ehAS1E7XPcKVVDBfxgOgJcDFoNNm7ve3HHk6jxF7iMSOZVbTsu', '1', '2025-05-11 15:45:46', '188.79.111.143', 'keekit08 ', 'G9DNE'),
(64, 'FaQuan-Blaze', '$2y$10$xRY/9RdeG5EUqkyVKsIjqeLvx3KlEQvlNFZYMXruOySWJTWMJysZ6', '1', '2025-05-11 17:18:54', '186.98.194.30', 'FaQuan-Blaze', 'SD6JZ'),
(65, 'ser87k-53', '$2y$10$hIQeZXep./pRrv/i2oISPOd0w08SrDAv4nmJLRz9XffK6gvHAJo1m', '1', '2025-05-11 17:48:07', '148.101.120.134', 'ser87k-53', 'WTPUQ'),
(66, 'fabianstev99', '$2y$10$p6RtHaN4Wu3U0giWk42NL.U3zFVEI0KDDM/nbLNnT7aik/NCh4O8u', '1', '2025-05-11 17:53:29', '181.61.208.133', 'fabianstev99', '8VPXJ'),
(67, 'B3to', '$2y$10$xteUftWJr3GRKI6X.TD3s.m6Mc1a31yml6.5m0EVmnwsKY80OO7by', '1', '2025-05-11 17:54:30', '181.208.115.139', 'Otea01.*', '86DAS'),
(68, 'Auricelys_', '$2y$10$PYCNsMrlWqUgSU4xr3dFO.zgYG3g8ZSBcvjZzAqAxizg1n9k4AtEe', '1', '2025-05-11 19:01:01', '190.218.21.109', 'Auricelys_', 'YA4E9'),
(69, 'IllojuanDonut', '$2y$10$ynIVuCLviEz34OUbDnBOqORxJcIS8d4IS/G7m7Oe2QtlwnB9p6oP2', '1', '2025-05-11 20:12:28', '200.119.179.2', 'IllojuanDonut', 'HAN7Q'),
(70, 'masterbbo', '$2y$10$zZXDYNfMLzaeR67/16DKz.COxT42y4oL7YZHZ1jKAEMDU3TlxYm6a', '1', '2025-05-11 20:29:40', '190.6.19.227', 'masterbbo', 'FNJQ5'),
(71, 'TurtlerabbittC', '$2y$10$GGfZWIshfvAqO1LdPJ7DxuwNsXfEUTlbCdFh9opilal6ja4x6eAqq', '1', '2025-05-11 23:27:49', '187.192.250.238', 'TurtlerabbittC', 'QH2HW'),
(72, 'DobleAA', '$2y$10$QZ7N9LXQMBQQ5m78.CRMLe55zL9b2i0BACMleTHud7EqxEPI7Hy7O', '1', '2025-05-12 00:59:29', '46.6.38.33', 'DobleAA', 'ATPWD'),
(73, '-Esdras507', '$2y$10$6hNfXt0.X79zH9mYndrrru8EweBz6C5Lz.PqX5KIgLGedFepBRbxe', '1', '2025-05-12 01:04:04', '190.35.50.196', '-Esdras507', '2RTN3'),
(74, 'iMica', '$2y$10$.Yc0FwnmVaoxssUD5E1OleGntBb9VE5G7ho/c1GJyiPJCxNca8Zui', '1', '2025-05-12 01:15:17', '189.233.48.211', 'iMica', 'RLLGR'),
(75, 'MariaGarcia_', '$2y$10$jf4jyDbHOb3/P0ZP/0lgp.zQU6HPx1oXuS1JBx87PRr0bOrHiLqP2', '1', '2025-05-12 14:35:54', '89.29.189.143', 'MariaGarcia_', 'AAFGM'),
(76, 'Ryoma_', '$2y$10$ryfBFpi6a/yHjsrWC68klOm63Wdz28Vqh25qErWfTyQlK4UEtt382', '1', '2025-05-12 15:14:05', '179.7.180.162', 'Ryoma_', 'YE94X'),
(77, 'Nocktus', '$2y$10$O.D3a6I15YPQZJQ49YKD0uUr9F3dq6lCV5/HJ0Z.1HLOlmK98dTSG', '1', '2025-05-12 17:17:33', '45.182.141.37', 'Nocktus', 'FP898'),
(78, 'Estefania1598', '$2y$10$vfVqte.qszWTh4bksHGogOwAbm6qi2v1eDtbEACtzz1VFwXYc3sCa', '1', '2025-05-12 17:51:08', '38.250.159.112', 'Estefania1598', '8WS42'),
(79, 'deyuki', '$2y$10$JTRIg01ODmLUpoGxcFvvr.ESeAwBsnMRPmf1YbDpwFJudUvxxpt36', '1', '2025-05-12 20:39:36', '190.234.75.238', 'deyuki', 'TNF7R'),
(80, 'ChiquisS_01', '$2y$10$fTet8NsZBwpx7gkDxNHadeEsAnfQ7zIkRVMI0VeRe/CqVTikyG8PK', '1', '2025-05-12 20:57:08', '190.62.84.76', 'ChiquisS_01', 'DGUWQ'),
(81, ':GATITO:', '$2y$10$NBe3O8Pl7fiO4iJ9VK5uW.sCL/YTk7HVUBX0ZZk2tc5IgPMOspBTG', '1', '2025-05-12 21:05:35', '189.234.119.113', ':GATITO:', '5W8W2'),
(82, ':x=esmeralda=x:', '$2y$10$FO.LUU/muVOjmAPUnGkRTe9/o/004T1h6RNmSqkjzw1enPJcwEtI2', '1', '2025-05-12 23:22:48', '38.25.30.246', ':x=esmeralda=x:', '2QPCG'),
(83, 'RenaIlena', '$2y$10$w2qKi0MIQBOViujRPGSJ3ui/u59VHynp00hoGFaywHgzncBtdmv22', '1', '2025-05-13 01:15:58', '200.92.180.239', 'RenaIlena', 'UWU9J'),
(84, 'MR.DEM0N', '$2y$10$0a948NBsLaIWFjsoWuZnFuUrn92HyRUVxi3HlyJr2CCyUML4Nhsje', '1', '2025-05-13 04:53:36', '201.240.5.49', 'MR.DEM0N', '6CVD6'),
(85, 'xavi88zkv1', '$2y$10$MWR2SWoYK3O79FCdf4g8JuqGza1x.w5ZU1rHdo6s7qd5mZcHaIjKK', '1', '2025-05-13 08:35:34', '90.167.86.183', 'xavi88zkv1', 'GFX8C'),
(86, '-.Lyra-', '$2y$10$/LVxg75Qzbfs2N/Th7bLzuZainEzFBqA0Dxjif/k.CvnnHZO.Lv/y', '1', '2025-05-13 16:20:14', '149.40.62.12', '-.Lyra-', '5T7X8'),
(87, 'Belzebong_', '$2y$10$POAoS4C3DC9vuVXUmIYjF.6gnzkySkLm830SeZaXuuechaFto0VPe', '1', '2025-05-13 17:18:19', '187.191.8.101', 'Belzebong_', 'DXNCH'),
(88, 'Gominola', '$2y$10$62tSeWJ94whTf2jNwuVqPumZTSykIjC2dU.4gcPG6X5xPdryRL09G', '1', '2025-05-14 20:56:21', '186.169.215.6', 'Gominola12', 'CQZKU'),
(89, 'lauraa23', '$2y$10$KT11aB4P2zYMpX9LknH/Ye.Wj5r72juz86neOyNPyF.iRfBJBaLX2', '1', '2025-05-14 22:35:10', '84.125.77.234', 'lauraa23', 'EXHE5'),
(90, 'The-Wick!!', '$2y$10$bXvMr9wExL7GLUtl9P3oZe1pCoHMrDLHNCW8AMrf5ZjDD5PolnleO', '1', '2025-05-19 05:08:08', '76.168.229.221', 'The-Wick!!', 'MAKQW');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ascensos`
--
ALTER TABLE `ascensos`
  ADD PRIMARY KEY (`ascenso_id`),
  ADD KEY `idx_codigo_time` (`codigo_time`);

--
-- Indices de la tabla `gestion_pagas`
--
ALTER TABLE `gestion_pagas`
  ADD PRIMARY KEY (`pagas_id`);

--
-- Indices de la tabla `gestion_rangos`
--
ALTER TABLE `gestion_rangos`
  ADD PRIMARY KEY (`rangov_id`);

--
-- Indices de la tabla `gestion_requisitos`
--
ALTER TABLE `gestion_requisitos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gestion_tiempo`
--
ALTER TABLE `gestion_tiempo`
  ADD PRIMARY KEY (`tiempo_id`),
  ADD KEY `idx_codigo_time` (`codigo_time`);

--
-- Indices de la tabla `gestion_ventas`
--
ALTER TABLE `gestion_ventas`
  ADD PRIMARY KEY (`venta_id`);

--
-- Indices de la tabla `historial_ascensos`
--
ALTER TABLE `historial_ascensos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `historial_tiempos`
--
ALTER TABLE `historial_tiempos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `registro_usuario`
--
ALTER TABLE `registro_usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_habbo` (`nombre_habbo`),
  ADD UNIQUE KEY `idx_codigo_time` (`codigo_time`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ascensos`
--
ALTER TABLE `ascensos`
  MODIFY `ascenso_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT de la tabla `gestion_pagas`
--
ALTER TABLE `gestion_pagas`
  MODIFY `pagas_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `gestion_rangos`
--
ALTER TABLE `gestion_rangos`
  MODIFY `rangov_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gestion_requisitos`
--
ALTER TABLE `gestion_requisitos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `gestion_tiempo`
--
ALTER TABLE `gestion_tiempo`
  MODIFY `tiempo_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `gestion_ventas`
--
ALTER TABLE `gestion_ventas`
  MODIFY `venta_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `historial_ascensos`
--
ALTER TABLE `historial_ascensos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT de la tabla `historial_tiempos`
--
ALTER TABLE `historial_tiempos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `registro_usuario`
--
ALTER TABLE `registro_usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ascensos`
--
ALTER TABLE `ascensos`
  ADD CONSTRAINT `ascensos_ibfk_1` FOREIGN KEY (`codigo_time`) REFERENCES `registro_usuario` (`codigo_time`) ON DELETE CASCADE;

--
-- Filtros para la tabla `gestion_tiempo`
--
ALTER TABLE `gestion_tiempo`
  ADD CONSTRAINT `gestion_tiempo_ibfk_1` FOREIGN KEY (`codigo_time`) REFERENCES `registro_usuario` (`codigo_time`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
