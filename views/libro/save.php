
<div class="form-container">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get" class="styled-form">

        <?php
        if (isset($data['libroID'])) {
            echo '<h1 class="title">Modificación de Libros</h1>';
            $db = new mysqli("localhost", "root", "root", "books");

            $idLibro = $data['libroID'];
            $result = $db->query("SELECT * FROM libros WHERE libros.idLibro = '$idLibro'");
            $libro = $result->fetch_object();

            echo "
            <input type='hidden' name='idLibro' value='$idLibro'>

            <div class='form-group'>
                <label for='titulo'>Título:</label>
                <input type='text' name='titulo' id='titulo' value='$libro->titulo' required>
            </div>

            <div class='form-group'>
                <label for='genero'>Género:</label>
                <input type='text' name='genero' id='genero' value='$libro->genero' required>
            </div>

            <div class='form-group'>
                <label for='pais'>País:</label>
                <input type='text' name='pais' id='pais' value='$libro->pais' required>
            </div>

            <div class='form-group'>
                <label for='ano'>Año:</label>
                <input type='text' name='ano' id='ano' value='$libro->ano' required>
            </div>

            <div class='form-group'>
                <label for='numPaginas'>Número de páginas:</label>
                <input type='text' name='numPaginas' id='numPaginas' value='$libro->numPaginas' required>
            </div>

            <div class='form-group'>
                <label for='autor'>Autores:</label>
                <select name='autor[]' id='autor' multiple size='3' required>";

            $todosLosAutores = $db->query("SELECT * FROM personas");
            $autoresLibro = $db->query("SELECT idPersona FROM escriben WHERE idLibro = '$idLibro'");
            $listaAutoresLibro = [];
            while ($autor = $autoresLibro->fetch_object()) {
                $listaAutoresLibro[] = $autor->idPersona;
            }

            while ($fila = $todosLosAutores->fetch_object()) {
                if (in_array($fila->idPersona, $listaAutoresLibro))
                    echo "<option value='$fila->idPersona' selected>$fila->nombre $fila->apellido</option>";
                else
                    echo "<option value='$fila->idPersona'>$fila->nombre $fila->apellido</option>";
            }

            echo "
                </select>
                <a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "?action=personaForm' class='add-link'>Añadir nuevo</a>
            </div>

            <input type='hidden' name='action' value='libroModificar'>
            <button type='submit' class='btn'>Guardar cambios</button>";
        } else {
            echo '<h1 class="title">Inserción de Libros</h1>';

            echo "
            <div class='form-group'>
                <label for='titulo'>Título:</label>
                <input type='text' name='titulo' id='titulo' required>
            </div>

            <div class='form-group'>
                <label for='genero'>Género:</label>
                <input type='text' name='genero' id='genero' required>
            </div>

            <div class='form-group'>
                <label for='pais'>País:</label>
                <input type='text' name='pais' id='pais' required>
            </div>

            <div class='form-group'>
                <label for='ano'>Año:</label>
                <input type='text' name='ano' id='ano' required>
            </div>

            <div class='form-group'>
                <label for='numPaginas'>Número de páginas:</label>
                <input type='text' name='numPaginas' id='numPaginas' required>
            </div>

            <div class='form-group'>
                <label for='autor'>Autores:</label>
                <select name='autor[]' id='autor' multiple required>";
            foreach ($data['persona_all'] as $fila) {
                echo "<option value='" . $fila->idPersona . "'>" . $fila->nombre . " " . $fila->apellido . "</option>";
            }

            echo "
                </select>
                <a href='" . htmlspecialchars($_SERVER['PHP_SELF']) . "?action=personaForm' class='add-link'>Añadir nuevo</a>
            </div>

            <input type='hidden' name='action' value='libroSave'>
            <button type='submit' class='btn'>Crear libro</button>";
        }
        ?>

    </form>

    <p><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="back-link">Volver</a></p>
</div>
