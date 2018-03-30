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
				/** $fileLocation = 'templates/carouselHtml.php';
				include( $fileLocation );  */
			?>
		</header>

		<!--==============================content================================-->
	   <section id="content"><div class="ic">Lanuza Group SAS - Official Website</div>
			<div class="main">
				<div class="container_12">
					<div class="wrapper">
						
						<article class="grid_4" style="text-align:center;">
						
						<h3> En Construcción...<h3>
						
						<figure class="img-indent2"><img src="<?= APPIMAGEPATH; ?>construccion.jpg" alt="" />
						
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