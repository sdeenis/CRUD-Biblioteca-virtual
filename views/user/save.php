<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get" class="styled-form">
    <?php
    echo '<h1 class="title">Alta de Usuarios</h1>';
    echo "
    <label for='user'>Usuario:</label>"
    . "<input type='text' name='user' id='user' required>"
    . "<label for='pwd'>Contraseña:</label>"
    . "<input type='password' name='pwd' id='pwd' required>"
    . "<label for='dni'>DNI:</label>"
    . "<input type='text' name='dni' id='dni' required>"
    . "<label for='nombre'>Nombre:</label>"
    . "<input type='text' name='nombre' id='nombre' required>"
    . "<label for='apellido'>Apellido:</label>"
    . "<input type='text' name='apellido' id='apellido' required>"
    . "<label for='direccion'>Dirección:</label>"
    . "<input type='text' name='direccion' id='direccion' required>"
    . "<label for='cp'>Código Postal:</label>"
    . "<input type='text' name='cp' id='cp' required>"
    . "<label for='nivel'>Nivel:</label>"
    . "<select name='nivel' id='nivel' required>"
    . "<option value='0'>Cliente</option>"
    . "<option value='1'>Operador</option>"
    . "<option value='2'>Gestor</option>"
    . "<option value='3'>Administrador</option>"
    . "</select>"
    . "<input type='hidden' name='action' value='userSave'>"
    . "<input type='submit' value='Guardar'>";
    ?>
</form>
<p><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?action=userAll" class="back-link">Volver</a></p>
