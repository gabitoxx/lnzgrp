<!--==============================footer=================================-->

<style type="text/css">

		.formulario {

			border-radius: 5px;
			border: 2px solid #ccc;
			padding: 13px 5px 13px 13px;
			margin-top: 5px;
						
			font-style: italic;
			color:#000;
			font-size: 16px;
			font-family:raleway;

			vertical-align: middle;

			width:90%; /* Sirve SIN las etiquetas <label>, sin ellas sí estira el componente */

			/* padding-left: 2px; */
			
			background-color: #CCC; /** rgb(250, 255, 189); */

		}

		

	</style>
		
	<footer>
	  <a name="abajo"></a>
		<div class="padding">

			<div class="main">

				<div class="container_12">

					<div class="wrapper">
						<article class="grid_8">
							<h4>Formulario de Contacto:</h4>

							<?php
							    if ( isset($contact_mail_error) ) {
							        echo '<div class="error_msg" style="color:#E30513;font-size: 18px;">';
							        echo $contact_mail_error;
							        echo "</div><br/>";
							    }
							?>

							<form action="<?= PROJECTURLMENU; ?>home/contactMail" id="contact-form" method="post" name="contact-form"
									onsubmit="javascript:return submitForm();">

								<!-- onBlur="if(this.value=='') this.value='Correo'" onFocus="if(this.value =='Correo' ) this.value=''"   -->
								<input name="nombre" id="nombre" class="formulario" placeholder="Nombre" required="required" />
								<br /><br />
								<input name="correo" id="correo" class="formulario" placeholder="Correo" required="required" />
								<br /><br />
								<input name="celular" id="celular" class="formulario" placeholder="Celular" required="required" />
								<br /><br />
								<textarea name="mensaje" id="mensaje" class="formulario" required="required" placeholder="Escriba sus dudas, si quiere conocer nuestros servicios, precios o sus comentarios"></textarea>
								<br /><br />
								<div class="buttons">
									<a href="#abajo" style="vertical-align: middle;font-size:15px;" onClick="javascript:document.getElementById('contact-form').reset();">Borrar</a>
									&nbsp;&nbsp;&nbsp;
									<input type="submit" value=" Enviar " name="submit" style="width: 30%;" />
								</div>
							</form>
							
						</article>
						<article class="grid_4">

							<h4 class="indent-bot">Redes:</h4>

							<ul class="list-services border-bot img-indent-bot">

								<li><a href="https://es-es.facebook.com/LanuzaGroup">Facebook</a></li>

								<li><a class="item-1" href="https://twitter.com/LanuzaGroup/">Twitter</a></li>

								<!--li><a class="item-2" href="#">Picassa</a></li-->

								<li><a class="item-3" href="http://www.youtube.com/user/LanuzaGroup">YouTube</a></li>

							</ul>

							<p class="p1">lanuzagroup.com &copy; 2017 - Derechos reservados. </p>

							<p class="p1"><a class="link" target="_blank" href="http://www.lanuzagroup.com/" rel="nofollow">Lanuza Group</a> por lanuzagroup.com</p>

							<!-- {%FOOTER_LINK} -->

						</article>
					</div>
				</div>
			</div>
		</div>
	  <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
	  
	</footer>

	<script>
		function validarEmail(valor) {
			if (/^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i.test(valor)){
				// alert("La dirección de email " + valor + " es correcta.");
				return true;
			} else {
				alert("La dirección de email " + valor + " es incorrecta.");
				document.getElementById("correo").focus();
				document.getElementById("correo").style = "border:1px solid #CB2027;";
                return false;
			}
		}

		function submitForm(){

			var bool = validarEmail( document.getElementById("correo").value );
			
			if ( bool != false ){
				document.getElementById("contact-form").submit();
				return true;

			} else {
				document.getElementById("nombre").focus();
				return false;
			}
		}
	</script>