<?php
class Mlote {
    // Atributos
    private $idlote;
    private $idprod;
    private $codlote;
    private $fecven;
    private $cant;
    private $fec_crea;
    private $fec_actu;

    // Getters
    function getIdlote(){ return $this->idlote; }
    function getIdprod(){ return $this->idprod; }
    function getCodlote(){ return $this->codlote; }
    function getFecven(){ return $this->fecven; }
    function getCant(){ return $this->cant; }
    function getFec_crea(){ return $this->fec_crea; }
    function getFec_actu(){ return $this->fec_actu; }

    // Setters
    function setIdlote($idlote){ $this->idlote = $idlote; }
    function setIdprod($idprod){ $this->idprod = $idprod; }
    function setCodlote($codlote){ $this->codlote = $codlote; }
    function setFecven($fecven){ $this->fecven = $fecven; }
    function setCant($cant){ $this->cant = $cant; }
    function setFec_crea($fec_crea){ $this->fec_crea = $fec_crea; }
    function setFec_actu($fec_actu){ $this->fec_actu = $fec_actu; }

    // Guardar nuevo
    function save(){
        $sql = "INSERT INTO lote (idprod, codlote, fecven, cant, fec_crea, fec_actu) 
                VALUES ('$this->idprod', '$this->codlote', '$this->fecven', '$this->cant', NOW(), NOW())";
        return mysqli_query($GLOBALS['cn'], $sql);
    }

    // Actualizar
    function upd(){
        $sql = "UPDATE lote SET 
                    idprod = '$this->idprod',
                    codlote = '$this->codlote',
                    fecven = '$this->fecven',
                    cant = '$this->cant',
                    fec_actu = NOW()
                WHERE idlote = '$this->idlote'";
        return mysqli_query($GLOBALS['cn'], $sql);
    }

    // Eliminar
    function del(){
        $sql = "DELETE FROM lote WHERE idlote = '$this->idlote'";
        return mysqli_query($GLOBALS['cn'], $sql);
    }

    // Obtener uno
    function getOne(){
        $sql = "SELECT * FROM lote WHERE idlote = '$this->idlote'";
        $res = mysqli_query($GLOBALS['cn'], $sql);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    // Obtener todos
    function getAll(){
        $sql = "SELECT * FROM lote ORDER BY idlote DESC";
        $res = mysqli_query($GLOBALS['cn'], $sql);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
}
?>
