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
				$MENUACTIVE   = "CONTACT";
				$fileLocation = 'templates/headerFormMenu.php';
				include( $fileLocation );
			?>
		</header>
		
		<!--==============================content================================-->
		<section id="content"><div class="ic">Lanuza Group SAS - Official Website 2014</div>
			<div class="content-bg">
				<div class="main">
					<div class="container_12">
						<div class="wrapper">   
							<article class="grid_12">
								<h3>Informaci&oacute;n</h3>
								<figure class="img-indent-bot img-border">
									<iframe width="80%" height="40%" src="https://www.google.com/maps/d/embed?mid=zxdFBeDBw2t0.kyT3g6jbZlHE"></iframe>
								</figure>
								<dl>
									<dt class="indent-bot">Colombia - Bogot&aacute;.</dt>
									<dd><h4 class="p3"><span>PBX:</span>  +057 508 8376</h4></dd>
									<dd><h4 class="p3"><span>M&oacute;vil:</span>  +318 312 1085</h4></dd>
									
									<dd><h4 class="p3"><span>Email:</span><a href="#"><?= CONTACTEMAIL1; ?></a></h4></dd>
									<dd><h4 class="p3"><span>Email:</span><a href="#"><?= CONTACTEMAIL2; ?></a></h4></dd>
								</dl>
							</article>
							
							<article class="grid_8">
								<div class="extra-wrap">
									<br/><br/>
								  <h4 class="p1" style="text-align:center;"><strong>Formulario de Contacto</strong></h4>
								  <br/><br/>
								  <h4 class="p3">Si desea enviarnos un correo electr&oacute;nico con alg&uacute;n requerimiento,
									  consulta o para conocer m&aacute;s sobre nuestros Productos o Servicios, le invitamos a llenar el 
									  <mark><b>formulario al pie de p&aacute;gina</b></mark>,
									  y con gusto le responderemos a la brevedad posible.
								  </h4>
							</div>
						 </article>
						 <article class="grid_4">
							<div class="wrapper p1">
								<figure class="img-indent2"><img src="<?= APPIMAGEPATH; ?>contacto-img3-01.png" alt="" /></figure>
								<div class="extra-wrap">
									<div class="indent-top">
								   <a class="link-1" href="<?= PROJECTURLMENU; ?>home/downloads">
										<h4>Descargas</h4>
								   </a> 
								   <p class="prev-indent-bot">(Software Libre)</p>
									</div>
								</div>
							</div>
							<p class="prev-indent-bot">En este espacio encontrará programas gratuitos que son de funcionamiento vital y/o necesario para su dispositivo Windows.</p>
							<a class="link-1" href="<?= PROJECTURLMENU; ?>home/downloads">Ir a descargas</a>
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