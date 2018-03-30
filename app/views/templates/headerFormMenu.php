<style type="text/css">

		#login {

			border-radius: 10px;

			font-family:raleway;

			border: 2px solid #ccc;

			padding: 3px 5px 3px;

			font-size: 14px;

			font-style: italic;

		}

		#user_login, #user_password {

			width:28%;

			margin-top: 4px;

			border: 1px solid #CCC;

			/* padding-left: 2px; */

			padding: 2px;

			font-size: 12px;

			font-family:raleway;

			background-color: rgb(250, 255, 189);

		}

		#signup{

			font-size: 13px;

		}

		#login_form_text{

			font-family:raleway;

			vertical-align: middle;

			font-size: 13px;

			font-style: italic;

		}

	</style>

<div class="row-top">

 <div class="main">

  <div class="wrapper">

   <table>

	<tr><td>

		<h1><a href="<?= PROJECTURL; ?>">Lanuza Group</a></h1>

	</td>
	<td align="center">

		<!-- Formulario de Busqueda en construccion -->
		<form id="search-form" method="post" enctype="multipart/form-data">

			<fieldset>  

					<div class="search-field">

							<input name="Buscar" type="text" value="Buscar..." onBlur="if(this.value=='') this.value='Buscar...'" onFocus="if(this.value =='Buscar...' ) this.value=''" />

							<a class="search-button" href="#" onClick="document.getElementById('search-form').submit()"></a>    

					</div>                      

			</fieldset>

		</form>

		<br/>

		<?php 
			$attributesLogin = array('id' => 'login');
			// echo form_open('userAuthentication/userLoginProcess2', $attributesLogin);
		?>
		<form id="login" method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>userAuthentication/login">

		<label id="login_form_text">Login: </label>

			<input type="text" name="username" id="user_login" placeholder="Usuario o Email" required="required" />

			<input type="password" name="password" id="user_password" placeholder="******" required="required" />

			<input type="submit" value="Ingresar" name="submit" />
			
			<br/>
			<a id="login_form_text" href="<?= PROJECTURLMENU; ?>register">&iquest;A&uacute;n no tienes cuenta&quest; Reg&iacute;strate como Cliente</a>
		</form>

		<!-- span id="signup"><a href="#" onClick="javascript:alert('En construcci&oacute;n');">¿A&uacute;n no tienes cuenta? Reg&iacute;strate como Cliente</a></span -->

	</td></tr>

   </table>

 </div>

</div>

</div>

<div class="menu-row">

	<div class="menu-bg">

		<div class="main">

			<nav class="indent-left">

				<ul class="menu wrapper">

					<li <?php if($MENUACTIVE=="HOME") echo 'class="active"' ?>><a href="<?= PROJECTURLMENU; ?>home">Inicio</a></li>

					<li <?php if($MENUACTIVE=="ABOUT") echo 'class="active"' ?>><a href="<?= PROJECTURLMENU; ?>home/aboutUs">Nosotros</a></li>

					<li <?php if($MENUACTIVE=="SERVICES") echo 'class="active"' ?>><a href="<?= PROJECTURLMENU; ?>home/services">Servicios</a></li>

					<li <?php if($MENUACTIVE=="CLIENTS") echo 'class="active"' ?>><a href="<?= PROJECTURLMENU; ?>home/clients">Clientes</a></li>

					<li <?php if($MENUACTIVE=="CONTACT") echo 'class="active"' ?>><a href="<?= PROJECTURLMENU; ?>home/contact">Contacto</a></li>

				</ul>

			</nav>

		</div>

	</div>

</div>