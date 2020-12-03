<?php
    generarImagen();

    function generarImagen()
    {
        header('Content-Type: text/html; charset=UTF-8');

        // Recuperar datos
        $titulo = $_GET['titulo'];
        $col1 = $_GET['col1'];
        $col2 = $_GET['col2'];

        // Convierte las cadenas a arrays
        $array1 = explode('|', $col1);
        $array2 = array_map('intval', explode('|', $col2));
        $numElementos = count($array1);

        // Crear una imagen de 500 x se ajusta automatico alnumero de elementos
        $lienzo = imagecreatetruecolor(500, $numElementos *20 + 70);
        
        // Asignar colores
        $blanco = imagecolorallocate($lienzo, 255, 255, 255);
        $rosa = imagecolorallocate($lienzo, 255, 105, 180);
        $verde = imagecolorallocate($lienzo, 132, 135, 28);
        $gris = imagecolorallocate($lienzo, 64, 64, 64);
        $grisClaro = imagecolorallocate($lienzo, 213, 213, 213);
        $negro = imagecolorallocate($lienzo, 0, 0, 0);

        // Inicializa el fondo del lienzo a blanco	
        imagefill($lienzo, 0, 0, $grisClaro);
        
        // Imprimir el titulo de la grafica
        imagestring($lienzo, 6, 25, 10, $titulo, $negro);

        //valores iniciales de x, y
        $x = 50;
        $y = 50;

        for ($i = 0; $i < $numElementos; $i++) {
            //dibuja rectangulo de la grafica
            imagerectangle($lienzo, $x, $y, $x+100, $y+20, $rosa);
            
            //dibuja el primer dato
            imagestring($lienzo, 2, $x+2, $y+2, $array1[$i]." : ".$array2[$i], $negro);
            $y += 20;
        }


       // imagestring($lienzo, 6, 25, 10, $col1, $negro);
        
        // Dibujar tres rectángulos, cada uno con su color
      // imagerectangle($lienzo, 50, 50, 100, 100, $rosa);
        //imagerectangle($lienzo, 100, 100, 150, 150, $verde);
        //imagerectangle($lienzo, 150, 150, 200, 200, $gris);
        
        // Imprimir y liberar memoria
        header('Content-Type: image/jpeg');
        
        imagejpeg($lienzo);
        imagedestroy($lienzo);
    }
?>