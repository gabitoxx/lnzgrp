<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	/* Load the Visualization API and the corechart package. */
	google.charts.load('current', {'packages':['corechart'], 'language': 'es'});
</script>

<!-- Javascript del circulo -->
<script src="<?= APPJSPATH; ?>jquery.circlechart.js"></script>

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

	.demo {
		max-width: 960px;
		/* margin: 150px auto; */
	}

	.demo > div {
		float: initial;
		/* margin: 20px; */
	}

	#imgY {
		width: 200px;
		height: 180px;
	}
	#imgX {
		width: 350px;
		height: 350px;
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

	#div_year{
		display: block;
		position: fixed;
		right: 650px;
		bottom: 0px;
		font-size: 20px;
		z-index: 999;
		background-color: <?= RGB_MANAGER; ?>;
	}
</style>

<form class="form-horizontal" data-toggle="validator" role="form" id="searched_info_company" method="post"
 enctype="multipart/form-data" action="">

	<input type="hidden" id="seleccionarEmpresaID" 		 	name="seleccionarEmpresaID" 			value="" />
	<input type="hidden" id="seleccionarEmpresaNombre"   	name="seleccionarEmpresaNombre" 		value="" />
	<input type="hidden" id="seleccionarEmpresaRazonsocial" name="seleccionarEmpresaRazonsocial"  	value="" />
	<input type="hidden" id="seleccionarEmpresaNIT"  		name="seleccionarEmpresaNIT" 			value="" />
	<input type="hidden" id="seleccionarEmpresaDireccion"   name="seleccionarEmpresaDireccion" 		value="" />
	<input type="hidden" id="seleccionarEmpresaCantEquipos" name="seleccionarEmpresaCantEquipos" 	value="" />
</form>

<div id="container">
<div id="HTMLtoPDF" class="page-body">


	<div id="div_year" class=" well well-lg">
		<b>Reporte de <?= $reporteYear; ?></b>
	</div>

	<div class="row">
		<div class="col-sm-4">
			<br/>
			<h4 style="text-align:center; color:#E30513;">
				<span class="glyphicon glyphicon-dashboard"></span>
				<i>Dashboard</i> .:. <?= $empresa->nombre; ?>
			</h4>
		</div>
		<div class="col-sm-5" align="center">
			<br/>
			<h4 style="background-color:yellow;"><i>
				Res&uacute;men de Reportes para el a&ntilde;o <u><?= $reporteYear; ?></u>
			</i></h4>
		</div>
		<div class="col-sm-3" align="center">
			<h5>
				Solicitar Reporte de otro a&ntilde;o:
				<select class="form-control" id="anyo_dashboard" name="anyo_dashboard"
				 onchange="javascript:goToYearReport();" style="width:30%;">
<?php
				for ( $i = date("Y",time()); $i >= 2017; $i-- ){
					echo '<option value="' . $i . '"';
					if ( $i == $reporteYear ) echo 'selected="selected"';
					echo '>' . $i . '</option>';
				}
?>
				</select>
			</h5>
		</div>
	</div>
<?php 
	echo "<script> var URL = '" . PROJECTURLMENU . "admin/reporte_dashboard/'; </script>" ;
?>

	<!-- =================================================================================================== -->
	<hr/>

	<div class="row">
		<div class="col-sm-5" align="right" style="font-size: 50px;">
			<span class="glyphicon glyphicon-share"></span> 
		</div>
		<div class="col-sm-7" align="left">
			<h2>Uso del Portal</h2>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-4" align="center">
			<div class="demo">
				<div class="demo-1" data-percent="100"
				 data-show="<?php if(isset($estadisticasPortal["Cantidad_Usuarios"]) && is_numeric($estadisticasPortal["Cantidad_Usuarios"]) ) echo $estadisticasPortal["Cantidad_Usuarios"]; else echo "0"; ?>">
				</div>
			</div>
			<br/>
			Cantidad de Usuarios registrados en el Portal LanuzaGroup
		</div>
		<div class="col-sm-4" align="center">
			<div class="demo">
				<div class="demo-2" data-percent="100"
				 data-show="<?php if(isset($estadisticasPortal["Numero_veces_ingreso_Portal"]) && is_numeric($estadisticasPortal["Numero_veces_ingreso_Portal"]) ) echo $estadisticasPortal["Numero_veces_ingreso_Portal"]; else echo "0"; ?>">
				</div>
			</div>
			<br/>
			Cantidad de veces que han ingresado al Portal <b>en este mes</b>
		</div>
		<div class="col-sm-4" align="center">
			<div class="demo">
				<div class="demo-3" data-percent="100"
				 data-show="<?php if(isset($estadisticasPortal["Numero_incidencias_creadas"]) && is_numeric($estadisticasPortal["Numero_incidencias_creadas"]) ) echo $estadisticasPortal["Numero_incidencias_creadas"]; else echo "0"; ?>">
				</div>
			</div>
			<br/>
			N&uacute;mero de Incidencias creadas <b>en este mes</b>
		</div>
	</div>
	<br/>

	<!-- =================================================================================================== -->
	<br/><br/><br/>
	<hr/>

	<div id="fondo1" class="well">
	<div class="row">
		<div class="col-sm-5" align="right" style="font-size: 50px;">
			<span class="glyphicon glyphicon-blackboard"></span> 
		</div>
		<div class="col-sm-7" align="left">
			<h2>Equipos</h2>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-4" align="center">
			<div class="demo">
				<div class="demo-1" data-percent="100"
				 data-show="<?php if(isset($reporteEquipos["Cantidad_Equipos"])) echo $reporteEquipos["Cantidad_Equipos"]; else echo "0"; ?>">
				</div>
			</div>
			<br/>
			Cantidad de Equipos Registrados
		</div>
		<div class="col-sm-4" align="center">
			<div class="demo">
				<div class="demo-2" data-percent="<?php
					$aux = ( (100 * $reporteEquipos["Equipos_Asignados"] ) / $reporteEquipos["Cantidad_Equipos"] );
					echo $aux;
				?>"
				 data-show="<?php if(isset($reporteEquipos["Equipos_Asignados"])) echo $reporteEquipos["Equipos_Asignados"]; else echo "0"; ?>">
				</div>
			</div>
			<br/>
			Equipos Asignados a Usuarios
		</div>
		<div class="col-sm-4" align="center">
			<div class="demo">
				<div class="demo-3" data-percent="<?php
					$aux = ( (100 * $reporteEquipos["Equipos_No_Asignados"] ) / $reporteEquipos["Cantidad_Equipos"] );
					echo $aux;
				?>"
				 data-show="<?php if(isset($reporteEquipos["Equipos_No_Asignados"])) echo $reporteEquipos["Equipos_No_Asignados"]; else echo "0"; ?>">
				</div>
			</div>
			<br/>
			Equipos no Asignados <br/>(o sus usuarios no poseen Cuentas asignadas en el Portal)
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="col-sm-12" align="center" style="text-align:center;">
			<br/>
			<u style="background-color:yellow;">
				<b>Cantidad de Equipos</b> de su Empresa registrados en el Portal LanuzaGroup <b>(clasificados por tipo de Equipos</b>):
			</u>
			<br/><br/>
		</div>
	</div>

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

			$cont = -1;
			$inicioRow = false;
			$finRow    = false;

			for ( $j = 0; $j < $i; $j++ ){

				/* contador de filas en el HTML */
				$cont++;

				if ( $cont % 3 == 0 ) {

					echo '<div class="row">';
					$inicioRow = true;
					$finRow    = false;
				}
?>
					<div class="col-sm-1">&nbsp;</div>
					<div class="col-sm-3 well well-lg" align="center" style="border-color:#000;">
<?php
						/*
						 * Imagenes referenciales
						 */
						$aux = $equipment[$j];

						if ( $aux == "Escritorio" )						echo '* <img id="imgY" alt="Escritorio" src="' . APPIMAGEPATH . 'escritorio.jpg" />';
						else if ( $aux == "Todo-en-uno" )				echo '* <img id="imgY" alt="Todo-en-uno" src="' . APPIMAGEPATH . 'Todo-en-uno.jpg" />';
						else if ( $aux == "Laptop o Portátil" )			echo '* <img id="imgY" alt="Laptop" src="' . APPIMAGEPATH . 'laptop.png" />';
						else if ( $aux == "Servidor" )					echo '* <img id="imgY" alt="Servidor" src="' . APPIMAGEPATH . 'servidor.png" />';
						else if ( $aux == "Router" )					echo '* <img id="imgY" alt="Router" src="' . APPIMAGEPATH . 'router.jpg" />';
						else if ( $aux == "Impresora" )					echo '* <img id="imgY" alt="Impresora" src="' . APPIMAGEPATH . 'impresora.jpg" />';
						else if ( $aux == "Impresora Multifuncional" )	echo '* <img id="imgY" alt="Impresora Multifuncional" src="' . APPIMAGEPATH . 'multifuncional.jpg" />';
						else if ( $aux == "Cámara Vigilancia" )			echo '* <img id="imgY" alt="Cámara Vigilancia" src="' . APPIMAGEPATH . 'camara.jpg" />';
						else if ( $aux == "Escáner" )					echo '* <img id="imgY" alt="Escáner" src="' . APPIMAGEPATH . 'escaner.jpg" />';
						else if ( $aux == "Módem" )						echo '* <img id="imgY" alt="Módem" src="' . APPIMAGEPATH . 'modem.jpg" />';
						else if ( $aux == "Repetidor" )					echo '* <img id="imgY" alt="Repetidor" src="' . APPIMAGEPATH . 'repetidor.jpg" />';
						else if ( $aux == "Switch" )					echo '* <img id="imgY" alt="Switch" src="' . APPIMAGEPATH . 'switch.jpg" />';
						else if ( $aux == "Monitor" )					echo '* <img id="imgY" alt="Monitor" src="' . APPIMAGEPATH . 'monitor.jpg" />';
						else if ( $aux == "Teclado" )					echo '* <img id="imgY" alt="Teclado" src="' . APPIMAGEPATH . 'teclado.jpg" />';
						else if ( $aux == "Mouse" )						echo '* <img id="imgY" alt="Mouse" src="' . APPIMAGEPATH . 'mouse.jpg" />';
						else if ( $aux == "TV" )						echo '* <img id="imgY" alt="TV" src="' . APPIMAGEPATH . 'TV.jpg" />';
						else if ( $aux =="Equipo Empresarial especial")	echo '* <img id="imgY" alt="Equipo Empresarial especial" src="' . APPIMAGEPATH . 'maquina_especial.jpeg" />';
						else if ( $aux == "POS" )						echo '* <img id="imgY" alt="POS" src="' . APPIMAGEPATH . 'POS.png" />';
						else if ( $aux == "Celular" )					echo '* <img id="imgY" alt="Smartphones" src="' . APPIMAGEPATH . 'celular.png" />';
						else if ( $aux == "Otro" )						echo '* <img id="imgY" alt="Otro tipo de equipo" src="' . APPIMAGEPATH . 'otro_equipo.png" />';
						else 											echo '* <img id="imgY" alt="Otro tipo de equipo" src="' . APPIMAGEPATH . 'computadora-empresarial-handheld.jpg" />';
				
?>
						<br/><br/>
						<?= $aux . ": "; ?>
						<span style="font-size:18px;"><?= $quantity[$j]; ?></span>
						<?php if( $quantity[$j]==1 ) echo " unidad"; else echo " unidades"; ?>
						
					</div>
<?php
				if ( ($cont + 1) % 3 == 0 ) {

					echo '</div>';/* row */
					$finRow = true;
				}

			}/* for */

			if ( $inicioRow == true && $finRow == false ){
				echo '</div>';/* row */
			}
?>
	<div class="row">
		<div class="col-sm-12" align="right" style="text-align:right;font-size:11px;">
			* Im&aacute;genes referenciales, NO son fotos de los Equipos reales de la Empresa.
			<br/>
			Para ver m&aacute;s detalles de los Equipos de su Empresa, haga click en el <b>Men&uacute; Equipos</b>,
			opci&oacute;n <a href="<?= PROJECTURLMENU; ?>portal/mis_equipos">Inventario de Equipos</a>.
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
								<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse1');return false;">
									Usuarios de Equipos registrados: aquellos con Cuentas (<b>B&aacute;sicas o Partner</b>) en el Portal LanuzaGroup. Click aqu&iacute; para desplegar/ocultar:
								</a>
							</td>
						</tr>
					</table>
				</h4>
			  </div>

			  <div id="collapse1" class="panel-collapse collapse in">
				<div class="panel-body">
					<div id="no-more-tables">
						<table id="usuarios" class="col-md-12 table-hover table-striped cf" style="font-size: 14px;">
							<thead class="cf">
								<tr>
									<th class="active">Nombre</th>
									<th class="active">Apellido</th>
									<th class="active">Dependencia</th>
									<th class="active">Tel&eacute;fono</th>
									<th class="active">Extensi&oacute;n</th>
									<th class="active">Cuenta Tipo</th>
								</tr>
							</thead>
							<tbody>

<?php 						foreach ($usuariosEquipos as $user) {  ?>

								<tr>
									<td><?= $user["nombre"]; ?></td>
									<td><?= $user["apellido"]; ?></td>
									<td><?= $user["dependencia"]; ?></td>
									<td><?= $user["telefonoTrabajo"]; ?></td>
									<td><?= $user["extensionTrabajo"]; ?></td>
									<td>
										<?php 
											if ( $user["role"] == "admin"){ 		echo "Administrador"; }
											else if ( $user["role"] == "manager"){  echo "Partner"; }
											else if ( $user["role"] == "client"){ 	echo "Usuario"; }
											else if ( $user["role"] == "developer"){echo "Programador"; }
											else if ( $user["role"] == "tech"){ 	echo "Ing. de Soporte"; }
										?>
									</td>
								</tr>

<?php							} ?>

							</tbody>
						</table>
					</div>
				</div>
			  </div>
			</div>
		</div>
	</div>

	<br/><br/>
	<div class="row">
		<div class="col-sm-2">&nbsp;</div>
		<div class="col-sm-4" align="center" style="text-align:center;">
<?php
	$Windows_conLic = 0;
	$Windows_sinLic = 0;
	$OtrosSO_conLic = 0;
	$OtrosSO_sinLic = 0;

	if ( isset($licencias["win_contSi"]) ){ 	$Windows_conLic = $licencias["win_contSi"]; }
	if ( isset($licencias["win_contNo"]) ){ 	$Windows_sinLic = $licencias["win_contNo"]; }
	if ( isset($licencias["win_otrosSO_Si"]) ){ $OtrosSO_conLic = $licencias["win_otrosSO_Si"]; }
	if ( isset($licencias["win_otrosSO_No"]) ){ $OtrosSO_sinLic = $licencias["win_otrosSO_No"]; }
?>
			<script type="text/javascript">

				google.charts.setOnLoadCallback(drawChart3);

				function drawChart3() {

					/* Create the data table. */
					var data = new google.visualization.DataTable();
					data.addColumn('string', '¿Es Licenciado?');
					data.addColumn('number', 'Cantidad de Equipos');
					data.addRows([
						['Windows con Licencia',		<?= $Windows_conLic; ?> ],
						['Windows sin Licencia',		<?= $Windows_sinLic; ?> ],
						['Desconocido', 				<?= $licencias["win_contUnknown"]; ?> ],
						['Otros S.O. con Licencia', 	<?= $OtrosSO_conLic; ?> ],
						['Otros S.O. sin Licencia', 	<?= $OtrosSO_sinLic; ?> ]
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
							2: { color: '#94A6B0' },
							3: { color: '#39A8D9' },
							4: { color: '#AFCA0A' }
						},
						width: 450,
						height: 300
					};

					var chart = new google.visualization.PieChart(document.getElementById('chart_div_pie1'));
					chart.draw(data, options);
				}
			</script>
			<div id="chart_div_pie1" align="center" style="text-align:center;"></div>
		</div>
		<div class="col-sm-6" align="center" style="text-align:center;">
<?php
	$Office_conLic = 0;
	$Office_sinLic = 0;
	$OtroOff_conLic = 0;
	$OtroOff_sinLic = 0;

	if ( isset($licencias["off_contSi"]) ){ 	$Office_conLic  = $licencias["off_contSi"]; }
	if ( isset($licencias["off_contNo"]) ){ 	$Office_sinLic  = $licencias["off_contNo"]; }
	if ( isset($licencias["off_otros_Si"]) ){ 	$OtroOff_conLic = $licencias["off_otros_Si"]; }
	if ( isset($licencias["off_otros_No"]) ){ 	$OtroOff_sinLic = $licencias["off_otros_No"]; }
?>
			<script type="text/javascript">

			  google.charts.setOnLoadCallback(drawChart4);

			  function drawChart4() {

				/* Create the data table. */
				var data = new google.visualization.DataTable();
				data.addColumn('string', '¿Es Licenciado?');
				data.addColumn('number', 'Cantidad de Equipos');
				data.addRows([
					['Microsoft Office con Licencia', 			<?= $Office_conLic; ?> ],
					['Microsoft Office sin Licencia', 			<?= $Office_sinLic; ?> ],
					['Desconocido', 							<?= $licencias["off_contUnknown"]; ?> ],
					['Otro software Ofimático con Licencia', 	<?= $OtroOff_conLic; ?> ],
					['Otro software Ofimático sin Licencia', 	<?= $OtroOff_sinLic; ?> ]
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
						2: { color: '#94A6B0' },
						3: { color: '#39A8D9' },
						4: { color: '#AFCA0A' }
					},
					width: 500,
					height: 300
				};

				var chart = new google.visualization.PieChart(document.getElementById('chart_div_pie2'));
				chart.draw(data, options);
			  }
			</script>
			<div id="chart_div_pie2" align="center" style="text-align:center;"></div>
		</div>
	</div>


	<div class="row">
<?php
	$cantReemplazosHardware = 0;
	foreach ( $reemplazosHardware as $hw) {
		$cantReemplazosHardware++;
	}

	$cantReemplazosSoftware = 0;
	foreach ( $reemplazosSoftware as $sf) {
		$cantReemplazosSoftware++;
	}

	$totalReemplazos = $cantReemplazosHardware + $cantReemplazosSoftware;
?>
		<div class="col-sm-4" align="center">
			<div class="demo">
				<div class="demo-1" data-percent="100" data-show="<?= $totalReemplazos; ?>">
				</div>
			</div>
			<br/>
			<b>Total</b> de Reemplazos/Cambios realizados por nuestros Ingenieros de Soporte en sus Equipos
		</div>
		<div class="col-sm-4" align="center">
			<div class="demo">
				<div class="demo-2" data-percent="<?= ( (100 * $cantReemplazosHardware ) / $totalReemplazos );	?>" 
				 data-show="<?= $cantReemplazosHardware; ?>">
				</div>
			</div>
			<br/>
			Total de Reemplazos/Cambios de <b>Hardware</b>
		</div>
		<div class="col-sm-4" align="center">
			<div class="demo">
				<div class="demo-3" data-percent="<?= ( (100 * $cantReemplazosSoftware ) / $totalReemplazos );	?>" 
				 data-show="<?= $cantReemplazosSoftware; ?>">
				</div>
			</div>
			<br/>
			Total de Reemplazos/Cambios de <b>Software</b>
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
								<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse2');return false;">
									Detalle de los Cambios Realizados por nuestros Ingenieros de Soporte en sus Equipos. Click aqu&iacute; para desplegar/ocultar:
								</a>
							</td>
						</tr>
					</table>
				</h4>
			  </div>


			  <div id="collapse2" class="panel-collapse collapse in">
				<div class="panel-body">
					<div id="no-more-tables">

						<div class="row">
							<div class="col-sm-12" align="center">

								<div style="text-align:center;">
									<u style="background-color:yellow;">Cambios en el <b>Hardware</b> de sus Equipos (Equipos, Perif&eacute;ricos, entre otros):</u>
								</div>
								<br/>
<?php 						
								if ( $cantReemplazosHardware == 0 ){
									echo "<br/>";
									echo "<b>No</b> ha habido la necesidad de realizar cambios en el Hardware de sus Equipos hasta ahora.";
									echo "<br/>";
								} else {
?>
									<table id="cambiosHW" class="col-md-12 table-hover table-striped cf" style="font-size: 14px;">
										<thead class="cf">
											<tr>
												<th class="active">Hardware a Reemplazar</th>
												<th class="active">Descripci&oacute;n</th>
												<th class="active">Hardware reemplazado</th>
												<th class="active">Hardware Nuevo</th>
												<th class="active" style="text-align:center;">&iquest;Fue Reemplazado&quest;</th>
											</tr>
										</thead>
										<tbody>
<?php 									
											foreach ($reemplazosHardware as $hw) {  ?>

												<tr>
													<td><?= $hw["hardwareARemplazar"]; ?></td>
													<td><?= $hw["descripcion"]; ?></td>
													<td><?= $hw["hardwareViejo"]; ?></td>
													<td><?= $hw["hardwareNuevo"]; ?></td>
													<td style="text-align:center;"><?= ucfirst( $hw["fueRemplazado"] ); ?></td>
												</tr>

<?php										}
								}
?>

									</tbody>
								</table>
							</div>
						</div>

						<div class="row"><div class="col-sm-12"><br/>&nbsp;<br/></div></div>

						<div class="row">
							<div class="col-sm-12" align="center">

								<div style="text-align:center;">
									<u style="background-color:yellow;">Cambios en el <b>Software</b> de sus Equipos (Programas, instalaciones nuevas o reemplazos, entre otros):</u>
								</div>
								<br/>
								
<?php 						
								if ( $cantReemplazosHardware == 0 ){
									echo "<br/>";
									echo "<b>No</b> ha existido la necesidad de realizar nuevas instalaciones en el Software de sus Equipos hasta ahora.";
									echo "<br/>";
								} else {
?>
									<table id="cambiosSF" class="col-md-12 table-hover table-striped cf" style="font-size: 14px;">
										<thead class="cf">
											<tr>
												<th class="active">Software a Reemplazar</th>
												<th class="active">Versi&oacute;n</th>
												<th class="active" style="text-align:center;">Tipo de Software<br/>(Libre o Propietario)</th>
												<th class="active">Serial</th>
												<th class="active" style="text-align:center;">Trabajo realizado<br/>(Cambio o Instalaci&oacute;n)</th>
											</tr>
										</thead>
										<tbody>

<?php 										foreach ($reemplazosSoftware as $sf) { ?>

												<tr>
													<td><?= $sf["softwareARemplazar"]; ?></td>
													<td><?= $sf["version"]; ?></td>
													<td style="text-align:center;"><?= ucfirst( $sf["tipo"] ); ?></td>
													<td><?= $sf["serial"]; ?></td>
													<td style="text-align:center;"><?= ucfirst( $sf["trabajo"] ); ?></td>
												</tr>

<?php										}
								}
?>
									</tbody>
								</table>

							</div>
						</div>

					</div>
				</div>
			  </div>

			</div>
		</div>
	</div>
	</div>

	<!-- =================================================================================================== -->
	<br/><br/><br/>
	<hr/>

	<div class="row">
		<div class="col-sm-5" align="right" style="font-size: 50px;">
			<span class="glyphicon glyphicon-fire"></span> 
		</div>
		<div class="col-sm-7" align="left">
			<h2>Incidencias</h2>
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
		<div class="col-sm-7" align="center" style="text-align:center;">
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

		<div class="col-sm-1">&nbsp;</div>

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
									Causas de las Incidencias registradas en los Reportes (Detalles de los Problemas). Click aqu&iacute; para desplegar/ocultar:
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
														
														echo "  <td>";
														echo      '<button type="button" class="btn btn-primary" 
																	data-toggle="tooltip" data-placement="bottom" title="Ver Soluci&oacute;n de la Incidencia | Opci&oacute;n Imprimir Reporte"
																	onclick="javascript:verDetalleSolucion(' . $aux . ');"><span class="glyphicon glyphicon-folder-open"></span></button>';
														echo "  </td>";
														
														echo "  <td>";
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
		action="<?= PROJECTURLMENU; ?>admin/ver_resolucion_incidencia">
		
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
									Usuarios han reportado Incidencias en este a&ntilde;o. Click aqu&iacute; para desplegar/ocultar:
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
										<th class="active" width="140px" style="text-align:center;">Cuenta Tipo</th>
									</tr>
								</thead>
								<tbody>

<?php 							
								$k = 0;
								foreach ( $usuariosDeIncidenciasDeEsteAnyo as $user ) {
									$k++;
?>

									<tr>
										<td><?= $user["nombre"]; ?></td>
										<td><?= $user["apellido"]; ?></td>
										<td><?= $user["dependencia"]; ?></td>
										<td><?= $user["telefonoTrabajo"]; ?></td>
										<td><?= $user["extensionTrabajo"]; ?></td>
										<td style="text-align:center;">
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
									Ingenieros de Soporte han solucionado las Incidencias reportadas este a&ntilde;o. Click aqu&iacute; para desplegar/ocultar:
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
										<td><?= $user["nombre"]; ?></td>
										<td><?= $user["apellido"]; ?></td>
										<td><?= $user["email"]; ?></td>
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



	<!-- =================================================================================================== -->
	<br/><br/><br/>
	<hr/>

	<div id="fondo1" class="well">
	<div class="row">
		<div class="col-sm-5" align="right" style="font-size: 50px;">
			<span class="glyphicon glyphicon-calendar"></span> 
		</div>
		<div class="col-sm-7" align="left">
			<h2>Agenda (citas programadas)</h2>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12" align="center">
			<u style="background-color:yellow;">
				Citas <i>pendientes</i> (Agenda a Futuro) de las Visitas a su Empresa por parte de nuestros Ingenieros de Soporte
			</u>
		</div>
	</div>

	<br/><br/>
	<div class="row">
		<div class="col-sm-12">
			<div id="no-more-tables">
<?php
						if ( $citasFuturas == NULL || $citasFuturas == "" ){
							echo "<br/>";
							echo "<b>No</b> hay agendadas Citas de Soporte IT pendientes programadas en nuestra Agenda.";
							echo "<br/>";
						} else {
?>
							<table id="agendaFutura" class="table-hover table-striped cf" style="font-size: 14px;">
								<thead class="cf">
									<tr>
										<th class="active" width="100px">Fecha<br/>(a&ntilde;o-mes-d&iacute;a)</th>
										<th class="active" width="200px">Horario de Visita</th>
										<th class="active" width="300px">Trabajo a Realizar</th>
										<th class="active" width="200px">Ing. de Soporte asignado</th>
									</tr>
								</thead>
								<tbody>

<?php 							foreach ( $citasFuturas as $cita ) {		?>

									<tr>
										<td>
											<?= substr( $cita["fecha_cita"], 0, 10 ); ?>
										</td>
										<td>
											<?php 
												$aux = $cita["hora_estimada"] . " " . $cita["am_pm"];

												if ( $cita["hasta_hora"] != NULL && $cita["hasta_hora"] != "" ){
													$aux1 = "Desde las " . $aux . " Hasta las " . $cita["hasta_hora"] . " " . $cita["hasta_am_pm"];

												} else {
													$aux1 = "A las " . $aux;
												}
												echo $aux1;
											?>
										</td>
										<td>
											<?php
												if ( $cita["inventario_info"] != NULL && $cita["inventario_info"] ){
													echo $cita["trabajoArealizar"] . "<br/>" . $cita["inventario_info"];
												} else {
													echo $cita["trabajoArealizar"];
												}
											?>
										</td>
										<td>
											<?php 
												if ( $cita["tecnicoId"] != NULL && $cita["tecnicoId"] != ""){
													echo $cita["nombre"] . " " . $cita["apellido"] . "<br/>(Contacto: " . $cita["email"] . ")";
												} else {
													echo "No asignado aún";
												}
											?>
										</td>
									</tr>

<?php							}	?>

								</tbody>
							</table>
<?php					}   	?>

			</div>
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
								<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse6');return false;">
									<span id="citasCantidad" style="font-family: monospace; font-size: 18px;"></span> 
									Citas de Soporte IT realizadas en lo que van de a&ntilde;o. Click aqu&iacute; para desplegar/ocultar:
								</a>
							</td>
						</tr>
					</table>
				</h4>
			  </div>

			  <div id="collapse6" class="panel-collapse collapse in">
				<div class="panel-body">
					<div id="no-more-tables">
<?php
						if ( $citasPasadas == NULL || $citasPasadas == "" ){
							echo "<br/>";
							echo "<b>No</b> se han reportado Incidencias en lo que va de año.";
							echo "<br/>";
							echo "<script>";
							echo ' document.getElementById("citasCantidad").innerHTML = "0"; ';
							echo "</script>";
						} else {
?>
							<table id="agendaPasada" class="table-hover table-striped cf" style="font-size: 14px;">
								<thead class="cf">
									<tr>
										<th class="active" width="100px">Fecha<br/>(a&ntilde;o-mes-d&iacute;a)</th>
										<th class="active" width="200px">Horario de Visita</th>
										<th class="active" width="300px">Trabajo a Realizar</th>
										<th class="active" width="200px">Ing. de Soporte asignado</th>
									</tr>
								</thead>
								<tbody>

<?php 							
								$m = 0;
								foreach ( $citasPasadas as $cita ) {
									$m++;
?>

									<tr>
										<td>
											<?= substr( $cita["fecha_cita"], 0, 10 ); ?>
										</td>
										<td>
											<?php 
												$aux = $cita["hora_estimada"] . " " . $cita["am_pm"];

												if ( $cita["hasta_hora"] != NULL && $cita["hasta_hora"] != "" ){
													$aux1 = "Desde las " . $aux . " Hasta las " . $cita["hasta_hora"] . " " . $cita["hasta_am_pm"];

												} else {
													$aux1 = "A las " . $aux;
												}
												echo $aux1;
											?>
										</td>
										<td>
											<?php
												if ( $cita["inventario_info"] != NULL && $cita["inventario_info"] ){
													echo $cita["trabajoArealizar"] . "<br/>" . $cita["inventario_info"];
												} else {
													echo $cita["trabajoArealizar"];
												}
											?>
										</td>
										<td>
											<?php 
												if ( $cita["tecnicoId"] != NULL && $cita["tecnicoId"] != ""){
													echo $cita["nombre"] . " " . $cita["apellido"] . "<br/>(Contacto: " . $cita["email"] . ")";
												} else {
													echo "No asignado aún";
												}
											?>
										</td>
									</tr>

<?php							
								}
								echo "<script>";
								echo ' document.getElementById("citasCantidad").innerHTML = "' . $m . '"; ';
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
		<div class="col-sm-4">&nbsp;</div>
		<div class="col-md-4 well well-lg" style="text-align:center;">
			<br/><br/>
			<span id="numero_reportes_visita" style="font-family: cursive; font-size: 50px;"></span>
			<br/><br/>
			Reportes de Visita se han generado en este a&ntilde;o
			<br/><br/><br/>
		</div>
		<div class="col-sm-4">&nbsp;</div>
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
								<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse7');return false;">
									<span id="citasCantidad" style="font-family: monospace; font-size: 18px;"></span> 
									Reportes de Visita: trabajos realizados por nuestros Ingenieros de Soporte en su Empresa in-situ (presencialmente). Click aqu&iacute; para desplegar/ocultar:
								</a>
							</td>
						</tr>
					</table>
				</h4>
			  </div>


				<div id="collapse7" class="panel-collapse collapse in">

				<div id="no-more-tables">
					<table class="col-md-12 table-hover table-striped cf" style="font-size:12px;">
						<thead class="cf">
							<tr>
								<th width="90px" class="active" style="text-align: center;" align="center">Nº Reporte<br/>y Estatus</th>
								<th width="110px" style="text-align: center;" align="center">Acciones</th>
								<th width="160px" style="text-align: center;" align="center">Fecha<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
								<th style="text-align: center;" align="center">Trabajo</th>
								<th width="130px" style="text-align: center;" align="center">Usuario<br/>afectado</th>
								<th style="text-align: center;" align="center">Observaciones</th>
								
							</tr>
						</thead>
						<tbody>
		<?php 

							/* Recorrido de Informes */
							$count=0;
							foreach ( $reportesVisita as $informe ) {
								$count++;
		?>
								<tr>

									<td data-title="#Reporte/Estatus" align="center" style="padding-top: 10px; padding-bottom: 10px;">
										<?= $informe["incidenciaId"] . "<br/>" . $informe["status"] ?>
									</td>

									<td data-title="Acciones" >
										<button type="button"
										 <?php 
											if ($informe["resolucionId"]==null || $informe["resolucionId"]==""){
												echo 'class="btn btn-primary disabled" disabled="disabled" ';
											}else{
												echo 'class="btn btn-primary"';
											}
										 ?>
										 data-toggle="tooltip" data-placement="top" title="VER +Detalles: Trabajo realizado al Equipo"
										 onclick="javascript:verMasDetalles('<?php echo 'tr-' . $informe["solucionId"] ?>');">
											<span class="glyphicon glyphicon-folder-open"></span> 
										</button>
										&nbsp;
										<button type="button"
										 <?php 
											if ($informe["tecnicoId"]==null || $informe["tecnicoId"]==""){
												echo 'class="btn btn-info disabled" disabled="disabled" ';
											}else{
												echo 'class="btn btn-info"';
											}
										 ?>
										 data-toggle="tooltip" data-placement="top" title="Ver Informaci&oacute;n de Contacto del Ingeniero de Soporte"
										 onclick="javascript:verInfoTecnico(<?php echo $informe["tecnicoId"] ?>);"
										 >
											<span class="glyphicon glyphicon-info-sign"></span> 
										</button>
										
									</td>

									<td data-title="Fecha Realización"><?php echo $informe["fecha"]; ?></td>
									<td data-title="Trabajo hecho:">
		<?php 
										echo $informe["TipoFalla"];
		?>
									</td>

									<td data-title="Usuario afectado" style="text-align: center;" align="center" class="info">
										<?php echo $informe["UsuarioNombre"] . "<br/>" . $informe["UsuarioApellido"]; ?>
									</td>

									<td data-title="Observaciones"><?php echo $informe["observaciones"]; ?></td>
									
								</tr>

								<tr id="<?= 'tr-' . $informe["solucionId"]; ?>" style="display: none; border: 1px solid black;">

									<td style="text-align: center;" align="center" class="warning">
										<a href="#" onclick="javascript:verMenosDetalles('<?= 'tr-' . $informe["solucionId"]; ?>');return false;" style="font-size:18px;">
											Cerrar
										</a>
									</td>
									<td colspan="2">
										Se reportaron las siguientes variables
										<br/><br/>
										<b>Variables End&oacute;genas:</b> 
		<?php 							if($informe["variableEndogena"]==NULL || $informe["variableEndogena"]=="") echo "N/A"; else echo $informe["variableEndogena"]; ?>
										
										<br/><br/>
										_________<br/>
										<b>Variables Ex&oacute;genas T&eacute;cnicas:</b> 
		<?php 							if($informe["variableExogenaTecnica"]==NULL || $informe["variableExogenaTecnica"]=="") echo "N/A"; else echo $informe["variableExogenaTecnica"]; ?>

										<br/><br/>
										_________<br/>
										<b>Variables Ex&oacute;genas Humanas:</b> 
		<?php 							if($informe["variableExogenaHumana"]==NULL || $informe["variableExogenaHumana"]=="") echo "N/A"; else echo $informe["variableExogenaHumana"]; ?>
									</td>

									<td colspan="3">
										<i>Trabajo Realizado:</i>
										<br/><br/>
										<b>Hardware:</b> 
		<?php 							if($informe["tipoTrabajoHardware"]==NULL || $informe["tipoTrabajoHardware"]=="") echo "N/A"; else echo $informe["tipoTrabajoHardware"]; ?>
										<br/>
										<b>Detalles:</b> 
		<?php 							if($informe["mantenimientoHardware"]==NULL || $informe["mantenimientoHardware"]=="") echo "N/A"; else echo $informe["mantenimientoHardware"]; ?>

										<br/><br/>
										_________<br/>
										<b>Software:</b> 
		<?php 							if($informe["tipoTrabajoSoftware"]==NULL || $informe["tipoTrabajoSoftware"]=="") echo "N/A"; else echo $informe["tipoTrabajoSoftware"]; ?>
										<br/>
										<b>Detalles:</b> 
		<?php 							if($informe["mantenimientoSoftware"]==NULL || $informe["mantenimientoSoftware"]=="") echo "N/A"; else echo $informe["mantenimientoSoftware"]; ?>

										<br/><br/>
										_________<br/>
										<i>Acompa&ntilde;amiento Junior:</i> 
		<?php 							if($informe["acompanamientoJunior"]==NULL || $informe["acompanamientoJunior"]=="") echo "N/A"; else echo $informe["acompanamientoJunior"]; ?>

									</td>
								</tr>

		<?php 				} ?>

						</tbody>
					</table>
		<?php
							echo "<script>";
							echo '	document.getElementById("numero_reportes_visita").innerHTML = "' . $count . '";	';
							echo "</script>";
		?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- =================================================================================================== -->
	<br/><br/><br/>
	<hr/>

	<div class="row">
		<div class="col-sm-5" align="right" style="font-size: 50px;">
			<span class="glyphicon glyphicon-tags"></span> 
		</div>
		<div class="col-sm-7" align="left">
			<h2>Inventario actual</h2>
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
								<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse8');return false;">
									<span id="citasCantidad" style="font-family: monospace; font-size: 18px;"></span> 
									A continuaci&oacute;n podr&aacute; ver el Iventario actualizado de Equipos, y un resumen de cada uno.
									Click aqu&iacute; para desplegar/ocultar:
								</a>
							</td>
						</tr>
					</table>
				</h4>
			  </div>


				<div id="collapse8" class="panel-collapse collapse in">

<?php 	
					if ( isset($inventario) ){

						$cont = -1;
						$inicioRow = false;
						$finRow    = false;

						foreach ($inventario as $equipo) {

							$cont++;

							if ( $cont % 2 == 0 ) {

								echo '<div class="row">';
								$inicioRow = true;
								$finRow    = false;
							}
							
?>
					
						<div class="col-sm-1">&nbsp;</div>
						<div class="col-sm-5 well well-lg" align="center" style="border-color:#000;">
							 
							<?php
								if ( $equipo["linkImagen"] != NULL && $equipo["linkImagen"] != "" ) {
									/*
									 * Imagen Real del Equipo (Foto)
									 */
									echo '<img id="imgX" alt="' . $equipo["TipoEquipo"] . '" src="' . $equipo["linkImagen"] . '" />';

								} else {
									echo "* ";
									/*
									 * Imagenes referenciales
									 */
									if ( $equipo["TipoEquipo"] == "Escritorio" )						echo '** <img id="imgX" alt="Escritorio" src="' . APPIMAGEPATH . 'escritorio.jpg" />';
									else if ( $equipo["TipoEquipo"] == "Todo-en-uno" )					echo '** <img id="imgX" alt="Todo-en-uno" src="' . APPIMAGEPATH . 'Todo-en-uno.jpg" />';
									else if ( $equipo["TipoEquipo"] == "Laptop o Portátil" )			echo '** <img id="imgX" alt="Laptop" src="' . APPIMAGEPATH . 'laptop.png" />';
									else if ( $equipo["TipoEquipo"] == "Servidor" )						echo '** <img id="imgX" alt="Servidor" src="' . APPIMAGEPATH . 'servidor.png" />';
									else if ( $equipo["TipoEquipo"] == "Router" )						echo '** <img id="imgX" alt="Router" src="' . APPIMAGEPATH . 'router.jpg" />';
									else if ( $equipo["TipoEquipo"] == "Impresora" )					echo '** <img id="imgX" alt="Impresora" src="' . APPIMAGEPATH . 'impresora.jpg" />';
									else if ( $equipo["TipoEquipo"] == "Impresora Multifuncional" )		echo '** <img id="imgX" alt="Impresora Multifuncional" src="' . APPIMAGEPATH . 'multifuncional.jpg" />';
									else if ( $equipo["TipoEquipo"] == "Cámara Vigilancia" )			echo '** <img id="imgX" alt="Cámara Vigilancia" src="' . APPIMAGEPATH . 'camara.jpg" />';
									else if ( $equipo["TipoEquipo"] == "Escáner" )						echo '** <img id="imgX" alt="Escáner" src="' . APPIMAGEPATH . 'escaner.jpg" />';
									else if ( $equipo["TipoEquipo"] == "Módem" )						echo '** <img id="imgX" alt="Módem" src="' . APPIMAGEPATH . 'modem.jpg" />';
									else if ( $equipo["TipoEquipo"] == "Repetidor" )					echo '** <img id="imgX" alt="Repetidor" src="' . APPIMAGEPATH . 'repetidor.jpg" />';
									else if ( $equipo["TipoEquipo"] == "Switch" )						echo '** <img id="imgX" alt="Switch" src="' . APPIMAGEPATH . 'switch.jpg" />';
									else if ( $equipo["TipoEquipo"] == "Monitor" )						echo '** <img id="imgX" alt="Monitor" src="' . APPIMAGEPATH . 'monitor.jpg" />';
									else if ( $equipo["TipoEquipo"] == "Teclado" )						echo '** <img id="imgX" alt="Teclado" src="' . APPIMAGEPATH . 'teclado.jpg" />';
									else if ( $equipo["TipoEquipo"] == "Mouse" )						echo '** <img id="imgX" alt="Mouse" src="' . APPIMAGEPATH . 'mouse.jpg" />';
									else if ( $equipo["TipoEquipo"] == "TV" )							echo '** <img id="imgX" alt="TV" src="' . APPIMAGEPATH . 'TV.jpg" />';
									else if ( $equipo["TipoEquipo"] == "Equipo Empresarial especial" )	echo '** <img id="imgX" alt="Equipo Empresarial especial" src="' . APPIMAGEPATH . 'maquina_especial.jpeg" />';
									else if ( $equipo["TipoEquipo"] == "POS" )							echo '** <img id="imgX" alt="POS" src="' . APPIMAGEPATH . 'POS.png" />';
									else if ( $equipo["TipoEquipo"] == "Celular" )						echo '** <img id="imgX" alt="Smartphones" src="' . APPIMAGEPATH . 'celular.png" />';
									else if ( $equipo["TipoEquipo"] == "Otro" )							echo '** <img id="imgX" alt="Otro tipo de equipo" src="' . APPIMAGEPATH . 'otro_equipo.png" />';
									else 																echo '** <img id="imgX" alt="Otro tipo de equipo" src="' . APPIMAGEPATH . 'computadora-empresarial-handheld.jpg" />';
								}
							?>
							<br/>
							<?= "<b>" . $equipo["TipoEquipo"] . "</b>"; ?>
							<br/>
							<?= "Dependencia: " . $equipo["dependencia"]; ?>
							<br/>
							<br/>
							<?= "Sistema Operativo: " . $equipo["sistemaOperativo"] . " " . $equipo["versionSO"] . " " . $equipo["nombreSO"]; ?>
							<br/>
							<br/>
							<?= "Marca y Modelo: " . $equipo["marca"] . " / " . $equipo["modelo"]; ?>
							<br/>
							<?= "Serial: " . $equipo["serial"]; ?>
							<br/>
							<?= "C&oacute;digo Barras: " . $equipo["codigoBarras"]; ?>
							<br/>
							<?php 
								if ( $equipo["infoBasica"] != NULL && $equipo["infoBasica"] != ""){
									echo $equipo["infoBasica"]. " <br/>";
								}
							?>
							<?php 
								if ( $equipo["observacionInicial"] != NULL && $equipo["observacionInicial"] != ""){
									echo " (" . $equipo["observacionInicial"] . ") <br/>";
								}
							?>
									
						</div>

<?php 	
							if ( $cont % 2 != 0 ) {

								echo '</div>';/* row */
								$finRow = true;
							}

						} /* foreach */

						if ( $inicioRow == true && $finRow == false ){
							echo '</div>';/* row */
						}

					} /* inventario */
?>
						
						<br/><br/>
						<div class="col-sm-8" align="center" style="background-color:yellow;">
							<h6>** Im&aacute;genes referenciales, NO son fotos de los Equipos reales de la Empresa.</h6>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- =================================================================================================== -->
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

	<a href="javascript:goArriba();" class="back-to-top" data-toggle="tooltip" title="Volver Arriba">Volver Arriba</a>

	<br/><br/><br/><br/>

</div><!-- HTMLtoPDF -->
</div><!-- container -->

<script>
	$(document).ready(function(){

		
		$('.demo-1').percentcircle({
			animate : true,
			diameter : 100,
			guage: 3,
			coverBg: '#F9B233',
			bgColor: '#951B81',
			fillColor: '#39A8D9',
			percentWeight: 'normal'
		});

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

	function verMasDetalles(trId){
		var result_style = document.getElementById( trId ).style;
		result_style.display = 'table-row';
	}
	function verMenosDetalles(trId){
		var result_style = document.getElementById( trId ).style;
		result_style.display = 'none';
	}


	function goArriba(){
		location.href = "#container";
	}

	function goToYearReport(){

		$("#container").css('cursor', 'wait');

		URL += $("#anyo_dashboard").val();
		
		// redireccion por GET		
		//location.href = URL;

		/* redireccion por POST de un formulario */
		$("#seleccionarEmpresaID").val('<?= $seleccionarEmpresaID; ?>');
		$("#seleccionarEmpresaNombre").val('<?= $seleccionarEmpresaNombre; ?>');
		$("#seleccionarEmpresaRazonsocial").val('<?= $seleccionarEmpresaRazonsocial; ?>');
		$("#seleccionarEmpresaNIT").val('<?= $seleccionarEmpresaNIT; ?>');
		$("#seleccionarEmpresaDireccion").val('<?= $seleccionarEmpresaDireccion; ?>');
		$("#seleccionarEmpresaCantEquipos").val('<?= $seleccionarEmpresaCantEquipos; ?>');

		document.getElementById("searched_info_company").action = URL;
		document.getElementById("searched_info_company").submit();
		
	}
	

</script>

<!-- ========================= MODAL para ver la info del Técnico ============================ -->
<div class="modal fade" id="myModal" role="dialog">
	<!-- tamaño del modal: modal-sm PEQUEÑO | modal-lg GRANDE -->
	<div class="modal-dialog modal-sm">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title" align="center">
			<span class="glyphicon glyphicon-wrench"></span> 
			Informaci&oacute;n del Ing. de Soporte
		  </h4>
		</div>

		<div class="modal-body">
		  <p><div id="feedback"></div></p>
		</div>

		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
	  </div>
	</div>
</div>
<!-- ========================= Formulario para usar AJAX .:. Buscar Datos Tecnico ============================ -->
<?php
	echo "<script>";
	echo "   var modalAjaxURL = '" . PROJECTURLMENU . "tecnicos/ajax_ver_tecnico';" ;
	echo "</script>";
?>

<form id="enviarTecnico" method="post" enctype="multipart/form-data">
	<input type="hidden" id="tecnicoId" name="tecnicoId" value="" />
</form>

<script>
	function verInfoTecnico(tecnicoId){

		$('#myModal').modal({
			backdrop: 'static',
			keyboard: false,
			show: true
		});

		/* valor en el input type hidden */
		document.getElementById("tecnicoId").value = "" + tecnicoId;

		$.ajax({
			type: "POST",
			url: modalAjaxURL,
			data: $('#enviarTecnico').serialize(),
			success: function(message){
				/*alert("OK_");*/
				/*$("#feedback-modal").modal('hide');*/
				$("#feedback").html(message);
			},
			error: function(){
				alert("Error al buscar info del Técnico en nuestro Sistema\nPor favor, intente más tarde");
			}
		});
	}
</script>