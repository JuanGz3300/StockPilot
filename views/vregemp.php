<?php
// ===============================================
// Archivo: views/VRegEmp.php
// Objetivo: Formulario de registro de la empresa (Paso 2)
// ===============================================

$idusu_token = $_GET['idusu_token'] ?? null;
$error = $_GET['err'] ?? null;

if (empty($idusu_token)) {
    // Redirección si falta el token del usuario (proceso de registro incompleto)
    header("Location: home.php?pg=registro&err=session_error");
    exit;
}

// 🚨 CORRECCIÓN CLAVE: Inicializamos los valores a vacío ('') para el formulario.
$razemp_val = '';
$nomemp_val = '';
$nitemp_val = '';
$diremp_val = '';
$telemp_val = '';
$emaemp_val = '';

// Si tienes lógica en el controlador que repobla el formulario en caso de error 
// (usando un POST de vuelta), deberías implementar aquí la lógica para 
// recuperar los valores de $_POST si existieran. Por ahora, se mantiene vacío 
// como en tu versión original.
?>

<div class="inis-registro">
    <h2>Registro del Sistema</h2>
    <h3 class="step-title">Paso 2 de 2: Datos de la Empresa</h3>
    
    <?php if ($error) { ?>
        <div class="form-group col-md-12 derr mt-3">
            <i class="fa-solid fa-triangle-exclamation"></i> 
            <?php 
                if ($error == "campos_vacios") echo "Faltan campos obligatorios de la empresa por llenar. Debe reingresar todos los datos.";
                elseif ($error == "db_error_emp") echo "Error al registrar la empresa. Verifica que el **NIT/ID Tributario** no esté duplicado.";
                elseif ($error == "db_error_link") echo "La empresa se registró, pero falló la vinculación con el usuario. Contacte a soporte.";
                elseif ($error == "session_error") echo "Error de sesión. Por favor, vuelva a empezar el registro.";
                else echo "Ocurrió un error desconocido durante el proceso.";
            ?>
        </div>
    <?php } ?>
    
    <form name="frm_regemp" id="frm_regemp" action="controllers/CRegEmp.php" method="POST" enctype="multipart/form-data">
        
        <input type="hidden" name="idusu_token" value="<?php echo htmlspecialchars($idusu_token); ?>">

        <div class="row">
            
            <div class="form-group col-md-6">
                <label for="razemp"><i class="fa-solid fa-building"></i> Razón Social</label>
                <input type="text" name="razemp" id="razemp" class="form-control" 
                        value="<?php echo $razemp_val; ?>"
                        placeholder="Ej: Innovaciones Globales S.A.S." required>
            </div>
            
            <div class="form-group col-md-6">
                <label for="nomemp"><i class="fa-solid fa-store"></i> Nombre Comercial</label>
                <input type="text" name="nomemp" id="nomemp" class="form-control" 
                        value="<?php echo $nomemp_val; ?>"
                        placeholder="Ej: Sistema iGlob" required>
            </div>
            
            <div class="form-group col-md-4">
                <label for="nitemp"><i class="fa-solid fa-id-card-clip"></i> NIT / ID Tributario</label>
                <input type="text" name="nitemp" id="nitemp" class="form-control" 
                        value="<?php echo $nitemp_val; ?>"
                        placeholder="Sin puntos ni guiones (Ej: 9001234567)" required>
            </div>

            <div class="form-group col-md-4">
                <label for="emaemp"><i class="fa-solid fa-envelope"></i> Correo de la Empresa</label>
                <input type="email" name="emaemp" id="emaemp" class="form-control" 
                        value="<?php echo $emaemp_val; ?>"
                        placeholder="contacto@tuempresa.com" required>
            </div>

            <div class="form-group col-md-4">
                <label for="telemp"><i class="fa-solid fa-phone-volume"></i> Teléfono</label>
                <input type="tel" name="telemp" id="telemp" class="form-control" 
                        value="<?php echo $telemp_val; ?>"
                        placeholder="Ej: 604 444 5555">
            </div>

            <div class="form-group col-md-12">
                <label for="diremp"><i class="fa-solid fa-location-dot"></i> Dirección Física</label>
                <input type="text" name="diremp" id="diremp" class="form-control" 
                        value="<?php echo $diremp_val; ?>"
                        placeholder="Avenida 123 #45-67, Medellín" required>
            </div>
            
            <div class="form-group col-md-12">
                <label for="logoemp"><i class="fa-solid fa-image"></i> Logo de la Empresa (Opcional)</label>
                <input type="file" name="logoemp" id="logoemp" class="form-control" accept="image/png, image/jpeg, image/jpg">
                <small class="form-text text-muted">Archivos permitidos: JPG, PNG. Máximo 5MB.</small>
            </div>
            <div class="form-group col-md-12 mt-4">
                <button type="submit" class="btn btn-primary-custom btn-lg btn-block">
                    <i class="fa-solid fa-save"></i> Finalizar Registro de Empresa
                </button>
            </div>
            
        </div>
    </form>
</div>