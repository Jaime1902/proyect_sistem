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
            $sql = "SELECT id_asignatura, nombre_asignatura FROM asignaturas WHERE id_grado = $id_grado";
            $result = $conn->query($sql);
            $colores = ['#8bc34a', '#e53935', '#ff9800', '#d32f2f', '#4caf50'];

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
            <?php
            include "heder.php";
            ?>
            <body>
            <div class="container">
            <h4>Asignaturas</h4>
            <div class="row">
              <?php while($row = $result->fetch_assoc()) { 
                // Seleccionar un color aleatorio
                $color = $colores[array_rand($colores)]; ?>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 card-column">
                  <button class="card-button" style="background-color: <?php echo $color; ?>" onclick="redirectToCalificaciones(<?php echo $row['id_asignatura']; ?>);">
                    <span style="color: white; font-size: 20px;"><?php echo $row["nombre_asignatura"]; ?></span>
                  </button>
                </div>
              <?php } ?>
            </div>
          </div>
            </div>
            <!-- Importar los scripts de Bootstrap -->
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script>
                function redirectToCalificaciones(idAsignatura) {
                    window.location.href = "calificaciones.php?id_asignatura=" + idAsignatura;
                }
            </script>
            </script>
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
