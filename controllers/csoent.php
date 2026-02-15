<?php
require_once __DIR__ . '/../models/msoent.php';
require_once __DIR__ . '/../models/mprod.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$msoent = new Msoent();
$msoent->setIdemp($_SESSION['idemp']);

$idsol = isset($_GET['idsol']) ? $_GET['idsol'] : null;
$ope   = isset($_POST['ope']) ? $_POST['ope'] : null;

// Guardar producto
if ($ope == "save" && $idsol) {
    $idprod = isset($_POST['idprod']) ? $_POST['idprod'] : null;
    $cantdet = isset($_POST['cantdet']) ? $_POST['cantdet'] : null;
    $vundet = isset($_POST['vundet']) ? $_POST['vundet'] : null;
    
    if ($idprod && $cantdet && $vundet) {
        $data = [
            ":idsol"   => $idsol,
            ":idprod"  => $idprod,
            ":cantdet" => $cantdet,
            ":vundet"  => $vundet,
            ":idemp"   => $_SESSION['idemp']
        ];
        
        if ($msoent->save($data)) {
            $_SESSION['mensaje'] = "Se guardó correctamente";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Error al agregar el producto";
            $_SESSION['tipo_mensaje'] = "danger";
        }
    } else {
        $_SESSION['mensaje'] = "Por favor complete todos los campos";
        $_SESSION['tipo_mensaje'] = "warning";
    }
    
    session_write_close();
    header("Location: home.php?pg=1015&idsol=" . $idsol);
    exit();
}

// Eliminar detalle
if (isset($_GET['delete']) && $_GET['delete'] && $idsol) {
    $iddet = $_GET['delete'];
    if ($msoent->delete($iddet)) {
        $_SESSION['mensaje'] = "Producto eliminado exitosamente";
        $_SESSION['tipo_mensaje'] = "success";
    } else {
        $_SESSION['mensaje'] = "Error al eliminar el producto";
        $_SESSION['tipo_mensaje'] = "danger";
    }
    
    session_write_close();
    header("Location: home.php?pg=1015&idsol=" . $idsol);
    exit();
}

// Aprobar solicitud y crear movimientos en Kardex
if (isset($_GET['aprobar']) && $_GET['aprobar'] && $idsol) {
    // Obtener el Kardex activo (mes/año actual)
    require_once __DIR__ . '/../models/mkard.php';
    $mkard = new MKard();
    $mkard->setIdemp($_SESSION['idemp']);
    
    // Buscar Kardex del mes/año actual
    $anio = date('Y');
    $mes = date('n');
    $kardexActual = $mkard->getByPeriodo($anio, $mes);
    
    if (!$kardexActual) {
        $_SESSION['mensaje'] = "No existe un Kardex para el período actual. Por favor créelo primero.";
        $_SESSION['tipo_mensaje'] = "warning";
    } else {
        $idkar = $kardexActual['idkar'];
        
        // Obtener ubicación predeterminada
        require_once __DIR__ . '/../models/mubi.php';
        $mubi = new MUbi();
        $ubicaciones = $mubi->getAll($_SESSION['idemp']);
        
        if (empty($ubicaciones)) {
            $_SESSION['mensaje'] = "No hay ubicaciones registradas. Por favor cree una primero.";
            $_SESSION['tipo_mensaje'] = "warning";
        } else {
            $idubi = $ubicaciones[0]['idubi']; // Primera ubicación
            
            if ($msoent->aprobarSolicitud($idsol, $idkar, $idubi, $_SESSION['idusu'])) {
                $_SESSION['mensaje'] = "✅ Solicitud aprobada y movimientos creados en el Kardex exitosamente";
                $_SESSION['tipo_mensaje'] = "success";
            } else {
                $_SESSION['mensaje'] = "Error al aprobar la solicitud";
                $_SESSION['tipo_mensaje'] = "danger";
            }
        }
    }
    
    session_write_close();
    header("Location: home.php?pg=1015&idsol=" . $idsol);
    exit();
}

// Traer productos para el select
$mprod = new MProd();
$productos = $mprod->getAll($_SESSION['idemp'], $_SESSION['idper']);

// Traer detalles de la solicitud actual
$detalles = [];
if ($idsol) {
    $detalles = $msoent->getAll($idsol);
}
?>