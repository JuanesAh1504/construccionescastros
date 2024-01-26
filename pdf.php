<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/sql.php';

function plantillaCotizacion() {
    $sqlPDF = sqlQuerySelect("SELECT c.fechaCotizacion, cl.primerNombre, cl.segundoNombre, cl.primerApellido, cl.segundoApellido, c.organizacionEmpresas, c.alcanceObra, c.material, c.metros_unidades, c.precio_unitario, c.cantidad, c.precio_total, c.totalPorTodo, c.dias, c.manoObra, c.porcentajeAdmin, c.porcentajeUtilidad, c.alquilerEquipos, c.transporte, c.valorTotalCotizacion FROM cotizacion c INNER JOIN clientes cl ON cl.numeroDocumento = c.organizacionEmpresas WHERE c.documentoId = '" . $_GET['id'] . "'");
    $sqlConceptos = sqlQuerySelect("SELECT material, metros_unidades, precio_unitario, cantidad, precio_total, totalValores  FROM cotizacion WHERE documentoId = '" . $_GET['id'] . "'");

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
                    font-family: sans-serif;
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
                
                footer {
                    text-align: center;
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
                    <p>Girardota, '.obtenerFechaActual().'. <br>
                    Cordial saludo. <br>
                    Envío cotización.</p>
                </div>

                <div class="segundaSeccion">
                    CLIENTE <br>
                    <span class="cliente">' . $nombreCliente . '</span>
                    <br><br><br>
                    ALCANCE DE LA OBRA <br>
                    <span class="alcanceObra">'.$fila['alcanceObra'].'</span>
                    <br><br>
                    <span>Somos una sociedad con una amplia experiencia en el mercado ofreciendo
                    seguridad y calidad en cada una de nuestras obras. Para nosotros es un placer
                    brindarles nuestros servicios con desempeño y responsabilidad.</span>
                    <br><br><br><br>
                    <span class="tituloNuestraResponsabilidad">Nuestra responsabilidad</span>
                    <ul>
                        <li>Personal calificado en cada una de las labores.</li>
                        <li>Nuestro personal cuenta con su seguridad social y curso de altura.</li>
                        <li>Suministro de equipos necesarios para la obra.</li>
                        <li>Recolección de residuo generados en la obra..</li>
                    </ul>
                </div>
                <br><br><br><br><br><br><br><br>
                <footer>
                    <span>CARRERA 17#7-121 LOCAL 101 EDIFICIO LAS ACACIAS GIRARDOTA <br>
                    TELÉFONOS 3668720 - 3128949012
                    </span>
                </footer>
                <br><br><br><br><br><br>
            </div>
            <div>
                <header class="imgPortada" style="text-align: center;">
                    <img src="' . __DIR__ . '/img/logo.jpeg" alt="Logo Castros Solucion" style="width:300px;">
                </header><br>
                <br><br>
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
                </table><br><br>
                <div class="firmaElectronica">
                    <img src="'.  __DIR__ . '/img/firmaElectronica.jpeg" style="width:200px"><br>
                    <span>JUAN FERNANDO CASTRO HERNANDEZ</span><br>
                    <span>CONTRATISTA</span>
                </div><br>
                <footer>
                    <span>CARRERA 17#7-121 LOCAL 101 EDIFICIO LAS ACACIAS GIRARDOTA <br>
                    TELÉFONOS 3668720 - 3128949012
                    </span>
                </footer>
            </div>
        </body>
        </html>';
    } else {
        echo '<script>alert("No se encontraron datos para crear el PDF");window.close();</script>';
        exit;
    }

    return $html;
}

$mpdf = new \Mpdf\Mpdf();
$mpdf->setFooter('{PAGENO}');

$html = plantillaCotizacion();

$mpdf->WriteHTML($html);
$mpdf->Output('archivo.pdf', \Mpdf\Output\Destination::INLINE);
?>
