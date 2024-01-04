<?php 
    require 'vendor/autoload.php';

    use NumberToWords\NumberToWords;
    
    // Crear una instancia de la clase NumberToWords
    $numberToWords = new NumberToWords();
    
    // Obtener el conversor para el idioma español
    $numberTransformer = $numberToWords->getNumberTransformer('es');
    
    // Convertir el número a letras
    $numero = 94864;
    $numeroEnLetras = $numberTransformer->toWords($numero);
    
    // Imprimir el resultado
    echo $numeroEnLetras;
    
?>