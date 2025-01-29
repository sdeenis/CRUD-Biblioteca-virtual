-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-01-2025 a las 10:33:47
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
(1, 5),
(1, 7),
(2, 3),
(2, 6),
(3, 2),
(3, 4),
(4, 1),
(4, 5),
(5, 6),
(5, 8),
(6, 7),
(6, 3),
(7, 2),
(7, 1),
(8, 4),
(8, 7),
(9, 6),
(9, 5),
(10, 1),
(10, 2),
(10, 3),
(11, 4),
(12, 5),
(12, 6),
(13, 3),
(14, 7),
(15, 2),
(15, 4),
(16, 1),
(16, 6),
(17, 5),
(18, 8);

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
(1, 'Cien años de soledad', 'Realismo mágico', '417', 'Colombia', '1967', '10', '8'),
(2, 'El amor en los tiempos del cólera', 'Romántico', '348', 'Colombia', '1985', '6', '4'),
(3, 'Don Quijote de la Mancha', 'Aventura', '1043', 'España', '1605', '15', '12'),
(4, 'Matar a un ruiseñor', 'Drama', '324', 'EE.UU.', '1960', '8', '6'),
(5, '1984', 'Distopía', '328', 'Reino Unido', '1949', '12', '9'),
(6, 'Orgullo y prejuicio', 'Romántico', '432', 'Reino Unido', '1813', '7', '6'),
(7, 'Cumbres Borrascosas', 'Drama', '416', 'Reino Unido', '1847', '5', '5'),
(8, 'La sombra del viento', 'Misterio', '560', 'España', '2001', '9', '7'),
(9, 'La Casa de los Espíritus', 'Realismo mágico', '448', 'Chile', '1982', '11', '9'),
(10, 'Fahrenheit 451', 'Ciencia ficción', '256', 'EE.UU.', '1953', '8', '6'),
(11, 'El gran Gatsby', 'Ficción', '180', 'EE.UU.', '1925', '6', '4'),
(12, 'Frankenstein', 'Horror', '280', 'Reino Unido', '1818', '4', '3'),
(13, 'Drácula', 'Horror', '416', 'Irlanda', '1897', '10', '8'),
(14, 'La Odisea', 'Épica', '375', 'Grecia', '800 a.C.', '7', '7'),
(15, 'Crimen y castigo', 'Psicológico', '430', 'Rusia', '1866', '9', '7'),
(16, 'El retrato de Dorian Gray', 'Filosófico', '254', 'Irlanda', '1890', '5', '4'),
(17, 'Mujer que mira a un hombre', 'Drama', '352', 'España', '2018', '6', '6'),
(18, 'La metamorfosis', 'Surrealista', '144', 'Alemania', '1915', '8', '6'),
(19, 'En busca del tiempo perdido', 'Literatura clásica', '4300', 'Francia', '1913', '3', '3'),
(20, 'El Principito', 'Fábula', '96', 'Francia', '1943', '15', '12');


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
(1, 'Ana', 'Pérez', 'España'),
(2, 'Juan', 'Pérez', 'México'),
(3, 'Ana', 'Martín', 'Argentina'),
(4, 'Pepe', 'Gómez', 'Colombia'),
(5, 'José María', 'González', 'España'),
(6, 'Cristina', 'Sánchez', 'Francia'),
(7, 'Olga', 'Smith', 'Reino Unido'),
(8, 'Marcelo', 'Lopez', 'Chile'),
(9, 'Carla', 'Fernández', 'Uruguay'),
(10, 'Luis', 'Alvarez', 'Perú');

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
(4, 'user1', 'pass1', '11111111A', 'Juan', 'Pérez', 'Calle Falsa 123', '28042', '0'),
(5, 'user2', 'pass2', '22222222B', 'María', 'López', 'Avenida Principal 456', '28042', '1'),
(6, 'user3', 'pass3', '33333333C', 'Carlos', 'Gómez', 'Calle del Sol 789', '28042', '2'),
(7, 'user4', 'pass4', '44444444D', 'Ana', 'Martínez', 'Calle Luna 101', '28042', '3');

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
  MODIFY `idLibro` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

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
