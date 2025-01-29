<h1 class="title">Listado de libros</h1>

<div class="table-container">
    <?php
    echo "<h3 class='info-message'>";
    printf(MSSGS['maxbooks'], MAXBOOKS, MAXCART);
    echo "</h3>";

    $libros = $data['libro_cart']; // Primer libro

    // Obtener nombres de propiedades 
    $campos = get_object_vars($libros[0]);

    echo "<table class='styled-table'>";
    echo "<thead><tr>";
    foreach ($campos as $c => $v) {
        echo "<th>" . ucfirst($c) . "</th>";
    }
    echo "<th colspan='3'>Acciones</th>";
    echo "</tr></thead>";

    echo "<tbody>";
    foreach ($libros as $libro) {
        echo "<tr>";

        // Salto de línea entre autores
        $libro->autores = str_replace(";", "<br>", ucwords($libro->autores));

        foreach ($campos as $c => $v) {
            echo "<td>" . ($libro->$c) . "</td>";
        }

        // Generar acciones según el estado del libro
        if ($_SESSION['cart'][$libro->idLibro] === 0) {
            echo "<td>" . MSSGS['reserved'] . "</td>";
            if ($data['prestados'] == MAXBOOKS) {
                echo "<td>" . MSSGS['maxbooktd'] . "</td>";
                echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=libroCancelar&idLibro=" . $libro->idLibro . "' class='action-link'>Cancelar</a></td>";
            } else {
                echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=libroPrestar&idLibro=" . $libro->idLibro . "' class='action-link'>Confirmar</a></td>";
                echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=libroCancelar&idLibro=" . $libro->idLibro . "' class='action-link'>Cancelar</a></td>";
            }
        } else if ($_SESSION['cart'][$libro->idLibro] === 1) {
            echo "<td>" . MSSGS['borrowed'] . "</td>";
            echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=libroDevolver&idLibro=" . $libro->idLibro . "' class='action-link'>Devolver</a></td>";
            echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=libroRenovar&idLibro=" . $libro->idLibro . "' class='action-link'>Renovar</a></td>";
        }

        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    ?>
</div>
