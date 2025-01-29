<!--
extraer todo lo de vista. Vamos a hacer un modelo por cada entidad y una vista por cada caso de uso
¿y cada vista en una clase diferente?
Aqui no hacemos el fetch, sino que recibimos el array ya hecho ($libros)
-->

<h1>Listado de libros</h1>
<table border='1'>

    <?php


    // Cada libro ha de aparecer una sola vez

    echo "<h1>Biblioteca</h1>";

    echo "<form action='" . $_SERVER['PHP_SELF'] . "'>
    <input type='hidden' name='action' value='libroGet'>
    <input type='text' name='textoBusqueda'> 
    <input type='submit' value='Buscar'>
    </form>";

    // $actual = $data['libro_all'][0]; // Inicializamos con el primer idLibro
    $actual = -1; // Inicializamos con un valor que no coincida con ningún idLibro
    $autores = ""; // Inicializamos una cadena vacía

    $aux = $data['libro_all'][0];
    $campos = array_keys((get_object_vars($aux)));
    print_r($campos);

    foreach ($data['libro_all'] as $libro) {
        // Si encontramos un libro diferente al actual
        if ($libro->idLibro != $actual) {
            // Imprimir el libro anterior con todos sus autores, si ya tenemos datos acumulados
            if ($actual != -1) {
                echo "<tr>
                <td>" . $actual . "</td>
                <td>" . $titulo . "</td>
                <td>" . $genero . "</td>
                <td>" . $numPaginas . "</td>
                <td>" . $autores . "</td>
                <td>" . $pais . "</td> <!-- Mostrar pais -->
                <td>" . $ano . "</td> <!-- Mostrar ano -->";




                if (isset($_SESSION['adm'])) {
                    echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=libroPrestamo&idLibro=" . $actual . "'>Prestar</a></td>";
                    echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=libroForm&idLibro=" . $actual . "'>Modificar</a></td>
                <td><a href='" . $_SERVER['PHP_SELF'] . "?action=libroDelete&idLibro=" . $actual . "'>Borrar</a></td>
            </tr>";
                } else if (isset($_SESSION['iduser'])) {
                    echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=libroPrestamo&idLibro=" . $actual . "'>Prestar</a></td>";
                    echo "</tr>";
                } else {
                    echo "</tr>";
                }

                //la profe imprime primero el iduser , y luego el admin (en caso de que haya) 
            }

            // Actualizamos el libro actual y reiniciamos la lista de autores
            $actual = $libro->idLibro;
            $titulo = $libro->titulo;
            $genero = $libro->genero;
            $numPaginas = $libro->numPaginas;
            $pais = $libro->pais;  // Asignamos el pais
            $ano = $libro->ano;    // Asignamos el ano
            $autores = ""; // Reiniciamos la acumulación de autores
        }

        // Acumulamos los autores
        $autores .= $libro->apellido . ", " . $libro->nombre . "<br>";
    }

    // Imprimir el último libro
    if ($actual != -1) {
        echo "<tr>
                <td>" . $actual . "</td>
        <td>" . $titulo . "</td>
        <td>" . $genero . "</td>
        <td>" . $numPaginas . "</td>
        <td>" . $autores . "</td>
        <td>" . $pais . "</td> <!-- Mostrar pais -->
        <td>" . $ano . "</td> <!-- Mostrar ano -->";
        if (isset($_SESSION['adm'])) {
            echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=libroPrestamo&idLibro=" . $actual . "'>Prestar</a></td>";
            echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=libroForm&idLibro=" . $actual . "'>Modificar</a></td>
                <td><a href='" . $_SERVER['PHP_SELF'] . "?action=libroDelete&idLibro=" . $actual . "'>Borrar</a></td>
            </tr>";
        } else if (isset($_SESSION['iduser'])) {
            echo "<td><a href='" . $_SERVER['PHP_SELF'] . "?action=libroPrestamo&idLibro=" . $actual . "'>Prestar</a></td>";
            echo "</tr>";
        } else {
            echo "</tr>";
        }
    }



    ?>


</table>
<?php
if (isset($_SESSION['adm'])) {
    echo "<p><a href='" . $_SERVER['PHP_SELF'] . "?action=libroForm'>Nuevo</a></p>";
}
?>