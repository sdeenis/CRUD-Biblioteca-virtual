<h1>Listado de libros</h1>
<?php
echo "<form action='" . $_SERVER['PHP_SELF'] . "'>
        <input type='hidden' name='action' value='libroGet'>
        <input type='text' name='textoBusqueda'> 
        <input type='submit' value='Buscar'>
    </form>";
    ?>

    <h3> <?php echo $data; ?> </h3>