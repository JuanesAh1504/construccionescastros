<?php 
    include_once('config.php');
    include_once("sql.php");
    include_once("functions.php");
    global $conn;
    conectarBaseDeDatos();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch($_POST['accion']){
            case 'S-CampoUsuario':
                cerrarConexion($conn);
            break;
            case 'S-CotizacionesContabilidad':
                $sql = "SELECT documentoId, alcanceObra FROM cotizacion WHERE estado = '1'";
                $resultado = sqlQuerySelect($sql);
                $options = "";
                if ($resultado->num_rows > 0) {
                    $options = "<option value=''></option>";
                    while ($row = $resultado->fetch_assoc()) {
                        if($row['alcanceObra'] != ''){
                            $options .= "<option value='" . $row["documentoId"] . "'>" . $row["documentoId"] . " - " . $row["alcanceObra"] . "</option>";
                        }
                    }
                }
                echo $options;
            break;
            case 'obtenerInfoCotizacionContabilidad':
                $cotizacionID = $_POST["cotizacionID"];
                $sql = "SELECT c.*, ct.* FROM cotizacion c INNER JOIN contratosgenerados ct ON ct.numerocontrato = " . $cotizacionID . " WHERE c.documentoId = " . $cotizacionID;
                $result = sqlQuerySelect($sql);
                $xmlResponse = new SimpleXMLElement('<cotizacionDetails></cotizacionDetails>');

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if($row['material'] == ''){
                            $detalle = $xmlResponse->addChild('detalle');
                            $idCotizacion = $xmlResponse->addChild('idCotizacion', $row["documentoId"]);
                            $fechaCotizacion = $xmlResponse->addChild('fechaCotizacion', $row["fechaCotizacion"]);
                            $alcanceObra = $xmlResponse->addChild('alcanceObra', $row["alcanceObra"]);
                            $porcentaje1 = $xmlResponse->addChild('porcentaje1', empty($row['Porcentaje1']) ? 0 : $row['Porcentaje1']);
                            $valorPago1 = $xmlResponse->addChild('valorPago1', empty($row['valorPago1']) ? 0 : $row['valorPago1']);
                            $porcentaje2 = $xmlResponse->addChild('porcentaje2', empty($row['Porcentaje2']) ? 0 : $row['Porcentaje2']);
                            $valorPago2 = $xmlResponse->addChild('valorPago2', empty($row['valorPago2']) ? 0 : $row['valorPago2']);
                            $porcentaje3 = $xmlResponse->addChild('porcentaje3', empty($row['Porcentaje3']) ? 0 : $row['Porcentaje3']);
                            $valorPago3 = $xmlResponse->addChild('valorPago3', empty($row['valorPago3']) ? 0 : $row['valorPago3']);
                            $porcentaje4 = $xmlResponse->addChild('porcentaje4', empty($row['Porcentaje4']) ? 0 : $row['Porcentaje4']);
                            $valorPago4 = $xmlResponse->addChild('valorPago4', empty($row['valorPago4']) ? 0 : $row['valorPago4']);                            
                            $manoObra = $xmlResponse->addChild('manoObra', $row['manoObra']);
                            $porcentajeAdmin = $xmlResponse->addChild('porcentajeAdmin', $row['porcentajeAdmin']);
                            $porcentajeUtilidad = $xmlResponse->addChild('porcentajeUtilidad', $row['porcentajeUtilidad']);
                            $alquilerEquipos = $xmlResponse->addChild('alquilerEquipos', $row['alquilerEquipos']);
                            $transporte = $xmlResponse->addChild('transporte', $row['transporte']);
                            $elementosProteccion = $xmlResponse->addChild('elementosProteccion', $row['elementosProteccion']);
                            $Dotacion = $xmlResponse->addChild('Dotacion', $row['Dotacion']);
                            
                        }  
                    }
                }
                header('Content-Type: text/xml');
                echo $xmlResponse->asXML();
            break;
            case 'detallesContratos':
                $contrato = $_POST["contrato"];
                $sql = "SELECT documentoId, alcanceObra, material, valorTotalCotizacion, Porcentaje1, Porcentaje2, Porcentaje3, Porcentaje4 FROM cotizacion WHERE documentoId = '".$contrato."'";
                $result = sqlQuerySelect($sql);
                $xmlRespuesta = new SimpleXMLElement('<contrato></contrato>');
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if($row['material'] == ''){ 
                            $documentoId = $xmlRespuesta->addChild('documentoId', $row["documentoId"]);
                            $alcanceObra = $xmlRespuesta->addChild('alcanceObra', $row["alcanceObra"]);
                            $valorTotalCotizacion = $xmlRespuesta->addChild('valorTotalCotizacion', $row["valorTotalCotizacion"]);
                            $porcentaje1 = $xmlRespuesta->addChild('porcentaje1', $row["Porcentaje1"]);
                            $porcentaje2 = $xmlRespuesta->addChild('porcentaje2', $row["Porcentaje2"]);
                            $porcentaje3 = $xmlRespuesta->addChild('porcentaje3', $row["Porcentaje3"]);
                            $porcentaje4 = $xmlRespuesta->addChild('porcentaje4', $row["Porcentaje4"]);
                        }  
                    }
                    $sqlContratoModificar = sqlQuerySelect("SELECT numeroContrato, valorPago1, valorPago2, valorPago3, valorPago4 FROM contratosgenerados WHERE numeroContrato = '".$documentoId[0]."'");
                    if ($sqlContratoModificar->num_rows > 0) {
                        while ($rowContratoModificar = $sqlContratoModificar->fetch_assoc()) {
                            $valorPago1 = $xmlRespuesta->addChild('valorPago1', $rowContratoModificar["valorPago1"]);
                            $valorPago2 = $xmlRespuesta->addChild('valorPago2', $rowContratoModificar["valorPago2"]);
                            $valorPago3 = $xmlRespuesta->addChild('valorPago3', $rowContratoModificar["valorPago3"]);
                            $valorPago4 = $xmlRespuesta->addChild('valorPago4', $rowContratoModificar["valorPago4"]);
                        }
                    }
                }
                header('Content-Type: text/xml');
                echo $xmlRespuesta->asXML();
            break;
        }   
    }
?>