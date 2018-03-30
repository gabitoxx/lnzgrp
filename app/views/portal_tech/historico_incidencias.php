
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

<h4 style="text-align:center; color:#E30513;" align="center">
	<span class="glyphicon glyphicon-time logo slideanim"></span>
	<u>Listado Hist&oacute;rico de Incidencias</u>
</h4>

<div class="row">
	<div class="col-sm-offset-2 col-sm-10">
		Las Incidencias Finalizadas poseen 2 estatus:
	</div>
</div>
<div class="row">
	<div class="col-sm-offset-2 col-sm-2">
		Estatus <b>"Cerrada"</b>:
	</div>
	<div class="col-sm-8">
		Aquellas Incidencias que han sido <b>solucionadas</b>, por Usted o por otro Ingeniero de Soporte.
	</div>
</div>
<div class="row">
	<div class="col-sm-offset-2 col-sm-2">
		Estatus <b>"Certificada"</b>:
	</div>
	<div class="col-sm-8">
		Aquellas Incidencias que han sido <b>solucionadas</b> y cuya soluci&oacute;n ya ha sido
		<b>certififcada o validada</b> por el Usuario que present&oacute; el inconveniente.
	</div>
	<br/>
</div>


<!-- ============================================================================================== -->
<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-indent-left logo slideanim"></span>
	<i>Listado Hist&oacute;rico de Incidencias <b>a su cargo</b></i>
</h4>

<?php 
	
	if ( isset($no_incidenciasTecnico) ){
?>

	<div class="container">
		<h3>Usted No posee Incidencias/Soportes t&eacute;cnicos Finalizados en el Sistema.
		</h3>
		<h4>Aqu&iacute; se mostrar&aacute;n las Incidencias que contengan el estatus "Cerrada" o "Certificada"
		</h4>
	</div>

<?php 
		/* Destruir la variable una vez usada */
		unset($no_incidenciasTecnico);

	} else { 
		/* En caso de que haya incidencias, mostrar la tabla */
?>

<div class="container">
	<div id="no-more-tables">
		<table id="tableIncidenciasGerente" class="col-md-12 table-hover table-striped cf" style="font-size: 12px;">
			<thead class="cf">
				<tr>
					<th width="90px" class="active" align="center">Nº Incidencia<br/>y Estatus</th>
					<th width="67px">Ver Soluci&oacute;n</th>
					<th width="100px" align="center">Nº Equipo<br/>Empresa</th>
					<th width="145px">Fecha creaci&oacute;n<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
					<th width="160px">Falla:<br/>General</th>
					<th width="160px">Falla:<br/>Comentarios</th>
					<th width="100px" align="center">Atendida por<br/>(Ing. de Soporte)</th>
					<th width="100px">Resumen de<br/>la soluci&oacute;n</th>
					<th width="30px" align="center">Duraci&oacute;n<br/>d&iacute;as</th>
				</tr>
			</thead>
			<tbody>

				<?php 
					/* Recorrido de Incidencias */
					foreach ($incidenciasTecnico as $incidencia) { 
				?>
					<tr>
						<td data-title="Incidencia/Estatus" align="center" style="padding-top: 10px; padding-bottom: 10px;" 
						 <?php 
							if($incidencia["status"]=="Cerrada"){echo 'class="info"';}
							else if($incidencia["status"]=="Certificada"){echo 'class="success"';}
							else {echo 'class="active"';}
						 ?>
						>
						 	<?= $incidencia["incidenciaId"] . "<br/>" . $incidencia["status"]; ?>
						</td>

						<td data-title="Acciones">

							<button type="button" class="btn btn-primary"
							 data-toggle="tooltip" data-placement="bottom" title="Ver Soluci&oacute;n de la Incidencia | Opci&oacute;n Imprimir Reporte"
							 onclick="javascript:verDetalleSolucion(<?php echo $incidencia["resolucionId"] ?>);"
							 >
								<span class="glyphicon glyphicon-folder-open"></span> 
							</button>

						</td>

						<td data-title="Nº Equipo" align="center">
							<?php 
								if ( $incidencia["codigoBarras"] != null && $incidencia["codigoBarras"] != ""){
									echo $incidencia["codigoBarras"] . "<br/>" . $incidencia["nombreEmpresa"];
								} else {
									echo $incidencia["nombreEmpresa"];
								}
							?>
						</td>
						<td data-title="Fecha creaci&oacute;n"><?php echo $incidencia["fecha"]; ?></td>
						<td data-title="Falla: General"><?php echo $incidencia["tipoFalla"]; ?></td>
						<td data-title="Observaciones"><?php echo $incidencia["observaciones"]; ?></td>

						<td data-title="Resumen">
							<?= $incidencia["variableEndogena"] . " " . $incidencia["variableExogenaTecnica"] . " " . $incidencia["variableExogenaHumana"]; ?>
						</td>

						<td data-title="Duraci&oacute;n" align="center">
							<?= $incidencia["incidenciaDuracionDias"]; ?>
						</td>
						
					</tr>
				<?php } ?>

			</tbody>
		</table>
	</div>
</div>


<!-- ========================= Formulario para VER SOLUCION DE una incidencia  ================================== -->
<form id="resolucionIncidenciaForm" method="post" enctype="multipart/form-data" 
	action="<?= PROJECTURLMENU; ?>tecnicos/ver_resolucion_incidencia">
	
		<input type="hidden" id="resolucionIncidenciaId" name="resolucionIncidenciaId" value="" />
</form>

<?php 
	}/*  incidenciasTecnico  */
?>

<script>
	/**
	 * Formulario como el del Tecnico pero sin poder editar
	 */
	function verDetalleSolucion(resolucionId){

		document.getElementById("resolucionIncidenciaId").value = resolucionId;

		document.getElementById("resolucionIncidenciaForm").submit();
	}
</script>

<!-- ============================================================================================== -->
<br/><br/>

<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-indent-left logo slideanim"></span>
	<i>Listado Hist&oacute;rico de <b>TODAS</b> las Incidencias <b>Finalizadas</b></i>
</h4>

<div class="container">
	<div id="no-more-tables">
		<table id="tableIncidenciasGerente" class="col-md-12 table-hover table-striped cf" style="font-size: 12px;">
			<thead class="cf">
				<tr>
					<th width="90px" class="active" align="center">Nº Incidencia<br/>y Estatus</th>
					<th width="104px">Acciones</th>
					<th width="100px" align="center">Nº Equipo<br/>Empresa</th>
					<th width="145px">Fecha creaci&oacute;n<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
					<th width="160px">Falla:<br/>General</th>
					<th width="160px">Falla:<br/>Comentarios</th>
					<th width="100px" align="center">Atendida por<br/>(Ing. de Soporte)</th>
					<th width="100px">Resumen de<br/>la soluci&oacute;n</th>
					<th width="30px" align="center">Duraci&oacute;n<br/>d&iacute;as</th>
				</tr>
			</thead>
			<tbody>

				<?php 
					/* Recorrido de Incidencias */
					foreach ($incidenciasTodas as $incidencia) { 
				?>
					<tr>
						<td data-title="Incidencia/Estatus" align="center" style="padding-top: 10px; padding-bottom: 10px;" 
						 <?php 
							if($incidencia["status"]=="Cerrada"){echo 'class="info"';}
							else if($incidencia["status"]=="Certificada"){echo 'class="success"';}
							else {echo 'class="active"';}
						 ?>
						>
						 	<?= $incidencia["incidenciaId"] . "<br/>" . $incidencia["status"]; ?>
						</td>

						<td data-title="Acciones">

							<button type="button" class="btn btn-primary"
							 data-toggle="tooltip" data-placement="bottom" title="Ver Soluci&oacute;n de la Incidencia | Opci&oacute;n Imprimir Reporte"
							 onclick="javascript:verDetalleSolucion(<?php echo $incidencia["resolucionId"] ?>);"
							 >
								<span class="glyphicon glyphicon-folder-open"></span> 
							</button>
							&nbsp;
							<button type="button" class="btn btn-warning"
							 data-toggle="tooltip" data-placement="bottom" title="Ver Informaci&oacute;n de Contacto del Ingeniero de Soporte"
							 onclick="javascript:verInfoTecnico(<?php echo $incidencia["tecnicoId"] ?>);"
							 >
								<span class="glyphicon glyphicon-wrench"></span>
							</button>

						</td>

						<td data-title="Nº Equipo" align="center">
							<?php 
								if ( $incidencia["codigoBarras"] != null && $incidencia["codigoBarras"] != ""){
									echo $incidencia["codigoBarras"] . "<br/>" . $incidencia["nombreEmpresa"];
								} else {
									echo $incidencia["nombreEmpresa"];
								}
							?>
						</td>
						<td data-title="Fecha creaci&oacute;n"><?php echo $incidencia["fecha"]; ?></td>
						<td data-title="Falla: General"><?php echo $incidencia["tipoFalla"]; ?></td>
						<td data-title="Observaciones"><?php echo $incidencia["observaciones"]; ?></td>

						<td data-title="Atendida por" align="center">
							<?= $incidencia["Tecnico_nombre"] . "<br/>" . $incidencia["Tecnico_apellido"]; ?>
						</td>

						<td data-title="Resumen">
							<?= $incidencia["variableEndogena"] . " " . $incidencia["variableExogenaTecnica"] . " " . $incidencia["variableExogenaHumana"]; ?>
						</td>

						<td data-title="Duraci&oacute;n" align="center">
							<?= $incidencia["incidenciaDuracionDias"]; ?>
						</td>
						
					</tr>
				<?php } ?>

			</tbody>
		</table>
	</div>
</div>

<!-- ================================== Formulario para VER info del Tecnico ======================================= -->
<?php
	echo "<script> var modalAjaxURL = '" . PROJECTURLMENU . "tecnicos/ajax_ver_tecnico'; </script>" ;
?>
<form id="enviarTecnico" method="post" enctype="multipart/form-data">
	<input type="hidden" id="tecnicoId" name="tecnicoId" value="" />
</form>

<div class="modal fade" id="myModal" role="dialog">
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

<script>

	function verInfoTecnico(tecnicoId){

		$('#myModal').modal('show');

		/* valor en el input type hidden */
		document.getElementById("tecnicoId").value = "" + tecnicoId;

		$.ajax({
			type: "POST",
			url: modalAjaxURL,
			data: $('#enviarTecnico').serialize(),
			success: function(message){
				/*alert("OK_");*/
				/*$("#feedback-modal").modal('hide');*/
				$("#feedback").html(message)
			},
			error: function(){
				alert("Error al buscar info del Técnico en nuestro Sistema\nPor favor, intente más tarde");
			}
		});
	}

</script>