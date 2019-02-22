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
	.imgX {
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

	#licencias-ofimaticas {
		font-size: 14px;
		text-align:center;
	}

	.semaforo {
		width: 35px;
		height: 80px;
		position: relative;
		z-index: 999;
		left: 400px;
	}
	.semaforo_verde {
		background: url(<?= APPIMAGEPATH; ?>semaforo_142x80_20.png) 0px 0px;
	}
	.semaforo_amarillo {
		background: url(<?= APPIMAGEPATH; ?>semaforo_142x80_20.png) -35px 0px;
	}
	.semaforo_rojo {
		background: url(<?= APPIMAGEPATH; ?>semaforo_142x80_20.png) -70px 0px;
	}
	.semaforo_all {
		background: url(<?= APPIMAGEPATH; ?>semaforo_142x80_20.png) -105px 0px;
	}

</style>

<div id="container">
  <div id="HTMLtoPDF" class="page-body">

		<div class="row">
			<div class="col-sm-12">
				<br/>
				<h4 style="text-align:center; color:#E30513;">
					<span class="glyphicon glyphicon-dashboard"></span>
					<i>Inventario por Licencias </i> .:. <?= $empresa->nombre; ?>
				</h4>
			</div>
		</div>

<!-- =================================================================================================== -->
		<hr/>

		<div class="row">
			<div class="col-sm-6" align="center">
				<h2>Clasificaci&oacute;n de Licencias por <b>Herramientas Ofim&aacute;ticas</b></h2>
			</div>
			<div class="col-sm-6" align="center">
				<h2>Clasificaci&oacute;n de Licencias por <b>Sistemas Operativos</b></h2>
			</div>
		</div>

		<div class="row">
			
			<div class="col-sm-6" align="center">
				<div id="chart_div_pie1" align="center" style="text-align:center;"></div>
			</div>

			<div class="col-sm-6" align="center">
				<div id="chart_div_pie2" align="center" style="text-align:center;"></div>
			</div>

		</div>

		<div class="row">
			<div class="col-sm-12" align="center">
				<div>
					<h6>
						* Si no aparece en la parte superior 2 gr&aacute;ficos de torta, es porque no existe registrada
						informaci&oacute;n referente a las Licencias de los Equipos registrados en su Empresa.
					</h6>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12" align="left">
				<strong>Leyenda: Tipos de Licencias</strong>
				<br/><br/>
				<b>Contrato</b>: Definida por un tiempo de contrato (Enterprise Agreement).
				<br/>
				<b>Licenciamiento FPP (Full Packaged Product/Licencia Retail)</b>: Estas licencias se pueden transferir a otro equipo siempre y cuando se desinstale de la m&aacute;quina inicial y se debe traspasar el COA, Manuales, Discos, etc.
				<br/>
				<b>Licenciamiento OEM (Original Equipment Manufacturer / Fabricante de equipos originales)</b>: Son licencias preinstaladas por fabricantes de computadoras que no se pueden transferir a otro equipo.
				<br/>
				<b>Licenciamiento OEM COA</b>: OEM para la reinstalaci&oacute;n en un nuevo equipo,  que se har&iacute;a con el Certificado de Autenticidad (COA) debido a que este ya se peg&oacute; en el equipo anterior.
				<br/>
				<b>Licenciamiento OEM BOX</b>: OEM f&iacute;sico, licencia en un adhesivo con un holograma junto a un DVD de instalaci&oacute;n. Las licencias OEM BOX permiten una sola instalaci&oacute;n y no permiten que el hardware que tenemos instalado en el ordenador cambie.
				<br/>
				<b>Open</b>: Tambi&eacute;n es conocida como Open License y nos permite adquirir el software usando un &uacute;nico pago y debemos comprar un l&iacute;mite m&iacute;nimo de cinco licencias y el contrato rige por un per&iacute;odo de algunos a&ntilde;os.
				<br/>
				<b>SNGL</b>: Licencias SNGL OLP NL.
				<br/>
				<b>Suscripci&oacute;n</b>: Modelo por opciones bajo una Suscripci&oacute;n por un periodo de tiempo dado.
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
										SISTEMAS OPERATIVOS - Informaci&oacute;n completa de Equipos. <strong>Click aqu&iacute;</strong> para desplegar/ocultar:
									</a>
								</td>
							</tr>
						</table>
					</h4>
				  </div>


				  <div id="collapse1" class="panel-collapse collapse in">
					<div class="panel-body">
						<div id="no-more-tables">

							<div class="row">
								<div class="col-sm-12" align="center">

									<div style="text-align:center;">
										<u style="background-color:yellow;">Ordenado por Licencias de Sistemas Operativos instalados en su Empresa:</u> (click sobre una fila para conocer m&aacute;s detalles)
									</div>
									<br/>
<?php 						
									if ( $licencias_sistemas_operativos == NULL || $licencias_sistemas_operativos == "" ){
										echo "<br/>";
										echo "<b>No</b> se ha registrado información de sus Equipos hasta ahora.";
										echo "<br/>";
									} else {
?>
										<table id="licencias-ofimaticas" class="col-md-12 table-hover table-striped cf">
											<thead class="cf">
												<tr>
													<th class="active" style="text-align:center;">Equipo ID (Codigo Barras)</th>
													<th class="active" style="text-align:center;">Equipo Info</th>
													<th class="active" style="text-align:center;">Herramienta</th>
													<th class="active" style="text-align:center;">Nombre Sistema Operativo</th>
													<th class="active" style="text-align:center;">Versi&oacute;n</th>
													<th class="active" style="text-align:center;">Licencia</th>
													<th class="active" style="text-align:center;">Serial</th>
													<th class="active" style="text-align:center;">Actualizado el</th>
												</tr>
											</thead>
											<tbody>
<?php 									
												$so_Contrato = 0;
												$so_FPP = 0;
												$so_OEM = 0;
												$so_OEM_COA = 0;
												$so_OEM_BOX = 0;
												$so_Open = 0;
												$so_Suscripcion = 0;//ó
												$so_SNGL = 0;
												foreach ( $licencias_sistemas_operativos as $sos ){
?>

													<tr style="cursor:pointer;" onclick="javascript:verMasDetalles('<?= $sos["codigoBarras"]; ?>','<?= $sos["estatus"]; ?>','<?= $sos["nombreEquipo"]; ?>','<?= $sos["linkImagen"]; ?>','<?= $sos["gama"]; ?>')">
														<td data-title="Equipo ID"><?= $sos["codigoBarras"]; ?></td>
														<td data-title="Equipo Info"><?=  $sos["nombreEquipo"] . " <br/> " . $sos["infoBasica"]; ?></td>
														<td data-title="Gama"><?= $sos["gama"]; ?></td>
														<td data-title="Nombre">
<?php 
															if ( $sos["nombre"] == NULL || $sos["nombre"] == "" || $sos["nombre"] == "none" ){ 
																echo "No registra";
															} else {
																echo $sos["SO"] . " " . $sos["version"] . " " . $sos["nombre"];
															}
?>
														</td>
														<td data-title="Versión"><?= $sos["version"]; ?></td>
														<td data-title="Licencia">
<?php 
															$lic = $sos["licencia"];
															if ( $lic == NULL || $lic == "" || $lic == "none" ){ 
																echo "No posee/no registra";
															} else {
																echo $lic;

																if ( $lic == "Contrato")		$so_Contrato++;
																else if ( $lic == "FPP")		$so_FPP++;
																else if ( $lic == "OEM")		$so_OEM++;
																else if ( $lic == "OEM COA")	$so_OEM_COA++;
																else if ( $lic == "OEM BOX")	$so_OEM_BOX++;
																else if ( $lic == "Open")		$so_Open++;
																else if ( $lic == "SNGL")		$so_SNGL++;
																else if ( $lic == "Suscripcion" || $lic == "Suscripción" ) $so_Suscripcion++;
															}
?>
														</td>
														<td data-title="Serial"><?= $sos["serial"]; ?></td>
														<td data-title="Actualizado"><?= $sos["fecha"]; ?></td>
													</tr>

<?php											} ?>

										</tbody>
									</table>
<?php								}  ?>

								</div>
							</div>
						</div>
					</div>
				</div>
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
									<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse2');return false;">
										HERRAMIENTAS OFIM&Aacute;TICAS - Informaci&oacute;n completa por Equipos. <strong>Click aqu&iacute;</strong> para desplegar/ocultar:
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
										<u style="background-color:yellow;">Ordenado por Licencias de Herramientas Ofim&aacute;ticas:</u> (click sobre una fila para conocer m&aacute;s detalles)
									</div>
									<br/>
<?php 						
									if ( $licencias_sistemas_ofimatica == NULL || $licencias_sistemas_ofimatica == "" ){
										echo "<br/>";
										echo "<b>No</b> se ha registrado información de sus Equipos hasta ahora.";
										echo "<br/>";
									} else {
?>
										<table id="licencias-ofimaticas" class="col-md-12 table-hover table-striped cf">
											<thead class="cf">
												<tr>
													<th class="active" style="text-align:center;">Equipo ID</th>
													<th class="active" style="text-align:center;">Equipo Info</th>
													<th class="active" style="text-align:center;">Gama</th>
													<th class="active" style="text-align:center;">Herramienta</th>
													<th class="active" style="text-align:center;">Nombre</th>
													<th class="active" style="text-align:center;">Versi&oacute;n</th>
													<th class="active" style="text-align:center;">Licencia</th>
													<th class="active" style="text-align:center;">Serial</th>
													<th class="active" style="text-align:center;">Actualizado el</th>
												</tr>
											</thead>
											<tbody>
<?php 									
												$Contrato = 0;
												$FPP = 0;
												$OEM = 0;
												$OEM_COA = 0;
												$OEM_BOX = 0;
												$Open = 0;
												$Suscripcion = 0;//ó
												$SNGL = 0;
												foreach ($licencias_sistemas_ofimatica as $excel) {
?>

													<tr style="cursor:pointer;" onclick="javascript:verMasDetalles('<?= $excel["codigoBarras"]; ?>','<?= $excel["estatus"]; ?>','<?= $excel["nombreEquipo"]; ?>','<?= $excel["linkImagen"]; ?>','<?= $excel["gama"]; ?>')">
														<td data-title="Equipo ID"><?= $excel["codigoBarras"]; ?></td>
														<td data-title="Equipo Info"><?=  $excel["nombreEquipo"] . " <br/> " . $excel["infoBasica"]; ?></td>
														<td data-title="Gama"><?= $excel["gama"]; ?></td>
														<td data-title="Herramienta"><?= $excel["Ofimatica"]; ?></td>
														<td data-title="Nombre">
<?php 
															if ( $excel["nombre"] == NULL || $excel["nombre"] == "" || $excel["nombre"] == "none" ){ 
																echo "No registra";
															} else {
																echo $excel["nombre"];
															}
?>
														</td>
														<td data-title="Versión"><?= $excel["version"]; ?></td>
														<td data-title="Licencia">
<?php 
															$lic = $excel["licencia"];
															if ( $lic == NULL || $lic == "" || $lic == "none" ){ 
																echo "No posee/no registra";
															} else {
																echo $lic;

																if ( $lic == "Contrato")		$Contrato++;
																else if ( $lic == "FPP")		$FPP++;
																else if ( $lic == "OEM")		$OEM++;
																else if ( $lic == "OEM COA")	$OEM_COA++;
																else if ( $lic == "OEM BOX")	$OEM_BOX++;
																else if ( $lic == "Open")		$Open++;
																else if ( $lic == "SNGL")		$SNGL++;
																else if ( $lic == "Suscripcion" || $lic == "Suscripción" ) $Suscripcion++;
															}
?>
														</td>
														<td data-title="Serial"><?= $excel["serial"]; ?></td>
														<td data-title="Actualizado"><?= $excel["fecha"]; ?></td>
													</tr>

<?php											} ?>

										</tbody>
									</table>
<?php								}  ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			  </div>
			</div>
		</div>




  </div>
</div>

<!-- ==================================  ======================================= -->
<div class="modal fade" id="myModal" role="dialog">
	<!-- tamaño del modal: modal-sm PEQUEÑO | modal-lg GRANDE -->
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4 class="modal-title" align="center">
			<span class="glyphicon glyphicon-blackboard" id="titleSpan">
				Informaci&oacute;n del Equipo
			</span> 
	      </h4>
	    </div>

	    <div class="modal-body">
	      	<div id="feedback" style="text-align:center;">
	      		<img id="feedback-img" class="imgX" src="<?= APPIMAGEPATH ?>escritorio.jpg" />
	      		<br/>
	      		Cod. Barras: <span id="feedback-codBarras"></span> 
	      		<br/>
	      		<span id="feedback-nombreEquipo"></span> 
	      		<br/>
	      		Estatus: <b><span id="feedback-estatus"></span></b>
	      		<br/>
	      		<span id="">
	      			<div id="feedback-semaforo" class="semaforo" style="text-align:center;" data-toggle="tooltip" data-placement="bottom" title=""></div>
	      		</span>
	      		<br/>
	      		<span id="feedback-semaforo-desc"></span> 
	      	</div>
	    </div>

	    <div class="modal-footer">
	      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	    </div>
	  </div>
	</div>
</div>

<script>
	function verMasDetalles(codigoBarras, estatus, nombreEquipo, linkImagen, gama){

		$('#myModal').modal({
			backdrop: 'static',
			keyboard: false,
			show: true
		});

		$('#feedback-img').attr('src', linkImagen );
		
		$('#feedback-codBarras').text( codigoBarras );
		$('#feedback-nombreEquipo').text( nombreEquipo );
		$('#feedback-estatus').text( estatus );

		var desc="", classSemaforo="";
		if ( gama == "Alta" ){
			classSemaforo = "semaforo_verde";
			desc = "Equipo de alto poder de cómputo";
		} else if ( gama == "Media" ){
			classSemaforo = "semaforo_amarillo";
			desc = "Equipo de gama media";
			
		} else if ( gama == "Baja" ){
			classSemaforo = "semaforo_rojo";
			desc = "Equipo obsoleto";
		}

		$('#feedback-semaforo-desc').text( desc );
		$('#feedback-semaforo').addClass( classSemaforo );

	}

	$(document).ready(function () {

		// Set a callback to run when the Google Visualization API is loaded.
		google.charts.setOnLoadCallback(drawChartOfic);

		// Sistemas Operativos
		google.charts.setOnLoadCallback(drawChartSO);
	});

	function drawChartOfic() {

		/* Create the data table. */
		var data = new google.visualization.DataTable();
		data.addColumn('string', '¿Es Licenciado?');
		data.addColumn('number', 'Cantidad de Equipos');
		data.addRows([
			['OEM',		<?= $OEM; ?> ],
			['Open',	<?= $Open; ?> ],
			['FPP', 	<?= $FPP; ?> ],
			['Contrato', 	<?= $Contrato; ?> ],
			['OEM COA', 	<?= $OEM_COA; ?> ],
			['OEM BOX', 	<?= $OEM_BOX; ?> ],
			['Suscripción', 	<?= $Suscripcion; ?> ],
			['SNGL', 	<?= $SNGL; ?> ]
		]);

		/* Set chart options */
		var options = {
			title: 'Licenciamiento de Herramientas de Office',
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
				4: { color: '#AFCA0A' },
				5: { color: '#efb230' },
				6: { color: '#5dc15c' },
				7: { color: '#8fbdac' }
			},
			width: 550,
			height: 400
		};

		var chart = new google.visualization.PieChart(document.getElementById('chart_div_pie1'));
		chart.draw(data, options);
	}

	function drawChartSO() {

		/* Create the data table. */
		var data = new google.visualization.DataTable();
		data.addColumn('string', '¿Es Licenciado?');
		data.addColumn('number', 'Cantidad de Equipos');
		data.addRows([
			['OEM',			<?= $so_OEM; ?> ],
			['Open',		<?= $so_Open; ?> ],
			['FPP', 		<?= $so_FPP; ?> ],
			['Contrato', 	<?= $so_Contrato; ?> ],
			['OEM COA', 	<?= $so_OEM_COA; ?> ],
			['OEM BOX', 	<?= $so_OEM_BOX; ?> ],
			['Suscripción', <?= $so_Suscripcion; ?> ],
			['SNGL', 		<?= $so_SNGL; ?> ]
		]);

		/* Set chart options */
		var options = {
			title: 'Licenciamiento de Sistemas Operativos Windows',
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
				4: { color: '#AFCA0A' },
				5: { color: '#efb230' },
				6: { color: '#5dc15c' },
				7: { color: '#8fbdac' }
			},
			width: 550,
			height: 400
		};

		var chart = new google.visualization.PieChart(document.getElementById('chart_div_pie2'));
		chart.draw(data, options);
	}
</script>