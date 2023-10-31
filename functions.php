<?php 
    function mostrarAlerta($mensaje, $tipoAlerta){
        $arregloMensajeAMostrar = array($tipoAlerta => true, "message" => $mensaje);
        error_log(json_encode($arregloMensajeAMostrar));   
        return json_encode($arregloMensajeAMostrar);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        switch($_POST['accion']){
            case 'descargarPDF':
                require('fpdf186/fpdf.php'); // Incluye la biblioteca FPDF
                // Crear una instancia de FPDF
                $pdf = new FPDF();
                $pdf->AddPage();

                // Configurar la fuente y el tamaño
                $pdf->SetFont('Arial', '', 14);
                $pdf->Write(5, 'Visit ');

                // Crear un enlace simulado
                $pdf->SetTextColor(0, 0, 255); // Color del enlace
                $pdf->SetFont('', 'U'); // Fuente subrayada
                $pdf->Cell(0, 5, 'www.fpdf.org', 0, 0, 'L', false, 'http://www.fpdf.org');

                // Generar el PDF en un búfer
                ob_start();
                $pdf->Output('D', 'miarchivo.pdf'); // Descargar en lugar de mostrar en línea
                ob_end_flush(); // Enviar el contenido del búfer al navegador
                $pdf_content = ob_get_clean();

                // Configura las cabeceras para indicar que el contenido es un PDF
                header('Content-Type: application/pdf');

                // Configura la cabecera Content-Disposition para que el navegador muestre el PDF en lugar de descargarlo
                header('Content-Disposition: inline; filename="miarchivo.pdf"');

                // Envia el contenido del PDF como respuesta
                echo $pdf_content;

                // Finaliza el script para evitar que se siga enviando contenido adicional
                exit;
        }
    }
?>