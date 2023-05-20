<?php
    // Conexión a la base de datos
    include "../../conexion.php";
    include"header.php";

    // Obtener todas las asignaturas
    $query = "SELECT a.*, g.nombre_grado AS nombre_grado 
              FROM asignaturas a 
              INNER JOIN grados g ON a.id_grado = g.id_grado 
              ORDER BY a.id_asignatura";
    $result = $conexion->query($query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Asignaturas</title>
</head>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.search-form {
    position: absolute;
    top: 50px;
    right: 20px;
}

header {
    background-color: #333;
    color: #fff;
    padding: 10px;
    text-align: center;
}

h1 {
    margin-top: 0;
}

form {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    margin: 20px;
}

input[type="text"] {
    padding: 10px;
    font-size: 16px;
    border-radius: 5px 0 0 5px;
    border: none;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

button[type="submit"] {
    padding: 10px;
    font-size: 16px;
    background-color: #333;
    color: #fff;
    border-radius: 0 5px 5px 0;
    border: none;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    cursor: pointer;
}

table {
    border-collapse: collapse;
    width: 100%;
    margin: 20px;
}

th,
td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #333;
    color: #fff;
}

td a {
    color: #333;
    text-decoration: none;
    background-color: #ddd;
    padding: 5px 10px;
    border-radius: 5px;
}

td a:hover {
    background-color: #333;
    color: #fff;
}

.delete-link {
    color: red;
}
</style>

<body>
    <h1>Asignaturas</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Grado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id_asignatura']; ?></td>
                <td><?php echo $row['nombre_asignatura']; ?></td>
                <td><?php echo $row['nombre_grado']; ?></td>
                <td>
                    <a href="editar_asignatura.php?id=<?php echo $row['id_asignatura']; ?>">Editar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>