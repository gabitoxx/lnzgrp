<?php 
	echo "&nbsp; En esta secci&oacute;n usted, como Ing. de Soporte registrado que trabaja para Lanuza Group, podr&aacute;"
		. " <b>resolver una Incidencia</b> reportada por un Usuario (Clientes de Lanuza Group)."
		. " Dicha Incidencia se podr&aacute; resolver <b>v&iacute;a in-situ (presencial) o v&iacute;a remota (Team Viewer)</b>."
		. " Una vez que usted le haya ofrecido el <b>Servicio de Soporte TI</b>, debe <i>llenar este formulario"
		. " y notificar al Cliente</i> para que otorge su aprobaci&oacute;n y dar por concluida la Incidencia."
		. " <br/><br/>"
		. " Este Formulario tambi&eacute;n servir&aacute; para llenar los <b>Reportes de Visita</b> a la Empresa, el trabajo que realiz&oacute; en los Equipos. "
		;

	if ( !isset($incidenciaInfo) ){
		die("ERROR al tratar de cargar la Info de la Incidencia. Por favo, Intente màs tarde.");
	}

	//POR DEFECTO
	$incidenciaUserId = "-1";
	
	//JSON vacío
	$incidenciasSinOpinar = "[]";

	if ( isset($objSinOpinar) && $objSinOpinar != NULL ){
		$incidenciaUserId = $objSinOpinar->userId;
		//JSON
		$incidenciasSinOpinar = $objSinOpinar->incidenciasSinOpinar;
	}

	if ( isset($usuarioCreadorIncidencia) && $usuarioCreadorIncidencia != NULL && $usuarioCreadorIncidencia != "" ){
		/* 
		 * En caso de que una Incidencia esté asignada a un Equipo SIN Usuario
		 * SE BUSCÓ el UsuarioId creador de Esta Incidencia
		 */
		$incidenciaUserId = $usuarioCreadorIncidencia;
	}

	$esReporteVisita = "false";
	if ( isset($es_REPORTE_VISITA) && $es_REPORTE_VISITA != NULL && $es_REPORTE_VISITA != "" ){
		$esReporteVisita = "true";
	}

?>

<script>
	var pasosHardware = "1. Verificación del código del equipo y seriales.\n"
			+ "2. Verificación de la garantía del equipo de cómputo.\n"
			+ "3. Verificación del estado del equipo.\n"
			+ "4. Desmontaje de partes, limpieza interna con aire comprimido y limpia contactos, aspirado profundo, verificación de tarjetas, limpieza externa con cera para equipos.\n"
			+ "\n\n"
			+ "*Se entregan las siguientes recomendaciones al usuario:\n"
			+ "\n"
			+ "1. Cuidar las condiciones físicas de limpieza donde se encuentre el equipo.\n"
			+ "2. Hacer buen uso de los equipos de cómputo, con una manipulación adecuada y trato gentil.\n"
			+ "3. No ingerir alimentos y bebidas en el área donde utilice el equipo de cómputo.\n"
			+ "4. No apagar la computadora sin antes salir adecuadamente del sistema.\n";

	var pasosSoftware = " 1. Revisión del Log de errores del sistema.\n"
			+ " 2. Revisión del estado del disco duro.\n"
			+ " 3. Desinstalación de todos los programas piratas, spam, toolbar o software que no estén autorizados por la Gerencia.\n"
			+ " 4. Limpieza del registro.\n"
			+ " 5. Limpieza de archivos temporales y Cookies.\n"
			+ " 6. Optimización de rendimiento del equipo.\n"
			+ " 7. Inhabilitación de los servicios de inicio no necesarios.\n"
			+ " 8. Inhabilitación de las aplicaciones de inicio no necesarios.\n"
			+ " 9. Limpieza de los navegadores y desinstalación de las extensiones.\n"
			+ "10. Veririficación de las actualizaciones correspondientes al sistema.\n"
			+ "11. Limpieza y actualización de drivers.\n"
			+ "12. Desfragmentacion del disco duro.\n"
			+ "13. Análisis de virus, usando el antivirus local y otros online.\n"
			+ "14. Análisis de spyware con antispyware local y otros online.\n"
			+ "\n\n"
			+ "*Se entregan las siguientes recomendaciones al Usuario:\n"
			+ "\n"
			+ "1. Cuidar las condiciones físicas de limpieza donde se encuentre el equipo.\n"
			+ "2. Hacer buen uso de los equipos de cómputo, con una manipulación adecuada y trato gentil.\n"
			+ "3. No ingerir alimentos y bebidas en el área donde utilice el equipo de cómputo.\n"
			+ "4. No apagar la computadora sin antes salir adecuadamente del sistema.\n";

	//JSON
	var jsIncidenciaId = <?= $incidenciaInfo[0]["incidenciaId"]; ?>;
	var incidenciaUserId = <?= $incidenciaUserId; ?>;
	var jsonFormatIncidenciasSinOpinar = '<?= $incidenciasSinOpinar; ?>';

	var jsonIncidenciasSinOpinar = JSON.parse( jsonFormatIncidenciasSinOpinar );

	//"true" o "false"
	var jsEsReporteVisita = '<?= $esReporteVisita; ?>';

</script>

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

	.panel-heading {
		background-color: #A0ADB5 !important;
	}

</style>

<h4 style="text-align:center; color:#E30513;">
	<br/>
	<span class="glyphicon glyphicon-wrench logo slideanim"></span>
	<i>Resolver 
<?php 
		$bEsReporte = "false";

		if ( $incidenciaInfo[0]["fallaId"] == "101" ){
			echo "Reporte General ";
			$bEsReporte = "true";

		} else if ( $incidenciaInfo[0]["fallaId"] == "100" ){
			echo "Reporte de Visita ";
			$bEsReporte = "true";

		} else {
			echo "Incidencia";
			$bEsReporte = "false";
		}

		echo " # " . $incidenciaInfo[0]["incidenciaId"] . "</i>&nbsp;&nbsp;&nbsp;";

		echo "<script>";
		echo ' var esReporte = "' . $bEsReporte . '";';
		echo "</script>";
?>

</h4>


<div class="container col-sm-12">
<form id="basicData">
	<div class="row">
		<div class="col-sm-2">
			<label for="c1" class="">Equipo Nº:</label>
		</div>
		<div class="col-sm-4">
			<input type="text" class="" id="c1" style="border: 0px solid;" disabled="disabled" value="<?php if($incidenciaInfo[0]["barcode"]!=NULL && $incidenciaInfo[0]["barcode"]!="") echo $incidenciaInfo[0]["barcode"]; else echo "No Registra"; ?>" />
		</div>
		<div class="col-sm-2">
			<label for="c2" class="">Usuario:</label>
		</div>
		<div class="col-sm-4">
			<input type="text" class="" id="c2" style="border: 0px solid;" disabled="disabled" value="<?= $incidenciaInfo[0]["usuario_nombre"] . " " . $incidenciaInfo[0]["usuario_apellido"] ; ?>" />
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2">
			<label for="c3"class="">Empresa:</label>
		</div>
		<div class="col-sm-4">
			<input type="text" class="" id="c3" style="border: 0px solid;" disabled="disabled" value="<?= $incidenciaInfo[0]["nombre_empresa"] ; ?>" />
		</div>
		<div class="col-sm-2">
			<label for="c4" class="">Dependencia:</label>
		</div>
		<div class="col-sm-4">
			<input type="text" class="" id="c4" style="border: 0px solid;" disabled="disabled" value="<?= $incidenciaInfo[0]["dependencia"] ; ?>" />
		</div>
	</div>
	<div class="row">
		<div class="col-sm-2">
			<label for="c5"class="">Fecha:</label>
		</div>
		<div class="col-sm-4">
			<input type="text" class="" id="c5" style="border: 0px solid;" disabled="disabled" value="<?= date("d/m/Y"); ?>" />
		</div>
		<div class="col-sm-2">
			<label for="c6" class="">Hora:</label>
		</div>
		<div class="col-sm-4">
			<input type="text" class="" id="c6" style="border: 0px solid;" disabled="disabled" value="<?= date("h:i:s A"); ?>" />
		</div>
	</div>
</form>
</div>


<hr/>

<div class="col-sm-12">
	<br/>
	<h4 align="center">
	  <i>
		Por favor, 
		<span style="color:#E30513">
			Completar con la Informaci&oacute;n del Soporte TI brindado por usted:
		</span>
	  </i>
	</h4>
	<br/>
</div>

<form class="form-horizontal" data-toggle="validator" role="form" id="resolver_incidencia_form"
 method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>tecnicos/cerrar_incidencia"
 onsubmit="javascript:return submitForm();">

	<input type="hidden" id="incidenciaId_mainForm" name="incidenciaId_mainForm" value="" />
	<input type="hidden" id="empresaId_mainForm"    name="empresaId_mainForm" 	 value="<?= $incidenciaInfo[0]["empresaId"] ; ?>" />
	<input type="hidden" id="reporteOincidencia" 	name="reporteOincidencia" 	 value="" />
	
	<input type="hidden" id="incidenciaUserId"         name="incidenciaUserId"         value="<?= $incidenciaUserId; ?>" />
	<input type="hidden" id="jsonIncidenciasSinOpinar" name="jsonIncidenciasSinOpinar" value="[]" />
	<input type="hidden" id="es_reporte_de_visita"     name="es_reporte_de_visita"     value="" />
	

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
						 Indique para qu&eacute; se est&aacute; usando este Equipo</label>
						<div class="col-sm-7">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
								<textarea class="form-control" id="laborDelEquipo" name="laborDelEquipo" rows="5"></textarea>
								<span id="laborDelEquipo-span" class=""></span>
							</div>
						</div>
						<div class="col-sm-3">
							<div id="laborDelEquipo-error" class="help-block">
								<button id="addRespuesta" type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModalLabor">
									<span class="glyphicon glyphicon-plus"></span> 
									 Agregar Respuesta Predefinida
								</button>
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
						 Variables End&oacute;genas <u>(?)</u></label>
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-fire"></i></span>
								<textarea class="form-control" id="variableEndogena" name="variableEndogena" rows="5"></textarea>
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
						 Variables Ex&oacute;genas T&eacute;cnicas <u>(?)</u></label>
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-fire"></i></span>
								<textarea class="form-control" id="variableExogenaTecnica" name="variableExogenaTecnica" rows="5"></textarea>
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
						data-toggle="tooltip" data-placement="bottom" title="Problemas EXTERNOS de índole HUMANA. Ej: se derramó agua sobre el PC, Virus por Juegos instalados, usos NO laborales, etc.">
						 Variables Ex&oacute;genas Humanas <u>(?)</u></label>
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-fire"></i></span>
								<textarea class="form-control" id="variableExogenaHumana" name="variableExogenaHumana" rows="5"></textarea>
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
					<div class="col-sm-12" align="center">
						<div class="input-group">
							Seleccione uno de los tipos de Trabajo realizado: 
							&nbsp;&nbsp;&nbsp;
							<label class="radio-inline"
							 data-toggle="tooltip" data-placement="bottom" title="Mantenimiento ANTES de que ocurra alg&uacute;n inconveniente; para prevenir futuras fallas.">
							  <input type="radio" name="HWmantenimiento" id="HWmantenimiento" value="HWpreventivo" onclick="javascript:habilitarMantemiento('HWpreventivo');">
							   Preventivo <u>(?)</u>
							</label>
							&nbsp;&nbsp;&nbsp;
							<label class="radio-inline"
							 data-toggle="tooltip" data-placement="bottom" title="Mantemiento DESPU&Eacute;S de ocurrir alguna falla, para corregirla. Especifique qu&eacute; hizo para arreglarlo.">
							  <input type="radio" name="HWmantenimiento" id="HWmantenimiento" value="HWcorrectivo" onclick="javascript:habilitarMantemiento('HWcorrectivo');">
							   Correctivo <u>(?)</u>
							</label>
							&nbsp;&nbsp;&nbsp;
							<label class="radio-inline"
							 data-toggle="tooltip" data-placement="bottom" title="Mantemiento DESPU&Eacute;S de ocurrir alguna falla, para corregirla. Especifique qu&eacute; hizo para arreglarlo.">
							  <input type="radio" name="HWmantenimiento" id="HWmantenimiento" value="HWotro" onclick="javascript:habilitarMantemiento('HWotro');">
							   Otro
							</label>
						</div>
						<br/>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
					  <div id="mantenimientoHardware-div" class="form-group">
						<label class="control-label col-sm-2" for="mantenimientoHardware">Indique los Procedimientos que se Ejecutaron para la realizaci&oacute;n del Mantenimiento de Hardware</label>
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-cog"></i></span>
								<textarea class="form-control" id="mantenimientoHardware" name="mantenimientoHardware" rows="5"></textarea>
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
						<table id="tableHardware" name="tableHardware" class="table table-hover table-striped" style="font-size: 12px;width:100%;">
							<thead>
								<tr>
									<th>Componente a remplazar</th>
									<th>Descripci&oacute;n</th>
									<th>Nº Serie Comp. a Remplazar</th>
									<th>Nº Serie Comp. Nuevo</th>
									<th>Equipo Remplazado (S/N)</th>
									<th>Eliminar ingreso</th>
								</tr>
							</thead>
							<tbody>
								<!--
								<tr>
									<td>q</td>
									<td>z</td>
									<td>123</td>
									<td>456</td>
									<td>S</td>
								</tr>
								-->
							</tbody>
						</table>
					</div>
				</div>
				<!-- SALVAR los valores SERIALIZADOS por coma ',' de la tabla para el form.SUBMIT -->
				<input type="hidden" id="cantidadComponenetesHardware" name="cantidadComponenetesHardware" value="" />
				<input type="hidden" id="hardwareARemplazar" name="hardwareARemplazar" value="" />
				<input type="hidden" id="hardwareDescripciones" name="hardwareDescripciones" value="" />
				<input type="hidden" id="hardwareViejo" name="hardwareViejo" value="" />
				<input type="hidden" id="hardwareNuevo" name="hardwareNuevo" value="" />
				<input type="hidden" id="hardwareFueRemplazadoSN" name="hardwareFueRemplazadoSN" value="" />

				<div class="row">
					<br/>
					<div class="col-sm-12"  style="text-align:center;">
						<button id="addHW" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">
							<span class="glyphicon glyphicon-plus"></span> 
							 Agregar otro Componente a la lista
						</button>
					</div>
					<br/>
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
								REPORTE MANTENIMIENTO DE SOFTWARE (Procedimientos que se Ejecutaron)
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
					<div class="col-sm-12" align="center">
						<div class="input-group">
							Seleccione uno de los tipos de Trabajo realizado: 
							&nbsp;&nbsp;&nbsp;
							<label class="radio-inline"
							 data-toggle="tooltip" data-placement="bottom" title="Mantenimiento ANTES de que ocurra alg&uacute;n inconveniente; para prevenir futuras fallas.">
							  <input type="radio" name="SWmantenimiento" id="SWmantenimiento" value="SWpreventivo" onclick="javascript:habilitarMantemiento('SWpreventivo');">
							   Preventivo <u>(?)</u>
							</label>
							&nbsp;&nbsp;&nbsp;
							<label class="radio-inline"
							 data-toggle="tooltip" data-placement="bottom" title="Mantemiento DESPU&Eacute;S de ocurrir alguna falla, para corregirla. Especifique qu&eacute; hizo para corregirlo.">
							  <input type="radio" name="SWmantenimiento" id="SWmantenimiento" value="SWcorrectivo" onclick="javascript:habilitarMantemiento('SWcorrectivo');">
							   Correctivo <u>(?)</u>
							</label>
							&nbsp;&nbsp;&nbsp;
							<label class="radio-inline"
							 data-toggle="tooltip" data-placement="bottom" title="Mantemiento DESPU&Eacute;S de ocurrir alguna falla, para corregirla. Especifique qu&eacute; hizo para arreglarlo.">
							  <input type="radio" name="SWmantenimiento" id="SWmantenimiento" value="SWotro" onclick="javascript:habilitarMantemiento('SWotro');">
							   Otro
							</label>
						</div>
						<br/>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
					  <div id="mantenimientoSoftware-div" class="form-group">
						<label class="control-label col-sm-2" for="mantenimientoSoftware">Indique los Procedimientos que se Ejecutaron para la realizaci&oacute;n del Mantenimiento de Software</label>
						<div class="col-sm-8">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-tasks"></i></span>
								<textarea class="form-control" id="mantenimientoSoftware" name="mantenimientoSoftware" rows="5"></textarea>
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
						<table id="tableSoftware" name="tableSoftware" class="table table-hover table-striped" style="font-size: 12px;width:100%;">
							<thead>
								<tr>
									<th>Software</th>
									<th>Versi&oacute;n</th>
									<th>Libre / Propietario</th>
									<th>Serial</th>
									<th>Cambio / Instalaci&oacute;n</th>
									<th>Eliminar ingreso</th>
								</tr>
							</thead>
							<tbody>
								<!-- vacio -->
							</tbody>
						</table>
					</div>
				</div>
				<!-- SALVAR los valores SERIALIZADOS por coma ',' de la tabla para el form.SUBMIT -->
				<input type="hidden" id="cantidadComponenetesSoftware" name="cantidadComponenetesSoftware" value="" />
				<input type="hidden" id="SoftwaresARemplazar" name="SoftwaresARemplazar" value="" />
				<input type="hidden" id="SoftwareVersiones" name="SoftwareVersiones" value="" />
				<input type="hidden" id="SoftwareTipos" name="SoftwareTipos" value="" />
				<input type="hidden" id="SoftwareSeriales" name="SoftwareSeriales" value="" />
				<input type="hidden" id="SoftwaresCambiados" name="SoftwaresCambiados" value="" />

				<div class="row">
					<br/>
					<div class="col-sm-12"  style="text-align:center;">
						<button id="addSW" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalSoftware">
							<span class="glyphicon glyphicon-plus"></span> 
							 Agregar otro Software a la lista
						</button>
					</div>
					<br/>
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
								<textarea class="form-control" id="acompanamientoJunior" name="acompanamientoJunior" rows="5"></textarea>
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

	<div class="panel-group col-sm-12">
		<div class="panel panel-default">
		  <div class="panel-heading">
			<h4 class="panel-title">
			  <table style="width:100%;">
					<tr>
						<td style="text-align:left;">
							<a data-toggle="collapse" href="#" onclick="javascript:collapseDiv('collapse6');return false;">
								SI VA A MARCAR LA INCIDENCIA CON EL ESTATUS 'EN ESPERA'...
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
		  
		  <div id="collapse6" class="panel-collapse collapse in">
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12">
					  <div id="observaciones-div" class="form-group">
						<label class="control-label col-sm-4" for="observaciones">Indique Qu&eacute; informaci&oacute;n necesita del Usuario para poder avanzar: &iquest;Qu&eacute; lo detiene para poder resolver la incidencia&quest;</label>
						<div class="col-sm-6">
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
								<textarea class="form-control" id="observaciones" name="observaciones" rows="7"></textarea>
								<span id="observaciones-span" class=""></span>
							</div>
						</div>
						<div class="col-sm-2">
							<div id="observaciones-error" class="help-block">
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

	<div class="form-group" align="center"> 
		<div class="col-sm-3">
		  <button type="button" class="btn btn-success"
		   <?= 'onclick="javascript:markAsWait(' . $incidenciaInfo[0]["incidenciaId"] . ');return false;" ' ?> 
		   data-toggle="tooltip" data-placement="bottom" title="Marcar estatus 'En Espera' (esperando m&aacute;s info por parte del Usuario)">
			<span class="glyphicon glyphicon-time"></span> 
			 Marcar 'En Espera'
		  </button>
		</div>

		<div class="col-sm-3" align="center">
		  <button type="submit" class="btn btn-primary"
		   data-toggle="tooltip" data-placement="bottom" title="Dar por Finalizada / Resuelta esta Incidencia">
			<span class="glyphicon glyphicon-ok"></span> 
			 Finalizar / Marcar 'Cerrada'
		  </button>
		</div>

		<div class="col-sm-3" align="center">
		  <button type="button" class="btn btn-danger" 
		   <?= 'onclick="javascript:abandonarIncidencia(' . $incidenciaInfo[0]["incidenciaId"] . ');return false;" ' ?> 
		   data-toggle="tooltip" data-placement="bottom" title="Deja la Incidencia libre para que otro T&eacute;cnico la resuelva">
			<span class="glyphicon glyphicon-remove-circle"></span> 
			 Abandonar Incidencia
		  </button>
		</div>

		<div class="col-sm-3" align="center">
		  <button type="reset" class="btn btn-warning" onclick="javascript:limpiarEstilos('form')" 
		   data-toggle="tooltip" data-placement="bottom" title="Limpiar Formulario y comenzar otra vez">
			<span class="glyphicon glyphicon-repeat"></span> 
			 Empezar desde cero 
		  </button>
		</div>

	</div>

</form>

<br/>

<fieldset class="scheduler-border">
	<legend class="scheduler-border">Acciones</legend>
	
	<div class="row control-group">
		<div class="col-sm-offset-1 col-sm-11">
			<table class="table table-hover table-striped">
				<tr>
					<td width="210px">
						<button type="button" class="btn btn-success">
							<span class="glyphicon glyphicon-time"></span> 
							Marcar 'En Espera'
						</button>
					</td>
					<td>Con esta opci&oacute;n usted indica que <b>necesita m&aacute;s informaci&oacute;n por parte del Usuario afectado
						 antes de poder continuar con su Soporte TI</b>.
						 Esta opci&oacute;n le enviar&aacute; un correo al Usuario para indicarle que
						 usted necesita m&aacute;s detalles (aunque puede contactarlo directamente).
						 <br/>
						 <b>En el sistema quedar&aacute; registrado que la demora NO es por causa suya.</b>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-1 col-sm-11">
			<table class="table table-hover table-striped">
				<tr>
					<td width="210px">
						<button type="button" class="btn btn-primary">
							<span class="glyphicon glyphicon-ok"></span> 
							Marcar 'Cerrada'
						</button>
					</td>
					<td>Usted ya realiz&oacute; el Soporte TI correspondiente y 
						ya le notific&oacute; al Usuario afectado. El Usuario qued&oacute; 
						conforme con su ayuda.
						<br/>
						<b>En el sistema quedar&aacute; registrado que usted resolvi&oacute; este inconveniente</b>.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-1 col-sm-11">
			<table class="table table-hover table-striped">
				<tr>
					<td width="210px">
						<button type="button" class="btn btn-danger">
							<span class="glyphicon glyphicon-remove-circle"></span> a
							Abandonar Incidencia
						</button>
					</td>
					<td>Usted dejar&aacute; de tener asignada esta Incidencia, y 
						<b>quedar&aacute; abierta para que otro Ing. de Soporte la atienda</b>.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-1 col-sm-11">
			<table class="table table-hover table-striped">
				<tr>
					<td width="210px">
						<button type="button" class="btn btn-warning">
							<span class="glyphicon glyphicon-repeat"></span> 
							Empezar desde cero
						</button>
					</td>
					<td>Limpiar todos los campos del formulario para comenzar desde cero.
					</td>
				</tr>
			</table>
		</div>
	</div>
	
</fieldset>	

<!-- ========================= Modal HARDWARE =============================================== -->
<div id="myModal" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Agregar nuevo Componente</h4>
	  </div>
	  <div class="modal-body">
		
		<form id="formHardware">

			<div id="hardwareRemplazar-div" class="form-group">
				<label class="control-label col-sm-3" for="hardwareRemplazar">Componente a Remplazar<span style="color:#E30513;">*</span></label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-star"></i></span>
						<input type="text" class="form-control" id="hardwareRemplazar" name="hardwareRemplazar" placeholder="Componente a Remplazar" required="required">
						<span id="hardwareRemplazar-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="hardwareRemplazar-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>
			<br/><br/>
			<div id="hardwareDescripcion-div" class="form-group">
				<label class="control-label col-sm-3" for="hardwareDescripcion">Descripci&oacute;n</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-star-empty"></i></span>
						<input type="text" class="form-control" id="hardwareDescripcion" name="hardwareDescripcion" placeholder="Descripción de dicho Componente" required="required">
						<span id="hardwareDescripcion-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="hardwareDescripcion-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>
			<br/><br/>
			<div id="hardwareSerialViejo-div" class="form-group">
				<label class="control-label col-sm-3" for="hardwareSerialViejo">Nº Serie Comp. a Reempl.</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-trash"></i></span>
						<input type="text" class="form-control" id="hardwareSerialViejo" name="hardwareSerialViejo" placeholder="Nº de Serie del Componente a Remplazar" required="required">
						<span id="hardwareSerialViejo-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="hardwareSerialViejo-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>
			<br/><br/>
			<div id="hardwareSerialNuevo-div" class="form-group">
				<label class="control-label col-sm-3" for="hardwareSerialNuevo">Nº Serie Comp. Nuevo</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-hdd"></i></span>
						<input type="text" class="form-control" id="hardwareSerialNuevo" name="hardwareSerialNuevo" placeholder="Nº de Serie de Componente Nuevo" required="required">
						<span id="hardwareSerialNuevo-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="hardwareSerialNuevo-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>
			<br/><br/>
			<div id="hardwareRemplazadoSN-div" class="form-group">
				<label class="control-label col-sm-3" for="hardwareRemplazadoSN">&iquest;Equipo Remplazado&quest;</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-saved"></i></span>
						<select class="form-control" id="hardwareRemplazadoSN" name="hardwareRemplazadoSN">
							<option value="Si">Sí</option>
							<option value="No">No</option>
						</select>
						<span id="hardwareRemplazadoSN-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="hardwareRemplazadoSN-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>
			<br/><br/>
			<div class="form-group">
				<div class="col-sm-4">
					<div style="color:#E30513;"><b>* = Campo Obligatorio</b></div>
				</div>
			</div>
			<br/><br/>

		</form>

	  </div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-info"
			onclick="javascript:addComponentModal();return false;">
			  Agregar a lista de Componentes
		  </button>
		   &nbsp;&nbsp;&nbsp;&nbsp;
		  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar sin agregar</button>
		</div>
	  </div>

  </div>
</div>

<!-- ========================= Modal SoftWARE =============================================== -->
<div id="myModalSoftware" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Agregar nuevo Software</h4>
	  </div>
	  <div class="modal-body">
		
		<form id="formsoftware">

			<div id="softwareNombre-div" class="form-group">
				<label class="control-label col-sm-3" for="softwareNombre">Software <span style="color:#E30513;">*</span> :</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-floppy-disk"></i></span>
						<input type="text" class="form-control" id="softwareNombre" name="softwareNombre" placeholder="Nombre del Software" required="required">
						<span id="softwareNombre-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="softwareNombre-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>
			<br/><br/>
			<div id="softwareVersion-div" class="form-group">
				<label class="control-label col-sm-3" for="softwareVersion">Versi&oacute;n:</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-sound-5-1"></i></span>
						<input type="text" class="form-control" id="softwareVersion" name="softwareVersion" placeholder="Versión de dicho Software" required="required">
						<span id="softwareVersion-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="softwareVersion-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>
			<br/><br/>
			<div id="softwareTipo-div" class="form-group">
				<label class="control-label col-sm-3" for="softwareTipo">&iquest;Es Software Libre o Propietario&quest;:</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-floppy-remove"></i></span>
						<select class="form-control" id="softwareTipo" name="softwareTipo">
							<option value="Libre">Software Libre</option>
							<option value="Propietario">Software Propietario</option>
						</select>
						<span id="softwareTipo-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="softwareTipo-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>
			<br/><br/>
			<div id="softwareSerial-div" class="form-group">
				<label class="control-label col-sm-3" for="softwareSerial">Serial:</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-sound-6-1"></i></span>
						<input type="text" class="form-control" id="softwareSerial" name="softwareSerial" placeholder="Nº de Serial de dicho Software" required="required">
						<span id="softwareSerial-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="softwareSerial-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>
			<br/><br/>
			<div id="softwareCambiadoOInstalado-div" class="form-group">
				<label class="control-label col-sm-3" for="softwareCambiadoOInstalado">&iquest;Fue Cambio o nueva Instalaci&oacute;n&quest; <span style="color:#E30513;">*</span> :</label>
				<div class="col-sm-7">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-floppy-save"></i></span>
						<select class="form-control" id="softwareCambiadoOInstalado" name="softwareCambiadoOInstalado">
							<option value="none"> -- Seleccione una opción -- </option>
							<option value="Cambio">Cambio</option>
							<option value="Instalacion">Instalación</option>
						</select>
						<span id="softwareCambiadoOInstalado-span" class=""></span>
					</div>
				</div>
				<div class="col-sm-2">
					<div id="softwareCambiadoOInstalado-error" class="help-block">
						&nbsp;
					</div>
				</div>
			</div>
			<br/><br/>
			<div class="form-group">
				<div class="col-sm-4">
					<div style="color:#E30513;"><b>* = Campo Obligatorio</b></div>
				</div>
			</div>
			<br/><br/>


		</form>

	  </div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-info" 
			onclick="javascript:addSoftwareModal();return false;">
			  Agregar a lista de Software
		  </button>
		   &nbsp;&nbsp;&nbsp;&nbsp;
		  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar sin agregar</button>
		</div>
	  </div>

  </div>
</div>


<!-- ========================= Modal Respuestas Prediseñadas =============================================== -->
<div id="myModalLabor" class="modal fade" role="dialog">

  <div class="modal-dialog modal-lg">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Buscar Respuestas Predise&ntilde;adas</h4>
	  </div>

	  <div class="modal-body">

	  	<div class="row control-group">
			<div class="col-sm-1">
				Seleccione una:
			</div>
			<div class="col-sm-11">
				<table id="tableLabor" name="tableLabor" class="table table-hover table-striped" style="font-size: 10px;width:100%;">
					<thead>
						<tr>
							<th width="40px">Selecci&oacute;n</th>
							<th>Respuestas Previas</th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ($respuestas as $respuesta) {
							$i = 0;
						?>
							<tr>
								<td><input type="radio" name="laborPredefRadio" id="laborPredefRadio" value="" onclick='javascript:document.getElementById("laborDelEquipo").value="<?= $respuesta["respuesta"]; ?>";'></td>
								<td><?= $respuesta["respuesta"]; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

	  </div>

	  <div class="modal-footer">
		<button type="button" class="btn btn-info" data-dismiss="modal">
			Agregar Respuesta
		</button>
		   &nbsp;&nbsp;&nbsp;&nbsp;
		<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='javascript:document.getElementById("laborDelEquipo").value="";'>
			Salir sin agregar
		</button>
	  </div>
	</div>

  </div>
</div>



<!-- ========================= Formulario para ABANDONAR incidencia ============================ -->
<form id="abandonarIncidenciaForm" method="post" enctype="multipart/form-data" 
	action="<?= PROJECTURLMENU; ?>tecnicos/abandonar_incidencia">
	
		<input type="hidden" id="abandonarIncidenciaId" name="abandonarIncidenciaId" value="" />
</form>


<!-- ========================= Formulario para estatus "EN ESPERA" ============================ -->
<form id="enEsperaForm" method="post" enctype="multipart/form-data" 
	action="<?= PROJECTURLMENU; ?>tecnicos/incidencia_en_espera">
	
		<input type="hidden" id="enesperaIncidenciaId" name="enesperaIncidenciaId" value="" />
		<input type="hidden" id="razonEnEspera" name="razonEnEspera" value="" />
</form>


<br/><br/>

<?php echo "<script> var varIncidenciaId = " . $incidenciaInfo[0]["incidenciaId"] . "; </script>"; ?>

<script>
	var cantidadComponenetesHardware = 0;
	var cantidadComponenetesSoftware = 0;

	$(document).ready(function () {

		$('[data-toggle="tooltip"]').tooltip();

		$('.collapse').collapse();

		cantidadComponenetesHardware = 0;
		cantidadComponenetesSoftware = 0;

		document.getElementById("cantidadComponenetesHardware").value = cantidadComponenetesHardware;
		document.getElementById("cantidadComponenetesSoftware").value = cantidadComponenetesSoftware;

		document.getElementById("incidenciaId_mainForm").value = varIncidenciaId;

	});


	/**
	 * Añadiendo Componentes de HARDWARE
	 */	
	function addComponentModal(){
		
		var x1 = document.getElementById("hardwareRemplazar").value;
		var x2 = document.getElementById("hardwareDescripcion").value;
		var x3 = document.getElementById("hardwareSerialViejo").value;
		var x4 = document.getElementById("hardwareSerialNuevo").value;
		var x5 = $("#hardwareRemplazadoSN").val();

		var bool = true;
		
		if ( x1 == "" ){
			
			bool = false;
		
			document.getElementById("hardwareRemplazar-div").className = "form-group has-error has-feedback";
			document.getElementById("hardwareRemplazar-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("hardwareRemplazar-error").innerHTML = "No debe ser vacío";
		}
		/*
		if ( x3 == "" ){
			
			bool = false;
		
			document.getElementById("hardwareSerialViejo-div").className = "form-group has-error has-feedback";
			document.getElementById("hardwareSerialViejo-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("hardwareSerialViejo-error").innerHTML = "No debe ser vacío";
		}
		if ( x4 == "" ){
			
			bool = false;
		
			document.getElementById("hardwareSerialNuevo-div").className = "form-group has-error has-feedback";
			document.getElementById("hardwareSerialNuevo-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("hardwareSerialNuevo-error").innerHTML = "No debe ser vacío";
		}
		*/
		/* Si hay *campos vacíos, NO esconder Modal */
		if ( bool == false ){
			$('#myModal').modal({
				backdrop: 'static',
				keyboard: false,
				show: true
			});

		} else {
			/*
			 * limpiando formulario para añadir un siguiente
			 */
			document.getElementById("hardwareRemplazar").value   = "";
			document.getElementById("hardwareDescripcion").value = ""; 
			document.getElementById("hardwareSerialViejo").value = "";
			document.getElementById("hardwareSerialNuevo").value = "";
			document.getElementById("hardwareRemplazadoSN").value= "Si";

			/*
			 * sumando 1 al CONT de la lista 
			 * y guardandolo en variable HIDDEN
			 */
			cantidadComponenetesHardware++;
			document.getElementById("cantidadComponenetesHardware").value = cantidadComponenetesHardware;

			/*
			 * Añadiendo a la TABLA
			 */
			var table = document.getElementById("tableHardware");
			var row = table.insertRow(cantidadComponenetesHardware);

			var cell0 = row.insertCell(0);
			var cell1 = row.insertCell(1);
			var cell2 = row.insertCell(2);
			var cell3 = row.insertCell(3);
			var cell4 = row.insertCell(4);
			var cell5 = row.insertCell(5);

			cell0.innerHTML = "" + x1;
			cell1.innerHTML = "" + x2;
			cell2.innerHTML = "" + x3;
			cell3.innerHTML = "" + x4;
			cell4.innerHTML = "" + x5;
			cell5.innerHTML = '<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Eliminar esta entrada" onclick="javascript:eliminarEntradaHardware(\'' + x1+x5 + '\');"><span class="glyphicon glyphicon-trash"></span></button>'
			;

			$('#myModal').modal('hide');

			limpiarEstilos("component");
		}
	}

	/**
	 * Añadiendo Componentes de SOFTWARE
	 */
	function addSoftwareModal(){
		
		var x1 = document.getElementById("softwareNombre").value;
		var x2 = document.getElementById("softwareVersion").value;
		var x3 = $("#softwareTipo").val();
		var x4 = document.getElementById("softwareSerial").value;
		var x5 = $("#softwareCambiadoOInstalado").val();

		var bool = true;
		
		if ( x1 == "" ){
			
			bool = false;
		
			document.getElementById("softwareNombre-div").className = "form-group has-error has-feedback";
			document.getElementById("softwareNombre-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("softwareNombre-error").innerHTML = "No debe ser vacío";
		}

		if ( x5 == "none" ){
			
			bool = false;
		
			document.getElementById("softwareCambiadoOInstalado-div").className = "form-group has-error has-feedback";
			document.getElementById("softwareCambiadoOInstalado-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("softwareCambiadoOInstalado-error").innerHTML = "Debe seleccionar uno";
		}
		
		if ( x3 == "Propietario" && x4 == "" ){
			bool = false;
		
			document.getElementById("softwareSerial-div").className = "form-group has-error has-feedback";
			document.getElementById("softwareSerial-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("softwareSerial-error").innerHTML = "Para todo Software Propietario debe llenar campo Serial del mismo";
		}

		/* Si hay *campos vacíos, NO esconder Modal */
		if ( bool == false ){
			$('#myModalSoftware').modal('show');

		} else {
			/*
			 * limpiando formulario para añadir un siguiente
			 */
			document.getElementById("softwareNombre").value = "";
			document.getElementById("softwareVersion").value= ""; 
			document.getElementById("softwareTipo").value 	= "Libre";
			document.getElementById("softwareSerial").value = "";
			document.getElementById("softwareCambiadoOInstalado").value= "Cambio";

			/*
			 * sumando 1 al CONT de la lista 
			 * y guardandolo en variable HIDDEN
			 */
			cantidadComponenetesSoftware++;
			document.getElementById("cantidadComponenetesSoftware").value = cantidadComponenetesSoftware;

			/*
			 * Añadiendo a la TABLA
			 */
			var table = document.getElementById("tableSoftware");
			var row = table.insertRow(cantidadComponenetesSoftware);

			var cell0 = row.insertCell(0);
			var cell1 = row.insertCell(1);
			var cell2 = row.insertCell(2);
			var cell3 = row.insertCell(3);
			var cell4 = row.insertCell(4);
			var cell5 = row.insertCell(5);

			cell0.innerHTML = "" + x1;
			cell1.innerHTML = "" + x2;
			cell2.innerHTML = "" + x3;
			cell3.innerHTML = "" + x4;
			cell4.innerHTML = "" + x5;
			cell5.innerHTML = '<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Eliminar esta entrada" onclick="javascript:eliminarEntradaSoftware(\'' + x1 + '\');"><span class="glyphicon glyphicon-trash"></span></button>'
			;

			$('#myModalSoftware').modal('hide');

			limpiarEstilos("software");
		}
	}

	/**
	 * Eliminar una fila de una tabla HTML
	 */
	function eliminarEntradaHardware( textoAencontrar ){
		

		var ask = confirm("¿Seguro de eliminar esta entrada de Hardware?");
		if ( ask == true) {
			var aux = "";
			var i = 0;
			/*
			 * Recorrido de tabla HTML usando Javascript para obtener valores
			 */
			for ( i=1; i < document.getElementById('tableHardware').rows.length -1; i++){

				aux ="" + document.getElementById('tableHardware').rows[i].cells[0].innerHTML
						+ document.getElementById('tableHardware').rows[i].cells[4].innerHTML;

				if ( textoAencontrar == aux ){
					break;
				}
			}

			document.getElementById( "tableHardware" ).deleteRow( i );
			
			/* Actualizar la cantidad */
			cantidadComponenetesHardware--;
			document.getElementById("cantidadComponenetesHardware").value = cantidadComponenetesHardware;
		}
	}

	function eliminarEntradaSoftware( textoAencontrar ){
		
		var r = confirm("¿Seguro de eliminar esta entrada de Software?");
		if ( r == true) {
			var aux = "";
			var i = 0;
			/*
			 * Recorrido de tabla HTML usando Javascript para obtener valores
			 */
			for ( i=1; i < document.getElementById('tableSoftware').rows.length -1; i++){

				aux ="" + document.getElementById('tableSoftware').rows[i].cells[0].innerHTML;

				if ( textoAencontrar == aux ){
					break;
				}
			}

			document.getElementById( "tableSoftware" ).deleteRow( i );
			
			/* Actualizar la cantidad */
			cantidadComponenetesSoftware--;
			document.getElementById("cantidadComponenetesSoftware").value = cantidadComponenetesSoftware;
		}
	}

	function abandonarIncidencia( incidenciaId ){

		var ask = confirm(" >> ABANDONAR la Incidencia número: "
			+ incidenciaId + " << "
			+ "\n\n Pulsando esta opción, Usted dejará de tener asignada esta Incidencia, y quedará abierta para que otro Ing. de Soporte la atienda."
			+ "\n\n ¿Desea continuar?"
			+ "\n\n (Presione Yes/OK para abandonar esta incidencia)");

		if ( ask == true) {
			
			document.getElementById("abandonarIncidenciaId").value = incidenciaId;

			document.getElementById("abandonarIncidenciaForm").submit();
		}
	}

	function markAsWait( incidenciaId ){

		var ask = confirm(" >> MARCAR EN ESPERA la Incidencia número: "
			+ incidenciaId + " << "
			+ "\n\n Indica que necesita más información para resolver esta Incidencia y no puede proseguir."
			+ "\n\n [En la medida de sus posibilidades NOTIFIQUE al Usuario que no ha podido resolver el inconveniente para que le dé la info que necesita] "
			+ "\n\n ¿Desea continuar?"
			+ "\n\n (Presione Yes/OK para colocar el estatus `En Espera`)");

		if ( ask == true) {

			if ( $("#observaciones").val() == "" || $("#observaciones").val() == null ) {

				document.getElementById("observaciones-div").className = "form-group has-error has-feedback";
				document.getElementById("observaciones-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("observaciones-error").innerHTML = "Si va a marcar `En Espera` debe indicar el o los motivos para que el Usuario esté notificado y busque proveerle la info necesaria.";

				collapseAll();

				$('#collapse6').collapse('show');

			} else {
				document.getElementById("enesperaIncidenciaId").value = incidenciaId;
				document.getElementById("razonEnEspera").value = $("#observaciones").val();
				
				document.getElementById("enEsperaForm").submit();
			}
		}
	}

	function submitForm(){
	
		var bool = true;
		var scrollElement = "#basicData";
		var scrolled = false;

		collapseAll();

		limpiarEstilos("form");

		if ( $("#laborDelEquipo").val() == "" ){
			bool = false;

			document.getElementById("laborDelEquipo-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("laborDelEquipo-div").className = "form-group has-error has-feedback";
			document.getElementById("laborDelEquipo-error").innerHTML += "<br/>Debe indicar algo, puede ser: Uso principal, Usuario, etc.";

			$('#collapse1').collapse('show');
		}

		if ( $('#variableEndogena').val() == "" && $('#variableExogenaTecnica').val() == ""
				&& $('#variableExogenaHumana').val() == "" && esReporte == "false" ){
			/*
			 * si es REPORTE pueden quedar vacíos, si es Incidencia debe marcar por lo menos uno de los 3
			 */
			bool = false;

			/* al lado del input element */
			document.getElementById("variableEndogena-span").className = "glyphicon glyphicon-remove form-control-feedback";
			/* en el elemento form-group*/
			document.getElementById("variableEndogena-div").className = "form-group has-error has-feedback";
			/* Mensaje de error */
			document.getElementById("variableEndogena-error").innerHTML = "Por lo menos 1 de las 3 VARIABLES debe ser llenada con la causa del Inconveniente";
			
			document.getElementById("variableExogenaTecnica-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("variableExogenaTecnica-div").className = "form-group has-error has-feedback";

			document.getElementById("variableExogenaHumana-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("variableExogenaHumana-div").className = "form-group has-error has-feedback";

			$('#collapse2').collapse('show');
		}

		if ( $('input[type=radio][name=HWmantenimiento]:checked').val() == "HWcorrectivo" 
				&& ( $('#mantenimientoHardware').val() == "" || cantidadComponenetesHardware == 0 ) ){

			bool = false;
			/*
			 * al ser HW - Correctivo, NO puede quedar vacío
			 */
			document.getElementById("mantenimientoHardware-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("mantenimientoHardware-div").className = "form-group has-error has-feedback";
			document.getElementById("mantenimientoHardware-error").innerHTML = "Al ser Mantenimiento 'Correctivo' se necesita que sea Espec&iacute;fico en los Pasos realizados para su Soluci&oacute;n";
 	
 			
 			$('#collapse3').collapse('show');
		}
		
		if ( $('input[type=radio][name=HWmantenimiento]:checked').val() == "HWcorrectivo" 
				&& ( $('#mantenimientoSoftware').val() == "" || cantidadComponenetesSoftware == 0 ) ){

			bool = false;
			/*
			 * al ser HW - Correctivo, NO puede quedar vacío
			 */
			document.getElementById("mantenimientoSoftware-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("mantenimientoSoftware-div").className = "form-group has-error has-feedback";
			document.getElementById("mantenimientoSoftware-error").innerHTML = "Al ser Mantenimiento 'Correctivo' se necesita que Especifique los Pasos realizados para la Soluci&oacute;n de dicha falla de Software";
 	
 			
 			$('#collapse4').collapse('show');
		}

		/* serializar la tabla dinámica */
		if ( cantidadComponenetesHardware > 0 ){

			var hardwareARemplazar = "";
			var hardwareDescripciones = "";
			var hardwareViejo = "";
			var hardwareNuevo = "";
			var hardwareFueRemplazadoSN = "";	
			
			var table = document.getElementById("tableHardware");var aux="";

			/* iterate through rows */
			for (var i = 0, row; row = table.rows[i]; i++) {
   
				/* saltando el titulo */
				if (i === 0) { continue; }

				/* rows would be accessed using the "row" variable assigned in the for loop */

				/* iterate through columns */
				for (var j = 0, col; col = row.cells[j]; j++) {
	 
					/* columns would be accessed using the "col" variable assigned in the for loop */
					aux = col.innerHTML;

					if(j===0){
						hardwareARemplazar += aux + "," ;

					} else if(j===1){
						hardwareDescripciones += aux + "," ;

					} else if(j===2){
						hardwareViejo += aux + "," ;

					} else if(j===3){
						hardwareNuevo += aux + "," ;

					} else if(j===4){
						hardwareFueRemplazadoSN += aux + "," ;
					}
			   }
			}

			document.getElementById("hardwareARemplazar").value 	 = hardwareARemplazar;
			document.getElementById("hardwareDescripciones").value 	 = hardwareDescripciones;
			document.getElementById("hardwareViejo").value 			 = hardwareViejo;
			document.getElementById("hardwareNuevo").value 			 = hardwareNuevo;
			document.getElementById("hardwareFueRemplazadoSN").value = hardwareFueRemplazadoSN;

		}

		/* serializar la tabla dinámica */
		if ( cantidadComponenetesSoftware > 0 ){

			var softwareARemplazar = "";
			var versiones = "";
			var tipos = "";
			var seriales = "";
			var remplazados = "";	
			
			var table = document.getElementById("tableSoftware");var aux="";

			/* iterate through rows */
			for (var i = 0, row; row = table.rows[i]; i++) {
   
				/* saltando el titulo */
				if (i === 0) { continue; }

				/* rows would be accessed using the "row" variable assigned in the for loop */

				/* iterate through columns */
				for (var j = 0, col; col = row.cells[j]; j++) {
	 
					/* columns would be accessed using the "col" variable assigned in the for loop */
					aux = col.innerHTML;

					if(j===0){
						softwareARemplazar += aux + "," ;

					} else if(j===1){
						versiones += aux + "," ;

					} else if(j===2){
						tipos += aux + "," ;

					} else if(j===3){
						seriales += aux + "," ;

					} else if(j===4){
						remplazados += aux + "," ;
					}
			   }
			}

			document.getElementById("SoftwaresARemplazar").value= softwareARemplazar;
			document.getElementById("SoftwareVersiones").value 	= versiones;
			document.getElementById("SoftwareTipos").value 		= tipos;
			document.getElementById("SoftwareSeriales").value 	= seriales;
			document.getElementById("SoftwaresCambiados").value = remplazados;

		}

		if ( bool == true ){

			var ask = confirm(" >> Marcar la Incidencia número: "
				+ varIncidenciaId + " como RESUELTA << "
				+ "\n\n Con la información que usted ha proporcionado se dará por Finalizada esta incidencia."
				+ "\n\n ¿Desea continuar?"
				+ "\n\n (Presione Yes/OK para colocar el estatus `CERRADA`)");

			if ( ask == true) {
				/*
				 * Si estan deshabilitados los campos NO llegan mediante $_POST
				 */
				$('#mantenimientoHardware').removeAttr("disabled");
				$('#mantenimientoSoftware').removeAttr("disabled");

				$('#reporteOincidencia').val( "" + esReporte );

				/*
				 * Añadir JSON a sus inscidencias sin opinar
				 */
				var toadd = JSON.parse(jsonFormatIncidenciasSinOpinar);
				var newobj = { "id": ""+jsIncidenciaId };
				var jsonToUpdate = addJsonObj(toadd, newobj);
				console.log("jsonToUpdate",jsonToUpdate);

				$('#jsonIncidenciasSinOpinar').val( jsonToUpdate );


				$('#es_reporte_de_visita').val( jsEsReporteVisita );


				/* submit POST enviando formulario */
				document.getElementById("resolver_incidencia_form").submit();

				return true;

			} else {
				//para que el onsubmit no se vaya
				return false;
			}

		} else {
			/* hacer scroll animando la pantalla hasta llegar a un DIV #id */
			$('html, body').animate({
				scrollTop: $( scrollElement ).offset().top
			}, 2000);

			return false;
		}
	}


	function limpiarEstilos(part){

		if ( part == "component" ){

			document.getElementById("hardwareRemplazar-span").className = "";
			document.getElementById("hardwareRemplazar-div").className = "form-group";
			document.getElementById("hardwareRemplazar-error").innerHTML = "";

			document.getElementById("hardwareSerialViejo-span").className = "";
			document.getElementById("hardwareSerialViejo-div").className = "form-group";
			document.getElementById("hardwareSerialViejo-error").innerHTML = "";

			document.getElementById("hardwareSerialNuevo-span").className = "";
			document.getElementById("hardwareSerialNuevo-div").className = "form-group";
			document.getElementById("hardwareSerialNuevo-error").innerHTML = "";

		} else if ( part == "software" ){
			
			document.getElementById("softwareNombre-span").className = "";
			document.getElementById("softwareNombre-div").className = "form-group";
			document.getElementById("softwareNombre-error").innerHTML = "";

			document.getElementById("softwareCambiadoOInstalado-span").className = "";
			document.getElementById("softwareCambiadoOInstalado-div").className = "form-group";
			document.getElementById("softwareCambiadoOInstalado-error").innerHTML = "";

			document.getElementById("softwareSerial-span").className = "";
			document.getElementById("softwareSerial-div").className = "form-group";
			document.getElementById("softwareSerial-error").innerHTML = "";

		} else if ( part == "form" ){
			document.getElementById("variableEndogena-span").className = "";
			document.getElementById("variableEndogena-div").className = "form-group";
			document.getElementById("variableEndogena-error").innerHTML = "";

			document.getElementById("mantenimientoHardware-span").className = "";
			document.getElementById("mantenimientoHardware-div").className = "form-group";
			document.getElementById("mantenimientoHardware-error").innerHTML = "";

			document.getElementById("mantenimientoSoftware-span").className = "";
			document.getElementById("mantenimientoSoftware-div").className = "form-group";
			document.getElementById("mantenimientoSoftware-error").innerHTML = "";

			document.getElementById("variableExogenaTecnica-span").className = "";
			document.getElementById("variableExogenaTecnica-div").className = "form-group";

			document.getElementById("variableExogenaHumana-span").className = "";
			document.getElementById("variableExogenaHumana-div").className = "form-group";

			document.getElementById("observaciones-span").className = "";
			document.getElementById("observaciones-div").className = "form-group";
			document.getElementById("observaciones-error").innerHTML = "";

			return true;
		}
	}

	/**
	 * Para habilitar/deshabilitar (toogle) opciones de Hardware y Software
	 */
	function habilitarMantemiento(opcion){

		if ( opcion == "HWcorrectivo" ){

			/* Es Obligatorio añadir componentes HW */
			$('#addHW').prop('disabled', false);

			/* Texto editable Obligatorio */
			document.getElementById("mantenimientoHardware").value = "";
			$('#mantenimientoHardware').prop('disabled', false);

		} else if ( opcion == "HWpreventivo" ){

			/* NO requiere añadir componentes HW */
			$('#addHW').prop('disabled', true);

			/* Texto fijo NO editable */
			document.getElementById("mantenimientoHardware").value = pasosHardware;
			$('#mantenimientoHardware').prop('disabled', true);

		} else if ( opcion == "HWotro" ){

			$('#addHW').prop('disabled', false);

			document.getElementById("mantenimientoHardware").value = "";
			$('#mantenimientoHardware').prop('disabled', false);

		} else if ( opcion == "SWcorrectivo" ){

			/* Es Obligatorio añadir componentes SoftWare */
			$('#addSW').prop('disabled', false);

			/* Texto editable Obligatorio */
			document.getElementById("mantenimientoSoftware").value = "";
			$('#mantenimientoSoftware').prop('disabled', false);

		} else if ( opcion == "SWpreventivo" ){

			/* NO requiere añadir componentes SoftWare */
			$('#addSW').prop('disabled', true);

			/* Texto fijo NO editable */
			document.getElementById("mantenimientoSoftware").value = pasosSoftware;
			$('#mantenimientoSoftware').prop('disabled', true);
		
		} else if ( opcion == "SWotro" ){

			$('#addSW').prop('disabled', false);

			document.getElementById("mantenimientoSoftware").value = "";
			$('#mantenimientoSoftware').prop('disabled', false);

		}
	}
	
</script>