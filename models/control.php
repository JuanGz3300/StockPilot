<?php
// ===============================================
// Archivo: controllers/CLogin.php (FINAL)
// Objetivo: Autenticación de usuario y creación de la sesión completa, 
//           incluyendo ID y Nombre de la Empresa.
// ===============================================

require_once('conexion.php');
require_once('../controllers/misfun.php'); // Asume que incluye generar_hash_contrasena()
require_once('maud.php'); // Incluir modelo de auditoría

$usu = isset($_POST['usu']) ? $_POST['usu'] : NULL; // Email o usuario
$pas = isset($_POST['pas']) ? $_POST['pas'] : NULL;

if ($usu && $pas) {
    validar($usu, $pas);
} else {
    echo '<script>window.location="../index.php";</script>';
}

function validar($usu, $pas) {
    // Llama a la función que trae los datos de usuario y empresa
    $res = verdat($usu, $pas);
    
    // Instanciar auditoría
    $maud = new MAud();
    $ip = $_SERVER['REMOTE_ADDR'];
    $navegador = $_SERVER['HTTP_USER_AGENT'];
    
    // Si la consulta devolvió resultados
    if ($res) {
        $usuario_data = $res[0];

        // 🎯 NUEVA VALIDACIÓN DE ESTADO 🎯
        // Si el usuario (u.act) está inactivo (0), se bloquea el acceso.
        if ($usuario_data['usu_act'] == 0) {
            // Registrar intento fallido (usuario inactivo)
            $maud->registrarLogin($usuario_data['idemp'] ?? NULL, $usuario_data['idusu'], $usu, 0, $ip, $navegador);
            echo '<script>window.location="../index.php?err=inactivo_usu";</script>';
            return;
        }

        // Si el usuario tiene una empresa asociada (idemp no es NULL o el perfil no es Superadmin)
        // y la empresa (e.act) está inactiva (0), se bloquea el acceso.
        // El Superadmin (idper=1) no debe ser bloqueado por el estado de la empresa.
        if ($usuario_data['idper'] != 1 && $usuario_data['emp_act'] == 0) {
            // Registrar intento fallido (empresa inactiva)
            $maud->registrarLogin($usuario_data['idemp'], $usuario_data['idusu'], $usu, 0, $ip, $navegador);
            echo '<script>window.location="../index.php?err=inactivo_emp";</script>';
            return;
        }

        session_start();
        
        // Crear variables de Sesión completas
        $_SESSION['idusu']      = $usuario_data['idusu'];
        $_SESSION['nomusu']     = $usuario_data['nomusu'];
        $_SESSION['apeusu']     = $usuario_data['apeusu'];
        $_SESSION['emausu']     = $usuario_data['emausu'];
        
        // Perfil
        $_SESSION['idper']      = $usuario_data['idper'];
        $_SESSION['nomper']     = $usuario_data['nomper'];
        
        // Empresa (Gracias al LEFT JOIN, estos pueden ser NULL si no hay vínculo)
        $_SESSION['idemp']      = $usuario_data['idemp'] ?? NULL; 
        $_SESSION['nomemp']     = $usuario_data['nomemp'] ?? NULL;
        
        // Bandera de autenticación
        $_SESSION['aut']        = "askjhd654-+"; 

        // Registrar login exitoso
        $maud->registrarLogin($_SESSION['idemp'], $_SESSION['idusu'], $usu, 1, $ip, $navegador);

        // Redirigir al home
        echo '<script>window.location="../home.php";</script>';
    } else {
        // Error de credenciales (usuario/contraseña incorrectos)
        // Registrar intento fallido
        $maud->registrarLogin(NULL, NULL, $usu, 0, $ip, $navegador);
        echo '<script>window.location="../index.php?err=ok";</script>';
    }
}

function verdat($usu, $con) {
    // Generar hash usando la función centralizada de misfun.php
    $pas = generar_hash_contrasena($con);

    // Consulta con LEFT JOIN para traer el ID y Nombre de la Empresa
    $sql = "SELECT u.idusu, u.nomusu, u.apeusu, u.emausu, u.pasusu, 
                   u.imgusu, u.idper, p.nomper, u.act AS usu_act,  -- 🔑 Agregado el estado del Usuario
                   e.idemp, e.nomemp, e.act AS emp_act             -- 🔑 Agregado el estado de la Empresa
             FROM usuario AS u
             INNER JOIN perfil AS p ON u.idper = p.idper
             LEFT JOIN usuario_empresa AS ue ON ue.idusu = u.idusu
             LEFT JOIN empresa AS e ON e.idemp = ue.idemp
             WHERE u.emausu = :emausu AND u.pasusu = :pasusu
             LIMIT 1";

    $modelo = new Conexion();
    $conexion = $modelo->get_conexion();
    $result = $conexion->prepare($sql);
    $result->bindParam(':emausu', $usu);
    $result->bindParam(':pasusu', $pas);
    $result->execute();
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
?>