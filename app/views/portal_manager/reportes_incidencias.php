<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	/* Load the Visualization API and the corechart package. */
	google.charts.load('current', {'packages':['corechart'], 'language': 'es'});
</script>

<!-- PDF -->
<script src="<?= APPJSPATH; ?>jspdf.js?version=2"></script>
<script src="<?= APPJSPATH; ?>pdfFromHTML.js?version=2"></script>

<!-- Javascript del circulo -->
<script src="<?= APPJSPATH; ?>jquery.circlechart.js"></script>

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

	a.back-to-top {
		display: block;
		width: 60px;
		height: 60px;
		text-indent: -9999px;
		position: fixed;
		z-index: 999;
		right: 500px;
		bottom: 20px;
		background: #F9B233 url("<?= APPIMAGEPATH; ?>up-arrow.png") no-repeat center 43%;
		-webkit-border-radius: 30px;
		-moz-border-radius: 30px;
		border-radius: 30px;
	}
	a:hover.back-to-top {
		background-color: #E30513;
	}

</style>

<div id="container">
<div id="HTMLtoPDF" class="page-body">


	<div class="row">
		<div class="col-sm-12">
			<h4 style="text-align:center; color:#E30513;">
				<span class="glyphicon glyphicon-fire"></span> 
				<i>Incidencias</i> .:. <?= $empresa->nombre; ?>
			</h4>
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-sm-12" align="center">
			<h4><i>
				Informaci&oacute;n sobre las Incidencias ocurridas en sus Equipos, registradas en el Portal LanuzaGroup
			</i></h4>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-6" align="center">
			<div class="demo">
				<div class="demo-2" data-percent="100"
				 data-show="<?php if(isset($estadisticasIncidencias["Numero_Incidencias"])) echo $estadisticasIncidencias["Numero_Incidencias"]; else echo "0"; ?>">
				</div>
			</div>
			<br/>
			N&uacute;mero de Incidencias registradas <b>en este a&ntilde;o</b>
		</div>
		<div class="col-sm-6" align="center">
			<div class="demo">
				<div class="demo-3" data-percent="100"
				 data-show="<?php if(isset($estadisticasIncidencias["Numero_tecnicos_que_han_visitado_empresa"])) echo $estadisticasIncidencias["Numero_tecnicos_que_han_visitado_empresa"]; else echo "0"; ?>">
				</div>
			</div>
			<br/>
			<b>N&uacute;mero de nuestros Ingenieros de Soporte</b> que han visitado su Empresa
		</div>
	</div>

	<br/>
	<div class="row">
		<div class="col-sm-8" align="center" style="text-align:center;">
<?php
			$open 		= $clasificacionIncidenciasDashboard["Numero_Incidencias_Status_Abierta"];
			$progress	= $clasificacionIncidenciasDashboard["Numero_Incidencias_Status_En_Progreso"];
			$wait 		= $clasificacionIncidenciasDashboard["Numero_Incidencias_Status_En_Espera"];
			$close 		= $clasificacionIncidenciasDashboard["Numero_Incidencias_Status_Cerrada"];
			$certified  = $clasificacionIncidenciasDashboard["Numero_Incidencias_Status_Certificada"];
?>
			<script type="text/javascript">

			  // Set a callback to run when the Google Visualization API is loaded.
			  google.charts.setOnLoadCallback(drawChart);

			  // Callback that creates and populates a data table,
			  // instantiates the pie chart, passes in the data and
			  // draws it.
			  function drawChart() {

				/* Create the data table.
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Topping');
				data.addColumn('number', 'Slices');
				data.addRows([
				  ['Mushrooms', 3],
				  ['Onions', 1],
				  ['Olives', 1],
				  ['Zucchini', 1],
				  ['Pepperoni', 2]
				]);
				*/

				var data = google.visualization.arrayToDataTable([
					["Estatus", "Cantidad de Incidencias", { role: "style" } ],
					
					["Abierta", 	 <?= $open; ?>, 	 "#E30513"],
					["En Progreso",  <?= $progress; ?>,  "#AFCA0A"],
					["En Espera", 	 <?= $wait; ?>, 	 "#F9B233"],
					["*Cerradas", 	 <?= $close; ?>, 	 "#39A8D9"],
					["Certificadas", <?= $certified; ?>, "#951B81"]

				]);

				/* Set chart options */
				var options = {
					width: 850,
					height: 500,
					bar: {groupWidth: "95%"},
					legend: { position: 'left', maxLines: 2 },
					title: 'Clasificación de las Incidencias según su Estatus Actual',
				};

				/* Instantiate and draw our chart, passing in some options.
				 *
				 * var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
				 * var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
				 */
				var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
				chart.draw(data, options);
			  }
			</script>

			<!--Div that will hold the pie chart-->
			<div id="chart_div" align="center" style="text-align:center;"></div>
		</div>

		<div class="col-sm-4" style="font-size:12px;">
			<br/><br/><br/>
			<b><u>Estatus</u></b>
			<br/><br/>

			<b><u style="color:#E30513;">Abierta:</u></b> 
			se report&oacute; la Incidencia.

			<br/><br/>
			<b><u style="color:#AFCA0A;">En Progreso:</u></b> 
			nuestros Ing. de Soporte est&aacute;n trabajando en solventar la(s) Incidencia(s).

			<br/><br/>
			<b><u style="color:#F9B233;">En Espera:</u></b> 
			no se puede avanzar en la resoluci&oacute;n de la Incidencia 
			debido a falta de alguna informaci&oacute;n por parte de los Usuarios que reportaron la Incidencia.

			<br/><br/>
			<b><u style="color:#39A8D9;">*Cerradas:</u></b> 
			los inconvenientes ya fueron resueltos.

			<br/><br/>
			<b><u style="color:#951B81;">Certificadas:</u></b> 
			ya los Usuarios afectados reportaron que las 
			soluciones brindadas por
			nuestros Ing. de Soporte ha sido resueltas satisfactoriamente.

			<br/><br/><br/>
			* Se recomienda Certificar todas las Incidencias Cerradas para brindarle
			una mejor <i>Calidad de Servicio</i>.
		</div>
	</div>

	<br/>
	<div class="row">
		<div class="col-sm-4">&nbsp;</div>
		<div class="col-sm-4 well well-lg" align="center" style="text-align:center;">
<?php
			$i = 0; $E = 0;
			foreach ($duracionPromedio as $dias) {
				$i++;	
				$E = $E + $dias["incidenciaDuracionDias"];
			}

			$promedio = ($E / $i);
?>
			<span style="font-family: cursive; font-size: 50px;">
				<?= number_format( "$promedio", 2 ); ?>
				<br/>
				d&iacute;as	
			</span>
			<br/><br/>
			Duraci&oacute;n <u>Promedio</u> en que las Incidencias han sido resueltas por nuestros Ingenieros de Soporte.
		</div>
		<div class="col-sm-4">&nbsp;</div>
	</div>


	<div class="row">
<?php
	$endo = 0;
	foreach ( $causalesIncidenciasDashboard["endogena"] as $hw) {
		$endo++;
	}

	$exo = 0;
	foreach ( $causalesIncidenciasDashboard["exogena"]as $sf) {
		$exo++;
	}

	$hum = 0;
	foreach ( $causalesIncidenciasDashboard["humana"] as $sf) {
		$hum++;
	}

	$total = $endo + $exo + $hum;
?>
		<div class="col-sm-7" align="center" style="text-align:center;">
			<script type="text/javascript">
				
				google.charts.setOnLoadCallback(drawChart2);

				function drawChart2() {

					var data = google.visualization.arrayToDataTable([
						["Causales", "Causales de Incidencias", { role: "style" } ],
						
						["Causas Endógenas", 	 	 <?= $endo; ?>, "#0D181C"],
						["Causas Exógenas Técnicas", <?= $exo; ?>,  "#94A6B0"],
						["Causas Exógenas Humanas",  <?= $hum; ?>, 	"#E30513"],

					]);

					/* Set chart options */
					var options = {
						width: 750,
						height: 500,
						bar: {groupWidth: "95%"},
						legend: { position: 'left', maxLines: 2 },
						title: 'Clasificación de las Incidencias según las causas que las originaron',
					};

					
					var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_variables'));
					chart.draw(data, options);
				}
			</script>

			<!--Div that will hold the pie chart-->
			<div id="chart_div_variables" align="center" style="text-align:center;"></div>
		</div>
		<div class="col-sm-5" style="font-size:12px;">
			<br/><br/><br/>
			<b><u>Causas que originan las Incidencias</u></b>

			<br/><br/>
			<b><u style="color:#0D181C;">Causas End&oacute;genas:</u></b> 
			Problemas DENTRO del Equipo, a nivel INTERNO. Ej: un componente interno dej&oacute; de funcionar, etc.

			<br/><br/>
			<b><u style="color:#94A6B0;">Causas Ex&oacute;genas T&eacute;cnicas:</u></b> 
			Problemas EXTERNOS de &iacute;ndole T&eacute;cnico. Ej: un baj&oacute;n de corriente, apag&oacute;n, etc.

			<br/><br/>
			<b><u style="color:#E30513;">Causas Ex&oacute;genas Humanas:</u></b> 
			Problemas EXTERNOS de &iacute;ndole HUMANA. Ej: se derram&oacute; agua sobre el PC, Virus por Juegos instalados, usos NO laborales, etc.
			
			<br/><br/>
			Estos problemas son los <b>m&aacute;s comunes</b> y requieren de un <i>correcto adiestramiento del personal</i> 
			para un mejor uso de los Equipos en el area laboral.
			<br/><br/><br/>
		</div>
	</div>

	<br/>
	<div class="row">
		<div class="panel-group col-sm-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h4 class="panel-title">
					<!--  el ID debe ser único #collapse1 -->
					<table style="width:100%;">
						<tr>
							<td style="text-align:left;">
								<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse3');return false;">
									Causas de las Incidencias registradas en los Reportes (Detalles de los Problemas). Click aqu&iacute; para desplegar:
								</a>
							</td>
						</tr>
					</table>
				</h4>
			  </div>

			  <div id="collapse3" class="panel-collapse collapse in">
				<div class="panel-body">
					<div id="no-more-tables">

<!-- ************************************************************************************************************ -->
						<div class="col-sm-4" style="font-size:12px;">
							<br/><br/>
							<u>Causas End&oacute;genas</u>
							<br/><br/>
<?php
							if ( $endo == 0 ){
								echo "<br/>";
								echo "No se han registrado causas de índole Endógena.";
								echo "<br/>";
							} else {
?>
								<table id="endogenas" class="table-hover table-striped cf" style="font-size: 12px;">
									<thead class="cf">
										<tr>
											<th class="active" width="90px">Ver Reporte<br/>completo</th>
											<th class="active">Detalle</th>
										</tr>
									</thead>
									<tbody>

<?php 								
												$terminoTodos = false; $cont = 0; $i = -1;
												while ($terminoTodos == false) {
													$i++;
													
													if ( isset($causalesIncidenciasDashboard["endogenaId"][$i]) ){

														$aux = $causalesIncidenciasDashboard["endogenaId"][$i];

														echo '<tr class="info">';
														
														echo "  <td data-title='Ver Reporte'>";
														echo      '<button type="button" class="btn btn-primary" 
																	data-toggle="tooltip" data-placement="bottom" title="Ver Soluci&oacute;n de la Incidencia | Opci&oacute;n Imprimir Reporte"
																	onclick="javascript:verDetalleSolucion(' . $aux . ');"><span class="glyphicon glyphicon-folder-open"></span></button>';
														echo "  </td>";
														
														echo "  <td data-title='Detalle'>";
														echo      $causalesIncidenciasDashboard["endogena"][$i] . "<br/>&nbsp;";
														echo "  </td>";

														echo "</tr>";

														$cont++;
														if ( $cont == $endo ){
															$terminoTodos = true;
															break;
														}
													}
												}
?>
									</tbody>
								</table>
<?php 						} ?>
						</div>


<!-- ************************************************************************************************************ -->
						<div class="col-sm-4" style="font-size:12px;">
							<br/><br/>
							<u>Causas Ex&oacute;genas T&eacute;cnicas</u>
							<br/><br/>
<?php
							if ( $exo == 0 ){
								echo "<br/>";
								echo "No se han registrado causas de índole Exógenas Técnicas.";
								echo "<br/>";
							} else {
?>
								<table id="exogenas" class="table-hover table-striped cf" style="font-size: 12px;">
									<thead class="cf">
										<tr>
											<th class="active" width="90px">Ver Reporte<br/>completo</th>
											<th class="active">Detalle</th>
										</tr>
									</thead>
									<tbody>

<?php 								
												$terminoTodos = false; $cont = 0; $i = -1;
												while ($terminoTodos == false) {
													$i++;
													
													if ( isset($causalesIncidenciasDashboard["exogenaId"][$i]) ){

														$aux = $causalesIncidenciasDashboard["exogenaId"][$i];

														echo '<tr class="info">';
														
														echo "  <td>";
														echo      '<button type="button" class="btn btn-primary" 
																	data-toggle="tooltip" data-placement="bottom" title="Ver Soluci&oacute;n de la Incidencia | Opci&oacute;n Imprimir Reporte"
																	onclick="javascript:verDetalleSolucion(' . $aux . ');"><span class="glyphicon glyphicon-folder-open"></span></button>';
														echo "  </td>";
														
														echo "  <td>";
														echo      $causalesIncidenciasDashboard["exogena"][$i] . "<br/>&nbsp;";
														echo "  </td>";

														echo "</tr>";

														$cont++;
														if ( $cont == $exo ){
															$terminoTodos = true;
															break;
														}
													}
												}
?>
									</tbody>
								</table>
<?php 						} ?>
						</div>

<!-- ************************************************************************************************************ -->
						<div class="col-sm-4" style="font-size:12px;">
							<br/><br/>
							<u>Causas Ex&oacute;genas Humanas</u>
							<br/><br/>
<?php
							if ( $hum == 0 ){
								echo "<br/>";
								echo "No se han registrado causas de índole Exógenas Humanas.";
								echo "<br/>";
							} else {
?>
								<table id="Humanas" class="table-hover table-striped cf" style="font-size: 12px;">
									<thead class="cf">
										<tr>
											<th class="active" width="90px">Ver Reporte<br/>completo</th>
											<th class="active">Detalle</th>
										</tr>
									</thead>
									<tbody>

<?php 								
												$terminoTodos = false; $cont = 0; $i = -1;
												while ($terminoTodos == false) {
													$i++;
													
													if ( isset($causalesIncidenciasDashboard["humanaId"][$i]) ){

														$aux = $causalesIncidenciasDashboard["humanaId"][$i];

														echo '<tr class="info">';
														
														echo "  <td>";
														echo      '<button type="button" class="btn btn-primary" 
																	data-toggle="tooltip" data-placement="bottom" title="Ver Soluci&oacute;n de la Incidencia | Opci&oacute;n Imprimir Reporte"
																	onclick="javascript:verDetalleSolucion(' . $aux . ');"><span class="glyphicon glyphicon-folder-open"></span></button>';
														echo "  </td>";
														
														echo "  <td>";
														echo      $causalesIncidenciasDashboard["humana"][$i] . "<br/>&nbsp;";
														echo "  </td>";

														echo "</tr>";

														$cont++;
														if ( $cont == $hum ){
															$terminoTodos = true;
															break;
														}
													}
												}
?>
									</tbody>
								</table>
<?php 						} ?>
						</div>
<!-- ************************************************************************************************************ -->
					</div>
				</div>
			  </div>
			</div>
		</div>
	</div>
	<!-- ========================= Formulario para VER SOLUCION DE una incidencia  ================================== -->
	<form id="resolucionIncidenciaForm" method="post" enctype="multipart/form-data" 
		action="<?= PROJECTURLMENU; ?>portal/ver_resolucion_incidencia">
		
			<input type="hidden" id="resolucionIncidenciaId" name="resolucionIncidenciaId" value="" />
	</form>

	
	<div class="row">
		<div class="panel-group col-sm-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h4 class="panel-title">
					<!--  el ID debe ser único #collapse1 -->
					<table style="width:100%;">
						<tr>
							<td style="text-align:left;">
								<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse4');return false;">
									<span id="usuariosReportanCantidad" style="font-family: monospace; font-size: 18px;"></span> 
									Usuarios han reportado Incidencias en este a&ntilde;o. Click aqu&iacute; para desplegar:
								</a>
							</td>
						</tr>
					</table>
				</h4>
			  </div>

			  <div id="collapse4" class="panel-collapse collapse in">
				<div class="panel-body">
					<div id="no-more-tables">
<?php
						if ( $usuariosDeIncidenciasDeEsteAnyo == NULL || $usuariosDeIncidenciasDeEsteAnyo == "" ){
							echo "<br/>";
							echo "<b>No</b> se han reportado Incidencias en lo que va de año.";
							echo "<br/>";
							echo "<script>";
							echo ' document.getElementById("usuariosReportanCantidad").innerHTML = "0"; ';
							echo "</script>";
						} else {
?>
							<table id="usuariosReportado" class="table-hover table-striped cf" style="font-size: 14px;">
								<thead class="cf">
									<tr>
										<th class="active" width="250px">Nombre</th>
										<th class="active" width="250px">Apellido</th>
										<th class="active" width="200px">Dependencia</th>
										<th class="active" width="150px">Tel&eacute;fono</th>
										<th class="active" width="100px">Extensi&oacute;n</th>
										<th class="active" width="140px" style="text-align:center;">Tipo de Cuenta</th>
									</tr>
								</thead>
								<tbody>

<?php 							
								$k = 0;
								foreach ( $usuariosDeIncidenciasDeEsteAnyo as $user ) {
									$k++;
?>

									<tr>
										<td data-title="Nombre"><?= $user["nombre"]; ?></td>
										<td data-title="Apellido"><?= $user["apellido"]; ?></td>
										<td data-title="Dependencia"><?= $user["dependencia"]; ?></td>
										<td data-title="Telef."><?= $user["telefonoTrabajo"]; ?></td>
										<td data-title="Ext."><?= $user["extensionTrabajo"]; ?></td>
										<td data-title="Tipo Cuenta" style="text-align:center;">
											<?php 
												if ( $user["role"] == "admin"){ 		echo "Administrador"; }
												else if ( $user["role"] == "manager"){  echo "Partner"; }
												else if ( $user["role"] == "client"){ 	echo "Usuario"; }
												else if ( $user["role"] == "developer"){echo "Programador"; }
												else if ( $user["role"] == "tech"){ 	echo "Ing. de Soporte"; }
											?>
										</td>
									</tr>

<?php								
								}
								echo "<script>";
								echo ' document.getElementById("usuariosReportanCantidad").innerHTML = "' . $k . '"; ';
								echo "</script>";
?>

								</tbody>
							</table>
<?php					}   	?>

					</div>
				</div>
			  </div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="panel-group col-sm-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h4 class="panel-title">
					<!--  el ID debe ser único #collapse1 -->
					<table style="width:100%;">
						<tr>
							<td style="text-align:left;">
								<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse5');return false;">
									<span id="tecnicosResuelvenCantidad" style="font-family: monospace; font-size: 18px;"></span> 
									Ingenieros de Soporte han solucionado las Incidencias reportadas este a&ntilde;o. Click aqu&iacute; para desplegar:
								</a>
							</td>
						</tr>
					</table>
				</h4>
			  </div>

			  <div id="collapse5" class="panel-collapse collapse in">
				<div class="panel-body">
					<div id="no-more-tables">
<?php
						if ( $tecnicosQueHanVisitadoLaEmpresa == NULL || $tecnicosQueHanVisitadoLaEmpresa == "" ){
							echo "<br/>";
							echo "<b>No</b> se han reportado Incidencias en lo que va de año.";
							echo "<br/>";
							echo "<script>";
							echo ' document.getElementById("tecnicosResuelvenCantidad").innerHTML = "0"; ';
							echo "</script>";
						} else {
?>
							<table id="usuariosReportado" class="table-hover table-striped cf" style="font-size: 14px;">
								<thead class="cf">
									<tr>
										<th class="active" width="200px">Nombre</th>
										<th class="active" width="200px">Apellido</th>
										<th class="active" width="400px">Email</th>
									</tr>
								</thead>
								<tbody>

<?php 							
								$l = 0;
								foreach ( $tecnicosQueHanVisitadoLaEmpresa as $user ) {
									$l++;
?>

									<tr>
										<td data-title="Nombre"><?= $user["nombre"]; ?></td>
										<td data-title="Apellido"><?= $user["apellido"]; ?></td>
										<td data-title="Email"><?= $user["email"]; ?></td>
									</tr>

<?php							
								}
								echo "<script>";
								echo ' document.getElementById("tecnicosResuelvenCantidad").innerHTML = "' . $l . '"; ';
								echo "</script>";
?>

								</tbody>
							</table>
<?php					}   	?>

					</div>
				</div>
			  </div>
			</div>
		</div>
	</div>

	<hr/><br/><br/>
	<div class="row">
		<div class="col-sm-6" align="center">
			<b style="font-size:20px;font-family: cursive;">Incidencias a&uacute;n pendientes por resolver</b>
			<br/><br/>
			Este <i>Listado de Incidencias</i> puede verse en la pantalla Inicial del Portal,
			 <br/><b>Men&uacute; Incidencias, opci&oacute;n Consulta de Incidencias</b>
			<br/><br/>
			Aqu&iacute; aparecer&aacute;n aquellas que est&eacute;n entre los estatus: 
			 <b>Abierta</b>, <b>En Progreso</b> y <b>En Espera</b>.
			<br/><br/>
			<a href="<?= PROJECTURLMENU; ?>portal/home" class="btn btn-link">
				<span class="glyphicon glyphicon-home"></span> 
				Ver Incidencias en la p&aacute;gina principal del Portal
			</a>
		</div>
		<div class="col-sm-6" align="center">
			<b style="font-size:20px;font-family: cursive;">Incidencias Resueltas</b>
			<br/><br/>
			Este <i>Listado Hist&oacute;rico de Incidencias</i> puede verse en el 
			 <br/><b>Men&uacute; Incidencias, opci&oacute;n Hist&oacute;rico de Incidencias</b>
			<br/><br/>
			Aqu&iacute; aparecer&aacute;n aquellas que est&eacute;n entre los estatus: 
			 <b>Cerradas*</b> y <b>Certificadas</b>.
			 <br/><br/>
			 *Se recomienda <i>"Certificar"</i> todas aquellas Incidencias que se encuentren Cerradas 
			 con el fin de evaluar si nuestros Ingenieros de Soporte les proporcionaron
			 la <u>Soluci&oacute;n adecuada</u> y as&iacute; poder mejorar nuestra <b>Calidad de Servicio</b>.
			<br/><br/>
			<a href="<?= PROJECTURLMENU; ?>portal/historico_incidencias" class="btn btn-link">
				<span class="glyphicon glyphicon-hourglass"></span> 
				Consultar el Listado Hist&oacute;rico de Incidencias
			</a>
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
			<a href="<?= PROJECTURLMENU; ?>portal/home" class="btn btn-link">
				<span class="glyphicon glyphicon-home"></span> 
				Ir a la p&aacute;gina principal del Portal
			</a>
		</div>
	</div>

	<a href="javascript:goArriba();" class="back-to-top" data-toggle="tooltip" title="Volver Arriba">Volver Arriba</a>

	<br/><br/><br/><br/>

</div><!-- HTMLtoPDF -->
</div><!-- container -->
<script>
	$(document).ready(function(){

		$('.demo-2').percentcircle({
			animate : true,
			diameter : 100,
			guage: 2,
			coverBg: '#FFF',
			bgColor: '#FFF',
			fillColor: '#F9B233', /* color principal */
			percentWeight: 'normal'
		});

		$('.demo-3').percentcircle({
			animate : true,
			diameter : 100,
			guage: 2,
			coverBg: '#FFF',
			bgColor: '#FFF',
			fillColor: '#951B81', /* color principal */
			percentWeight: 'normal'
		});

		$('.collapse').collapse();

	});

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