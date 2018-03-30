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
				$MENUACTIVE   = "ABOUT";
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
			<div class="content-bg">
				<div class="main">
					<div class="container_12">
						<div class="wrapper">
							

							<article class="grid_4">
								<h3>Equipo de Trabajo</h3>
								<div class="wrapper indent-bot2">
									<figure class="img-indent"><a href="#"><img class="img-border" src="<?= APPIMAGEPATH; ?>Anderson.jpg" alt="" /></a></figure>
									<div class="extra-wrap">
										<span class="text-2">Director General</span>
										<h4 class="p1">Anderson Lanuza</h4>
										Programador de sistemas, emprendedor y empresario vinculado al programa Microsoft Bizspark y miembro de Microsoft Partner Network.
									</div>
								</div>
								<div class="wrapper indent-bot2">
									<figure class="img-indent"><a href="#"><img class="img-border" src="<?= APPIMAGEPATH; ?>Ricardo.jpg" alt="" /></a></figure>
									<div class="extra-wrap">
										<span class="text-2">Gerente de Proyectos</span>
										<h4 class="p1">Ricardo Valdivieso</h4>
										MBA con &eacute;nfasis en Proyectos y Administrador de Empresas. Especialista en planificaci&oacute;n y direcci&oacute;n en los procesos de contrataci&oacute;n con organizaciones privadas y p&uacute;blicas.
									</div>
								</div>
								<div class="wrapper indent-bot2">
									<figure class="img-indent"><a href="#"><img class="img-border" src="<?= APPIMAGEPATH; ?>Guillermo.jpg" alt="" /></a></figure>
									<div class="extra-wrap">
										<span class="text-2">Desarrollador Web Avanzado</span>
										<h4 class="p1">Guillermo Gallego</h4>
										Programador y desarrollador web, JQuery expert, PHP Expert, Ajax, HTML, CSS3, MySQL, especializado en e-commerce y bases de datos. 
									</div>
								</div>
								<div class="wrapper">
									<figure class="img-indent"><a href="#"><img class="img-border" src="<?= APPIMAGEPATH; ?>Alexandra.jpg" alt="" /></a></figure>
									<div class="extra-wrap">
										<span class="text-2">Digital Community Management</span>
										<h4 class="p1">Alexandra Hernandez</h4>
										Estratega Digital y Publicista especialista en marketing digital y social media. 
									</div>
								</div>
							</article>
							<article class="grid_8">
								<div class="indent-left2">
									<h3>Nuestro compromiso son ustedes. </h3>
								</div>
								<div class="wrapper indent-bot">
									<article class="grid_4 alpha">
										<div class="indent-left2">
											<figure class="p2"><img class="img-border" src="<?= APPIMAGEPATH; ?>page2-img5.jpg" alt="" /></figure>
											<h4 class="p1">Misi&oacute;n</h4>
											Ejecutar soluciones eficientes y pr&aacute;cticas de acuerdo a las necesidades de cada cliente, ofreciendo productos tecnol&oacute;gicos de vanguardia y un soporte TI con calidad, seguimiento y garant&iacute;a. <br> <br> <br>
											
											<h4 class="p1">Valores Corporativos</h4>
											Fe en cada paso que damos junto a usted.<br>
Creatividad e innovaci&oacute;n en todos nuestros procesos.<br>
Pasi&oacute;n por la tecnolog&iacute;a y el cambio.<br>
Servicio a la sociedad con responsabilidad.<br>
Practicidad y agilidad en el soporte.<br>
Calidad y garant&iacute;a en los servicios ejecutados.<br>                                    
										</div>
									</article>
									<article class="grid_4 omega">
										<div class="indent-left2">
											<figure class="p2"><img class="img-border" src="<?= APPIMAGEPATH; ?>page2-img6.jpg" alt="" /></figure>
											<h4 class="p1">Visi&oacute;n</h4>
											Ser reconocida en el 2025 como una empresa l&iacute;der en soporte TI.
										</div>
									</article>
								</div>
								<div class="indent-left2">
									<h3>Sobre Nosotros</h3>
									<p>Lanuza Group es una empresa Colombiana cuya oficina principal se encuentra en la capital, Bogot&aacute;. Nace el 15 de agosto de 2012 y cuenta con un equipo de profesionales con m&aacute;s de 8 años de experiencia en el sector TIC (Tecnolog&iacute;as de la informaci&oacute;n y comunicaci&oacute;n)
<br><br>Ha desarrollado un portafolio de servicios id&oacute;neo en soporte TI, con el objetivo de mejorar la experiencia de los usuarios en el uso de los dispositivos tecnol&oacute;gicos y as&iacute; mismo aumentar la productividad de las organizaciones que cuentan con nuestro apoyo. <br><br>
Creemos en el cambio, en un mejor entorno y en que su empresa aumentar&aacute; significativamente la productividad si sus dispositivos tienen nuestro sello de calidad. <br>
</p>
								</div>
								<div class="wrapper">
									<article class="grid_4 alpha">
										<div class="indent-left2">
											<ul class="list-1">
												<!--li><a href="#">At vero eos et accusamus et iusto</a></li>
												<li><a href="#">Dignissimos ducimus qui blanditiis prae</a></li>
											</ul>
										</div>
									</article>
									<article class="grid_4 omega">
										<div class="indent-left2">
											<ul class="list-1">
												<li><a href="#">At vero eos et accusamus et iusto</a></li>
												<li><a href="#">Dignissimos ducimus qui blanditiis prae</a></li-->
											</ul>
										</div>
									</article>
								</div>
							</article>
						
						</div>
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