<?php
	if(!isset($_SESSION)) { 
		session_start(); 
	}
	defined("APPPATH") OR die("Access denied");

	if( isset( $_SESSION['logged_user']) ){

		$title = $pageTitle;

	} else {
		header("location: " . PROJECTURLMENU . "showLogin");
	}

	/*
	 * En una página donde se coloca Tiempo - Hora  - Fecha
	 * se debe establecer estas lineas:
	 */
	date_default_timezone_set("America/Bogota");
	putenv("TZ=America/Bogota");

?>
<!DOCTYPE html>
<html lang="es">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title><?= $title ?></title>

	<link rel="shortcut icon" href="<?= APPIMAGEPATH; ?>favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= APPIMAGEPATH; ?>favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="<?= APPIMAGEPATH; ?>apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= APPIMAGEPATH; ?>apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= APPIMAGEPATH; ?>apple-touch-icon-114x114.png">
	<link rel="manifest" href="http://lanuzasoft.com/app/views/portal_client/user-manifest.json" />
	<meta name="theme-color" content="<?= $_SESSION['portal_color_rgb']; ?>" />

	<!-- Bootstrap core CSS -->
	<link href="<?= BOOTSTRAPPATH; ?>css/bootstrap.min.css" rel="stylesheet">

	<!-- Tablas Responsivas de verdad -->
	<link href="<?= APPCSSPATH; ?>no-more-tables.css" rel="stylesheet">

	<!-- Add icon library del boton tipo pulgar arriba/abajo como like/dislike de facebook, y cara feliz/triste -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<style>
		#wrapper {
			min-height: 100%;
			height: 100%;
			width: 100%;
			position: absolute;
			top: 0px;
			left: 0;
			display: inline-block;
		}
		#main-wrapper {
			height: 100%;
			overflow-y: auto;
			padding: 50px 0 0px 0;
		}
		.navbar-default .navbar-nav .open .dropdown-menu>li>a {
			color: #000;
			font-size:18px;
		}

		body {
			transition: background-color .5s;
		}

		.sidenav {
			height: 100%;
			width: 0;
			position: fixed;
			z-index: 1;
			top: 0;
			left: 0;
			background-color: #111;
			overflow-x: hidden;
			transition: 0.5s;
			padding-top: 60px;
		}

		.sidenav a {
			padding: 8px 8px 8px 32px;
			text-decoration: none;
			font-size: 25px;
			color: #818181;
			display: block;
			transition: 0.3s;
		}

		.sidenav a:hover, .offcanvas a:focus{
			color: #f1f1f1;
		}

		.sidenav .closebtn {
			position: absolute;
			top: 50px;
			right: 25px;
			font-size: 36px;
			margin-left: 50px;
		}

		#main {
			transition: margin-left .5s;
			padding: 16px;
		}

		@media screen and (max-height: 450px) {
		  .sidenav {padding-top: 15px;}
		  .sidenav a {font-size: 18px;}
		}

		#menuIzqButton {
			border-radius: 25px;
			border: 2px solid #337AB7;
			padding: 5px;
		}
		.dropdown-menu li:hover {
			background-color: #CCC;
			font-style: italic;
		}
		.dropdown-menu:hover {
			background-color: #CCC;
		}

		fieldset.scheduler-border {
			border: 1px groove #ddd !important;
			padding: 0 1.4em 1.4em 1.4em !important;
			margin: 0 0 1.5em 0 !important;
			-webkit-box-shadow:  0px 0px 0px 0px #000;
					box-shadow:  0px 0px 0px 0px #000;
		}
		legend.scheduler-border {
			width:inherit; /* Or auto */
			padding:0 10px; /* To give a bit of padding on the left and right */
			border-bottom:none;
		}
	</style>
  </head>

  <body>

	<div id="wrapper">
		<div id="header" class="navbar navbar-default navbar-fixed-top"
		 style="min-height:57px; <?= "background-color:" . $_SESSION['portal_color_rgb']; ?>">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".navbar-collapse">
					<i class="icon-reorder"></i>
				</button>

				<div class="hidden-xs">
					<!-- Esconder en Celulares -->
					<a class="navbar-brand" href="<?= PROJECTURL; ?>">
						<img src="<?= APPIMAGEPATH; ?>logo.png" alt="Lanuza Group" class="img-responsive" width="200" height="88">
					</a>
				</div>
				<div class="visible-xs-block">
					<!-- Mostrar SOLO en Celulares -->
					<a class="navbar-brand" href="<?= PROJECTURL; ?>">
						<img src="<?= APPIMAGEPATH; ?>logo2.png" alt="Lanuza Group" class="img-responsive" width="103" height="46 ">
					</a>
				</div>
			</div>

			<nav class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #000 !important;font-size:16px;font-weight: bold;"
						 onclick="javascript:openNav();">
							&#9776; Men&uacute;
						</a>
					</li>
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #000 !important;">
						<span class="glyphicon glyphicon-cog"></span>
						Incidencias<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?= PROJECTURLMENU; ?>portal/nueva_incidencia"><span class="glyphicon glyphicon-fire"></span> Generar nueva Incidencia</a></li>
							<li><a href="<?= PROJECTURLMENU; ?>portal/ver_incidencias"><span class="glyphicon glyphicon-list"></span> Consulta de Incidencias</a></li>
							<li><a href="<?= PROJECTURLMENU; ?>portal/ver_historico_cliente"><span class="glyphicon glyphicon-hourglass"></span> Incidencias/Reportes ya cerrados</a></li>
						</ul>
					</li>
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #000 !important;">
						<span class="glyphicon glyphicon-tasks"></span>
						Equipo<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="<?= PROJECTURLMENU; ?>portal/mis_equipos"><span class="glyphicon glyphicon-blackboard"></span> Ver Inventario de Mi(s) Equipo(s)</a></li>
							<li><a href="<?= PROJECTURLMENU; ?>portal/historialEquipoCliente"><span class="glyphicon glyphicon-hourglass"></span> Historial de mis Equipos</a></li>
						</ul>
					</li>
					<li>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #000 !important;">
						<span class="glyphicon glyphicon-calendar"></span>
						Calendario Soportes<b class="caret"></b></a><!-- Trello -->
						<ul class="dropdown-menu">
							<li><a href="<?= PROJECTURLMENU; ?>portal/calendario"><span class="glyphicon glyphicon-calendar"></span> Calendario</a></li>
							<li><a href="<?= PROJECTURLMENU; ?>portal/listado_soportes"><span class="glyphicon glyphicon-object-align-right"></span> Resumen Listado Soportes</a></li>
						</ul>
					</li>
					
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #000 !important;">
						<span class="glyphicon glyphicon-text-background"></span>
						Ayuda<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Incidencias &iquest;Qu&eacute; son&quest;</a></li>
							<li><a href="#">Tengo problemas con mi Equipo &iquest;Qu&eacute; hago&quest;</a></li>
							<li><a href="#">Ya me solucionaron el problema. &iquest;Qu&eacute; hago ahora&quest;</a></li>
							<li><a href="#">Inventario: componentes de mi Equipo</a></li>
							<li><a href="#">Asignaci&oacute;n Equipos: &iquest;C&oacute;omo funciona y para qu&eacute; es&quest;</a></li>
							<li><a href="#">&iquest;C&oacute;mo veo/actualizo mi tel&eacute;fono o el resto de mis datos&quest;</a></li>
							<li><a href="#">Soportes Programados: &iquest;Qu&eacute; son&quest;</a></li>
						</ul>
					</li>

					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #000 !important;">
						<span class="glyphicon glyphicon-user"></span>
						<i>
<?php 
							echo $user->saludo . " ";
							/*
							 * Si contiene más de 1 nombre, se colocará solo el primero
							 */
							if ( strpos( $user->nombre, ' ' ) !== false ){

								$nombres = explode(" ", $user->nombre);
								echo $nombres[0] . " ";

							} else {
								echo $user->nombre . " ";
							}
							
							/*
							 * Si contiene más de 1 Apellido, se colocará solo el primero
							 */
							if ( strpos( $user->apellido, ' ' ) !== false ){

								$apellidos = explode(" ", $user->apellido);
								echo $apellidos[0] . " ";

							} else {
								echo $user->apellido;
							}
?>
						</i>
						<b class="caret"></b>
					  </a>
					  <ul class="dropdown-menu">
						  <li><a href="<?= PROJECTURLMENU; ?>portal/profile"><span class="glyphicon glyphicon-info-sign"></span> Info de Perfil</a></li>
						  <li><a href="<?= PROJECTURLMENU; ?>portal/update_profile"><span class="glyphicon glyphicon-pencil"></span> Actualizar Mis Datos</a></li>
					  </ul>
					</li>

				</ul>
				<ul class="nav navbar-nav pull-right">
					<li>
						<a href="<?= PROJECTURLMENU; ?>UserAuthentication/logout" style="color: #000 !important;">
							Salir <span class="glyphicon glyphicon-log-out"></span></a>
					</li>
				</ul>
			</nav>
		</div>

		<!-- ===================================== Menu izquierdo ============================================== -->
		<div id="mySidenav" class="sidenav">
			<a href="#">&nbsp;</a>
			<a href="javascript:void(0)" class="closebtn" onclick="javascript:closeNav();">&times;</a>
			<a href="<?= PROJECTURLMENU; ?>portal/nueva_incidencia">Nueva Incidencia</a>
			<a href="<?= PROJECTURLMENU; ?>portal/ver_incidencias">Ver Incidencias</a>
			<a href="<?= PROJECTURLMENU; ?>portal/calendario">Calendario Soportes</a>
			<a href="<?= PROJECTURLMENU; ?>portal/mis_equipos">Mi(s) Equipo(s)</a>
			<a href="<?= PROJECTURLMENU; ?>portal/profile">Info de Perfil</a>
			<a href="<?= PROJECTURLMENU; ?>portal/update_profile">Actualizar Datos</a>
			<a href="#">Temas de Ayuda</a>
			<a href="<?= PROJECTURLMENU; ?>UserAuthentication/logout">Salir</a>
		</div>
		

		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

		<script src="<?= APPJSPATH; ?>funcionesGenericas.js"></script>

		<div id="main-wrapper" class="col-md-12 col-sm-12 col-xs-12 pull-right">
			<div id="main">
				<div class="page-header" style="margin-top:0px; margin-bottom:0px;">

					<div class="hidden-xs">
					<!-- Esconder en Celulares -->
						<table id="presentation-bar" width="100%">
							<tr>
								<td width="150px">
									<p id="menuIzqButton">
										&nbsp; <span style="font-size:30px;cursor:pointer" onclick="javascript:openNav();">&#9776; Men&uacute;</span>
									</p>
								</td>
								<td>
									&nbsp;&nbsp;
									<a href="<?= PROJECTURLMENU; ?>portal/home" data-toggle="tooltip" data-placement="bottom" title="Ir al Inicio">
										<span class="glyphicon glyphicon-home" style="font-size:30px;cursor:pointer"></span>
									</a>
								</td>
								<td>
									<h3>&nbsp; <span class="glyphicon glyphicon-wrench"></span> <u>Portal Usuarios</u>: <i><?= $user->saludo . " " . $user->nombre . " " . $user->apellido; ?></i></h3>
								</td>
								<td align="right">
									<?php
									echo "Hoy es " . date("d/m/Y");
									?>
								</td>
							</tr>
						</table>
					</div>

					<div class="visible-xs-block">
					<!-- Mostrar SOLO en Celulares -->
						<table id="presentation-bar" width="100%">
							<tr>
								<td>
									<p id="menuIzqButton">
										<span style="font-size:20px;cursor:pointer" onclick="javascript:openNav();">&#9776;</span>
									</p>
								</td>
								<td>
									&nbsp;&nbsp;
									<a href="<?= PROJECTURLMENU; ?>portal/home">
										<span class="glyphicon glyphicon-home" style="font-size:20px;cursor:pointer"></span>
									</a>
								</td>
								<td>
									<i><?= $user->saludo . " " . $user->nombre . " " . $user->apellido; ?></i>
								</td>
								<td align="right">
									<?php
									echo "Hoy: " . date("d/m/Y");
									?>
								</td>
						</table>
					</div>
				</div>
			  
			  <div class="page-body">
				<?php 
					$fileLocation = 'portal_client/' . $opcionMenu . '.php';
					include( $fileLocation );
				?>
			  </div>
			  
			</div>
			
			<!-- div class="col-md-12 footer">
			  <ul class="nav navbar-nav"><li><a href="">Link</a></li><li><a href="">Link</a></li><li><a href="">Link</a></li></ul>
			</div -->
		  
			<br/><br/><br/><br/>&nbsp;

		</div>
	</div>

<?php 
	/***********************************************************************************************************/
	include( 'portal_client/moduloPQRS.php' );
?>

	<!-- ==========================   Scripts  para Ajustar tamaños de pantalla y menu izquierdo ==================  -->
	<script>

		$(document).ready(function () {

			$(window).resize(function() {
				/* al ajustar pantalla, recalcular * /
				resizingWindow(); */
			});

			/* calculando la pantalla la primera vez * /
			resizingWindow(); */

			$('[data-toggle="tooltip"]').tooltip();

		});

		function resizingWindow(){

			if ($(this).width() >= 1280) {
				document.getElementById("sidebar-wrapper").style.position = "fixed";/*alert("+1280");*/
				document.getElementById("sidebar-wrapper").style.display = "block";
			} else if ($(this).width() < 1280 && $(this).width()>= 980) {
				document.getElementById("sidebar-wrapper").style.position = "fixed";/*alert("1280");*/
				document.getElementById("sidebar-wrapper").style.display = "block";
			} else if ($(this).width() < 980 && $(this).width()>= 768) {
				document.getElementById("sidebar-wrapper").style.position = "fixed";/*alert("968-768");*/
				document.getElementById("sidebar-wrapper").style.display = "block";
			} else if ($(this).width() < 768 && $(this).width()>= 480) {
				document.getElementById("sidebar-wrapper").style.position = "fixed";/*alert("+480");*/
				document.getElementById("sidebar-wrapper").style.display = "none !important";
			} else {
				document.getElementById("sidebar-wrapper").style.position = "relative";/*alert("<480");*/
				document.getElementById("sidebar-wrapper").style.display = "none !important";
			}
		}

		function openNav() {
			document.getElementById("mySidenav").style.width = "300px";
			document.getElementById("main").style.marginLeft = "300px";
			document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
		}

		function closeNav() {
			document.getElementById("mySidenav").style.width = "0";
			document.getElementById("main").style.marginLeft= "0";
			document.body.style.backgroundColor = "white";
		}
	</script>

  </body>
</html>