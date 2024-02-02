<?php 
    include_once('config.php');
    include_once("sql.php");
    include_once("functions.php");
    global $conn;
    conectarBaseDeDatos();
    $response = '<response>';
    $xmlData = file_get_contents('php://input');
    $xml = simplexml_load_string($xmlData);
    switch ($xml->accion) {
        case 'obtenerCotizacion':
            $contrato = $xml->param->idCotizacion;
            $sql = "SELECT documentoId, alcanceObra, material, valorTotalCotizacion, Porcentaje1, Porcentaje2, Porcentaje3, Porcentaje4 FROM cotizacion WHERE documentoId = '".$contrato."'";
            $result = sqlQuerySelect($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if($row['material'] == ''){ 
                        $response .= "<respuesta>OK</respuesta><documentoId>".$row['documentoId']."</documentoId>";
                        $response .= "<alcanceObra>".$row['alcanceObra']."</alcanceObra>";
                        $response .= "<valorTotalCotizacion>{$row['valorTotalCotizacion']}</valorTotalCotizacion>";
                        $response .= "<porcentaje1>{$row['Porcentaje1']}</porcentaje1>";
                        $response .= "<porcentaje2>{$row['Porcentaje2']}</porcentaje2>";
                        $response .= "<porcentaje3>{$row['Porcentaje3']}</porcentaje3>";
                        $response .= "<porcentaje4>{$row['Porcentaje4']}</porcentaje4>";
                    }  
                }
                $sqlConsultaContrato = sqlQuerySelect("SELECT numeroContrato, valorPago1, valorPago2, valorPago3, valorPago4, fechaPago1, fechaPago2, fechaPago3, fechaPago4, pagado1, pagado2, pagado3, pagado4 FROM contratosgenerados WHERE numeroContrato = '".$xml->param->idCotizacion."'");
                if ($sqlConsultaContrato->num_rows > 0) {
                    while ($rowContrato = $sqlConsultaContrato->fetch_assoc()) {
                        $response .= " <valorPago1>".$rowContrato['valorPago1']."</valorPago1>";
                        $response .= " <valorPago2>".$rowContrato['valorPago2']."</valorPago2>";
                        $response .= " <valorPago3>".$rowContrato['valorPago3']."</valorPago3>";
                        $response .= " <valorPago4>".$rowContrato['valorPago4']."</valorPago4>";
                        $response .= " <fechaPago1>".$rowContrato['fechaPago1']."</fechaPago1>";
                        $response .= " <fechaPago2>".$rowContrato['fechaPago2']."</fechaPago2>";
                        $response .= " <fechaPago3>".$rowContrato['fechaPago3']."</fechaPago3>";
                        $response .= " <fechaPago4>".$rowContrato['fechaPago4']."</fechaPago4>";
                        $response .= " <pagado1>".$rowContrato['pagado1']."</pagado1>";
                        $response .= " <pagado2>".$rowContrato['pagado2']."</pagado2>";
                        $response .= " <pagado3>".$rowContrato['pagado3']."</pagado3>";
                        $response .= " <pagado4>".$rowContrato['pagado4']."</pagado4>";
                    }
                }
            }
            break;
        case 'U-pagoContrato':
            $sqlVerificarExistencia = "SELECT numerocontrato FROM contratosgenerados WHERE numerocontrato = '".$xml->param->cotizacionId."'";
            $result = sqlQuerySelect($sqlVerificarExistencia);
            if($result -> num_rows == 0){
                $insertRegistro = sqlInsertUpdate("INSERT INTO contratosgenerados (numerocontrato, valorPago1, valorPago2, valorPago3, valorPago4, fechaPago1, fechaPago2, fechaPago3, fechaPago4, pagado1, pagado2, pagado3, pagado4) VALUES ('".$xml->param->cotizacionId."', '".$xml->param->valorPago1."','".$xml->param->valorPago2."','".$xml->param->valorPago3."','".$xml->param->valorPago4."','".$xml->param->fechaPagado1."','".$xml->param->fechaPagado2."','".$xml->param->fechaPagado3."','".$xml->param->fechaPagado4."','".$xml->param->pagado1."','".$xml->param->pagado2."','".$xml->param->pagado3."','".$xml->param->pagado4."')");
                if($insertRegistro){
                    $response .= "<respuesta>OK</respuesta>";
                    break;
                }else{
                    $response .= "<respuesta>ERROR</respuesta>";
                    break;
                }
            }
            $sql = sqlInsertUpdate("UPDATE contratosgenerados SET valorPago1 = '".$xml->param->valorPago1."', valorPago2 = '".$xml->param->valorPago2."', valorPago3 = '".$xml->param->valorPago3."', valorPago4 = '".$xml->param->valorPago4."', fechaPago1 = '".$xml->param->fechaPagado1."', fechaPago2 = '".$xml->param->fechaPagado2."', fechaPago3 = '".$xml->param->fechaPagado3."', fechaPago4 = '".$xml->param->fechaPagado4."', pagado1 = '".$xml->param->pagado1."', pagado2 = '".$xml->param->pagado2."', pagado3 = '".$xml->param->pagado3."', pagado4 = '".$xml->param->pagado4."' WHERE numerocontrato = '".$xml->param->cotizacionId."'");
            if($sql){
                $response .= "<respuesta>OK</respuesta>";
            }
            break;
        case 'obtenerInfoContabilidad':
            $sql = "SELECT c.*, ct.* FROM cotizacion c INNER JOIN contratosgenerados ct ON ct.numerocontrato = " . $xml->param->idCotizacion . " WHERE c.documentoId = " . $xml->param->idCotizacion;
            $result = sqlQuerySelect($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if($row['material'] == ''){
                        $response .= '<idCotizacion>'.$row['documentoId'].'</idCotizacion>';
                        $response .= '<fechaCotizacion>'.$row['fechaCotizacion'].'</fechaCotizacion>';
                        $response .= '<alcanceObra>'.$row['alcanceObra'].'</alcanceObra>';
                        $response .= '<porcentaje1>'.$row['Porcentaje1'].'</porcentaje1>';
                        $response .= '<valorPago1>'.$row['valorPago1'].'</valorPago1>';
                        $response .= '<porcentaje2>'.$row['Porcentaje2'].'</porcentaje2>';
                        $response .= '<valorPago2>'.$row['valorPago2'].'</valorPago2>';
                        $response .= '<porcentaje3>'.$row['Porcentaje3'].'</porcentaje3>';
                        $response .= '<valorPago3>'.$row['valorPago3'].'</valorPago3>';
                        $response .= '<porcentaje4>'.$row['Porcentaje4'].'</porcentaje4>';
                        $response .= '<valorPago4>'.$row['valorPago4'].'</valorPago4>';
                        $response .= '<manoObra>'.$row['manoObra'].'</manoObra>';
                        $response .= '<porcentajeAdmin>'.$row['porcentajeAdmin'].'</porcentajeAdmin>';
                        $response .= '<porcentajeUtilidad>'.$row['porcentajeUtilidad'].'</porcentajeUtilidad>';
                        $response .= '<alquilerEquipos>'.$row['alquilerEquipos'].'</alquilerEquipos>';
                        $response .= '<transporte>'.$row['transporte'].'</transporte>'; 
                        $response .= '<elementosProteccion>'.$row['elementosProteccion'].'</elementosProteccion>';
                        $response .= '<Dotacion>'.$row['Dotacion'].'</Dotacion>';
                    }
                }
            }
            break;
        case 'I-user':
            if(xmlInsertarDatos('clientes', $xml->param->idCampo, $xml->param->valor)){
                $response .= "<respuesta>OK</respuesta>";
            }else{  
                $response .= "<respuesta>ERROR</respuesta>";
            }
            break;
            case 'U-user':
                if (xmlActualizarDatos('clientes', $xml->param->idCampo, $xml->param->valor, 'documentoId=' . $xml->param->valor[0])) {
                    $response .= "<respuesta>OK</respuesta>";
                } else {
                    $response .= "<respuesta>ERROR</respuesta>";
                }
                break;
            case 'I-Gastos':
                $i = 1; // Inicializa el contador
                $rowCount = intval($xml->param->rowCountModal);
                $contadorEjecuciones = 0;
                $datosRepetidos = false;
                for ($i = 0; $i < count($xml->param->valor); $i += 2) {
                    $numeralPorcentaje = $xml->param->numeralPorcentaje;
                    $porcentaje = $xml->param->porcentaje;
                    $producto = $xml->param->valor[$i];
                    $precio = $xml->param->valor[$i + 1];
                    $verificarExistencia = sqlQuerySelect("SELECT idContrato, porcentaje, producto, precio FROM gastoscontratos WHERE idContrato = '".$xml->param->idContrato."' AND producto = '".$producto."' AND precio = '".$precio."'");
                    if($verificarExistencia->num_rows <= 0){
                        $stmt = $conn->prepare("INSERT INTO gastoscontratos (numeralPorcentaje, porcentaje, idContrato, producto, precio) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("sssss", $numeralPorcentaje,$porcentaje,$xml->param->idContrato,$producto,$precio);
                        $stmt->execute();
                        if ($stmt->affected_rows < 1) {
                            $mensaje = mostrarAlerta("Error al insertar los datos, inténtelo de nuevo más tarde.", "danger");
                            return;
                        }else{
                            $contadorEjecuciones++;
                        }
                    }else{
                        $datosRepetidos = true;
                    }
                    
                }
                $totalRestante = $xml->param->totalRestante;
                $verificarExistencia = sqlQuerySelect("SELECT numeralPorcentaje, porcentaje, idContrato, idTotal, total FROM gastoscontratos WHERE total = '".$totalRestante."' AND numeralPorcentaje = '".$numeralPorcentaje."' AND porcentaje = '".$porcentaje."' AND idContrato = '".$xml->param->idContrato."' AND idTotal = '".$xml->param->tdTotal."'");
                if($verificarExistencia->num_rows <= 0){
                    $stmt = $conn->prepare("INSERT INTO gastoscontratos (numeralPorcentaje, porcentaje, idContrato, idTotal, total) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssss", $numeralPorcentaje, $porcentaje, $xml->param->idContrato, $xml->param->tdTotal, $totalRestante);
                    $stmt->execute();
                    if ($stmt->affected_rows < 1) {
                        $mensaje = mostrarAlerta("Error al insertar los datos, inténtelo de nuevo más tarde.", "danger");
                        return;
                    }else{
                        $contadorEjecuciones++;
                    }
                }else{
                    $datosRepetidos = true;
                }
                if($contadorEjecuciones >= 2){
                    $response .= '<respuesta>OK</respuesta>';
                }else if($datosRepetidos){
                    $response .= '<respuesta>REPETIDOS</respuesta>';
                }else{
                    $response .= '<respuesta>ERROR</respuesta>';
                }
                break;
            case 'U-gastos':
                $i = 1; // Inicializa el contador
                $rowCount = intval($xml->param->rowCountModal);
                $contadorEjecuciones = 0;
                $datosActualizados = false;
                for ($i = 0; $i < count($xml->param->valor); $i += 2) {
                    $numeralPorcentaje = $xml->param->numeralPorcentaje;
                    $porcentaje = $xml->param->porcentaje;
                    $producto = $xml->param->valor[$i];
                    $precio = $xml->param->valor[$i + 1];
                    // Verificar si el registro ya existe en la base de datos
                    $verificarExistencia = sqlQuerySelect("SELECT id, numeralPorcentaje, porcentaje, producto, precio FROM gastoscontratos WHERE idContrato = '".$xml->param->idContrato."' AND producto = '".$producto."' AND precio = '".$precio."'");
                    if($verificarExistencia->num_rows > 0){
                        $registro = $verificarExistencia->fetch_assoc();
                        $idRegistro = $registro['id'];
                        // Actualizar el registro existente
                        $stmt = $conn->prepare("UPDATE gastoscontratos SET numeralPorcentaje=?, porcentaje=?, producto=?, precio=? WHERE id=?");
                        $stmt->bind_param("ssssi", $numeralPorcentaje, $porcentaje, $producto, $precio, $idRegistro);
                        $stmt->execute();
                        if ($stmt->affected_rows < 1) {
                            $mensaje = mostrarAlerta("Error al actualizar los datos, inténtelo de nuevo más tarde.", "danger");
                            return;
                        } else {
                            $contadorEjecuciones++;
                            $datosActualizados = true;
                        }
                    }
                }
                break;
    }
    header('Content-Type: application/xml');
    $response .= "</response>";
    echo $response;
?>