<div class="inis">
    <h2>Inicio de Sesión</h2>
    <form name="frm1" action="models/control.php" method="POST">
        <div class="row">
            <div class="form-group col-md-12">
                <label for="usu"><i class="fa-solid fa-user"></i>Usuario</label>
                <input type="text" name="usu" id="usu" class="form-control" placeholder="Ingresa tu usuario" required>
            </div>
            <div class="form-group col-md-12">
                <label for="pas"><i class="fa-solid fa-key"></i>Contraseña</label>
                <input type="password" name="pas" id="pas" class="form-control" placeholder="Ingresa tu contraseña" required>
            </div>
            
            <?php 
            $err = isset($_GET['err']) ? $_GET['err'] : NULL;
            if($err == "ok"){
            ?>
            <div class="form-group col-md-12 derr">
                <i class="fa-solid fa-triangle-exclamation"></i> ¡Datos Incorrectos!
            </div>
            <?php } ?>
            
            <div class="form-group col-md-12">
                <input type="submit" value="Ingresar" class="form-control btn btn-primary">
            </div>
            
            <div class="forgot-password col-md-12">
                <a href="index.php?pg=olvido">¿Olvidaste tu contraseña?</a>
            </div>
            
            <div class="register-text col-md-12">
                <p>¿Aún no trabajas con nosotros? <a href="index.php?pg=registro" class="register-link">Regístrate</a></p>
            </div>
        </div>
    </form>
    
</div>