<!DOCTYPE html><html lang="es"><head>	<meta charset="utf-8">	<meta http-equiv="X-UA-Compatible" content="IE=edge">	<meta name="viewport" content="width=device-width, initial-scale=1"><!-- Favicons ================================================== -->	<?php 		$fileLocation = 'templates/headerLinksAndMetas.php';		include( $fileLocation );	?></head><body id="page1"> <!-- onload="javascript:alert('<?= PROJECTURL; ?>');" -->	<!-- div class="extra" -->		<!--==============================header=================================-->		<header>			<?php 				$MENUACTIVE   = "HOME";				$fileLocation = 'templates/headerFormMenu.php'; /** echo $fileLocation; */				include( $fileLocation );			?>			<?php 				$fileLocation = 'templates/carouselHtml.php'; /** echo $fileLocation; */				include( $fileLocation );			?>		</header>		<!--==============================content================================-->		<section id="content">			<div class="ic">Lanuza Group SAS - Official Website 2014</div>			<div class="main">				<div class="container_12">					<div class="wrapper">						<article class="grid_8">							<h3>¡Bienvenidos! ¿Por qu&eacute; Lanuza Group?</h3>							<em class="text-1 margin-bot"> Porque en cada servicio que ofrecemos creemos en un cambio definitivo, creemos en un entorno que beneficia a todos y creemos en que los usuarios de las tecnolog&iacute;as de la informaci&oacute;n aumentan su productividad significativamente cuando cuentan con nuestro apoyo. La manera como impulsamos el cambio y renovamos el entorno es ofreciendo calidad, garant&iacute;a y seguimiento en todos nuestros servicios ejecutados. Sencillamente, ofrecemos la mejor experiencia en Soporte TI</em>							<div class="wrapper p4">								<article class="grid_4 alpha">									<div class="wrapper p1">										<figure class="img-indent2"><img src="<?= APPIMAGEPATH; ?>page1-img1.png" alt="" /></figure>										<div class="extra-wrap">											<div class="indent-top">												<h41>Soporte TI<em>(Tecnolog&iacute;as de la informaci&oacute;n)</em></h41>											</div>										</div>									</div>									<p class="prev-indent-bot">Su empresa necesita a alguien que cuide sus equipos con sentido de pertenencia. Nosotros los cuidamos como si fueran nuestros. </p>									<a class="link-1" href="home/ITSupport">Seguir leyendo</a>								</article>								<article class="grid_4 omega">									<div class="wrapper p1">										<figure class="img-indent2"><img src="<?= APPIMAGEPATH; ?>page1-img2.png" alt="" /></figure>										<div class="extra-wrap">											<div class="indent-top">												<h42>Infraestructura<em>(Redes de datos)</em></h42>											</div>										</div>									</div>									<p class="prev-indent-bot">Entendemos que la comunicaci&oacute;n es un factor determinante en cualquier contexto, por esta raz&oacute;n  hacemos  de  sus  redes  de  datos  un conducto optimo y efectivo en su compañia. </p>									<a class="link-1" href="home/infrastructure">Seguir leyendo...</a>								</article>							</div>							<div class="wrapper">								<article class="grid_4 alpha">									<div class="wrapper p1">										<figure class="img-indent2"><img src="<?= APPIMAGEPATH; ?>page1-img3.png" alt="" /></figure>										<div class="extra-wrap">											<div class="indent-top">												<h43>Store<em>(Dispositivos, partes y suministros)</em></h43>											</div>										</div>									</div>									<p class="prev-indent-bot">La mejor asesor&iacute;a para comprar el elemento id&oacute;neo que equilibre la necesidad, el costo y su presupuesto; es la experiencia que brindamos en la proveedur&iacute;a de dispositivos, partes y suministros.</p>									<a class="link-1" href="home/store">Seguir leyendo</a>								</article>								<article class="grid_4 omega">									<div class="wrapper p1">																				<!--div class="extra-wrap">											<div class="indent-top">												<h4>Descargas<em>(Software free)</em></h4>											</div>										</div>									</div>									<p class="prev-indent-bot">En este espacio encontrar&aacute; programas gratuitos que son de funcionamiento vital y/o necesario para su dispositivo Windows. <!--a class="color-2" href="index.html">Home</a>,<br>  <a class="color-2" href="nosotros.html">Company</a>, <a class="color-2" href="servicios.html">Services</a>, <a class="color-2" href="clientes.html">Projects</a>, <a class="color-2" href="contacto.html">Contacts</a> (note<br> that contact us form – doesn’t work).--><!--/p>									<a class="link-1" href="servicios.html">Seguir leyendo</a-->								</article>							</div>						</article>						<article class="grid_4">							<figure class="img-indent2"><img src="<?= APPIMAGEPATH; ?>microsoftpn.png" alt="" /></figure><!--h3>Testimonios</h3>							<div class="wrapper p3">								<figure class="img-indent"><a href="#"><img class="img-border" src="images/page1-img5.jpg" alt="" /></a></figure>								<div class="extra-wrap">									<span class="text-2">Director</span>									<h4 class="p2">Mary Ryan</h4>									<p class="prev-indent-bot">Ut vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum atque corrupti...</p>									<a class="link-1" href="#">Read More</a>								</div>							</div>							<div class="wrapper p3">								<figure class="img-indent"><a href="#"><img class="img-border" src="images/page1-img6.jpg" alt="" /></a></figure>								<div class="extra-wrap">									<span class="text-2">Senior assistant</span>									<h4 class="p1">Bill Joel</h4>									<p class="prev-indent-bot">Ut vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum atque corrupti...</p>									<a class="link-1" href="#">Read More</a>								</div>							</div>							<div class="wrapper">								<figure class="img-indent"><a href="#"><img class="img-border" src="images/page1-img7.jpg" alt="" /></a></figure>								<div class="extra-wrap">									<span class="text-2">Junior researcher</span>									<h4 class="prev-indent-bot">Michael Anderson</h4>									<p class="prev-indent-bot">Ut vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum atque corrupti...</p>									<a class="link-1" href="#">Read More</a-->								</div>							</div>						</article>					</div>				</div>			</div>			<!-- div class="block"></div -->		</section>	</div>	<!--==============================footer================================-->	<?php 		$attributes = array('id' => 'contactUsForm');		/** echo form_open('home/contactForm', $attributes);		// echo form_open('home/contactForm'); */		$fileLocation = 'templates/scripts.php'; /** echo $fileLocation; */		include( $fileLocation );				$fileLocation = 'templates/footerForm.php'; /** echo $fileLocation; */		include( $fileLocation );				/** echo form_close(); */	?>	<!-- Modal -->	<style>		.logo-small {			color: #337AB7;			font-size: 50px;		}	</style>  	<div class="modal fade" id="myModal" role="dialog">		<div class="modal-dialog modal-lg">		  <div class="modal-content">		    <div class="modal-header">		      <button type="button" class="close" data-dismiss="modal">&times;</button>		      <h4 class="modal-title">				<?php					if ( isset($index_message_title)) {						echo "<i>" . $index_message_title ."</i>";					}				?>		      </h4>		    </div>		    <div class="modal-body">		      <p>				<?php					if ( isset($index_message)) {						echo "<i>" . $index_message ."</i>";					}				?>		      </p>		    </div>		    <div class="modal-footer">		      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>		    </div>		  </div>		</div>	</div>	<?php		if ( isset($index_message)) {			echo "<script> $('#myModal').modal('show'); </script> ";		}	?></body></html>