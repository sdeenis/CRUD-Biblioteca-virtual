<nav class="admin-nav">
    <h1 class="admin-title">Panel de administración</h1>
    <?php
    echo "<a href='" . $_SERVER['PHP_SELF'] . "?action=libroAll' class='admin-link'>Gestión de Libros</a><br>";
    echo "<a href='" . $_SERVER['PHP_SELF'] . "?action=userAll' class='admin-link'>Gestión de usuarios</a><br>";
    echo "<a href='" . $_SERVER['PHP_SELF'] . "?action=prestamoAll' class='admin-link'>Consulta de préstamos</a><br>";
    ?>
</nav>
