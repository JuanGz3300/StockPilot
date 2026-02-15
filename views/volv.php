<div class="inis">
    <h2>¿Olvidó su Contraseña?</h2>
    <form name="frm_olvido" id="frm_olvido" action="controllers/colv.php" method="POST">
        <div class="row">
            
            <div class="form-group col-md-12">
                <label for="emausu"><i class="fa-solid fa-envelope"></i> Correo Electrónico</label>
                <input type="email" name="emausu" id="emausu" class="form-control" 
                       placeholder="Ingresa tu correo registrado" required>
                </div>
            
            <?php 
            $msg = $_GET['msg'] ?? null;
            if ($msg == "ok") {
            ?>
            <div class="form-group col-md-12 dsucc">
                <i class="fa-solid fa-circle-check"></i> Enlace enviado. ¡Revisa tu bandeja de entrada!
            </div>
            <?php } elseif ($msg == "err") { ?>
            <div class="form-group col-md-12 derr">
                <i class="fa-solid fa-triangle-exclamation"></i> El correo no está registrado o hubo un error.
            </div>
            <?php } ?>
            
            <div class="form-group col-md-12">
                <input type="submit" value="Enviar Enlace de Recuperación" class="form-control btn btn-primary">
            </div>
            
            <div class="forgot-password col-md-12">
                <a href="index.php">Volver a Iniciar Sesión</a>
            </div>
            
        </div>
    </form>
    
    </div>