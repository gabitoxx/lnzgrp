<div class="container col-sm-12 well well-lg">

  <form class="form-horizontal" data-toggle="validator" role="form" id="update_company_form"
	  method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>admin/update_company">
	

	<input type="hidden" id="idEmpresaAEditar" name="idEmpresaAEditar" value="<?= $idEmpresaAEditar; ?>" />

	<hr/>
	<h4 style="text-align:center; color:#E30513;">
		<span class="glyphicon glyphicon-briefcase logo slideanim"></span>
		<i>Datos de la Empresa</i>&nbsp;&nbsp;&nbsp;</h4>

	

	  <div id="company-div" class="form-group">
		<label class="control-label col-sm-3" for="company" align="right">Nombre de la Empresa:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
				<input type="text" class="form-control" id="company" name="company" value="<?= $empresa->nombre ?>" required="required" 
				 placeholder="El nombre de la Empresa donde labora" onblur="javascript:cambio();">
				<span id="company-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="company-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="company_razon-div" class="form-group">
		<label class="control-label col-sm-3" for="company_razon" align="right">Raz&oacute;n Social de la Empresa:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-file"></i></span>
				<input type="text" class="form-control" id="company_razon" name="company_razon" onblur="javascript:cambio();" 
				 placeholder="Raz&oacute;n Social de la Empresa (OPCIONAL)" value="<?= $empresa->razonSocial ?>" >
				<span id="company_razon-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="company_razon-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="company_nit-div" class="form-group">
		<label class="control-label col-sm-3" for="company_nit" align="right">NIT:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-text-background"></i></span>
				<input type="text" class="form-control" id="company_nit" name="company_nit"
				 placeholder="NIT (OPCIONAL)" value="<?= $empresa->NIT ?>" onblur="javascript:cambio();">
				<span id="company_nit-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="company_nit-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="company_pais-div" class="form-group">
		<label class="control-label col-sm-3" for="company_pais" align="right">Pa&iacute;s</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
				<select class="form-control" id="company_pais" name="company_pais" onblur="javascript:cambio();">
					<option value="none" disabled="disabled">  --  Seleccione Pa&iacute;s --  </option>
					<?php 
						$fileLocation = 'ComboCountries.php';
						include( $fileLocation );
					?>
				</select>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="company_pais-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="company_estados-div" class="form-group">
		<label class="control-label col-sm-3" for="company_estados" align="right">Departamento / Estado:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
				<select class="form-control" id="company_estados" name="company_estados" onblur="javascript:cambio();">
					<option value="none">  --  Seleccione Departamento --  </option>
					<?php 
						$fileLocation = 'ComboDepartamentos.php';
						include( $fileLocation );
					?>
				</select>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="company_estados-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="company_city-div" class="form-group">
		<label class="control-label col-sm-3" for="company_city" align="right">Ciudad:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
				<input type="text" class="form-control" id="company_city" name="company_city" value="<?= $empresa->ciudad ?>" 
				 placeholder="Indique Ciudad  (OPCIONAL)" onblur="javascript:cambio();">
				<span id="company_city-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="company_city-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="company_direccion-div" class="form-group">
		<label class="control-label col-sm-3" for="company_direccion" align="right">Direcci&oacute;n:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
				<input type="text" class="form-control" id="company_direccion" name="company_direccion" value="<?= $empresa->direccion ?>" required="required" 
				 placeholder="Calle con Karrera, Edificio, Piso, Oficina y/o puntos de referencia" onblur="javascript:cambio();">
				<span id="company_direccion-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="company_direccion-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="company_web-div" class="form-group">
		<label class="control-label col-sm-3" for="company_web" align="right">P&aacute;gina Web oficial:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span>
				<input type="text" class="form-control" id="company_web" name="company_web" value="<?= $empresa->paginaWeb ?>" 
				 placeholder="P&aacute;gina Web oficial (OPCIONAL)" onblur="javascript:cambio();">
				<span id="company_web-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="company_web-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="company_email-div" class="form-group">
		<label class="control-label col-sm-3" for="company_email" align="right">Correo Empresarial:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				<input type="text" class="form-control" id="company_email" name="company_email" value="<?= $empresa->email ?>" 
				 onblur="javascript:cambio();return false;"
				 placeholder="Correo Corporativo (OPCIONAL)">
				<span id="company_email-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="company_email-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="company_pbx-div" class="form-group">
		<label class="control-label col-sm-3" for="company_pbx" align="right">PBX / Tel&eacute;fono de Trabajo:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
				<input type="text" class="form-control" id="company_pbx" name="company_pbx" value="<?= $empresa->PBX ?>" 
				 placeholder="Tel&eacute;fono central de la Empresa o PBX (OPCIONAL)" onblur="javascript:cambio();">
				<span id="company_pbx-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="company_pbx-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <br/><br/>

	  <div class="form-group"> 
		<div class="col-sm-offset-3 col-sm-3" align="center">
			<button type="button" class="btn btn-primary btn-lg" onclick="javascript:submitForm2();"
			 data-toggle="tooltip" data-placement="left" title="Actualizar la info de Perfil de la Empresa">
				<span class="glyphicon glyphicon-edit"></span> Actualizar Datos de Empresa </button>
		</div>
		<div class="col-sm-4">
			<button type="button" class="btn btn-info btn-lg" type="reset" onclick="javascript:goHome();"
			 data-toggle="tooltip" data-placement="bottom" title="NO hacer Cambios">
			  <span class="glyphicon glyphicon-home"></span> Cancelar </button>
		</div>
	  </div>

  </form>

</div>

<br/><br/><br/><br/>

<?php
	echo "<script>";
	echo "   var paisSinCambiar = '" . $empresa->pais . "';" ;
	echo "   var citySinCambiar = '" . $empresa->departamento_Estado . "';" ;
	echo "   var gohome = '" . PROJECTURLMENU . "admin/home';" ;
	echo "</script>";
?>

<script>
	
	var algunCambioRealizado  = false;

	function cambio(){
		algunCambioRealizado  = true;		
	}

	function goHome(){
		location.href = gohome;
	}

	/*
	 * Seleccionar el pais segun el codigo inicial del campo celular
	 */
	function direccionEmpresaSetear(){

		var sel = document.getElementById("company_pais");

		for(var i = 0, j = sel.options.length; i < j; i++) {
			if(sel.options[i].value === paisSinCambiar ) {
			   sel.selectedIndex = i;
			   break;
			}
		}

		var sel2 = document.getElementById("company_estados");

		for(var i = 0, j = sel2.options.length; i < j; i++) {
			if(sel2.options[i].value === citySinCambiar ) {
			   sel2.selectedIndex = i;
			   break;
			}
		}
	}
	direccionEmpresaSetear();

	function submitForm2(){
		
		var bool = true;
		var scrollElement = "";
		var scrolled = false;

		if ( $("#company").val() == "" || $("#company").val().length < 2 ){
			
			bool = false;
			
			document.getElementById("company-div").className = "form-group has-error has-feedback";
			document.getElementById("company-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("company-error").innerHTML = "No puede ser vacío";
		}

		if ( $("#company_direccion").val() == "" ){
			
			bool = false;
			
			document.getElementById("company_direccion-div").className = "form-group has-error has-feedback";
			document.getElementById("company_direccion-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("company_direccion-error").innerHTML = "No puede ser vacío";
		}

		

		if ( $("#company_email").val() != "" && !validarEmail( $("#company_email").val() ) ){
			bool = false;
			
			document.getElementById("company_email-div").className = "form-group has-error has-feedback";
			document.getElementById("company_email-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("company_email-error").innerHTML = "Email Corp. NO válido";
		}

		if ( bool == true && algunCambioRealizado == true ){

			var ask = confirm("¿Desea cambiar los datos de la Empresa con la información aquí suministrada?");
			if ( ask == true) {

				/* submit POST enviando formulario */
				document.getElementById("update_company_form").submit();

				return true;
			} else {
				return false;
			}
		} else if ( !algunCambioRealizado ){
			alert("NO ha realizado cambios que ameriten ser salvados.");

		} else {
			return false;
		}

	}

	function validarEmail(valor) {

		if (/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i.test(valor)){
			// alert("La dirección de email " + valor + " es correcta.");
			return true;
		} else {
			/* alert("La dirección de email " + valor + " es incorrecta."); * /
			document.getElementById("correo").focus();
			document.getElementById("correo").style = "border:1px solid #CB2027;";
			*/
			return false;
		}
	}

</script>


<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog modal-sm">
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title" align="center" style="color:#E30513;">
			<span class="glyphicon glyphicon-pencil"></span> 
			Informaci&oacute;n:
		  </h4>
		</div>

		<div class="modal-body">
		  <p>
			<?php
				if ( isset( $updated_info ) ){
					echo $updated_info;
				}
			?>
		  </p>
		</div>

		<div class="modal-footer">
		  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		</div>
	  </div>
	</div>
</div>

<?php
	echo "<script>";
	if ( isset( $updated_info ) ){
		
		echo " $('#myModal').modal('show'); ";

		unset( $updated_info );
	}
	echo "</script>";
?>
