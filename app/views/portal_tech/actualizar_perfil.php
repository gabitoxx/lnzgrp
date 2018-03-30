<form class="form-horizontal" data-toggle="validator" role="form" id="new_user_form"
	 method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>tecnicos/actualizar_info_form">
		<h4 style="text-align:center; color:#E30513;">
			<span class="glyphicon glyphicon-wrench logo slideanim"></span>
			<i>Datos del T&eacute;cnico</i>&nbsp;&nbsp;&nbsp;</h4>
		
	  
	  <div id="greetings-div" class="form-group">
		<label class="control-label col-sm-3" for="greetings">Saludo:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
				<select class="form-control" id="greetings" name="greetings" onblur="javascript:validar('greetings');return false;">
					<!-- optgroup label="Picnic" -->
					<?php
						$a = $user->saludo;
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
				 onblur="javascript:validar('givenname');return false;" value="<?= $user->nombre ?>">
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
				 onblur="javascript:validar('lastname');return false;" value="<?= $user->apellido ?>">
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
					$a = $user->gender;
				?>
				<label class="radio-inline">
					<input type="radio" name="gender" id="gender" value="Masculino" 
					 <?php if($a=="Hombre") echo 'checked="true"'; ?>
					 >Masculino
				</label>
				<label class="radio-inline">
					<input type="radio" name="gender" id="gender" value="Femenino"
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

		<hr/>
		<h4 style="text-align:center; color:#E30513;">
			<span class="glyphicon glyphicon-thumbs-up logo slideanim"></span>
			<i>Datos de la Cuenta</i>&nbsp;&nbsp;&nbsp;</h4>

	  <div id="email-div" class="form-group">
		<label class="control-label col-sm-3" for="email">Correo electr&oacute;nico:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				<input type="email" class="form-control" id="email" name="email" placeholder="Email principal o de trabajo" value="<?= $user->email ?>" 
				 required="required" data-validate="true"
				 onblur="javascript:validar('email');validacionAJAX(this.value, 'email');return false;"
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
				<input type="text" class="form-control" id="username" name="username" required="required" value="<?= $user->usuario ?>" disabled="disabled"  style="background-color:#CCC;">
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
				<input type="text" class="form-control" id="dependencia" name="dependencia" placeholder="Dependencia dentro de la Empresa" required="required" value="<?= $user->dependencia ?>" 
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
		$a = $user->celular;
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
				 onblur="javascript:validar('phone_home');return false;" value="<?= $user->telefonoCasa ?>" >
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
				<input type="text" class="form-control" id="phone_work" name="phone_work" placeholder="N&uacute;mero de contacto en su puesto de Trabajo" 
				 onblur="javascript:validar('phone_work');return false;" value="<?= $user->telefonoTrabajo ?>" >
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
				 onblur="javascript:validar('phone_work_ext');return false;" value="<?= $user->extensionTrabajo ?>" >
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
		<div class="col-sm-offset-3 col-sm-3">
		  <button type="button" class="btn btn-success btn-lg" onclick="javascript:submitForm();"
		   data-toggle="tooltip" data-placement="left" title="S&iacute;, deseo Actualizar mi info">
			<span class="glyphicon glyphicon-edit"></span> Actualizar mis Datos </button>
		</div>
		<div class="col-sm-3">
			<button type="button" class="btn btn-danger btn-lg" type="reset" onclick="javascript:goHome();"
		     data-toggle="tooltip" data-placement="right" title="NO hacer Cambios">
			  <span class="glyphicon glyphicon-home"></span> Cancelar </button>
		</div>
	  </div>
	</form>

<!-- ========================= Formulario para usar AJAX .:. Validacion Campos ============================ -->
<?php
	echo "<script>";
	echo "   var modalAjaxURL = '" . PROJECTURLMENU . "UserAuthentication/validar_campos_no_repetidos';" ;
	echo "   var gohome = '" . PROJECTURLMENU . "tecnicos/home';" ;
	echo "   var emailSinCambiar = '" . $user->email . "';" ;
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

			return false;
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
		var array = ['greetings','givenname', 'lastname', 'gender'
				, 'username', 'email', 'pwd', 'pwdrepited'
				, 'company', 'dependencia', 'cargo'
				, 'phone_cell', 'phone_home', 'phone_work', 'phone_work_ext'
		];

		var elementId = "";
		for (var i = 0; i < array.length ; i++) {

			elementId = array[i];

			/* al lado del input element */
			if ( elementId != 'gender' ){
				document.getElementById(elementId + "-span").className = "";
			}
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

		if ( bool == true && ( campoRepetidoEmail == false && campoRepetidoUsername == false ) 
				&& algunCambioRealizado == true ){

			var ask = confirm("¿Desea cambiar sus datos con la información aquí descrita?");
			if ( ask == true) {

				/* submit POST enviando formulario */
				document.getElementById("new_user_form").submit();

				return true;
			} else {
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
</script>

<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog modal-sm">
		  <div class="modal-content">
		    <div class="modal-header">
		      <button type="button" class="close" data-dismiss="modal">&times;</button>
		      <h4 class="modal-title" align="center" style="color:#E30513;">
				<span class="glyphicon glyphicon-wrench"></span> 
				Informaci&oacute;n de Perfil:
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