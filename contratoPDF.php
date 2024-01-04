<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/sql.php';

function plantillaCotizacion() {
    $sqlPDF = sqlQuerySelect("SELECT c.fechaCotizacion, c.fechaCotizacionfin, c.organizacionEmpresas, cl.tipoDocumento, cl.numeroDocumento, cl.primerNombre, cl.segundoNombre, cl.primerApellido, cl.segundoApellido, cl.razonSocial, cl.ciudad, cl.direccion, c.alcanceObra, c.material, c.metros_unidades, c.precio_unitario, c.cantidad, c.precio_total, c.totalPorTodo, c.dias, c.manoObra, c.porcentajeAdmin, c.porcentajeUtilidad, c.alquilerEquipos, c.transporte, c.valorTotalCotizacion FROM cotizacion c    INNER JOIN clientes cl ON cl.numeroDocumento = c.organizacionEmpresas WHERE c.documentoId = '" . $_GET['id'] . "'");
    $sqlConceptos = sqlQuerySelect("SELECT material, metros_unidades, precio_unitario, cantidad, precio_total, totalValores  FROM cotizacion WHERE documentoId = '" . $_GET['id'] . "'");

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
                        <th>Cantidad</th>
                        <th>Valor total</th>
                    </tr>
                </thead>
                <tbody>';
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
                                <td>' . $row["cantidad"] . '</td>
                                <td>' . $row["totalValores"] . '</td>
                            </tr>';
                    }
                }
                $html .= '<tr>  
                        <td colspan="4" style="text-align:right;font-weight:bold">Valor total Conceptos: <span style="color:red">'.$fila['valorTotalCotizacion'].'</span></td>
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
           '.convertirNumeroATexto($fila['valorTotalCotizacion']).'('.$fila['valorTotalCotizacion'].')</b><br><br>
           <b>SEXTA: FORMA DE PAGO: EL CONTRATANTE</b> pagara a <b>EL CONTRATISTA</b>, el
           50% al iniciar, el 40% a mitad de obra y 10% al finalizar entera satisfacción.<br><br>
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
           mencionan y se dejen de pagar luego de prestado el servicio.<br><br>
           
           <b>DECIMA: SEGUNDA RETENCION EN LA FUENTE: EL CONTRATANTE</b> aplicara
           una retención en la fuente del 2% a el <b>CONTRATISTA</b>.
           Para constancia de todo lo anterior y en señal de aceptación, se suscribe el presente
           contrato el documento en dos ejemplares de un mismo tenor y valor a los 20 días
           del mes de septiembre 2023</p>
            
        </html>';
    } else {
        echo '<script>alert("No se encontraron datos para crear el PDF");window.close();</script>';
        exit;
    }

    return $html;
}
function convertirNumeroATexto($numero) {
    $unidades = array('cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve');
    $decenas = array('', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa');
    $centenas = array('', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos');
    $miles = array('', 'mil', 'millón', 'mil millones', 'billón', 'mil billones');

    $resultado = '';

    $parteEntera = floor($numero);
    $parteDecimal = ($numero - $parteEntera) * 1000;

    // Convertir la parte entera a texto
    $resultado .= convertirParteEnteraATexto($parteEntera, $miles);

    // Agregar la parte decimal si existe
    if ($parteDecimal > 0) {
        $resultado .= ' con ' . convertirParteEnteraATexto($parteDecimal, $miles);
    }

    return trim($resultado);
}

function convertirParteEnteraATexto($parteEntera, $miles) {
    $resultado = '';

    // Iterar sobre cada bloque de tres dígitos
    for ($i = 0; $parteEntera > 0; $i++) {
        $bloque = $parteEntera % 1000;
        $parteEntera = floor($parteEntera / 1000);

        if ($bloque > 0) {
            // Convertir el bloque actual a texto
            $bloqueTexto = convertirBloqueATexto($bloque, $miles[$i]);

            // Concatenar al resultado
            $resultado = $bloqueTexto . ' ' . $resultado;
        }
    }

    return trim($resultado);
}

function convertirBloqueATexto($bloque, $unidad) {
    $unidades = array('cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve');
    $decenas = array('', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa');
    $centenas = array('', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos');

    $resultado = '';

    // Obtener las centenas, decenas y unidades del bloque
    $centena = floor($bloque / 100);
    $decena = floor(($bloque % 100) / 10);
    $unidad = $bloque % 10;

    // Convertir la centena a texto
    if ($centena > 0) {
        $resultado .= $centenas[$centena] . ' ';
    }

    // Convertir la decena y la unidad a texto
    if ($decena > 0 || $unidad > 0) {
        if ($decena == 1 && $unidad > 0) {
            // Caso especial para números entre 10 y 19
            $resultado .= 'dieci' . $unidades[$unidad] . ' ';
        } else {
            $resultado .= $decenas[$decena] . ' ';
            if ($unidad > 0) {
                $resultado .= $unidades[$unidad] . ' ';
            }
        }
    }

    // Agregar la unidad (mil, millón, billón, etc.)
    if (!empty($unidad) || $bloque == 1) {
        $resultado .= $unidad . ' ' . $unidad;
    }

    return trim($resultado);    
}
$mpdf = new \Mpdf\Mpdf();
$mpdf->setFooter('{PAGENO}');
$html = plantillaCotizacion();

$mpdf->WriteHTML($html);
$mpdf->Output('archivo.pdf', \Mpdf\Output\Destination::INLINE);
?>
