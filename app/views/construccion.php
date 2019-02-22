<!DOCTYPE html>

<html lang="es">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Favicons ================================================== -->

	<?php 
		/**
		$fileLocation = 'templates/headerLinksAndMetas.php';
		include( $fileLocation );
		*/
	?>
	<title>En Mantenimiento</title>


</head>

<body id="page1"> <!-- onload="javascript:alert('<?= PROJECTURL; ?>');" -->

	<!-- div class="extra" -->

		<!--==============================header=================================-->

		<header>

			<?php 
				/**
				$MENUACTIVE   = "ABOUT";
				$fileLocation = 'templates/headerFormMenu.php';
				include( $fileLocation );
				*/
			?>

			<?php 
				/** 
				$fileLocation = 'templates/carouselHtml.php';
				include( $fileLocation );  
				*/
			?>
		</header>

		<!--==============================content================================-->
	   <section id="content"><div class="ic">Lanuza Group SAS - Official Website</div>
			<div class="main">
				<div class="container_12">
					<div class="wrapper">
						
						<article class="grid_4" style="text-align:center;">
						
							<h1> En Mantenimiento...<h1>
							
							<figure class="img-indent2"><img src="<?= APPIMAGEPATH; ?>construccion.jpg" alt="" />
							
							<p>
								Está previsto llevar a cabo la siguiente intervención planificada en 
								la plataforma 
								<br/>
								con el fin de hacer la migración del servicio al nuevo Hosting; 
								intervención que se llevará a cabo:
								<br/><br/>
								<b><u>Sábado y Domingo, 16 y 17 de Junio de 2018</u></b>
								<br/><br/>
								Durante la intervención, se tendrá indisponibilidad total del servicio.
								<br/>
								Ofrecemos disculpas por las molestias que esta intervención pueda causar.
								<br/>
								Cualquier duda o comentario contactar con la dirección de correo direccion@lanuzagroup.com
							</p>
						</article>
					</div>
				</div>
			</div>
		</section>


		<!--==============================footer================================-->
	<?php 

		/** 
		$fileLocation = 'templates/scripts.php';
		include( $fileLocation );
		
		$fileLocation = 'templates/footerForm.php';
		include( $fileLocation );
		*/
	?>

</body>

</html>