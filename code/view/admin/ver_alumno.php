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
  }
}

?>

<?php include("header.php"); ?>
<main class="container p-4">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-body">
        <h3>Detalles del alumno</h3>
        <table class="table table-bordered">
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

             
