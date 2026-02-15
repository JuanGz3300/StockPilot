<?php
require_once __DIR__ . '/../models/msosal.php';
require_once __DIR__ . '/../models/mprod.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$msosal = new Msosal();
$msosal->setIdemp($_SESSION['idemp']); // empresa activa

$idsol = isset($_GET['idsol']) ? $_GET['idsol'] : null;
$ope   = isset($_POST['ope']) ? $_POST['ope'] : null;

// Guardar
if ($ope == "save") {
    $idprod = $_POST['idprod'];
    $cantdet = $_POST['cantdet'];
    $vundet = $_POST['vundet'];
    
    // Verificar stock disponible
    if ($msosal->verificarStockDisponible($idprod, $cantdet)) {
        $data = [
            ":idsol"   => $_POST['idsol'],
            ":idprod"  => $idprod,
            ":cantdet" => $cantdet,
            ":vundet"  => $vundet,
            ":totdet"  => ($cantdet * $vundet),
            ":idemp"   => $_SESSION['idemp']
        ];
        
        if ($msosal->save($data)) {
            $_SESSION['mensaje'] = "Producto agregado exitosamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al agregar el producto";
            $_SESSION['tipo_mensaje'] = "danger";
        }
    } else {
        $_SESSION['mensaje'] = "Stock insuficiente para realizar la salida";
        $_SESSION['tipo_mensaje'] = "warning";
    }
    
    // Redireccionar para evitar resubmisión del formulario
    header("Location: dashboard.php?pg=2070&idsol=" . $idsol);
    exit();
}

// Eliminar detalle
if (isset($_GET['delete']) && $_GET['delete']) {
    $iddet = $_GET['delete'];
    if ($msosal->delete($iddet)) {
        $_SESSION['mensaje'] = "Producto eliminado exitosamente";
        $_SESSION['tipo_mensaje'] = "success";
    } else {
        $_SESSION['mensaje'] = "Error al eliminar el producto";
        $_SESSION['tipo_mensaje'] = "danger";
    }
    
    header("Location: dashboard.php?pg=2070&idsol=" . $idsol);
    exit();
}

// Traer productos para el select (solo con stock disponible)
$mprod = new MProd();
$productos = $mprod->getAll(); // Puedes filtrar solo productos con stock > 0

// Traer detalles de la solicitud actual
$detalles = [];
if ($idsol) {
    $detalles = $msosal->getAll($idsol);
}
?>