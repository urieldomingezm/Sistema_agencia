-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: db
-- Tiempo de generación: 05-05-2025 a las 16:29:09
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
  `mision_nueva` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `firma_usuario` varchar(10) DEFAULT NULL,
  `firma_encargado` varchar(10) DEFAULT NULL,
  `estado_ascenso` enum('pendiente','ascendido','en_espera') DEFAULT 'pendiente',
  `fecha_ultimo_ascenso` datetime DEFAULT CURRENT_TIMESTAMP,
  `fecha_disponible_ascenso` datetime DEFAULT NULL,
  `usuario_encargado` varchar(50) DEFAULT NULL,
  `es_recluta` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `ascensos`
--

INSERT INTO `ascensos` (`ascenso_id`, `codigo_time`, `rango_actual`, `mision_actual`, `mision_nueva`, `firma_usuario`, `firma_encargado`, `estado_ascenso`, `fecha_ultimo_ascenso`, `fecha_disponible_ascenso`, `usuario_encargado`, `es_recluta`) VALUES
(1, '4554K', 'Administrador', 'AGE- Iniciado I', NULL, NULL, NULL, 'en_espera', '2025-05-04 22:44:50', '2025-05-04 23:14:50', NULL, 1),
(2, 'G1H2I', 'Administrador', 'administrado G', NULL, 'REN', NULL, 'en_espera', '2025-05-05 03:11:15', NULL, NULL, 0),
(3, 'J4K5L', 'Seguridad', 'Seguridad', NULL, 'null', NULL, 'en_espera', '2025-05-05 03:11:15', NULL, NULL, 0),
(4, 'S0T1U', 'Fundador', 'Fundador', NULL, 'ADL', NULL, 'en_espera', '2025-05-05 03:11:15', NULL, NULL, 0),
(5, 'V2W3X', 'Administrador', 'administrado G', NULL, 'CBQ', NULL, 'en_espera', '2025-05-05 03:11:15', NULL, NULL, 0),
(6, 'Y4Z5A', 'Fundador', 'Fundador', NULL, 'JOC', NULL, 'en_espera', '2025-05-05 03:11:15', NULL, NULL, 0),
(7, 'B6C7D', 'Administrador', 'administrado G', NULL, 'MPM', NULL, 'en_espera', '2025-05-05 03:11:15', NULL, NULL, 0),
(8, 'E8F9G', 'Fundador', 'Fundador', NULL, 'STK', NULL, 'en_espera', '2025-05-05 03:11:15', NULL, NULL, 0),
(9, 'H0I1J', 'Administrador', 'administrado G', NULL, 'NEF', NULL, 'en_espera', '2025-05-05 03:11:15', NULL, NULL, 0),
(10, 'P8Q9R', 'Administrador', 'administrado G', NULL, 'BLU', NULL, 'en_espera', '2025-05-05 03:11:15', NULL, NULL, 0),
(11, 'GSUDH', 'Agente', 'AGE- Iniciado I', NULL, NULL, NULL, 'en_espera', '2025-05-05 05:54:13', '2025-05-05 06:24:13', NULL, 1);

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
(4, 'Santidegm', 'Seguridad', 23, 'Guarda paga', 'Bonificacion', '', '2025-03-21 01:11:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_tiempo`
--

CREATE TABLE `gestion_tiempo` (
  `tiempo_id` int NOT NULL,
  `codigo_time` varchar(5) NOT NULL,
  `tiempo_status` enum('pausa','disponible','ocupado','ausente','terminado','completado') DEFAULT 'disponible',
  `tiempo_restado` int DEFAULT '0',
  `tiempo_acumulado` int DEFAULT '0',
  `tiempo_transcurrido` int DEFAULT '0',
  `tiempo_encargado_usuario` varchar(50) DEFAULT NULL,
  `tiempo_fecha_registro` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `gestion_tiempo`
--

INSERT INTO `gestion_tiempo` (`tiempo_id`, `codigo_time`, `tiempo_status`, `tiempo_restado`, `tiempo_acumulado`, `tiempo_transcurrido`, `tiempo_encargado_usuario`, `tiempo_fecha_registro`) VALUES
(1, '4554K', 'disponible', 0, 0, 0, NULL, '2025-05-04 23:10:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestion_ventas`
--

CREATE TABLE `gestion_ventas` (
  `venta_id` int NOT NULL,
  `venta_titulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `venta_descripcion` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
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

INSERT INTO `gestion_ventas` (`venta_id`, `venta_titulo`, `venta_descripcion`, `venta_compra`, `venta_caducidad`, `venta_estado`, `venta_costo`, `venta_comprador`, `venta_encargado`, `venta_fecha_compra`) VALUES
(1, 'sdsd', 'sds', '2025-03-12', '2025-03-14', 'dsds', 21, 'sds', 'dsds', '2025-03-14 03:46:20'),
(2, 'venta_rango', 'sdsds', NULL, NULL, 'sdsds', 23, 'dasd', 'asda', '2025-03-14 03:57:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_ascensos`
--

CREATE TABLE `historial_ascensos` (
  `historial_id` int NOT NULL,
  `ascenso_id` int NOT NULL,
  `codigo_time` varchar(5) NOT NULL,
  `mision_anterior` varchar(255) DEFAULT NULL,
  `mision_nueva` varchar(255) NOT NULL,
  `firma_encargado` varchar(10) NOT NULL,
  `usuario_encargado` varchar(50) NOT NULL,
  `fecha_ascenso` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `historial_ascensos`
--

INSERT INTO `historial_ascensos` (`historial_id`, `ascenso_id`, `codigo_time`, `mision_anterior`, `mision_nueva`, `firma_encargado`, `usuario_encargado`, `fecha_ascenso`) VALUES
(1, 1, '4554K', 'Agente B', 'Agente C', 'XDD', 'urielmedina', '2025-05-05 02:25:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_usuario`
--

CREATE TABLE `registro_usuario` (
  `id` int NOT NULL,
  `usuario_registro` varchar(50) NOT NULL,
  `password_registro` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rol_id` varchar(255) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `ip_registro` varchar(30) NOT NULL,
  `nombre_habbo` varchar(50) DEFAULT NULL,
  `codigo_time` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `registro_usuario`
--

INSERT INTO `registro_usuario` (`id`, `usuario_registro`, `password_registro`, `rol_id`, `fecha_registro`, `ip_registro`, `nombre_habbo`, `codigo_time`) VALUES
(23, 'goblinslayer88', '$2y$10$O86FCJIxuXlG5.y7o2GGXO3CECHlUvdBJJDbAuXzvQleXGGRCiKQa', '1', '2025-03-17 21:26:32', '172.18.0.1111111111', 'goblinslayer88', NULL),
(26, 'Santidemg', '$2y$10$UC7bPNC.Y70Tc.S1vxa9fOQjFLdgW8EK0IL8rBzleuvpNSU4NTf7S', '1', '2025-03-21 01:06:17', '172.18.0.111111', 'Santidemg', NULL),
(29, 'Renzz', '$2y$10$5RQGu1NrrWlLCKRrSyiXiOatHj6cAyPoTl/ZyurxRxWwa7Ue/7ni2', '1', '2025-05-04 03:21:09', '172.18.0.52222', 'Renzz', 'G1H2I'),
(30, 'Nocktus', '$2y$10$Y415sFlvKnZ4r./1.AhAVO1rMLHLjnKw0.lSirv2BfOyrmz6xFoVC', '1', '2025-05-04 03:25:31', '172.18.0.5223232', 'jazy1234', 'J4K5L'),
(33, 'Santidemg2', '$2y$10$8vaEdfgHk/UU0uof35sCWeqTYdz/X4XlVWDYiBnCOSPrmqTpnf81a', '1', '2025-05-04 22:44:50', '172.18.0.1', 'Santidemg2', '4554K'),
(34, 'Snotra', '$2y$10$dfb27mIroIH.3lSYfxVp5.oVCFxiAfCt4w8CU2ST/u8ZTAgoSmh8a', '1', '2025-05-04 03:49:11', '104.28.246.26', 'Snotra', 'S0T1U'),
(35, 'juancBQ', '$2y$10$gplCIBsf678/dqneHZfDsO43N7hMu2obFv3XRjgu4u.peOX4dgFX2', '1', '2025-05-04 04:31:15', '179.52.231.230', 'juancBQ', 'V2W3X'),
(36, 'Jo.C', '$2y$10$rxPs.HMhPrNG/WzmGczdJOyreLOCmZ6bmV9svtBEjRFpsJltrwkVa', '1', '2025-05-04 10:34:23', '104.28.96.153', 'Jo.C', 'Y4Z5A'),
(37, 'maria51162', '$2y$10$VHf4SOKGgWTwkbJHyE2kSO5ueIku4IDgyGbTtcctvu2.HJpfRsJe.', '1', '2025-05-04 20:43:49', '79.117.162.218', 'maria51162', 'B6C7D'),
(38, 'xOllstarx', '$2y$10$N/wx1youJtM8T0nuh6NVpuQykNBCfcRYo2hgrQUlUCHqpgNSD4jkG', '1', '2025-05-04 22:02:35', '187.132.203.144', 'xOllstarx', 'E8F9G'),
(39, 'Nefita', '$2y$10$QGzzuEZk6XIlWcgAQ042.OHoKts5jcqyITcjNpyHjAIfetqNHp3Ru', '1', '2025-05-04 22:45:19', '181.51.89.41', 'Nefita', 'H0I1J'),
(40, 'Vanderlind', '$2y$10$4QUUrIKmi1me0RJtzNdsBuJBk3b6WT.sYz2/pYI8nMGvRMusNcbwO', '1', '2025-05-04 03:47:05', '187.133.255.40', 'Vanderlind', 'P8Q9R'),
(41, 'keekit08', '$2y$10$K4oOPc9K2ZoefT/qMlS9.ev7E942lRh9NHfepvcjEvePmAr6KtEwu', '1', '2025-05-05 05:54:13', '188.79.111.143', 'keekit08', 'GSUDH');

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
  ADD PRIMARY KEY (`historial_id`),
  ADD KEY `ascenso_id` (`ascenso_id`),
  ADD KEY `idx_codigo_time` (`codigo_time`);

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
  MODIFY `ascenso_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `gestion_pagas`
--
ALTER TABLE `gestion_pagas`
  MODIFY `pagas_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `gestion_tiempo`
--
ALTER TABLE `gestion_tiempo`
  MODIFY `tiempo_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `gestion_ventas`
--
ALTER TABLE `gestion_ventas`
  MODIFY `venta_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `historial_ascensos`
--
ALTER TABLE `historial_ascensos`
  MODIFY `historial_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `registro_usuario`
--
ALTER TABLE `registro_usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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

--
-- Filtros para la tabla `historial_ascensos`
--
ALTER TABLE `historial_ascensos`
  ADD CONSTRAINT `historial_ascensos_ibfk_1` FOREIGN KEY (`ascenso_id`) REFERENCES `ascensos` (`ascenso_id`),
  ADD CONSTRAINT `historial_ascensos_ibfk_2` FOREIGN KEY (`codigo_time`) REFERENCES `registro_usuario` (`codigo_time`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
