-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-10-2023 a las 17:18:01
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
(1, 'Antoine ', 'de Saint-Exupéry'),
(2, 'René ', 'Descartes'),
(3, 'Charles ', 'Bukowski'),
(4, 'Stephen', 'King'),
(5, 'Dante', 'Alighieri'),
(6, 'Howard Phillips', 'Lovecraft'),
(7, 'Julio', 'Cortázar'),
(8, 'Homero', ''),
(9, 'Frank', 'Herbert'),
(10, 'Anthony ', 'Burgess');

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
(2, 'Filosofía'),
(3, 'Novela'),
(4, 'Ciencia Ficción'),
(5, 'Literatura Clásica');

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
(1, 'El Principito', 1, 'Fábula mítica y relato filosófico que interroga acerca de la relación del ser humano con su prójimo y con el mundo, El Principito concentra, con maravillosa simplicidad, la constante reflexión de Saint-Exupery sobre la amistad, el amor, la responsabilidad y el sentido de la vida.', 3, 2500.00, 1943, '652fec71a19c30.00889474.jpg'),
(2, 'Cartero', 3, 'En \"Cartero\" describe los doce años en que estuvo empleado en una sórdida oficina de correos de Los Ángeles. El libro termina cuando Chinaski/Bukowski abandona la miserable seguridad de su empleo, a los 49 años, para dedicarse exclusivamente a escribir. Y escribe \"Cartero\", su primera novela.', 3, 4550.00, 1979, '652fecfccf75f6.98120550.jpeg'),
(3, 'Dune', 9, 'Arrakis, también denominado \"Dune\", se ha convertido en el planeta más importante del universo. A su alrededor comienza una gigantesca lucha por el poder que culmina en una guerra interestelar.', 4, 7550.00, 1965, '652fed6dc96291.85671323.jpg'),
(4, 'Carrie', 4, 'Carrie White, una tímida adolescente críada por una fanática religosa es humillada constantemente por su compañeros de instituto. Sin embargo, Carrie no es una chica cualquiera, la joven posee poderes psíquicos que se manifiestan cuando se siente dominada por la ira. El día del baile de graduación la situación llega a hacérsele insoportable.', 1, 4000.50, 1974, '652fee1c094cf3.82095001.jpg'),
(5, 'El Extraño', 6, 'El extraño, como muchas de las obras de H.P. Lovecraft, está escrito en primera persona y detalla la vida miserable y aparentemente solitaria de un individuo que parece no haber tenido contacto con nadie durante muchos años.', 6, 1550.00, 1926, '652fefa13351b8.40353199.jpg'),
(6, 'Rayuela', 7, 'El amor turbulento de Oliveira y La Maga, los amigos del Club de la Serpiente, las caminatas por Paría en busca del cielo y el infierno tienen su reverso en la aventura simétrica de Oliveira, Talira y Traveler en un Buenos Aires teñido por el recuerdo.', 3, 9550.60, 1963, '652ff0513de259.26195816.jpg'),
(7, 'Ilíada', 11, 'La Ilíada es un poema épico en veinticuatro cantos, que tiene como argumento un episodio del último año de la guerra de Troya: la cólera de Aquiles, el más célebre y valiente soldado griego, contra Agamenón, su comandante, quien le ha robado su esclava Briseida.', 8, 5500.20, 0, '652ff0a13ff6d5.37600038.jpeg'),
(8, 'La Divina Comedia', 5, 'La Divina Comedia sigue el camino desde el centro de la Tierra, donde se halla Lucifer, hasta el dominio de Dios. El tema de la obra es el recorrido del poeta a través del más allá. En su obra se encuentra gran capacidad para describir el infierno, los círculos, los sufrimientos y los pecadores.', 8, 7550.65, 1472, '652ff1906c6d09.99640103.jpg'),
(9, 'La Naranja Mécanica', 10, 'Alex es un joven muy agresivo que tiene dos pasiones: la violencia desaforada y Beethoven. Es el jefe de la banda de los drugos, que dan rienda suelta a sus instintos más salvajes aterrorizando a la población.', 3, 3550.00, 1962, '652ff256beec92.99290742.jpg'),
(10, 'El Discurso del Método', 2, 'Esta obra marca el inicio de la filosofía moderna. Descartes cuestiona aquí que cualquier tipo de conocimiento pueda basarse en algo tan engañoso como los sentidos. Para buscar la verdad tenemos que poner en duda lo que sabemos.', 2, 3365.00, 1637, '652ff511cb9690.30404228.jpg');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
