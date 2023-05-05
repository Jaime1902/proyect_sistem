<?php 
include("header.php"); 
?>

<?php
include "../../conexion.php";

// Obtener la información de los profesores y sus grados
$consulta = "SELECT p.id_profesor, p.nombre, p.apellido, p.carrera_universitaria, GROUP_CONCAT(pg.id_grado SEPARATOR ', ') AS id_grados
             FROM profesores p
             LEFT JOIN profesores_grados pg ON p.id_profesor = pg.id_profesor
             GROUP BY p.id_profesor";

// Verificar si se ha enviado una consulta de búsqueda
if (isset($_GET['buscar'])) {
  $busqueda = $_GET['buscar'];
  // Agregar la condición de búsqueda a la consulta
  $consulta .= " HAVING nombre LIKE '%$busqueda%' OR apellido LIKE '%$busqueda%'";
}

$resultado = mysqli_query($conexion, $consulta);
?>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.search-form {
    position: absolute;
    top: 50px;
    right: 20px;
}

header {
    background-color: #333;
    color: #fff;
    padding: 10px;
    text-align: center;
}

h1 {
    margin-top: 0;
}

form {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    margin: 20px;
}

input[type="text"] {
    padding: 10px;
    font-size: 16px;
    border-radius: 5px 0 0 5px;
    border: none;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

button[type="submit"] {
    padding: 10px;
    font-size: 16px;
    background-color: #333;
    color: #fff;
    border-radius: 0 5px 5px 0;
    border: none;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    cursor: pointer;
}

table {
    border-collapse: collapse;
    width: 100%;
    margin: 20px;
}

th,
td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #333;
    color: #fff;
}

td a {
    color: #333;
    text-decoration: none;
    background-color: #ddd;
    padding: 5px 10px;
    border-radius: 5px;
}

td a:hover {
    background-color: #333;
    color: #fff;
}
.delete-link {
		color: red;
	}
</style>
<div class="search-form">
  <form action="" method="GET">
    <input type="text" name="buscar" placeholder="Buscar por nombre">
    <button type="submit">Buscar</button>
  </form>
</div>
<table>
  <tr>
    <th>Nombre completo</th>
    <th>Grado</th>
    <th>Carrera Universitaria</th>
    <th>Acciones</th>
  </tr>
  <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
    <tr>
      <td><?php echo $fila['nombre'] . " " . $fila['apellido']; ?></td>
      <td>
        <?php
          // Obtener los nombres de los grados del profesor
          $consulta_grados = "SELECT nombre_grado FROM grados WHERE id_grado IN (" . $fila['id_grados'] . ")";
          $resultado_grados = mysqli_query($conexion, $consulta_grados);
          while ($fila_grado = mysqli_fetch_assoc($resultado_grados)) {
            echo $fila_grado['nombre_grado'] . ", ";
          }
        ?>
      </td>
      <td><?php echo $fila['carrera_universitaria']; ?></td>
      <td>
        <a href="editar_profesor.php?id=<?php echo $fila['id_profesor']; ?>">Editar</a> |
        <a href="mostrar_profesor.php?id=<?php echo $fila['id_profesor']; ?>">Mostrar</a> |
        <a href="eliminar_profesor.php?id=<?php echo $fila['id_profesor']; ?>"class="delete-link onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">Eliminar</a>
      </td>
    </tr>
  <?php } ?>
</table>

<?php mysqli_close($conexion); ?>