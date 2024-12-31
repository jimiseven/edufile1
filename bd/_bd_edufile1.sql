-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-12-2024 a las 13:24:25
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
-- Base de datos: `	bd_edufile1`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` bigint(20) NOT NULL,
  `nivel_id` bigint(20) NOT NULL,
  `paralelo_id` bigint(20) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos_materias`
--

CREATE TABLE `cursos_materias` (
  `id` bigint(20) NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `materia_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos_profesores_materias`
--

CREATE TABLE `cursos_profesores_materias` (
  `id` bigint(20) NOT NULL,
  `curso_id` bigint(20) NOT NULL,
  `profesor_id` bigint(20) NOT NULL,
  `materia_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` bigint(20) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `apellido_paterno` varchar(255) NOT NULL,
  `apellido_materno` varchar(255) NOT NULL,
  `carnet_identidad` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `sexo` varchar(10) NOT NULL,
  `rude` varchar(255) NOT NULL,
  `curso_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes_responsables`
--

CREATE TABLE `estudiantes_responsables` (
  `id` bigint(20) NOT NULL,
  `estudiante_id` bigint(20) NOT NULL,
  `responsable_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles_educativos`
--

CREATE TABLE `niveles_educativos` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE `notas` (
  `id` bigint(20) NOT NULL,
  `estudiante_id` bigint(20) NOT NULL,
  `materia_id` bigint(20) NOT NULL,
  `trimestre` int(11) NOT NULL CHECK (`trimestre` in (1,2,3)),
  `nota` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paralelos`
--

CREATE TABLE `paralelos` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `carnet_identidad` varchar(255) NOT NULL,
  `numero_celular` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores_materias`
--

CREATE TABLE `profesores_materias` (
  `id` bigint(20) NOT NULL,
  `profesor_id` bigint(20) NOT NULL,
  `materia_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsables`
--

CREATE TABLE `responsables` (
  `id` bigint(20) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `parentesco` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nivel_id` (`nivel_id`),
  ADD KEY `paralelo_id` (`paralelo_id`);

--
-- Indices de la tabla `cursos_materias`
--
ALTER TABLE `cursos_materias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Indices de la tabla `cursos_profesores_materias`
--
ALTER TABLE `cursos_profesores_materias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`),
  ADD KEY `profesor_id` (`profesor_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rude` (`rude`),
  ADD KEY `curso_id` (`curso_id`);

--
-- Indices de la tabla `estudiantes_responsables`
--
ALTER TABLE `estudiantes_responsables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiante_id` (`estudiante_id`),
  ADD KEY `responsable_id` (`responsable_id`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `niveles_educativos`
--
ALTER TABLE `niveles_educativos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiante_id` (`estudiante_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Indices de la tabla `paralelos`
--
ALTER TABLE `paralelos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesores_materias`
--
ALTER TABLE `profesores_materias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor_id` (`profesor_id`),
  ADD KEY `materia_id` (`materia_id`);

--
-- Indices de la tabla `responsables`
--
ALTER TABLE `responsables`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos_materias`
--
ALTER TABLE `cursos_materias`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos_profesores_materias`
--
ALTER TABLE `cursos_profesores_materias`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estudiantes_responsables`
--
ALTER TABLE `estudiantes_responsables`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `niveles_educativos`
--
ALTER TABLE `niveles_educativos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notas`
--
ALTER TABLE `notas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paralelos`
--
ALTER TABLE `paralelos`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `profesores_materias`
--
ALTER TABLE `profesores_materias`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `responsables`
--
ALTER TABLE `responsables`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`nivel_id`) REFERENCES `niveles_educativos` (`id`),
  ADD CONSTRAINT `cursos_ibfk_2` FOREIGN KEY (`paralelo_id`) REFERENCES `paralelos` (`id`);

--
-- Filtros para la tabla `cursos_materias`
--
ALTER TABLE `cursos_materias`
  ADD CONSTRAINT `cursos_materias_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`),
  ADD CONSTRAINT `cursos_materias_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `cursos_profesores_materias`
--
ALTER TABLE `cursos_profesores_materias`
  ADD CONSTRAINT `cursos_profesores_materias_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`),
  ADD CONSTRAINT `cursos_profesores_materias_ibfk_2` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`),
  ADD CONSTRAINT `cursos_profesores_materias_ibfk_3` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`);

--
-- Filtros para la tabla `estudiantes_responsables`
--
ALTER TABLE `estudiantes_responsables`
  ADD CONSTRAINT `estudiantes_responsables_ibfk_1` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`),
  ADD CONSTRAINT `estudiantes_responsables_ibfk_2` FOREIGN KEY (`responsable_id`) REFERENCES `responsables` (`id`);

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`),
  ADD CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

--
-- Filtros para la tabla `profesores_materias`
--
ALTER TABLE `profesores_materias`
  ADD CONSTRAINT `profesores_materias_ibfk_1` FOREIGN KEY (`profesor_id`) REFERENCES `profesores` (`id`),
  ADD CONSTRAINT `profesores_materias_ibfk_2` FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
