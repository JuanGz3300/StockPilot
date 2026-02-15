<?php
// ===============================================
// Archivo: controllers/CRegEmp.php (CORREGIDO)
// Objetivo: Procesar el registro de la empresa y la vinculación Usuario-Empresa (Paso 2)
// ===============================================

// 🚨 PASO 1: Iniciar la sesión para poder guardar los datos de login y autenticar al usuario
if (session_status() == PHP_SESSION_NONE) { 
    session_start(); 
}

require_once('../models/memp.php'); 
// 🚨 NECESARIO: Incluir la conexión para poder consultar los datos del usuario recién creado
require_once('../models/conexion.php'); 

$pg = 'regemp'; // Vista de error de registro de empresa

/**
 * Función auxiliar para obtener el nombre, apellido y nombre de perfil del usuario.
 * Se agrega u.idper para usarlo en la sesión.
 * @param int $idusu ID del usuario.
 * @return array|bool Arreglo asociativo con los detalles o false si falla.
 */
function fetchUserDetails($idusu) {
    // 🔑 CORRECCIÓN: Se incluye u.idper en el SELECT
    $sql = "SELECT u.nomusu, u.apeusu, p.nomper, u.idper 
            FROM usuario AS u
            INNER JOIN perfil AS p ON u.idper = p.idper
            WHERE u.idusu = :idusu
            LIMIT 1";

    $modelo = new Conexion();
    $conexion = $modelo->get_conexion();
    $result = $conexion->prepare($sql);
    $result->bindParam(':idusu', $idusu, PDO::PARAM_INT);
    $result->execute();
    return $result->fetch(PDO::FETCH_ASSOC); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $memp = new Memp();

    // 1. Recepción de datos del POST
    $nomemp     = $_POST['nomemp'] ?? NULL;
    $razemp     = $_POST['razemp'] ?? NULL;
    $nitemp     = $_POST['nitemp'] ?? NULL;
    $diremp     = $_POST['diremp'] ?? NULL;
    $telemp     = $_POST['telemp'] ?? NULL;
    $emaemp     = $_POST['emaemp'] ?? NULL;
    
    // 🚨 INICIO: Lógica para SUBIR EL LOGO (CORREGIDA)
    // Inicializar con el valor por defecto. Se mantiene si no hay subida exitosa.
    $logo_nombre_final = 'logo.png'; 
    $target_dir = "img/logos/";  

    // 1. Verificar si hubo subida de archivo y si fue exitosa (Error code 0)
    // UPLOAD_ERR_NO_FILE (código 4) significa que el usuario no seleccionó archivo.
    // Si el error es 4, o si ni siquiera existe la clave 'logoemp', simplemente se 
    // mantiene $logo_nombre_final = 'default.png'.
    if (isset($_FILES['logoemp']) && $_FILES['logoemp']['error'] === UPLOAD_ERR_OK) {
        
        $file_name = $_FILES['logoemp']['name'];
        $file_tmp_name = $_FILES['logoemp']['tmp_name'];
        $file_size = $_FILES['logoemp']['size'];
        
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_exts = array("jpg", "jpeg", "png");

        // 2. Validación de archivo (tipo y tamaño - Máx 5MB)
        if (in_array($file_ext, $allowed_exts) && $file_size <= 5000000) {
            
            // 3. Generar nombre de archivo único
            $new_file_name = uniqid('logo_', true) . '.' . $file_ext;
            $target_file = $target_dir . $new_file_name;

            // 4. Mover el archivo subido del temporal a la carpeta de destino
            if (move_uploaded_file($file_tmp_name, $target_file)) {
                $logo_nombre_final = $new_file_name; // Sobrescribe 'default.png' con el nombre único.
            } else {
                // Opcional: Manejar error de movimiento (ej: problema de permisos)
                // Si falla, se mantiene 'default.png'
                // Podrías agregar una redirección de error si quieres notificar al usuario.
                error_log("Fallo al mover archivo subido: " . $file_name);
            }
        } else {
            // Opcional: Manejar error de validación (ej: extensión no permitida)
            // Si falla, se mantiene 'default.png'
            error_log("Archivo no válido: " . $file_name);
        }
    }
    // 🚨 FIN: Lógica para SUBIR EL LOGO
    // Nota: Si el usuario no subió un archivo, $_FILES['logoemp']['error'] será 4 (UPLOAD_ERR_NO_FILE),
    // por lo tanto, la condición inicial `$_FILES['logoemp']['error'] === UPLOAD_ERR_OK` no se cumple,
    // y `$logo_nombre_final` mantiene su valor inicial: `'default.png'`. Esto soluciona el problema.

    // 2. Obtener el ID del usuario del campo oculto 
    $idusu_token = $_POST['idusu_token'] ?? NULL;
    $idusu_crea = (int) $idusu_token; 

    // 3. Validaciones de campos
    if (empty($nomemp) || empty($razemp) || empty($nitemp) || empty($diremp) || empty($emaemp) || $idusu_crea <= 0) {
        // Redirigir a INDEX.PHP para mostrar el error 
        header("Location: ../index.php?pg=$pg&idusu_token=$idusu_token&err=campos_vacios");
        exit;
    }

    // 4. Asignar valores al Modelo (Memp.php)
    $memp->setNomemp($nomemp);
    $memp->setRazemp($razemp);
    $memp->setNitemp($nitemp);
    $memp->setDiremp($diremp);
    $memp->setTelemp($telemp);
    $memp->setEmaemp($emaemp);
    $memp->setLogo($logo_nombre_final); // 🔑 ASIGNACIÓN FINAL DEL NOMBRE DEL LOGO (default.png o el nuevo)
    $memp->setIdusu($idusu_crea); // ID del usuario creador 
    
    // Valores por defecto
    $memp->setAct(1);       // Activo
    $memp->setEstado(1);    // Estado (asumo 1 = OK)
    $fec_crea = date('Y-m-d H:i:s');
    $memp->setFec_crea($fec_crea);
    $memp->setFec_actu($fec_crea);

    // 5. Guardar la empresa
    $id_nueva_empresa = $memp->insertNewEmpresa(); 

    if ($id_nueva_empresa > 0) {
        
        // 6. VINCULAR USUARIO - EMPRESA
        if ($memp->linkUsuEmp($idusu_crea, $id_nueva_empresa)) {
            
            // ÉXITO: CREACIÓN DE LA SESIÓN DE LOGIN AUTOMÁTICO
            $user_details = fetchUserDetails($idusu_crea); 

            // 🚨 AJUSTE DE SESIÓN CRÍTICO 1/3: Regenerar el ID de sesión para seguridad.
            session_regenerate_id(true); 

            // Asignamos las variables de sesión
            $_SESSION['idusu'] = $idusu_crea;
            $_SESSION['idemp'] = $id_nueva_empresa;
            
            // Asignar el ID de perfil real que tiene el usuario en la BD
            // 🔑 CORREGIDO: Ahora usamos el idper de los detalles del usuario, si existe.
            $idper_creador = $user_details['idper'] ?? 2; 
            $_SESSION['idper'] = $idper_creador; 
            
            // 🚨 AJUSTES NUEVOS: ASIGNAR DATOS DE PERFIL NECESARIOS PARA vpf.php
            if ($user_details) {
                $_SESSION['nomusu'] = $user_details['nomusu']; 
                $_SESSION['apeusu'] = $user_details['apeusu']; 
                $_SESSION['nomper'] = $user_details['nomper']; 
            } else {
                // Fallback de seguridad si la consulta falló
                $_SESSION['nomusu'] = 'Usuario';
                $_SESSION['apeusu'] = 'Nuevo';
                $_SESSION['nomper'] = 'Administrador'; // Fallback
            }
            
            // 🚨 AJUSTE DE SESIÓN CRÍTICO 2/3: USAR 'aut' para que coincida con models/seg.php
            $_SESSION['aut'] = "askjhd654-+"; 
            
            // 🚨 AJUSTE DE SESIÓN CRÍTICO 3/3: Forzar el guardado y cierre de la sesión
            session_write_close();
            
            // Éxito: Redirigir a HOME.PHP
            header("Location: ../home.php"); 
            exit;
            
        } else {
            // Error en la vinculación 
            header("Location: ../index.php?pg=$pg&idusu_token=$idusu_token&err=db_error_link");
            exit;
        }
        
    } else {
        // Error al guardar la empresa
        header("Location: ../index.php?pg=$pg&idusu_token=$idusu_token&err=db_error_emp");
        exit;
    }
    
} else {
    // Si acceden directamente sin POST
    header("Location: ../index.php?pg=registro");
    exit;
}