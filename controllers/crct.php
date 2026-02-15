<?php
// ----------------------------------------------------
// 1. INCLUSIONES
// ----------------------------------------------------
require_once ('../models/conexion.php'); 
require_once ('../models/molv.php');
require_once ('../controllers/misfun.php');     

// ----------------------------------------------------
// 2. RECEPCIÓN DE DATOS DEL FORMULARIO vrct.php
// ----------------------------------------------------
// $ko es el token SIN hash que viene del formulario POST (keyolv del email)
$ko      = $_POST["keyolv"] ?? NULL;
$emausu  = $_POST["emausu"] ?? NULL;
$pas1    = $_POST["pas1"]      ?? NULL;
$pas2    = $_POST["pas2"]      ?? NULL;

// ----------------------------------------------------
// 3. FUNCIÓN DE HASH Y CONFIGURACIÓN
// ----------------------------------------------------
function hash_token($key) {
    // Función de doble hash (sha1(md5())) para buscar el token en la BD.
    return sha1(md5($key)); 
}

$molv = new Molv(); 
date_default_timezone_set('America/Bogota'); 

// ----------------------------------------------------
// 4. LÓGICA PRINCIPAL DE VALIDACIÓN Y CAMBIO
// ----------------------------------------------------
if ($ko AND $emausu) {
    
    // CRÍTICO: Hashear el token recibido antes de buscarlo en la BD
    $key_hasheado = hash_token($ko); 
    
    // 4.1. Establecer el token HASHEADO en el modelo
    $molv->setKeyolv($key_hasheado);
    $molv->setEmausu($emausu);
    
    $dtAll = $molv->getOneKey();
    
    if ($dtAll) { 
        $idusu_db = $dtAll['idusu'];
        $bloqkey_db = $dtAll['bloqkey'];
        $fecsol_db = $dtAll['fecsol']; 
        
        if ($bloqkey_db == 0) {
            $tiempo_limite_segundos = 24 * 60 * 60; 
            $tiempo_generacion = strtotime($fecsol_db);
            $tiempo_actual = time(); 
            
            if (($tiempo_actual - $tiempo_generacion) <= $tiempo_limite_segundos) {
                
                if ($pas1 === $pas2) {
                    
                    // ----------------------------------------------------------------
                    // ✅ CORRECCIÓN CRÍTICA: Usar la misma función de hashing que el login
                    $nueva_pas_hash = generar_hash_contrasena($pas1);
                    // ----------------------------------------------------------------
                    
                    $molv->setIdusu($idusu_db); 
                    $molv->setPasusu($nueva_pas_hash);
                    // CRÍTICO: Limpiar el token después de usarlo para evitar reutilización.
                    $molv->setKeyolv(NULL); 
                    
                    if ($molv->updPasusu()) { // Esta función debe anular 'keyolv' y 'fecsol'
                        echo "<script>alert('Tu contraseña ha sido restablecida con éxito. Ya puedes iniciar sesión.');</script>";
                        echo "<script>window.location.href='../index.php';</script>";
                    } else {
                        echo "<script>alert('Hubo un error al intentar cambiar tu contraseña. Por favor, inténtalo de nuevo.');</script>";
                        echo "<script>window.location.href='../index.php?pg=reset&msg=dberror';</script>";
                    }
                } else {
                    echo "<script>alert('Las contraseñas no coinciden. Por favor, verifica.');</script>";
                    echo "<script>window.location.href='../index.php?pg=reset&keyolv={$ko}&emausu={$emausu}&msg=match';</script>";
                }
            } else {
                echo "<script>alert('El enlace de restablecimiento ha expirado. Por favor, solicita uno nuevo.');</script>";
                echo "<script>window.location.href='../index.php?pg=reset&msg=expired';</script>";
            }
        } else {
            echo "<script>alert('Este enlace de restablecimiento ya ha sido utilizado o es inválido. Por favor, solicita uno nuevo.');</script>";
            echo "<script>window.location.href='../index.php?pg=reset&msg=invalid';</script>";
        }
    } else {
        echo "<script>alert('El enlace de restablecimiento es inválido o el usuario no existe.');</script>";
        echo "<script>window.location.href='../index.php?pg=reset&msg=notfound';</script>";
    }

} else {
    echo "<script>alert('Acceso no autorizado al cambio de contraseña.');</script>";
    echo "<script>window.location.href='../index.php';</script>"; 
}
?>