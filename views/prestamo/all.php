<br>
<h1>Listado de préstamos</h1>

<?php

$prestamos = $data['prestamo_all'];
$campos = get_object_vars($prestamos[0]); // Obtener nombres de propiedades de los préstamos

// Mostrar encabezado de la tabla
echo "<table class='user-table'>";
echo "<tr>";
foreach ($campos as $c => $v) {
    echo "<th>$c</th>";
}
echo "</tr>";

// Recorremos y mostramos los préstamos
foreach ($prestamos as $prestamo) {
    echo "<tr>";
    echo "<td>" . $prestamo->idprestan . "</td>";
    echo "<td>" . $prestamo->iduser . "</td>";
    echo "<td>" . $prestamo->idlibro . "</td>";
    echo "<td>" . $prestamo->fechai . "</td>";
    echo "</tr>";
}

echo "</table>";
