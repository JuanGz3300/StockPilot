<?php


class MAud{
    private $idaud;
    private $idemp;
    private $idusu;
    private $tabla;
    private $accion;
    private $idreg;
    private $datos_ant;
    private $datos_nue;
    private $email;
    private $exitoso;
    private $navegador;
    private $fecha;
    private $ip;

    function getIdaud(){
        return $this->idaud;
    }
    function getIdemp(){
        return $this->idemp;
    }
    function getIdusu(){
        return $this->idusu;
    }
    function getTabla(){
        return $this->tabla;
    }
    function getAccion(){
        return $this->accion;
    }
    function getIdreg(){
        return $this->idreg;
    }
    function getDatos_ant(){
        return $this->datos_ant;
    }
    function getDatos_nue(){
        return $this->datos_nue;
    }
    function getFecha(){
        return $this->fecha;
    }
    function getIp(){
        return $this->ip;
    }
    function setIdaud($idaud){
        $this->idaud = $idaud;
    }
    function setIdemp($idemp){
        $this->idemp = $idemp;
    }
    function setIdusu($idusu){
        $this->idusu = $idusu;
    }
    function setTabla($tabla){
        $this->tabla = $tabla;
    }
    function setAccion($accion){
        $this->accion = $accion;
    }
    function setIdreg($idreg){
        $this->idreg = $idreg;
    }
    function setDatos_ant($datos_ant){
        $this->datos_ant = $datos_ant;
    }
    function setDatos_nue($datos_nue){
        $this->datos_nue = $datos_nue;
    }
    function setFecha($fecha){
        $this->fecha = $fecha;
    }
    function setIp($ip){
        $this->ip = $ip;
    }
    function getEmail(){
        return $this->email;
    }
    function setEmail($email){
        $this->email = $email;
    }
    function getExitoso(){
        return $this->exitoso;
    }
    function setExitoso($exitoso){
        $this->exitoso = $exitoso;
    }
    function getNavegador(){
        return $this->navegador;
    }
    function setNavegador($navegador){
        $this->navegador = $navegador;
    }

    public function getAll($idemp = null){
        try{
            if($idemp){
                $sql = "SELECT idaud, idemp, idusu, tabla, accion, idreg, datos_ant, datos_nue, email, exitoso, navegador, fecha, ip 
                        FROM auditoria 
                        WHERE idemp = :idemp AND (accion IS NULL OR accion NOT IN (4, 5))
                        ORDER BY fecha DESC";
            }else{
                $sql = "SELECT idaud, idemp, idusu, tabla, accion, idreg, datos_ant, datos_nue, email, exitoso, navegador, fecha, ip 
                        FROM auditoria 
                        WHERE (accion IS NULL OR accion NOT IN (4, 5))
                        ORDER BY fecha DESC";
            }
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            if($idemp){
                $result->bindParam(':idemp', $idemp);
            }
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(Exception $e){
            echo "Error".$e."<br><br>";
        }
    }

    public function getOne(){
        try{
            $sql = "SELECT idaud, idusu, tabla, accion, idreg, datos_ant, datos_nue, fecha, ip FROM auditoria WHERE idaud=:idaud";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idaud = $this->getIdaud();
            $result->bindParam(':idaud', $idaud);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(Exception $e){
            echo "Error".$e."<br><br>";
        }
    }

    public function save(){
        try{
            $log = "MAud::save called at " . date('Y-m-d H:i:s') . "\n";
            $log .= "Data: " . json_encode([
                'idemp' => $this->idemp,
                'idusu' => $this->idusu,
                'tabla' => $this->tabla,
                'accion' => $this->accion,
                'idreg' => $this->idreg
            ]) . "\n";
            file_put_contents(__DIR__ . '/../debug_log.txt', $log, FILE_APPEND);

            $sql = "INSERT INTO auditoria(idemp, idusu, tabla, accion, idreg, datos_ant, datos_nue, fecha, ip) VALUES (:idemp, :idusu, :tabla, :accion, :idreg, :datos_ant, :datos_nue, :fecha, :ip) ";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idemp = $this->getIdemp();
            $result->bindParam(':idemp', $idemp);
            $idusu = $this->getIdusu();
            $result->bindParam(':idusu', $idusu);
            $tabla = $this->getTabla();
            $result->bindParam(':tabla', $tabla);
            $accion = $this->getAccion();
            $result->bindParam(':accion', $accion);
            $idreg = $this->getIdreg();
            $result->bindParam(':idreg', $idreg);
            $datos_ant = $this->getDatos_ant();
            $result->bindParam(':datos_ant', $datos_ant);
            $datos_nue = $this->getDatos_nue();
            $result->bindParam(':datos_nue', $datos_nue);
            $fecha = $this->getFecha();
            $result->bindParam(':fecha', $fecha);
            $ip = $this->getIp();
            $result->bindParam(':ip', $ip);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(Exception $e){
            $log = "MAud::save ERROR: " . $e->getMessage() . "\n";
            file_put_contents(__DIR__ . '/../debug_log.txt', $log, FILE_APPEND);
            echo "Error".$e."<br><br>";
        }
    }

    public function edit(){
        try{
            $sql = "UPDATE auditoria SET idusu=:idusu, tabla=:tabla, accion=:accion, idreg=:idreg, datos_ant=:datos_ant, datos_nue=:datos_nue, fecha=:fecha, ip=:ip WHERE idaud=:idaud";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idaud = $this->getIdaud();
            $result->bindParam(':idaud', $idaud);
            $idusu = $this->getIdusu();
            $result->bindParam(':idusu', $idusu);
            $tabla = $this->getTabla();
            $result->bindParam(':tabla', $tabla);
            $accion = $this->getAccion();
            $result->bindParam(':accion', $accion);
            $idreg = $this->getIdreg();
            $result->bindParam(':idreg', $idreg);
            $datos_ant = $this->getDatos_ant();
            $result->bindParam(':datos_ant', $datos_ant);
            $datos_nue = $this->getDatos_nue();
            $result->bindParam(':datos_nue', $datos_nue);
            $fecha = $this->getFecha();
            $result->bindParam(':fecha', $fecha);
            $ip = $this->getIp();
            $result->bindParam(':ip', $ip);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(Exception $e){
            echo "Error".$e."<br><br>";
        }
    }

    public function del(){
        try{
            $sql = "DELETE FROM auditoria WHERE idaud=:idaud";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $idaud = $this->getIdaud();
            $result->bindParam(':idaud', $idaud);
            $result->execute();
            $res = $result->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }catch(Exception $e){
            echo "Error".$e."<br><br>";
        }
    }

    // Método para registrar logins en tabla auditoria
    public function registrarLogin($idemp, $idusu, $email, $exitoso, $ip, $navegador){
        try{
            $sql = "INSERT INTO auditoria(idemp, idusu, tabla, accion, email, exitoso, ip, navegador, fecha) 
                    VALUES (:idemp, :idusu, 'login', 4, :email, :exitoso, :ip, :navegador, NOW())";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idemp', $idemp);
            $result->bindParam(':idusu', $idusu);
            $result->bindParam(':email', $email);
            $result->bindParam(':exitoso', $exitoso);
            $result->bindParam(':ip', $ip);
            $result->bindParam(':navegador', $navegador);
            $result->execute();
        }catch(Exception $e){
            echo "Error".$e."<br><br>";
        }
    }

    // Método para registrar logouts en tabla auditoria
    public function registrarLogout($idemp, $idusu, $email, $ip, $navegador){
        try{
            $sql = "INSERT INTO auditoria(idemp, idusu, tabla, accion, email, exitoso, ip, navegador, fecha) 
                    VALUES (:idemp, :idusu, 'login', 6, :email, 1, :ip, :navegador, NOW())";
            $modelo = new Conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idemp', $idemp);
            $result->bindParam(':idusu', $idusu);
            $result->bindParam(':email', $email);
            $result->bindParam(':ip', $ip);
            $result->bindParam(':navegador', $navegador);
            $result->execute();
        }catch(Exception $e){
            echo "Error".$e."<br><br>";
        }
    }

    // Método para obtener logins de una empresa
    public function getLogins($idemp, $idusu = null){
        try{
            $sql = "SELECT a.idaud, a.idemp, a.idusu, a.email, a.exitoso, a.ip, a.navegador, a.fecha, a.accion,
                           COALESCE(u.nomusu, 'Desconocido') as nomusu, 
                           COALESCE(u.apeusu, '') as apeusu
                    FROM auditoria a
                    LEFT JOIN usuario u ON a.idusu = u.idusu
                    WHERE a.idemp = :idemp AND a.accion IN (4, 6)";
            
            if(!empty($idusu)){
                $sql .= " AND a.idusu = :idusu";
            }
            
            $sql .= " ORDER BY a.fecha DESC";
            
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idemp', $idemp);
            
            if(!empty($idusu)){
                $result->bindParam(':idusu', $idusu);
            }
            
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error".$e."<br><br>";
            return [];
        }
    }

    // Método para obtener movimientos de inventario de una empresa
    public function getMovimientos($idemp, $idusu = null){
        try{
            $sql = "SELECT a.idaud, a.idemp, a.idusu, a.idreg, a.datos_nue, a.datos_ant, a.fecha, a.ip, a.accion,
                           u.nomusu, u.apeusu,
                           p.nomprod
                    FROM auditoria a
                    LEFT JOIN usuario u ON a.idusu = u.idusu
                    LEFT JOIN movim m ON a.idreg = m.idmov
                    LEFT JOIN producto p ON m.idprod = p.idprod
                    WHERE a.idemp = :idemp AND (a.accion = 5 OR (a.tabla = 'movim' AND a.accion IN (1,2,3)))";
            
            if($idusu){
                $sql .= " AND a.idusu = :idusu";
            }
            
            $sql .= " ORDER BY a.fecha DESC";
            
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idemp', $idemp);
            
            if($idusu){
                $result->bindParam(':idusu', $idusu);
            }
            
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error".$e."<br><br>";
            return [];
        }
    }



    // Método para obtener todos los usuarios de la empresa
    public function getUsuariosEmpresa($idemp){
        try{
            $sql = "SELECT DISTINCT u.idusu, u.nomusu, u.apeusu, u.emausu
                    FROM usuario u
                    INNER JOIN usuario_empresa ue ON u.idusu = ue.idusu
                    WHERE ue.idemp = :idemp
                    ORDER BY u.nomusu, u.apeusu";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idemp', $idemp);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            echo "Error".$e."<br><br>";
            return [];
        }
    }

    // Método para vaciar el historial de logins de una empresa
    public function vaciarLogins($idemp){
        try{
            $sql = "DELETE FROM auditoria WHERE idemp = :idemp AND accion IN (4, 6)";
            $modelo = new conexion();
            $conexion = $modelo->get_conexion();
            $result = $conexion->prepare($sql);
            $result->bindParam(':idemp', $idemp);
            $result->execute();
        }catch(Exception $e){
            echo "Error".$e."<br><br>";
        }
    }
}
?>