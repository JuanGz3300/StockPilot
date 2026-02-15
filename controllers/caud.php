<?php
require_once('models/maud.php');

$maud = new MAud();

$idaud = isset($_REQUEST['idaud']) ? $_REQUEST['idaud']:NULL;
$idusu = isset($_POST['idusu']) ? $_POST['idusu']:NULL;
$tabla = isset($_POST['tabla']) ? $_POST['tabla']:NULL;
$accion = isset($_POST['accion']) ? $_POST['accion']:NULL;
$idreg = isset($_POST['idreg']) ? $_POST['idreg']:NULL;
$datos_ant = isset($_POST['datos_ant']) ? $_POST['datos_ant']:NULL;
$datos_nue = isset($_POST['datos_nue']) ? $_POST['datos_nue']:NULL;
$fecha = isset($_POST['fecha']) ? $_POST['fecha']:NULL;
$ip = isset($_POST['ip']) ? $_POST['ip']:NULL;

$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope']:NULL;
$datOne = NULL;

// Obtener empresa de la sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$idemp_sesion = isset($_SESSION['idemp']) ? $_SESSION['idemp'] : null;

// DEBUG: Descomentar para ver qué valor tiene idemp_sesion
// echo "<pre>DEBUG - idemp_sesion: " . var_export($idemp_sesion, true) . "</pre>";
// echo "<pre>DEBUG - SESSION completa: " . var_export($_SESSION, true) . "</pre>";

$maud->setIdaud($idaud);
if($ope == "save"){
    $maud->setIdemp($idemp_sesion); // Agregar empresa de la sesión
    $maud->setIdusu($idusu);
    $maud->setTabla($tabla);
    $maud->setAccion($accion);
    $maud->setIdreg($idreg);
    $maud->setDatos_ant($datos_ant);
    $maud->setDatos_nue($datos_nue);
    $maud->setFecha($fecha);
    $maud->setIp($ip);
    if(!$idaud) $maud->save(); else $maud->edit();
}

if($ope == "clear_logins"){
    $maud->vaciarLogins($idemp_sesion);
    header("Location: ../home.php?pg=1010"); // Redirigir a la vista de auditoría (ajustar pg si es necesario)
    exit;
}

if($ope =="eli" && $idaud) $maud->del();
if($ope =="edi" && $idaud) $datOne = $maud->getOne();

// Filtrar auditoría por empresa
$datAll = $maud->getAll($idemp_sesion);
?>