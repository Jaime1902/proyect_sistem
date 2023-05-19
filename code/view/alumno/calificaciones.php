<?php
// Iniciar sesión
include "header.php";

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
    $sql = "SELECT a.id_alumno, a.nombre, a.apellidos, a.fecha_nacimiento, g.nombre_grado
            FROM alumnos a
            INNER JOIN grados g ON a.id_grado = g.id_grado
            WHERE a.login_id = $id_login";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Encontrar el registro de alumno y grado correspondiente al usuario autenticado
        $row = $result->fetch_assoc();
        $id_alumno = $row["id_alumno"];
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

            // Obtener el ID de la asignatura de la URL
            if (isset($_GET["id_asignatura"])) {
                $id_asignatura = $_GET["id_asignatura"];

                // Consulta a la base de datos para obtener el nombre de la asignatura
                $sql = "SELECT nombre_asignatura FROM asignaturas WHERE id_asignatura = $id_asignatura";
                $result = $conn->query($sql);

                if ($result->num_rows == 1) {
                    // Encontrar el nombre de la asignatura correspondiente al ID proporcionado
                    $row = $result->fetch_assoc();
                    $nombre_asignatura = $row["nombre_asignatura"];
                } else {
                    echo "No se encontró ninguna asignatura con el ID proporcionado.";
                    exit();
                }
            } else {
                echo "No se proporcionó ningún ID de asignatura.";
                exit();
            }

            // Obtener las calificaciones del alumno para la asignatura enviada
            $sql = "SELECT semestre1, semestre2, semestre3, semestre4
                    FROM calificaciones
                    WHERE id_alumno = $id_alumno AND id_asignatura = $id_asignatura";
            $result = $conn->query($sql);

            if ($result->num_rows == 1) {
                // Encontrar el registro de calificaciones correspondiente al alumno y asignatura
                $row = $result->fetch_assoc();
                $semestre1 = $row["semestre1"];
                $semestre2 = $row["semestre2"];
                $semestre3 = $row["semestre3"];
                $semestre4 = $row["semestre4"];

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
                    <div class="container">
                        <h3>Calificaciones de <?php echo $nombre_alumno; ?></h3>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Asignatura:</th>
                                    <td><?php echo $nombre_asignatura; ?></td>
                                </tr>
                                <tr>
                                    <th>Semestre 1:</th>
                                    <td><?php echo $semestre1; ?></td>
                                </tr>
                                <tr>
                                    <th>Semestre 2:</th>
                                    <td><?php echo $semestre2; ?></td>
                                </tr>
                                <tr>
                                    <th>Semestre 3:</th>
                                    <td><?php echo $semestre3; ?></td>
                                </tr>
                                <tr>
                                    <th>Semestre 4:</th>
                                    <td><?php echo $semestre4; ?></td>
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
                $_SESSION['error'] = "No se encontró ninguna calificación para el alumno y asignatura especificados.";
                header("Location: 403.php");
            }
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
