-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-12-2025 a las 23:25:36
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `stockpilot`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--
DROP DATABASE IF EXISTS stockpilot;
CREATE DATABASE stockpilot;
USE stockpilot;

CREATE TABLE `auditoria` (
  `idaud` int(10) NOT NULL,
  `idemp` int(10) DEFAULT NULL,
  `idusu` int(10) DEFAULT NULL,
  `tabla` varchar(50) DEFAULT NULL,
  `accion` tinyint(2) DEFAULT NULL COMMENT '1=INSERT, 2=UPDATE, 3=DELETE, 4=LOGIN',
  `idreg` int(10) DEFAULT NULL,
  `datos_ant` text DEFAULT NULL,
  `datos_nue` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL COMMENT 'Email usado en login',
  `exitoso` tinyint(1) DEFAULT NULL COMMENT 'Para logins: 1=éxito, 0=fallo',
  `navegador` varchar(255) DEFAULT NULL COMMENT 'User agent del navegador',
  `fecha` datetime DEFAULT NULL,
  `ip` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `auditoria`
--

INSERT INTO `auditoria` (`idaud`, `idemp`, `idusu`, `tabla`, `accion`, `idreg`, `datos_ant`, `datos_nue`, `email`, `exitoso`, `navegador`, `fecha`, `ip`) VALUES
(1, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-11-20 08:30:00', '192.168.1.100'),
(2, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-11-20 09:15:00', '192.168.1.100'),
(3, 1, 2, 'login', 4, NULL, NULL, NULL, 'juan@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0', '2025-11-20 10:00:00', '192.168.1.101'),
(4, 2, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 1, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Safari/537.36', '2025-11-20 08:45:00', '192.168.2.50'),
(5, 2, 3, 'login', 4, NULL, NULL, NULL, 'maria@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Firefox/121.0', '2025-11-20 11:30:00', '192.168.2.51'),
(6, 3, 2, 'login', 4, NULL, NULL, NULL, 'juan@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Edge/120.0.0.0', '2025-11-20 07:00:00', '192.168.3.20'),
(7, 1, NULL, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', '2025-11-20 08:28:00', '192.168.1.100'),
(8, 1, NULL, 'login', 4, NULL, NULL, NULL, 'juan@example.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0', '2025-11-20 09:58:00', '192.168.1.101'),
(9, 2, NULL, 'login', 4, NULL, NULL, NULL, 'maria@example.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Firefox/121.0', '2025-11-20 11:28:00', '192.168.2.51'),
(10, 3, NULL, 'login', 4, NULL, NULL, NULL, 'usuario_inexistente@test.com', 0, 'Mozilla/5.0 (Linux; Android 10) Mobile Safari/537.36', '2025-11-20 12:00:00', '192.168.3.99'),
(11, 1, NULL, 'login', 4, NULL, NULL, NULL, 'hacker@malicious.com', 0, 'curl/7.68.0', '2025-11-20 13:00:00', '203.0.113.45'),
(12, 1, 1, 'producto', 1, 1, NULL, '{\"codprod\":\"PROD-001\",\"nomprod\":\"Laptop HP EliteBook\",\"precio\":2500.00}', NULL, NULL, NULL, '2025-11-20 09:00:00', '192.168.1.100'),
(13, 1, 2, 'producto', 2, 1, '{\"precio\":2500.00}', '{\"precio\":2400.00}', NULL, NULL, NULL, '2025-11-20 10:30:00', '192.168.1.101'),
(14, 1, 1, 'categoria', 1, 1, NULL, '{\"nomcat\":\"Electrónica\",\"descat\":\"Dispositivos electrónicos\"}', NULL, NULL, NULL, '2025-11-20 11:00:00', '192.168.1.100'),
(15, 2, 1, 'producto', 1, 3, NULL, '{\"codprod\":\"PROD-003\",\"nomprod\":\"Resma Papel A4\",\"precio\":15.00}', NULL, NULL, NULL, '2025-11-20 09:30:00', '192.168.2.50'),
(16, 2, 3, 'proveedor', 1, 2, NULL, '{\"nomprov\":\"Papelería Moderna\",\"docprov\":\"543216789-1\"}', NULL, NULL, NULL, '2025-11-20 12:00:00', '192.168.2.51'),
(17, 2, 1, 'inventario', 2, 3, '{\"cant\":150}', '{\"cant\":200}', NULL, NULL, NULL, '2025-11-20 13:00:00', '192.168.2.50'),
(18, 3, 2, 'producto', 1, 4, NULL, '{\"codprod\":\"PROD-004\",\"nomprod\":\"Silla Oficina\",\"precio\":300.00}', NULL, NULL, NULL, '2025-11-20 08:00:00', '192.168.3.20'),
(19, 3, 2, 'producto', 3, 4, '{\"codprod\":\"PROD-004\",\"nomprod\":\"Silla Oficina\",\"precio\":300.00}', NULL, NULL, NULL, NULL, '2025-11-20 14:00:00', '192.168.3.20'),
(20, NULL, 1, 'kardex', 1, 0, NULL, '{\"anio\":\"20253\",\"mes\":\"11\",\"cerrado\":\"0\",\"ope\":\"save\",\"idkar\":\"\"}', NULL, NULL, NULL, '2025-11-20 21:50:50', '::1'),
(21, NULL, 1, 'kardex', 3, 6, '[{\"idkar\":6,\"idemp\":1,\"anio\":20253,\"mes\":11,\"cerrado\":0,\"fec_crea\":null,\"fec_actu\":null}]', NULL, NULL, NULL, NULL, '2025-11-20 21:50:57', '::1'),
(22, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-20 16:08:05', '::1'),
(23, NULL, NULL, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-20 16:08:28', '::1'),
(24, NULL, NULL, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-20 16:08:30', '::1'),
(25, NULL, NULL, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-20 16:08:32', '::1'),
(26, NULL, NULL, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-20 16:08:33', '::1'),
(27, NULL, NULL, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-20 16:08:36', '::1'),
(28, NULL, NULL, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-20 16:08:38', '::1'),
(29, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-20 16:08:43', '::1'),
(30, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-20 16:26:41', '::1'),
(31, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-20 16:28:29', '::1'),
(32, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-21 20:09:15', '::1'),
(33, 1, 2, 'producto', 2, 2, '{\"nomprod\":\"Taladro Inalámbrico\",\"precio\":200.00}', '{\"nomprod\":\"Taladro Inalámbrico Pro\",\"precio\":220.00}', NULL, NULL, NULL, '2025-11-22 10:15:00', '192.168.1.101'),
(34, 2, 3, 'categoria', 1, 3, NULL, '{\"nomcat\":\"Papelería\",\"descat\":\"Artículos de oficina\"}', NULL, NULL, NULL, '2025-11-22 11:00:00', '192.168.2.51'),
(35, 1, 1, 'proveedor', 2, 1, '{\"nomprov\":\"ElectroParts SA\",\"telprov\":\"6012345679\"}', '{\"nomprov\":\"ElectroParts SA\",\"telprov\":\"6012345680\"}', NULL, NULL, NULL, '2025-11-22 14:30:00', '192.168.1.100'),
(36, 3, 2, 'usuario', 1, 6, NULL, '{\"nomusu\":\"Carlos\",\"apeusu\":\"López\",\"emausu\":\"carlos@test.com\"}', NULL, NULL, NULL, '2025-11-23 09:00:00', '192.168.3.20'),
(37, 1, 1, 'inventario', 2, 1, '{\"cant\":15}', '{\"cant\":20}', NULL, NULL, NULL, '2025-11-23 10:30:00', '192.168.1.100'),
(38, 2, 3, 'lote', 1, 1, NULL, '{\"codlote\":\"LOTE-001\",\"cant\":100,\"fecven\":\"2026-12-31\"}', NULL, NULL, NULL, '2025-11-23 15:00:00', '192.168.2.51'),
(39, 1, 2, 'ubicacion', 2, 1, '{\"nomubi\":\"Bodega Principal\",\"codubi\":\"BOD-01\"}', '{\"nomubi\":\"Bodega Principal A\",\"codubi\":\"BOD-01\"}', NULL, NULL, NULL, '2025-11-24 08:00:00', '192.168.1.101'),
(40, 3, 2, 'empresa', 2, 3, '{\"nomemp\":\"Ferretería El Tornillo\",\"telemp\":\"6023456789\"}', '{\"nomemp\":\"Ferretería El Tornillo\",\"telemp\":\"6023456790\"}', NULL, NULL, NULL, '2025-11-24 11:00:00', '192.168.3.20'),
(44, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-29 21:47:05', '::1'),
(45, NULL, 6, 'kardex', 1, 6, NULL, '{\"ope\":\"save\",\"idkar\":\"\",\"anio\":\"2025\",\"mes\":\"11\",\"cerrado\":\"0\"}', NULL, NULL, NULL, '2025-11-30 03:47:12', '::1'),
(46, 6, 6, 'ubicacion', 1, 6, NULL, '{\"idubi\":\"\",\"nomubi\":\"3\",\"codubi\":\"3\",\"dirubi\":\"3\",\"depubi\":\"3\",\"ciuubi\":\"3\",\"idresp\":\"2\",\"act\":\"1\",\"ope\":\"save\"}', NULL, NULL, NULL, '2025-11-30 03:47:51', '::1'),
(47, NULL, 6, 'movim', 1, 6, NULL, '{\":idkar\":\"6\",\":idprod\":\"5\",\":idubi\":\"6\",\":tipmov\":\"1\",\":cantmov\":\"3\",\":valmov\":\"33\",\":docref\":\"3\",\":obs\":\"3\",\":idusu\":6}', NULL, NULL, NULL, '2025-11-30 03:48:17', '::1'),
(48, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 16:34:07', '::1'),
(49, NULL, 6, 'kardex', 1, 7, NULL, '{\"ope\":\"save\",\"idkar\":\"\",\"anio\":\"2025\",\"mes\":\"10\",\"cerrado\":\"0\"}', NULL, NULL, NULL, '2025-12-03 22:34:16', '::1'),
(50, NULL, 6, 'movim', 1, 7, NULL, '{\":idkar\":\"7\",\":idprod\":\"1\",\":idubi\":\"6\",\":tipmov\":\"2\",\":cantmov\":\"7\",\":valmov\":\"8\",\":docref\":\"\",\":obs\":\"9\",\":idusu\":6}', NULL, NULL, NULL, '2025-12-03 22:34:35', '::1'),
(51, 6, 6, 'ubicacion', 1, 8, NULL, '{\"idubi\":\"\",\"nomubi\":\"44\",\"codubi\":\"44\",\"dirubi\":\"44\",\"depubi\":\"44\",\"ciuubi\":\"4\",\"idresp\":\"6\",\"act\":\"1\",\"ope\":\"save\"}', NULL, NULL, NULL, '2025-12-03 22:35:18', '::1'),
(52, 6, 6, 'ubicacion', 1, 9, NULL, '{\"idubi\":\"\",\"nomubi\":\"44\",\"codubi\":\"44\",\"dirubi\":\"44\",\"depubi\":\"44\",\"ciuubi\":\"4\",\"idresp\":\"6\",\"act\":\"1\",\"ope\":\"save\"}', NULL, NULL, NULL, '2025-12-03 22:36:34', '::1'),
(53, 6, 6, 'ubicacion', 1, 10, NULL, '{\"idubi\":\"\",\"nomubi\":\"44\",\"codubi\":\"44\",\"dirubi\":\"44\",\"depubi\":\"44\",\"ciuubi\":\"4\",\"idresp\":\"6\",\"act\":\"1\",\"ope\":\"save\"}', NULL, NULL, NULL, '2025-12-03 22:36:57', '::1'),
(54, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 16:42:29', '::1'),
(55, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 16:42:34', '::1'),
(56, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 16:43:24', '::1'),
(58, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 16:44:06', '::1'),
(59, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 16:44:13', '::1'),
(60, 1, 2, 'login', 4, NULL, NULL, NULL, 'juan@example.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 16:44:29', '::1'),
(61, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 16:44:31', '::1'),
(62, 1, 2, 'login', 4, NULL, NULL, NULL, 'juan@example.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 16:44:37', '::1'),
(63, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 16:45:04', '::1'),
(64, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 17:29:19', '::1'),
(65, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 15:52:35', '::1'),
(66, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 15:56:37', '::1'),
(67, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:16:50', '::1'),
(68, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:19:25', '::1'),
(70, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:19:37', '::1'),
(71, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:19:52', '::1'),
(72, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:21:34', '::1'),
(73, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:22:32', '::1'),
(74, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:22:39', '::1'),
(75, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:32:11', '::1'),
(76, 6, 6, 'logout', 6, NULL, NULL, NULL, 'alexis@example.com', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:41:27', '::1'),
(77, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:41:29', '::1'),
(78, 6, 6, 'logout', 6, NULL, NULL, NULL, 'alexis@example.com', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:41:32', '::1'),
(79, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:41:38', '::1'),
(80, 6, 6, 'logout', 6, NULL, NULL, NULL, 'alexis@example.com', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:43:31', '::1'),
(81, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:43:32', '::1'),
(82, 6, 7, 'login', 4, NULL, NULL, NULL, 'alexis1@example.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:51:50', '::1'),
(83, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:51:57', '::1'),
(84, 1, 1, 'logout', 6, NULL, NULL, NULL, 'admin@gmail.com', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:52:02', '::1'),
(85, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:52:08', '::1'),
(86, 6, 7, 'login', 4, NULL, NULL, NULL, 'alexis1@example.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:52:41', '::1'),
(87, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:55:05', '::1'),
(88, 6, 7, 'login', 4, NULL, NULL, NULL, 'alexis1@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:55:34', '::1'),
(89, 6, 7, 'logout', 6, NULL, NULL, NULL, 'alexis1@example.com', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:56:20', '::1'),
(90, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:56:22', '::1'),
(91, 6, 7, 'login', 4, NULL, NULL, NULL, 'alexis1@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 16:57:35', '::1'),
(92, 6, 7, 'movim', 1, 8, NULL, '{\"idmov\":\"\",\"ope\":\"save\",\"idemp\":\"6\",\"idusu\":\"7\",\"idprod\":\"2\",\"idubi\":\"2\",\"fecmov\":\"2025-12-06\",\"tipmov\":\"1\",\"cantmov\":\"33\",\"valmov\":\"33\",\"costprom\":\"33\",\"docref\":\"\",\"obs\":\"33\"}', NULL, NULL, NULL, '2025-12-06 23:09:13', '::1'),
(93, 6, 7, 'movim', 1, 9, NULL, '{\"idmov\":\"\",\"ope\":\"save\",\"idemp\":\"6\",\"idusu\":\"7\",\"idprod\":\"2\",\"idubi\":\"2\",\"fecmov\":\"2025-12-06\",\"tipmov\":\"1\",\"cantmov\":\"33\",\"valmov\":\"33\",\"costprom\":\"33\",\"docref\":\"\",\"obs\":\"33\"}', NULL, NULL, NULL, '2025-12-06 23:09:29', '::1'),
(94, 6, 7, 'movim', 1, 10, NULL, '{\"idmov\":\"\",\"ope\":\"save\",\"idemp\":\"6\",\"idusu\":\"7\",\"idkar\":\"6\",\"idprod\":\"6\",\"idubi\":\"6\",\"fecmov\":\"2025-12-06\",\"tipmov\":\"1\",\"cantmov\":\"11\",\"valmov\":\"11\",\"costprom\":\"11\",\"docref\":\"\",\"obs\":\"11\"}', NULL, NULL, NULL, '2025-12-06 23:14:55', '::1'),
(95, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 17:15:04', '::1'),
(96, NULL, 6, 'kardex', 1, 8, NULL, '{\"ope\":\"save\",\"idkar\":\"\",\"anio\":\"2025\",\"mes\":\"12\",\"cerrado\":\"0\"}', NULL, NULL, NULL, '2025-12-06 23:17:26', '::1'),
(97, 6, 6, 'movim', 1, 11, NULL, '{\"idmov\":\"\",\"ope\":\"save\",\"idemp\":\"6\",\"idusu\":\"6\",\"idkar\":\"8\",\"idprod\":\"6\",\"idubi\":\"8\",\"fecmov\":\"2025-12-06\",\"tipmov\":\"1\",\"cantmov\":\"12\",\"valmov\":\"12\",\"costprom\":\"122\",\"docref\":\"442\",\"obs\":\"22\"}', NULL, NULL, NULL, '2025-12-06 23:18:19', '::1'),
(98, 6, 6, 'login', 4, NULL, NULL, NULL, 'alexis@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 17:23:51', '::1'),
(99, 1, 1, 'login', 4, NULL, NULL, NULL, 'admin@gmail.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 17:24:12', '::1'),
(100, 1, 1, 'logout', 6, NULL, NULL, NULL, 'admin@gmail.com', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 17:24:30', '::1'),
(101, 6, 7, 'login', 4, NULL, NULL, NULL, 'alexis1@example.com', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-06 17:24:34', '::1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcat` int(10) NOT NULL,
  `nomcat` varchar(100) DEFAULT NULL,
  `descat` varchar(255) DEFAULT NULL,
  `idemp` int(10) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL,
  `act` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcat`, `nomcat`, `descat`, `idemp`, `fec_crea`, `fec_actu`, `act`) VALUES
(1, 'Electrónica', 'Dispositivos y componentes electrónicos', 1, NULL, NULL, NULL),
(2, 'Herramientas', 'Herramientas manuales y eléctricas', 1, NULL, NULL, NULL),
(3, 'Insumos', 'Materiales de oficina y limpieza', 2, NULL, NULL, NULL),
(4, 'Muebles', 'Mobiliario de oficina', 3, NULL, NULL, NULL),
(5, 'Repuestos', 'Repuestos industriales', 4, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detentrada`
--

CREATE TABLE `detentrada` (
  `iddet` int(10) NOT NULL,
  `idemp` int(10) DEFAULT NULL,
  `idsol` int(10) DEFAULT NULL,
  `idprod` int(10) DEFAULT NULL,
  `cantdet` int(11) DEFAULT NULL,
  `vundet` decimal(10,2) DEFAULT NULL,
  `totdet` decimal(10,2) GENERATED ALWAYS AS (`cantdet` * `vundet`) STORED,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detsalida`
--

CREATE TABLE `detsalida` (
  `iddet` int(10) NOT NULL,
  `idemp` int(10) DEFAULT NULL,
  `idsol` int(10) DEFAULT NULL,
  `idprod` int(10) DEFAULT NULL,
  `cantdet` int(11) DEFAULT NULL,
  `vundet` decimal(10,2) DEFAULT NULL,
  `totdet` decimal(10,2) GENERATED ALWAYS AS (`cantdet` * `vundet`) STORED,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dominio`
--

CREATE TABLE `dominio` (
  `iddom` int(10) NOT NULL,
  `nomdom` varchar(100) DEFAULT NULL,
  `desdom` varchar(255) DEFAULT NULL,
  `idemp` int(10) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL,
  `act` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `estado` tinyint(1) DEFAULT NULL,
  `idemp` int(10) NOT NULL,
  `nomemp` varchar(100) DEFAULT NULL,
  `razemp` varchar(150) DEFAULT NULL,
  `nitemp` varchar(20) DEFAULT NULL,
  `diremp` varchar(150) DEFAULT NULL,
  `telemp` varchar(15) DEFAULT NULL,
  `emaemp` varchar(100) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `idusu` int(10) DEFAULT NULL COMMENT 'Usuario creador',
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL,
  `act` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`estado`, `idemp`, `nomemp`, `razemp`, `nitemp`, `diremp`, `telemp`, `emaemp`, `logo`, `idusu`, `fec_crea`, `fec_actu`, `act`) VALUES
(NULL, 1, 'TechSolutions SA', 'TechSolutions Sociedad Anónima', '123456789-1', 'Calle 123 #45-67, Bogotá', '6012345678', 'contacto@techsolutions.com', NULL, 1, NULL, NULL, NULL),
(NULL, 2, 'DistriElectro', 'Distribuidora Electrónica Ltda', '987654321-1', 'Av. Principal 890, Medellín', '6045678901', 'ventas@distrielectro.com', NULL, 1, NULL, NULL, NULL),
(NULL, 3, 'Ferretería El Tornillo', 'Ferretería El Tornillo SAS', '555444333-2', 'Cra. 45 #56-78, Cali', '6023456789', 'info@eltornillo.com', NULL, 2, NULL, NULL, NULL),
(NULL, 4, 'Papelería Moderna', 'Papelería Moderna Ltda', '111222333-4', 'Av. Comercial 123, Medellín', '6056789012', 'contacto@papeleriamoderna.com', NULL, 3, NULL, NULL, NULL),
(NULL, 5, 'Bodega Central', 'Bodega Central SAS', '999888777-5', 'Zona Industrial, Barranquilla', '6051234567', 'bodega@central.com', NULL, 4, NULL, NULL, NULL),
(1, 6, 'empresota', 'empresita', '1111', 'cra4a286', '223', 'contactame@miempresa', 'logo_692b96e69885d3.74651544.png', 6, '2025-11-30 01:59:18', '2025-11-30 01:59:18', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `idinv` int(10) NOT NULL,
  `idemp` int(10) DEFAULT NULL,
  `idprod` int(10) DEFAULT NULL,
  `idubi` int(10) DEFAULT NULL,
  `cant` int(11) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`idinv`, `idemp`, `idprod`, `idubi`, `cant`, `fec_crea`, `fec_actu`) VALUES
(1, 1, 1, 1, 15, NULL, NULL),
(2, 1, 2, 1, 30, NULL, NULL),
(3, 2, 3, 2, 150, NULL, NULL),
(4, 3, 4, 3, 12, NULL, NULL),
(5, 4, 5, 4, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex`
--

CREATE TABLE `kardex` (
  `idkar` int(10) NOT NULL,
  `idemp` int(10) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `mes` tinyint(4) DEFAULT NULL,
  `cerrado` tinyint(1) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `kardex`
--

INSERT INTO `kardex` (`idkar`, `idemp`, `anio`, `mes`, `cerrado`, `fec_crea`, `fec_actu`) VALUES
(1, 1, 2024, 1, 1, NULL, NULL),
(2, 2, 2024, 1, 0, NULL, NULL),
(3, 3, 2024, 2, 0, NULL, NULL),
(4, 4, 2024, 2, 1, NULL, NULL),
(5, 5, 2024, 3, 0, NULL, NULL),
(6, 6, 2025, 11, 0, NULL, NULL),
(7, 6, 2025, 10, 0, NULL, NULL),
(8, 6, 2025, 12, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE `lote` (
  `idlote` int(10) NOT NULL,
  `idprod` int(10) DEFAULT NULL,
  `codlote` varchar(50) DEFAULT NULL,
  `fecven` date DEFAULT NULL,
  `cant` int(11) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modulo`
--

CREATE TABLE `modulo` (
  `idmod` int(10) NOT NULL,
  `nommod` varchar(100) DEFAULT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `ruta` varchar(100) DEFAULT NULL,
  `orden` tinyint(4) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL,
  `act` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modulo`
--

-- 
-- Volcado de datos para la tabla `dominio`
--

INSERT INTO `dominio` (`iddom`, `nomdom`, `desdom`, `fec_crea`, `fec_actu`, `act`) VALUES
(1, 'tipo de documento', 'identificacion de personas', '2025-11-06 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `valor`
--

-- (Sin datos iniciales en v4.6, pero tabla disponible para uso)

--

INSERT INTO `modulo` (`idmod`, `nommod`, `icono`, `ruta`, `orden`, `fec_crea`, `fec_actu`, `act`) VALUES
(1, 'Principal', 'fa fa-layer-group', '#', 1, '2025-11-29 19:57:42', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movim`
--

CREATE TABLE `movim` (
  `idmov` int(10) NOT NULL,
  `idkar` int(10) DEFAULT NULL,
  `idprod` int(10) DEFAULT NULL,
  `idubi` int(10) DEFAULT NULL,
  `fecmov` date DEFAULT NULL,
  `tipmov` tinyint(2) DEFAULT NULL COMMENT '1=ENTRADA, 2=SALIDA',
  `cantmov` int(11) DEFAULT NULL,
  `valmov` decimal(12,2) DEFAULT NULL,
  `costprom` decimal(12,2) DEFAULT NULL,
  `docref` varchar(50) DEFAULT NULL,
  `obs` text DEFAULT NULL,
  `idusu` int(10) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `movim`
--

INSERT INTO `movim` (`idmov`, `idkar`, `idprod`, `idubi`, `fecmov`, `tipmov`, `cantmov`, `valmov`, `costprom`, `docref`, `obs`, `idusu`, `fec_crea`, `fec_actu`) VALUES
(1, 1, 1, 1, '2024-01-15', 1, 5, 2500.00, 500.00, 'FACT-001', NULL, 1, '2025-11-29 19:57:42', '2025-11-29 19:57:42'),
(2, 1, 2, 1, '2024-01-15', 1, 10, 2000.00, 200.00, 'FACT-001', NULL, 1, '2025-11-29 19:57:42', '2025-11-29 19:57:42'),
(3, 2, 3, 2, '2024-01-18', 1, 50, 180.50, 3.61, 'FACT-002', NULL, 1, '2025-11-29 19:57:42', '2025-11-29 19:57:42'),
(4, 3, 4, 3, '2024-02-05', 2, 3, 900.00, 300.00, 'FACT-003', NULL, 2, '2025-11-29 19:57:42', '2025-11-29 19:57:42'),
(5, 4, 5, 4, '2024-02-10', 1, 7, 1400.00, 200.00, 'FACT-004', NULL, 3, '2025-11-29 19:57:42', '2025-11-29 19:57:42'),
(6, 6, 5, 6, '2025-11-29', 1, 3, 33.00, NULL, '3', '3', 6, '2025-11-29 21:48:17', NULL),
(7, 7, 1, 6, '2025-12-03', 2, 7, 8.00, NULL, '', '9', 6, '2025-12-03 16:34:35', NULL),
(8, NULL, 2, 2, '2025-12-06', 1, 33, 33.00, 33.00, '', '33', 7, '2025-12-06 17:09:13', '2025-12-06 17:09:13'),
(9, NULL, 2, 2, '2025-12-06', 1, 33, 33.00, 33.00, '', '33', 7, '2025-12-06 17:09:29', '2025-12-06 17:09:29'),
(10, 6, 6, 6, '2025-12-06', 1, 11, 11.00, 11.00, '', '11', 7, '2025-12-06 17:14:55', '2025-12-06 17:14:55'),
(11, 8, 6, 8, '2025-12-06', 1, 12, 12.00, 122.00, '442', '22', 6, '2025-12-06 17:18:19', '2025-12-06 17:18:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagina`
--

CREATE TABLE `pagina` (
  `idpag` int(10) NOT NULL,
  `idmod` int(10) DEFAULT NULL,
  `nompag` varchar(100) DEFAULT NULL,
  `ruta` varchar(100) DEFAULT NULL,
  `icono` varchar(50) DEFAULT NULL,
  `orden` tinyint(4) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL,
  `act` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagina`
--

INSERT INTO `pagina` (`idpag`, `idmod`, `nompag`, `ruta`, `icono`, `orden`, `fec_crea`, `fec_actu`, `act`) VALUES
(1001, 1, 'Empresas', 'views/vemp.php', 'fa fa-building', 1, '2025-11-29 19:57:42', NULL, 1),
(1002, 1, 'Productos', 'views/vprod.php', 'fa fa-box', 2, '2025-11-29 19:57:42', NULL, 1),
(1003, 1, 'Proveedores', 'views/vprov.php', 'fa fa-truck', 3, '2025-11-29 19:57:42', NULL, 1),
(1004, 1, 'Usuarios Empresa', 'views/vusemp.php', 'fa fa-users', 4, '2025-11-29 19:57:42', NULL, 1),
(1005, 1, 'Categorías', 'views/vcat.php', 'fa fa-tags', 5, '2025-11-29 19:57:42', NULL, 1),
(1006, 1, 'Auditoría', 'views/vaud.php', 'fa fa-shield', 6, '2025-11-29 19:57:42', NULL, 1),
(1007, 1, 'Kardex', 'views/vkard.php', 'fa fa-clipboard-list', 7, '2025-11-29 19:57:42', NULL, 1),
(1008, 1, 'Lotes', 'views/vlote.php', 'fa fa-layer-group', 8, '2025-11-29 19:57:42', NULL, 1),
(1009, 1, 'Inventario', 'views/vinv.php', 'fa fa-boxes', 9, '2025-11-29 19:57:42', NULL, 1),
(1010, 1, 'Movimientos', 'views/vmovim.php', 'fa fa-exchange-alt', 10, '2025-11-29 19:57:42', NULL, 1),
(1011, 1, 'Dominios', 'views/vdom.php', 'fa fa-database', 11, '2025-11-29 19:57:42', NULL, 1),
(1012, 1, 'Valores', 'views/vval.php', 'fa fa-check-circle', 12, '2025-11-29 19:57:42', NULL, 1),
(1013, 1, 'Solicitud Salida', 'views/vsolsal.php', 'fa fa-file-alt', 13, '2025-11-29 19:57:42', NULL, 1),
(1014, 1, 'Detalle salida', 'views/vdetsal.php', 'fa fa-file-alt', 14, '2025-11-29 19:57:42', NULL, 1),
(1015, 1, 'Solicitud entrada', 'views/vsoent.php', 'fa fa-file-alt', 15, '2025-11-29 19:57:42', NULL, 1),
(1016, 1, 'Modulo', 'views/vmod.php', 'fa fa-file-alt', 16, '2025-11-29 19:57:42', NULL, 1),
(1017, 1, 'Ubicacion', 'views/vubi.php', 'fa fa-map-marker-alt', 17, '2025-11-29 19:57:42', NULL, 1),
(1018, 1, 'Usuarios', 'views/vusu.php', 'fa fa-user-cog', 18, '2025-11-29 19:57:42', NULL, 1),
(1019, 1, 'Pagina', 'views/vpag.php', 'fa fa-user-cog', 19, '2025-11-29 19:57:42', NULL, 1),
(1020, 1, 'Perfil', 'views/vper.php', 'fa fa-user-cog', 20, '2025-11-29 19:57:42', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `idper` int(10) NOT NULL,
  `nomper` varchar(100) DEFAULT NULL,
  `ver` tinyint(1) DEFAULT NULL,
  `crear` tinyint(1) DEFAULT NULL,
  `editar` tinyint(1) DEFAULT NULL,
  `eliminar` tinyint(1) DEFAULT NULL,
  `act` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`idper`, `nomper`, `ver`, `crear`, `editar`, `eliminar`, `act`) VALUES
(1, 'Superadmin', 1, 1, 1, 1, 1),
(2, 'Admin/empresa', 1, 1, 1, 0, 1),
(3, 'Empleado', 1, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `tipo_inventario` tinyint(1) DEFAULT NULL COMMENT '1=Mercancías, 2=Materia Prima, 3=En Proceso, 4=Terminados',
  `idprod` int(10) NOT NULL,
  `codprod` varchar(20) DEFAULT NULL,
  `nomprod` varchar(100) DEFAULT NULL,
  `desprod` varchar(200) DEFAULT NULL,
  `idcat` int(10) DEFAULT NULL,
  `idemp` int(10) DEFAULT NULL,
  `unimed` varchar(20) DEFAULT NULL,
  `stkmin` int(11) DEFAULT NULL,
  `stkmax` int(11) DEFAULT NULL,
  `imgprod` varchar(255) DEFAULT NULL,
  `costouni` decimal(12,2) DEFAULT NULL COMMENT 'Costo unitario (opcional)',
  `precioven` decimal(12,2) DEFAULT NULL COMMENT 'Precio de venta (opcional)',
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL,
  `act` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`tipo_inventario`, `idprod`, `codprod`, `nomprod`, `desprod`, `idcat`, `idemp`, `unimed`, `stkmin`, `stkmax`, `imgprod`, `costouni`, `precioven`, `fec_crea`, `fec_actu`, `act`) VALUES
(1, 1, 'PROD-001', 'Laptop HP EliteBook', 'Laptop i7 16GB RAM 512GB SSD', 1, 1, 'UND', 5, 50, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 2, 'PROD-002', 'Taladro Inalámbrico', 'Taladro 20V con 2 baterías', 2, 1, 'UND', 10, 100, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 3, 'PROD-003', 'Resma Papel A4', 'Paquete 500 hojas 75g', 3, 2, 'UND', 20, 200, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 4, 'PROD-004', 'Silla Oficina', 'Silla ergonómica ejecutiva', 4, 3, 'UND', 5, 30, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 5, 'PROD-005', 'Filtro de Aire', 'Filtro para maquinaria industrial', 5, 4, 'UND', 2, 15, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 6, 'PROD-001', 'lol', '1', 1, 6, 'UND', 0, 111, NULL, 1.00, 1.00, '2025-12-06 23:14:32', '2025-12-06 23:14:32', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `idprov` int(10) NOT NULL,
  `idubi` int(10) DEFAULT NULL,
  `tipoprov` varchar(20) DEFAULT NULL,
  `nomprov` varchar(100) DEFAULT NULL,
  `docprov` varchar(20) DEFAULT NULL,
  `telprov` varchar(15) DEFAULT NULL,
  `emaprov` varchar(100) DEFAULT NULL,
  `dirprov` varchar(150) DEFAULT NULL,
  `idemp` int(10) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL,
  `act` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`idprov`, `idubi`, `tipoprov`, `nomprov`, `docprov`, `telprov`, `emaprov`, `dirprov`, `idemp`, `fec_crea`, `fec_actu`, `act`) VALUES
(1, 1, 'Jurídico', 'ElectroParts SA', '987654321-2', '6012345679', 'compras@electroparts.com', 'Calle 456 #78-90, Bogotá', 1, NULL, NULL, NULL),
(2, 2, 'Jurídico', 'Papelería Moderna', '543216789-1', '6056789012', 'contacto@papeleriamoderna.com', 'Av. Comercial 123, Medellín', 2, NULL, NULL, NULL),
(3, 3, 'Natural', 'Carlos Torres', '1122334455', '3101234567', 'carlos.torres@mail.com', 'Cra 10 #20-30, Cali', 3, NULL, NULL, NULL),
(4, 4, 'Jurídico', 'Muebles S.A.S', '2233445566', '3159876543', 'ventas@muebles.com', 'Zona Industrial 45, Medellín', 4, NULL, NULL, NULL),
(5, 5, 'Jurídico', 'Repuestos Industriales Ltda', '3344556677', '3009871234', 'contacto@repuestos.com', 'Av. 80 #45-67, Bogotá', 5, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pxp`
--

CREATE TABLE `pxp` (
  `idper` int(10) DEFAULT NULL,
  `idpag` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pxp`
--

INSERT INTO `pxp` (`idper`, `idpag`) VALUES
(1, 1001),
(1, 1002),
(1, 1003),
(1, 1004),
(1, 1005),
(1, 1006),
(1, 1007),
(1, 1008),
(1, 1009),
(1, 1010),
(1, 1011),
(1, 1012),
(1, 1013),
(1, 1014),
(1, 1015),
(1, 1016),
(1, 1017),
(1, 1018),
(1, 1019),
(1, 1020),
(2, 1001),
(2, 1002),
(2, 1003),
(2, 1004),
(2, 1005),
(2, 1006),
(2, 1007),
(2, 1008),
(2, 1009),
(2, 1010),
(2, 1013),
(2, 1015),
(2, 1017),
(3, 1002),
(3, 1005),
(3, 1009),
(3, 1010);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solentrada`
--

CREATE TABLE `solentrada` (
  `idsol` int(10) NOT NULL,
  `idemp` int(10) DEFAULT NULL,
  `idprov` int(10) DEFAULT NULL,
  `idubi` int(10) DEFAULT NULL,
  `fecsol` date DEFAULT NULL,
  `fecent` date DEFAULT NULL,
  `tippag` varchar(20) DEFAULT NULL,
  `estsol` varchar(20) DEFAULT NULL,
  `totsol` decimal(12,2) DEFAULT NULL,
  `obssol` text DEFAULT NULL,
  `idusu` int(10) DEFAULT NULL,
  `idusu_apr` int(10) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solsalida`
--

CREATE TABLE `solsalida` (
  `idsol` int(10) NOT NULL,
  `idemp` int(10) DEFAULT NULL,
  `idubi` int(10) DEFAULT NULL,
  `fecsol` date DEFAULT NULL,
  `estsol` varchar(20) DEFAULT NULL,
  `totsol` decimal(12,2) DEFAULT NULL,
  `obssol` text DEFAULT NULL,
  `idusu` int(10) DEFAULT NULL,
  `idusu_apr` int(10) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `idubi` int(10) NOT NULL,
  `nomubi` varchar(100) DEFAULT NULL,
  `codubi` varchar(20) DEFAULT NULL,
  `dirubi` varchar(150) DEFAULT NULL,
  `depubi` varchar(100) DEFAULT NULL,
  `ciuubi` varchar(100) DEFAULT NULL,
  `idemp` int(10) DEFAULT NULL,
  `idresp` int(10) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL,
  `act` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ubicacion`
--

INSERT INTO `ubicacion` (`idubi`, `nomubi`, `codubi`, `dirubi`, `depubi`, `ciuubi`, `idemp`, `idresp`, `fec_crea`, `fec_actu`, `act`) VALUES
(1, 'Bodega Principal', 'BOD-01', 'Calle 123 #45-67', 'Bogotá DC', 'Bogotá', 1, 1, NULL, NULL, NULL),
(2, 'Centro de Distribución', 'BOD-02', 'Av. Industrial 789', 'Antioquia', 'Medellín', 2, 1, NULL, NULL, NULL),
(3, 'Almacén Cali', 'BOD-03', 'Cra. 45 #56-78', 'Valle', 'Cali', 3, 2, NULL, NULL, NULL),
(4, 'Depósito Medellín', 'BOD-04', 'Av. Comercial 123', 'Antioquia', 'Medellín', 4, 3, NULL, NULL, NULL),
(5, 'Bodega Barranquilla', 'BOD-05', 'Zona Industrial', 'Atlántico', 'Barranquilla', 5, 4, NULL, NULL, NULL),
(6, '3', '3', '3', '3', '3', 6, 2, '2025-11-30 03:47:51', '2025-11-30 03:47:51', 1),
(8, '44', '44', '44', '44', '4', 6, 6, '2025-12-03 22:35:18', '2025-12-03 22:35:18', 1),
(9, '44', '44', '44', '44', '4', 6, 6, '2025-12-03 22:36:34', '2025-12-03 22:36:34', 1),
(10, '44', '44', '44', '44', '4', 6, 6, '2025-12-03 22:36:57', '2025-12-03 22:36:57', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusu` int(10) NOT NULL,
  `nomusu` varchar(100) DEFAULT NULL,
  `apeusu` varchar(100) DEFAULT NULL,
  `tdousu` varchar(20) DEFAULT NULL COMMENT 'Tipo doc (valor dominio)',
  `ndousu` varchar(20) DEFAULT NULL,
  `celusu` varchar(15) DEFAULT NULL,
  `emausu` varchar(100) DEFAULT NULL,
  `pasusu` varchar(255) DEFAULT NULL,
  `imgusu` varchar(255) DEFAULT NULL,
  `idper` int(10) DEFAULT NULL,
  `tokreset` varchar(255) DEFAULT NULL,
  `fecreset` datetime DEFAULT NULL,
  `ultlogin` datetime DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL,
  `act` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusu`, `nomusu`, `apeusu`, `tdousu`, `ndousu`, `celusu`, `emausu`, `pasusu`, `imgusu`, `idper`, `tokreset`, `fecreset`, `ultlogin`, `fec_crea`, `fec_actu`, `act`) VALUES
(1, 'Admin', 'Sistema', 'CC', '123456789', '3001234567', 'admin@gmail.com', 'e0f53c0a8c931f995f898d5f166491ccbdc7f528kjahw9', NULL, 1, NULL, NULL, NULL, NULL, '2025-12-06 16:47:54', 1),
(2, 'Juan', 'Pérez', 'CC', '987654321', '3102345678', 'juan@example.com', 'a9108ef59cf29bdd49c6ab3a91997aa25fe8bfdekjahw9', NULL, 2, NULL, NULL, NULL, NULL, '2025-12-06 16:47:56', 1),
(3, 'María', 'Gómez', 'TI', '1122334455', '3203456789', 'maria@example.com', 'e0f53c0a8c931f995f898d5f166491ccbdc7f528kjahw9', NULL, 3, NULL, NULL, NULL, NULL, '2025-12-06 16:47:58', 1),
(4, 'Pedro', 'Rodríguez', 'CC', '2233445566', '3009876543', 'pedro@example.com', '$2b$12$6oTkFgnxtIkSkZsTnjy5Zu3ydEEdgUUU9PA46z3DGljO3U2KPCclq', NULL, 1, NULL, NULL, NULL, NULL, '2025-12-06 16:48:03', 1),
(5, 'Laura', 'Martínez', 'CE', '3344556677', '3158765432', 'laura@example.com', 'a9108ef59cf29bdd49c6ab3a91997aa25fe8bfdekjahw9', NULL, 3, NULL, NULL, NULL, NULL, '2025-12-06 16:48:00', 1),
(6, 'Brayan', 'Zabala', 'CC', '101841795', '3202091145', 'alexis@example.com', 'a9108ef59cf29bdd49c6ab3a91997aa25fe8bfdekjahw9', NULL, 1, NULL, NULL, NULL, '2025-11-30 01:58:15', '2025-11-30 01:58:15', 1),
(7, '22', '22', '', '22', '2', 'alexis1@example.com', 'a9108ef59cf29bdd49c6ab3a91997aa25fe8bfdekjahw9', '2', 3, NULL, NULL, NULL, '2025-12-06 22:57:30', '2025-12-06 22:57:30', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_empresa`
--

CREATE TABLE `usuario_empresa` (
  `idusu` int(10) DEFAULT NULL,
  `idemp` int(10) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_empresa`
--

INSERT INTO `usuario_empresa` (`idusu`, `idemp`, `fec_crea`) VALUES
(1, 1, '2025-11-20 14:50:01'),
(2, 1, '2025-11-20 14:50:01'),
(3, 2, '2025-11-20 14:50:01'),
(4, 3, '2025-11-20 14:50:01'),
(5, 4, '2025-11-20 14:50:01'),
(6, 6, '2025-11-30 01:59:18'),
(7, 6, '2025-12-06 22:51:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valor`
--

CREATE TABLE `valor` (
  `idval` int(10) NOT NULL,
  `nomval` varchar(100) DEFAULT NULL,
  `iddom` int(10) DEFAULT NULL,
  `codval` varchar(20) DEFAULT NULL,
  `desval` varchar(255) DEFAULT NULL,
  `idemp` int(10) DEFAULT NULL,
  `fec_crea` datetime DEFAULT NULL,
  `fec_actu` datetime DEFAULT NULL,
  `act` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD PRIMARY KEY (`idaud`),
  ADD KEY `fkauem` (`idemp`),
  ADD KEY `fkauus` (`idusu`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcat`),
  ADD KEY `fkcaem` (`idemp`);

--
-- Indices de la tabla `detentrada`
--
ALTER TABLE `detentrada`
  ADD PRIMARY KEY (`iddet`),
  ADD KEY `fk_detent_idemp` (`idemp`),
  ADD KEY `fk_detent_idsol` (`idsol`),
  ADD KEY `fk_detent_idprod` (`idprod`);

--
-- Indices de la tabla `detsalida`
--
ALTER TABLE `detsalida`
  ADD PRIMARY KEY (`iddet`),
  ADD KEY `fk_detsal_idemp` (`idemp`),
  ADD KEY `fk_detsal_idsol` (`idsol`),
  ADD KEY `fk_detsal_idprod` (`idprod`);

--
-- Indices de la tabla `dominio`
--
ALTER TABLE `dominio`
  ADD PRIMARY KEY (`iddom`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idemp`),
  ADD UNIQUE KEY `nitemp` (`nitemp`),
  ADD KEY `fkemus` (`idusu`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`idinv`),
  ADD UNIQUE KEY `uk_inv_emp_prod_ubi` (`idemp`,`idprod`,`idubi`),
  ADD KEY `fk_inv_idemp` (`idemp`),
  ADD KEY `fk_inv_idprod` (`idprod`),
  ADD KEY `fk_inv_idubi` (`idubi`);

--
-- Indices de la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD PRIMARY KEY (`idkar`),
  ADD UNIQUE KEY `uk_kardex` (`idemp`,`anio`,`mes`);

--
-- Indices de la tabla `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`idlote`),
  ADD KEY `fk_lote_idprod` (`idprod`);

--
-- Indices de la tabla `modulo`
--
ALTER TABLE `modulo`
  ADD PRIMARY KEY (`idmod`);

--
-- Indices de la tabla `movim`
--
ALTER TABLE `movim`
  ADD PRIMARY KEY (`idmov`),
  ADD KEY `fk_movim_idkar` (`idkar`),
  ADD KEY `fk_movim_idprod` (`idprod`),
  ADD KEY `fk_movim_idubi` (`idubi`),
  ADD KEY `fk_movim_idusu` (`idusu`);

--
-- Indices de la tabla `pagina`
--
ALTER TABLE `pagina`
  ADD PRIMARY KEY (`idpag`),
  ADD KEY `fk_pg_idmod` (`idmod`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`idper`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idprod`),
  ADD KEY `fk_prod_idcat` (`idcat`),
  ADD KEY `fk_prod_idemp` (`idemp`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`idprov`),
  ADD KEY `fk_prv_idubi` (`idubi`),
  ADD KEY `fk_prv_idemp` (`idemp`);

--
-- Indices de la tabla `pxp`
--
ALTER TABLE `pxp`
  ADD KEY `fk_pxp_idper` (`idper`),
  ADD KEY `fk_pxp_idpag` (`idpag`);

--
-- Indices de la tabla `solentrada`
--
ALTER TABLE `solentrada`
  ADD PRIMARY KEY (`idsol`),
  ADD KEY `fk_solent_idemp` (`idemp`),
  ADD KEY `fk_solent_idprov` (`idprov`),
  ADD KEY `fk_solent_idubi` (`idubi`),
  ADD KEY `fk_solent_idusu` (`idusu`),
  ADD KEY `fk_solent_idusuapr` (`idusu_apr`);

--
-- Indices de la tabla `solsalida`
--
ALTER TABLE `solsalida`
  ADD PRIMARY KEY (`idsol`),
  ADD KEY `fk_solsal_idemp` (`idemp`),
  ADD KEY `fk_solsal_idubi` (`idubi`),
  ADD KEY `fk_solsal_idusu` (`idusu`),
  ADD KEY `fk_solsal_idusuapr` (`idusu_apr`);

--
-- Indices de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD PRIMARY KEY (`idubi`),
  ADD KEY `fk_ubi_idemp` (`idemp`),
  ADD KEY `fk_ubi_idresp` (`idresp`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusu`),
  ADD KEY `fkuspe` (`idper`);

--
-- Indices de la tabla `usuario_empresa`
--
ALTER TABLE `usuario_empresa`
  ADD KEY `fk_ue_idusu` (`idusu`),
  ADD KEY `fk_ue_idemp` (`idemp`);

--
-- Indices de la tabla `valor`
--
ALTER TABLE `valor`
  ADD PRIMARY KEY (`idval`),
  ADD KEY `fk_val_iddom` (`iddom`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `auditoria`
--
ALTER TABLE `auditoria`
  MODIFY `idaud` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcat` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `detentrada`
--
ALTER TABLE `detentrada`
  MODIFY `iddet` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detsalida`
--
ALTER TABLE `detsalida`
  MODIFY `iddet` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dominio`
--
ALTER TABLE `dominio`
  MODIFY `iddom` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idemp` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `idinv` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `kardex`
--
ALTER TABLE `kardex`
  MODIFY `idkar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `lote`
--
ALTER TABLE `lote`
  MODIFY `idlote` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `modulo`
--
ALTER TABLE `modulo`
  MODIFY `idmod` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `movim`
--
ALTER TABLE `movim`
  MODIFY `idmov` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pagina`
--
ALTER TABLE `pagina`
  MODIFY `idpag` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1021;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `idper` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idprod` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `idprov` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `solentrada`
--
ALTER TABLE `solentrada`
  MODIFY `idsol` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solsalida`
--
ALTER TABLE `solsalida`
  MODIFY `idsol` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  MODIFY `idubi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusu` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `valor`
--
ALTER TABLE `valor`
  MODIFY `idval` int(10) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD CONSTRAINT `fkauem` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`),
  ADD CONSTRAINT `fkauus` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `fkcaem` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`);

--
-- Filtros para la tabla `detentrada`
--
ALTER TABLE `detentrada`
  ADD CONSTRAINT `fk_detent_emp` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`),
  ADD CONSTRAINT `fk_detent_ids` FOREIGN KEY (`idsol`) REFERENCES `solentrada` (`idsol`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detent_prod` FOREIGN KEY (`idprod`) REFERENCES `producto` (`idprod`);

--
-- Filtros para la tabla `detsalida`
--
ALTER TABLE `detsalida`
  ADD CONSTRAINT `fk_detsal_emp` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`),
  ADD CONSTRAINT `fk_detsal_ids` FOREIGN KEY (`idsol`) REFERENCES `solsalida` (`idsol`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detsal_prod` FOREIGN KEY (`idprod`) REFERENCES `producto` (`idprod`);

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `fkemus` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_inv_emp` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`),
  ADD CONSTRAINT `fk_inv_prod` FOREIGN KEY (`idprod`) REFERENCES `producto` (`idprod`),
  ADD CONSTRAINT `fk_inv_ubi` FOREIGN KEY (`idubi`) REFERENCES `ubicacion` (`idubi`);

--
-- Filtros para la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD CONSTRAINT `fkkaem` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`);

--
-- Filtros para la tabla `lote`
--
ALTER TABLE `lote`
  ADD CONSTRAINT `fk_lote_prod` FOREIGN KEY (`idprod`) REFERENCES `producto` (`idprod`);

--
-- Filtros para la tabla `movim`
--
ALTER TABLE `movim`
  ADD CONSTRAINT `fk_movim_kar` FOREIGN KEY (`idkar`) REFERENCES `kardex` (`idkar`),
  ADD CONSTRAINT `fk_movim_prod` FOREIGN KEY (`idprod`) REFERENCES `producto` (`idprod`),
  ADD CONSTRAINT `fk_movim_ubi` FOREIGN KEY (`idubi`) REFERENCES `ubicacion` (`idubi`),
  ADD CONSTRAINT `fk_movim_usu` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `pagina`
--
ALTER TABLE `pagina`
  ADD CONSTRAINT `fkpgmo` FOREIGN KEY (`idmod`) REFERENCES `modulo` (`idmod`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fkprca` FOREIGN KEY (`idcat`) REFERENCES `categoria` (`idcat`),
  ADD CONSTRAINT `fkprem` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`);

--
-- Filtros para la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD CONSTRAINT `fkpremp` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`),
  ADD CONSTRAINT `fkprub` FOREIGN KEY (`idubi`) REFERENCES `ubicacion` (`idubi`);

--
-- Filtros para la tabla `pxp`
--
ALTER TABLE `pxp`
  ADD CONSTRAINT `fkpxpe` FOREIGN KEY (`idper`) REFERENCES `perfil` (`idper`),
  ADD CONSTRAINT `fkpxpg` FOREIGN KEY (`idpag`) REFERENCES `pagina` (`idpag`);

--
-- Filtros para la tabla `solentrada`
--
ALTER TABLE `solentrada`
  ADD CONSTRAINT `fk_solent_emp` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`),
  ADD CONSTRAINT `fk_solent_prov` FOREIGN KEY (`idprov`) REFERENCES `proveedor` (`idprov`),
  ADD CONSTRAINT `fk_solent_ubi` FOREIGN KEY (`idubi`) REFERENCES `ubicacion` (`idubi`),
  ADD CONSTRAINT `fk_solent_usu` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`),
  ADD CONSTRAINT `fk_solent_usuapr` FOREIGN KEY (`idusu_apr`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `solsalida`
--
ALTER TABLE `solsalida`
  ADD CONSTRAINT `fk_solsal_emp` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`),
  ADD CONSTRAINT `fk_solsal_ubi` FOREIGN KEY (`idubi`) REFERENCES `ubicacion` (`idubi`),
  ADD CONSTRAINT `fk_solsal_usu` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`),
  ADD CONSTRAINT `fk_solsal_usuapr` FOREIGN KEY (`idusu_apr`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `ubicacion`
--
ALTER TABLE `ubicacion`
  ADD CONSTRAINT `fkubem` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`),
  ADD CONSTRAINT `fkubus` FOREIGN KEY (`idresp`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fkuspe` FOREIGN KEY (`idper`) REFERENCES `perfil` (`idper`);

--
-- Filtros para la tabla `usuario_empresa`
--
ALTER TABLE `usuario_empresa`
  ADD CONSTRAINT `fk_ue_em` FOREIGN KEY (`idemp`) REFERENCES `empresa` (`idemp`),
  ADD CONSTRAINT `fk_ue_us` FOREIGN KEY (`idusu`) REFERENCES `usuario` (`idusu`);

--
-- Filtros para la tabla `valor`
--
ALTER TABLE `valor`
  ADD CONSTRAINT `fkvldm` FOREIGN KEY (`iddom`) REFERENCES `dominio` (`iddom`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

