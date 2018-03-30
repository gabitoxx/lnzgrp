<style>
	#tableId tr td:nth-child(3){
		width:210px !important;
	}
	#tableId tr td:nth-child(4){
		width:210px !important;
	}
	#tableId tr td:nth-child(5){
		width:300px !important;
	}
	#tableId {
		table-layout: fixed !important;
		width: 100% !important;
	}
</style>


<!-- ============================================================================================== -->
<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-indent-left logo slideanim"></span>
	<i>Reportes de Vista</i>
</h4>

<?php 

	if ( isset($no_reportes_de_visita) ){
?>

	<div class="container">
		<h4>
			Nuestros Ingenieros de Soporte a&uacute;n no han visitado su Empresa 
			para realizar trabajos presencialmente (mantenimientos preventivos, correctivos o adecuaciones).
		 </h4>
	</div>

<?php 
		/* Destruir la variable una vez usada */
		unset($no_reportes_de_visita);

	} else { 
		/* En caso de que haya incidencias, mostrar la tabla */
?>

<div class="container">
	<div class="row">
		<div class="col-md-12" style="text-align:center;">
			<u>Trabajos realizados por nuestros Ing. de Soporte en su Empresa in-situ (presencialmente).</u>
			<br/><br/>
		</div>
	</div>
	<div class="row">
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

					/* Recorrido de Incidencias */
					foreach ( $reportesVisita as $informe ) {
?>
						<tr>

							<td data-title="#Reporte/Estatus" align="center" style="padding-top: 10px; padding-bottom: 10px;">
								<?= $informe["incidenciaId"] . "<br/>" . $informe["status"] ?>
							</td>

							<td data-title="Acciones" >
								<button type="button"
								 <?php 
									if ($informe["resolucionId"]==null || $informe["resolucionId"]==""){
										echo 'class="btn btn-primary disabled"';
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
										echo 'class="btn btn-info disabled"';
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
		</div>
	</div>
</div>

<fieldset class="scheduler-border">
	<legend class="scheduler-border">Leyenda</legend>
	<div class="row control-group">
		<div class="col-sm-2"><b>Nº de Reporte y Estatus actual:</b></div>
		<div class="col-sm-10">
		 es el <b>identificador &uacute;nico</b> y el <b>estado actual</b>
		  en el que se encuentra el Reporte de Visita.
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-2"><b>Acciones:</b></div>
		<div class="col-sm-10">
		 las Acciones que usted puede ejecutar en esta Vista, las cuales son:
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="57px">
						<button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-folder-open"></span></button>
					</td>
					<td>
						<b>Ver la Soluci&oacute;n de la Incidencia</b> (<span class="glyphicon glyphicon-print"></span> <i>Imprimir</i>): 
						<br/>El Ingeniero de Soporte asignado cerr&oacute; la Incidencia
						porque resolvi&oacute; el inconveniente y pulsando esta opci&oacute;n usted podr&aacute; conocer
						la soluci&oacute;n al mismo (Reporte generado por el Ingeniero de Soporte a cargo).
						<br/><br/>
						Si surge un problema nuevo, por favor puede proceder a <b>Crear Nueva Incidencia</b>.
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row control-group">
		<div class="col-sm-offset-2 col-sm-10">
			<table class="table table-hover table-striped">
				<tr>
					<td width="57px">
						<button type="button" class="btn btn-info"><span class="glyphicon glyphicon-wrench"></span></button>
					</td>
					<td>
						<b>Ver info del Ingeniero de Soporte</b>: 
						<br/>Se mostrar&aacute; la informaci&oacute;n de contacto del Ingeniero de Soporte.
					</td>
				</tr>
			</table>
		</div>
	</div>
</fieldset>

<!-- ========================= MODAL para ver la info del Técnico ============================ -->
<div class="modal fade" id="myModal" role="dialog">
	<!-- tamaño del modal: modal-sm PEQUEÑO | modal-lg GRANDE -->
	<div class="modal-dialog modal-sm">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title" align="center">
			<span class="glyphicon glyphicon-wrench"></span> 
			Informaci&oacute;n del Ingeniero de Soporte
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

	function verMasDetalles(trId){
		var result_style = document.getElementById( trId ).style;
		result_style.display = 'table-row';
	}
	function verMenosDetalles(trId){
		var result_style = document.getElementById( trId ).style;
		result_style.display = 'none';
	}
</script>

<?php
	}/* else */
?>