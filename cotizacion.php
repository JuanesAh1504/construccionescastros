    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <div class="contenedor">
        <?php
            include_once("config.php"); 
            include_once("sql.php"); 
            $esEdicion = false;

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM cotizacion WHERE documentoId = $id"; // Reemplaza con tu consulta SQL
                $resultado = sqlQuerySelect($sql); // Utiliza tu función sqlQuerySelect

                if ($resultado) {
                    $fila = array();
                    while($fila = $resultado->fetch_assoc()){
                        if($fila['material'] == '' && $fila['metros_unidades'] == '' && $fila['precio_unitario'] == '' && $fila['cantidad'] == '' && $fila['precio_total'] == ''){
                            $fechaInicio = $fila['fechaCotizacion'];
                            $fechaCotizacionFin = $fila['fechaCotizacionFin'];
                            $cliente = $fila['organizacionEmpresas'];
                            $alcanceObra = $fila['alcanceObra'];
                            $totalNetoInput = $fila['totalNetoInput'];
                            $totalIVAInput = $fila['totalIVAInput'];
                            $totalRetefuenteTablaInput = $fila['totalRetefuenteTablaInput'];
                            $totalPorTodoTablaInput = $fila['totalPorTodoTablaInput'];
                            $dias = $fila['dias'];
                            $manoObra = $fila['manoObra'];
                            $porcentajeAdmin = $fila['porcentajeAdmin'];
                            $porcentajeUtilidad = $fila['porcentajeUtilidad'];
                            $alquilerEquipos = $fila['alquilerEquipos'];
                            $transporte = $fila['transporte'];
                            $elementosProteccion = $fila['elementosProteccion'];
                            $Dotacion = $fila['Dotacion'];
                            $Porcentaje1 = $fila['Porcentaje1'];
                            $Porcentaje2 = $fila['Porcentaje2'];
                            $Porcentaje3 = $fila['Porcentaje3'];
                            $Porcentaje4 = $fila['Porcentaje4'];
                            $valorTotalCotizacion = $fila['valorTotalCotizacion'];
                        }
                    }
                    $esEdicion = true;
                }
            }
        ?> 
        <form id="formCotizacion" autocomplete="off">
            <br>
            <h4 style="color: #00535E;font-weight:bold"><?php if($esEdicion){echo 'Edite ';}else{echo 'Ingrese ';}?>los datos de Cotización</h4>
            <p><?php if($esEdicion){echo 'Edite ';}else{echo 'Cree ';}?>cotizaciones de todos tus productos o servicios y lleva un mejor control.</p>
            <div class="card">
                <div class="card-header bg-primary text-white" style="font-weight:bold">
                    Información general
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Id documento</label>
                            <input type="text" class="form-control obligatorio" id="documentoId" name="documentoId" value="<?php if($esEdicion){echo $id;}?>" readonly>
                        </div>
                        <div class="col-md-3 campo">
                            <label for="fechaCotizacion">Fecha inicio</label>
                            <input type="date" class="form-control campoFormulario obligatorio" id="fechaCotizacion" onchange="calcularDiferenciaEnDias();" name="fechaCotizacion" value="<?php if($esEdicion){echo $fechaInicio; }?>">
                        </div>
                        <div class="col-md-3 campo">
                            <label for="fechaCotizacion">Fecha fin</label>
                            <input type="date" class="form-control campoFormulario obligatorio" id="fechaCotizacionFin" onchange="calcularDiferenciaEnDias();" value="<?php if($esEdicion){echo $fechaCotizacionFin;}?>">
                        </div>
                    </div>
                    <input type="hidden" class="campoFormulario" value="1" id="rowCount">
                    <div class="row">
                        <div class="form-group col-6 campo">
                            <label for="organizacionEmpresas">Cliente</label>
                            <select id="organizacionEmpresas" class="campoFormulario obligatorio form-control">
                                <option value=""></option>
                                <?php 
                                    $sqlClientes = "SELECT primerNombre, segundoNombre, primerApellido, segundoApellido, razonSocial, numeroDocumento FROM clientes"; // Reemplaza con tu consulta SQL
                                    $resultado = sqlQuerySelect($sqlClientes); // Utiliza tu función sqlQuerySelect

                                    while ($row = $resultado->fetch_assoc()) {
                                        $nombreCompleto = '';

                                        if (!empty($row['primerNombre'])) {
                                            $nombreCompleto .= $row['primerNombre'];
                                        }
                                        if (!empty($row['segundoNombre'])) {
                                            $nombreCompleto .= (!empty($nombreCompleto) ? ' ' : '') . $row['segundoNombre'];
                                        }
                                        if (!empty($row['primerApellido'])) {
                                            $nombreCompleto .= (!empty($nombreCompleto) ? ' ' : '') . $row['primerApellido'];
                                        }
                                        if (!empty($row['segundoApellido'])) {
                                            $nombreCompleto .= (!empty($nombreCompleto) ? ' ' : '') . $row['segundoApellido'];
                                        }

                                        // Si todos los campos de nombre y apellido están vacíos, utilizar la razón social
                                        if (empty($nombreCompleto)) {
                                            $nombreCompleto = $row['razonSocial'];
                                        }
                                        $selected = ($cliente == $row['numeroDocumento']) ? 'selected' : '';
                                        echo '<option value="'.$row['numeroDocumento'].'" '.$selected.'>'.$nombreCompleto.'</option>';
                                    }
                                ?>
                            </select>

                        </div>
                        <div class="form-group col-6 campo">
                            <label for="alcanceObra">Alcance de obra</label>
                            <input type="text" class="form-control campoFormulario obligatorio" id="alcanceObra" value="<?php if($esEdicion){echo $alcanceObra;}?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 campo">
                            <div class="table-responsive">
                                <table id="dynamic-table">
                                    <thead style="text-align:center;">
                                        <tr>
                                            <th>Concepto</th>
                                            <th>M<sub>2</sub> - Unidades M Lineal</th>
                                            <th>Precio unitario</th>
                                            <th>Cantidad</th>
                                            <th>Valor neto</th>
                                            <th>Valor impuesto</th>
                                            <th>Valor IVA</th>
                                            <th>% Retefuente</th>
                                            <th>Valor retefuente</th>
                                            <th>Valor total</th>
                                            <th>Valor incluido demás gastos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if($esEdicion){
                                                $sql = "SELECT * FROM cotizacion WHERE documentoId = $id";
                                                $resultado = sqlQuerySelect($sql);

                                                if ($resultado) {
                                                    $rowCount = 0; // Inicializar el contador de filas

                                                    while ($fila = $resultado->fetch_assoc()) {
                                                        if ($fila['material'] == '' && $fila['metros_unidades'] == '' &&
                                                            $fila['precio_unitario'] == '' && $fila['cantidad'] == '' && $fila['precio_total'] == '') {
                                                            continue;
                                                        }

                                                        echo '<tr>';
                                                        echo '<td style="width:380px"><input type="text" class="inputPersonalizado campoFormulario obligatorio" id="materiales';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '" value="' . $fila['material'] . '"></td>';
                                                        echo '<td><input type="text" class="inputPersonalizado campoFormulario" id="metrosUnidades';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '" value="' . $fila['metros_unidades'] . '"></td>';
                                                        echo '<td><input style="width:110px" type="text" class="inputPersonalizado campoFormulario obligatorio" id="precioUnitario';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '" onchange="formatoPesoColombiano(this);calcularFormula(\'cantidad';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'precioUnitario';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\');calcularIva(\'precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'iva';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'totalIva';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\');calcularRetefuente(\'precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'retefuente';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'totalRetefuente';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\');valorTotal([\'#precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'#totalIva';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'#totalRetefuente';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\'], \'totalPorTodo';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\');sumarPrecioTotal();calcularCamposAdicionales();" value="' . $fila['precio_unitario'] . '"></td>';
                                                        echo '<td><input style="width:70px" type="text" class="inputPersonalizado campoFormulario campoNumero obligatorio" id="cantidad';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '" value="1" onchange="calcularFormula(\'precioUnitario';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'cantidad';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\');calcularIva(\'precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'iva';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'totalIva';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\');calcularRetefuente(\'precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'retefuente';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'totalRetefuente';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\');valorTotal([\'#precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'#totalIva';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'#totalRetefuente';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\'], \'totalPorTodo';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\');sumarPrecioTotal();calcularCamposAdicionales();" value="' . $fila['cantidad'] . '"></td>';
                                                        echo '<td><input style="width:110px" type="text" class="inputPersonalizado campoFormulario" id="precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '" disabled value="' . $fila['precio_total'] . '"></td>';
                                                        echo '<td><input style="width:110px" type="text" class="inputPersonalizado campoFormulario" id="iva';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '" onchange="calcularIva(\'precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'iva';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'totalIva';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\');valorTotal([\'#precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'#totalIva';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'#totalRetefuente';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\'], \'totalPorTodo';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\');sumarPrecioTotal();calcularCamposAdicionales();" value="' . $fila['iva'] . '"></td>';
                                                        echo '<td><input style="width:110px" type="text" id="totalIva';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '" class="inputPersonalizado campoFormulario" disabled value="' . $fila['totalIva'] . '"></td>';
                                                        echo '<td><input style="width:110px" type="text" class="inputPersonalizado campoFormulario" id="retefuente';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '" onchange="calcularRetefuente(\'precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'retefuente';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'totalRetefuente';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\');valorTotal([\'#precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'#totalIva';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\', \'#totalRetefuente';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\'], \'totalPorTodo';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '\');sumarPrecioTotal();calcularCamposAdicionales();" value="' . $fila['retefuente'] . '"></td>';
                                                        echo '<td><input style="width:110px" type="text" id="totalRetefuente';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '" class="inputPersonalizado campoFormulario" disabled value="' . $fila['totalRetefuente'] . '"></td>';
                                                        echo '<td><input style="width:110px" type="text" id="totalPorTodo';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '" class="inputPersonalizado campoFormulario" onchange="" disabled value="' . $fila['totalPorTodo'] . '"></td>';
                                                        echo '<td><input style="width:110px" type="text" id="totalIncluidoOtrosPrecios';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '" class="inputPersonalizado campoFormulario" onchange="" disabled value="' . $fila['totalValores'] . '"></td>';
                                                        echo '</tr>';
                                                        $rowCount++; // Incrementar el contador de filas
                                                    }
                                                }

                                        }else{ ?>
                                                <tr>
                                                    <td style="width:380px"><input type="text" class="inputPersonalizado campoFormulario obligatorio" id="materiales"></td>
                                                    <td><input type="text" class="inputPersonalizado campoFormulario" id="metrosUnidades"></td>
                                                    <td><input style="width:110px" type="text" class="inputPersonalizado campoFormulario obligatorio" id="precioUnitario" onchange="formatoPesoColombiano(this);calcularFormula('cantidad', 'precioUnitario', 'precioTotal');calcularIva('precioTotal', 'iva', 'totalIva');calcularRetefuente('precioTotal', 'retefuente', 'totalRetefuente');valorTotal(['#precioTotal', '#totalIva', '#totalRetefuente'], 'totalPorTodo');calcularCamposAdicionales();sumarPrecioTotal();"></td>
                                                    <td><input style="width:70px" type="text" class="inputPersonalizado campoFormulario campoNumero obligatorio" id="cantidad" value="1" onchange="calcularFormula('precioUnitario', 'cantidad', 'precioTotal');calcularIva('precioTotal', 'iva', 'totalIva');calcularRetefuente('precioTotal', 'retefuente', 'totalRetefuente');valorTotal(['#precioTotal', '#totalIva', '#totalRetefuente'], 'totalPorTodo');sumarPrecioTotal();calcularCamposAdicionales()"></td>
                                                    <td><input style="width:110px" type="text" class="inputPersonalizado campoFormulario" id="precioTotal" disabled></td>
                                                    <td><input style="width:110px" type="text" class="inputPersonalizado campoFormulario" id="iva" onchange="calcularIva('precioTotal', 'iva', 'totalIva');valorTotal(['#precioTotal', '#totalIva', '#totalRetefuente'], 'totalPorTodo');sumarPrecioTotal();calcularCamposAdicionales()"></td>
                                                    <td><input style="width:110px" type="text" id="totalIva" class="inputPersonalizado campoFormulario" disabled></td>
                                                    <td><input style="width:110px" type="text" class="inputPersonalizado campoFormulario" id="retefuente" onchange="calcularRetefuente('precioTotal', 'retefuente', 'totalRetefuente');valorTotal(['#precioTotal', '#totalIva', '#totalRetefuente'], 'totalPorTodo');sumarPrecioTotal();calcularCamposAdicionales()"></td>
                                                    <td><input style="width:110px" type="text" id="totalRetefuente" class="inputPersonalizado campoFormulario" disabled></td>
                                                    <td><input style="width:110px" type="text" id="totalPorTodo" class="inputPersonalizado campoFormulario" onchange="" disabled></td>
                                                    <td><input style="width:110px" type="text" id="totalIncluidoOtrosPrecios" class="inputPersonalizado campoFormulario" onchange="" disabled></td>
                                                </tr>
                                        <?php }?>
                                        <tr class="addNuevaFila">
                                            <button id="add-row-button" class="btn btn-primary btn-sm" type="button" onclick="agregarFila()">+</button>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr id="sum-row" style="text-align:center">
                                            <td>Total:</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td id="totalNeto" style="font-weight:bold"></td>
                                            <td></td>
                                            <td id="totalIVA" style="font-weight:bold"></td>
                                            <td></td>
                                            <td id="totalRetefuenteTabla" style="font-weight:bold"></td>
                                            <td id="totalPorTodoTabla" style="font-weight:bold"></td>
                                            <td id="totalValoresIncluidos" style="font-weight:bold"></td>
                                            <input type="hidden" class="campoFormulario" id="totalNetoInput">
                                            <input type="hidden" class="campoFormulario" id="totalIVAInput">
                                            <input type="hidden" class="campoFormulario" id="totalRetefuenteTablaInput">
                                            <input type="hidden" class="campoFormulario" id="totalPorTodoTablaInput">
                                            <input type="hidden" class="campoFormulario" id="totalValoresIncluidosInput">
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <input type="hidden" id="rowCount" value="1">
                    </div><br>
                    <div class="row">
                        <div class="form-group col-md-2 campo">
                            <label for="dias">Días</label>
                            <input type="text" class="form-control campoFormulario obligatorio" readonly id="dias" value="<?php if($esEdicion){echo $dias;}?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-5 campo">
                            <label for="mano-obra">Mano de obra</label>
                            <input type="text" class="form-control campoFormulario" id="manoObra" onchange="formatoPesoColombiano(this);sumarPrecioTotal();calcularCamposAdicionales();" value="<?php if($esEdicion){echo $manoObra;}?>">
                        </div>
                        <div class="form-group col-md-5 campo">
                            <label for="porcentaje-admin">Porcentaje admin</label>
                            <input type="text" class="form-control campoFormulario" id="porcentajeAdmin"onchange="calcularCamposAdicionales()" value="<?php if($esEdicion){echo $porcentajeAdmin;}?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-5 campo">
                            <label for="porcentaje-utilidad">Porcentaje utilidad</label>
                            <input type="text" class="form-control campoFormulario" id="porcentajeUtilidad" onchange="formatoPesoColombiano(this);calcularCamposAdicionales()" value="<?php if($esEdicion){echo $porcentajeUtilidad;}?>">
                        </div>
                        <div class="form-group col-md-3 campo">
                            <label for="alquiler-equipos">Alquiler de equipos</label>
                            <input type="text" class="form-control campoFormulario" id="alquilerEquipos" onchange="formatoPesoColombiano(this);calcularCamposAdicionales()" value="<?php if($esEdicion){echo $alquilerEquipos;}?>">
                        </div>
                        <div class="form-group col-md-3 campo">
                            <label for="transporte">Transporte</label>
                            <input type="text" class="form-control campoFormulario" id="transporte" onchange="formatoPesoColombiano(this);calcularCamposAdicionales()" value="<?php if($esEdicion){echo $transporte;}?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-3 campo">
                            <label for="elementosProteccion">Elementos de protección</label>
                            <input type="text" class="form-control campoFormulario" id="elementosProteccion" onchange="formatoPesoColombiano(this);sumarPrecioTotal();calcularCamposAdicionales()" value="<?php if($esEdicion){echo $elementosProteccion;}?>">
                        </div>
                        <div class="form-group col-md-3 campo">
                            <label for="Dotacion">Dotacion</label>
                            <input type="text" class="form-control campoFormulario" id="Dotacion" onchange="formatoPesoColombiano(this);calcularCamposAdicionales()" value="<?php if($esEdicion){echo $Dotacion;}?>">
                        </div>
                        <div class="form-group col-md-1 campo">
                            <label for="Porcentaje1">P1</label>
                            <input type="text" style="text-align:center" class="form-control campoFormulario" id="Porcentaje1" value="<?php if($esEdicion){echo $Porcentaje1;}?>">
                        </div>
                        <div class="form-group col-md-1 campo">
                            <label for="Porcentaje2">P2</label>
                            <input type="text" style="text-align:center" class="form-control campoFormulario" id="Porcentaje2" value="<?php if($esEdicion){echo $Porcentaje2;}?>">
                        </div>
                        <div class="form-group col-md-1 campo">
                            <label for="Porcentaje3">P3</label>
                            <input type="text" style="text-align:center" class="form-control campoFormulario" id="Porcentaje3" value="<?php if($esEdicion){echo $Porcentaje3;}?>">
                        </div>
                        <div class="form-group col-md-1 campo">
                            <label for="Porcentaje4">P4</label>
                            <input type="text" style="text-align:center" class="form-control campoFormulario" id="Porcentaje4" value="<?php if($esEdicion){echo $Porcentaje4;}?>">
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="form-group col-md-2 campo">
                            <label for="valorTotalCotizacion">Valor total cotización</label>
                            <input type="text" class="form-control campoFormulario obligatorio" id="valorTotalCotizacion" readonly value="<?php if($esEdicion){echo $valorTotalCotizacion;}?>">
                        </div>
                    </div><br>
                    <button type="button" class="btn btn-primary" onclick="validarFormulario('formCotizacion','<?php if(!$esEdicion){echo 'I-cot';}else{echo 'U-cot';}?>')">Enviar</button>
                </div>
            </div>
        </form>
    </div>  