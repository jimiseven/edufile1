-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-01-2025 a las 16:28:45
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_edufile3`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) NOT NULL,
  `level_id` bigint(20) DEFAULT NULL,
  `grade` int(11) NOT NULL,
  `parallel` enum('A','B','C') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `courses`
--

INSERT INTO `courses` (`id`, `level_id`, `grade`, `parallel`) VALUES
(1, 1, 1, 'A'),
(2, 1, 1, 'B'),
(3, 1, 1, 'C'),
(4, 1, 2, 'A'),
(5, 1, 2, 'B'),
(6, 1, 2, 'C'),
(7, 2, 1, 'A'),
(8, 2, 1, 'B'),
(9, 2, 1, 'C'),
(10, 2, 2, 'A'),
(11, 2, 2, 'B'),
(12, 2, 2, 'C'),
(13, 2, 3, 'A'),
(14, 2, 3, 'B'),
(15, 2, 3, 'C'),
(16, 2, 4, 'A'),
(17, 2, 4, 'B'),
(18, 2, 4, 'C'),
(19, 2, 5, 'A'),
(20, 2, 5, 'B'),
(21, 2, 5, 'C'),
(22, 2, 6, 'A'),
(23, 2, 6, 'B'),
(24, 2, 6, 'C'),
(25, 3, 1, 'A'),
(26, 3, 1, 'B'),
(27, 3, 1, 'C'),
(28, 3, 2, 'A'),
(29, 3, 2, 'B'),
(30, 3, 2, 'C'),
(31, 3, 3, 'A'),
(32, 3, 3, 'B'),
(33, 3, 3, 'C'),
(34, 3, 4, 'A'),
(35, 3, 4, 'B'),
(36, 3, 4, 'C'),
(37, 3, 5, 'A'),
(38, 3, 5, 'B'),
(39, 3, 5, 'C'),
(40, 3, 6, 'A'),
(41, 3, 6, 'B'),
(42, 3, 6, 'C');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `levels`
--

CREATE TABLE `levels` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `levels`
--

INSERT INTO `levels` (`id`, `name`) VALUES
(1, 'Inicial'),
(2, 'Primario'),
(3, 'Secundario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students`
--

CREATE TABLE `students` (
  `id` bigint(20) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name_father` varchar(255) NOT NULL,
  `last_name_mother` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `rude_number` varchar(20) NOT NULL,
  `identity_card` varchar(9) NOT NULL,
  `birth_date` date NOT NULL,
  `guardian_first_name` varchar(255) DEFAULT NULL,
  `guardian_last_name` varchar(255) DEFAULT NULL,
  `guardian_identity_card` varchar(9) DEFAULT NULL,
  `guardian_phone_number` varchar(15) DEFAULT NULL,
  `guardian_relationship` enum('padre','madre','tutor') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `students`
--

INSERT INTO `students` (`id`, `first_name`, `last_name_father`, `last_name_mother`, `gender`, `rude_number`, `identity_card`, `birth_date`, `guardian_first_name`, `guardian_last_name`, `guardian_identity_card`, `guardian_phone_number`, `guardian_relationship`) VALUES
(1, 'Nombre141', 'ApellidoP439', 'ApellidoM772', 'Masculino', '8089001520155531J', '52189064', '2024-11-29', NULL, NULL, NULL, NULL, NULL),
(2, 'Nombre206', 'ApellidoP992', 'ApellidoM344', 'Masculino', '8089001520155811E', '52189239', '2020-04-11', NULL, NULL, NULL, NULL, NULL),
(3, 'Nombre2', 'ApellidoP579', 'ApellidoM889', 'Masculino', '8089001520156017H', '52189249', '2023-07-23', NULL, NULL, NULL, NULL, NULL),
(4, 'Nombre331', 'ApellidoP209', 'ApellidoM52', 'Masculino', '8089001520155152E', '52189344', '2015-10-10', NULL, NULL, NULL, NULL, NULL),
(5, 'Nombre939', 'ApellidoP912', 'ApellidoM742', 'Masculino', '8089001520155792J', '52189288', '2023-10-14', NULL, NULL, NULL, NULL, NULL),
(6, 'Nombre101', 'ApellidoP128', 'ApellidoM337', 'Femenino', '8089001520155626O', '52188793', '2024-07-31', NULL, NULL, NULL, NULL, NULL),
(7, 'Nombre188', 'ApellidoP798', 'ApellidoM429', 'Masculino', '8089001520155610D', '52188645', '2018-10-07', NULL, NULL, NULL, NULL, NULL),
(8, 'Nombre539', 'ApellidoP809', 'ApellidoM430', 'Masculino', '8089001520155457L', '52188743', '2023-09-26', NULL, NULL, NULL, NULL, NULL),
(9, 'Nombre760', 'ApellidoP408', 'ApellidoM761', 'Masculino', '8089001520155762K', '52188542', '2022-01-14', NULL, NULL, NULL, NULL, NULL),
(10, 'Nombre210', 'ApellidoP150', 'ApellidoM120', 'Femenino', '8089001520155517M', '52188669', '2018-01-22', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `student_courses`
--

CREATE TABLE `student_courses` (
  `student_id` bigint(20) NOT NULL,
  `course_id` bigint(20) NOT NULL,
  `status` enum('Efectivo - I','Efectivo - T','Traslado','Retirado','No inscrito') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `student_courses`
--

INSERT INTO `student_courses` (`student_id`, `course_id`, `status`) VALUES
(1, 1, 'Efectivo - I'),
(2, 1, 'Efectivo - I'),
(3, 1, 'Efectivo - I'),
(4, 1, 'Efectivo - I'),
(5, 1, 'Efectivo - I'),
(6, 1, 'Efectivo - I'),
(7, 1, 'Efectivo - I'),
(8, 1, 'Efectivo - I'),
(9, 1, 'Efectivo - I'),
(10, 1, 'Efectivo - I');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `level_id` (`level_id`);

--
-- Indices de la tabla `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `student_courses`
--
ALTER TABLE `student_courses`
  ADD PRIMARY KEY (`student_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `levels`
--
ALTER TABLE `levels`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`);

--
-- Filtros para la tabla `student_courses`
--
ALTER TABLE `student_courses`
  ADD CONSTRAINT `student_courses_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `student_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
