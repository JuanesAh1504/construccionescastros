<?php 
    include_once('config.php');
    include_once("sql.php");
    include_once("functions.php");
    global $conn;
    conectarBaseDeDatos();
    $response = '<contrato>';
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
                $sqlConsultaContrato = sqlQuerySelect("SELECT numeroContrato, valorPago1, valorPago2, valorPago3, valorPago4 FROM contratosgenerados WHERE numeroContrato = '".$xml->param->idCotizacion."'");
                if ($sqlConsultaContrato->num_rows > 0) {
                    while ($rowContrato = $sqlConsultaContrato->fetch_assoc()) {
                        $response .= " <valorPago1>".$rowContrato['valorPago1']."</valorPago1>";
                        $response .= " <valorPago2>".$rowContrato['valorPago2']."</valorPago2>";
                        $response .= " <valorPago3>".$rowContrato['valorPago3']."</valorPago3>";
                        $response .= " <valorPago4>".$rowContrato['valorPago4']."</valorPago4>";
                    }
                }
            }
            break;
        case 'U-pagoContrato':
            $sql = sqlInsertUpdate("UPDATE contratosgenerados SET valorPago1 = '".$xml->param->valorPago1."', valorPago2 = '".$xml->param->valorPago2."', valorPago3 = '".$xml->param->valorPago3."', valorPago4 = '".$xml->param->valorPago4."' WHERE numerocontrato = '".$xml->param->cotizacionId."'");
            if($sql){
                $response .= "<respuesta>OK</respuesta>";
            }
            break;
    }
    header('Content-Type: application/xml');
    $response .= "</contrato>";
    echo $response;
?>