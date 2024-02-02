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
        case 'S-Contrato':
            $sql = "SELECT documentoId, alcanceObra FROM cotizacion WHERE estado = '1'";
            $resultado = sqlQuerySelect($sql);
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) {
                    if($row['alcanceObra'] != ''){
                        $response .= "<documentoId>".$row['documentoId']."</documentoId><alcanceObra>".$row['documentoId'] . ' - ' .$row['alcanceObra']."</alcanceObra>";
                    }
                }
            }
            break;
        case 'S-gastosContratos':
            $sql = 'SELECT producto, precio, idTotal, total FROM gastoscontratos WHERE numeralPorcentaje = "'.$xml->param->numeralPorcentaje.'" AND porcentaje = "'.$xml->param->porcentaje.'" AND idContrato = "'.$xml->param->documentoId.'"';
            $resultado = sqlQuerySelect($sql);
            if ($resultado->num_rows > 0) {
                $response .= '<modal>'.$xml->param->modal.'</modal>';
                while ($row = $resultado->fetch_assoc()) {
                    $response .= '<producto>'.$row['producto'].'</producto><precio>'.$row['precio'].'</precio>';
                    if($row['producto'] == "" && $row['precio'] == ""){
                        $response .= '<total>'.$row['total'].'</total>';
                        $response .= '<tdTotal>'.$row['idTotal'].'</tdTotal>';
                    }
                }
            }
            break;
    }
    header('Content-Type: application/xml');
    $response .= "</response>";
    echo $response;
?>