-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2022 a las 14:52:19
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `business2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `brand`
--

CREATE TABLE `brand` (
  `id_brand` int(50) NOT NULL,
  `brand` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `brand`
--

INSERT INTO `brand` (`id_brand`, `brand`) VALUES
(1, 'Prada'),
(2, 'Gucci'),
(3, 'Las Oreiro'),
(4, 'Zarkani'),
(5, 'Calvin Klein'),
(6, 'Zara'),
(7, 'Soleil');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clothes`
--

CREATE TABLE `clothes` (
  `id` int(50) NOT NULL,
  `id_clothes` int(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `size` varchar(50) NOT NULL,
  `colour` varchar(50) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clothes`
--

INSERT INTO `clothes` (`id`, `id_clothes`, `description`, `size`, `colour`, `price`) VALUES
(1, 1, 'vestido de fiesta con lentejuelas moradas', 'small', 'lila', 35000),
(2, 2, 'vestido largo estilo halter con tirantes y detalles de frunces y abertura en la cintura', 'large', 'blanco', 43000),
(3, 3, 'vestido largo estampado con escote en v cruzado y volados', 'medium', 'verde', 25000),
(4, 5, 'vestido strapless de raso corto de noche', 'xlarge', 'rosa', 32000),
(5, 7, 'vestido de novia estilo sirena de gaza bordada', 'large', 'blanco', 58000),
(6, 7, 'vestido largo de playa estampado con tirantes cruzados en la espalda', 'xlarge', 'rosa', 17000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(50) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `password`) VALUES
(1, 'ana@gmail.com', '$2a$12$9z3zJ4.N3ylUhyB8c5EpOu1mtoWqEK98HMxSmqYypNXwkxcj5D.cC');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id_brand`);

--
-- Indices de la tabla `clothes`
--
ALTER TABLE `clothes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_id_clothes` (`id_clothes`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `brand`
--
ALTER TABLE `brand`
  MODIFY `id_brand` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `clothes`
--
ALTER TABLE `clothes`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clothes`
--
ALTER TABLE `clothes`
  ADD CONSTRAINT `clothes_ibfk_1` FOREIGN KEY (`id_clothes`) REFERENCES `brand` (`id_brand`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
