<?php
	/* 
	 * FUNCION PHP interna en una página .php de la Vista
	 *
	 * Quitar la Notacion Cientifica
	 */
	function quitarNotacion($bytes){

		if( strpos( $bytes, 'E+' ) !== false ){
			/* Notacion Cientifica */
			$a = sprintf('%f', $bytes );
			//$b = str_replace('.', '', $a);
			echo ( number_format( ($a / 1000000000), 2, '.', '') );

		} else {
			/* impresion normal */
			if ( $bytes != NULL && $bytes != "" && $bytes != " " ){
				echo $bytes;
			} else {
				echo "0";
			}
		}		
	}

	function convertFarenheitACentigrados($f){
		if ( $f <= 0 ){
			echo "Desconocida";
		} else {
			/* Conversion de ºF a ºC - formula de Fahrenheit a Centígrados */
			$c = ( (5/9) * ($f - 32) );
			echo ( number_format( ($c), 2, ',', '') ) . "ºC";
		}
	}

?>
<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	/* Load the Visualization API and the corechart package. */
	google.charts.load('current', {'packages':['corechart'], 'language': 'es'});
</script>

<!-- PDF -->
<script src="<?= APPJSPATH; ?>jspdf.js?version=2"></script>
<script src="<?= APPJSPATH; ?>pdfFromHTML.js?version=2"></script>


<style>
	h2 {
			font-size: 24px;
			text-transform: uppercase;
			color: #303030;
			font-weight: 600;
			margin-bottom: 30px;
	}
	h4 {
			font-size: 19px;
			line-height: 1.375em;
			color: #303030;
			font-weight: 400;
			margin-bottom: 30px;
	} 
	.logo {
			color: #F9B233;
			font-size: 200px;
	}

	#imgX {
		width: 200px;
		height: 180px;
	}
	hr { 
		display: block;
		margin-top: 0.5em;
		margin-bottom: 0.5em;
		margin-left: auto;
		margin-right: auto;
		border-style: inset;
		border-width: 3px;
	}
	.encabezadoTabla {
		background-color:#39A8D9;
		color:#000;
		font-weight:bold;
		height:50px;
	}
</style>

<div id="container">
<div id="HTMLtoPDF" class="page-body">


	<div class="row">
		<div class="col-sm-12">
			<h4 style="text-align:center; color:#E30513;">
				<span class="glyphicon glyphicon-blackboard"></span> 
				<i>Equipos</i> .:. <?= $empresa->nombre; ?>
			</h4>
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-sm-12" align="center">
			<h4><i>
				Informaci&oacute;n de los Equipos registrada en el Portal LanuzaGroup
			</i></h4>
		</div>
	</div>


	<div class="row">
		<div class="col-sm-1">&nbsp;</div>
		<div class="col-sm-5" align="center" style="text-align:center;">
			<span style="font-family: cursive; font-size: 50px;">
				<br/>
					<span style="color: #39A8D9;">
<?php
			if(isset($reporteEquipos["Cantidad_Equipos"])) echo $reporteEquipos["Cantidad_Equipos"]; else echo "0";
?>
					</span>
				<br/>
				Equipos registrados	
				<br/>
			</span>
			<br/>
		</div>
		<div class="col-sm-5" align="center" style="text-align:center;">
			<script type="text/javascript">

				google.charts.setOnLoadCallback(drawChart1);

				function drawChart1() {

					/* Create the data table. */
					var data = new google.visualization.DataTable();
					data.addColumn('string', 'Tipo de Equipos');
					data.addColumn('number', 'Cantidad');
					data.addRows([
<?php		
						$equipment[0] = "";
						$quantity[0]  = 0;
						$i = 0;
						foreach ($tipos_equipos as $presentacion) {
							$equipment[$i] = $presentacion;
							$i++;
						}

						$i = 0;
						foreach ($cantidad_equipos as $q) {
							$quantity[$i] = $q;
							$i++;
						}

						for ( $j = 0; $j < $i; $j++ ){
							
							echo "['" . $equipment[$j] . "' , " . $quantity[$j] .  "]," ;
						}
?>
					]);

					/* Set chart options */
					var options = {
						title: 'Tipos de Equipos',
						titleTextStyle : {
							color: 'black',
							fontName: 'sans-serif',
							fontSize: 18,
							bold: true,
							italic: true
						},
						is3D: true,
						width: 500,
						height: 300
					};

					var chart = new google.visualization.PieChart(document.getElementById('chart_div_pie1'));
					chart.draw(data, options);
				}
			</script>
			<div id="chart_div_pie1" align="center" style="text-align:center;"></div>
		</div>
		<div class="col-sm-1">&nbsp;</div>
	</div>

	<br/>
	<div class="row">
		<div class="col-sm-1">&nbsp;</div>
		<div class="col-sm-5" align="center" style="text-align:center;">
			<script type="text/javascript">

				google.charts.setOnLoadCallback(drawChart2);

				function drawChart2() {

					/* Create the data table. */
					var data = new google.visualization.DataTable();
					data.addColumn('string', '¿Es Licenciado?');
					data.addColumn('number', 'Cantidad de Equipos');
					data.addRows([
					  ['Sí', 			<?= $licencias["win_contSi"]; ?> ],
					  ['No', 			<?= $licencias["win_contNo"]; ?> ],
					  ['Desconocido', 	<?= $licencias["win_contUnknown"]; ?> ]
					]);

					/* Set chart options */
					var options = {
						title: 'Licenciamiento de Windows de sus Equipos',
						titleTextStyle : {
							color: 'black',
							fontName: 'sans-serif',
							fontSize: 18,
							bold: true,
							italic: true
						},
						is3D: true,
						slices: {
							0: { color: '#E30513' },
							1: { color: '#0D181C' },
							2: { color: '#94A6B0' }
						},
						width: 600,
						height: 300
					};

					var chart = new google.visualization.PieChart(document.getElementById('chart_div_pie2'));
					chart.draw(data, options);
				}
			</script>
			<div id="chart_div_pie2" align="center" style="text-align:center;"></div>
		</div>
		<div class="col-sm-6" align="center" style="text-align:center;">
			<script type="text/javascript">

			  google.charts.setOnLoadCallback(drawChart3);

			  function drawChart3() {

				/* Create the data table. */
				var data = new google.visualization.DataTable();
				data.addColumn('string', '¿Es Licenciado?');
				data.addColumn('number', 'Cantidad de Equipos');
				data.addRows([
				  ['Sí', 			<?= $licencias["off_contSi"]; ?> ],
				  ['No', 			<?= $licencias["off_contNo"]; ?> ],
				  ['Desconocido', 	<?= $licencias["off_contUnknown"]; ?> ]
				]);

				/* Set chart options */
				var options = {
					title: 'Licenciamiento de Office de sus Equipos',
					titleTextStyle : {
						color: 'black',
						fontName: 'sans-serif',
						fontSize: 18,
						bold: true,
						italic: true
					},
					is3D: true,
					slices: {
						0: { color: '#E30513' },
						1: { color: '#0D181C' },
						2: { color: '#94A6B0' }
					},
					width: 550,
					height: 300
				};

				var chart = new google.visualization.PieChart(document.getElementById('chart_div_pie3'));
				chart.draw(data, options);
			  }
			</script>
			<div id="chart_div_pie3" align="center" style="text-align:center;"></div>
		</div>
	</div>

	<hr/>
	<div class="row">
		<div class="col-sm-12" align="center">
			<span class="glyphicon glyphicon-indent-right"></span> 
			<u><i>Listado de Equipos y su Informaci&oacute;n B&aacute;sica</i></u>
			<br/><br/>
			<div id="no-more-tables">
			    <table class="col-md-12 table-hover table-striped cf" style="font-size:12px;">
					<thead class="cf">
						<tr class="encabezadoTabla" height="50">
							<th align="center" style="text-align:center;width:100px;">C&oacute;digo<br/>Barras</th>
							<th align="center" style="text-align:center;width:100px;">Uso de<br/>Equipo</th>
							<th align="center" style="text-align:center;width:120px;">Dependencia</th>
							<th align="center" style="text-align:center;width:120px;">Marca y<br/>Modelo</th>
							<th align="center" style="text-align:center;">Serial</th>
							<th align="center" style="text-align:center;width:100px;">Tipo de<br/>Equipo</th>
							<th align="center" style="text-align:center;width:80px;">TeamViewer</th>
							<th align="center" style="text-align:center;width:300px;">Informaci&oacute;n<br/>B&aacute;sica</th>
							<th align="center" style="text-align:center;">Observaciones<br/>Iniciales</th>
						</tr>
					</thead>
					<tbody>
<?php 
						$i=0;
						foreach ($equipos as $equipo) {
							$i++;
?>
						<tr class="<?php if ( $i % 2 == 0 ) echo "active"; else echo "info"; ?>">

							<td align="center" style="text-align:center;height:100px" height="100">
								<?= $equipo["codigoBarras"]; ?>
							</td>
							<td align="center" style="text-align:center;">
								<?= $equipo["nombreEquipo"]; ?>
							</td>
							<td align="center" style="text-align:center;"><?= $equipo["dependencia"]; ?></td>
							<td align="center" style="text-align:center;"><?= $equipo["marca"] . " " . $equipo["modelo"]; ?></td>
							<td align="center" style="text-align:center;"><?= $equipo["serial"]; ?></td>
							<td align="center" style="text-align:center;"><?= $equipo["TipoEquipo"]; ?></td>
							<td align="center" style="text-align:center;"><?= $equipo["teamViewer_Id"]; ?></td>
							<td><?= $equipo["infoBasica"]; ?></td>
							<td><?= $equipo["observacionInicial"]; ?></td>

						</tr>
<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<hr/><br/><br/>
	<div class="row">
		<div class="col-sm-2">&nbsp;</div>
		<div class="col-sm-8" align="center">
			<span class="glyphicon glyphicon-usd"></span> 
			<u><i>Listado de Valores de los Equipos</i></u>
			<br/><br/>
			<div id="no-more-tables">
			    <table class="table-hover table-striped cf" style="font-size:12px;">
					<thead class="cf">
						<tr class="encabezadoTabla" height="50">
							<th align="center" style="text-align:center;width:120px;">C&oacute;digo<br/>Barras</th>
							<th align="center" style="text-align:center;width:200px;">Uso de<br/>Equipo</th>
							<th align="center" style="text-align:center;width:250px;">Valor del Equipo<br/>(Pesos Colombianos)</th>
							<th align="center" style="text-align:center;width:250px;">Valor de Reponer el Equipo<br/>(Pesos Colombianos)</th>
						</tr>
					</thead>
					<tbody>
<?php 
						$i=0;
						foreach ($valores as $valor) {
							$i++;
?>
						<tr class="<?php if ( $i % 2 == 0 ) echo "active"; else echo "info"; ?>">

							<td align="center" style="text-align:center;height:20px" height="20">
								<?= $valor["codigoBarras"]; ?>
							</td>
							<td align="center" style="text-align:center;"><?= $valor["nombreEquipo"]; ?></td>
							<td align="center" style="text-align:center;">
								<?php if($valor["valor"]==0 || $valor["valor"]=="0.00") echo "No registrado"; else echo $valor["valor"]; ?>
							</td>
							<td align="center" style="text-align:center;">
								<?php if($valor["valorReposicion"]==0 || $valor["valorReposicion"]=="0.00") echo "No registrado"; else echo $valor["valorReposicion"]; ?>
							</td>

						</tr>
<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-2">&nbsp;</div>
	</div>


	<hr/><br/><br/>
	<div class="row">
		<div class="col-sm-12" align="center">
			<span class="glyphicon glyphicon-tasks"></span> 
			<u><i>Memoria y Tarjetas de sus Equipos</i></u>
			<br/><br/>
			<div id="no-more-tables">
			    <table class="table-hover table-striped cf" style="font-size:12px;">
					<thead class="cf">
						<tr class="encabezadoTabla" height="50">
							<th align="center" style="text-align:center;width:120px;">C&oacute;digo<br/>Barras</th>
							<th align="center" style="text-align:center;width:150px;">Uso de<br/>Equipo</th>
							<th align="center" style="text-align:center;width:250px;">CPU</th>
							<th align="center" style="text-align:center;width:150px;">Tarjeta Madre</th>
							<th align="center" style="text-align:center;width:200px;">Memoria RAM</th>
							<th align="center" style="text-align:center;width:130px;">Cantidad de<br/>Tarjetas de Sonido</th>
							<th align="center" style="text-align:center;width:130px;">Cantidad de<br/>Tarjetas de Video</th>
						</tr>
					</thead>
					<tbody>
<?php 
						$i=0;
						/* recorrido 1: memoria */
						foreach ($memoriaYtarjetas as $memory) {
							$i++;
?>
						<tr class="<?php if ( $i % 2 == 0 ) echo "active"; else echo "info"; ?>">

							<td align="center" style="text-align:center;height:50px" height="50">
								<?= $memory["codigoBarras"]; ?>
							</td>
							<td align="center" style="text-align:center;"><?= $memory["nombreEquipo"]; ?></td>
							<td>
								<?php 
									echo $memory["CPU_Name"] . "<br/>";
									echo "Máquina de " . $memory["AddressWidth"] . " bits<br/>";
									if ( $memory["NumberOfCores"] == 1 ){
										echo "1 Núcleo.";
									} else {
										echo $memory["NumberOfCores"] . " Núcleos.";
									}
								?>
							</td>
							<td align="center" style="text-align:center;">
								<?php 
									echo $memory["Motherboard"] . "<br/>";
									if ( $memory["Product"] != NULL && $memory["Product"] != ""){
										echo "Modelo: " . $memory["Product"] . ".";
									}
								?>
							</td>
							<td>
<?php 
							$j=0;
							/* recorrido 2: RAM */
							foreach ($tarjetasRAM as $ram) {
								$j++;

								if ( $memory["codigoBarras"] == $ram["codigoBarras"] ){
									echo $ram["BankLabel"] . "<br/>";
									echo "Capacidad: <b>" . ( number_format( ($ram["Capacity"] / 1000000000), 2, '.', '') ) . " Gigabytes</b><br/>";
									echo "Velocidad: " . $ram["Speed"];
									echo "<br/>---<br/>";
								}
							} ?>
							</td>
							<td align="center" style="text-align:center;">
<?php 
							/* recorrido 3: tarjetas de sonido */
							$array1 = $soundVideo["sonido"];
							foreach ( $array1 as $sonido) {

								if ( $memory["codigoBarras"] == $sonido["codigoBarras"] ){
									echo $sonido["cantidad"];
									break;
								}
							}  ?>
							</td>
							<td align="center" style="text-align:center;">
<?php 
							/* recorrido 4: tarjetas de video */
							$array2 = $soundVideo["video"];
							foreach ( $array2 as $video) {

								if ( $memory["codigoBarras"] == $video["codigoBarras"] ){
									echo $video["cantidad"];
									break;
								}
							}  ?>
							</td>

						</tr>

<?php 					} 	?>

					</tbody>
				</table>
			</div>
		</div>
	</div>

	<hr/><br/><br/>
	<div class="row">
		<div class="col-sm-12" align="center">
			<span class="glyphicon glyphicon-cd"></span> 
			<u><i>Discos y Uso de sus Equipos</i></u>
			<br/><br/>
			<div id="no-more-tables">
			    <table class="table-hover table-striped cf" style="font-size:12px;">
					<thead class="cf">
						<tr class="encabezadoTabla" height="50">
							<th align="center" style="text-align:center;width:120px;">C&oacute;digo<br/>Barras</th>
							<th align="center" style="text-align:center;width:120px;">Uso de<br/>Equipo</th>
							<th align="center" style="text-align:center;width:220px;">Particiones L&oacute;gicas</th>
							<th align="center" style="text-align:center;width:300px;">Discos Duros</th>
							<th align="center" style="text-align:center;width:200px;">Info de Uso</th>
						</tr>
					</thead>
					<tbody>
<?php 
						$i=-1;
						/* recorrido 1: todos los Equipos */
						foreach ( $equipos as $equipo ) {
							$i++;
?>
							<tr class="<?php if ( $i % 2 == 0 ) echo "active"; else echo "info"; ?>">
								
								<td align="center" style="text-align:center;height:150px" height="150">
									<?= $equipo["codigoBarras"]; ?>
								</td>
								<td align="center" style="text-align:center;">
									<?= $equipo["nombreEquipo"]; ?>
								</td>

								<td>
<?php 
								/* recorrido 2: Particiones Logicas */
								foreach ( $discosDurosYLogicos["arrayParticiones"] as $pl ) {

									if ( $equipo["codigoBarras"] == $pl["codigoBarras"] ) {
										/**/
										echo $pl["DriveLetter"] . " " . $pl["DriveType"] . "<br/>";

										/**/
										echo "Capacidad: ";
										quitarNotacion( $pl["Capacity"] );
										echo " Gb.<br/>";

										/**/
										echo "Espacio Libre: ";
										quitarNotacion( $pl["FreeSpace"] );
										echo " Gb.<br/>";

										/**/
										echo "---<br/>";

									} else {
										continue;
									}
								}
?>
								</td>
								<td>
<?php 
								/* recorrido 2: Particiones Logicas */
								foreach ( $discosDurosYLogicos["arrayDiscos"] as $hdd ) {

									if ( $equipo["codigoBarras"] == $hdd["codigoBarras"] ) {
										/**/
										echo "Modelo: " . $hdd["Model"] . "<br/>";
										echo "Interfaz: " . $hdd["InterfaceType"] . "<br/>";

										/**/
										echo "Capacidad: ";
										quitarNotacion( $hdd["Size"] );
										echo " Gb.<br/>";

										/**/
										echo "---<br/>";
									}
								}
?>
								</td>
								<td>
<?php 
								$ultActualizacion = "";

								/* recorrido 3: SMART */
								foreach ( $smart as $sm ) {

									if ( $equipo["codigoBarras"] == $sm["codigoBarras"] ) {
										
										/**/
										echo "Modelo: " . $sm["Model"] . "<br/>";
										echo "Horas de Uso: <b>" . $sm["Horas_encendido"] . "</b><br/>";
										echo "Cant. Sectores relocalizados: " . $sm["Reallocated_sector_count"] . "<br/>";

										echo "Temperatura: <b>";

										$f = $sm["HDD_temperature"];
										convertFarenheitACentigrados($f);

										/**/
										echo "</b><br/>---<br/>";
									}
								}
?>
								</td>

							</tr>
<?php 					} 	?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<br/><br/><br/>

	<div class="row">
		<div class="col-sm-4" align="center">
			<button type="button" class="btn btn-warning btn-lg" onclick="javascript:printThisPage();" 
			   data-toggle="tooltip" data-placement="bottom" title="Guardar esta página en formato PDF - se descargará automáticamente">
				<span class="glyphicon glyphicon-file"></span> 
				 Guardar en PDF
			</button>
		</div>

		<div class="col-sm-4" align="center">
			<button type="button" class="btn btn-info btn-lg" onclick="javascript:imprimirBrowser();" 
			   data-toggle="tooltip" data-placement="bottom" title="Imprimir esta página usando su Navegador de Internet">
				<span class="glyphicon glyphicon-print"></span> 
				 Imprimir usando Navegador
			</button>
		</div>

		<div class="col-sm-4" align="center">
			<a href="<?= PROJECTURLMENU; ?>admin/home" class="btn btn-link">
				<span class="glyphicon glyphicon-home"></span> 
				Ir a la p&aacute;gina principal del Portal
			</a>
		</div>
	</div>

	<br/><br/><br/><br/>

</div><!-- HTMLtoPDF -->
</div><!-- container -->
<script>
	function printThisPage(){

		HTMLtoPDF();

		alert("Se está descargando automáticamente un archivo PDF con este Reporte."
			+ "\n\n(Puede que el formato visual adaptado a PDF difiera de su navegador y/o tamaño de pantalla)"
			+ "\n\nPresione OK/Aceptar para continuar...");
	}

	function imprimirBrowser(){

		/* var printContents = document.getElementById("HTMLtoPDF").innerHTML;

		var originalContents = document.body.innerHTML;

		document.body.innerHTML = printContents;
		*/
		window.print();

		/*document.body.innerHTML = originalContents;*/
	}
</script>