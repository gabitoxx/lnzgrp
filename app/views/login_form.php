<!DOCTYPE html>

<html lang="es">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Favicons ================================================== -->
	
	<?php 
		$fileLocation = 'templates/headerLinksAndMetas.php';
		include( $fileLocation );
	?>

	<link rel="stylesheet" href="<?= APPCSSPATH; ?>relogin.css?version=10" type="text/css" media="screen">	
	
<style>
	#googlelogin {
		width:350px;
		float:left;
		border-radius:10px;
		font-family:raleway;
		
		border:2px solid #CCC;
		/* colores google
		border-top-color: red;
		border-left-color: yellow;
		border-bottom-color: green;
		border-right-color: blue;
		*/
		padding:10px 0px 25px;
		/* margin-top:70px; */
	}
</style>
<!-- script src="https://apis.google.com/js/platform.js" async defer></script -->
<!-- script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script -->
<!-- meta name="google-signin-client_id" content="712503867445-jalv39o1ne39o8b70ac8n1jld9bpve9h.apps.googleusercontent.com" -->


<!-- PROBAR EN PRODUCCION ALGUN DIA
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css">
  <script src="https://apis.google.com/js/api:client.js"></script>
  <script>
  var googleUser = {};
  var startApp = function() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: '712503867445-jalv39o1ne39o8b70ac8n1jld9bpve9h.apps.googleusercontent.com',
        cookiepolicy: 'single_host_origin',
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });
      attachSignin(document.getElementById('customBtn'));
    });
  };

  function attachSignin(element) {
    console.log(element.id);
    auth2.attachClickHandler(element, {},
        function(googleUser) {
          document.getElementById('name').innerText = "Logueado como: " +
              googleUser.getBasicProfile().getName();
        }, function(error) {
          alert(JSON.stringify(error, undefined, 2));
        });
  }
  </script>
  <style type="text/css">
    #customBtn {
      display: inline-block;
      background: white;
      color: #444;
      width: 190px;
      border-radius: 5px;
      border: thin solid #888;
      box-shadow: 1px 1px 1px grey;
      white-space: nowrap;
    }
    #customBtn:hover {
      cursor: pointer;
    }
    span.label {
      font-family: serif;
      font-weight: normal;
    }
    span.icon {
      /* background: url('/identity/sign-in/g-normal.png') transparent 5px 50% no-repeat; */
      display: inline-block;
      vertical-align: middle;
      width: 42px;
      height: 42px;
    }
    span.buttonText {
      display: inline-block;
      vertical-align: middle;
      padding-left: 42px;
      padding-right: 42px;
      font-size: 14px;
      font-weight: bold;
      /* Use the Roboto font that is loaded in the <head> */
      font-family: 'Roboto', sans-serif;
    }
  </style>
-->

</head>

<body id="page1"
<?php 
	if (isset($error_message_email)) {
 		echo ' onload="javascript:onfocusEmailError();" ';
 	}
 	else if (isset($error_message)) {
 		echo ' onload="javascript:onfocusPasswordError();" ';
 	}
?> >

	<!-- div class="extra" -->

		<!--==============================header=================================-->

		<header>

			<?php 
				$MENUACTIVE   = "CONTACT";
				$fileLocation = 'templates/headerFormMenu.php';
				include( $fileLocation );
			?>
		</header>

 <!--==============================content================================-->
 	<div class="row">
	  <div class="col-md-offset-1 col-md-6 col-sm-12">
 		<br /><br />
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
				<div id="reloginmain">
					<div id="relogin">
						<h4>Ingreso al Sistema de Gesti&oacute;n de Soportes TI <br/> Lanuza Group</h4>
						<hr/>

						<form id="login" method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>userAuthentication/login">
						
						<?php
							echo "<span>";
							if (isset($error_message)) {
								echo $error_message;
							}
							echo "</span><br/>";
						?>
						<label for="username">Usuario:</label>
						<input type="text" name="username" id="username" placeholder="Escriba Usuario aqui" />
						<br /><br />
						
						<label for="password">Contrase&ntilde;a:</label>
						<input type="password" name="password" id="password" placeholder="**********" />
						<br/><br />
						
						<input type="submit" value=" Login " name="submit" />
						<br /><br />
						<a href="<?= PROJECTURLMENU; ?>register">Para Registrarse ingrese aqu&iacute;</a>
						</form>
					</div>
				</div>

				
			</div><!-- end login_form -->
		<br /><br />
	  </div>
	  <div class="col-md-5 col-sm-12 col-xs-12">
	  	<br /><br />
	  	<div id="reloginmain">
	  		<div id="relogin" style="width:350px;margin-left:100px;padding-left:0px;padding-right:0px;">
	  		<h4 align="center" id='olvido'>Olvido de Contrase&ntilde;a</h4>
			<hr style="margin-left:0px;margin-right:0px;"/>
			
			<form id="login" style="margin-left:25px; margin-right:25px; "
			 method="post" enctype="multipart/form-data" action="<?= PROJECTURLMENU; ?>userAuthentication/forget">

			 	<?php
					echo "<span>";
					if (isset($error_message_email)) {
						echo $error_message_email;
						echo "";
					}
					echo "</span><br/>";
				?>

				<em class="text-1 margin-bot">Si olvid&oacute; su contrase&ntilde;a, por esta opci&oacute;n puede recuperarla.
					Para ello indique a continuaci&oacute;n su <b>Correo Electr&oacute;nico registrado o su Nombre de Usuario</b>.
					Le estaremos enviando a su email su contrase&ntilde;a.</em>

				<label for="forgotPassword">Correo Electr&oacute;nico o Usuario:</label>
				<br />
				<input type="text" name="forgotPassword" id="forgotPassword" placeholder="Escriba Usuario o Email aqui" />
				<br /><br />
				<input type="submit" value=" Recordarme Contrase&ntilde;a " name="submit"
				 style="width:100%;margin-left:0px;background-color:rgba(227, 108, 28, 0.62) !important;"/>
				<br /><br />
			</form>

	  		<!-- div class="g-signin2" data-onsuccess="onSignIn"></div -->
	  		<!-- div id="my-signin2"></div -->
	  		<!-- div id="gSignInWrapper">
	    		<span class="label">Sign in with:</span>
			    <div id="customBtn" class="customGPlusSignIn">
			      <span class="icon"></span>
			      <span class="buttonText">Google</span>
			    </div>
			  </div>
		  <div id="name"></div>
		  <script>startApp();</script>
		-->
			</div>
	  	</div>
	  </div>
	</div>
	<br /><br />
<script>
	function onfocusEmailError(){
		document.getElementById('forgotPassword').focus();
		document.getElementById('forgotPassword').style = 'background: rgba(255, 0, 0, 0.27) !important';

		$('html, body').animate({
			scrollTop: $( "#olvido" ).offset().top
		}, 2000);
	}
	function onfocusPasswordError(){
		document.getElementById('username').focus();
		
		document.getElementById('username').style = 'background: rgba(255, 0, 0, 0.27) !important';
		document.getElementById('password').style = 'background: rgba(255, 0, 0, 0.27) !important';

		$('html, body').animate({
			scrollTop: $( "#reloginmain" ).offset().top
		}, 2000);
	}
</script>
<!--==============================footer================================-->
	<?php 

		$fileLocation = 'templates/scripts.php';
		include( $fileLocation );
		
		$fileLocation = 'templates/footerForm.php';
		include( $fileLocation );
	?>

</body>

</html>