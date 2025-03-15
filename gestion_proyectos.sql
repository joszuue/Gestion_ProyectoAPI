-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 15-03-2025 a las 03:44:18
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_proyectos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

DROP TABLE IF EXISTS `equipo`;
CREATE TABLE IF NOT EXISTS `equipo` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_responsable` int NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `estado` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `equipo_id_responsable_index` (`id_responsable`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`id`, `id_responsable`, `nombre`, `estado`) VALUES
(1, 6, 'TEST', 'Eliminado'),
(2, 6, 'Equipo 2 UPDATE', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `integrantes_equipo`
--

DROP TABLE IF EXISTS `integrantes_equipo`;
CREATE TABLE IF NOT EXISTS `integrantes_equipo` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_equipo` int NOT NULL,
  `id_usuario` int NOT NULL,
  `estado` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `integrantes_equipo_id_equipo_index` (`id_equipo`),
  KEY `integrantes_equipo_id_usuario_index` (`id_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progreso_tarea`
--

DROP TABLE IF EXISTS `progreso_tarea`;
CREATE TABLE IF NOT EXISTS `progreso_tarea` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tarea` int NOT NULL,
  `comentario` varchar(500) NOT NULL,
  `last_estado` varchar(100) NOT NULL,
  `new_estado` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `progreso_tarea_id_tarea_index` (`id_tarea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--

DROP TABLE IF EXISTS `proyecto`;
CREATE TABLE IF NOT EXISTS `proyecto` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `id_equipo` int NOT NULL,
  `fecha_entrega` date NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `estado` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `proyecto_id_cliente_index` (`id_cliente`),
  KEY `proyecto_id_equipo_index` (`id_equipo`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `proyecto`
--

INSERT INTO `proyecto` (`id`, `id_cliente`, `id_equipo`, `fecha_entrega`, `nombre`, `estado`) VALUES
(1, 1, 1, '2025-03-29', 'Test Proyecto', 'Activo'),
(2, 5, 10, '2025-04-29', 'Test Proyecto UPDATE', 'Eliminado'),
(3, 5, 10, '2025-04-29', 'Test Proyecto 3', 'Eliminado'),
(4, 15, 1, '2025-01-29', 'Desafio 1 UPDATE', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--

DROP TABLE IF EXISTS `tarea`;
CREATE TABLE IF NOT EXISTS `tarea` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_proyecto` int NOT NULL,
  `tarea` varchar(1000) NOT NULL,
  `estado` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tarea_id_proyecto_index` (`id_proyecto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea_responsables`
--

DROP TABLE IF EXISTS `tarea_responsables`;
CREATE TABLE IF NOT EXISTS `tarea_responsables` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tarea` int NOT NULL,
  `id_responsable` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tarea_responsables_id_tarea_index` (`id_tarea`),
  KEY `tarea_responsables_id_responsable_index` (`id_responsable`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombres` varchar(250) NOT NULL,
  `apellidos` varchar(250) NOT NULL,
  `email` varchar(500) NOT NULL,
  `contra` varchar(500) NOT NULL,
  `rol` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `email`, `contra`, `rol`, `estado`) VALUES
(1, 'TESTtttt', 'Vásquezzz', '', '$2y$10$aBw1O6QX8bJcmDN1eLYqBuxt0tyg8BHJ5aE2b9Rwnism3WDvnliXC', 'uwu', 'Activo'),
(2, 'Denis', 'Rodríguez', '', 'xd', 'Admin', 'Activo'),
(3, 'TEST', 'Vásquez', '', '$2y$10$mNhVNcJEaj6hly06M/x9NeTuVebgwVZ7jns/O5Wd7miWabck7a9dG', 'User', 'Activo'),
(4, 'TEST', 'Vásque', '', '$2y$10$72gjG5n4zuAG5irofa1eHeSilzba2obHTDBTu2K1RogxYiHFs3Tgm', 'uwu', 'Activo'),
(5, 'TEST', 'Vásquez', 'josue@gmail.com', '$2y$10$B1k4jnilqlObEgKtuFwTZ.NLmoo06VDf2KZIX6ynanwdOwu0uGGZ.', ' ', 'Eliminado'),
(6, 'Josué UPDATE', 'Rodríguez UPDATE', 'imjosuu@gmail.com', '$2y$10$QuJsruqzvK9UuC6XYRivKOxJJmfXXZ7yWmURv3tuhIvGyp8tJNty', 'Cliente', 'Activo');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
