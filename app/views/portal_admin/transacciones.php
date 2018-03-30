<h4 style="text-align:center; color:#E30513;">
	<span class="glyphicon glyphicon-indent-left logo slideanim"></span>
	<i>Buscar Transacciones en el Sistema: Portal LanuzaGroup</i>&nbsp;&nbsp;&nbsp;
</h4>

<?php
	$footer = "*Esta informaci&oacute;n es concerniente a la Empresa LanuzaGroup y NO debe ser usada 
			con otros fines m&aacute;s all&aacute; del alcance de los Soportes T&eacute;cnicos 
			contratados con la Empresa y NO para divulgaci&oacute;n p&uacute;blica.";
?>
<div class="container">

	<form class="form-horizontal" data-toggle="validator" role="form" id="transacciones_form" method="post"
	 enctype="multipart/form-data" action="<?= PROJECTURLMENU ?>admin/busqueda_transacciones">

		<div class="row">
			<div class="col-sm-12" align="center" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				
				<b>Filtrar por Estatus:</b>

				&nbsp;&nbsp;&nbsp;

				<label class="radio-inline"
				  data-toggle="tooltip" data-placement="bottom" title="Filtrar solo aquellas operaciones donde hubo alg&uacute;n ERROR en el Sistema que NO dej&oacute; completar alguna acci&oacute;n">
				  <input type="radio" name="status" id="status" value="Not_Ok" <?php if($status == "Not_Ok") echo ' checked="checked" ' ?> >
					Transacciones donde hubo alg&uacute;n ERROR
				</label>

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<label class="radio-inline"
				  data-toggle="tooltip" data-placement="bottom" title="Traer solo aquellas operaciones registradas como Exitosas">
				  <input type="radio" name="status" id="status" value="Ok" <?php if($status == "Ok") echo ' checked="checked" ' ?> >
					Solo Transacciones Exitosas
				</label>

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

				<label class="radio-inline"
				  data-toggle="tooltip" data-placement="bottom" title="Traer ambos tipos de Transacciones">
				  <input type="radio" name="status" id="status" value="both" <?php if($status == "both") echo ' checked="checked" ' ?> >
					Ambos estatus
				</label>
			</div>
		</div>

		<hr/>

		<div class="row">
			<div class="col-sm-4" align="center" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<label>
					<input type="checkbox" id="search_keywords" name="search_keywords" value="keywords" onclick="javascript:toogleDisableID('searched');"
					 <?php if($checkboxKeywords == "true") echo ' checked="checked" ' ?>
					 > 
					<b>Buscar</b>: puede <i>escribir palabras claves</i> sobre informaci&oacute;n de acciones y/o errores
				</label>
			</div>
			<div class="col-sm-8">
				<input type="text" name="searched" id="searched" class="search" <?php if($checkboxKeywords != "true") echo ' disabled="disabled" ' ?>
				 placeholder="Buscar por Errores reportados, ocurridos o por información de operaciones: indique palabra(s) clave."
				 <?php if ( isset($searched) ) echo 'value="' . $searched . '"'; ?>
				>
			</div>
		</div>

		<hr/>

		<div class="row">
			<div class="col-sm-4" align="center" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<label>
					<input type="checkbox" id="search_company" name="search_company" value="company" onclick="javascript:toogleDisableID('companiesCombo');"
					<?php if($checkboxCompany == "true") echo ' checked="checked" ' ?>
					 >
					Filtrar por Empresa:
				</label>
			</div>
			<div class="col-sm-8">
				<select class="form-control" id="companiesCombo" name="companiesCombo" <?php if($checkboxCompany != "true") echo ' disabled="disabled" ' ?> >
					<option value="none">-- Cualquier Empresa -- </option>
<?php
						$option = "";
						$razon  = "";
						foreach ( $empresas as $empresa ){

							$a = "";
							if ( $empresa["empresaId"] == $searchedCompany ){
								$a = ' selected="selected" ';
							}

							$option = '<option value="' . $empresa["empresaId"] . '"' . $a . '>' . $empresa["nombre"];
							
							if ( $empresa["razonSocial"] != "" ) {
								$razon = " (" . $empresa["razonSocial"] . ")" ;
							} else {
								$razon = "";
							}
							
							echo $option . $razon . "</option>";
						}
?>
				</select>
			</div>
		</div>

		<hr/>

		<div class="row">
			<div class="col-sm-4" align="center" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<label>
					<input type="checkbox" id="search_operation" name="search_operation" value="operation" onclick="javascript:toogleDisableID('trx');"
					 <?php if($checkboxOperation == "true") echo ' checked="checked" ' ?>
					 >
					Filtrar por tipo de Operaci&oacute;n:
				</label>
			</div>
			<div class="col-sm-8">
				<select class="form-control" id="trx" name="trx" <?php if($checkboxOperation != "true") echo ' disabled="disabled" ' ?> >
					<option value="none">-- Cualquier operación -- </option>
<?php
						foreach ( $operaciones as $trx ){

							$b = "";
							if ( $trx["nombre"] == $searchedTrx ){
								$b = ' selected="selected" ';
							}

							$a = $trx["descripcion"];
							if ( strlen($a) > 60 ){
								$a = substr( $a , 0 , 60 );
							}
							echo '<option value="' . $trx["nombre"] . '" ' . $b . '>' . $a . " &nbsp;&nbsp;&nbsp;&nbsp; (" . $trx["nombre"]  . ")</option>";
						}
?>
				</select>
			</div>
		</div>

		<hr/>

		<div class="row">
			<!-- Include Bootstrap Datepicker -->
			<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
			<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />

			<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

			<style type="text/css">
				/**
				 * Override feedback icon position
				 * See http://formvalidation.io/examples/adjusting-feedback-icon-position/
				 */
				#transacciones_form .form-control-feedback {
					top: 0;
					right: -15px;
				}
			</style>

			<div class="col-sm-2">
				<br/><br/><br/>
				<b style="font-size: 16px;">Filtrar por Fecha:</b>
			</div>
			<div class="col-sm-4" align="center" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<div class="form-group">
					<label class="control-label">
						<input type="checkbox" id="search_from" name="search_from" value="from" onclick="javascript:toogleDisableID('fechaDesde');"
						 <?php if($checkboxDesde == "true") echo ' checked="checked" ' ?>
						 >
						Desde
					</label>
					<div class="date">
						<div class="input-group input-append date" id="datePicker">
							<input type="text" class="form-control" name="fechaDesde" id="fechaDesde" 
							 <?php if($checkboxDesde != "true") echo ' disabled="disabled" ' ?>
							 value="<?= $searchDesde; ?>" />
							<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</div>
				</div>

			</div>

			<div class="col-sm-4" align="center" style="padding: 12px 20px 12px 40px; font-size: 16px;">
				<div class="form-group">
					<label class="control-label">
						<input type="checkbox" id="search_to" name="search_to" value="to" onclick="javascript:toogleDisableID('fechaHasta');"
						 <?php if($checkboxHasta == "true") echo ' checked="checked" ' ?>
						 >
						Hasta
					</label>
					<div class="date">
						<div class="input-group input-append date" id="datePicker2">
							<input type="text" class="form-control" name="fechaHasta" id="fechaHasta"
							 <?php if($checkboxHasta != "true") echo ' disabled="disabled" ' ?>
							 value="<?= $searchHasta; ?>" />
							<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
						</div>
					</div>
				</div>
			</div>

		</div>

		<hr/>

		<div class="row">
			<div class="col-sm-12" align="center">
				<button type="button" class="btn btn-primary btn-lg" onclick="javascript:habilitarTodo();" 
				 data-toggle="tooltip" data-placement="bottom" title="Buscar en tabla Transacciones del Portal">
					<span class="glyphicon glyphicon-search"></span> Buscar Transacciones
				</button>
			</div>
		</div>

	</form>

	<br/><br/><br/>
<?php 
	if ( isset($no_transacciones) && $no_transacciones == "no_transacciones"){
		echo "<b>NO se encontraron Transacciones</b> con los filtros especificados.
				<br/><br/>
				Query ejecutado: " . $query
				. "<br/><br/> Intente nuevamente con otra data de búsqueda.";
	
	} else {
		echo "<script>";
		echo " var modalAjaxURL  = '" . PROJECTURLMENU . "admin/ajax_ver_usuario';" ;
		echo " var modalAjaxURL2 = '" . PROJECTURLMENU . "admin/ajax_ver_incidencia';" ;
		echo "</script>";

?>
	<div class="row">
		<div class="col-sm-12">
			Query ejecutado: <?= $query; ?>
			<br/><br/>
		</div>
	</div>

	<div>
		<table style="font-size: 12px;" border="1">
			<thead>
				<tr style="background-color:rgba(73, 111, 224, 0.3);">
					<th align="center" class="primary">TransaccionId</th>
					<th align="center" class="warning" style="width: 150px; text-align: center;">Fecha/Hora<br/>(A&ntilde;o-Mes-D&iacute;a Hora)</th>
					<th align="center" class="active" style="width: 150px; text-align: center;">Tipo transacci&oacute;n<br/>(Operaci&oacute;n)</th>
					<th align="center" class="active" style="width: 60px; text-align: center;">Estatus</th>
					<th align="center" class="info"   style="width: 100px; text-align: center;">Involucrados</th>
					<th style="text-align: center;">Info</th>
					<th style="text-align: center;">Error: Tipo</th>
					<th style="text-align: center;">Error: C&oacute;digo</th>
					<th style="text-align: center;">Error: Mensaje</th>
				</tr>
			</thead>
			<tbody>
<?php 			foreach ( $transacciones as $trx ) {     ?>
					<tr onmouseover="this.style.background='#AAA';" onmouseout="this.style.background='#FFF';">
						<td align="center" class="active"><?= $trx["transaccionId"]; ?></td>
						<td align="center" class="active"><?= $trx["fecha_hora"]; ?></td>
						<td align="center" class="active"><?= $trx["tipo_transaccion"]; ?></td>
						<td align="center" class="active"><?= $trx["status"]; ?></td>
						<td>
<?php							
							if ( $trx["usuarioId"] != NULL && $trx["usuarioId"] != "" ){
								echo '<a href="javascript:verInfoTecnico(' . $trx["usuarioId"] . ');">Usuario id: ' . $trx["usuarioId"] . '</a><br/>';
							}
							if ( $trx["tecnicoId"] != NULL && $trx["tecnicoId"] != "" ){
								echo '<a href="javascript:verInfoTecnico(' . $trx["tecnicoId"] . ');">Ing. Soporte Id: ' . $trx["tecnicoId"] . '</a><br/>';
							}
							if ( $trx["managerId"] != NULL && $trx["managerId"] != "" ){
								echo '<a href="javascript:verInfoTecnico(' . $trx["managerId"] . ');">Partner Id: ' . $trx["managerId"] . '</a><br/>';
							}
							if ( $trx["adminId"] != NULL && $trx["adminId"] != "" ){
								echo '<a href="javascript:verInfoTecnico(' . $trx["adminId"] . ');">Admin Id: ' . $trx["adminId"] . '</a><br/>';
							}
							if ( $trx["developerId"] != NULL && $trx["developerId"] != "" ){
								echo '<a href="javascript:verInfoTecnico(' . $trx["developerId"] . ');">Developer Id: ' . $trx["developerId"] . '</a><br/>';
							}
							if ( $trx["equipoId"] != NULL && $trx["equipoId"] != "" ){
								echo '<a href="javascript:verInfoEquipo(' . $trx["equipoId"] . ');">Equipo Id: ' . $trx["equipoId"] . '</a><br/>';
							}
							if ( $trx["incidenciaId"] != NULL && $trx["incidenciaId"] != "" ){
								echo '<a href="javascript:verInfoIncidencia(' . $trx["incidenciaId"] . ');">Incidencia Id: ' . $trx["incidenciaId"] . '</a><br/>';
							}
							if ( $trx["solucionId"] != NULL && $trx["solucionId"] != "" ){
								echo '<a href="javascript:verDetalleSolucion(' . $trx["solucionId"] . ');">Solucion Id: ' . $trx["solucionId"] . '</a><br/>';
							}
							
?>
						</td>
						<td><?= $trx["info"]; ?></td>
						<td><?= $trx["error_tipo"]; ?></td>
						<td><?= $trx["error_codigo"]; ?></td>
						<td><?= $trx["error_mensaje"]; ?></td>
					</tr>

<?php 			}   ?>

			</tbody>
		</table>
	</div>

<?php
	}
?>


	<br/><br/><br/>

	<div class="row">
		<div class="col-sm-12" align="center">
			<br/><br/><br/>
			<h6>
				<?= $footer; ?>
			</h6>
		</div>
	</div>


<script>

	function toogleDisableID(id){
		
		var attr = $('#' + id).attr('disabled');

		/* For some browsers, `attr` is undefined; for others,
		 * `attr` is false.  Check for both.
		 */
		if ( typeof attr !== typeof undefined && attr !== false) {
			
			/* si lo tiene, hay que quitarlo */
			$("#" + id).removeAttr( 'disabled' );

		} else {

			/* NO lo tiene, hay que añadirlo */
			$("#" + id).attr( "disabled", "disabled" );
		}
	}

	$(document).ready(function() {
		$('#datePicker')
			.datepicker({
				autoclose: true,
				format: 'yyyy-mm-dd',
				startDate: '2017-01-01',
				endDate: '<?= date("Y-m-d"); ?>'
			})
			/*
			.on('changeDate', function(e) {
				// Revalidate the date field
				$('#eventForm').formValidation('revalidateField', 'date');
			});
			*/
			;

		$('#datePicker2').datepicker({
				autoclose: true,
				format: 'yyyy-mm-dd',
				startDate: '2017-01-01',
				endDate: '<?= date("Y-m-d"); ?>'
		});

		/*
		$('#eventForm').formValidation({
			framework: 'bootstrap',
			icon: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				name: {
					validators: {
						notEmpty: {
							message: 'The name is required'
						}
					}
				},
				date: {
					validators: {
						notEmpty: {
							message: 'The date is required'
						},
						date: {
							format: 'MM/DD/YYYY',
							message: 'The date is not a valid'
						}
					}
				}
			}
		});
		*/
	});

	function habilitarTodo(){
		$("#searched").removeAttr( 'disabled' );
		$("#companiesCombo").removeAttr( 'disabled' );
		$("#trx").removeAttr( 'disabled' );
		$("#fechaDesde").removeAttr( 'disabled' );
		$("#fechaHasta").removeAttr( 'disabled' );

		$("#transacciones_form").submit();
	}

	function verInfoTecnico(userId){

		$('#myModal').modal('show');

		/* valor en el input type hidden */
		document.getElementById("usuario_en_sistema_id").value = "" + userId;

		$("#feedback_title").html("Informaci&oacute;n del Usuario en el Sistema");

		$.ajax({
			type: "POST",
			url: modalAjaxURL,
			data: $('#buscarDataUsuario').serialize(),
			success: function(message){
				/*alert("OK_");*/
				/*$("#feedback-modal").modal('hide');*/
				$("#feedback").html(message);
			},
			error: function(){
				alert("Error al buscar info del Usuario en nuestro Sistema\nPor favor, intente más tarde");
			}
		});
	}

	function borrarInfo(){
		$("#feedback").html( "&nbsp;" );
		$("#feedback_title").html("&nbsp;");
	}

	function verInfoEquipo(){
		alert("FUTURE-FUNCTION: pendiente por crear");
	}

	/**
	 * 
	 */
	function verDetalleSolucion(resolucionId){

		document.getElementById("resolucionIncidenciaId").value = resolucionId;

		document.getElementById("resolucionIncidenciaForm").submit();
	}

	
	function verInfoIncidencia(id){

		$('#myModal').modal('show');

		/* valor en el input type hidden */
		document.getElementById("incidencia_id").value = "" + id;

		$("#feedback_title").html("Informaci&oacute;n de la Incidencia en el Sistema");

		$.ajax({
			type: "POST",
			url: modalAjaxURL2,
			data: $('#buscarDataUsuario').serialize(),
			success: function(message){
				/*alert("OK_");*/
				/*$("#feedback-modal").modal('hide');*/
				$("#feedback").html(message);
			},
			error: function(){
				alert("Error al buscar info de la Incidencia en nuestro Sistema\nPor favor, intente más tarde");
			}
		});
	}

	
</script>

</div>

<!-- ========================= Formulario para VER SOLUCION DE una incidencia  ================================== -->
<form id="resolucionIncidenciaForm" method="post" enctype="multipart/form-data" 
	action="<?= PROJECTURLMENU; ?>admin/ver_resolucion_incidencia">
	
		<input type="hidden" id="resolucionIncidenciaId" name="resolucionIncidenciaId" value="" />
</form>

<!-- ========================= Formulario para asignar incidencia ============================ -->
<form id="buscarDataUsuario" method="post" enctype="multipart/form-data">
	
	<input type="hidden" id="usuario_en_sistema_id" name="usuario_en_sistema_id" value="" />
	<input type="hidden" id="incidencia_id" 		name="incidencia_id" 		 value="" />

</form>

<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title" align="center">
			<span class="glyphicon glyphicon-info-sign"></span> 
			<div id="feedback_title"></div>
		  </h4>
		</div>

		<div class="modal-body">
		  <p><div id="feedback"></div></p>
		</div>

		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal" onclick="javascript:borrarInfo();">Cerrar</button>
		</div>
	  </div>
	</div>
</div>