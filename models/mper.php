<?php

class Mper {
    private $idper;
    private $codper;
    private $nomper;
    private $nivel;
    private $fec_crea;
    private $fec_actu;
    private $act;

    // Getters
    function getIdper() {
        return $this->idper;
    }
    function getCodper() {
        return $this->codper;
    }
    function getNomper() {
        return $this->nomper;
    }
    function getNivel() {
        return $this->nivel;
    }
    function getFec_crea() {
        return $this->fec_crea;
    }
    function getFec_actu() {
        return $this->fec_actu;
    }
    function getAct() {
        return $this->act;
    }

    // Setters
    function setIdper($idper) {
        $this->idper = $idper;
    }
    function setCodper($codper) {
        $this->codper = $codper;
    }
    function setNomper($nomper) {
        $this->nomper = $nomper;
    }
    function setNivel($nivel) {
        $this->nivel = $nivel;
    }
    function setFec_crea($fec_crea) {
        $this->fec_crea = $fec_crea;
    }
    function setFec_actu($fec_actu) {
        $this->fec_actu = $fec_actu;
    }
    function setAct($act) {
        $this->act = $act;
    }

    // Obtener todos los registros
    public function getAll() {
        try {
            $sql = "SELECT idper, codper, nomper, nivel, fec_crea, fec_actu, act FROM perfil";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br><br>";
        }
    }

    // Obtener un registro por ID
    public function getOne() {
        try {
            $sql = "SELECT idper, codper, nomper, nivel, fec_crea, fec_actu, act 
                    FROM perfil WHERE idper = :idper";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idper = $this->getIdper();
            $result->bindParam(':idper', $idper);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br><br>";
        }
    }

    // Guardar un nuevo registro
    public function save() {
        try {
            $sql = "INSERT INTO perfil (codper, nomper, nivel, fec_crea, fec_actu, act) 
                    VALUES (:codper, :nomper, :nivel, :fec_crea, :fec_actu, :act)";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $codper = $this->getCodper();
            $nomper = $this->getNomper();
            $nivel = $this->getNivel();
            $fec_crea = $this->getFec_crea();
            $fec_actu = $this->getFec_actu();
            $act = $this->getAct();

            $result->bindParam(':codper', $codper);
            $result->bindParam(':nomper', $nomper);
            $result->bindParam(':nivel', $nivel);
            $result->bindParam(':fec_crea', $fec_crea);
            $result->bindParam(':fec_actu', $fec_actu);
            $result->bindParam(':act', $act);

            $result->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br><br>";
        }
    }

    // Editar un registro existente
    public function edit() {
        try {
            $sql = "UPDATE perfil 
                    SET codper = :codper, nomper = :nomper, nivel = :nivel, 
                        fec_crea = :fec_crea, fec_actu = :fec_actu, act = :act 
                    WHERE idper = :idper";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);

            $idper = $this->getIdper();
            $codper = $this->getCodper();
            $nomper = $this->getNomper();
            $nivel = $this->getNivel();
            $fec_crea = $this->getFec_crea();
            $fec_actu = $this->getFec_actu();
            $act = $this->getAct();

            $result->bindParam(':idper', $idper);
            $result->bindParam(':codper', $codper);
            $result->bindParam(':nomper', $nomper);
            $result->bindParam(':nivel', $nivel);
            $result->bindParam(':fec_crea', $fec_crea);
            $result->bindParam(':fec_actu', $fec_actu);
            $result->bindParam(':act', $act);

            $result->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br><br>";
        }
    }

    // Eliminar un registro
    public function del() {
        try {
            $sql = "DELETE FROM perfil WHERE idper = :idper";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idper = $this->getIdper();
            $result->bindParam(':idper', $idper);
            $result->execute();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "<br><br>";
        }
    }
}

?>
