<!DOCTYPE html>
<html>
    <?php include ("header.php");?>
    <br><br>
<head>
  <title>Asignaturas</title>
  <style>
    .button-container {
        display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .asignatura-button {
        display: block;
      width: 300px;
      height: 100px;
      margin: 10px;
      background-color: <?php echo getRandomColor(); ?>;
      border: none;
      border-radius: 5px;
      font-size: 18px;
      color: #fff;
      text-align: center;
      text-decoration: none;
      line-height: 100px;
    }

    .asignatura-button:hover {
      opacity: 0.8;
    }

    .asignatura-button:active {
      opacity: 0.6;
    }
  </style>
</head>
<body>
<?php
session_start();

// Validar que el usuario haya iniciado sesión
if (!isset($_SESSION['id_profesor'])) {
    header("Location: login.php");
    exit;
}

// Obtener el ID del profesor desde la sesión
$id_profesor = $_SESSION['id_profesor'];

// Obtener el ID del grado desde la URL
if (isset($_GET['id_grado'])) {
    $id_grado = $_GET['id_grado'];
} else {
    // Redirigir en caso de que no se proporcione un ID de grado válido
    header("Location: view_grado.php");
    exit;
}

// Realizar la consulta SQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_db";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta SQL
$sql = "SELECT asignaturas.id_asignatura, asignaturas.nombre_asignatura
        FROM profesores_asignaturas
        INNER JOIN asignaturas ON profesores_asignaturas.id_asignatura = asignaturas.id_asignatura
        WHERE profesores_asignaturas.id_profesor = $id_profesor AND asignaturas.id_grado = $id_grado";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="button-container">';
    // Mostrar los resultados de la consulta
    while ($row = $result->fetch_assoc()) {
        echo '<a href="calificar.php?id_asignatura=' . $row['id_asignatura'] . '&id_grado=' . $_GET['id_grado'] . '" class="asignatura-button">' . $row['nombre_asignatura'] . '</a>';
    }
    echo '</div>';
} else {
    echo "No se encontraron asignaturas para este grado y profesor.";
}

// Cerrar la conexión
$conn->close();

// Función para obtener un color aleatorio
function getRandomColor() {
    $colors = ['#8bc34a', '#e53935', '#ff9800', '#d32f2f', '#4caf50'];
    return $colors[array_rand($colors)];
}
?>
</body>
</html>
