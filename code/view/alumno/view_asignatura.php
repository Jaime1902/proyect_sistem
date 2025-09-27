<?php
// Iniciar sesión
include "header.php";

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "mysql";
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
            // Consulta para obtener asignaturas correspondientes al ID de grado
            $sql = "SELECT id_asignatura, nombre_asignatura, ruta_imagen FROM asignaturas WHERE id_grado = $id_grado";
            $result = $conn->query($sql);

            // Mostrar resultados en formato HTML con estilo CSS de Bootstrap
            ?>
    <!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        .card {
            margin: 10px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s;
            cursor: pointer;
            height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px 8px 0 0;
        }

        .card span {
            font-size: 16px;
            font-weight: bold;
        }

        .container {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h4>Ver las Notas por Asignaturas - <?php echo $nombre_grado; ?></h4>
        <div class="row">
            <?php 
            while ($row = $result->fetch_assoc()) {
                // Seleccionar color y determinar la imagen
                $color = $colores[array_rand($colores)];
                $imagen = !empty($row["ruta_imagen"]) ? $row["ruta_imagen"] : "img/Asignatura/predeterminada.png";
                ?>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card" style="background-color: <?php echo $color; ?>;" 
                         onclick="redirectToCalificaciones(<?php echo $row['id_asignatura']; ?>);">
                        <img src="<?php echo htmlspecialchars($imagen); ?>" alt="Imagen de <?php echo htmlspecialchars($row['nombre_asignatura']); ?>">
                        <span><?php echo htmlspecialchars($row["nombre_asignatura"]); ?></span>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <script>
        function redirectToCalificaciones(idAsignatura) {
            window.location.href = "calificaciones.php?id_asignatura=" + idAsignatura;
        }
    </script>
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
