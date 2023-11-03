-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2023 a las 02:41:47
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
(1, 'Jane ', 'Austen'),
(2, 'Stephen', 'King'),
(3, 'Julio', 'Verne'),
(4, 'Edgar Allan ', 'Poe'),
(5, 'Charles', 'Dickens'),
(6, 'Nicholas', 'Sparks'),
(7, 'Emily', 'Brontë'),
(8, 'Robert Louis ', 'Stevenson'),
(9, 'Friedrich ', 'Nietzsche'),
(10, 'Jean-Paul', 'Sartre'),
(11, 'Isaac', 'Asimov'),
(12, 'Philip K. ', 'Dick');

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
(1, 'Terror'),
(2, 'Literatura Clásica'),
(3, 'Romance'),
(4, 'Aventuras'),
(5, 'Filosofía'),
(6, 'Ciencia Ficción');

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
  `precio` decimal(10,2) NOT NULL,
  `fecha_publicacion` int(4) DEFAULT NULL,
  `portada` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `titulo`, `autor_id`, `descripcion`, `categoria_id`, `precio`, `fecha_publicacion`, `portada`) VALUES
(1, 'El resplandor', 2, 'Jack Torrance acepta una oferta de trabajo en un hotel de montaña que se encuentra a 65 kilómetros del pueblo más cercano. Además, las carreteras se encuentran cerradas al tráfico por las fuertes nevadas del invierno. Pronto comenzarán a manifestarse espíritus y apariciones extrañas.', 1, 11800.00, 1977, '65444a495bc878.82585624.jpg'),
(2, 'Los crímenes de la calle Morgue', 4, 'El asesinato de una madre y su hija ha sacudido a la sociedad parisina decimonónica debido a la crueldad con que fue cometido el crimen, pero sobre todo porque la policía ha sido incapaz de encontrar al asesino a pesar de haber entrevistado a numerosos testigos.', 1, 3500.00, 1841, '65444a98d7f895.35145619.jpg'),
(3, 'Orgullo y prejuicio', 1, 'La señora Bennet ha criado a sus cinco hijas con el único deseo de encontrar marido. La llegada al vecindario de Charles Bingley, un joven rico y soltero, con algunas amistades despierta el interés de las hermanas Bennet y de las familias vecinas, que verán una excelente oportunidad para cumplir su propósito. Elizabeth, una de las hijas de los Bennet, empezará una singular relación con Darcy, uno de los amigos de Bingley, que desencadenará esta historia de orgullo y prejuicios entre los dos hasta llegar a conocer el verdadero amor. ', 2, 3990.00, 1813, '65444b04e4ebf0.49927583.jpg'),
(4, 'Grandes esperanzas', 5, 'Grandes esperanzas es uno de los títulos más célebres del gran autor inglés. Publicado originalmente en 1860, narra la historia de Pip, un joven huérfano y miedoso, cuyo humilde destino se ve agraciado por un benefactor inesperado que cambiará el sino de su vida y hará de él un caballero.', 2, 19850.00, 1861, '65444b5383a907.64046520.jpg'),
(5, 'Diario de una pasión', 6, 'En un hogar de retiro un hombre le lee a una mujer, que sufre de Alzheimer, la historia de dos jóvenes de distintas clases sociales que se enamoraron durante la convulsionada década del 40, y de cómo fueron separados por terceros, y por la guerra.', 3, 9750.00, 1996, '65444bafaea094.24604009.jpg'),
(6, 'Cumbres Borrascosas', 7, 'Cumbres borrascosas, una de las novelas inglesas más relevantes del siglo XIX, narra la épica historia de Catherine y Heathcliff. Situada en los sombríos y desolados páramos de Yorkshire, constituye una asombrosa visión metafísica del destino, la obsesión, la pasión y la venganza.', 3, 10250.00, 1847, '65444bfc6a1c34.68022945.jpg'),
(7, 'Veinte mil leguas de viaje submarino', 3, 'El profesor Pierre Aronnax, gran conocedor de la biología marina, su fiel criado Conseil, y un habilidoso arponero son secuestrados por la tripulación del submarino Nautilus: una de las máquinas más formidables que jamás haya concebido el hombre.', 4, 3650.00, 1870, '65444c575066b3.31244572.jpg'),
(8, 'La isla del tesoro', 8, 'La llegada de un misterioso marino a la posada de su padre cambiará la vida del joven Jim Hawkins. El viejo confraternizará con él y, al morir repentinamente en la posada, Jim hallará entre sus cosas un mapa que revela la situación de un tesoro pirata enterrado en una isla remota.', 4, 8200.00, 1883, '65444cb10fd637.20671841.jpg'),
(9, 'Así habló Zaratustra', 9, 'Zaratustra es un ermitaño que, tras muchos años de soledad y reflexión en solitario, abandona la montaña en la que vive para compartir con su sabiduría con la gente. En su camino, se topa con un sabio que encontró la felicidad con Dios en la soledad del bosque.', 5, 3200.00, 1883, '65444d02c511d2.36548767.jpg'),
(10, 'El ser y la nada', 10, 'El ser y la nada (en francés, L´être et le néant) es la primera obra filosófica de Jean-Paul Sartre (1905-1980), filósofo y principal exponente del existencialismo francés. Fue publicada en 1943. Representa la culminación de la primera filosofía egocéntrica de Sartre, iniciada por la Trascendencia del Ego.', 5, 12600.00, 1943, '65444d5a254b80.44047704.jpg'),
(11, 'El fin de la eternidad', 11, 'En el siglo XXVII, la Tierra funda una organización llamada Eternidad, enviando sus emisarios al pasado y al futuro para abrir el comercio entre las diferentes epocas, y para alterar la larga y a veces trágica historia de la raza humana.', 6, 13330.00, 1955, '65444da235d0e1.72555941.jpg'),
(12, '¿Sueñan los androides con ovejas eléctricas?', 11, 'La novela combina la historia de Rick Deckard, un cazador de androides de última generación huidos de una colonia que se hacen pasar por humanos y la de J.R. Isidore, quien no cumple los requisitos para huir a Marte y sobrevive en la Tierra como conductor de una empresa de reparación de animales eléctricos.', 6, 8743.00, 1968, '65444de6be7ee3.99334002.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(255) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `telefono` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `correo_electronico`, `contrasena`, `fecha_nacimiento`, `telefono`) VALUES
(1, 'cristian', 'cristian94@gmail.com', '$2y$10$hmUYYltsumLzFYuQ07uGnOH3J/WU.xr07qQbJyBDbRp1BrAOh9Yga', '1994-01-07', '1234567890'),
(2, 'dante', 'danteespinoza@gmail.com', '$2y$10$pFrRWPOsS8/Ku45YdBiDjeyMaFwXFm3WUPWd2nWRChWlmj.SagKsW', '1998-05-05', '1234567890'),
(3, 'santinolaferrara', 'santinolaferrara@gmail.com', '$2y$10$IR2IziYP/P/YRdEyOtTgLuHUHC/y802JR0.Eq3/cHdIph7zxjTQiG', '2000-08-15', '1234567890'),
(4, 'guadalupenavarro', 'guadalupe@gmail.com', '$2y$10$xmrK99jHI7yWeNixRmusqeJAEfVHDwHaFoJIWb.t4vQZrp7wbys56', '2000-08-04', '1234567890'),
(5, 'francoromero', 'francoromero@gmail.com', '$2y$10$.mUHCI0PeWgitZpImV4g0upRizdpCw2lBuw2OdNLrBhCpNNz0G22G', '1998-09-02', '1234567890'),
(6, 'marinadorina', 'marinadorina@gmail.com', '$2y$10$yER5Kvw9oDhUJ0BZ0Bbu1Ok3zSU1OFmq/bIwjiCTDkD8gUNsSrjpW', '1998-04-05', '1234567890');

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
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT de la tabla `autor`
--
ALTER TABLE `autor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
