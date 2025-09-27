-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 21, 2024 at 04:30 AM
-- Server version: 8.0.39
-- PHP Version: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumnos`
--

CREATE TABLE `alumnos` (
  `id_alumno` int NOT NULL,
  `login_id` int NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lugar_nacimiento` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `codigo_estudiante` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `id_grado` int NOT NULL,
  `fecha_inscripcion` date NOT NULL,
  `padecimiento_alergia` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nombre_padre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre_madre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `cedula_padre` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `cedula_madre` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono_emergencia` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `ocupacion_padre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `ocupacion_madre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `direccion_exacta` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumnos`
--

INSERT INTO `alumnos` (`id_alumno`, `login_id`, `nombre`, `apellidos`, `lugar_nacimiento`, `fecha_nacimiento`, `codigo_estudiante`, `id_grado`, `fecha_inscripcion`, `padecimiento_alergia`, `nombre_padre`, `nombre_madre`, `cedula_padre`, `cedula_madre`, `telefono_emergencia`, `ocupacion_padre`, `ocupacion_madre`, `direccion_exacta`) VALUES
(22, 5, 'Jaime', 'Suarez', 'Hospital', '2005-02-19', '0011101105', 8, '2023-05-17', 'alergia', 'Santos Rivera', 'JUANA MENDOZA', '001-040590-0000J', '0010405900000K', '5551236', 'comerciante', 'ama de casa', 'Contiguo a la coop. 104');

-- --------------------------------------------------------

--
-- Table structure for table `asignaturas`
--

CREATE TABLE `asignaturas` (
  `id_asignatura` int NOT NULL,
  `nombre_asignatura` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_grado` int NOT NULL,
  `ruta_imagen` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '../../img/Asignatura/predeterminada.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asignaturas`
--

INSERT INTO `asignaturas` (`id_asignatura`, `nombre_asignatura`, `id_grado`, `ruta_imagen`) VALUES
(1, 'Lengua Y literatura', 8, '../../img/Asignatura/asignatura_676606b7c86c31.72098231.jpeg'),
(4, 'Matematica', 8, '../../img/Asignatura/asignatura_676606bf0cb7a7.76592818.jpg'),
(6, 'Ciencias Naturales', 8, '../../img/Asignatura/asignatura_676606c5800194.74857151.png'),
(8, 'T.I.C', 10, '../../img/Asignatura/predeterminada.png'),
(9, 'T.I.C', 8, '../../img/Asignatura/asignatura_676606d31b49b9.64252474.jpeg'),
(10, 'Lengua y literatura', 13, '../../img/Asignatura/predeterminada.png'),
(11, 'Lengua Y literatura', 6, '../../img/Asignatura/predeterminada.png');

-- --------------------------------------------------------

--
-- Table structure for table `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id_calificacion` int NOT NULL,
  `id_alumno` int NOT NULL,
  `id_grado` int NOT NULL,
  `id_asignatura` int NOT NULL,
  `semestre1` float DEFAULT NULL,
  `semestre2` float DEFAULT NULL,
  `semestre3` float DEFAULT NULL,
  `semestre4` float DEFAULT NULL,
  `promedio_final` float GENERATED ALWAYS AS (((((`semestre1` + `semestre2`) + `semestre3`) + `semestre4`) / 4)) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calificaciones`
--

INSERT INTO `calificaciones` (`id_calificacion`, `id_alumno`, `id_grado`, `id_asignatura`, `semestre1`, `semestre2`, `semestre3`, `semestre4`) VALUES
(63, 22, 8, 1, 95, 90, 85, 82),
(65, 22, 8, 4, 85, 92, 80, 90),
(67, 22, 8, 6, 90, 80, 80, 90),
(68, 22, 8, 9, 80, 60, 70, 80);

-- --------------------------------------------------------

--
-- Table structure for table `grados`
--

CREATE TABLE `grados` (
  `id_grado` int NOT NULL,
  `nombre_grado` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grados`
--

INSERT INTO `grados` (`id_grado`, `nombre_grado`) VALUES
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
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('administrador','secretaria','alumno','profesor') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password_hash`, `role`) VALUES
(1, 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', 'administrador'),
(2, 'secretaria', '1c392f167af58d8184653ba5f241d00f8e847e3e83211a04be121339ee2744e9', 'secretaria'),
(3, 'estudiante', '29500c9eac355cca3d3d0e75e86ce585cb8f670d10516c168050c8ead6250c70', 'alumno'),
(4, 'profesor', '25da2ece06d8767eccaff139d4ba7490dd1b9aeeb51f413de23bce797cc47e68', 'profesor'),
(5, 'Jaime.suarez', '8d82f3cfbac62255ca057baa6d8cb94e293a41c542a135756217b6e223682fbb', 'alumno'),
(8, 'demo_profe', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', 'profesor'),
(13, 'xd1902', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'alumno');

-- --------------------------------------------------------

--
-- Table structure for table `mensualidades`
--

CREATE TABLE `mensualidades` (
  `id_mensualidad` int NOT NULL,
  `id_alumno` int NOT NULL,
  `fecha_pago` date NOT NULL,
  `monto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mensualidades`
--

INSERT INTO `mensualidades` (`id_mensualidad`, `id_alumno`, `fecha_pago`, `monto`) VALUES
(27, 22, '2024-12-20', 450);

-- --------------------------------------------------------

--
-- Table structure for table `profesores`
--

CREATE TABLE `profesores` (
  `id_profesor` int NOT NULL,
  `login_id` int NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `correo_electronico` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `certificaciones` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `carrera_universitaria` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profesores`
--

INSERT INTO `profesores` (`id_profesor`, `login_id`, `nombre`, `apellido`, `correo_electronico`, `telefono`, `direccion`, `certificaciones`, `carrera_universitaria`) VALUES
(10, 8, 'demo', 'Costa', 'Arielcosta@gmail.com', '547821', 'Calle los alpes 210', 'si tiene', 'Ingeniero');

-- --------------------------------------------------------

--
-- Table structure for table `profesores_asignaturas`
--

CREATE TABLE `profesores_asignaturas` (
  `id_profesor` int NOT NULL,
  `id_asignatura` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profesores_asignaturas`
--

INSERT INTO `profesores_asignaturas` (`id_profesor`, `id_asignatura`) VALUES
(10, 1),
(10, 4),
(10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `profesores_grados`
--

CREATE TABLE `profesores_grados` (
  `id_profesor` int NOT NULL,
  `id_grado` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profesores_grados`
--

INSERT INTO `profesores_grados` (`id_profesor`, `id_grado`) VALUES
(10, 8),
(10, 9),
(10, 10),
(10, 11),
(10, 12),
(10, 13);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id_alumno`),
  ADD KEY `id_grado` (`id_grado`),
  ADD KEY `login_id` (`login_id`);

--
-- Indexes for table `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD PRIMARY KEY (`id_asignatura`),
  ADD KEY `id_grado` (`id_grado`);

--
-- Indexes for table `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id_calificacion`),
  ADD KEY `id_alumno` (`id_alumno`),
  ADD KEY `id_asignatura` (`id_asignatura`),
  ADD KEY `id_grado` (`id_grado`);

--
-- Indexes for table `grados`
--
ALTER TABLE `grados`
  ADD PRIMARY KEY (`id_grado`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mensualidades`
--
ALTER TABLE `mensualidades`
  ADD PRIMARY KEY (`id_mensualidad`),
  ADD KEY `id_alumno` (`id_alumno`);

--
-- Indexes for table `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id_profesor`),
  ADD KEY `login_id` (`login_id`);

--
-- Indexes for table `profesores_asignaturas`
--
ALTER TABLE `profesores_asignaturas`
  ADD PRIMARY KEY (`id_profesor`,`id_asignatura`),
  ADD KEY `id_asignatura` (`id_asignatura`);

--
-- Indexes for table `profesores_grados`
--
ALTER TABLE `profesores_grados`
  ADD PRIMARY KEY (`id_profesor`,`id_grado`),
  ADD KEY `id_grado` (`id_grado`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id_alumno` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `asignaturas`
--
ALTER TABLE `asignaturas`
  MODIFY `id_asignatura` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id_calificacion` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `grados`
--
ALTER TABLE `grados`
  MODIFY `id_grado` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mensualidades`
--
ALTER TABLE `mensualidades`
  MODIFY `id_mensualidad` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id_profesor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumnos`
--
ALTER TABLE `alumnos`
  ADD CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`id_grado`) REFERENCES `grados` (`id_grado`),
  ADD CONSTRAINT `alumnos_ibfk_2` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `alumnos_ibfk_3` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`);

--
-- Constraints for table `asignaturas`
--
ALTER TABLE `asignaturas`
  ADD CONSTRAINT `asignaturas_ibfk_1` FOREIGN KEY (`id_grado`) REFERENCES `grados` (`id_grado`);

--
-- Constraints for table `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`),
  ADD CONSTRAINT `calificaciones_ibfk_3` FOREIGN KEY (`id_grado`) REFERENCES `grados` (`id_grado`),
  ADD CONSTRAINT `fk_asignatura` FOREIGN KEY (`id_asignatura`) REFERENCES `asignaturas` (`id_asignatura`) ON DELETE CASCADE;

--
-- Constraints for table `mensualidades`
--
ALTER TABLE `mensualidades`
  ADD CONSTRAINT `mensualidades_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`);

--
-- Constraints for table `profesores`
--
ALTER TABLE `profesores`
  ADD CONSTRAINT `profesores_ibfk_1` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `profesores_ibfk_2` FOREIGN KEY (`login_id`) REFERENCES `login` (`id`);

--
-- Constraints for table `profesores_asignaturas`
--
ALTER TABLE `profesores_asignaturas`
  ADD CONSTRAINT `profesores_asignaturas_ibfk_1` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`),
  ADD CONSTRAINT `profesores_asignaturas_ibfk_2` FOREIGN KEY (`id_asignatura`) REFERENCES `asignaturas` (`id_asignatura`);

--
-- Constraints for table `profesores_grados`
--
ALTER TABLE `profesores_grados`
  ADD CONSTRAINT `profesores_grados_ibfk_1` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`),
  ADD CONSTRAINT `profesores_grados_ibfk_2` FOREIGN KEY (`id_grado`) REFERENCES `grados` (`id_grado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
