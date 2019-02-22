<div class="container">
	
	<h4 style="text-align:center; color:#E30513;">
		<span class="glyphicon glyphicon-pencil logo slideanim"></span>
		<i>Nuevo(s) Reporte(s) de Visita</i>&nbsp;&nbsp;&nbsp;
	</h4>

	<div class="row" style="background-color:#F9B233;">
		<div class="col-sm-1" align="right">
			<b>Empresa:</b>
		</div>
		<div class="col-sm-8" align="left">
			<?php if ( isset($companyInfo) ){ echo $companyInfo; } ?>
		</div>
		<div class="col-sm-2" align="left">
			<a href="<?= PROJECTURLMENU; ?>tecnicos/generarReporte">No usar esta Empresa</a>
		</div>
	</div>

	<div class="row" style="background-color:#F9B233;">
		<div class="col-sm-1" align="right">
			<b>Direcci&oacute;n:</b>
		</div>
		<div class="col-sm-6" align="left">
			<?php if ( isset($empresaDireccion) ){ echo $empresaDireccion; } ?>
		</div>
		<div class="col-sm-4" align="right">
			<b>Cantidad de Equipos registrados en el Portal:</b>
		</div>
		<div class="col-sm-1" align="left">
			<?php if ( isset($empresaCantidadEquipos) ){ echo $empresaCantidadEquipos; } ?>
		</div>
	</div>

	<br/><br/>

	<form class="form-horizontal" data-toggle="validator" role="form" id="new_reporte_visita"
	 method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>tecnicos/crear_reporte_visita">

	 	<br/>
	 	<hr/>
	 	<br/>

	 	<input type="hidden" id="reporte_general_check" name="reporte_general_check" value="false" />

	 	<div id="reporte_general-div" class="form-group">
	 		<label class="control-label col-sm-3" for="reporte_general">Informe General</label>
			<div class="col-sm-9">
				<input type="checkbox" id="reporte_general" name="reporte_general" value="reporte_general"
				 onclick="javascript:toogleReporteGeneral();">
					seleccione este campo si ha de presentar <b>un informe por cada Equipo</b>,
					el cual ser&aacute; 1 reporte asociado al trabajo que ud. realiz&oacute;
					por su Visita a la Empresa.
					<br/><br/>
					En este caso se crear&aacute;n <b>
					<?php if ( isset($empresaCantidadEquipos) ){ echo $empresaCantidadEquipos; } ?> 
					</b> Reportes, <u>cada uno asociado a UN Equipo en Particular (exceptuando los Equipos con estatus SUSPENDIDO)</u>.
					<b>Para ver cu&aacute;ntos equipos est&aacute;n ACTIVOS</b> revise el campo de selecci&oacute;n creado abajo
					 ("Indique el Equipo que presenta fallas") y ah&iacute; podr&aacute; ver los equipos habilitados.
					<br/><br/>
					<b>Ser&aacute; su Responsabilidad llenar cada uno de los Formularios</b>,
					indicando su trabajo realizado en los mismos,
					ya sea <b>mantenimiento preventivo o correctivo</b>. 
					Esto es porque se generar&aacute;n los Reportes con <b>usted</b> como el 
					Ing. de Soporte encargado de llenar los formularios respectivos.
			</div>
		</div>

	 	<br/>
	 	<hr/>
	 	<br/>

		<div id="givenname-div" class="form-group">
			<label class="control-label col-sm-3" for="givenname">Usuario que necesita Soporte TI:</label>
			<div class="col-sm-7">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<select class="form-control" id="givenname" name="givenname" disabled="disabled">
						
						<option value="0">  --  Seleccione al Usuario afectado --  </option>
						
						<?php
							if ( isset($no_usuarios) ){

								echo "<option disabled>No hay Usuarios registrados</option>";

								unset($no_usuarios);

							} else {
								foreach ($usuarios as $usuario){
									echo '<option value="' . $usuario[0] . '">' . $usuario[3] . " " . $usuario[4] . '</option>';
								}
							}
						?>

					</select>
					<span id="givenname-span" class=""></span>
				</div>
			</div>
			<div class="col-sm-2">
				<div id="givenname-error" class="help-block">
					&nbsp;
				</div>
			</div>
		</div>
		
		<div class="form-group"><div class="col-sm-12" align="center">&oacute;</div></div>

		<div id="equipos-div" class="form-group">
			<label class="control-label col-sm-3" for="equipos">Indique el Equipo que presenta fallas:</label>
			<div class="col-sm-7">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-blackboard"></i></span>
					<select class="form-control" id="equipo" name="equipo">
						
						<option value="0">  --  Seleccione uno de los Equipos --  </option>

						<optgroup label="Equipos de esta Empresa">

						<?php
							if ( isset($no_equipos) ){

								echo "<option disabled>Empresa No posee equipos registrados</option>";

								unset($no_equipos);

							} else {
								$aux = "";

								foreach ( $equipos as $equipo ){
									
									$aux = "COD:" . $equipo["codigoBarras"];
									
									if ( $equipo["infoBasica"] != NULL && $equipo["infoBasica"] != "" ){
										$aux .= " - " . $equipo["infoBasica"];
									}
									echo '<option value="' . $equipo["id"] . '">' . $aux . '</option>';
								}
							}
						?>

						</optgroup>

					</select>
					<span id="equipos-span" class=""></span>
				</div>
			</div>
			<div class="col-sm-2">
				<div id="equipos-error" class="help-block">
					&nbsp;
				</div>
			</div>
		</div>

		<br/>
	 	<hr/>
	 	<br/>

		<div id="cantidad-div" class="form-group">
			<label class="control-label col-sm-3" for="cantidad">Cantidad de Reportes a crear:</label>
			<div class="col-sm-7">

				<div class="input-group">
					<span class="input-group-btn">
					  	<button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
							<span class="glyphicon glyphicon-minus"></span>
						</button>
					</span>
					
					<input type="hidden" id="quantity"  name="quantity"  value="" />
					<input type="hidden" id="empresaID" name="empresaID" value="<?= $searchedCompanyId; ?>" />

					<input type="text" name="quant[1]" id="quant" class="form-control input-number" value="1" min="1" max="3" disabled="disabled">
					<span class="input-group-btn">
						<button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
							<span class="glyphicon glyphicon-plus"></span>
						</button>
					</span>
				</div>

			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-3 col-sm-7">
				Puede generar entre 1 y 3 Reportes de Visita (SOLO PARA ESTE EQUIPO o USUARIO);
				 y todos quedar&aacute;n asociados
				a Usted como el Ingeniero de Soporte <b>responsable de llenar estos reportes</b>.
				<br/><br/>
				<u>Recuerde</u>: estos Reportes se manejar&aacute;n como se manejan las Incidencias,
				por lo que cuando haga el informe de su trabajo <b>tendr&aacute; que llenar 
				el mismo formato usado para <i>resolver Incidencias</i></b>.
			</div>
		</div>

		<div id="fecha-div" class="form-group">
			<label class="control-label col-sm-3" for="fecha">Fecha:</label>
			<div class="col-sm-7">
				<div class="input-group">
					<p class="form-control-static">
					<span id="fecha" class="glyphicon glyphicon-calendar">
						<?= date("d/m/Y"); ?> (hoy)
					</span>
					</p>
				</div>
			</div>
			<div class="col-sm-2">
				<div id="fecha-error" class="help-block">
					&nbsp;
				</div>
			</div>
		</div>

		<div id="tech-div" class="form-group">
			<label class="control-label col-sm-3" for="tech">Ing. de Soporte responsable:</label>
			<div class="col-sm-7" style="padding-top: 5px;">
				<i>Usted</i>. ( <?= $_SESSION['logged_user_saludo']; ?> )
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-12" align="center">
				
				<button id="accept" type="button" class="btn btn-primary btn-lg" onclick="javascript:crear();"
				 data-toggle="tooltip" data-placement="bottom" title="Se procederá a crear Reportes de Visita para esta Empresa">
				   <span class="glyphicon glyphicon-edit"></span> Crear Reportes de Visita para esta Empresa </button>

			</div>
		</div>

	</form>
</div>

<?php
	if ( isset($empresaCantidadEquipos) ){ 
		echo "<script>";
		echo 	" var empresaCantidadEquipos = " . $empresaCantidadEquipos . ";";
		echo "</script>";
	}
?>
<script>
	
	$('.btn-number').click(function(e){
	    e.preventDefault();
	    
	    fieldName = $(this).attr('data-field');
	    type      = $(this).attr('data-type');

	    var input = $("input[name='"+fieldName+"']");
	    var currentVal = parseInt(input.val());

	    if (!isNaN(currentVal)) {
	        if(type == 'minus') {
	            
	            if ( currentVal > input.attr('min')) {
	            	/* Cambia el valor */
	                input.val(currentVal - 1).change();
	            }

	            if ( parseInt(input.val()) == input.attr('min') ){
	            	/* desahbilita el boton */
	                $(this).attr('disabled', true);
	            }

	        } else if(type == 'plus') {

	            if(currentVal < input.attr('max')) {
	            	/* Cambia el valor */
	                input.val(currentVal + 1).change();
	            }

	            if(parseInt(input.val()) == input.attr('max')) {
	            	/* desahbilita el boton */
	                $(this).attr('disabled', true);
	            }
	        }
	    } else {
	        input.val(0);
	    }
	});


	$('.input-number').focusin(function(){
	   $(this).data( 'oldValue', $(this).val() );
	});


	$('.input-number').change(function() {
	    
	    minValue 	 = parseInt($(this).attr('min'));
	    maxValue 	 = parseInt($(this).attr('max'));
	    valueCurrent = parseInt($(this).val());
	    
	    name = $(this).attr('name');

	    if ( valueCurrent >= minValue) {
	    	/* desahbilita el boton */
	        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');

	    } else {
	        alert('Sorry, el valor minimo fue alcanzado');
	        $(this).val($(this).data('oldValue'));
	    }

	    if ( valueCurrent <= maxValue) {
	    	/* desahbilita el boton */
	        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');

	    } else {
	        alert('Sorry, el valor MAXIMO fue alcanzado');
	        $(this).val($(this).data('oldValue'));
	    }
	    
	});


	$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

	function crear(){

		var comboUser   = parseInt( $("#givenname").val() );
		var comboEquipo = parseInt( $("#equipo").val() );

		var bCheck = $("#reporte_general").is(':checked');

		var cantidad = 0;

		if ( (comboUser + comboEquipo == 0) && (bCheck == false) ){
			alert("Debe elegir un Usuario y/o un Equipo sobre los cuales trabajó en su visita a la Empresa"
					+ "\n\n\nO en su defecto crear un Reporte de Visita");
			return false;

		} else {

			if ( bCheck == true ){
				cantidad = empresaCantidadEquipos;
			} else {
				cantidad = $("#quant").val() ;
			}
			
			var ask = confirm("Se procederá a crear " 
					+ cantidad 
					+ " Reporte(s) de Visita para esta Empresa con Usted como Ingeniero de Soporte encargado de llenar la información necesaria."
					+ "\n\n\n ¿Desea continuar?"
					+ "\n\n\n (Podrá ver los Reportes en el listado de Sus Incidencias Pendientes)");

			if ( ask == true) {
				$("#quantity").val( cantidad );

				$("#givenname").removeAttr( 'disabled' );
				$("#equipo").removeAttr( 'disabled' );

				document.getElementById("new_reporte_visita").submit();
			} else {
				return false;
			}
		}
	}

	/**
	 * toogle los combos
	 */
	var check_reporte = false;
	function toogleReporteGeneral(){

		if ( check_reporte == false ){
			/*
			 * Se creará un reporte General
			 */
			check_reporte = true;

			/* $('#givenname').prop('disabled', true); */
			$('#equipo').prop('disabled', true);

			$('#reporte_general_check').val("true");

		} else {
			/* Reporte por Equipo o Usuario */
			check_reporte = false;

			/* $('#givenname').prop('disabled', false); */
			$('#equipo').prop('disabled', false);

			$('#reporte_general_check').val("false");
		}
	}

</script>
