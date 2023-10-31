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

    function sqlInsert($sql) {
        global $conn; // Suponiendo que $conn es tu variable de conexión global
    
        if ($conn->query($sql) === TRUE) {
            return true; // La consulta se ejecutó con éxito
        } else {
            return false; // Hubo un error en la ejecución de la consulta
        }
    }
?>