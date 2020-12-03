<?php
	//funcion para mostrar graficas
	function mostrarGrafica($titulo, $col1, $col2)
	{
		//mando los datos a la pagina que crea la imagen y la muestro
		echo "<img src='imagen.php?titulo=".$titulo."&col1=".$col1."&col2=".$col2."' alt='Grafica de ".$titulo."' />";
	}
?>