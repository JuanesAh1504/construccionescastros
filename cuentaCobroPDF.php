<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/sql.php';
require_once __DIR__ . '/functions.php';


function plantillaCotizacion() {
    $sqlPDF = sqlQuerySelect("SELECT
        cl.tipoDocumento, 
        cl.primerNombre, 
        cl.segundoNombre, 
        cl.primerApellido, 
        cl.segundoApellido,
        cl.razonSocial, 
        c.Cliente, 
        c.consecutivo_cliente, 
        MAX(c.Fecha) AS Fecha
    FROM 
        cuentacobro c 
    INNER JOIN 
        clientes cl ON cl.numeroDocumento = c.Cliente 
    WHERE 
        c.consecutivo_cliente = '".$_GET['consecutivo']."' 
        AND c.Cliente = '".$_GET['Cliente']."'
    GROUP BY 
        cl.tipoDocumento, 
        cl.primerNombre, 
        cl.segundoNombre, 
        cl.primerApellido, 
        cl.segundoApellido, 
        cl.razonSocial, 
        c.Cliente, 
        c.consecutivo_cliente");

    $sqlConceptos = sqlQuerySelect("SELECT concepto, precio FROM cuentacobro WHERE consecutivo_cliente = '".$_GET['consecutivo']."' AND Cliente = '".$_GET['Cliente']."'");
    $sqlConceptosAux = sqlQuerySelect("SELECT concepto, precio FROM cuentacobro WHERE consecutivo_cliente = '".$_GET['consecutivo']."' AND Cliente = '".$_GET['Cliente']."'");
    if ($sqlPDF && mysqli_num_rows($sqlPDF) > 0) {
        $fila = $sqlPDF->fetch_assoc();
        $nombreCliente = '';
        if($fila['primerNombre'] !== '' || $fila['segundoNombre'] !== ''){
            $nombreCliente = $fila['primerNombre'] . ' ' . $fila['segundoNombre'] . ' ' .$fila['primerApellido'] . ' ' . $fila['segundoApellido'];
        }else{
            $nombreCliente = $fila['razonSocial'];
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
                    font-family: Roboto;
                    font-size: 16px;
                }

                .container {
                    margin: 350px 0px 0px 50px;
                }
                
                .segundaSeccion {
                    padding: 50px 0px;
                    width: 10px;
                }
                
                span.cliente, span.alcanceObra, .tituloNuestraResponsabilidad {
                    font-weight: bold;
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

                .card {
                    display: flex;
                    border: 1px solid #ddd;
                    border-radius: 8px;
                    overflow: hidden;
                    margin-top: 20px;
                }

                .card img {
                    max-width: 100px;
                    object-fit: contain;
                    padding: 20px;
                    background-color: #138FCB;
                }

                .card-content {
                    flex-grow: 1;
                    padding: 20px;
                }

                .card-title {
                    font-size: 20px;
                    font-weight: bold;
                    margin-bottom: 15px;
                }

                .info-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 10px;
                }

                .info-table td, .info-table th {
                    padding: 10px;
                    border-bottom: 1px solid #ddd;
                    text-align: left;
                }

                .info-table th {
                    background-color: #138FCB;
                    color: white;
                }
            </style>
        </head>
        <body>
            <header class="imgPortada" style="text-align: center;">
                <img src="' . __DIR__ . '/img/logo.jpeg" alt="Logo Castros Solucion" style="width:300px;">
            </header>
            <div class="container">
            <br><br>
                <div class="primeraSeccion">
                    <p style="font-weight:bold">Girardota, '.obtenerFechaActual().'.  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Cuenta de cobro '.$fila['consecutivo_cliente'].'  </p> 
                </div>

                <div class="segundaSeccion" style="display: flex; justify-content: center; align-items: center;">
                   <p style="text-align:center;font-size:20px;font-weight:bold;">'.$nombreCliente.' <br>
                    <span style="font-size:15px">'.strtoupper($fila['tipoDocumento']) . ' ' .$fila['Cliente']. '</span></p>

                    <br>
                    <p style="text-align:center"><b>DEBE A: </b><br>
                    <span>JUAN FERNANDO CASTRO HERNÁNDEZ</span><br>
                    <span>C.C. 1.035.850.790 de GIRARDOTA (ANTIOQUIA).</span><br>
                    </p>
                    
                    <br>
                    <p style="text-align:center"><b>LA SUMA DE: <br>';
                    if ($sqlConceptos) {
                        while ($row = $sqlConceptos->fetch_assoc()) {
                            if(strpos($row['concepto'], "Total Cuenta de cobro:") !== false){
                                $html .= strtoupper(numeroALetras($row['precio'])).' PESOS ('.$row['precio'].')';
                            }
                        }
                    }
                    $html .= '</b></p>
                    <br>
                    <p>Por concepto de:</p>';
                    if ($sqlConceptosAux) {
                        while ($filaConcepto = $sqlConceptosAux->fetch_assoc()) {
                            if($filaConcepto['concepto'] != ""){
                                if($filaConcepto['concepto'] !== "Total Cuenta de cobro:"){
                                    $html .= '- ' . $filaConcepto['concepto'] . ': ' . $filaConcepto['precio'] . '<br>';

                                }
                            }
                        }
                    }
                $html .= '</div>
            </div>
            <div class="firmaElectronica">
                    <img src="'.  __DIR__ . '/img/firmaElectronica.jpeg" style="width:200px"><br>
                    <span>JUAN FERNANDO CASTRO HERNANDEZ</span><br>
                    <span>C.C. 1.035.850.790</span><br>
                    <span>Teléfono 3124684287</span>
                </div><br>
        </body>
        </html>';
    } else {
        echo '<script>alert("No se encontraron datos para crear el PDF");window.close();</script>';
        exit;
    }

    return $html;
}

$mpdf = new \Mpdf\Mpdf();

$html = plantillaCotizacion();

$mpdf->WriteHTML($html);
$mpdf->Output('archivo.pdf', \Mpdf\Output\Destination::INLINE);
?>
