<?php 
    function mostrarError($mensaje, $tipoAlerta){
        $arregloMensajeAMostrar = array($tipoAlerta => true, "message" => $mensaje);
        error_log(json_encode($arregloMensajeAMostrar));   
        return json_encode($arregloMensajeAMostrar);
    }
?>