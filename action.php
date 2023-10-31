<script src="js/menu.js"></script>
<?php 
    include_once('config.php');
    include_once("sql.php");
    include_once("functions.php");
    global $conn;
    conectarBaseDeDatos();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch($_POST['accion']){
            case 'I-cot':
                $documentoId = $_POST['documentoId'];

                $cliente = $_POST['organizacionEmpresas'];
                $dias = $_POST['dias'];
                $manoObra = $_POST['manoObra'];
                $porcentajeAdmin = $_POST['porcentajeAdmin'];
                $porcentajeUtilidad = $_POST['porcentajeUtilidad'];
                $alquilerEquipos = $_POST['alquilerEquipos'];
                $transporte = $_POST['transporte'];
                $stmt = $conn->prepare("INSERT INTO cotizacion (documentoId, organizacionEmpresas, dias, manoObra, porcentajeAdmin, porcentajeUtilidad, alquilerEquipos, transporte) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssss", $documentoId, $cliente, $dias, $manoObra, $porcentajeAdmin, $porcentajeUtilidad, $alquilerEquipos, $transporte);
                $stmt->execute();
                $contadorEjecuciones = 0;
                if ($stmt->affected_rows < 1) {
                    $mensaje = mostrarAlerta("Error al insertar los datos, inténtelo de nuevo más tarde.", "danger");
                    return;
                }else{
                    $contadorEjecuciones++;
                }

                $i = 1; // Inicializa el contador
                $rowCount = intval($_POST['rowCount']);

                for ($i = 0; $i < $rowCount; $i++) {
                    if($i == 0){
                        $materiales = $_POST['materiales'];
                        $metrosUnidades = $_POST['metrosUnidades'];
                        $precioUnitario = $_POST['precioUnitario'];
                        $cantidad = $_POST['cantidad'];
                        $precioTotal = $_POST['precioTotal'];
                    }else{
                        $materiales = $_POST['materiales_' . $i];
                        $metrosUnidades = $_POST['metrosUnidades_' . $i];
                        $precioUnitario = $_POST['precioUnitario_' . $i];
                        $cantidad = $_POST['cantidad_' . $i];
                        $precioTotal = $_POST['precioTotal_' . $i];
                    }
                    // Inserta los datos de la tabla dinámica en la base de datos, utilizando $documentoId para relacionarlos
                    $stmt = $conn->prepare("INSERT INTO cotizacion (documentoId, material, metros_unidades, precio_unitario, cantidad, precio_total) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $documentoId, $materiales, $metrosUnidades, $precioUnitario, $cantidad, $precioTotal);
                    $stmt->execute();
                    if ($stmt->affected_rows < 1) {
                        $mensaje = mostrarAlerta("Error al insertar los datos, inténtelo de nuevo más tarde.", "danger");
                        return;
                    }else{
                        $contadorEjecuciones++;
                    }
                }
                if($contadorEjecuciones >= 2){
                    $mensaje = mostrarAlerta("El documento se ha guardado correctamente.", "success");
                }
                echo $mensaje;
                break;
            case 'L-cot': 
                    $sql = sqlQuerySelect("SELECT id, documentoId, organizacionEmpresas, dias, manoObra FROM cotizacion GROUP BY documentoId;");
                    if($sql){
                        //Se construye la tabla HTML
                        $htmlTable = '<div class="table-responsive table-hover">';
                        $htmlTable .= '<table id="tablaCotizaciones" class="table table-bordered table-striped">';
                        $htmlTable .= '<thead class="bg-primary text-white">';
                        $htmlTable .= '<tr>';
                        $htmlTable .= '<th style="width:10px"></th><th>Id documento</th><th>Cliente</th><th>Días</th><th>Mano de obra</th><th style="width:10px"></th>';
                        $htmlTable .= '</tr>';
                        $htmlTable .= '</thead>';
                        $htmlTable .= '<tbody>';
                        for ($i = 0; $row = $sql->fetch_assoc(); $i++) {
                            $htmlTable .= '<tr>';
                            $htmlTable .= '<td><a onclick="listarDocumentos(\'mostrarCotizacion.php?id='.$row['documentoId'].'\'); return false;">Ver Cotización</a></td>';
                            $htmlTable .= '<td>' . $row['documentoId'] . '</td>';
                            $htmlTable .= '<td>' . $row['organizacionEmpresas'] . '</td>';
                            $htmlTable .= '<td>' . $row['dias'] . '</td>';
                            $htmlTable .= '<td>' . $row['manoObra'] . '</td>';
                            $htmlTable .= '<td><a href="pdf.php?id='.$row['documentoId'].'" target="_blank">Descargar PDF</a></td>';
                            $htmlTable .= '</tr>';
                        }
                        $htmlTable .= '</tbody>';
                        $htmlTable .= '</table>';
                        $htmlTable .= '</div>';
                        echo $htmlTable;
                    }else{
                        echo mostrarAlerta("Hubo un error al obtener la consulta para el documento Cotización", "danger");
                    }
                break;
        }   
    }
?>