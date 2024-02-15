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
        case 'detallesContabilidad':
            $sql = "SELECT c.*, ct.* FROM cotizacion c INNER JOIN contratosgenerados ct ON ct.numerocontrato = " . $xml->param->cotizacionId . " WHERE c.documentoId = " . $xml->param->cotizacionId;
            $result = sqlQuerySelect($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if($row['material'] == ''){
                        $response .= '<idCotizacion>'.$row['documentoId'].'</idCotizacion>';
                        $response .= '<fechaCotizacion>'.$row['fechaPago1'].'</fechaCotizacion>';
                        $response .= '<fechaCotizacion>'.$row['fechaPago2'].'</fechaCotizacion>';
                        $response .= '<fechaCotizacion>'.$row['fechaPago3'].'</fechaCotizacion>';
                        $response .= '<fechaCotizacion>'.$row['fechaPago4'].'</fechaCotizacion>';
                        $response .= '<alcanceObra>'.$row['alcanceObra'].'</alcanceObra>';
                        $response .= '<porcentajesPago>'.$row['Porcentaje1'].'</porcentajesPago>';
                        $response .= '<valoresPago>'.$row['valorPago1'].'</valoresPago>';
                        $response .= '<porcentajesPago>'.$row['Porcentaje2'].'</porcentajesPago>';
                        $response .= '<valoresPago>'.$row['valorPago2'].'</valoresPago>';
                        $response .= '<porcentajesPago>'.$row['Porcentaje3'].'</porcentajesPago>';
                        $response .= '<valoresPago>'.$row['valorPago3'].'</valoresPago>';
                        $response .= '<porcentajesPago>'.$row['Porcentaje4'].'</porcentajesPago>';
                        $response .= '<valoresPago>'.$row['valorPago4'].'</valoresPago>';
                        $response .= '<manoObra>'.$row['manoObra'].'</manoObra>';
                        $response .= '<porcentajeAdmin>'.$row['porcentajeAdmin'].'</porcentajeAdmin>';
                        $response .= '<porcentajeUtilidad>'.$row['porcentajeUtilidad'].'</porcentajeUtilidad>';
                        $response .= '<alquilerEquipos>'.$row['alquilerEquipos'].'</alquilerEquipos>';
                        $response .= '<transporte>'.$row['transporte'].'</transporte>';
                        $response .= '<elementosProteccion>'.$row['elementosProteccion'].'</elementosProteccion>';
                        $response .= '<Dotacion>'.$row['Dotacion'].'</Dotacion>';
                    }
                }
            }else{
                $response .= '<resultados>0</resultados>';
            }
            break;
        case 'L-cuentaCobro':
            $sql = "SELECT cl.tipoDocumento, cl.primerNombre, cl.segundoNombre, cl.primerApellido, cl.segundoApellido, cl.razonSocial, 
            c.Cliente, c.consecutivo_cliente, MAX(c.Fecha) AS Fecha FROM cuentacobro c INNER JOIN clientes cl ON cl.numeroDocumento = c.Cliente 
            GROUP BY cl.tipoDocumento, cl.primerNombre, cl.segundoNombre, cl.primerApellido, cl.segundoApellido, cl.razonSocial, 
            c.Cliente, c.consecutivo_cliente";
            $result = sqlQuerySelect($sql);
            if($result->num_rows > 0){
                // Variable para controlar si ya se han generado los encabezados
                $encabezadosGenerados = false;

                while ($row = $result->fetch_assoc()) {
                    if (!$encabezadosGenerados) {
                        // Generar encabezados solo la primera vez que se entra al bucle
                        $response .= '<tabla>';
                        $response .= '<encabezado>Consecutivo</encabezado>';
                        $response .= '<encabezado>Cliente</encabezado>';
                        $response .= '<encabezado>Fecha</encabezado>';
                        $response .= '</tabla>';
                        
                        // Marcar que los encabezados ya han sido generados
                        $encabezadosGenerados = true;
                    }
                    $nombreCompleto = '';

                    if (!empty($row['primerNombre'])) {
                        $nombreCompleto .= $row['primerNombre'];
                    }

                    if (!empty($row['segundoNombre'])) {
                        $nombreCompleto .= ' ' . $row['segundoNombre'];
                    }

                    if (!empty($row['primerApellido'])) {
                        $nombreCompleto .= ' ' . $row['primerApellido'];
                    }

                    if (!empty($row['segundoApellido'])) {
                        $nombreCompleto .= ' ' . $row['segundoApellido'];
                    }

                    // Si ninguno de los campos de nombre está lleno, utilizamos la razón social
                    if (empty($nombreCompleto)) {
                        $nombreCompleto = $row['razonSocial'];
                    }

                    // Generar datos de fila
                    $response .= '<tabla>';
                    $response .= '<cuerpo>'.$row['consecutivo_cliente'].'</cuerpo>';
                    $response .= '<cuerpo>'.$nombreCompleto.'</cuerpo>';
                    $response .= '<cuerpo>'.$row['Fecha'].'</cuerpo>';
                    $response .= '<consecutivoCliente>'.$row['consecutivo_cliente'].'</consecutivoCliente>';
                    $response .= '<Cliente>'.$row['Cliente'].'</Cliente>';
                    $response .= '<NombreCompleto>'.$nombreCompleto.'</NombreCompleto>';
                    $response .= '</tabla>';
                }
                $response .= '<documento>Cuenta de cobro</documento>';
                

            }else{
                $response .= '<respuesta>0 datos</respuesta>';
            }
            break;
    }
    header('Content-Type: application/xml');
    $response .= "</response>";
    echo $response;
?>