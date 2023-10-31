<?php 
    require('fpdf186/fpdf.php'); // Incluye la biblioteca FPDF
    // Crear una instancia de FPDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Establecer márgenes para el contenido
    $pdf->SetLeftMargin(20); // Margen izquierdo

    // Agregar una imagen centrada al principio del PDF
    $imagePath = 'img/logoCastrosSolucion.png'; // Ruta de la imagen que deseas agregar
    $imageWidth = 100; // Ancho de la imagen en puntos
    $imageX = ($pdf->GetPageWidth() - $imageWidth) / 2; // Calcula la posición X centrada

    // Calcula la posición Y de la imagen
    $imageY = $pdf->GetY();

    $pdf->Image($imagePath, $imageX, $imageY, $imageWidth);

    // Ajusta la posición Y para el texto debajo de la imagen
    $textY = $imageY + $imageWidth + 10; // 10 es la distancia entre la imagen y el texto

    // Agregar el texto debajo de la imagen
    $pdf->SetFont('Arial', '', 14);
    $pdf->SetY($textY); // Establece la posición Y para el texto
    $pdf->Cell(0, 10, 'Girardota 25 de octubre 2023', 0, 1, 'L');
    $pdf->Cell(0, 10, 'Cordial Saludo. Envió Cotización', 0, 1, 'L');

    // Puedes continuar agregando más contenido debajo del texto
    $pdf->Cell(0, 10, 'Otro texto aquí', 0, 1, 'C');

    // Generar el PDF en un búfer
    ob_start();
    $pdf->Output();
    ob_end_flush();
    $pdf_content = ob_get_clean();

    // Configura las cabeceras para indicar que el contenido es un PDF
    header('Content-Type: application/pdf');

    // Configura la cabecera Content-Disposition para que el navegador muestre el PDF en lugar de descargarlo
    header('Content-Disposition: inline; filename="miarchivo.pdf"');

    // Envia el contenido del PDF como respuesta
    echo $pdf_content;

    // Finaliza el script para evitar que se siga enviando contenido adicional
    exit;

?>