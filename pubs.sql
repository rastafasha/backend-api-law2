-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 16-02-2025 a las 20:06:52
-- Versión del servidor: 5.7.34
-- Versión de PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `api_rest_consultorios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pubs`
--

CREATE TABLE `pubs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:pendiente, 2:activo',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pubs`
--

INSERT INTO `pubs` (`id`, `avatar`, `state`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'publicidads/9FjTB5hAHOvGcnizqlDJDxw3z0Hu2x4cdE5WFjen.jpg', 1, '2024-01-15 23:01:53', '2024-01-15 23:09:50', NULL),
(2, 'publicidads/K4I5kBZ3BZF593DNit2Szh4fNiYvXUQfpe3gYtRm.jpg', 1, '2024-01-15 23:04:36', '2024-01-15 23:04:36', NULL),
(3, 'publicidads/sqNEtxj0WBa9vbTPEhk5THYMMEEnwdVvUQFFozio.jpg', 1, '2024-01-15 23:06:00', '2024-01-15 23:06:00', NULL),
(4, 'publicidads/EMQZLSdot9yEk6fOgPBlg9ED1umWJizlh53p8wD3.jpg', 2, '2024-01-15 23:06:50', '2024-01-15 23:06:50', NULL),
(5, 'publicidads/874AfEidDRuJTt0LTELllkat2xxmAGDsRck3FIbb.jpg', 2, '2024-01-15 23:10:42', '2024-01-16 02:11:57', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pubs`
--
ALTER TABLE `pubs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pubs`
--
ALTER TABLE `pubs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
