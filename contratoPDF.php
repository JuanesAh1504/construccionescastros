<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/sql.php';

function plantillaCotizacion() {
    $sqlPDF = sqlQuerySelect("SELECT c.fechaCotizacion, c.fechaCotizacionfin, c.organizacionEmpresas, cl.tipoDocumento, cl.numeroDocumento, cl.primerNombre, cl.segundoNombre, cl.primerApellido, cl.segundoApellido, cl.razonSocial, cl.ciudad, cl.direccion, c.alcanceObra, c.material, c.metros_unidades, c.precio_unitario, c.cantidad, c.precio_total, c.totalPorTodo, c.dias, c.manoObra, c.porcentajeAdmin, c.porcentajeUtilidad, c.alquilerEquipos, c.transporte, c.valorTotalCotizacion, c.Porcentaje1, c.Porcentaje2, c.Porcentaje3, c.Porcentaje4 FROM cotizacion c INNER JOIN clientes cl ON cl.numeroDocumento = c.organizacionEmpresas WHERE c.documentoId = '" . $_GET['id'] . "'");
    $sqlConceptos = sqlQuerySelect("SELECT material, metros_unidades, precioUnitarioFinalValores, cantidad, precio_total, totalValores, retefuente  FROM cotizacion WHERE documentoId = '" . $_GET['id'] . "'");

    if ($sqlPDF && mysqli_num_rows($sqlPDF) > 0) {
        $fila = $sqlPDF->fetch_assoc();
        $nombreCompleto = '';

        if (!empty($fila['primerNombre'])) {
            $nombreCompleto .= $fila['primerNombre'];
        }

        if (!empty($fila['segundoNombre'])) {
            $nombreCompleto .= (!empty($nombreCompleto) ? ' ' : '') . $fila['segundoNombre'];
        }

        if (!empty($fila['primerApellido'])) {
            $nombreCompleto .= (!empty($nombreCompleto) ? ' ' : '') . $fila['primerApellido'];
        }

        if (!empty($fila['segundoApellido'])) {
            $nombreCompleto .= (!empty($nombreCompleto) ? ' ' : '') . $fila['segundoApellido'];
        }
        // Si todos los campos están vacíos, utiliza la razón social
        if (empty($nombreCompleto)) {
            $nombreCompleto = $fila['razonSocial'];
        }

        $formaDePago = '';
        $contadorCondiciones = 0;
        $porcentaje1 = "";
        $porcentaje2 = "";
        $porcentaje3 = "";
        $porcentaje4 = "";
        if (!empty($fila['Porcentaje1'])) {
            $porcentaje1 .= ''.$fila['Porcentaje1'].'';
            $contadorCondiciones++;
            if (!empty($fila['Porcentaje2'])) {
                $porcentaje2 .= ''.$fila['Porcentaje2'].'';
                $contadorCondiciones++;
                if (!empty($fila['Porcentaje3'])) {
                    $porcentaje3 .= ''.$fila['Porcentaje3'].'';
                    $contadorCondiciones++;
                    if (!empty($fila['Porcentaje4'])) {
                        $porcentaje4    .= ''.$fila['Porcentaje4'].'';
                        $contadorCondiciones++;
                    }
                    
                }
            }
        }

        if($contadorCondiciones == 1){
            // Si solo está lleno el primer porcentaje
            $formaDePago = $porcentaje1 . ' en su totalidad.';
        }else if($contadorCondiciones == 2){
            $formaDePago = $porcentaje1 . ' al iniciar, el ' . $porcentaje2 . ' al finalizar entera satisfacción.';
        }else if($contadorCondiciones == 3){
            $formaDePago = $porcentaje1 . ' al iniciar, el ' . $porcentaje2 . ' en la mitad de obra y el '.$porcentaje3.' al finalizar entera satisfacción.';
        }else if($contadorCondiciones == 4){
            $formaDePago = $porcentaje1 . ' al iniciar, el ' . $porcentaje2 . ' en un cuarto de obra, el '.$porcentaje3.' a mitad de obra y el '.$porcentaje4.' al finalizar entera satisfacción.';
        }
        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Cotización</title>
            <style>
                body{
                    font-family: sans-serif;
                    letter-spacing: 0.5px;
                    font-size: 16px;
                    text-align:center;
                }

                table {
                    width: 100%;
                    border-spacing: 0;
                    font-family: Arial, sans-serif;
                    border: 1px solid #ddd;
                }
            
                th, td {
                    padding: 15px;
                    text-align: left;
                    border-bottom: 1px solid #ddd;
                    border-right: 1px solid #ddd;
                    text-align: center;
                    word-wrap: break-word;
                }

                td {
                    white-space: nowrap;
                }
            
                th {
                    background-color: #138FCB;
                    color: white;
                    font-weight: bold;
                    border-right: 1px solid #ddd;
                }
            
                tr:last-child td {
                    border-bottom: none;
                }
            
                tr:hover {
                    background-color: #f5f5f5;
                }

                p{
                    line-height: 2;
                    text-align:left;
                } /* Ajusta este valor según tus preferencias */
                
            </style>
        </head>
        <body><br><br><br><br>
            <center>
                <span class="textoPrincipal" style="font-weight:bold;">'.$nombreCompleto.'<br>
                    '.$fila['tipoDocumento'].' '.$fila['numeroDocumento'].'<br><br>
                    '.$fila['alcanceObra'].'
                </span>
                <br><br><br>
            </center>
            <p>Entre los suscritos a saber de un lado <b>JUAN FERNANDO CASTRO HERNÁNDEZ</b>,
            con '.$fila['tipoDocumento'].' '.$fila['numeroDocumento'].' mayor de edad, vecino del municipio de '.$fila['ciudad'].' y en
            representación quien para los efectos del presente contrato se denominará <b>EL
            CONTRATISTA</b>, y, del otro lado <b>'.$nombreCompleto.'</b>, quien para los mismos efectos se denominará <b>EL
            CONTRATANTE</b>, se ha celebrado un contrato mano de obra que se denominara en
            las siguientes clausulas.<br><br>
            PRIMERA OBJETO: EL CONTRATISTA se obliga a prestar sus servicios
            profesionales de mano de obra a EL CONTRATANTE, en la modalidad del precio
            unitario fijo, para los trabajos correspondientes: <br><br></p>
            <table>
                <thead>
                    <tr>
                        <th style="width: 200px">Concepto</th>
                        <th>M2 - Unidades</th>
                        <th>Precio unitario</th>
                        <th>Cantidad</th>
                        <th>Valor total</th>
                    </tr>
                </thead>
                <tbody>';
                $tieneRetefuente = false;
                $valorPrimeraRetefuente = "";
                if ($sqlConceptos) {
                    while ($row = $sqlConceptos->fetch_assoc()) {
                        if ($row['material'] == '' && $row['metros_unidades'] == ''
                            && $row['precio_unitario'] == '' && $row['cantidad'] == '' && $row['precio_total'] == '') {
                            continue;
                        }
                        $html .= '
                            <tr>
                                <td>' . $row["material"] . '</td>
                                <td>' . $row["metros_unidades"] . '</td>
                                <td>' . $row["precioUnitarioFinalValores"] . '</td>
                                <td>' . $row["cantidad"] . '</td>
                                <td>' . $row["totalValores"] . '</td>
                            </tr>';
                            if($row['retefuente'] != ""){
                                $tieneRetefuente = true;
                                $valorPrimeraRetefuente = $row['retefuente'];
                            }
                    }
                }
                $html .= '<tr>  
                        <td colspan="5" style="text-align:right;font-weight:bold">Valor total Conceptos: <span style="color:red">'.$fila['valorTotalCotizacion'].'</span></td>
                    </tr>
                </tbody>
            </table><br>
           <p><b>SEGUNDA OBLIGACIONES DEL CONTRATISTA:</b> 1) Ejecutar el objeto del contrato
           de conformidad con las especificaciones y recomendaciones dadas por <b>EL
           CONTRATANTE</b> o por quien este designe. 2) Tener en la obra bajo u absoluta
           responsabilidad el personal necesario para la buena marcha y ejecución de los
           trabajos. 3) Reparar, demoler y/o reconstruir las obras defectuosas que se presentan
           en la ejecución del contrato hasta la fecha de entrega, así como los daños
           y defectos posteriores a la entrega, que tengan como causa la mala construcción,
           deficiente montaje y/o instalación, todo por su cuenta y riesgo, y dentro del plazo
           prudencial que señale <b>EL CONTRATANTE</b>. 4) <b>EL CONTRATISTA</b> se compromete
           a pagar a sus trabajadores o ayudante todas las prestaciones, salarios y seguridad
           social en la forma en que la ley y a colocar todo su empeño en la misión
           encomendada.
           <br><br>
           <b>TERCERA AUTONOMIA TECNICA Y DIRECTIVA:</b> En la ejecución del presente
           contrato <b>EL CONTRATISTA</b> actúa con plena autonomía técnica y directiva,
           asumiendo todo los riesgos y sin estar sujeto a horarios, ordenes o reglamentos que
           impliquen dependencia o subordinación jurídica laboral Por consiguiente, la
           presente relación entre <b>EL CONTRATANTE</b> y <b>EL CONTRATISTA</b> o los empleados
           o subcontratistas de <b>EL CONTRATISTA</b>, ni dará lugar al pago de ninguna de las
           acreencias previstas en las disposiciones laborales, dejando expresamente
           manifestada <b>EL CONTRATISTA</b> que está en la forma habitual de prestar sus
           servicio profesionales en el desarrollo de contratos de esta naturaleza. <br><br>
           <b>CUARTA RESPONSABILIDAD DEL CONTRATISTA:</b> Se entiende que la
           responsabilidad técnica, administrativa y operativa de las labores de construcción
           implica, además, la atención de soluciones y asunción de gastos por parte de <b>EL
           CONTRATISTA</b>, de prestación de servicios y seguridad social; de las indemnizaciones laborales, así como de las indemnizaciones civiles a que haya
           lugar como consecuencia de accidentes ocasionados por imprevisión o mal manejo
           esta cláusula incluye una indemnización por lesiones personales o muertes
           accidental. <br><br>
           <b>PARAGRAFO: EL CONTRATANTE</b> podrá exigir a <b>EL CONTRATISTA</b> toda la
           documentación que acredite la afiliación del personal de la obra al Régimen de
           Seguridad Social, el pago de prestaciones sociales y demás exigencia que tenga
           por ley. <br><br>
           Dar pleno cumplimiento a lo señalado en el decreto 1072 de 2015 y demás normas
           complementarias, que regulan lo concerniente al sistema de gestión de la seguridad
           y salud en el trabajo. Teniendo en cuenta lo anterior y con la finalidad de cumplir
           con las disposiciones que respecto a ese tema se encuentran vigentes, el contratista
           deberá informar siempre a sus trabajadores sobre los peligros y riesgos a los cuales
           se encuentra expuesto durante la ejecución de la obra. <br><br>
           <b>QUINTA: VALOR DEL CONTRATO EL CONTRATATE:</b> se obliga a reconocer y
           pagar al <b>EL CONTRATISTA:</b> el equivalente a los precios unitarios establecidos en el
           presupuesto a todo costo, anexo de acuerdo a los cual el valor del contrato será de
           <b>
           ('.$fila['valorTotalCotizacion'].')</b><br><br>
            <b>SEXTA: FORMA DE PAGO: EL CONTRATANTE</b> pagará a <b>EL CONTRATISTA</b>, el
            '.$formaDePago.'<br><br>
           <b>SEPTIMA: TIEMPO DE ENTREGA:</b> El tiempo de entrega de la obra del presente
           contrato será de '.$fila['dias'].' días contados a partir del '.$fila['fechaCotizacion'].' hasta el '.$fila['fechaCotizacionfin'].', termino durante el cual EL CONTRATISTA deberá cumplir con el objeto
           del contrato.<br><br><br>
           <b>PARAGRAFO:</b> Solo será excusa de retraso la fuerza mayor o caso fortuito
           debidamente comprobados.<br><br>
           <b>OCTAVA: OBRA EXTRA:</b> Son aquellas que no están consideradas en el prepuestode
           mano obra anexo al presente al presente contrato, pero cuya ejecución <b>EL
           CONTRATANTE</b> considere necesaria En esta obra extra se considera establecido
           entre <b>EL CONTRATANTE</b> y <b>EL CONTRATISTA</b> previamente a su ejecución Esta
           clase de obra se diferencia de la obra adicional las cuales deberán ser autorizadas
           por <b>EL CONTRATANTE</b> y serán canceladas de acuerdo a los precios unitarios de
           mano de obra de la propuesta.<br><br>
           <b>NOVENA: CESIÓN DEL CONTRATO: EL CONTRATISTA</b> no podrá ceder el
           presente contrato ni los hechos derivados del el a ningún título, o sin consentimiento
           previo y expreso de <b>EL CONTRATANTE</b>. <br><br>
           <b>DECIMA: MODIFICACIONES:</b> Cuando sea necesario modificar el valor convenio oel
           plazo señalado en el presente contrato, se suscribirá la respectiva modificación mediante otro
           si al presente contrato Las adiciones quedaran perfeccionadas una vez firmado el documento.<br><br>
           <b>DECIMA: PRIMERA DOMICILIO:</b> Las partes acuerdan que para los efectos del
           presente contrato el domicilio será '.$fila['ciudad'].', '.$fila['direccion'].', lugar de ejecución dela obra.<br><br>
           Este documento prestara merito ejecutivo para el cobro de las sumas que en él se
           mencionan y se dejen de pagar luego de prestado el servicio.<br><br>';
           if($tieneRetefuente){
                $html .= '<b>DECIMA: SEGUNDA RETENCION EN LA FUENTE: EL CONTRATANTE</b> aplicará
                una retención en la fuente del '.$valorPrimeraRetefuente.' a el <b>CONTRATISTA</b>.
                Para constancia de todo lo anterior y en señal de aceptación, se suscribe el presente
                contrato el documento en dos ejemplares de un mismo tenor y valor al '.obtenerFechaActual().'.</p>';
           }
        $html .= '<div class="firmaElectronica">
        <img src="'.  __DIR__ . '/img/firmaElectronica.jpeg" style="width:200px"><br>
        <span>JUAN FERNANDO CASTRO HERNANDEZ</span><br>
        <span>CONTRATISTA</span>
    </div><br>
    <footer>
        <span>CARRERA 17#7-121 LOCAL 101 EDIFICIO LAS ACACIAS GIRARDOTA <br>
        TELÉFONOS 3668720 - 3128949012
        </span>
    </footer></html>';
    } else {
        echo '<script>alert("No se encontraron datos para crear el PDF");window.close();</script>';
        exit;
    }

    return $html;
}

$mpdf = new \Mpdf\Mpdf();
$mpdf->setFooter('{PAGENO} de {nb}');
$html = plantillaCotizacion();

$mpdf->WriteHTML($html);
$mpdf->Output('archivo.pdf', \Mpdf\Output\Destination::INLINE);

?>
