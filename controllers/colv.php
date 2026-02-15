<?php
// ----------------------------------------------------
// 1. INCLUSIONES
// ----------------------------------------------------
require_once ('../vendor/autoload.php'); 
require_once ('../models/conexion.php');
require_once ('../models/molv.php');
require_once ("cmail.php"); 

$molv = new Molv();

// ----------------------------------------------------
// 2. RECEPCIÓN Y CONFIGURACIÓN
// ----------------------------------------------------
$emausu = $_POST["emausu"] ?? NULL;
date_default_timezone_set('America/Bogota'); 

if ($emausu) {
    
    // 3. BUSCAR USUARIO POR CORREO
    $molv->setEmausu($emausu);
    $dtAll = $molv->getOneEma(); 
    
    if ($dtAll) {
        
        // 4. GENERAR TOKEN Y FECHA
        
        // 4.1. Generamos el token ALEATORIO (SIN HASHEAR) que va en el email
        $key_para_email = genPass(15); 
        
        // 4.2. Aplicamos el doble hash (sha1(md5())) solo para GUARDAR en la BD
        $key_para_bd = sha1(md5($key_para_email)); 
        
        $fecsol = date('Y-m-d H:i:s');
        
        // 5. ACTUALIZAR MODELO Y BD
        $molv->setFecsol($fecsol);
        $molv->setKeyolv($key_para_bd); // 👈 Guardamos el valor HASHEADO
        $molv->setIdusu($dtAll['idusu']); 
        
        // Ejecuta la actualización de keyolv y fecsol en la tabla usuario
        $molv->updUsu(); 
        
        // 6. PREPARAR Y ENVIAR CORREO
        $titu = "Cambiar clave de ingreso en StockPilot"; 
        
        // Genera el contenido HTML del correo con la clave SIN HASHEAR
        $mens = plaOlvCon($dtAll['nomusu'], $emausu, $key_para_email); 
        
        envmail($emausu, $titu, $mens); 
        
        // 7. MENSAJE DE ÉXITO
        echo "<script>alert('Revise el e-mail ". $emausu. " y siga los pasos para recordar su contraseña.');</script>";
        
    } else {
        // 8. MENSAJE DE ERROR (CORREO NO REGISTRADO)
        echo "<script>alert('Este e-mail no se encuentra registrado en nuestro sistema. Por favor verifíquelo nuevamente.');</script>";
    }
    
    // 9. REDIRECCIÓN FINAL
    echo "<script>window.location.href='../index.php';</script>"; 
}

// ----------------------------------------------------
// 10. FUNCIÓN PARA GENERAR EL TOKEN (genPass)
// ----------------------------------------------------
function genPass($len){
    $key = "";
    $pattern = "1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM"; 
    $max = strlen($pattern)-1;
    
    for($i=0; $i<$len; $i++){
        $key .= substr($pattern, mt_rand(0,$max), 1); 
    }
    
    // CORRECCIÓN: La función solo devuelve la clave aleatoria SIN hash.
    return $key;
}
?>