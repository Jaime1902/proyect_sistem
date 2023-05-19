<!DOCTYPE html>
<html>
    <?php include ("header.php");?>
    <br><br>
<head>
  <title>Grados</title>
  <style>
    .panel {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
    }

    .grado-button {
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

    .grado-button:hover {
      opacity: 0.8;
    }

    .grado-button:active {
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
$sql = "SELECT grados.id_grado, grados.nombre_grado
        FROM profesores_grados
        INNER JOIN grados ON profesores_grados.id_grado = grados.id_grado
        WHERE profesores_grados.id_profesor = $id_profesor";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="panel">';
    // Crear una variable para almacenar la URL de redirección
    $redirect_url = "view_asignatura.php?id_grado=";

    // Mostrar los resultados de la consulta
    while ($row = $result->fetch_assoc()) {
        echo '<a href="' . $redirect_url . $row["id_grado"] . '" class="grado-button">' . $row["nombre_grado"] . '</a>';
    }
    echo '</div>';
} else {
    echo "No se encontraron resultados.";
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
