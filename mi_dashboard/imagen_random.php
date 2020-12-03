<?php
    // Crear una imagen de 300 x 300
    $lienzo = imagecreatetruecolor(300, 300);
    
    // Asignar colores
    $blanco = imagecolorallocate($lienzo, 255, 255, 255);
    $negro = imagecolorallocate($lienzo, 0, 0, 0);
    
    // Inicializa el fondo del lienzo a blanco	
	imagefill($lienzo, 0, 0, $blanco);
	
    // Dibujar un rectángulo de 100 x 100 en una posición aleatoria
	$x=rand(0,200);
	$y=rand(0,200);
    imagerectangle($lienzo, $x, $y, $x+100, $y+100, $negro);
    
    // Imprimir y liberar memoria
    header('Content-Type: image/jpeg');
    
    imagejpeg($lienzo);
    imagedestroy($lienzo);
?>