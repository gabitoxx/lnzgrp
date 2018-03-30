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
		

	  <div class="jumbotron text-center">
  <h1>My First Bootstrap Page</h1>
  <p>Resize this responsive page to see the effect!</p> 
</div>
  
<div class="container">
  <div class="row">
  	<div class="col-sm-12">
  		<h3>Informaci&oacute;n</h3>
		<figure class="img-indent-bot img-border">
			<iframe width="80%" height="40%" src="https://www.google.com/maps/d/embed?mid=zxdFBeDBw2t0.kyT3g6jbZlHE"></iframe>
		</figure>
  	</div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <h3>Column 1</h3>
      <dl>
		<dt class="indent-bot">Colombia - Bogot&aacute;.</dt>
		<dd><h4 class="p3"><span>PBX:</span>  +057 508 8376</h4></dd>
		<dd><h4 class="p3"><span>M&oacute;vil:</span>  +318 312 1085</h4></dd>
		
		<dd><h4 class="p3"><span>Email:</span><a href="#"><?= CONTACTEMAIL1; ?></a></h4></dd>
		<dd><h4 class="p3"><span>Email:</span><a href="#"><?= CONTACTEMAIL2; ?></a></h4></dd>
	</dl>
    </div>
    <div class="col-sm-6">
      <h3>Column 2</h3>
        <figure class="img-indent2">
      		<img src="<?= APPIMAGEPATH; ?>contacto-img3-01.png" alt="" />
      	</figure>
	    <a class="link-1" href="<?= PROJECTURLMENU; ?>home/downloads">
			<h4>Descargas</h4>
	    </a> 
	    <p class="prev-indent-bot">(Software Libre)</p>
		<p class="prev-indent-bot">En este espacio encontrará programas gratuitos que son de funcionamiento vital y/o necesario para su dispositivo Windows.</p>
		<a class="link-1" href="<?= PROJECTURLMENU; ?>home/downloads">Ir a descargas</a>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <h3>Column 3</h3>        
      <br/><br/>
	   <h4 class="p1" style="text-align:center;"><strong>Formulario de Contacto</strong></h4>
	  <br/><br/>
	  <h4 >Si desea enviarnos un correo electr&oacute;nico con alg&uacute;n requerimiento,
		  consulta o para conocer m&aacute;s sobre nuestros Productos o Servicios, le invitamos a llenar el 
		  <mark><b>formulario al pie de p&aacute;gina</b></mark>,
		  y con gusto le responderemos a la brevedad posible.
	  </h4>
    </div>
  </div>
</div>



		<!--==============================footer================================-->
	<?php 

		$fileLocation = 'templates/scripts.php';
		include( $fileLocation );
		
		$fileLocation = 'templates/footerForm.php';
		include( $fileLocation );
	?>

</body>

</html>