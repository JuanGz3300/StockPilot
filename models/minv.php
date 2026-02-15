<?php

class MInv{
    private $idinv;
    private $idemp;  // ✅ NUEVO
    private $idprod;
    private $idubi;
    private $cant;
    private $fec_crea;
    private $fec_actu;

    function getIdinv(){
        return $this->idinv;
    }
    function getIdemp(){
        return $this->idemp;
    }
    function getIdprod(){
        return $this->idprod;
    }
    function getIdubi(){
        return $this->idubi;
    }
    function getCant(){
        return $this->cant;
    }
    function getFec_crea(){
        return $this->fec_crea;
    }
    function getFec_actu(){
        return $this->fec_actu;
    }
    
    function setIdinv($idinv){
        $this->idinv = $idinv;
    }
    function setIdemp($idemp){
        $this->idemp = $idemp;
    }
    function setIdprod($idprod){
        $this->idprod = $idprod;
    }
    function setIdubi($idubi){
        $this->idubi = $idubi;
    }
    function setCant($cant){
        $this->cant = $cant;
    }
    function setFec_crea($fec_crea){
        $this->fec_crea = $fec_crea;
    }
    function setFec_actu($fec_actu){
        $this->fec_actu = $fec_actu;
    }

    // ✅ MODIFICADO: Filtra por empresa
    public function getAll(){
        try{
            $idper = isset($_SESSION['idper']) ? $_SESSION['idper'] : NULL;
            $idemp = isset($_SESSION['idemp']) ? $_SESSION['idemp'] : NULL;

            if($idper == 1){
                // SuperAdmin ve TODO
                $sql = "SELECT i.idinv, i.idemp, i.idprod, p.nomprod, p.codprod,
                               i.idubi, u.nomubi, u.codubi,
                               c.idcat, c.nomcat,
                               i.cant, i.fec_crea, i.fec_actu,
                               e.nomemp, e.razemp
                        FROM inventario i
                        INNER JOIN producto p ON i.idprod = p.idprod
                        INNER JOIN categoria c ON p.idcat = c.idcat
                        INNER JOIN ubicacion u ON i.idubi = u.idubi
                        LEFT JOIN empresa e ON i.idemp = e.idemp
                        ORDER BY i.idinv DESC";
                $modelo = new conexion();
                $conexion = $modelo->get_conexion();
                $result = $conexion->prepare($sql);
            } else {
                // Admin/Empleado: Solo ve su empresa
                $sql = "SELECT i.idinv, i.idemp, i.idprod, p.nomprod, p.codprod,
                               i.idubi, u.nomubi, u.codubi,
                               c.idcat, c.nomcat,
                               i.cant, i.fec_crea, i.fec_actu,
                               e.nomemp, e.razemp
                        FROM inventario i
                        INNER JOIN producto p ON i.idprod = p.idprod
                        INNER JOIN categoria c ON p.idcat = c.idcat
                        INNER JOIN ubicacion u ON i.idubi = u.idubi
                        LEFT JOIN empresa e ON i.idemp = e.idemp
                        WHERE i.idemp = :idemp
                        ORDER BY i.idinv DESC";
                $modelo = new conexion();
                $conexion = $modelo->get_conexion();
                $result = $conexion->prepare($sql);
                $result->bindParam(':idemp', $idemp);
            }
            
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br><br>";
        }
    }

    // ✅ MODIFICADO: Filtra por empresa
    public function getOne(){
        try{
            $idper = isset($_SESSION['idper']) ? $_SESSION['idper'] : NULL;
            $idemp = isset($_SESSION['idemp']) ? $_SESSION['idemp'] : NULL;

            if($idper == 1){
                $sql = "SELECT idinv, idemp, idprod, idubi, cant, fec_crea, fec_actu 
                        FROM inventario 
                        WHERE idinv=:idinv";
                $modelo = new conexion();
                $conexion = $modelo->get_conexion();
                $result = $conexion->prepare($sql);
                $idinv = $this->getIdinv();
                $result->bindParam(':idinv', $idinv);
            } else {
                $sql = "SELECT idinv, idemp, idprod, idubi, cant, fec_crea, fec_actu 
                        FROM inventario 
                        WHERE idinv=:idinv AND idemp=:idemp";
                $modelo = new conexion();
                $conexion = $modelo->get_conexion();
                $result = $conexion->prepare($sql);
                $idinv = $this->getIdinv();
                $result->bindParam(':idinv', $idinv);
                $result->bindParam(':idemp', $idemp);
            }
            
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br><br>";
        }
    }

    // ✅ MODIFICADO: Guarda con idemp
    public function save(){
        try{
            $sql = "INSERT INTO inventario(idemp, idprod, idubi, cant, fec_crea, fec_actu) 
                    VALUES (:idemp, :idprod, :idubi, :cant, :fec_crea, :fec_actu)";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            
            $idemp = $this->getIdemp();
            $result->bindParam(':idemp', $idemp);
            $idprod = $this->getIdprod();
            $result->bindParam(':idprod', $idprod);
            $idubi = $this->getIdubi();
            $result->bindParam(':idubi', $idubi);
            $cant = $this->getCant();
            $result->bindParam(':cant', $cant);
            $fec_crea = $this->getFec_crea();
            $result->bindParam(':fec_crea', $fec_crea);
            $fec_actu = $this->getFec_actu();
            $result->bindParam(':fec_actu', $fec_actu);
            
            $result->execute();
            return true;
        }catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br><br>";
            return false;
        }
    }

    // ✅ MODIFICADO: Solo edita de su empresa
    public function upd(){
        try{
            $idper = isset($_SESSION['idper']) ? $_SESSION['idper'] : NULL;
            $idemp_session = isset($_SESSION['idemp']) ? $_SESSION['idemp'] : NULL;

            if($idper == 1){
                $sql = "UPDATE inventario 
                        SET idemp=:idemp, idprod=:idprod, idubi=:idubi, cant=:cant, 
                            fec_crea=:fec_crea, fec_actu=:fec_actu 
                        WHERE idinv=:idinv";
            } else {
                $sql = "UPDATE inventario 
                        SET idprod=:idprod, idubi=:idubi, cant=:cant, 
                            fec_crea=:fec_crea, fec_actu=:fec_actu 
                        WHERE idinv=:idinv AND idemp=:idemp_session";
            }
            
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            
            $idinv = $this->getIdinv();
            $result->bindParam(':idinv', $idinv);
            
            if($idper == 1){
                $idemp = $this->getIdemp();
                $result->bindParam(':idemp', $idemp);
            } else {
                $result->bindParam(':idemp_session', $idemp_session);
            }
            
            $idprod = $this->getIdprod();
            $result->bindParam(':idprod', $idprod);
            $idubi = $this->getIdubi();
            $result->bindParam(':idubi', $idubi);
            $cant = $this->getCant();
            $result->bindParam(':cant', $cant);
            $fec_crea = $this->getFec_crea();
            $result->bindParam(':fec_crea', $fec_crea);
            $fec_actu = $this->getFec_actu();
            $result->bindParam(':fec_actu', $fec_actu);
            
            $result->execute();
            return true;
        }catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br><br>";
            return false;
        }
    }

    // ✅ MODIFICADO: Solo elimina de su empresa
    public function del(){
        try{
            $idper = isset($_SESSION['idper']) ? $_SESSION['idper'] : NULL;
            $idemp = isset($_SESSION['idemp']) ? $_SESSION['idemp'] : NULL;

            if($idper == 1){
                $sql = "DELETE FROM inventario WHERE idinv=:idinv";
                $modelo = new conexion();
                $conexion = $modelo->get_conexion();
                $result = $conexion->prepare($sql);
                $idinv = $this->getIdinv();
                $result->bindParam(':idinv', $idinv);
            } else {
                $sql = "DELETE FROM inventario WHERE idinv=:idinv AND idemp=:idemp";
                $modelo = new conexion();
                $conexion = $modelo->get_conexion();
                $result = $conexion->prepare($sql);
                $idinv = $this->getIdinv();
                $result->bindParam(':idinv', $idinv);
                $result->bindParam(':idemp', $idemp);
            }
            
            $result->execute();
            return true;
        }catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br><br>";
            return false;
        }
    }

    // ✅ NUEVO: Obtener productos de la empresa
    public function getAllProd(){
        try{
            $idper = isset($_SESSION['idper']) ? $_SESSION['idper'] : NULL;
            $idemp = isset($_SESSION['idemp']) ? $_SESSION['idemp'] : NULL;

            if($idper == 1){
                $sql = "SELECT p.idprod, p.nomprod, p.codprod, c.nomcat 
                        FROM producto p
                        INNER JOIN categoria c ON p.idcat = c.idcat
                        WHERE p.act = 1
                        ORDER BY p.nomprod ASC";
                $modelo = new conexion();
                $conexion = $modelo->get_conexion();
                $result = $conexion->prepare($sql);
            } else {
                $sql = "SELECT p.idprod, p.nomprod, p.codprod, c.nomcat 
                        FROM producto p
                        INNER JOIN categoria c ON p.idcat = c.idcat
                        WHERE p.idemp = :idemp AND p.act = 1
                        ORDER BY p.nomprod ASC";
                $modelo = new conexion();
                $conexion = $modelo->get_conexion();
                $result = $conexion->prepare($sql);
                $result->bindParam(':idemp', $idemp);
            }
            
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br><br>";
        }
    }

    // ✅ NUEVO: Obtener ubicaciones de la empresa
    public function getAllUbi(){
        try{
            $idper = isset($_SESSION['idper']) ? $_SESSION['idper'] : NULL;
            $idemp = isset($_SESSION['idemp']) ? $_SESSION['idemp'] : NULL;

            if($idper == 1){
                $sql = "SELECT idubi, nomubi, codubi 
                        FROM ubicacion
                        WHERE act = 1
                        ORDER BY nomubi ASC";
                $modelo = new conexion();
                $conexion = $modelo->get_conexion();
                $result = $conexion->prepare($sql);
            } else {
                $sql = "SELECT idubi, nomubi, codubi 
                        FROM ubicacion
                        WHERE idemp = :idemp AND act = 1
                        ORDER BY nomubi ASC";
                $modelo = new conexion();
                $conexion = $modelo->get_conexion();
                $result = $conexion->prepare($sql);
                $result->bindParam(':idemp', $idemp);
            }
            
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br><br>";
        }
    }

    // ✅ NUEVO: Obtener datos de la empresa para el PDF
    public function getEmpresa(){
        try{
            $idemp = isset($_SESSION['idemp']) ? $_SESSION['idemp'] : NULL;
            
            $sql = "SELECT idemp, nomemp, razemp, nitemp, diremp, telemp, emaemp, logo 
                    FROM empresa 
                    WHERE idemp = :idemp";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idemp', $idemp);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(Exception $e){
            echo "Error: ".$e->getMessage()."<br><br>";
        }
    }
}
?>
