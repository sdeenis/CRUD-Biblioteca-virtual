<br>
<h1>Listado de préstamos</h1>

<?php

$prestamos = $data['prestamo_all'];
$campos = get_object_vars($prestamos[0]); // Obtener nombres de propiedades de los préstamos

// Mostrar encabezado de la tabla
echo "<table class='user-table'>";
echo "<tr>";

    echo "<th>idPréstamo</th>";
    echo "<th>idUsuario</th>";
    echo "<th>Usuario</th>";
    echo "<th>idLibro</th>";
    echo "<th>Libro</th>";
    echo "<th>Fecha inicio</th>";

echo "</tr>";



// Recorremos y mostramos los préstamos
foreach ($prestamos as $prestamo) {
    echo "<tr>";
    echo "<td>" . $prestamo->idprestan . "</td>";
    echo "<td>" . $prestamo->iduser . "</td>";

    $db = new mysqli('localhost', 'root', 'root', 'books');
    $q = "SELECT user from users where iduser = $prestamo->iduser";
    $res = $db->execute_query($q)->fetch_object();

    echo "<td>" . $res->user . "</td>";

    echo "<td>" . $prestamo->idlibro . "</td>";

    $db = new mysqli('localhost', 'root', 'root', 'books');
    $q = "SELECT titulo from libros where idlibro = $prestamo->idlibro";
    $res = $db->execute_query($q)->fetch_object();

    echo "<td>" . $res->titulo . "</td>";

    echo "<td>" . $prestamo->fechai . "</td>";
    echo "</tr>";
}

echo "</table>";
