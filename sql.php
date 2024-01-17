<?php 
    include_once("config.php");
    conectarBaseDeDatos();
    function sqlQuerySelect($sql) {
        global $conn;
            $resultado = $conn->query($sql);
        if ($resultado) {
            return $resultado;
        } else {
            echo "Error en la consulta: " . $conn->error;
            return false;
        }
    }   

    function sqlInsertUpdate($sql) {
        global $conn; // Suponiendo que $conn es tu variable de conexión global
    
        if ($conn->query($sql) === TRUE) {
            return true; // La consulta se ejecutó con éxito
        } else {
            return false; // Hubo un error en la ejecución de la consulta
        }
    }

    function sqlQueryDelete($sql){
        global $conn;
        if ($conn->query($sql) === TRUE) {
            return true; // Eliminación exitosa
        } else {
            return false; // Error en la eliminación
        }
    }

    function limpiarDatos($dato) {
        global $conn;
        if (is_numeric($dato)) {
            // Escapar la cadena para prevenir inyección SQL
            $dato = $conn->real_escape_string($dato);
            return $dato;
        } else {
            return false; // Datos no válidos
        }
    }

    function xmlInsertarDatos($tabla, $idCampos, $valores) {
        if (count($idCampos) !== count($valores)) {
            return false;
        }
    
        $idCamposArray = json_decode(json_encode($idCampos), true);
        $valoresArray = json_decode(json_encode($valores), true);
    
        foreach ($valoresArray as &$valor) {
            if (is_array($valor)) {
                $valor = "''";
            } else {
                $valor = "'" . $valor . "'";
            }
        }
    
        $sql = "INSERT INTO " . $tabla . " (";
        $sql .= implode(", ", $idCamposArray);
        $sql .= ") VALUES (";
        $sql .= implode(", ", $valoresArray);
        $sql .= ")";
    
        // Pasa el SQL a la función sqlQuery
        $sqlQuery = sqlInsertUpdate($sql);
    
        if ($sqlQuery > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    
    
    function xmlActualizarDatos($tabla, $idCampos, $valores, $condicion) {
        if (count($idCampos) !== count($valores)) {
            return false;
        }
        $idCamposArray = json_decode(json_encode($idCampos), true);
        $valoresArray = json_decode(json_encode($valores), true);
        foreach ($valoresArray as &$valor) {
            if (is_array($valor)) {
                $valor = "";
            }
        }
    
        $updatePairs = array();
        for ($i = 0; $i < count($idCamposArray); $i++) {
            $updatePairs[] = $idCamposArray[$i] . "='" . $valoresArray[$i] . "'";
        }
    
        $sql = "UPDATE " . $tabla . " SET " . implode(", ", $updatePairs) . " WHERE " . $condicion;
    
        // Pasa el SQL y los parámetros a la función sqlQuery
        $sqlQuery = sqlInsertUpdate($sql);
        if($sqlQuery){
            return true;
        }else{
            return false;
        }
    }    
?>