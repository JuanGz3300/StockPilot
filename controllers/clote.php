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
    function setIdlote($idlote){ return $this->idlote = $idlote; }
    function setIdprod($idprod){ return $this->idprod = $idprod; }
    function setCodlote($codlote){ return $this->codlote = $codlote; }
    function setFecven($fecven){ return $this->fecven = $fecven; }
    function setCant($cant){ return $this->cant = $cant; }
    function setFec_crea($fec_crea){ return $this->fec_crea = $fec_crea; }
    function setFec_actu($fec_actu){ return $this->fec_actu = $fec_actu; }

    // Obtener todos
    public function getAll(){
        try{
            $sql = "SELECT * FROM lote ORDER BY idlote DESC";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $res = $conexion->prepare($sql);
            $res->execute();
            return $res->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $e){
            men($e);
        }
    }

    // Obtener uno
    public function getOne(){
        try{
            $sql = "SELECT * FROM lote WHERE idlote=:idlote";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $res = $conexion->prepare($sql);
            $idlote = $this->getIdlote();
            $res->bindParam(":idlote", $idlote);
            $res->execute();
            return $res->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $e){
            men($e);
        }
    }

    // Guardar
    public function save(){
        try{
            $sql = "INSERT INTO lote(idlote, idprod, codlote, fecven, cant, fec_crea, fec_actu)
                    VALUES(:idlote, :idprod, :codlote, :fecven, :cant, :fec_crea, :fec_actu)";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $res = $conexion->prepare($sql);

            $idlote = $this->getIdlote();
            $res->bindParam(":idlote", $idlote);
            $idprod = $this->getIdprod();
            $res->bindParam(":idprod", $idprod);
            $codlote = $this->getCodlote();
            $res->bindParam(":codlote", $codlote);
            $fecven = $this->getFecven();
            $res->bindParam(":fecven", $fecven);
            $cant = $this->getCant();
            $res->bindParam(":cant", $cant);
            $fec_crea = $this->getFec_crea();
            $res->bindParam(":fec_crea", $fec_crea);
            $fec_actu = $this->getFec_actu();
            $res->bindParam(":fec_actu", $fec_actu);

            $res->execute();
            return $res->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $e){
            men($e);
        }
    }

    // Actualizar
    public function upd(){
        try{
            $sql = "UPDATE lote SET idprod=:idprod, codlote=:codlote, fecven=:fecven, cant=:cant, fec_actu=:fec_actu
                    WHERE idlote=:idlote";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $res = $conexion->prepare($sql);

            $idlote = $this->getIdlote();
            $res->bindParam(":idlote", $idlote);
            $idprod = $this->getIdprod();
            $res->bindParam(":idprod", $idprod);
            $codlote = $this->getCodlote();
            $res->bindParam(":codlote", $codlote);
            $fecven = $this->getFecven();
            $res->bindParam(":fecven", $fecven);
            $cant = $this->getCant();
            $res->bindParam(":cant", $cant);
            $fec_actu = $this->getFec_actu();
            $res->bindParam(":fec_actu", $fec_actu);

            $res->execute();
            men("upd");
        } catch(Exception $e){
            men($e);
        }
    }

    // Eliminar
    public function del(){
        try{
            $sql = "DELETE FROM lote WHERE idlote=:idlote";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $res = $conexion->prepare($sql);
            $idlote = $this->getIdlote();
            $res->bindParam(":idlote", $idlote);
            $res->execute();
            men("Eli");
        } catch(Exception $e){
            men($e);
        }
    }

}
?>
