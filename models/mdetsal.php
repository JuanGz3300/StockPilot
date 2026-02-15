<?php
class Mdetsal {
    // Atributos
    private $iddet;
    private $idemp;
    private $idsol;
    private $idprod;
    private $cantdet;
    private $vundet;
    private $fec_crea;
    private $fec_actu;

    // Getters
    function getIddet(){ return $this->iddet; }
    function getIdemp(){ return $this->idemp; }
    function getIdsol(){ return $this->idsol; }
    function getIdprod(){ return $this->idprod; }
    function getCantdet(){ return $this->cantdet; }
    function getVundet(){ return $this->vundet; }
    function getFec_crea(){ return $this->fec_crea; }
    function getFec_actu(){ return $this->fec_actu; }

    // Setters
    function setIddet($iddet){ $this->iddet = $iddet; }
    function setIdemp($idemp){ $this->idemp = $idemp; }
    function setIdsol($idsol){ $this->idsol = $idsol; }
    function setIdprod($idprod){ $this->idprod = $idprod; }
    function setCantdet($cantdet){ $this->cantdet = $cantdet; }
    function setVundet($vundet){ $this->vundet = $vundet; }
    function setFec_crea($fec_crea){ $this->fec_crea = $fec_crea; }
    function setFec_actu($fec_actu){ $this->fec_actu = $fec_actu; }

    // Obtener todos por solicitud
    public function getAll(){
        try{
            $sql = "SELECT d.*, p.nomprod 
                    FROM detsalida d
                    INNER JOIN producto p ON d.idprod = p.idprod
                    WHERE d.idsol = :idsol";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $res = $conexion->prepare($sql);
            $idsol = $this->getIdsol();
            $res->bindParam(":idsol", $idsol);
            $res->execute();
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            men($e);
        }
    }

    // Obtener uno
    public function getOne(){
        try{
            $sql = "SELECT * FROM detsalida WHERE iddet=:iddet";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $res = $conexion->prepare($sql);
            $iddet = $this->getIddet();
            $res->bindParam(":iddet", $iddet);
            $res->execute();
            return $res->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            men($e);
        }
    }

    // Guardar
    public function save(){
        try{
            $sql = "INSERT INTO detsalida (idemp, idsol, idprod, cantdet, vundet, fec_crea, fec_actu)
                    VALUES(:idemp, :idsol, :idprod, :cantdet, :vundet, :fec_crea, :fec_actu)";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $res = $conexion->prepare($sql);

            $res->bindParam(":idemp", $this->idemp);
            $res->bindParam(":idsol", $this->idsol);
            $res->bindParam(":idprod", $this->idprod);
            $res->bindParam(":cantdet", $this->cantdet);
            $res->bindParam(":vundet", $this->vundet);
            $res->bindParam(":fec_crea", $this->fec_crea);
            $res->bindParam(":fec_actu", $this->fec_actu);

            $res->execute();
            men("save");
        }catch(Exception $e){
            men($e);
        }
    }

    // Actualizar
    public function upd(){
        try{
            $sql = "UPDATE detsalida 
                    SET idemp=:idemp, idsol=:idsol, idprod=:idprod, cantdet=:cantdet, 
                        vundet=:vundet, fec_actu=:fec_actu 
                    WHERE iddet=:iddet";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $res = $conexion->prepare($sql);

            $res->bindParam(":iddet", $this->iddet);
            $res->bindParam(":idemp", $this->idemp);
            $res->bindParam(":idsol", $this->idsol);
            $res->bindParam(":idprod", $this->idprod);
            $res->bindParam(":cantdet", $this->cantdet);
            $res->bindParam(":vundet", $this->vundet);
            $res->bindParam(":fec_actu", $this->fec_actu);

            $res->execute();
            men("upd");
        }catch(Exception $e){
            men($e);
        }
    }

    // Eliminar
    public function del(){
        try{
            $sql = "DELETE FROM detsalida WHERE iddet=:iddet";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $res = $conexion->prepare($sql);
            $iddet = $this->getIddet();
            $res->bindParam(":iddet", $iddet);
            $res->execute();
            men("del");
        }catch(Exception $e){
            men($e);
        }
    }
}
?>
