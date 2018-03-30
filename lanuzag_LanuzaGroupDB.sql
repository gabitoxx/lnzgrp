-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 19-01-2017 a las 14:02:30
-- Versión del servidor: 5.5.51-38.2
-- Versión de PHP: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `lanuzag_LanuzaGroupDB`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Usuarios`
--

CREATE TABLE IF NOT EXISTS `Usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `empresa` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `dependencia` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_ingreso` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Todos los Usuarios del sistema';

--
-- Volcado de datos para la tabla `Usuarios`
--

INSERT INTO `Usuarios` (`id`, `usuario`, `nombre`, `apellido`, `email`, `empresa`, `role`, `dependencia`, `fecha_ingreso`) VALUES
(1, 'user', 'prueba', 'Probando', 'e3@gc.com', 'Enterprise', 'developer', 'LanuzaGroup', '2017-01-19 18:57:13'),
(2, 'developer', 'Dev', 'Eloper', 'dev@eloper.com', 'LanuzaGroup', 'developer', 'LanuzaGroup', '2017-01-19 19:01:52');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Usuarios`
--
ALTER TABLE `Usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
