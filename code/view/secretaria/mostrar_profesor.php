<?php 
  include("header.php"); 
?>

<?php
include "../../conexion.php";

$id_profesor = $_GET['id'];

// Obtener la información del profesor
$consulta = "SELECT p.*, GROUP_CONCAT(pg.id_grado SEPARATOR ', ') AS id_grados, GROUP_CONCAT(pa.id_asignatura SEPARATOR ', ') AS id_asignaturas
             FROM profesores p
             LEFT JOIN profesores_grados pg ON p.id_profesor = pg.id_profesor
             LEFT JOIN profesores_asignaturas pa ON p.id_profesor = pa.id_profesor
             WHERE p.id_profesor = $id_profesor";
$resultado = mysqli_query($conexion, $consulta);

// Verificar si se encontró al profesor
if (mysqli_num_rows($resultado) == 0) {
  echo "<p>No se encontró al profesor.</p>";
} else {
  $fila = mysqli_fetch_assoc($resultado);
?>
<style>
  table {
    border-collapse: collapse;
    width: 100%;
  }

  th, td {
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
  }

  th {
    background-color: #f2f2f2;
  }

  tr:hover {
    background-color: #f5f5f5;
  }
</style>

<h2>Información del profesor</h2>
<form>
<table>
  <tr>
    <td>Nombre:</td>
    <td><?php echo $fila['nombre']; ?></td>
  </tr>
  <tr>
    <td>Apellido:</td>
    <td><?php echo $fila['apellido']; ?></td>
  </tr>
  <tr>
    <td>Correo electrónico:</td>
    <td><?php echo $fila['correo_electronico']; ?></td>
  </tr>
  <tr>
    <td>Teléfono:</td>
    <td><?php echo $fila['telefono']; ?></td>
  </tr>
  <tr>
    <td>Dirección:</td>
    <td><?php echo $fila['direccion']; ?></td>
  </tr>
  <tr>
    <td>Certificaciones:</td>
    <td><?php echo $fila['certificaciones']; ?></td>
  </tr>
  <tr>
    <td>Carrera universitaria:</td>
    <td><?php echo $fila['carrera_universitaria']; ?></td>
  </tr>
  <tr>
    <td>Grados:</td>
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
  </tr>
  <tr>
    <td>Asignaturas:</td>
    <td>
     <?php
    // Obtener los nombres de las asignaturas y grados del profesor
    $consulta_asignaturas = "SELECT a.nombre_asignatura, g.nombre_grado
                             FROM asignaturas a
                             INNER JOIN profesores_asignaturas pa ON a.id_asignatura = pa.id_asignatura
                             INNER JOIN profesores_grados pg ON pg.id_profesor = pa.id_profesor
                             INNER JOIN grados g ON g.id_grado = pg.id_grado
                             WHERE pa.id_profesor = $id_profesor";
    $resultado_asignaturas = mysqli_query($conexion, $consulta_asignaturas);

    // Mostrar la lista de asignaturas y grados
    while ($fila_asignatura = mysqli_fetch_assoc($resultado_asignaturas)) {
      echo '<tr><td>' . $fila_asignatura['nombre_asignatura'] . ' (' . $fila_asignatura['nombre_grado'] . ')</td></tr>';
    }
  ?>
    </td>
  </tr>
</table>

</form>


<?php } ?>

<?php mysqli_close($conexion); ?>
