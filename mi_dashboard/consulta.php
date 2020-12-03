<!DOCTYPE html>
<html lang='es'>
	<head>
		<title>DASHBOARD</title>
		<meta charset="utf-8" />
        <link rel="stylesheet" href="estilos.css" />
	</head>

	<body>
		<?php
            // Se incluyen los parámetros de conexión
			include 'conexion.inc';
			include 'crearTabla.php';
			include 'crearGrafica.php';
			
			// Conectar al servidor MySQL
			$l=mysqli_connect($servidor, $usuario, $clave, $bd_nombre);
			if($l==false){
				echo "No se pudo conectar al servidor...";
				exit;
			};

			//Arreglo con los titulos
			$titulos = array(
				"Suma de ventas",
				"Top 5 vendedores",
				"Top 5 producto vendido",
				"Ventas por compañia",
				"Ventas por estado"
			);
			
			//Arreglo con las consultas
			$consultas = array(
			"SELECT SUM(ventas) AS 'Suma de Ventas' FROM northwind.partida",
			"SELECT e1.nom_empleado, SUM(t1.ventas) AS ventas
				FROM 
				(
					SELECT empleado.id_empleado AS id_empleado , empleado.nom_empleado AS nom_empleado
					FROM empleado
				)e1
				JOIN
				(
					SELECT pedido.id_empleado AS id_empleado, pedido.num_pedido, v1.ventas AS ventas
					FROM pedido
					JOIN
					(
						SELECT partida.num_pedido AS num_pedido , SUM(partida.ventas) AS
						ventas FROM partida 
						GROUP BY partida.num_pedido
					)v1
					ON pedido.num_pedido=v1.num_pedido
				)t1
				ON e1.id_empleado=t1.id_empleado
				GROUP BY e1.nom_empleado
				ORDER BY ventas DESC
				LIMIT 5",
			"SELECT producto.nom_producto, v1.ventas AS ventas
					FROM producto
					JOIN
					(
						SELECT partida.id_producto AS id_producto , SUM(partida.ventas) AS
						ventas FROM partida 
						GROUP BY partida.id_producto
					)v1
					ON producto.id_producto=v1.id_producto
					ORDER BY ventas DESC
					LIMIT 5",
			"SELECT c1.nom_cliente AS nom_cliente, SUM(t1.ventas) AS ventas
				FROM 
				(
					SELECT cliente.id_cliente AS id_cliente , cliente.nom_cliente AS nom_cliente
					FROM cliente
				)c1
				JOIN
				(
					SELECT pedido.id_cliente AS id_cliente, pedido.num_pedido, v1.ventas AS ventas
					FROM pedido
					JOIN
					(
						SELECT partida.num_pedido AS num_pedido , SUM(partida.ventas) AS
						ventas FROM partida 
						GROUP BY partida.num_pedido
					)v1
					ON pedido.num_pedido=v1.num_pedido
				)t1
				ON c1.id_cliente=t1.id_cliente
				GROUP BY c1.nom_cliente
				ORDER BY nom_cliente ASC",
			"SELECT c1.clave_estado AS clave_estado, SUM(t1.ventas) AS ventas
				FROM 
				(
					SELECT cliente.id_cliente AS id_cliente , cliente.clave_estado AS clave_estado
					FROM cliente
				)c1
				JOIN
				(
					SELECT pedido.id_cliente AS id_cliente, pedido.num_pedido, v1.ventas AS ventas
					FROM pedido
					JOIN
					(
						SELECT partida.num_pedido AS num_pedido , SUM(partida.ventas) AS
						ventas FROM partida 
						GROUP BY partida.num_pedido
					)v1
					ON pedido.num_pedido=v1.num_pedido
				)t1
				ON c1.id_cliente=t1.id_cliente
				GROUP BY c1.clave_estado
				ORDER BY clave_estado ASC");
			
			//recorre para cada consulta
			$contador = 0;
			foreach($consultas as &$consulta) {

				$resultado=mysqli_query($l, $consulta);
				$res = mysqli_query($l, $consulta);
				if($resultado==false){
					echo "No se pudo efectuar la consulta...";
					exit;
				};
				
				//imprimo el titulo
				echo "<H1>".$titulos[$contador]."</H1>";

				crearTabla($resultado);
				
				//La primer tabla no necesita grafica
				if($contador != 0){
					
					//en el primer arreglo guardo cadenas
					$col1 = array();
					//y en el segundo los valores numericos
					$col2 = array();

					//extraigo cada fila del resultado de la consulta
					while($fila=mysqli_fetch_array($res, MYSQLI_NUM)){

						//guardo cada  valor de cada columna en arrays correspondientes
						$col1[] = $fila[0];
						$col2[] = $fila[1];
					};

					//convierto ambos arrays en string
					$col1 = implode("|", $col1);
					$col2 = implode("|", $col2);

					mostrarGrafica($titulos[$contador], $col1, $col2);
				}
				
				$contador++;
				echo "<hr>";
			}

		?>

	</body>
</html>