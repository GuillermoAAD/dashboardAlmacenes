<?php
	//funcion para crear tabla
	function crearTabla($resultado)
	{
		// Determinar el número de filas y columnas devueltos
		$num_filas = mysqli_num_rows($resultado);
		$num_cols = mysqli_num_fields($resultado);

		// Obtener el arreglo $campos con los nombres de las columnas devueltas
		$columnas = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		$campos = array_keys($columnas);
		// Regresar el apuntador al inicio del arreglo
		mysqli_data_seek($resultado,0);

		// Comenzar a Desplegar en HTML la tabla resultante
		echo "\n<table>\n";
				
		// Desplegar en HTML  el encabezado de la tabla resultante en la consulta
		echo "<tr>\n";
		for ($i = 0; $i < $num_cols; $i++)
			echo "<td class='fila_encabezado'>" . $campos[$i] . "</a></td>\n";
		echo "</tr>\n";

		// Extraer una a una cada fila devuelta por la consulta y desplegarla en HTML
		while($fila=mysqli_fetch_array ($resultado, MYSQLI_NUM)){
			echo "<tr>\n";
			for ($i = 0; $i < $num_cols; $i++)
				echo "<td>$fila[$i]</td>\n";
			echo "</tr>\n";
		};

		// Terminar el despliegue de la tabla en HTML
		echo "</table><br />\n";
	}
?>