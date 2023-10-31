<!DOCTYPE html>
<html lang="en">
    <body> 
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <div class="contenedor">
            <br>
            <h4 style="color: #00535E;font-weight:bold">Listado - Documento Cotizaciones</h4>
            <p>Visualice los documentos Cotizaciones creados. </p>
            <form id="formCotizacion" autocomplete="off">
            <?php
                include_once("config.php"); 
                include_once("sql.php"); 

                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM cotizacion WHERE documentoId = $id"; // Reemplaza con tu consulta SQL
                    $resultado = sqlQuerySelect($sql); // Utiliza tu función sqlQuerySelect

                    if ($resultado) {
                        $fila = $resultado->fetch_assoc();
                        // Asigna los valores a las variables
                        $documentoId = $fila['documentoId'];
                        $organizacionEmpresas = $fila['organizacionEmpresas'];
                        $dias = $fila['dias'];
                        $manoObra = $fila['manoObra'];
                        $porcentajeAdmin = $fila['porcentajeAdmin'];
                        $porcentajeUtilidad = $fila['porcentajeUtilidad'];
                        $alquilerEquipos = $fila['alquilerEquipos'];
                        $transporte = $fila['transporte'];
                        
                        // Asigna los demás campos según sea necesario

                        // Muestra los valores en los campos del formulario
                        echo '<div class="card">';
                        echo '<div class="card-header bg-primary text-white" style="font-weight: bold">Información general</div>';
                        echo '<div class="card-body">';
                        echo '<input type="text" class="form-control" id="documentoId" name="documentoId" value="' . $documentoId . '">';
                        echo '<div class="row">';
                        echo '<div class="form-group col-6 campo">';
                        echo '<label for="organizacionEmpresas">Cliente</label>';
                        echo '<input type="text" class="form-control campoFormulario" id="organizacionEmpresas" value="' . $organizacionEmpresas . '">';
                        echo '</div>';
                        echo '<div class="col-lg-12 campo">';
                        echo ' <button id="add-row-button" class="btn btn-primary btn-sm" type="button" onclick="agregarFila()">+</button><table id="dynamic-table">';
                        echo '<thead>
                                <tr>
                                    <td>Materiales</td>
                                    <td>M<sub>2</sub> - Unidades M Lineal</td>
                                    <td>Precio unitario</td>
                                    <td>Cantidad</td>
                                    <td>Precio total</td>
                                </tr>
                            </thead>
                            <tbody>';
                            while ($fila = $resultado->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td style="width:380px"><input type="text" class="form-control campoFormulario" id="materiales" value="' . $fila['material'] . '"></td>';
                                echo '<td><input type="text" class="form-control campoFormulario" id="metrosUnidades" value="' . $fila['metros_unidades'] . '"></td>';
                                echo '<td style="width:140px"><input type="text" class="form-control campoFormulario" id="precioUnitario" value="' . $fila['precio_unitario'] . '"></td>';
                                echo '<td style="width:80px"><input type="text" class="form-control campoFormulario campoNumero" id="cantidad" value="' . $fila['cantidad'] . '"></td>';
                                echo '<td style="width:140px"><input type="text" class="form-control campoFormulario" id="precioTotal" value="' . $fila['precio_total'] . '"></td>';
                                echo '<td><input type="text" class="form-control campoFormulario" id="precioTotal_1"></td>';
                                echo '</tr>';
                            }
                        echo '</tbody>';
                        echo '</thead></table>';
                        echo '<div class="row">';
                        echo '<div class="form-group col-md-2 campo">';
                        echo '<label for="dias">Días</label>';
                        echo '<input type="text" class="form-control campoFormulario" id="dias" value="' . $dias . '">';
                        echo '</div></div>';
                        echo '<div class="row">';
                        echo '<div class="form-group col-md-5 campo">';
                        echo '<label for="manoObra">Mano de obra</label>';
                        echo '<input type="text" class="form-control campoFormulario" id="manoObra" value="' . $manoObra . '">';
                        echo '</div>';
                        echo '<div class="form-group col-md-5 campo">';
                        echo '<label for="porcentajeAdmin">Porcentaje admin</label>';
                        echo '<input type="text" class="form-control campoFormulario" id="porcentajeAdmin" value="' . $porcentajeAdmin . '">';
                        echo '</div></div>';
                        echo '<div class="row">';
                        echo '<div class="form-group col-md-5 campo">';
                        echo '<label for="porcentajeUtilidad">Porcentaje utilidad</label>';
                        echo '<input type="text" class="form-control campoFormulario" id="porcentajeUtilidad" value="' . $porcentajeUtilidad . '">';
                        echo '</div>';
                        echo '<div class="form-group col-md-3 campo">';
                        echo '<label for="alquilerEquipos">Alquiler de equipos</label>';
                        echo '<input type="text" class="form-control campoFormulario" id="alquilerEquipos" value="' . $alquilerEquipos . '">';
                        echo '</div>';
                        echo '<div class="form-group col-md-3 campo">';
                        echo '<label for="transporte">Transporte</label>';
                        echo '<input type="text" class="form-control campoFormulario" id="transporte" value="' . $transporte . '">';
                        echo '</div>';
                        echo '</div>';
                        // Continúa con los demás campos del formulario

                        // Cierra el resultado
                        $resultado->close();
                    } else {
                        echo "Error en la consulta: " . $conn->error;
                    }
                }
            ?>
            </form>
        </div>
    </body>
</html>