<?php
session_start();

// Verificar si el usuario ha iniciado sesión y tiene un rol válido
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'administrador')) {
  header("location: ../../index.php");
  exit;
}
// Verificar si ha pasado más de 5 minutos desde la última acción del usuario
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 120)) {
  // Destruir la sesión
  session_unset();
  session_destroy();
  header("location: ../../index.php");
  exit;
}

// Actualizar el tiempo de última actividad de la sesión
$_SESSION['last_activity'] = time();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="header">
    <h1>Colegio Cristiano Presbiteriano</h1>
  </div>
  <div id="menu">
    <a href="index.php">Inicio</a>
    <a href="A_estudiante.php">Estudiantes</a>
    <a href="#">Mensualidad</a>
    <a href="#">Profesores</a>
    <a href="#">Cursos</a>
    <a href="#">Calificaciones</a>
    <a href="close.php">Cerrar sesión</a>
  </div>
  <br><br>
  <form action="agregar_alumno.php" method="post">
  <h1>Agregar nuevo alumno</h1>
	<label for="nombre">Nombre:</label>
	<input type="text" name="nombre" required><br><br> 

	<label for="apellidos">Apellidos:</label>
	<input type="text" name="apellidos" required><br><br>

	<label for="lugar_nacimiento">Lugar de nacimiento:</label>
	<input type="text" name="lugar_nacimiento" required><br><br>

	<label for="fecha_nacimiento">Fecha de nacimiento:</label>
	<input type="date" name="fecha_nacimiento" required><br><br>

	<label for="codigo_estudiante">Código de estudiante:</label>
	<input type="text" name="codigo_estudiante" required><br><br>

	<label for="id_grado">Grado:</label>
	<select name="id_grado">
		<?php 
			// Aquí hacemos una consulta a la base de datos para obtener los grados disponibles
			// y los mostramos en un desplegable
			include '../../conexion.php';
			$sql = "SELECT * FROM grados";
			$resultado = $conexion->query($sql);
			while ($fila = $resultado->fetch_assoc()) {
				echo '<option value="'.$fila['id_grado'].'">'.$fila['nombre_grado'].'</option>';
			}
		?>
	</select><br><br>

	<label for="fecha_inscripcion">Fecha de inscripción:</label>
	<input type="date" name="fecha_inscripcion" required><br><br>

	<label for="padecimiento_alergia">Padecimiento o alergia:</label>
	<input type="text" name="padecimiento_alergia"><br><br>

	<label for="nombre_padre">Nombre del padre:</label>
	<input type="text" name="nombre_padre" required><br><br>

	<label for="nombre_madre">Nombre de la madre:</label>
	<input type="text" name="nombre_madre" required><br><br>

	<label for="cedula_padre">Cédula del padre:</label>
	<input type="text" name="cedula_padre" required><br><br>

	<label for="cedula_madre">Cédula de la madre:</label>
	<input type="text" name="cedula_madre" required><br><br>

	<label for="telefono_emergencia">Teléfono de emergencia:</label>
	<input type="text" name="telefono_emergencia" required><br><br>

	<label for="ocupacion_padre">Ocupación del padre:</label>
	<input type="text" name="ocupacion_padre" required><br><br>

	<label for="ocupacion_madre">Ocupación de la madre:</label>
	<input type="text" name="ocupacion_madre" required><br><br>

	<label for="direccion_exacta">Dirección exacta:</label>
	<input type="text" name="direccion_exacta" required><br><br>

	<input type="submit" value="Agregar alumno"><br><br>
</form>
  </div>
</body>
</html>