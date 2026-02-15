<div class="inis">
    <h2>🔒 Restablecer Contraseña</h2>
    
    <?php
    // 1. Recepción y validación inicial de datos
    $keyolv = $_POST['ko'] ?? NULL;
    $emausu_post = $_POST['m1'] ?? NULL; 
    
    // 2. Manejo de mensajes de error/éxito (desde el controlador crct.php)
    $msg = $_GET['msg'] ?? NULL;
    
    // 3. Verificación de existencia de token y email
    if (empty($keyolv) || empty($emausu_post)) {
        // Muestra este bloque si faltan token o email (ej. acceso directo o error en el POST)
    ?>
        <div class="form-group col-md-12 derr">
            <i class="fa-solid fa-triangle-exclamation"></i> Acceso denegado o enlace inválido.
        </div>
        <div class="forgot-password col-md-12">
            <a href="index.php?pg=olvido">Solicitar nuevo enlace</a>
        </div>
    <?php
    } else {
        // Muestra el formulario si los datos básicos (token y email) llegaron
    ?>
    
    <form name="frm_cambio_pas" id="frm_cambio_pas" action="controllers/crct.php" method="POST">
        <div class="row">
            
            <div class="form-group col-md-12">
                <label for="pas1"><i class="fa-solid fa-lock"></i> Nueva Contraseña</label>
                <input type="password" name="pas1" id="pas1" class="form-control" 
                       placeholder="Ingresa tu nueva contraseña" required>
            </div>
            
            <div class="form-group col-md-12">
                <label for="pas2"><i class="fa-solid fa-lock"></i> Repetir Contraseña</label>
                <input type="password" name="pas2" id="pas2" class="form-control" 
                       placeholder="Repite la nueva contraseña" required>
            </div>
            
            <input type="hidden" name="keyolv" value="<?php echo htmlspecialchars($keyolv); ?>">
            <input type="hidden" name="emausu" value="<?php echo htmlspecialchars($emausu_post); ?>">
            
            <?php 
            // 🚨 Manejo de todos los mensajes de error enviados por crct.php (GET)
            if ($msg == "match") {
            ?>
                <div class="form-group col-md-12 derr">
                    <i class="fa-solid fa-triangle-exclamation"></i> **¡Error!** Las contraseñas no coinciden.
                </div>
            <?php } elseif ($msg == "expired") { ?>
                <div class="form-group col-md-12 derr">
                    <i class="fa-solid fa-triangle-exclamation"></i> **Error de tiempo.** El enlace ha expirado (más de 24 horas).
                </div>
            <?php } elseif ($msg == "invalid" || $msg == "notfound") { ?>
                <div class="form-group col-md-12 derr">
                    <i class="fa-solid fa-triangle-exclamation"></i> **Enlace inválido.** El código de reseteo ya fue usado o no existe.
                </div>
                <div class="forgot-password col-md-12">
                    <a href="index.php?pg=olvido">Solicitar nuevo enlace</a>
                </div>
            <?php } elseif ($msg == "dberror") { ?>
                <div class="form-group col-md-12 derr">
                    <i class="fa-solid fa-triangle-exclamation"></i> **Error de sistema.** No se pudo actualizar tu contraseña. Intenta de nuevo.
                </div>
            <?php } ?>
            
            <div class="form-group col-md-12">
                <input type="submit" value="Cambiar Contraseña" class="form-control btn btn-primary">
            </div>
            
            <div class="forgot-password col-md-12">
                <a href="index.php">Volver a Iniciar Sesión</a>
            </div>
            
        </div>
    </form>
    
    <?php } // Cierre del else (si hay token y email) ?>
</div>