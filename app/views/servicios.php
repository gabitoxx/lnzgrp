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
		
		<section id="content"><div class="ic">Lanuza Group SAS - Official Website 2014</div>
			<div class="main">
				<div class="container_12">
				   
					<div class="wrapper">
					
						   
					   <h31>          L&iacute;neas de Servicio</h31>    
				   <article class="grid_12">
				   <figure><a href="<?= PROJECTURLMENU; ?>home/ITSupport"><img class="img-border2" src="<?= APPIMAGEPATH; ?>linea1.png" alt="" /></a></figure> 
				   
			  <h3></h3>
							<em class="text-1 margin-bot"><!--Consulting is one of <a class="link" target="_blank" href="http://blog.templatemonster.com/free-website-templates/">free website templates</a> created by TemplateMonster.com team. This website template is optimized for 1280X1024 screen resolution. It is also XHTML &amp; CSS valid.--> <br>Contamos con ingenieros, tecn&oacute;logos y t&eacute;cnicos, que proporcionar&aacute;n la mejor experiencia al cliente, ofreciendo una asistencia excepcional de hardware y/o software en el dispositivo afectado. <br> <br>
Dentro del portafolio de servicios de software ofrecemos: mantenimiento preventivo, mantenimiento correctivo, soporte remoto, intervenci&oacute;n en software especial, asistencia vital, instalaci&oacute;n de software, proveedur&iacute;a de software y licenciamiento. <br><br>
En cuanto a hardware ofrecemos: mantenimiento preventivo, mantenimiento correctivo, asistencia vital, relevo de hardware, alquiler de hardware y proveedur&iacute;a de partes y repuestos. <br><br>
Tambi&eacute;n contamos con el servicio de respaldo multiforme de sus datos, pues ofrecemos respaldo f&iacute;sico, respaldo en la nube, seguridad de datos, recuperaci&oacute;n de datos perdidos y estructuramos un sistema de digitalizaci&oacute;n y almacenamiento de la informaci&oacute;n. <br><br> <a class="link-1" href="<?= PROJECTURLMENU; ?>home/ITSupport">Leer m&aacute;s</a>
</em> 
				</article>
				<article class="grid_12">
					
			   <figure><a href="<?= PROJECTURLMENU; ?>home/infrastructure"><img class="img-border2" src="<?= APPIMAGEPATH; ?>linea2.png" alt="" /></a></figure>       
					<h3> </h3>
							<br><em class="text-1 margin-bot"><!--Consulting is one of <a class="link" target="_blank" href="http://blog.templatemonster.com/free-website-templates/">free website templates</a> created by TemplateMonster.com team. This website template is optimized for 1280X1024 screen resolution. It is also XHTML &amp; CSS valid.--> As&iacute; como la informaci&oacute;n es transcendental dentro de una organizaci&oacute;n, del mismo modo lo es, el medio por el cual se trasmite. Obtener una sinergia en el flujo de la informaci&oacute;n es determinante en una compañ&iacute;a para generar una productividad significativa y &oacute;ptima. <br><br>
Contamos con personal calificado y certificado, el cual ejecutar&aacute; una infraestructura est&eacute;tica e id&oacute;nea en su red de datos, que permitir&aacute; el intercambio de informaci&oacute;n fluida, sin retrasos y sin ca&iacute;das en la conexi&oacute;n. <br><br>
Dentro del portafolio de servicios ofrecemos: red de datos en categor&iacute;a 5e, 6 y 6a; red el&eacute;ctrica regulada y convencional; configuraci&oacute;n de los distintos dispositivos de red (router, switch, acces point, etc); seguridad y encriptaci&oacute;n de datos, configuraci&oacute;n de servidores, mantenimiento preventivo y correctivo de la red, certificaci&oacute;n de la red, proveedur&iacute;a de partes y dispositivos; backup de la conexi&oacute;n de internet y administraci&oacute;n de la red. <br><br> <a class="link-1" href="<?= PROJECTURLMENU; ?>home/infrastructure">Leer m&aacute;s</a>
</em>
				</article>
				<article class="grid_12">
			 
			  <figure><a href="<?= PROJECTURLMENU; ?>home/store"><img class="img-border2" src="<?= APPIMAGEPATH; ?>linea3.png" alt="" /></a></figure>    
				
			  <h3></h3>
						  <br>  <em class="text-1 margin-bot"><!--Consulting is one of <a class="link" target="_blank" href="http://blog.templatemonster.com/free-website-templates/">free website templates</a> created by TemplateMonster.com team. This website template is optimized for 1280X1024 screen resolution. It is also XHTML &amp; CSS valid.--> Optimizando nuestro portafolio tecnol&oacute;gico, proveemos todos los productos y/o dispositivos que se requieren en la ejecuci&oacute;n o implementaci&oacute;n de los servicios TIC. <br><br>
Store es la l&iacute;nea que opera y centraliza todos estos productos. Contamos con dispositivos m&oacute;viles, computadores port&aacute;tiles, equipos de escritorio, equipos corporativos, impresoras, servidores, entre otros. <br><br>
Adicional a esto, contamos con un equipo de trabajo ideal, que lo asesorar&aacute; en la compra de su dispositivo tecnol&oacute;gico, con el objetivo de tomar la mejor decisi&oacute;n para ahorrar costos y sacar el mejor provecho a su dispositivo. <br><br>
 <a class="link-1" href="<?= PROJECTURLMENU; ?>home/store">Leer m&aacute;s</a></em>
					
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