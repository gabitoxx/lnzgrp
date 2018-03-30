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


</head>

<body id="page1"> <!-- onload="javascript:alert('<?= PROJECTURL; ?>');" -->

	<!-- div class="extra" -->

		<!--==============================header=================================-->

		<header>

			<?php 
				$MENUACTIVE   = "SERVICES";
				$fileLocation = 'templates/headerFormMenu.php';
				include( $fileLocation );
			?>

			<?php 
				$fileLocation = 'templates/carouselHtml.php';
				include( $fileLocation );
			?>
		</header>          

		<!--==============================content================================-->
	   <section id="content">
		  <div class="ic">Lanuza Group SAS - Official Website</div>
			<div class="main">
				<div class="container_12">
					
					<div class="wrapper">
					
					<h3> Infraestructura en Redes de Datos y Red electrica Complementaria</h3>
							<em class="text-1 margin-bot"><!--Consulting is one of <a class="link" target="_blank" href="http://blog.templatemonster.com/free-website-templates/">free website templates</a> created by TemplateMonster.com team. This website template is optimized for 1280X1024 screen resolution. It is also XHTML &amp; CSS valid.--> La conexi&oacute;n y comunicaci&oacute;n, eficaz y eficiente de la redes de datos es de vital importancia para su empresa, por eso Lanuza Group
ofrece el diseño y cableado estructural para su organizaci&oacute;n en categoria 5e, 6 y 6a; ejecuta enlaces WiFi, ofrece la implementaci&oacute;n
del patch panel, rack, estructurado de la red electrica para los dispositivos, auditoria, certificaci&oacute;n de la red y administraci&oacute;n de la red.</em>
					
				<article class="grid_12">
								<h3>Servicios</h3>
								<div class="wrapper p3">
									<article class="grid_4 alpha">
										<div class="wrapper">
											<figure class="img-indent3"><img src="<?= APPIMAGEPATH; ?>certificacionred.png" alt="" /></figure>
											<div class="extra-wrap">
												<h4 class="p1"> Implementaci&oacute;n <strong>y Certificaci&oacute;n</strong></h4>
												<p class="prev-indent-bot">Contamos con el personal certificado y calificado, con el cual estructuramos redes de datos en categor&iacute;as 5e, 6 y 6a, del mismo modo ofrecemos la adecuaci&oacute;n red el&eacute;ctrica regulada y/o convencional para cada dispositivo de la red de trabajo. La certificaci&oacute;n se lleva a cabo con equipos Fluke de &uacute;ltima generaci&oacute;n y todos los recursos f&iacute;sicos utilizados en el levantamiento de la infraestructura, cuentan con la correspondiente certificaci&oacute;n.</p>
												<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer m&aacute;s</a>
											</div>
										</div>
									</article>
									<article class="grid_4">
										<div class="wrapper">
											<figure class="img-indent2"><img src="<?= APPIMAGEPATH; ?>seguridadred.png" alt="" /></figure>
											<div class="extra-wrap">
												<h4 class="p1">Administraci&oacute;n <strong>en Redes de Datos</strong></h4>
												<p class="prev-indent-bot">Desde la importante experiencia con la que cuenta nuestro equipo de trabajo, ingenieros y programadores, agregamos el componente de seguridad a toda la red de datos de la organizaci&oacute;n, configurando cada dispositivo de la red con los &uacute;ltimos est&aacute;ndares de seguridad inform&aacute;tica, aplic&aacute;ndolos seg&uacute;n la necesidad de cada organizaci&oacute;n, con el objetivo de que la red sea completamente administrable, fluida y segura. Dentro de la configuraci&oacute;n de la red se establecen unas pol&iacute;ticas de seguridad, una de ellas que es transversal en todas las organizaciones es el bloqueo de p&aacute;ginas web y redes sociales para usuarios.</p>
												<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer m&aacute;s</a>
											</div>
										</div>
									</article>
									<article class="grid_4 omega">
										<div class="indent-left3">
											<div class="wrapper">
												<figure class="img-indent3"><img src="<?= APPIMAGEPATH; ?>mantenimientored.png" alt="" /></figure>
												<div class="extra-wrap">
													<h4 class="p1">Mantenimiento<strong>de las Redes</strong></h4>
													<p class="prev-indent-bot">Es importante realizar el mantenimiento peri&oacute;dico de la infraestructura en la red, con el fin de proteger los dispositivos, los otros activos de la organizaci&oacute;n y lo m&aacute;s importante, la valiosa informaci&oacute;n. Nosotros ejecutamos un mantenimiento id&oacute;neo, pr&aacute;ctico y eficiente, para alargar la vida &uacute;til de toda la infraestructura de la red local de trabajo, tanto en la de datos como en la el&eacute;ctrica. Esto le permitir&aacute; un ahorro importante y le evitar&aacute; un gasto futuro, del mismo modo cuidar la inversi&oacute;n le evitar&aacute; circunstancias que pueden ser lamentables, pues una falla en la red se traduce en menos producci&oacute;n, p&eacute;rdida de tiempo y de dinero.</p>
													<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer m&aacute;s</a>
												</div>
											</div>
										</div>
									</article>
								</div>
								<div class="wrapper">
									<article class="grid_4 alpha">
										<div class="wrapper">
											<figure class="img-indent3"><img src="<?= APPIMAGEPATH; ?>ups.png" alt="" /></figure>
											<div class="extra-wrap">
												<h4 class="p1">Red El&eacute;ctrica y <strong>UPS</strong></h4>
												<p class="prev-indent-bot"> Proporcionar una fuente de energ&iacute;a estable y continua independientemente de las variaciones que puedan presentarse en la red el&eacute;ctrica es un ideal dentro de la organizaci&oacute;n, con el objetivo de proteger los equipos, prevenir daños, prevenir una p&eacute;rdida en la productividad y proteger los datos.</p>
												<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer m&aacute;s</a>
											</div>
										</div>
									</article>
									<article class="grid_4">
										<div class="wrapper">
											<figure class="img-indent2"><img src="<?= APPIMAGEPATH; ?>servidores.png" alt="" /></figure>
											<div class="extra-wrap">
												<h4 class="p1">Instalaci&oacute;n <strong>de Servidores</strong></h4>
												<p class="prev-indent-bot">As&iacute; como en el proceso administrativo es importante contar con un gerente que lidere y gestione la organizaci&oacute;n, del mismo modo, un servidor trabaja como un gerente de la red, gestionando los usuarios y la informaci&oacute;n de forma centralizada. Nosotros sincronizamos su servidor en la nube para que su informaci&oacute;n siempre est&eacute; a salvo.</p>
												<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer m&aacute;s</a>
											</div>
										</div>
									</article>
									<article class="grid_4 omega">
										<div class="indent-left3">
											<div class="wrapper">
												<figure class="img-indent3"><img src="<?= APPIMAGEPATH; ?>planb.png" alt="" /></figure>
												<div class="extra-wrap">
													<h4 class="p1">Backup WAN <strong>(de Internet)</strong></h4>
													<p class="prev-indent-bot"> Con el objetivo de que nunca se pierda la conexi&oacute;n a internet, implementamos un doble enlace WAN en su red de datos.</p>
													<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer m&aacute;s</a>
												</div>
											</div>
										</div>
									</article>
								</div>
							</article>
						</div>
						<div class="wrapper">
							<!--article class="grid_8">
								<h3>Servicios Especiales</h3>
								<div class="wrapper">
									<figure class="img-indent"><img class="img-border" src="<?= APPIMAGEPATH; ?>page3-img7.jpg" alt="" /></figure>
									<div class="extra-wrap">
										<p>Optimizaci&oacute;n de procesos TIC dentro de su organizaci&oacute;n, implementaci&oacute;n de sistemas de archivo y digitalizaci&oacute;n atomatizada en la nube, instalaci&oacute;n y adecuaci&oacute;n de software especializado como CRM, ERP, BPM, etc. Estas herramientas generan un ahorro significativo de tiempo y por ende una mayor rentabilidad al final del periodo en un mediano y largo plazo.</p>
										<ul class="list-1">
											<li><a href="<?= PROJECTURLMENU; ?>home/underConstruction">Implementaci&oacute;n de software especializado.</a></li>
											<li><a href="<?= PROJECTURLMENU; ?>home/underConstruction">Sistema de digitalizaci&oacute;n y archivo autom&aacute;tico en la nube.</a></li>
										</ul>
									</div>
								</div>
							</article-->   
						</div>
					</div>
				</div>
			</section>



		<!--==============================footer================================-->
	<?php 

		$fileLocation = 'templates/scripts.php';
		include( $fileLocation );
		
		$fileLocation = 'templates/footerForm.php';
		include( $fileLocation );
	?>

</body>

</html>