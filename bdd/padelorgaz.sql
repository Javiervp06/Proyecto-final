-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2026 a las 18:50:28
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
-- Base de datos: `padelorgaz`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_solicitud` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(20) NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`id`, `nombre`, `email`, `telefono`, `mensaje`, `fecha_solicitud`, `estado`) VALUES
(9, 'Javier', 'javiervidartep06@gmail.com', '665333791', 'Avanzados', '2026-05-11 14:37:15', 'Pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `nombre`, `email`, `telefono`, `mensaje`, `fecha`) VALUES
(1, 'Javier', 'jvidartep05@educarex.es', '600000000', 'ASUNTO: Padel\n-------------------\nhola', '2026-05-06 10:29:48');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pistas`
--

CREATE TABLE `pistas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pistas`
--

INSERT INTO `pistas` (`id`, `nombre`, `descripcion`, `imagen`) VALUES
(1, 'Pista 1', 'Pista exterior', 'pista1.jpg'),
(2, 'Pista 2', 'Pista exterior', 'pista2.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `especialidad` varchar(100) NOT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `nombre`, `email`, `telefono`, `especialidad`, `fecha_alta`) VALUES
(1, 'Alberto Garrido', 'albertoGarri@yahoo.es', '777231423', 'Menores', '2026-05-06 10:55:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id` int(11) NOT NULL,
  `dia` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `pista_id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `nivel` varchar(50) NOT NULL,
  `jugadores` int(11) NOT NULL,
  `resultado` enum('pendiente','victoria','derrota') DEFAULT 'pendiente',
  `abierta_a_jugadores` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id`, `dia`, `hora_inicio`, `hora_fin`, `pista_id`, `id_usuario`, `usuario`, `telefono`, `creado_en`, `nivel`, `jugadores`, `resultado`, `abierta_a_jugadores`) VALUES
(11, '2026-02-10', '09:00:00', '10:30:00', 0, 0, NULL, NULL, '2026-04-27 18:00:42', 'amistoso libre', 1, 'pendiente', 1),
(12, '2026-04-28', '09:00:00', '10:30:00', 1, 2, NULL, NULL, '2026-04-28 15:57:02', 'amistoso libre', 2, 'victoria', 1),
(13, '2026-04-28', '09:00:00', '10:30:00', 1, 4, NULL, NULL, '2026-04-28 19:21:48', 'amistoso libre', 2, 'pendiente', 1),
(14, '2026-05-01', '16:30:00', '18:00:00', 2, 4, NULL, NULL, '2026-04-28 19:23:40', 'amistoso 0.25', 2, 'pendiente', 1),
(15, '2026-05-01', '16:30:00', '18:00:00', 2, 8, NULL, NULL, '2026-04-28 19:24:18', 'amistoso libre', 2, 'pendiente', 1),
(16, '2026-04-29', '15:00:00', '16:30:00', 2, 8, NULL, NULL, '2026-04-28 19:28:59', 'amistoso 0.25', 1, 'pendiente', 1),
(18, '2026-05-01', '10:30:00', '12:00:00', 1, 2, NULL, NULL, '2026-04-29 16:57:52', 'amistoso libre', 4, 'derrota', 1),
(19, '2026-04-29', '19:30:00', '21:00:00', 1, 2, NULL, NULL, '2026-04-29 17:28:50', 'amistoso libre', 4, 'victoria', 1),
(20, '2026-05-02', '12:00:00', '13:30:00', 2, 2, NULL, NULL, '2026-04-30 14:32:22', 'amistoso 0.5', 1, 'victoria', 1),
(21, '2026-05-02', '16:30:00', '18:00:00', 1, 10, NULL, NULL, '2026-04-30 16:19:29', 'amistoso libre', 2, 'derrota', 1),
(22, '2026-05-03', '09:00:00', '10:30:00', 1, 10, NULL, NULL, '2026-04-30 16:21:40', 'amistoso libre', 4, 'victoria', 1),
(23, '2026-05-01', '10:30:00', '12:00:00', 2, 2, NULL, NULL, '2026-05-01 08:28:21', 'amistoso libre', 1, 'derrota', 1),
(24, '2026-05-03', '18:00:00', '19:30:00', 1, 2, NULL, NULL, '2026-05-01 08:36:02', 'amistoso libre', 1, 'victoria', 1),
(26, '2026-05-05', '15:00:00', '16:30:00', 1, 10, NULL, NULL, '2026-05-04 16:42:00', 'amistoso libre', 4, 'pendiente', 1),
(27, '2026-05-05', '09:00:00', '10:30:00', 1, 10, NULL, NULL, '2026-05-04 17:42:33', 'amistoso libre', 1, 'pendiente', 1),
(29, '2026-05-07', '10:30:00', '12:00:00', 2, 2, NULL, NULL, '2026-05-04 18:16:18', 'amistoso libre', 1, 'pendiente', 1),
(31, '2026-05-05', '15:00:00', '16:30:00', 2, 10, NULL, NULL, '2026-05-04 18:21:31', 'amistoso libre', 1, 'pendiente', 1),
(32, '2026-05-05', '15:00:00', '16:30:00', 2, 10, NULL, NULL, '2026-05-04 18:21:57', 'amistoso libre', 3, 'derrota', 1),
(37, '2026-05-05', '18:00:00', '19:30:00', 1, 10, NULL, NULL, '2026-05-04 18:34:17', 'amistoso libre', 1, 'victoria', 1),
(38, '2026-05-05', '18:00:00', '19:30:00', 1, 2, NULL, NULL, '2026-05-04 18:34:43', 'amistoso libre', 3, 'pendiente', 1),
(41, '2026-05-05', '09:00:00', '10:30:00', 1, 10, NULL, NULL, '2026-05-04 18:40:36', 'amistoso libre', 3, 'pendiente', 1),
(43, '2026-05-08', '09:00:00', '10:30:00', 2, 2, NULL, NULL, '2026-05-05 14:20:23', 'amistoso libre', 3, 'pendiente', 1),
(44, '2026-05-08', '18:00:00', '19:30:00', 1, 2, NULL, NULL, '2026-05-05 14:22:23', 'amistoso 0.25', 1, 'pendiente', 1),
(48, '2026-05-08', '10:30:00', '12:00:00', 1, 2, NULL, NULL, '2026-05-05 14:30:30', 'amistoso libre', 1, 'pendiente', 1),
(51, '2026-05-05', '19:30:00', '21:00:00', 2, 10, NULL, NULL, '2026-05-05 15:50:32', 'amistoso libre', 1, 'pendiente', 1),
(52, '2026-05-05', '19:30:00', '21:00:00', 2, 10, NULL, NULL, '2026-05-05 15:50:41', 'amistoso libre', 3, 'derrota', 1),
(54, '2026-05-07', '09:00:00', '10:30:00', 2, 2, NULL, NULL, '2026-05-05 15:56:12', 'amistoso libre', 3, 'pendiente', 1),
(56, '2026-05-09', '13:30:00', '15:00:00', 1, 2, NULL, NULL, '2026-05-05 16:22:06', 'amistoso libre', 2, 'pendiente', 1),
(57, '2026-05-07', '18:00:00', '19:30:00', 2, 2, NULL, NULL, '2026-05-05 16:23:48', 'amistoso libre', 1, 'pendiente', 1),
(60, '2026-05-07', '09:00:00', '10:30:00', 1, 2, NULL, NULL, '2026-05-05 16:28:32', 'amistoso libre', 3, 'pendiente', 1),
(61, '2026-05-07', '12:00:00', '13:30:00', 1, 2, NULL, NULL, '2026-05-05 16:30:43', 'amistoso libre', 1, 'pendiente', 1),
(63, '2026-05-07', '16:30:00', '18:00:00', 2, 10, NULL, NULL, '2026-05-05 16:38:04', 'amistoso libre', 3, 'pendiente', 1),
(66, '2026-05-09', '13:30:00', '15:00:00', 2, 2, NULL, NULL, '2026-05-06 16:32:29', 'amistoso 0.25', 1, 'pendiente', 1),
(67, '2026-05-07', '09:00:00', '10:30:00', 1, 10, NULL, NULL, '2026-05-06 16:36:38', 'amistoso libre', 1, 'victoria', 1),
(68, '2026-05-09', '13:30:00', '15:00:00', 1, 10, NULL, NULL, '2026-05-08 16:43:17', 'amistoso libre', 2, 'pendiente', 1),
(69, '2026-05-11', '09:00:00', '10:30:00', 2, 10, NULL, NULL, '2026-05-09 18:14:10', 'amistoso libre', 1, 'pendiente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `apellidos` varchar(100) DEFAULT NULL,
  `alias` varchar(50) DEFAULT NULL,
  `sexo` varchar(20) DEFAULT NULL,
  `posicion` varchar(20) DEFAULT NULL,
  `nivel` decimal(3,2) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(20) DEFAULT 'usuario',
  `remember_token` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `telefono`, `email`, `creado_en`, `apellidos`, `alias`, `sexo`, `posicion`, `nivel`, `avatar`, `password`, `rol`, `remember_token`, `reset_token`, `reset_expires`) VALUES
(2, 'Javier', '600000000', 'jvidartep05@educarex.es', '2026-04-13 12:26:54', 'Pulido', 'jvp', 'masculino', 'drive', 1.30, '1777474218_whatsapp.jpg', '$2y$10$t/CC3d7t.7Dd3DynOpVdpOT3ya5n78/ebFfxPgTylcR9gwR9EM/7a', 'usuario', NULL, '0cd89891c8810464fdae837b984ebaddea1c71b82cd304800f59312147c2ddb5', '2026-05-05 20:04:42'),
(4, 'Invitado', '600000004', 'invitado@yahoo.es', '2026-04-15 14:24:47', 'invitado', 'miau', 'masculino', 'reves', 1.00, '1777404100_Logopaginaweb.png', '$2y$10$YMulSpJe3SW9PxFTyeTAWuI2jXBIIpXwApedaLHbNP30ECSFKVyha', 'usuario', NULL, NULL, NULL),
(6, 'Jose', '743245983', 'Josepp@yahoo.es', '2026-04-17 15:28:47', 'Pulido', 'Josete', 'masculino', 'drive', 1.00, '1776439824_oso-saludo.jpg', '$2y$10$vkF4RCWYA8A86h5rTMMuF.rT.QBZ3J0O.oAhL70Uf4D3dgRKl90fm', 'usuario', NULL, NULL, NULL),
(8, 'Hola', '600000000', 'holahola@yahoo.es', '2026-04-27 16:03:58', 'miaullll', 'Juan', 'masculino', 'drive', 2.00, '1777313288_pista2.jpg', '$2y$10$Z04HViujlV02NeEwGt7b6.7fzavj5qn4Vf4e0kkil.jox520FCw1q', 'usuario', NULL, NULL, NULL),
(10, 'Javier', '665333791', 'javiervidartep06@gmail.com', '2026-04-30 15:31:33', 'Vidarte Pulido', 'JavierVidarte', 'masculino', 'drive', 1.06, '1777563180_Florentino.jpg', '$2y$10$rbR9hdVM0KnMj3FKNgsoNOHiqGlN4.NUTQz1vtTdOpYN9iQRoudsa', 'admin', '11d55dd342c0aac521095ffc79a7ca2c903ed2f4', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pistas`
--
ALTER TABLE `pistas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pista_id` (`pista_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alias` (`alias`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pistas`
--
ALTER TABLE `pistas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
