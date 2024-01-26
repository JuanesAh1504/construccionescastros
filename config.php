<?php
    global $conn;
    function conectarBaseDeDatos() {
        global $conn;

        // Datos de conexión (deberían estar en un archivo de configuración externo)
        $host = "localhost";
        $dbname = "castro'ssolucion";
        $username = "root";
        $password = "";
    
        // Crear una conexión a la base de datos
        $conn = new mysqli($host, $username, $password, $dbname);
    
        // Verificar si hay errores de conexión
        if ($conn->connect_error) {
            die("Error de conexión a la base de datos: " . $conn->connect_error);
        }
    
        return $conn;
    }
    
    function cerrarConexion($conn) {
        $conn->close();
    }

    function obtenerFechaActual() {
        date_default_timezone_set('America/Bogota');
        // Arreglo de los nombres de los meses en español
        $meses = array(
            1 => "enero", 2 => "febrero", 3 => "marzo", 4 => "abril",
            5 => "mayo", 6 => "junio", 7 => "julio", 8 => "agosto",
            9 => "septiembre", 10 => "octubre", 11 => "noviembre", 12 => "diciembre"
        );

        // Obtiene la fecha actual
        $fecha_actual = getdate();
        // Formatea la fecha en español
        $dia = $fecha_actual['mday'];
        $mes = $meses[$fecha_actual['mon']];
        $anio = $fecha_actual['year'];
        return $dia . ' de ' . $mes . ' ' . $anio;
    }
?>
