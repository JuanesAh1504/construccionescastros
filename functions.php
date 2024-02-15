<?php 
    function mostrarAlerta($mensaje, $tipoAlerta){
        $arregloMensajeAMostrar = array($tipoAlerta => true, "message" => $mensaje);
        error_log(json_encode($arregloMensajeAMostrar));   
        return json_encode($arregloMensajeAMostrar);
    }
    function numeroALetras($numero) {
        $unidades = array('', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve');
        $decenas = array('', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa');
        $centenas = array('', 'cien', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos');
    
        $numero = str_replace('.', '', $numero); // Eliminar los puntos de separación
        $numero = str_pad($numero, 9, '0', STR_PAD_LEFT); // Asegurar que la longitud sea de 9 caracteres
    
        $millones = substr($numero, 0, 3);
        $miles = substr($numero, 3, 3);
        $unidades_miles = substr($numero, 6, 3);
    
        $texto = '';
    
        if ($millones > 0) {
            $texto .= ($millones == 1) ? 'un millón ' : $unidades[$millones] . ' millones ';
        }
    
        if ($miles > 0) {
            if ($miles == 1) {
                $texto .= 'mil ';
            } else {
                $texto .= $centenas[substr($miles, 0, 1)];
                if (substr($miles, 1, 1) == '1') {
                    if (substr($miles, 2, 1) == '0') {
                        $texto .= ' diez ';
                    } elseif (substr($miles, 2, 1) == '1') {
                        $texto .= ' once ';
                    } elseif (substr($miles, 2, 1) == '2') {
                        $texto .= ' doce ';
                    } elseif (substr($miles, 2, 1) == '3') {
                        $texto .= ' trece ';
                    } elseif (substr($miles, 2, 1) == '4') {
                        $texto .= ' catorce ';
                    } elseif (substr($miles, 2, 1) == '5') {
                        $texto .= ' quince ';
                    } elseif (substr($miles, 2, 1) == '6') {
                        $texto .= ' dieciséis ';
                    } elseif (substr($miles, 2, 1) == '7') {
                        $texto .= ' diecisiete ';
                    } elseif (substr($miles, 2, 1) == '8') {
                        $texto .= ' dieciocho ';
                    } elseif (substr($miles, 2, 1) == '9') {
                        $texto .= ' diecinueve ';
                    } else {
                        $texto .= 'dieci' . $unidades[substr($miles, 2, 1)];
                    }
                } else {
                    $texto .= ($decenas[substr($miles, 1, 1)] !== '') ? ' y ' : ' ';
                    $texto .= $decenas[substr($miles, 1, 1)];
                    $texto .= ($unidades[substr($miles, 2, 1)] !== '') ? ' y ' : ' ';
                    $texto .= $unidades[substr($miles, 2, 1)] . ' mil ';
                }
            }
        }
    
        if ($unidades_miles > 0) {
            $texto .= $centenas[substr($unidades_miles, 0, 1)];
            $texto .= ($decenas[substr($unidades_miles, 1, 1)] !== '') ? ' y ' : ' ';
            $texto .= $decenas[substr($unidades_miles, 1, 1)];
            $texto .= ($unidades[substr($unidades_miles, 2, 1)] !== '') ? ' y ' : ' ';
            $texto .= $unidades[substr($unidades_miles, 2, 1)];
        }
    
        return trim($texto);
    }
?>