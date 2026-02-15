<?php
require_once('models/mper.php');
$mper = new Mper();
$idper = isset($_REQUEST['idper']) ? $_REQUEST['idper'] : NULL;
$nomper = isset($_POST['nomper']) ? $_POST['nomper'] : NULL;
$desper = isset($_POST['desper']) ? $_POST['desper'] : NULL;
$fec_crea = isset($_POST['fec_crea']) ? $_POST['fec_crea'] : NULL;
$fec_actu = isset($_POST['fec_actu']) ? $_POST['fec_actu'] : NULL;
$act = isset($_POST['act']) ? $_POST['act'] : NULL;
$ope = isset($_REQUEST['ope']) ? $_REQUEST['ope'] : NULL;
$datOne = NULL;

$mper->setIdper($idper);
if ($ope == "save") {
    $mper->setNomper($nomper);
    $mper->setDesper($desper);
    $mper->setFec_crea($fec_crea);
    $mper->setFec_actu($fec_actu);
    $mper->setAct($act);
    if (!$idper) $mper->save(); else $mper->edit();
}
if ($ope == "eli" && $idper) $mper->del();
if ($ope == "edi" && $idper) $datOne = $mper->getOne();
$datAll = $mper->getAll();
?>
