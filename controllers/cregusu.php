<?php
// ===============================================
// Archivo: controllers/CRegUsu.php
// Objetivo: Procesar la solicitud de registro de usuario (Paso 1)
// 
// Flujo CORREGIDO: Guarda el usuario y redirige al Paso 2 (Registro de Empresa) 
// en index.php, sin iniciar sesión todavía.
// ===============================================

// NO se inicia sesión aquí, ya que el registro no ha terminado.

// CORRECCIÓN DE RUTA: Se incluye la conexión desde models/
require_once('../models/conexion.php'); 

// 1. Incluir el Modelo de Usuario (Musu.php)
require_once('../models/musu.php'); 

// 2. Incluir el archivo de funciones (donde está generar_hash_contrasena)
require_once('misfun.php'); 

// Redireccionamiento base en caso de error
$pg = 'registro'; // La vista de registro de usuario en index.php

// Solo procesar si la solicitud es por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Instanciar el Modelo de Usuario
    $muser = new Musu();

    // Recibir datos del POST
    $nomusu     = $_POST['nomusu'] ?? NULL;
    $apeusu     = $_POST['apeusu'] ?? NULL;
    $tdousu     = $_POST['tdousu'] ?? NULL;
    $ndousu     = $_POST['ndousu'] ?? NULL;
    $celusu     = $_POST['celusu'] ?? NULL;
    $emausu     = $_POST['emausu'] ?? NULL;
    $pasusu     = $_POST['pasusu'] ?? NULL; 
    $pasusu2    = $_POST['pasusu2'] ?? NULL; 
    
    // Valores por defecto
    $idper      = 2; // Perfil de Usuario Estándar (Inicial)
    $act        = 1; // Estado Activo
    $fec_crea   = date('Y-m-d H:i:s');
    $fec_actu   = date('Y-m-d H:i:s');
    
    // =====================================
    //          VALIDACIONES INICIALES
    // =====================================

    // 1. Validar campos vacíos
    if (empty($nomusu) || empty($emausu) || empty($pasusu) || empty($pasusu2) || empty($tdousu) || empty($ndousu)) {
        // Redirección a index.php
        header("Location: ../index.php?pg=$pg&err=campos_vacios");
        exit;
    }

    // 2. Validar que las contraseñas coincidan
    if ($pasusu !== $pasusu2) {
        // Redirección a index.php
        header("Location: ../index.php?pg=$pg&err=pass_mismatch");
        exit;
    }
    
    // 3. Hashear la contraseña (Llamando a la función de misfun.php)
    $pas_hash = generar_hash_contrasena($pasusu); 

    // 4. Asignar los valores para verificación de duplicados
    $muser->setEmausu($emausu);
    $muser->setNdousu($ndousu); 

    // 5. Verificar si el usuario ya existe (Modelo Musu.php)
    $existe = $muser->checkIfExists(); 

    if ($existe) {
        // Redirección a index.php
        header("Location: ../index.php?pg=$pg&err=user_exists");
        exit;
    }

    // 6. Asignar el resto de valores al Modelo para guardar
    $muser->setNomusu($nomusu);
    $muser->setApeusu($apeusu);
    $muser->setTdousu($tdousu);
    $muser->setNdousu($ndousu); // Aseguramos que se guarda el documento
    $muser->setCelusu($celusu);
    $muser->setPasusu($pas_hash); // Usamos el hash
    $muser->setIdper($idper);     
    $muser->setAct($act);
    $muser->setFec_crea($fec_crea);
    $muser->setFec_actu($fec_actu);

    // 7. Guardar el usuario y capturar el ID
    $id_nuevo_usuario = $muser->save(); 

    if ($id_nuevo_usuario) {
        
        $id_para_url = $id_nuevo_usuario; 
        
        // Éxito: Redirigir a la vista de Registro de EMPRESA (Paso 2) en index.php
        // Pasamos el ID del usuario recién creado como token para el siguiente paso
        header("Location: ../index.php?pg=regemp&idusu_token=$id_para_url"); 
        exit;
        
    } else {
        // Error al guardar en la DB
        header("Location: ../index.php?pg=$pg&err=db_error");
        exit;
    }
    
} else {
    // Si la solicitud no es por POST, redirigir al formulario
    header("Location: ../index.php?pg=$pg");
    exit;
}
?>