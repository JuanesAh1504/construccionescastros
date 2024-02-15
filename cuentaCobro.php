<body onload="generarNumeroAleatorio()">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <div class="contenedor">
        <?php
            include_once("config.php"); 
            include_once("sql.php"); 
            $esEdicion = false;

            if (isset($_GET['consecutivo']) && isset($_GET['Cliente'])) {
                $consecutivo = $_GET['consecutivo'];
                $Cliente = $_GET['Cliente'];
                $sql = "SELECT DISTINCT Cliente, consecutivo_cliente, Fecha FROM cuentacobro";
                $resultado = sqlQuerySelect($sql); // Utiliza tu función sqlQuerySelect
                if ($resultado) {
                    $fila = $resultado->fetch_assoc();
                    $esEdicion = true;
                }
            }
        ?> 
        <form id="formCotizacion" autocomplete="off">
            <br>
            <h4 style="color: #00535E;font-weight:bold"><?php if($esEdicion){echo 'Edite ';}else{echo 'Ingrese ';}?>los datos de Cuenta de cobro</h4>
            <p><?php if($esEdicion){echo 'Edite ';}else{echo 'Cree ';}?>cuentas de cobro y lleve un mejor control.</p>
            <div class="card">
                <div class="card-header bg-primary text-white" style="font-weight:bold">
                    Información general
                </div>
                <div class="card-body formulario">
                    <div class="row">
                        <div class="col-md-3 campo obligatorio">
                            <label for="Fecha">Fecha</label>
                            <input type="date" id="Fecha" class="form-control" value="<?php if($esEdicion){echo $fila['Fecha'];}else{ echo obtenerFechaActualInput();}?>">
                        </div>
                        <div class="col-5 campo obligatorio">
                            <label for="Cliente">Cliente</label>
                            <select id="Cliente" class="campoFormulario obligatorio form-control">
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
                                        $selected = '';
                                        if($esEdicion){
                                            $selected = ($Cliente == $row['numeroDocumento']) ? 'selected' : '';
                                        }
                                        echo '<option value="'.$row['numeroDocumento'].'" '.$selected.'>'.$nombreCompleto.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 campo">
                            <input type="hidden" id="rowCount" value="1">
                            <div class="table-responsive">
                                <table id="conceptosCuentaCobro">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th>Concepto</th>
                                            <th>Precio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            if($esEdicion){
                                                $sql = "SELECT Fecha, concepto, precio FROM cuentacobro WHERE consecutivo_cliente = $consecutivo AND Cliente = $Cliente";
                                                $resultado = sqlQuerySelect($sql);

                                                if ($resultado) {
                                                    $rowCount = 0; // Inicializar el contador de filas

                                                    while ($fila = $resultado->fetch_assoc()) {
                                                        if ($fila['Fecha'] !== '') {
                                                            continue;
                                                        }
                                                        if ($fila['concepto'] == 'Total Cuenta de cobro:') {
                                                            continue;
                                                        }
                                                        echo '<tr>';
                                                        echo '<td><input type="text" class="inputPersonalizado campoFormulario obligatorio" id="concepto';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '" value="' . $fila['concepto'] . '"></td>';
                                                        echo '<td><input type="text" class="inputPersonalizado campoFormulario" id="precioTotal';
                                                        echo $rowCount > 0 ? '_' . $rowCount : '';
                                                        echo '" value="' . $fila['precio'] . '"></td>';
                                                        echo '</tr>';
                                                        $rowCount++; // Incrementar el contador de filas
                                                    }
                                                }

                                            }else{ ?>
                                                    <tr>
                                                        <td><input type="text" class="inputPersonalizado campoFormulario obligatorio" id="concepto"></td>
                                                        <td><input type="text" class="inputPersonalizado campoFormulario" id="precioTotal" onchange="cuentaCobroTotal();formatoPesoColombiano(this)"></td>
                                                    </tr>
                                            <?php }?>
                                        <tr class="addNuevaFila">
                                            <button id="add-row-button" class="btn btn-primary btn-sm" type="button" onclick="duplicarFilas('#conceptosCuentaCobro', 1)">+</button>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr id="sum-row" style="text-align:center">
                                            <td>Total:</td>
                                            <td id="totalCuentaCobro" style="font-weight:bold"></td>
                                            <input type="hidden" class="campoFormulario" id="totalCuentaCobroTitulo" value="Total Cuenta de cobro:">
                                            <input type="hidden" class="campoFormulario" id="totalCuentaCobroInput">
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div><br><br>
                    <button type="button" class="btn btn-primary" onclick="<?php if($esEdicion) {echo 'guardar(2, \'cuentaCobro\')';} else { echo 'guardar(1, \'cuentaCobro\')';} ?>">Enviar</button>

                </div>
            </div>
        </form>
    </div>
</body>