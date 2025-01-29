<form method="GET" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="form-login">
    <div>
        <label for="email">Email:</label>
        <input class="email" type="text" id="email" name="user" placeholder="Introduce tu email">
    </div>
    <div>
        <label for="password">Clave:</label>
        <input class="pwd" type="password" id="password" name="pwd" placeholder="Introduce tu clave">
    </div>
    <div class="diventrar">
        <input type="submit" name="enviar" value="Entrar" class="btn">
        <input type="hidden" name="action" value="userValidate">
    </div>
</form>
