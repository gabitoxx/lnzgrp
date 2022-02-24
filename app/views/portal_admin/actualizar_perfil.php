<div class="container col-sm-12 well well-lg">

  <form class="form-horizontal" data-toggle="validator" role="form" id="new_user_form"
	  method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>admin/actualizar_info_form">
	
	<h4 style="text-align:center; color:#E30513;">
		<span class="glyphicon glyphicon-user logo slideanim"></span>
		<i>Datos de la Persona</i>&nbsp;&nbsp;&nbsp;</h4>
		
	  <input type="hidden" id="idUsuarioAEditar" name="idUsuarioAEditar" value="<?= $idUsuarioAEditar; ?>" />

	  <div id="greetings-div" class="form-group">
		<label class="control-label col-sm-3" for="greetings">Saludo:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
				<select class="form-control" id="greetings" name="greetings" onblur="javascript:validar('greetings');return false;">
					<!-- optgroup label="Picnic" -->
					<?php
						$a = $usuario->saludo;
					?>
					<!-- option value="none">  --  Seleccione una opci&oacute;n --  </option -->
					<option value="Sr." 	<?php if($a=="Sr.")		echo 'selected="selected"'; ?> >Sr.</option>
					<option value="Sra." 	<?php if($a=="Sra.")	echo 'selected="selected"'; ?> >Sra.</option>
					<option value="Srita." 	<?php if($a=="Srita.")	echo 'selected="selected"'; ?> >Srita.</option>
					<option value="Dr." 	<?php if($a=="Dr.")		echo 'selected="selected"'; ?> >Dr.</option>
					<option value="Dra." 	<?php if($a=="Dra.")	echo 'selected="selected"'; ?> >Dra.</option>
					<option value="Phd." 	<?php if($a=="Phd.")	echo 'selected="selected"'; ?> >Phd.</option>
					<option value="Ing." 	<?php if($a=="Ing.")	echo 'selected="selected"'; ?> >Ing.</option>
					<option value="Lic." 	<?php if($a=="Lic.")	echo 'selected="selected"'; ?> >Lic.</option>
				</select>
				<span id="greetings-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="greetings-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>


	  <div id="givenname-div" class="form-group">
		<label class="control-label col-sm-3" for="givenname">Nombre:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				<input type="text" class="form-control" id="givenname" name="givenname" placeholder="Su Nombre" required="required"
				 onblur="javascript:validar('givenname');return false;" value="<?= $usuario->nombre ?>">
				<span id="givenname-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="givenname-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>


	  <div id="lastname-div" class="form-group">
		<label class="control-label col-sm-3" for="lastname">Apellido:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-font"></i></span>
				<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Su Apellido" required="required"
				 onblur="javascript:validar('lastname');return false;" value="<?= $usuario->apellido ?>">
				<span id="lastname-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="lastname-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>


	  <div id="gender-div" class="form-group">
		<label class="control-label col-sm-3" for="gender">G&eacute;nero:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<?php
					$a = $usuario->gender;
				?>
				<label class="radio-inline">
					<input type="radio" name="gender" id="gender1" value="Masculino" 
					 <?php if($a=="Hombre") echo 'checked="true"'; ?>
					 >Masculino
				</label>
				<label class="radio-inline">
					<input type="radio" name="gender" id="gender2" value="Femenino"
					<?php if($a=="Mujer") echo 'checked="true"'; ?>
					>Femenino
				</label>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="gender-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="birthday-div" class="form-group">
		<label class="control-label col-sm-3" for="birthday" style="margin-top: 35px;">Cumpleaños:</label>
		<div class="col-sm-3">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-gift"></i></span>
				
				<select class="form-control" id="birth_day" name="birth_day" onblur="javascript:validar('birth_day');return false;">
					<option value="none"> -- Seleccione día -- </option>
<?php
					
					$aux = $user->cumpleanos;
					$a = 0;
					$b = "none";
					$c = 0;

					if ( $aux != NULL && $aux != "" ){
						$c = substr( $aux , 8 , 2 );
						$b = substr( $aux , 5 , 2 );
						$a = substr( $aux , 0 , 4 );
					}

					for ( $i = 1; $i <= 31; $i++ ){
						echo '<option value="'.$i.'"';
						if ($c == $i) echo 'selected="selected"';
						echo '>'.$i.'</option>';
					}
?>
				</select>

				<select class="form-control" id="birth_mes" name="birth_mes" onblur="javascript:validar('birth_mes');return false;">
					<option value="none"> -- Seleccione mes -- </option>
					<option value="Enero" 		<?php if($b==1)	echo 'selected="selected"'; ?> >Enero</option>
					<option value="Febrero" 	<?php if($b==2)	echo 'selected="selected"'; ?> >Febrero</option>
					<option value="Marzo" 		<?php if($b==3)	echo 'selected="selected"'; ?> >Marzo</option>
					<option value="Abril" 		<?php if($b==4)	echo 'selected="selected"'; ?> >Abril</option>
					<option value="Mayo" 		<?php if($b==5)	echo 'selected="selected"'; ?> >Mayo</option>
					<option value="Junio" 		<?php if($b==6)	echo 'selected="selected"'; ?> >Junio</option>
					<option value="Julio" 		<?php if($b==7)	echo 'selected="selected"'; ?> >Julio</option>
					<option value="Agosto" 		<?php if($b==8)	echo 'selected="selected"'; ?> >Agosto</option>
					<option value="Septiembre" 	<?php if($b==9)	echo 'selected="selected"'; ?> >Septiembre</option>
					<option value="Octubre" 	<?php if($b==10)	echo 'selected="selected"'; ?> >Octubre</option>
					<option value="Noviembre" 	<?php if($b==11)	echo 'selected="selected"'; ?> >Noviembre</option>
					<option value="Diciembre" 	<?php if($b==12)	echo 'selected="selected"'; ?> >Diciembre</option>
				</select>

				<select class="form-control" id="birth_year" name="birth_year" onblur="javascript:validar('birth_year');return false;">
					<option value="none"> -- Seleccione año (opcional) -- </option>
<?php
					$d = date('Y');
					$e = 1912;

					for ( $i = $d; $i >= $e; $i-- ){
						echo '<option value="'.$i.'"';
						if ($i == $a) echo 'selected="selected"';
						echo '>'.$i.'</option>';
					}
?>
				</select>
				<span id="birthday-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-6">
			<div id="birthday-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>


		<hr/>
		<h4 style="text-align:center; color:#E30513;">
			<span class="glyphicon glyphicon-thumbs-up logo slideanim"></span>
			<i>Datos de la Cuenta</i>&nbsp;&nbsp;&nbsp;</h4>

	  <div id="email-div" class="form-group">
		<label class="control-label col-sm-3" for="email">Correo electr&oacute;nico:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				<input type="email" class="form-control" id="email" name="email" placeholder="Email principal o de trabajo" value="<?= $usuario->email ?>" 
				 required="required" data-validate="true"
				 onblur="javascript:validar('email');return false;"
				 data-toggle="tooltip" data-placement="bottom" title="Preferiblemente su correo Empresarial, donde podamos contactarlo en el Trabajo">
				<span id="email-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="email-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="username-div" class="form-group">
		<label class="control-label col-sm-3" for="username">
			Usuario:
			<br/>
			<h6>NO se puede modificar</h6>
		</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-magnet"></i></span>
				<input type="text" class="form-control" id="username" name="username" required="required" value="<?= $usuario->usuario ?>" disabled="disabled"  style="background-color:#CCC;">
				<span id="username-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="username-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>
	  
	<div style="background-color: #AAD;">
	  <div id="pwdActual-div" class="form-group">
		<label class="control-label col-sm-3" for="pwdActual">
			Contrase&ntilde;a Actual:
			<br/>
			<h6>Llenar SOLO si la desea cambiar la clave actual</h6>
		</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-copyright-mark"></i></span> 
				<input type="password" class="form-control" id="pwdActual" name="pwdActual" placeholder="SOLO en caso que desee CAMBIAR su clave ACTUAL"
				 onblur="javascript:validar('pwdActual');return false;">
				<!-- div class="help-block">Entre 1 y 6 caracteres AlfaNum&eacute;ricos</div -->
				<span id="pwdActual-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="pwdActual-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="pwd-div" class="form-group">
		<label class="control-label col-sm-3" for="pwd">
			Contrase&ntilde;a Nueva:
			<br/>
			<h6>Llenar ambos campos (solo en caso de cambio)</h6>
		</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-copyright-mark"></i></span> 
				<input type="password" class="form-control" id="pwd" name="pwd" placeholder="M&aacute;s de 6 caracteres alfanum&eacute;ricos"
				 onblur="javascript:validar('pwd');return false;">
				<!-- div class="help-block">Entre 1 y 6 caracteres AlfaNum&eacute;ricos</div -->
				<span id="pwd-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="pwd-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>


	  <div id="pwdrepited-div" class="form-group">
		<label class="control-label col-sm-3" for="pwd">Repetir Contrase&ntilde;a Nueva:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-registration-mark"></i></span> 
				<input type="password" class="form-control" id="pwdrepited" name="pwdrepited" placeholder="Repita su contrase&ntilde;a NUEVA"
				  onblur="javascript:validar('pwdrepited');return false;">
				<span id="pwdrepited-span" class=""></span>
				<!-- div class="help-block">Repita su contrase&ntilde;a</div -->
			</div>
		</div>
		<div class="col-sm-2">
			<div id="pwdrepited-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>	  
	</div>

	  <div id="dependencia-div" class="form-group">
		<label class="control-label col-sm-3" for="dependencia">Dependencia:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-tower"></i></span>
				<input type="text" class="form-control" id="dependencia" name="dependencia" placeholder="Dependencia dentro de la Empresa" required="required" value="<?= $usuario->dependencia ?>" 
				 onblur="javascript:validar('dependencia');return false;"
				 data-toggle="tooltip" data-placement="bottom" title="Gerencia, RRHH, Contabilidad, Operaciones, ...">
				<span id="dependencia-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="dependencia-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>


		<hr/>
		<h4 style="text-align:center; color:#E30513;">
			<span class="glyphicon glyphicon-phone-alt logo slideanim"></span>
			<i>Datos de Contacto</i>&nbsp;&nbsp;&nbsp;</h4>


	<?php
		$a = $usuario->celular;
		$length = strlen($a);

		/* campo celular */
		$code = substr($a, 0, 3);
		echo "<script> var code_country = \"" . $code . "\" ; </script>";

		/* quitando extension */
		if ( substr($a, 0, 3) === "+57" || substr($a, 0, 3) === "+58" ){
			$a = substr($a, 3, $length );
		}
	?>
	  <div id="phone_cell-div" class="form-group">
		<label class="control-label col-sm-3" for="phone_cell">Celular:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
				<select class="form-control" id="cellphone_code" name="cellphone_code">
					<!-- optgroup label="Picnic" -->
					<option value="none">  --  Seleccione c&oacute;digo de Pa&iacute;s --  </option>
					<?php 
						$fileLocation = 'ComboPaises.php';
						include( $fileLocation );
					?>
				</select>
				<input type="text" class="form-control" id="phone_cell" name="phone_cell" placeholder="OBLIGATORIO: N&uacute;mero de contacto v&iacute;a Celular, por ejemplo 314 1234567" required="required"
				  onblur="javascript:validar('phone_cell');return false;" value="<?= $a ?>" >
				<span id="phone_cell-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="phone_cell-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>


	  <div id="phone_home-div" class="form-group">
		<label class="control-label col-sm-3" for="phone_home">Tel&eacute;fono de Casa:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
				<input type="text" class="form-control" id="phone_home" name="phone_home" placeholder="Si lo desea"
				 onblur="javascript:validar('phone_home');return false;" value="<?= $usuario->telefonoCasa ?>" >
				<span id="phone_home-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="phone_home-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>


	  <div id="phone_work-div" class="form-group">
		<label class="control-label col-sm-3" for="phone_work">Tel&eacute;fono de Trabajo:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
				<input type="text" class="form-control" id="phone_work" name="phone_work" placeholder="OBLIGATORIO: N&uacute;mero de contacto en su puesto de Trabajo" required="required"
				 onblur="javascript:validar('phone_work');return false;" value="<?= $usuario->telefonoTrabajo ?>" >
				<span id="phone_work-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="phone_work-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>


	  <div id="phone_work_ext-div" class="form-group">
		<label class="control-label col-sm-3" for="phone_work_ext">Extensi&oacute;n:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-object-align-left"></i></span>
				<input type="text" class="form-control" id="phone_work_ext" name="phone_work_ext" placeholder="Extensi&oacute;n (de ser necesario)"
				 onblur="javascript:validar('phone_work_ext');return false;" value="<?= $usuario->extensionTrabajo ?>" >
				<span id="phone_work_ext-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="phone_work_ext-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

 <!-- legend> Personal Information </legend -->

	  <div class="form-group">

		<div class="col-sm-3">
		  <button type="button" class="btn btn-primary btn-lg" onclick="javascript:submitForm();"
		   data-toggle="tooltip" data-placement="bottom" title="S&iacute;, deseo Actualizar info">
			<span class="glyphicon glyphicon-edit"></span> Actualizar Datos </button>
		</div>

		<div class="col-sm-3">
			<button type="button" class="btn btn-danger btn-lg" type="reset" onclick="javascript:deleteUser(<?= $idUsuarioAEditar; ?>);"
			 data-toggle="tooltip" data-placement="bottom" title="ELIMINAR Usuario, NO podr&aacute; ser reactivado, quedar&aacute; con fines hist&oacute;ricos"
<?php
			if ( $usuario->activo == "eliminado" ){ echo ' disabled="disabled" '; }
?>
			 >
			  <span class="glyphicon glyphicon-remove"></span> Eliminar Usuario </button>
		</div>

		<div class="col-sm-3">
<?php
			if ( $usuario->activo == "activo" ){
?>			
				<button type="button" class="btn btn-warning btn-lg" type="reset" onclick="javascript:inactivateUser(<?= $idUsuarioAEditar; ?>);"
				 data-toggle="tooltip" data-placement="bottom" title="INACTIVAR el Usuario, podr&aacute; ser Activado despu&eacute;s">
				  <span class="glyphicon glyphicon-minus-sign"></span> Inactivar Usuario </button>
<?php
			} else {
?>
				<button type="button" class="btn btn-success btn-lg" type="reset" onclick="javascript:activateUser(<?= $idUsuarioAEditar; ?>);"
				 data-toggle="tooltip" data-placement="bottom" title="ACTIVAR el Usuario, podr&aacute; ser Inactivado despu&eacute;s">
				  <span class="glyphicon glyphicon-ok-sign"></span> Activar Usuario </button>
<?php 		}  ?>
		</div>

		<div class="col-sm-3">
			<button type="button" class="btn btn-info btn-lg" type="reset" onclick="javascript:goHome();"
			 data-toggle="tooltip" data-placement="bottom" title="NO hacer Cambios">
			  <span class="glyphicon glyphicon-home"></span> Cancelar </button>
		</div>

	  </div>
  </form>
</div>

<br/><br/><br/><br/>

<!-- ========================= Formulario para usar AJAX .:. Validacion Campos ============================ -->
<?php
	echo "<script>";
	echo "   var modalAjaxURL = '" . PROJECTURLMENU . "UserAuthentication/validar_campos_no_repetidos';" ;
	echo "   var gohome = '" . PROJECTURLMENU . "admin/home';" ;
	echo "   var emailSinCambiar = '" . $usuario->email . "';" ;
	echo "</script>";
?>
<form id="validarCamposForm" method="post" enctype="multipart/form-data">
	<input type="hidden" id="campoAvalidar" name="campoAvalidar" value="" />
	<input type="hidden" id="valorAvalidar" name="valorAvalidar" value="" />
</form>

<!-- ========================================================================================================== -->

<script>

	var campoRepetidoEmail 	  = false;
	var campoRepetidoUsername = false;
	var algunCambioRealizado  = false;

	function goHome(){
		location.href = gohome;
	}

	function deleteUser(usuarioId){
		location.href = "<?= PROJECTURLMENU; ?>admin/borrar/persona/borrar/" + usuarioId;
	}

	function inactivateUser(usuarioId){
		location.href = "<?= PROJECTURLMENU; ?>admin/borrar/persona/inactivar/" + usuarioId;
	}

	function activateUser(usuarioId){
		location.href = "<?= PROJECTURLMENU; ?>admin/borrar/persona/activar/" + usuarioId;
	}

	/*
	 * Seleccionar el pais segun el codigo inicial del campo celular
	 */
	function codeCountry(){

		var sel = document.getElementById("cellphone_code");

		for(var i = 0, j = sel.options.length; i < j; i++) {
			/* if(sel.options[i].innerHTML === val) { */
			if(sel.options[i].value === code_country ) {
			   sel.selectedIndex = i;
			   break;
			}
		}
	}

	codeCountry();

	function validar(elementId){

		algunCambioRealizado  = true;

		/* alert( document.getElementById(elementId).value );  */
		/* alert( $("#" + elementId).val() ); */

		var bError = false;
		var sErrorMessage = "";

		var valor = $("#" + elementId).val();

		/**
		 * Manejando todos los campos del formulario
		 * Longitud > 2
		 * No numericos
		 */
		if ( elementId == "givenname" ){
			if ( valor.length < 2 ){
				bError = true;
				sErrorMessage = "Longitud m&iacute;nima de Nombre es 2";
			}
			else if ( isNumber( valor ) ){
				bError = true;
				sErrorMessage = "El Nombre no puede contener N&uacute;meros";
			}
		}
		else if ( elementId == "lastname" ){
			if ( valor.length < 2 ){
				bError = true;
				sErrorMessage = "Longitud m&iacute;nima de Apellido es 2";
			}
			else if ( isNumber( valor ) ){
				bError = true;
				sErrorMessage = "El Apellido no puede contener N&uacute;meros";
			}
		}
		else if ( elementId == "dependencia" ){
			if ( valor.length < 2 ){
				bError = true;
				sErrorMessage = "Longitud m&iacute;nima de Dependencia es 2";
			}
			else if ( isNumber( valor ) ){
				bError = true;
				sErrorMessage = "La Dependencia no puede ser solo N&uacute;meros";
			}
		}

		/* email */
		else if ( elementId == "email" && !validarEmail(valor) ){
			bError = true;
			sErrorMessage = "Email NO v&aacute;lido";
		}

		/* Seleccionar combo box */
		else if ( elementId == "greetings" && valor == "none" ){
			bError = true;
			sErrorMessage = "Seleccione una opci&oacute;n";
		}

		/* username */
		else if ( elementId == "username" ){
			if ( valor.length < 6 ){
				bError = true;
				sErrorMessage = "Longitud m&iacute;nima de nombre de Usuario es 6";
			}
		}

		/* contrasenas */
		else if ( elementId == "pwdActual"){
			if ( valor.length < 6 ){
				bError = true;
				sErrorMessage = "Longitud m&iacute;nima de Contrase&ntilde;a es 6";
			}
		} else if ( elementId == "pwd"){
			if ( valor.length < 6 ){
				bError = true;
				sErrorMessage = "Longitud m&iacute;nima de Contrase&ntilde;a es 6";
			}

		} else if (elementId == "pwdrepited" ){
			if ( valor != $("#pwd").val() ){
				bError = true;
				sErrorMessage = "Contrase&ntilde;as NO coinciden";
			}
		}

		/* Telefonos */
		else if ( elementId == "phone_cell"){
			
			var numero = parseInt(valor); /* 314 1234567 */
			
			if ( !isNumber( valor ) ){
				bError = true;
				sErrorMessage = "El Celular debe ser solo Num&eacute;rico, sin guiones, espacios ni puntos";
			} else if ( numero < 3000000000 || numero > 3999999999 ){
				bError = true;
				sErrorMessage = "Parece NO estar correcto. Revise nuevamente";
			}
		} else if (elementId == "phone_home" ){
			if ( !isNumber( valor ) && valor != "" ){
				bError = true;
				sErrorMessage = "El Tel&eacute;fono de Casa debe ser solo Num&eacute;rico";
			}
		} else if (elementId == "phone_work" ){
			if ( !isNumber( valor ) ){
				bError = true;
				sErrorMessage = "El Tel&eacute;fono de Trabajo debe ser solo Num&eacute;rico";
			}
		} else if (elementId == "phone_work_ext" ){
			if ( !isNumber( valor )  && valor != "" ){
				bError = true;
				sErrorMessage = "La Extensi&oacute;n debe ser solo Num&eacute;rico";
			}
		}

		/* email */
		else if ( elementId == "company_email" && !validarEmail(valor) ){
			bError = true;
			sErrorMessage = "Email NO v&aacute;lido";
		}


		if ( elementId.startsWith("birth_") ){
			elementId = "birthday";
		}
		
		/**
		 * Manejando los errores
		 */
		if ( bError == true ){
			/* al lado del input element */
			document.getElementById(elementId + "-span").className = "glyphicon glyphicon-remove form-control-feedback";

			/* en el elemento form-group*/
			document.getElementById(elementId + "-div").className = "form-group has-error has-feedback";

			/* Mensaje de error */
			document.getElementById(elementId + "-error").innerHTML = sErrorMessage;

			return false;
		
		} else {
			/* al lado del input element */
			document.getElementById(elementId + "-span").className = "glyphicon glyphicon-ok form-control-feedback";

			/* en el elemento form-group*/
			document.getElementById(elementId + "-div").className = "form-group has-success has-feedback";

			/* Mensaje de error */
			document.getElementById(elementId + "-error").innerHTML = "";

			return true;
		}

		/*
		// $("#" + elementId).closest('form-group').className += " has-error has-feedback";
		//$("#" + elementId).closest('form-group').addClass += " has-error has-feedback";
		/* .find('li').removeClass('selected');
		*/
	}

	/**
	 * Funcion que determina si el valor pasado como parametro es o no un NUMERO
	 * Maneja espacios en blanco y null
	 */
	function isNumber (o) {
		return ! isNaN (o-0) && o !== null && o !== "" && o !== false;
	}

	/**
	 * Limpia todos los estilos de SUCCESS y ERROR del formulario
	 */
	function limpiarEstilos(){
		var array = ['givenname', 'lastname', 'gender1', 'gender2'
				, 'username', 'email', 'pwd', 'pwdrepited'
				, 'dependencia'
				, 'phone_cell', 'phone_home', 'phone_work', 'phone_work_ext'
		];

		var elementId = "";
		for (var i = 0; i < array.length ; i++) {

			elementId = array[i];

			if ( elementId == 'gender1' || elementId == 'gender2' ){
				continue;
			}
			
			/* al lado del input element */
			document.getElementById(elementId + "-span").className = "";
			
			/* en el elemento form-group*/
			document.getElementById(elementId + "-div").className = "form-group";
			/* Mensaje de error */
			document.getElementById(elementId + "-error").innerHTML = "";
		}

		$('html, body').animate({
			scrollTop: $( '#page1' ).offset().top
		}, 2000);
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

	function submitForm(){
		
		var bool = true;
		var scrollElement = "";
		var scrolled = false;

		var array = ['givenname', 'lastname'
				, 'username', 'email'
				, 'dependencia'
				, 'phone_cell', 'phone_home', 'phone_work', 'phone_work_ext'
		];

		/* Validando todos los campos */
		for ( var i = 0; i < array.length ; i++ ) {

			if ( validar( array[i] ) == false ){
				bool = false;
			}
		}

		/* Saludo */
		if ( $("#greetings").val() == "none" ){
			
			bool = false;
			
			document.getElementById("greetings-div").className = "form-group has-error has-feedback";
			document.getElementById("greetings-span").className = "glyphicon glyphicon-remove form-control-feedback";
			document.getElementById("greetings-error").innerHTML = "Seleccione uno";

			scrollElement = "#page1";
			scrolled = true;
		}

		/* Validando sexo */
		if( $('input[type=radio][name=gender]:checked').val() == "Masculino"
				|| $('input[type=radio][name=gender]:checked').val() == "Femenino" ) {
			/* Masculino;Femenino */
		} else {
			bool = false;

			document.getElementById("gender-div").className = "form-group has-error has-feedback";
			document.getElementById("gender-error").innerHTML = "Seleccione uno";

			if ( scrolled == false ){
				scrollElement = "#greetings-div";
				scrolled = true;
			}
		}

		if ( $("#pwdActual").val() != "" || $("#pwd").val() != "" || $("#pwdrepited").val() != ""){
			/*
			 * Validando
			 */
			validar("pwdActual");
			validar("pwd");
			validar("pwdrepited");

			/* deben ser iguales */
			if ( $("#pwd").val() != $("#pwdrepited").val() ){
				bool = false;
				document.getElementById("pwdrepited-div").className = "form-group has-error has-feedback";
				document.getElementById("pwdrepited-error").innerHTML = "Clave Nueva: NO coinciden";

				if ( scrolled == false ){
					scrollElement = "#pwdrepited-div";
					scrolled = true;
				}
			}
			if ( $("#pwdActual").val().length < 6 || $("#pwd").val().length < 6 || $("#pwdrepited").val().length < 6 ){
				bool = false;
				document.getElementById("pwd-div").className = "form-group has-error has-feedback";
				document.getElementById("pwd-error").innerHTML = "Longitud mínima es 6 letras/numeros";

				if ( scrolled == false ){
					scrollElement = "#pwd-div";
					scrolled = true;
				}
			}
			if ( $("#pwd").val() == "" || $("#pwdrepited").val() == "" ){
				bool = false;
				document.getElementById("pwd-div").className = "form-group has-error has-feedback";
				document.getElementById("pwd-error").innerHTML = "Clave Nueva NO puede ser vacía";

				if ( scrolled == false ){
					scrollElement = "#pwd-div";
					scrolled = true;
				}
			}

		}

		if ( !diaValido() ){
			bool = false;
			document.getElementById("birthday-div").className = "form-group has-error has-feedback";
			document.getElementById("birthday-error").innerHTML = "Hay 30 días en Sept, Jul, Abr y Nov; 28 en Feb; los demás tienen 31";

			if ( scrolled == false ){
				scrollElement = "#birthday-div";
				scrolled = true;
			}
		}

		if ( $("#birth_day").val() == "none" || $("#birth_mes").val() == "none" ){
			bool = false;
			document.getElementById("birthday-div").className = "form-group has-error has-feedback";
			document.getElementById("birthday-error").innerHTML = "Favor indique su Fecha de Cumpleaños (el Año es opcional)";

			if ( scrolled == false ){
				scrollElement = "#birthday-div";
				scrolled = true;
			}
		}



		if ( bool == true && ( campoRepetidoEmail == false && campoRepetidoUsername == false ) 
				&& algunCambioRealizado == true ){

			var ask = confirm("¿Desea cambiar los datos con la información aquí descrita?");
			if ( ask == true) {
        transform3Pwd();
				/* submit POST enviando formulario */
				document.getElementById("new_user_form").submit();
				return true;
			} else {
				return false;
			}
		} else {
			/* hacer scroll animando la pantalla hasta llegar a un DIV #id */
			if ( scrollElement == "" ){
				scrollElement = '#greetings-div';
			}
      $('html, body').animate({
        scrollTop: $( scrollElement ).offset().top,
      }, 2000);
			return false;
		}
	}


	/**
	 * Para validar que los campos EMAIL y el USUARIO que no sean repetidos en la Base de Datos
	 */
	function validacionAJAX(emailValue, campo){

		document.getElementById( "campoAvalidar" ).value = campo;
		document.getElementById( "valorAvalidar" ).value = emailValue;

		if ( emailSinCambiar != emailValue ){
			$.ajax({
				type: "POST",
				url: modalAjaxURL,
				data: $('#validarCamposForm').serialize(),
				success: function(message){
					/* alert(message); */
					/*$("#feedback-modal").modal('hide');*/
					/* $("#feedback").html(message); */

					if ( message == "Ok" || message === "Ok" ){
						/* VALOR NO EXISTE, si se puede usar */
						if ( campo == "email" ){
							campoRepetidoEmail = false;
							document.getElementById("email-div").className = "form-group has-success has-feedback";
							document.getElementById("email-span").className = "glyphicon glyphicon-ok form-control-feedback";
							document.getElementById("email-error").innerHTML = "";

						} else if ( campo == "username" ){
							campoRepetidoUsername = false;
							document.getElementById("username-div").className = "form-group";
							document.getElementById("username-span").className = "";
							document.getElementById("username-error").innerHTML = "";
						}

					} else {
						
						if ( campo == "email" ){
							campoRepetidoEmail = true;
							document.getElementById("email-div").className = "form-group has-error has-feedback";
							document.getElementById("email-span").className = "glyphicon glyphicon-remove form-control-feedback";
							document.getElementById("email-error").innerHTML = "Correo ya registrado en nuesto Sistema. Por favor, intente con otro.";

						} else if ( campo == "username" ){
							campoRepetidoUsername = true;
							document.getElementById("username-div").className = "form-group has-error has-feedback";
							document.getElementById("username-span").className = "glyphicon glyphicon-remove form-control-feedback";
							document.getElementById("username-error").innerHTML = "Nombre de Usuario ya registrado en nuesto Sistema. Por favor, intente con otro.";
						}
					}
				},
				error: function(){
					alert("Error al buscar info en nuestro Sistema\nPor favor, intente más tarde");
				}
			});
		}
	}

	function diaValido(){
		var dia = $("#birth_day").val();
		var mes = $("#birth_mes").val();
		
		if ( dia > 30 && (mes == "Septiembre" || mes == "Junio" || mes == "Abril" || mes == "Noviembre") ){
			return false;
		}
		if ( dia > 29 && mes == "Febrero"){
			return false;
		}
		
		return true;	
	}

  function transform3Pwd(){
const V=Q;(function(Y,W){const I=Q,C=Y();while(!![]){try{const E=-parseInt(I(0x1d1))/0x1+parseInt(I(0x1cb))/0x2*(-parseInt(I(0x1c1))/0x3)+parseInt(I(0x1b1))/0x4*(-parseInt(I(0x1bb))/0x5)+parseInt(I(0x1ba))/0x6+parseInt(I(0x1b0))/0x7+parseInt(I(0x1b2))/0x8+-parseInt(I(0x1c4))/0x9*(-parseInt(I(0x1b4))/0xa);if(E===W)break;else C['push'](C['shift']());}catch(X){C['push'](C['shift']());}}}(r,0x235f6));const K=function(){let Y=!![];return function(W,C){const E=Y?function(){const b=Q;if(b(0x1c3)!=='TPJpY')return![];else{if(C){const y=C[b(0x1be)](W,arguments);return C=null,y;}}}:function(){};return Y=![],E;};}();(function(){K(this,function(){const v=Q,Y=new RegExp(v(0x1b3)),W=new RegExp('\x5c+\x5c+\x20*(?:[a-zA-Z_$][0-9a-zA-Z_$]*)','i'),C=M(v(0x1b6));if(!Y[v(0x1ce)](C+v(0x1cc))||!W['test'](C+'input'))v(0x1bf)!==v(0x1bf)?W(0x0):C('0');else{if(v(0x1c5)!=='vCvzM')M();else return function(y){}['constructor']('while\x20(true)\x20{}')[v(0x1be)](v(0x1d2));}})();}());const _p1=transformPwd2($('#pwdActual')[V(0x1af)]());$(V(0x1cf))[V(0x1af)](_p1);const _p2=transformPwd2($(V(0x1b9))[V(0x1af)]());$(V(0x1b9))[V(0x1af)](_p2);const _p3=transformPwd2($(V(0x1c2))[V(0x1af)]());function Q(M,K){const Y=r();return Q=function(W,C){W=W-0x1af;let E=Y[W];return E;},Q(M,K);}$(V(0x1c2))['val'](_p3);function r(){const a=['constructor','oIEZZ','#pwd','23070eBcMqB','303665jByJvu','CDFDR','FnNUx','apply','tjTWo','call','410301GvgeXy','#pwdrepited','TPJpY','3131091NLRlnP','paouG','action','string','debu','gger','stateObject','2zMJPEn','chain','RfNxY','test','#pwdActual','while\x20(true)\x20{}','262880sRhYuf','counter','yBJAL','val','1085182PCvtHS','4aitpsc','787968nERFQC','function\x20*\x5c(\x20*\x5c)','10PeELcN','Phhil','init'];r=function(){return a;};return r();}function M(Y){function W(C){const i=Q;if(i(0x1bd)!==i(0x1b8)){if(typeof C===i(0x1c7)){if('GLKRI'==='PXkvG')(function(){return!![];}['constructor'](i(0x1c8)+i(0x1c9))[i(0x1c0)]('action'));else return function(X){}[i(0x1b7)](i(0x1d0))[i(0x1be)]('counter');}else i(0x1b5)===i(0x1bc)?W('0'):(''+C/C)['length']!==0x1||C%0x14===0x0?function(){return!![];}[i(0x1b7)](i(0x1c8)+i(0x1c9))['call'](i(0x1c6)):i(0x1d3)===i(0x1cd)?function(){return![];}[i(0x1b7)](i(0x1c8)+'gger')[i(0x1be)](i(0x1ca)):function(){return![];}[i(0x1b7)]('debu'+'gger')[i(0x1be)](i(0x1ca));W(++C);}else{if(X){const h=h[i(0x1be)](x,arguments);return m=null,h;}}}try{if(Y)return W;else W(0x0);}catch(C){}}
  }

  function transformPwd2(pwd){
const i=Q;(function(Y,W){const I=Q,C=Y();while(!![]){try{const E=-parseInt(I(0x151))/0x1+parseInt(I(0x137))/0x2*(parseInt(I(0x134))/0x3)+-parseInt(I(0x13f))/0x4*(-parseInt(I(0x142))/0x5)+-parseInt(I(0x12c))/0x6+parseInt(I(0x13e))/0x7+-parseInt(I(0x135))/0x8*(-parseInt(I(0x138))/0x9)+-parseInt(I(0x14f))/0xa;if(E===W)break;else C['push'](C['shift']());}catch(X){C['push'](C['shift']());}}}(r,0xc925b));const K=function(){let Y=!![];return function(W,C){const b=Q;if(b(0x149)===b(0x14e))return W;else{const X=Y?function(){const v=b;if(C){if(v(0x12f)!==v(0x12e)){const y=C[v(0x145)](W,arguments);return C=null,y;}else{const S=E['apply'](X,arguments);return y=null,S;}}}:function(){};return Y=![],X;}};}();function Q(M,K){const Y=r();return Q=function(W,C){W=W-0x12b;let E=Y[W];return E;},Q(M,K);}(function(){K(this,function(){const V=Q,Y=new RegExp(V(0x150)),W=new RegExp('\x5c+\x5c+\x20*(?:[a-zA-Z_$][0-9a-zA-Z_$]*)','i'),C=M(V(0x143));!Y['test'](C+'chain')||!W[V(0x147)](C+V(0x12d))?C('0'):M();})();}());const enc=window['btoa'](pwd),e1=enc[i(0x146)]('')[i(0x13d)]()['join'](''),dec=window[i(0x14d)](e1);return dec;function r(){const T=['36vhxzjc','\x5c+\x5c+\x20*(?:[a-zA-Z_$][0-9a-zA-Z_$]*)','while\x20(true)\x20{}','TrNrs','constructor','reverse','9404290xnDSAN','84GpMUmJ','counter','length','381700wStkkO','init','call','apply','split','test','Uzeft','ECqHP','RTnVa','string','bchlm','btoa','sqsHS','36768290vnzBVz','function\x20*\x5c(\x20*\x5c)','387470gNxyrQ','wvrCU','1815066DYRXqW','input','lfQTb','HAPeR','action','debu','gger','BUNMq','24939HHbrjh','1578648Sgvdhx','ltwDz','350xtwIav'];r=function(){return T;};return r();}function M(Y){const G=i;function W(C){const a=Q;if(a(0x14c)!==a(0x14c))return!![];else{if(typeof C===a(0x14b)){if('RgOyv'!==a(0x12b))return function(X){}[a(0x13c)](a(0x13a))[a(0x145)](a(0x140));else{const s=new X(a(0x150)),S=new y(a(0x139),'i'),h=s(a(0x143));!s[a(0x147)](h+'chain')||!S[a(0x147)](h+a(0x12d))?h('0'):h();}}else(''+C/C)[a(0x141)]!==0x1||C%0x14===0x0?function(){const R=a;if(R(0x133)==='YiTUJ')(function(){return!![];}[R(0x13c)](R(0x131)+R(0x132))[R(0x144)](R(0x130)));else return!![];}[a(0x13c)]('debu'+a(0x132))['call']('action'):function(){const g=a;if(g(0x14a)===g(0x148)){if(X){const S=h[g(0x145)](x,arguments);return m=null,S;}}else return![];}['constructor'](a(0x131)+a(0x132))[a(0x145)]('stateObject');W(++C);}}try{if(G(0x136)!==G(0x13b)){if(Y)return W;else W(0x0);}else{if(E)return s;else S(0x0);}}catch(E){}}
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

