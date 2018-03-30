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
					
					<h3> Store - Asesor&iacute;a y Proveedur&iacute;a de Hardware B&aacute;sico y Especializado</h3>
							<em class="text-1 margin-bot"><!--Consulting is one of <a class="link" target="_blank" href="http://blog.templatemonster.com/free-website-templates/">free website templates</a> created by TemplateMonster.com team. This website template is optimized for 1280X1024 screen resolution. It is also XHTML &amp; CSS valid.--> Optimizando el portafolio tecnol&oacute;gico, hemos agregado el servicio de  proveedur&iacute;a de todos los productos y/o dispositivos que se requieren en la ejecuci&oacute;n o implementaci&oacute;n de los servicios TIC.
Store es la l&iacute;nea que opera y centraliza todos estos productos. Contamos con dispositivos m&oacute;viles, equipos corporativos, computadores port&aacute;tiles, equipos de escritorio, impresoras, servidores, entre otros.
Adicional a esto, Lanuza Group cuenta con un equipo de trabajo ideal, que lo asesorar&aacute; en la compra de su dispositivo tecnol&oacute;gico, con el objetivo de tomar la mejor decisi&oacute;n para ahorrar costos y sacar el mejor provecho a su dispositivo.
</em>
					
				<article class="grid_12">
								<h3>Servicios</h3>
								<div class="wrapper p3">
									<article class="grid_4 alpha">
										<div class="wrapper">
											<figure class="img-indent3"><img src="<?= APPIMAGEPATH; ?>asesoria.png" alt="" /></figure>
											<div class="extra-wrap">
												<h4 class="p1"> Asesor&iacute;a  <strong> de Compra</strong></h4>
												<p class="prev-indent-bot">Brindamos una asesor&iacute;a y acompañamiento para que el cliente encuentre el dispositivo perfecto que se adapte a sus necesidades, analizamos con el cliente de forma clara, transparente e imparcial todas las marcas hasta encontrar el dispositivo id&oacute;neo.</p>
												<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer m&aacute;s</a>
											</div>
										</div>
									</article>
									<article class="grid_4">
										<div class="wrapper">
											<figure class="img-indent2"><img src="<?= APPIMAGEPATH; ?>dispositivos.png" alt="" /></figure>
											<div class="extra-wrap">
												<h4 class="p1">Dispositivos <strong>y Perif&eacute;ricos</strong></h4>
												<p class="prev-indent-bot">Proveemos computadores de escritorio, equipos corporativos, port&aacute;tiles, todo en uno, tabletas, celulares inteligentes, monitores, impresoras l&aacute;ser, impresoras de inyecci&oacute;n, impresoras multifuncionales, video proyectores, esc&aacute;neres de alta velocidad, esc&aacute;neres sencillos, c&aacute;maras, altavoces, t&aacute;ctiles, unidades de almacenamiento externas, tarjetas de red, m&oacute;dems, routers y access point.</p>
												<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer m&aacute;s</a>
											</div>
										</div>
									</article>
									<article class="grid_4 omega">
										<div class="indent-left3">
											<div class="wrapper">
												<figure class="img-indent3"><img src="<?= APPIMAGEPATH; ?>partes.png" alt="" /></figure>
												<div class="extra-wrap">
													<h4 class="p1">Partes, Accesorios<strong>y Suministros</strong></h4>
													<p class="prev-indent-bot">Tambi&eacute;n proveemos boards, procesadores, memorias RAM, discos duros, discos s&oacute;lidos, unidades de DVDRW, unidades de Blu-ray, tarjetas de video, tarjetas de sonido, tarjetas de radio y televisi&oacute;n fuentes de poder, cajas, reguladores, ups, bater&iacute;as, cargadores, cables, diademas, tonner, cartuchos y tintas.</p>
													<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer m&aacute;s</a>
												</div>
											</div>
										</div>
									</article>
								</div>
								<div class="wrapper">
									<article class="grid_4 alpha">
										<div class="wrapper">
											<figure class="img-indent3"><img src="<?= APPIMAGEPATH; ?>licencias.png" alt="" /></figure>
											<div class="extra-wrap">
												<h4 class="p1">Licencias<strong></strong></h4>
												<p class="prev-indent-bot"> En el contexto de software proveemos licencias de Microsoft Office, Microsoft Windows, antivirus como Eset Nod 32, Kaspersky e Internet Security. Tanto para personas naturales como para empresas. </p>
												<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer m&aacute;s</a>
											</div>
										</div>
									</article>
									<article class="grid_4">
										<div class="wrapper">
											<figure class="img-indent2"><img src="<?= APPIMAGEPATH; ?>seguimiento.png" alt="" /></figure>
											<div class="extra-wrap">
												<h4 class="p1">Seguimiento <strong>de Productos</strong></h4>
												<p class="prev-indent-bot">Entendemos que usted necesita un acompañamiento pos venta por eso brindamos seguimiento constante durante los 3 meses siguientes a la compra de su dispositivo y adicional le ofrecemos un mantenimiento preventivo gratuito para ejecutar durante el periodo del seguimiento.</p>
												<a class="link-1" href="<?= PROJECTURLMENU; ?>home/underConstruction">Conocer m&aacute;s</a>
											</div>
										</div>
									</article>
									<article class="grid_4 omega">
										<div class="indent-left3">
											<div class="wrapper">
												<figure class="img-indent3"><img src="<?= APPIMAGEPATH; ?>garantias.png" alt="" /></figure>
												<div class="extra-wrap">
													<h4 class="p1">Marcas <strong>Recomendadas</strong></h4>
													<p class="prev-indent-bot"> Nosotros solo ofrecemos productos de marcas registradas y garantizadas que brinden soporte en territorio Colombiano, con el objetivo de ofrecerle al usuario una experiencia agradable y calidad en el servicio de proveedur&iacute;a. Algunas de estas marcas son Intel, Amd, Asus, Lenovo, Acer, Dell, Toshiba, Samsung, AOC, HP, Compaq, Cisco, TP-Link, Genius, Hitachi, Seagate, Epson, Kingstong, Patriot, Sandisk, GeForce, Nvidia, Microsoft y Viewsonic entre otras.</p>
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