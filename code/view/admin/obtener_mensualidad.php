<?php
if (isset($_POST['id_alumno'])) {
    // Obtener el id del alumno del parámetro POST
    $id_alumno = $_POST['id_alumno'];

    if (!isset($id_alumno) || empty($id_alumno)) {
        echo "Seleciona un alumno primero";
        exit;
    }

    // Conectarse a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project_db";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Realizar la consulta a la tabla de mensualidades
    $sql = "SELECT * FROM mensualidades WHERE id_alumno = " . $id_alumno;
    $result = $conn->query($sql);

    // Crear la lista HTML con los resultados de la consulta
    if ($result->num_rows > 0) {
        $html = '<h2>Mensualidades del alumno '.$id_alumno.'</h2>';
        $html .= '<table style="border-collapse: collapse; width: 100%;">';
        $html .= '<tr style="background-color: #f2f2f2;"><th style="padding: 8px; border: 1px solid #ddd;">Fecha de pago</th><th style="padding: 8px; border: 1px solid #ddd;">Monto</th></tr>';
        while($row = $result->fetch_assoc()) {
            $fecha_pago = date("M j, Y", strtotime($row["fecha_pago"]));
            $html .= '<tr><td style="padding: 8px; border: 1px solid #ddd;">' . $fecha_pago . '</td><td style="padding: 8px; border: 1px solid #ddd;">' . $row["monto"] . '</td></tr>';
        }
        $html .= '</table>';
        echo $html;
    } else {
        echo "No se encontraron mensualidades para este alumno.";
    }

    $conn->close();
}
?>