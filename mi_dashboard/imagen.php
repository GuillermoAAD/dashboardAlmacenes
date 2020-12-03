<?php
    generarImagen();

    function generarImagen()
    {
        // Recuperar datos
        $titulo = $_GET['titulo'];
        $col1 = $_GET['col1'];
        $col2 = $_GET['col2'];

        // Convierte las cadenas a arrays
        $array1 = explode('|', $col1);
        $array2 = array_map('intval', explode('|', $col2));
        $array2String = explode('|', $col2);

        $numElementos = count($array1);
        $valMax = max($array2);

        //guarda el largo donde se dinuja la grafica
        $largoLienzo = 500;

        // Crear una imagen de 500 x se ajusta automatico al numero de elementos
        $lienzo = imagecreatetruecolor($largoLienzo, $numElementos *20 + 70);
        
        // Asignar colores
        $blanco = imagecolorallocate($lienzo, 255, 255, 255);
        $negro = imagecolorallocate($lienzo, 0, 0, 0);
        $azulClaro = imagecolorallocate($lienzo, 142, 205, 233);        

        // Inicializa el fondo del lienzo a blanco	
        imagefill($lienzo, 0, 0, $blanco);
        
        // Imprimir el titulo de la grafica
        imagestring($lienzo, 6, 25, 10, "Grafica: ".$titulo, $negro);

        //valores iniciales de x, y
        $x = 50;
        $y = 50;

        for ($i = 0; $i < $numElementos; $i++) {

            //Calculo el largo que tendra el elemento en la grafica y
            //descuento el espaciado de los dos lados
            $x2 = obtenerLargoGrafica($array2[$i], $valMax, $largoLienzo-100);
            //le sumo 50 porque es el espaciado izquierdo que ledi
            $x2 += 50;

            //dibuja rectangulo de la grafica
            imagefilledrectangle($lienzo, $x2, $y, $x, $y+20, $azulClaro);
            imagerectangle($lienzo, $x2, $y, $x, $y+20, $blanco);
            
            //dibuja los datos
            imagestring($lienzo, 2, $x+2, $y+2, $array1[$i]." : $ ".$array2String[$i], $negro);

            //incremento y para que se dibuje la siguiente barra abajo
            $y += 20;
        }

        // Imprimir y liberar memoria
        header('Content-Type: image/jpeg');
        
        imagejpeg($lienzo);
        imagedestroy($lienzo);
    }

    //Calculo el tamaño/longitud de la grafica para el elemento
    function obtenerLargoGrafica($val, $valMax, $tamanioCanvas) {
        return ($val / $valMax) * $tamanioCanvas;
    }
?>