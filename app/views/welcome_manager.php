<?php
	session_start();
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

	<meta name="theme-color" content="<?= $_SESSION['portal_color_rgb']; ?>" />
	<meta name="google-site-verification" content="7MTL52H6Hqrg5Ps8VtI8Lc5XraA_mI9P570lCUClxe0" />
	<link rel="manifest" href="https://lanuzasoft.com/app/views/portal_manager/partner-manifest.json" />

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
			background-color: #F9B233;   /** #antiguo color #F4511E naranja */
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
			color: #F9B233;
			font-size: 50px;
	}
	.logo {
			color: #F9B233;
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
			color: #F9B233;
	}
	.carousel-indicators li {
			border-color: #F9B233;
	}
	.carousel-indicators li.active {
			background-color: #F9B233;
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
			border: 1px solid #F9B233; 
			border-radius:0 !important;
			transition: box-shadow 0.5s;
	}
	.panel:hover {
			box-shadow: 5px 0px 40px rgba(0,0,0, .2);
	}
	.panel-footer .btn:hover {
			border: 1px solid #F9B233;
			background-color: #fff !important;
			color: #F9B233;
	}
	.panel-heading {
			color: #fff !important;
			background-color: #F9B233 !important;
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
			background-color: #F9B233;
			color: #fff;
	}
	.navbar {
			margin-bottom: 0;
			background-color: #F9B233;
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
			background-color: #F9B233 !important;
	}
	/*
	.navbar-nav li a:hover, .navbar-nav li.active a {
			color: #000 !important;
			background-color: #A94442 !important;
	}
	*/
	.navbar-default .navbar-toggle {
			border-color: #F9B233; /** transparent; */
			color: #000 !important;
	}
	footer .glyphicon {
			font-size: 20px;
			margin-bottom: 20px;
			color: #F9B233;
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
		background: #F9B233 url("<?= APPIMAGEPATH; ?>up-arrow.png") no-repeat center 43%;
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
	background: #F9B233 url("<?= APPIMAGEPATH; ?>down-arrow.png") no-repeat center 43%;
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
				<li><a href="#equipo">Equipo</a></li>
				<li><a href="#incidencias">Incidencias</a></li>
				<li><a href="#appTrello">App</a></li>
				<li><a href="#soportes">Soportes</a></li>
				<li><a style="background-color: #337AB7 !important; color: #FFF;" href="<?= PROJECTURLMENU; ?>portal/home">Ir al Portal<span class="glyphicon glyphicon-arrow-right"></span></a></li>
			</ul>
		</div>
	</div>
</nav>

<div class="jumbotron text-center" style="padding-bottom: 20px;">
	<h1>Lanuza Group</h1>
	<p>Su compa&ntilde;&iacute;a de Soporte TI, redes, servicios en infraestrutura y m&aacute;s...</p> 
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
			<br/>al Portal <b>Sistema de Gesti&oacute;n de Soportes TI</b>
		</h3>
		</div>
		<div class="col-md-2">&nbsp;</div>
	</div>
</div>

<!-- div id="mantenimiento" class="container-fluid">
  <div class="row" style="margin-top: -60px;">
    <div class="col-sm-12 text-center">
      <h2>MANTENIMIENTO PROGRAMADO</h2>
      <img src="<?= APPIMAGEPATH; ?>construccion.jpg" class="img-rounded" alt="Compu" style="height: 150px; width: 200px;">
      <br/>
      <h4>
        <?php
            if( $genderMale == true) {
              echo "Estimado usuario";
            } else {
              echo "Estimada usuaria";
            }
          ?>,
        por tareas de mantenimiento y en aras de actualizar nuestro software, el portal <b>permanerecerá inactivo</b>
        los días <b>sábado 4 y domingo 5 de septiembre de 2021</b>. Rogamos disculpe las molestias.
        <br/>
        Si necesita hablar con nuestro equipo de Lanuza Group de forma urgente, puede contactarnos, durante el periodo de cierre, 
        directamente al correo <b>soporte@lanuzagroup.com</b>.
      </h4>
    </div>      
  </div>
</div -->

<!-- Container (About Section) -->
<div id="welcome" class="container-fluid">
	<br/>
	<div class="row">
		<div class="col-sm-3">
			&nbsp;
			<div class="hidden-xs">
				<span class="glyphicon glyphicon-briefcase logo slideanim"></span>
			</div>
		</div>
		<div class="col-sm-6 col-xs-12 text-center">
			<h2>Portal Sistema de Gesti&oacute;n de Soportes TI para <i>Gerentes</i></h2><br>
			<h4>
			  Bienvenid<?php
				if( $genderMale == true) {
					echo "o ";
				} else {
					echo "a ";
				}
				echo "<i>" . $user -> saludo . " " . $user -> nombre . " " . $user -> apellido . "</i>";
			?>
			<br/>al Portal <b>Sistema de Gesti&oacute;n de Soportes TI</b>
			</h4><br>
			<p>Usted hace parte de nuestra familia de <b>L&iacute;deres Empresariales</b> a los que le ofrecemos nuestros servicios.</p>
			<p>En nuestro Portal usted podr&aacute;...</p>
		</div>
		<div class="col-sm-3">
			&nbsp;
			<div class="hidden-xs">
				<span class="glyphicon glyphicon-ok logo slideanim"></span>
			</div>
		</div>
	</div>
</div>

<!-- Container (Services Section) -->
<div id="equipo" class="container-fluid text-center">
	<br/>
	<h2>Conocer el Estado de todos los Equipos de su Empresa</h2>
	<h4>Nosotros realizamos el Servicio de <mark>Inventario de Equipos</mark> para nuestros clientes.</h4>
	<p>Esto consiste en que nosotros recopilamos la informaci&oacute;n sobre los equipos de su
		Compa&ntilde;&iacute;a para que Usted conozca en detalle el <b>estado de todos los equipos</b>
		 con los que sus Empleados est&aacute;n trabajando.</p>
	<p>Entre la informaci&oacute;n que recaudamos est&aacute;...</p>
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
			<p>Tipo de Conex&oacute;n de Red: Ethernet, WiFi,... entre otros detalles.</p>
		</div>
		
		<div class="col-sm-4">
			<span class="glyphicon glyphicon-eye-open logo-small"></span>
			<h4>Conexi&oacute;n Remota</h4>
			<p>Acceso remoto a trav&eacute;s de Herramientas como TeamViewer, para ofrecerle <i>Soporte T&eacute;cnico a distancia</i></p>
		</div>
		
		<div class="col-sm-4">
			<span class="glyphicon glyphicon-wrench logo-small"></span>
			<h4 style="color:#303030;">Hardware</h4>
			<p>Tipo de Discos RAM, de Memoria, Horas de Uso, entre otros.</p>
		</div>
	</div>
</div>

<!-- Container (Portfolio Section) -->
<div id="incidencias" class="container-fluid text-center bg-grey">
	<br/>
	<h2>Creaci&oacute;n de incidencias</h2><br>
	<h4>&iquest;Alguna vez ha tenido usted o sus empleados inconvenientes como estos... &quest; </h4>
	<div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
			<li data-target="#myCarousel" data-slide-to="3"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<h4>"No enciende mi equipo"<!-- br><span style="font-style:normal;">Michael Roe, Vice President, Comment Box</span -->
				</h4>
			</div>
			<div class="item">
				<h4>"Est&aacute; muy lento el arranque del sistema"</h4>
			</div>
			<div class="item">
				<h4>"No puedo iniciar Word ni mi navegador"</h4>
			</div>
			<div class="item">
				<h4>"Veo la pantalla azul, no inicia Windows"</h4>
			</div>
		</div>

		<!-- Left and right controls -->
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

	<br/>
	
	<h2>Si es as&iacute;, somos la soluci&oacute;n perfecta para usted&excl; </h2>
	<h4>Si presentas alguno de estos inconvenientes, o cualquier otro, en tan solo 3 pasos podremos ayudarle, ya sea a Usted o a sus Empleados:</h4>
	<br/>
	<div class="row text-center slideanim">
		<div class="col-sm-4">
				<span class="glyphicon glyphicon-home logo-small"></span>
				<p><strong>1.- Entra en nuestro Portal</strong></p>
				<p>Con tu <mark>cuenta activa</mark>, ingresas por medio de tu usuario y contrase&ntilde;a a nuestro Portal.</p>
		</div>
		<div class="col-sm-4">
				<span class="glyphicon glyphicon-edit logo-small"></span>
				<p><strong>2.- Crea una nueva Incidencia</strong></p>
				<p>Con un sencillo <mark>formulario</mark> nos cuentas en qu&eacute; deseas que te ayudemos.</p>
		</div>
		<div class="col-sm-4">
				<span class="glyphicon glyphicon-eye-open logo-small"></span>
				<p><strong>3.- Nuestros t&eacute;cnicos le asistir&aacute;n</strong></p>
				<p>Ya sea de forma <mark>presencial</mark> (en tu puesto de trabajo, Empresa o Casa) 
					o de forma <mark>remota</mark> (a trav&eacute;s de herramientas como TeamViewer), 
					asignaremos a uno de nuestros t&eacute;cnicos para que le asista con su inconveniente.</p>
		</div>
	</div>

	<br/>

</div>

<!-- Container (Pricing Section) -->
<div id="appTrello" class="container-fluid">
	<br/>
	<div class="text-center">
		<h2>&iexcl;Un portal muy accesible&excl;</h2>
		<h4>Con nuestro Portal de Soporte TI, le ofrecemos un servicio en el que usted podr&aacute; acceder a trav&eacute;s de...</h4>
	</div>
	<div class="row slideanim">
		<div class="col-sm-4 col-xs-12">
			<div class="panel panel-default text-center">
				<div class="panel-heading">
					<h1>Escritorio o PC</h1>
				</div>
				<div class="panel-body">
					<p>Podr&aacute;s acceder desde cualquier navegador</p>
					<p>web como <strong>Google Chrome</strong>, </p>
					<p><strong>Mozilla Firefox</strong>, <strong>Safari</strong> o el de tu</p>
					<p>preferencia; desde los sistemas <strong>32 o 64 bits</strong>,</p>
					<p>desde computadoras <strong>todo-en-uno</strong> o cualquier otra.</p>
				</div>
				<div class="panel-footer text-center">
					<img src="<?= APPIMAGEPATH; ?>all_in_one.png" class="img-rounded" alt="Compu" width="95%" height="200">
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-xs-12">
			<div class="panel panel-default text-center">
				<div class="panel-heading">
					<h1>Celulares o Tablets</h1>
				</div>
				<div class="panel-body">
					<p>Nuestro Portal est&aacute; dise&ntilde;ado</p>
					<p>con un estilo <strong>responsivo</strong>,</p>
					<p>lo que significa que est&aacute; <strong>optimizado</strong></p>
					<p>para acceder tambi&eacute;n a trav&eacute;s de</p>
					<p>navegadores desde <strong>celulares inteligentes o tablets</strong>.</p>
				</div>
				<div class="panel-footer text-center">
					<img src="<?= APPIMAGEPATH; ?>celular.png" class="img-rounded" alt="Compu" style="width: 150px; height: 200px;">
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-xs-12">
			<div class="panel panel-default text-center">
				<div class="panel-heading">
					<h1>Diversos Sistemas</h1>
				</div>
				<div class="panel-body">
					<p>Al ser una aplicaci&oacute;n basada <strong>en la nube</strong>,</p>
					<p>usted podr&aacute; acceder a la informaci&oacute;n a </p>
					<p>trav&eacute;s de cualquier Sistema Operativo</p>
					<p>(<strong>Windows</strong>, <strong>Linux</strong> o <strong>Mac</strong>)</p>
					<p>o desde celulares y cualquier navegador m&oacute;vil.</p>
				</div>
				<div class="panel-footer text-center">
					<img src="<?= APPIMAGEPATH; ?>laptop.png" class="img-rounded" alt="Compu" width="95%" height="200">
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Container (Pricing Section) -->
<div id="informes" class="container-fluid">
	<br/>
	<div class="row slideanim text-center">
		<div class="col-sm-3">
			<br/><br/>
			<span class="glyphicon glyphicon-signal logo"></span>
		</div>
		<div class="col-sm-6">
			<h2 class="text-center">Reportes</h2>
			<br/>
			<p>
				Con el uso cont&iacute;nuo de nuestro Portal se van generando informaci&oacute;n que a Usted le
				podr&aacute; servir para una correcta <b>Toma de la Decisiones</b>. 
				Con nuestros informes sabr&aacute; si sus equipos necesitan un cambio, si son los adecuados
				para sus necesidades, si reportan fallas cont&iacute;nuamente, entre otros.
				<br/>
				Le brindaremos una <b>Asesor&iacute;a personalizada</b> adapt&aacute;ndonos a las necesidades de 
				su Empresa, con el completo an&aacute;lisis del inventario de sus Equipos podremos ayudarle
				proveyendole soluciones acertadas.
			</p>
		</div>
		<div class="col-sm-3">
			<br/><br/>
			<span class="glyphicon glyphicon-list-alt logo"></span>
		</div>
	</div>
</div>

<!-- Container (Contact Section) -->
<div id="soportes" class="container-fluid bg-grey">
	<br/>
	<h2 class="text-center">Soportes</h2>
	<div class="row">
		<div class="col-sm-2">
			&nbsp;
			<div class="hidden-xs text-right">
				<span class="glyphicon glyphicon-inbox logo-small slideanim"></span>
			</div>
		</div>
		<div class="col-sm-8 col-xs-12 text-center">
			<p>Mant&eacute;ngase informado sobre el <strong>estatus actual</strong> de los Soportes, 
				el <strong>Hist&oacute;rico</strong> de Soportes previos 
				y cu&aacute;ndo ser&aacute; el pr&oacute;ximo
				<strong>Soporte programado</strong> para todos sus Equipos.
			</p>
		</div>
		<div class="col-sm-2">
			&nbsp;
			<div class="hidden-xs text-left">
				<span class="glyphicon glyphicon-calendar logo-small slideanim"></span>
			</div>
		</div>
  </div>
  <br/><br/>


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
	<p>Sistema de Gesti&oacute;n de Soportes TI. Un Portal de <a href="https://lanuzasoft.com" title="P&aacute;gina Principal">Lanuza Group</a>.</p>
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
var menuArray = ["#welcome", "#equipo", "#incidencias", "#appTrello", "#informes", "#soportes"];

$("#showMeMore").click(function() {

		
		var sectionClicked = menuArray[iSectionClicked];
		iSectionClicked++;
		if ( iSectionClicked == 6 ){
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
