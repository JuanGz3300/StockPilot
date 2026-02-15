<?php
require_once __DIR__ . '/conexion.php';

class Msoent {
    private $idemp;

    function setIdemp($idemp){ 
        $this->idemp = $idemp; 
    }
    
    function getIdemp(){ 
        return $this->idemp; 
    }

    // Obtener todos los detalles de entrada
    public function getAll($idsol) {
        try {
            // Usamos LEFT JOIN para mostrar el registro aunque el producto no exista
            // Usamos COALESCE para manejar valores nulos si el producto fue borrado
            $sql = "SELECT d.iddet, d.idsol, d.idprod, COALESCE(p.nomprod, 'Producto no encontrado') as nomprod, 
                           d.cantdet, d.vundet, (d.cantdet * d.vundet) as totdet
                    FROM detentrada d
                    LEFT JOIN producto p ON d.idprod = p.idprod
                    WHERE d.idsol = :idsol AND d.idemp = :idemp
                    ORDER BY d.iddet DESC";
            
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(":idsol", $idsol, PDO::PARAM_INT);
            $stmt->bindParam(":idemp", $this->idemp, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en Msoent::getAll() - " . $e->getMessage());
            return [];
        }
    }

    // Guardar detalle
    public function save($data) {
        try {
            $sql = "INSERT INTO detentrada (idsol, idprod, cantdet, vundet, idemp, fec_crea)
                    VALUES (:idsol, :idprod, :cantdet, :vundet, :idemp, NOW())";
            
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $stmt = $conexion->prepare($sql);
            
            if(isset($data[':totdet'])) unset($data[':totdet']);
            
            $result = $stmt->execute($data);
            
            if (!$result) {
                throw new Exception("Error al guardar el detalle");
            }
            
            return true;
        } catch (PDOException $e) {
            error_log("Error en Msoent::save() - " . $e->getMessage());
            return false;
        }
    }

    // Eliminar detalle
    public function delete($iddet) {
        try {
            $sql = "DELETE FROM detentrada WHERE iddet = :iddet AND idemp = :idemp";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(":iddet", $iddet, PDO::PARAM_INT);
            $stmt->bindParam(":idemp", $this->idemp, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error en Msoent::delete() - " . $e->getMessage());
            return false;
        }
    }

    // Obtener total de la solicitud
    public function getTotal($idsol) {
        try {
            $sql = "SELECT SUM(cantdet * vundet) as total FROM detentrada 
                    WHERE idsol = :idsol AND idemp = :idemp";
            
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(":idsol", $idsol, PDO::PARAM_INT);
            $stmt->bindParam(":idemp", $this->idemp, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            error_log("Error en Msoent::getTotal() - " . $e->getMessage());
            return 0;
        }
    }

    // Aprobar solicitud y crear movimientos en Kardex
    public function aprobarSolicitud($idsol, $idkar, $idubi, $idusu) {
        try {
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $conexion->beginTransaction();
            
            $detalles = $this->getAll($idsol);
            
            if (empty($detalles)) {
                throw new Exception("No hay detalles para aprobar");
            }
            
            foreach ($detalles as $detalle) {
                $sqlMov = "INSERT INTO movim (idkar, idprod, idubi, idusu, idemp, tipmov, cantmov, valmov, fecmov, fec_crea)
                          VALUES (:idkar, :idprod, :idubi, :idusu, :idemp, 1, :cantmov, :valmov, NOW(), NOW())";
                
                $stmtMov = $conexion->prepare($sqlMov);
                $stmtMov->execute([
                    ':idkar' => $idkar,
                    ':idprod' => $detalle['idprod'],
                    ':idubi' => $idubi,
                    ':idusu' => $idusu,
                    ':idemp' => $this->idemp,
                    ':cantmov' => $detalle['cantdet'],
                    ':valmov' => $detalle['vundet']
                ]);
            }
            
            $conexion->commit();
            return true;
            
        } catch (Exception $e) {
            if (isset($conexion)) {
                $conexion->rollBack();
            }
            error_log("Error en Msoent::aprobarSolicitud() - " . $e->getMessage());
            return false;
        }
    }
}
?>