-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-05-2023 a las 23:45:39
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
-- Base de datos: `project_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id_alumno` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `lugar_nacimiento` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `codigo_estudiante` varchar(20) NOT NULL,
  `id_grado` int(11) NOT NULL,
  `fecha_inscripcion` date NOT NULL,
  `padecimiento_alergia` varchar(100) DEFAULT NULL,
  `nombre_padre` varchar(50) NOT NULL,
  `nombre_madre` varchar(50) NOT NULL,
  `cedula_padre` varchar(20) NOT NULL,
  `cedula_madre` varchar(20) NOT NULL,
  `telefono_emergencia` varchar(20) NOT NULL,
  `ocupacion_padre` varchar(50) NOT NULL,
  `ocupacion_madre` varchar(50) NOT NULL,
  `direccion_exacta` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id_alumno`, `login_id`, `nombre`, `apellidos`, `lugar_nacimiento`, `fecha_nacimiento`, `codigo_estudiante`, `id_grado`, `fecha_inscripcion`, `padecimiento_alergia`, `nombre_padre`, `nombre_madre`, `cedula_padre`, `cedula_madre`, `telefono_emergencia`, `ocupacion_padre`, `ocupacion_madre`, `direccion_exacta`) VALUES
(22, 5, 'Jaime', 'Suarez', 'Hospital', '2005-02-19', '0011101105', 8, '2023-05-17', 'alergia', 'Santos Rivera', 'JUANA MENDOZA', '001-040590-0000J', '0010405900000K', '5551236', 'comerciante', 'ama de casa', 'Contiguo a la coop. 104'),
(23, 6, 'Ariel', 'Urroz', 'managua', '2002-02-19', '0001552520541', 8, '2023-05-17', 'null', 'Santos Rivera', 'JUANA MENDOZA', '001-040590-0000J', '0010405900000K', '5551235', 'nose jajaj', 'ama de casa', 'Contiguo a la coop. 104');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaturas`
--

CREATE TABLE `asignaturas` (
  `id_asignatura` int(11) NOT NULL,
  `nombre_asignatura` varchar(50) NOT NULL,
  `id_grado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asignaturas`
--

INSERT INTO `asignaturas` (`id_asignatura`, `nombre_asignatura`, `id_grado`) VALUES
(1, 'Lengua Y literatura', 8),
(4, 'Matematica', 8),
(6, 'Ciencias Naturales', 8),
(8, 'T.I.C', 10),
(9, 'T.I.C', 8),
(10, 'Lengua y literatura', 13),
(11, 'Lengua Y literatura', 6),
(12, 'Lengua Y literatura', 5),
(13, 'Matematica', 5),
(14, 'Matematica', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id_calificacion` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_grado` int(11) NOT NULL,
  `id_asignatura` int(11) NOT NULL,
  `semestre1` float DEFAULT NULL,
  `semestre2` float DEFAULT NULL,
  `semestre3` float DEFAULT NULL,
  `semestre4` float DEFAULT NULL,
  `promedio_final` float GENERATED ALWAYS AS ((`semestre1` + `semestre2` + `semestre3` + `semestre4`) / 4) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificaciones`
--

INSERT INTO `calificaciones` (`id_calificacion`, `id_alumno`, `id_grado`, `id_asignatura`, `semestre1`, `semestre2`, `semestre3`, `semestre4`) VALUES
(63, 22, 8, 1, 95, 90, 85, 82),
(64, 23, 8, 1, 85, 95, 78, 90),
(65, 22, 8, 4, 87, 92, NULL, NULL),
(66, 23, 8, 4, 80, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grados`
--

CREATE TABLE `grados` (
  `id_grado` int(11) NOT NULL,
  `nombre_grado` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grados`
--

INSERT INTO `grados` (`id_grado`, `nombre_grado`) VALUES
(1, '2 Nivel'),
(2, '3 Nivel'),
(3, '1 grado'),
(4, '2 grado'),
(5, '3 grado'),
(6, '4 grado'),
(7, '5 grado'),
(8, '6 grado'),
(9, '7 grado'),
(10, '8 grado'),
(11, '9 grado'),
(12, '10 grado'),
(13, '11 grado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(64) NOT NULL,
  `role` enum('administrador','secretaria','alumno','profesor') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `login`
--

INSERT INTO `login` (`id`, `username`, `password_hash`, `role`) VALUES
(1, 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'administrador'),
(2, 'secretaria', '1c392f167af58d8184653ba5f241d00f8e847e3e83211a04be121339ee2744e9', 'secretaria'),
(3, 'estudiante', '29500c9eac355cca3d3d0e75e86ce585cb8f670d10516c168050c8ead6250c70', 'alumno'),
(4, 'profesor', '25da2ece06d8767eccaff139d4ba7490dd1b9aeeb51f413de23bce797cc47e68', 'profesor'),
(5, 'Jaime.suarez', '8d82f3cfbac62255ca057baa6d8cb94e293a41c542a135756217b6e223682fbb', 'alumno'),
(6, 'ariel.mendoza', '10800b752b5c3c0df0c573c349eea71cb1750ae291abb48f458afe4e51b0ff8c', 'alumno'),
(8, 'demo_profe', '49dac2d67d9813dedcd8cf9fe71b03f11f00b4d25cfc4f2be5d5fcbdf141b62a', 'profesor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensualidades`
--

CREATE TABLE `mensualidades` (
  `id_mensualidad` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `fecha_pago` date NOT NULL,
  `monto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id_profesor` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo_electronico` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `certificaciones` varchar(100) DEFAULT NULL,
  `carrera_universitaria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id_profesor`, `login_id`, `nombre`, `apellido`, `correo_electronico`, `telefono`, `direccion`, `certificaciones`, `carrera_universitaria`) VALUES
(10, 8, 'demo', 'Costa', 'Arielcosta@gmail.com', '547821', 'Calle los alpes 210', 'si tiene', 'Ingeniero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores_asignaturas`
--

CREATE TABLE `profesores_asignaturas` (
  `id_profesor` int(11) NOT NULL,
  `id_asignatura` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores_asignaturas`
--

INSERT INTO `profesores_asignaturas` (`id_profesor`, `id_asignatura`) VALUES
(10, 1),
(10, 4),
(10, 10),
(10, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores_grados`
--

CREATE TABLE `profesores_grados` (
  `id_profesor` int(11) NOT NULL,
  `id_grado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores_grados`
--

INSERT INTO `profesores_grados` (`id_profesor`, `id_grado`) VALUES
(10, 8),
(10, 9),
(10, 10),
(10, 11),
(10, 12),
(10, 13);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id_alumno`),
  ADD KEY `id_grado` (`id_grado`),
  ADD KEY `login_id` (`login_id`);

--
-- Indices de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`id_asignatura`),
  ADD KEY `id_grado` (`id_grado`);

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id_calificacion`),
  ADD KEY `id_alumno` (`id_alumno`),
  ADD KEY `id_asignatura` (`id_asignatura`),
  ADD KEY `id_grado` (`id_grado`);

--
-- Indices de la tabla `grados`
--
ALTER TABLE `grados`
  ADD PRIMARY KEY (`id_grado`);

--
-- Indices de la tabla `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensualidades`
--
ALTER TABLE `mensualidades`
  ADD PRIMARY KEY (`id_mensualidad`),
  ADD KEY `id_alumno` (`id_alumno`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id_profesor`),
  ADD KEY `login_id` (`login_id`);

--
-- Indices de la tabla `profesores_asignaturas`
--
ALTER TABLE `profesores_asignaturas`
  ADD PRIMARY KEY (`id_profesor`,`id_asignatura`),
  ADD KEY `id_asignatura` (`id_asignatura`);

--
-- Indices de la tabla `profesores_grados`
--
ALTER TABLE `profesores_grados`
  ADD PRIMARY KEY (`id_profesor`,`id_grado`),
  ADD KEY `id_grado` (`id_grado`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id_alumno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `id_asignatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id_calificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `grados`
--
ALTER TABLE `grados`
  MODIFY `id_grado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `mensualidades`
--
ALTER TABLE `mensualidades`
  MODIFY `id_mensualidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id_profesor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`id_grado`) REFERENCES `grados` (`id_grado`),
  ADD CONSTRAINT `alumnos_ibfk_2` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `alumnos_ibfk_3` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`);

--
-- Filtros para la tabla `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD CONSTRAINT `asignaturas_ibfk_1` FOREIGN KEY (`id_grado`) REFERENCES `grados` (`id_grado`);

--
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`),
  ADD CONSTRAINT `calificaciones_ibfk_2` FOREIGN KEY (`id_asignatura`) REFERENCES `asignaturas` (`id_asignatura`),
  ADD CONSTRAINT `calificaciones_ibfk_3` FOREIGN KEY (`id_grado`) REFERENCES `grados` (`id_grado`);

--
-- Filtros para la tabla `mensualidades`
--
ALTER TABLE `mensualidades`
  ADD CONSTRAINT `mensualidades_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`);

--
-- Filtros para la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD CONSTRAINT `profesores_ibfk_1` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `profesores_ibfk_2` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`);

--
-- Filtros para la tabla `profesores_asignaturas`
--
ALTER TABLE `profesores_asignaturas`
  ADD CONSTRAINT `profesores_asignaturas_ibfk_1` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`),
  ADD CONSTRAINT `profesores_asignaturas_ibfk_2` FOREIGN KEY (`id_asignatura`) REFERENCES `asignaturas` (`id_asignatura`);

--
-- Filtros para la tabla `profesores_grados`
--
ALTER TABLE `profesores_grados`
  ADD CONSTRAINT `profesores_grados_ibfk_1` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`),
  ADD CONSTRAINT `profesores_grados_ibfk_2` FOREIGN KEY (`id_grado`) REFERENCES `grados` (`id_grado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
