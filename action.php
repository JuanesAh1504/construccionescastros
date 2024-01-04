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
                $fechaCotizacion = $_POST['fechaCotizacion'];
                $fechaCotizacionFin = $_POST['fechaCotizacionFin'];
                $cliente = $_POST['organizacionEmpresas'];
                $alcanceObra = $_POST['alcanceObra'];
                $totalNetoInput = $_POST['totalNetoInput'];
                $totalIVAInput = $_POST['totalIVAInput'];
                $totalRetefuenteTablaInput = $_POST['totalRetefuenteTablaInput'];
                $totalPorTodoTablaInput = $_POST['totalPorTodoTablaInput'];
                $totalValoresIncluidosInput = $_POST['totalValoresIncluidosInput'];
                $dias = $_POST['dias'];
                $manoObra = $_POST['manoObra'];
                $porcentajeAdmin = $_POST['porcentajeAdmin'];
                $porcentajeUtilidad = $_POST['porcentajeUtilidad'];
                $alquilerEquipos = $_POST['alquilerEquipos'];
                $transporte = $_POST['transporte'];
                $elementosProteccion = $_POST['elementosProteccion'];
                $Dotacion = $_POST['Dotacion'];
                $Porcentaje1 = $_POST['Porcentaje1'];
                $Porcentaje2 = $_POST['Porcentaje2'];
                $Porcentaje3 = $_POST['Porcentaje3'];
                $Porcentaje4 = $_POST['Porcentaje4'];   
                $valorTotalCotizacion = $_POST['valorTotalCotizacion'];
                $estado = 0;
                $stmt = $conn->prepare("INSERT INTO cotizacion (documentoId, fechaCotizacion, fechaCotizacionFin, organizacionEmpresas, alcanceObra, totalNetoInput, totalIVAInput, totalRetefuenteTablaInput, totalPorTodoTablaInput, dias, manoObra, porcentajeAdmin, porcentajeUtilidad, alquilerEquipos, transporte, elementosProteccion, Dotacion, Porcentaje1, Porcentaje2, Porcentaje3, Porcentaje4, valorTotalCotizacion, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssssssssssssssssssss", $documentoId, $fechaCotizacion, $fechaCotizacionFin, $cliente, $alcanceObra, $totalNetoInput, $totalIVAInput, $totalRetefuenteTablaInput, $totalPorTodoTablaInput, $dias, $manoObra, $porcentajeAdmin, $porcentajeUtilidad, $alquilerEquipos, $transporte, $elementosProteccion, $Dotacion, $Porcentaje1, $Porcentaje2, $Porcentaje3, $Porcentaje4, $valorTotalCotizacion, $estado);
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
                        $iva = $_POST['iva'];
                        $totalIva = $_POST['totalIva'];
                        $retefuente = $_POST['retefuente'];
                        $totalRetefuente = $_POST['totalRetefuente'];
                        $totalPorTodo = $_POST['totalPorTodo'];
                        $totalValoresIncluidos = $_POST['totalIncluidoOtrosPrecios'];
                    }else{
                        $materiales = $_POST['materiales_' . $i];
                        $metrosUnidades = $_POST['metrosUnidades_' . $i];
                        $precioUnitario = $_POST['precioUnitario_' . $i];
                        $cantidad = $_POST['cantidad_' . $i];
                        $precioTotal = $_POST['precioTotal_' . $i];
                        $iva = $_POST['iva_' . $i];
                        $totalIva = $_POST['totalIva_' . $i];
                        $retefuente = $_POST['retefuente_' . $i];
                        $totalRetefuente = $_POST['totalRetefuente_' . $i];
                        $totalPorTodo = $_POST['totalPorTodo_' . $i];
                        $totalValoresIncluidos = $_POST['totalIncluidoOtrosPrecios_' . $i];
                    }
                    // Inserta los datos de la tabla dinámica en la base de datos, utilizando $documentoId para relacionarlos
                    $stmt = $conn->prepare("INSERT INTO cotizacion (documentoId, material, metros_unidades, precio_unitario, cantidad, precio_total, iva, totalIva, retefuente, totalRetefuente, totalPorTodo, totalValores) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssssssssss", $documentoId, $materiales, $metrosUnidades, $precioUnitario, $cantidad, $precioTotal, $iva, $totalIva, $retefuente, $totalRetefuente, $totalPorTodo, $totalValoresIncluidos);
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
            case 'D-filaCotizacion':
                $idFila = $_POST['id'];
                $sql = "DELETE FROM cotizacion WHERE id = '$idFila'";
                $resultado = sqlQueryDelete($sql);
                if($resultado){
                    $mensaje = mostrarAlerta("Se eliminó la fila de cotización exitosamente.", "success");
                }else{
                    $mensaje = mostrarAlerta("No fue posible eliminar la fila, intentelo nuevamente.", "danger");
                }
                echo $mensaje; 
                break;
            case 'L-cot': 
                    $sql = sqlQuerySelect("SELECT id, documentoId, organizacionEmpresas, fechaCotizacion, alcanceObra, dias, manoObra FROM cotizacion GROUP BY documentoId;");
                    if($sql){
                        //Se construye la tabla HTML
                        $htmlTable = '<div class="table-responsive table-hover">';
                        $htmlTable .= '<table id="tablaCotizaciones" class="table table-bordered table-striped">';
                        $htmlTable .= '<thead class="bg-primary text-white">';
                        $htmlTable .= '<tr>';
                        $htmlTable .= '<th style="width:10px"></th><th>Id documento</th><th>Cliente</th><th>Fecha de cotización</th><th>Alcance de la obra</th><th>Días</th><th>Mano de obra</th><th colspan="3"></th>';
                        $htmlTable .= '</tr>';
                        $htmlTable .= '</thead>';
                        $htmlTable .= '<tbody>';
                        for ($i = 0; $row = $sql->fetch_assoc(); $i++) {
                            $htmlTable .= '<tr id="'.$row['documentoId'].'">';
                            $htmlTable .= '<td><a style="color: #007bff" onclick="listarDocumentos(\'cotizacion.php?id='.$row['documentoId'].'\'); return false;"><center><i class="bx bxs-business"></i>Ver</a></center></td>';
                            $htmlTable .= '<td>' . $row['documentoId'] . '</td>';
                            $htmlTable .= '<td>' . $row['organizacionEmpresas'] . '</td>';
                            $htmlTable .= '<td>' . $row['fechaCotizacion'] . '</td>';
                            $htmlTable .= '<td>' . $row['alcanceObra'] . '</td>';
                            $htmlTable .= '<td>' . $row['dias'] . '</td>';
                            $htmlTable .= '<td>' . $row['manoObra'] . '</td>';
                            $htmlTable .= '<td style="width:5px"><a href="pdf.php?id=' . $row['documentoId'] . '&accion=cotizacionPDF" target="_blank"><center><i class="bx bxs-file-pdf"></i>PDF</center></a></td>';
                            $htmlTable .= '<td style="width:5px"><a href="contratoPDF.php?id=' . $row['documentoId'] . '" target="_blank" onclick="generarContrato(' . $row['documentoId'] . ');"><center><i class="bx bxs-file-pdf"></i>Generar contrato</center></a></td>';
                            $htmlTable .= '<td style="width:5px"><a onclick="eliminarRegistro(\'' . $row['documentoId'] . '\', \'cotizacion\')"><center><i class="bx bxs-trash"></i>Eliminar</center></a></td>';
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
            case 'D-doc':
                $sql = "DELETE FROM ".$_POST['tabla']." WHERE documentoId = '".$_POST['documento']."'";
                $resultado = sqlQueryDelete($sql);
                if($resultado){
                    $mensaje = mostrarAlerta("Se eliminó la fila exitosamente.", "success");
                }else{
                    $mensaje = mostrarAlerta("No fue posible eliminar la fila, intentelo nuevamente.", "danger");
                }
                echo $mensaje; 
                break;
            case 'U-cot':
                $documentoId = $_POST['documentoId'];
                $fechaCotizacion = $_POST['fechaCotizacion'];
                $metodoPagoCotizacion = $_POST['metodoPagoCotizacion'];
                $cliente = $_POST['organizacionEmpresas'];
                $alcanceObra = $_POST['alcanceObra'];
                $dias = $_POST['dias'];
                $iva = $_POST['iva'];
                $retefuente = $_POST['retefuente'];
                $manoObra = $_POST['manoObra'];
                $porcentajeAdmin = $_POST['porcentajeAdmin'];
                $porcentajeUtilidad = $_POST['porcentajeUtilidad'];
                $alquilerEquipos = $_POST['alquilerEquipos'];
                $transporte = $_POST['transporte'];
                $elementosProteccion = $_POST['elementosProteccion'];
                $Dotacion = $_POST['Dotacion'];
                $sql = "UPDATE cotizacion SET fechaCotizacion = '".$fechaCotizacion."', metodoPagoCotizacion = '".$metodoPagoCotizacion."', organizacionEmpresas = '".$cliente."', alcanceObra = '".$alcanceObra."', dias = '".$dias."', iva = '".$iva."', retefuente = '".$retefuente."', manoObra = '".$manoObra."', porcentajeAdmin = '".$porcentajeAdmin."', porcentajeUtilidad = '".$porcentajeUtilidad."', alquilerEquipos = '".$alquilerEquipos."', transporte = '".$transporte."', elementosProteccion = '".$elementosProteccion."', Dotacion = '".$Dotacion."' WHERE documentoId = '".$documentoId."'"; 
                $sql = sqlInsertUpdate($sql);
                if($sql){
                    $mensaje = mostrarAlerta("Se editó el documento correctamente.", "success");
                }else{
                    $mensaje = mostrarAlerta("No fue posible editar el documento.", "danger");
                }
                echo $mensaje; 
                break;
            case 'I-cliente':
                $documentoId = $_POST['documentoId'];
                $tipoContribuyente = $_POST['tipoContribuyente'];
                $regimen = $_POST['regimen'];
                $nombreComercial = $_POST['nombreComercial'];
                $tipoDocumento = $_POST['tipoDocumento'];
                $numeroDocumento = $_POST['numeroDocumento'];
                $primerNombre = $_POST['primerNombre'];
                $segundoNombre = $_POST['segundoNombre'];
                $primerApellido = $_POST['primerApellido'];
                $segundoApellido = $_POST['segundoApellido'];
                $razonSocial = $_POST['razonSocial'];
                $ciudad = $_POST['ciudad'];
                $direccion = $_POST['direccion'];
                $telefonoCelular = $_POST['telefonoCelular'];
                $correoElectronico = $_POST['correoElectronico'];
                $stmt = $conn->prepare("INSERT INTO clientes (documentoId, tipoContribuyente, regimen, nombreComercial, tipoDocumento, numeroDocumento, primerNombre, segundoNombre, primerApellido, segundoApellido, razonSocial, ciudad, direccion, telefonoCelular, correoElectronico) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssssssssssss", $documentoId, $tipoContribuyente, $regimen, $nombreComercial, $tipoDocumento, $numeroDocumento, $primerNombre, $segundoNombre, $primerApellido, $segundoApellido, $razonSocial, $ciudad, $direccion, $telefonoCelular, $correoElectronico);
                $stmt->execute();
                $contadorEjecuciones = 0;
                if ($stmt->affected_rows >= 1) {
                    $mensaje = mostrarAlerta("Se creó el usuario correctamente.", "success");
                }else{
                    $mensaje = mostrarAlerta("Error al insertar los datos, inténtelo de nuevo más tarde.", "danger");
                }
                echo $mensaje;
                break;
            case 'L-clientes':
                $sql = sqlQuerySelect("SELECT documentoId, tipoContribuyente, tipoDocumento, numeroDocumento, primerNombre, primerApellido, razonSocial, ciudad, telefonoCelular, correoElectronico FROM clientes");
                if($sql){
                    //Se construye la tabla HTML
                    $htmlTable = '<div class="table-responsive table-hover">';
                    $htmlTable .= '<table id="tablaCotizaciones" class="table table-bordered table-striped">';
                    $htmlTable .= '<thead class="bg-primary text-white">';
                    $htmlTable .= '<tr>';
                    $htmlTable .= '<th style="width:10px"></th><th>Id documento</th><th>Tipo de contribuyente</th><th>Tipo documento</th><th>Número de documento</th><th>Primer nombre</th><th>Primer apellido</th><th>Razón social</th><th>Ciudad</th><th>Teléfono - Celular</th><th>Correo electrónico</th><th></th>';
                    $htmlTable .= '</tr>';
                    $htmlTable .= '</thead>';
                    $htmlTable .= '<tbody>';
                    for ($i = 0; $row = $sql->fetch_assoc(); $i++) {
                        $htmlTable .= '<tr id="'.$row['documentoId'].'">';
                        $htmlTable .= '<td><a onclick="listarDocumentos(\'crearCliente.php?id='.$row['documentoId'].'\'); return false;"><center><i class="bx bxs-business"></i>Ver</a></center></td>';
                        $htmlTable .= '<td>' . $row['documentoId'] . '</td>';
                        $htmlTable .= '<td>' . $row['tipoContribuyente'] . '</td>';
                        $htmlTable .= '<td>' . $row['tipoDocumento'] . '</td>';
                        $htmlTable .= '<td>' . $row['numeroDocumento'] . '</td>';
                        $htmlTable .= '<td>' . $row['primerNombre'] . '</td>';
                        $htmlTable .= '<td>' . $row['primerApellido'] . '</td>';
                        $htmlTable .= '<td>' . $row['razonSocial'] . '</td>';
                        $htmlTable .= '<td>' . $row['ciudad'] . '</td>';
                        $htmlTable .= '<td>' . $row['telefonoCelular'] . '</td>';
                        $htmlTable .= '<td>' . $row['correoElectronico'] . '</td>';
                        $htmlTable .= '<td style="width:5px"><a onclick="eliminarRegistro(\'' . $row['documentoId'] . '\', \'clientes\')"><center><i class="bx bxs-trash"></i>Eliminar</center></a></td>';
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
            case 'actualizarEstadoContrato':
                $sql = sqlQuerySelect('UPDATE cotizacion SET estado = "1" WHERE documentoId = "'.$_POST['cotizacionID'].'"');
                if ($sql !== false && $conn->affected_rows > 0) {
                    echo mostrarAlerta("Se generó el contrato exitosamente", "success");
                } else {
                    echo mostrarAlerta("No se pudo actualizar el estado de la cotización.", "danger");
                }
                break;
            case 'I-pagoContrato':
                $documentoId = $_POST['documentoId'];
                $valorPago1 = $_POST['valorPago1'];
                $valorPago2 = $_POST['valorPago2'];
                $valorPago3 = $_POST['valorPago3'];
                $valorPago4 = $_POST['valorPago4'];
                $stmt = $conn->prepare("INSERT INTO contratosgenerados (numerocontrato, valorPago1, valorPago2, valorPago3, valorPago4) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $documentoId, $valorPago1, $valorPago2, $valorPago3, $valorPago4);
                $stmt->execute();
                if ($stmt->affected_rows >= 1) {
                    $mensaje = mostrarAlerta("Se agregó el pago de la contización exitosamente.", "success");
                }else{
                    $mensaje = mostrarAlerta("Hubo un error al agregar el pago del contrato.", "danger");
                }
                echo $mensaje;
                break;
            case 'SaveGastos':
                $i = 1; // Inicializa el contador
                $rowCount = intval($_POST['rowCountModal']);
                $contadorEjecuciones = 0;
                $datosRepetidos = false;
                for ($i = 0; $i < $rowCount; $i++) {
                    $numeralPorcentaje = $_POST['numeralPorcentaje'];
                    $porcentaje = $_POST['porcentaje'];
                    $idContrato = $_POST['idContrato'];
                    if($i == 0){
                        $producto = $_POST['producto'];
                        $precio = $_POST['precio'];
                    }else{
                        $producto = $_POST['producto_'.$i];
                        $precio = $_POST['precio_'.$i];
                    }
                    $verificarExistencia = sqlQuerySelect("SELECT idContrato, porcentaje, producto, precio FROM gastoscontratos WHERE idContrato = '".$idContrato."' AND producto = '".$producto."' AND precio = '".$precio."'");
                    if($verificarExistencia->num_rows <= 0){
                        $stmt = $conn->prepare("INSERT INTO gastoscontratos (numeralPorcentaje, porcentaje, idContrato, producto, precio) VALUES (?, ?, ?, ?, ?)");
                        $stmt->bind_param("sssss", $numeralPorcentaje,$porcentaje,$idContrato,$producto,$precio);
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
                $totalRestante = $_POST['totalRestante'];
                $verificarExistencia = sqlQuerySelect("SELECT total FROM gastoscontratos WHERE total = '".$totalRestante."'");
                if($verificarExistencia->num_rows <= 0){
                    $stmt = $conn->prepare("INSERT INTO gastoscontratos (total) VALUES (?)");
                    $stmt->bind_param("s", $totalRestante);
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
                    $mensaje = mostrarAlerta("Los datos se han guardado correctamente.", "success");
                }else if($datosRepetidos){
                    $mensaje = mostrarAlerta("Los datos ya están guardados.", "danger");
                }else{
                    $mensaje = mostrarAlerta("Ocurrió un problema al guardar los cambios.", "danger");
                }
                echo $mensaje;
                break;
        }   
    }
?>