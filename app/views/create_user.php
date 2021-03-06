<!DOCTYPE html>

<html lang="es">

<head>
  <title><?= $pageTitle ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script src="<?= APPJSPATH; ?>jquery.validate.js?version=5"></script>

	<link rel="shortcut icon" href="<?= APPIMAGEPATH; ?>favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= APPIMAGEPATH; ?>favicon.ico" type="image/x-icon">
	
	<link rel="apple-touch-icon" href="<?= APPIMAGEPATH; ?>apple-touch-icon.png">

	<link rel="apple-touch-icon" sizes="72x72" href="<?= APPIMAGEPATH; ?>apple-touch-icon-72x72.png">

	<link rel="apple-touch-icon" sizes="114x114" href="<?= APPIMAGEPATH; ?>apple-touch-icon-114x114.png">
<style>		
.logo {
	color: #E30513;
	font-size:20px;
}
.navbar-inverse{
	background-color: #337AB7;
	border-color: #337AB7;
}
</style>
</head>

<body id="page1">

<header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
  <div class="container">
	<div class="navbar-header">
	  <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </button>
	  <div class="hidden-xs">
			<!-- Esconder en Celulares -->
			<a class="navbar-brand" href="<?= PROJECTURL; ?>">
				<img src="<?= APPIMAGEPATH; ?>logo.png" alt="Lanuza Group" class="img-responsive" width="300" height="94">
			</a>
		</div>
		<div class="visible-xs-block">
			<!-- Mostrar SOLO en Celulares -->
			<a class="navbar-brand" href="<?= PROJECTURL; ?>">
				<img src="<?= APPIMAGEPATH; ?>logo2.png" alt="Lanuza Group" class="img-responsive" width="103" height="46 ">
			</a>
		</div>
	</div>
	<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
	  <ul class="nav navbar-nav navbar-right">
		<li>
		  <h4 style="text-align:center; color:#FFF;">
			Administraci&oacute;n :: Formulario de Creaci&oacute;n de un nuevo Usuario
		  </h4>
		</li>
	  </ul>
	</nav>
  </div>
</header>

<div class="jumbotron text-center" style="padding-bottom: 20px;">
	<h1 style="color: red;">Lanuza Group :: Administraci&oacute;n</h1>
	<p>Formulario de Creaci&oacute;n de un nuevo Usuario</p> 
</div>
 <!--==============================content================================-->
<div id="login_form">
		
		<?php
		if ( isset($logout_message)) {
			echo "<div class='message'>";
			echo $logout_message;
			echo "</div>";
		}
		?>
		<?php
		if (isset($message_display)) {
			echo "<div class='message'>";
			echo $message_display;
			echo "</div>";
		}
		?>				

	<form class="form-horizontal" data-toggle="validator" role="form" id="new_user_form"
	 method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>userAuthentication/create_new_user">

		<h4 style="text-align:center; color:#E30513;">
			<span class="glyphicon glyphicon-user logo slideanim"></span>
			<i>Datos de la Persona</i>&nbsp;&nbsp;&nbsp;</h4>
		

	  <div id="cargo-div" class="form-group" style="background-color: #CECECE;">
		<label class="control-label col-sm-3" for="dependencia">Tipo de Usuario:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<label class="radio-inline"
				  data-toggle="tooltip" data-placement="bottom" title="Para un T&Eacute;CNICO Contratado por Lanuza Group">
				  <input type="radio" name="cargo" id="cargo1" value="tech">
					T&eacute;cnico
				</label>
				<label class="radio-inline"
				  data-toggle="tooltip" data-placement="bottom" title="Para GERENTES o DUE&Ntilde;OS de Empresa, el que pagar&aacute; por los SERVICIOS o Encargado de Contactar directamente con Lanuza Group">
				  <input type="radio" name="cargo" id="cargo2" value="manager">
					Partner
				</label>
				<label class="radio-inline"
				  data-toggle="tooltip" data-placement="bottom" title="Para un Empleado del Portal de una Empresa que ya pag&oacute; Contrataci&oacute;n con nosotros">
				  <input type="radio" name="cargo" id="cargo3" value="client">
					Usuario
				</label>
				<label class="radio-inline"
				  data-toggle="tooltip" data-placement="bottom" title="Servicio planificado A FUTURO, a&uacute;n NO habilitado: Usuarios desde su casa">
				  <input type="radio" name="cargo" id="cargo4" disabled="disabled" value="homeUser">
					<span style="color:#ABABAB">Usuario independiente (hogar)</span>
				</label>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="cargo-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>


	  <div id="greetings-div" class="form-group">
		<label class="control-label col-sm-3" for="greetings">Saludo:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-hand-right"></i></span>
				<select class="form-control" id="greetings" name="greetings" onblur="javascript:validar('greetings');return false;">
					<!-- optgroup label="Picnic" -->
					<option value="none">  --  Seleccione una opci&oacute;n --  </option>
					<option value="Sr.">Sr.</option>
					<option value="Sra.">Sra.</option>
					<option value="Srita.">Srita.</option>
					<option value="Dr.">Dr.</option>
					<option value="Dra.">Dra.</option>
					<option value="Phd.">Phd.</option>
					<option value="Ing.">Ing.</option>
					<option value="Lic.">Lic.</option>
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
				 onblur="javascript:validar('givenname');return false;">
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
				 onblur="javascript:validar('lastname');return false;">
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
		<label class="control-label col-sm-3" for="pwd">G&eacute;nero:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<label class="radio-inline">
				  <input type="radio" name="gender" id="gender1" value="Masculino">Masculino
				</label>
				<label class="radio-inline">
				  <input type="radio" name="gender" id="gender2" value="Femenino">Femenino
				</label>
				<span id="gender-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="gender-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="birthday-div" class="form-group">
		<label class="control-label col-sm-3" for="birthday" style="margin-top: 35px;">Cumplea&ntilde;os:</label>
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
				<input type="email" class="form-control" id="email" name="email" placeholder="Email principal o de trabajo"
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
		<label class="control-label col-sm-3" for="username">Usuario:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-magnet"></i></span>
				<input type="text" class="form-control" id="username" name="username" placeholder="Su Nombre de Usuario en el Portal LanuzaGroup" required="required"
				 onblur="javascript:validar('username');validacionAJAX(this.value, 'username');return false;"
				 data-toggle="tooltip" data-placement="bottom" title="Este ser&aacute; su usuario en el Portal, preferiblemente mayor de 6 caracteres AlfaN&uacute;mericos (letras y n&uacute;meros)">
				<span id="username-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="username-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>
	  

	  <div id="pwd-div" class="form-group">
		<label class="control-label col-sm-3" for="pwd">Contrase&ntilde;a:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-copyright-mark"></i></span> 
				<input type="password" class="form-control" id="pwd" name="pwd" placeholder="M&aacute;s de 6 caracteres alfanum&eacute;ricos" required="required"
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
		<label class="control-label col-sm-3" for="pwd">Repita Contrase&ntilde;a:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-registration-mark"></i></span> 
				<input type="password" class="form-control" id="pwdrepited" name="pwdrepited" placeholder="Repita su contrase&ntilde;a" required="required"
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


		<hr/>
		<h4 style="text-align:center; color:#E30513;">
			<span class="glyphicon glyphicon-briefcase logo slideanim"></span>
			<i>Datos de la Empresa</i>&nbsp;&nbsp;&nbsp;</h4>


	  <div id="companyCombo-div" class="form-group">
		<label class="control-label col-sm-3" for="companyCombo">Empresa en la que trabaja:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
				<select class="form-control" id="companyCombo" name="companyCombo">
					<option value="none">  --  Seleccione una Empresa --  </option>
					<?php
						$option = "";
						$razon  = "";
						foreach ($empresas as $empresa){

							if ( $empresa["empresaId"] <= 11 ){
								/* saltar Empresas de prueba */
								continue;
							}

							$option = '<option value="' . $empresa["empresaId"] . '">' . $empresa["nombre"];
							
							if ( $empresa["razonSocial"] != "" ) {
								$razon = " (" . $empresa["razonSocial"] . ")" ;
							} else {
								$razon = "";
							}
							
							echo $option .  $razon . "</option>";
						}
					?>
				</select>
				<span id="companyCombo-span" class=""></span>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="companyCombo-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="company_check-div" class="form-group">
		<label class="control-label col-sm-3" for="company_check">Nueva Empresa</label>
		<div class="col-sm-7">
			<div class="input-group">
				<label><input type="checkbox" id="company_check" name="company_check" value="company_new" onclick="javascript:toogle('extraCompanyData');">
					La Empresa NO aparece en las opciones de arriba. Registraré una nueva:
				</label>
			</div>
		</div>
		<div class="col-sm-2">
			<div id="company_check-error" class="help-block">
				&nbsp;
			</div>
		</div>
	  </div>

	  <div id="extraCompanyData" style="background-color: #951B81;">

		  <div id="company-div" class="form-group">
			<label class="control-label col-sm-3" for="company">Nombre de la Empresa:</label>
			<div class="col-sm-7">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
					<input type="text" class="form-control" id="company" name="company" placeholder="El nombre de la Empresa donde labora">
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
			<label class="control-label col-sm-3" for="company_razon">Razon Social de la Empresa:</label>
			<div class="col-sm-7">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
					<input type="text" class="form-control" id="company_razon" name="company_razon" placeholder="opcional">
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
			<label class="control-label col-sm-3" for="company_nit">NIT</label>
			<div class="col-sm-7">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
					<input type="text" class="form-control" id="company_nit" name="company_nit" placeholder="opcional">
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
			<label class="control-label col-sm-3" for="company_pais">Pa&iacute;s</label>
			<div class="col-sm-7">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
					<select class="form-control" id="company_pais" name="company_pais">
						<option value="none" disabled="disabled">  --  Seleccione Pa&iacute;s --  </option>
						<?php 
							$fileLocation = 'templates/ComboCountries.php';
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
			<label class="control-label col-sm-3" for="company_estados">Departamento / Estado</label>
			<div class="col-sm-7">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
					<select class="form-control" id="company_estados" name="company_estados">
						<option value="none">  --  Seleccione Departamento --  </option>
						<?php 
							$fileLocation = 'templates/ComboDepartamentos.php';
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
			<label class="control-label col-sm-3" for="company_city">Ciudad</label>
			<div class="col-sm-7">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
					<input type="text" class="form-control" id="company_city" name="company_city" placeholder="Indique Ciudad (opcional)">
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
			<label class="control-label col-sm-3" for="company_direccion">Direcci&oacute;n</label>
			<div class="col-sm-7">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-briefcase"></i></span>
					<input type="text" class="form-control" id="company_direccion" name="company_direccion" placeholder="Calle con Karrera, Edificio, piso y/o puntos de referencia">
					<span id="company_direccion-span" class=""></span>
				</div>
			</div>
			<div class="col-sm-2">
				<div id="company_direccion-error" class="help-block">
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
				<input type="text" class="form-control" id="dependencia" name="dependencia" placeholder="Dependencia dentro de la Empresa"
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


	  <div id="phone_cell-div" class="form-group">
		<label class="control-label col-sm-3" for="phone_cell">Celular:</label>
		<div class="col-sm-7">
			<div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
				<select class="form-control" id="cellphone_code" name="cellphone_code">
					<!-- optgroup label="Picnic" -->
					<option value="none">  --  Seleccione c&oacute;digo de Pa&iacute;s --  </option>
					<?php 
						$fileLocation = 'templates/ComboPaises.php';
						include( $fileLocation );
					?>
				</select>
				<input type="text" class="form-control" id="phone_cell" name="phone_cell" placeholder="N&uacute;mero de contacto v&iacute;a Celular, por ejemplo 314 1234567" required="required"
				  onblur="javascript:validar('phone_cell');return false;">
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
				 onblur="javascript:validar('phone_home');return false;">
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
				<input type="text" class="form-control" id="phone_work" name="phone_work" placeholder="N&uacute;mero de contacto en su puesto de Trabajo" required="required"
				 onblur="javascript:validar('phone_work');return false;">
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
				 onblur="javascript:validar('phone_work_ext');return false;">
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
		<div class="col-sm-offset-3 col-sm-2">
		  <button type="submit" id="createAccount" 
		   class="btn btn-success btn-lg" onclick="javascript:return submitForm();" 
		   data-toggle="tooltip" data-placement="bottom" title="S&iacute;, deseo Crear mi cuenta con estos datos">
			<span class="glyphicon glyphicon-user"></span> Crear Cuenta </button>
		</div>
		<div class="col-sm-3">
		  <input class="btn btn-warning btn-lg" type="reset" value=" Empezar desde cero " onclick="javascript:limpiarEstilos();"
		   data-toggle="tooltip" data-placement="bottom" title="Limpiar Formulario y comenzar otra vez">
		</div>
		<div class="col-sm-4">
			<a href="<?= PROJECTURLMENU; ?>home" class="btn btn-link" role="button"
				data-toggle="tooltip" data-placement="bottom" title="No quiero crear una cuenta en estos momentos">
				Salir, No crear cuenta nueva </a>
		</div>
	  </div>
	</form>
		
</div><!-- end login_form -->
<br /><br />

<!-- ========================= Formulario para usar AJAX .:. Validacion Campos ============================ -->
<?php
	echo "<script>";
	echo "   var modalAjaxURL = '" . PROJECTURLMENU . "UserAuthentication/validar_campos_no_repetidos';" ;
	echo "</script>";
?>
<form id="validarCamposForm" method="post" enctype="multipart/form-data">
	<input type="hidden" id="campoAvalidar" name="campoAvalidar" value="" />
	<input type="hidden" id="valorAvalidar" name="valorAvalidar" value="" />
</form>


<!--==============================footer================================-->
	
<script>

$(document).ready(function () {
	/*
	$('#new_user_form').validate({
		rules: {
			givenname: {
				minlength: 2,
				required: true
			},
			lastname: {
				minlength: 2,
				required: true
			},
			email: {
				required: true,
				email: true
			},
			agree: "required"
			
		},
		highlight: function (element) {
			/*
			$(element).closest('.input-group')
			.removeClass('has-success')
			.addClass('has-error has-feedback');
			*/
			/*
			$(element).closest('.form-group')
			.addClass('has-error has-feedback');
		},
		success: function (element) {
			/* element  .text('OK!')  .addClass('valid') * /
			$(element)
				
				.closest('.input-group')
				.removeClass('has-error')
				.addClass('has-success glyphicon glyphicon-ok form-control-feedback');
		}
	});
*/

	

	var msg="";

	var elements = document.getElementsByTagName("INPUT");

	for (var i = 0; i < elements.length; i++) {

		elements[i].oninvalid =function(e) {

			if (!e.target.validity.valid) {

				switch(e.target.id){

					case 'email' : 
						e.target.setCustomValidity("Introduzca un Email válido");
						break;
					case 'username' : 
						e.target.setCustomValidity("Nombre de Usuario NO puede estar en blanco.");
						break;
					case 'givenname' : 
						e.target.setCustomValidity("Nombre NO puede estar en blanco.");
						break;
					case 'lastname' : 
						e.target.setCustomValidity("Apellido NO puede estar en blanco.");
						break;
					case 'pwd' : 
						e.target.setCustomValidity("Contraseña NO puede estar en blanco.");
						break;
					case 'pwdrepited' : 
						e.target.setCustomValidity("Confirmación de Contraseña NO puede estar en blanco.");
						break;
					case 'company' : 
						e.target.setCustomValidity("Compañía NO puede estar en blanco.");
						break;
					case 'dependencia' : 
						e.target.setCustomValidity("Dependencia NO puede estar en blanco.");
						break;
					case 'phone_cell' : 
						e.target.setCustomValidity("Celular NO puede estar en blanco.");
						break;
					case 'phone_work' : 
						e.target.setCustomValidity("Teléfono de Trabajo NO puede estar en blanco.");
						break;
					default : 
						e.target.setCustomValidity("");
						break;
				}
			}
		};

		elements[i].oninput = function(e) {
			e.target.setCustomValidity(msg);
		};
	}

	$('[data-toggle="tooltip"]').tooltip();

	/*
	 * Ocultar / mostrar la seccion de EXTRA data
	 */
	toogle("extraCompanyData");

});


var campoRepetidoEmail = false;
var campoRepetidoUsername = false;

function validar(elementId){
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
	else if ( elementId == "company" ){
		if ( valor.length < 2 ){
			bError = true;
			sErrorMessage = "Longitud m&iacute;nima de Compa&ntilde;&iacute;a es 2";
		}
		else if ( isNumber( valor ) ){
			bError = true;
			sErrorMessage = "La Compa&ntilde;&iacute;a no puede ser solo N&uacute;meros";
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
	else if ( elementId == "pwd"){
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
	else if ( elementId == "phone_cell"){debugger;
		
		var numero = parseInt(valor); /* 314 1234567 */
		
		if ( !isNumber( valor ) ){
			bError = true;
			sErrorMessage = "El Celular debe ser solo Num&eacute;rico, sin guiones, espacios ni puntos";
		
		} else if ( $('#cellphone_code').val() == "+57" && (numero < 3000000000 || numero > 3999999999) ){
			bError = true;
			sErrorMessage = "Parece NO estar correcto. Revise nuevamente (Colombia)";
		
		} else if ( $('#cellphone_code').val() == "+1" && (numero < 100000 ) ){
			bError = true;
			sErrorMessage = "Parece NO estar correcto. Revise nuevamente (Code +1)";
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
	var array = ['greetings','givenname', 'lastname', 'gender'
			, 'username', 'email', 'pwd', 'pwdrepited'
			, 'company', 'dependencia', 'cargo'
			, 'phone_cell', 'phone_home', 'phone_work', 'phone_work_ext'
	];

	var elementId = "";
	for (var i = 0; i < array.length ; i++) {

		elementId = array[i];

		/* al lado del input element */
		if ( elementId != 'cargo' ){
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

	/* Esconder el botón */
	$("#createAccount").attr("disabled", "disabled");

	
	var bool = true;
	var scrollElement = "";
	var scrolled = false;

	/* validar los campos que no se validan en este metodo */
	var array = ['givenname', 'lastname'
			, 'username', 'email', 'pwd', 'pwdrepited'
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

	/* validando CARGO */
	var sCargo = $('input[type=radio][name=cargo]:checked').val();
	if( sCargo == "manager" || sCargo == "client" || sCargo == "homeUser" || sCargo == "tech" ) {
		/* manager,client,homeUser,tech */

		if ( sCargo != "tech" ){

			/*
			 * Si el Usuario NO es Tecnico, debe indicar Compañia y cargo
			 */
			if ( $('#company').val() == "" && $('#companyCombo').val() == "none" ){
				bool = false;
				document.getElementById("company-div").className = "form-group has-error has-feedback";
				document.getElementById("company-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("company-error").innerHTML = "Indique Nombre de Compa&ntilde;ia";
				if ( scrolled == false ){
					scrollElement = "#pwd-div";
					scrolled = true;
				}
			} else if ( $('#dependencia').val() == "" ){
				bool = false;
				document.getElementById("dependencia-div").className = "form-group has-error has-feedback";
				document.getElementById("dependencia-span").className = "glyphicon glyphicon-remove form-control-feedback";
				document.getElementById("dependencia-error").innerHTML = "Indique Dependencia";
				if ( scrolled == false ){
					scrollElement = "#pwdrepited-div";
					scrolled = true;
				}
			}
			
		}

	} else {
		bool = false;

		document.getElementById("cargo-div").className = "form-group has-error has-feedback";
		document.getElementById("cargo-error").innerHTML = "Seleccione uno";

		if ( scrolled == false ){
			scrollElement = "#page1";
			scrolled = true;
		}
	}

	var bCompanyCheck = $("#company_check").is(':checked');
	var sCompanyCombo = $("#companyCombo").val();

	if ( bCompanyCheck == true ){
		/* se validara la nueva empresa */

		//company
		//company_pais
		if ( $("#company").val() == "" ){
			bool = false;
			document.getElementById("company-div").className = "form-group has-error has-feedback";
			document.getElementById("company-error").innerHTML = "Especifique una nueva Empresa o Seleccione una Existente";
			if ( scrolled == false ){
				scrollElement = "#companyCombo-div";
				scrolled = true;
			}
		} else if ( $("#company_pais").val() == "" ){
			bool = false;
			document.getElementById("company_pais-div").className = "form-group has-error has-feedback";
			document.getElementById("company_pais-error").innerHTML = "Seleccione uno";
			if ( scrolled == false ){
				scrollElement = "#companyCombo-div";
				scrolled = true;
			}
		} else if ( $("#company_direccion").val() == "" ){
			bool = false;
			document.getElementById("company_direccion-div").className = "form-group has-error has-feedback";
			document.getElementById("company_direccion-error").innerHTML = "Indique Dirección al estilo: #Calle - Nº Karrera";
			if ( scrolled == false ){
				scrollElement = "#companyCombo-div";
				scrolled = true;
			}
		}
	} else {
		/* se validara que el usuario haya seleccionado una empresa existente */
		if ( sCompanyCombo == "none" ){
			bool = false;
			document.getElementById("companyCombo-div").className = "form-group has-error has-feedback";
			document.getElementById("companyCombo-error").innerHTML = "Seleccione una Empresa o Registre una Nueva";
			if ( scrolled == false ){
				scrollElement = "#companyCombo-div";
				scrolled = true;
			}
		}
	}

	/* Validando Cumpleaños */
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

	if ( bool == true && ( campoRepetidoEmail == false && campoRepetidoUsername == false ) ){

		/* habilitando ANTES del envio */
		if ( $("#companyCombo").attr("disabled") != undefined ){
			document.getElementById( "companyCombo" ).removeAttribute("disabled");
		}
		
		/* submit POST enviando formulario */
		document.getElementById("new_user_form").submit();

		return true;

	} else {

		if ( scrollElement == "" || scrollElement == undefined ){
			scrollElement = "#page1";
		}

		/* hacer scroll animando la pantalla hasta llegar a un DIV #id */
		$('html, body').animate({
			scrollTop: $( scrollElement ).offset().top
		}, 2000);

		/* Mostrar el botón en caso de alguna falla en el registro */
		$("#createAccount").removeAttr( "disabled" );

		return false;
	}
}

function toogle(divIdToToogle) {

	var x = document.getElementById( divIdToToogle );
	var y = document.getElementById( "companyCombo" );

	if (x.style.display === 'none') {
		/* Mostrar */
		x.style.display = 'block';
		
		/* no debe haber empresa seleccionada */
		y.value = 'none';
		y.setAttribute("disabled","disabled");

	} else {
		/* Ocultar */
		x.style.display = 'none';

		/* habilitar seleccion */
		y.removeAttribute("disabled");

	}
}


/**
 * Para validar que los campos EMAIL y el USUARIO que no sean repetidos en la Base de Datos
 */
function validacionAJAX(emailValue, campo){

	document.getElementById( "campoAvalidar" ).value = campo;
	document.getElementById( "valorAvalidar" ).value = emailValue;

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
					document.getElementById("email-div").className = "form-group";
					document.getElementById("email-span").className = "";
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

</script>

</body>

</html>