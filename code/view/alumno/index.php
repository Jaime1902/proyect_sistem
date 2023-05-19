<?php
// Iniciar sesión
session_start();

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Si el usuario está autenticado, obtener el ID de login desde la variable de sesión
if (isset($_SESSION["id_login"])) {
    $id_login = $_SESSION["id_login"];
  
    // Obtener la información del alumno y del grado correspondiente al ID de login
    $sql = "SELECT a.nombre, a.apellidos, a.fecha_nacimiento, g.nombre_grado
            FROM alumnos a
            INNER JOIN grados g ON a.id_grado = g.id_grado
            WHERE a.login_id = $id_login";
    $result = $conn->query($sql);
  
    if ($result->num_rows == 1) {
      // Encontrar el registro de alumno y grado correspondiente al usuario autenticado
      $row = $result->fetch_assoc();
      $nombre_alumno = $row["nombre"] . " " . $row["apellidos"];
      $nombre_grado = $row["nombre_grado"];
      $fecha_nacimiento = $row["fecha_nacimiento"];
  
      // Obtener el ID de grado correspondiente al ID de alumno
      $sql = "SELECT id_grado FROM alumnos WHERE login_id = $id_login";
      $result = $conn->query($sql);
  
      if ($result->num_rows == 1) {
        // Encontrar el registro de grado correspondiente al alumno autenticado
        $row = $result->fetch_assoc();
        $id_grado = $row["id_grado"];
  
        // Mostrar resultados en formato HTML con estilo CSS de Bootstrap
        ?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Importar los estilos de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            text-align: center;
        }

        .table {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <?php include "heder.php"; ?>
    <div class="container">
      <br><br>
        <h3>Información del Estudiante</h3>
        <br><br>
        <table class="table">
            <tbody>
                <tr>
                    <th>Nombre completo:</th>
                    <td><?php echo $nombre_alumno; ?></td>
                </tr>
                <tr>
                    <th>Grado:</th>
                    <td><?php echo $nombre_grado; ?></td>
                </tr>
                <tr>
                    <th>Fecha de nacimiento:</th>
                    <td><?php echo $fecha_nacimiento; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Importar los scripts de Bootstrap -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>

<?php
      } else {

        $_SESSION['error'] = "No se encontró ningún registro de grado para el alumno correspondiente.";
            header("Location: 403.php");
      }
    } else {
      $_SESSION['error'] = "No se encontró ningún registro de alumno y grado para el usuario actual.";
      header("Location: 403.php");
    }
  } else {
    // Si el usuario no está autenticado, redirigir al formulario de inicio de sesión
    header("Location: ../../index.php");
    exit();
  }
?>