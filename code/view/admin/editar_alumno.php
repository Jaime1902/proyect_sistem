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

if(isset($_POST['actualizar'])){
  $id = $_GET['id'];
  $nombre = $_POST['nombre'];
  $apellidos = $_POST['apellidos'];
  $lugar_nacimiento = $_POST['lugar_nacimiento'];
  $fecha_nacimiento = $_POST['fecha_nacimiento'];
  $codigo_estudiante = $_POST['codigo_estudiante'];
  $id_grado = $_POST['id_grado'];
  $fecha_inscripcion = $_POST['fecha_inscripcion'];
  $padecimiento_alergia = $_POST['padecimiento_alergia'];
  $nombre_padre = $_POST['nombre_padre'];
  $nombre_madre = $_POST['nombre_madre'];
  $cedula_padre = $_POST['cedula_padre'];
  $cedula_madre = $_POST['cedula_madre'];
  $telefono_emergencia = $_POST['telefono_emergencia'];
  $ocupacion_padre = $_POST['ocupacion_padre'];
  $ocupacion_madre = $_POST['ocupacion_madre'];
  $direccion_exacta = $_POST['direccion_exacta'];

  $query = "UPDATE alumnos SET nombre = '$nombre', apellidos = '$apellidos', lugar_nacimiento = '$lugar_nacimiento', fecha_nacimiento = '$fecha_nacimiento', codigo_estudiante = '$codigo_estudiante', id_grado = $id_grado, fecha_inscripcion = '$fecha_inscripcion', padecimiento_alergia = '$padecimiento_alergia', nombre_padre = '$nombre_padre', nombre_madre = '$nombre_madre', cedula_padre = '$cedula_padre', cedula_madre = '$cedula_madre', telefono_emergencia = '$telefono_emergencia', ocupacion_padre = '$ocupacion_padre', ocupacion_madre = '$ocupacion_madre', direccion_exacta = '$direccion_exacta' WHERE id_alumno = $id";
  mysqli_query($conexion,$query);

  $_SESSION['mensaje'] = 'Alumno actualizado correctamente';
  $_SESSION['tipo_mensaje'] = 'success';
  header('Location: index.php');
  }
  ?>
  
  <main class="container p-4">
    <div class="row">
      <div class="col-md-4 mx-auto">
        <div class="card card-body">
          <h3>Editar alumno</h3>
          <form action="editar_alumno.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <div class="form-group">
              <input type="text" name="nombre" value="<?php echo $nombre; ?>" class="form-control" placeholder="Nombre" autofocus required>
            </div>
            <div class="form-group">
              <input type="text" name="apellidos" value="<?php echo $apellidos; ?>" class="form-control" placeholder="Apellidos" required>
            </div>
            <div class="form-group">
              <input type="text" name="lugar_nacimiento" value="<?php echo $lugar_nacimiento; ?>" class="form-control" placeholder="Lugar de nacimiento" required>
            </div>
            <div class="form-group">
              <input type="date" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" class="form-control" placeholder="Fecha de nacimiento" required>
            </div>
            <div class="form-group">
              <input type="text" name="codigo_estudiante" value="<?php echo $codigo_estudiante; ?>" class="form-control" placeholder="Código de estudiante" required>
            </div>
            <div class="form-group">
              <select name="id_grado" class="form-select" required>
                <option value="">Seleccione el grado</option>
                <?php
                $query_grados = "SELECT * FROM grados";
                $result_grados = mysqli_query($conexion, $query_grados);
                while($fila_grados = mysqli_fetch_array($result_grados)){
                  $selected = ($fila_grados['id_grado'] == $id_grado) ? 'selected' : '';
                  echo "<option value='" . $fila_grados['id_grado'] . "' $selected>" . $fila_grados['nombre_grado'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <input type="date" name="fecha_inscripcion" value="<?php echo $fecha_inscripcion; ?>" class="form-control" placeholder="Fecha de inscripción" required>
            </div>
            <div class="form-group">
              <input type="text" name="padecimiento_alergia" value="<?php echo $padecimiento_alergia; ?>" class="form-control" placeholder="Padecimientos o alergias">
            </div>
            <div class="form-group">
              <input type="text" name="nombre_padre" value="<?php echo $nombre_padre; ?>" class="form-control" placeholder="Nombre del padre" required>
            </div>
            <div class="form-group">
              <input type="text" name="nombre_madre" value="<?php echo $nombre_madre; ?>" class="form-control" placeholder="Nombre de la madre" required>
            </div>
            <div class="form-group">
              <input type="text" name="cedula_padre" value="<?php echo $cedula_padre; ?>" class="form-control" placeholder="Cédula del padre" required>
              </div>
          <div class="form-group">
            <input type="text" name="cedula_madre" value="<?php echo $cedula_madre; ?>" class="form-control" placeholder="Cédula de la madre" required>
          </div>
          <button class="btn btn-success btn-block" name="actualizar">
            Actualizar
          </button>
        </form>
      </div>
    </div>
  </div>

