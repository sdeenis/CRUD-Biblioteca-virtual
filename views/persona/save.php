
<form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='get' class="styled-form">
    <h1 class="styled-form-title">Introduce los datos</h1>
    <div class="form-group">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" name="nombre" class="form-input" id="nombre">
    </div>
    <div class="form-group">
        <label for="apellido" class="form-label">Apellido:</label>
        <input type="text" name="apellido" class="form-input" id="apellido">
    </div>
    <div class="form-group">
        <label for="pais" class="form-label">Pais:</label>
        <input type="text" name="pais" class="form-input" id="pais">
    </div>
    <input type='hidden' name='action' value='personaSave'>
    <input type='submit' class="btn-submit">
</form>
<p><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="btn-back">Volver</a></p>
