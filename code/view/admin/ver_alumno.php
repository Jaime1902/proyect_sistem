<?php
include("../../conexion.php");

if(isset($_GET['id'])){
  $id = $_GET['id'];
  $query = "SELECT * FROM alumnos WHERE id_alumno = $id";
  $result = mysqli_query($conexion, $query);
  if(mysqli_num_rows($result) == 1){
    $fila = mysqli_fetch_array($result);
    $nombre = $fila['nombre'];
    $apellidos = $fila['apellidos'];
    $lugar_nacimiento = $fila['lugar_nacimiento'];
    $fecha_nacimiento = $fila['fecha_nacimiento'];
    $codigo_estudiante = $fila['codigo_estudiante'];
    $id_grado = $fila['id_grado'];
    $fecha_inscripcion = $fila['fecha_inscripcion'];
    $padecimiento_alergia = $fila['padecimiento_alergia'];
    $nombre_padre = $fila['nombre_padre'];
    $nombre_madre = $fila['nombre_madre'];
    $cedula_padre = $fila['cedula_padre'];
    $cedula_madre = $fila['cedula_madre'];
    $telefono_emergencia = $fila['telefono_emergencia'];
    $ocupacion_padre = $fila['ocupacion_padre'];
    $ocupacion_madre = $fila['ocupacion_madre'];
    $direccion_exacta = $fila['direccion_exacta'];
  }
}

?>

<?php include("header.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>
  /* Estilos para el contenedor principal */
.container {
  margin-top: 10px;
}

/* Estilos para centrar el contenido horizontalmente */
.row {
  display: flex;
  justify-content: center;
}

/* Estilos para la tarjeta */
.card {
  width: 120%;
  max-width: 800px;
  border: none;
  border-radius: 50px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
}

/* Estilos para el título */
.card-body h1 {
  font-size: 32px;
  font-weight: bold;
  color: #333;
  text-align: center;
  margin-bottom: 30px;
}

/* Estilos para la tabla */
.table {
  width: 100%;
  font-size: 16px;
  border-collapse: collapse;
  margin-top: 10px;
}

/* Estilos para los encabezados de la tabla */
.table th {
  background-color: #f8f8f8;
  color: #333;
  font-weight: bold;
  padding: 20px;
  text-align: left;
  border-bottom: 5px solid #ddd;
}

/* Estilos para las celdas de la tabla */
.table td {
  padding: 10px;
  border-bottom: 5px solid #ddd;
}

/* Estilos para las filas impares de la tabla */
.table tbody tr:nth-child(odd) {
  background-color: #f8f8f8;
}



</style>
<body>
 
<main class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
 
          <h1 class="text-center mb-4">Detalles del alumno</h1>
          <div class="table-responsive">
            <table class="table table-hover">

              <tbody>
                <tr>
                  <th>ID</th>
                  <td><?php echo $id; ?></td>
                </tr>
                <tr>
                  <th>Nombre</th>
                  <td><?php echo $nombre; ?></td>
                </tr>
                <tr>
                  <th>Apellidos</th>
                  <td><?php echo $apellidos; ?></td>
                </tr>
                <tr>
                  <th>Lugar de nacimiento</th>
                  <td><?php echo $lugar_nacimiento; ?></td>
                </tr>
                <tr>
                  <th>Fecha de nacimiento</th>
                  <td><?php echo $fecha_nacimiento; ?></td>
                </tr>
                <tr>
                  <th>Código de estudiante</th>
                  <td><?php echo $codigo_estudiante; ?></td>
                </tr>
                <tr>
                  <th>Grado</th>
                  <td>
                    <?php
                    $query_grado = "SELECT nombre_grado FROM grados WHERE id_grado = $id_grado";
                    $result_grado = mysqli_query($conexion, $query_grado);
                    $fila_grado = mysqli_fetch_array($result_grado);
                    echo $fila_grado['nombre_grado'];
                    ?>
                  </td>
                </tr>
                <tr>
                  <th>Fecha de inscripción</th>
                  <td><?php echo $fecha_inscripcion; ?></td>
                </tr>
                <tr>
                  <th>Padecimientos o alergias</th>
                  <td><?php echo $padecimiento_alergia; ?></td>
                </tr>
                <tr>
                  <th>Nombre del padre</th>
                  <td><?php echo $nombre_padre; ?></td>
                </tr>
                <tr>
                  <th>Nombre de la madre</th>
                  <td><?php echo $nombre_madre; ?></td>
                </tr>
                <tr>
                  <th>Cédula del padre</th>
                  <td><?php echo $cedula_padre; ?></td>
                </tr>
                <tr>
                  <th>Cédula de la madre</th>
                  <td><?php echo $cedula_madre; ?></td>
                </tr>
                <tr>
                  <th>Teléfono de emergencia</th>
                  <td><?php echo $telefono_emergencia; ?></td>
                </tr>
                <tr>
                  <th>Ocupación del padre</th>
                  <td><?php echo $ocupacion_padre; ?></td>
                </tr>
                <tr>
                  <th>Ocupación de la madre</th>
                  <td><?php echo $ocupacion_madre; ?></td>
                </tr>
                <tr>
                  <th>Dirección exacta</th>
                  <td><?php echo $direccion_exacta; ?></td>
                </tr>
              </tbody>
              <div class="button-container">
  <a href="exportar_calificaciones.php?id=<?php echo $id; ?>" class="btn btn-red">Exportar calificaciones</a>
  <a href="exportar_alumno.php?id=<?php echo $id; ?>" class="btn btn-blue">Exportar datos al alumno</a>
</div>



            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
</body>
</html>
