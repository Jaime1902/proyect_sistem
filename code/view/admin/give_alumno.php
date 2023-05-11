<?php 
  include("header.php"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar nuevo alumno</title>
  <style>
    /* Estilos generales */
    * {
      box-sizing: border-box;
    }
    
    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      color: #333;
      margin: 0;
      padding: 0;
    }
    
    /* Estilos para el contenedor del formulario */
    #formulario-alumno {
      max-width: 600px;
      margin: 0 auto;
      background-color: #fff;
      padding: 20px;
      border-radius: 4px;
      box-shadow: 0px 0px 5px #ccc;
    }
    
    /* Estilos para los campos del formulario */
    #formulario-alumno label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      font-size: 16px;
    }
    
    #formulario-alumno input[type="text"],
    #formulario-alumno select,
    #formulario-alumno input[type="date"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
      line-height: 1.5;
    }
    
    #formulario-alumno select {
      height: 40px;
    }
    
    #formulario-alumno input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }
    
    #formulario-alumno input[type="submit"]:hover {
      background-color: #45a049;
    }
    
    /* Estilos para los grupos de campos */
    .grupo {
      margin-bottom: 40px;
    }
    
    .grupo legend {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 20px;
    }
    
    .grupo > div {
      display: flex;
      flex-wrap: wrap;
      margin-bottom: 20px;
    }
    
    .grupo > div > div {
      flex-basis: calc(50% - 10px);
      margin-right: 20px;
    }
    
    .grupo > div > div:last-child {
      margin-right: 0;
    }
  </style>
</head>
<br><br>
<body>
  <div id="formulario-alumno">
    <form action="agregar_alumno.php" method="post">
      <h1 style="text-align:center;">Agregar nuevo alumno</h1>
      
      <div class="grupo">

        <legend>Información personal</legend>
        <div>
          <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
          </div>
          <div>
            <label for="apellidos">Apellidos:</label>
            <input type="text" name="apellidos" required>
          </div>
        </div>
        <div>
          <div>
            <label for="lugar_nacimiento">Lugar de nacimiento:</label>
            <input type="text" name="lugar_nacimiento" required>
          </div>
          <div>
            <label for="fecha_nacimiento">Fecha de nacimiento:</label>
            <input type="date" name="fecha_nacimiento" required>
          </div>
        </div>
        <div>
          <div>
            <label for="codigo_estudiante">Código de estudiante:</label>
            <input type="text" name="codigo_estudiante" required>
          </div>
          <div>
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
            </select>
          </div>
        </div>
        <div>
          <div>
            <label for="fecha_inscripcion">Fecha de inscripción:</label>
             <input type="date" name="fecha_inscripcion" value="<?php echo date('Y-m-d'); ?>" required>
          </div>
          <div>
            <label for="padecimiento_alergia">Padecimiento o alergia:</label>
            <input type="text" name="padecimiento_alergia">
          </div>
        </div>
      </div>
      
      <div class="grupo">
        <legend>Información de los padres</legend>
        <div>
          <div>
            <label for="nombre_padre">Nombre del padre:</label>
            <input type="text" name="nombre_padre" required>
          </div>
          <div>
            <label for="nombre_madre">Nombre de la madre:</label>
            <input type="text" name="nombre_madre" required>
          </div>
        </div>
        <div>
          <div>
            <label for="cedula_padre">Cédula del padre:</label>
            <input type="text" name="cedula_padre" required>
          </div>
          <div>
            <label for="cedula_madre">Cédula de la madre:</label>
            <input type="text" name="cedula_madre" required>
          </div>
        </div>
        <div>
          <div>
            <label for="telefono_emergencia">Teléfono de emergencia:</label>
            <input type="text" name="telefono_emergencia" required>
          </div>
          <div>
            <label for="ocupacion_padre">Ocupación del padre:</label>
            <input type="text" name="ocupacion_padre">
          </div>
        </div>
        <div>
          <div>
            <label for="ocupacion_madre">Ocupación de la madre:</label>
            <input type="text" name="ocupacion_madre">
          </div>
        </div>
      </div>
      
      <input type="submit" value="Agregar alumno">
    </form>
  </div>
</body>
</html>