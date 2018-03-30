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
			<div class="ic">Lanuza Group SAS - Official Website 2014</div>
			<div class="main">
				<div class="container_12">
					
					<div class="wrapper">
					
					<h3>Soporte TI</h3>
							<em class="text-1 margin-bot"><!--Consulting is one of <a class="link" target="_blank" href="http://blog.templatemonster.com/free-website-templates/">free website templates</a> created by TemplateMonster.com team. This website template is optimized for 1280X1024 screen resolution. It is also XHTML &amp; CSS valid.--> Cuidar los activos fijos de la organizaci&oacute;n no es solo un acto de sentido de pertenencia, es una inversi&oacute;n que dará sus frutos al corto y largo plazo. El mantenimiento oportuno de los equipos de c&oacute;mputo y demás dispositivos tecnol&oacute;gicos, permitir&iacute;an un aumento significativo en la productividad de la organizaci&oacute;n y mejorará el clima organizacional, ya que los usuarios se sentirán satisfechos con sus herramientas de trabajo.</em>
					
				<article class="grid_12">
								<h3>Servicios</h3>
								<div class="wrapper p3">
									<article class="grid_4 alpha">
										<div class="wrapper">
											<figure class="img-indent3"><img src="<?= APPIMAGEPATH; ?>mantenimientop.png" alt="" /></figure>
											<div class="extra-wrap">
												<h4 class="p1"> Mantenimiento <strong>Preventivo</strong></h4>
												<p class="prev-indent-bot">Revisi&oacute;n peri&oacute;dica del software y del hardware con el objetivo de evaluar su estado, obtener un diagn&oacute;stico y ejecutar herramientas de procesos de prevenci&oacute;n, como eliminaci&oacute;n de software potencialmente no deseado, virus, desfragmentar los discos magn&eacute;ticos, entre otros. Estos procesos influyen en el &oacute;ptimo desempeño del dispositivo, en la integridad de la informaci&oacute;n almacenada y en el intercambio id&oacute;neo de los datos..</p>
												<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer más</a>
											</div>
										</div>
									</article>
									<article class="grid_4">
										<div class="wrapper">
											<figure class="img-indent2"><img src="<?= APPIMAGEPATH; ?>mantenimientoc.png" alt="" /></figure>
											<div class="extra-wrap">
												<h4 class="p1">Mantenimiento <strong>Correctivo</strong></h4>
												<p class="prev-indent-bot">Este tipo de mantenimiento se realiza de inesperadamente, cuando un dispositivo presenta fallas o deficiencias tanto en el software como en el hardware e interrumpe con las actividades diarias del usuario, impidiendo las ejecuci&oacute;n de su proceso diario.</p>
												<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer más</a>
											</div>
										</div>
									</article>
									<article class="grid_4 omega">
										<div class="indent-left3">
											<div class="wrapper">
												<figure class="img-indent3"><img src="<?= APPIMAGEPATH; ?>licenciamiento.png" alt="" /></figure>
												<div class="extra-wrap">
													<h4 class="p1">Licenciamiento  <strong>de Software</strong></h4>
													<p class="prev-indent-bot">Somos especialistas en licenciar sus herramientas de trabajo, con el objetivo de que sus equipos siempre trabajen en &oacute;ptimas condiciones y no sufran riesgos de seguridad. Licenciamos Office y  Windows especialmente.</p>
													<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer más</a>
												</div>
											</div>
										</div>
									</article>
								</div>
								<div class="wrapper">
									<article class="grid_4 alpha">
										<div class="wrapper">
											<figure class="img-indent3"><img src="<?= APPIMAGEPATH; ?>soportevital.png" alt="" /></figure>
											<div class="extra-wrap">
												<h4 class="p1">Soporte <strong>Remoto y Vital</strong></h4>
												<p class="prev-indent-bot">El soporte remoto consiste en controlar un dispositivo a distancia con el objetivo de responder inmediatamente al requerimiento del usuario y de esta manera ahorrar tiempo valioso. El soporte vital es un soporte presencial atendido de forma inmediata despu&eacute;s de generar un requerimiento, se ejecuta cuando es de suma importancia atender un dispositivo al cual no se puede acceder de forma remota.</p>
												<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer más</a>
											</div>
										</div>
									</article>
									<article class="grid_4">
										<div class="wrapper">
											<figure class="img-indent2"><img src="<?= APPIMAGEPATH; ?>relevo.png" alt="" /></figure>
											<div class="extra-wrap">
												<h4 class="p1">Relevo y Alquiler <strong>de Hardware</strong></h4>
												<p class="prev-indent-bot">Cuando su dispositivo no responda y requiera de un mantenimiento correctivo que puede tardar un tiempo importante, simplemente nosotros relevamos su hardware para que no le genere p&eacute;rdida de tiempo y de dinero. Tambien ofrecemos el servicio de alquiler, diseñado para aquellas compañ&iacute;as que requieren hardware temporal.</p>
												<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer más</a>
											</div>
										</div>
									</article>
									<article class="grid_4 omega">
										<div class="indent-left3">
											<div class="wrapper">
												<figure class="img-indent3"><img src="<?= APPIMAGEPATH; ?>restauracion.png" alt="" /></figure>
												<div class="extra-wrap">
													<h4 class="p1">Restauraci&oacute;n y <strong>Backups de Datos</strong></h4>
													<p class="prev-indent-bot">Si su informaci&oacute;n se borr&oacute;, se perdi&oacute; o simplemente no apare, nosotros a trav&eacute;s de procesos especializados podemos recuperar su informaci&oacute;n. No obstante con el objetivo de que esto nunca le suceda, generamos respaldos de su informaci&oacute;n en discos f&iacute;sicos y en la nube.</p>
													<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer más</a>
												</div>
											</div>
										</div>
									</article>
								</div>
							</article>
						</div>
						<div class="wrapper">
							<article class="grid_8">
								<h3>Servicios Especiales</h3>
								<div class="wrapper">
									<figure class="img-indent"><img class="img-border" src="<?= APPIMAGEPATH; ?>page3-img7.jpg" alt="" /></figure>
									<div class="extra-wrap">
										<p>Optimizaci&oacute;n de procesos TIC dentro de su organizaci&oacute;n, implementaci&oacute;n de sistemas de archivo y digitalizaci&oacute;n atomatizada en la nube, instalaci&oacute;n y adecuaci&oacute;n de software especializado como CRM, ERP, BPM, etc. Estas herramientas generan un ahorro significativo de tiempo y por ende una mayor rentabilidad al final del periodo en un mediano y largo plazo.</p>
										<ul class="list-1">
											<li><a href="<?= PROJECTURLMENU; ?>home/underConstruction">Implementaci&oacute;n de software especializado.</a></li>
											<li><a href="<?= PROJECTURLMENU; ?>home/underConstruction">Sistema de digitalizaci&oacute;n y archivo automático en la nube.</a></li>
										</ul>
									</div>
								</div>
							</article>
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