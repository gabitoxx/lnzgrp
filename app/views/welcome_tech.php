<?php
 	defined("APPPATH") OR die("Access denied");
 	
	if( isset( $_SESSION['login_username']) ){

		$title = $pageTitle;

	} else {
		header("location: " . PROJECTURLMENU . "showLogin");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $title ?></title>

	<link rel="shortcut icon" href="<?= APPIMAGEPATH; ?>favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?= APPIMAGEPATH; ?>favicon.ico" type="image/x-icon">
	
	<link rel="apple-touch-icon" href="<?= APPIMAGEPATH; ?>apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?= APPIMAGEPATH; ?>apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="<?= APPIMAGEPATH; ?>apple-touch-icon-114x114.png">

	<meta name="google-site-verification" content="7MTL52H6Hqrg5Ps8VtI8Lc5XraA_mI9P570lCUClxe0" />
	<meta name="theme-color" content="<?= $_SESSION['portal_color_rgb']; ?>" />
	<link rel="manifest" href="https://lanuzasoft.com/app/views/portal_tech/tech-manifest.json" />

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
	body {
			font: 400 15px Lato, sans-serif;
			line-height: 1.8;
			color: #818181;
	}
	h2 {
			font-size: 24px;
			text-transform: uppercase;
			color: #303030;
			font-weight: 600;
			margin-bottom: 30px;
	}
	h4 {
			font-size: 19px;
			line-height: 1.375em;
			color: #303030;
			font-weight: 400;
			margin-bottom: 30px;
	}  
	.jumbotron {
			background-color: #AFCA0A;   /** #antiguo color #F4511E naranja */
			color: #fff;
			padding: 100px 25px;
			font-family: Montserrat, sans-serif;
	}
	.container-fluid {
			padding: 60px 50px;
	}
	.bg-grey {
			background-color: #f6f6f6;
	}
	.logo-small {
			color: #AFCA0A;
			font-size: 50px;
	}
	.logo {
			color: #AFCA0A;
			font-size: 200px;
	}
	.thumbnail {
			padding: 0 0 15px 0;
			border: none;
			border-radius: 0;
	}
	.thumbnail img {
			width: 100%;
			height: 100%;
			margin-bottom: 10px;
	}
	.carousel-control.right, .carousel-control.left {
			background-image: none;
			color: #AFCA0A;
	}
	.carousel-indicators li {
			border-color: #AFCA0A;
	}
	.carousel-indicators li.active {
			background-color: #AFCA0A;
	}
	.item h4 {
			font-size: 19px;
			line-height: 1.375em;
			font-weight: 400;
			font-style: italic;
			margin: 70px 0;
	}
	.item span {
			font-style: normal;
	}
	.panel {
			border: 1px solid #AFCA0A; 
			border-radius:0 !important;
			transition: box-shadow 0.5s;
	}
	.panel:hover {
			box-shadow: 5px 0px 40px rgba(0,0,0, .2);
	}
	.panel-footer .btn:hover {
			border: 1px solid #AFCA0A;
			background-color: #fff !important;
			color: #AFCA0A;
	}
	.panel-heading {
			color: #fff !important;
			background-color: #AFCA0A !important;
			padding: 25px;
			border-bottom: 1px solid transparent;
			border-top-left-radius: 0px;
			border-top-right-radius: 0px;
			border-bottom-left-radius: 0px;
			border-bottom-right-radius: 0px;
	}
	.panel-footer {
			background-color: white !important;
	}
	.panel-footer h3 {
			font-size: 32px;
	}
	.panel-footer h4 {
			color: #aaa;
			font-size: 14px;
	}
	.panel-footer .btn {
			margin: 15px 0;
			background-color: #AFCA0A;
			color: #fff;
	}
	.navbar {
			margin-bottom: 0;
			background-color: #AFCA0A;
			z-index: 9999;
			border: 0;
			font-size: 12px !important;
			line-height: 1.42857143 !important;
			letter-spacing: 4px;
			border-radius: 0;
			font-family: Montserrat, sans-serif;
			height: 80px;
	}
	.navbar li a, .navbar .navbar-brand {
			color: #000 !important;
			background-color: #AFCA0A !important;
	}
	/*
	.navbar-nav li a:hover, .navbar-nav li.active a {
			color: #000 !important;
			background-color: #A94442 !important;
	}
	*/
	.navbar-default .navbar-toggle {
			border-color: #AFCA0A; /** transparent; */
			color: #000 !important;
	}
	footer .glyphicon {
			font-size: 20px;
			margin-bottom: 20px;
			color: #AFCA0A;
	}
	.slideanim {visibility:hidden;}
	.slide {
			animation-name: slide;
			-webkit-animation-name: slide;
			animation-duration: 1s;
			-webkit-animation-duration: 1s;
			visibility: visible;
	}
	@keyframes slide {
		0% {
			opacity: 0;
			transform: translateY(70%);
		} 
		100% {
			opacity: 1;
			transform: translateY(0%);
		}
	}
	@-webkit-keyframes slide {
		0% {
			opacity: 0;
			-webkit-transform: translateY(70%);
		} 
		100% {
			opacity: 1;
			-webkit-transform: translateY(0%);
		}
	}
	@media screen and (max-width: 768px) {
		.col-sm-4 {
			text-align: center;
			margin: 25px 0;
		}
		.btn-lg {
				width: 100%;
				margin-bottom: 35px;
		}
	}
	@media screen and (max-width: 480px) {
		.logo {
				font-size: 150px;
		}
	}

	a.back-to-top {
		display: none;
		width: 60px;
		height: 60px;
		text-indent: -9999px;
		position: fixed;
		z-index: 999;
		right: 20px;
		bottom: 20px;
		background: #AFCA0A url("<?= APPIMAGEPATH; ?>up-arrow.png") no-repeat center 43%;
		-webkit-border-radius: 30px;
		-moz-border-radius: 30px;
		border-radius: 30px;
	}
	a:hover.back-to-top {
		background-color: #E30513;
	}

#showMeMore {
	display: block;
	width: 60px;
	height: 60px;
	text-indent: -9999px;
	position: fixed;
	z-index: 999;
	right: 50%;
	bottom: 20px;
	background: #AFCA0A url("<?= APPIMAGEPATH; ?>down-arrow.png") no-repeat center 43%;
	-webkit-border-radius: 30px;
	-moz-border-radius: 30px;
	border-radius: 30px;
}
#showMeMore:hover {
	background-color: #E30513;
}


	</style>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
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
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#welcome">Bienvenid<?php if($genderMale==true){echo "o";}else{echo "a";} ?></a></li>
				<li><a href="#incidencias">Atenci&oacute;n Incidencias</a></li>
				<li><a href="#equipo">Inventario Equipos</a></li>
				<li><a href="#appTrello">App</a></li>
				<li><a style="background-color: red !important; color: #FFF;" href="<?= PROJECTURLMENU; ?>portal/home">Ir al Portal<span class="glyphicon glyphicon-arrow-right"></span></a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="jumbotron text-center" style="padding-bottom: 20px;">
	<h1>Lanuza Group</h1>
	<p>Portal de Atenci&oacute;n al Cliente</p> 
	<div class="row">
		<div class="col-md-2">&nbsp;</div>
		<div class="col-md-8 col-sm-12">
			<h3>Bienvenid<?php
				if( $genderMale == true) {
					echo "o ";
				} else {
					echo "a ";
				}
				echo "<i>" . $user -> saludo . " " . $user -> nombre . " " . $user -> apellido . "</i>";
			?>
			<br/>al Portal <b>Sistema de Gesti&oacute;n de Soportes TI</b> para <b>Ingenieros de Soporte</b>.
		</h3>
		</div>
		<div class="col-md-2">&nbsp;</div>
	</div>
</div>


<!-- Container (About Section) -->
<div id="welcome" class="container-fluid">
	<br/>
	<div class="row">
		<div class="col-sm-3">
			&nbsp;
			<div class="hidden-xs">
				<span class="glyphicon glyphicon-wrench logo slideanim"></span>
			</div>
		</div>
		<div class="col-sm-6 col-xs-12 text-center">
			<h2>Portal Sistema de Gesti&oacute;n de Soportes TI</h2><br>
			<h4>
			  Bienvenid<?php
				if( $genderMale == true) {
					echo "o ";
				} else {
					echo "a ";
				}
				echo "<i>" . $user -> saludo . " " . $user -> nombre . " " . $user -> apellido . "</i>";
			?>
			<br/>al Portal <b>Sistema de Gesti&oacute;n de Soportes TI</b> para <b>Ingenieros de Soporte</b>.
			</h4><br>
			<p>Esto es parte de lo que podr&aacute;s hacer en el Portal:</p>
		</div>
		<div class="col-sm-3">
			&nbsp;
			<div class="hidden-xs">
				<span class="glyphicon glyphicon-ok logo slideanim"></span>
			</div>
		</div>
	</div>
</div>

<!-- Container -->
<div id="incidencias" class="container-fluid text-center bg-grey">
	<br/>
	<h2>Atenci&oacute;n de incidencias</h2><br>
	<h4>Desde aqu&iacute; podr&aacute;s:</h4>
	<br/>
	<div class="row text-center slideanim">
		<div class="col-sm-4">
			<span class="glyphicon glyphicon-inbox logo-small"></span>
			<p><strong>Conocer Incidencias Pendientes</strong></p>
			<p>Con tu <mark>cuenta activa</mark>, ingresas por medio de tu usuario y contrase&ntilde;a a nuestro Portal.
				Luego podr&aacute;s ver qu&eacute; <mark>incidencias</mark> hay pendientes y la <mark>informaci&oacute;n</mark> 
				de las personas a las cuales podr&aacute;s atender.</p>
		</div>
		<div class="col-sm-4">
			<span class="glyphicon glyphicon-hdd logo-small"></span>
			<p><strong>Hacer Inventario de Equipos</strong></p>
			<p>Por medio de funciones como el <mark>script</mark> que levanta informaci&oacute;n de un Equipo. 
				Tambi&eacute;n habr&aacute; campos que puedas rellenar a mano desde nuestro <mark>formulario de Inventario</mark>.</p>
		</div>
		<div class="col-sm-4">
			<span class="glyphicon glyphicon-list-alt logo-small"></span>
			<p><strong>Reportes</strong></p>
			<p>Podr&aacute;s acceder a la Informaci&oacute;n recaudada por el Portal desde un equipo de Escritorio, tablet o celular.</p>
		</div>
	</div>

	<br/>

</div>

<!-- Container (Services Section) -->
<div id="equipo" class="container-fluid text-center">
	<br/>
	<h2>Conocer el Estado de los Equipos</h2>
	<h4>Aqu&iacute; deber&aacute;s cargar la Informaci&oacute;n de los Equipos</h4>
	<p>Para nosotros es muy importante conocer los componentes de los Equipos de nuestros clientes. 
	Parte de la Informaci&oacute;n ser&aacute; cargada v&iacute;a <mark>script</mark>, la cual deber&aacute;s confirmar en el <strong>formulario</strong>. 
	La informaci&oacute;n faltante podr&aacute; ser cargada a mano. Parte de la data importante es: </p>
	<br>
	<div class="row slideanim">
		<div class="col-sm-4">
			<span class="glyphicon glyphicon-off logo-small"></span>
			<h4>Tipo de Equipo</h4>
			<p>Todo-en-uno, port&aacute;til, de escritorio</p>
		</div>
		<div class="col-sm-4">
			<span class="glyphicon glyphicon-lock logo-small"></span>
			<h4>Sistema Operativo</h4>
			<p>Windows, Linux, Mac... y sus versiones</p>
		</div>
		<div class="col-sm-4">
			<span class="glyphicon glyphicon-certificate logo-small"></span>
			<h4>Licencias</h4>
			<p>Tipos de Licenciamiento de Sistemas Operativos, Servidores, Suite Ofim&aacute;tica, entre otros.</p>
		</div>
	</div>
	<br><br>
	<div class="row slideanim">
		<div class="col-sm-4">
			<span class="glyphicon glyphicon-globe logo-small"></span>
			<h4>Conexi&oacute;n de Red</h4>
			<p>Tipo de Conex&oacute;n de Red: Ethernet, WiFi, IP, MAC address, puerta de enlace y m&aacute;s.</p>
		</div>
		
		<div class="col-sm-4">
			<span class="glyphicon glyphicon-eye-open logo-small"></span>
			<h4>Conexi&oacute;n Remota</h4>
			<p>Acceso remoto a trav&eacute;s de TeamViewer, para ofrecerle <i>Soporte T&eacute;cnico a distancia</i>. Conocer los c&oacute;digos de acceso.</p>
		</div>
		
		<div class="col-sm-4">
			<span class="glyphicon glyphicon-wrench logo-small"></span>
			<h4 style="color:#303030;">HARDWARE</h4>
			<p>Tipo de Discos RAM, ROM, especialmente las <strong>Horas de Uso</strong>, entre otra data.</p>
		</div>
	</div>
</div>


<!-- Container (Pricing Section) -->
<div id="appTrello" class="container-fluid">
	<br/>
	<div class="text-center">
		<h2>Ayudar es nuestra consigna</h2>
		<h4>En este Portal podremos:</h4>
	</div>
	<div class="row slideanim">
		<div class="col-sm-4 col-xs-12">
			<div class="panel panel-default text-center">
				<div class="panel-heading">
					<h1>Resolver Incidencias</h1>
				</div>
				<div class="panel-body">
					<p>Las personas podr&aacute;n crear sus Incidencias</p>
					<p>y nosotros enterarnos a trav&eacute;s del Portal.</p>
					<p>Toda la info necesaria estar&aacute; disponible</p>
					<p>a trav&eacute;s de Internet usando el Portal.</p>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-xs-12">
			<div class="panel panel-default text-center">
				<div class="panel-heading">
					<h1>Realizar Inventarios</h1>
				</div>
				<div class="panel-body">
					<p>Podremos almacenar la info que</p>
					<p>recaudamos a trav&eacute;s de las labores </p>
					<p>Inventariado. Con ayuda de una herramienta</p>
					<p>de autor&iacute;a propia de LanuzaGroup</p>
					<p>tendremos la info siempre a la mano.</p>
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-xs-12">
			<div class="panel panel-default text-center">
				<div class="panel-heading">
					<h1>Soportes Programados</h1>
				</div>
				<div class="panel-body">
					<p>Con la Funci&oacute;n <strong>Calendario</strong> podremos </p>
					<p>agendar citas para Soportes Programados.</p>
					<p>As&iacute; las Empresas ser&aacute;n notificadas</p>
					<p>sobre nuestras visitas directamente a trav&eacute;s</p>
					<p>del Portal (que hace tambi&eacute;n env&iacute;o de correos).</p>
					<p>Ya podemos olvidarnos del WhatsApp para atender asuntos de Trabajo.</p>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Container (Contact Section) -->
<div class="hidden-xs">
	<!-- Esconder en Celulares -->
	<div id="gotoportal" class="row">
		<br/><br/>
		<div class="col-sm-3">
			&nbsp;
		</div>
		<div class="col-sm-6 col-xs-12 text-center">
			<a href="<?= PROJECTURLMENU; ?>portal/home" class="btn btn-primary btn-block" role="button">
				<span class="glyphicon glyphicon-hand-right logo-small" style="color: #000; font-size: 30px;"></span>
					Acceder a nuestro <strong>Portal</strong>
			</a>
		</div>
	</div>
	<div class="col-sm-3">
		&nbsp;
	</div>
</div>
<div align="center" class="visible-xs-block">
	<!-- Mostrar SOLO en Celulares -->
	<a href="<?= PROJECTURLMENU; ?>portal/home" title="Ingresa al Portal">
		<span class="glyphicon glyphicon-hand-right logo-small" style="color: #000; font-size: 30px;"></span>
		Acceder a nuestro <strong>Portal</strong>
	</a>
</div>


<footer class="container-fluid text-center">
	<a href="#myPage" title="Volver Arriba">
		<span class="glyphicon glyphicon-chevron-up"></span>
	</a>
	<!-- p>Bootstrap Theme Made By <a href="http://www.w3schools.com" title="Visit w3schools">www.w3schools.com</a></p -->
	<p>Sistema de Gesti&oacute;n de Soportes TI. Un Portal de <a href="https://lanuzasoft.com" title="P&aacute;gina Principal">Lanuza Group</a></p>
	<br/><br/>
</footer>


<script>
$(document).ready(function(){
	// Add smooth scrolling to all links in navbar + footer link
	$(".navbar a, footer a[href='#myPage']").on('click', function(event) {
		// Make sure this.hash has a value before overriding default behavior
		if (this.hash !== "") {
			// Prevent default anchor click behavior
			event.preventDefault();

			// Store hash
			var hash = this.hash;

			// Using jQuery's animate() method to add smooth page scroll
			// The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
			$('html, body').animate({
				scrollTop: $(hash).offset().top
			}, 900, function(){
	 
				// Add hash (#) to URL when done scrolling (default click behavior)
				window.location.hash = hash;
			});
		} // End if
	});
	
	$(window).scroll(function() {
		$(".slideanim").each(function(){
			var pos = $(this).offset().top;

			var winTop = $(window).scrollTop();
				if (pos < winTop + 600) {
					$(this).addClass("slide");
				}
		});
	});

	$('[data-toggle="tooltip"]').tooltip(); 

})

// create the back to top button -- Botón de Volver Arriba
$('body').prepend('<a href="#" class="back-to-top" data-toggle="tooltip" title="Volver Arriba">Volver Arriba</a>');

var amountScrolled = 300;

$(window).scroll(function() {
	if ( $(window).scrollTop() > amountScrolled ) {
		$('a.back-to-top').fadeIn('slow');
	} else {
		$('a.back-to-top').fadeOut('slow');
	}
});

$('a.back-to-top, a.simple-back-to-top').click(function() {
	$('html, body').animate({
		scrollTop: 0
	}, 700);
	return false;
});


//<!-- Botón de Bajar sección -->
$('body').prepend('<a href="#" id="showMeMore" data-toggle="tooltip" title="Ver M&aacute;s">M&aacute;s</a>');

var iSectionClicked = 0;
var menuArray = ["#welcome", "#incidencias", "#equipo", "#appTrello", "#gotoportal"];

$("#showMeMore").click(function() {

		
		var sectionClicked = menuArray[iSectionClicked];
		iSectionClicked++;
		if ( iSectionClicked == 5 ){
			iSectionClicked = 0;
		}
 		
		$('html, body').delay(500).animate({
			scrollTop: $( sectionClicked ).offset().top
		}, 1000);

		return false;
});  



</script>

</div>

</body>
</html>
