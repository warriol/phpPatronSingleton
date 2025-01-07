-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-06-2023 a las 18:23:59
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `labphp2023`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `pass` varchar(50) DEFAULT NULL,
  `nick` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `nombre`, `apellido`, `pass`, `nick`) VALUES
(1, 'Wilson', 'Arriola', 'MXLxL0TGO50E3T41Aiam4w==', 'wilson'),
(2, 'Fabio', 'Cedres', 'nH/kNhylgM3/MNvjZlNKqQ==', 'fabio'),
(3, 'Juan', 'Rodriguez', 'hgvuEWO57bvTKtn+MXLnjA==', 'profesor'),
(5, 'Julio', 'Rodriguez', 'FBCd9su/8saF3NqQGznmdQ==', 'julio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor`
--

CREATE TABLE `autor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `idPais` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autor`
--

INSERT INTO `autor` (`id`, `nombre`, `idPais`) VALUES
(1, 'Socrates', 41),
(2, 'Pablo Neruda', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editoriales`
--

CREATE TABLE `editoriales` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `editoriales`
--

INSERT INTO `editoriales` (`id`, `nombre`) VALUES
(1, 'Planeta Libros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `idautor` int(11) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `ideditorial` int(11) DEFAULT NULL,
  `anio_publicacion` int(11) DEFAULT NULL,
  `disponibilidad` tinyint(1) DEFAULT 1,
  `copias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `titulo`, `idautor`, `categoria`, `ideditorial`, `anio_publicacion`, `disponibilidad`, `copias`) VALUES
(1, 'Confieso que he vivido', 2, 'Libros de literatura', 1, 1974, 1, 30),
(2, 'Residencia en la tierra', 2, 'Libros de literatura', 1, 1933, 1, 31);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `idpais` int(3) NOT NULL,
  `pais` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`idpais`, `pais`) VALUES
(1, 'AFGANO'),
(2, 'AFRICANO'),
(3, 'ALBANO'),
(4, 'ALEMAN'),
(5, 'ARABE'),
(6, 'ARGELINO'),
(7, 'ARGENTINO'),
(8, 'ARMENIO'),
(9, 'ASIATICO'),
(10, 'AUSTRALIANO'),
(11, 'AUSTRIACO'),
(12, 'BELGA'),
(13, 'BOLIVIANO'),
(14, 'BRASILERO'),
(15, 'BULGARO'),
(16, 'CABOVERDIANO'),
(17, 'CANADIENSE'),
(18, 'CELIANES'),
(22, 'COLOMBIANO'),
(23, 'COREANO'),
(24, 'COSTA RICENSE'),
(25, 'CROATA'),
(26, 'CUBANO'),
(19, 'CHECOSLOVACO'),
(20, 'CHILENO'),
(21, 'CHINO'),
(27, 'DINAMARQUES'),
(28, 'DOMINICANO'),
(29, 'ECUATORIANO'),
(30, 'EGIPCIO'),
(31, 'ESCOCES'),
(32, 'ESLOVACO'),
(33, 'ESPAÑOL'),
(34, 'ESTADOUNIDENSE'),
(35, 'ESTONIO'),
(36, 'ETIOPE'),
(37, 'FILIPINO'),
(38, 'FINLANDES'),
(39, 'FRANCES'),
(40, 'GABONES'),
(41, 'GRIEGO'),
(42, 'GUATEMALTECO'),
(43, 'HOLANDES'),
(44, 'HONDUREÑO'),
(45, 'HUNGARO'),
(46, 'INDONESIO'),
(47, 'INDU'),
(48, 'INGLES'),
(49, 'IRAKI'),
(50, 'IRANI'),
(51, 'ISLANDIA'),
(52, 'ISRAELITA'),
(53, 'ITALIANO'),
(54, 'JAMAIQUINO'),
(55, 'JAPONES'),
(56, 'JORDANO'),
(57, 'LETONES'),
(58, 'LIBANES'),
(59, 'LITUANO'),
(60, 'MARROQUI'),
(61, 'MEJICANO'),
(62, 'MONGOL'),
(63, 'MONTENEGRINO'),
(64, 'NAMIBIO'),
(65, 'NEOZELANDES'),
(66, 'NICARAGUENSE'),
(67, 'NIGERIANO'),
(68, 'NORUEGO'),
(69, 'ORIENTAL'),
(70, 'PAKISTANI'),
(71, 'PALESTINO'),
(72, 'PANAMEÑO'),
(73, 'PARAGUAYO'),
(74, 'PERUANO'),
(75, 'POLACO'),
(76, 'POLONES'),
(77, 'PORTUGUES'),
(78, 'PUERTORIQUEÑO'),
(79, 'QATARI'),
(80, 'RUMANO'),
(81, 'RUSO'),
(82, 'SALVADOREÑO'),
(83, 'SIERRA LEONA'),
(84, 'SIRIO'),
(85, 'SUAZI'),
(86, 'SUDAFRICANO'),
(87, 'SUDANES'),
(88, 'SUECO'),
(89, 'SUIZO'),
(90, 'SURINAMES'),
(91, 'TAILANDES'),
(92, 'TURCO'),
(93, 'UCRANIANO'),
(94, 'URUGUAYO'),
(95, 'VENEZOLANO'),
(96, 'VIETNAMITA'),
(97, 'YUGOSLAVO'),
(98, 'ZAIREÑO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` int(11) NOT NULL,
  `libro_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_prestamo` date NOT NULL,
  `fecha_devolucion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `idAdministrador` int(11) NOT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `idAdministrador`, `direccion`, `email`, `estado`) VALUES
(1, 5, 'Colonia 1234', 'julio.rodriguez@correo.com', 'activo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `libro_id` (`libro_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `autor`
--
ALTER TABLE `autor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`libro_id`) REFERENCES `libros` (`id`),
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id`) REFERENCES `administradores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
