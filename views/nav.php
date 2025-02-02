<hr />
<nav class="navbar">
    <ul>
        <div class="left-menu">
        <?php
        // if (!isset($_SESSION)) session_start();

        // Mostrar enlace "Inicio" a la izquierda
        if (isset($_SESSION['adm'])) {
            echo "<li><a href='" . $_SERVER['PHP_SELF'] . "?action=adminAll' title='Inicio'><img src='img/home.svg' alt='Inicio'></a></li>";
        } else {
            echo "<li><a href='" . $_SERVER['PHP_SELF'] . "' title='Inicio'><img src='img/home.svg' alt='Inicio'></a></li>";
        }
        ?>
        </div>

        
    <div class="header-content">
    <h1 class="header-title">Biblioteca Virtual</h1>
    </div>

        
        <!-- Agrupamos los elementos de la derecha -->
        <div class="right-menu">
    <?php
    if (isset($_SESSION['iduser'])) {
        echo "<li><a href='" . $_SERVER['PHP_SELF'] . "?action=libroCart' title='Carrito'><img src='img/cart.svg' alt='Carrito'></a></li>";
        echo "<li><a href='" . $_SERVER['PHP_SELF'] . "?action=logOut' title='Cerrar sesión'><img src='img/logout.svg' alt='Cerrar sesión'></a></li>";
    } else {
        echo "<li><span class='invisible-space'></span></li>"; 
        echo "<li class='specialLi'><a href='" . $_SERVER['PHP_SELF'] . "?action=loginForm' title='Iniciar sesión'><img src='img/login.svg' alt='Iniciar sesión'></a></li>";
    }
    ?>
</div>

    </ul>
</nav>
<hr />
