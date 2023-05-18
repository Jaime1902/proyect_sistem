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
    $sql = "SELECT a.nombre, a.apellidos, g.nombre_grado
            FROM alumnos a
            INNER JOIN grados g ON a.id_grado = g.id_grado
            WHERE a.login_id = $id_login";
    $result = $conn->query($sql);
  
    if ($result->num_rows == 1) {
      // Encontrar el registro de alumno y grado correspondiente al usuario autenticado
      $row = $result->fetch_assoc();
      $nombre_alumno = $row["nombre"] . " " . $row["apellidos"];
      $nombre_grado = $row["nombre_grado"];
  
      // Obtener el ID de grado correspondiente al ID de alumno
      $sql = "SELECT id_grado FROM alumnos WHERE login_id = $id_login";
      $result = $conn->query($sql);
  
      if ($result->num_rows == 1) {
        // Encontrar el registro de grado correspondiente al alumno autenticado
        $row = $result->fetch_assoc();
        $id_grado = $row["id_grado"];
  
        // Consulta a la base de datos para obtener las asignaturas correspondientes al ID de grado
        $sql = "SELECT nombre_asignatura FROM asignaturas WHERE id_grado = $id_grado";
        $result = $conn->query($sql);

        // Colores aleatorios para los bloques de asignaturas
        $colores = ['#8bc34a', '#e53935', '#ff9800', '#d32f2f', '#4caf50'];
  
        // Mostrar resultados en formato HTML con estilo CSS de Materialize
        ?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <!-- Importar los estilos de Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <style>
    .red-header {
      background-color: red;
    }
    .header-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      height: 70px;
    }
    .header-text {
      font-size: 20px;
      font-weight: bold;
      color: white;
      margin: 0;
    }
    .header-info {
      display: flex;
      align-items: center;
    }
    .header-info li {
      margin-left: 20px;
      color: white;
      font-size: 18px;
      list-style-type: none;
    }
    .card-button {
      cursor: pointer;
      background-color: #f5f5f5;
      border: none;
      border-radius: 5px;
      padding: 10px;
      margin-bottom: 10px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    .card-button:hover {
      background-color: #e0e0e0;
    }
    .sub-header {
      background-color: #f5f5f5;
      padding: 10px;
      margin-top: 20px;
    }
    .sub-header ul {
      display: flex;
      justify-content: space-around;
      margin: 0;
      padding: 0;
    }
    .sub-header li {
      list-style-type: none;
      margin: 0 10px;
    }
  </style>
</head>
<body>
  <nav class="red-header">
    <div class="container-fluid">
      <div class="header-container">
        <h5 class="header-text">Colegio Cristiano Presbiteriano</h5>
      </div>
    </div>
  </nav>
  <div class="sub-header">
    <div class="container">
      <ul>
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Ver Calificaciones</a></li>
      </ul>
    </div>
  </div>
  <div class="container">
    <h4>Asignaturas</h4>
    <div class="row">
      <?php while($row = $result->fetch_assoc()) { 
        // Seleccionar un color aleatorio
        $color = $colores[array_rand($colores)]; ?>
        <div class="col-xs-12 col-sm-6">
          <button class="card-button" style="background-color: <?php echo $color; ?>" onclick="location.href='#';">
            <?php echo $row["nombre_asignatura"]; ?>
          </button>
        </div>
      <?php } ?>
    </div>
  </div>
  <!-- Importar los scripts de Bootstrap -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>

        <?php
      } else {
        echo "No se encontró ningún registro de grado para el alumno correspondiente.";
      }
    } else {
      echo "No se encontró ningún registro de alumno y grado para el usuario actual.";
    }
  } else {
    // Si el usuario no está autenticado, redirigir al formulario de inicio de sesión
    header("Location: login.php");
    exit();
  }
?>
