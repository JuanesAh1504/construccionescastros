<?php 
    include_once("config.php");
    conectarBaseDeDatos();
    function sqlQuerySelect($sql) {
        global $conn;
        $resultado = $conn->query($sql);
        if ($resultado) {
            return $resultado;
        } else {
            echo "Error en la consulta: " . $conn->error;
            return false;
        }
    }
?>