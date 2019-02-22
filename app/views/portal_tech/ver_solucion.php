<?php    
	if ( !isset($solucion) ){
		die("ERROR al tratar de cargar la Info de la Incidencia. Por favo, Intente màs tarde.");
	}

?>

<style>
  a:hover {
	text-decoration: none;
  }
  a:visited  {
	text-decoration: none;
  }
  a:active  {
	text-decoration: none;
  }
  a:link {
	 text-decoration: none;
  }
  
 </style>

<h4 style="text-align:center; color:#E30513; margin-top:0px; ">
	<br/>
	<span class="glyphicon glyphicon-wrench logo slideanim"></span>
	<i>Soluci&oacute;n de la Incidencia # <?= $solucion["incidenciaId"]; ?>  </i>&nbsp;&nbsp;&nbsp;
</h4>

<div id="wholePage">
	<div class="container col-sm-12">
	<form id="basicData">
		<div class="row">
			<div class="col-sm-2" align="right">
				<label for="c1" class="">Equipo Nº:</label>
			</div>
			<div class="col-sm-4" align="left">
				<input type="text" class="" id="c1" size="50" style="border: 0px solid;" disabled="disabled" value="<?= $incidenciaInfo[0]["barcode"] ; ?> (C&oacute;digo de Barras)" />
			</div>
			<div class="col-sm-2" align="right">
				<label for="c2" class="">Nombre de Usuario:</label>
			</div>
			<div class="col-sm-4" align="left">
				<input type="text" class="" id="c2" size="50" style="border: 0px solid;" disabled="disabled" value="<?= $incidenciaInfo[0]["usuario_nombre"] . " " . $incidenciaInfo[0]["usuario_apellido"] ; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2" align="right">
				<label for="c3"class="">Nombre de Empresa:</label>
			</div>
			<div class="col-sm-4" align="left">
				<input type="text" class="" id="c3" size="50" style="border: 0px solid;" disabled="disabled" value="<?= $incidenciaInfo[0]["nombre_empresa"] ; ?>" />
			</div>
			<div class="col-sm-2" align="right">
				<label for="c4" class="">Dependencia:</label>
			</div>
			<div class="col-sm-4" align="left">
				<input type="text" class="" id="c4" size="50" style="border: 0px solid;" disabled="disabled" value="<?= $incidenciaInfo[0]["dependencia"] ; ?>" />
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2" align="right">
				<label for="c5"class="">Fecha actual:</label>
			</div>
			<div class="col-sm-4" align="left">
				<input type="text" class="" id="c5" style="border: 0px solid;" disabled="disabled" value="<?= date("d/m/Y"); ?>" />
			</div>
			<div class="col-sm-2" align="right">
				<label for="c6" class="">Hora actual:</label>
			</div>
			<div class="col-sm-4" align="left">
				<input type="text" class="" id="c6" style="border: 0px solid;" disabled="disabled" value="<?= date("h:i:s A"); ?>" />
			</div>
		</div>
	</form>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<h5>
				Pulse sobre el <span style="color:blue;">T&iacute;tulo</span> de las secciones 
				para conocer la info que contiene...
			</h5>
		</div>
	</div>

	<form class="form-horizontal" data-toggle="validator" role="form" id="solucion_incidencia_form"
	 method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>portal/certificar_incidencia">

	  <input type="hidden" id="incidenciaId_Form" name="incidenciaId_Form" value='<?= $solucion["incidenciaId"]; ?>' />
	  <input type="hidden" id="solucionId_Form"   name="solucionId_Form"   value='<?= $solucion["solucionId"]; ?>' />

		<div class="panel-group col-sm-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h4 class="panel-title">
					<!--  el ID debe ser único #collapse1 -->
					<table style="width:100%;">
						<tr>
							<td style="text-align:left;">
								<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse1');return false;">
									LABOR QUE DESEMPE&Ntilde;A EL EQUIPO
								</a>
							</td>
							<td style="text-align:right;">
								<a href="#" onclick="javascript:collapseAll();return false;">
									Contraer todo
								</a> 
								| 
								<a href="#" onclick="javascript:expandAll();return false;">
									Expandir todo
								</a>
							</td>
						</tr>
					</table>
				</h4>
			  </div>
			  <!--  el ID debe ser único "collapse1" -->
			  <div id="collapse1" class="panel-collapse collapse in">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
						  <div id="laborDelEquipo-div" class="form-group">
							<label class="control-label col-sm-2" for="laborDelEquipo"
							data-toggle="tooltip" data-placement="bottom" title="Qu&eacute; uso tiene este Equipo dentro de la Empresa">
							 Para qu&eacute; se est&aacute; usando este Equipo</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
									<textarea class="form-control" id="laborDelEquipo" name="laborDelEquipo" rows="5" disabled="disabled"
									 ><?= $solucion["laborDelEquipo"]; ?></textarea>

									<span id="laborDelEquipo-span" class=""></span>
								</div>
							</div>
							<div class="col-sm-2">
								<div id="laborDelEquipo-error" class="help-block">
									&nbsp;
								</div>
							</div>
						  </div>
						</div>
					</div>
				</div>
			  </div>
			</div>
		</div>

		<div class="panel-group col-sm-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h4 class="panel-title">
				  <table style="width:100%;">
						<tr>
							<td style="text-align:left;">
								<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse2');return false;">
									OBSERVACIONES Y NOVEDADES
								</a>
							</td>
							<td style="text-align:right;">
								<a href="#" onclick="javascript:collapseAll();return false;">
									Contraer todo
								</a> 
								| 
								<a href="#" onclick="javascript:expandAll();return false;">
									Expandir todo
								</a>
							</td>
						</tr>
					</table>
				</h4>
			  </div>
			  
			  <div id="collapse2" class="panel-collapse collapse in">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
						  <div id="variableEndogena-div" class="form-group">
							<label class="control-label col-sm-2" for="variableEndogena"
							data-toggle="tooltip" data-placement="bottom" title="Problemas DENTRO del Equipo, a nivel INTERNO. Ej: un componente que se echó a perder, etc.">
							 Variables End&oacute;genas</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-fire"></i></span>
									<textarea class="form-control" id="variableEndogena" name="variableEndogena" rows="5" disabled="disabled"
									 ><?= $solucion["variableEndogena"]; ?></textarea>

									<span id="variableEndogena-span" class=""></span>
								</div>
							</div>
							<div class="col-sm-2">
								<div id="variableEndogena-error" class="help-block">
									&nbsp;
								</div>
							</div>
						  </div>
						</div>

						<div class="col-sm-12">
						  <div id="variableExogenaTecnica-div" class="form-group">
							<label class="control-label col-sm-2" for="variableExogenaTecnica"
							data-toggle="tooltip" data-placement="bottom" title="Problemas EXTERNOS de índole Técnico. Ej: un bajón de corriente, apagón, etc.">
							 Variables Ex&oacute;genas T&eacute;cnicas</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-fire"></i></span>
									<textarea class="form-control" id="variableExogenaTecnica" name="variableExogenaTecnica" rows="5" disabled="disabled"
									 ><?= $solucion["variableExogenaTecnica"]; ?></textarea>
									<span id="variableExogenaTecnica-span" class=""></span>
								</div>
							</div>
							<div class="col-sm-2">
								<div id="variableExogenaTecnica-error" class="help-block">
									&nbsp;
								</div>
							</div>
						  </div>
						</div>

						<div class="col-sm-12">
						  <div id="variableExogenaHumana-div" class="form-group">
							<label class="control-label col-sm-2" for="variableExogenaHumana"
							data-toggle="tooltip" data-placement="bottom" title="Problemas EXTERNOS de índole HUMANA. Ej: se derramó agua sobre el PC, etc.">
							 Variables Ex&oacute;genas Humanas</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-fire"></i></span>
									<textarea class="form-control" id="variableExogenaHumana" name="variableExogenaHumana" rows="5" disabled="disabled"
									 ><?= $solucion["variableExogenaHumana"]; ?></textarea>

									<span id="variableExogenaHumana-span" class=""></span>
								</div>
							</div>
							<div class="col-sm-2">
								<div id="variableExogenaHumana-error" class="help-block">
									&nbsp;
								</div>
							</div>
						  </div>
						</div>
					</div>
				</div>
			  </div>
			</div>
		</div>


		<div class="panel-group col-sm-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h4 class="panel-title">
				  <table style="width:100%;">
						<tr>
							<td style="text-align:left;">
								<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse3');return false;">
									REPORTE MANTENIMIENTO DE HARDWARE (Procedimientos Ejecutados)
								</a>
							</td>
							<td style="text-align:right;">
								<a href="#" onclick="javascript:collapseAll();return false;">
									Contraer todo
								</a> 
								| 
								<a href="#" onclick="javascript:expandAll();return false;">
									Expandir todo
								</a>
							</td>
						</tr>
					</table>
				</h4>
			  </div>
			  
			  <div id="collapse3" class="panel-collapse collapse in">
				<div class="panel-body">

					<div class="row">
						<div class="col-sm-12">
						  <div id="mantenimientoHardware-div" class="form-group">
							<label class="control-label col-sm-2" for="mantenimientoHardware">Procedimientos que se Ejecutaron para la realizaci&oacute;n del Mantenimiento de Hardware</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
									<textarea class="form-control" id="mantenimientoHardware" name="mantenimientoHardware" rows="5" disabled="disabled"
									 ><?= $solucion["mantenimientoHardware"]; ?></textarea>

									<span id="mantenimientoHardware-span" class=""></span>
								</div>
							</div>
							<div class="col-sm-2">
								<div id="mantenimientoHardware-error" class="help-block">
									&nbsp;
								</div>
							</div>
						  </div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12" align="center">
							<b>REPORTE DE RELEVO O CAMBIO DE HARDWARE DEL EQUIPO</b> (en Caso de Mantenimiento Correctivo)
							<br/><br/>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<?php if ( isset($no_hardware) ){ ?>
						
								<div style="text-align:center;">
									No se realizaron reemplazos de Componentes de Hardware.
								</div>

							<?php } else { ?>
						
								<table id="tableHardware" name="tableHardware" class="table table-hover table-striped" style="font-size: 12px;width:100%;">
									<thead>
										<tr>
											<th>Componente a remplazar</th>
											<th>Descripci&oacute;n</th>
											<th>Nº Serie Componente Reemplazado</th>
											<th>Nº Serie Componente Nuevo</th>
											<th>&iquest;Equipo Reemplazado&quest; (S/N)</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($hardware as $cambio) { ?>
											<tr>
												<td><?= $cambio["hardwareARemplazar"]; ?></td>
												<td><?= $cambio["descripcion"]; ?></td>
												<td><?= $cambio["hardwareViejo"]; ?></td>
												<td><?= $cambio["hardwareNuevo"]; ?></td>
												<td align="center"><?= ucfirst( $cambio["fueRemplazado"] ); ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
							<?php } ?>
						</div>
			  		</div>
				</div>
			</div>
		  </div>
		</div>

		<div class="panel-group col-sm-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h4 class="panel-title">
				  <table style="width:100%;">
						<tr>
							<td style="text-align:left;">
								<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse4');return false;">
									REPORTE MANTENIMIENTO DE SOFTWARE (Procedimientos Ejecutados)
								</a>
							</td>
							<td style="text-align:right;">
								<a href="#" onclick="javascript:collapseAll();return false;">
									Contraer todo
								</a> 
								| 
								<a href="#" onclick="javascript:expandAll();return false;">
									Expandir todo
								</a>
							</td>
						</tr>
					</table>
				</h4>
			  </div>
			  
			  <div id="collapse4" class="panel-collapse collapse in">
				<div class="panel-body">

					<div class="row">
						<div class="col-sm-12">
						  <div id="mantenimientoSoftware-div" class="form-group">
							<label class="control-label col-sm-2" for="mantenimientoSoftware">Procedimientos que se Ejecutaron para la realizaci&oacute;n del Mantenimiento de Software</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-tasks"></i></span>
									<textarea class="form-control" id="mantenimientoSoftware" name="mantenimientoSoftware" rows="5" disabled="disabled"
									 ><?= $solucion["mantenimientoSoftware"]; ?></textarea>

									<span id="mantenimientoSoftware-span" class=""></span>
								</div>
							</div>
							<div class="col-sm-2">
								<div id="mantenimientoSoftware-error" class="help-block">
									&nbsp;
								</div>
							</div>
						  </div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12" align="center">
							<b>REPORTE DE CAMBIO DE SOFTWARE DEL EQUIPO</b> (en Caso de Mantenimiento Correctivo)
							<br/><br/>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-12">
							<?php if ( isset($no_software) ){ ?>
								<div style="text-align:center;">
									No se realizaron Cambios o Instalaciones de Componentes de Software.
								</div>

							<?php } else { ?>

								<table id="tableSoftware" name="tableSoftware" class="table table-hover table-striped" style="font-size: 12px;width:100%;">
									<thead>
										<tr>
											<th>Software</th>
											<th width="160px">Versi&oacute;n</th>
											<th align="center" width="160px">Tipo de Software<br/>(Libre o Propietario)</th>
											<th>Serial</th>
											<th align="center" width="160px">Trabajo realizado<br/>(Cambio o Instalaci&oacute;n)</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($software as $trabajo) { ?>
											<tr>
												<td><?= $trabajo["softwareARemplazar"]; ?></td>
												<td><?= $trabajo["version"]; ?></td>
												<td><?= ucfirst( $trabajo["tipo"] ); ?></td>
												<td><?= $trabajo["serial"]; ?></td>
												<td align="center"><?= ucfirst( $trabajo["trabajo"] ); ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>

							<?php } ?>
						</div>
					</div>
				</div>
			  </div>
			</div>
		</div>

		<div class="panel-group col-sm-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h4 class="panel-title">
				  <table style="width:100%;">
						<tr>
							<td style="text-align:left;">
								<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse5');return false;">
									REPORTE DE ACOMPA&Ntilde;AMIENTO JUNIOR
								</a>
							</td>
							<td style="text-align:right;">
								<a href="#" onclick="javascript:collapseAll();return false;">
									Contraer todo
								</a> 
								| 
								<a href="#" onclick="javascript:expandAll();return false;">
									Expandir todo
								</a>
							</td>
						</tr>
					</table>
				</h4>
			  </div>
			  
			  <div id="collapse5" class="panel-collapse collapse in">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
						  <div id="acompanamientoJunior-div" class="form-group">
							<label class="control-label col-sm-2" for="acompanamientoJunior">Acompa&ntilde;amiento Junior</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>
									<textarea class="form-control" id="acompanamientoJunior" name="acompanamientoJunior" rows="5" disabled="disabled"
									 ><?= $solucion["acompanamientoJunior"]; ?></textarea>

									<span id="acompanamientoJunior-span" class=""></span>
								</div>
							</div>
							<div class="col-sm-2">
								<div id="acompanamientoJunior-error" class="help-block">
									&nbsp;
								</div>
							</div>
						  </div>
						</div>
					</div>
				</div>
			  </div>
			</div>
		</div>

		<div class="form-group">

			<div class="col-sm-6" align="right">
			  <a href="<?= PROJECTURLMENU; ?>tecnicos/historico_incidencias" class="btn btn-warning btn-lg" role="button"
			   data-toggle="tooltip" data-placement="top" title="Volver a la Vista 'Ver Incidencias'">
			    <span class="glyphicon glyphicon-menu-left"></span> 
			     Volver</a>
			</div>

			<div class="col-sm-6" align="left">
				<button type="button" class="btn btn-info btn-lg" onclick="javascript:expandAll();imprimirReporte();" 
				   data-toggle="tooltip" data-placement="bottom" title="Imprimir esta página en PDF">
					<span class="glyphicon glyphicon-print"></span> 
					 Imprimir en PDF
				</button>
			</div>

		</div>

	</form>

	<!-- ========================= Formulario para Impresion de este Reporte ===================== -->
	<form class="form-horizontal" data-toggle="validator" role="form" id="print_incidencia_form"
	 method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>tecnicos/imprimir_solucion_incidencia">

	  <input type="hidden" id="incidenciaId_print" name="incidenciaId_print" value='<?= $solucion["incidenciaId"] ?>' />
	  <input type="hidden" id="solucionId_print"   name="solucionId_print"   value='<?= $solucion["solucionId"] ?>' />

	</form>
</div>

<script>

	$(document).ready(function () {

		$('[data-toggle="tooltip"]').tooltip();

		$('.collapse').collapse();

	});

	function certificar(){
		document.getElementById("solucion_incidencia_form").submit();
	}

	function imprimirReporte(){

		document.getElementById("wholePage").style.cursor = "progress";
		
		document.getElementById("print_incidencia_form").submit();
	}

</script>