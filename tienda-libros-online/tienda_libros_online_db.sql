-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-10-2023 a las 21:49:07
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_libros_online_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `nombre_completo`, `email`, `contraseña`) VALUES
(1, 'Cristian P', 'cristianperkins1994@gmail.com', '$2y$10$S0caCgUceAS./xLLTo/92ORtwdVUxmF0NUcowAG7OsU6OBx7RVasG\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor`
--

CREATE TABLE `autor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `autor`
--

INSERT INTO `autor` (`id`, `nombre`, `apellido`) VALUES
(1, 'Stephen', 'King'),
(2, 'Homero', ''),
(3, 'Lewis', 'Carroll'),
(4, 'Howard Phillips', 'Lovecraft'),
(5, 'Dante', 'Alighieri'),
(6, 'Hipócrates', ''),
(7, 'Miguel', 'de Cervantes Saavedra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Novela'),
(2, 'Terror'),
(3, 'Historico'),
(4, 'Drama'),
(10, 'Filosofía Clásica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `portada` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `titulo`, `autor_id`, `descripcion`, `categoria_id`, `portada`) VALUES
(1, 'Carrie', 1, 'Carrie White, una tímida adolescente críada por una fanática religosa es humillada constantemente por su compañeros de instituto. Sin embargo, Carrie no es una chica cualquiera, la joven posee poderes psíquicos que se manifiestan cuando se siente dominada por la ira. El día del baile de graduación la situación llega a hacérsele insoportable.', 2, '6524d7c2b56245.33773446.jpeg'),
(2, 'Las aventuras de Alicia en el país de las maravillas', 3, 'La historia cuenta cómo una niña llamada Alicia cae por un agujero, encontrándose en un mundo peculiar y extraño, poblado por humanos y criaturas antropomórficas. El libro juega con la lógica, dando a la novela gran popularidad tanto en niños como en adultos.', 1, '6524d7d3e15f11.29693358.jpeg'),
(3, 'Los mitos de Cthulhu', 4, 'Los Mitos de Cthulhu, ciclo de narraciones de horror cósmico, a medio camino entre lo mítico, lo literario y lo religioso, la imaginería desatada y desasosegante de Lovecraft son pródigos en criaturas primigenias que aguardan el momento propicio para darse a conocer.', 2, '652553396a6907.13151360.jpeg'),
(4, 'El resplandor', 1, 'Jack Torrance acepta una oferta de trabajo en un hotel de montaña que se encuentra a 65 kilómetros del pueblo más cercano. Además, las carreteras se encuentran cerradas al tráfico por las fuertes nevadas del invierno. Pronto comenzarán a manifestarse espíritus y apariciones extrañas.', 2, '6525535bd2de08.63940060.jpg'),
(5, 'La Divina Comedia', 5, 'La Divina Comedia sigue el camino desde el centro de la Tierra, donde se halla Lucifer, hasta el dominio de Dios. El tema de la obra es el recorrido del poeta a través del más allá. En su obra se encuentra gran capacidad para describir el infierno, los círculos, los sufrimientos y los pecadores.', 3, '652553b85e8444.53195231.jpeg'),
(6, 'Ilíada', 2, 'La Ilíada es un poema épico en veinticuatro cantos, que tiene como argumento un episodio del último año de la guerra de Troya: la cólera de Aquiles, el más célebre y valiente soldado griego, contra Agamenón, su comandante, quien le ha robado su esclava Briseida.', 3, '65282d87f119a8.08713919.jpeg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `autor`
--
ALTER TABLE `autor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
