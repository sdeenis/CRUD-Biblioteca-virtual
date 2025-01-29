<br>
<h1 class="page-title">Listado de libros</h1>

<!-- Formulario de búsqueda -->
<form class="search-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <input type="hidden" name="action" value="libroGet">
    <input type="text" name="textoBusqueda" placeholder="Buscar libros..." class="search-input">
    <input type="submit" value="Buscar" class="search-button">
</form>

<?php
// Si hay un mensaje relacionado con el carrito
if (isset($data['maxcart'])) {
    printf($data['maxcart'], $_SERVER['PHP_SELF']);
    echo "<br>";
}

// Mostrar los libros
$libros = $data['libro_all'];
$campos = get_object_vars($libros[0]); // Obtener nombres de propiedades de los libros

// Mostrar encabezado de la tabla
echo "<table class='books-table'>";
echo "<thead><tr>";
foreach ($campos as $c => $v) {
    echo "<th class='table-header'>$c</th>";
}

if (isset($_SESSION['adm'])) {
    echo "<th class='table-header' colspan='3'>Acciones</th>";
} else if (isset($_SESSION['iduser'])) {
    echo "<th class='table-header'>Acciones</th>";
}

echo "</tr></thead><tbody>";

// Recorremos y mostramos los libros
foreach ($libros as $libro) {
    echo "<tr>";

    // Formatear autores
    $libro->autores = str_replace(";", "<br>", ucwords($libro->autores));

    foreach ($campos as $c => $v) {
        echo "<td class='table-data'>" . ($libro->$c) . "</td>";
    }

    // Mostrar opciones dependiendo del estado del usuario y disponibilidad del libro
    if (isset($_SESSION['iduser'])) {
        echo "<td class='action-cell'>";
        if (isset($_SESSION['cart'][$libro->idLibro])) {
            if ($_SESSION['cart'][$libro->idLibro] === 0) {
                echo MSSGS['reserved'];
            } else if ($_SESSION['cart'][$libro->idLibro] === 1) {
                echo MSSGS['borrowed'];
            }
        } else if ($libro->disponibles > 0) {
            echo "<a href='" . $_SERVER['PHP_SELF'] . "?action=libroReservar&idLibro=" . $libro->idLibro . "' class='reserve-link'>" . MSSGS['reserve'] . "</a>";
        } else {
            echo MSSGS['unavailable'];
        }
        echo "</td>";
    }

    // Opciones de administración (si es admin)
    if (isset($_SESSION['adm'])) {
        echo "<td class='action-cell'><a href='" . $_SERVER['PHP_SELF'] . "?action=libroForm&idLibro=" . $libro->idLibro . "' class='edit-link'>Modificar</a></td>";
        echo "<td class='action-cell'><a href='" . $_SERVER['PHP_SELF'] . "?action=libroDelete&idLibro=" . $libro->idLibro . "' class='delete-link'>Borrar</a></td>";
    }

    echo "</tr>";
}

echo "</tbody></table>";

// Botón para añadir nuevo libro (si es admin)
if (isset($_SESSION['adm'])) {
    echo "<p class='add-book-p'><a href='" . $_SERVER['PHP_SELF'] . "?action=libroForm' class='add-book-link'>Nuevo libro</a></p>";
}
?>
