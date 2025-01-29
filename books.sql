-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-01-2025 a las 09:14:46
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
-- Base de datos: `books`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escriben`
--

CREATE TABLE `escriben` (
  `idLibro` bigint(20) NOT NULL,
  `idPersona` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `escriben`
--

INSERT INTO `escriben` (`idLibro`, `idPersona`) VALUES
(2, 1),
(2, 2),
(4, 2),
(4, 3),
(20, 5),
(20, 6),
(23, 1),
(23, 2),
(23, 5),
(24, 1),
(24, 3),
(25, 1),
(25, 3),
(27, 7),
(28, 1),
(28, 3),
(29, 4),
(29, 7),
(31, 4),
(33, 6),
(33, 7),
(35, 1),
(35, 2),
(35, 3),
(35, 4),
(35, 5),
(35, 6),
(35, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `idLibro` bigint(20) NOT NULL,
  `titulo` varchar(30) DEFAULT 'novela',
  `genero` varchar(45) DEFAULT NULL,
  `numPaginas` varchar(6) DEFAULT '100',
  `pais` varchar(255) NOT NULL DEFAULT 'España',
  `ano` varchar(4) NOT NULL DEFAULT '2000',
  `ejemplares` varchar(4) DEFAULT '1',
  `disponibles` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`idLibro`, `titulo`, `genero`, `numPaginas`, `pais`, `ano`, `ejemplares`, `disponibles`) VALUES
(2, 'My novel', 'Novela', '200', 'Reino Unido', '2000', '5', '5'),
(4, 'Mi novela preferida', 'novela', '135', 'Francia', '2003', '3', '3'),
(20, 'Bélgica mía', 'Novela', '150', 'Bélgica', '2003', '3', '3'),
(23, 'Mi burro', 'Poesia', '85', 'España', '2003', '1', '0'),
(24, 'Me llamo ana', 'Poesia', '85', 'España', '2000', '2', '1'),
(25, 'Dos autoras', 'Poesia', '85', 'España', '2000', '1', '1'),
(27, 'Soy Olga', 'Poesia', '145', 'Reino Unido', '2020', '7', '7'),
(28, 'Mi gata Flora', 'Poesia', '200', 'Bélgica', '2004', '1', '0'),
(29, 'Mi primo Andrés', 'Poesia', '145', 'Reino Unido', '1950', '2', '2'),
(31, 'Autobiografía', 'Poesia', '150', 'Bélgica', '2004', '1', '1'),
(33, 'Mi pueblo33333', 'Poesia', '200', 'Reino Unido', '2020', '4', '4'),
(35, 'dkbfab', 'kbshjfbds', '324', 'fsekldmkldsm', '2131', '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `idPersona` bigint(20) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `pais` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `personas`
--

INSERT INTO `personas` (`idPersona`, `nombre`, `apellido`, `pais`) VALUES
(1, 'ana', 'perez', ''),
(2, 'juan', 'perez', ''),
(3, 'ana', 'martin', ''),
(4, 'pepe', 'fox', ''),
(5, 'José María', 'González', 'España'),
(6, 'Cristina', 'Sotch', 'Francia'),
(7, 'Olga', 'Smith', 'Reino Unido'),
(8, 'safdef', 'fdsfdsfa', 'asd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestan`
--

CREATE TABLE `prestan` (
  `idprestan` bigint(20) NOT NULL,
  `iduser` bigint(20) DEFAULT NULL,
  `idlibro` bigint(20) DEFAULT NULL,
  `fechai` datetime DEFAULT current_timestamp(),
  `fechaf` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestan`
--

INSERT INTO `prestan` (`idprestan`, `iduser`, `idlibro`, `fechai`, `fechaf`) VALUES
(35, 1, 23, '2025-01-16 09:18:56', '2025-01-16 10:43:13'),
(43, 1, 24, '2025-01-21 09:53:04', '2025-01-21 09:33:19'),
(44, 2, 28, '2025-01-21 09:55:52', '2025-01-21 09:55:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestanhist`
--

CREATE TABLE `prestanhist` (
  `idhist` int(11) NOT NULL,
  `iduser` bigint(20) DEFAULT NULL,
  `datosuser` varchar(200) DEFAULT NULL,
  `idlibro` bigint(20) DEFAULT NULL,
  `datoslibro` varchar(200) DEFAULT NULL,
  `fechaf` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestanhist`
--

INSERT INTO `prestanhist` (`idhist`, `iduser`, `datosuser`, `idlibro`, `datoslibro`, `fechaf`) VALUES
(1, 1, 'a@a.com;1a;a;a;calle a, 1, 1a;28042', 25, 'Dos autoras;perez, ana;martin, ana;85;2000;España', '2025-01-21 09:26:08'),
(2, 1, 'a@a.com;1a;a;a;calle a, 1, 1a;28042', 2, 'My novel;perez, ana;perez, juan;200;2000;Reino Unido', '2025-01-21 09:31:57'),
(3, 1, 'a@a.com;1a;a;a;calle a, 1, 1a;28042', 4, 'Mi novela preferida;perez, juan;martin, ana;135;2003;Francia', '2025-01-21 09:34:35'),
(4, 1, 'a@a.com;1a;a;a;calle a, 1, 1a;28042', 20, 'Bélgica mía;González, José María;Sotch, Cristina;150;2003;Bélgica', '2025-01-21 09:35:14'),
(5, 2, 'b@c.bom;2b;b;b;calle b, 2, 2b;28042', 35, 'dkbfab;perez, ana;perez, juan;martin, ana;fox, pepe;González, José María;Sotch, Cristina;Smith, Olga;324;2131;fsekldmkldsm', '2025-01-21 09:55:49'),
(6, 2, 'b@c.bom;2b;b;b;calle b, 2, 2b;28042', 31, 'Autobiografía;fox, pepe;150;2004;Bélgica', '2025-01-21 09:55:50');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `iduser` bigint(20) NOT NULL,
  `user` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'login único',
  `pass` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `dni` varchar(9) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `nomcli` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `apecli` varchar(50) DEFAULT NULL,
  `dircli` varchar(100) DEFAULT NULL,
  `cpcli` varchar(5) DEFAULT '28042',
  `nivel` set('0','1','2','3') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`iduser`, `user`, `pass`, `dni`, `nomcli`, `apecli`, `dircli`, `cpcli`, `nivel`) VALUES
(1, 'a@a.com', 'a', '1a', 'a', 'a', 'calle a, 1, 1a', '28042', '3'),
(2, 'b@c.bom', 'b', '2b', 'b', 'b', 'calle b, 2, 2b', '28042', '0'),
(3, 'c', 'c', 'ccc', 'cccc', 'ccc', 'ccc', '28042', '0');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vlibros`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vlibros` (
`idLibro` bigint(20)
,`titulo` varchar(30)
,`genero` varchar(45)
,`numPaginas` varchar(6)
,`ano` varchar(4)
,`pais` varchar(255)
,`autores` mediumtext
,`ejemplares` varchar(4)
,`disponibles` varchar(4)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vlibros`
--
DROP TABLE IF EXISTS `vlibros`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vlibros`  AS SELECT `escriben`.`idLibro` AS `idLibro`, `libros`.`titulo` AS `titulo`, `libros`.`genero` AS `genero`, `libros`.`numPaginas` AS `numPaginas`, `libros`.`ano` AS `ano`, `libros`.`pais` AS `pais`, group_concat(concat(`personas`.`apellido`,', ',`personas`.`nombre`) separator ';') AS `autores`, `libros`.`ejemplares` AS `ejemplares`, `libros`.`disponibles` AS `disponibles` FROM ((`libros` join `escriben` on(`libros`.`idLibro` = `escriben`.`idLibro`)) join `personas` on(`escriben`.`idPersona` = `personas`.`idPersona`)) GROUP BY `escriben`.`idLibro` ORDER BY `libros`.`idLibro` ASC, `libros`.`titulo` ASC ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `escriben`
--
ALTER TABLE `escriben`
  ADD PRIMARY KEY (`idLibro`,`idPersona`),
  ADD KEY `fk_escriben_personas` (`idPersona`),
  ADD KEY `fk_escriben_libro` (`idLibro`) USING BTREE;

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`idLibro`);

--
-- Indices de la tabla `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`idPersona`);

--
-- Indices de la tabla `prestan`
--
ALTER TABLE `prestan`
  ADD PRIMARY KEY (`idprestan`);

--
-- Indices de la tabla `prestanhist`
--
ALTER TABLE `prestanhist`
  ADD PRIMARY KEY (`idhist`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `USER_U` (`user`),
  ADD UNIQUE KEY `DNI_U` (`dni`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `idLibro` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `personas`
--
ALTER TABLE `personas`
  MODIFY `idPersona` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `prestan`
--
ALTER TABLE `prestan`
  MODIFY `idprestan` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `prestanhist`
--
ALTER TABLE `prestanhist`
  MODIFY `idhist` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `iduser` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `escriben`
--
ALTER TABLE `escriben`
  ADD CONSTRAINT `fk_escriben_libros` FOREIGN KEY (`idLibro`) REFERENCES `libros` (`idLibro`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_escriben_personas` FOREIGN KEY (`idPersona`) REFERENCES `personas` (`idPersona`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
